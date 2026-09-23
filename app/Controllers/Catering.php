<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\RequestModel;

class Catering extends BaseController
{
    function __construct(){
        parent:: __construct();
        helper('url');
        helper('common');
		$this->model = new PermissionModel();
        if( ($this->session->get('login') ) == false && $this->session->get('role') != 1){
            $data['dn_msg'] = 'Please Login';
            header('Location: '.base_url().'/login'); 
            exit;
		}
    }

    public function index()
	{
		$data['list'] = $this->db->table('annathanam_new')->where('booking_type', 3)->get()->getResultArray();
		$data['payment_modes'] = $this->db->table('payment_mode')->where("catering", 1)->orderby('menu_order', "ASC")->where('status', 1)->where('paid_through', 'DIRECT')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('catering/index',$data);
		echo view('template/footer');
	}

	public function add_catering()
	{
		$data['phone_codes'] = $this->db->table("phone_code")->orderBy('dailing_code', 'ASC')->get()->getResultArray();
		$data['payment_modes'] = $this->db->table('payment_mode')->where("catering", 1)->orderby('menu_order', "ASC")->where('status', 1)->where('paid_through', 'DIRECT')->get()->getResultArray();
		$data['packages'] = $this->db->table('annathanam_packages')->select('id, name_eng, name_tamil, amount, view')->where('status', 1)->get()->getResultArray();
		$yr=date('Y');
		$mon=date('m');
		$query   = $this->db->query("SELECT ref_no FROM annathanam_new where booking_type = 3 AND id=(select max(id) from annathanam_new where year (date)='". $yr ."' and month (date)='". $mon ."')")->getRowArray();
      	$data['bill_no']= 'CA' .date('y').$mon. (sprintf("%05d",(((float)  substr($query['ref_no'],-5))+1)));
		$data['terms'] = json_decode($result['catering'], true);
		$settings = $this->db->table('settings')->where('type', 10)->get()->getResultArray();
		$setting_array = array();
		if(count($settings) > 0){
			foreach ($settings as $item) {
				$setting_array[$item['setting_name']] = $item['setting_value'];
			}
		}
		$data['setting'] = $setting_array;

		echo view('template/header');
		echo view('template/sidebar');
		echo view('catering/add_catering',$data);
		echo view('template/footer');
	}

