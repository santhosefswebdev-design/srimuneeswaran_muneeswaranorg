<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PermissionModel;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\RequestModel;

class Templehallbooking extends BaseController
{
	function __construct()
	{
		parent::__construct();
		helper('url');
		helper('common');
		$this->model = new PermissionModel();
		if (($this->session->get('login')) == false && $this->session->get('role') != 1) {
			$data['dn_msg'] = 'Please Login';
			header('Location: ' . base_url() . '/login');
			exit;
		}
	}

	public function index()
	{
		$data = array();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('templehallbooking/index', $data);
		echo view('template/footer');
	}

	
	public function add_booking()
	{
	//   if (!$this->model->permission_validate('templehallbooking', 'create_p')) {
	// 	header('Location: ' . base_url() . '/dashboard');
	//   }
	$data['permission'] = $this->model->get_permission('hallbooking');
	$date = $this->request->uri->getSegment(3);
	$cur_date = date('Y-m-d');
	$date_three_days_ago = date('Y-m-d', strtotime('+3 days', strtotime($cur_date)));
	$data["temple_block_date"] = "";
		
	if ($date > $date_three_days_ago) {
	
	// $res = $this->db->table("booking_slot_new")
    //     ->select("booking_slot_new.*, booking_slot_type_new.*")
    //     ->join("booking_slot_type_new", "booking_slot_type_new.booking_slot_id = booking_slot_new.id", "left")
    //     ->where("booking_slot_type_new.slot_type", 2)
    //     ->where("booking_slot_new.status", 1)
    //     ->get()
    //     ->getResultArray();

    // // Process the results if needed
    // $data_time = array();
    // $time_name = array();
    // foreach ($res as $r) {
    //     $data_time[] = $r['id'];
    //     $time_name[$r['id']] = $r['slot_name'];
    // }
	//   //die;
		
		$retndate = $this->db->table('overall_temple_block')->select('date')->where('date', $date)->get()->getRowArray();
		if($retndate){
			$data["temple_block_date"] = "Kindly select various dates";
			echo view('template/header');
			echo view('template/sidebar');
			echo view('templehallbooking/index', $data);
			echo view('template/footer');

		} else {
			$data['date'] = $date;
			//   $data['data_time'] = $data_time;
			//   $data['time_name'] = $time_name;
			$data['time_list'] = $this->db->table("booking_slot_new")
			->select("booking_slot_new.*, booking_slot_type_new.*")
			->join("booking_slot_type_new", "booking_slot_type_new.booking_slot_id = booking_slot_new.id", "left")
			->where("booking_slot_type_new.slot_type", 1)
			->where("booking_slot_new.status", 1)
			->get()
			->getResultArray();
			$query = $this->db->query("SELECT hall FROM terms_conditions ");
			$result = $query->getRowArray();
			// $data['terms'] = json_decode($result['hall'], true);
			$data['terms'] = array();
			$data['staff'] = $this->db->table("staff")->where('is_admin', 0)->get()->getResultArray();
			// $data['package'] = $this->db->table("temple_packages")->where('package_type', 2)->where('status', 1)->get()->getResultArray();
			$data['package'] = array();
			$data['package_addon'] = $this->db->table("temple_services")->where('service_type', 1)->where('add_on', 1)->where('status', 1)->get()->getResultArray();
			$data['payment_modes'] = $this->db->table('payment_mode')->where('status', 1)->where('paid_through', 'DIRECT')->get()->getResultArray();
			$data['phone_codes'] = $this->db->table("phone_code")->orderBy('dailing_code', 'ASC')->get()->getResultArray();
			echo view('template/header');
			echo view('template/sidebar');
			echo view('templehallbooking/add_booking', $data);
			echo view('template/footer');
		}
	} else {
		$data["temple_block_date"] = "You can book 3 days after today's date.";
		echo view('template/header');
		echo view('template/sidebar');
		echo view('templehallbooking/index', $data);
		echo view('template/footer');
	}
	}
	public function getpack_amt()
	{
	  $id = $_POST['id'];
	  $res = $this->db->table("temple_packages")->where("id", $id)->get()->getRowArray();
	  //$amt = $res['amount'] + $res['commision'];
	  $amt = $res['amount'];
	  $data['amt'] = $amt;
	  $data['name'] = $res['name'];
	  echo json_encode($data);
	}
	public function get_service_list()
	{
		$resp = array();
		$pack_id = $_POST['id'];
		$get_result_details = $this->db->table("temple_packages")->where("id", $pack_id)->get()->getResultArray();
		$resp['data']['services'] = $get_result_details;
		$resp['data']['addons'] =  $this->db->query("select * from temple_services where id in(select service_id from temple_package_addons where package_id in ($pack_id))")->getResultArray();
		echo json_encode($resp);
	}
  public function get_service_name()
  {
    $id = $_POST['id'];
    $res = $this->db->table("temple_packages")->where("id", $id)->get()->getRowArray();
    $data['name'] = $res['name'];
    $data['amount'] = $res['amount'];
    $data['description'] = $res['description'];
    echo json_encode($data);
  }

