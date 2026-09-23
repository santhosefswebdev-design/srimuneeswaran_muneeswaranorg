<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PermissionModel;
use App\Models\RequestModel;

class Outdoor_online extends BaseController
{
    function __construct(){
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
		$login_id = $_SESSION['log_id_frend'];
		$data['phone_codes'] = $this->db->table("phone_code")->orderBy('dailing_code', 'ASC')->get()->getResultArray();
		$login_id = $_SESSION['log_id_frend'];
		$data['products'] = $this->db->table("temple_packages")->select('id, name, amount, image')->where('package_type', 4)->where('status', 1)->get()->getResultArray();
        $data['reprintlists'] = $this->db->query("SELECT id,customer_name,amount,name,date FROM prasadam WHERE paid_through = 'COUNTER' AND payment_status = 2 ORDER BY id DESC LIMIT 3")->getResultArray();
        $data['payment_mode'] = $this->db->table('payment_mode')->where("paid_through", "COUNTER")->where("outdoor", 1)->where('status', 1)->orderby('menu_order', "ASC")->get()->getResultArray();
		$query = $this->db->query("SELECT outdoor FROM terms_conditions ");
		$result = $query->getRowArray();
		$data['terms'] = json_decode($result['outdoor'], true);
		$settings = $this->db->table('settings')->where('type', 8)->get()->getResultArray();
		$setting_array = array();
		if(count($settings) > 0){
			foreach ($settings as $item) {
				$setting_array[$item['setting_name']] = $item['setting_value'];
			}
		}
		$data['setting'] = $setting_array;

		echo view('frontend/layout/header');
		echo view('frontend/outdoor_servics/index', $data);		
	}

