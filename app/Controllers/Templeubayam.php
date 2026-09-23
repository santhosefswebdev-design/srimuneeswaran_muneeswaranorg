<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PermissionModel;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\RequestModel;

class Templeubayam extends BaseController
{
	function __construct()
	{
		parent::__construct();
		helper('url');
		helper('common');
		$this->model = new PermissionModel();
		if (($this->session->get('login')) == false && $this->session->get('role') != 1) {
			$data['dn_msg'] = 'Please Login';
			header('Location: ' . base_url() . '/login');
			exit;
		}
	}

	public function index()
	{
		$data = array();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('templeubayam/index', $data);
		echo view('template/footer');
	}

	public function add_booking()
	{
		//   if (!$this->model->permission_validate('temple_ubayam', 'create_p')) {
		// 	header('Location: ' . base_url() . '/dashboard');
		//   }
		$data['permission'] = $this->model->get_permission('hall_booking');
		$date = $this->request->uri->getSegment(3);
		$cur_date = date('Y-m-d');
		$date_three_days_ago = date('Y-m-d', strtotime('+3 days', strtotime($cur_date)));
		$data["temple_block_date"] = "";
			
		if ($date > $date_three_days_ago) {
			
			$retndate = $this->db->table('overall_temple_block')->select('date')->where('date', $date)->get()->getRowArray();
			if($retndate){
				$data["temple_block_date"] = "Kindly select various dates";
				echo view('template/header');
				echo view('template/sidebar');
				echo view('templeubayam/index', $data);
				echo view('template/footer');

			} else {
				$data['date'] = $date;
				//   $data['data_time'] = $data_time;
				//   $data['time_name'] = $time_name;
				// $data['time_list'] = $this->db->table("booking_slot_new")
				// ->select("booking_slot_new.*, booking_slot_type_new.*")
				// ->join("booking_slot_type_new", "booking_slot_type_new.booking_slot_id = booking_slot_new.id", "left")
				// ->where("booking_slot_type_new.slot_type", 2)
				// ->where("booking_slot_new.status", 1)
				// ->get()
				// ->getResultArray();

				$subquery = "SELECT booking_slot_id FROM temple_session_block WHERE date = '{$date}' AND event_type = booking_slot_type_new.slot_type";
				$subquery2 = "SELECT booking_slot_id FROM temple_session_spl_event WHERE date = '{$date}' AND event_type = booking_slot_type_new.slot_type";

				$data['time_list'] = $this->db->table("booking_slot_new")
					->select("booking_slot_new.*, booking_slot_type_new.*")
					->join("booking_slot_type_new", "booking_slot_type_new.booking_slot_id = booking_slot_new.id", "left")
					->where("booking_slot_type_new.slot_type", 2)
					->where("booking_slot_new.status", 1)
					->where("booking_slot_new.id NOT IN ({$subquery})", NULL, false) 
					->where("booking_slot_new.id NOT IN ({$subquery2})", NULL, false) 
					->get()
					->getResultArray();
				if(!$data['time_list']){
					$data["temple_block_date"] = "Selected date is not available, Kindly select various date!";
					echo view('template/header');
					echo view('template/sidebar');
					echo view('templeubayam/index', $data);
					echo view('template/footer');
					exit;
				}		


				// $query = $this->db->query("SELECT ubayam FROM terms_conditions ");
				// $result = $query->getRowArray();
				// $data['terms'] = json_decode($result['ubayam'], true);

				$data['staff'] = $this->db->table("staff")->where('is_admin', 0)->get()->getResultArray();
				//$data['package'] = $this->db->table("temple_packages")->where('package_type', 2)->where('status', 1)->get()->getResultArray();
				$data['package'] = array();
				$data['payment_modes'] = $this->db->table('payment_mode')->where('status', 1)->where('paid_through', 'DIRECT')->get()->getResultArray();
				$data['phone_codes'] = $this->db->table("phone_code")->orderBy('dailing_code', 'ASC')->get()->getResultArray();
				$data['rasi'] = $this->db->table('rasi')->get()->getResultArray();
				$data['package_addon'] = $this->db->table("temple_services")->where('service_type', 2)->where('add_on', 1)->where('status', 1)->get()->getResultArray();
				$data['abishegam_deities'] = $this->db->table("deity")->where('status', 1)->where('abishegam_status', 1)->select('id, name_eng, name_tamil, abishegam_amount')->get()->getResultArray();
				$data['homam_deities'] = $this->db->table("deity")->where('status', 1)->where('homam_status', 1)->select('id, name_eng, name_tamil, homam_amount')->get()->getResultArray();
				$data['prasadam_groups'] = $this->db->table('prasadam_group')->get()->getResultArray();

				$data['annathanam_packages'] = $this->db->table('annathanam_packages')->where('status', 1)->where('view', 1)->select('id, name_eng, name_tamil, amount')->get()->getResultArray();

				echo view('template/header');
				echo view('template/sidebar');
				echo view('templeubayam/add_booking_new', $data);
				echo view('template/footer');
			}
		} else {
			$data["temple_block_date"] = "You can book 3 days after today's date.";
			echo view('template/header');
			echo view('template/sidebar');
			echo view('templeubayam/index', $data);
			echo view('template/footer');
		}
	}

