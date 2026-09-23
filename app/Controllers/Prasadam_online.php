<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\PermissionModel;
use App\Models\RequestModel;

class Prasadam_online extends BaseController
{
  function __construct()
  {
    parent::__construct();
    helper('url');
    helper('common');
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
    $data['prasadam_settings'] = $this->db->query("SELECT * FROM prasadam_setting WHERE status = 1 order by name_eng asc")->getResultArray();
    // $data['reprintlists'] = $this->db->query("SELECT id,customer_name,amount,name,date FROM prasadam WHERE added_by = '" . $login_id . "' and paid_through = 'COUNTER' AND payment_status != 3 ORDER BY id DESC LIMIT 3")->getResultArray();
    $data['reprintlists'] = $this->db->query("SELECT id,customer_name,amount,name,date FROM prasadam WHERE paid_through = 'COUNTER' AND payment_status != 3 ORDER BY id DESC LIMIT 3")->getResultArray();
    $data['prasadam_groups'] = $this->db->table('prasadam_group')->where('status', 1)->get()->getResultArray();
    $data['payment_mode'] = $this->db->table('payment_mode')->where("paid_through", "COUNTER")->where("prasadam", 1)->where('status', 1)->orderby('menu_order', "ASC")->get()->getResultArray();
    $settings = $this->db->table('settings')->where('type', 3)->get()->getResultArray();
		$setting_array = array();
		if(count($settings) > 0){
			foreach ($settings as $item) {
				$setting_array[$item['setting_name']] = $item['setting_value'];
			}
		}
		$data['setting'] = $setting_array;

    echo view('frontend/layout/header');
    echo view('frontend/prasadam/index', $data);
  }