	public function save_catering(){
		// echo "<pre>";
		// print_r($_POST);
		// exit;
		$msg_data = array();
		$msg_data['err'] = '';
		$msg_data['succ'] = '';
		$this->db->transStart();
		try{
			$yr= date('Y', strtotime($_POST['date']));
			$mon= date('m', strtotime($_POST['date']));
			$data['date'] = date('Y-m-d', strtotime($_POST['date']));
			$data['event_date'] = $event_date = date('Y-m-d', strtotime($_POST['event_date']));
			$query = $this->db->query("SELECT ref_no FROM annathanam_new WHERE booking_type = 3 AND id=(SELECT max(id) FROM annathanam_new WHERE year(date)='". $yr ."' AND month(date)='". $mon ."')")->getRowArray();
			$data['ref_no'] = 'CA' .date('y', strtotime($_POST['date'])) . $mon . (sprintf("%05d", (((float) substr($query['ref_no'], -5)) + 1)));
			$data['booking_type'] = 3;
			$data['name'] = $_POST['name'];
			$data['phone_code'] = $_POST['phone_code'];
			$data['phone_no'] = $_POST['phone_no'];
			$mobile = $_POST['phone_code'] . $_POST['phone_no'];
			$data['is_special'] = 1;
			$data['package_id'] = $package_id = 1;
			$data['dob'] = $_POST['dob'];
			$data['address'] = $_POST['address'];
			$data['pickup_time'] = $_POST['pickup_time'];
			$data['slot_time'] = $_POST['time'];
			$time_session = ($data['slot_time'] == 'Breakfast') ? "AM" : "PM";
			$data['serve_time'] = $_POST['hour'] . ':' . $_POST['minute'] .' '. $time_session;
			$tot_amt = $_POST['total_amount'];
			$sub_total = $tot_amt;
			if (!empty($_POST['discount_amount'])) {
				$data['discount_amount'] = $_POST['discount_amount'];
				$sub_total += $_POST['discount_amount'];
			}
			$data['sub_total'] = $sub_total;
			$data['total_amount'] = $tot_amt;
			$data['payment_type'] = !empty($_POST['payment_type']) ? $_POST['payment_type']: 'full';
			$data['booking_through'] = 'DIRECT';
			$data['added_by'] = $this->session->get('log_id');
			$data['created'] = date('Y-m-d H:i:s');
			$data['payment_mode'] = $pay_id = $_POST['payment_mode'];
			$payment_mode = $this->db->table('payment_mode')->where("id", $pay_id)->get()->getRowArray();
			$pay_method = $payment_mode['name'];
			$data['payment_status'] = !empty($pay_method) ? 2 : 1;
	
			$res = $this->db->table('annathanam_new')->insert($data);
			$annathanam_id = $this->db->insertID();
	
			if(!empty($_POST['special'])){
				foreach ($_POST['special'] as $item) {
					$data_special_item = array(
						'annathanam_id' => $annathanam_id,
						'type_id' => $item['type_id'],
						'item_id' => $item['id'],
						'quantity' => $item['quantity'],
						'item_amount' => $item['amount'],
						'total_amount' => $item['total_amount']
					);
					$this->db->table('annathanam_booked_special')->insert($data_special_item);

					$settings = $this->db->table('settings')->where('type', 10)->where('setting_name', 'enable_madapalli')->get()->getRowArray();
					if ($settings['setting_value'] == 1) {
						$anna_set = $this->db->table('annathanam_special_items')->where('id', $item['id'])->get()->getRowArray();
						$madapalli_details['date'] = $event_date;
						$madapalli_details['type'] = 3;
						$madapalli_details['booking_id'] = $annathanam_id;
						$madapalli_details['product_id'] = $item['id'];
						$madapalli_details['quantity'] = $item['quantity'];
						$madapalli_details['amount'] = $item['total_amount'];
						$madapalli_details['session'] = $_POST['time'];
						$madapalli_details['serve_time'] = $data['serve_time'];
						$madapalli_details['customer_name'] = $_POST['name'];
						$madapalli_details['pro_name_eng'] = $anna_set['name_eng'];
						$madapalli_details['customer_mobile'] = $mobile;
						$madapalli_details['status'] = 0;
						$madapalli_details['created_by'] = $this->session->get('log_id');
						$madapalli_details['created_at'] = date('Y-m-d H:i:s');
						$madapalli_details['updated_at'] = date('Y-m-d H:i:s');
						$res_m1 = $this->db->table('madapalli_booking_details')->insert($madapalli_details);

						if ($res_m1){
							$preparation_details = $this->db->table('madapalli_preparation_details')->where('date', $event_date)->where('type', 3)->get()->getResultArray();
							$product_found1 = false;

							foreach ($preparation_details as $detail) {
								if ($detail['product_id'] == $madapalli_details['product_id'] && $detail['session'] == $madapalli_details['session'] && $detail['type'] == $madapalli_details['type']) {
									$new_quantity = $detail['quantity'] + $madapalli_details['quantity'];
									$update_data1 = [
										'quantity' => $new_quantity,
										'updated_at' => date('Y-m-d H:i:s')
									];
									$this->db->table('madapalli_preparation_details')->where('id', $detail['id'])->update($update_data1);
									$product_found1 = true;
									break;
								}
							}

							if (!$product_found1) {
								$insert_data1 = [
									'date' => $event_date,
									'type' => 3,
									'session' => $_POST['time'],
									'product_id' => $madapalli_details['product_id'],
									'pro_name_eng' => $anna_set['name_eng'],
									'pro_name_tamil' => $anna_set['name_tamil'],
									'quantity' => $madapalli_details['quantity'],
									'status' => 0,
									'created_by' => $this->session->get('log_id'),
									'created_at' => date('Y-m-d H:i:s'),
									'updated_at' => date('Y-m-d H:i:s')
								];
								$this->db->table('madapalli_preparation_details')->insert($insert_data1);
							}
						}
					}
				}
			}

			if(!empty($_POST['add_on'])){
				foreach ($_POST['add_on'] as $addon_item) {
					$data_addon_item = array(
						'annathanam_id' => $annathanam_id,
						'package_id' => $data['package_id'],
						'item_id' => $addon_item['id'],
						'quantity' => $addon_item['quantity'],
						'item_amount' => $addon_item['amount'],
						'item_total_amount' => $addon_item['total_amount'],
						'add_on' => 1
					);
					$this->db->table('annathanam_booked_addon')->insert($data_addon_item);

					$settings = $this->db->table('settings')->where('type', 10)->where('setting_name', 'enable_madapalli')->get()->getRowArray();			
					if ($settings['setting_value'] == 1) {
						
						$anna_set = $this->db->table('annathanam_items')->where('id', $addon_item['id'])->get()->getRowArray();
						$madapalli_details['date'] = $event_date;
						$madapalli_details['type'] = 3;
						$madapalli_details['booking_id'] = $annathanam_id;
						$madapalli_details['product_id'] = $addon_item['id'];
						$madapalli_details['quantity'] = $addon_item['quantity'];
						$madapalli_details['amount'] = $addon_item['total_amount'];
						$madapalli_details['session'] = $_POST['time'];
						$madapalli_details['serve_time'] = $data['serve_time'];
						$madapalli_details['customer_name'] = $_POST['name'];
						$madapalli_details['pro_name_eng'] = $anna_set['name_eng'];
						$madapalli_details['customer_mobile'] = $mobile;
						$madapalli_details['status'] = 0;
						$madapalli_details['created_by'] = $this->session->get('log_id');
						$madapalli_details['created_at'] = date('Y-m-d H:i:s');
						$madapalli_details['updated_at'] = date('Y-m-d H:i:s');
						$res_m2 = $this->db->table('madapalli_booking_details')->insert($madapalli_details);

						if ($res_m2){
							$preparation_details = $this->db->table('madapalli_preparation_details')->where('date', $event_date)->where('type', 3)->get()->getResultArray();
							$product_found2 = false;

							foreach ($preparation_details as $detail) {
								if ($detail['product_id'] == $madapalli_details['product_id'] && $detail['session'] == $madapalli_details['session'] && $detail['type'] == $madapalli_details['type']) {
									$new_quantity = $detail['quantity'] + $madapalli_details['quantity'];
									$update_data2 = [
										'quantity' => $new_quantity,
										'updated_at' => date('Y-m-d H:i:s')
									];
									$this->db->table('madapalli_preparation_details')->where('id', $detail['id'])->update($update_data2);
									$product_found2 = true;
									break;
								}
							}

							if (!$product_found2) {
								$insert_data2 = [
									'date' => $event_date,
									'type' => 3,
									'session' => $_POST['time'],
									'product_id' => $madapalli_details['product_id'],
									'pro_name_eng' => $anna_set['name_eng'],
									'pro_name_tamil' => $anna_set['name_tamil'],
									'quantity' => $madapalli_details['quantity'],
									'status' => 0,
									'created_by' => $this->session->get('log_id'),
									'created_at' => date('Y-m-d H:i:s'),
									'updated_at' => date('Y-m-d H:i:s')
								];
								$this->db->table('madapalli_preparation_details')->insert($insert_data2);
							}
						}
					}
				}
			}

			if(!empty($_POST['addi_item'])){
				$addon = $this->db->table('annathanam_items')->where('add_on', 2)->get()->getRowArray();
				foreach ($_POST['addi_item'] as $item) {
					$data_addi_item = array(
						'annathanam_id' => $annathanam_id,
						'name' => $item['name'],
						'quantity' => $item['quantity'],
						'amount' => $item['amount'],
						'total_amount' => $item['total_amount']
					);
					$this->db->table('annathanam_booked_additional')->insert($data_addi_item);

					$settings = $this->db->table('settings')->where('type', 10)->where('setting_name', 'enable_madapalli')->get()->getRowArray();			
					if ($settings['setting_value'] == 1) {
						
						$madapalli_details['date'] = $event_date;
						$madapalli_details['type'] = 3;
						$madapalli_details['is_additional'] = 1;
						$madapalli_details['booking_id'] = $annathanam_id;
						$madapalli_details['product_id'] = $addon['id'];
						$madapalli_details['quantity'] = $item['quantity'];
						$madapalli_details['amount'] = $item['total_amount'];
						$madapalli_details['session'] = $_POST['time'];
						$madapalli_details['serve_time'] = $data['serve_time'];
						$madapalli_details['customer_name'] = $_POST['name'];
						$madapalli_details['pro_name_eng'] = $item['name'];
						$madapalli_details['customer_mobile'] = $mobile;
						$madapalli_details['status'] = 0;
						$madapalli_details['created_by'] = $this->session->get('log_id');
						$madapalli_details['created_at'] = date('Y-m-d H:i:s');
						$madapalli_details['updated_at'] = date('Y-m-d H:i:s');
						$res_m2 = $this->db->table('madapalli_booking_details')->insert($madapalli_details);

						if ($res_m2){
							$insert_data2 = [
								'date' => $event_date,
								'type' => 3,
								'is_additional' => 1,
								'session' => $_POST['time'],
								'product_id' => $madapalli_details['product_id'],
								'pro_name_eng' => $item['name'],
								'pro_name_tamil' => $item['name'],
								'quantity' => $item['quantity'],
								'status' => 0,
								'created_by' => $this->session->get('log_id'),
								'created_at' => date('Y-m-d H:i:s'),
								'updated_at' => date('Y-m-d H:i:s')
							];
							$this->db->table('madapalli_preparation_details')->insert($insert_data2);
						}
					}
				}
			}
			
			$pay_details = array();
			if($pay_id){
				$payment_mode_details = $this->db->table("payment_mode")->where('id', $pay_id)->get()->getRowArray();
				$pay_details['payment_key'] = $pay_method;
				$pay_details['annathanam_id'] = $annathanam_id;
				$pay_details['is_repayment'] = 0;
				$pay_details['payment_mode_id'] = $pay_id;
				$pay_details['paid_through'] = 'DIRECT';
				$pay_details['pay_status'] = !empty($pay_method) ? 2 : 1;
				$pay_details['payment_mode_title'] = $payment_mode_details['name'];
				$pay_details['booking_ref_no'] = $data['ref_no'];
				if($data['payment_type'] == 'partial') $pay_details['amount'] = $_POST['paid_amount'];
				else $pay_details['amount'] = $tot_amt;

				if(empty($pay_details['amount'])){
					$this->db->transRollback();
					$msg_data['err'] = 'Invalid Amount';
					exit;
				}
				$pay_details['paid_date'] = date('Y-m-d');
				$this->requestmodel = new RequestModel();
				$ip = $this->requestmodel->getIpAddress();
				$pay_details['ip'] = $ip;
				if ($ip != 'unknown') {
					$ip_details = $this->requestmodel->getLocation($ip);
					$pay_details['ip_location'] = (!empty($ip_details['country']) ? $ip_details['country'] : 'Unknown');
					$pay_details['ip_details'] = json_encode($ip_details);
				}
				$this->db->table('annathanam_booked_pay_details')->insert($pay_details);
				$booking_ref_data = array();
				$booking_ref_data['paid_amount'] = $pay_details['amount'];
				$booking_ref_data['booking_status'] = 1;
				if($data['payment_type'] == 'partial'){ 
					$booking_ref_data['payment_status'] = 1;
				}else {
					$booking_ref_data['payment_status'] = 2;
				}
				$this->db->table("annathanam_new")->where('id', $annathanam_id)->update($booking_ref_data);

				$payment_gateway_data = array();
				$payment_gateway_data['annathanam_booking_id'] = $annathanam_id;
				$payment_gateway_data['pay_method'] = $pay_method;
				$resss = $this->db->table('annathanam_payment_gateway_datas')->insert($payment_gateway_data);
				
			}else{
				$this->db->transRollback();
				$msg_data['err'] = 'Invalid Payment';
				exit;
			}
			// $this->send_whatsapp_msg($annathanam_id);
			$this->account_migration($annathanam_id);
			$msg_data['id'] = $annathanam_id;
			$msg_data['succ'] = 'Catering added successfully';
			

			$this->db->transComplete();
		}catch (Exception $e) {
			$this->db->transRollback();
			$msg_data['err'] = $e->getMessage();
		}
		echo json_encode($msg_data);
		exit;
	}

