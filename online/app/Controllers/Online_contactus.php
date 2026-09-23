<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Online_contactus extends BaseController
{
	function __construct(){
        parent:: __construct();
        helper('url');
        helper('common_helper');
        //$this->model = new PermissionModel();
    }
	public function index()
	{
        echo view('website/layout/header');
        echo view('website/contactus');
        echo view('website/layout/footer');
    }
    public function sendmail(){
        $mail_data = array();
        $mail_data['name'] = !empty($_POST['name']) ? $_POST['name'] : "";
        $mail_data['email'] = !empty($_POST['email']) ? $_POST['email'] : "";
        $mail_data['subject'] = !empty($_POST['subject']) ? $_POST['subject'] : "";
        $mail_data['message'] = !empty($_POST['message']) ? $_POST['message'] : "";
        $temple_title = "ARULMIGU RAJAMARIAMMAN DEVASTHANAM CONTACT FORM";
        $message =  view('website/mail/contact_mail_template',$mail_data);
        $subject = "ARULMIGU RAJAMARIAMMAN DEVASTHANAM CONTACT FORM";
        $to_user = "rajkumar.bizsoft@gmail.com";
        $to_mail = array("prithivitest@gmail.com",$to_user);
        send_mail_with_content($to_mail,$message,$subject,$temple_title);
        $this->session->setFlashdata('succ', 'Email sent Successflly');
        $redirect_url = base_url() . '/online_contactus';
		header('Location: ' . $redirect_url);
    }
	
}	
