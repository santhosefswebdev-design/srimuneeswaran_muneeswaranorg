<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Tennant extends BaseController
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
	
	public function index() {
		$data['tennants'] = $this->db->table('tennant')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('tennant/list', $data);
		echo view('template/footer');
    }
	
	public function add() {
		$data['phone_codes'] = $this->db->table("phone_code")->orderBy('dailing_code', 'ASC')->get()->getResultArray();
		$data['tenancy_documents'] = array();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('tennant/add', $data);
		echo view('template/footer');
    }
	public function edit($id) {
		$data['tennant'] = $this->db->table('tennant')->where("id", $id)->get()->getRowArray();
		$data['tenancy_documents'] = $this->db->table('tenancy_documents')->where("tennant_id", $id)->get()->getResultArray();
		$data['phone_codes'] = $this->db->table("phone_code")->orderBy('dailing_code', 'ASC')->get()->getResultArray();
		$data['edit'] = true;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('tennant/add', $data);
		echo view('template/footer');
    }
	public function view($id) {
		$data['tennant'] = $this->db->table('tennant')->where("id", $id)->get()->getRowArray();
		$data['tenancy_documents'] = $this->db->table('tenancy_documents')->where("tennant_id", $id)->get()->getResultArray();
		$data['phone_codes'] = $this->db->table("phone_code")->orderBy('dailing_code', 'ASC')->get()->getResultArray();
		$data['view'] = true;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('tennant/add', $data);
		echo view('template/footer');
    }
	public function store() {
		$id = $_POST['id'];
		
		$data['name'] = $_POST['tennant_name'];
		$data['phonecode'] = !empty($_POST['phonecode'])?$_POST['phonecode']:"";
		$data['phone'] = !empty($_POST['tennant_phoneno'])?$_POST['tennant_phoneno']:"";
		$data['icno'] = $_POST['tennant_icno']?$_POST['tennant_icno']:"";
		$data['email'] = $_POST['tennant_emailid'];
		$data['address'] = $_POST['tennant_address'];
		$data['company'] = $_POST['company_organisation'];
		
		if(empty($id)){
			$data['created_at']  =	date('Y-m-d H:i:s');
			$this->db->table('tennant')->insert($data);
			$insert_id = $this->db->insertID();
		}
		else
		{
			$data['status'] = $_POST['status'];
			$data['updated_at' ] = date('Y-m-d H:i:s');
            $this->db->table('tennant')->where('id', $id)->update($data);
			$insert_id = $id;
		}

		if(!empty($_FILES['file']["name"]) && !empty($_POST['date']))
		{
			$files = count($_FILES['file']["name"]);
			$document_date = !empty($_POST['date']) ? $_POST['date'] : "";
			$remark = !empty($_POST['remark']) ? $_POST['remark'] : "";
			for($j=0;$j<$files;$j++) 
			{
				if(!empty($_FILES['file']['name'][$j]))
				{
					$logoimg = time() . '_' .$_FILES['file']['name'][$j];
					$target_dir = "uploads/tenant/";
					move_uploaded_file($_FILES['file']['tmp_name'][$j],$target_dir.$logoimg);
					$document_name = $logoimg;
				}
				else {
					$document_name = '';
				}
				$document_data = array(
					'date' => $document_date[$j],
					'document_name' => $document_name,
					'remark' => $remark[$j],
					'tennant_id'=> $insert_id
				);
				$this->db->table('tenancy_documents')->insert($document_data);
			}
		}
		$this->session->setFlashdata('succ', 'Tennant Added Successfully');
		return redirect()->to("/tennant");
	}
	public function del_tennant_check(){
		$id = $_POST['id'];
		$res = $this->db->table("tennant_property")->where("tennant_id", $id)->get()->getResultArray();
		echo count($res);
	}
	public function delete_tennant(){
	    $id=  $this->request->uri->getSegment(3);
		$res = $this->db->table('tennant')->delete(['id' => $id]);
		if($res){
		    $this->session->setFlashdata('succ', 'Tennant Delete Successfully');
		    header("Location: ".base_url()."/tennant");
		}else{
		    $this->session->setFlashdata('fail', 'Please Try Again');
		    header("Location: ".base_url()."/tennant");
		}
	}
	public function del_tennant_document(){
		$id = $_POST['t_d_id'];
		$this->db->table("tenancy_documents")->delete(['id' => $id]);
	}
	public function findNameExists()
    {
		$tennant_name =  $this->request->getPost('tennant_name');
        $updateid = $this->request->getPost('update_id');
		if(!empty($updateid))
		{
			$query = $this->db->table('tennant')->where(['name' => $tennant_name, 'id !=' => $updateid])->countAllResults();
		}
        else
		{
			$query = $this->db->table('tennant')->where(['name' => $tennant_name])->countAllResults();
		}
        if($query > 0){
            echo "false";
        }else{
            echo "true";
        }
    }
	public function tennant_history_report() {
		$data['tennancies'] = $this->db->query("SELECT * FROM tennant where status = 1")->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('tennant/tennant_history_report',$data);
		echo view('template/footer');
    }
	public function get_tennant_history_report()
	{
		$fltername = $_REQUEST['fltername'];
		$res = $this->db->table('tennant');
		if(!empty($fltername)){
			$res = $res->where('id', $fltername);
		}
		$res = $res->get()->getResultArray();
		$i = 1;
		$data = array();
		if (!empty($res)) {
			foreach ($res as $r) {
				$action = '<a class="btn btn-primary btn-rad" title="Edit" href="'.base_url().'/tennant/show_tennant_history/'.$r['id'].'"><i class="material-icons">&#xE417;</i></a>';
				$phone_no = $r['phonecode']."".$r['phone'];
				$data[] = array(
					$i++,
					$r['name'],
					$phone_no,
					$r['email'],
					$r['address'],
					$r['company'],
					$action
				);
			}
		}
		//die;
		$result = array(
			"draw" => 0,
			"recordsTotal" => $i - 1,
			"recordsFiltered" => $i - 1,
			"data" => $data,
		);
		echo json_encode($result);
		exit();
	}
	public function show_tennant_history($id) {
		$data['tennant'] = $this->db->query("SELECT * FROM tennant WHERE tennant.status = 1 and tennant.id = $id ")->getRowArray();
		if(!empty($data['tennant']['id'])){
			echo view('template/header');
			echo view('template/sidebar');
			echo view('tennant/show_tennant_history',$data);
			echo view('template/footer');
		}
		else{
			header("Location: ".base_url()."/tennant/tennant_history_report");
		}
    }


}