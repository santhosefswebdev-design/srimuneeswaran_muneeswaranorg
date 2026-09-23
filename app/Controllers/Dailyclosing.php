<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Dailyclosing extends BaseController
{
    function __construct(){
        parent:: __construct();
        helper('url');
		helper('common_helper');
        $this->model = new PermissionModel();
        if( ($this->session->get('log_id') ) == false && $this->session->get('role') != 1){
            $data['dn_msg'] = 'Please Login';
            header('Location: '.base_url().'/login');
            exit;
		}
    }
//     public function index(){

// 		if(!empty($_POST['dailyclosing_start_date'])) $dailyclosing_start_date = $_POST['dailyclosing_start_date'];
// 		else $dailyclosing_start_date = date("Y-m-d");
// 		if(!empty($_POST['dailyclosing_end_date'])) $dailyclosing_end_date = $_POST['dailyclosing_end_date'];
// 		else $dailyclosing_end_date = date("Y-m-d");
// 		  if(!empty($_POST['login_id'])) $login_id = $_POST['login_id'];
//     else $login_id = '';
// 		$data['archanai_details'] = daily_archanai_booking_withcurrentdate($dailyclosing_start_date,$dailyclosing_end_date);
		
// 		$data['hallbooking_details'] = daily_hall_booking_withcurrentdate($dailyclosing_start_date,$dailyclosing_end_date);
// 		$ubayam_data = daily_ubayam_withcurrentdate($dailyclosing_start_date,$dailyclosing_end_date);
// 		$data['ubayam_details'] = $ubayam_data;
// 		$donation_data = daily_donation_withcurrentdate($dailyclosing_start_date,$dailyclosing_end_date);
// 		$data['donation_details'] = $donation_data;
// 		$annathanam_data = daily_annathanam_withcurrentdate($dailyclosing_start_date,$dailyclosing_end_date);
// 		$data['annathanam_details'] = $annathanam_data;
// 		$prasadam_data = daily_prasadam_withcurrentdate($dailyclosing_start_date,$dailyclosing_end_date);
// 		$kattalai_archanai_data = daily_kattalai_archanai_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date);
// 		$data['Kattalai_archanai_details'] = $kattalai_archanai_data;
// 		$product_offering_data = daily_product_offering_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date);
// 		$data['product_offering_details'] = $product_offering_data;
// 		$outdoor_services_data = daily_outdoor_services_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date);
// 		$data['outdoor_services_details'] = $outdoor_services_data;
// 		$receipt_voucher_data = daily_receipt_voucher_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date);
// 		$repayment_data = daily_repayment_data_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date);
// 		$data['repayment_details'] = $repayment_data;
// 		$data['receipt_voucher_details'] = $receipt_voucher_data;
// 		$data['prasadam_details'] = $prasadam_data;
// 		$data['dailyclosing_start_date'] = $dailyclosing_start_date;
// 		$data['dailyclosing_end_date'] = $dailyclosing_end_date;
//         // Fetch login users — exclude customer role (98)
// $data['login_users'] = $this->db->table('login')
//     ->select('id, name')
//     ->where('status', 1)
//     ->whereNotIn('role', [98])  // exclude customer role
//     ->orderBy('name', 'ASC')
//     ->get()
//     ->getResultArray();
// 		// echo '<pre>';
// 		// print_r($data['ubayam_details']);
// 		// exit;
// 		echo view('template/header');
// 		echo view('template/sidebar');
// 		echo view('daily_closing/index', $data);
// 		echo view('template/footer');
//     }
	public function index(){

    if(!empty($_POST['dailyclosing_start_date'])) $dailyclosing_start_date = $_POST['dailyclosing_start_date'];
    else $dailyclosing_start_date = date("Y-m-d");
    if(!empty($_POST['dailyclosing_end_date'])) $dailyclosing_end_date = $_POST['dailyclosing_end_date'];
    else $dailyclosing_end_date = date("Y-m-d");
    
    // ✅ Capture login_id from POST
    $login_id = !empty($_POST['login_id']) ? $_POST['login_id'] : '';

    // ✅ Pass $login_id to every helper function that supports it
    $data['archanai_details']          = daily_archanai_booking_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, '', $login_id);
    $data['hallbooking_details']       = daily_hall_booking_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date);
    $data['ubayam_details']            = daily_ubayam_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, '', $login_id);
    $data['donation_details']          = daily_donation_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, '', $login_id);
    $data['annathanam_details']        = daily_annathanam_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, '', $login_id);
    $data['prasadam_details']          = daily_prasadam_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, '', $login_id);
    $data['Kattalai_archanai_details'] = daily_kattalai_archanai_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, '', $login_id);
    
	$data['Kattalai_abishegam_details'] = daily_kattalai_abishegam_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, '', $login_id);
	
    $data['product_offering_details']  = daily_product_offering_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, '', $login_id);
    $data['outdoor_services_details']  = daily_outdoor_services_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, '', $login_id);
    $data['receipt_voucher_details']   = daily_receipt_voucher_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, '', $login_id);
    $data['repayment_details']         = daily_repayment_data_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, '', $login_id);
    $data['dailyclosing_start_date']   = $dailyclosing_start_date;
    $data['dailyclosing_end_date']     = $dailyclosing_end_date;
    $data['selected_login_id']         = $login_id; // ✅ Pass to view to retain dropdown selection

    // Fetch login users — exclude customer role (98)
    $data['login_users'] = $this->db->table('login')
        ->select('id, name')
        ->where('status', 1)
        ->whereNotIn('role', [98])
        ->orderBy('name', 'ASC')
        ->get()
        ->getResultArray();

    echo view('template/header');
    echo view('template/sidebar');
    echo view('daily_closing/index', $data);
    echo view('template/footer');
}
	public function print($fromdate,$todate){
		$tmpid = $this->session->get('profile_id');
		if(!empty($fromdate)) $dailyclosing_start_date = date('Y-m-d', $fromdate);
		else $dailyclosing_start_date = date("Y-m-d");
		if(!empty($todate)) $dailyclosing_end_date = date('Y-m-d', $todate);
		else $dailyclosing_end_date = date("Y-m-d");
		/* $archanai_data_direct = daily_archanai_booking_withcurrentdate($current_date, $booking_type = "DIRECT");
		$archanai_data_online = daily_archanai_booking_withcurrentdate($current_date, $booking_type = "ONLINE");
		$data['archanai_details'] = array_merge($archanai_data_online,$archanai_data_direct); */
		$archanai_data_online = daily_archanai_booking_withcurrentdate($dailyclosing_start_date,$dailyclosing_end_date);
		$archanai_diety_data_online = daily_diety_archanai_booking_withcurrentdate($dailyclosing_start_date,$dailyclosing_end_date);
		$data['archanai_diety_details'] = $archanai_diety_data_online;
		$data['archanai_details'] = $archanai_data_online;
		$data['hallbooking_details'] = daily_hall_booking_withcurrentdate($dailyclosing_start_date,$dailyclosing_end_date);
		$ubayam_data = daily_ubayam_withcurrentdate($dailyclosing_start_date,$dailyclosing_end_date);
		$data['ubayam_details'] = $ubayam_data;
		$donation_data = daily_donation_withcurrentdate($dailyclosing_start_date,$dailyclosing_end_date);
		$data['donation_details'] = $donation_data;
		$prasadam_data = daily_prasadam_withcurrentdate($dailyclosing_start_date,$dailyclosing_end_date);
		$data['prasadam_details'] = $prasadam_data;
		$annathanam_data = daily_annathanam_withcurrentdate($dailyclosing_start_date,$dailyclosing_end_date);
		$data['annathanam_details'] = $annathanam_data;
		$receipt_voucher_data = daily_receipt_voucher_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date);
		$data['receipt_voucher_details'] = $receipt_voucher_data;
		$repayment_data = daily_repayment_data_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date);
		$data['repayment_details'] = $repayment_data;
		$data['receipt_voucher_details'] = $receipt_voucher_data;
		$tmpid = $this->session->get('profile_id');
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
		$data['dailyclosing_start_date'] = $dailyclosing_start_date;
		$data['dailyclosing_end_date'] = $dailyclosing_end_date;
		echo view('daily_closing/print_page', $data);
    }
	public function print_a4($fromdate,$todate){
		$tmpid = $this->session->get('profile_id');
		if(!empty($fromdate)) $dailyclosing_start_date = date('Y-m-d', $fromdate);
		else $dailyclosing_start_date = date("Y-m-d");
		if(!empty($todate)) $dailyclosing_end_date = date('Y-m-d', $todate);
		else $dailyclosing_end_date = date("Y-m-d");
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
		$annathanam_data = daily_annathanam_withcurrentdate($dailyclosing_start_date,$dailyclosing_end_date);
		$data['annathanam_details'] = $annathanam_data;
		$receipt_voucher_data = daily_receipt_voucher_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date);
		$data['receipt_voucher_details'] = $receipt_voucher_data;
		$repayment_data = daily_repayment_data_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date);
		$data['repayment_details'] = $repayment_data;
		$data['receipt_voucher_details'] = $receipt_voucher_data;
		$tmpid = $this->session->get('profile_id');
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
		$data['dailyclosing_start_date'] = $dailyclosing_start_date;
		$data['dailyclosing_end_date'] = $dailyclosing_end_date;
		echo view('daily_closing/print_a4', $data);
    }

	public function analytics_amount($fromdate, $todate) {
		if (!empty($fromdate)) $dailyclosing_start_date = date('Y-m-d', $fromdate);
		else $dailyclosing_start_date = date("Y-m-d");
		if (!empty($todate)) $dailyclosing_end_date = date('Y-m-d', $todate);
		else $dailyclosing_end_date = date("Y-m-d");
	
		// Fetch details and counts for archanai
		$archanai_details = daily_archanai_booking_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date);
		$archanai_count = archanai_booking_count($dailyclosing_start_date, $dailyclosing_end_date); // Count of transactions
		$donation_details = daily_donation_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date);
		$prasadam_details = daily_prasadam_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date);
	
		// Aggregating sales amounts by payment type
		$archanai_sales_graph = [
			'counter' => 0,
			'kiosk' => 0
		];
	
		foreach ($archanai_details as $detail) {
			if ($detail['paid_through'] == 'DIRECT') {
				$paymentname = strtoupper($detail['paymentmode']);
				if (in_array($paymentname, ['CASH', 'QR'])) {
					$archanai_sales_graph['counter'] += $detail['amount'];
				}
			} else {
				switch ($detail['paymentmode']) {
					case 'ipay_merch_qr':
						$paymentname = 'QR PAYMENT';
						$archanai_sales_graph['kiosk'] += $detail['amount'];
						break;
					case 'ipay_merch_online':
						$paymentname = 'ONLINE PAYMENT';
						$archanai_sales_graph['kiosk'] += $detail['amount'];
						break;
					case 'cash':
						$paymentname = strtoupper($detail['paymentmode']);
						$archanai_sales_graph['counter'] += $detail['amount'];
						break;
					default:
						$paymentname = strtoupper($detail['paymentmode']);
						$archanai_sales_graph['kiosk'] += $detail['amount'];
						break;
				}
			}
		}
	
		// Total sales calculation
		$total_sales_graph = [
			'Archanai' => array_sum(array_column($archanai_details, 'amount')),
			'Donation' => array_sum(array_column($donation_details, 'amount')),
			'Prasadam' => array_sum(array_column($prasadam_details, 'amount')),
		];
	
		// Prepare data for the view
		$data = [
			'archanai_sales_graph' => $archanai_sales_graph,
			'total_sales_graph' => $total_sales_graph,
			'archanai_transaction_count' => $archanai_count, // Adding count for a new chart
			'dailyclosing_start_date' => $dailyclosing_start_date,
			'dailyclosing_end_date' => $dailyclosing_end_date
		];
	
		// echo '<pre>';  // Makes the output more readable
		// print_r($data);  // Shows the structured data array
		// echo '</pre>';
		
		// Output to the view
		echo view('template/header');
		echo view('template/sidebar');
		echo view('daily_closing/analytics', $data);
		echo view('template/footer');
	}
}