	public function get_natchathram()
	{
		$rasi_id = $_POST['rasi_id'];
		$res = $this->db->table('rasi')->where('id', $rasi_id)->get()->getRowArray();
		if (!empty ($res['natchathra_id'])) {
			$data = array("natchathra_id" => $res['natchathra_id'], "rasi_id" => $res['rasi_id']);
		} else {
			$res_natchathrams = $this->db->table('natchathram')->get()->getResultArray();
			$data_bf = array();
			foreach ($res_natchathrams as $res_natchathram) {
				$data_bf[] = $res_natchathram['id'];
			}
			$dataip = implode(',', $data_bf);
			$data = array("natchathra_id" => $dataip, "rasi_id" => $res['rasi_id']);
		}
		echo json_encode($data);
		exit;
	}
	public function get_natchathram_name()
	{
		$id = $_POST['id'];
		$res = $this->db->table('natchathram')->where('id', $id)->get()->getRowArray();
		$data = array("id" => $res['id'], "name_eng" => $res['name_eng']);
		echo json_encode($data);
		exit;
	}

	public function get_prasadam_details()
	{
		$prasadam_group_id = $_POST['prasadam_group_id']; 
		$prasadam_details = $this->db->table('prasadam_setting_group')
							->select('prasadam_setting_group.prasadam_id, prasadam_setting_group.amount, prasadam_setting.name_eng, prasadam_setting.name_tamil') 
							->join('prasadam_setting', 'prasadam_setting_group.prasadam_id = prasadam_setting.id', 'inner') 
							->where('prasadam_setting_group.prasadam_group_id', $prasadam_group_id) 
							->get()
							->getResultArray();

		return $this->response->setJSON($prasadam_details);
	}

	public function getAddonsForPackage() 
	{
		$packageId = $_POST['annathanam_package_id']; 
		$results = $this->db->table('annathanam_package_items')
							->select('annathanam_items.id, annathanam_items.name_eng, annathanam_items.name_tamil, annathanam_items.amount, annathanam_package_items.add_on')
							->join('annathanam_items', 'annathanam_package_items.item_id = annathanam_items.id')
							->where('annathanam_package_items.package_id', $packageId)
							->where('annathanam_items.status', 1)
							->get()
							->getResultArray();
	
		// Prepare arrays to hold items and addons
		$items = [];
		$addons = [];
	
		// Iterate over the results and classify them into items and addons
		foreach ($results as $row) {
			if ($row['add_on'] == 0) {
				// This is an item
				$items[] = [
					'id' => $row['id'],
					'name_eng' => $row['name_eng'],
					'name_tamil' => $row['name_tamil']
				];
			} else {
				// This is an addon
				$addons[] = [
					'id' => $row['id'],
					'name_eng' => $row['name_eng'],
					'name_tamil' => $row['name_tamil'],
					'amount' => $row['amount']
				];
			}
		}
	
		// Encode and return both items and addons in a JSON format
		echo json_encode(['items' => $items, 'addons' => $addons]);
	}
	

