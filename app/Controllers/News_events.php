<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PermissionModel;

class News_events extends BaseController
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

    public function index()
    {
        $data['list'] = $this->db->table('reviews1')
								->select('reviews1.*')
								->get()->getResultArray();
        echo view('template/header');
        echo view('template/sidebar');
        echo view('reviews1/index',$data);
        // echo view('template/footer');
    }
    public function add()
    {

        echo view('template/header');
        echo view('template/sidebar');
        echo view('reviews1/add');
        // echo view('template/footer');
    }

    public function save()
    {
        $id = $_POST['id'];


        $data['name'] = trim($_POST['name']);
        $data['description'] = trim($_POST['description']);

        if (!empty($_FILES['image']['name']) > 0) {
            echo $_FILES['image']['name'];
            $name = time() . '_' . $_FILES['image']['name'];
            $target_dir = "uploads/reviews1/";
            move_uploaded_file($_FILES['image']['tmp_name'], $target_dir . $name);
            $data['image'] = $name;
        }
        if (empty($id)) {
            $data['created'] = date('Y-m-d H:i:s');
            $data['modified'] = date('Y-m-d H:i:s');
            $builder = $this->db->table('reviews1')->insert($data);

            if ($builder) {
                $this->session->setFlashdata('succ', 'reviews1 Added Successfully');
                header("Location: " . base_url() . "/news_events");
            } else {
                $this->session->setFlashdata('fail', 'Please Try Again');
                header("Location: " . base_url() . "/news_events");
            }
        }else{
            $data['modified' ] = date('Y-m-d H:i:s');
            $builder = $this->db->table('reviews1')->where('id', $id)->update($data);
		    if($builder){
    		    $this->session->setFlashdata('succ', 'Image Update Successfully');
    		    header("Location: ".base_url()."/news_events");
    		}else{
    		    $this->session->setFlashdata('fail', 'Please Try Again');
    		    header("Location: ".base_url()."/news_events");
    		}
		}
    }
    public function view(){
	    
	    $id=  $this->request->uri->getSegment(3);
	    $data['data'] = $this->db->table('reviews1')->where('id', $id)->get()->getRowArray();
	   
	    $data['view'] = true;
	    echo view('template/header');
		echo view('template/sidebar');
		echo view('reviews1/add', $data);
		
	}

    public function edit(){
	    
	    $id=  $this->request->uri->getSegment(3);
	    $data['data'] = $this->db->table('reviews1')->where('id', $id)->get()->getRowArray();
		
	    echo view('template/header');
		echo view('template/sidebar');
		echo view('reviews1/add', $data);
		
	}
    public function delete(){
	    
	    $id=  $this->request->uri->getSegment(3);
		$res = $this->db->table('reviews1')->delete(['id' => $id]);
		if($res){
		    $this->session->setFlashdata('succ', 'Image Delete Successfully');
		    header("Location: ".base_url()."/news_events");
		}else{
		    $this->session->setFlashdata('fail', 'Please Try Again');
		    header("Location: ".base_url()."/news_events");
		}
	}
    public function del_check(){
        $id = $_POST['id'];
        $res = $this->db->table("reviews1")->where("id", $id)->get()->getResultArray();
        echo count($res);
    }

    
}


