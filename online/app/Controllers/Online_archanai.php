<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Online_archanai extends BaseController
{
	function __construct(){
        parent:: __construct();
        helper('url');
        helper('common_helper');
        //$this->model = new PermissionModel();
    }
	public function index()
	{
		$data['staff'] = $this->db->table('staff')->get()->getResultArray();
		$data['rasi'] = $this->db->table('rasi')->get()->getResultArray();
		$data['nat'] = $this->db->table('natchathram')->get()->getResultArray();
		$group = $this->db->query("SELECT * FROM archanai_group order by order_no, name asc")->getResultArray();
		$diety = $this->db->query("SELECT * FROM archanai_diety order by name asc")->getResultArray();
		$i = 0;
		foreach ($group as $row) {
			$group_achanai_list = $this->db->table('archanai')->where('groupname', $row['name'])->where('view_archanai', 1)->orderBy('order_no', 'ASC')->get()->getResultArray();
			$g_a_list = array();
			if (count($diety) > 0) {
				foreach ($diety as $d_row) {
					foreach ($group_achanai_list as $gal) {
						$diety_ids = explode(',', $gal['diety_id']);
						if (in_array($d_row['id'], $diety_ids)) {
							$gal['diety_id'] = $d_row['id'];
							$gal['code'] = $d_row['code'];
							$gal['diety_img_url'] = !empty($d_row['image']) ? base_url() . '/uploads/diety/' . $d_row['image'] : '';
							$g_a_list[] = $gal;
						}
					}
				}
			}
			if (count($g_a_list) > 0) {
				usort($g_a_list, fn($a, $b) => $a['name_eng'] <=> $b['name_eng']);
				if (empty($i))
					$data['default'] = str_replace(' ', '_', strtolower($row['name']));
				$data['archanai'][$row['id']]['title'] = $row['name'];
				$data['archanai'][$row['id']]['datas'] = $g_a_list;
				$i++;
			}
		}
        $yr = date('Y');
		$mon = date('m');
		$query = $this->db->query("SELECT ref_no FROM archanai_booking where id=(select max(id) from archanai_booking where year (date)='" . $yr . "' and month (date)='" . $mon . "')")->getRowArray();
		$data['bill_no'] = 'AR' . date('y') . $mon . (sprintf("%05d", (((float) substr($query['ref_no'], -5)) + 1)));
		$data['reprintlists'] = $this->db->query("SELECT id,amount,ref_no,date FROM archanai_booking WHERE entry_by = '" . $login_id . "' and paid_through = 'COUNTER' AND payment_status = 2 ORDER BY id DESC LIMIT 3")->getResultArray();
        echo view('website/layout/header');
        echo view('website/archanai', $data);
        echo view('website/layout/footer');
    }
	
	
	
	public function archanai()
	{
		$data['staff'] = $this->db->table('staff')->get()->getResultArray();
		$data['rasi'] = $this->db->table('rasi')->get()->getResultArray();
		$data['nat'] = $this->db->table('natchathram')->get()->getResultArray();
		$data['arch_ctry'] = $this->db->table('archanai_group')->get()->getResultArray();
		//echo "<pre>"; print_r($data); die();
		
		$group = $this->db->query("SELECT * FROM archanai_group order by order_no, name asc")->getResultArray();
		$diety = $this->db->query("SELECT * FROM archanai_diety order by name asc")->getResultArray();
		$i = 0;
		foreach ($group as $row) {
			$group_achanai_list = $this->db->table('archanai')->where('groupname', $row['name'])->where('view_archanai', 1)->orderBy('order_no', 'ASC')->get()->getResultArray();
			$g_a_list = array();
			if (count($diety) > 0) {
				foreach ($diety as $d_row) {
					foreach ($group_achanai_list as $gal) {
						$diety_ids = explode(',', $gal['diety_id']);
						if (in_array($d_row['id'], $diety_ids)) {
							$gal['diety_id'] = $d_row['id'];
							$gal['code'] = $d_row['code'];
							$gal['diety_img_url'] = !empty($d_row['image']) ? base_url() . '/uploads/diety/' . $d_row['image'] : '';
							$g_a_list[] = $gal;
						}
					}
				}
			}
			if (count($g_a_list) > 0) {
				usort($g_a_list, fn($a, $b) => $a['name_eng'] <=> $b['name_eng']);
				if (empty($i))
					$data['default'] = str_replace(' ', '_', strtolower($row['name']));
				$data['archanai'][$row['id']]['title'] = $row['name'];
				$data['archanai'][$row['id']]['datas'] = $g_a_list;
				$i++;
			}
		}
        $yr = date('Y');
		$mon = date('m');
		$query = $this->db->query("SELECT ref_no FROM archanai_booking where id=(select max(id) from archanai_booking where year (date)='" . $yr . "' and month (date)='" . $mon . "')")->getRowArray();
		$data['bill_no'] = 'AR' . date('y') . $mon . (sprintf("%05d", (((float) substr($query['ref_no'], -5)) + 1)));
		$data['reprintlists'] = $this->db->query("SELECT id,amount,ref_no,date FROM archanai_booking WHERE entry_by = '" . $login_id . "' and paid_through = 'COUNTER' AND payment_status = 2 ORDER BY id DESC LIMIT 3")->getResultArray();
        echo view('website/layout/header');
        echo view('website/archanai_new', $data);
        echo view('website/layout/footer');
    }
	
	
	public function get_archanai()
	{
		$name = $_POST['arch_cat'];
		//echo $name;
		$res = $this->db->table('archanai')->where('groupname', $name)->get()->getResultArray();
		//var_dump($res);
		/*foreach($res as $row)
		{ 
			$qry =  $this->db->table('archanai')->where('groupname', $row['groupname'])->get()->getRowArray();
			$data['id'] = $qry['id'];
			$data['name_eng'] = $qry['name_eng'];
		}*/

		echo json_encode($res);
		exit;
	}
	
	
	
	public function save_archanai()
	{
		$msg_data = array();
		$msg_data['err'] = '';
		$msg_data['succ'] = '';
		$yr = date('Y');
		$mon = date('m');
		$query = $this->db->query("SELECT ref_no FROM archanai_booking where id=(select max(id) from archanai_booking where year (date)='" . $yr . "' and month (date)='" . $mon . "')")->getRowArray();
		$data['ref_no'] = 'AR' . date('y') . $mon . (sprintf("%05d", (((float) substr($query['ref_no'], -5)) + 1)));
		$data['date'] = date('Y-m-d');
		//$data['amount'] = $_POST['tot_amt'];
		$data['payment_mode']  =	5;
		$data['paid_through'] = "ONLINE";
		$pay_method       =	'ipay_online';
		$data['payment_status'] =   1;
		$data['entry_by'] = $_POST['user_login_id'];
		$tot_amt = 0;
		foreach ($_POST['arch'] as $arch) {
			$cash = $this->db->table('archanai')->where('id', $arch['id'])->get()->getRowArray();
			$amt = $arch['qty'] * $cash['amount'];
			$tot_amt += $amt;
		}
		$data['amount'] = $tot_amt;
		$data['comission'] = "0.00";
		$data['sep_print'] = 0;
		$data['created']      =	date('Y-m-d H:i:s');
		$data['updated']      =	date('Y-m-d H:i:s');
		$res = $this->db->table('archanai_booking')->insert($data);
		if ($res) {
			$arch_book_id = $this->db->insertID();
			if (!empty($_POST['arch'])) {
				foreach ($_POST['arch'] as $arch) {
					$data_arch_book['archanai_booking_id'] = $arch_book_id;
					$data_arch_book['archanai_id'] = $arch['id'];
					$data_arch_book['diety_id'] = $arch['diety_id'];
					$data_arch_book['quantity'] = $arch['qty'];
					$data_arch_book['created'] = date('Y-m-d H:i:s');
					$cash = $this->db->table('archanai')->where('id', $arch['id'])->get()->getRowArray();
					$data_arch_book['amount'] = $cash['amount'];
					$data_arch_book['commision'] = $cash['commission'];
					$amt = $arch['qty'] * $cash['amount'];
					$camt = $arch['qty'] * $cash['commission'];
					$data_arch_book['total_amount'] = $amt - $camt;
					$data_arch_book['total_commision'] = $camt;
					$this->db->table('archanai_booking_details')->insert($data_arch_book);
				}
			}
			if (!empty($_POST['rasi'])) {
				foreach ($_POST['rasi'] as $rasi) {
					$data_arch_rasi['archanai_booking_id'] = $arch_book_id;
					$data_arch_rasi['name'] = $rasi['arc_name'];
					$data_arch_rasi['rasi_id'] = $rasi['rasi_ids'];
					$data_arch_rasi['natchathram_id'] = $rasi['natchathra_ids'];
					$this->db->table('archanai_booking_rasi')->insert($data_arch_rasi);
				}
			}
			if (!empty($_POST['vehicle'])) {
				foreach ($_POST['vehicle'] as $vehicle) {
					$data_arch_vehicle['archanai_booking_id'] = $arch_book_id;
					$data_arch_vehicle['name'] = $vehicle['vle_name'];
					$data_arch_vehicle['vehicle_no'] = $vehicle['vle_no'];
					$this->db->table('archanai_booking_vehicle')->insert($data_arch_vehicle);
				}
			}
			$payment_gateway_data = array();
			$payment_gateway_data['archanai_booking_id'] = $arch_book_id;
			$payment_gateway_data['pay_method'] = $pay_method;
			$this->db->table('archanai_payment_gateway_datas')->insert($payment_gateway_data);
			$archanai_payment_gateway_id = $this->db->insertID();
			$msg_data['succ'] = 'Archanai Booking Added Successfully';
			$msg_data['id'] = $arch_book_id;
		}
		echo json_encode($msg_data);
		exit;
	}
	public function payment_process($archanai_id) {
		if(!empty($archanai_id)){
			include_once FCPATH . 'app/Libraries/ipay88-master/IPay88.class.php';
			$archanai_booking = $this->db->table('archanai_booking')->where('id', $archanai_id)->get()->getRowArray();
			$email = 'dd@ipay88.com.my';
			$description='Archanai';
			$final_amt = $archanai_booking['amount'];
			$MerchantCode = 'M01236';
			$MerchantKey = 'HQgUUZLVzg';
			$ref_no = 'ARCHANAI_' . $archanai_id;
			$refno_pay = $archanai_id;
			$module = 'Archanai';
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
			$ipay88->setField('ResponseURL',  base_url() . '/online_archanai/ipay88_online_response');
			$ipay88->generateSignature();
			$ipay88_fields = $ipay88->getFields();
			$data['ipay88_fields'] = $ipay88_fields;
			$data['epayment_url'] = \Ipay88::$epayment_url;
			$data['title'] = "Archanai Payment Process";
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
		$archanai_id = $response['data']['RefNo'];
		//print_r($response);
		$archanai_payment_gateway_datas = $this->db->table('archanai_payment_gateway_datas')->where('archanai_booking_id', $archanai_id)->get()->getRowArray();
		$payment_gateway_up_data = array();
		$payment_gateway_up_data['response_data'] = json_encode($response);
		$this->db->table('archanai_payment_gateway_datas')->where('id', $archanai_payment_gateway_datas['id'])->update($payment_gateway_up_data);
		if($response['status']){
			$archanai_booking_up_data = array();
			$archanai_booking_up_data['payment_status'] = 2;
			$this->db->table('archanai_booking')->where('id', $archanai_id)->update($archanai_booking_up_data);
			$this->account_migration($archanai_id);
			//$this->session->setFlashdata('succ', 'Archanai Booking Successfully');
			$redirect_url = base_url() . '/online_archanai/print_archanai/' .$archanai_id;
			header('Location: ' . $redirect_url);
			exit;
		}else{
			$archanai_booking_up_data = array();
			$archanai_booking_up_data['payment_status'] = 3;
			$this->db->table('archanai_booking')->where('id', $archanai_id)->update($archanai_booking_up_data);
			$redirect_url = base_url() . '/online_archanai/payment_failed';
			header('Location: ' . $redirect_url);
			exit;
		}
	}
	public function payment_failed(){
		echo view('website/payment_failed');
	}
	public function account_migration($arch_book_id)
	{
		$archanai_booking = $this->db->table('archanai_booking')->where('id', $arch_book_id)->get()->getRowArray();
		$archanai_booking_details = $this->db->table('archanai_booking_details')->where('archanai_booking_id', $arch_book_id)->get()->getResultArray();
		if ($archanai_booking['paid_through'] == 'ONLINE') {
			$archanai_payment_gateway_datas = $this->db->table('archanai_payment_gateway_datas')->where('archanai_booking_id', $arch_book_id)->get()->getRowArray();
			$payment_id = 5;
			$payment_mode_details = $this->db->table('payment_mode')->where('id', $payment_id)->get()->getRowArray();
			if (empty($payment_mode_details['id']))
				$payment_mode_details = $this->db->table('payment_mode')->get()->getRowArray();
			$sales_group = $this->db->table('groups')->where('name', 'Sales')->where('parent_id', 26)->get()->getRowArray();
			if (!empty($sales_group)) {
				$sls_id = $sales_group['id'];
			} else {
				$sls1['parent_id'] = 26;
				$sls1['name'] = 'Sales';
				$sls1['code'] = '330';
				$sls1['added_by'] = $archanai_booking['entry_by'];
				$led_ins1 = $this->db->table('groups')->insert($sls1);
				$sls_id = $this->db->insertID();
			}
			if (count($archanai_booking_details) > 0) {
				// Archanai Dedection Start
				foreach ($archanai_booking_details as $arch) {
					$archanai_dedection_data = $this->db->table('archanai')->where('id', $arch['id'])->get()->getRowArray();
					if (!empty($archanai_dedection_data['dedection_from_stock'])) {
						if ($archanai_dedection_data['dedection_from_stock'] == 1) {
							$am_raw_items = $this->db->table("archanai_raw_material_items")
								->where("product_id", $arch['id'])
								->get()->getResultArray();
							if (count($am_raw_items) > 0) {
								$data_rtout['date'] = $archanai_booking['date'];
								$data_rtout['staff_name'] = $archanai_booking['entry_by'];
								$query_out = $this->db->query("SELECT invoice_no FROM stock_outward where id=(select max(id) from stock_outward where year (date)='" . $yr . "' and month (date)='" . $mon . "')")->getRowArray();
								$data_rtout['invoice_no'] = 'AR' . date('y', strtotime($archanai_booking['date'])) . $mon . (sprintf("%05d", (((float) substr($query_out['invoice_no'], -5)) + 1)));
								$data_rtout['date'] = $archanai_booking['date'];
								$data_rtout['added_by'] = $archanai_booking['entry_by'];
								$data_rtout['modified'] = date("Y-m-d H:i:s");
								$data_rtout['created'] = date("Y-m-d H:i:s");
								$this->db->table('stock_outward')->insert($data_rtout);
								$ins_id_rtout = $this->db->insertID();
								$tot_outward_list_amt = 0;
								foreach ($am_raw_items as $pr_raw_item) {
									$tot_req_qty = $arch['qty'] * $pr_raw_item['qty'];
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
									$data_rtout_list['dedection_from'] = "Archanai";
									$data_rtout_list['dedection_id'] = $pr_raw_item['product_id'];
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
				// Archanai Dedection End
				$cash_amt = 0;
				$com_amt = 0;
				foreach ($archanai_booking_details as $arch) {
					$amt = $arch['quantity'] * $arch['amount'];
					$camt = $arch['quantity'] * $arch['commission'];
					$cash_amt = $cash_amt + $amt;
					$com_amt = $com_amt + $camt;
				}
				$number = $this->db->table('entries')->select('number')->where('entrytype_id', 1)->orderBy('id', 'desc')->get()->getRowArray();
				if (empty($number)) {
					$num = 1;
				} else {
					$num = $number['number'] + 1;
				}
				$yr = date('Y', strtotime($archanai_booking['date']));
				$mon = date('m', strtotime($archanai_booking['date']));
				$qry = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='" . $yr . "' and entrytype_id =1 and month (date)='" . $mon . "')")->getRowArray();
				$entries['entry_code'] = 'REC' . date('y', strtotime($archanai_booking['date'])) . $mon . (sprintf("%05d", (((float) substr($qry['entry_code'], -5)) + 1)));
				$entries['entrytype_id'] = '1';
				$entries['number'] = $num;
				$entries['date'] = $archanai_booking['date'];
				$entries['dr_total'] = $cash_amt;
				$entries['cr_total'] = $cash_amt;
				$entries['narration'] = 'Archanai Booking(' . $archanai_booking['ref_no'] . ')';
				$entries['inv_id'] = $arch_book_id;
				$entries['type'] = '3';
				$entries['paid_through'] = 'ONLINE';
				$entries['entry_by'] = $archanai_booking['entry_by'];
				$ent = $this->db->table('entries')->insert($entries);
				$en_id = $this->db->insertID();
				if (!empty($en_id)) {
					foreach ($archanai_booking_details as $arch) {
						$archanai_details = $this->db->table('archanai')->where('id', $arch['archanai_id'])->get()->getRowArray();
						if (!empty($archanai_details['ledger_id'])) {
							$dr_id = $archanai_details['ledger_id'];
						} else {
							$ledger1 = $this->db->table('ledgers')->where('name', 'All Sales')->where('group_id', $sls_id)->get()->getRowArray();
							if (!empty($ledger1)) {
								$dr_id = $ledger1['id'];
							} else {
								$right_code = $this->db->table('ledgers')->select('right_code')->where('group_id', $sls_id)->where('left_code', '4913')->orderBy('right_code', 'desc')->get()->getRowArray();
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
						$cash_amount = $arch['quantity'] * $arch['amount'];
						$eitems_d = array();
						$eitems_d['entry_id'] = $en_id;
						$eitems_d['ledger_id'] = $dr_id;
						$eitems_d['amount'] = $cash_amount;
						$eitems_d['dc'] = 'C';
						$this->db->table('entryitems')->insert($eitems_d);
					}
					$eitems_c['entry_id'] = $en_id;
					$eitems_c['ledger_id'] = $payment_mode_details['ledger_id'];
					$eitems_c['amount'] = $cash_amt;
					$eitems_c['dc'] = 'D';
					$this->db->table('entryitems')->insert($eitems_c);
				}
				return true;
			} else
				return false;
		} else
			return false;
	}
	public function print_archanai($arch_book_id)
	{
		$id = $this->request->uri->getSegment(3);
		$data['qry1'] = $archanai_booking = $this->db->table('archanai_booking')->where('id', $id)->get()->getRowArray();
		$view_file = 'website/archanai/print';
		if ($archanai_booking['paid_through'] == 'ONLINE') {
			if ($archanai_booking['payment_status'] == '2') {
				$tmpid = 1;
				$data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
				$data['archanai_book_id'] = $id;
				$data['booking'] = $this->db->table('archanai_booking_details', 'archanai', 'archanai_booking_rasi', 'rasi', 'natchathram')
					->join('archanai', 'archanai.id = archanai_booking_details.archanai_id', 'left')
					->join('archanai_diety', 'archanai_diety.id = archanai_booking_details.diety_id', 'left')
					->where('archanai_booking_details.archanai_booking_id', $id)
					->select('archanai.*, archanai_diety.name as diety_name,archanai_diety.name_tamil as diety_tamil')
					->select('archanai_booking_details.*,(archanai_booking_details.amount+archanai_booking_details.commision) as tot')
					->get()
					->getResultArray();
				$data['rasi'] = $this->db->table('archanai_booking_rasi', 'rasi', 'natchathram')
					->join('rasi', 'rasi.id = archanai_booking_rasi.rasi_id', 'left')
					->join('natchathram', 'natchathram.id = archanai_booking_rasi.natchathram_id', 'left')
					->where('archanai_booking_rasi.archanai_booking_id', $id)
					->select('archanai_booking_rasi.*')
					->select('rasi.*, rasi.name_eng as rasi_name_eng, rasi.name_tamil as rasi_name_tamil')
					->select('natchathram.*, natchathram.name_eng as nat_name_eng, natchathram.name_tamil as nat_name_tamil')
					->get()
					->getResultArray();
				$data['vehicles'] = $this->db->table('archanai_booking_vehicle')
					->where('archanai_booking_vehicle.archanai_booking_id', $id)
					->select('archanai_booking_vehicle.*')
					->get()
					->getResultArray();
				echo view($view_file, $data);
			}
		}
	}
	public function get_natchathram()
	{
		$rasi_id = $_POST['rasi_id'];
		$res = $this->db->table('rasi')->where('id', $rasi_id)->get()->getRowArray();
		if (!empty($res['natchathra_id'])) {
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
    public function get_member_rasi()
	{
		$json_resp = array();
		if (!empty($_REQUEST['term'])) {
			$term = $_REQUEST['term'];
			$rasis = $this->db->query("SELECT Distinct CONCAT_WS(' | ', abr.name, r.name_eng, n.name_eng) as label, abr.name, r.name_eng as rasi_eng, r.name_tamil as rasi_tamil, n.name_eng as natchathram_eng, n.name_tamil as natchathram_tamil, abr.rasi_id, abr.natchathram_id FROM `archanai_booking_rasi` abr left join rasi r on r.id = abr.rasi_id left join natchathram n on n.id = abr.natchathram_id where abr.name like '%$term%' limit 0,8")->getResultArray();
			$json_resp = $rasis;
		}
		echo json_encode($json_resp);
		exit;
	}
    
}