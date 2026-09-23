<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Dailyclosing_online extends BaseController
{
	function __construct()
	{
		parent::__construct();
		helper('url');
		helper('common_helper');
		$this->model = new PermissionModel();
		if (($this->session->get('log_id_frend')) == false) {
			$data['dn_msg'] = 'Please Login';
			header('Location: ' . base_url() . '/member_login');
			exit;
		}
	}
	public function index()
	{
		if (!empty($_POST['dailyclosing_start_date']))
			$dailyclosing_start_date = $_POST['dailyclosing_start_date'];
		else
			$dailyclosing_start_date = date("Y-m-d");
		if (!empty($_POST['dailyclosing_end_date']))
			$dailyclosing_end_date = $_POST['dailyclosing_end_date'];
		else
			$dailyclosing_end_date = date("Y-m-d");
		// $login_id = $_SESSION['log_id_frend'];
		//$archanai_data_online = daily_archanai_booking_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "", $login_id);
		$archanai_diety_data_online = daily_diety_archanai_booking_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "", $login_id);
		$data['archanai_diety_details'] = $archanai_diety_data_online;
		$hallbooking_data_online = daily_hall_booking_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "", $login_id);
		$data['hallbooking_details'] = $hallbooking_data_online;
		$ubayam_data = daily_ubayam_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "", $login_id);
		$data['ubayam_details'] = $ubayam_data;
		log_message('error',json_encode($ubayam_data));
		$donation_data = daily_donation_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "", $login_id);
		$data['donation_details'] = $donation_data;
		$prasadam_data = daily_prasadam_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "", $login_id);
		$data['prasadam_details'] = $prasadam_data;
		$kattalai_archanai_data = daily_kattalai_archanai_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "COUNTER", $login_id);
		$data['Kattalai_archanai_details'] = $kattalai_archanai_data;
		
		$kattalai_abishegam_data = daily_kattalai_abishegam_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "COUNTER", $login_id);
		$data['Kattalai_abishegam_details'] = $kattalai_abishegam_data;
		
		$annathanam_data = daily_annathanam_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "", $login_id);
		$data['annathanam_details'] = $annathanam_data;
		$product_offering_data = daily_product_offering_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "COUNTER", $login_id);
		$data['product_offering_details'] = $product_offering_data;
		$outdoor_services_data = daily_outdoor_services_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "COUNTER", $login_id);
		$data['outdoor_services_details'] = $outdoor_services_data;
		$payment_voucher_data = daily_payment_voucher_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "", $login_id);
		$member_data = daily_member_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "", $login_id);
		$data['member_details'] = $member_data;
		$data['payment_voucher_details'] = $payment_voucher_data;
		$data['dailyclosing_start_date'] = $dailyclosing_start_date;
		$data['dailyclosing_end_date'] = $dailyclosing_end_date;
		$data['coin_denominations'] = $this->db->query("SELECT max(cv.name) as name, sum(cv.value * cd.quantity) as amount, max(cd.coin_key) as coin_key, sum(cd.quantity) as quantity, sum(cv.value * cd.c_quantity) as c_amount,  max(cd.c_quantity) as c_quantity FROM `coin_denomination` cd left join coin_value cv on cv.key = cd.coin_key where cd.date >= '$dailyclosing_start_date' and cd.date >= '$dailyclosing_end_date' group by coin_key order by cv.order_no")->getResult();
		$data['floating_cash'] = $this->db->query("SELECT sum(amount) as amount FROM `floating_cash` where date >= '$dailyclosing_start_date' and date >= '$dailyclosing_end_date'")->getRowArray();
		$repayment_data = daily_repayment_data_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "", $login_id);
		$data['repayment_details'] = $repayment_data;
		$catering_data = daily_catering_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "COUNTER", $login_id);
		$data['catering_details'] = $catering_data;

		$data['arch_inv_no'] = $this->db->query(" SELECT (SELECT ref_no FROM archanai_booking WHERE date >= '$dailyclosing_start_date' AND date <= '$dailyclosing_end_date' ORDER BY date ASC, ref_no ASC LIMIT 1) AS first_ref_no, (SELECT ref_no FROM archanai_booking WHERE date >= '$dailyclosing_start_date' AND date <= '$dailyclosing_end_date' ORDER BY date DESC, ref_no DESC LIMIT 1) AS last_ref_no; ")->getRowArray();
		$data['pras_inv_no'] = $this->db->query(" SELECT (SELECT ref_no FROM prasadam WHERE date >= '$dailyclosing_start_date' AND date <= '$dailyclosing_end_date' ORDER BY date ASC, ref_no ASC LIMIT 1) AS first_ref_no, (SELECT ref_no FROM prasadam WHERE date >= '$dailyclosing_start_date' AND date <= '$dailyclosing_end_date' ORDER BY date DESC, ref_no DESC LIMIT 1) AS last_ref_no; ")->getRowArray();				
		$data['don_inv_no'] = $this->db->query(" SELECT (SELECT ref_no FROM donation WHERE date >= '$dailyclosing_start_date' AND date <= '$dailyclosing_end_date' ORDER BY date ASC, ref_no ASC LIMIT 1) AS first_ref_no, (SELECT ref_no FROM donation WHERE date >= '$dailyclosing_start_date' AND date <= '$dailyclosing_end_date' ORDER BY date DESC, ref_no DESC LIMIT 1) AS last_ref_no; ")->getRowArray();		
		$data['anna_inv_no'] = $this->db->query(" SELECT (SELECT ref_no FROM annathanam_new WHERE date >= '$dailyclosing_start_date' AND date <= '$dailyclosing_end_date' ORDER BY date ASC, ref_no ASC LIMIT 1) AS first_ref_no, (SELECT ref_no FROM annathanam_new WHERE date >= '$dailyclosing_start_date' AND date <= '$dailyclosing_end_date' ORDER BY date DESC, ref_no DESC LIMIT 1) AS last_ref_no; ")->getRowArray();		
		$data['hall_inv_no'] = $this->db->query(" SELECT (SELECT ref_no FROM templebooking WHERE booking_type = 1 AND entry_date >= '$dailyclosing_start_date' AND entry_date <= '$dailyclosing_end_date' ORDER BY entry_date ASC, ref_no ASC LIMIT 1) AS first_ref_no, (SELECT ref_no FROM templebooking WHERE booking_type = 1 AND entry_date >= '$dailyclosing_start_date' AND entry_date <= '$dailyclosing_end_date' ORDER BY entry_date DESC, ref_no DESC LIMIT 1) AS last_ref_no; ")->getRowArray();		
		$data['ubayam_inv_no'] = $this->db->query(" SELECT (SELECT ref_no FROM templebooking WHERE booking_type = 2 AND entry_date >= '$dailyclosing_start_date' AND entry_date <= '$dailyclosing_end_date' ORDER BY entry_date ASC, ref_no ASC LIMIT 1) AS first_ref_no, (SELECT ref_no FROM templebooking WHERE booking_type =2 AND entry_date >= '$dailyclosing_start_date' AND entry_date <= '$dailyclosing_end_date' ORDER BY entry_date DESC, ref_no DESC LIMIT 1) AS last_ref_no; ")->getRowArray();		
		$data['katt_inv_no'] = $this->db->query(" SELECT (SELECT ref_no FROM kattalai_archanai_booking WHERE date >= '$dailyclosing_start_date' AND date <= '$dailyclosing_end_date' ORDER BY date ASC, ref_no ASC LIMIT 1) AS first_ref_no, (SELECT ref_no FROM kattalai_archanai_booking WHERE date >= '$dailyclosing_start_date' AND date <= '$dailyclosing_end_date' ORDER BY date DESC, ref_no DESC LIMIT 1) AS last_ref_no; ")->getRowArray();		
		$data['outdoor_inv_no'] = $this->db->query(" SELECT (SELECT ref_no FROM outdoor_booking WHERE date >= '$dailyclosing_start_date' AND date <= '$dailyclosing_end_date' ORDER BY date ASC, ref_no ASC LIMIT 1) AS first_ref_no, (SELECT ref_no FROM outdoor_booking WHERE date >= '$dailyclosing_start_date' AND date <= '$dailyclosing_end_date' ORDER BY date DESC, ref_no DESC LIMIT 1) AS last_ref_no; ")->getRowArray();						
		$data['catering_inv_no'] = $this->db->query(" SELECT (SELECT ref_no FROM annathanam_new WHERE booking_type = 3 AND date >= '$dailyclosing_start_date' AND date <= '$dailyclosing_end_date' ORDER BY date ASC, ref_no ASC LIMIT 1) AS first_ref_no, (SELECT ref_no FROM annathanam_new WHERE date >= '$dailyclosing_start_date' AND date <= '$dailyclosing_end_date' ORDER BY date DESC, ref_no DESC LIMIT 1) AS last_ref_no; ")->getRowArray();		

		echo view('frontend/layout/header');
		echo view('frontend/daily_closing/index', $data);
	}
	public function print($fromdate, $todate)
	{
		$tmpid = $this->session->get('profile_id');
		if (!empty($fromdate))
			$dailyclosing_start_date = date('Y-m-d', $fromdate);
		else
			$dailyclosing_start_date = date("Y-m-d");
		if (!empty($todate))
			$dailyclosing_end_date = date('Y-m-d', $todate);
		else
			$dailyclosing_end_date = date("Y-m-d");
		//$login_id = $_SESSION['log_id_frend'];
		$archanai_data_online = daily_archanai_booking_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "", $login_id);
		$data['archanai_details'] = $archanai_data_online;
		$archanai_diety_data_online = daily_diety_archanai_booking_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "", $login_id);
		$data['archanai_diety_details'] = $archanai_diety_data_online;
		$hallbooking_data_online = daily_hall_booking_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "", $login_id);
		$data['hallbooking_details'] = $hallbooking_data_online;
		$ubayam_data = daily_ubayam_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "", $login_id);
		$data['ubayam_details'] = $ubayam_data;
		$donation_data = daily_donation_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "", $login_id);
		$data['donation_details'] = $donation_data;
		$prasadam_data = daily_prasadam_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "", $login_id);
		$data['prasadam_details'] = $prasadam_data;
		$annathanam_data = daily_annathanam_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "", $login_id);
		$data['annathanam_details'] = $annathanam_data;
		$kattalai_archanai_data = daily_kattalai_archanai_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "COUNTER", $login_id);
		$data['Kattalai_archanai_details'] = $kattalai_archanai_data;
		$product_offering_data = daily_product_offering_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "COUNTER", $login_id);
		$data['product_offering_details'] = $product_offering_data;
		$outdoor_services_data = daily_outdoor_services_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "COUNTER", $login_id);
		$data['outdoor_services_details'] = $outdoor_services_data;
		$member_data = daily_member_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "", $login_id);
		$data['member_details'] = $member_data;
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
		$data['dailyclosing_start_date'] = $dailyclosing_start_date;
		$data['dailyclosing_end_date'] = $dailyclosing_end_date;
		// $data['coin_denominations'] = $this->db->query("SELECT max(cv.name) as name, sum(cv.value * cd.quantity) as amount, max(cd.coin_key) as coin_key, sum(cd.quantity) as quantity FROM `coin_denomination` cd left join coin_value cv on cv.key = cd.coin_key where cd.date >= '$dailyclosing_start_date' and cd.date >= '$dailyclosing_end_date' group by coin_key")->getResult();
		$data['coin_denominations'] = $this->db->query("SELECT max(cv.name) as name, sum(cv.value * cd.quantity) as amount, max(cd.coin_key) as coin_key, sum(cd.quantity) as quantity, sum(cv.value * cd.c_quantity) as c_amount,  max(cd.c_quantity) as c_quantity FROM `coin_denomination` cd left join coin_value cv on cv.key = cd.coin_key where cd.date >= '$dailyclosing_start_date' and cd.date >= '$dailyclosing_end_date' group by coin_key order by cv.order_no")->getResult();
		$catering_data = daily_catering_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "COUNTER", $login_id);
		$data['catering_details'] = $catering_data;

		// $data['floating_cash'] = $this->db->query("SELECT sum(amount) as amount FROM `floating_cash` where date >= '$dailyclosing_start_date' and date >= '$dailyclosing_end_date'")->getRowArray();
		$data['floating_cash'] = $this->db->query("SELECT sum(amount) as amount, checked_by FROM `floating_cash` WHERE date >= '$dailyclosing_start_date' AND date <= '$dailyclosing_end_date' GROUP BY checked_by")->getRowArray();
		$repayment_data = daily_repayment_data_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "", $login_id);
		$data['repayment_details'] = $repayment_data;
		
		$data['arch_inv_no'] = $this->db->query(" SELECT (SELECT ref_no FROM archanai_booking WHERE date >= '$dailyclosing_start_date' AND date <= '$dailyclosing_end_date' ORDER BY date ASC, ref_no ASC LIMIT 1) AS first_ref_no, (SELECT ref_no FROM archanai_booking WHERE date >= '$dailyclosing_start_date' AND date <= '$dailyclosing_end_date' ORDER BY date DESC, ref_no DESC LIMIT 1) AS last_ref_no; ")->getRowArray();
		$data['pras_inv_no'] = $this->db->query(" SELECT (SELECT ref_no FROM prasadam WHERE date >= '$dailyclosing_start_date' AND date <= '$dailyclosing_end_date' ORDER BY date ASC, ref_no ASC LIMIT 1) AS first_ref_no, (SELECT ref_no FROM prasadam WHERE date >= '$dailyclosing_start_date' AND date <= '$dailyclosing_end_date' ORDER BY date DESC, ref_no DESC LIMIT 1) AS last_ref_no; ")->getRowArray();				
		$data['don_inv_no'] = $this->db->query(" SELECT (SELECT ref_no FROM donation WHERE date >= '$dailyclosing_start_date' AND date <= '$dailyclosing_end_date' ORDER BY date ASC, ref_no ASC LIMIT 1) AS first_ref_no, (SELECT ref_no FROM donation WHERE date >= '$dailyclosing_start_date' AND date <= '$dailyclosing_end_date' ORDER BY date DESC, ref_no DESC LIMIT 1) AS last_ref_no; ")->getRowArray();		
		$data['anna_inv_no'] = $this->db->query(" SELECT (SELECT ref_no FROM annathanam_new WHERE date >= '$dailyclosing_start_date' AND date <= '$dailyclosing_end_date' ORDER BY date ASC, ref_no ASC LIMIT 1) AS first_ref_no, (SELECT ref_no FROM annathanam_new WHERE date >= '$dailyclosing_start_date' AND date <= '$dailyclosing_end_date' ORDER BY date DESC, ref_no DESC LIMIT 1) AS last_ref_no; ")->getRowArray();		
		$data['hall_inv_no'] = $this->db->query(" SELECT (SELECT ref_no FROM templebooking WHERE booking_type = 1 AND entry_date >= '$dailyclosing_start_date' AND entry_date <= '$dailyclosing_end_date' ORDER BY entry_date ASC, ref_no ASC LIMIT 1) AS first_ref_no, (SELECT ref_no FROM templebooking WHERE booking_type = 1 AND entry_date >= '$dailyclosing_start_date' AND entry_date <= '$dailyclosing_end_date' ORDER BY entry_date DESC, ref_no DESC LIMIT 1) AS last_ref_no; ")->getRowArray();		
		$data['ubayam_inv_no'] = $this->db->query(" SELECT (SELECT ref_no FROM templebooking WHERE booking_type = 2 AND entry_date >= '$dailyclosing_start_date' AND entry_date <= '$dailyclosing_end_date' ORDER BY entry_date ASC, ref_no ASC LIMIT 1) AS first_ref_no, (SELECT ref_no FROM templebooking WHERE booking_type =2 AND entry_date >= '$dailyclosing_start_date' AND entry_date <= '$dailyclosing_end_date' ORDER BY entry_date DESC, ref_no DESC LIMIT 1) AS last_ref_no; ")->getRowArray();		
		$data['katt_inv_no'] = $this->db->query(" SELECT (SELECT ref_no FROM kattalai_archanai_booking WHERE date >= '$dailyclosing_start_date' AND date <= '$dailyclosing_end_date' ORDER BY date ASC, ref_no ASC LIMIT 1) AS first_ref_no, (SELECT ref_no FROM kattalai_archanai_booking WHERE date >= '$dailyclosing_start_date' AND date <= '$dailyclosing_end_date' ORDER BY date DESC, ref_no DESC LIMIT 1) AS last_ref_no; ")->getRowArray();		
		$data['outdoor_inv_no'] = $this->db->query(" SELECT (SELECT ref_no FROM outdoor_booking WHERE date >= '$dailyclosing_start_date' AND date <= '$dailyclosing_end_date' ORDER BY date ASC, ref_no ASC LIMIT 1) AS first_ref_no, (SELECT ref_no FROM outdoor_booking WHERE date >= '$dailyclosing_start_date' AND date <= '$dailyclosing_end_date' ORDER BY date DESC, ref_no DESC LIMIT 1) AS last_ref_no; ")->getRowArray();						
		$data['catering_inv_no'] = $this->db->query(" SELECT (SELECT ref_no FROM annathanam_new WHERE booking_type = 3 AND date >= '$dailyclosing_start_date' AND date <= '$dailyclosing_end_date' ORDER BY date ASC, ref_no ASC LIMIT 1) AS first_ref_no, (SELECT ref_no FROM annathanam_new WHERE date >= '$dailyclosing_start_date' AND date <= '$dailyclosing_end_date' ORDER BY date DESC, ref_no DESC LIMIT 1) AS last_ref_no; ")->getRowArray();		

		// echo '<pre>';
		// print_r($data);
		// exit;

		echo view('frontend/daily_closing/print_page', $data);
	}
	public function print_a4($fromdate, $todate)
	{
		$tmpid = $this->session->get('profile_id');
		if (!empty($fromdate))
			$dailyclosing_start_date = date('Y-m-d', $fromdate);
		else
			$dailyclosing_start_date = date("Y-m-d");
		if (!empty($todate))
			$dailyclosing_end_date = date('Y-m-d', $todate);
		else
			$dailyclosing_end_date = date("Y-m-d");
		//$login_id = $_SESSION['log_id_frend'];
		$archanai_data_online = daily_archanai_booking_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "", $login_id);
		$archanai_diety_data_online = daily_diety_archanai_booking_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "", $login_id);
		$data['archanai_details'] = $archanai_data_online;
		$data['archanai_diety_details'] = $archanai_diety_data_online;
		$hallbooking_data_online = daily_hall_booking_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "", $login_id);
		$data['hallbooking_details'] = $hallbooking_data_online;
		$ubayam_data = daily_ubayam_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "", $login_id);
		$data['ubayam_details'] = $ubayam_data;
		$donation_data = daily_donation_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "", $login_id);
		$data['donation_details'] = $donation_data;
		$prasadam_data = daily_prasadam_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "", $login_id);
		$data['prasadam_details'] = $prasadam_data;
		$annathanam_data = daily_annathanam_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "", $login_id);
		$data['annathanam_details'] = $annathanam_data;
		$outdoor_services_data = daily_outdoor_services_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "COUNTER", $login_id);
		$data['outdoor_services_details'] = $outdoor_services_data;
		$member_data = daily_member_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "", $login_id);
		$data['member_details'] = $member_data;
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
		$data['dailyclosing_start_date'] = $dailyclosing_start_date;
		$data['dailyclosing_end_date'] = $dailyclosing_end_date;
		$data['coin_denominations'] = $this->db->query("SELECT max(cv.name) as name, sum(cv.value * cd.quantity) as amount, max(cd.coin_key) as coin_key, sum(cd.quantity) as quantity, sum(cv.value * cd.c_quantity) as c_amount,  max(cd.c_quantity) as c_quantity FROM `coin_denomination` cd left join coin_value cv on cv.key = cd.coin_key where cd.date >= '$dailyclosing_start_date' and cd.date >= '$dailyclosing_end_date' group by coin_key order by cv.order_no")->getResult();
		// $data['floating_cash'] = $this->db->query("SELECT sum(amount) as amount FROM `floating_cash` where date >= '$dailyclosing_start_date' and date >= '$dailyclosing_end_date'")->getRowArray();
		$data['floating_cash'] = $this->db->query("SELECT sum(amount) as amount, checked_by FROM `floating_cash` WHERE date >= '$dailyclosing_start_date' AND date <= '$dailyclosing_end_date' GROUP BY checked_by")->getRowArray();
		$repayment_data = daily_repayment_data_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "", $login_id);
		$data['repayment_details'] = $repayment_data;
		$kattalai_archanai_data = daily_kattalai_archanai_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "COUNTER", $login_id);
		$data['Kattalai_archanai_details'] = $kattalai_archanai_data;
		$product_offering_data = daily_product_offering_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "COUNTER", $login_id);
		$data['product_offering_details'] = $product_offering_data;
		$catering_data = daily_catering_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "COUNTER", $login_id);
		$data['catering_details'] = $catering_data;

		$data['arch_inv_no'] = $this->db->query(" SELECT (SELECT ref_no FROM archanai_booking WHERE date >= '$dailyclosing_start_date' AND date <= '$dailyclosing_end_date' ORDER BY date ASC, ref_no ASC LIMIT 1) AS first_ref_no, (SELECT ref_no FROM archanai_booking WHERE date >= '$dailyclosing_start_date' AND date <= '$dailyclosing_end_date' ORDER BY date DESC, ref_no DESC LIMIT 1) AS last_ref_no; ")->getRowArray();
		$data['pras_inv_no'] = $this->db->query(" SELECT (SELECT ref_no FROM prasadam WHERE date >= '$dailyclosing_start_date' AND date <= '$dailyclosing_end_date' ORDER BY date ASC, ref_no ASC LIMIT 1) AS first_ref_no, (SELECT ref_no FROM prasadam WHERE date >= '$dailyclosing_start_date' AND date <= '$dailyclosing_end_date' ORDER BY date DESC, ref_no DESC LIMIT 1) AS last_ref_no; ")->getRowArray();				
		$data['don_inv_no'] = $this->db->query(" SELECT (SELECT ref_no FROM donation WHERE date >= '$dailyclosing_start_date' AND date <= '$dailyclosing_end_date' ORDER BY date ASC, ref_no ASC LIMIT 1) AS first_ref_no, (SELECT ref_no FROM donation WHERE date >= '$dailyclosing_start_date' AND date <= '$dailyclosing_end_date' ORDER BY date DESC, ref_no DESC LIMIT 1) AS last_ref_no; ")->getRowArray();		
		$data['anna_inv_no'] = $this->db->query(" SELECT (SELECT ref_no FROM annathanam_new WHERE date >= '$dailyclosing_start_date' AND date <= '$dailyclosing_end_date' ORDER BY date ASC, ref_no ASC LIMIT 1) AS first_ref_no, (SELECT ref_no FROM annathanam_new WHERE date >= '$dailyclosing_start_date' AND date <= '$dailyclosing_end_date' ORDER BY date DESC, ref_no DESC LIMIT 1) AS last_ref_no; ")->getRowArray();		
		$data['hall_inv_no'] = $this->db->query(" SELECT (SELECT ref_no FROM templebooking WHERE booking_type = 1 AND entry_date >= '$dailyclosing_start_date' AND entry_date <= '$dailyclosing_end_date' ORDER BY entry_date ASC, ref_no ASC LIMIT 1) AS first_ref_no, (SELECT ref_no FROM templebooking WHERE booking_type = 1 AND entry_date >= '$dailyclosing_start_date' AND entry_date <= '$dailyclosing_end_date' ORDER BY entry_date DESC, ref_no DESC LIMIT 1) AS last_ref_no; ")->getRowArray();		
		$data['ubayam_inv_no'] = $this->db->query(" SELECT (SELECT ref_no FROM templebooking WHERE booking_type = 2 AND entry_date >= '$dailyclosing_start_date' AND entry_date <= '$dailyclosing_end_date' ORDER BY entry_date ASC, ref_no ASC LIMIT 1) AS first_ref_no, (SELECT ref_no FROM templebooking WHERE booking_type =2 AND entry_date >= '$dailyclosing_start_date' AND entry_date <= '$dailyclosing_end_date' ORDER BY entry_date DESC, ref_no DESC LIMIT 1) AS last_ref_no; ")->getRowArray();		
		$data['katt_inv_no'] = $this->db->query(" SELECT (SELECT ref_no FROM kattalai_archanai_booking WHERE date >= '$dailyclosing_start_date' AND date <= '$dailyclosing_end_date' ORDER BY date ASC, ref_no ASC LIMIT 1) AS first_ref_no, (SELECT ref_no FROM kattalai_archanai_booking WHERE date >= '$dailyclosing_start_date' AND date <= '$dailyclosing_end_date' ORDER BY date DESC, ref_no DESC LIMIT 1) AS last_ref_no; ")->getRowArray();		
		$data['outdoor_inv_no'] = $this->db->query(" SELECT (SELECT ref_no FROM outdoor_booking WHERE date >= '$dailyclosing_start_date' AND date <= '$dailyclosing_end_date' ORDER BY date ASC, ref_no ASC LIMIT 1) AS first_ref_no, (SELECT ref_no FROM outdoor_booking WHERE date >= '$dailyclosing_start_date' AND date <= '$dailyclosing_end_date' ORDER BY date DESC, ref_no DESC LIMIT 1) AS last_ref_no; ")->getRowArray();						
		$data['catering_inv_no'] = $this->db->query(" SELECT (SELECT ref_no FROM annathanam_new WHERE booking_type = 3 AND date >= '$dailyclosing_start_date' AND date <= '$dailyclosing_end_date' ORDER BY date ASC, ref_no ASC LIMIT 1) AS first_ref_no, (SELECT ref_no FROM annathanam_new WHERE date >= '$dailyclosing_start_date' AND date <= '$dailyclosing_end_date' ORDER BY date DESC, ref_no DESC LIMIT 1) AS last_ref_no; ")->getRowArray();		

		// echo '<pre>';
		// print_r($data['ubayam_details']);
		// exit;

		echo view('frontend/daily_closing/print_a4', $data);
	}
	
	public function summary_print_a4($fromdate, $todate)
	{
		$tmpid = $this->session->get('profile_id');
		if (!empty($fromdate))
			$dailyclosing_start_date = date('Y-m-d', $fromdate);
		else
			$dailyclosing_start_date = date("Y-m-d");
		if (!empty($todate))
			$dailyclosing_end_date = date('Y-m-d', $todate);
		else
			$dailyclosing_end_date = date("Y-m-d");
		//$login_id = $_SESSION['log_id_frend'];
		$archanai_data_online = daily_archanai_booking_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "", $login_id, $group_id = 54);
		$archanai_diety_data_online = daily_diety_archanai_booking_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "", $login_id);
		$data['archanai_details'] = $archanai_data_online;
		$data['archanai_diety_details'] = $archanai_diety_data_online;
		$hallbooking_data_online = daily_hall_booking_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "", $login_id);
		$data['hallbooking_details'] = $hallbooking_data_online;
		$ubayam_data = daily_ubayam_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "", $login_id);
		$data['ubayam_details'] = $ubayam_data;
		$donation_data = daily_donation_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "", $login_id);
		$data['donation_details'] = $donation_data;
		$prasadam_data = daily_prasadam_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "", $login_id);
		$data['prasadam_details'] = $prasadam_data;
		$annathanam_data = daily_annathanam_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "", $login_id);
		$data['annathanam_details'] = $annathanam_data;
		$kattalai_archanai_data = daily_kattalai_archanai_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "COUNTER", $login_id);
		$data['Kattalai_archanai_details'] = $kattalai_archanai_data;
		$outdoor_services_data = daily_outdoor_services_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "COUNTER", $login_id);
		$data['outdoor_services_details'] = $outdoor_services_data;
		$product_offering_data = daily_product_offering_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "COUNTER", $login_id);
		$data['product_offering_details'] = $product_offering_data;
		$catering_data = daily_catering_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "COUNTER", $login_id);
		$data['catering_details'] = $catering_data;
		$member_data = daily_member_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "", $login_id);
		$data['member_details'] = $member_data;
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
		$data['dailyclosing_start_date'] = $dailyclosing_start_date;
		$data['dailyclosing_end_date'] = $dailyclosing_end_date;
		$data['coin_denominations'] = $this->db->query("SELECT max(cv.name) as name, sum(cv.value * cd.quantity) as amount, max(cd.coin_key) as coin_key, sum(cd.quantity) as quantity, sum(cv.value * cd.c_quantity) as c_amount,  max(cd.c_quantity) as c_quantity FROM `coin_denomination` cd left join coin_value cv on cv.key = cd.coin_key where cd.date >= '$dailyclosing_start_date' and cd.date >= '$dailyclosing_end_date' group by coin_key order by cv.order_no")->getResult();
		// $data['floating_cash'] = $this->db->query("SELECT sum(amount) as amount FROM `floating_cash` where date >= '$dailyclosing_start_date' and date >= '$dailyclosing_end_date'")->getRowArray();
		$data['floating_cash'] = $this->db->query("SELECT sum(amount) as amount, checked_by FROM `floating_cash` WHERE date >= '$dailyclosing_start_date' AND date <= '$dailyclosing_end_date' GROUP BY checked_by")->getRowArray();
		$repayment_data = daily_repayment_data_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "", $login_id);
		$data['repayment_details'] = $repayment_data;

		// echo '<pre>';
		// print_r($data['ubayam_details']);
		// exit;

		echo view('frontend/daily_closing/summary_print_a4', $data);
	}

	public function summary_cash_denomination_a4($fromdate, $todate)
	{
		$tmpid = $this->session->get('profile_id');
		if (!empty($fromdate))
			$dailyclosing_start_date = date('Y-m-d', $fromdate);
		else
			$dailyclosing_start_date = date("Y-m-d");
		if (!empty($todate))
			$dailyclosing_end_date = date('Y-m-d', $todate);
		else
			$dailyclosing_end_date = date("Y-m-d");

		$login_id = $_SESSION['log_id_frend'];
		$archanai_data_online = daily_archanai_booking_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "", $login_id);
		$archanai_diety_data_online = daily_diety_archanai_booking_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "", $login_id);
		$data['archanai_details'] = $archanai_data_online;
		$data['archanai_diety_details'] = $archanai_diety_data_online;
		$hallbooking_data_online = daily_hall_booking_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "", $login_id);
		$data['hallbooking_details'] = $hallbooking_data_online;
		$ubayam_data = daily_ubayam_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "", $login_id);
		$data['ubayam_details'] = $ubayam_data;
		$donation_data = daily_donation_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "", $login_id);
		$data['donation_details'] = $donation_data;
		$prasadam_data = daily_prasadam_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "", $login_id);
		$data['prasadam_details'] = $prasadam_data;
		$annathanam_data = daily_annathanam_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "", $login_id);
		$data['annathanam_details'] = $annathanam_data;
		$kattalai_archanai_data = daily_kattalai_archanai_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "COUNTER", $login_id);
		$data['Kattalai_archanai_details'] = $kattalai_archanai_data;
		$outdoor_services_data = daily_outdoor_services_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "COUNTER", $login_id);
		$data['outdoor_services_details'] = $outdoor_services_data;
		$member_data = daily_member_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "", $login_id);
		$data['member_details'] = $member_data;
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
		$data['dailyclosing_start_date'] = $dailyclosing_start_date;
		$data['dailyclosing_end_date'] = $dailyclosing_end_date;
		$data['coin_denominations'] = $this->db->query("SELECT max(cv.name) as name, max(cv.value) as value, sum(cv.value * cd.quantity) as amount, max(cd.coin_key) as coin_key, sum(cd.quantity) as quantity, sum(cv.value * cd.c_quantity) as c_amount,  max(cd.c_quantity) as c_quantity FROM `coin_denomination` cd left join coin_value cv on cv.key = cd.coin_key where cd.date >= '$dailyclosing_start_date' and cd.date <= '$dailyclosing_end_date' group by coin_key order by cv.order_no")->getResult();
		// $data['floating_cash'] = $this->db->query("SELECT sum(amount) as amount FROM `floating_cash` where date >= '$dailyclosing_start_date' and date >= '$dailyclosing_end_date'")->getRowArray();
		$data['floating_cash'] = $this->db->query("SELECT sum(amount) as amount, checked_by FROM `floating_cash` WHERE date >= '$dailyclosing_start_date' AND date <= '$dailyclosing_end_date' GROUP BY checked_by")->getRowArray();
		$repayment_data = daily_repayment_data_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "", $login_id);
		$data['repayment_details'] = $repayment_data;
		// echo '<pre>';
		// print_r($data['annathanam_details']);
		// exit;
		echo view('frontend/daily_closing/cash_denomination_a4', $data);
	}

	public function summary_print($fromdate, $todate)
	{
		$tmpid = $this->session->get('profile_id');
		if (!empty($fromdate))
			$dailyclosing_start_date = date('Y-m-d', $fromdate);
		else
			$dailyclosing_start_date = date("Y-m-d");
		if (!empty($todate))
			$dailyclosing_end_date = date('Y-m-d', $todate);
		else
			$dailyclosing_end_date = date("Y-m-d");
		//$login_id = $_SESSION['log_id_frend'];
		$archanai_data_online = daily_archanai_booking_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "", $login_id);
		$data['archanai_details'] = $archanai_data_online;
		$archanai_diety_data_online = daily_diety_archanai_booking_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "", $login_id);
		$data['archanai_diety_details'] = $archanai_diety_data_online;
		$hallbooking_data_online = daily_hall_booking_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "", $login_id);
		$data['hallbooking_details'] = $hallbooking_data_online;
		$ubayam_data = daily_ubayam_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "", $login_id);
		$data['ubayam_details'] = $ubayam_data;
		$donation_data = daily_donation_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "", $login_id);
		$data['donation_details'] = $donation_data;
		$prasadam_data = daily_prasadam_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "", $login_id);
		$data['prasadam_details'] = $prasadam_data;
		$annathanam_data = daily_annathanam_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "", $login_id);
		$data['annathanam_details'] = $annathanam_data;
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
		$data['dailyclosing_start_date'] = $dailyclosing_start_date;
		$data['dailyclosing_end_date'] = $dailyclosing_end_date;
		$data['coin_denominations'] = $this->db->query("SELECT max(cv.name) as name, sum(cv.value * cd.quantity) as amount, max(cd.coin_key) as coin_key, sum(cd.quantity) as quantity, sum(cv.value * cd.c_quantity) as c_amount,  max(cd.c_quantity) as c_quantity FROM `coin_denomination` cd left join coin_value cv on cv.key = cd.coin_key where cd.date >= '$dailyclosing_start_date' and cd.date >= '$dailyclosing_end_date' group by coin_key order by cv.order_no")->getResult();
	
		// $data['floating_cash'] = $this->db->query("SELECT sum(amount) as amount FROM `floating_cash` where date >= '$dailyclosing_start_date' and date >= '$dailyclosing_end_date'")->getRowArray();
		$data['floating_cash'] = $this->db->query("SELECT sum(amount) as amount, checked_by FROM `floating_cash` WHERE date >= '$dailyclosing_start_date' AND date <= '$dailyclosing_end_date' GROUP BY checked_by")->getRowArray();
		$repayment_data = daily_repayment_data_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "", $login_id);
		$data['repayment_details'] = $repayment_data;

		echo view('frontend/daily_closing/summary_print', $data);
	}

	public function print_sales_summary()
	{
		$data['sale_summary'] = $_POST['sale_summary'];
		$data['sale_summary_qty'] = $_POST['sale_summary_qty'];
		$data['sale_summary_amount'] = $_POST['sale_summary'];

		echo view('frontend/daily_closing/daily_sales_report', $data);
	}

	function get_coin_values()
	{
		$db = db_connect(); // Connect to the database
		$query = $db->table('coin_value')->select("*");
		$result = $query->get()->getResultArray();

		return $this->response->setJSON($result);
	}


	public function save_coin_denominations()
	{
		$msg_data = ['err' => '', 'succ' => ''];

		$quantities = $_POST['quantity'] ?? [];
		$c_quantities = $_POST['c_quantity'] ?? [];
		$floating_cash = $_POST['floating_cash'] ?? 0;
		$checked_by = $_POST['checked_by'] ?? null;

		$successCount = 0;
		$errorCount = 0;
		if (count($quantities) > 0) {
			$this->db->table('coin_denomination')->where('date', date('Y-m-d'))->delete();
			$this->db->table('floating_cash')->where('date', date('Y-m-d'))->delete();
			
			foreach ($quantities as $index => $quantity) {
				$quantity = trim($quantities[$index]);
				$c_quantity = trim($c_quantities[$index]);

				$quantity = !empty($quantity) ? $quantity : 0;
				$data = [
					'date' => date('Y-m-d'),
					'coin_key' => $index,
					'quantity' => $quantity,
					'c_quantity' => $c_quantity,
					'created_at' => date('Y-m-d H:i:s'),
					'modified_at' => date('Y-m-d H:i:s')
				];

				$this->db->table('coin_denomination')->insert($data);
				if ($this->db->affectedRows() > 0) {
					$successCount++;
				} else {
					$errorCount++;
					$msg_data['err'] = "Failed to insert data for '{$coin_name}'.";
				}
			}
			// Insert floating cash entry
			$floating_data = [
				'date' => date('Y-m-d'),
				'amount' => $floating_cash,
				'checked_by' => $checked_by, 
				'created_at' => date('Y-m-d H:i:s'),
				'modified_at' => date('Y-m-d H:i:s')
			];
			$this->db->table('floating_cash')->insert($floating_data);
		}

		if ($successCount > 0 && $errorCount == 0) {
			$msg_data['succ'] = 'Data saved successfully!';
		} elseif ($successCount > 0 && $errorCount > 0) {
			$msg_data['succ'] .= ' Data saved with some errors.';
		} else {
			$msg_data['err'] .= ' Failed to save data.';
		}

		echo json_encode($msg_data);
		exit();
	}


}
