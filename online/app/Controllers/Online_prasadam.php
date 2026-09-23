<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Online_prasadam extends BaseController
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
        $data['prasadam_settings'] = $this->db->query("SELECT * FROM prasadam_setting order by name_eng asc")->getResultArray();
        echo view('website/layout/header');
        echo view('website/prasadambooking', $data);
        echo view('website/layout/footer');
    }
    public function save()
    {
        $msg_data = array();
        $msg_data['err'] = '';
        $msg_data['succ'] = '';
        if (!empty($_POST['prasadam']) && count($_POST['prasadam']) > 0) {
            $yr = date('Y',strtotime($_POST['date']));
            $mon = date('m',strtotime($_POST['date']));
            $query = $this->db->query("SELECT ref_no FROM prasadam where id=(select max(id) from prasadam where year (date)='" . $yr . "' and month (date)='" . $mon . "')")->getRowArray();
            $data['ref_no'] = 'PR' . date('y',strtotime($_POST['date'])) . $mon . (sprintf("%05d", (((float) substr($query['ref_no'], -5)) + 1)));
            $data['customer_name'] = $_POST['name'];
            $data['date'] = $_POST['date'];
            $data['email_id'] = $_POST['email'];
            $data['ic_no'] = $_POST['ic_num'];
            $mble_phonecode = !empty ($_POST['phonecode']) ? $_POST['phonecode'] : "";
            $mble_number = !empty ($_POST['phone_no']) ? $_POST['phone_no'] : "";
            $data['mobile_no'] = $mble_phonecode . $mble_number;
            $data['address'] = $_POST['address'];
            $data['desciption'] = $_POST['description'];
            $data['amount'] = $_POST['tot_amt'];
            $data['collection_date'] = $_POST['collection_date'];
            $data['start_time'] = $_POST['s_time'];
            $data['dob'] = $_POST['dob'];
            $data['added_by'] = $_POST['user_login_id'];
            $data['paid_through'] = "ONLINE";
            $data['payment_status'] =   1;
            $data['payment_mode'] =	5;
            $pay_method = 'ipay_online';
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
            $res = $this->db->table('prasadam')->insert($data);
            if($res){
                $prasadam_id = $this->db->insertID();
                if (!empty ($_POST['prasadam'])) {
                    foreach ($_POST['prasadam'] as $prasadam) {
                        $data_prdm_book['prasadam_booking_id'] = $prasadam_id;
                        $data_prdm_book['prasadam_id'] = $prasadam['id'];
                        $data_prdm_book['quantity'] = $prasadam['qty'];
                        $data_prdm_book['created'] = date('Y-m-d H:i:s');
                        $prsm_set = $this->db->table('prasadam_setting')->where('id', $prasadam['id'])->get()->getRowArray();
                        $data_prdm_book['amount'] = $prsm_set['amount'];
                        $amt = $prasadam['qty'] * $prsm_set['amount'];
                        $data_prdm_book['total_amount'] = $amt;
                        $this->db->table('prasadam_booking_details')->insert($data_prdm_book);
                    }
                }
                $payment_gateway_data = array();
                $payment_gateway_data['prasadam_id'] = $prasadam_id;
                $payment_gateway_data['pay_method'] = $pay_method;
                $this->db->table('prasadam_payment_gateway_datas')->insert($payment_gateway_data);
                $msg_data['succ'] = 'Prasadam Added Successflly';
                $msg_data['id'] = $prasadam_id;
            }
            else{
                $msg_data['err'] = 'Please Try Again';
            }
        }
        else{
            $msg_data['err'] = 'Please select atleast one prasadam detail.';
        }
        echo json_encode($msg_data);
		exit;
    }
    public function payment_process($prasadam_id) {
        if(!empty($prasadam_id)){
            include_once FCPATH . 'app/Libraries/ipay88-master/IPay88.class.php';
            $prasadam_booking = $this->db->table('prasadam')->where('id', $prasadam_id)->get()->getRowArray();
            $email = 'dd@ipay88.com.my';
            $description='Prasadam';
            $final_amt = $prasadam_booking['amount'];
            $MerchantCode = 'M01236';
            $MerchantKey = 'HQgUUZLVzg';
            $ref_no = 'PRASADAM_' . $prasadam_id;
            $refno_pay = $prasadam_id;
            $module = 'Prasadam';
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
            $ipay88->setField('ResponseURL',  base_url() . '/online_prasadam/ipay88_online_response');
            $ipay88->generateSignature();
            $ipay88_fields = $ipay88->getFields();
            $data['ipay88_fields'] = $ipay88_fields;
            $data['epayment_url'] = \Ipay88::$epayment_url;
            $data['title'] = "Prasadam Payment Process";
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
		$prasadam_id = $response['data']['RefNo'];
		//print_r($response);
		$prasadam_payment_gateway_datas = $this->db->table('prasadam_payment_gateway_datas')->where('prasadam_id', $prasadam_id)->get()->getRowArray();
		$payment_gateway_up_data = array();
		$payment_gateway_up_data['response_data'] = json_encode($response);
		$this->db->table('prasadam_payment_gateway_datas')->where('id', $prasadam_payment_gateway_datas['id'])->update($payment_gateway_up_data);
		if($response['status']){
			$prasadam_booking_up_data = array();
			$prasadam_booking_up_data['payment_status'] = 2;
			$this->db->table('prasadam')->where('id', $prasadam_id)->update($prasadam_booking_up_data);
			$this->account_migration($prasadam_id);
			//$this->session->setFlashdata('succ', 'Prasadam Booking Successfully');
			$redirect_url = base_url() . '/online_prasadam/print_prasadam/' .$prasadam_id;
			header('Location: ' . $redirect_url);
			exit;
		}else{
			$prasadam_booking_up_data = array();
			$prasadam_booking_up_data['payment_status'] = 3;
			$this->db->table('prasadam')->where('id', $prasadam_id)->update($prasadam_booking_up_data);
			//$this->session->setFlashdata('fail', 'Payment Failed');
			$redirect_url = base_url() . '/online_prasadam/payment_failed';
			header('Location: ' . $redirect_url);
			exit;
		}
	}
    public function payment_failed(){
		echo view('website/payment_failed');
	}
    public function print_prasadam($prsm_id)
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
        $tmpid = 1;
        $data['temp_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
        $data['terms'] = $this->db->table("terms_conditions")->get()->getRowArray();
        echo view('website/prasadam/print_page', $data);                              
    }
    public function account_migration($prsm_id)
    {
        $prasadam = $this->db->table('prasadam')->where('id', $prsm_id)->get()->getRowArray();
        if ($prasadam['paid_through'] == 'ONLINE') {
            $prasadam_payment_gateway_datas = $this->db->table('prasadam_payment_gateway_datas')->where('prasadam_id', $prsm_id)->get()->getRowArray();
            if($prasadam_payment_gateway_datas['pay_method'] == 'cash')
            $payment_id = 6; ////  goto cash Ledger
            else if ($prasadam_payment_gateway_datas['pay_method'] == 'ipay_online')$payment_id = 5; ////  goto online Ledger
            else
            $payment_id = 4; ////  goto Qr or Online Payment Ledger
            $payment_mode_details = $this->db->table('payment_mode')->where('id', $payment_id)->get()->getRowArray();
            if(empty ($payment_mode_details['id']))
            $payment_mode_details = $this->db->table('payment_mode')->get()->getRowArray();
            $sales_group = $this->db->table('groups')->where('code', '4000')->get()->getRowArray();
            if(!empty($sales_group)){
                $sls_id = $sales_group['id'];
            }else{
                $sls1['parent_id'] = 0;
                $sls1['name'] = 'Sales';
                $sls1['code'] = '4000';
                $sls1['added_by'] = $prasadam['added_by'];
                $this->db->table('groups')->insert($sls1);
                $sls_id = $this->db->insertID();
            }
            $prasadam_booking_details = $this->db->table('prasadam_booking_details')->where('prasadam_booking_id', $prsm_id)->get()->getResultArray();
            /*STOCK DEDECTION SECTION START */
            foreach ($prasadam_booking_details as $pbd_prasadam) {
                $prasadam_dedection_data = $this->db->table('prasadam_setting')->where('id', $pbd_prasadam['prasadam_id'])->get()->getRowArray();
                if (!empty ($prasadam_dedection_data['dedection_from_stock'])) {
                    if ($prasadam_dedection_data['dedection_from_stock'] == 1) {
                        $pm_raw_items = $this->db->table("prasadam_raw_material_items")
                                                ->where("product_id", $pbd_prasadam['prasadam_id'])
                                                ->get()->getResultArray();
                        if (count($pm_raw_items) > 0) {
                            $data_rtout['date'] = $prasadam['date'];
                            $data_rtout['staff_name'] = $prasadam['added_by'];
                            $query_out = $this->db->query("SELECT invoice_no FROM stock_outward where id=(select max(id) from stock_outward where year (date)='" . $yr . "' and month (date)='" . $mon . "')")->getRowArray();
                            $data_rtout['invoice_no'] = 'PR' . date('y', strtotime($prasadam['date'])) . $mon . (sprintf("%05d", (((float) substr($query_out['invoice_no'], -5)) + 1)));
                            $data_rtout['added_by'] = $prasadam['added_by'];
                            $data_rtout['modified'] = date("Y-m-d H:i:s");
                            $data_rtout['created'] = date("Y-m-d H:i:s");
                            $this->db->table('stock_outward')->insert($data_rtout);
                            $ins_id_rtout = $this->db->insertID();
                            $tot_outward_list_amt = 0;
                            foreach ($pm_raw_items as $pr_raw_item) {
                                $tot_req_qty = $pbd_prasadam['quantity'] * $pr_raw_item['qty'];
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
            }
            /*STOCK DEDECTION SECTION END */
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
                //$date = explode('-', date("Y-m-d", strtotime($prasadam['date'])));
                $yr = date('Y', strtotime($prasadam['date']));
                $mon = date('m', strtotime($prasadam['date']));
                $qry = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='" . $yr . "' and entrytype_id =1 and month (date)='" . $mon . "')")->getRowArray();
                $entries['entry_code'] = 'REC' . date('y', strtotime($prasadam['date'])) . $mon . (sprintf("%05d", (((float) substr($qry['entry_code'], -5)) + 1)));
                $entries['entrytype_id'] = '1';
                $entries['number'] = $num;
                $entries['date'] = date("Y-m-d", strtotime($prasadam['date']));
                $entries['dr_total'] = $pbd['amount'];
                $entries['cr_total'] = $pbd['amount'];
                $entries['narration'] = 'Prasadam(' . $prasadam['ref_no'] . ')' . "\n" . 'name:' . $prasadam['customer_name'] . "\n" . 'NRIC:' . $prasadam['ic_no'] . "\n" . 'email:' . $prasadam['email_id'] . "\n";
                $entries['inv_id'] = $prsm_id;
                $entries['type'] = '10';
                $entries['paid_through'] = 'ONLINE';
			    $entries['entry_by'] = $prasadam['added_by'];
                $ent = $this->db->table('entries')->insert($entries);
                $en_id = $this->db->insertID();
                if (!empty($en_id)) {
                    $eitems_d['entry_id'] = $en_id;
                    $eitems_d['ledger_id'] = $dr_id;
                    $eitems_d['amount'] = $pbd['amount'];
                    $eitems_d['details'] = 'Prasadam(' . $prasadam['ref_no'] . ')';
                    $eitems_d['dc'] = 'C';
                    $cr_res = $this->db->table('entryitems')->insert($eitems_d);
                    $eitems_c['entry_id'] = $en_id;
                    $eitems_c['ledger_id'] = $cr_id;
                    $eitems_c['amount'] = $pbd['amount'];
                    $eitems_c['details'] = 'Prasadam(' . $prasadam['ref_no'] . ')';
                    $eitems_c['dc'] = 'D';
                    $deb_res = $this->db->table('entryitems')->insert($eitems_c);
                }
            }
        }
    }



}