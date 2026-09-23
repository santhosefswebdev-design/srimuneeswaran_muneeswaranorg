<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Online_hallbooking extends BaseController
{
	function __construct(){
        parent:: __construct();
        helper('url');
        helper('common_helper');
        //$this->model = new PermissionModel();
    }
	public function index()
	{
		$date=  date("Y-m-d");
        $res = $this->db->table("hall_booking")->select("id, name")->where("booking_date", $date)->where("status<>", 3)->get()->getResultArray();
        $data_time= array();
        $time_name = array();
        $i=0;  //echo '<pre>';
        foreach($res as $r){
            $ds = $this->db->table("hall_booking_slot_details")->select("booking_slot_id")->where("hall_booking_id", $r['id'])->get()->getResultArray();
           // print_r($ds);
            foreach($ds as $rr){
              if(!empty($rr)){
                $data_time[] = $rr['booking_slot_id'];
                $time_name[$rr['booking_slot_id']] = $r['name'];
              }
            }
        }
        //die;
        $data['date'] = $date;
        $data['data_time'] = $data_time;
        $data['time_name'] = $time_name;
        $data['time_list'] = $this->db->table("booking_slot")->get()->getResultArray();
        $data['staff'] = $this->db->table("staff")->where('is_admin',0)->get()->getResultArray();
        $data['package'] = $this->db->table("booking_addonn")->get()->getResultArray();
        $data['payment_modes'] = $this->db->table('payment_mode')->where('status', 1)->where('paid_through', 'ONLINE')->get()->getResultArray();
        $data['phone_codes'] = $this->db->table("phone_code")->orderBy('dailing_code', 'ASC')->get()->getResultArray();
		echo view('website/layout/header');
        echo view('website/hallbooking', $data);
        echo view('website/layout/footer');
    }
	public function getpack_amt()
    {
      $id = $_POST['id'];
      $res = $this->db->table("booking_addonn")->where("id", $id)->get()->getRowArray();
      //$amt = $res['amount'] + $res['commision'];
      $amt = $res['amount'];
      $data['amt'] = $amt;
      $data['name'] = $res['name'];
      echo json_encode($data);
    }
	public function get_service_list()
    {
        $pack_id = $_POST['id'];
        $get_result_details = $this->db->table("booking_addonn_service")->where("booking_addon_id", $pack_id)->get()->getResultArray();
        echo json_encode($get_result_details);
    }
	public function get_service_name()
    {
        $id = $_POST['id'];
        $res = $this->db->table("service")->where("id", $id)->get()->getRowArray();
        $data['name'] = $res['name'];
        $data['amount'] = $res['amount'];
        $data['description'] = $res['description'];
        echo json_encode($data);
    }
	public function loadbookingslots()
    {
        $date=  date("Y-m-d",$_POST['bookeddate']);
		//var_dump($date);
		//exit;
        $res = $this->db->table("hall_booking")->select("id, name")->where("booking_date", $date)->where("status<>", 3)->get()->getResultArray();
        $data_time= array();
        $time_name = array();
        $i=0;  //echo '<pre>';
        foreach($res as $r){
            $ds = $this->db->table("hall_booking_slot_details")->select("booking_slot_id")->where("hall_booking_id", $r['id'])->get()->getResultArray();
          // print_r($ds);
            foreach($ds as $rr){
              if(!empty($rr)){
                $data_time[] = $rr['booking_slot_id'];
                $time_name[$rr['booking_slot_id']] = $r['name'];
              }
            }
        }

        //SLOT BLOCKED BOOKING
        $data_blocked_time= array();
        $res_blocked = $this->db->table("block_date")->select("date, description")->where("date", $date)->get()->getResultArray();
        foreach($res_blocked as $res_block)
        {
          $data_blocked_time[] = 1;
          $data_blocked_time[] = 2;
          $data_blocked_time[] = 3;
        }
        //END SLOT BLOCKED BOOKING
        $html = "<tr>";
        $time_list = $this->db->table("booking_slot")->get()->getResultArray();
        foreach($time_list as $row) {
          if (in_array($row['id'], $data_time)) { 
            $disabled = "disabled"; $t_name = $time_name[$row['id']];
            $checkbox_style = 'border: 2px solid #f61f1f !important;background: #f16e6e !important;';
            $label_style = 'cursor: no-drop;';
          }
          else if (in_array($row['id'], $data_blocked_time)) { 
            $disabled = "disabled"; $t_name = '';
            $checkbox_style = 'border: 2px solid #f61f1f !important;background: #f16e6e !important;';
            $label_style = 'cursor: no-drop;';
          }
          else  { 
            $disabled = ""; $t_name = '';
            $checkbox_style ="";
            $label_style ="";
          }
          $html .='
				<td style="border: none;font-size: 18px;padding: 0px;">
				<input type="checkbox" class="slot largerCheckbox" name="timing[]" value="'.$row["id"].'" id="timing'.$row["id"].'" '.$disabled.' style="'.$checkbox_style.'"> <span>'.date("g:i A", strtotime($row["name"])) .' - '.date("g:i A", strtotime($row["description"])).' ( '.$row["slot_season"].' ) </span>
				</td>';  
        }
		$html.='</tr>';
        echo $html;
    }
	public function save_booking(){
		//var_dump($_POST);
		//exit;
		$msg_data = array();
		$msg_data['err'] = '';
		$msg_data['succ'] = '';
		$data = array();
		$date = explode('-', $_POST['event_date']);
		$yr = $date[0];
		$mon = $date[1];
		$query   = $this->db->query("SELECT ref_no FROM hall_booking where id=(select max(id) from hall_booking where year (booking_date)='". $yr ."' and month (booking_date)='". $mon ."')")->getRowArray();
		if(!empty($query['ref_no'])){
			$data['ref_no']= 'HA' .date('y',strtotime($_POST['event_date'])).$mon. (sprintf("%05d",(((float)  substr($query['ref_no'],-5))+1)));
		}
		else{
			$data['ref_no']= 'HA' .date('y',strtotime($_POST['event_date'])).$mon. (sprintf("%05d",1));
		}
		$data['booking_date']   = $_POST['event_date'];
		$data['booking_time']   = date("H:i:s");
		$data['event_name']     = trim($_POST['event_name']);
		$data['register_by']    = !empty($_POST['register']) ? trim($_POST['register']) : '';
		$data['name']           = trim($_POST['name']);
		$data['status']         = 1;		
		$data['address']        = trim($_POST['address']);
		$mble_phonecode = !empty($_POST['phonecode'])?$_POST['phonecode']:"";
		$mble_number = !empty($_POST['mobile'])?$_POST['mobile']:"";
		$data['mobile_number']  = $mble_phonecode.$mble_number;
		$data['email']          = trim($_POST['email']);
		$data['ic_no']          = trim($_POST['ic_num']);
		$data['total_amount']   = trim($_POST['total_amt']);
		$data['paid_amount']    = trim($_POST['total_amt']);
		$data['balance_amount'] = 0;
		$data['paid_through'] = "ONLINE";
		$pay_method       =	'ipay_online';
		$data['payment_status'] = 1;
		$data['entry_date']     = date("Y-m-d");
		$data['entry_by']       = $_POST['user_login_id'];//
		$data['created']       = date("Y-m-d H:i:s");
		$data['modified']       = date("Y-m-d H:i:s");
		$res = $this->db->table("hall_booking")->insert($data);
		//$whatsapp_resp = whatsapp_aisensy($data['mobile_number'], [], 'success_message1');
		if($res){
			$id = $this->db->insertID();
			if(!empty($_POST['service']))
			{
				foreach($_POST['service'] as $row){
					$packdata['hall_booking_id']  = $id;
					$packdata['service_id'] = $row['service_id'];
					$packdata['service_name']     = $row['service_name'];
					$packdata['service_description'] = $row['description'];
					$packdata['service_amount'] = $row['service_amt'];
					$packdata['created']     = date("Y-m-d H:i:s");
					$packdata['modified']     = date("Y-m-d H:i:s");
					$this->db->table("hall_booking_service_details")->insert($packdata);
				}
			}
			$final_amount = $_POST['total_amt'];
			$paydata['hall_booking_id'] = $id;
			$paydata['date'] = $data['entry_date'];
			$paydata['amount'] = $final_amount;
			$paydata['payment_mode'] = 5;
			$paydata['created'] = date("Y-m-d H:i:s");
			$paydata['updated'] = date("Y-m-d H:i:s");
			$this->db->table("hall_booking_pay_details")->insert($paydata);
			if(!empty($_POST['timing'])){  
				foreach($_POST['timing'] as $key => $value) { 
					$slotdata['hall_booking_id'] = $id;
					$slotdata['booking_slot_id'] = $value;
					$this->db->table("hall_booking_slot_details")->insert($slotdata);
				}
			}
			$payment_gateway_data = array();
			$payment_gateway_data['hall_booking_id'] = $id;
			$payment_gateway_data['pay_method'] = $pay_method;
			$this->db->table('hall_booking_payment_gateway_datas')->insert($payment_gateway_data);
			$hall_payment_gateway_id = $this->db->insertID();
			//if($data['payment_status'] == 2) $this->account_migration($id);
			$msg_data['succ'] = 'Hall Booking Added Successfully';
			$msg_data['id'] = $id;
		}else{
			//$this->session->setFlashdata('fail', 'Please Try Again');
			$msg_data['err'] = 'Please Try Again';
		}
      	echo json_encode($msg_data);
      	exit();
    }
	public function payment_process($hall_book_id) {
		if(!empty($hall_book_id)){
			include_once FCPATH . 'app/Libraries/ipay88-master/IPay88.class.php';
			$hall_booking = $this->db->table('hall_booking')->where('id', $hall_book_id)->get()->getRowArray();
			$email = 'dd@ipay88.com.my';
			$description='Hall';
			$final_amt = $hall_booking['total_amount'];
			$MerchantCode = 'M01236';
			$MerchantKey = 'HQgUUZLVzg';
			$ref_no = 'HALL_' . $hall_book_id;
			$refno_pay = $hall_book_id;
			$module = 'Hall';
			$final_amount = '1.00';
			$final_amt_str = '10000';
			$ipay88 = new \IPay88($MerchantCode);
			$ipay88->setMerchantKey($MerchantKey);
			$ipay88->setField('PaymentId', 16);
			$ipay88->setField('RefNo', $refno_pay);
			$ipay88->setField('Amount', $final_amount);
			$ipay88->setField('Currency', 'MYR');
			$ipay88->setField('ProdDesc', $description);
			$ipay88->setField('UserName', 'Prithivi');
			$ipay88->setField('UserEmail', $email);
			$ipay88->setField('UserContact', '9856734562');
			$ipay88->setField('Remark', $description);
			$ipay88->setField('Lang', 'utf-8');
			$ipay88->setField('ResponseURL',  base_url() . '/online_hallbooking/ipay88_online_response');
			//$ipay88->setField('BackendURL',  base_url() . '/online_hallbooking/ipay88_online_response');
			$ipay88->generateSignature();
			$ipay88_fields = $ipay88->getFields();
			$data['ipay88_fields'] = $ipay88_fields;
			$data['epayment_url'] = \Ipay88::$epayment_url;
			$data['title'] = "Hall Payment Process";
			$view_file = 'website/ipay88/ipay_merch_online_process';
			echo view($view_file, $data);
		}
	}
	public function ipay88_online_response() {
		include_once FCPATH . 'app/Libraries/ipay88-master/IPay88.class.php';
		$MerchantCode = 'M01236';
		$MerchantKey = 'HQgUUZLVzg';
		$ipay88 = new \IPay88($MerchantCode);
		$ipay88->setMerchantKey($MerchantKey);
		$response = $ipay88->getResponse();
		$hall_book_id = $response['data']['RefNo'];
		//print_r($response);
		$hall_booking_payment_gateway_datas = $this->db->table('hall_booking_payment_gateway_datas')->where('hall_booking_id', $hall_book_id)->get()->getRowArray();
		$payment_gateway_up_data = array();
		$payment_gateway_up_data['response_data'] = json_encode($response);
		$this->db->table('hall_booking_payment_gateway_datas')->where('id', $hall_booking_payment_gateway_datas['id'])->update($payment_gateway_up_data);
		if($response['status']){
			$hall_booking_up_data = array();
			$hall_booking_up_data['payment_status'] = 2;
			$this->db->table('hall_booking')->where('id', $hall_book_id)->update($hall_booking_up_data);
			$this->account_migration($hall_book_id);
			//$this->session->setFlashdata('succ', 'Hall Booking Successfully');
			$redirect_url = base_url() . '/online_hallbooking/print_booking/' .$hall_book_id;
			header('Location: ' . $redirect_url);
			exit;
		}else{
			$hall_booking_up_data = array();
			$hall_booking_up_data['payment_status'] = 3;
			$this->db->table('hall_booking')->where('id', $hall_book_id)->update($hall_booking_up_data);
			//$this->session->setFlashdata('fail', 'Payment Failed');
			$redirect_url = base_url() . '/online_hallbooking/payment_failed';
			header('Location: ' . $redirect_url);
			exit;
		}
	}
	public function payment_failed(){
		echo view('website/payment_failed');
	}
	public function account_migration($hall_booking_id){
		$hall_booking = $this->db->table("hall_booking")->where("id", $hall_booking_id)->get()->getRowArray();
		if($hall_booking['paid_through'] == 'ONLINE'){
			$date = explode('-', $hall_booking['event_date']);
			$yr = $date[0];
			$mon = $date[1];
			$td_ledger = $this->db->table('ledgers')->where('name', 'TRADE RECEIVABLE')->where('group_id', 3)->where('left_code', '3000')->get()->getRowArray();
			if(!empty($td_ledger)){
				$cr_id1 = $td_ledger['id'];
			}else{
				$cled1['group_id'] = 3;
				$cled1['name'] = 'TRADE RECEIVABLE';
				$cled1['code'] = '3000/000';
				$cled1['op_balance'] = '0';
				$cled1['op_balance_dc'] = 'D';
				$cled1['left_code'] = '3000';
				$cled1['right_code'] = '000';
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
				$sls1['added_by'] = $hall_booking['entry_by'];
				$led_ins1 = $this->db->table('groups')->insert($sls1);
				$sls_id = $this->db->insertID();
			}
			$hall_booking_service_details = $this->db->table("hall_booking_service_details")->join('service', 'hall_booking_service_details.service_id = service.id')->select('hall_booking_service_details.*, service.ledger_id')->where("hall_booking_service_details.hall_booking_id", $hall_booking_id)->get()->getResultArray();
			if (count($hall_booking_service_details) > 0) {
				$over_all_tot_amt = 0;
				foreach ($hall_booking_service_details as $row)
					$over_all_tot_amt += (float) $row['service_amount'];
				$number1 = $this->db->table('entries')->select('number')->where('entrytype_id', 4)->orderBy('id', 'desc')->get()->getRowArray();
				if (empty($number1))
					$num1 = 1;
				else
					$num1 = $number1['number'] + 1;
				// Get Entry Code
				$qry1 = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='" . $yr . "' and entrytype_id =4 and month (date)='" . $mon . "')")->getRowArray();
	
				$entries1['entry_code'] = 'JOR' . date('y', strtotime($hall_booking['entry_date'])) . $mon . (sprintf("%05d", (((float) substr($qry1['entry_code'], -5)) + 1)));
				$entries1['entrytype_id'] = '4';
				$entries1['number'] = $num1;
				$entries1['date'] = $hall_booking['entry_date'];
				$entries1['dr_total'] = $over_all_tot_amt;
				$entries1['cr_total'] = $over_all_tot_amt;
				$entries1['narration'] = 'Hall Booking(' . $hall_booking['ref_no'] . ')' . "\n" . 'name:' . $hall_booking['name'] . "\n" . 'NRIC:' . $hall_booking['ic_no'] . "\n" . 'email:' . $hall_booking['email'] . "\n";
				$entries1['inv_id'] = $hall_booking_id;
				$entries1['type'] = 8;
				$entries1['paid_through'] = 'ONLINE';
				$entries1['entry_by'] = $hall_booking['entry_by'];
				//Insert Entries
				$ent = $this->db->table('entries')->insert($entries1);
				$en_id1 = $this->db->insertID();
				if (!empty($en_id1)) {
					foreach ($hall_booking_service_details as $row) {
						$hallbooking_details = $this->db->table('service')->where('id', $row['service_id'])->get()->getRowArray();
						if(!empty($hallbooking_details['ledger_id'])){
							$led_hall_book_id = $hallbooking_details['ledger_id'];
						}else{
							$ledger1 = $this->db->table('ledgers')->where('name', 'All Incomes')->where('group_id', $sls_id)->get()->getRowArray();
							if(!empty($ledger1)){
								$led_hall_book_id = $ledger1['id'];
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
								$led_hall_book_id = $this->db->insertID();
							}
						}
						// Hall Booking => Credit
						$eitems_hall_book['entry_id'] = $en_id1;
						$eitems_hall_book['ledger_id'] = $led_hall_book_id;
						$eitems_hall_book['amount'] = $row['service_amount'];
						$eitems_hall_book['dc'] = 'C';
						$eitems_hall_book['details'] = 'Amount for' . $row['service_name'] . '(' . $hall_booking['ref_no'] . ')';
						$this->db->table('entryitems')->insert($eitems_hall_book);
						//  Trade Debtors => Debit 
						$eitems_cash_led['entry_id'] = $en_id1;
						$eitems_cash_led['ledger_id'] = $cr_id1;
						$eitems_cash_led['amount'] = $row['service_amount'] . '(' . $hall_booking['ref_no'] . ')';
						$eitems_cash_led['dc'] = 'D';
						$eitems_cash_led['details'] = 'Amount for' . $row['service_name'];
						$this->db->table('entryitems')->insert($eitems_cash_led);
					}
				}
			}
			$hall_booking_pay_details = $this->db->table("hall_booking_pay_details")->where("hall_booking_id", $hall_booking_id)->get()->getResultArray();
			if(count($hall_booking_pay_details) > 0){
				foreach($hall_booking_pay_details as $row){
					$paymentmode = $this->db->table('payment_mode')->where('id',$row['payment_mode'])->get()->getRowArray();
					if(!empty($paymentmode['ledger_id'])){
						$number = $this->db->table('entries')->select('number')->where('entrytype_id',1)->orderBy('id','desc')->get()->getRowArray(); 
						if(empty($number)) $num = 1;
						else $num = $number['number'] + 1;
						// Get Entry Code
						$qry   = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='". $yr ."' and entrytype_id =1 and month (date)='". $mon ."')")->getRowArray();
						if(count($qry) > 0){
							$max_entry = $qry[0];
							$entries['entry_code'] = 'REC' .date('y',strtotime($hall_booking['entry_date'])).$mon. (sprintf("%05d",(((float)  substr($max_entry['entry_code'],-5))+1)));
						}
						else{
							$entries['entry_code'] = 'REC' .date('y',strtotime($hall_booking['entry_date'])).$mon. (sprintf("%05d", 1));
						}
						$entries['entrytype_id'] = '1';
						$entries['number'] 		 = $num;
						$entries['date'] 		 = date("Y-m-d");					
						$entries['dr_total'] 	 = $row['amount'];
						$entries['cr_total'] 	 = $row['amount'];						
						$entries['narration'] 	 = 'Hall Booking(' . $hall_booking['ref_no'] . ')' . "\n" . 'name:' . $hall_booking['ref_no'] . "\n" . 'NRIC:' . $hall_booking['ic_no'] . "\n" . 'email:' . $hall_booking['email'] . "\n";
						$entries['inv_id']		 = $id;
						$entries['type']		 = 8;
						$entries['paid_through'] = 'ONLINE';
						$entries['entry_by'] = $hall_booking['entry_by'];
						//Insert Entries
						$ent = $this->db->table('entries')->insert($entries);
						$en_id = $this->db->insertID();
						if(!empty($en_id)){
							// Trade Debtors => Credit
							$eitems_hall_book1['entry_id'] = $en_id;
							$eitems_hall_book1['ledger_id'] = $cr_id1;
							$eitems_hall_book1['amount'] = $row['amount'];
							$eitems_hall_book1['dc'] = 'C'; 
							$eitems_hall_book1['details'] = 'Hall Booking Amount'. '(' . $hall_booking['ref_no'] . ')'; 
							$this->db->table('entryitems')->insert($eitems_hall_book1);
							// PETTY CASH => Debit 
							$eitems_cash_led1['entry_id'] = $en_id;
							$eitems_cash_led1['ledger_id'] = $paymentmode['ledger_id'];
							$eitems_cash_led1['amount'] = $row['amount'];					
							$eitems_cash_led1['dc'] = 'D';
							$eitems_cash_led1['details'] = 'Hall Booking Amount'. '(' . $hall_booking['ref_no'] . ')'; 
							$this->db->table('entryitems')->insert($eitems_cash_led1);
						}
					}
				}
			}
		}
		
	}
	public function print_booking($hall_booking_id){
		$id = $this->request->uri->getSegment(3);
	   	$data['qry1'] = $hall_booking = $this->db->table('hall_booking')->where('id', $id)->get()->getRowArray();
	   	$view_file = 'website/hallbooking/print';
	   	if($hall_booking['paid_through'] == 'ONLINE'){
		   	if($hall_booking['payment_status'] == '2'){
			   	$tmpid = 1;
			   	$data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
			   	$data['hall_booking_slot_details'] = $this->db->table("hall_booking_slot_details")->select('hall_booking_slot_details.*, CONCAT(booking_slot.name,\'-\',booking_slot.description) as slot_time')->join('booking_slot', 'booking_slot.id = hall_booking_slot_details.booking_slot_id')->where("hall_booking_slot_details.hall_booking_id", $id)->get()->getResultArray();
			   
			   	$data['hall_booking_details'] = $this->db->table("hall_booking_details")->select('hall_booking_details.*, booking_addonn.name')->join('booking_addonn', 'booking_addonn.id = hall_booking_details.booking_addon_id')->where("hall_booking_details.hall_booking_id", $id)->get()->getResultArray();
			   	echo view($view_file, $data);
		  	}
	   	}else{
		   $tmpid = 1;
		   $data['temp_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
		   $data['hall_booking_slot_details'] = $this->db->table("hall_booking_slot_details")->select('hall_booking_slot_details.*, CONCAT(booking_slot.name,\'-\',booking_slot.description) as slot_time')->join('booking_slot', 'booking_slot.id = hall_booking_slot_details.booking_slot_id')->where("hall_booking_slot_details.hall_booking_id", $id)->get()->getResultArray();
			   
		   $data['hall_booking_details'] = $this->db->table("hall_booking_details")->select('hall_booking_details.*, booking_addonn.name')->join('booking_addonn', 'booking_addonn.id = hall_booking_details.booking_addon_id')->where("hall_booking_details.hall_booking_id", $id)->get()->getResultArray();
		   echo view($view_file, $data);
	   	}
	}
}	
