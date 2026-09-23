<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;
use Dompdf\Options;
class Member extends BaseController
{
    function __construct(){
        parent:: __construct();
        helper('url');
        helper('common_helper');
        $this->model = new PermissionModel();
        if( ($this->session->get('login') ) == false && $this->session->get('role') != 1){
            $data['dn_msg'] = 'Please Login';
            header('Location: '.base_url().'/login');
            exit;
		}
    }
    
    public function index(){
		if(!$this->model->list_validate('member')){
			header('Location: '.base_url().'/dashboard');
		}
		$data['permission'] = $this->model->get_permission('member');
		$qry =  $this->db->table('member', 'member_type.name as tname')
							->join('member_type', 'member_type.id = member.member_type')
							->select('member_type.name as tname')
							->select('member.*');
		 
	 	$res = $qry->get()->getResultArray();
		$data['list'] = $res;
        // echo '<pre>'; print_r($data); die;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('member/index',$data);
		echo view('template/footer');
    }
	public function view(){
	    if(!$this->model->permission_validate('member','view')){
			header('Location: '.base_url().'/dashboard');
		}
	    $id=  $this->request->uri->getSegment(3);
		
	    
	    $data['data'] = $this->db->table('member')->where('id', $id)->get()->getRowArray();
		$data['member_type_list'] = $this->db->table('member_type')->get()->getResultArray();
        $data['payment_modes'] = $this->db->table('payment_mode')->where('status', 1)->get()->getResultArray();
		$data['phone_codes'] = $this->db->table("phone_code")->orderBy('dailing_code', 'ASC')->get()->getResultArray();
	    $data['view'] = true;
	    echo view('template/header');
		echo view('template/sidebar');
		echo view('member/add', $data);
		echo view('template/footer');
	}
	public function add()
	{
		if(!$this->model->permission_validate('member', 'create_p')){
			header('Location: '.base_url().'/dashboard');
		}
        $query   = $this->db->query("select max(member_no) as member_no from member")->getRowArray();
		$data['data']['member_no']=  sprintf("%06d",(((float)  substr($query['member_no'],-5))+1));
		$data['payment_modes'] = $this->db->table('payment_mode')->where('status', 1)->where('paid_through', 'DIRECT')->get()->getResultArray();
		$data['member_type_list'] = $this->db->table('member_type')->get()->getResultArray();
		$data['phone_codes'] = $this->db->table("phone_code")->orderBy('dailing_code', 'ASC')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('member/add', $data);
		echo view('template/footer');
	}
	public function edit(){
	    if(!$this->model->permission_validate('member','edit')){
			header('Location: '.base_url().'/dashboard');			
		}
	    $id=  $this->request->uri->getSegment(3);
	    $data['data'] 		= $this->db->table('member')->where('id', $id)->get()->getRowArray();
		$data['member_type_list'] = $this->db->table('member_type')->get()->getResultArray();
        $data['payment_modes'] = $this->db->table('payment_mode')->where('status', 1)->get()->getResultArray();
		$data['phone_codes'] = $this->db->table("phone_code")->orderBy('dailing_code', 'ASC')->get()->getResultArray();
		$data['mode'] = 'edit';
		$data['edit'] = true;
	    echo view('template/header');
		echo view('template/sidebar');
		echo view('member/add', $data);
		echo view('template/footer');
	}

