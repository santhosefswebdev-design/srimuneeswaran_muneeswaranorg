<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PermissionModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\RequestModel;

class Rental extends BaseController
{
	function __construct()
	{
		parent::__construct();
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', 10000);
		ini_set('max_input_time', 12000);
		helper('url');
		$this->model = new PermissionModel();
		if (($this->session->get('login')) == false && $this->session->get('role') != 1) {
			$data['dn_msg'] = 'Please Login';
			header('Location: ' . base_url() . '/login');
			exit;
		}
	}

	public function index()
	{
		$data['rentals'] = $this->db->table('rental')->select("rental.*, property_category.name, properties.name as propertyname")->join("properties", "properties.id = rental.property_id", "inner")->join("property_category", "property_category.id = properties.property_category_id", "inner")->get()->getResultArray();
		//echo "<pre>"; print_r($data); exit();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('rental/list', $data);
		echo view('template/footer');
	}

	public function add($id)
	{
		$data['property'] = $this->db->table('properties')->where("id", $id)->get()->getRowArray();
		$data['property_lists'] = $this->db->query("SELECT properties.id,properties.name FROM properties join tennant_property ON tennant_property.property_id = properties.id WHERE tennant_property.status = 1")->getResultArray();
		$data['payment_modes'] = $this->db->query("SELECT payment_mode.name,payment_mode.id FROM payment_mode WHERE paid_through LIKE '%direct%' and status = 1 ")->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('rental/add', $data);
		echo view('template/footer');
	}
	public function edit($id)
	{
		$data['property_lists'] = $this->db->query("SELECT id,name FROM properties where id in (SELECT property_id  FROM tennant_property WHERE status = 1)")->getResultArray();
		$data['rental'] = $this->db->table('rental')->where("id", $id)->get()->getRowArray();
		$data['payment'] = $this->db->table('rental_pay_details')->where('rental_id', $id)->get()->getResultArray();
		$data['payment_modes'] = $this->db->query("SELECT payment_mode.name,payment_mode.id FROM payment_mode WHERE paid_through LIKE '%direct%' and status = 1 ")->getResultArray();
		$rental_id = $data['rental']['property_id'];
		$res = $this->db->query("SELECT properties.rental_value as amount FROM `properties` LEFT JOIN tennant_property ON tennant_property.property_id = properties.id WHERE tennant_property.status = 1 AND properties.id = '$rental_id' ")->getRowArray();
		$data['rental_amt'] = !empty($res['amount']) ? $res['amount'] : 0;
		$data['view'] = true;
		//echo "<pre>"; print_r($data); exit();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('rental/add', $data);
		echo view('template/footer');
	}
	
	public function print_pdf($id)
	{
		$data['rental'] = $this->db->table('rental')
			->join('properties', 'rental.property_id = properties.id')
			->select('rental.*,properties.lot_no,properties.area')
			->where("rental.id", $id)
			->get()
			->getRowArray();
		$data['pay_details'] = $this->db->table("rental_pay_details")->where("rental_id", $id)->get()->getResultArray();
		
		$dompdf = new \Dompdf\Dompdf();
			$options = $dompdf->getOptions();
			$options->set(array('isRemoteEnabled' => true));
			$dompdf->setOptions($options);
			$html = view('rental/print_pdf', $data);
			$dompdf->loadHtml(view('rental/print_pdf', ["pdfdata" => $data]));
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			

		// Output the PDF as download
		$dompdf->stream("rental_receipt_" . $id . ".pdf", ["Attachment" => true]);
	}
	// public function notice_print($id)
	// {
	// 	$data['rental'] = $this->db->table('rental')
	// 		->join('properties', 'rental.property_id = properties.id')
	// 		->select('rental.*,properties.lot_no,properties.area')
	// 		->where("rental.id", $id)
	// 		->get()
	// 		->getRowArray();
	// 		$data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
	// 	$data['pay_details'] = $this->db->table("rental_pay_details")->where("rental_id", $id)->get()->getResultArray();
	// 	echo view('rental/notice_print', $data);
	// }
	public function notice_print($id)
	{
		$data['rental'] = $this->db->table('rental')
			->join('properties', 'rental.property_id = properties.id')
			->select('rental.*, properties.lot_no, properties.area')
			->where("rental.id", $id)
			->get()
			->getRowArray();

		$data['temp_details'] = $this->db->table('admin_profile')
			->where('id', 1)
			->get()
			->getRowArray();

		$data['pay_details'] = $this->db->table("rental_pay_details")
			->where("rental_id", $id)
			->get()
			->getResultArray();
			

		// Load the view into a variable instead of sending it to the browser
		

		
		
		$dompdf = new \Dompdf\Dompdf();
			$options = $dompdf->getOptions();
			$options->set(array('isRemoteEnabled' => true));
			$dompdf->setOptions($options);
			$html = view('rental/notice_print', $data);
			$dompdf->loadHtml(view('rental/notice_print', ["pdfdata" => $data]));
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			

		// Output the PDF as download
		$dompdf->stream("rental_notice_" . $id . ".pdf", ["Attachment" => true]);
	}