	public function getpack_amt()
	{
	  $id = $_POST['id'];
	  $res = $this->db->table("temple_packages")->where("id", $id)->get()->getRowArray();
	  //$amt = $res['amount'] + $res['commision'];
	  $amt = $res['amount'];
	  $data['id'] = $res['id'];
	  $data['amt'] = $amt;
	  $data['name'] = $res['name'];
	  $data['description'] = $res['description'];
	  echo json_encode($data);
	}

	public function get_service_list()
	{
		$resp = array();
		$pack_id = $_POST['id'];
		$get_result_details = $this->db->table("temple_packages")->where("id", $pack_id)->get()->getResultArray();
		$resp['data']['services'] = $get_result_details;
		$resp['data']['addons'] =  $this->db->query("select * from temple_services where id in(select service_id from temple_package_addons where package_id in ($pack_id))")->getResultArray();
		echo json_encode($resp);
	}

	public function get_service_name(){
		$id = $_REQUEST['id'];
		$res = $this->db->table("temple_packages")->where("id", $id)->get()->getRowArray();
		$temple_package_services = $this->db->table("temple_package_services")->join('temple_services', 'temple_services.id = temple_package_services.service_id')->select('temple_package_services.*, temple_services.name as service_name')->where("package_id", $id)->get()->getResultArray();
		  //$amt = $res['amount'] + $res['commision'];
		$description = array();
		if(count($temple_package_services)){
			foreach($temple_package_services as $tps) $description[] = $tps['service_name'];
		}
		$data['name'] = $res['name'];
		$data['amount'] = $res['amount'];
		// $data['description'] = $res['description'];
		$data['description'] = implode(', ', $description);
		echo json_encode($data);
	}

  	public function getpack_amt_addon()
	{
	  $id = $_POST['id'];
	  $res = $this->db->table("temple_services")->where("id", $id)->get()->getRowArray();
	  $amt = $res['amount'];
	  $data['amt'] = $amt;
	  $data['name'] = $res['name'];
	  echo json_encode($data);
	}

	public function get_service_list_addon()
	{
		$addon_id = $_POST['id'];
		$package_id = $_POST['package_id'];
		$get_result_details = $this->db->table("temple_services")->join('temple_package_addons', 'temple_package_addons.service_id = temple_services.id')->select('temple_services.*, temple_package_addons.quantity')->where("temple_package_addons.package_id", $package_id)->where("temple_package_addons.service_id", $addon_id)->get()->getResultArray();
		echo json_encode($get_result_details);
	}

	public function get_service_name_addon()
	{
		$id = $_POST['id'];
		$res = $this->db->table("temple_services")->where("id", $id)->get()->getRowArray();
		$data['name'] = $res['name'];
		$data['amount'] = $res['amount'];
		$data['description'] = $res['description'];
		echo json_encode($data);
	}

	public function ubayambook_list()
	{
		$data['permission'] = $this->model->get_permission('hall_booking');
		$date = $_REQUEST['date'];

		$data["temple_block_date"] = "";
		$retndate = $this->db->table('overall_temple_block')->select('date')->where('date', $date)->get()->getRowArray();
		if($retndate){
			$data["temple_block_date"] = "Kindly select various date";
			echo view('template/header');
			echo view('template/sidebar');
			echo view('templeubayam/index', $data);
			echo view('template/footer');

		} else {
			$data['list'] = $this->db->table("templebooking")->where("DATE_FORMAT(templebooking.booking_date, '%Y-%m-%d')", $date)->where('templebooking.booking_type', 2)->get()->getResultArray();
			$data['payment_modes'] = $this->db->table('payment_mode')->where('status', 1)->where('paid_through', 'DIRECT')->get()->getResultArray();
			// foreach ($data['list'] as &$d_list) {
			//   $slot_details = $this->db->table("booking_slot")->select('booking_slot.*')->join('hall_booking_slot_details', 'hall_booking_slot_details.booking_slot_id = booking_slot.id')->where("hall_booking_slot_details.hall_booking_id", $d_list['id'])->get()->getResultArray();
			//   $d_list['slot_details'] = $slot_details;
			// }
			$data['date'] = $date;
			// print_r($data);die;
			echo view('template/header');
			echo view('template/sidebar');
			echo view('templeubayam/templeubayamlist', $data);
			echo view('template/footer');
		}
	}
	public function get_payment_mode()
	{
		$id = $_POST['id'];
		$res = $this->db->table("payment_mode")->where("id", $id)->get()->getRowArray();
		$p_id = $res['id'];
		$name = $res['name'];
		$data['id'] = $p_id;
		$data['name'] = $name;
		echo json_encode($data);
	}

