<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Properties extends BaseController
{
	function __construct()
	{
		parent::__construct();
		helper(['url']);
		helper('common');
		$this->model = new PermissionModel();
		if (($this->session->get('login')) == false && $this->session->get('role') != 1) {
			$data['dn_msg'] = 'Please Login';
			header('Location: ' . base_url() . '/login');
			exit;
		}
	}

	public function index()
	{
		$data['properties'] = $this->db->table('properties')->get()->getResultArray();
		$data['property_status'] = $this->db->table('property_status')->get()->getResultArray();
		$data['rental'] = $this->db->table('rental')->get()->getResultArray();
		echo view('template/header');
		 echo view('template/sidebar');
		echo view('properties/list', $data);
		echo view('template/footer');
	}

	public function add()
	{
		$data['property_category'] = $this->db->table('property_category')->get()->getResultArray();
		$data['property_titles'] = $this->db->table('property_title')->get()->getResultArray();
		$data['property_duedates'] = $this->db->table('property_due_date')->get()->getResultArray();
		$data['rental_types'] = $this->db->table("rental_type")->where('status', 1)->get()->getResultArray();
		$data['property_documents'] = array();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('properties/add', $data);
		echo view('template/footer');
	}
	public function edit($id)
	{
		$data['property_category'] = $this->db->table('property_category')->get()->getResultArray();
		$data['property_titles'] = $this->db->table('property_title')->get()->getResultArray();
		$data['property_duedates'] = $this->db->table('property_due_date')->get()->getResultArray();
		$data['property'] = $this->db->table('properties')->where("id", $id)->get()->getRowArray();
		$data['property_documents'] = $this->db->table('property_documents')->where("property_id", $id)->get()->getResultArray();
		$data['rental_types'] = $this->db->table("rental_type")->where('status', 1)->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('properties/add', $data);
		echo view('template/footer');
	}
	public function view($id)
	{
		$data['property_category'] = $this->db->table('property_category')->get()->getResultArray();
		$data['property_titles'] = $this->db->table('property_title')->get()->getResultArray();
		$data['property_duedates'] = $this->db->table('property_due_date')->get()->getResultArray();
		$data['property'] = $this->db->table('properties')->where("id", $id)->get()->getRowArray();
		$data['property_documents'] = $this->db->table('property_documents')->where("property_id", $id)->get()->getResultArray();
		$data['rental_types'] = $this->db->table("rental_type")->where('status', 1)->get()->getResultArray();
		$data['view'] = true;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('properties/add', $data);
		echo view('template/footer');
	}
	public function store()
	{
		//exit;
		$id = $_POST['id'];
		$data['name'] = $_POST['property_name'];
		$data['lot_no'] = $_POST['lotno'];
		$data['area'] = $_POST['area'];
		$data['square_feet'] = $_POST['square_feet'];
		//$data['type'] = $_POST['type'];
		$data['amount'] = $_POST['amount'];
		$data['property_category_id'] = $_POST['property_category'];
		$data['purchased_year'] = $_POST['purchased_year'];
		$data['rental_value'] = $_POST['rental_value'];
		$data['rental_type'] = $_POST['rental_type'];
		$data['due_date'] = $_POST['due_date'];
		if (empty($id)) {
			$data['created_at'] = date('Y-m-d H:i:s');
			$this->db->table('properties')->insert($data);
			$insert_id = $this->db->insertID();
		} else {
			$data['updated_at'] = date('Y-m-d H:i:s');
			$this->db->table('properties')->where('id', $id)->update($data);
			$insert_id = $id;
		}

		if (!empty($_FILES['file']["name"]) && !empty($_POST['date'])) {
			$document_date = !empty($_POST['date']) ? $_POST['date'] : "";
			$remark = !empty($_POST['remark']) ? $_POST['remark'] : "";
			$files = count($_FILES['file']["name"]);
			for ($j = 0; $j < $files; $j++) {
				if (!empty($_FILES['file']['name'][$j])) {
					$logoimg = time() . '_' . $_FILES['file']['name'][$j];
					$target_dir = "uploads/properties/";
					move_uploaded_file($_FILES['file']['tmp_name'][$j], $target_dir . $logoimg);
					$document_name = $logoimg;
				} else {
					$document_name = '';
				}
				$document_data = array(
					'date' => $document_date[$j],
					'document_name' => $document_name,
					'remark' => $remark[$j],
					'property_id' => $insert_id
				);
				$this->db->table('property_documents')->insert($document_data);
			}
		}
		$this->session->setFlashdata('succ', 'Property Added Successfully');
		return redirect()->to("/properties");
	}
	public function findpropertyNameExists()
	{
		$property_category = $this->request->getPost('property_category');
		$updateid = $this->request->getPost('update_id');
		if (!empty($updateid)) {
			$query = $this->db->table('properties')->where(['property_category_id' => $property_category, 'id !=' => $updateid])->countAllResults();
		} else {
			$query = $this->db->table('properties')->where(['property_category_id' => $property_category])->countAllResults();
		}
		if ($query > 0) {
			echo "false";
		} else {
			echo "true";
		}
	}
	public function del_property_check()
	{
		$id = $_POST['id'];
		$res = $this->db->table("tennant_property")->where("property_id", $id)->get()->getResultArray();
		echo count($res);
	}
	public function delete_property()
	{
		if (!$this->model->permission_validate('properties', 'delete_p')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$res = $this->db->table('properties')->delete(['id' => $id]);
		if ($res) {
			$this->session->setFlashdata('succ', 'Property Delete Successfully');
			header("Location: " . base_url() . "/properties");
		} else {
			$this->session->setFlashdata('fail', 'Please Try Again');
			header("Location: " . base_url() . "/properties");
		}
	}
	public function del_property_document()
	{
		$id = $_POST['p_d_id'];
		$this->db->table("property_documents")->delete(['id' => $id]);
	}
	public function save_property_type()
	{
		$id = $_POST['id'];
		$data['name'] = trim($_POST['property_type']);
		$data['created_at'] = date('Y-m-d H:i:s');
		$builder = $this->db->table('property_category')->insert($data);
	}
	public function findpropertytypenameExists()
	{
		$property_type = trim($this->request->getPost('property_type'));
		$query = $this->db->table('property_category')->where(['name' => $property_type])->countAllResults();
		if ($query > 0) {
			echo "false";
		} else {
			echo "true";
		}
	}
	public function save_rental_type()
	{
		$id = $_POST['id'];
		$data['name'] = trim($_POST['rental_type_add']);
		$data['created_at'] = date('Y-m-d H:i:s');
		$builder = $this->db->table('rental_type')->insert($data);
	}
	public function findrentaltypenameExists()
	{
		$rental_type_add = trim($this->request->getPost('rental_type_add'));
		$query = $this->db->table('rental_type')->where(['name' => $rental_type_add])->countAllResults();
		if ($query > 0) {
			echo "false";
		} else {
			echo "true";
		}
	}


	public function assign_property()
	{
		$data['properties'] = $this->db->query("SELECT tennant_property.*,tennant.name as tennant_name,properties.name as property_name FROM tennant_property JOIN properties ON properties.id = tennant_property.property_id JOIN tennant ON tennant.id = tennant_property.tennant_id WHERE tennant_property.status = 1 ")->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('assign_property/list', $data);
		echo view('template/footer');
	}
	public function add_assign_property($id)
	{
		$data['property'] = $this->db->table('properties')->where("id", $id)->get()->getRowArray();
		$data['tennancies'] = $this->db->query("SELECT tennant.* FROM tennant WHERE tennant.status = 1 ")->getResultArray();
		$data['rental_types'] = $this->db->table("rental_type")->where('status', 1)->get()->getResultArray();
		echo view('template/header');
		 echo view('template/sidebar');
		echo view('assign_property/add', $data);
		echo view('template/footer');
	}
	public function edit_assign_property($id)
	{
		$data['properties'] = $this->db->query("SELECT tennant_property.*,tennant.name as tennant_name,properties.name as property_name FROM tennant_property JOIN properties ON properties.id = tennant_property.property_id JOIN tennant ON tennant.id = tennant_property.tennant_id WHERE tennant_property.status = 1 ")->getResultArray();

		$data['tennancies'] = $this->db->query("SELECT tennant.* FROM tennant WHERE tennant.status = 1 ")->getResultArray();
		$data['rental_types'] = $this->db->table("rental_type")->where('status', 1)->get()->getResultArray();
		$data['tennant_property'] = $this->db->table("tennant_property")->where('id', $id)->get()->getRowArray();
		$data['edit'] = true;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('assign_property/add', $data);
		echo view('template/footer');
	}
	public function view_assign_property($id)
	{
		$data['tennancies'] = $this->db->query("SELECT tennant.* FROM tennant WHERE tennant.status = 1 ")->getResultArray();
		$data['rental_types'] = $this->db->table("rental_type")->where('status', 1)->get()->getResultArray();
		$data['tennant_property'] = $this->db->table("tennant_property")->where('id', $id)->get()->getRowArray();
		$data['view'] = true;
		echo view('template/header');
		 echo view('template/sidebar');
		echo view('assign_property/add', $data);
		echo view('template/footer');
	}
	public function store_assign_property()
	{
		//var_dump($_POST);
		//exit;
		$id = $_POST['id'];
		$data['property_id'] = $_POST['property_id'];
		$data['tennant_id'] = $_POST['tennant_id'];
		$data['start_date'] = $_POST['start_date'];
		$data['end_date'] = $_POST['end_date'];
		$data['due_start_month'] = $_POST['due_start_month'] . "-01";
		$data['deposit_amount'] = $_POST['deposit_amount'];
		$data['utility_deposit'] = $_POST['utility_deposit'];
		if (empty($id)) {
			$data['created_at'] = date('Y-m-d H:i:s');
			$this->db->table('tennant_property')->insert($data);
			$insert_id = $this->db->insertID();
			$ten_data['property_status'] = 1;
			$ten_data['updated_at'] = date('Y-m-d H:i:s');
			$this->db->table('properties')->where('id', $_POST['property_id'])->update($ten_data);
			$this->session->setFlashdata('succ', 'Assign Property Added Successfully');
		} else {
			$data['status'] = $_POST['status'];
			$data['modified_at'] = date('Y-m-d H:i:s');
			$this->db->table('tennant_property')->where('id', $id)->update($data);
			$insert_id = $id;
			$this->session->setFlashdata('succ', 'Assign Property Updated Successfully');
		}

		return redirect()->to("/properties");
	}
	public function del_assign_property_check()
	{
		$id = $_POST['id'];
		$res = $this->db->table("rental")->where("tenn_prop_id", $id)->get()->getResultArray();
		echo count($res);
	}
	public function delete_assign_property()
	{
		if (!$this->model->permission_validate('properties', 'delete_p')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$propertyQuery = $this->db->table('tennant_property')->select('property_id')->where('id', $id)->get();
		$propertyRow = $propertyQuery->getRow();

		$propertyId = $propertyRow->property_id;

		// Update the property_status in the properties table to mark it as "deleted"
		$res1 = $this->db->table('properties')->update(['property_status' => 3], ['id' => $propertyId]);
		
		
		$res = $this->db->table('tennant_property')->delete(['id' => $id]);
		if ($res) {
			$this->session->setFlashdata('succ', 'Assign Property Delete Successfully');
			header("Location: " . base_url() . "/properties/assign_property");
		} else {
			$this->session->setFlashdata('fail', 'Please Try Again');
			header("Location: " . base_url() . "/properties/assign_property");
		}
	}
	public function property_history_report()
	{
		$data['properties'] = $this->db->query("SELECT * FROM properties")->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('properties/property_history_report', $data);
		echo view('template/footer');
	}
	public function get_property_history_report()
	{
		$fltername = $_REQUEST['fltername'];
		$res = $this->db->table('properties');
		if (!empty($fltername)) {
			$res = $res->where('id', $fltername);
		}
		$res = $res->get()->getResultArray();
		$i = 1;
		$data = array();
		if (!empty($res)) {
			foreach ($res as $r) {
				$property_category_row = $this->db->table('property_category')->where('id', $r['property_category_id'])->get()->getRowArray();
				$property_category_name = !empty($property_category_row['name']) ? $property_category_row['name'] : "";
				$action = '<a class="btn btn-primary btn-rad" title="Edit" href="' . base_url() . '/properties/show_property_history/' . $r['id'] . '"><i class="material-icons">&#xE417;</i></a>';
				$data[] = array(
					$i++,
					$r['name'],
					$property_category_name,
					$r['purchased_year'],
					$r['rental_value'],
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
	public function show_property_history($id)
	{
		$data['properties'] = $this->db->query("SELECT * FROM properties WHERE id = $id ")->getRowArray();
		$data['tennancies'] = $this->db->query("SELECT tennant.* FROM tennant WHERE tennant.status = 1 ")->getResultArray();
		$data['rental_types'] = $this->db->table("rental_type")->where('status', 1)->get()->getResultArray();
		$data['tennant_property'] = $this->db->table("tennant_property")->where('id', $id)->get()->getRowArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('properties/show_property_history', $data);
		echo view('template/footer');
	}
	public function property_collection_report()
	{
		$current_monf = date('Y-m');
		//and DATE_FORMAT(tp.due_start_month,'%Y-%m') < '$current_monf' 
		$data['properties'] = $this->db->query("SELECT p.id,p.name FROM properties as p JOIN tennant_property as tp ON tp.property_id = p.id WHERE tp.status = 1 GROUP BY p.name ORDER BY p.name ASC ")->getResultArray();
		
		// echo '<pre>';
		// print_r($data);
		// echo '</pre>';
		// exit;
		
		echo view('template/header');
		echo view('template/sidebar');
		echo view('properties/property_collection_report', $data);
		echo view('template/footer');
	}
	public function print_property_collection_report()
	{
		$fltername = $_POST['fltername'];
		$res = $this->db->table('properties as p')
			->join('tennant_property as tp', 'tp.property_id = p.id')
			->join('tennant as t', 't.id = tp.tennant_id')
			->select('p.property_category_id,p.id as propid,p.name as property_name,p.lot_no,p.rental_value,t.name as tennant_name,tp.id as tns_propid')
			->where('tp.status', 1);
		//->where("DATE_FORMAT(tp.due_start_month,'%Y-%m') <",date('Y-m'));
		if (!empty($fltername)) {
			$res = $res->where('p.name', $fltername);
		}
		$data['res'] = $res->groupBy('tp.property_id')->orderBy('p.lot_no', 'ASC')->get()->getResultArray();
		
		echo view('template/header');
		echo view('template/sidebar');
		echo view('properties/print_property_collection_report', $data);
		echo view('template/footer');
		
	}

	// public function property_collection_analytics()
	// {
	// 	$fltername = $_POST['fltername'];
	// 	$res = $this->db->table('properties as p')
	// 		->join('tennant_property as tp', 'tp.property_id = p.id')
	// 		->join('tennant as t', 't.id = tp.tennant_id')
	// 		->select('p.property_category_id,p.id as propid,p.name as property_name,p.lot_no,p.rental_value,t.name as tennant_name,tp.id as tns_propid')
	// 		->where('tp.status', 1);
	// 	//->where("DATE_FORMAT(tp.due_start_month,'%Y-%m') <",date('Y-m'));
	// 	if (!empty($fltername)) {
	// 		$res = $res->where('p.name', $fltername);
	// 	}
	// 	$data['res'] = $res->groupBy('tp.property_id')->orderBy('p.lot_no', 'ASC')->get()->getResultArray();
	// 		echo view('properties/property_collection_report', $data);
		
	// }

	public function get_property_collection_report()
	{
		$fltername = $_REQUEST['fltername'];
		$res = $this->db->table('properties as p')
			->join('tennant_property as tp', 'tp.property_id = p.id')
			->join('tennant as t', 't.id = tp.tennant_id')
			->select('p.property_category_id,p.id as propid,p.name as property_name,p.lot_no,p.rental_value,t.name as tennant_name,tp.id as tns_propid')
			->where('tp.status', 1);
		//->where("DATE_FORMAT(tp.due_start_month,'%Y-%m') <",date('Y-m'));
		if (!empty($fltername)) {
			$res = $res->where('p.name', $fltername);
		}
		$res = $res->groupBy('tp.property_id')->orderBy('p.lot_no', 'ASC')->get()->getResultArray();
		$i = 1;
		$data = array();
		if (!empty($res)) {
			$totalOutstanding = 0;
			foreach ($res as $r) {
				$property_category_row = $this->db->table('property_category')->where('id', $r['property_category_id'])->get()->getRowArray();
				$property_category_name = !empty($property_category_row['name']) ? $property_category_row['name'] : "";

				$totalrentalamount = getpropertyTotalrentalamount($r['propid']);
				$paid_amt = getpropertyTotalrentalpaidamount($r['propid']);
				$pending_amt = $totalrentalamount - $paid_amt;

				$duemonthcount = getpropertyduemonthcount($r['tns_propid'], $r['propid']);
				$lastpaidmonth = getproperty_lastpaidmonth($r['tns_propid'], $r['propid']);
				$totalOutstanding += $duemonthcount['unpaid_amount'];
				$action = '<a class="btn btn-primary btn-rad" title="Edit" href="' . base_url() . '/properties/show_property_collection/' . $r['propid'] . '"><i class="material-icons">&#xE417;</i></a>';
				$data[] = array(
					$i++,
					$r['property_name'],
					// $property_category_name,
					$r['lot_no'],
					$r['rental_value'],
					$r['tennant_name'],
					$duemonthcount['unpaid_count'],
					number_format($duemonthcount['unpaid_amount'], 2),
					$lastpaidmonth,
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
			"totalOutstanding" => $totalOutstanding

		);
		echo json_encode($result);
		exit();
	}
	public function show_property_collection($id)
	{
		$data['properties'] = $this->db->query("SELECT * FROM properties WHERE id = $id ")->getRowArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('properties/show_property_collection', $data);
		echo view('template/footer');
	}
	public function print_property_collection_history()
	{
		$collection_prop_id = $_POST['collection_prop_id'];
		$data['properties'] = $this->db->query("SELECT * FROM properties WHERE id = $collection_prop_id ")->getRowArray();
		echo view('properties/print_property_collection_history', $data);
	}
	public function loadstartmonth()
	{
		$date_convert_half = $_POST['start_date'];
		$startmonth = date('Y-m', strtotime($date_convert_half));
		echo $startmonth;
	}
}