	public function singlerental()
	{
		$data['month_year'] = $_POST['rental_monthyear'];
		$rental_amount = isset($_POST['rental_amount']) && is_numeric($_POST['rental_amount']) ? floatval($_POST['rental_amount']) : 0;
		$extra_charges = isset($_POST['extracharges']) && is_numeric($_POST['extracharges']) ? floatval($_POST['extracharges']) : 0;
		$data['amount'] = $rental_amount + $extra_charges;
		$data['extracharges'] = $extra_charges;
		$data['payee_name'] = $_POST['rental_paynee_name'];
		$data['payee_description'] = $_POST['rental_description'];
		$data['payment_mode'] = $_POST['paymentmode'];
		$payid = $_POST['paymentmode'];
		$check_payment_mode = $this->db->query("SELECT payment_mode.name FROM payment_mode WHERE id = $payid ")->getRowArray();
		if (strtolower($check_payment_mode['name']) == "online") {
			$data['transaction_date'] = $_POST['paymentmode_transaction_date'];
			$data['ref_no'] = $_POST['paymentmode_transaction_no'];
			$data['cheque_date'] = NULL;
			$data['cheque_no'] = NULL;
		} else if (strtolower($check_payment_mode['name']) == "cheque") {
			$data['cheque_date'] = $_POST['paymentmode_cheque_date'];
			$data['cheque_no'] = $_POST['paymentmode_cheque_no'];
			$data['transaction_date'] = NULL;
			$data['ref_no'] = NULL;
		} else {
			$data['cheque_date'] = NULL;
			$data['cheque_no'] = NULL;
			$data['transaction_date'] = NULL;
			$data['ref_no'] = NULL;
		}
		$ip = 'unknown';
		$this->requestmodel = new RequestModel();
		$ip = $this->requestmodel->getIpAddress();
		if ($ip != 'unknown') {
			$ip_details = $this->requestmodel->getLocation($ip);
			$data['ip'] = $ip;
			$data['ip_location'] = (!empty($ip_details['country']) ? $ip_details['country'] : 'Unknown');
			$data['ip_details'] = json_encode($ip_details);
		}
		$data['property_id'] = $_POST['property_id'];
		$data['tenn_prop_id'] = $_POST['tenn_prop_id'];
		$data['created_at'] = date('Y-m-d H:i:s');
		$builder = $this->db->table('rental')->insert($data);
		
		$insert_id = $this->db->insertID();
		$rental_pay['rental_id'] = $insert_id;
		$rental_pay['date'] = date('Y-m-d');
		$rental_pay['amount'] = $rental_amount + $extra_charges;
		$rental_pay['payment_mode'] = $_POST['paymentmode'];
		$builder = $this->db->table('rental_pay_details')->insert($rental_pay);
		$pp_id = $_POST['property_id'];
		$pp_tan_id = $_POST['tenn_prop_id'];
		$res_maxvalue = $this->db->query("SELECT MAX(rental.month_year) as monthyear FROM properties JOIN rental ON rental.property_id = properties.id WHERE properties.property_status != 3 and rental.property_id = $pp_id and rental.tenn_prop_id = $pp_tan_id GROUP BY rental.property_id ")->getResultArray();
		if (count($res_maxvalue) > 0) {
			$pro_tan_id = $_POST['tenn_prop_id'];
			$property_tenant_id = $this->db->query("SELECT tennant_property.id as tent_id,tennant_property.end_date FROM properties join tennant_property ON tennant_property.property_id = properties.id WHERE tennant_property.id = $pro_tan_id and tennant_property.status = 1 ")->getRowArray();
			$protanid = $property_tenant_id['tent_id'];
			if ($_POST['rental_monthyear'] == date("Y-m", strtotime($res_maxvalue[0]['end_date']))) {
				$this->db->table('tennant_property')->where('id', $protanid)->update(array("status" => 0));
			}
		}
		$this->send_whatsapp_msg($insert_id);
		if (!empty($insert_id) && !empty($_POST['property_id'])) {

			$directincome_group = $this->db->table('groups')->where('name', 'Sales')->where('parent_id', 26)->get()->getRowArray();
			if (!empty($directincome_group)) {
				$dic_id = $directincome_group['id'];
			} else {
				$dic1['parent_id'] = 26;
				$dic1['name'] = 'Sales';
				$dic1['code'] = '330';
				$dic1['added_by'] = $this->session->get('log_id');
				$this->db->table('groups')->insert($dic1);
				$dic_id = $this->db->insertID();
			}
			// Rendal ledger
			$rental_ledger = $this->db->table('ledgers')->where('name', 'RENTAL RECEIVED')->where('left_code', '7003')->where('group_id', $dic_id)->get()->getRowArray();
			if (!empty($rental_ledger)) {
				$rr_id = $rental_ledger['id'];
			} else {
				$led1['group_id'] = $dic_id;
				$led1['name'] = 'RENTAL RECEIVED';
				$led1['code'] = '7003/000';
				$led1['op_balance'] = '0';
				$led1['op_balance_dc'] = 'D';
				$led1['left_code'] = '7003';
				$led1['right_code'] = '000';
				$this->db->table('ledgers')->insert($led1);
				$rr_id = $this->db->insertID();
			}
			$cashinhand = $this->db->table('groups')->where('name', 'Cash-in-Hand')->where('parent_id', 3)->get()->getRowArray();
			if (!empty($cashinhand)) {
				$cih_id = $cashinhand['id'];
			} else {
				$cih1['parent_id'] = 3;
				$cih1['name'] = 'Cash-in-Hand';
				$cih1['code'] = '111';
				$cih1['added_by'] = $this->session->get('log_id');
				$this->db->table('ledgers')->insert($cih1);
				$cih_id = $this->db->insertID();
			}
			$ledger2 = $this->db->table('ledgers')->where('name', 'PETTY CASH')->where('group_id', $cih_id)->get()->getRowArray();
			if (!empty($ledger2)) {
				$cr_id1 = $ledger2['id'];
			} else {
				$cled1['group_id'] = $cih_id;
				$cled1['name'] = 'PETTY CASH';
				$cled1['op_balance'] = '0';
				$cled1['op_balance_dc'] = 'C';
				$cled_ins1 = $this->db->table('ledgers')->insert($cled1);
				$cr_id1 = $this->db->insertID();
			}
			if (!empty($_POST['paymentmode'])) {
				if (empty($id) && $id == "") {
					//Payment Mode Details
					$payment_mode_details = $this->db->table('payment_mode')->where('id', $data['payment_mode'])->get()->getRowArray();
					$pyemnt_ledger_id = !empty($payment_mode_details['ledger_id']) ? $payment_mode_details['ledger_id'] : 1;
					$number = $this->db->table('entries')->select('number')->where('entrytype_id', 1)->orderBy('id', 'desc')->get()->getRowArray();
					if (empty($number)) {
						$num = 1;
					} else {
						$num = $number['number'] + 1;
					}
					$date = explode('-', date("Y-m-d"));
					$yr = $date[0];
					$mon = $date[1];
					$qry = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='" . $yr . "' and entrytype_id =1 and month (date)='" . $mon . "')")->getRowArray();
					$entries['entry_code'] = 'REC' . date('y') . $mon . (sprintf("%05d", (((float) substr($qry['entry_code'], -5)) + 1)));
					$entries['entrytype_id'] = '1';
					$entries['number'] = $num;
					$entries['date'] = date("Y-m-d");
					$entries['dr_total'] = $data['amount'];
					$entries['cr_total'] = $data['amount'];
					$entries['narration'] = 'Rental';
					$entries['inv_id'] = $insert_id;
					$entries['type'] = '1';
					$ent = $this->db->table('entries')->insert($entries);
					$en_id = $this->db->insertID();
					if (!empty($en_id)) {
						$eitems_d['entry_id'] = $en_id;
						$eitems_d['ledger_id'] = $rr_id;
						$eitems_d['amount'] = $data['amount'];
						$eitems_d['dc'] = 'C';
						$cr_res = $this->db->table('entryitems')->insert($eitems_d);

						$eitems_c['entry_id'] = $en_id;
						$eitems_c['ledger_id'] = $pyemnt_ledger_id;
						$eitems_c['amount'] = $data['amount'];
						$eitems_c['dc'] = 'D';
						$deb_res = $this->db->table('entryitems')->insert($eitems_c);
					}
				}
			}
			$array_id[] = $insert_id;
			return $array_id;
		}
	}
	public function multiplerental()
	{
		$numericSelection = $_POST['numericSelection'];
		$lastpaid_month = getproperty_lastpaidmonth_ym($_POST['tenn_prop_id'],$_POST['property_id']);
		if(!empty($lastpaid_month)){
			$pre_convert = $lastpaid_month."-14";
			$start_newDate = date('Y-m-14', strtotime($pre_convert. ' +1 months'));
			$end_newDate = date('Y-m-14', strtotime($pre_convert. ' +'.$numericSelection.' months'));
			$finns = getMonthsInRange($start_newDate,$end_newDate);
		}
		else{
			$tp_id_new = $_POST['tenn_prop_id'];
			$res_paid_month = $this->db->query("SELECT due_start_month FROM tennant_property WHERE tennant_property.id = $tp_id_new and tennant_property.status = 1 ")->getResultArray();
			$start_newDate = date('Y-m', strtotime($res_paid_month[0]['due_start_month']));
			$re_start_newDate = $start_newDate."-14";
			$re_numericSelection = $numericSelection - 1;
			$end_newDate = date('Y-m-14', strtotime($re_start_newDate. ' +'.$re_numericSelection.' months'));
			$finns = getMonthsInRange($re_start_newDate,$end_newDate);
		}
		$array_id = array();
		foreach($finns as $finns_my){
			$data['month_year'] = $finns_my;
			$rental_amount = isset($_POST['rental_amount']) && is_numeric($_POST['rental_amount']) ? floatval($_POST['rental_amount']) : 0;
		$extra_charges = isset($_POST['extracharges']) && is_numeric($_POST['extracharges']) ? floatval($_POST['extracharges']) : 0;
		$data['amount'] = $rental_amount + $extra_charges;
		$data['extracharges'] = $extra_charges;
			$data['payee_name'] = $_POST['rental_paynee_name'];
			$data['payee_description'] = $_POST['rental_description'];
			$data['payment_mode'] = $_POST['paymentmode'];
			$payid = $_POST['paymentmode'];
			$check_payment_mode = $this->db->query("SELECT payment_mode.name FROM payment_mode WHERE id = $payid ")->getRowArray();
			if (strtolower($check_payment_mode['name']) == "online") {
				$data['transaction_date'] = $_POST['paymentmode_transaction_date'];
				$data['ref_no'] = $_POST['paymentmode_transaction_no'];
				$data['cheque_date'] = NULL;
				$data['cheque_no'] = NULL;
			} else if (strtolower($check_payment_mode['name']) == "cheque") {
				$data['cheque_date'] = $_POST['paymentmode_cheque_date'];
				$data['cheque_no'] = $_POST['paymentmode_cheque_no'];
				$data['transaction_date'] = NULL;
				$data['ref_no'] = NULL;
			} else {
				$data['cheque_date'] = NULL;
				$data['cheque_no'] = NULL;
				$data['transaction_date'] = NULL;
				$data['ref_no'] = NULL;
			}
			$ip = 'unknown';
			$this->requestmodel = new RequestModel();
			$ip = $this->requestmodel->getIpAddress();
			if ($ip != 'unknown') {
				$ip_details = $this->requestmodel->getLocation($ip);
				$data['ip'] = $ip;
				$data['ip_location'] = (!empty($ip_details['country']) ? $ip_details['country'] : 'Unknown');
				$data['ip_details'] = json_encode($ip_details);
			}
			$data['property_id'] = $_POST['property_id'];
			$data['tenn_prop_id'] = $_POST['tenn_prop_id'];
			$data['created_at'] = date('Y-m-d H:i:s');
			$builder = $this->db->table('rental')->insert($data);
			$insert_id = $this->db->insertID();
			
			$rental_pay['rental_id'] = $insert_id;
			$rental_pay['date'] = date('Y-m-d');
			$rental_pay['amount'] = $rental_amount + $extra_charges;
			$rental_pay['payment_mode'] = $_POST['paymentmode'];
			$builder = $this->db->table('rental_pay_details')->insert($rental_pay);
			$pp_id = $_POST['property_id'];
			$pp_tan_id = $_POST['tenn_prop_id'];
			$res_maxvalue = $this->db->query("SELECT MAX(rental.month_year) as monthyear FROM properties JOIN rental ON rental.property_id = properties.id WHERE properties.property_status != 3 and rental.property_id = $pp_id and rental.tenn_prop_id = $pp_tan_id GROUP BY rental.property_id ")->getResultArray();
			if (count($res_maxvalue) > 0) {
				$pro_tan_id = $_POST['tenn_prop_id'];
				$property_tenant_id = $this->db->query("SELECT tennant_property.id as tent_id,tennant_property.end_date FROM properties join tennant_property ON tennant_property.property_id = properties.id WHERE tennant_property.id = $pro_tan_id and tennant_property.status = 1 ")->getRowArray();
				$protanid = $property_tenant_id['tent_id'];
				if ($_POST['rental_monthyear'] == date("Y-m", strtotime($res_maxvalue[0]['end_date']))) {
					$this->db->table('tennant_property')->where('id', $protanid)->update(array("status" => 0));
				}
			}
			$this->send_whatsapp_msg($insert_id);
			if (!empty($insert_id) && !empty($_POST['property_id'])) {

				$directincome_group = $this->db->table('groups')->where('name', 'Sales')->where('parent_id', 26)->get()->getRowArray();
				if (!empty($directincome_group)) {
					$dic_id = $directincome_group['id'];
				} else {
					$dic1['parent_id'] = 26;
					$dic1['name'] = 'Sales';
					$dic1['code'] = '330';
					$dic1['added_by'] = $this->session->get('log_id');
					$this->db->table('groups')->insert($dic1);
					$dic_id = $this->db->insertID();
				}
				// Rendal ledger
				$rental_ledger = $this->db->table('ledgers')->where('name', 'RENTAL RECEIVED')->where('left_code', '7003')->where('group_id', $dic_id)->get()->getRowArray();
				if (!empty($rental_ledger)) {
					$rr_id = $rental_ledger['id'];
				} else {
					$led1['group_id'] = $dic_id;
					$led1['name'] = 'RENTAL RECEIVED';
					$led1['code'] = '7003/000';
					$led1['op_balance'] = '0';
					$led1['op_balance_dc'] = 'D';
					$led1['left_code'] = '7003';
					$led1['right_code'] = '000';
					$this->db->table('ledgers')->insert($led1);
					$rr_id = $this->db->insertID();
				}
				$cashinhand = $this->db->table('groups')->where('name', 'Cash-in-Hand')->where('parent_id', 3)->get()->getRowArray();
				if (!empty($cashinhand)) {
					$cih_id = $cashinhand['id'];
				} else {
					$cih1['parent_id'] = 3;
					$cih1['name'] = 'Cash-in-Hand';
					$cih1['code'] = '111';
					$cih1['added_by'] = $this->session->get('log_id');
					$this->db->table('ledgers')->insert($cih1);
					$cih_id = $this->db->insertID();
				}
				$ledger2 = $this->db->table('ledgers')->where('name', 'PETTY CASH')->where('group_id', $cih_id)->get()->getRowArray();
				if (!empty($ledger2)) {
					$cr_id1 = $ledger2['id'];
				} else {
					$cled1['group_id'] = $cih_id;
					$cled1['name'] = 'PETTY CASH';
					$cled1['op_balance'] = '0';
					$cled1['op_balance_dc'] = 'C';
					$cled_ins1 = $this->db->table('ledgers')->insert($cled1);
					$cr_id1 = $this->db->insertID();
				}
				if (!empty($_POST['paymentmode'])) {
					if (empty($id) && $id == "") {
						//Payment Mode Details
						$payment_mode_details = $this->db->table('payment_mode')->where('id', $data['payment_mode'])->get()->getRowArray();
						$pyemnt_ledger_id = !empty($payment_mode_details['ledger_id']) ? $payment_mode_details['ledger_id'] : 1;
						$number = $this->db->table('entries')->select('number')->where('entrytype_id', 1)->orderBy('id', 'desc')->get()->getRowArray();
						if (empty($number)) {
							$num = 1;
						} else {
							$num = $number['number'] + 1;
						}
						$date = explode('-', date("Y-m-d"));
						$yr = $date[0];
						$mon = $date[1];
						$qry = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='" . $yr . "' and entrytype_id =1 and month (date)='" . $mon . "')")->getRowArray();
						$entries['entry_code'] = 'REC' . date('y') . $mon . (sprintf("%05d", (((float) substr($qry['entry_code'], -5)) + 1)));
						$entries['entrytype_id'] = '1';
						$entries['number'] = $num;
						$entries['date'] = date("Y-m-d");
						$entries['dr_total'] = $data['amount'];
						$entries['cr_total'] = $data['amount'];
						$entries['narration'] = 'Rental';
						$entries['inv_id'] = $insert_id;
						$entries['type'] = '1';
						$ent = $this->db->table('entries')->insert($entries);
						$en_id = $this->db->insertID();
						if (!empty($en_id)) {
							$eitems_d['entry_id'] = $en_id;
							$eitems_d['ledger_id'] = $rr_id;
							$eitems_d['amount'] = $data['amount'];
							$eitems_d['dc'] = 'C';
							$cr_res = $this->db->table('entryitems')->insert($eitems_d);

							$eitems_c['entry_id'] = $en_id;
							$eitems_c['ledger_id'] = $pyemnt_ledger_id;
							$eitems_c['amount'] = $data['amount'];
							$eitems_c['dc'] = 'D';
							$deb_res = $this->db->table('entryitems')->insert($eitems_c);
						}
					}
				}
			}
			$array_id[] = $insert_id;
		}

		return $array_id;
	}
	public function store()
	{
		$msg_data = array();
		if($_POST['typeSelection'] == "single"){
			$insertid_data = $this->singlerental();
			$rental_print['rental_ids'] = implode(',',$insertid_data);
			$this->db->table('rental_print')->insert($rental_print);
			$rental_id = $this->db->insertID();
			$msg_data['id'] = $rental_id;
		}
		if($_POST['typeSelection'] == "multiple"){
			$tesst = $this->multiplerental();
			$rental_print_mul['rental_ids'] = implode(',',$tesst);
			$this->db->table('rental_print')->insert($rental_print_mul);
			$rental_id = $this->db->insertID();
			$msg_data['id'] = $rental_id;
		}
		echo json_encode($msg_data);
		exit;
	}
	public function print_single_multiple($id)
	{
		$data['id'] = $id;
		echo view('rental/print_single_multiple', $data);
	}
	public function print($id)
	{
		$data['rental'] = $this->db->table('rental')
			->join('properties', 'rental.property_id = properties.id')
			->select('rental.*,properties.lot_no,properties.area')
			->where("rental.id", $id)
			->get()
			->getRowArray();
		$data['pay_details'] = $this->db->table("rental_pay_details")->where("rental_id", $id)->get()->getResultArray();
		echo view('rental/print', $data);
	}
	public function store_old()
	{
		//var_dump($_POST);
		//exit;
		$msg_data = array();
		$id = $_POST['id'];
		$data['month_year'] = $_POST['rental_monthyear'];
		if($_POST['typeSelection'] == "single"){
			$data['amount'] = $_POST['rental_amount'];
		}
		else{
			$data['amount'] = $_POST['totalAmount'];
		}
	
		$data['payee_name'] = $_POST['rental_paynee_name'];
		$data['payee_description'] = $_POST['rental_description'];
		$data['payment_mode'] = $_POST['paymentmode'];
		$payid = $_POST['paymentmode'];

		$check_payment_mode = $this->db->query("SELECT payment_mode.name FROM payment_mode WHERE id = $payid ")->getRowArray();
		//var_dump($check_payment_mode);
		//exit;
		if (strtolower($check_payment_mode['name']) == "online") {
			$data['transaction_date'] = $_POST['paymentmode_transaction_date'];
			$data['ref_no'] = $_POST['paymentmode_transaction_no'];
			$data['cheque_date'] = NULL;
			$data['cheque_no'] = NULL;
		} else if (strtolower($check_payment_mode['name']) == "cheque") {
			$data['cheque_date'] = $_POST['paymentmode_cheque_date'];
			$data['cheque_no'] = $_POST['paymentmode_cheque_no'];
			$data['transaction_date'] = NULL;
			$data['ref_no'] = NULL;
		} else {
			$data['cheque_date'] = NULL;
			$data['cheque_no'] = NULL;
			$data['transaction_date'] = NULL;
			$data['ref_no'] = NULL;
		}
		//ip location and ip details
		$ip = 'unknown';
		$this->requestmodel = new RequestModel();
		$ip = $this->requestmodel->getIpAddress();
		if ($ip != 'unknown') {
			$ip_details = $this->requestmodel->getLocation($ip);
			$data['ip'] = $ip;
			$data['ip_location'] = (!empty($ip_details['country']) ? $ip_details['country'] : 'Unknown');
			$data['ip_details'] = json_encode($ip_details);
		}

		if (empty($id)) {
			$data['property_id'] = $_POST['property_id'];
			$data['tenn_prop_id'] = $_POST['tenn_prop_id'];
			$data['created_at'] = date('Y-m-d H:i:s');
			$builder = $this->db->table('rental')->insert($data);
			$insert_id = $this->db->insertID();
			$pp_id = $_POST['property_id'];
			$pp_tan_id = $_POST['tenn_prop_id'];
			$res_maxvalue = $this->db->query("SELECT MAX(rental.month_year) as monthyear FROM properties JOIN rental ON rental.property_id = properties.id WHERE properties.property_status != 3 and rental.property_id = $pp_id and rental.tenn_prop_id = $pp_tan_id GROUP BY rental.property_id ")->getResultArray();
			if (count($res_maxvalue) > 0) {
				$pro_tan_id = $_POST['tenn_prop_id'];
				$property_tenant_id = $this->db->query("SELECT tennant_property.id as tent_id,tennant_property.end_date FROM properties join tennant_property ON tennant_property.property_id = properties.id WHERE tennant_property.id = $pro_tan_id and tennant_property.status = 1 ")->getRowArray();
				$protanid = $property_tenant_id['tent_id'];
				if ($_POST['rental_monthyear'] == date("Y-m", strtotime($res_maxvalue[0]['end_date']))) {
					$this->db->table('tennant_property')->where('id', $protanid)->update(array("status" => 0));
				}
			}
		} else {
			$data['updated_at'] = date('Y-m-d H:i:s');
			$builder = $this->db->table('rental')->where('id', $id)->update($data);
			$insert_id = $id;
		}

		if (!empty($insert_id) && !empty($_POST['property_id'])) {

			$directincome_group = $this->db->table('groups')->where('name', 'Sales')->where('parent_id', 26)->get()->getRowArray();
			if (!empty($directincome_group)) {
				$dic_id = $directincome_group['id'];
			} else {
				$dic1['parent_id'] = 26;
				$dic1['name'] = 'Sales';
				$dic1['code'] = '330';
				$dic1['added_by'] = $this->session->get('log_id');
				$this->db->table('groups')->insert($dic1);
				$dic_id = $this->db->insertID();
			}
			// Rendal ledger
			$rental_ledger = $this->db->table('ledgers')->where('name', 'RENTAL RECEIVED')->where('left_code', '7003')->where('group_id', $dic_id)->get()->getRowArray();
			if (!empty($rental_ledger)) {
				$rr_id = $rental_ledger['id'];
			} else {
				$led1['group_id'] = $dic_id;
				$led1['name'] = 'RENTAL RECEIVED';
				$led1['code'] = '7003/000';
				$led1['op_balance'] = '0';
				$led1['op_balance_dc'] = 'D';
				$led1['left_code'] = '7003';
				$led1['right_code'] = '000';
				$this->db->table('ledgers')->insert($led1);
				$rr_id = $this->db->insertID();
			}
			$cashinhand = $this->db->table('groups')->where('name', 'Cash-in-Hand')->where('parent_id', 3)->get()->getRowArray();
			if (!empty($cashinhand)) {
				$cih_id = $cashinhand['id'];
			} else {
				$cih1['parent_id'] = 3;
				$cih1['name'] = 'Cash-in-Hand';
				$cih1['code'] = '111';
				$cih1['added_by'] = $this->session->get('log_id');
				$this->db->table('ledgers')->insert($cih1);
				$cih_id = $this->db->insertID();
			}
			$ledger2 = $this->db->table('ledgers')->where('name', 'PETTY CASH')->where('group_id', $cih_id)->get()->getRowArray();
			if (!empty($ledger2)) {
				$cr_id1 = $ledger2['id'];
			} else {
				$cled1['group_id'] = $cih_id;
				$cled1['name'] = 'PETTY CASH';
				$cled1['op_balance'] = '0';
				$cled1['op_balance_dc'] = 'C';
				$cled_ins1 = $this->db->table('ledgers')->insert($cled1);
				$cr_id1 = $this->db->insertID();
			}
			//$prop_data = $this->db->table('properties')->where('id', $_POST['property_id'])->get()->getResultArray();
			//$temple_id = $prop_data['temple_id'];
			if (!empty($_POST['paymentmode'])) {
				if (empty($id) && $id == "") {
					//Payment Mode Details
					$payment_mode_details = $this->db->table('payment_mode')->where('id', $data['payment_mode'])->get()->getRowArray();
					$pyemnt_ledger_id = !empty($payment_mode_details['ledger_id']) ? $payment_mode_details['ledger_id'] : 1;
					$number = $this->db->table('entries')->select('number')->where('entrytype_id', 1)->orderBy('id', 'desc')->get()->getRowArray();
					if (empty($number)) {
						$num = 1;
					} else {
						$num = $number['number'] + 1;
					}
					$date = explode('-', date("Y-m-d"));
					$yr = $date[0];
					$mon = $date[1];
					$qry = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='" . $yr . "' and entrytype_id =1 and month (date)='" . $mon . "')")->getRowArray();
					$entries['entry_code'] = 'REC' . date('y') . $mon . (sprintf("%05d", (((float) substr($qry['entry_code'], -5)) + 1)));
					$entries['entrytype_id'] = '1';
					$entries['number'] = $num;
					$entries['date'] = date("Y-m-d");
					$entries['dr_total'] = $data['amount'];
					$entries['cr_total'] = $data['amount'];
					$entries['narration'] = 'Rental';
					$entries['inv_id'] = $insert_id;
					$entries['type'] = '1';
					$ent = $this->db->table('entries')->insert($entries);
					$en_id = $this->db->insertID();
					if (!empty($en_id)) {
						$eitems_d['entry_id'] = $en_id;
						$eitems_d['ledger_id'] = $rr_id;
						$eitems_d['amount'] = $data['amount'];
						$eitems_d['dc'] = 'C';
						$cr_res = $this->db->table('entryitems')->insert($eitems_d);

						$eitems_c['entry_id'] = $en_id;
						$eitems_c['ledger_id'] = $pyemnt_ledger_id;
						$eitems_c['amount'] = $data['amount'];
						$eitems_c['dc'] = 'D';
						$deb_res = $this->db->table('entryitems')->insert($eitems_c);
					}
					//var_dump($en_id);
					//exit;

				}
			}
			$msg_data['id'] = $insert_id;
		}
		echo json_encode($msg_data);
		exit;
		//$this->session->setFlashdata('succ', 'Rental payment added successfully');
		//return redirect()->to("/rental");
	}
	public function get_payment_mode()
	{
		$id = $_POST['id'];
		$res = $this->db->table("payment_mode")->where("id", $id)->get()->getRowArray();
		$ledger_id = $res['ledger_id'];
		$name = $res['name'];
		$data['ledger_id'] = $ledger_id;
		$data['name'] = $name;
		echo json_encode($data);
	}
	public function findpropertyNameExists()
	{
		$property_id = $this->request->getPost('property_id');
		$rental_monthyear = $this->request->getPost('rental_monthyear');
		$tenn_prop_id = $this->request->getPost('tenn_prop_id');
		$updateid = $this->request->getPost('update_id');
		if (!empty($updateid)) {
			$query = $this->db->table('rental')->where(['property_id' => $property_id, 'tenn_prop_id' => $tenn_prop_id, 'month_year' => $rental_monthyear, 'id !=' => $updateid])->countAllResults();
		} else {
			$query = $this->db->table('rental')->where(['property_id' => $property_id, 'tenn_prop_id' => $tenn_prop_id, 'month_year' => $rental_monthyear])->countAllResults();
		}
		if ($query > 0) {
			echo "false";
		} else {
			echo "true";
		}
	}
	public function print_rental()
	{
		$data = array();
		$res = $this->db->table('rental')->select("rental.*, property_category.name, properties.name as propertyname")->join("properties", "properties.id = rental.property_id", "inner")->join("property_category", "property_category.id = properties.property_category_id", "inner")->get()->getResultArray();

		$data['data'] = $res;
		if ($_REQUEST['pdf_data'] == "PDF") {
			$file_name = "rental_" . date("dmY");
			$dompdf = new \Dompdf\Dompdf();
			$options = $dompdf->getOptions();
			$options->set(array('isRemoteEnabled' => true));
			$dompdf->setOptions($options);
			$dompdf->loadHtml(view('rental/pdf/rental_print', ["pdfdata" => $data]));
			$dompdf->setPaper('LEGAL', 'portrait');
			$dompdf->render();
			$dompdf->stream($file_name);
		} else if ($_REQUEST["excel_data"] == "EXCEL") {
			$fileName = "rental_" . date("dmY");
			$spreadsheet = new Spreadsheet();

			$sheet = $spreadsheet->getActiveSheet();
			$sheet->getStyle('A1')->getFont()->setBold(true)->setName('Arial')->SetSize(10);
			$style = array(
				'alignment' => array(
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				)
			);
			$sheet->getStyle("A1:E1")->applyFromArray($style);
			$sheet->getStyle("A2:E2")->applyFromArray($style);
			$sheet->mergeCells('A1:E1');
			$sheet->mergeCells('A2:E2');
			$sheet->setCellValue('A1', "");
			$sheet->setCellValue('A2', 'RENTAL LIST');

			$sheet->setCellValue('A4', "SNo");
			$sheet->setCellValue('B4', "Property Name");
			$sheet->setCellValue('C4', "Month / Year");
			$sheet->setCellValue('D4', "Amount");
			$sheet->setCellValue('E4', "Payee Name");

			$rows = 5;
			$i = 1;
			foreach ($data['data'] as $key => $row) {
				$sheet->setCellValue('A' . $rows, $i);
				$sheet->setCellValue('B' . $rows, $row['propertyname']);
				$sheet->setCellValue('C' . $rows, $row['month_year']);
				$sheet->setCellValue('D' . $rows, $row['amount']);
				$sheet->setCellValue('E' . $rows, $row['payee_name']);
				$rows++;
				$i++;
			}

			$writer = new Xlsx($spreadsheet);
			$writer->save('uploads/excel/' . $fileName . '.xlsx');
			return $this->response->download('uploads/excel/' . $fileName . '.xlsx', null)->setFileName($fileName . '.xlsx');
		} else {
			echo view('rental/print/rental_print', $data);
		}
	}
	public function get_properties_amount()
	{
		if (!empty($_POST['prop_id'])) {
			$id = $_POST['prop_id'];
			$res = $this->db->query("SELECT properties.rental_value as amount,tennant.address,tennant.name as payee_name,tennant_property.due_start_month,tennant_property.end_date,tennant_property.id as tenn_prop_id FROM tennant_property JOIN properties ON properties.id = tennant_property.property_id JOIN tennant ON tennant.id = tennant_property.tennant_id WHERE tennant_property.status = 1 AND properties.id = '$id' ")->getRowArray();
			$amount_val = !empty($res['amount']) ? $res['amount'] : 0;
			$address = !empty($res['address']) ? $res['address'] : "";
			$payee_name = !empty($res['payee_name']) ? $res['payee_name'] : "";
			$tenn_prop_id = $res['tenn_prop_id'];
			$min_month = date("Y-m", strtotime($res['due_start_month']));

			$res_maxvalue = $this->db->query("SELECT MAX(rental.month_year) as monthyear FROM properties JOIN rental ON rental.property_id = properties.id WHERE properties.property_status != 3 and rental.property_id = $id and rental.tenn_prop_id = $tenn_prop_id GROUP BY rental.property_id ")->getResultArray();
			if (count($res_maxvalue) > 0) {
				$reentdate = $res_maxvalue[0]['monthyear'] . "-01";
				$end_time = strtotime($reentdate);
				if (date("Y-m", strtotime($res['end_date'])) == $res_maxvalue[0]['monthyear']) {
					$max_month = date("Y-m", strtotime($res['end_date']));
				} else {
					$max_month = date("Y-m", strtotime("+1 month", $end_time));
				}
			} else {
				$max_month = date("Y-m", strtotime($res['due_start_month']));
			}
		}
		$json_resp = array("amount" => $amount_val, "address" => $address, "payee_name" => $payee_name, "min_month" => $min_month, "max_month" => $max_month, "tenn_prop_id" => $tenn_prop_id);
		echo json_encode($json_resp);
		exit;
	}
	public function default_list()
	{
		//rental_value
		if ($_POST['rental_monthyear'])
			$rental_monthyear = $_POST['rental_monthyear'];
		else
			$rental_monthyear = date("m/Y");
		$convert_date = explode("/", $rental_monthyear);
		$str_to_date_convert = $convert_date[1] . "-" . $convert_date[0];
		//echo $str_to_date_convert;
		$datalist = $this->db->query("SELECT tennant.phone as phone_no,tennant.phonecode as areacode,tennant.name as tennant_name, properties.id as property_id, properties.name as property_name,properties.rental_value as amount FROM properties JOIN tennant_property ON tennant_property.property_id = properties.id JOIN tennant ON tennant.id = tennant_property.tennant_id  WHERE DATE_FORMAT(tennant_property.due_start_month,'%Y-%m') <= '$str_to_date_convert' AND DATE_FORMAT(tennant_property.end_date,'%Y-%m') >= '$str_to_date_convert' AND tennant.status = 1  ")->getResultArray();
		$retn_array = array();
		foreach ($datalist as $roww) {
			$paid_rental = $this->db->table("rental")->select('SUM(rental.amount) as paidamt')->where("rental.property_id", $roww['property_id'])->where("rental.month_year", $str_to_date_convert)->get()->getRowArray();
			//echo $paid_rental['paidamt'];
			//echo $roww['amount'];
			if (floatval($paid_rental['paidamt']) == floatval($roww['amount']) || floatval($paid_rental['paidamt']) > floatval($roww['amount'])) {
				//echo "Full Paid";
			} else {
				//echo "Half Paid";
				$pending_amt = $roww['amount'] - $paid_rental['paidamt'];
				$due_date = $str_to_date_convert . "-01";
				$converted_month = date("M", strtotime($due_date));
				$phone_with_code = $roww['areacode'] . "" . $roww['phone_no'];
				$retn_array[] = array("phone_no" => $phone_with_code, "tennant_name" => $roww['tennant_name'], "property_id" => $roww['property_id'], "property_name" => $roww['property_name'], "amount" => $roww['amount'], "pending_amount" => $pending_amt, "due_month" => $converted_month);
			}
		}
		//echo $rental_monthyear;
		//exit;
		$data['list'] = $retn_array;
		//exit;
		//echo $this->db->getLastQuery(); die;
		$data['rental_monthyear'] = $rental_monthyear;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('rental/default_list', $data);
		echo view('template/footer');
	}
	public function get_multiple_choosecount()
	{
		$propid = $_POST['propp_id'];
		$tenn_propid = $_POST['tenn_propid'];
		$count = getpropertyduemonthcount($tenn_propid,$propid);
		$tot_paid_count = $count['unpaid_count'];
		$html = '<option value="">Select number of months</option>';
		if($tot_paid_count > 0){
			for($i = 1; $i <= $tot_paid_count; $i++){
				$html .= '<option value='.$i.'>'.$i.'</option>';
			}
		}
		echo $html;
	}
	public function send_whatsapp_msg($id)
	{
		$data['rental'] = $rental = $this->db->table('rental')
			->join('properties', 'rental.property_id = properties.id')
			->join('tennant_property', 'tennant_property.id = rental.tenn_prop_id')
			->join('tennant', 'tennant.id = tennant_property.tennant_id')
			->select('rental.*,properties.lot_no,properties.area, tennant.phonecode, tennant.phone')
			->where("rental.id", $id)
			->get()
			->getRowArray();
		$data['pay_details'] = $this->db->table("rental_pay_details")->where("rental_id", $id)->get()->getResultArray();
		$tmpid = 1;
		$data['temp_details'] = $temp_details = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
		$mobile_number = array();
		if(!empty($temp_details['daily_closing_phone'])){
			$daily_closing_phone = json_decode($temp_details['daily_closing_phone'], true);
			if(!empty($daily_closing_phone[0]['phonecode']) && !empty($daily_closing_phone[0]['phoneno'])){
				foreach($daily_closing_phone as $dcp){
					$mobile_number[] = $dcp['phonecode'] . $dcp['phoneno'];
				}
			}
		}
		if(empty($rental['phonecode'])) $rental['phonecode'] = '+60';
		$mobile_number[] = $rental['phonecode'] . $rental['phone'];
		$dompdf = new \Dompdf\Dompdf();
		$options = $dompdf->getOptions();
		$options->set(array('isRemoteEnabled' => true));
		$dompdf->setOptions($options);
		$html = view('rental/print_pdf', $data);
		$dompdf->loadHtml(view('rental/print_pdf', ["pdfdata" => $data]));
		$dompdf->setPaper('A4', 'portrait');
		$dompdf->render();
		$filePath = FCPATH . 'uploads/documents/invoice_rental_' . $id . '.pdf';

		file_put_contents($filePath, $dompdf->output());
		$message_params = array();
		$media['url'] = base_url() . '/uploads/documents/invoice_rental_' . $id . '.pdf';
		if(count($mobile_number) > 0){
			foreach($mobile_number as $mn){
				$media['filename'] = 'rental_invoice.pdf';
				//$mn = '+918012288811';
				// print_r($mobile_number);
				// print_r($message_params);
				// print_r($media);
				// die; 
				$whatsapp_resp = whatsapp_aisensy($mn, $message_params, 'rental_receipt_live', $media);
				//print_r($whatsapp_resp);
			}
		}
	}
	
}