	public function fetch_package_settings()
	{
		$package_id = $_POST['package_id'];
		$package_settings = $this->db->query("
			SELECT ts.*, tps.quantity
			FROM temple_services ts
			JOIN temple_package_services tps ON ts.id = tps.service_id
			WHERE tps.package_id = ?", [$package_id])->getResultArray();

		return $this->response->setJSON($package_settings);
	}

	public function fetch_outdoor_services()
	{
		$package_id = $_POST['product_id'];
		$service_settings = $this->db->table("temple_package_addons")->join('temple_services', 'temple_package_addons.service_id = temple_services.id')->select('temple_package_addons.*, temple_services.name')->where("temple_package_addons.package_id", $package_id)->get()->getResultArray();

		return $this->response->setJSON($service_settings);
	}

	public function get_service_list_addon()
	{
		$addon_id = $_POST['id'];
		$package_id = $_POST['package_id'];
		$get_result_details = $this->db->table("temple_services")->join('temple_package_addons', 'temple_package_addons.service_id = temple_services.id')->select('temple_services.*, temple_package_addons.quantity')->where("temple_package_addons.package_id", $package_id)->where("temple_package_addons.id", $addon_id)->get()->getResultArray();
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

	public function get_terms() {

		$id = $_POST['id'];
		$terms_res = $this->db->table("terms_conditions")->get()->getRowArray();
		$terms = json_decode($terms_res['outdoor'], true); 

		$data['terms'] = isset($terms[$id]) ? $terms[$id] : [];
		echo json_encode($data);
	}

  	public function show_product()
	{
		$prasadam_settings = $this->db->query("SELECT * FROM prasadam_setting WHERE name_eng LIKE '%" . $_POST['prod'] . "%' order by name_eng asc")->getResultArray();
		foreach ($prasadam_settings as $key => $value) {
			if (!empty ($value)) {
				foreach ($value as $row) {
					$tr_row[] .= '<div class="col-md-3" style="padding-left: 0px;">
									<div class="prod" id="prod' . $row['id'] . '" data-id="prod' . $row['id'] . '" onclick="addtocart(' . $row['id'] . ')"><img src="' . base_url() . '/uploads/package/' . $row['image'] . '" width="200" height="80" alt="image" />
										<!--<div class="vl"></div>-->
										<div class="detail">
										<h5 id="nm_' . $row['id'] . '" data-id="' . $row['id'] . '"> ' . $row['name_tamil'] . ' <br>' . $row['name_eng'] . '</h5><h4 id="amt_' . $row['id'] . '" data-id="' . ($row['amount']) . '" >RM ' . number_format((float) ($row['amount']), 2) . '</h4>
										</div>
									</div>
								</div>';
				}
			}
		}

		$data['row'] = $tr_row;
		echo json_encode($data);
	}
	public function save()
	{
		// NO VALIDATION REQUIRED - Can save with package only or package + addons
		if (!empty($_POST['package_id'])) {
			$msg_data = array();
			$msg_data['err'] = '';
			$msg_data['succ'] = '';

			try {
				$date = $_POST['date'];
				$tot_amt = $_POST['tot_amt'];
				$data['dob'] = $_POST['dob'];
				$data['package_id'] = $package_id = $_POST['package_id'];
				$data['payment_type'] = !empty($_POST['payment_type']) ? $_POST['payment_type'] : 'full';

				$yr = date('Y');
				$mon = date('m');
				$query = $this->db->query("SELECT ref_no FROM outdoor_booking where id=(select max(id) from outdoor_booking where year (date)='" . $yr . "' and month (date)='" . $mon . "')")->getRowArray();
				$data['ref_no'] = 'OS' . date('y', strtotime($_POST['date'])) . $mon . (sprintf("%05d", (((float) substr($query['ref_no'], -5)) + 1)));
				$data['date'] = date('Y-m-d', strtotime($_POST['date']));
				$data['name'] = $_POST['name'];
				$mble_phonecode = !empty($_POST['phonecode']) ? $_POST['phonecode'] : "";
				$mble_number = !empty($_POST['mobile']) ? $_POST['mobile'] : "";
				$data['mobile_no'] = $mble_phonecode . $mble_number;
				$data['email_id'] = $_POST['email_id'];
				$data['amount'] = $_POST['tot_amt'];
				$data['address'] = $_POST['address'];
				$data['event_date'] = $_POST['collection_date'];
				$data['start_time'] = $_POST['s_time'];
				$data['desciption'] = $_POST['description'];
				$data['added_by'] = $this->session->get('profile_id_frend');
				$data['created_at'] = date('Y-m-d H:i:s');
				$data['updated_at'] = date('Y-m-d H:i:s');
				$data['paid_amount'] = $_POST['paid_amount'];
				$data['sep_print'] = (!empty($_REQUEST['sep_print']) ? $_REQUEST['sep_print'] : 0);
				$data['paid_through'] = "COUNTER";

				// FIX: Set booking_status
				$data['booking_status'] = 1; // 1 = Booked

				$data['payment_mode'] = $pay_id = $_POST['pay_method'];
				$payment_mode = $this->db->table('payment_mode')->where("id", $pay_id)->get()->getRowArray();
				$pay_method = $payment_mode['name'];
				$data['payment_status'] = !empty($pay_method) ? 2 : 1;

				$res = $this->db->table('outdoor_booking')->insert($data);
				$ins_id = $this->db->insertID();

				if ($res) {
					// Insert Package
					if (!empty($package_id)) {
						$packages = $this->db->table("temple_packages")->where('id', $package_id)->get()->getRowArray();
						$data_prdm_book1['booking_id'] = $ins_id;
						$data_prdm_book1['package_id'] = $packages['id'];
						$data_prdm_book1['ledger_id'] = $packages['ledger_id'];
						$data_prdm_book1['name'] = $packages['name'];
						$data_prdm_book1['amount'] = $packages['amount'];
						$res_4 = $this->db->table('outdoor_booked_packages')->insert($data_prdm_book1);
					}

					// FIX: Initialize $res_2 as true by default
					$res_2 = true;

					// Insert Add-ons (if any)
					if (!empty($_POST['add_on'])) {
						foreach ($_POST['add_on'] as $row) {
							$services = $this->db->table("temple_services")->where('id', $row['id'])->get()->getRowArray();
							$data_prdm_book['booking_id'] = $ins_id;
							$data_prdm_book['service_id'] = $row['id'];
							$data_prdm_book['ledger_id'] = $services['ledger_id'];
							$data_prdm_book['quantity'] = $row['quantity'];
							$data_prdm_book['amount'] = $row['amount'];
							$res_2 = $this->db->table('outdoor_booked_addon')->insert($data_prdm_book);

							// If any add-on insertion fails, break
							if (!$res_2)
								break;
						}
					}

					// Insert payment details (now works with or without add-ons)
					if ($res_2) {
						$pay_details = array();
						$payment_mode_details = $this->db->table("payment_mode")->where('id', $pay_id)->get()->getRowArray();
						$pay_details['booking_id'] = $ins_id;
						$pay_details['payment_mode_id'] = $pay_id;
						$pay_details['paid_through'] = 'COUNTER';
						$pay_details['pay_status'] = 2;
						$pay_details['payment_mode_title'] = $payment_mode_details['name'];
						$pay_details['booking_ref_no'] = $data['ref_no'];
						if ($data['payment_type'] == 'partial')
							$pay_details['amount'] = $_POST['paid_amount'];
						else
							$pay_details['amount'] = $tot_amt;

						if (empty($pay_details['amount'])) {
							$msg_data['err'] = 'Invalid Amount';
							echo json_encode($msg_data);
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

						$res_3 = $this->db->table('outdoor_pay_details')->insert($pay_details);

						// Update booking with paid amount and payment status
						$booking_ref_data = array();
						$booking_ref_data['paid_amount'] = $pay_details['amount'];
						$booking_ref_data['booking_status'] = 1;
						if ($data['payment_type'] == 'partial')
							$booking_ref_data['payment_status'] = 1;
						else
							$booking_ref_data['payment_status'] = 2;
						$this->db->table("outdoor_booking")->where('id', $ins_id)->update($booking_ref_data);
					}

					// Account migration
					$this->account_migration($ins_id);

					if ($res_3) {
						$msg_data['succ'] = 'Outdoor Services Booked Successfully';
						$msg_data['id'] = $ins_id;
					} else {
						$msg_data['err'] = 'Payment details insertion failed';
					}
				} else {
					$msg_data['err'] = 'Booking insertion failed';
				}

			} catch (Exception $e) {
				$msg_data['err'] = $e->getMessage();
			}
		} else {
			$msg_data['err'] = 'Please select a service package';
		}
		echo json_encode($msg_data);
		exit();
	}
	// public function save()
	// {
    // // echo '<pre>';
    // // print_r($_POST);
    // // echo '</pre>';
    // // exit;
	// 	if(!empty($_POST['services'])){
	// 		$msg_data = array();
	// 		$msg_data['err'] = '';
	// 		$msg_data['succ'] = '';
	// 		//$this->db->transStart();
	// 		try {
	// 			$date = $_POST['date'];
	// 			$tot_amt = $_POST['tot_amt'];
	// 			$data['dob'] = $_POST['dob'];
	// 			$data['package_id'] = $package_id = $_POST['package_id'];
	// 			$data['payment_type'] = !empty($_POST['payment_type']) ? $_POST['payment_type']: 'full';
        
	// 			$yr = date('Y');
	// 			$mon = date('m');
	// 			$query = $this->db->query("SELECT ref_no FROM outdoor_booking where id=(select max(id) from outdoor_booking where year (date)='" . $yr . "' and month (date)='" . $mon . "')")->getRowArray();
	// 			$data['ref_no'] = 'OS' . date('y', strtotime($_POST['date'])) . $mon . (sprintf("%05d", (((float) substr($query['ref_no'], -5)) + 1)));
	// 			$data['date'] = date('Y-m-d', strtotime($_POST['date']));
	// 			$data['name'] = $_POST['name'];
	// 			$mble_phonecode = !empty ($_POST['phonecode']) ? $_POST['phonecode'] : "";
	// 			$mble_number = !empty ($_POST['mobile']) ? $_POST['mobile'] : "";
	// 			$data['mobile_no'] = $mble_phonecode . $mble_number;
	// 			$data['email_id'] = $_POST['email_id'];
	// 			$data['amount'] = $_POST['tot_amt'];
	// 			$data['address'] = $_POST['address'];
	// 			$data['event_date'] = $_POST['collection_date'];
	// 			$data['start_time'] = $_POST['s_time'];
	// 			$data['desciption'] = $_POST['description'];
	// 			$data['added_by'] = $this->session->get('profile_id_frend');
	// 			$data['created_at'] = date('Y-m-d H:i:s');
	// 			$data['updated_at'] = date('Y-m-d H:i:s');
	// 			$data['paid_amount'] = $_POST['paid_amount'];
	// 			$data['sep_print'] = (!empty ($_REQUEST['sep_print']) ? $_REQUEST['sep_print'] : 0);
	// 			$data['paid_through'] = "COUNTER";
	// 			// $pay_method = (!empty ($_POST['pay_method']) ? $_POST['pay_method'] : 'cash');
	// 			// $query = "SELECT id FROM payment_mode WHERE 
	// 			// 		LOWER(REPLACE(REPLACE(REPLACE(name, ' ', ''), '_', ''), '-', '')) = 
	// 			// 		LOWER(REPLACE(REPLACE(REPLACE(?, ' ', ''), '_', ''), '-', '')) 
	// 			// 		AND paid_through = 'COUNTER' ";
	// 			// $result = $this->db->query($query, [$pay_method])->getRowArray();
	// 			// $payment_mode = $result['id'];
	// 			// $data['payment_mode'] = $payment_mode;
	// 			// $data['payment_status'] = (($pay_method == 'cash' || $pay_method == 'online'  || $pay_method == 'qr' || $pay_method == 'nets_pay') ? 2 : 1);
	// 			$data['payment_mode'] = $pay_id = $_POST['pay_method'];
	// 			$payment_mode = $this->db->table('payment_mode')->where("id", $pay_id)->get()->getRowArray();
	// 			$pay_method = $payment_mode['name'];
	// 			$data['payment_status'] = !empty($pay_method) ? 2 : 1;
	// 			$res = $this->db->table('outdoor_booking')->insert($data);
	// 			$ins_id = $this->db->insertID();

	// 			if ($res) {
	// 				if (!empty ($package_id)) {
	// 					$packages = $this->db->table("temple_packages")->where('id', $package_id)->get()->getRowArray();
	// 					$data_prdm_book1['booking_id'] = $ins_id;
	// 					$data_prdm_book1['package_id'] = $packages['id'];
	// 					$data_prdm_book1['ledger_id'] = $packages['ledger_id'];
	// 					$data_prdm_book1['name'] = $packages['name'];
	// 					$data_prdm_book1['amount'] = $packages['amount'];
	// 					$res_4 = $this->db->table('outdoor_booked_packages')->insert($data_prdm_book1);
	// 				}

	// 				if (!empty ($_POST['add_on'])) {
	// 					foreach ($_POST['add_on'] as $row) {
	// 						$services = $this->db->table("temple_services")->where('id', $row['id'])->get()->getRowArray();
	// 						$data_prdm_book['booking_id'] = $ins_id;
	// 						$data_prdm_book['service_id'] = $row['id'];
	// 						$data_prdm_book['ledger_id'] = $services['ledger_id'];
	// 						$data_prdm_book['quantity'] = $row['quantity'];
	// 						$data_prdm_book['amount'] = $row['amount'];
	// 						$res_2 = $this->db->table('outdoor_booked_addon')->insert($data_prdm_book);
	// 					}
	// 				}
	// 				if($res_2){
	// 					$pay_details = array();
	// 					$payment_mode_details = $this->db->table("payment_mode")->where('id', $pay_id)->get()->getRowArray();
	// 					$pay_details['booking_id'] = $ins_id;
	// 					$pay_details['payment_mode_id'] = $pay_id;
	// 					$pay_details['paid_through'] = 'COUNTER';
	// 					$pay_details['pay_status'] = 2;
	// 					$pay_details['payment_mode_title'] = $payment_mode_details['name'];
	// 					$pay_details['booking_ref_no'] = $data['ref_no'];
	// 					if($data['payment_type'] == 'partial') $pay_details['amount'] = $_POST['paid_amount'];
	// 					else $pay_details['amount'] = $tot_amt;

	// 					if(empty($pay_details['amount'])){
	// 					$this->db->transRollback();
	// 					$msg_data['err'] = 'Invalid Amount';
	// 					exit;
	// 					}
	// 					$pay_details['paid_date'] = date('Y-m-d');
	// 					$this->requestmodel = new RequestModel();
	// 					$ip = $this->requestmodel->getIpAddress();
	// 					$pay_details['ip'] = $ip;
	// 					if ($ip != 'unknown') {
	// 					$ip_details = $this->requestmodel->getLocation($ip);
	// 					$pay_details['ip_location'] = (!empty($ip_details['country']) ? $ip_details['country'] : 'Unknown');
	// 					$pay_details['ip_details'] = json_encode($ip_details);
	// 					}
				
	// 					$res_3 = $this->db->table('outdoor_pay_details')->insert($pay_details);
	// 					$booking_ref_data = array();
	// 					$booking_ref_data['paid_amount'] = $pay_details['amount'];
	// 					$booking_ref_data['booking_status'] = 1;
	// 					if($data['payment_type'] == 'partial') $booking_ref_data['payment_status'] = 1;
	// 									else $booking_ref_data['payment_status'] = 2;
	// 					$this->db->table("outdoor_booking")->where('id', $ins_id)->update($booking_ref_data);

	// 				}
	// 				$this->account_migration($ins_id);
					
	// 				if ($res_3) {
	// 					$msg_data['succ'] = 'Outdoor Services Booked Successfully';
	// 					$msg_data['id'] = $ins_id;
	// 				} else {
	// 					$msg_data['err'] = 'Please Try Again1';
	// 				}
	// 			}
						
	// 		//$this->db->transComplete();
	// 		}catch (Exception $e) {
	// 			$this->db->transRollback();
	// 			$msg_data['err'] = $e->getMessage();
	// 		}
	// 	}else {
	// 		$this->session->setFlashdata('fail', 'Please Try Again2');
	// 		$msg_data['err'] = 'Please Try Again, not got to the function';
	// 	}
	// 	echo json_encode($msg_data);
	// 	exit();
	// }

	public function gtpaymentdata()
	{
		$id = $_POST['id'];
		$data['id'] = $id;
		$res = $this->db->table("outdoor_booking")->where("id", $id)->get()->getRowArray();
		$amt = $res['amount'];
		$data['amt'] = $amt;
		$res1 = $this->db->table("outdoor_pay_details")->selectSum('amount')->where("booking_id", $id)->get()->getRowArray();
		$paid_amount = $res1['amount'];
		$data['paid_amount'] = $paid_amount;
		$data['bal_amount'] = $amt - $paid_amount;

		echo json_encode($data);
	}

	public function print_page()
	{
		$id = $this->request->uri->getSegment(3);

		$data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
		$data['data'] = $this->db->table("outdoor_booking")->where("id", $id)->get()->getRowArray();
		$data['packages'] = $this->db->table("outdoor_booking")
				->select('temple_packages.*')
				->join('temple_packages', 'temple_packages.id = outdoor_booking.package_id', 'inner')
				->where("outdoor_booking.id", $id)->get()->getResultArray();

		$data['services'] = $this->db->table("outdoor_booking")
				->select('temple_services.*, temple_package_services.quantity')
				->join('temple_package_services', 'temple_package_services.package_id = outdoor_booking.package_id', 'inner')
				->join('temple_services', 'temple_services.id = temple_package_services.service_id', 'inner')
				->where("outdoor_booking.id", $id)->get()->getResultArray();

		$data['addons'] = $this->db->table("outdoor_booked_addon")
				->select('temple_services.*, outdoor_booked_addon.quantity')
				->join('temple_services', 'temple_services.id = outdoor_booked_addon.service_id', 'inner')
				->where("outdoor_booked_addon.booking_id", $id)->get()->getResultArray();

		echo view('frontend/outdoor_servics/print_page', $data);
	}

	public function account_migration($booking_id){
		$succ = true;
		$templeubayam = $this->db->table("outdoor_booking")->where("id", $booking_id)->get()->getRowArray();
		$entry_date = date('Y-m-d', strtotime($templeubayam['date']));
		$date = explode('-', $entry_date);
		$yr = $date[0];
		$mon = $date[1];
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
		$incomes_group = $this->db->table('groups')->where('code', '8000')->get()->getRowArray();
		if (!empty($incomes_group)) {
			$sls_id = $incomes_group['id'];
		} else {
			$sls1['parent_id'] = 0;
			$sls1['name'] = 'Incomes';
			$sls1['code'] = '8000';
			$sls1['added_by'] = $this->session->get('log_id');
			$led_ins1 = $this->db->table('groups')->insert($sls1);
			$sls_id = $this->db->insertID();
		}

		$booked_packages_cnt = $this->db->table("outdoor_booked_packages")->where("booking_id", $booking_id)->get()->getNumRows();	
		$booked_addon_cnt = $this->db->table("outdoor_booked_addon")->where("booking_id", $booking_id)->get()->getNumRows();
		if ($booked_packages_cnt > 0) {
			$booked_packages_details = $this->db->table("outdoor_booked_packages")->where("booking_id", $booking_id)->get()->getResultArray();
			$booked_addon_details = $this->db->table("outdoor_booked_addon")->join('temple_services', 'temple_services.id = outdoor_booked_addon.service_id')->select('temple_services.*, outdoor_booked_addon.quantity')->where("outdoor_booked_addon.booking_id", $booking_id)->get()->getResultArray();
			$over_all_tot_amt = 0;
			foreach ($booked_packages_details as $row) $over_all_tot_amt += (float) $row['amount'];
			if($booked_addon_cnt > 0){
				foreach ($booked_addon_details as $row) $over_all_tot_amt += (float) $row['amount'] * (int) $row['quantity'];
			}
			  $number1 = $this->db->table('entries')->select('number')->where('entrytype_id', 4)->orderBy('id', 'desc')->get()->getRowArray();
			  if (empty($number1))
				$num1 = 1;
			  else
				$num1 = $number1['number'] + 1;
			  // Get Entry Code
			  $qry1 = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='" . $yr . "' and entrytype_id =4 and month (date)='" . $mon . "')")->getRowArray();

			  $entries1['entry_code'] = 'JOR' . date('y', strtotime($entry_date)) . $mon . (sprintf("%05d", (((float) substr($qry1['entry_code'], -5)) + 1)));
			  $entries1['entrytype_id'] = '4';
			  $entries1['number'] = $num1;
			  $entries1['date'] = $entry_date;
			  $entries1['dr_total'] = $over_all_tot_amt;
			  $entries1['cr_total'] = $over_all_tot_amt;
			  $entries1['narration'] = 'Outdoor Services(' . $templeubayam['ref_no'] . ')' . "\n" . 'name:' . $templeubayam['name'] . "\n" . 'email:' . $templeubayam['email'] . "\n";
			  $entries1['inv_id'] = $booking_id;
			  $entries1['type'] = 13;
			  //Insert Entries
			  $ent = $this->db->table('entries')->insert($entries1);
			  $en_id1 = $this->db->insertID();
			  if (!empty($en_id1)) {
				foreach ($booked_packages_details as $row) {
					if($row['amount'] != 0){
						if(!empty($row['ledger_id'])){
							$led_book_id = $row['ledger_id'];
						}else{
							$ledger1 = $this->db->table('ledgers')->where('name', 'All Incomes')->where('group_id', $sls_id)->get()->getRowArray();
							if(!empty($ledger1)){
								$led_book_id = $ledger1['id'];
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
								$led_book_id = $this->db->insertID();
							}
						}
						// Hall Booking => Credit
						$eitems_hall_book['entry_id'] = $en_id1;
						$eitems_hall_book['ledger_id'] = $led_book_id;
						$eitems_hall_book['amount'] = $row['amount'];
						$eitems_hall_book['dc'] = 'C';
						$eitems_hall_book['details'] = 'Amount for' . $row['name'];
						$this->db->table('entryitems')->insert($eitems_hall_book);
						//  Trade Debtors => Debit 
						$eitems_cash_led['entry_id'] = $en_id1;
						$eitems_cash_led['ledger_id'] = $cr_id1;
						$eitems_cash_led['amount'] = $row['amount'];
						$eitems_cash_led['dc'] = 'D';
						$eitems_cash_led['details'] = 'Amount for' . $row['name'];
						$this->db->table('entryitems')->insert($eitems_cash_led);
					}
				}
			}else{
				$succ = false;
				return $succ;
			}
		}else{
			$succ = false;
			return $succ;
		}

		if($booked_addon_cnt > 0){
			$booked_addon_details = $this->db->table("outdoor_booked_addon")->join('temple_services', 'temple_services.id = outdoor_booked_addon.service_id')->select('temple_services.*, outdoor_booked_addon.quantity')->where("outdoor_booked_addon.booking_id", $booking_id)->get()->getResultArray();
			foreach ($booked_addon_details as $row) {
				if(!empty($row['ledger_id'])){
					$led_book_id = $row['ledger_id'];
				}else{
					$ledger1 = $this->db->table('ledgers')->where('name', 'All Incomes')->where('group_id', $sls_id)->get()->getRowArray();
					if(!empty($ledger1)){
						$led_book_id = $ledger1['id'];
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
						$led_book_id = $this->db->insertID();
					}
				}
				$amount = (float) $row['amount'] * $row['quantity'];
				// Hall Booking => Credit
				$eitems_hall_book['entry_id'] = $en_id1;
				$eitems_hall_book['ledger_id'] = $led_book_id;
				$eitems_hall_book['amount'] = $amount;
				$eitems_hall_book['dc'] = 'C';
				$eitems_hall_book['details'] = 'Amount for ' . $row['name'];
				$this->db->table('entryitems')->insert($eitems_hall_book);
				$debtor_amount += $amount;
			}
			//  Trade Debtors => Debit 
			$eitems_cash_led['entry_id'] = $en_id1;
			$eitems_cash_led['ledger_id'] = $cr_id1;
			$eitems_cash_led['amount'] = $debtor_amount;
			$eitems_cash_led['dc'] = 'D';
			$eitems_cash_led['details'] = 'Amount for Outdoor Services';
			$this->db->table('entryitems')->insert($eitems_cash_led);
		}
		$booked_pay_details_cnt = $this->db->table("outdoor_pay_details")->where("booking_id", $booking_id)->get()->getNumRows();	
		if ($booked_pay_details_cnt > 0) {
			$booked_pay_details = $this->db->table("outdoor_pay_details")->where("booking_id", $booking_id)->get()->getResultArray();
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
					$entries['narration'] = 'Outdoor Services(' . $templeubayam['ref_no'] . ')' . "\n" . 'name:' . $templeubayam['name'] . "\n" . 'email:' . $templeubayam['email'] . "\n";
					$entries['inv_id'] = $booking_id;
					$entries['type'] = 13;
					//Insert Entries
					$ent = $this->db->table('entries')->insert($entries);
					$en_id = $this->db->insertID();
					if (!empty($en_id)) {
						// Trade Debtors => Credit
						$eitems_hall_book['entry_id'] = $en_id;
						$eitems_hall_book['ledger_id'] = $cr_id1;
						$eitems_hall_book['amount'] = $row['amount'];
						$eitems_hall_book['dc'] = 'C';
						$eitems_hall_book['details'] = 'Outdoor Services Amount';
						$this->db->table('entryitems')->insert($eitems_hall_book);
						// PETTY CASH => Debit 
						$eitems_cash_led['entry_id'] = $en_id;
						$eitems_cash_led['ledger_id'] = $paymentmode['ledger_id'];
						$eitems_cash_led['amount'] = $row['amount'];
						$eitems_cash_led['dc'] = 'D';
						$eitems_cash_led['details'] = 'Outdoor Services Amount';
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
		return $succ;
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
				$ubayam_details = $this->db->table("outdoor_booking")->where('id', $booking_id)->get()->getRowArray();
				if($ubayam_details['amount'] >= ($ubayam_details['paid_amount'] + $pay_amount)){
					$booking_payment_ins_data = array();
					$booking_payment_ins_data['booking_id'] = $booking_id;
					$booking_payment_ins_data['booking_type'] = 2;
					$booking_payment_ins_data['booking_ref_no'] = $ubayam_details['ref_no'];
					$booking_payment_ins_data['payment_mode_id'] = $payment_mode;
					$booking_payment_ins_data['paid_date'] = !empty($date) ? $date : date('Y-m-d');
					$booking_payment_ins_data['amount'] = $pay_amount;
					$booking_payment_ins_data['payment_mode_title'] = $payment_mode_details['name'];
					$paid_through = 'COUNTER';
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
					$res = $this->db->table("outdoor_pay_details")->insert($booking_payment_ins_data);
					$booked_pay_id = $this->db->insertID();
					$this->db->query("UPDATE outdoor_booking SET paid_amount = paid_amount + ? WHERE id = ?", [$pay_amount, $booking_id]);
					$query = $this->db->table('outdoor_booking')->where('id', $booking_id)->get()->getRowArray();
					if ($query['amount'] == $query['paid_amount']) {
						$this->db->query("UPDATE outdoor_booking SET payment_status = 2 WHERE id = ?", [$booking_id]);
					}elseif($query['paid_amount'] > 0 && $query['payment_status'] == 0){
						$this->db->query("UPDATE outdoor_booking SET payment_status = 1 WHERE id = ?", [$booking_id]);
					}
					//$this->partial_account_migration($booked_pay_id);
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
  

}
