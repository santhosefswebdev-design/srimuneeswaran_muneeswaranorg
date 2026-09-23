<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Profile extends BaseController
{
	function __construct()
	{
		parent::__construct();
		helper('url');
		$this->model = new PermissionModel();
		if (($this->session->get('login')) == false && $this->session->get('role') != 1) {
			$data['dn_msg'] = 'Please Login';
			header('Location: ' . base_url() . '/login');
			exit;
		}
	}

	public function index()
	{

		$data['profile'] = $this->db->table('admin_profile')
			->join('login', 'login.profile_id = admin_profile.id')
			->select('admin_profile.*')
			->select('login.profile_id')
			->get()->getRowArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('profile', $data);
		echo view('template/footer');
	}
	public function myprofile()
	{
		$data['data'] = $this->db->table("login")->where('id', $_SESSION['log_id'])->get()->getRowArray();
		$data['role'] = $this->db->table("role_list")->where('id', $_SESSION['role'])->get()->getRowArray();

		echo view('template/header');
		echo view('template/sidebar');
		echo view('profile/userprofile', $data);
		echo view('template/footer');
	}
	public function profile_edit()
	{
		if (!$this->model->permission_validate('temple_setting', 'edit')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['profile'] = $this->db->table('admin_profile')
			->join('login', 'login.profile_id = admin_profile.id')
			->select('admin_profile.*')
			->select('login.profile_id')
			->get()->getRowArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('profile/edit', $data);
		echo view('template/footer');
	}
	public function save()
	{
		$id = $_POST['id'];
		$data['name'] = $_POST['name'];
		$data['name_tamil'] = $_POST['name_tamil'];
		$data['address1'] = $_POST['address1'];
		$data['address2'] = $_POST['address2'];
		$data['city'] = $_POST['city'];
		$data['postcode'] = $_POST['postcode'];
		$data['telephone'] = $_POST['telephone'];
		$data['mobile'] = $_POST['mobile'];
		$data['email'] = $_POST['email'];
		$data['gstno'] = $_POST['gstno'];
		$data['fax_no'] = $_POST['fax_no'];
		$data['website'] = $_POST['website'];
		$data['bankid'] = $_POST['bankid'];
		$data['donation_courtesy_grace_amount'] = $_POST['donation_courtesy_grace_amount'];
		$data['ubayam_courtesy_grace_amount'] = $_POST['ubayam_courtesy_grace_amount'];
		$data['daily_closing_phone'] = $_POST['daily_closing_phone'];
		$data['hall_remind'] = $_POST['hall_remind'];
		$data['image'] = $_SESSION['logo_img'];
		$data['ar_image'] = $_SESSION['ar_logo_img'];

		if (!empty($_FILES['logo_img']['name']) > 0) {
			echo $_FILES['logo_img']['name'];
			$logoimg = time() . '_' . $_FILES['logo_img']['name'];
			$target_dir = "uploads/main/";
			move_uploaded_file($_FILES['logo_img']['tmp_name'], $target_dir . $logoimg);
			$data['image'] = $logoimg;
		}

		if (!empty($_FILES['ar_logo_img']['name']) > 0) {
			echo $_FILES['ar_logo_img']['name'];
			$logoimg1 = time() . '_' . $_FILES['ar_logo_img']['name'];
			$target_dir = "uploads/main/";
			move_uploaded_file($_FILES['ar_logo_img']['tmp_name'], $target_dir . $logoimg1);
			$data['ar_image'] = $logoimg1;
		}

		$res = $this->db->table('admin_profile')->where('id', $id)->update($data);
		if ($res) {
			$session = array(
				'username' => $_SESSION['username'],
				'ic_number' => $_SESSION['ic_number'],
				'log_id' => $_SESSION['log_id'],
				'role' => $_SESSION['role'],
				'profile_id' => $_SESSION['profile_id'],

				'email' => $_POST['email'],
				'site_title' => $_POST['name'],
				'site_title_tamil' => $_POST['name_tamil'],
				'address1' => $_POST['address1'],
				'address2' => $_POST['address2'],
				'city' => $_POST['city'],
				'postcode' => $_POST['postcode'],
				'telephone' => $_POST['telephone'],
				'mobile' => $_POST['mobile'],
				'gstno' => $_POST['gstno'],
				'website' => $_POST['website'],
				'logo_img' => $data['image'],
				'ar_logo_img' => $data['ar_image'],
				'login' => true
			);
			/*$val = $this->session->get('telephone');
			print_r($val);*/



			$this->session->set($session);
			$this->session->setFlashdata('succ', 'Profile Updated Successfully');
			header("Location: " . base_url() . "/profile/profile_edit");
		} else {
			$this->session->setFlashdata('fail', 'Please Try Again');
			header("Location: " . base_url() . "/profile/profile_edit");
		}
	}
}