  public function fetch_prasadam_settings()
	{
		$prasadam_group_id = $_POST['prasadam_group_id'];
		$prasadam_settings = $this->db->query("
			SELECT ps.*,psg.amount as proamt 
			FROM prasadam_setting ps
			JOIN prasadam_setting_group psg ON ps.id = psg.prasadam_id
			WHERE ps.status = ? AND psg.prasadam_group_id = ?", [1, $prasadam_group_id])->getResultArray();

		return $this->response->setJSON($prasadam_settings);
	}

  public function show_product()
	{
		$prasadam_settings = $this->db->query("SELECT * FROM prasadam_setting WHERE status = 1 AND name_eng LIKE '%" . $_POST['prod'] . "%' order by name_eng asc")->getResultArray();
		foreach ($prasadam_settings as $key => $value) {
			if (!empty ($value)) {
				foreach ($value as $row) {
					$tr_row[] .= '<div class="col-md-3" style="padding-left: 0px;">
									<div class="prod" id="prod' . $row['id'] . '" data-id="prod' . $row['id'] . '" onclick="addtocart(' . $row['id'] . ')"><img src="' . base_url() . '/uploads/prasadam_setting/' . $row['image'] . '" width="200" height="80" alt="image" />
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

  public function gtpaymentdata()
    {
      $id = $_POST['id'];
      $res = $this->db->table("prasadam")->where("id", $id)->get()->getRowArray();
      $amt = $res['amount'];
      $data['amt'] = $amt;
      $res1 = $this->db->table("prasadam_booked_pay_details")->selectSum('amount')->where("prasadam_id", $id)->get()->getRowArray();
      $paid_amount = $res1['amount'];
      $data['paid_amount'] = $paid_amount;
      $data['bal_amount'] = $amt - $paid_amount;

      echo json_encode($data);
    }

	public function save()
	{
		if(!empty($_POST['prasadam_group'])){
			$msg_data = array();
			$msg_data['err'] = '';
			$msg_data['succ'] = '';
			$this->db->transStart();
			try {
				$date = $_POST['date'];
				$billno = $_POST['billno'];
				$tot_amt = $_POST['tot_amt'];
				$data['dob'] = $_POST['dob'];
				$data['prasadam_group_id'] = $_POST['prasadam_group'];
				$data['payment_type'] = !empty($_POST['payment_type']) ? $_POST['payment_type']: 'full';
				
				$yr = date('Y');
				$mon = date('m');
				$query = $this->db->query("SELECT ref_no FROM prasadam where id=(select max(id) from prasadam where year (date)='" . $yr . "' and month (date)='" . $mon . "')")->getRowArray();
				$data['ref_no'] = 'PR' . date('y', strtotime($_POST['date'])) . $mon . (sprintf("%05d", (((float) substr($query['ref_no'], -5)) + 1)));
				$data['date'] = date('Y-m-d', strtotime($_POST['date']));
				$data['customer_name'] = $_POST['name'];
				$mble_phonecode = !empty ($_POST['phonecode']) ? $_POST['phonecode'] : "";
				$mble_number = !empty ($_POST['mobile']) ? $_POST['mobile'] : "";
				$data['mobile_no'] = $mble_phonecode . $mble_number;
				$data['email_id'] = $_POST['email_id'];
				$data['ic_no'] = $_POST['ic_number'];
				$data['amount'] = $_POST['tot_amt'];
				$data['address'] = $_POST['address'];
				$data['collection_date'] = $_POST['collection_date'];
				$data['session'] = $_POST['time'];
				$time_session = ($data['session'] == 'Breakfast') ? "AM" : "PM";
				$data['serve_time'] = $_POST['hour'] . ':' . $_POST['minute'] .' '. $time_session;
				$data['desciption'] = $_POST['description'];
				$data['added_by'] = $this->session->get('profile_id_frend');
				$data['created_at'] = date('Y-m-d H:i:s');
				$data['updated_at'] = date('Y-m-d H:i:s');
				$data['paid_amount'] = $_POST['paid_amount'];
				$data['sep_print'] = (!empty ($_REQUEST['sep_print']) ? $_REQUEST['sep_print'] : 0);
				$data['paid_through'] = "COUNTER";
				$data['payment_mode'] = $payment_mode = $_POST['pay_method'];
				$payment_mode_details = $this->db->table('payment_mode')->where("id", $payment_mode)->get()->getRowArray();
				$pay_method = $payment_mode_details['name'];
				
				// Validate prasadam items exist
				if (empty($_POST['prasadam'])) {
					throw new Exception("No prasadam items in order");
				}
				
				// Calculate and validate total amount
				$calculated_total = 0;
				foreach ($_POST['prasadam'] as $prasadam_item) {
					if (empty($prasadam_item['id']) || empty($prasadam_item['qty'])) {
						throw new Exception("Invalid prasadam item data");
					}
					
					$prsm_set = $this->db->table('prasadam_setting_group')
						->where('prasadam_id', $prasadam_item['id'])
						->where('prasadam_group_id', $data['prasadam_group_id'])
						->get()->getRowArray();
					
					if (empty($prsm_set)) {
						throw new Exception("Invalid prasadam item: " . $prasadam_item['id']);
					}
					
					$calculated_total += ($prsm_set['amount'] * $prasadam_item['qty']);
				}
				
				// Verify total matches (allow 0.01 difference for rounding)
				if (abs($calculated_total - floatval($tot_amt)) > 0.01) {
					throw new Exception("Amount mismatch: Expected " . number_format($calculated_total, 2) . " but got " . number_format($tot_amt, 2));
				}
				
				// Use calculated total for accuracy
				$data['amount'] = $calculated_total;
				
				$res = $this->db->table('prasadam')->insert($data);
				$ins_id = $this->db->insertID();

				if (!empty ($data['mobile_no'])) {
					$users_all_data = array();
					if (substr($data['mobile_no'], 0, 1) == '+') {
						$users_all_data['mobile'] = substr($data['mobile_no'], 3);
						$users_all_data['country_phone_code'] = substr($data['mobile_no'], 0, 3);
					} else {
						$users_all_data['mobile'] = $data['mobile_no'];
						$users_all_data['country_phone_code'] = '+61';
					}
					$users_all_data['name'] = $data['customer_name'];
					$users_all_data['address'] = $data['address'];
					$users_all_data['nric'] = $data['ic_no'];
					$users_all_data['dob'] = $data['dob'];
					$users_all_data['email'] = $data['email_id'];
					sync_users_all_tag($users_all_data, 7);
				}
				
				if ($res) {
					$item_count = 0;
					foreach ($_POST['prasadam'] as $prasadam) {
						$data_prdm_book['prasadam_booking_id'] = $ins_id;
						$data_prdm_book['prasadam_id'] = $prasadam['id'];
						$data_prdm_book['prasadam_group_id'] = $data['prasadam_group_id'];
						$data_prdm_book['quantity'] = $prasadam['qty'];
						$data_prdm_book['created'] = date('Y-m-d H:i:s');
						
						$prsm_set = $this->db->table('prasadam_setting_group')
							->where('prasadam_id', $prasadam['id'])
							->where('prasadam_group_id', $data['prasadam_group_id'])
							->get()->getRowArray();
						
						$data_prdm_book['amount'] = $prsm_set['amount'];
						$amt = $prasadam['qty'] * $prsm_set['amount'];
						$data_prdm_book['total_amount'] = $amt;
						
						$res_2 = $this->db->table('prasadam_booking_details')->insert($data_prdm_book);
						
						if (!$res_2) {
							throw new Exception("Failed to insert booking detail for item: " . $prasadam['id']);
						}
						
						$item_count++;

						$settings = $this->db->table('settings')->where('type', 3)->where('setting_name', 'enable_madapalli')->get()->getRowArray();
						if ($settings['setting_value'] == 1) {
							$pras_det = $this->db->table('prasadam_setting')->where('id', $prasadam['id'])->get()->getRowArray();
							$madapalli_details['date'] = $_POST['collection_date'];
							$madapalli_details['type'] = 1;
							$madapalli_details['booking_id'] = $ins_id;
							$madapalli_details['product_id'] = $prasadam['id'];
							$madapalli_details['quantity'] = $prasadam['qty'];
							$madapalli_details['amount'] = $amt;
							$madapalli_details['session'] = $data['session'];
							$madapalli_details['serve_time'] = $data['serve_time'];
							$madapalli_details['customer_name'] = $_POST['name'];
							$madapalli_details['customer_mobile'] = $mble_phonecode . $mble_number;
							$madapalli_details['status'] = 0;
							$madapalli_details['created_by'] = $this->session->get('log_id_frend');
							$madapalli_details['created_at'] = date('Y-m-d H:i:s');
							$madapalli_details['updated_at'] = date('Y-m-d H:i:s');
							$res_m1 = $this->db->table('madapalli_booking_details')->insert($madapalli_details);

							if ($res_m1){
								$preparation_details = $this->db->table('madapalli_preparation_details')->where('date', $_POST['collection_date'])->where('type', 1)->get()->getResultArray();
								$product_found = false;

								foreach ($preparation_details as $detail) {
									if ($detail['product_id'] == $madapalli_details['product_id'] && $detail['session'] == $madapalli_details['session']) {
										$new_quantity = $detail['quantity'] + $madapalli_details['quantity'];
										$update_data = [
											'quantity' => $new_quantity,
											'updated_at' => date('Y-m-d H:i:s')
										];
										$this->db->table('madapalli_preparation_details')->where('id', $detail['id'])->update($update_data);
										$product_found = true;
										break;
									}
								}

								if (!$product_found) {
									$insert_data = [
										'date' => $_POST['collection_date'],
										'type' => 1,
										'session' => $data['session'],
										'product_id' => $madapalli_details['product_id'],
										'pro_name_eng' => $pras_det['name_eng'],
										'pro_name_tamil' => $pras_det['name_tamil'],
										'quantity' => $madapalli_details['quantity'],
										'status' => 0,
										'created_by' => $this->session->get('log_id_frend'),
										'created_at' => date('Y-m-d H:i:s'),
										'updated_at' => date('Y-m-d H:i:s')
									];
									$this->db->table('madapalli_preparation_details')->insert($insert_data);
								}
							}
						}
					}
					
					// Log for debugging
					log_message('info', 'Prasadam booking ID: ' . $ins_id . ' | Items inserted: ' . $item_count . ' | Total: ' . $calculated_total);
					
					if($res_2){
						$pay_details = array();
						$payment_mode_details = $this->db->table("payment_mode")->where('id', $payment_mode)->get()->getRowArray();
						$pay_details['prasadam_id'] = $ins_id;
						$pay_details['is_repayment'] = 0;
						$pay_details['payment_mode_id'] = $payment_mode;
						$pay_details['paid_through'] = 'COUNTER';
						$pay_details['pay_status'] = 2;
						$pay_details['payment_mode_title'] = $payment_mode_details['name'];
						$pay_details['booking_ref_no'] = $data['ref_no'];
						if($data['payment_type'] == 'partial') $pay_details['amount'] = $_POST['paid_amount'];
						else $pay_details['amount'] = $calculated_total;

						if(empty($pay_details['amount'])){
							throw new Exception('Invalid Payment Amount');
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
						$res_3 = $this->db->table('prasadam_booked_pay_details')->insert($pay_details);
				
						$booking_ref_data = array();
						$booking_ref_data['paid_amount'] = $pay_details['amount'];
						$booking_ref_data['booking_status'] = 1;
						if($data['payment_type'] == 'partial') $booking_ref_data['payment_status'] = 1;
						else $booking_ref_data['payment_status'] = 2;
						$this->db->table("prasadam")->where('id', $ins_id)->update($booking_ref_data);

						$payment_gateway_data = array();
						$payment_gateway_data['prasadam_id'] = $ins_id;
						$payment_gateway_data['pay_method'] = $pay_method;
						$this->db->table('prasadam_payment_gateway_datas')->insert($payment_gateway_data);
						$prasadam_payment_gateway_id = $this->db->insertID();
					}
					
					$this->account_migration($ins_id);
					
					if ($res_3) {
						$msg_data['succ'] = 'Prasadam Added Successfully';
						$msg_data['id'] = $ins_id;
					} else {
						throw new Exception('Payment details insert failed');
					}
				}
				
				$this->db->transComplete();
				
				if ($this->db->transStatus() === FALSE) {
					throw new Exception("Transaction failed");
				}
				
			} catch (Exception $e) {
				$this->db->transRollback();
				$msg_data['err'] = $e->getMessage();
				log_message('error', 'Prasadam booking error: ' . $e->getMessage() . ' | POST data: ' . json_encode($_POST));
			}
		} else {
			$msg_data['err'] = 'Please select a prasadam group';
		}
		echo json_encode($msg_data);
		exit();
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
				$annathanam_details = $this->db->table("prasadam")->where('id', $booking_id)->get()->getRowArray();
				if($annathanam_details['amount'] >= ($annathanam_details['paid_amount'] + $pay_amount)){
					$booking_payment_ins_data = array();
					$booking_payment_ins_data['prasadam_id'] = $booking_id;
					$booking_payment_ins_data['booking_ref_no'] = $annathanam_details['ref_no'];
					$booking_payment_ins_data['payment_mode_id'] = $payment_mode;
          $booking_payment_ins_data['is_repayment'] = 1;
					$booking_payment_ins_data['paid_date'] = !empty($date) ? $date : date('Y-m-d');
					$booking_payment_ins_data['amount'] = $pay_amount;
					$booking_payment_ins_data['payment_mode_title'] = $payment_mode_details['name'];
					$paid_through = 'COUNTER';
					if($paid_through != 'ADMIN' && $paid_through != 'COUNTER') $booking_payment_ins_data['payment_ref_no'] = $ubayam_details['ref_no'];
					$booking_payment_ins_data['paid_through'] = $paid_through;
					$booking_payment_ins_data['pay_status'] = ($paid_through == 'ADMIN' || $paid_through == 'COUNTER') ? 2 : 1;
					// $this->requestmodel = new RequestModel();
					// $ip = $this->requestmodel->getIpAddress();
					// $booking_payment_ins_data['ip'] = $ip;
					// if ($ip != 'unknown') {
					// 	$ip_details = $this->requestmodel->getLocation($ip);
					// 	$booking_payment_ins_data['ip_location'] = (!empty($ip_details['country']) ? $ip_details['country'] : 'Unknown');
					// 	$booking_payment_ins_data['ip_details'] = json_encode($ip_details);
					// } 

					// $this->paid_amount += $booking_payment_ins_data['amount'];
					$res = $this->db->table("prasadam_booked_pay_details")->insert($booking_payment_ins_data);
					$booked_pay_id = $this->db->insertID();
					$this->db->query("UPDATE prasadam SET paid_amount = paid_amount + ? WHERE id = ?", [$pay_amount, $booking_id]);
					$query = $this->db->table('prasadam')->where('id', $booking_id)->get()->getRowArray();
					if ($query['total_amount'] == $query['paid_amount']) {
						$this->db->query("UPDATE prasadam SET payment_status = 2 WHERE id = ?", [$booking_id]);
					}
					$this->account_migration($booked_pay_id);

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

  public function account_migration($ins_id)
	{
    $yr = date('Y');
    $mon = date('m');
		$data = $this->db->table('prasadam')->where('id', $ins_id)->get()->getRowArray();
		$payment_mode_details = $this->db->table('payment_mode')->where('id', $data['payment_mode'])->get()->getRowArray();
		$sales_group = $this->db->table('groups')->where('code', '4000')->get()->getRowArray();
		
		if(!empty($sales_group)){
			$sls_id = $sales_group['id'];
		} else {
			$sls1['parent_id'] = 0;
			$sls1['name'] = 'Sales';
			$sls1['code'] = '4000';
			$sls1['added_by'] = $this->session->get('log_id');
			$this->db->table('groups')->insert($sls1);
			$sls_id = $this->db->insertID();
		}

    $td_ledger = $this->db->table('ledgers')->where('name', 'TRADE RECEIVABLE')->where('group_id', 3)->where('left_code', '1200')->get()->getRowArray();
    if (!empty($td_ledger)) {
      $trade_receivable_id = $td_ledger['id'];
    } else {
      $cled1['group_id'] = 3;
      $cled1['name'] = 'TRADE RECEIVABLE';
      $cled1['code'] = '1200/005';
      $cled1['op_balance'] = '0';
      $cled1['op_balance_dc'] = 'D';
      $cled1['left_code'] = '1200';
      $cled1['right_code'] = '005';
      $this->db->table('ledgers')->insert($cled1);
      $trade_receivable_id = $this->db->insertID();
    }

    $number1 = $this->db->table('entries')->select('number')->where('entrytype_id', 4)->orderBy('id', 'desc')->get()->getRowArray();
    if (empty($number1)) $num1 = 1;
    else $num1 = $number1['number'] + 1;

    // Transfer total amount to Trade Receivable
    $qry = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='" . $yr . "' and entrytype_id =4 and month (date)='" . $mon . "')")->getRowArray();
    $entries['entry_code'] = 'JOR' . date('y', strtotime($data['date'])) . $mon . (sprintf("%05d", (((float) substr($qry['entry_code'], -5)) + 1)));
    $entries['date'] = date("Y-m-d", strtotime($data['date']));
    $entries['number'] = $num1;
    $entries['entrytype_id'] = '4';
    $entries['dr_total'] = $data['amount']; // Assuming 'total_amount' is the field for total booking amount
    $entries['cr_total'] = $data['amount'];
    $entries['narration'] = 'Prasadam(' . $data['ref_no'] . ')' . "\n" . 'name:' . $data['customer_name'] . "\n" . 'NRIC:' . $data['ic_no'] . "\n" . 'email:' . $data['email_id'] . "\n";
    $entries['inv_id'] = $ins_id;
    $entries['type'] = '10';
    $ent = $this->db->table('entries')->insert($entries);
    $en_id1 = $this->db->insertID();
	
		// $is_partial = $data['payment_type']; // Assuming 'is_partial' field in 'prasadam' table indicates if it's a partial payment
    $prasadam_booking_details = $this->db->table('prasadam_booking_details')->where('prasadam_booking_id', $ins_id)->get()->getResultArray();
		
		foreach ($prasadam_booking_details as $pbd) {
			$prasadam_details = $this->db->table('prasadam_setting')->where('id', $pbd['prasadam_id'])->get()->getRowArray();

			if(!empty($prasadam_details['ledger_id'])){
				$dr_id = $prasadam_details['ledger_id'];
			} else {
				$ledger1 = $this->db->table('ledgers')->where('name', 'All Sales')->where('group_id', $sls_id)->get()->getRowArray();
				if(!empty($ledger1)){
					$dr_id = $ledger1['id'];
				} else {
					$right_code = $this->db->table('ledgers')->select('right_code')->where('group_id', $sls_id)->where('left_code', '4913')->orderBy('right_code','desc')->get()->getRowArray();
					$set_right_code = (int) $right_code['right_code'] + 1;
					$set_right_code = sprintf("%04d", $set_right_code);
					$led1['group_id'] = $sls_id;
					$led1['name'] = 'All Sales';
					$led1['left_code'] = '4913';
					$led1['right_code'] = $set_right_code;
					$led1['op_balance'] = '0';
					$led1['op_balance_dc'] = 'D';
					$led_ins1 = $this->db->table('ledgers')->insert($led1);
					$dr_id = $this->db->insertID();
				}
			}
      // Debit the Product's Ledger (dr_id)
      $eitems_d['entry_id'] = $en_id1;
      $eitems_d['ledger_id'] = $dr_id;
      $eitems_d['amount'] = $pbd['total_amount'];
      $eitems_d['details'] = 'Prasadam(' . $data['ref_no'] . ')';
      $eitems_d['dc'] = 'C';
      $cr_res = $this->db->table('entryitems')->insert($eitems_d);
      $debtor_amount += $pbd['total_amount'];
    }
    // Credit Trade Receivable (trade_receivable_id)
    $eitems_c['entry_id'] = $en_id1;
    $eitems_c['ledger_id'] = $trade_receivable_id;
    $eitems_c['amount'] = $debtor_amount;
    $eitems_c['details'] = 'Prasadam(' . $data['ref_no'] . ')';
    $eitems_c['dc'] = 'D';
    $deb_res = $this->db->table('entryitems')->insert($eitems_c);

    $prasadam_booked_count = $this->db->table('prasadam_booked_pay_details')->where('prasadam_id', $ins_id)->get()->getNumRows();
    if($prasadam_booked_count > 0){
      $prasadam_booked_detail = $this->db->table('prasadam_booked_pay_details')->where('prasadam_id', $ins_id)->get()->getRowArray();

      $cr_id = $payment_mode_details['ledger_id'];
      $number = $this->db->table('entries')->select('number')->where('entrytype_id', 1)->orderBy('id', 'desc')->get()->getRowArray();
      if (empty($number) && empty($number1)) $num = 1;
      else $num = $number['number'] + 1;
			
      // Transfer total amount to Trade Receivable
      $qry = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='" . $yr . "' and entrytype_id =1 and month (date)='" . $mon . "')")->getRowArray();
      $entries['entry_code'] = 'REC' . date('y', strtotime($data['date'])) . $mon . (sprintf("%05d", (((float) substr($qry['entry_code'], -5)) + 1)));
      $entries['date'] = date("Y-m-d", strtotime($data['date']));
      $entries['number'] = $num;
      $entries['entrytype_id'] = '1';
      $entries['dr_total'] = $prasadam_booked_detail['amount']; // Assuming 'total_amount' is the field for total booking amount
      $entries['cr_total'] = $prasadam_booked_detail['amount'];
      $entries['narration'] = 'Prasadam(' . $data['ref_no'] . ')' . "\n" . 'name:' . $data['customer_name'] . "\n" . 'NRIC:' . $data['ic_no'] . "\n" . 'email:' . $data['email_id'] . "\n";
      $entries['inv_id'] = $ins_id;
      $entries['type'] = '10';
      $ent = $this->db->table('entries')->insert($entries);
      $en_id2 = $this->db->insertID();

      $eitems_d['entry_id'] = $en_id2;
      $eitems_d['ledger_id'] = $trade_receivable_id;
      $eitems_d['amount'] = $prasadam_booked_detail['amount'];
      $eitems_d['details'] = 'Prasadam(' . $data['ref_no'] . ')';
      $eitems_d['dc'] = 'C';
      $cr_res = $this->db->table('entryitems')->insert($eitems_d);

      // Credit Payment Mode (cr_id)
      $eitems_c['entry_id'] = $en_id2;
      $eitems_c['ledger_id'] = $cr_id;
      $eitems_c['amount'] = $prasadam_booked_detail['amount'];
      $eitems_c['details'] = 'Prasadam(' . $data['ref_no'] . ')';
      $eitems_c['dc'] = 'D';
      $deb_res = $this->db->table('entryitems')->insert($eitems_c);

    }
  }

  public function partial_account_migration($booked_pay_id){
		$succ = true;
		$booked_pay_details_cnt = $this->db->table("prasadam_booked_pay_details")->where("id", $booked_pay_id)->get()->getNumRows();	
		if ($booked_pay_details_cnt > 0) {
			$booked_pay_details = $this->db->table("prasadam_booked_pay_details")->where("id", $booked_pay_id)->get()->getResultArray();
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
			$prasadam = $this->db->table("prasadam")->where("id", $booking_id)->get()->getRowArray();
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
					$entries['narration'] = 'Prasadam(' . $prasadam['ref_no'] . ')' . "\n" . 'name:' . $prasadam['customer_name'] . "\n" . 'NRIC:' . $prasadam['ic_number'] . "\n" . 'email:' . $prasadam['email'] . "\n";
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
						$eitems_hall_book['details'] = 'Prasadam Amount';
						$this->db->table('entryitems')->insert($eitems_hall_book);
						// PETTY CASH => Debit 
						$eitems_cash_led['entry_id'] = $en_id;
						$eitems_cash_led['ledger_id'] = $paymentmode['ledger_id'];
						$eitems_cash_led['amount'] = $row['amount'];
						$eitems_cash_led['dc'] = 'D';
						$eitems_cash_led['details'] = 'Prasadam Amount';
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

  public function save_old()
  {
    // var_dump($_POST);
    // exit;
    $msg_data = array();
    $msg_data['err'] = '';
    $msg_data['succ'] = '';
    $yr = date('Y');
    $mon = date('m');
    $query = $this->db->query("SELECT ref_no FROM prasadam where id=(select max(id) from prasadam where year (date)='" . $yr . "' and month (date)='" . $mon . "')")->getRowArray();
    $data['ref_no'] = 'PR' . date('y') . $mon . (sprintf("%05d", (((float) substr($query['ref_no'], -5)) + 1)));
    $data['customer_name'] = $_POST['name'];
    $data['date'] = $_POST['date'];
    $data['email_id'] = $_POST['email_id'];
    $data['ic_no'] = $_POST['ic_number'];
    $mble_phonecode = !empty ($_POST['phonecode']) ? $_POST['phonecode'] : "";
    $mble_number = !empty ($_POST['mobile']) ? $_POST['mobile'] : "";
    $data['mobile_no'] = $mble_phonecode . $mble_number;
    $data['address'] = $_POST['address'];
    $data['desciption'] = $_POST['description'];
    $data['amount'] = $_POST['tot_amt'];
    $data['collection_date'] = $_POST['collection_date'];
    $data['dob'] = $_POST['dob'];
    $data['start_time'] = $_POST['s_time'];
    //$data['end_time'] = $_POST['e_time'];
    $data['payment_type'] = !empty($_POST['payment_type']) ? $_POST['payment_type']: 'full';
    $data['added_by'] = $this->session->get('log_id_frend');
    $data['sep_print'] = (!empty ($_REQUEST['sep_print']) ? $_REQUEST['sep_print'] : 0);
    $data['paid_through'] = "COUNTER";
    $pay_method = (!empty ($_POST['pay_method']) ? $_POST['pay_method'] : 'cash');
    $data['payment_status'] = (($pay_method == 'cash' || $pay_method == 'online'  || $pay_method == 'qr' || $pay_method == 'nets_pay') ? 2 : 1);
    $data['created_at'] = date('Y-m-d H:i:s');
    $data['updated_at'] = date('Y-m-d H:i:s');
    
    // if (!empty ($data['customer_name']) && !empty ($_POST['mobile'])) {
      $res = $this->db->table('prasadam')->insert($data);
      //   if (!$res) {
      //     log_message('error', 'Error inserting into prasadam: ' . json_encode($this->db->error()));
      // }
      // if (!$res) {
      // 		echo $this->db->getLastQuery();
      // 		print_r($this->db->error());
      // 		exit;
      // 	}	

      if ($res) {
        $this->session->setFlashdata('succ', 'Prasadam Added Successflly');
        $msg_data['succ'] = 'Prasadam Added Successflly';
        $msg_data['id'] = $ins_id;
      } else {
        $this->session->setFlashdata('fail', 'Please Try Again for prasadam');
        $msg_data['err'] = 'Please Try Again for save prasadam';
      }
      $ins_id = $this->db->insertID();
      if (!empty ($data['mobile_no'])) {
        $users_all_data = array();
        if (substr($data['mobile_no'], 0, 1) == '+') {
          $users_all_data['mobile'] = substr($data['mobile_no'], 3);
          $users_all_data['country_phone_code'] = substr($data['mobile_no'], 0, 3);
        } else {
          $users_all_data['mobile'] = $data['mobile_no'];
          $users_all_data['country_phone_code'] = '+61';
        }
        $users_all_data['name'] = $data['customer_name'];
        $users_all_data['address'] = $data['address'];
        $users_all_data['nric'] = $data['ic_no'];
        $users_all_data['dob'] = $data['dob'];
        $users_all_data['email'] = $data['email_id'];
        sync_users_all_tag($users_all_data, 7);
      }
      if ($res) {
        if (!empty ($_POST['prasadam'])) {
          foreach ($_POST['prasadam'] as $prasadam) {
            $data_prdm_book['prasadam_booking_id'] = $ins_id;
            $data_prdm_book['prasadam_id'] = $prasadam['id'];
            $data_prdm_book['quantity'] = $prasadam['qty'];
            $data_prdm_book['created'] = date('Y-m-d H:i:s');
            $prsm_set = $this->db->table('prasadam_setting')->where('id', $prasadam['id'])->get()->getRowArray();
            $data_prdm_book['amount'] = $prsm_set['amount'];
            $amt = $prasadam['qty'] * $prsm_set['amount'];
            $data_prdm_book['total_amount'] = $amt;
            $res_2 = $this->db->table('prasadam_booking_details')->insert($data_prdm_book);
            
            /*STOCK DEDECTION SECTION START */
            $prasadam_dedection_data = $this->db->table('prasadam_setting')->where('id', $prasadam['id'])->get()->getRowArray();
            if (!empty ($prasadam_dedection_data['dedection_from_stock'])) {
              if ($prasadam_dedection_data['dedection_from_stock'] == 1) {
                $pm_raw_items = $this->db->table("prasadam_raw_material_items")
                  ->where("product_id", $prasadam['id'])
                  ->get()->getResultArray();
                if (count($pm_raw_items) > 0) {
                  $staff_row = $this->db->table('staff')->where('name', 'admin')->where('is_admin', 1)->get()->getRowArray();
                  $data_rtout['date'] = $_POST['date'];
                  $data_rtout['staff_name'] = !empty ($staff_row['id']) ? $staff_row['id'] : NULL;
                  $query_out = $this->db->query("SELECT invoice_no FROM stock_outward where id=(select max(id) from stock_outward where year (date)='" . $yr . "' and month (date)='" . $mon . "')")->getRowArray();
                  $data_rtout['invoice_no'] = 'PR' . date('y', strtotime($_POST['date'])) . $mon . (sprintf("%05d", (((float) substr($query_out['invoice_no'], -5)) + 1)));
                  $data_rtout['added_by'] = $this->session->get('log_id_frend');
                  $data_rtout['modified'] = date("Y-m-d H:i:s");
                  $data_rtout['created'] = date("Y-m-d H:i:s");
                  $this->db->table('stock_outward')->insert($data_rtout);
                  $ins_id_rtout = $this->db->insertID();
                  $tot_outward_list_amt = 0;
                  foreach ($pm_raw_items as $pr_raw_item) {
                    $tot_req_qty = $prasadam['qty'] * $pr_raw_item['qty'];
                    $av_data_r = $this->db->table("raw_matrial_groups")->where("id", $pr_raw_item['raw_id'])->get()->getRowArray();
                    $avl_stack_r['opening_stock'] = $av_data_r['opening_stock'] - $tot_req_qty;
                    $this->db->table('raw_matrial_groups')->where('id', $pr_raw_item['raw_id'])->update($avl_stack_r);

                    $uom_item_data = $this->db->table('raw_matrial_groups')->where('id', $pr_raw_item['raw_id'])->get()->getRowArray();
                    $uom_id = $uom_item_data['uom_id'];
                    $item_raw_name = $uom_item_data['name'];
                    $item_raw_rate = $uom_item_data['price'];
                    $item_raw_qty = $tot_req_qty;
                    $item_raw_amt = $uom_item_data['price'] * $tot_req_qty;
                    $data_rtout_list['stack_out_id'] = $ins_id_rtout;
                    $data_rtout_list['item_type'] = 2;
                    $data_rtout_list['item_id'] = $pr_raw_item['raw_id'];
                    $data_rtout_list['item_name'] = $item_raw_name;
                    $data_rtout_list['uom_id'] = $uom_id;
                    $data_rtout_list['rate'] = $item_raw_rate;
                    $data_rtout_list['quantity'] = $item_raw_qty;
                    $data_rtout_list['amount'] = $item_raw_amt;
                    $data_rtout_list['created'] = date("Y-m-d H:i:s");
                    $data_rtout_list['modified'] = date("Y-m-d H:i:s");
                    $this->db->table('stock_outward_list')->insert($data_rtout_list);
                    $tot_outward_list_amt = $tot_outward_list_amt + $item_raw_amt;
                  }
                  $this->db->table('stock_outward')->where('id', $ins_id_rtout)->update(array("total_amount" => $tot_outward_list_amt));
                }
              }
            }
            /*STOCK DEDECTION SECTION END */
          }
        }
        $pay_details = array();
        //$count = $this->db->table("payment_mode")->where('id', $payment_mode_id)->get()->getNumRows();
        // if($count){
        $payment_mode_details = $this->db->table("payment_mode")->where('id', $payment_mode)->get()->getRowArray();
        $pay_details['prasadam_id'] = $ins_id;
        $pay_details['payment_mode_id'] = $payment_mode;
        $pay_details['paid_through'] = 'ADMIN';
        $pay_details['pay_status'] = 2;
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
        // $this->requestmodel = new RequestModel();
        // $ip = $this->requestmodel->getIpAddress();
        // $pay_details['ip'] = $ip;
        // if ($ip != 'unknown') {
        // 	$ip_details = $this->requestmodel->getLocation($ip);
        // 	$pay_details['ip_location'] = (!empty($ip_details['country']) ? $ip_details['country'] : 'Unknown');
        // 	$pay_details['ip_details'] = json_encode($ip_details);
        // }
        $res_3 = $this->db->table('prasadam_booked_pay_details')->insert($pay_details);
        if (!$res_3) {
          error_log('Failed to insert into prasadam: ' . $this->db->error());
        }
        $booking_ref_data = array();
        $booking_ref_data['paid_amount'] = $pay_details['amount'];
        $booking_ref_data['booking_status'] = 1;
        if($data['payment_type'] == 'partial') $booking_ref_data['payment_status'] = 1;
        $this->db->table("prasadam")->where('id', $prasadam_id)->update($booking_ref_data);

        $payment_gateway_data = array();
        $payment_gateway_data['prasadam_id'] = $ins_id;
        $payment_gateway_data['pay_method'] = $pay_method;
        $this->db->table('prasadam_payment_gateway_datas')->insert($payment_gateway_data);
        $prasadam_payment_gateway_id = $this->db->insertID();
        if ($data['payment_status'] == 2) {
          //$this->account_migration($ins_id);
          //$this->send_whatsapp_msg($ins_id);
          //$this->send_mail_to_customer($ins_id);
        }
        if ($res_2) {
          $this->session->setFlashdata('succ', 'Prasadam Added Successflly');
          $msg_data['succ'] = 'Prasadam Added Successflly';
          $msg_data['id'] = $ins_id;
        } else {
          $this->session->setFlashdata('fail', 'Please Try Again');
          $msg_data['err'] = 'Please Try Again for.....';
        }
      }
    // } else {
    //   //$this->session->setFlashdata('fail', 'Please Try Again');
    //   $msg_data['err'] = 'Please Try Again. required user details.';
    // }
    echo json_encode($msg_data);
    exit();
  }

  

  public function send_mail_to_customer($id)
  {
    $prasadam = $this->db->table("prasadam")->where("id", $id)->get()->getRowArray();
    if (!empty ($prasadam['email_id'])) {
      $prasadam_booking_details = $this->db->table('prasadam_booking_details')->select("prasadam_booking_details.*, prasadam_setting.name_eng as prasadam_eng, prasadam_setting.name_tamil as prasadam_tamil")->join('prasadam_setting', 'prasadam_booking_details.prasadam_id = prasadam_setting.id', 'left')->where('prasadam_booking_id', $id)->get()->getResultArray();
      $tmpid = 1;
      $temple_details = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
      $temple_title = "Temple " . $temple_details['name'];
      $qr_url = base_url() . "/prasadam/reg/";
      $mail_data['qr_image'] = qrcode_generation($id, $qr_url);
      $mail_data['don_id'] = $id;
      $mail_data['prasadam'] = $prasadam;
      $mail_data['prasadam_booking_details'] = $prasadam_booking_details;
      $mail_data['temple_details'] = $temple_details;
      $message = view('prasadam/mail_template', $mail_data);
      $to = $prasadam['email_id'];
      $subject = $temple_details['name'] . " Prasadam";
      $to_mail = array("prithivitest@gmail.com", $to);
      send_mail_with_content($to_mail, $message, $subject, $temple_title);
    }
  }
  public function payment_process($prsm_id)
  {
    $prasadam_booking = $this->db->table('prasadam')->where('id', $prsm_id)->get()->getRowArray();
    $prasadam_payment_gateway_datas = $this->db->table('prasadam_payment_gateway_datas')->where('prasadam_id', $prsm_id)->get()->getResultArray();
    if (count($prasadam_payment_gateway_datas) > 0) {
      if ($prasadam_payment_gateway_datas[0]['pay_method'] == 'adyen') {
        if (!empty ($prasadam_payment_gateway_datas[0]['request_data'])) {
          $request_data = $prasadam_payment_gateway_datas[0]['request_data'];
          $response = json_decode($request_data, true);
        } else {
          $tmpid = 1;
          $temple_details = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
          $result = $this->initiatePayment($prasadam_booking['amount'], $prsm_id, $temple_details['address1'] . $temple_details['address2'], $temple_details['city'], $temple_details['email']);
          $response = json_decode($result, true);
          $payment_gateway_up_data = array();
          $payment_gateway_up_data['request_data'] = $result;
          $payment_gateway_up_data['reference_id'] = $response['id'];
          $this->db->table('prasadam_payment_gateway_datas')->where('id', $prasadam_payment_gateway_datas[0]['id'])->update($payment_gateway_up_data);
        }
        if (!empty ($response['url']) && !empty ($response['id'])) {
          header('Location: ' . $response['url']);
          exit;
        }
      } else {
        $redirect_url = base_url() . '/prasadam_online/print_booking/' . $prsm_id;
        header('Location: ' . $redirect_url);
        exit;
      }
    } else {
      $tmpid = 1;
      $temple_details = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
      $result = $this->initiatePayment($prasadam_booking['amount'], $prsm_id, $temple_details['address1'] . $temple_details['address2'], $temple_details['city'], $temple_details['email']);
      $response = json_decode($result, true);
      if (!empty ($response['url']) && !empty ($response['id'])) {
        $payment_gateway_data = array();
        $payment_gateway_data['prasadam_id'] = $prsm_id;
        $payment_gateway_data['pay_method'] = 'adyen';
        $payment_gateway_data['request_data'] = $result;
        $payment_gateway_data['reference_id'] = $response['id'];
        $this->db->table('prasadam_payment_gateway_datas')->insert($payment_gateway_data);
        $prasadam_payment_gateway_id = $this->db->insertID();
        if (!empty ($prasadam_payment_gateway_id)) {
          header('Location: ' . $response['url']);
          exit;
        }
      }
    }
  }

  public function initiatePayment($amount, $orderid, $address, $city, $email)
  {
    if (file_get_contents('php://input') != '') {
      $request = json_decode(file_get_contents('php://input'), true);
    } else {
      $request = array();
    }
    $apikey = "AQExhmfuXNWTK0Qc+iSGm3I5puqPTYhFHpxGTXFfyXa4nWlGJfnh+XuzwV6dTmmMJv6GnBDBXVsNvuR83LVYjEgiTGAH-09p02SzaBtpvbU0D3ZRFu8cWY44ivj4mqeMXogk0Ogk=-@e*vZIt9AWvaNN:.";
    $merchantAccount = "VivaantechsolutionscomECOM";
    $url = "https://checkout-test.adyen.com/v70/paymentLinks";
    $final_amt = $amount * 100;
    $data = [
      'amount' => [
        'currency' => 'MYR',
        'value' => $final_amt
      ],
      "reference" => $orderid,
      'countryCode' => "MY",
      'shopperReference' => "order_" . $orderid,
      'shopperEmail' => $email,
      'shopperLocale' => "en-US",
      "billingAddress" => [
          "street" => $address,
          "postalCode" => "46000",
          "city" => $city,
          "houseNumberOrName" => "1/23",
          "country" => "MY",
          "stateOrProvince" => "KL"
        ],
      "deliveryAddress" => [
        "street" => $address,
        "postalCode" => "46000",
        "city" => $city,
        "houseNumberOrName" => "1/23",
        "country" => "MY",
        "stateOrProvince" => "KL"
      ],
      'returnUrl' => base_url() . '/prasadam_online/print_booking/' . $orderid,
      'merchantAccount' => $merchantAccount
    ];
    $json_data = json_encode($data);
    $curlAPICall = curl_init();
    curl_setopt($curlAPICall, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curlAPICall, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curlAPICall, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt($curlAPICall, CURLOPT_URL, $url);
    curl_setopt(
      $curlAPICall,
      CURLOPT_HTTPHEADER,
      array(
        "x-api-key: " . $apikey,
        "Content-Type: application/json",
        "Content-Length: " . strlen($json_data)
      )
    );
    $result = curl_exec($curlAPICall);
    if ($result === false) {
      throw new Exception(curl_error($curlAPICall), curl_errno($curlAPICall));
    }
    curl_close($curlAPICall);
    return $result;
  }

  public function initiatePayment_response($pay_id)
  {
    if (file_get_contents('php://input') != '') {
      $request = json_decode(file_get_contents('php://input'), true);
    } else {
      $request = array();
    }
    $apikey = "AQExhmfuXNWTK0Qc+iSGm3I5puqPTYhFHpxGTXFfyXa4nWlGJfnh+XuzwV6dTmmMJv6GnBDBXVsNvuR83LVYjEgiTGAH-09p02SzaBtpvbU0D3ZRFu8cWY44ivj4mqeMXogk0Ogk=-@e*vZIt9AWvaNN:.";
    $merchantAccount = "VivaantechsolutionscomECOM";
    $url = "https://checkout-test.adyen.com/v70/paymentLinks/" . $pay_id;
    $curlAPICall = curl_init();
    curl_setopt($curlAPICall, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($curlAPICall, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curlAPICall, CURLOPT_URL, $url);
    // Api key
    curl_setopt(
      $curlAPICall,
      CURLOPT_HTTPHEADER,
      array(
        "x-api-key: " . $apikey
      )
    );
    $result = curl_exec($curlAPICall);
    if ($result === false) {
      throw new Exception(curl_error($curlAPICall), curl_errno($curlAPICall));
    }
    curl_close($curlAPICall);
    return $result;
  }
  
  public function account_migration_old($prsm_id)
  {
    $prasadam = $this->db->table('prasadam')->where('id', $prsm_id)->get()->getRowArray();
    if ($prasadam['paid_through'] == 'COUNTER') {
      $prasadam_payment_gateway_datas = $this->db->table('prasadam_payment_gateway_datas')->where('prasadam_id', $prsm_id)->get()->getRowArray();
      if ($prasadam_payment_gateway_datas['pay_method'] == 'cash')
        $payment_id = 6; ////  goto cash Ledger
      else if ($prasadam_payment_gateway_datas['pay_method'] == 'online')$payment_id = 8; ////  goto online Ledger
	  elseif($prasadam_payment_gateway_datas['pay_method'] == 'qr') $payment_id = 9; ////  goto qr Ledger
	  elseif($prasadam_payment_gateway_datas['pay_method'] == 'nets_pay') $payment_id = 10; ////  goto qr Ledger
      else
        $payment_id = 4; ////  goto Qr or Online Payment Ledger
      $payment_mode_details = $this->db->table('payment_mode')->where('id', $payment_id)->get()->getRowArray();
      if (empty ($payment_mode_details['id']))
        $payment_mode_details = $this->db->table('payment_mode')->get()->getRowArray();
      /*$ledger = $this->db->table('ledgers')->where('name', 'PRASADAM FEE')->where('group_id', 29)->where('left_code', '7111')->get()->getRowArray();
      if (!empty ($ledger)) {
        $dr_id = $ledger['id'];
      } else {
        $led['group_id'] = 29;
        $led['name'] = 'PRASADAM FEE';
        $led['left_code'] = '7111';
        $led['right_code'] = '000';
        $led['op_balance'] = '0';
        $led['op_balance_dc'] = 'D';
        $led_ins = $this->db->table('ledgers')->insert($led);
        $dr_id = $this->db->insertID();
      }
            $cr_id = $payment_mode_details['ledger_id'];
      */
      $sales_group = $this->db->table('groups')->where('code', '4000')->get()->getRowArray();
      if(!empty($sales_group)){
        $sls_id = $sales_group['id'];
      }else{
        $sls1['parent_id'] = 0;
        $sls1['name'] = 'Sales';
        $sls1['code'] = '4000';
        $sls1['added_by'] = $this->session->get('log_id');
        $this->db->table('groups')->insert($sls1);
        $sls_id = $this->db->insertID();
      }
      $prasadam_booking_details = $this->db->table('prasadam_booking_details')->where('prasadam_booking_id', $prsm_id)->get()->getResultArray();
      foreach ($prasadam_booking_details as $pbd) {
        $prasadam_details = $this->db->table('prasadam_setting')->where('id', $pbd['prasadam_id'])->get()->getRowArray();
        if(!empty($prasadam_details['ledger_id'])){
          $dr_id = $prasadam_details['ledger_id'];
        }else{
          $ledger1 = $this->db->table('ledgers')->where('name', 'All Sales')->where('group_id', $sls_id)->get()->getRowArray();
          if(!empty($ledger1)){
            $dr_id = $ledger1['id'];
          }else{
            $right_code = $this->db->table('ledgers')->select('right_code')->where('group_id', $sls_id)->where('left_code', '4913')->orderBy('right_code','desc')->get()->getRowArray();
            $set_right_code = (int) $right_code['right_code'] + 1;
            $set_right_code = sprintf("%04d", $set_right_code);
            $led1['group_id'] = $sls_id;
            $led1['name'] = 'All Sales';
            $led1['left_code'] = '4913';
            $led1['right_code'] = $set_right_code;
            $led1['op_balance'] = '0';
            $led1['op_balance_dc'] = 'D';
            $led_ins1 = $this->db->table('ledgers')->insert($led1);
            $dr_id = $this->db->insertID();
          }
        }

          $cr_id = $payment_mode_details['ledger_id'];
          $number = $this->db->table('entries')->select('number')->where('entrytype_id', 1)->orderBy('id', 'desc')->get()->getRowArray();
          if (empty($number)) {
            $num = 1;
          } else {
            $num = $number['number'] + 1;
          }
          $date = explode('-', date("Y-m-d", strtotime($prasadam['date'])));
          $yr = date('Y', strtotime($prasadam['date']));
          $mon = date('m', strtotime($prasadam['date']));
          $qry = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='" . $yr . "' and entrytype_id =1 and month (date)='" . $mon . "')")->getRowArray();
          $entries['entry_code'] = 'REC' . date('y', strtotime($prasadam['date'])) . $mon . (sprintf("%05d", (((float) substr($qry['entry_code'], -5)) + 1)));
          $entries['entrytype_id'] = '1';
          $entries['number'] = $num;
          $entries['date'] = date("Y-m-d", strtotime($prasadam['date']));
          $entries['dr_total'] = $pbd['total_amount'];
          $entries['cr_total'] = $pbd['total_amount'];
          $entries['narration'] = 'Prasadam(' . $prasadam['ref_no'] . ')' . "\n" . 'name:' . $prasadam['customer_name'] . "\n" . 'NRIC:' . $prasadam['ic_no'] . "\n" . 'email:' . $prasadam['email_id'] . "\n";
          $entries['inv_id'] = $prsm_id;
          $entries['type'] = '10';
          $ent = $this->db->table('entries')->insert($entries);
          $en_id = $this->db->insertID();
          if (!empty($en_id)) {
            $ent_id[] = $en_id;
            $eitems_d['entry_id'] = $en_id;
            $eitems_d['ledger_id'] = $dr_id;
            $eitems_d['amount'] = $pbd['total_amount'];
            $eitems_d['details'] = 'Prasadam(' . $prasadam['ref_no'] . ')';
            $eitems_d['dc'] = 'C';
            $cr_res = $this->db->table('entryitems')->insert($eitems_d);
            $eitems_c['entry_id'] = $en_id;
            $eitems_c['ledger_id'] = $cr_id;
            $eitems_c['amount'] = $pbd['total_amount'];
            $eitems_c['details'] = 'Prasadam(' . $prasadam['ref_no'] . ')';
            $eitems_c['dc'] = 'D';
            $deb_res = $this->db->table('entryitems')->insert($eitems_c);
            if ($cr_res && $deb_res)
              $succ++;
            else
              $err++;
          }
      }

    }
  }
  public function print_booking($prsm_id)
  {
    $id = $this->request->uri->getSegment(3);
    $data['qry1'] = $prasadam = $this->db->table('prasadam')
      ->select('prasadam.*')
      ->where('prasadam.id', $id)
      ->get()->getRowArray();
    $data['qry1_payfor'] = $this->db->table('prasadam_booking_details')
      ->join('prasadam_setting', 'prasadam_setting.id = prasadam_booking_details.prasadam_id')
      ->select('prasadam_booking_details.*,prasadam_setting.name_eng,prasadam_setting.name_tamil')
      ->where('prasadam_booking_details.prasadam_booking_id', $id)
      ->get()->getResultArray();
    $url = "https://maps.app.goo.gl/SyWKRkVEzrTDa1BB8";
    $data['qrcdoee'] = qrcode_generation($id, $url, 95, 95);
    if ($prasadam['sep_print'] == 1)
      $view_file = 'frontend/prasadam/print_sep';
    else
      $view_file = 'frontend/prasadam/print_page';
    if ($prasadam['paid_through'] == 'COUNTER') {
      if ($prasadam['payment_status'] == '2') {
        $tmpid = $this->session->get('profile_id_frend');
        $data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
        $data['terms'] = $this->db->table("terms_conditions")->get()->getRowArray();
        echo view($view_file, $data);
      } elseif ($prasadam['payment_status'] == '1') {
          $tmpid = $this->session->get('profile_id_frend');
          $data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
          $data['terms'] = $this->db->table("terms_conditions")->get()->getRowArray();
          echo view($view_file, $data);
              // } else {
              //     $prasadam_up_data = array();
              //     $prasadam_up_data['payment_status'] = 3;
              //     $this->db->table('prasadam')->where('id', $id)->update($prasadam_up_data);
              //     redirect()->to("/cancelled_booking");
              //     exit;
              //}
                  
                // } else {
                //   redirect()->to("/cancelled_booking");
                //   exit;
      }
    } else {
      $tmpid = 1;
      $data['temp_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
      $data['terms'] = $this->db->table("terms_conditions")->get()->getRowArray();
      echo view($view_file, $data);
    }
  }

  

  public function print_booking_report($prsm_id)
	{
		// if (!$this->model->permission_validate('prasadam', 'print')) {
		// 	header('Location: ' . base_url() . '/dashboard');
		// }
		$id = $prsm_id;
		$data['data'] = $this->db->table('prasadam')->select('prasadam.*')->where('prasadam.id', $id)->get()->getRowArray();
		$tmpid = $this->session->get('profile_id_frend');
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
		$data['booking_details'] = $this->db->table('prasadam_booking_details')
			->join('prasadam_setting', 'prasadam_setting.id = prasadam_booking_details.prasadam_id')
			->select('prasadam_booking_details.*,prasadam_setting.name_eng,prasadam_setting.name_tamil')
			->where('prasadam_booking_details.prasadam_booking_id', $id)
			->get()->getResultArray();
		//$url = "https://maps.app.goo.gl/SyWKRkVEzrTDa1BB8";
		//$data['qrcdoee'] = qrcode_generation($id, $url, 95, 95);
		echo view('frontend/prasadam/print_page_a4', $data);
	}

  public function print_booking_sep($prsm_id)
  {
    $id = $this->request->uri->getSegment(3);
    $data['qry1'] = $this->db->table('prasadam')
      ->select('prasadam.*')
      ->where('prasadam.id', $id)
      ->get()->getRowArray();
    $tmpid = $this->session->get('profile_id_frend');
    $data['temp_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
    $data['qry1_payfor'] = $this->db->table('prasadam_booking_details')
      ->join('prasadam_setting', 'prasadam_setting.id = prasadam_booking_details.prasadam_id')
      ->select('prasadam_booking_details.*,prasadam_setting.name_eng,prasadam_setting.name_tamil')
      ->where('prasadam_booking_details.prasadam_booking_id', $id)
      ->get()->getResultArray();
    $url = "https://maps.app.goo.gl/SyWKRkVEzrTDa1BB8";
    $data['qrcdoee'] = qrcode_generation($id, $url, 95, 95);
    echo view('frontend/prasadam/print_sep', $data);
  }
  public function cancelled_booking()
  {
    echo view('frontend/layout/header');
    echo view('frontend/prasadam/cancelled_booking');
    echo view('frontend/layout/footer');
  }
  public function reprint_booking($id)
  {
    $data['qry1'] = $prasadam = $this->db->table('prasadam')
      ->select('prasadam.*')
      ->where('prasadam.id', $id)
      ->get()->getRowArray();
    $data['qry1_payfor'] = $this->db->table('prasadam_booking_details')
      ->join('prasadam_setting', 'prasadam_setting.id = prasadam_booking_details.prasadam_id')
      ->select('prasadam_booking_details.*,prasadam_setting.name_eng,prasadam_setting.name_tamil')
      ->where('prasadam_booking_details.prasadam_booking_id', $id)
      ->get()->getResultArray();
    $view_file = 'frontend/prasadam/print_page';
    $tmpid = $this->session->get('profile_id_frend');
    $data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
    $data['terms'] = $this->db->table("terms_conditions")->get()->getRowArray();
    $url = "https://maps.app.goo.gl/SyWKRkVEzrTDa1BB8";
    $data['qrcdoee'] = qrcode_generation($id, $url, 95, 95);
    echo view($view_file, $data);
  }
  public function send_whatsapp_msg($id)
  {
    $data['qry1'] = $prasadam = $this->db->table('prasadam')
      ->select('prasadam.*')
      ->where('prasadam.id', $id)
      ->get()->getRowArray();
    $tmpid = 1;
    $data['temp_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
    $data['qry1_payfor'] = $this->db->table('prasadam_booking_details')
      ->join('prasadam_setting', 'prasadam_setting.id = prasadam_booking_details.prasadam_id')
      ->select('prasadam_booking_details.*,prasadam_setting.name_eng,prasadam_setting.name_tamil')
      ->where('prasadam_booking_details.prasadam_booking_id', $id)
      ->get()->getResultArray();
    $url = "https://maps.app.goo.gl/SyWKRkVEzrTDa1BB8";
    $data['qrcdoee'] = qrcode_generation($id, $url, 95, 95);
    $tmpid = 1;
    $data['temple_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
    if (!empty ($prasadam['mobile_no'])) {
      $html = view('prasadam/pdf', $data);
      $options = new Options();
      $options->set('isHtml5ParserEnabled', true);
      $options->set(array('isRemoteEnabled' => true));
      $options->set('isPhpEnabled', true);
      // echo $html;
      $dompdf = new Dompdf($options);
      $dompdf->loadHtml($html);
      $dompdf->setPaper('A4', 'portrait');
      $dompdf->render();
      $filePath = FCPATH . 'uploads/documents/invoice_prasadam_' . $id . '.pdf';

      file_put_contents($filePath, $dompdf->output());
      $message_params = array();
      $message_params[] = date('d M, Y', strtotime($prasadam['date']));
      $message_params[] = date('d M, Y', strtotime($prasadam['collection_date']));
      $message_params[] = date('h:i A', strtotime($prasadam['collection_date'] . ' ' . $prasadam['start_time']));
      $message_params[] = $prasadam['amount'];
      $media['url'] = base_url() . '/uploads/documents/invoice_prasadam_' . $id . '.pdf';
      $media['filename'] = 'prasadam_invoice.pdf';
      $mobile_number = $prasadam['mobile_no'];
      //$mobile_number = '+919092615446';
      // print_r($mobile_number);
      // print_r($message_params);
      // print_r($media);
      // die; 
      $whatsapp_resp = whatsapp_aisensy($mobile_number, $message_params, 'prasadam_live', $media);
      //print_r($whatsapp_resp);
    }
  }



}