	public function save()
	{
		// echo '<pre>'; print_r($_POST); die;
		$id = $_POST['id'];
		$data['name'] = trim($_POST['name']);
		$data['member_type'] = trim($_POST['member_type']);
		$data['ic_no'] = trim($_POST['ic_number']);
		$data['dob'] = $_POST['dob'];

		if(empty($_POST['edit_status'])){
			$mble_phonecode = !empty($_POST['phonecode'])?$_POST['phonecode']:"";
			$mble_number = !empty($_POST['mobile'])?$_POST['mobile']:"";
			$data['mobile']  = $mble_phonecode.$mble_number;
		}
		else{
			$data['mobile'] = $_POST['mobile'];
		}

		$data['address'] = trim($_POST['address']);
		$data['joining_date'] = trim($_POST['start_date']);
		$data['start_date'] = trim($_POST['start_date']);
		// $data['end_date'] = date('Y-m-d', strtotime(trim($_POST['end_date'])));
		//ip location and ip details
		if ($_POST['member_type'] === '3') { // Assuming 3 is the numerical value for 'Lifetime'
			$data['end_date'] = null;
		} else {
			$data['end_date'] = date('Y-m-d', strtotime(trim($_POST['end_date'])));
		}
		$data['payment'] = trim($_POST['payment']);
		$data['payment_mode'] = trim($_POST['paymentmode']);
		$data['status'] = $_POST['status'];
		$data['email_address'] = $_POST['email_address'];
		$data['added_by'] = $this->session->get('log_id');
		$data['payment_status'] = 2;

		if (empty($id)) {
			// Application fee is a one-time charge at initial registration only (not on renewal/edit).
			$data['application_fee'] = !empty($_POST['application_fee']) ? trim($_POST['application_fee']) : 0.00;
			$query = $this->db->query("select max(member_no) as member_no from member")->getRowArray();
			$data['member_no'] = sprintf("%06d", (((float) substr($query['member_no'], -5)) + 1));
			$data['created'] = date('Y-m-d H:i:s');
			$data['modified'] = date('Y-m-d H:i:s');
			$res = $this->db->table('member')->insert($data);
			if ($res) {
				$ins_id = $this->db->insertID();
				$this->account_migration($ins_id,$content="Member Registration");
				//$this->send_whatsapp_msg($ins_id);
				if (!empty($_POST['email_address'])) {
					$temple_title = "Temple " . $_SESSION['site_title'];
					$mail_data['mem_id'] = $ins_id;
					$message = view('member/mail_template', $mail_data);
					$subject = $_SESSION['site_title'] . " Member Registration";
					$to_user = $_POST['email_address'];
					$to_mail = array("prithivitest@gmail.com", $to_user);
					send_mail_with_content($to_mail, $message, $subject, $temple_title);
				}
				$this->session->setFlashdata('succ', 'Member Added Successfully');
				header("Location: " . base_url() . "/member");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/member");
			}
		} else {
			$data['modified'] = date('Y-m-d H:i:s');
			$res = $this->db->table('member')->where('id', $id)->update($data);
			if ($res) {
				$this->session->setFlashdata('succ', 'Member Updated Successfully');
				header("Location: " . base_url() . "/member");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/member");
			}
		}
	}
	public function renewal_save()
	{
		$id = $_POST['id'];
		if (!empty($id)) {
			$data['start_date'] = date('Y-m-d');
			$endDate = date("Y-m-d", strtotime("+1 year -1 day", strtotime($data['start_date'])));
			$data['end_date'] = $endDate;
			$data['status'] = 1;
			$data['added_by'] = $this->session->get('log_id');
			$data['payment_status'] = 2;
			$data['payment_mode'] = trim($_POST['paymentmode']);
			$data['modified'] = date('Y-m-d H:i:s');
			$res = $this->db->table('member')->where('id', $id)->update($data);
			if ($res) {

				$renewal_data['member_id'] = $id;
				$renewal_data['renewal_start_date'] = date("Y-m-d");
				$renewal_data['renewal_end_date'] = $endDate;
				$this->db->table('member_renewal')->insert($renewal_data);

				$this->account_migration($id,$content="Member Renewal");
				//$this->send_whatsapp_msg($id);
				if (!empty($_POST['email_address'])) {
					$temple_title = "Temple " . $_SESSION['site_title'];
					$mail_data['mem_id'] = $id;
					$message = view('member/mail_template', $mail_data);
					$subject = $_SESSION['site_title'] . " Member Renewal";
					$to_user = $_POST['email_address'];
					$to_mail = array("prithivitest@gmail.com", $to_user);
					send_mail_with_content($to_mail, $message, $subject, $temple_title);
				}
				$this->session->setFlashdata('succ', 'Member Renewal Successfully completed');
				header("Location: " . base_url() . "/member");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/member");
			}
		}
	}
	public function account_migration($member_id,$content){
		 $member_datas = $this->db->table('member')->where('id', $member_id)->get()->getRowArray();
		 $payment_mode_details = $this->db->table('payment_mode')->where('id', 3)->get()->getRowArray();
		 if(empty($payment_mode_details['id']))$payment_mode_details = $this->db->table('payment_mode')->get()->getRowArray();
		 $sales_group = $this->db->table('groups')->where('name', 'Sales')->where('parent_id', 26)->get()->getRowArray();
		if(!empty($sales_group)){
			$sls_id = $sales_group['id'];
		}else{
			$sls1['parent_id'] = 26;
			$sls1['name'] = 'Sales';
			$sls1['code'] = '330';
			$sls1['added_by'] = $this->session->get('log_id');
			$led_ins1 = $this->db->table('groups')->insert($sls1);
			$sls_id = $this->db->insertID();
		}
		// Debit ledger
		$ledger1 = $this->db->table('ledgers')->where('name', 'Member Fees')->where('group_id', $sls_id)->get()->getRowArray();
		if(!empty($ledger1)){
			$dr_id = $ledger1['id'];
		}else{
			$led1['group_id'] = $sls_id;
			$led1['name'] = 'Member Fees';
			$led1['left_code'] = '7099';
			$led1['right_code'] = '000';
			$led1['op_balance'] = '0';
			$led1['op_balance_dc'] = 'D';
			$led_ins1 = $this->db->table('ledgers')->insert($led1);
			$dr_id = $this->db->insertID();
		}
		if(!empty($member_datas['payment'])){
			$number = $this->db->table('entries')->select('number')->where('entrytype_id',1)->orderBy('id','desc')->get()->getRowArray(); 
			if(empty($number)) {
				$num = 1;
			} else {
				$num = $number['number'] + 1;
			}
			$yr= date('Y',strtotime($member_datas['date'])) ;
			$mon= date('m',strtotime($member_datas['date'])) ;
			$qry   = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='". $yr ."' and entrytype_id =1 and month (date)='". $mon ."')")->getRowArray();
			$entries['entry_code'] = 'REC' .date('y',strtotime($member_datas['date'])).$mon. (sprintf("%05d",(((float)  substr($qry['entry_code'],-5))+1)));
			
			$entries['entrytype_id'] = '1';
			$entries['number'] 		 = $num;
			$entries['date'] 		 = $member_datas['start_date'];
							
			$entries['dr_total'] 	 = $member_datas['payment'];
			$entries['cr_total'] 	 = $member_datas['payment'];	
			$entries['narration'] 	 = $content;
			$entries['inv_id']		 = $member_id;
			$entries['type']		 = '11';
			$ent = $this->db->table('entries')->insert($entries);
			$en_id = $this->db->insertID();
			if(!empty($en_id) ){
				$eitems_d['entry_id'] = $en_id;
				$eitems_d['ledger_id'] = $dr_id;
				$eitems_d['amount'] = $member_datas['payment'];
				$eitems_d['dc'] = 'C';
				$this->db->table('entryitems')->insert($eitems_d);

				$eitems_c['entry_id'] = $en_id;
				$eitems_c['ledger_id'] = $payment_mode_details['ledger_id'];
				$eitems_c['amount'] = $member_datas['payment'];
				$eitems_c['dc'] = 'D';
				$this->db->table('entryitems')->insert($eitems_c);				
			}
			return true;
		}else return false;
	 }
	public function delete()
	{
		if(!$this->model->permission_validate('member','delete_p')){
			header('Location: '.base_url().'/dashboard');			
		}
		$id=  $this->request->uri->getSegment(3);
		$res=$this->db->table('ubayam')->delete(['id' => $id]);
		if($res){
		    $this->session->setFlashdata('succ', 'Ubayam Deleted Successfully');
		    header("Location: ".base_url()."/ubayam");
		}else{
		    $this->session->setFlashdata('fail', 'Please Try Again');
		    header("Location: ".base_url()."/ubayam");
		}
		header("Location: ".base_url()."/ubayam");
	     
	}
	
	public function get_member_amount(){
		$id = $_POST['id'];
		$data = $this->db->table('member_type')->select('amount, application_fee')->where('id', $id)->get()->getRowArray();
		echo json_encode($data);
	}
	public function renewal_report()
	{
		if (!$this->model->list_validate('member')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['permission'] = $this->model->get_permission('member');
		
		$data['list'] = $res;
		// echo '<pre>'; print_r($data); die;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('member/renewal_report', $data);
		echo view('template/footer');
	}
	public function get_renewal_report()
	{
		$fdata = $_REQUEST['fdt'];
		$tdata = $_REQUEST['tdt'];
		$qry = $this->db->table('member', 'member_type.name as tname')
						->join('member_type', 'member_type.id = member.member_type')
						->join('member_renewal', 'member_renewal.member_id = member.id')
						->select('member_type.name as tname,member_renewal.renewal_end_date,member_renewal.renewal_start_date')
						->select('member.*')
						->where('member_renewal.renewal_start_date >=',$fdata)
						->where('member_renewal.renewal_start_date <=',$tdata);
		$res = $qry->get()->getResultArray();
		$i = 1;
		$data = array();
		if (!empty($res)) {
			foreach ($res as $r) {
				$data[] = array(
					$i++,
					$r['name'],
					$r['member_no'],
					$r['tname'],
					date('d/m/Y', strtotime($r['renewal_start_date'])),
					date('d/m/Y', strtotime($r['renewal_end_date'])),
					$r['payment']
				);
			}
		}
		$result = array(
			"draw" => 0,
			"recordsTotal" => $i - 1,
			"recordsFiltered" => $i - 1,
			"data" => $data,
		);
		echo json_encode($result);
		exit();
	}
	public function print_renewalreport()
	{
		if (!$this->model->list_validate('member')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$tmpid = $this->session->get('profile_id');
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
		$data['fdate'] = $_REQUEST['fdt'];
		$data['tdate'] = $_REQUEST['tdt'];
		$fdata = $_REQUEST['fdt'];
		$tdata = $_REQUEST['tdt'];
		$i = 0;
		$qry = $this->db->table('member', 'member_type.name as tname')
						->join('member_type', 'member_type.id = member.member_type')
						->join('member_renewal', 'member_renewal.member_id = member.id')
						->select('member_type.name as tname,member_renewal.renewal_end_date,member_renewal.renewal_start_date')
						->select('member.*')
						->where('member_renewal.renewal_start_date >=',$fdata)
						->where('member_renewal.renewal_start_date <=',$tdata);
		$res = $qry->get()->getResultArray();
		$data['member_data'] = $res;
		if ($_REQUEST['pdf_renewalreport'] == "PDF") {
			$file_name = "Member_Renewal_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$dompdf = new \Dompdf\Dompdf();
			$options = $dompdf->getOptions();
			$options->set(array('isRemoteEnabled' => true));
			$dompdf->setOptions($options);
			$dompdf->loadHtml(view('member/pdf/member_renewal_print', ["pdfdata" => $data]), 'UTF-8');
			$dompdf->setPaper('LEGAL', 'portrait');
			$dompdf->render();
			$dompdf->stream($file_name);
		} elseif ($_REQUEST['excel_renewalreport'] == "EXCEL") {
			$fileName = "Member_Renewal_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();
			$sheet->getStyle('A1')->getFont()->setBold(true)->setName('Arial')->SetSize(10);
			$style = array(
				'alignment' => array(
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				)
			);
			$sheet->getStyle("A1:G1")->applyFromArray($style);
			$sheet->mergeCells('A1:G1');
			$sheet->setCellValue('A1', $_SESSION['site_title']);
			$sheet->setCellValue('A2', 'S.No');
			$sheet->setCellValue('B2', 'Member Name');
			$sheet->setCellValue('C2', 'Member No');
			$sheet->setCellValue('D2', 'Member Type');
			$sheet->setCellValue('E2', 'Renewal Start Date');
			$sheet->setCellValue('F2', 'Renewal End Date');
			$sheet->setCellValue('G2', 'Amount');
			$rows = 3;
			$si = 1;
			if(count($data['member_data']) > 0){
				foreach ($data['member_data'] as $val) {
					$sheet->setCellValue('A' . $rows, $si);
					$sheet->setCellValue('B' . $rows, $val['name']);
					$sheet->setCellValue('C' . $rows, $val['member_no']);
					$sheet->setCellValue('D' . $rows, $val['tname']);
					$sheet->setCellValue('E' . $rows, date('d/m/Y', strtotime($val['renewal_start_date'])));
					$sheet->setCellValue('F' . $rows, date('d/m/Y', strtotime($val['renewal_end_date'])));
					$sheet->setCellValue('G' . $rows, $val['payment']);
					$rows++;
					$si++;
				}
			}
			$writer = new Xlsx($spreadsheet);
			$writer->save('uploads/excel/' . $fileName . '.xlsx');
			return $this->response->download('uploads/excel/' . $fileName . '.xlsx', null)->setFileName($fileName . '.xlsx');
		} else {
			echo view('member/member_renewal_print', $data);
		}
	}
	public function print_page(){
		if(!$this->model->permission_validate('member','print')){
			header('Location: '.base_url().'/dashboard');			
		}
	 	$id = $this->request->uri->getSegment(3);
		$qry =  $this->db->table('member', 'member_type.name as tname')
							->join('member_type', 'member_type.id = member.member_type')
							->select('member_type.name as tname')
							->select('member.*')
							->where("member.id", $id);
		 
	 	$res = $qry->get()->getRowArray();

		$data['qry1'] = $res;
		echo view('member/print_page', $data);
	}
	public function cron(){
		echo 'test';
	}
	public function renewal()
	{
		$currentDate = date("Y-m-d");

		// Deactivate members with end date below the current date
		$this->db->table('member')
			->where('end_date <', $currentDate)
			->where('status', 1)
			->update(['status' => 0]);

		// Retrieve inactive members for display
		$query = $this->db->table('member')
			->where('status', 2)
			->get();
		$data['inactiveMembers'] = $query->getResultArray();

		// Load the view with the data
		echo view('template/header');
		echo view('template/sidebar');
		echo view('member/renewal', $data);
		echo view('template/footer');
	}
	public function renewal_page()
	{

		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('member')->where('id', $id)->get()->getRowArray();
		$data['member_type_list'] = $this->db->table('member_type')->get()->getResultArray();
		$data['payment_modes'] = $this->db->table('payment_mode')->where('status', 1)->where('paid_through', 'DIRECT')->get()->getResultArray();


		echo view('template/header');
		echo view('template/sidebar');
		echo view('member/renewal_page', $data);
		echo view('template/footer');
	}
}
