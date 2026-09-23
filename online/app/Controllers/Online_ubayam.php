<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Online_ubayam extends BaseController
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
		$data['date'] = $date;
		$data['phone_codes'] = $this->db->table("phone_code")->orderBy('dailing_code', 'ASC')->get()->getResultArray();
        echo view('website/layout/header');
        echo view('website/ubayambooking', $data);
        echo view('website/layout/footer');
    }
	public function get_booking_ubhayam()
	{
		//$cemetryid = $_POST['cemetryid'];
		//->where("id", 5)
		$ubhayamdate = $_POST['ubhayamdate'];
		$selected_row = $this->db->table("ubayam")->select('ubayam.pay_for')
			->join('ubayam_setting', 'ubayam_setting.id = ubayam.pay_for', 'left')
			->where("ubayam.dt", $ubhayamdate)->get()->getRowArray();
		$selected_row_slot = $selected_row['pay_for'];
		$ress = $this->db->table("ubayam")->select('ubayam.pay_for')
			->join('ubayam_setting', 'ubayam_setting.id = ubayam.pay_for', 'left')
			->where("ubayam.dt", $ubhayamdate)
			->get()->getResultArray();
		$ubhyams = array();
		$implode_arry = array();
		foreach ($ress as $row) {
			$ubhyams[] = $row['pay_for'];
		}
		$ubhayam_bookings = $this->db->table('ubayam_setting')->get()->getResultArray();
		$html = "<option value='' >--Select Ubayam--</option>";
		foreach ($ubhayam_bookings as $ubhayam_booking) {
			if (is_array($ubhyams) && in_array($ubhayam_booking['id'], $ubhyams)) {
				//$selected = "selected";
				if ($ubhayam_booking['event_type'] == 1) {
					$disabled = "disabled";
				} else {
					$disabled = "";
				}
			} else {
				$disabled = "";
				$selected = "";
			}
			$html .= '<option value=' . $ubhayam_booking['id'] . ' ' . $disabled . ' ' . $selected . ' >' . $ubhayam_booking['name'] . '</option>';
		}
		echo $html;
	}
	public function get_payfor_collection()
	{
		$id = $_POST['id'];
		$res = $this->db->table('ubayam_setting')->where('id', $id)->get()->getRowArray();
		$data['target_amount'] = $res['amount'];
		$data['balanceamt'] = $res['amount'];
		$res = $this->db->table('ubayam')->select('id')->where('pay_for', $id)->get()->getResultArray();
		$data['totalamt'] = 0;
		$data['collection'] = 0;
		if (count($res)) {
			foreach ($res as $row) {
				$array[] = $row['id'];
			}
			$pid = implode(',', $array);
			$res1 = $this->db->query("select sum(amount) as totalamt from `ubayam` where id in ($pid)")->getRowArray();
			$res2 = $this->db->query("select sum(amount) as collection from `ubayam_pay_details` where ubayam_id in ($pid)")->getRowArray();
			$data['totalamt'] = number_format($res1['totalamt'], 2, '.', ',');
			$data['collection'] = number_format($res2['collection'], 2, '.', ',');
			$balance = $data['target_amount'] - $res2['collection'];
			if ($balance > 0)
				$data['balanceamt'] = number_format($balance, 2, '.', ',');
			else
				$data['balanceamt'] = 0;
		}
		echo json_encode($data);
	}
	public function save_booking()
	{
		$msg_data = array();
		$msg_data['err'] = '';
		$msg_data['succ'] = '';
		$date = explode('-', $_POST['ubhayam_date']);
		$yr = $date[0];
  		$mon = $date[1];
		$ubyam_set_amt =  $this->db->table('ubayam_setting')->where('id',$_POST['pay_for'])->get()->getRowArray();
		$amt = !empty($ubyam_set_amt['amount']) ? $ubyam_set_amt['amount'] : 0;
		$balanceamount = $amt - $_POST['total_amt'];
		$query   = $this->db->query("SELECT ref_no FROM ubayam where id=(select max(id) from ubayam where year (dt)='". $yr ."' and month (dt)='". $mon ."')")->getRowArray();
		$data['ref_no']= 'UB' .date('y').$mon. (sprintf("%05d",(((float)  substr($query['ref_no'],-5))+1)));
        $data['dt']		 	 	=	$_POST['ubhayam_date'];
		$data['pay_for']	 	=	trim($_POST['pay_for']);
		$data['name']		 	=	trim($_POST['name']);
		$data['address']	 	=	trim($_POST['address']);
		$data['email']	 	=	trim($_POST['email']);
		$data['ic_number']	 	=	trim($_POST['ic_num']);
		$mble_phonecode = !empty($_POST['phonecode'])?$_POST['phonecode']:"";
      	$mble_number = !empty($_POST['mobile'])?$_POST['mobile']:"";
		$data['mobile']  = $mble_phonecode.$mble_number;
		$data['description'] 	=	trim($_POST['description']);
		$data['amount']		 	=	$amt;
		$data['paidamount'] 	=	trim($_POST['total_amt']);
		$data['balanceamount']	=	$balanceamount;
		$data['paid_through'] = "ONLINE";
		$pay_method       =	'ipay_online';
		$data['payment_status'] =   1;
		$data['added_by']	 	=	$_POST['user_login_id'];;
		$data['created_at']  =	date('Y-m-d H:i:s');
		$data['modified_at'] = date('Y-m-d H:i:s');
		$res = $this->db->table('ubayam')->insert($data);
		if($res){
			$ins_id = $this->db->insertID();
			$pays['ubayam_id'] 	= $ins_id;
			$pays['date'] 		= date("Y-m-d");
			$pays['amount'] 	= $data['amount'];
			$this->db->table('ubayam_pay_details')->insert($pays);
			if(!empty($_POST['familly']))
			{
				foreach($_POST['familly'] as $row_fam){
					$fmys['ubayam_id'] 	= $ins_id;
					$fmys['name'] 		= $row_fam['name'];
					$fmys['icno'] 	= $row_fam['icno'];
					$fmys['relationship'] 	= $row_fam['relationship'];
					$this->db->table('ubayam_family_details')->insert($fmys);
				}
			}
			$payment_gateway_data = array();
			$payment_gateway_data['ubayam_id'] = $ins_id;
			$payment_gateway_data['pay_method'] = $pay_method;
			$this->db->table('ubayam_payment_gateway_datas')->insert($payment_gateway_data);
			$ubayam_payment_gateway_id = $this->db->insertID();
			//if($data['payment_status'] == 2) $this->account_migration($ins_id);

			$msg_data['succ'] = 'Ubayam Added Successflly';
			$msg_data['id'] = $ins_id;
		}else{
			$this->session->setFlashdata('fail', 'Please Try Again');
			$msg_data['err'] = 'Please Try Again';
		}
		echo json_encode($msg_data);
		exit();
    }
	public function payment_process($ubayam_id) {
		if(!empty($ubayam_id)){
			include_once FCPATH . 'app/Libraries/ipay88-master/IPay88.class.php';
			$ubayam_booking = $this->db->table('ubayam')->where('id', $ubayam_id)->get()->getRowArray();
			$email = 'dd@ipay88.com.my';
			$description='Ubayam';
			$final_amt = $ubayam_booking['amount'];
			$MerchantCode = 'M01236';
			$MerchantKey = 'HQgUUZLVzg';
			$ref_no = 'UBAYAM_' . $ubayam_id;
			$refno_pay = $ubayam_id;
			$module = 'Ubayam';
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
			$ipay88->setField('ResponseURL',  base_url() . '/online_ubayam/ipay88_online_response');
			$ipay88->generateSignature();
			$ipay88_fields = $ipay88->getFields();
			$data['ipay88_fields'] = $ipay88_fields;
			$data['epayment_url'] = \Ipay88::$epayment_url;
			$data['title'] = "Ubayam Payment Process";
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
		$ubayam_id = $response['data']['RefNo'];
		//print_r($response);
		$ubayam_payment_gateway_datas = $this->db->table('ubayam_payment_gateway_datas')->where('ubayam_id', $ubayam_id)->get()->getRowArray();
		$payment_gateway_up_data = array();
		$payment_gateway_up_data['response_data'] = json_encode($response);
		$this->db->table('ubayam_payment_gateway_datas')->where('id', $ubayam_payment_gateway_datas['id'])->update($payment_gateway_up_data);
		if($response['status']){
			$ubayam_booking_up_data = array();
			$ubayam_booking_up_data['payment_status'] = 2;
			$this->db->table('ubayam')->where('id', $ubayam_id)->update($ubayam_booking_up_data);
			$this->account_migration($ubayam_id);
			//$this->session->setFlashdata('succ', 'Ubayam Booking Successfully');
			$redirect_url = base_url() . '/online_ubayam/print_booking/' .$ubayam_id;
			header('Location: ' . $redirect_url);
			exit;
		}else{
			$ubayam_booking_up_data = array();
			$ubayam_booking_up_data['payment_status'] = 3;
			$this->db->table('ubayam')->where('id', $ubayam_id)->update($ubayam_booking_up_data);
			//$this->session->setFlashdata('fail', 'Payment Failed');
			$redirect_url = base_url() . '/online_ubayam/payment_failed';
			header('Location: ' . $redirect_url);
			exit;
		}
	}
	public function payment_failed(){
		echo view('website/payment_failed');
	}
	public function account_migration($ubayam_id){
		$ubayam = $this->db->table('ubayam')->where('id', $ubayam_id)->get()->getRowArray();
		if($ubayam['paid_through'] == 'ONLINE'){
			 $ubayam_payment_gateway_datas = $this->db->table('ubayam_payment_gateway_datas')->where('ubayam_id', $ubayam_id)->get()->getRowArray();
			if($ubayam_payment_gateway_datas['pay_method'] == 'cash') $payment_id = 6; ////  goto cash Ledger
			elseif($ubayam_payment_gateway_datas['pay_method'] == 'ipay_online') $payment_id = 5; ////  goto online Ledger
			else $payment_id = 4; ////  goto Qr or Online Payment Ledger
			$payment_mode_details = $this->db->table('payment_mode')->where('id', $payment_id)->get()->getRowArray();
			if(empty($payment_mode_details['id'])) $payment_mode_details = $this->db->table('payment_mode')->get()->getRowArray();
			$sales_group = $this->db->table('groups')->where('code', '4000')->get()->getRowArray();
			if(!empty($sales_group)){
				$sls_id = $sales_group['id'];
			}else{
				$sls1['parent_id'] = 0;
				$sls1['name'] = 'Sales';
				$sls1['code'] = '4000';
				$sls1['added_by'] = $ubayam['added_by'];
				$led_ins1 = $this->db->table('groups')->insert($sls1);
				$sls_id = $this->db->insertID();
			}
			$ubayam_setting = $this->db->table('ubayam_setting')->where('id', $ubayam['pay_for'])->get()->getRowArray();
			$ubayam_name = $ubayam_setting['name'];
			if(!empty($ubayam_setting['ledger_id'])){
				$dr_id = $ubayam_setting['ledger_id'];
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
			$ubayam_pay_details = $this->db->table('ubayam_pay_details')->where('ubayam_id', $ubayam_id)->get()->getResultArray();
			foreach($ubayam_pay_details as $upd){
				$cr_id = $payment_mode_details['ledger_id'];
				$number = $this->db->table('entries')->select('number')->where('entrytype_id',1)->orderBy('id','desc')->get()->getRowArray(); 
				if(empty($number)) {
					$num = 1;
				} else {
					$num = $number['number'] + 1;
				}
				$date = explode('-', date("Y-m-d", strtotime($upd['date'])));
				$yr = date("Y",strtotime($upd['date']));
				$mon = date("m",strtotime($upd['date']));
				$qry   = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='". $yr ."' and entrytype_id =1 and month (date)='". $mon ."')")->getRowArray();
				if(count($qry) > 0){
					$max_entry = $qry[0];
					$entries['entry_code'] = 'REC' .date('y',strtotime($upd['date'])).$mon. (sprintf("%05d",(((float)  substr($max_entry['entry_code'],-5))+1)));
				}
				else{
					$entries['entry_code'] = 'REC' .date('y',strtotime($upd['date'])).$mon. (sprintf("%05d", 1));
				}
				$entries['entrytype_id'] = '1';
				$entries['number'] 		 = $num;
				$entries['date'] 		 = date("Y-m-d", strtotime($upd['date'])); 
				$entries['dr_total'] 	 = $upd['amount'];
				$entries['cr_total'] 	 = $upd['amount'];
				$entries['narration'] 	 = 'Ubayam(' . $ubayam['ref_no'] . ')' . "\n" . 'name:' . $ubayam['name'] . "\n" . 'NRIC:' . $ubayam['ic_number'] . "\n" . 'email:' . $ubayam['email'] . "\n";
				$entries['inv_id']       = $ubayam_id;
				$entries['type']         = '1';
				$entries['paid_through'] = 'ONLINE';
				$entries['entry_by'] = $ubayam['added_by'];
				$ent = $this->db->table('entries')->insert($entries);
				$en_id = $this->db->insertID();
				
				if(!empty($en_id)){
					$ent_id[] = $en_id;
					$eitems_d['entry_id'] = $en_id;
					$eitems_d['ledger_id'] = $dr_id;
					$eitems_d['amount'] = $upd['amount'];
					$eitems_d['details'] = 'Ubayam(' . $ubayam['ref_no'] . ')';
					$eitems_d['dc'] = 'C';
					$cr_res = $this->db->table('entryitems')->insert($eitems_d);

					$eitems_c['entry_id'] = $en_id;
					$eitems_c['ledger_id'] = $cr_id;
					$eitems_c['amount'] = $upd['amount'];
					$eitems_c['details'] = 'Ubayam(' . $ubayam['ref_no'] . ')';
					$eitems_c['dc'] = 'D';
					$deb_res = $this->db->table('entryitems')->insert($eitems_c);
				}
			}
		 }
	}
	public function print_booking($ubayam_id){
		$id = $this->request->uri->getSegment(3);
	  	$data['qry1'] = $ubayam = $this->db->table('ubayam')
					   ->join('ubayam_setting', 'ubayam_setting.id = ubayam.pay_for')
					   ->select('ubayam_setting.name as uname')
					   ->select('ubayam.*')
					   ->where('ubayam.id', $id)
					   ->get()->getRowArray();
	   	$view_file = 'website/ubayam/print_page';
	   	if($ubayam['paid_through'] == 'ONLINE'){
		   if($ubayam['payment_status'] == '2'){
			   $tmpid = 1;
			   $data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
			   $data['payment'] 	= $this->db->table('ubayam_pay_details')->where('ubayam_id', $id)->get()->getResultArray();
			   $data['terms'] =  $this->db->table("terms_conditions")->get()->getRowArray();
			   $data['pay_details'] = $this->db->table("ubayam_pay_details")->where("ubayam_id", $id)->get()->getResultArray();
			   echo view($view_file, $data);
		   }
	   }else{
		   $data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
		   $data['payment'] 	= $this->db->table('ubayam_pay_details')->where('ubayam_id', $id)->get()->getResultArray();
		   $data['terms'] =  $this->db->table("terms_conditions")->get()->getRowArray();
		   $data['pay_details'] = $this->db->table("ubayam_pay_details")->where("ubayam_id", $id)->get()->getResultArray();
		   echo view($view_file, $data);
	   }
   	}

	
}	
