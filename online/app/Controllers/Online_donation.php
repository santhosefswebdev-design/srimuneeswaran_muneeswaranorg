<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Online_donation extends BaseController
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
		$data['donation_setting'] = $this->db->table('donation_setting')->get()->getResultArray();
        echo view('website/layout/header');
        echo view('website/donationbooking', $data);
        echo view('website/layout/footer');
    }
	public function save_booking()
	{
		$msg_data = array();
		$msg_data['err'] = '';
		$msg_data['succ'] = '';
		$date = explode('-', $_POST['donation_date']);
		$yr = $date[0];
  		$mon = $date[1];
		$query   = $this->db->query("SELECT ref_no FROM donation where id=(select max(id) from donation where year (date)='". $yr ."' and month (date)='". $mon ."')")->getResultArray();
		if(count($query) > 0){
			$max_entry = $query[0];
			if(!empty($max_entry['ref_no'])) $data['ref_no'] = 'DO' .date('y').$mon. (sprintf("%05d",(((float)  substr($max_entry['ref_no'],-5))+1)));
			else  $data['ref_no'] = 'DO' .date('y').$mon. (sprintf("%05d", 1));
		}else  $data['ref_no'] = 'DO' .date('y').$mon. (sprintf("%05d", 1));
        $data['date']		 	 	=	$_POST['donation_date'];
		$data['pay_for']	 	=	trim($_POST['pay_for']);
		$data['name']		 	=	trim($_POST['name']);
		$data['address']	 	=	trim($_POST['address']);
		$data['email']	 	=	trim($_POST['email']);
		$data['ic_number']	 	=	trim($_POST['ic_num']);
		$mble_phonecode = !empty($_POST['phonecode'])?$_POST['phonecode']:"";
      	$mble_number = !empty($_POST['mobile'])?$_POST['mobile']:"";
		$data['mobile']  = $mble_phonecode.$mble_number;
		$data['description'] 	=	trim($_POST['description']);
		$data['amount']		 	=	trim($_POST['total_amt']);
		$data['target_amount'] 	=	"0.00";
		$data['collected_amount']	=	"0.00";
		$data['paid_through'] = "ONLINE";
		$pay_method       =	'ipay_online';
		$data['payment_status'] =   1;
		$data['added_by']	 	=	$_POST['user_login_id'];;
		$data['created']  =	date('Y-m-d H:i:s');
		$data['modified'] = date('Y-m-d H:i:s');
		$res = $this->db->table('donation')->insert($data);
		if($res){
			$ins_id = $this->db->insertID();
			$payment_gateway_data = array();
			$payment_gateway_data['donation_booking_id'] = $ins_id;
			$payment_gateway_data['pay_method'] = $pay_method;
			$this->db->table('donation_payment_gateway_datas')->insert($payment_gateway_data);
			$donation_payment_gateway_id = $this->db->insertID();
			//if($data['payment_status'] == 2) $this->account_migration($ins_id);
			$msg_data['succ'] = 'Donation Added Successflly';
			$msg_data['id'] = $ins_id;
		}else{
			$this->session->setFlashdata('fail', 'Please Try Again');
			$msg_data['err'] = 'Please Try Again';
		}
		echo json_encode($msg_data);
		exit();
    }
	public function payment_process($donation_id) {
		if(!empty($donation_id)){
			include_once FCPATH . 'app/Libraries/ipay88-master/IPay88.class.php';
			$donation_booking = $this->db->table('donation')->where('id', $donation_id)->get()->getRowArray();
			$email = 'dd@ipay88.com.my';
			$description='Donation';
			$final_amt = $donation_booking['amount'];
			$MerchantCode = 'M01236';
			$MerchantKey = 'HQgUUZLVzg';
			$ref_no = 'DONATION_' . $donation_id;
			$refno_pay = $donation_id;
			$module = 'Donation';
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
			$ipay88->setField('ResponseURL',  base_url() . '/online_donation/ipay88_online_response');
			$ipay88->generateSignature();
			$ipay88_fields = $ipay88->getFields();
			$data['ipay88_fields'] = $ipay88_fields;
			$data['epayment_url'] = \Ipay88::$epayment_url;
			$data['title'] = "Donation Payment Process";
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
		$donation_id = $response['data']['RefNo'];
		//print_r($response);
		$donation_payment_gateway_datas = $this->db->table('donation_payment_gateway_datas')->where('donation_booking_id', $donation_id)->get()->getRowArray();
		$payment_gateway_up_data = array();
		$payment_gateway_up_data['response_data'] = json_encode($response);
		$this->db->table('donation_payment_gateway_datas')->where('id', $donation_payment_gateway_datas['id'])->update($payment_gateway_up_data);
		if($response['status']){
			$donation_booking_up_data = array();
			$donation_booking_up_data['payment_status'] = 2;
			$this->db->table('donation')->where('id', $donation_id)->update($donation_booking_up_data);
			$this->account_migration($donation_id);
			//$this->session->setFlashdata('succ', 'Donation Booking Successfully');
			$redirect_url = base_url() . '/online_donation/print_booking/' .$donation_id;
			header('Location: ' . $redirect_url);
			exit;
		}else{
			$donation_booking_up_data = array();
			$donation_booking_up_data['payment_status'] = 3;
			$this->db->table('donation')->where('id', $donation_id)->update($donation_booking_up_data);
			//$this->session->setFlashdata('fail', 'Payment Failed');
			$redirect_url = base_url() . '/online_donation/payment_failed';
			header('Location: ' . $redirect_url);
			exit;
		}
	}
	public function payment_failed(){
		echo view('website/payment_failed');
	}
	public function account_migration($donation_id){
		$donation = $this->db->table('donation')
							->join('donation_setting', 'donation_setting.id = donation.pay_for')
							->select('donation_setting.name as pname, donation_setting.donation_cat_id')
							->select('donation.*')
							->where('donation.id', $donation_id)
							->get()
							->getRowArray();
		if($donation['paid_through'] == 'ONLINE'){
			 $donation_payment_gateway_datas = $this->db->table('donation_payment_gateway_datas')->where('donation_booking_id', $donation_id)->get()->getRowArray();
			if($donation_payment_gateway_datas['pay_method'] == 'cash') $payment_id = 6; ////  goto cash Ledger
			elseif($donation_payment_gateway_datas['pay_method'] == 'ipay_online') $payment_id = 5; ////  goto online Ledger
			else $payment_id = 4; ////  goto Qr or Online Payment Ledger
			$payment_mode_details = $this->db->table('payment_mode')->where('id', $payment_id)->get()->getRowArray();
			if(empty($payment_mode_details['id'])) $payment_mode_details = $this->db->table('payment_mode')->get()->getRowArray();
			$incomes_group = $this->db->table('groups')->where('code', '8000')->get()->getRowArray();
			if (!empty($incomes_group)) {
				$sls_id = $incomes_group['id'];
			} else {
				$sls1['parent_id'] = 0;
				$sls1['name'] = 'Incomes';
				$sls1['code'] = '8000';
				$sls1['added_by'] = $donation['added_by'];
				$this->db->table('groups')->insert($sls1);
				$sls_id = $this->db->insertID();
			}
			$donation_details = $this->db->table('donation_setting')->where('id', $donation['pay_for'])->get()->getRowArray();
			if(!empty($donation_details['ledger_id'])){
				$dr_id = $donation_details['ledger_id'];
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
			$donation_setting = $this->db->table('donation_setting')->where('id', $donation['pay_for'])->get()->getRowArray();
			$donation_category = $this->db->table('donation_category')->where('id', $donation_setting['donation_cat_id'])->get()->getRowArray();
			$number = $this->db->table('entries')->select('number')->where('entrytype_id', 1)->orderBy('id', 'desc')->get()->getRowArray();
			if (empty ($number)) {
				$num = 1;
			} else {
				$num = $number['number'] + 1;
			}
			$yr = date("Y",strtotime($donation['date']));
			$mon = date("m",strtotime($donation['date']));
			$qry = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='" . $yr . "' and entrytype_id =1 and month (date)='" . $mon . "')")->getRowArray();
			$entries['entry_code'] = 'REC' . date('y', strtotime($donation['date'])) . $mon . (sprintf("%05d", (((float) substr($qry['entry_code'], -5)) + 1)));
			$entries['entrytype_id'] = '1';
			$entries['number'] = $num;
			$entries['date'] = date("Y-m-d", strtotime($donation['date']));
			$entries['dr_total'] = $donation['amount'];
			$entries['cr_total'] = $donation['amount'];
			if (!empty ($donation_category['fund_id']))
				$entries['fund_id'] = $donation_category['fund_id'];
			$entries['narration'] = 'Cash Donation(' . $donation['ref_no'] . ')' . "\n" . 'name:' . $donation['name'] . "\n" . 'NRIC:' . $donation['ic_number'] . "\n" . 'email:' . $donation['email'] . "\n";
			$entries['inv_id'] = $donation_id;
			$entries['type'] = '2';
			$entries['paid_through'] = 'ONLINE';
			$entries['entry_by'] = $donation['added_by'];
			$ent = $this->db->table('entries')->insert($entries);
			$en_id = $this->db->insertID();
			if (!empty ($en_id)) {
				$eitems_d['entry_id'] = $en_id;
				$eitems_d['ledger_id'] = $dr_id;
				$eitems_d['amount'] = $donation['amount'];
				$eitems_d['details'] = 'Cash Donation(' . $donation['ref_no'] . ')';
				$eitems_d['dc'] = 'C';
				$this->db->table('entryitems')->insert($eitems_d);

				$eitems_c['entry_id'] = $en_id;
				$eitems_c['ledger_id'] = $payment_mode_details['ledger_id'];
				$eitems_c['details'] = 'Cash Donation(' . $donation['ref_no'] . ')';
				$eitems_c['amount'] = $donation['amount'];
				$eitems_c['dc'] = 'D';
				$this->db->table('entryitems')->insert($eitems_c);
			}
		}
	}
	public function print_booking($donation_id){
		$id = $this->request->uri->getSegment(3);
	  	$data['qry1'] = $donation = $this->db->table('donation')
					   ->join('donation_setting', 'donation_setting.id = donation.pay_for')
					   ->select('donation_setting.name as pname')
					   ->select('donation.*')
					   ->where('donation.id', $id)
					   ->get()->getRowArray();
	   	$view_file = 'website/donation/print_page';
	   	if($donation['paid_through'] == 'ONLINE'){
		   if($donation['payment_status'] == '2'){
			   $data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
			   $data['terms'] =  $this->db->table("terms_conditions")->get()->getRowArray();
			   echo view($view_file, $data);
		   }
	   }else{
		   $data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
		   $data['terms'] =  $this->db->table("terms_conditions")->get()->getRowArray();
		   echo view($view_file, $data);
	   }
   	}
	
	
}	