  public function getpack_amt_addon()
	{
	  $id = $_POST['id'];
	  $res = $this->db->table("temple_services")->where("id", $id)->get()->getRowArray();
	  //$amt = $res['amount'] + $res['commision'];
	  $amt = $res['amount'];
	  $data['amt'] = $amt;
	  $data['name'] = $res['name'];
	  echo json_encode($data);
	}
	public function get_service_list_addon()
	{
		$addon_id = $_POST['id'];
		$package_id = $_POST['package_id'];
		$get_result_details = $this->db->table("temple_services")->join('temple_package_addons', 'temple_package_addons.service_id = temple_services.id')->select('temple_services.*, temple_package_addons.quantity')->where("temple_package_addons.package_id", $package_id)->where("temple_package_addons.service_id", $addon_id)->get()->getResultArray();
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
  public function hallbook_list()
  {
    $data['permission'] = $this->model->get_permission('hall_booking');
    $date = $_REQUEST['date'];

	$data["temple_block_date"] = "";
	$retndate = $this->db->table('overall_temple_block')->select('date')->where('date', $date)->get()->getRowArray();
	if($retndate){
		$data["temple_block_date"] = "Kindly select various date";
		echo view('template/header');
		echo view('template/sidebar');
		echo view('templehallbooking/index', $data);
		echo view('template/footer');

	} else {
		$data['list'] = $this->db->table("templebooking")->where("DATE_FORMAT(templebooking.booking_date, '%Y-%m-%d')", $date)->where('templebooking.booking_type', 1)->get()->getResultArray();
		$data['payment_modes'] = $this->db->table('payment_mode')->where('status', 1)->where('paid_through', 'DIRECT')->get()->getResultArray();
		// foreach ($data['list'] as &$d_list) {
		//   $slot_details = $this->db->table("booking_slot")->select('booking_slot.*')->join('hallbooking_slot_details', 'hallbooking_slot_details.booking_slot_id = booking_slot.id')->where("hallbooking_slot_details.hallbooking_id", $d_list['id'])->get()->getResultArray();
		//   $d_list['slot_details'] = $slot_details;
		// }
		$data['date'] = $date;
		// print_r($data);die;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('templehallbooking/templehallbookinglist', $data);
		echo view('template/footer');
	}

    
  }
	public function overall_blocked_event_check(){
		$eventdate = $_POST['eventdate'];
		$retndate = $this->db->table('overall_temple_block')->select('date')->where('date', $eventdate)->get()->getRowArray();
		echo !empty($retndate['date']) ? $retndate['date'] : "";
	}
	public function print_page()
	{
		if (!$this->model->permission_validate('hallbooking', 'print')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		// echo  $id;
		//  exit ;
		$data['qry1'] = $this->db->table('templebooking')
			->where('templebooking.id', $id)
			->get()->getRowArray();
		$query = $this->db->table("booked_packages")
		->select('name') 
		->where('booking_id', $id)
		->get()->getResultArray();

		$package_names = '';
		if (!empty($query)) {
			$names = array_column($query, 'name'); 
			$package_names = implode(',', $names);
		}
		$data['package_names'] = $package_names;
		// $data['terms'] = $this->db->table("terms_conditions")->get()->getRowArray();
		$query = $this->db->query("SELECT hall FROM terms_conditions ");
		$result = $query->getRowArray();
		$data['terms'] = json_decode($result['hall'], true);
		$data['booked_addon'] = $this->db->table("booked_addon")->where("booking_id", $id)->get()->getResultArray();
		$data['pay_details'] = $this->db->table("booked_pay_details")->where("booking_id", $id)->get()->getResultArray();
		echo view('templehallbooking/print_page', $data);
	}
	public function gtpaymentdata()
	{
		$id = $_POST['id'];
		$res = $this->db->table("templebooking")->where("id", $id)->get()->getRowArray();
		//$amt = $res['amount'] + $res['commision'];
		$amt = $res['amount'];
		$data['amt'] = $amt;
		$res1 = $this->db->table("booked_pay_details")->selectSum('amount')->where("booking_id", $id)->get()->getRowArray();
		$paid_amount = $res1['amount'];
		$data['paid_amount'] = $paid_amount;
		$data['bal_amount'] = $amt - $paid_amount;

		echo json_encode($data);
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
				$hall_details = $this->db->table("templebooking")->where('id', $booking_id)->get()->getRowArray();
				if($hall_details['amount'] >= ($hall_details['paid_amount'] + $pay_amount)){
					$booking_payment_ins_data = array();
					$booking_payment_ins_data['booking_id'] = $booking_id;
					$booking_payment_ins_data['booking_type'] = 1;
					$booking_payment_ins_data['booking_ref_no'] = $hall_details['ref_no'];
					$booking_payment_ins_data['payment_mode_id'] = $payment_mode;
					$booking_payment_ins_data['paid_date'] = !empty($date) ? $date : date('Y-m-d');
					$booking_payment_ins_data['amount'] = $pay_amount;
					$booking_payment_ins_data['payment_mode_title'] = $payment_mode_details['name'];
					$paid_through = 'DIRECT';
					if($paid_through != 'DIRECT' && $paid_through != 'COUNTER') $booking_payment_ins_data['payment_ref_no'] = $hall_details['ref_no'];
					$booking_payment_ins_data['paid_through'] = $paid_through;
					$booking_payment_ins_data['pay_status'] = ($paid_through == 'DIRECT' || $paid_through == 'COUNTER') ? 2 : 1;
					$this->requestmodel = new RequestModel();
					$ip = $this->requestmodel->getIpAddress();
					$booking_payment_ins_data['ip'] = $ip;
					if ($ip != 'unknown') {
						$ip_details = $this->requestmodel->getLocation($ip);
						$booking_payment_ins_data['ip_location'] = (!empty($ip_details['country']) ? $ip_details['country'] : 'Unknown');
						$booking_payment_ins_data['ip_details'] = json_encode($ip_details);
					} 
					// $this->paid_amount += $booking_payment_ins_data['amount'];
					$res = $this->db->table("booked_pay_details")->insert($booking_payment_ins_data);
					$booked_pay_id = $this->db->insertID();
					$this->db->query("UPDATE templebooking SET paid_amount = paid_amount + ? WHERE id = ?", [$pay_amount, $booking_id]);
					$this->partial_account_migration($booked_pay_id);
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
			$booking_id = $booked_pay_details[0]['booking_id'];
			$templehallbooking = $this->db->table("templebooking")->where("id", $booking_id)->get()->getRowArray();
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

					$entries['entry_code'] = 'REC' . date('y', strtotime($entry_date)) . $mon . (sprintf("%05d", (((float) substr($qry['entry_code'], -5)) + 1)));
					$entries['entrytype_id'] = '1';
					$entries['number'] = $num;
					$entries['date'] = $entry_date;
					$entries['dr_total'] = $row['amount'];
					$entries['cr_total'] = $row['amount'];
					$entries['narration'] = 'Hall Booking(' . $templehallbooking['ref_no'] . ')' . "\n" . 'name:' . $templehallbooking['name'] . "\n" . 'NRIC:' . $templehallbooking['ic_number'] . "\n" . 'email:' . $templehallbooking['email'] . "\n";
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
						$eitems_hall_book['details'] = 'Hall Booking Amount';
						$this->db->table('entryitems')->insert($eitems_hall_book);
						// PETTY CASH => Debit 
						$eitems_cash_led['entry_id'] = $en_id;
						$eitems_cash_led['ledger_id'] = $paymentmode['ledger_id'];
						$eitems_cash_led['amount'] = $row['amount'];
						$eitems_cash_led['dc'] = 'D';
						$eitems_cash_led['details'] = 'Hall Booking Amount';
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
	public function event_list()
  {
    $query = $this->db->query("SELECT  tu.id, tu.booking_date, tu.created_at, bp.name FROM  templebooking tu 
				JOIN booked_packages bp ON tu.id = bp.booking_id 
				WHERE tu.booking_status != 3
				and tu.booking_type = 1
				
				GROUP BY tu.booking_date
				ORDER BY tu.created_at ASC;");
    $res = $query->getResultArray();
    
    $res_array = array();
    foreach($res as $row){
        $html = $row['name'];
        $hb_booking_date = $row['booking_date'];
        // $hb_slot_id = $row['hall_id'];
        // $slot_dets = $this->db->query("SELECT bs.name,bs.description,bs.slot_season,hbsd.hallbooking_id FROM hallbooking_slot_details as hbsd JOIN booking_slot as bs ON bs.id = hbsd.booking_slot_id where hbsd.hallbooking_id = $hb_slot_id ")->getResultArray();
        // foreach($slot_dets as $slot_row){
        //     $hb_id = $slot_row['hallbooking_id'];
        //     $html[]= $slot_row['name']."-".$slot_row['description']."\n(".$slot_row['slot_season'].")"."\n";
        //     $service_dets = $this->db->query("SELECT hbsd.service_name FROM hallbooking_service_details as hbsd where hbsd.hallbooking_id = $hb_id ")->getResultArray();
        //     foreach($service_dets as $service_row){
        //         $html[]= $service_row['service_name']."\n";
        //     }
        // }
        $res_array[] = array('booking_date'=>$hb_booking_date,'slot_pack_dets'=>$html);
    }
    //var_dump(json_encode($res_array));
    //exit;
    echo json_encode($res_array);
  }
  public function update_booking_status()
{
    $id = $_POST['id'];
    $status = $_POST['status'];

    $data = [
        'booking_status' => $status
    ];

    $this->db->table('templebooking')
             ->where('id', $id)
             ->update($data);

    if($this->db->affectedRows() > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
}
}
