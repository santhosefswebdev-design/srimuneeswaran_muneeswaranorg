<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Bookingnotification extends BaseController
{
    function __construct(){
        parent:: __construct();
        helper('url');
        $this->model = new PermissionModel();
        if( ($this->session->get('login') ) == false && $this->session->get('role') != 1){
            $data['dn_msg'] = 'Please Login';
            header('Location: '.base_url().'/login');
            exit;
		}
    }
    public function index(){
		if(!$this->model->permission_validate('booking_notification','view')){
			header('Location: '.base_url().'/dashboard');
		}
		$data['permission'] = $this->model->get_permission('booking_notification');
		$res =  $this->db->table('booking_notification')
						->join('booking_type','booking_type.id=booking_notification.type')
						->select("booking_type.name as type_name,booking_notification.*")
						->where('booking_notification.status', 1)
						->get()->getResultArray();
		$data['list'] = $res;
        // echo '<pre>'; print_r($data); die;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('booking_notification/list',$data);
		echo view('template/footer');
    }
	public function add()
	{
		if(!$this->model->permission_validate('booking_notification', 'create_p')){
			header('Location: '.base_url().'/dashboard');
		}
		$data['booking_type_list'] = $this->db->table('booking_type')->where("status", 1)->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('booking_notification/add', $data);
		echo view('template/footer');
	}
	public function edit(){
	    if(!$this->model->permission_validate('booking_notification','edit')){
			header('Location: '.base_url().'/dashboard');			
		}
	    $id=  $this->request->uri->getSegment(3);
	    $data['booktype'] 		= $this->db->table('booking_notification')->where('id', $id)->get()->getRowArray();
		$data['booking_type_list'] = $this->db->table('booking_type')->where("status", 1)->get()->getResultArray();
	    echo view('template/header');
		echo view('template/sidebar');
		echo view('booking_notification/add', $data);
		echo view('template/footer');
	}
	public function save(){
		$id = $_POST['book_noti_id'];
		$data['type'] = $_POST['booking_type'];
		$data['title'] = $_POST['booking_title'];
		$data['description'] = $_POST['booking_description'];
		$data['status'] = 1;
		if(!empty($_FILES['booking_file']['name']) > 0){
			$logoimg = time() . '_' .$_FILES['booking_file']['name'];
			$target_dir = "uploads/notification/";
			move_uploaded_file($_FILES['booking_file']['tmp_name'],$target_dir.$logoimg);
			$data['image'] = $logoimg;
		}
		if(empty($id))
		{
			$this->db->table('booking_notification')->insert($data);
			$insert_id = $this->db->insertID();
			$this->session->setFlashdata('succ', 'Notification detail added successfully');
    		header("Location: ".base_url()."/bookingnotification");
		}
		else
		{
			$this->db->table('booking_notification')->where("id", $id)->update($data);
			$this->session->setFlashdata('succ', 'Notification detail updated successfully');
    		header("Location: ".base_url()."/bookingnotification");
		}
	}
	public function delete_booking_notification(){
	    if(!$this->model->permission_validate('booking_notification', 'delete_p')){
			header('Location: '.base_url().'/dashboard');
		}
		$id=  $this->request->uri->getSegment(3);
		$res = $this->db->table('booking_notification')->where("id",$id)->update(['status' => 0]);
		if($res){
		    $this->session->setFlashdata('succ', 'Booking Notification Delete Successfully');
		    header("Location: ".base_url()."/bookingnotification");
		}else{
		    $this->session->setFlashdata('fail', 'Please Try Again');
		    header("Location: ".base_url()."/bookingnotification");
		}
	}


	
}