	public function overall_blocked_event_check(){
		$eventdate = $_POST['eventdate'];
		$retndate = $this->db->table('overall_temple_block')->select('date')->where('date', $eventdate)->get()->getRowArray();
		echo !empty($retndate['date']) ? $retndate['date'] : "";
	}
	
	public function print_page()
	{
		if (!$this->model->permission_validate('ubayam', 'print')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
	
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
		$data['data'] = $this->db->table('templebooking')->where('templebooking.id', $id)->get()->getRowArray();
		// $data['packages'] = $this->db->table("booked_packages")->select('name, quantity, amount')->where('booking_id', $id)->get()->getRowArray();
		$data['packages'] = $this->db->table("booked_packages")
			->select('name, quantity, amount')
			->where('booking_id', $id)
			->get()
			->getResultArray(); // Changed fr
		$data['services'] = $this->db->table("booked_services")->select('name, quantity, amount')->where('booking_id', $id)->get()->getResultArray();
		$data['booked_addon'] = $this->db->table("booked_addon")->select('name, quantity, amount')->where("booking_id", $id)->get()->getResultArray();
		$data['abishegam'] = $this->db->table("booked_abishegam_details")->select('name, quantity, amount')->where("templebooking_id", $id)->get()->getResultArray();
		$data['homam'] = $this->db->table("booked_homam_details")->select('name, quantity, amount')->where("templebooking_id", $id)->get()->getResultArray();
		$data['booked_extra'] = $this->db->table("booked_extra_charges")->select('description, amount')->where("booking_id", $id)->where("booking_type", 2)->get()->getResultArray();
		$data['prasadam'] = $this->db->table("prasadam")
				->select('prasadam_booking_details.quantity, prasadam_booking_details.amount, prasadam_setting.name_eng, prasadam_setting.name_tamil,')
				->join('prasadam_booking_details', 'prasadam.id = prasadam_booking_details.prasadam_booking_id')
				->join('prasadam_setting', 'prasadam_booking_details.prasadam_id = prasadam_setting.id')
				->where('prasadam.booking_id', $id)->where('prasadam.booking_type', 2)->get()->getResultArray();
				
		$data['annathanam'] = $this->db->table("annathanam_new")
				->select('annathanam_new.no_of_pax, annathanam_new.amount, annathanam_packages.name_eng')
				->join('annathanam_packages', 'annathanam_packages.id = annathanam_new.package_id', 'inner')
				->where("annathanam_new.booking_id", $id)->where('annathanam_new.booking_type' ,2)->get()->getResultArray();

		$data['annathanam_addons'] = $this->db->table("annathanam_new")
				->select('annathanam_booked_addon.quantity, annathanam_booked_addon.item_amount, annathanam_items.name_eng')
				->join('annathanam_booked_addon', 'annathanam_booked_addon.annathanam_id = annathanam_new.id', 'inner')
				->join('annathanam_items', 'annathanam_items.id = annathanam_booked_addon.item_id', 'inner')
				->where("annathanam_new.booking_id", $id)->where('annathanam_new.booking_type' ,2)->get()->getResultArray();

		$data['pay_details'] = $this->db->table("booked_pay_details")->where("booking_id", $id)->get()->getResultArray();
	    /*print_r($data['pay_details']);	exit;*/
		echo view('frontend/templeubayam_new/print_page', $data);
	}
	public function gtpaymentdata()
	{
		$id = $_POST['id'];
		$res = $this->db->table("templebooking")->where("id", $id)->get()->getRowArray();
		//$amt = $res['amount'] + $res['commision'];
		$amt = $res['amount'];
		$data['amt'] = $amt;
		$res1 = $this->db->table("booked_pay_details")->selectSum('amount')->where("booking_id", $id)->get()->getRowArray();
		$paid_amount = $res1['amount'];
		$data['paid_amount'] = $paid_amount;
		$data['bal_amount'] = $amt - $paid_amount;

		echo json_encode($data);
	}
	public function save_repayment()
	{
		if(!empty($_POST['payment_mode']) && !empty($_POST['pay_amount'])&& !empty($_POST['booking_id'])){
			$date = $_POST['date'];
			$pay_amount = $_POST['pay_amount'];
			$payment_mode = $_POST['payment_mode'];
			$booking_id = $_POST['booking_id'];
			$count = $this->db->table("payment_mode")->where('id', $payment_mode)->get()->getNumRows();
			if($count > 0){
				$payment_mode_details = $this->db->table("payment_mode")->where('id', $payment_mode)->get()->getRowArray();
				$ubayam_details = $this->db->table("templebooking")->where('id', $booking_id)->get()->getRowArray();
				if($ubayam_details['amount'] >= ($ubayam_details['paid_amount'] + $pay_amount)){
					$booking_payment_ins_data = array();
					$booking_payment_ins_data['booking_id'] = $booking_id;
					$booking_payment_ins_data['booking_type'] = 2;
					$booking_payment_ins_data['booking_ref_no'] = $ubayam_details['ref_no'];
					$booking_payment_ins_data['payment_mode_id'] = $payment_mode;
					$booking_payment_ins_data['paid_date'] = !empty($date) ? $date : date('Y-m-d');
					$booking_payment_ins_data['amount'] = $pay_amount;
					$booking_payment_ins_data['payment_mode_title'] = $payment_mode_details['name'];
					$paid_through = 'ADMIN';
					if($paid_through != 'ADMIN' && $paid_through != 'COUNTER') $booking_payment_ins_data['payment_ref_no'] = $ubayam_details['ref_no'];
					$booking_payment_ins_data['paid_through'] = $paid_through;
					$booking_payment_ins_data['pay_status'] = ($paid_through == 'ADMIN' || $paid_through == 'COUNTER') ? 2 : 1;
					$this->requestmodel = new RequestModel();
					$ip = $this->requestmodel->getIpAddress();
					$booking_payment_ins_data['ip'] = $ip;
					if ($ip != 'unknown') {
						$ip_details = $this->requestmodel->getLocation($ip);
						$booking_payment_ins_data['ip_location'] = (!empty($ip_details['country']) ? $ip_details['country'] : 'Unknown');
						$booking_payment_ins_data['ip_details'] = json_encode($ip_details);
					} 
					// $this->paid_amount += $booking_payment_ins_data['amount'];
					$res = $this->db->table("booked_pay_details")->insert($booking_payment_ins_data);
					$booked_pay_id = $this->db->insertID();
					$this->db->query("UPDATE templebooking SET paid_amount = paid_amount + ? WHERE id = ?", [$pay_amount, $booking_id]);
					$query = $this->db->table('templebooking')->where('id', $booking_id)->get()->getRowArray();
					if ($query['amount'] == $query['paid_amount']) {
						$this->db->query("UPDATE templebooking SET payment_status = 2 WHERE id = ?", [$booking_id]);
					}elseif($query['paid_amount'] > 0 && $query['payment_status'] == 0){
						$this->db->query("UPDATE templeboking SET payment_status = 1 WHERE id = ?", [$booking_id]);
					}
					$this->partial_account_migration($booked_pay_id);
					echo json_encode(['status' => true, 'message' => 'Repayment saved successfully.']);
				}else{
					echo json_encode(['status' => false, 'message' => 'Payment amount not exceed Total.']);
				}
			} else {
				echo json_encode(['status' => false, 'message' => 'Failed to save repayment.']);
			}
		} else {
			echo json_encode(['status' => false, 'message' => 'Failed to save repayment.']);
		}
		exit;
	}
	public function partial_account_migration($booked_pay_id){
		$succ = true;
		$booked_pay_details_cnt = $this->db->table("booked_pay_details")->where("id", $booked_pay_id)->get()->getNumRows();	
		if ($booked_pay_details_cnt > 0) {
			$booked_pay_details = $this->db->table("booked_pay_details")->where("id", $booked_pay_id)->get()->getResultArray();
			$td_ledger = $this->db->table('ledgers')->where('name', 'TRADE RECEIVABLE')->where('group_id', 3)->where('left_code', '1200')->get()->getRowArray();
			if (!empty($td_ledger)) {
			  $cr_id1 = $td_ledger['id'];
			} else {
			  $cled1['group_id'] = 3;
			  $cled1['name'] = 'TRADE RECEIVABLE';
			  $cled1['code'] = '1200/005';
			  $cled1['op_balance'] = '0';
			  $cled1['op_balance_dc'] = 'D';
			  $cled1['left_code'] = '1200';
			  $cled1['right_code'] = '005';
			  $this->db->table('ledgers')->insert($cled1);
			  $cr_id1 = $this->db->insertID();
			}
			$booking_id = $booked_pay_details[0]['booking_id'];
			$templeubayam = $this->db->table("templebooking")->where("id", $booking_id)->get()->getRowArray();
			foreach ($booked_pay_details as $row) {
				$paymentmode = $this->db->table('payment_mode')->where('id', $row['payment_mode_id'])->get()->getRowArray();
				if (!empty($paymentmode['ledger_id'])) {
					$number = $this->db->table('entries')->select('number')->where('entrytype_id', 1)->orderBy('id', 'desc')->get()->getRowArray();
					if (empty($number))
						$num = 1;
					else
						$num = $number['number'] + 1;
					// Get Entry Code
					$qry = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='" . $yr . "' and entrytype_id =1 and month (date)='" . $mon . "')")->getRowArray();

					$entries['entry_code'] = 'REC' . date('y', strtotime($row['paid_date'])) . date('m', strtotime($row['paid_date'])) . (sprintf("%05d", (((float) substr($qry['entry_code'], -5)) + 1)));
					$entries['entrytype_id'] = '1';
					$entries['number'] = $num;
					$entries['date'] = $row['paid_date'];
					$entries['dr_total'] = $row['amount'];
					$entries['cr_total'] = $row['amount'];
					$entries['narration'] = 'Hall Booking(' . $templeubayam['ref_no'] . ')' . "\n" . 'name:' . $templeubayam['name'] . "\n" . 'NRIC:' . $templeubayam['ic_number'] . "\n" . 'email:' . $templeubayam['email'] . "\n";
					$entries['inv_id'] = $booking_id;
					$entries['type'] = 8;
					//Insert Entries
					$ent = $this->db->table('entries')->insert($entries);
					$en_id = $this->db->insertID();
					if (!empty($en_id)) {
						// Trade Debtors => Credit
						$eitems_hall_book['entry_id'] = $en_id;
						$eitems_hall_book['ledger_id'] = $cr_id1;
						$eitems_hall_book['amount'] = $row['amount'];
						$eitems_hall_book['dc'] = 'C';
						if ($templeubayam['booking_type'] == 2){$eitems_hall_book['details'] = 'Ubayam Amount';}
						elseif ($templeubayam['booking_type'] == 1){$eitems_hall_book['details'] = 'Hall Booking Amount';}
						else {$eitems_hall_book['details'] = 'Sannathi Amount';}
						$this->db->table('entryitems')->insert($eitems_hall_book);
						// PETTY CASH => Debit 
						$eitems_cash_led['entry_id'] = $en_id;
						$eitems_cash_led['ledger_id'] = $paymentmode['ledger_id'];
						$eitems_cash_led['amount'] = $row['amount'];
						$eitems_cash_led['dc'] = 'D';
						if ($templeubayam['booking_type'] == 2){$eitems_cash_led['details'] = 'Ubayam Amount';}
						elseif ($templeubayam['booking_type'] == 1){$eitems_cash_led['details'] = 'Hall Booking Amount';}
						else {$eitems_cash_led['details'] = 'Sannathi Amount';}
						$this->db->table('entryitems')->insert($eitems_cash_led);
					}
				}else{
					$succ = false;
					return $succ;
				}
			}
		}else{
			$succ = false;
			return $succ;
		}
	}
// 	public function event_list()
//   {
//     $query = $this->db->query("SELECT  tu.id, tu.booking_date, tu.created_at, bp.name FROM  templebooking tu 
// 				JOIN booked_packages bp ON tu.id = bp.booking_id 
// 				WHERE tu.booking_status != 3
// 				and tu.booking_type = 2
// 				GROUP BY tu.booking_date
// 				ORDER BY tu.created_at ASC;");
//     $res = $query->getResultArray();
    
//     $res_array = array();
//     foreach($res as $row){
//         $html = $row['name'];
//         $hb_booking_date = $row['booking_date'];
//         // $hb_slot_id = $row['hall_id'];
//         // $slot_dets = $this->db->query("SELECT bs.name,bs.description,bs.slot_season,hbsd.hall_booking_id FROM hall_booking_slot_details as hbsd JOIN booking_slot as bs ON bs.id = hbsd.booking_slot_id where hbsd.hall_booking_id = $hb_slot_id ")->getResultArray();
//         // foreach($slot_dets as $slot_row){
//         //     $hb_id = $slot_row['hall_booking_id'];
//         //     $html[]= $slot_row['name']."-".$slot_row['description']."\n(".$slot_row['slot_season'].")"."\n";
//         //     $service_dets = $this->db->query("SELECT hbsd.service_name FROM hall_booking_service_details as hbsd where hbsd.hall_booking_id = $hb_id ")->getResultArray();
//         //     foreach($service_dets as $service_row){
//         //         $html[]= $service_row['service_name']."\n";
//         //     }
//         // }
//         $res_array[] = array('booking_date'=>$hb_booking_date,'slot_pack_dets'=>$html);
//     }
//     //var_dump(json_encode($res_array));
//     //exit;
//     echo json_encode($res_array);
//   }

