<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Online_common extends BaseController
{
	function __construct(){
        parent:: __construct();
        helper('url');
        helper('common_helper');
        //$this->model = new PermissionModel();
    }
	
	public function username_check(){
		  $cust_username = $_POST['cust_username'];
      $builder = $this->db->table('login')
                          ->where("username", $cust_username)
                          ->where("role", '98')
                          ->where("status", '1');
			$datas = $builder->get();
			$details = $datas->getResultArray();
      if(count($details) > 0){
        echo "false";
      }
      else{
        echo "true";
      }
    }
    public function email_check(){
		  $cust_email = $_POST['cust_email'];
      $builder = $this->db->table('login')
                          ->where("email", $cust_email)
                          ->where("role", '98')
                          ->where("status", '1');
			$datas = $builder->get();
			$details = $datas->getResultArray();
      if(count($details) > 0){
        echo "false";
      }
      else{
        echo "true";
      }
    }
	public function save_register(){
		$msg_data = array();
        $cust_name = $_POST['cust_name'];
        $cust_ic_no = $_POST['cust_ic_no'];
        $cust_email = $_POST['cust_email'];
        $cust_username = $_POST['cust_username'];
        $cust_password = $_POST['cust_password'];
        $data['name'] = $cust_name;
        $data['ic_number'] = $cust_ic_no;
        $data['username'] = $cust_username;
        $data['password'] = $cust_password;
        $data['email'] = $cust_email;
        $data['role'] = 98;
        $data['profile_id'] = 1;
        $data['status'] = 1;
        $data['member_comes'] = "customer";
        $data['created'] = date('Y-m-d H:i:s');
        $data['modified'] = date('Y-m-d H:i:s');
        $res = $this->db->table('login')->insert($data);
        if ($res) {
          $ins_id = $this->db->insertID();
          if (!empty($_POST['cust_email'])) {
            $temple_title = "Temple Rajamariamman";
            $mail_data['login_id'] = $ins_id;
            $message = view('front_user/register_mail_template', $mail_data);
            $subject = "Customer Registration";
            $to_user = $_POST['cust_email'];
            $to_mail = array("prithivitest@gmail.com", $to_user);
            send_mail_with_content($to_mail, $message, $subject, $temple_title);
          }
		  $cust_data = $this->db->table('login')->where('id',$ins_id)->get()->getRowArray();
          $msg_data['succ'] = 'Customer registered successfully';
		  $msg_data['id'] = $cust_data['id'];
		  $msg_data['name'] = $cust_data['name'];
		  $msg_data['ic_number'] = $cust_data['ic_number'];
		  $msg_data['username'] = $cust_data['username'];
		  $msg_data['password'] = $cust_data['password'];
		  $msg_data['email'] = $cust_data['email'];
		  $msg_data['role'] = $cust_data['role'];
		  $msg_data['profile_id'] = $cust_data['profile_id'];
        }
		echo json_encode($msg_data);
		exit();
    }
	public function check_login(){
        $username = $_POST['user_name'];
        $password = $_POST['password'];
        if(trim($username) != '' && trim($password != '') ){
            
            $builder = $this->db->table('login')
						->where("username", $username)
						->where("password", $password)
						->where("role", '98')
						->where("member_comes", 'customer');

				$datas = $builder->get();
				$details = $datas->getRowArray();
            if($datas->resultID->num_rows > 0){
                $builder = $this->db->table('login')
						->select('login.*')
						->where("login.id", $details['id']);
				$datas = $builder->get();
				$cust_data = $datas->getRowArray();
				$msg_data['msg'] = '';
				$msg_data['id'] = $cust_data['id'];
				$msg_data['name'] = $cust_data['name'];
				$msg_data['ic_number'] = $cust_data['ic_number'];
				$msg_data['username'] = $cust_data['username'];
				$msg_data['password'] = $cust_data['password'];
				$msg_data['email'] = $cust_data['email'];
				$msg_data['role'] = $cust_data['role'];
				$msg_data['profile_id'] = $cust_data['profile_id'];
            }else{
				$msg_data['msg'] = 'Wrong Username And Password';
            }
        }
		echo json_encode($msg_data);
		exit();
    }
}	