	public function get_special_items() {
		$result = [];
		$special_types = $this->db->table('annathanam_special_types')->select('id, name')->where('status', 1)->get()->getResultArray();

		foreach ($special_types as $type) {
			$type_id = $type['id'];
			$special_items = $this->db->table('annathanam_special_items')->select('id, name_eng, name_tamil, amount')
									->where('type_id', $type_id)->where('status', 1)
									->get()->getResultArray();
									
			foreach ($special_items as &$item) {
				$item['type_id'] = $type_id; 
			}

			$result[$type['name']] = [
				'type_id' => $type_id,
				'items' => $special_items
			];
		}

		$addon_items = $this->db->table('annathanam_items')
						->select('id, name_eng, name_tamil, amount, add_on')
						->whereIn('add_on', [1, 2])->where('status', 1)
						->get()->getResultArray();

		$response = [
			'special' => $result,
			'addons' => $addon_items
		 ];

		echo json_encode($response);
	}

	public function print_page() {
		$id=  $this->request->uri->getSegment(3);
		$tmpid = $this->session->get('profile_id');
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
		
	    $annathanam = $this->db->table('annathanam_new')
							->select('annathanam_new.*, annathanam_packages.name_eng, annathanam_packages.name_tamil, annathanam_packages.amount')
							->join('annathanam_packages', 'annathanam_packages.id = annathanam_new.package_id', 'left')
							->where('annathanam_new.id', $id)->get()->getRowArray();
							
		$data['special_items'] = $this->db->table('annathanam_booked_special')
									->select('annathanam_special_items.*, annathanam_booked_special.quantity')
									->join('annathanam_special_items', 'annathanam_booked_special.item_id = annathanam_special_items.id')
									->where('annathanam_booked_special.annathanam_id', $id)->get()->getResultArray();

		$data['data'] = $annathanam;
		$data['addon_items'] = $this->db->table('annathanam_booked_addon')
											->select('annathanam_items.*, annathanam_booked_addon.quantity')
											->join('annathanam_items', 'annathanam_booked_addon.item_id = annathanam_items.id')
											->where('annathanam_booked_addon.annathanam_id', $id)->get()->getResultArray();

		$data['additional'] = $this->db->table('annathanam_booked_additional')->where('annathanam_id', $id)->get()->getResultArray();
		$setting = $this->db->table('settings')->where('type', 10)->where('setting_name', 'enable_terms')->get()->getRowArray();
		if ($setting['setting_value'] == 1) {
			$terms_res = $this->db->table("terms_conditions")->get()->getRowArray();
			$terms = json_decode($terms_res['catering'], true);
			$data['terms'] = $terms;
		}

		echo view('catering/print_page',$data);
	}

