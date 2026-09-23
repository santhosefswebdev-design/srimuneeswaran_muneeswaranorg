<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Youtube extends BaseController
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

    public function youtube_validation(){
		$title = trim($_POST['title']);
		$url = trim($_POST['url']);
		$data = array();
		if (empty($title) || empty($url) ) {
		  $data['err'] = "Please Fill Required Fields";
		  $data['succ']= '';
		}else{
		  $data['succ'] = "Form validate";
		  $data['err'] ='';
		}
		echo json_encode($data);
	}

    public function del_don_check(){
		$id = $_POST['id'];
		$res = $this->db->table("youtube")->where("title", $id)->get()->getResultArray();
		echo count($res);
	}
	public function youtube() {
	
		$data['permission'] = $this->model->get_permission('youtube');
		$data['list'] = $this->db->table('youtube')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('youtube/youtube', $data);
		echo view('template/footer');
    }
	public function add_youtube() {
		
		echo view('template/header');
		echo view('template/sidebar');
		echo view('youtube/add_youtube');
		echo view('template/footer');
    }
	
	public function save_youtube(){
        $id = $_POST['id'];
        //echo '<pre>';
		
		$data['title']	 =	trim($_POST['title']);
		$data['description']	 =	trim($_POST['description']);
		$data['url']	 =	trim($_POST['url']);
		
		if(empty($id)){
		    $data['created']  =	date('Y-m-d H:i:s');
			$data['modified'] = date('Y-m-d H:i:s');
		    $builder = $this->db->table('youtube')->insert($data);
		    if($builder){
    		    $this->session->setFlashdata('succ', 'Youtube Url Added Successfully');
    		    header("Location: ".base_url()."/youtube/youtube");
    		}else{
    		    $this->session->setFlashdata('fail', 'Please Try Again');
    		    header("Location: ".base_url()."/youtube/youtube");
    		}
		}else{
            $data['modified' ] = date('Y-m-d H:i:s');
            $builder = $this->db->table('youtube')->where('id', $id)->update($data);
		    if($builder){
    		    $this->session->setFlashdata('succ', 'Youtube Url Update Successfully');
    		    header("Location: ".base_url()."/youtube/youtube");
    		}else{
    		    $this->session->setFlashdata('fail', 'Please Try Again');
    		    header("Location: ".base_url()."/youtube/youtube");
    		}
		}
	}
	
	public function delete_youtube(){
	    
		$id=  $this->request->uri->getSegment(3);
		$res = $this->db->table('youtube')->delete(['id' => $id]);
		if($res){
		    $this->session->setFlashdata('succ', 'Youtube Url Delete Successfully');
		    header("Location: ".base_url()."/youtube/youtube");
		}else{
		    $this->session->setFlashdata('fail', 'Please Try Again');
		    header("Location: ".base_url()."/youtube/youtube");
		}
	}
	
	public function edit_youtube(){
	    
		$id=  $this->request->uri->getSegment(3);
	    $data['data'] = $this->db->table('youtube')->where('id', $id)->get()->getRowArray();
	    echo view('template/header');
		echo view('template/sidebar');
		echo view('youtube/add_youtube', $data);
		echo view('template/footer');
	}
	
	public function view_youtube(){
	    
		$id=  $this->request->uri->getSegment(3);
	    $data['data'] = $this->db->table('youtube')->where('id', $id)->get()->getRowArray();
	    $data['view'] = true;
	    echo view('template/header');
		echo view('template/sidebar');
		echo view('youtube/add_youtube', $data);
		echo view('template/footer');
	}
	
}