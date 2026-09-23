<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Prasadamsetting extends BaseController
{
    function __construct(){
        parent:: __construct();
        helper('url');
        helper('common');
		$this->model = new PermissionModel();
        if( ($this->session->get('login') ) == false && $this->session->get('role') != 1){
            $data['dn_msg'] = 'Please Login';
            header('Location: '.base_url().'/login'); 
            exit;
		}
    }
    
    public function index(){
        if(!$this->model->list_validate('prasadam_setting')){
			header('Location: '.base_url().'/dashboard');
		}
		$data['permission'] = $this->model->get_permission('prasadam_setting');
		$data['list'] = $this->db->table('prasadam_setting')->get()->getResultArray();

		echo view('template/header');
		echo view('template/sidebar');
		echo view('prasadam_setting/index', $data);
		echo view('template/footer');
    }
	public function add()
	{
		if(!$this->model->permission_validate('prasadam_setting', 'create_p')){
			header('Location: '.base_url().'/dashboard');
		}
		$three_level_group = get_three_level_in_group($code = array("4000","8000"));
		$data['ledgers'] = $this->db->table("ledgers")->select('id,name,code,left_code,right_code')->whereIn('group_id', $three_level_group)->orderBy('right_code','asc')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('prasadam_setting/add',$data);
		echo view('template/footer');
	}
	
	public function edit(){
	    if(!$this->model->permission_validate('prasadam_setting', 'edit')){
			header('Location: '.base_url().'/dashboard');
		}
	    $id=  $this->request->uri->getSegment(3);
	    $data['data'] = $this->db->table('prasadam_setting')->where('id', $id)->get()->getRowArray();
		$three_level_group = get_three_level_in_group($code = array("4000","8000"));
		$data['ledgers'] = $this->db->table("ledgers")->select('id,name,code,left_code,right_code')->whereIn('group_id', $three_level_group)->orderBy('right_code','asc')->get()->getResultArray();
	    echo view('template/header');
		echo view('template/sidebar');
		echo view('prasadam_setting/add', $data);
		echo view('template/footer');
	}
	
	public function view(){
	    if(!$this->model->permission_validate('prasadam_setting', 'view')){
			header('Location: '.base_url().'/dashboard');
		}
	    $id=  $this->request->uri->getSegment(3);
	    $data['data'] = $this->db->table('prasadam_setting')->where('id', $id)->get()->getRowArray();
		$three_level_group = get_three_level_in_group($code = array("4000","8000"));
		$data['ledgers'] = $this->db->table("ledgers")->select('id,name,code,left_code,right_code')->whereIn('group_id', $three_level_group)->orderBy('right_code','asc')->get()->getResultArray();
	    $data['view'] = true;
	    echo view('template/header');
		echo view('template/sidebar');
		echo view('prasadam_setting/add', $data);
		echo view('template/footer');
	}
	
	public function save(){
        $id = $_POST['id'];
		$data['name_eng']	 =	trim($_POST['name_eng']);
		$data['name_tamil']		 =	trim($_POST['name_tamil']);
		$data['amount']	 =	trim($_POST['amount']);
		$data['added_by']	 =	$this->session->get('log_id');
		if(!empty($_POST['ledger_id'])) $data['ledger_id'] = $_POST['ledger_id'];
		if(!empty($_POST['stock_prasadam'])) $data['dedection_from_stock'] = 1;
		else $data['dedection_from_stock'] = 0;
		if(!empty($_FILES['prasadam_image']['name']) > 0){
			echo $_FILES['prasadam_image']['name'];
			$name = time() . '_' .$_FILES['prasadam_image']['name'];
			$target_dir = "uploads/prasadam_setting/";
			move_uploaded_file($_FILES['prasadam_image']['tmp_name'],$target_dir.$name);
			$data['image'] = $name;
		}
		if(empty($id)){
		    $data['created']  =	date('Y-m-d H:i:s');
			$data['modified'] = date('Y-m-d H:i:s');
		    $builder = $this->db->table('prasadam_setting')->insert($data);
		    if($builder){
    		    $this->session->setFlashdata('succ', 'Prasadam Setting Added Successfully');
    		    header("Location: ".base_url()."/prasadamsetting");
    		}else{
    		    $this->session->setFlashdata('fail', 'Please Try Again');
    		    header("Location: ".base_url()."/prasadamsetting");
    		}
		}else{
            $data['modified' ] = date('Y-m-d H:i:s');
            $builder = $this->db->table('prasadam_setting')->where('id', $id)->update($data);
		    if($builder){
    		    $this->session->setFlashdata('succ', 'Prasadam Setting Update Successfully');
    		    header("Location: ".base_url()."/prasadamsetting");
    		}else{
    		    $this->session->setFlashdata('fail', 'Please Try Again');
    		    header("Location: ".base_url()."/prasadamsetting");
    		}
		}
	}
	
	public function delete(){
	    if(!$this->model->permission_validate('prasadam_setting', 'delete_p')){
			header('Location: '.base_url().'/dashboard');
		}
	    $id=  $this->request->uri->getSegment(3);
		$res = $this->db->table('prasadam_setting')->delete(['id' => $id]);
		if($res){
		    $this->session->setFlashdata('succ', 'Prasadam Setting Delete Successfully');
		    header("Location: ".base_url()."/prasadamsetting");
		}else{
		    $this->session->setFlashdata('fail', 'Please Try Again');
		    header("Location: ".base_url()."/prasadamsetting");
		}
	}
	public function del_check(){
		$id = $_POST['id'];
		$res = $this->db->table("prasadam_booking_details")->where("prasadam_id", $id)->get()->getResultArray();
		echo count($res);
	}
	public function prasadam_setting_validation(){
		$name_eng = trim($_POST['name_eng']);
		$name_tamil = trim($_POST['name_tamil']);
		$amount = trim($_POST['amount']);
		$data = array();
		if (empty($name_eng) || empty($name_tamil) || empty($amount) ) {
		  $data['err'] = "Please Fill Required Fields";
		  $data['succ']= '';
		}
		else{
		  $data['succ'] = "Form validate";
		  $data['err'] ='';
		}
		echo json_encode($data);
	}
	
}