	public function gtpaymentdata() {
		$id = $_POST['id'];
		$res = $this->db->table("annathanam_new")->where("id", $id)->get()->getRowArray();
		//$amt = $res['amount'] + $res['commision'];
		$amt = $res['total_amount'];
		$data['amt'] = $amt;
		$res1 = $this->db->table("annathanam_booked_pay_details")->selectSum('amount')->where("annathanam_id", $id)->get()->getRowArray();
		$paid_amount = $res1['amount'];
		$data['paid_amount'] = $paid_amount;
		$data['bal_amount'] = $amt - $paid_amount;

		echo json_encode($data);
	}

	public function save_repayment() {
		if(!empty($_POST['payment_mode']) && !empty($_POST['pay_amount'])&& !empty($_POST['booking_id'])){
			$date = $_POST['date'];
			$pay_amount = $_POST['pay_amount'];
			$payment_mode = $_POST['payment_mode'];
			$booking_id = $_POST['booking_id'];
			$count = $this->db->table("payment_mode")->where('id', $payment_mode)->get()->getNumRows();
			if($count > 0){
				$payment_mode_details = $this->db->table("payment_mode")->where('id', $payment_mode)->get()->getRowArray();
				$annathanam_details = $this->db->table("annathanam_new")->where('id', $booking_id)->get()->getRowArray();
				if($annathanam_details['total_amount'] >= ($annathanam_details['paid_amount'] + $pay_amount)){
					$booking_payment_ins_data = array();
					$booking_payment_ins_data['annathanam_id'] = $booking_id;
					$booking_payment_ins_data['is_repayment'] = 1;
					$booking_payment_ins_data['booking_ref_no'] = $annathanam_details['ref_no'];
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
					$res = $this->db->table("annathanam_booked_pay_details")->insert($booking_payment_ins_data);
					$booked_pay_id = $this->db->insertID();
					if ($res) {
						$this->db->query("UPDATE annathanam_new SET paid_amount = paid_amount + ? WHERE id = ?", [$pay_amount, $booking_id]);
						$query = $this->db->table('annathanam_new')->where('id', $booking_id)->get()->getRowArray();
						if ($query['total_amount'] == $query['paid_amount']) {
							$this->db->query("UPDATE annathanam_new SET payment_status = 2 WHERE id = ?", [$booking_id]);
						}
						$this->partial_account_migration($booked_pay_id);
						echo json_encode(['status' => true, 'message' => 'Repayment saved successfully.']);
					}
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
		$booked_pay_details_cnt = $this->db->table("annathanam_booked_pay_details")->where("id", $booked_pay_id)->get()->getNumRows();	
		if ($booked_pay_details_cnt > 0) {
			$booked_pay_details = $this->db->table("annathanam_booked_pay_details")->where("id", $booked_pay_id)->get()->getResultArray();
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
			$booking_id = $booked_pay_details[0]['annathanam_id'];
			$annathanam_new = $this->db->table("annathanam_new")->where("id", $booking_id)->get()->getRowArray();
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

					$entries['entry_code'] = 'REC' . date('y', strtotime($row['paid_date'])) . $mon . (sprintf("%05d", (((float) substr($qry['entry_code'], -5)) + 1)));
					$entries['entrytype_id'] = '1';
					$entries['number'] = $num;
					$entries['date'] = $row['paid_date'];
					$entries['dr_total'] = $row['amount'];
					$entries['cr_total'] = $row['amount'];
					$entries['narration'] = 'Catering Repayment(' . $annathanam_new['ref_no'] . ')' . "\n" . 'name:' . $annathanam_new['name'] . "\n" . 'NRIC:' . $annathanam_new['ic_number'] . "\n" . 'email:' . $annathanam_new['email'] . "\n";
					$entries['inv_id'] = $booking_id;
					$entries['type'] = 14;
					//Insert Entries
					$ent = $this->db->table('entries')->insert($entries);
					$en_id = $this->db->insertID();
					if (!empty($en_id)) {
						// Trade Debtors => Credit
						$eitems_hall_book['entry_id'] = $en_id;
						$eitems_hall_book['ledger_id'] = $cr_id1;
						$eitems_hall_book['amount'] = $row['amount'];
						$eitems_hall_book['dc'] = 'C';
						$eitems_hall_book['details'] = 'Catering Repayment(' . $annathanam_new['ref_no'] . ')';
						$this->db->table('entryitems')->insert($eitems_hall_book);
						// PETTY CASH => Debit 
						$eitems_cash_led['entry_id'] = $en_id;
						$eitems_cash_led['ledger_id'] = $paymentmode['ledger_id'];
						$eitems_cash_led['amount'] = $row['amount'];
						$eitems_cash_led['dc'] = 'D';
						$eitems_cash_led['details'] = 'Catering Repayment(' . $annathanam_new['ref_no'] . ')';
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

	public function account_migration($ins_id) {
    	$yr = date('Y');
    	$mon = date('m');
		$data = $this->db->table('annathanam_new')->where('id', $ins_id)->get()->getRowArray();
		$payment_mode_details = $this->db->table('payment_mode')->where('id', $data['payment_mode'])->get()->getRowArray();
		$booking_settings = $this->db->table('settings')->get()->getResultArray();
		$setting = array();
		if (count($booking_settings) > 0) {
			foreach ($booking_settings as $bs) {
				$setting[$bs['setting_name']] = $bs['setting_value'];
			}
		}

		$incomes_group = $this->db->table('groups')->where('code', '8000')->get()->getRowArray();
		if (!empty($incomes_group)) {
			$sls_id = $incomes_group['id'];
		} else {
			$sls1['parent_id'] = 0;
			$sls1['name'] = 'Incomes';
			$sls1['code'] = '8000';
			$sls1['added_by'] = $this->session->get('log_id');
			$this->db->table('groups')->insert($sls1);
			$sls_id = $this->db->insertID();
		}
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

		$number1 = $this->db->table('entries')->select('number')->where('entrytype_id', 4)->orderBy('id', 'desc')->get()->getRowArray();
		if (empty($number1))
			$num1 = 1;
		else
			$num1 = $number1['number'] + 1;

		$qry1 = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='" . $yr . "' and entrytype_id =4 and month (date)='" . $mon . "')")->getRowArray();
		$entries1['entry_code'] = 'JOR' . date('y', strtotime($data['date'])) . $mon . (sprintf("%05d", (((float) substr($qry1['entry_code'], -5)) + 1)));
		$entries1['entrytype_id'] = '4';
		$entries1['number'] = $num1;
		$entries1['date'] = date("Y-m-d", strtotime($data['date']));
		$entries1['dr_total'] = $data['sub_total'];
		$entries1['cr_total'] = $data['sub_total'];
		$entries1['narration'] = 'Catering(' . $data['ref_no'] . ')' . "\n" . 'name:' . $data['name'] . "\n" . 'NRIC:' . "\n" . 'email:' . $data['email'] . "\n";
		$entries1['inv_id'] = $ins_id;
		$entries1['type'] = 14;
		$ent = $this->db->table('entries')->insert($entries1);
		$en_id1 = $this->db->insertID();

		$debtor_amount = 0;
		if($data['is_special'] == 1){
			$booked_special_cnt = $this->db->table("annathanam_booked_special")->where("annathanam_id", $ins_id)->get()->getNumRows();
			if($booked_special_cnt > 0){
				$booked_special_details = $this->db->table("annathanam_booked_special")->join('annathanam_special_items', 'annathanam_special_items.id = annathanam_booked_special.item_id')->select('annathanam_special_items.*, annathanam_booked_special.quantity')->where("annathanam_booked_special.annathanam_id", $ins_id)->get()->getResultArray();

				foreach($booked_special_details as $row){
					if(!empty($row['ledger_id'])){
						$dr_id = $row['ledger_id'];
					}else{
						$ledger1 = $this->db->table('ledgers')->where('name', 'All Incomes')->where('group_id', $sls_id)->get()->getRowArray();
						if(!empty($ledger1)){
							$dr_id = $ledger1['id'];
						}else{
							$right_code = $this->db->table('ledgers')->select('right_code')->where('group_id', $sls_id)->where('left_code', '8913')->orderBy('right_code','desc')->get()->getRowArray();
							$set_right_code = (int) $right_code['right_code'] + 1;
							$set_right_code = sprintf("%04d", $set_right_code);
							$led1['group_id'] = $sls_id;
							$led1['name'] = 'All Incomes';
							$led1['left_code'] = '8913';
							$led1['right_code'] = $set_right_code;
							$led1['op_balance'] = '0';
							$led1['op_balance_dc'] = 'D';
							$led_ins1 = $this->db->table('ledgers')->insert($led1);
							$dr_id = $this->db->insertID();
						}
					}
					$amount = (float) $row['amount'] * $row['quantity'];

					// Debit the Product's Ledger (dr_id)
					$eitems_d['entry_id'] = $en_id1;
					$eitems_d['ledger_id'] = $dr_id;
					$eitems_d['amount'] = $amount;
					$eitems_d['details'] = $row['name_eng'] . '(' . $data['ref_no'] . ')';
					$eitems_d['dc'] = 'C';
					$cr_res = $this->db->table('entryitems')->insert($eitems_d);
					$debtor_amount += $amount;
				}
			}
		}

		$booked_addon_cnt = $this->db->table("annathanam_booked_addon")->where("annathanam_id", $ins_id)->get()->getNumRows();
		if($booked_addon_cnt > 0){
			$booked_addon_details = $this->db->table("annathanam_booked_addon")->join('annathanam_items', 'annathanam_items.id = annathanam_booked_addon.item_id')->select('annathanam_items.*, annathanam_booked_addon.quantity')->where("annathanam_booked_addon.annathanam_id", $ins_id)->where('annathanam_items.add_on', 1)->get()->getResultArray();

			foreach($booked_addon_details as $row){
				if(!empty($row['ledger_id'])){
					$dr_id = $row['ledger_id'];
				}else{
					$ledger1 = $this->db->table('ledgers')->where('name', 'All Incomes')->where('group_id', $sls_id)->get()->getRowArray();
					if(!empty($ledger1)){
						$dr_id = $ledger1['id'];
					}else{
						$right_code = $this->db->table('ledgers')->select('right_code')->where('group_id', $sls_id)->where('left_code', '8913')->orderBy('right_code','desc')->get()->getRowArray();
						$set_right_code = (int) $right_code['right_code'] + 1;
						$set_right_code = sprintf("%04d", $set_right_code);
						$led1['group_id'] = $sls_id;
						$led1['name'] = 'All Incomes';
						$led1['left_code'] = '8913';
						$led1['right_code'] = $set_right_code;
						$led1['op_balance'] = '0';
						$led1['op_balance_dc'] = 'D';
						$led_ins1 = $this->db->table('ledgers')->insert($led1);
						$dr_id = $this->db->insertID();
					}
				}
				$amount = (float) $row['amount'] * $row['quantity'];

				// Debit the Product's Ledger (dr_id)
				$eitems_d['entry_id'] = $en_id1;
				$eitems_d['ledger_id'] = $dr_id;
				$eitems_d['amount'] = $amount;
				$eitems_d['details'] = $row['name_eng'] . '(' . $data['ref_no'] . ')';
				$eitems_d['dc'] = 'C';
				$cr_res = $this->db->table('entryitems')->insert($eitems_d);
				$debtor_amount += $amount;

			}
		}

		if($booked_additional_cnt > 0){
			$booked_additional_details = $this->db->table("annathanam_booked_additional")->where("annathanam_id", $ins_id)->get()->getResultArray();
			$additional = $this->db->table("annathanam_items")->where("add_on", 2)->get()->getRowArray();
			foreach($booked_additional_details as $row){
				if(!empty($additional['ledger_id'])){
					$dr_id = $additional['ledger_id'];
				}else{
					$ledger1 = $this->db->table('ledgers')->where('name', 'All Incomes')->where('group_id', $sls_id)->get()->getRowArray();
					if(!empty($ledger1)){
						$dr_id = $ledger1['id'];
					}else{
						$right_code = $this->db->table('ledgers')->select('right_code')->where('group_id', $sls_id)->where('left_code', '8913')->orderBy('right_code','desc')->get()->getRowArray();
						$set_right_code = (int) $right_code['right_code'] + 1;
						$set_right_code = sprintf("%04d", $set_right_code);
						$led1['group_id'] = $sls_id;
						$led1['name'] = 'All Incomes';
						$led1['left_code'] = '8913';
						$led1['right_code'] = $set_right_code;
						$led1['op_balance'] = '0';
						$led1['op_balance_dc'] = 'D';
						$led_ins1 = $this->db->table('ledgers')->insert($led1);
						$dr_id = $this->db->insertID();
					}
				}
				$amount = (float) $row['amount'] * $row['quantity'];

				// Debit the Product's Ledger (dr_id)
				$eitems_d['entry_id'] = $en_id1;
				$eitems_d['ledger_id'] = $dr_id;
				$eitems_d['amount'] = $amount;
				$eitems_d['details'] = $row['name'] . '(' . $data['ref_no'] . ')';
				$eitems_d['dc'] = 'C';
				$cr_res = $this->db->table('entryitems')->insert($eitems_d);
				$debtor_amount += $amount;

			}
		}

		$eitems_c['entry_id'] = $en_id1;
		$eitems_c['ledger_id'] = $cr_id1;
		$eitems_c['amount'] = $debtor_amount;
		$eitems_c['details'] = 'Catering Amount';
		$eitems_c['dc'] = 'D';
		$deb_res = $this->db->table('entryitems')->insert($eitems_c);

		$data['discount_amount'] = !empty($data['discount_amount']) ? (float) $data['discount_amount'] : 0;
		if (!empty($data['discount_amount'])) {
			$number = $this->db->table('entries')->select('number')->where('entrytype_id', 4)->orderBy('id', 'desc')->get()->getRowArray();
			if (empty($number) && empty($number1))
			  $num = 1;
			else
			  $num = $number['number'] + 1;
	  
			$qry = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='" . $yr . "' and entrytype_id =4 and month (date)='" . $mon . "')")->getRowArray();
			$entries['entry_code'] = 'JOR' . date('y', strtotime($data['date'])) . $mon . (sprintf("%05d", (((float) substr($qry['entry_code'], -5)) + 1)));
			$entries['date'] = date("Y-m-d", strtotime($data['date']));
			$entries['number'] = $num;
			$entries['entrytype_id'] = '4';
			$entries['dr_total'] = $data['discount_amount']; // Assuming 'total_amount' is the field for total booking amount
			$entries['cr_total'] = $data['discount_amount'];
			$entries['narration'] = 'Catering Discount(' . $data['ref_no'] . ')' . "\n" . 'name:' . $data['name'] . "\n" . 'NRIC:' . "\n" . 'email:' . $data['email'] . "\n";
			$entries['inv_id'] = $ins_id;
			$entries['type'] = '14';
			$ent = $this->db->table('entries')->insert($entries);
			$en_id2 = $this->db->insertID();
	  
			$eitems_c = array();
			$eitems_c['entry_id'] = $en_id2;
			$eitems_c['ledger_id'] = $cr_id1;
			$eitems_c['amount'] = $data['discount_amount'];
			$eitems_c['details'] = 'Discount for Catering(' . $data['ref_no'] . ')';
			$eitems_c['dc'] = 'C';
			$deb_res = $this->db->table('entryitems')->insert($eitems_c);
	  
			$eitems_disc_ent = array();
			$discount_ledger_id = !empty($setting['discount_catering_ledger_id']) ? $setting['discount_catering_ledger_id'] : 43;
			$eitems_disc_ent['entry_id'] = $en_id2;
			$eitems_disc_ent['ledger_id'] = $discount_ledger_id;
			$eitems_disc_ent['amount'] = $data['discount_amount'];
			$eitems_disc_ent['is_discount'] = 1;
			$eitems_disc_ent['dc'] = 'D';
			$eitems_disc_ent['details'] = 'Discount for Catering(' . $data['ref_no'] . ')';
			$this->db->table('entryitems')->insert($eitems_disc_ent);
			$debtor_amount -= $data['discount_amount'];
		}


		$booked_pay_cnt = $this->db->table("annathanam_booked_pay_details")->where("annathanam_id", $ins_id)->get()->getNumRows();
		if($booked_pay_cnt > 0){
			$booked_pay_details = $this->db->table("annathanam_booked_pay_details")->where("annathanam_id", $ins_id)->get()->getResultArray();

			foreach ($booked_pay_details as $row) {
				$paymentmode = $this->db->table('payment_mode')->where('id', $row['payment_mode_id'])->get()->getRowArray();
				
				$number = $this->db->table('entries')->select('number')->where('entrytype_id', 1)->orderBy('id', 'desc')->get()->getRowArray();
				if (empty($number))
					$num = 1;
				else
					$num = $number['number'] + 1;
				// Get Entry Code
				$qry = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='" . $yr . "' and entrytype_id =1 and month (date)='" . $mon . "')")->getRowArray();

				$entries['entry_code'] = 'REC' . date('y', strtotime($row['paid_date'])) . $mon . (sprintf("%05d", (((float) substr($qry['entry_code'], -5)) + 1)));
				$entries['entrytype_id'] = '1';
				$entries['number'] = $num;
				$entries['date'] = $row['paid_date'];
				$entries['dr_total'] = $row['amount'];
				$entries['cr_total'] = $row['amount'];
				$entries['narration'] = 'Catering Payment(' . $data['ref_no'] . ')' . "\n" . 'name:' . $data['name'] . "\n" . 'NRIC:' . $data['ic_no'] . "\n" . 'email:' . $data['email_id'] . "\n";
				$entries['inv_id'] = $ins_id;
				$entries['type'] = 14;
				//Insert Entries
				$ent = $this->db->table('entries')->insert($entries);
				$en_id = $this->db->insertID();
				if (!empty($en_id)) {
					// Trade Debtors => Credit
					$eitems_hall_book['entry_id'] = $en_id;
					$eitems_hall_book['ledger_id'] = $cr_id1;
					$eitems_hall_book['amount'] = $row['amount'];
					$eitems_hall_book['dc'] = 'C';
					$eitems_hall_book['details'] = 'Catering Payment';
					$this->db->table('entryitems')->insert($eitems_hall_book);
					// PETTY CASH => Debit 
					$eitems_cash_led['entry_id'] = $en_id;
					$eitems_cash_led['ledger_id'] = $paymentmode['ledger_id'];
					$eitems_cash_led['amount'] = $row['amount'];
					$eitems_cash_led['dc'] = 'D';
					$eitems_cash_led['details'] = 'Catering Payment';
					$this->db->table('entryitems')->insert($eitems_cash_led);
				}
			}
		}
	}

	public function update_booking_status() {
		$id = $_POST['id'];
		$status = $_POST['status'];
		$data = ['booking_status' => $status];
		$res = $this->db->table('annathanam_new')->where('id', $id)->update($data);
	
		if($res){
			echo json_encode(['success' => true, 'message' => 'Booking Cancelled Successfully.']);
		} else {
			echo json_encode(['success' => false, 'message' => 'Failed to Cancel the Booking.']);
		}
	}

	
	
}
