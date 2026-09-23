<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Online_mybooking extends BaseController
{
    function __construct()
    {
        parent::__construct();
        helper('url');
        //$this->model = new PermissionModel();
    }
    public function index()
    {
        echo view('website/layout/header');
        echo view('website/reports/my_booking');
        echo view('website/layout/footer');
    }
    public function get_archanai_list()
	{
		$fdt = date('Y-m-d', strtotime($_POST['fdt']));
		$tdt = date('Y-m-d', strtotime($_POST['tdt']));
		$userid = $_POST['userid'];
		$bstatus = $_POST['bstatus'];
		$data = [];
		$dat = $this->db->table('archanai_booking')
                        ->select('*')
                        ->where('paid_through','ONLINE')
                        ->where('entry_by',$userid)
                        ->where('date >=', $fdt)
                        ->where('date <=', $tdt);
        if(!empty($bstatus)){
            $dat = $dat->where('payment_status', $bstatus);
        }
		$dat = $dat->get()->getResultArray();
		$i = 1;
		foreach ($dat as $row) {
            if($row['payment_status'] == 2){
                $action = '<a class="btn btn-primary" style="padding: 1px 5px;" title="Print" href='.base_url().'/online_mybooking/print_archanai/'.$row['id'].' target="_blank"><i class="fa fa-print" aria-hidden="true"></i></a>';
            }
            else if($row['payment_status'] == 3){
                $action = '<span style="margin:0px;text-align:center;font-weight: bold;text-transform: uppercase;" class="text-danger">Failed</span>';
            }
            else if($row['payment_status'] == 1){
                $action = '<span style="margin:0px;text-align:center;font-weight: bold;text-transform: uppercase;" class="text-primary">Pending</span>';
            }
            
			$data[] = array(
				'<p style="text-align:center;margin:0px;">'.$i++.'</p>',
				'<p style="text-align:center;margin:0px;">'.date('d-m-Y', strtotime($row['date'])).'</p>',
				'<p style="text-align:center;margin:0px;">'.$row['ref_no'].'</p>',
				'<p style="text-align:center;margin:0px;">'.$row['amount'].'</p>',
				'<p style="text-align:center;margin:0px;">'.$action.'</p>',
			);
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
    public function print_archanai($id)
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
    public function get_donation_list()
	{
		$fdt = date('Y-m-d', strtotime($_POST['fdt']));
		$tdt = date('Y-m-d', strtotime($_POST['tdt']));
		$userid = $_POST['userid'];
		$bstatus = $_POST['bstatus'];
		$data = [];
		$dat = $this->db->table('donation')
                        ->select('*')
                        ->where('paid_through','ONLINE')
                        ->where('added_by',$userid)
                        ->where('date >=', $fdt)
                        ->where('date <=', $tdt);
        if(!empty($bstatus)){
            $dat = $dat->where('payment_status', $bstatus);
        }
		$dat = $dat->get()->getResultArray();
		$i = 1;
		foreach ($dat as $row) {
            if($row['payment_status'] == 2){
                $action = '<a class="btn btn-primary" style="padding: 1px 5px;" title="Print" href='.base_url().'/online_mybooking/print_donation/'.$row['id'].' target="_blank"><i class="fa fa-print" aria-hidden="true"></i></a>';
            }
            else if($row['payment_status'] == 3){
                $action = '<span style="margin:0px;text-align:center;font-weight: bold;text-transform: uppercase;" class="text-danger">Failed</span>';
            }
            else if($row['payment_status'] == 1){
                $action = '<span style="margin:0px;text-align:center;font-weight: bold;text-transform: uppercase;" class="text-primary">Pending</span>';
            }
            
			$data[] = array(
				'<p style="text-align:center;margin:0px;">'.$i++.'</p>',
				'<p style="text-align:center;margin:0px;">'.date('d-m-Y', strtotime($row['date'])).'</p>',
				'<p style="text-align:center;margin:0px;">'.$row['ref_no'].'</p>',
				'<p style="text-align:center;margin:0px;">'.$row['amount'].'</p>',
				'<p style="text-align:center;margin:0px;">'.$action.'</p>',
			);
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
    public function print_donation($id){
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
    public function get_prasadam_list()
    {
        $fdt = date('Y-m-d', strtotime($_POST['fdt']));
        $tdt = date('Y-m-d', strtotime($_POST['tdt']));
        $userid = $_POST['userid'];
        $bstatus = $_POST['bstatus'];
        $data = [];
        $dat = $this->db->table('prasadam')
                        ->select('*')
                        ->where('paid_through','ONLINE')
                        ->where('added_by',$userid)
                        ->where('date >=', $fdt)
                        ->where('date <=', $tdt);
        if(!empty($bstatus)){
            $dat = $dat->where('payment_status', $bstatus);
        }
        $dat = $dat->get()->getResultArray();
        $i = 1;
        foreach ($dat as $row) {
            if($row['payment_status'] == 2){
                $action = '<a class="btn btn-primary" style="padding: 1px 5px;" title="Print" href='.base_url().'/online_mybooking/print_prasadam/'.$row['id'].' target="_blank"><i class="fa fa-print" aria-hidden="true"></i></a>';
            }
            else if($row['payment_status'] == 3){
                $action = '<span style="margin:0px;text-align:center;font-weight: bold;text-transform: uppercase;" class="text-danger">Failed</span>';
            }
            else if($row['payment_status'] == 1){
                $action = '<span style="margin:0px;text-align:center;font-weight: bold;text-transform: uppercase;" class="text-primary">Pending</span>';
            }
            
            $data[] = array(
                '<p style="text-align:center;margin:0px;">'.$i++.'</p>',
                '<p style="text-align:center;margin:0px;">'.date('d-m-Y', strtotime($row['date'])).'</p>',
                '<p style="text-align:center;margin:0px;">'.$row['ref_no'].'</p>',
                '<p style="text-align:center;margin:0px;">'.$row['amount'].'</p>',
                '<p style="text-align:center;margin:0px;">'.$action.'</p>',
            );
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
    public function print_prasadam($id)
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
    public function get_annathanam_list()
    {
        $fdt = date('Y-m-d', strtotime($_POST['fdt']));
        $tdt = date('Y-m-d', strtotime($_POST['tdt']));
        $userid = $_POST['userid'];
        $bstatus = $_POST['bstatus'];
        $data = [];
        $dat = $this->db->table('annathanam')
                        ->select('*')
                        ->where('paid_through','ONLINE')
                        ->where('added_by',$userid)
                        ->where('date >=', $fdt)
                        ->where('date <=', $tdt);
        if(!empty($bstatus)){
            $dat = $dat->where('payment_status', $bstatus);
        }
        $dat = $dat->get()->getResultArray();
        $i = 1;
        foreach ($dat as $row) {
            if($row['payment_status'] == 2){
                $action = '<a class="btn btn-primary" style="padding: 1px 5px;" title="Print" href='.base_url().'/online_mybooking/print_annathanam/'.$row['id'].' target="_blank"><i class="fa fa-print" aria-hidden="true"></i></a>';
            }
            else if($row['payment_status'] == 3){
                $action = '<span style="margin:0px;text-align:center;font-weight: bold;text-transform: uppercase;" class="text-danger">Failed</span>';
            }
            else if($row['payment_status'] == 1){
                $action = '<span style="margin:0px;text-align:center;font-weight: bold;text-transform: uppercase;" class="text-primary">Pending</span>';
            }
            
            $data[] = array(
                '<p style="text-align:center;margin:0px;">'.$i++.'</p>',
                '<p style="text-align:center;margin:0px;">'.date('d-m-Y', strtotime($row['date'])).'</p>',
                '<p style="text-align:center;margin:0px;">'.$row['ref_no'].'</p>',
                '<p style="text-align:center;margin:0px;">'.$row['total_amount'].'</p>',
                '<p style="text-align:center;margin:0px;">'.$action.'</p>',
            );
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


}
