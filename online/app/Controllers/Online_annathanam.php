<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Online_annathanam extends BaseController
{
	function __construct(){
        parent:: __construct();
        helper('url');
        helper('common_helper');
        //$this->model = new PermissionModel();
    }
	public function index()
	{
        $data['phone_codes'] = $this->db->table("phone_code")->orderBy('dailing_code', 'ASC')->get()->getResultArray();
		$data['annathanam_rice_category'] = $this->db->table('annathanam_rice_category')->where('status', 1)->get()->getResultArray();
		$data['annathanam_kuruma_type'] = $this->db->table('annathanam_kuruma_type')->get()->getResultArray();
		$data['annathanam_rice_type'] = $this->db->table('annathanam_rice_type')->where('status', 1)->get()->getResultArray();
		$data['annathanam_vegetables'] = $this->db->query("SELECT * FROM annathanam_vegetables  order by name_eng asc")->getResultArray();
		$yr=date('Y');
		$mon=date('m');
		$query   = $this->db->query("SELECT ref_no FROM annathanam where id=(select max(id) from annathanam where year (date)='". $yr ."' and month (date)='". $mon ."')")->getRowArray();
      	$data['bill_no']= 'AT' .date('y').$mon. (sprintf("%05d",(((float)  substr($query['ref_no'],-5))+1)));
        echo view('website/layout/header');
        echo view('website/annathanam', $data);
        echo view('website/layout/footer');
    }
    public function save_annathanam(){
		$msg_data = array();
		$msg_data['err'] = '';
		$msg_data['succ'] = '';
		if(!empty($_POST['vegetables'])){
			$annathan_veg_count = count($_POST['vegetables']);
		}
		else{
			$annathan_veg_count = 0;
		}
		$kuruma_check_count = $_POST['kuruma_id'];
		if($kuruma_check_count >= $annathan_veg_count)
      	{
			$msg_data['err'] = 'Please choose the type of vegetables.';
	  	}
		else{
			$yr= date('Y',strtotime($_POST['date'])) ;
			$mon= date('m',strtotime($_POST['date'])) ;
			$query   = $this->db->query("SELECT ref_no FROM annathanam where id=(select max(id) from annathanam where year (date)='". $yr ."' and month (date)='". $mon ."')")->getRowArray();
			$data['ref_no']= 'AT' .date('y',strtotime($_POST['date'])).$mon. (sprintf("%05d",(((float)  substr($query['ref_no'],-5))+1)));
			$data['date']			= date('Y-m-d',strtotime($_POST['date']));
			$data['name']       =	trim($_POST['name']);
			$data['phone_code']       =	trim($_POST['phone_code']);
			$data['phone_no']       =	trim($_POST['phone_no']);
			$data['slot_time']       =	$_POST['time'];
			$data['rice_category_id']       =	$_POST['rice_category'];
			$data['kuruma_id']       =	$_POST['kuruma_id'];
			$data['rice_type_id']       =	$_POST['rice_type_id'];
			$data['amount']       =	$_POST['amount'];
			$data['dob'] = $_POST['dob'];
			$data['no_of_pax']       =	$_POST['no_of_pax'];
			$data['total_amount']       =	$_POST['total_amount'];
			$data['payment_mode']       =	5;
			$data['paid_through'] = "ONLINE";
			$pay_method       =	'ipay_online';
            $data['payment_status'] =   1;
			$data['added_by']	 =	$_POST['user_login_id'];
			$data['created']      =	date('Y-m-d H:i:s');
			$res = $this->db->table('annathanam')->insert($data);
            if($res){
                $annathanam_id=$this->db->insertID();
                if(!empty($_POST['vegetables'])){
                    foreach ($_POST['vegetables'] as $vegetable) 
                    {
                        $data_vegetable['annathanam_id']	 =	$annathanam_id;
                        $data_vegetable['vegetable_id'] =   $vegetable['vegetble_id'];
                        $this->db->table('annathanam_item')->insert($data_vegetable);
                    } 
                }
                $payment_gateway_data = array();
                $payment_gateway_data['annathanam_booking_id'] = $annathanam_id;
                $payment_gateway_data['pay_method'] = $pay_method;
                $this->db->table('annathanam_payment_gateway_datas')->insert($payment_gateway_data);
                $msg_data['succ'] = 'Annadhanam added successflly';
                $msg_data['id'] = $annathanam_id;
            }
			else{
                $msg_data['err'] = 'Please Try Again';
            }
		}
		echo json_encode($msg_data);
		exit;
	}
    public function payment_process($annathanam_id) {
		if(!empty($annathanam_id)){
			include_once FCPATH . 'app/Libraries/ipay88-master/IPay88.class.php';
			$annathanam_booking = $this->db->table('annathanam')->where('id', $annathanam_id)->get()->getRowArray();
			$email = 'dd@ipay88.com.my';
			$description='Annadhanam';
			$final_amt = $annathanam_booking['total_amount'];
			$MerchantCode = 'M01236';
			$MerchantKey = 'HQgUUZLVzg';
			$ref_no = 'ANNADHANAM_' . $annathanam_id;
			$refno_pay = $annathanam_id;
			$module = 'Annadhanam';
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
			$ipay88->setField('ResponseURL',  base_url() . '/online_annathanam/ipay88_online_response');
			$ipay88->generateSignature();
			$ipay88_fields = $ipay88->getFields();
			$data['ipay88_fields'] = $ipay88_fields;
			$data['epayment_url'] = \Ipay88::$epayment_url;
			$data['title'] = "Annadhanam Payment Process";
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
		$annathanam_id = $response['data']['RefNo'];
		//print_r($response);
		$annathanam_payment_gateway_datas = $this->db->table('annathanam_payment_gateway_datas')->where('annathanam_booking_id', $annathanam_id)->get()->getRowArray();
		$payment_gateway_up_data = array();
		$payment_gateway_up_data['response_data'] = json_encode($response);
		$this->db->table('annathanam_payment_gateway_datas')->where('id', $annathanam_payment_gateway_datas['id'])->update($payment_gateway_up_data);
		if($response['status']){
			$annathanam_booking_up_data = array();
			$annathanam_booking_up_data['payment_status'] = 2;
			$this->db->table('annathanam')->where('id', $annathanam_id)->update($annathanam_booking_up_data);
			$this->account_migration($annathanam_id);
			//$this->session->setFlashdata('succ', 'Annadhanam Booking Successfully');
			$redirect_url = base_url() . '/online_annathanam/print_annathanam/' .$annathanam_id;
			header('Location: ' . $redirect_url);
			exit;
		}else{
			$annathanam_booking_up_data = array();
			$annathanam_booking_up_data['payment_status'] = 3;
			$this->db->table('annathanam')->where('id', $annathanam_id)->update($annathanam_booking_up_data);
			//$this->session->setFlashdata('fail', 'Payment Failed');
			$redirect_url = base_url() . '/online_annathanam/payment_failed';
			header('Location: ' . $redirect_url);
			exit;
		}
	}
	public function payment_failed(){
		echo view('website/payment_failed');
	}
    public function print_annathanam($id)
	{
		$id=  $this->request->uri->getSegment(3);
	    $data['data'] = $this->db->table('annathanam')->where('id', $id)->get()->getRowArray();
		$tmpid = 1;
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
		$data['annathanam_items'] = $this->db->table('annathanam_item')
											->join('annathanam_vegetables','annathanam_vegetables.id = annathanam_item.vegetable_id')
											->select('annathanam_vegetables.name_eng,annathanam_vegetables.name_tamil')
											->where('annathanam_item.annathanam_id', $id)
											->get()
											->getResultArray();
		echo view('website/annathanam/print_annathanam',$data);
	}
    public function account_migration($annathanam_id){
		$annathanam = $this->db->table('annathanam')->where('id', $annathanam_id)->get()->getRowArray();
		if($annathanam['paid_through'] == 'ONLINE'){
			 $payment_mode_details = $this->db->table('payment_mode')->where('id', $annathanam['payment_mode'])->get()->getRowArray();
			  if(empty($payment_mode_details['id'])) $payment_mode_details = $this->db->table('payment_mode')->get()->getRowArray();

			$incomes_group = $this->db->table('groups')->where('code', '8000')->get()->getRowArray();
			if (!empty($incomes_group)) {
				$sls_id = $incomes_group['id'];
			} else {
				$sls1['parent_id'] = 0;
				$sls1['name'] = 'Incomes';
				$sls1['code'] = '8000';
				$sls1['added_by'] = $annathanam['added_by'];
				$this->db->table('groups')->insert($sls1);
				$sls_id = $this->db->insertID();
			}
			$annathanam_setting_details = $this->db->table("annathanam_setting")
													->where("rice_category_id", $annathanam['rice_category_id'])
													->where("kuruma_id", $annathanam['kuruma_id'])
													->where("rice_type_id", $annathanam['rice_type_id'])
													->get()->getRowArray();
			if(!empty($annathanam_setting_details['ledger_id'])){
				$rr_id = $annathanam_setting_details['ledger_id'];
			}else{
				$ledger1 = $this->db->table('ledgers')->where('name', 'All Incomes')->where('group_id', $sls_id)->get()->getRowArray();
				if(!empty($ledger1)){
					$rr_id = $ledger1['id'];
				}else{
					$right_code = $this->db->table('ledgers')->select('right_code')->where('group_id', $sls_id)->where('left_code', '8913')->orderBy('right_code','desc')->get()->getRowArray();
					$set_right_code = (int) $right_code['right_code'] + 1;
					$set_right_code = sprintf("%04d", $set_right_code);
					$lednew1['group_id'] = $sls_id;
					$lednew1['name'] = 'All Incomes';
					$lednew1['left_code'] = '8913';
					$lednew1['right_code'] = $set_right_code;
					$lednew1['op_balance'] = '0';
					$lednew1['op_balance_dc'] = 'D';
					$this->db->table('ledgers')->insert($lednew1);
					$rr_id = $this->db->insertID();
				}
			}
			$cr_id = $payment_mode_details['ledger_id'];
			$number = $this->db->table('entries')->select('number')->where('entrytype_id',1)->orderBy('id','desc')->get()->getRowArray(); 
			if(empty($number)) {
				$num = 1;
			} else {
				$num = $number['number'] + 1;
			}
			//$date = explode('-', date("Y-m-d", strtotime($annathanam['date'])));
			$yr = date('Y',strtotime($annathanam['date']));
			$mon = date('m',strtotime($annathanam['date']));
			$qry   = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='". $yr ."' and entrytype_id =1 and month (date)='". $mon ."')")->getRowArray();
			$entries['entry_code'] = 'REC' .date('y',strtotime($annathanam['date'])).date('m',strtotime($annathanam['date'])). (sprintf("%05d",(((float)  substr($qry['entry_code'],-5))+1)));
			$entries['entrytype_id'] = '1';
			$entries['number'] 		 = $num;
			$entries['date'] 		 = date("Y-m-d", strtotime($annathanam['date'])); 
			$entries['dr_total'] 	 = $annathanam['total_amount'];
			$entries['cr_total'] 	 = $annathanam['total_amount'];
			$entries['narration'] 	 = 'Annadhanam(' . $annathanam['ref_no'] . ')' . "\n" . 'name:' . $annathanam['name'] . "\n" . 'Phone:' . $annathanam['phone_no'] . "\n";
			$entries['inv_id']       = $annathanam_id;
			$entries['type']         = '12';
			$entries['paid_through'] = 'ONLINE';
			$entries['entry_by'] = $annathanam['added_by'];
			$ent = $this->db->table('entries')->insert($entries);
			$en_id = $this->db->insertID();
			if(!empty($en_id)){
				$ent_id[] = $en_id;
				$eitems_d['entry_id'] = $en_id;
				$eitems_d['ledger_id'] = $rr_id;
				$eitems_d['amount'] = $annathanam['total_amount'];
				$eitems_d['details'] = 'Annadhanam(' . $annathanam['ref_no'] . ')';
				$eitems_d['dc'] = 'C';
				$cr_res = $this->db->table('entryitems')->insert($eitems_d);
				$eitems_c['entry_id'] = $en_id;
				$eitems_c['ledger_id'] = $cr_id;
				$eitems_c['amount'] = $annathanam['total_amount'];
				$eitems_c['details'] = 'Annadhanam(' . $annathanam['ref_no'] . ')';
				$eitems_c['dc'] = 'D';
				$deb_res = $this->db->table('entryitems')->insert($eitems_c);
				if($cr_res && $deb_res) $succ++;
				else $err++;
			}
		}
	}
    public function getkurumaCount()
	{
		$kurm_id = !empty($_POST['kurm_id']) ? $_POST['kurm_id'] : 0;
		$getkuruma = $this->db->table('annathanam_kuruma_type')
								->where('id', $kurm_id)
								->get()->getResultArray();
		if(count($getkuruma) > 0)
		{
			$count = $getkuruma[0]['count'];
		}
		else
		{
			$count = 0;
		}
		return $count;
	}
    public function getriceAmount()
	{
		$rice_cat = !empty($_POST['rice_cat']) ? $_POST['rice_cat'] : 0;
		$kurm_id = !empty($_POST['kurm_id']) ? $_POST['kurm_id'] : 0;
		$ricetype_id = !empty($_POST['ricetype_id']) ? $_POST['ricetype_id'] : 0;
		$getamount = $this->db->table('annathanam_setting')
								->where('rice_category_id', $rice_cat)
								->where('kuruma_id', $kurm_id)
								->where('rice_type_id', $ricetype_id)
								->get()->getResultArray();
		if(count($getamount) > 0)
		{
			$amt = $getamount[0]['amount'];
		}
		else
		{
			$amt = "0.00";
		}
		return $amt;
	}

}