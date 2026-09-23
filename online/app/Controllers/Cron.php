<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;
use Dompdf\Dompdf;
use Dompdf\Options;
class Cron extends BaseController
{
    function __construct(){
        parent:: __construct();
        helper('url');
		helper('common_helper');
        $this->model = new PermissionModel();
    }
    public function hallbook_remainder_notification()
    {
      $email = \Config\Services::email();
      $profile_id = 1;
      $query = $this->db->table('admin_profile')->where('id', $profile_id)->get()->getRowArray();
      $days = $query['hall_remind'];
      if($days!=0 || !empty($days)) {
        $hallremind_days = $days;
      }
      else{
        $hallremind_days = 5;
      }
		  $lists = $this->db->query("SELECT *, abs(datediff(DATE_FORMAT(hall_booking.booking_date, '%Y-%m-%d'), NOW())) as interval_date FROM hall_booking WHERE DATE_FORMAT(hall_booking.booking_date, '%Y-%m-%d') >= NOW() AND DATE_FORMAT(hall_booking.booking_date, '%Y-%m-%d')  < NOW() + INTERVAL $hallremind_days DAY and paid_amount < total_amount;")->getResultArray();
        foreach($lists as $row)
        {
          if(!empty($row['email']))
          {
            $interval_date = $row['interval_date'];
            $html = "Hi, ";
            $html .= "Your booking has remaining $interval_date days to schedule, You need to pay the remaining amount.";
            $to = $row['email'];
            $subject = "Hall Booking Reminder";
            $message = $html;
            $email->setTo($to);
            $email->setFrom('templetest@grasp.com.my', 'Temple Rajamariamman');
          // $email->setNewline("\r\n");
            $email->setSubject($subject);
            $email->setMessage($message);
            $email->send();
          }
       }

    }
    function testmail()
    {
      $email = \Config\Services::email();
      $html = "Hi, ";
      $html .= "this is test mail";
      $to = "rajkumar.bizsoft@gmail.com";
      $subject = "Test Mail";
      $message = $html;
      $email->setTo($to);
      $email->setFrom('templetest@grasp.com.my', 'Test Mail');
    // $email->setNewline("\r\n");
      $email->setSubject($subject);
      $email->setMessage($message);
      $email->send();
      //echo $email->print_debugger();
    }
    function daily_closing($mobile = ''){
		$tmpid = 1;
		$dailyclosing_start_date = date('Y-m-d');
		$dailyclosing_end_date = date("Y-m-d");
		$archanai_data_online = daily_archanai_booking_withcurrentdate($dailyclosing_start_date,$dailyclosing_end_date);
		$archanai_diety_data_online = daily_diety_archanai_booking_withcurrentdate($dailyclosing_start_date,$dailyclosing_end_date);
		$data['archanai_diety_details'] = $archanai_diety_data_online;
		$data['archanai_details'] = $archanai_data_online;
		$hallbooking_data_online = daily_hall_booking_withcurrentdate($dailyclosing_start_date,$dailyclosing_end_date);
		$data['hallbooking_details'] = $hallbooking_data_online;
		$ubayam_data = daily_ubayam_withcurrentdate($dailyclosing_start_date,$dailyclosing_end_date);
		$data['ubayam_details'] = $ubayam_data;
		$donation_data = daily_donation_withcurrentdate($dailyclosing_start_date,$dailyclosing_end_date);
		$data['donation_details'] = $donation_data;
		$prasadam_data = daily_prasadam_withcurrentdate($dailyclosing_start_date,$dailyclosing_end_date);
		$data['prasadam_details'] = $prasadam_data;
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
		if(empty($mobile) && !empty($temp_details['daily_closing_phone'])) $mobile = $temp_details['daily_closing_phone'];
		if(!empty($mobile)){
			$html = view('daily_closing/pdf', $data);
			// echo $html;
			// die;
			$options = new Options();
			$options->set('isHtml5ParserEnabled', true);
			$options->set(array('isRemoteEnabled'=>true));
			$options->set('isPhpEnabled', true);
			$dompdf = new Dompdf($options);
			$dompdf->loadHtml($html);
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$filePath = FCPATH . 'uploads/documents/daily_closing_' . time() . '.pdf';
			file_put_contents($filePath, $dompdf->output());
			$message_params = array();
			$media['url'] = base_url() . '/uploads/documents/daily_closing_' . time() . '.pdf';
			$media['filename'] = 'daily_closing.pdf';
			//$mobile = '+919092615446';
			// print_r($mobile);
			// print_r($message_params);
			// print_r($media);
			// die; 
			$whatsapp_resp = whatsapp_aisensy($mobile, $message_params, 'daily_closing_live', $media);
		}
	}
    
}