	public function event_list()
	{
		$query = $this->db->query("SELECT tu.id, tu.booking_date, tu.created_at, bp.name 
                               FROM templebooking tu 
                               JOIN booked_packages bp ON tu.id = bp.booking_id 
                               WHERE tu.booking_status != 3 AND tu.booking_type = 2
                               ORDER BY tu.created_at ASC;");
		$res = $query->getResultArray();

		$res_array = [];
		foreach ($res as $row) {
			$booking_date = $row['booking_date'];
			if (!isset($res_array[$booking_date])) {
				$res_array[$booking_date] = [
					'booking_date' => $booking_date,
					'slot_pack_dets' => []
				];
			}
			// Append this booking's details to the existing date
			$res_array[$booking_date]['slot_pack_dets'][] = $row['name'];
		}

		// Prepare final array for JSON encoding
		$final_array = [];
		foreach ($res_array as $date => $info) {
			$final_array[] = [
				'booking_date' => $info['booking_date'],
				'slot_pack_dets' => implode(", ", $info['slot_pack_dets']) // Combine all slots details
			];
		}

		echo json_encode($final_array);
	}

	public function update_booking_status()
{
    $id = $_POST['id'];
    $status = $_POST['status'];

    $data = [
        'booking_status' => $status
    ];

    $this->db->table('templebooking')
             ->where('id', $id)
             ->update($data);

    if($this->db->affectedRows() > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
}
public function get_terms()
{
    $name = $this->request->getPost('name');
    $ic_number = $this->request->getPost('ic_number');

    if (!$name || !$ic_number) {
        return $this->response->setJSON(['success' => false]);
    }

    $query = $this->db->query("SELECT ubayam FROM terms_conditions");
    $result = $query->getRowArray();
    $terms = json_decode($result['ubayam'], true);

    $terms_html = '';
    foreach ($terms as $term) {
        $replaced_term = str_replace('[person_name]', $name, $term);
        $replaced_term = str_replace('[ic_number]', $ic_number, $replaced_term);
        $stripped_term = strip_tags($replaced_term);
        
        $terms_html .= '
        <div class="form-group">
            <label class="custom-checkbox">
                ' . strip_tags($stripped_term) . '
                <input type="checkbox" class="term-checkbox" name="terms[]" value="' . strip_tags($stripped_term) . '">
                <span class="checkmark"></span>
            </label>
        </div>';
    }

    return $this->response->setJSON([
        'success' => true,
        'terms' => $terms_html
    ]);
}
}
