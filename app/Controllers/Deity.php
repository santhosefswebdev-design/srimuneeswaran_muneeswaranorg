<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;
use Dompdf\Dompdf;
use Dompdf\Options;

class Deity extends BaseController
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

	public function index()
	{
		$data = array();
		$data['list'] = $this->db->table("deity")->select('*')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('deity/index', $data);
		echo view('template/footer');
	}
	
	public function add_deity()
	{
		$data = array();
		$data['ledgers'] = $this->db->table("ledgers")->select('id,name,code,left_code,right_code')->whereIn('group_id', $three_level_group)->orderBy('right_code','asc')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('deity/add_deity', $data);
		echo view('template/footer');
	}
	
	public function edit_deity()
	{
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('deity')->where('id', $id)->get()->getRowArray();
		$data['ledgers'] = $this->db->table("ledgers")->select('id,name,code,left_code,right_code')->whereIn('group_id', $three_level_group)->orderBy('right_code','asc')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('deity/add_deity', $data);
		echo view('template/footer');
	}
	
	public function view_deity()
	{
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('deity')->where('id', $id)->get()->getRowArray();
		$data['ledgers'] = $this->db->table("ledgers")->select('id,name,code,left_code,right_code')->whereIn('group_id', $three_level_group)->orderBy('right_code','asc')->get()->getResultArray();
		$data['view'] = true;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('deity/add_deity', $data);
		echo view('template/footer');
	}

	public function delete_deity($id)
	{

		$res=$this->db->table('deity')->delete(['id' => $id]);
		if ($res) {
			session()->setFlashdata('succ', 'Deity deleted successfully.');
		} else {
			session()->setFlashdata('fail', 'Please try again.');
		}
		
		return redirect()->to(base_url('/deity'));
	}
	
	public function save_deity()
	{
		$data['name_eng'] = $_POST['name_eng'];
		$data['name_tamil'] = $_POST['name_tamil'];
		$data['abishegam_status'] = $_POST['abi_status'];
		$data['abishegam_amount'] = !empty($_POST['abi_amount']) ? $_POST['abi_amount'] : 0;
		$data['homam_status'] = $_POST['hom_status'];
		$data['homam_amount'] = !empty($_POST['hom_amount']) ? $_POST['hom_amount'] : 0;
		if(!empty($_POST['ledger_id'])) $data['ledger_id'] = $_POST['ledger_id'];
		$data['status'] = $_POST['status'];
		
		if (empty($_POST['id'])) {
			$data['created_at'] = date('Y-m-d H:i:s');
			$data['modified_at'] = date('Y-m-d H:i:s');
			$builder = $this->db->table('deity')->insert($data);

			if ($builder) {
				$this->session->setFlashdata('succ', 'Deity added Successfully');
				header("Location: " . base_url() . "/deity");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/deity");
			}
		}
		else {
			$id = $_POST['id'];
		    $data['modified_at'] = date('Y-m-d H:i:s');
			$builder = $this->db->table('deity')->where('id', $id)->update($data);
			if ($builder) {
				$this->session->setFlashdata('succ', 'Deity update Successfully');
				header("Location: " . base_url() . "/deity");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/deity");
			}
		}
		exit;
	}

	public function validation2()
	{
		$data = [
			'err' => '',
			'succ' => ''
		];
		if (empty($_POST['name_eng'])) {
			$data['err'] = "Please Fill English Name Fields";
		} 
		if (empty($_POST['name_tamil'])) {
			$data['err'] = "Please Fill Tamil Name Fields";
		} 
		else if (empty($_POST['status'])) {
			$data['err'] = "Please Select Status";
		} 
		else if (isset($_POST['abi_status']) && $_POST['abi_status'] == '1' && (!isset($_POST['abi_amount']) || !is_numeric($_POST['abi_amount']) || $_POST['abi_amount'] <= 0)) {
			$data['err'] = "Please Fill Amount for Abishegam";
		} 
		else if (isset($_POST['hom_status']) && $_POST['hom_status'] == '1' && (!isset($_POST['hom_amount']) || !is_numeric($_POST['hom_amount']) || $_POST['hom_amount'] <= 0)) {
			$data['err'] = "Please Fill Amount for Homam";
		} 
		else {
			$data['succ'] = "Form validate";
		}
		echo json_encode($data);
		exit;
	}

}
