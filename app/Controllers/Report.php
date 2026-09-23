<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\PermissionModel;

class Report extends BaseController
{
	function __construct()
	{
		parent::__construct();
		helper('url');
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
		if (!$this->model->list_validate('payslip_report')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data = array();
		$data['staff_data'] = $this->db->table('staff')->where('is_admin', 0)->where('status', 1)->select('name')->orderBy('name', 'asc')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('report/payslip', $data);
		echo view('template/footer');
	}

	public function arch_book_rep_view()
	{

		if (!$this->model->list_validate('archanai_report')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['grp'] = $this->db->table('archanai_group')
			->get()->getResultArray();
		$data['arch'] = $this->db->table('archanai')->orderby('name_eng', 'ASC')
			->get()->getResultArray();

		// echo '<pre>';
		// print_r ($data['grp']);exit;

		echo view('template/header');
		echo view('template/sidebar');
		echo view('report/archanaibooking', $data);
		echo view('template/footer');
	}
	public function arc_counter()
	{

		if (!$this->model->list_validate('archanai_report')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['counter'] = $this->db->table('login')->where('member_comes', 'counter')
			->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('report/arc_counter', $data);
		echo view('template/footer');
	}
	public function cash_don_rep_view()
	{
		if (!$this->model->list_validate('cash_report')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['dons_set'] = $this->db->table('donation_setting')->get()->getResultArray();
		$data['dons_name'] = $this->db->table('donation')->groupby('name')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('report/cashdonation', $data);
		echo view('template/footer');
	}

	public function prod_don_rep_view()
	{
		if (!$this->model->list_validate('product_donation_report')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['dons_prod'] = $this->db->table('donation_product')->groupby('name')->get()->getResultArray();
		$data['prds_name'] = $this->db->table('product')->groupby('name')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('report/productdonation', $data);
		echo view('template/footer');
	}
	public function prod_don_rep_ref()
	{
		$fdt = date('Y-m-d', strtotime($_POST['fdt']));
		$tdt = date('Y-m-d', strtotime($_POST['tdt']));
		$productname = $_POST['productname'];
		$fltername = $_POST['fltername'];
		$data = [];
		$dat = $this->db->table('donation_product', 'product.name as pname', 'donation_product_item')
			->join('donation_product_item', 'donation_product.id = donation_product_item.donation_prod_id')
			->join('product', 'product.id = donation_product_item.product_id')
			->select('product.name as pname')
			->select('donation_product.*')
			->select('donation_product_item.*')
			->where('donation_product.date>=', $fdt)
			->where('donation_product.date<=', $tdt);
		if ($productname) {
			$dat = $dat->where('product.id', $productname);
		}
		if ($fltername) {
			$dat = $dat->where('donation_product.name', $fltername);
		}
		$dat = $dat->get()->getResultArray();

		$i = 1;
		foreach ($dat as $row) {
			$data[] = array(
				$i++,
				date('d-m-Y', strtotime($row['date'])),
				$row['pname'],
				$row['name'],
				$row['quantity'],
				number_format($row['total_amount'], '2', '.', ','),
			);
		}

		$result = array(
			"draw" => 0,
			"recordsTotal" => $i - 1,
			"recordsFiltered" => $i - 1,
			"data" => $data,
		);
		echo json_encode($result);
		exit();
	}
	public function print_productdonationreport()
	{
		if (!$this->model->list_validate('product_donation_report')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['fdate'] = $_REQUEST['fdt'];
		$data['tdate'] = $_REQUEST['tdt'];
		$productname = $_REQUEST['productname'];
		$data['productname'] = $productname;
		$fltername = $_REQUEST['fltername'];
		$data['fltername'] = $fltername;
		$dat = $this->db->table('donation_product', 'product.name as pname', 'donation_product_item')
			->join('donation_product_item', 'donation_product.id = donation_product_item.donation_prod_id')
			->join('product', 'product.id = donation_product_item.product_id')
			->select('product.name as pname')
			->select('donation_product.*')
			->select('donation_product_item.*')
			->where('donation_product.date>=', $data['fdate'])
			->where('donation_product.date<=', $data['tdate']);
		if ($productname) {
			$dat = $dat->where('product.id', $productname);
		}
		if ($fltername) {
			$dat = $dat->where('donation_product.name', $fltername);
		}
		$dat = $dat->get()->getResultArray();
		$data['data'] = $dat;

		if ($_REQUEST['pdf_productdonationreport'] == "PDF") {
			$file_name = "Product_Donation_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$dompdf = new \Dompdf\Dompdf();
			$options = $dompdf->getOptions();
			$options->set(array('isRemoteEnabled' => true));
			$dompdf->setOptions($options);
			$dompdf->loadHtml(view('report/pdf/productdonation_print', ["pdfdata" => $data]));
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$dompdf->stream($file_name);
		} elseif ($_REQUEST['excel_productdonationreport'] == "EXCEL") {
			$fileName = "Product_Donation_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();
			$sheet->getStyle('A1')->getFont()->setBold(true)->setName('Arial')->SetSize(10);
			$style = array(
				'alignment' => array(
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				)
			);

			$sheet->getStyle("A1:F1")->applyFromArray($style);
			$sheet->mergeCells('A1:F1');
			$sheet->setCellValue('A1', $_SESSION['site_title']);
			$sheet->setCellValue('A2', 'S.No');
			$sheet->setCellValue('B2', 'Date');
			$sheet->setCellValue('C2', 'Product');
			$sheet->setCellValue('D2', 'Name');
			$sheet->setCellValue('E2', 'Quantity');
			$sheet->setCellValue('F2', 'Total Amount');
			$rows = 3;
			$si = 1;
			//var_dump($excel_format_data);
			//exit;
			foreach ($data['data'] as $val) {
				$sheet->setCellValue('A' . $rows, $si);
				$sheet->setCellValue('B' . $rows, date('d-m-Y', strtotime($val['date'])));
				$sheet->setCellValue('C' . $rows, $val['pname']);
				$sheet->setCellValue('D' . $rows, $val['name']);
				$sheet->setCellValue('E' . $rows, $val['quantity']);
				$sheet->setCellValue('F' . $rows, $val['total_amount']);
				$rows++;
				$si++;
			}
			$writer = new Xlsx($spreadsheet);
			$writer->save('uploads/excel/' . $fileName . '.xlsx');
			return $this->response->download('uploads/excel/' . $fileName . '.xlsx', null)->setFileName($fileName . '.xlsx');
		} else {
			echo view('report/productdonation_print', $data);
		}
	}
	public function temple_rep_view()
	{

		if (!$this->model->list_validate('ubayam_report')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['ubyam_set'] = $this->db->table('temple_packages')->where('status', 1)
			->get()->getResultArray();
		// $data['fltr_name'] = $this->db->table('ubayam')->groupby('name')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('report/ubayam_temple', $data);
		echo view('template/footer');
	}
	public function temple_booking_reminder()
	{

		if (!$this->model->list_validate('ubayam_report')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['ubyam_set'] = $this->db->table('temple_packages')->where('status', 1)
			->get()->getResultArray();
		// $data['fltr_name'] = $this->db->table('ubayam')->groupby('name')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('report/ubayam_temple_reminder', $data);
		echo view('template/footer');
	}

	public function ubayam_rep_view()
	{

		if (!$this->model->list_validate('ubayam_report')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['ubyam_set'] = $this->db->table('ubayam_setting')
			->get()->getResultArray();
		// $data['fltr_name'] = $this->db->table('ubayam')->groupby('name')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('report/ubayam', $data);
		echo view('template/footer');
	}

	public function hall_booking_rep_view()
	{
		if (!$this->model->list_validate('hall_report')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		echo view('template/header');
		echo view('template/sidebar');
		echo view('report/hall_booking');
		echo view('template/footer');
	}

	public function stock_rep_view()
	{
		if (!$this->model->list_validate('stock_report')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		echo view('template/header');
		echo view('template/sidebar');
		echo view('report/stock');
		echo view('template/footer');
	}
	public function stock_rep_ref()
	{
		$fdt = date('Y-m-d', strtotime($_POST['fdt']));
		$tdt = date('Y-m-d', strtotime($_POST['tdt']));
		$data_product = [];
		$dat_product = $this->db->table('product')->get()->getResultArray();
		foreach ($dat_product as $row) {
			$pid = $row['id'];
			$donation = $this->db->query("select sum(donation_product_item.quantity) as donation from `donation_product` inner join donation_product_item on donation_product_item.donation_prod_id = donation_product.id where donation_product_item.product_id = $pid and donation_product.date >= '$fdt' and donation_product.date <= '$tdt'")->getRowArray();
			$stockin = $this->db->query("select sum(stock_inward_list.quantity) as stockin 
										 from `stock_inward`
										 inner join stock_inward_list on stock_inward_list.stack_in_id = stock_inward.id
										 where stock_inward_list.item_type = 1 and stock_inward.date  >= '$fdt' and stock_inward.date <= '$tdt' and stock_inward_list.item_id = $pid")->getRowArray();
			$stockout = $this->db->query("select sum(stock_outward_list.quantity) as stockout
										  from `stock_outward`
										  inner join stock_outward_list on stock_outward_list.stack_out_id = stock_outward.id
										  where stock_outward_list.item_type = 1 and stock_outward.date  >= '$fdt' and stock_outward.date <= '$tdt' and stock_outward_list.item_id = $pid")->getRowArray();
			$defective = $this->db->query("select sum(defective_item_list.quantity) as stockout
										  from `defective_item`
										  inner join defective_item_list on defective_item_list.defective_item_id = defective_item.id
										  where defective_item_list.item_type = 1 and defective_item.date  >= '$fdt' and defective_item.date <= '$tdt' and defective_item_list.item_id = $pid")->getRowArray();
			//echo $pid; print_r($donation); print_r($stockin);print_r($stockout);
			if ($donation['donation'] > 0)
				$donq = $donation['donation'];
			else
				$donq = 0;
			if ($stockin['stockin'] > 0)
				$sinq = $stockin['stockin'];
			else
				$sinq = 0;
			if ($stockout['stockout'] > 0)
				$sotq = $stockout['stockout'];
			else
				$sotq = 0;
			if ($defective['stockout'] > 0)
				$dotq = $defective['stockout'];
			else
				$dotq = 0;
			$opbal = (($row['opening_stock'] + $sotq + $dotq) - ($sinq + $donq));
			//$closing_bal = ($row ['quantity'] + $sinq + $donq) - ($sotq);
			$data_product[] = array(
				'<p style="text-align:left;">Product</p>',
				'<p style="text-align:left;">' . $row['name'] . '</p>',
				number_format($opbal, 2),
				number_format($donq, 2),
				number_format($sinq, 2),
				number_format($sotq, 2),
				number_format($dotq, 2),
				$row['opening_stock']
			);
		}
		$data_rawmaterial = [];
		$dat_rawmaterial = $this->db->table('raw_matrial_groups')->get()->getResultArray();
		foreach ($dat_rawmaterial as $row) {
			$pid = $row['id'];
			$stockin = $this->db->query("select sum(stock_inward_list.quantity) as stockin 
										 from `stock_inward`
										 inner join stock_inward_list on stock_inward_list.stack_in_id = stock_inward.id
										 where stock_inward_list.item_type = 2 and stock_inward.date  >= '$fdt' and stock_inward.date <= '$tdt' and stock_inward_list.item_id = $pid")->getRowArray();
			$stockout = $this->db->query("select sum(stock_outward_list.quantity) as stockout
										  from `stock_outward`
										  inner join stock_outward_list on stock_outward_list.stack_out_id = stock_outward.id
										  where stock_outward_list.item_type = 2 and stock_outward.date  >= '$fdt' and stock_outward.date <= '$tdt' and stock_outward_list.item_id = $pid")->getRowArray();
			$defective = $this->db->query("select sum(defective_item_list.quantity) as stockout
										  from `defective_item`
										  inner join defective_item_list on defective_item_list.defective_item_id = defective_item.id
										  where defective_item_list.item_type = 2 and defective_item.date  >= '$fdt' and defective_item.date <= '$tdt' and defective_item_list.item_id = $pid")->getRowArray();
			if ($stockin['stockin'] > 0)
				$sinq = $stockin['stockin'];
			else
				$sinq = 0.00;
			if ($stockout['stockout'] > 0)
				$sotq = $stockout['stockout'];
			else
				$sotq = 0.00;
			if ($defective['stockout'] > 0)
				$dotq = $defective['stockout'];
			else
				$dotq = 0;
			$opbal = (($row['opening_stock'] + $sotq + $dotq) - ($sinq + 0));
			$data_rawmaterial[] = array(
				'<p style="text-align:left;">Raw Material</p>',
				'<p style="text-align:left;">' . $row['name'] . '</p>',
				number_format($opbal, 2),
				"0.00",
				number_format($sinq, 2),
				number_format($sotq, 2),
				number_format($dotq, 2),
				$row['opening_stock']
			);
		}

		$merge_product_rawmaterial = array_merge($data_product, $data_rawmaterial);
		//var_dump($merge_product_rawmaterial);
		//exit;
		$type = $_POST['type'];
		if ($type == 1) {
			$data = $data_product;
		} else if ($type == 2) {
			$data = $data_rawmaterial;
		} else {
			$data = $merge_product_rawmaterial;
		}
		$result = array(
			"draw" => 0,
			"recordsTotal" => $i - 1,
			"recordsFiltered" => $i - 1,
			"data" => $data,
		);
		echo json_encode($result);
		exit();
	}
	public function inventory_rep()
	{
		echo view('template/header');
		echo view('template/sidebar');
		echo view('report/inventory');
		echo view('template/footer');
	}
	public function inventory_ref()
	{
		$json_arr = array();
		//$product_type = !empty($_REQUEST['']) ? 
	}
	public function get_products_materials()
	{
		$json_arr = array();
		$product_type = !empty($_REQUEST['producttype']) ? $_REQUEST['producttype'] : 1;
		$product_list = array();
		if ($product_type == 1) {
			$product_list = $this->db->table('product')->select("id, name")->get()->getResultArray();
		} elseif ($product_type == 2) {
			$product_list = $this->db->table('raw_matrial_groups')->select("id, name")->get()->getResultArray();
		}
		echo json_encode(array('product_list' => $product_list));
		exit;
	}
	public function print_stockreport()
	{
		if (!$this->model->list_validate('stock_report')) {
			header('Location: ' . base_url() . '/dashboard');
		}

		$fdt = date('Y-m-d', strtotime($_REQUEST['fdt']));
		$tdt = date('Y-m-d', strtotime($_REQUEST['tdt']));
		$data_product = array();
		$result_data = array();
		$dat_product = $this->db->table('product')->get()->getResultArray();
		foreach ($dat_product as $row) {
			$pid = $row['id'];
			$donation = $this->db->query("select sum(donation_product_item.quantity) as donation from `donation_product` inner join donation_product_item on donation_product_item.donation_prod_id = donation_product.id where donation_product_item.product_id = $pid and donation_product.date >= '$fdt' and donation_product.date <= '$tdt'")->getRowArray();
			$stockin = $this->db->query("select sum(stock_inward_list.quantity) as stockin 
										 from `stock_inward`
										 inner join stock_inward_list on stock_inward_list.stack_in_id = stock_inward.id
										 where stock_inward_list.item_type = 1 and stock_inward.date  >= '$fdt' and stock_inward.date <= '$tdt' and stock_inward_list.item_id = $pid")->getRowArray();
			$stockout = $this->db->query("select sum(stock_outward_list.quantity) as stockout
										  from `stock_outward`
										  inner join stock_outward_list on stock_outward_list.stack_out_id = stock_outward.id
										  where stock_outward_list.item_type = 1 and stock_outward.date  >= '$fdt' and stock_outward.date <= '$tdt' and stock_outward_list.item_id = $pid")->getRowArray();
			if ($donation['donation'] > 0)
				$donq = $donation['donation'];
			else
				$donq = 0.00;
			if ($stockin['stockin'] > 0)
				$sinq = $stockin['stockin'];
			else
				$sinq = 0.00;
			if ($stockout['stockout'] > 0)
				$sotq = $stockout['stockout'];
			else
				$sotq = 0.00;
			$opbal = (($row['opening_stock'] + $sotq) - ($sinq + $donq));
			$data_product[] = array(
				"type" => "Product",
				"name" => $row['name'],
				"opbal" => $opbal,
				"pdon" => $donq,
				"sin" => $sinq,
				"sout" => $sotq,
				"avilble" => $row['opening_stock']
			);
		}
		$data_rawmaterial = array();
		$dat_rawmaterial = $this->db->table('raw_matrial_groups')->get()->getResultArray();
		foreach ($dat_rawmaterial as $row) {
			$pid = $row['id'];
			$stockin = $this->db->query("select sum(stock_inward_list.quantity) as stockin 
										 from `stock_inward`
										 inner join stock_inward_list on stock_inward_list.stack_in_id = stock_inward.id
										 where stock_inward_list.item_type = 2 and stock_inward.date  >= '$fdt' and stock_inward.date <= '$tdt' and stock_inward_list.item_id = $pid")->getRowArray();
			$stockout = $this->db->query("select sum(stock_outward_list.quantity) as stockout
										  from `stock_outward`
										  inner join stock_outward_list on stock_outward_list.stack_out_id = stock_outward.id
										  where stock_outward_list.item_type = 2 and stock_outward.date  >= '$fdt' and stock_outward.date <= '$tdt' and stock_outward_list.item_id = $pid")->getRowArray();
			if ($stockin['stockin'] > 0)
				$sinq = $stockin['stockin'];
			else
				$sinq = 0.00;
			if ($stockout['stockout'] > 0)
				$sotq = $stockout['stockout'];
			else
				$sotq = 0.00;
			$opbal = (($row['opening_stock'] + $sotq) - ($sinq + 0));
			$data_rawmaterial[] = array(
				"type" => "Raw Material",
				"name" => $row['name'],
				"opbal" => $opbal,
				"pdon" => 0.00,
				"sin" => $sinq,
				"sout" => $sotq,
				"avilble" => $row['opening_stock']
			);
		}
		$merge_product_rawmaterial = array_merge($data_product, $data_rawmaterial);
		$type = $_REQUEST['producttype'];
		if ($type == 1) {
			$data = $data_product;
		} else if ($type == 2) {
			$data = $data_rawmaterial;
		} else {
			$data = $merge_product_rawmaterial;
		}
		$result_data['fdate'] = $_REQUEST['fdt'];
		$result_data['tdate'] = $_REQUEST['tdt'];
		$result_data['type'] = $_REQUEST['producttype'];

		$result_data['data'] = $data;

		if ($_REQUEST['pdf_stockreport'] == "PDF") {
			$file_name = "Stock_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$dompdf = new \Dompdf\Dompdf();
			$options = $dompdf->getOptions();
			$options->set(array('isRemoteEnabled' => true));
			$dompdf->setOptions($options);
			$dompdf->loadHtml(view('report/pdf/stock_print', ["pdfdata" => $result_data]));
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$dompdf->stream($file_name);
		} elseif ($_REQUEST['excel_stockreport'] == "EXCEL") {
			$fileName = "Stock_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();
			$sheet->getStyle('A1')->getFont()->setBold(true)->setName('Arial')->SetSize(10);
			$style = array(
				'alignment' => array(
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				)
			);

			$sheet->getStyle("A1:G1")->applyFromArray($style);
			$sheet->mergeCells('A1:G1');
			$sheet->setCellValue('A1', $_SESSION['site_title']);
			$sheet->setCellValue('A2', 'Type');
			$sheet->setCellValue('B2', 'Item Name');
			$sheet->setCellValue('C2', 'Opening');
			$sheet->setCellValue('D2', 'Product Donate');
			$sheet->setCellValue('E2', 'Stock In');
			$sheet->setCellValue('F2', 'Stock Out');
			$sheet->setCellValue('G2', 'Available');
			$rows = 3;
			$si = 1;
			//var_dump($result_data['data']);
			//exit;
			foreach ($result_data['data'] as $val) {
				$sheet->setCellValue('A' . $rows, $val['type']);
				$sheet->setCellValue('B' . $rows, $val['name']);
				$sheet->setCellValue('C' . $rows, number_format($val['opbal'], 2));
				$sheet->setCellValue('D' . $rows, number_format($val['pdon'], 2));
				$sheet->setCellValue('E' . $rows, number_format($val['sin'], 2));
				$sheet->setCellValue('F' . $rows, number_format($val['sout'], 2));
				$sheet->setCellValue('G' . $rows, $val['avilble']);
				$rows++;
				$si++;
			}
			$writer = new Xlsx($spreadsheet);
			$writer->save('uploads/excel/' . $fileName . '.xlsx');
			return $this->response->download('uploads/excel/' . $fileName . '.xlsx', null)->setFileName($fileName . '.xlsx');
		} else {
			echo view('report/stock_print', $result_data);
		}
	}
	public function commission_rep_view()
	{
		if (!$this->model->list_validate('commission_report')) {
			header('Location: ' . base_url() . '/dashboard');
		}

		// Get Archanai names for filter
		$dat = $this->db->table('archanai_booking')
			->join('archanai_booking_details', 'archanai_booking_details.archanai_booking_id = archanai_booking.id')
			->join('archanai', 'archanai.id = archanai_booking_details.archanai_id')
			->select('archanai.name_eng as name')
			->groupby('archanai_booking_details.archanai_id')
			->get()->getResultArray();

		// Get Hall Booking commission names from the commission table
		$dat2 = $this->db->table('commission')
			->select('commission.remarks as name')
			->where('commission.type', 'Hall Booking')
			->groupby('commission.remarks')
			->get();

		// Check if query was successful
		if ($dat2 === false) {
			// Log the error
			log_message('error', 'Database error in commission_rep_view: ' . print_r($this->db->error(), true));
			$dat2_array = array();
		} else {
			$dat2_array = $dat2->getResultArray();
		}

		// Merge the results
		$commission_array = array_merge($dat, $dat2_array);
		$data['commision_data'] = $commission_array;

		$data['staff_data'] = $this->db->table('staff')
			->where('is_admin', 0)
			->where('status', 1)
			->select('id, name')
			->orderBy('name', 'asc')
			->get()->getResultArray();

		echo view('template/header');
		echo view('template/sidebar');
		echo view('report/commission', $data);
		echo view('template/footer');
	}
	public function commission_rep_ref()
	{
		// archanai_booking_details.total_commision once confirmed.
		$fdt = $_POST['fdt'];
		$tdt = $_POST['tdt'];
		$cat_type = $_POST['cat_type'];
		$data = [];
		$dat = $this->db->table('archanai_booking')
			->join('archanai_booking_details', 'archanai_booking_details.archanai_booking_id = archanai_booking.id')
			->join('archanai', 'archanai.id = archanai_booking_details.archanai_id')
			->join('staff', 'staff.id = archanai_booking_details.comission_to')
			->select('archanai.name_eng as name, archanai_booking.date as date, SUM(archanai_booking_details.total_commision) as amount, "Archanai" as type, staff.name as staff_name ')
			->where("((archanai_booking.paid_through != 'ADMIN' and archanai_booking.payment_status = 2) or archanai_booking.paid_through = 'ADMIN')")
			->where('archanai_booking.date >=', $fdt)
			->where('archanai_booking.date <=', $tdt);
		if (!empty($_POST['staff_name'])) {
			$staff_name = $_POST['staff_name'];
			$dat = $dat->where('archanai_booking_details.comission_to', $staff_name);
		}
		$dat->having('amount > 0');
		$dat = $dat->groupby('archanai_booking_details.archanai_id')
			->groupby('archanai_booking.date')
			->get()->getResultArray();
		// echo $this->db->getLastQuery();die;
		/*
		$dat2 = $this->db->table('hall_booking')
			->join('hall_booking_commission_details', 'hall_booking_commission_details.hall_booking_id = hall_booking.id')
			->select(' CONCAT(IFNULL(hall_booking.name,""), "-", IFNULL(hall_booking.event_name,"")) AS name, hall_booking.entry_date as date, SUM(hall_booking_commission_details.amount) as amount')
			->where('DATE_FORMAT(hall_booking.entry_date,"%Y-%m-%d") >=', $fdt)
			->where('DATE_FORMAT(hall_booking.entry_date,"%Y-%m-%d") <=', $tdt);
		if (!empty($_POST['staff_name'])) {
			$staff_name = $_POST['staff_name'];
			$dat2 = $dat2->where('hall_booking_commission_details.staff_id', $staff_name);
		}
		$dat2->having('amount > 0');
		$dat2 = $dat2->groupby('hall_booking_commission_details.hall_booking_id')
			->get()->getResultArray();
		//echo $this->db->getLastQuery();die;
		//var_dump($dat2);
		//exit;
		*/
		$dat_hallbooking = $this->db->table('commission')
			->join('staff', 'staff.id = commission.staff_id')
			->select('commission.remarks as name, commission.date as date, SUM(commission.amount) as amount,"Hall Booking" as type, staff.name as staff_name ')
			->where('DATE_FORMAT(commission.date,"%Y-%m-%d") >=', $fdt)
			->where('DATE_FORMAT(commission.date,"%Y-%m-%d") <=', $tdt)
			->where('commission.type', 'Hall Booking');
		if (!empty($_POST['staff_name'])) {
			$staff_name = $_POST['staff_name'];
			$dat_hallbooking = $dat_hallbooking->where('commission.staff_id', $staff_name);
		}
		//$dat_hallbooking->having('commission.amount > 0');
		$dat_hallbooking = $dat_hallbooking->get()->getResultArray();

		$dat_ubayaam = $this->db->table('commission')
			->join('staff', 'staff.id = commission.staff_id')
			->select('commission.remarks as name, commission.date as date, SUM(commission.amount) as amount,"UBAYAM" as type,staff.name as staff_name')
			->where('DATE_FORMAT(commission.date,"%Y-%m-%d") >=', $fdt)
			->where('DATE_FORMAT(commission.date,"%Y-%m-%d") <=', $tdt)
			->where('commission.type', 'Ubayam');
		if (!empty($_POST['staff_name'])) {
			$staff_name = $_POST['staff_name'];
			$dat_ubayaam = $dat_ubayaam->where('commission.staff_id', $staff_name);
		}
		//$dat_hallbooking->having('commission.amount > 0');
		$dat_ubayaam = $dat_ubayaam->get()->getResultArray();

		if ($cat_type == "archanai") {
			$commission_array = $dat;
		} else if ($cat_type == "hallbooking") {
			$commission_array = $dat_hallbooking;
		} else if ($cat_type == "ubayam") {
			$commission_array = $dat_ubayaam;
		} else {
			$commission_array = array_merge($dat, $dat_hallbooking, $dat_ubayaam);
		}
		$i = 1;
		usort($commission_array, function ($a, $b) {
			return $b['date'] <=> $a['date'];
		});
		foreach ($commission_array as $row) {
			if (!empty($row['staff_name']) && !empty($row['name'])) {
				if (!empty($row['amount'])) {
					$amount = number_format($row['amount'], 2);
				} else {
					$amount = "0.00";
				}
				$data[] = array(
					$i++,
					$row['type'],
					date('d-m-Y', strtotime($row['date'])),
					$row['staff_name'],
					$row['name'],
					number_format($amount, '2', '.', ','),
				);
			}
		}

		$result = array(
			"draw" => 0,
			"recordsTotal" => $i - 1,
			"recordsFiltered" => $i - 1,
			"data" => $data,
		);
		echo json_encode($result);
		exit();
	}
	public function print_commissionreport()
	{
		if (!$this->model->list_validate('commission_report')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['fdate'] = $_REQUEST['fdt'];
		$data['tdate'] = $_REQUEST['tdt'];
		$cat_type = $_REQUEST['cat_type'];
		$staff_name = $_REQUEST['staff_name'];


		$data['staff_name'] = $staff_name;
		$dat = $this->db->table('archanai_booking')
			->join('archanai_booking_details', 'archanai_booking_details.archanai_booking_id = archanai_booking.id')
			->join('archanai', 'archanai.id = archanai_booking_details.archanai_id')
			->join('staff', 'staff.id = archanai_booking_details.comission_to')
			->select('archanai.name_eng as name, archanai_booking.date as date, SUM(archanai_booking_details.total_commision) as amount,"Archanai" as type, staff.name as staff_name')
			->where('archanai_booking.date >=', $data['fdate'])
			->where('archanai_booking.date <=', $data['tdate']);
		if (!empty($staff_name)) {
			$dat = $dat->where('archanai_booking_details.comission_to', $staff_name);
		}
		$dat = $dat->groupBy('archanai_booking_details.archanai_id')
			->get()->getResultArray();


		/*
		$dat2 = $this->db->table('hall_booking')
			->join('hall_booking_commission_details', 'hall_booking_commission_details.hall_booking_id = hall_booking.id')
			->select(' CONCAT(IFNULL(hall_booking.name,""), "-", IFNULL(hall_booking.event_name,"")) AS name, hall_booking.entry_date as date, SUM(hall_booking_commission_details.amount) as amount')
			->where('DATE_FORMAT(hall_booking.entry_date,"%Y-%m-%d") >=', $data['fdate'])
			->where('DATE_FORMAT(hall_booking.entry_date,"%Y-%m-%d") <=', $data['tdate']);
		if (!empty($staff_name)) {
			$dat2 = $dat2->where('hall_booking_commission_details.staff_id', $staff_name);
		}
		$dat2 = $dat2->groupBy('hall_booking_commission_details.hall_booking_id')
			->get()->getResultArray();
		*/
		$dat_hallbooking = $this->db->table('commission')
			->join('staff', 'staff.id = commission.staff_id')
			->select('commission.remarks as name, commission.date as date, SUM(commission.amount) as amount,"Hall Booking" as type, staff.name as staff_name ')
			->where('DATE_FORMAT(commission.date,"%Y-%m-%d") >=', $data['fdate'])
			->where('DATE_FORMAT(commission.date,"%Y-%m-%d") <=', $data['tdate'])
			->where('commission.type', 'Hall Booking');
		if (!empty($staff_name)) {
			$dat_hallbooking = $dat_hallbooking->where('commission.staff_id', $staff_name);
		}
		$dat_hallbooking = $dat_hallbooking->get()->getResultArray();
		//echo $this->db->getLastQuery();die;

		$dat_ubayaam = $this->db->table('commission')
			->join('staff', 'staff.id = commission.staff_id')
			->select('commission.remarks as name, commission.date as date, SUM(commission.amount) as amount,"UBAYAM" as type,staff.name as staff_name')
			->where('DATE_FORMAT(commission.date,"%Y-%m-%d") >=', $data['fdate'])
			->where('DATE_FORMAT(commission.date,"%Y-%m-%d") <=', $data['tdate'])
			->where('commission.type', 'Ubayam');
		if (!empty($staff_name)) {
			$dat_ubayaam = $dat_ubayaam->where('commission.staff_id', $staff_name);
		}
		//$dat_ubayaam->having('commission.amount > 0');
		$dat_ubayaam = $dat_ubayaam->get()->getResultArray();

		if ($cat_type == "archanai") {
			$commission_array = $dat;
		} else if ($cat_type == "hallbooking") {
			$commission_array = $dat_hallbooking;
		} else if ($cat_type == "ubayam") {
			$commission_array = $dat_ubayaam;
		} else {
			$commission_array = array_merge($dat, $dat_hallbooking, $dat_ubayaam);
		}
		//var_dump($dat_ubayaam);
		//exit;
		usort($commission_array, function ($a, $b) {
			return $b['date'] <=> $a['date'];
		});
		$data['commission_data'] = $commission_array;

		if ($_REQUEST['pdf_commissionreport'] == "PDF") {
			$file_name = "Commission_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$dompdf = new \Dompdf\Dompdf();
			$options = $dompdf->getOptions();
			$options->set(array('isRemoteEnabled' => true));
			$dompdf->setOptions($options);
			$dompdf->loadHtml(view('report/pdf/commission_print', ["pdfdata" => $data]));
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$dompdf->stream($file_name);
		} elseif ($_REQUEST['excel_commissionreport'] == "EXCEL") {
			$fileName = "Commission_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();
			$sheet->getStyle('A1')->getFont()->setBold(true)->setName('Arial')->SetSize(10);
			$style = array(
				'alignment' => array(
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				)
			);

			$sheet->getStyle("A1:F1")->applyFromArray($style);
			$sheet->mergeCells('A1:F1');
			$sheet->setCellValue('A1', $_SESSION['site_title']);
			$sheet->setCellValue('A2', 'S.No');
			$sheet->setCellValue('B2', 'Booking Type');
			$sheet->setCellValue('C2', 'Date');
			$sheet->setCellValue('D2', 'Staff Name');
			$sheet->setCellValue('E2', 'Name');
			$sheet->setCellValue('F2', 'Amount');
			$rows = 3;
			$si = 1;
			//var_dump($excel_format_data);
			//exit;
			$total = 0;
			foreach ($data['commission_data'] as $val) {
				if (!empty($val['staff_name']) && !empty($val['name'])) {
					if (!empty($val['amount'])) {
						$amount = number_format($val['amount'], 2);
					} else {
						$amount = "0.00";
					}
					if ($amount > 0) {
						$sheet->setCellValue('A' . $rows, $si);
						$sheet->setCellValue('B' . $rows, $val['type']);
						$sheet->setCellValue('C' . $rows, $val['date']);
						$sheet->setCellValue('D' . $rows, $val['staff_name']);
						$sheet->setCellValue('E' . $rows, $val['name']);
						$sheet->setCellValue('F' . $rows, $amount);
						$rows++;
						$si++;
						$total += $amount;
					}
				}
			}
			$sheet->setCellValue('A' . $rows, "");
			$sheet->setCellValue('B' . $rows, "");
			$sheet->setCellValue('C' . $rows, "");
			$sheet->setCellValue('D' . $rows, "");
			$sheet->setCellValue('E' . $rows, "Total");
			$sheet->setCellValue('F' . $rows, $total);

			$writer = new Xlsx($spreadsheet);
			$writer->save('uploads/excel/' . $fileName . '.xlsx');
			return $this->response->download('uploads/excel/' . $fileName . '.xlsx', null)->setFileName($fileName . '.xlsx');
		} else {
			echo view('report/commission_print', $data);
		}
	}
	public function arch_book_rep_ref()
	{
		$fdata = $_REQUEST['fdt'];
		$tdata = $_REQUEST['tdt'];
		$grp = $_REQUEST['grp'];
		$fltername = $_REQUEST['fltername'];
		if (!empty($fltername)) {
			$pfltername = $fltername;
			$flternameg = " and a.archanai_id = '" . $pfltername . "' ";
		} else {
			$flternameg = '';
		}

		$query1 = $this->db->query("select date, COUNT(date) as tcnt FROM archanai_booking where date >= '$fdata' and date <= '$tdata' GROUP BY date HAVING COUNT(date) > 0");
		$res = $query1->getResultArray();
		$i = 0;

		$i = 1;
		$data = array();
		$grand_total = 0;
		if (!empty($res)) {
			foreach ($res as $r) {
				$rd = $r['date'];
				$query2 = $this->db->query("select id from archanai_booking where date = '$rd'");
				$res1 = $query2->getResultArray();

				foreach ($res1 as $r1) {
					$rid[] = $r1['id'];
				}
				$string_version = implode(',', $rid); //print_r($string_version);die;
				if ($grp == "0" || $grp == '') {
					$query3 = $this->db->query("select a.archanai_id, sum(a.quantity) as qunty, sum(a.total_amount) as amt, sum(a.total_commision) as comm, count(a.archanai_id) as cnt
											from archanai_booking_details a, archanai_booking b
											where a.archanai_booking_id in ($string_version) and a.archanai_booking_id = b.id  and b.date like '%$rd%' $flternameg group by a.archanai_id having count(a.archanai_id) > 0");
				} else {
					$query3 = $this->db->query("select a.archanai_id, sum(a.quantity) as qunty, sum(a.total_amount) as amt, sum(a.total_commision) as comm, count(a.archanai_id) as cnt
					from archanai_booking_details a,archanai b, archanai_booking c
					where b.groupname ='$grp' and a.archanai_id=b.id and c.id = a.archanai_booking_id and a.archanai_booking_id in ($string_version) and c.date like '%$rd%' $flternameg group by a.archanai_id having count(a.archanai_id) > 0");
				}

				$res2 = $query3->getResultArray();

				foreach ($res2 as $row) {
					$total = $row['amt'] + $row['comm'];
					$aname = $this->db->table('archanai')->where('id', $row['archanai_id'])->get()->getRowArray();
					$data[] = array(
						$i++,
						date("d-m-Y", strtotime($rd)),
						$aname['name_eng'],
						$aname['name_tamil'],
						$row['qunty'],
						number_format($total, '2', '.', ',')
					);
					$grand_total += $total;
				}
			}
		}

		$result = array(
			"draw" => 0,
			"recordsTotal" => $i - 1,
			"recordsFiltered" => $i - 1,
			"data" => $data,
			"total" => number_format($grand_total, '2', '.', ','),
		);
		echo json_encode($result);
		exit();
	}
	public function archanai_booking_range()
	{
		$from_date = !empty($_REQUEST['fdt']) ? $_REQUEST['fdt'] : '';
		$to_date = !empty($_REQUEST['tdt']) ? $_REQUEST['tdt'] : '';
		$counter_id = !empty($_REQUEST['counter_id']) ? $_REQUEST['counter_id'] : '';
		$archanai_datas = archanai_booking_range($from_date, $to_date, 'COUNTER', $counter_id);
		$data = array();
		$i = 1;
		foreach ($archanai_datas as $ad) {
			$data[] = array(
				$i++,
				date("d-m-Y", strtotime($ad['date'])),
				$ad['name_in_english'] . '/' . $ad['name_in_tamil'],
				$ad['paymentmode'],
				$ad['counter_name'],
				$ad['qty'],
				number_format($ad['amount'], '2', '.', ',')
			);
		}
		$result = array(
			"draw" => 0,
			"recordsTotal" => $i - 1,
			"recordsFiltered" => $i - 1,
			"data" => $data,
		);
		echo json_encode($result);
		exit();
	}

	public function cash_don_rep_ref()
	{
		$fdt = date('Y-m-d', strtotime($_POST['fdt']));
		$tdt = date('Y-m-d', strtotime($_POST['tdt']));
		$payfor = $_POST['payfor'];
		$fltername = $_POST['fltername'];
		$data = [];
		$dat = $this->db->table('donation', 'donation_setting.name as pname')
			->join('donation_setting', 'donation_setting.id = donation.pay_for')
			->select('donation_setting.name as pname')
			->select('donation.*')
			->where('donation.date>=', $fdt);
		$dat = $dat->where('donation.date<=', $tdt);
		if ($payfor) {
			$dat = $dat->where('donation_setting.id', $payfor);
		}
		if ($fltername) {
			$dat = $dat->where('donation.name', $fltername);
		}
		$dat = $dat->get()->getResultArray();
		$i = 1;
		foreach ($dat as $row) {
			$data[] = array(
				$i++,
				date('d-m-Y', strtotime($row['date'])),
				$row['pname'],
				$row['name'],
				number_format($row['amount'], '2', '.', ','),
			);
		}

		$result = array(
			"draw" => 0,
			"recordsTotal" => $i - 1,
			"recordsFiltered" => $i - 1,
			"data" => $data,
		);
		echo json_encode($result);
		exit();
	}

	public function payslip_report_list()
	{
		$fdt = date('Y-m-d', strtotime($_POST['fdt']));
		$tdt = date('Y-m-d', strtotime($_POST['tdt']));
		$data = [];
		$builder = $this->db->table('pay_slip', 'staff.name as sname')
			->join('staff', 'staff.id = pay_slip.staff_id')
			->select('staff.name as sname')
			->select('pay_slip.*')
			->where('pay_slip.date>=', $fdt)
			->where('pay_slip.date<=', $tdt);
		if (!empty($_POST['staff_name'])) {
			$staff_name = $_POST['staff_name'];
			$builder->where("staff.name LIKE '%$staff_name%'");
		}
		$dat = $builder->orderBy('pay_slip.date', 'desc')->get()->getResultArray();
		$i = 1;
		foreach ($dat as $row) {
			$data[] = array(
				$i++,
				date('d-m-Y', strtotime($row['date'])),
				$row['sname'],
				$row['ref_no'],
				number_format($row['net_pay'], '2', '.', ','),
			);
		}

		$result = array(
			"draw" => 0,
			"recordsTotal" => $i - 1,
			"recordsFiltered" => $i - 1,
			"data" => $data,
		);
		echo json_encode($result);
		exit();
	}

	public function ubayam_rep_ref()
	{
		$fdt = date('Y-m-d', strtotime($_POST['fdt']));
		$tdt = date('Y-m-d', strtotime($_POST['tdt']));
		$payfor = $_POST['payfor'];
		$fltername = $_POST['fltername'];
		$data = [];
		$dat = $this->db->table('ubayam', 'ubayam_setting.name as pname')
			->join('ubayam_setting', 'ubayam_setting.id = ubayam.pay_for')
			->select('ubayam_setting.name as pname')
			->select('ubayam.*')
			->where('DATE_FORMAT(ubayam.ubayam_date, "%Y-%m-%d") >=', $fdt);
		$dat = $dat->where('DATE_FORMAT(ubayam.ubayam_date, "%Y-%m-%d") <=', $tdt);
		if ($payfor) {
			$dat = $dat->where('ubayam_setting.id', $payfor);
		}
		if ($fltername) {
			$dat = $dat->where('ubayam.name', $fltername);
		}
		$dat = $dat->orderBy('ubayam_date', 'desc');
		$dat = $dat->get()->getResultArray();

		$i = 1;
		foreach ($dat as $row) {
			$balance_amount = (float) $row['amount'] - (float) $row['paidamount'];
			if ($balance_amount < 0)
				$balance_amount = 0;
			if (empty($balance_amount)) {
				$txt = '<span class="paid_text">Paid</span>';
			} else {
				$txt = '<span class="unpaid_text">Not Paid</span>';
			}

			$data[] = array(
				$i++,
				date('d-m-Y', strtotime($row['ubayam_date'])),
				$row['pname'],
				$row['name'],
				$row['amount'],
				$row['paidamount'],
				number_format($balance_amount, '2', '.', ','),
				$txt,

			);
		}

		$result = array(
			"draw" => 0,
			"recordsTotal" => $i - 1,
			"recordsFiltered" => $i - 1,
			"data" => $data,
		);
		echo json_encode($result);
		exit();
	}


	public function ubayam_rep_ref_temple()
	{
		$fdt = date('Y-m-d', strtotime($_POST['fdt']));
		$tdt = date('Y-m-d', strtotime($_POST['tdt']));
		$event_date = isset($_POST['event_date']) && !empty($_POST['event_date']) ? date('Y-m-d', strtotime($_POST['event_date'])) : ''; // NEW
		$payfor = $_POST['payfor'];
		$fltername = $_POST['fltername'];
		$booking_type = $_POST['booking_type'];
		$payment_type = isset($_POST['payment_type']) ? $_POST['payment_type'] : '';

		$data = [];
		$dat = $this->db->table('templebooking', 'booked_packages.name as pname')
			->join('booked_packages', 'booked_packages.booking_id = templebooking.id')
			->select('booked_packages.name as pname')
			->select('templebooking.*')
			->where('DATE_FORMAT(templebooking.entry_date, "%Y-%m-%d") >=', $fdt);
		$dat = $dat->where('DATE_FORMAT(templebooking.entry_date, "%Y-%m-%d") <=', $tdt);

		// NEW: Event Date Filter
		if (!empty($event_date)) {
			$dat = $dat->where('DATE_FORMAT(templebooking.booking_date, "%Y-%m-%d")', $event_date);
		}

		if ($payfor) {
			$dat = $dat->where('booked_packages.package_id', $payfor);
		}
		if ($booking_type) {
			$dat = $dat->where('booked_packages.booking_type', $booking_type);
		}
		if ($fltername) {
			$dat = $dat->where('templebooking.name', $fltername);
		}

		// Payment type filter
		if (!empty($payment_type)) {
			if ($payment_type === 'paid' || $payment_type === 'full') {
				$dat = $dat->where('templebooking.paid_amount = templebooking.amount');
				$dat = $dat->where('templebooking.paid_amount > 0');
			} elseif ($payment_type === 'partial') {
				$dat = $dat->where('templebooking.paid_amount > 0');
				$dat = $dat->where('templebooking.paid_amount < templebooking.amount');
			} elseif ($payment_type === 'only_booking') {
				$dat = $dat->groupStart()
					->where('templebooking.paid_amount', 0)
					->orWhere('templebooking.paid_amount IS NULL', null, false)
					->groupEnd();
			}
		}

		$dat = $dat->orderBy('entry_date', 'desc');
		$dat = $dat->get()->getResultArray();

		$print = "";
		$i = 1;

		foreach ($dat as $row) {
			$amount = (float) $row['amount'];
			$paid_amount = (float) $row['paid_amount'];
			$balance_amount = $amount - $paid_amount;

			if ($balance_amount < 0)
				$balance_amount = 0;

			if ($row['booking_status'] == 3) {
				$txt = '<span class="cancel_text">Cancelled</span>';
			} else {
				if ($paid_amount == 0 || $paid_amount === null) {
					$txt = '<span class="unpaid_text">Only Booking</span>';
				} elseif ($paid_amount >= $amount) {
					$txt = '<span class="paid_text">Paid</span>';
				} else {
					$txt = '<span class="unpaid_text">Partially Paid</span>';
				}
			}

			if ($row['booking_type'] == 1) {
				$print = '<a class="btn btn-warning btn-rad" title="Print" href="' . base_url() . '/templehallbooking/print_page/' . $row['id'] . '" target="_blank"><i class="material-icons">print</i> </a>';
			} else if ($row['booking_type'] == 2) {
				$print = '<a class="btn btn-warning btn-rad" title="Print" href="' . base_url() . '/templeubayam/print_page/' . $row['id'] . '" target="_blank"><i class="material-icons">print</i> </a>';
			} else {
				$print = "";
			}

			$edit = '';
			if ($row['booking_status'] != 3) {
				$edit = '<a class="btn btn-primary btn-rad btn-edit-booking" title="Edit" 
    data-id="' . $row['id'] . '" 
    data-name="' . htmlspecialchars($row['name'], ENT_QUOTES) . '" 
    data-booking-date="' . $row['booking_date'] . '" 
    data-booking-type="' . $row['booking_type'] . '" 
    data-remarks="' . htmlspecialchars($row['remarks'] ?? '', ENT_QUOTES) . '" 
    href="javascript:void(0);"><i class="material-icons">edit</i></a>';
			}

			$data[] = array(
				$i++,
				date('d-m-Y', strtotime($row['entry_date'])),
				date('d-m-Y', strtotime($row['booking_date'])),
				$row['pname'],
				$row['name'],
				$row['amount'],
				$txt,
				$print . ' ' . $edit,
			);
		}

		$result = array(
			"draw" => 0,
			"recordsTotal" => $i - 1,
			"recordsFiltered" => $i - 1,
			"data" => $data,
		);
		echo json_encode($result);
		exit();
	}


	public function ubayam_rep_ref_temple_reminder()
	{
		$fdt = date('Y-m-d', strtotime($_POST['fdt']));
		$tdt = date('Y-m-d', strtotime($_POST['tdt']));
		$payfor = $_POST['payfor'];
		$fltername = $_POST['fltername'];
		$booking_type = $_POST['booking_type'];
		$data = [];
		$dat = $this->db->table('templebooking', 'booked_packages.name as pname')
			->join('booked_packages', 'booked_packages.booking_id = templebooking.id')
			->select('booked_packages.name as pname')
			->select('templebooking.*')
			->where('DATE_FORMAT(templebooking.booking_date, "%Y-%m-%d") >=', $fdt);
		$dat = $dat->where('DATE_FORMAT(templebooking.booking_date, "%Y-%m-%d") <=', $tdt);
		// $dat = $this->db->table('ubayam', 'ubayam_setting.name as pname')
		// 	->join('ubayam_setting', 'ubayam_setting.id = ubayam.pay_for')
		// 	->select('ubayam_setting.name as pname')
		// 	->select('ubayam.*')
		// 	->where('DATE_FORMAT(ubayam.ubayam_date, "%Y-%m-%d") >=', $fdt);
		// $dat = $dat->where('DATE_FORMAT(ubayam.ubayam_date, "%Y-%m-%d") <=', $tdt);
		if ($payfor) {
			$dat = $dat->where('booked_packages.package_id', $payfor);
		}
		if ($booking_type) {
			$dat = $dat->where('booked_packages.booking_type', $booking_type);
		}
		if ($fltername) {
			$dat = $dat->where('templebooking.name', $fltername);
		}
		$dat = $dat->orderBy('booking_date', 'asc');
		$dat = $dat->get()->getResultArray();


		$print = "";



		$i = 1;
		foreach ($dat as $row) {
			$balance_amount = (float) $row['amount'] - (float) $row['paid_amount'];
			if ($balance_amount < 0)
				$balance_amount = 0;

			if ($row['booking_status'] == 3) {
				$txt = '<span class="cancel_text">Cancelled</span>';
			} else {

				if (empty($balance_amount)) {
					$txt = '<span class="paid_text">Paid</span>';
				} else {
					$txt = '<span class="unpaid_text">Partially Paid</span>';
				}
			}

			if ($row['booking_type'] == 1) {
				$print = '<a class="btn btn-warning btn-rad" title="Print" href="' . base_url() . '/templehallbooking/print_page/' . $row['id'] . '" target="_blank"><i class="material-icons">print</i> </a>';
				$action = '<a class="btn btn-primary btn-rad" title="Edit" href="' . base_url() . '/report/show_loan_history/' . $r['staff_id'] . '"><i class="material-icons">&#xE417;</i></a>';
			} else if ($row['booking_type'] == 2) {

				$print = '<a class="btn btn-warning btn-rad" title="Print" href="' . base_url() . '/templeubayam/print_page/' . $row['id'] . '" target="_blank"><i class="material-icons">print</i> </a>';
			} else {
				$print = "";
			}

			$data[] = array(
				$i++,
				date('d-m-Y', strtotime($row['entry_date'])),
				date('d-m-Y', strtotime($row['booking_date'])),
				$row['pname'],
				$row['name'],
				$row['amount'],
				// $row['paid_amount'],
				// number_format($balance_amount, '2', '.', ','),
				$txt,
				$print,

			);
		}


		$result = array(
			"draw" => 0,
			"recordsTotal" => $i - 1,
			"recordsFiltered" => $i - 1,
			"data" => $data,
		);
		echo json_encode($result);
		exit();
	}

	/*public function ubayam_rep_ref(){
																																																	 $fdt= date('Y-m-d',strtotime($_POST['fdt']));
																																																	 $tdt= date('Y-m-d',strtotime($_POST['tdt']));
																																																	 $payfor = $_POST['payfor'];
																																																	 $fltername = $_POST['fltername'];
																																																	 $data = [];
																																																	 $dat =  $this->db->table('ubayam', 'ubayam_setting.name as pname', 'ubayam_pay_details.amount as pay_amount', 'ubayam_pay_details.date')
																																																			 ->join('ubayam_setting', 'ubayam_setting.id = ubayam.pay_for')
																																																			 ->join('ubayam_pay_details', 'ubayam_pay_details.ubayam_id = ubayam.id')
																																																			 ->select('ubayam_setting.name as pname')
																																																			 ->select('ubayam_pay_details.amount as pay_amount, ubayam_pay_details.date')
																																																			 ->select('ubayam.*')
																																																			 ->where('DATE_FORMAT(ubayam_pay_details.date, "%Y-%m-%d") >=',$fdt);
																																																			 $dat = $dat->where('DATE_FORMAT(ubayam_pay_details.date, "%Y-%m-%d") <=',$tdt);
																																																			 if($payfor)
																																																			 {
																																																				 $dat = $dat->where('ubayam_setting.id',$payfor);
																																																			 }
																																																			 if($fltername)
																																																			 {
																																																				 $dat = $dat->where('ubayam.name',$fltername);
																																																			 }
																																																			 $dat = $dat->orderBy('date', 'asc');
																																																			 $dat = $dat->get()->getResultArray();

																																																	 $i = 1;		
																																																	 foreach($dat as $row)
																																																	 {
																																																		 $balance_amount = (float) $row['amount'] - (float) $row['paidamount'];
																																																		 if($balance_amount < 0) $balance_amount = 0;
																																																		 if(empty($balance_amount)) { $txt = '<span class="paid_text">Paid</span>'; }  else  { $txt = '<span class="unpaid_text">Not Paid</span>'; }

																																																		 $data[] = array(
																																																			 $i++,
																																																			 date('d-m-Y', strtotime($row['date'])),
																																																			 $row ['pname']  ,
																																																			 $row ['name'],
																																																			 $row['amount'],
																																																			 $row['paidamount'],
																																																			 number_format($balance_amount, '2','.',','),
																																																			 $txt,

																																																		 );
																																																	 }

																																																 $result = array(
																																																	 "draw" => 0,
																																																	 "recordsTotal" => $i-1,
																																																	 "recordsFiltered" => $i-1,
																																																	 "data" => $data,
																																																 );
																																																 echo json_encode($result);
																																																 exit();		
																																																 }*/


	public function hall_book_rep_ref()
	{
		$fdt = date('Y-m-d', strtotime($_POST['fdt']));
		$tdt = date('Y-m-d', strtotime($_POST['tdt']));
		$stss = $_POST['sts'];
		$edate = $_POST['edate'];
		if ($stss == 0) {
			if ($edate)
				$dat = $this->db->table('hall_booking')->where('DATE_FORMAT(entry_date, "%Y-%m-%d")', $edate)->where('DATE_FORMAT(entry_date, "%Y-%m-%d")>=', $fdt)->where('DATE_FORMAT(entry_date, "%Y-%m-%d")<=', $tdt)->get()->getResultArray();
			else
				$dat = $this->db->table('hall_booking')->where('DATE_FORMAT(entry_date, "%Y-%m-%d")>=', $fdt)->where('DATE_FORMAT(entry_date, "%Y-%m-%d")<=', $tdt)->get()->getResultArray();
		} else {
			if ($edate)
				$dat = $this->db->table('hall_booking')->where('DATE_FORMAT(entry_date, "%Y-%m-%d")', $edate)->where('DATE_FORMAT(entry_date, "%Y-%m-%d")>=', $fdt)->where('DATE_FORMAT(entry_date, "%Y-%m-%d")<=', $tdt)->where('status', $stss)->get()->getResultArray();
			else
				$dat = $this->db->table('hall_booking')->where('DATE_FORMAT(entry_date, "%Y-%m-%d")>=', $fdt)->where('DATE_FORMAT(entry_date, "%Y-%m-%d")<=', $tdt)->where('status', $stss)->get()->getResultArray();
		}
		$data = [];
		// $dat =  $this->db->table('hall_booking')		
		// ->where('DATE_FORMAT(entry_date, "%Y-%m-%d")>=',$fdt)
		// ->where('DATE_FORMAT(entry_date, "%Y-%m-%d")<=',$tdt)			
		// ->get()->getResultArray();
		//echo "<pre>"; print_r($dat); exit();
		$i = 1;
		$sts = "";
		foreach ($dat as $row) {
			if ($row['status'] == 1)
				$sts = "Booked";
			else if ($row['status'] == 2)
				$sts = "Completed";
			else if ($row['status'] == 3)
				$sts = "Cancelled";



			$data[] = array(
				$i++,
				// $row['booking_date'],
				// $row ['entry_date'],
				date('d-m-Y', strtotime($row['booking_date'])),
				date('d-m-Y', strtotime($row['entry_date'])),
				$row['name'],
				$row['event_name'],
				$sts,
				$row['total_amount'],
				$row['paid_amount'],
				$row['balance_amount']
			);
		}

		$result = array(
			"draw" => 0,
			"recordsTotal" => $i - 1,
			"recordsFiltered" => $i - 1,
			"data" => $data,
		);
		echo json_encode($result);
		exit();
	}


	public function print_hallbooking()
	{
		if (!$this->model->list_validate('hall_report')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['fdate'] = $_REQUEST['fdt'];
		$data['tdate'] = $_REQUEST['tdt'];
		$data['sts'] = $_REQUEST['sts'];
		$data['edate'] = $_REQUEST['event_date'];

		$fdt = date('Y-m-d', strtotime($_REQUEST['fdt']));
		$tdt = date('Y-m-d', strtotime($_REQUEST['tdt']));
		$stss = $_REQUEST['sts'];
		$edate = $_REQUEST['event_date'];
		if ($stss == 0) {
			if ($edate)
				$data['data'] = $this->db->table('hall_booking')->where('DATE_FORMAT(entry_date, "%Y-%m-%d")', $edate)->where('DATE_FORMAT(entry_date, "%Y-%m-%d")>=', $fdt)->where('DATE_FORMAT(entry_date, "%Y-%m-%d")<=', $tdt)->get()->getResultArray();
			else
				$data['data'] = $this->db->table('hall_booking')->where('DATE_FORMAT(entry_date, "%Y-%m-%d")>=', $fdt)->where('DATE_FORMAT(entry_date, "%Y-%m-%d")<=', $tdt)->get()->getResultArray();
		} else {
			if ($edate)
				$data['data'] = $this->db->table('hall_booking')->where('DATE_FORMAT(entry_date, "%Y-%m-%d")', $edate)->where('DATE_FORMAT(entry_date, "%Y-%m-%d")>=', $fdt)->where('DATE_FORMAT(entry_date, "%Y-%m-%d")<=', $tdt)->where('status', $stss)->get()->getResultArray();
			else
				$data['data'] = $this->db->table('hall_booking')->where('DATE_FORMAT(entry_date, "%Y-%m-%d")>=', $fdt)->where('DATE_FORMAT(entry_date, "%Y-%m-%d")<=', $tdt)->where('status', $stss)->get()->getResultArray();
		}

		// if ($data['sts']==0)
		// {

		// $data['data'] =  $this->db->table('hall_booking')->where('DATE_FORMAT(entry_date, "%Y-%m-%d")>=',$data['fdate'])->where('DATE_FORMAT(entry_date, "%Y-%m-%d")<=',$data['tdate'])->get()->getResultArray();		
		// }
		// else
		// {
		// // echo '<pre>'; print_r($data['sts']);die;
		// $data['data'] =  $this->db->table('hall_booking')->where('DATE_FORMAT(entry_date, "%Y-%m-%d")>=',$data['fdate'])->where('DATE_FORMAT(entry_date, "%Y-%m-%d")<=',$data['tdate'])->where('status',$data['sts'])->get()->getResultArray();		
		// }
		//echo $this->db->getLastQuery();
		//echo '<pre>'; print_r($data['data']);die;
		if ($_REQUEST['pdf_hallreport'] == "PDF") {
			$file_name = "Hall_Booking_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$dompdf = new \Dompdf\Dompdf();
			$options = $dompdf->getOptions();
			$options->set(array('isRemoteEnabled' => true));
			$dompdf->setOptions($options);
			$dompdf->loadHtml(view('report/pdf/hallbooking_print', ["pdfdata" => $data]));
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$dompdf->stream($file_name);
		} elseif ($_REQUEST['excel_hallreport'] == "EXCEL") {
			$fileName = "Hall_Booking_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();
			$sheet->getStyle('A1')->getFont()->setBold(true)->setName('Arial')->SetSize(10);
			$style = array(
				'alignment' => array(
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				)
			);

			$sheet->getStyle("A1:I1")->applyFromArray($style);
			$sheet->mergeCells('A1:I1');
			$sheet->setCellValue('A1', $_SESSION['site_title']);
			$sheet->setCellValue('A2', 'S.No');
			$sheet->setCellValue('B2', 'Booking Date');
			$sheet->setCellValue('C2', 'Entry Date');
			$sheet->setCellValue('D2', 'Name');
			$sheet->setCellValue('E2', 'Event Details');
			$sheet->setCellValue('F2', 'Status');
			$sheet->setCellValue('G2', 'Total Amount');
			$sheet->setCellValue('H2', 'Paid Amount');
			$sheet->setCellValue('I2', 'Balance Amount');
			$rows = 3;
			$si = 1;
			$excel_format_data = $this->excel_format_get_hallreport($data['fdate'], $data['tdate'], $data['sts']);
			//var_dump($excel_format_data);
			//exit;
			foreach ($excel_format_data as $val) {
				$sheet->setCellValue('A' . $rows, $val['s_no']);
				$sheet->setCellValue('B' . $rows, $val['booking_date']);
				$sheet->setCellValue('C' . $rows, $val['entry_date']);
				$sheet->setCellValue('D' . $rows, $val['name']);
				$sheet->setCellValue('E' . $rows, $val['event_name']);
				$sheet->setCellValue('F' . $rows, $val['status']);
				$sheet->setCellValue('G' . $rows, $val['total_amount']);
				$sheet->setCellValue('H' . $rows, $val['paid_amount']);
				$sheet->setCellValue('I' . $rows, $val['balance_amount']);
				$rows++;
				$si++;
			}
			$writer = new Xlsx($spreadsheet);
			$writer->save('uploads/excel/' . $fileName . '.xlsx');
			return $this->response->download('uploads/excel/' . $fileName . '.xlsx', null)->setFileName($fileName . '.xlsx');
		} else {
			echo view('report/hallbooking_print', $data);
		}
	}
	public function excel_format_get_hallreport($fdata, $tdata, $sts)
	{
		$fdt = date('Y-m-d', strtotime($fdata));
		$tdt = date('Y-m-d', strtotime($tdata));
		$stss = $sts;

		if ($stss == 0) {
			$dat = $this->db->table('hall_booking')
				->where('DATE_FORMAT(entry_date, "%Y-%m-%d")>=', $fdt)
				->where('DATE_FORMAT(entry_date, "%Y-%m-%d")<=', $tdt)
				->get()->getResultArray();
		} else {
			$dat = $this->db->table('hall_booking')
				->where('DATE_FORMAT(entry_date, "%Y-%m-%d")>=', $fdt)
				->where('DATE_FORMAT(entry_date, "%Y-%m-%d")<=', $tdt)
				->where('status', $stss)
				->get()->getResultArray();
		}
		$data = [];
		$i = 1;
		$sts = "";
		foreach ($dat as $row) {
			if ($row['status'] == 1)
				$sts = "Booked";
			else if ($row['status'] == 2)
				$sts = "Completed";
			else if ($row['status'] == 3)
				$sts = "Cancelled";
			$data[] = array(
				"s_no" => $i++,
				"booking_date" => date('d-m-Y', strtotime($row['booking_date'])),
				"entry_date" => date('d-m-Y', strtotime($row['entry_date'])),
				"event_name" => $row['event_name'],
				"status" => $sts,
				"total_amount" => $row['total_amount'],
				"paid_amount" => $row['paid_amount'],
				"balance_amount" => $row['balance_amount']
			);
		}
		return $data;
	}

	public function print_archanaireport()
	{

		if (!$this->model->list_validate('archanai_report')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['fdate'] = $_REQUEST['fdt'];
		$data['tdate'] = $_REQUEST['tdt'];
		$fdata = $_REQUEST['fdt'];
		$tdata = $_REQUEST['tdt'];
		$grp = $_REQUEST['grp'];
		$fltername = $_REQUEST['fltername'];
		if (!empty($fltername)) {
			$pfltername = $fltername;
			$flternameg = " and a.archanai_id = '" . $pfltername . "' ";
		} else {
			$flternameg = '';
		}
		$data['grp'] = $grp;
		$data['fltername'] = $fltername;
		$query1 = $this->db->query("select date, COUNT(date) as tcnt FROM archanai_booking where date >= '$fdata' and date <= '$tdata' GROUP BY date HAVING COUNT(date) > 0");
		$res = $query1->getResultArray();
		$i = 0;
		foreach ($res as $r) {
			$rd = $r['date'];
			$query2 = $this->db->query("select id from archanai_booking where date = '$rd'");
			$res1 = $query2->getResultArray();
			foreach ($res1 as $r1) {
				$rid[] = $r1['id'];
			}
			$string_version = implode(',', $rid);
			if ($grp == "0" || $grp == '') {
				$query3 = $this->db->query("select a.archanai_id, sum(a.quantity) as qunty, sum(a.total_amount) as amt, sum(a.total_commision) as comm, count(a.archanai_id) as cnt
											from archanai_booking_details a, archanai_booking b
											where a.archanai_booking_id in ($string_version) and a.archanai_booking_id = b.id  and b.date like '%$rd%' $flternameg group by a.archanai_id having count(a.archanai_id) > 0");
			} else {
				$query3 = $this->db->query("select a.archanai_id, sum(a.quantity) as qunty, sum(a.total_amount) as amt, sum(a.total_commision) as comm, count(a.archanai_id) as cnt
					from archanai_booking_details a,archanai b, archanai_booking c
					where b.groupname ='$grp' and a.archanai_id=b.id and c.id = a.archanai_booking_id and a.archanai_booking_id in ($string_version) and c.date like '%$rd%' $flternameg group by a.archanai_id having count(a.archanai_id) > 0");
			}


			$res2 = $query3->getResultArray();

			// echo '<pre>';
			// print_r($res2); exit;
			// $sqla="select a.archanai_id, sum(a.quantity) as qunty, a.amount+a.commision as tot, count(a.archanai_id) as cnt from archanai_booking_details a,archanai b where b.groupname=a and a.archanai_booking_id=b.id and a.archanai_booking_id in  group by a.archanai_id having count(a.archanai_id) > 0"


			foreach ($res2 as $row) {
				$aname = $this->db->table('archanai')->where('id', $row['archanai_id'])->get()->getRowArray();
				$total = $row['amt'] + $row['comm'];
				$data['data'][$i]['date'] = date("d-m-Y", strtotime($rd));
				$data['data'][$i]['name'] = $aname['name_eng'];
				$data['data'][$i]['qunt'] = $row['qunty'];
				$data['data'][$i++]['rate'] = $total;
			}
		}
		if ($_REQUEST['pdf_archanaireport'] == "PDF") {
			$file_name = "Archanai_Booking_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$dompdf = new \Dompdf\Dompdf();
			$options = $dompdf->getOptions();
			$options->set(array('isRemoteEnabled' => true));
			$dompdf->setOptions($options);
			$dompdf->loadHtml(view('report/pdf/archanai_print', ["pdfdata" => $data]), 'UTF-8');
			$dompdf->setPaper('LEGAL', 'portrait');
			$dompdf->render();
			$dompdf->stream($file_name);
		} elseif ($_REQUEST['excel_archanaireport'] == "EXCEL") {
			$fileName = "Archanai_Booking_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$spreadsheet = new Spreadsheet();

			$sheet = $spreadsheet->getActiveSheet();
			$sheet->getStyle('A1')->getFont()->setBold(true)->setName('Arial')->SetSize(10);
			$style = array(
				'alignment' => array(
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				)
			);

			$sheet->getStyle("A1:F1")->applyFromArray($style);
			$sheet->mergeCells('A1:F1');
			$sheet->setCellValue('A1', $_SESSION['site_title']);
			$sheet->setCellValue('A2', 'S.No');
			$sheet->setCellValue('B2', 'Date');
			$sheet->setCellValue('C2', 'Product Name in English');
			$sheet->setCellValue('D2', 'Product Name in Tamil');
			$sheet->setCellValue('E2', 'Quantity');
			$sheet->setCellValue('F2', 'Amount');
			$rows = 3;
			$si = 1;
			$excel_format_data = $this->excel_format_get_archanairecord($fdata, $tdata, $grp, $fltername);
			//var_dump($excel_format_data);
			//exit;
			foreach ($excel_format_data as $val) {
				$sheet->setCellValue('A' . $rows, $val['s_no']);
				$sheet->setCellValue('B' . $rows, $val['date']);
				$sheet->setCellValue('C' . $rows, $val['name_eng']);
				$sheet->setCellValue('D' . $rows, $val['name_tamil']);
				$sheet->setCellValue('E' . $rows, $val['qty']);
				$sheet->setCellValue('F' . $rows, $val['total']);
				$rows++;
				$si++;
			}
			$writer = new Xlsx($spreadsheet);
			$writer->save('uploads/excel/' . $fileName . '.xlsx');
			return $this->response->download('uploads/excel/' . $fileName . '.xlsx', null)->setFileName($fileName . '.xlsx');
		} else {
			echo view('report/archanai_print', $data);
		}
	}
	public function print_counter()
	{

		if (!$this->model->list_validate('archanai_report')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data = array();
		$from_date = !empty($_REQUEST['fdt']) ? $_REQUEST['fdt'] : '';
		$to_date = !empty($_REQUEST['tdt']) ? $_REQUEST['tdt'] : '';
		$counter_id = !empty($_REQUEST['counter_id']) ? $_REQUEST['counter_id'] : '';
		$archanai_datas = archanai_booking_range($from_date, $to_date, 'COUNTER', $counter_id);
		$data['fdate'] = date('d-m-Y', strtotime($from_date));
		$data['tdate'] = date('d-m-Y', strtotime($to_date));
		$data['data'] = $archanai_datas;
		$i = 1;
		if ($_REQUEST['pdf_archanaireport'] == "PDF") {
			$file_name = "Archanai_Booking_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$dompdf = new \Dompdf\Dompdf();
			$options = $dompdf->getOptions();
			$options->set(array('isRemoteEnabled' => true));
			$dompdf->setOptions($options);
			$dompdf->loadHtml(view('report/pdf/counter_archanai', ["pdfdata" => $data]), 'UTF-8');
			$dompdf->setPaper('LEGAL', 'portrait');
			$dompdf->render();
			$dompdf->stream($file_name);
		} elseif ($_REQUEST['excel_archanaireport'] == "EXCEL") {
			$fileName = "Archanai_Booking_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$spreadsheet = new Spreadsheet();

			$sheet = $spreadsheet->getActiveSheet();
			$sheet->getStyle('A1')->getFont()->setBold(true)->setName('Arial')->SetSize(10);
			$style = array(
				'alignment' => array(
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				)
			);

			$sheet->getStyle("A1:F1")->applyFromArray($style);
			$sheet->mergeCells('A1:F1');
			$sheet->setCellValue('A1', $_SESSION['site_title']);
			$sheet->setCellValue('A2', 'S.No');
			$sheet->setCellValue('B2', 'Date');
			$sheet->setCellValue('C2', 'Name');
			$sheet->setCellValue('D2', 'Payment Mode');
			$sheet->setCellValue('E2', 'Paid Through');
			$sheet->setCellValue('F2', 'Quantity');
			$sheet->setCellValue('G2', 'Amount');
			$rows = 3;
			$si = 1;
			$excel_format_data = $this->excel_format_get_archanairecord($fdata, $tdata, $grp, $fltername);
			//var_dump($excel_format_data);
			//exit;
			// foreach ($excel_format_data as $val) {
			// 	$sheet->setCellValue('A' . $rows, $val['s_no']);
			// 	$sheet->setCellValue('B' . $rows, $val['date']);
			// 	$sheet->setCellValue('C' . $rows, $val['name_eng'] . '/' . $val['name_tamil']);
			// 	$sheet->setCellValue('D' . $rows, $val['paymentmode']);
			// 	$sheet->setCellValue('E' . $rows, $val['counter_name']);
			// 	$sheet->setCellValue('F' . $rows, $val['qty']);
			// 	$sheet->setCellValue('G' . $rows, $val['total']);
			// 	$rows++;
			// 	$si++;
			// }
			foreach ($archanai_datas as $val) {
				$sheet->setCellValue('A' . $rows, $si);
				$sheet->setCellValue('B' . $rows, date('d-m-Y', strtotime($val['date'])));
				$sheet->setCellValue('C' . $rows, $val['name_in_english'] . '/' . $val['name_in_tamil']);
				$sheet->setCellValue('D' . $rows, $val['paymentmode']);
				$sheet->setCellValue('E' . $rows, $val['counter_name']);
				$sheet->setCellValue('F' . $rows, $val['qty']);
				$sheet->setCellValue('G' . $rows, number_format($val['amount'], 2));
				$rows++;
				$si++;
			}
			$writer = new Xlsx($spreadsheet);
			$writer->save('uploads/excel/' . $fileName . '.xlsx');
			return $this->response->download('uploads/excel/' . $fileName . '.xlsx', null)->setFileName($fileName . '.xlsx');
		} else {
			echo view('report/counter_archanai_print', $data);
		}
	}
	public function excel_format_get_archanairecord($fdata, $tdata, $grp, $nameid)
	{
		if (!empty($nameid)) {
			$pfltername = $nameid;
			$flternameg = " and a.archanai_id = '" . $pfltername . "' ";
		} else {
			$flternameg = '';
		}
		$query1 = $this->db->query("select date, COUNT(date) as tcnt FROM archanai_booking where date >= '$fdata' and date <= '$tdata' GROUP BY date HAVING COUNT(date) > 0");
		$res = $query1->getResultArray();
		$i = 0;
		$i = 1;
		$data = array();
		if (!empty($res)) {
			foreach ($res as $r) {
				$rd = $r['date'];
				$query2 = $this->db->query("select id from archanai_booking where date = '$rd'");
				$res1 = $query2->getResultArray();

				foreach ($res1 as $r1) {
					$rid[] = $r1['id'];
				}
				$string_version = implode(',', $rid); //print_r($string_version);die;
				if ($grp == "0" || $grp == '') {
					$query3 = $this->db->query("select a.archanai_id, sum(a.quantity) as qunty, sum(a.total_amount) as amt, sum(a.total_commision) as comm, count(a.archanai_id) as cnt
											from archanai_booking_details a, archanai_booking b
											where a.archanai_booking_id in ($string_version) and a.archanai_booking_id = b.id  and b.date like '%$rd%' $flternameg group by a.archanai_id having count(a.archanai_id) > 0");
				} else {
					$query3 = $this->db->query("select a.archanai_id, sum(a.quantity) as qunty, sum(a.total_amount) as amt, sum(a.total_commision) as comm, count(a.archanai_id) as cnt
					from archanai_booking_details a,archanai b, archanai_booking c
					where b.groupname ='$grp' and a.archanai_id=b.id and c.id = a.archanai_booking_id and a.archanai_booking_id in ($string_version) and c.date like '%$rd%' $flternameg group by a.archanai_id having count(a.archanai_id) > 0");
				}

				//echo $this->db->getLastQuery();die;
				$res2 = $query3->getResultArray();
				//print_r($res2);die;
				foreach ($res2 as $row) {
					//print_r($row);
					$total = $row['amt'] + $row['comm'];
					$aname = $this->db->table('archanai')->where('id', $row['archanai_id'])->get()->getRowArray();
					$data[] = array(
						"s_no" => $i++,
						"date" => date("d-m-Y", strtotime($rd)),
						"name_eng" => $aname['name_eng'],
						"name_tamil" => $aname['name_tamil'],
						"qty" => $row['qunty'],
						"total" => $total
					);
				}
			}
		}
		return $data;
	}
	public function print_ubayamreport_temple()
	{
		if (!$this->model->list_validate('ubayam_report')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['fdate'] = $_REQUEST['fdt'];
		$data['tdate'] = $_REQUEST['tdt'];
		$data['payfor'] = $_REQUEST['payfor'];
		$data['booking_type'] = $_REQUEST['booking_type'];
		$data['fltername'] = $_REQUEST['fltername'];
		$data['payment_type'] = isset($_REQUEST['payment_type']) ? $_REQUEST['payment_type'] : ''; // NEW

		if ($_REQUEST['pdf_ubayamreport'] == "PDF") {
			$file_name = "Ubayam_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$dompdf = new \Dompdf\Dompdf();
			$options = $dompdf->getOptions();
			$options->set(array('isRemoteEnabled' => true));
			$dompdf->setOptions($options);
			$dompdf->loadHtml(view('report/pdf/ubay_print_temple', ["pdfdata" => $data]));
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$dompdf->stream($file_name);
		} elseif ($_REQUEST['excel_ubayamreport'] == "EXCEL") {
			$fileName = "Ubayam_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();
			$sheet->getStyle('A1')->getFont()->setBold(true)->setName('Arial')->SetSize(10);
			$style = array(
				'alignment' => array(
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				)
			);

			$sheet->getStyle("A1:H1")->applyFromArray($style);
			$sheet->mergeCells('A1:H1');
			$sheet->setCellValue('A1', $_SESSION['site_title']);
			$sheet->setCellValue('A2', 'S.No');
			$sheet->setCellValue('B2', 'Booking Date');
			$sheet->setCellValue('C2', 'Event Date');
			$sheet->setCellValue('D2', 'Event Name');
			$sheet->setCellValue('E2', 'Name');
			$sheet->setCellValue('F2', 'Amount');
			$sheet->setCellValue('G2', 'Status');
			$rows = 3;
			$si = 1;
			$excel_format_data = $this->excel_format_get_ubayamreport_temple($data['fdate'], $data['tdate'], $data['payfor'], $data['fltername'], $data['booking_type'], $data['payment_type']);

			foreach ($excel_format_data as $val) {
				$sheet->setCellValue('A' . $rows, $val['s_no']);
				$sheet->setCellValue('B' . $rows, $val['entry_date']);
				$sheet->setCellValue('C' . $rows, $val['date']);
				$sheet->setCellValue('D' . $rows, $val['pname']);
				$sheet->setCellValue('E' . $rows, $val['name']);
				$sheet->setCellValue('F' . $rows, $val['amount']);
				$sheet->setCellValue('G' . $rows, $val['status']);
				$rows++;
				$si++;
			}
			$writer = new Xlsx($spreadsheet);
			$writer->save('uploads/excel/' . $fileName . '.xlsx');
			return $this->response->download('uploads/excel/' . $fileName . '.xlsx', null)->setFileName($fileName . '.xlsx');
		} else {
			echo view('report/ubay_print_temple', $data);
		}
	}


	public function print_ubayamreport_temple_reminder()
	{
		if (!$this->model->list_validate('ubayam_report')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['fdate'] = $_REQUEST['fdt'];
		$data['tdate'] = $_REQUEST['tdt'];
		$data['payfor'] = $_REQUEST['payfor'];
		$data['booking_type'] = $_REQUEST['booking_type'];
		$data['fltername'] = $_REQUEST['fltername'];
		if ($_REQUEST['pdf_ubayamreport'] == "PDF") {
			$file_name = "Ubayam_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$dompdf = new \Dompdf\Dompdf();
			$options = $dompdf->getOptions();
			$options->set(array('isRemoteEnabled' => true));
			$dompdf->setOptions($options);
			$dompdf->loadHtml(view('report/pdf/ubay_print_temple_reminder', ["pdfdata" => $data]));
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$dompdf->stream($file_name);
		} elseif ($_REQUEST['excel_ubayamreport'] == "EXCEL") {
			$fileName = "Ubayam_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$spreadsheet = new Spreadsheet();

			$sheet = $spreadsheet->getActiveSheet();
			$sheet->getStyle('A1')->getFont()->setBold(true)->setName('Arial')->SetSize(10);
			$style = array(
				'alignment' => array(
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				)
			);

			$sheet->getStyle("A1:H1")->applyFromArray($style);
			$sheet->mergeCells('A1:H1');
			$sheet->setCellValue('A1', $_SESSION['site_title']);
			$sheet->setCellValue('A2', 'S.No');
			$sheet->setCellValue('B2', 'Booking Date');
			$sheet->setCellValue('C2', 'Event Date');
			$sheet->setCellValue('D2', 'Event Name');
			$sheet->setCellValue('E2', 'Name');
			$sheet->setCellValue('F2', 'Amount');
			// $sheet->setCellValue('F2', 'Paid');
			// $sheet->setCellValue('G2', 'Balance');
			$sheet->setCellValue('G2', 'Status');
			$rows = 3;
			$si = 1;
			$excel_format_data = $this->excel_format_get_ubayamreport_temple_reminder($data['fdate'], $data['tdate'], $data['payfor'], $data['fltername'], $data['booking_type']);
			//var_dump($excel_format_data);
			//exit;
			foreach ($excel_format_data as $val) {
				$sheet->setCellValue('A' . $rows, $val['s_no']);
				$sheet->setCellValue('B' . $rows, $val['entry_date']);
				$sheet->setCellValue('C' . $rows, $val['date']);
				$sheet->setCellValue('D' . $rows, $val['pname']);
				$sheet->setCellValue('E' . $rows, $val['name']);
				$sheet->setCellValue('F' . $rows, $val['amount']);
				// $sheet->setCellValue('F' . $rows, $val['paid']);
				// $sheet->setCellValue('G' . $rows, $val['bal']);
				$sheet->setCellValue('G' . $rows, $val['status']);
				$rows++;
				$si++;
			}
			$writer = new Xlsx($spreadsheet);
			$writer->save('uploads/excel/' . $fileName . '.xlsx');
			return $this->response->download('uploads/excel/' . $fileName . '.xlsx', null)->setFileName($fileName . '.xlsx');
		} else {
			echo view('report/ubay_print_temple_reminder', $data);
		}
	}

	public function print_ubayamreport()
	{
		if (!$this->model->list_validate('ubayam_report')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['fdate'] = $_REQUEST['fdt'];
		$data['tdate'] = $_REQUEST['tdt'];
		$data['payfor'] = $_REQUEST['payfor'];
		$data['fltername'] = $_REQUEST['fltername'];
		if ($_REQUEST['pdf_ubayamreport'] == "PDF") {
			$file_name = "Ubayam_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$dompdf = new \Dompdf\Dompdf();
			$options = $dompdf->getOptions();
			$options->set(array('isRemoteEnabled' => true));
			$dompdf->setOptions($options);
			$dompdf->loadHtml(view('report/pdf/ubay_print', ["pdfdata" => $data]));
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$dompdf->stream($file_name);
		} elseif ($_REQUEST['excel_ubayamreport'] == "EXCEL") {
			$fileName = "Ubayam_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$spreadsheet = new Spreadsheet();

			$sheet = $spreadsheet->getActiveSheet();
			$sheet->getStyle('A1')->getFont()->setBold(true)->setName('Arial')->SetSize(10);
			$style = array(
				'alignment' => array(
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				)
			);

			$sheet->getStyle("A1:H1")->applyFromArray($style);
			$sheet->mergeCells('A1:H1');
			$sheet->setCellValue('A1', $_SESSION['site_title']);
			$sheet->setCellValue('A2', 'S.No');
			$sheet->setCellValue('B2', 'Date');
			$sheet->setCellValue('C2', 'Pay for');
			$sheet->setCellValue('D2', 'Name');
			$sheet->setCellValue('E2', 'Amount');
			$sheet->setCellValue('F2', 'Paid');
			$sheet->setCellValue('G2', 'Balance');
			$sheet->setCellValue('H2', 'Status');
			$rows = 3;
			$si = 1;
			$excel_format_data = $this->excel_format_get_ubayamreport($data['fdate'], $data['tdate'], $data['payfor'], $data['fltername']);
			//var_dump($excel_format_data);
			//exit;
			foreach ($excel_format_data as $val) {
				$sheet->setCellValue('A' . $rows, $val['s_no']);
				$sheet->setCellValue('B' . $rows, $val['date']);
				$sheet->setCellValue('C' . $rows, $val['pname']);
				$sheet->setCellValue('D' . $rows, $val['name']);
				$sheet->setCellValue('E' . $rows, $val['amount']);
				$sheet->setCellValue('F' . $rows, $val['paid']);
				$sheet->setCellValue('G' . $rows, $val['bal']);
				$sheet->setCellValue('H' . $rows, $val['status']);
				$rows++;
				$si++;
			}
			$writer = new Xlsx($spreadsheet);
			$writer->save('uploads/excel/' . $fileName . '.xlsx');
			return $this->response->download('uploads/excel/' . $fileName . '.xlsx', null)->setFileName($fileName . '.xlsx');
		} else {
			echo view('report/ubay_print', $data);
		}
	}
	public function excel_format_get_ubayamreport_temple($fdata, $tdata, $payfor, $fltername, $booking_type, $payment_type = '')
	{
		$fdt = date('Y-m-d', strtotime($fdata));
		$tdt = date('Y-m-d', strtotime($tdata));
		$payforg = $payfor;
		$flternameg = $fltername;
		$data = [];

		$dat = $this->db->table('templebooking', 'booked_packages.name as pname')
			->join('booked_packages', 'booked_packages.booking_id = templebooking.id')
			->select('booked_packages.name as pname')
			->select('templebooking.*')
			->where('DATE_FORMAT(templebooking.entry_date, "%Y-%m-%d") >=', $fdt);
		$dat = $dat->where('DATE_FORMAT(templebooking.entry_date, "%Y-%m-%d") <=', $tdt);

		if ($payforg) {
			$dat = $dat->where('booked_packages.package_id', $payforg);
		}
		if ($booking_type) {
			$dat = $dat->where('booked_packages.booking_type', $booking_type);
		}
		if ($fltername) {
			$dat = $dat->where('templebooking.name', $fltername);
		}

		// NEW: Add payment type filter
		if (!empty($payment_type)) {
			if ($payment_type === 'paid') {
				$dat = $dat->where('templebooking.paid_amount = templebooking.amount');
				$dat = $dat->where('templebooking.paid_amount > 0');
			} elseif ($payment_type === 'partial') {
				$dat = $dat->where('templebooking.paid_amount > 0');
				$dat = $dat->where('templebooking.paid_amount < templebooking.amount');
			} elseif ($payment_type === 'unpaid') {
				$dat = $dat->groupStart()
					->where('templebooking.paid_amount', 0)
					->orWhere('templebooking.paid_amount IS NULL', null, false)
					->groupEnd();
			}
		}

		$dat = $dat->orderBy('entry_date', 'desc');
		$dat = $dat->get()->getResultArray();

		$i = 1;
		foreach ($dat as $row) {
			$balance_amount = (float) $row['amount'] - (float) $row['paid_amount'];
			if ($balance_amount < 0)
				$balance_amount = 0;
			if ($row['booking_status'] == 3) {
				$txt = 'Cancelled';
			} else {
				if (empty($balance_amount)) {
					$txt = 'Paid';
				} else {
					$txt = 'Partially Paid';
				}
			}
			$data[] = array(
				"s_no" => $i++,
				"entry_date" => date('d-m-Y', strtotime($row['entry_date'])),
				"date" => date('d-m-Y', strtotime($row['booking_date'])),
				"pname" => $row['pname'],
				"name" => $row['name'],
				"amount" => $row['amount'],
				"status" => $txt
			);
		}
		return $data;
	}







	public function excel_format_get_ubayamreport_temple_reminder($fdata, $tdata, $payfor, $fltername, $booking_type)
	{
		$fdt = date('Y-m-d', strtotime($fdata));
		$tdt = date('Y-m-d', strtotime($tdata));
		$payforg = $payfor;
		$flternameg = $fltername;
		$data = [];
		// $dat = $this->db->table('ubayam', 'ubayam_setting.name as pname')
		// 	->join('ubayam_setting', 'ubayam_setting.id = ubayam.pay_for')
		// 	->select('ubayam_setting.name as pname')
		// 	->select('ubayam.*')
		// 	->where('DATE_FORMAT(ubayam.ubayam_date, "%Y-%m-%d") >=', $fdt);
		// $dat = $dat->where('DATE_FORMAT(ubayam.ubayam_date, "%Y-%m-%d") <=', $tdt);
		// if ($payfor) {
		// 	$dat = $dat->where('ubayam_setting.id', $payfor);
		// }
		// if ($fltername) {
		// 	$dat = $dat->where('ubayam.name', $fltername);
		// }
		// $dat = $dat->orderBy('ubayam_date', 'asc');
		// $dat = $dat->get()->getResultArray();
		$dat = $this->db->table('templebooking', 'booked_packages.name as pname')
			->join('booked_packages', 'booked_packages.booking_id = templebooking.id')
			->select('booked_packages.name as pname')
			->select('templebooking.*')
			->where('DATE_FORMAT(templebooking.booking_date, "%Y-%m-%d") >=', $fdt);
		$dat = $dat->where('DATE_FORMAT(templebooking.booking_date, "%Y-%m-%d") <=', $tdt);
		if ($payforg) {
			$dat = $dat->where('booked_packages.package_id', $payforg);
		}
		if ($booking_type) {
			$dat = $dat->where('booked_packages.booking_type', $booking_type);
		}
		if ($fltername) {
			$dat = $dat->where('templebooking.name', $fltername);
		}
		$dat = $dat->orderBy('booking_date', 'asc');
		$dat = $dat->get()->getResultArray();

		$i = 1;
		foreach ($dat as $row) {
			$balance_amount = (float) $row['amount'] - (float) $row['paid_amount'];
			if ($balance_amount < 0)
				$balance_amount = 0;
			if ($row['booking_status'] == 3) {
				$txt = 'Cancelled';
			} else {

				if (empty($balance_amount)) {
					$txt = 'Paid';
				} else {
					$txt = 'Partially Paid';
				}
			}
			$data[] = array(
				"s_no" => $i++,
				"entry_date" => date('d-m-Y', strtotime($row['entry_date'])),
				"date" => date('d-m-Y', strtotime($row['booking_date'])),
				"pname" => $row['pname'],
				"name" => $row['name'],
				"amount" => $row['amount'],
				// "paid" => $row['paid_amount'],
				// "bal" => $balance_amount,
				"status" => $txt
			);
		}
		return $data;
	}

	public function excel_format_get_ubayamreport($fdata, $tdata, $payfor, $fltername)
	{
		$fdt = date('Y-m-d', strtotime($fdata));
		$tdt = date('Y-m-d', strtotime($tdata));
		$payforg = $payfor;
		$flternameg = $fltername;
		$data = [];
		$dat = $this->db->table('ubayam', 'ubayam_setting.name as pname')
			->join('ubayam_setting', 'ubayam_setting.id = ubayam.pay_for')
			->select('ubayam_setting.name as pname')
			->select('ubayam.*')
			->where('DATE_FORMAT(ubayam.ubayam_date, "%Y-%m-%d") >=', $fdt);
		$dat = $dat->where('DATE_FORMAT(ubayam.ubayam_date, "%Y-%m-%d") <=', $tdt);
		if ($payfor) {
			$dat = $dat->where('ubayam_setting.id', $payfor);
		}
		if ($fltername) {
			$dat = $dat->where('ubayam.name', $fltername);
		}
		$dat = $dat->orderBy('ubayam_date', 'asc');
		$dat = $dat->get()->getResultArray();
		$i = 1;
		foreach ($dat as $row) {
			$balance_amount = (float) $row['amount'] - (float) $row['paidamount'];
			if ($balance_amount < 0)
				$balance_amount = 0;
			if (empty($balance_amount)) {
				$txt = 'Paid';
			} else {
				$txt = 'Not Paid';
			}
			$data[] = array(
				"s_no" => $i++,
				"date" => date('d-m-Y', strtotime($row['ubayam_date'])),
				"pname" => $row['pname'],
				"name" => $row['name'],
				"amount" => $row['amount'],
				"paid" => $row['paidamount'],
				"bal" => $balance_amount,
				"status" => $txt
			);
		}
		return $data;
	}

	public function print_cashreport()
	{
		if (!$this->model->list_validate('cash_report')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['fdate'] = $_REQUEST['fdt'];
		$data['tdate'] = $_REQUEST['tdt'];
		$data['payfor'] = $_REQUEST['payfor'];
		$data['fltername'] = $_REQUEST['fltername'];

		if (isset($_REQUEST['pdf_cashdonationreport']) == "PDF") {
			$file_name = "Cash_Donation_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$dompdf = new \Dompdf\Dompdf();
			$options = $dompdf->getOptions();
			$options->set(array('isRemoteEnabled' => true));
			$dompdf->setOptions($options);
			$dompdf->loadHtml(view('report/pdf/cashdonation_print', ["pdfdata" => $data]));
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$dompdf->stream($file_name);
		} elseif (isset($_REQUEST['excel_cashdonationreport']) == "EXCEL") {
			$fileName = "Cash_Donation_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$spreadsheet = new Spreadsheet();

			$sheet = $spreadsheet->getActiveSheet();
			$sheet->getStyle('A1')->getFont()->setBold(true)->setName('Arial')->SetSize(10);
			$style = array(
				'alignment' => array(
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				)
			);

			$sheet->getStyle("A1:E1")->applyFromArray($style);
			$sheet->mergeCells('A1:E1');
			$sheet->setCellValue('A1', $_SESSION['site_title']);

			if ($_REQUEST['payfor']) {
				$res_don_set = $this->db->table('donation_setting ds')->join('donation d', 'ds.id = d.pay_for', 'left')->select('max(ds.amount) as total_amount')->select('COALESCE(sum(d.amount), 0) as collected_amount')->where(['ds.id' => $_REQUEST['payfor']])->get()->getRowArray();
				$balance_amount = $res_don_set['total_amount'] - $res_don_set['collected_amount'];
				if ($balance_amount >= 0) {
					$re_balance_amount = $balance_amount;
				} else {
					$re_balance_amount = 0;
				}
				$sheet->setCellValue('A2', '');
				$sheet->setCellValue('B2', 'Target Amount : ' . $res_don_set['total_amount']);
				$sheet->setCellValue('C2', 'Collected Amount : ' . $res_don_set['collected_amount']);
				$sheet->setCellValue('D2', 'Balance Amount : ' . $re_balance_amount);
				$sheet->setCellValue('E2', '');
			}
			$sheet->setCellValue('A3', 'S.No');
			$sheet->setCellValue('B3', 'Date');
			$sheet->setCellValue('C3', 'Pay for');
			$sheet->setCellValue('D3', 'Name');
			$sheet->setCellValue('E3', 'Amount');
			$rows = 4;
			$si = 1;
			$totalAmount = 0;
			$excel_format_data = $this->excel_format_get_cashdonationreport($data['fdate'], $data['tdate'], $data['payfor'], $data['fltername']);
			//var_dump($excel_format_data);
			//exit;
			$sheet->getStyle('E4:E' . (count($excel_format_data) + 4))
				->getNumberFormat()
				->setFormatCode('#,##0.00');

			foreach ($excel_format_data as $val) {
				$sheet->setCellValue('A' . $rows, $val['s_no']);
				$sheet->setCellValue('B' . $rows, $val['date']);
				$sheet->setCellValue('C' . $rows, $val['pname']);
				$sheet->setCellValue('D' . $rows, $val['name']);
				$sheet->setCellValue('E' . $rows, $val['amount']);
				$totalAmount += $val['amount'];
				$rows++;
				$si++;
			}
			$sheet->setCellValue('D' . $rows, 'Total');
			$sheet->setCellValue('E' . $rows, $totalAmount);

			$sheet->getStyle('E' . $rows)
				->getNumberFormat()
				->setFormatCode('#,##0.00');
			$writer = new Xlsx($spreadsheet);
			$writer->save('uploads/excel/' . $fileName . '.xlsx');
			return $this->response->download('uploads/excel/' . $fileName . '.xlsx', null)->setFileName($fileName . '.xlsx');
		} else {
			echo view('report/cashdonation_print', $data);
		}
	}

	public function print_payslipreport()
	{
		if (!$this->model->list_validate('payslip_report')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['fdate'] = $_REQUEST['fdt'];
		$data['tdate'] = $_REQUEST['tdt'];
		$data['data'] = $this->db->table('pay_slip', 'staff.name as sname')
			->join('staff', 'staff.id = pay_slip.staff_id')
			->select('staff.name as sname')
			->select('pay_slip.*')
			->where('pay_slip.date>=', $data['fdate'])
			->where('pay_slip.date<=', $data['tdate'])
			->orderBy('pay_slip.date', 'desc')
			->get()->getResultArray();
		if ($_REQUEST['pdf_payslipreport'] == "PDF") {
			$file_name = "Payslip_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$dompdf = new \Dompdf\Dompdf();
			$options = $dompdf->getOptions();
			$options->set(array('isRemoteEnabled' => true));
			$dompdf->setOptions($options);
			$dompdf->loadHtml(view('report/pdf/payslip_print', ["pdfdata" => $data]));
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$dompdf->stream($file_name);
		} elseif ($_REQUEST['excel_payslipreport'] == "EXCEL") {
			$fileName = "Payslip_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$spreadsheet = new Spreadsheet();

			$sheet = $spreadsheet->getActiveSheet();
			$sheet->getStyle('A1')->getFont()->setBold(true)->setName('Arial')->SetSize(10);
			$style = array(
				'alignment' => array(
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				)
			);

			$sheet->getStyle("A1:E1")->applyFromArray($style);
			$sheet->mergeCells('A1:E1');
			$sheet->setCellValue('A1', $_SESSION['site_title']);
			$sheet->setCellValue('A2', 'S.No');
			$sheet->setCellValue('B2', 'Date');
			$sheet->setCellValue('C2', 'Pay for');
			$sheet->setCellValue('D2', 'Ref No');
			$sheet->setCellValue('E2', 'Amount');
			$rows = 3;
			$si = 1;
			$excel_format_data = $this->excel_format_get_payslipreport($data['fdate'], $data['tdate']);
			//var_dump($excel_format_data);
			//exit;
			foreach ($excel_format_data as $val) {
				$sheet->setCellValue('A' . $rows, $val['s_no']);
				$sheet->setCellValue('B' . $rows, $val['date']);
				$sheet->setCellValue('C' . $rows, $val['sname']);
				$sheet->setCellValue('D' . $rows, $val['ref_no']);
				$sheet->setCellValue('E' . $rows, $val['amount']);
				$rows++;
				$si++;
			}
			$writer = new Xlsx($spreadsheet);
			$writer->save('uploads/excel/' . $fileName . '.xlsx');
			return $this->response->download('uploads/excel/' . $fileName . '.xlsx', null)->setFileName($fileName . '.xlsx');
		} else {
			echo view('report/payslip_print', $data);
		}
	}

	public function excel_format_get_cashdonationreport($fdata, $tdata, $payfor, $name)
	{
		$fdt = date('Y-m-d', strtotime($fdata));
		$tdt = date('Y-m-d', strtotime($tdata));
		$payforg = $payfor;
		$nameg = $name;
		$data = [];
		$dat = $this->db->table('donation', 'donation_setting.name as pname')
			->join('donation_setting', 'donation_setting.id = donation.pay_for')
			->select('donation_setting.name as pname')
			->select('donation.*')
			->where('donation.date>=', $fdt);
		$dat = $dat->where('donation.date<=', $tdt);
		if ($payforg) {
			$dat = $dat->where('donation_setting.id', $payforg);
		}
		if ($nameg) {
			$dat = $dat->where('donation.name', $nameg);
		}
		$dat = $dat->get()->getResultArray();
		$i = 1;
		foreach ($dat as $row) {
			$data[] = array(
				"s_no" => $i++,
				"date" => date('d-m-Y', strtotime($row['date'])),
				"pname" => $row['pname'],
				"name" => $row['name'],
				"amount" => $row['amount']
			);
		}
		return $data;
	}

	public function excel_format_get_payslipreport($fdata, $tdata)
	{
		$fdt = date('Y-m-d', strtotime($fdata));
		$tdt = date('Y-m-d', strtotime($tdata));
		$data = [];
		$dat = $this->db->table('pay_slip', 'staff.name as sname')
			->join('staff', 'staff.id = pay_slip.staff_id')
			->select('staff.name as sname')
			->select('pay_slip.*')
			->where('pay_slip.date>=', $fdt)
			->where('pay_slip.date<=', $tdt)
			->orderBy('pay_slip.date', 'desc')
			->get()->getResultArray();
		$i = 1;
		foreach ($dat as $row) {
			$data[] = array(
				"s_no" => $i++,
				"date" => date('d-m-Y', strtotime($row['date'])),
				"sname" => $row['sname'],
				"ref_no" => $row['ref_no'],
				"amount" => $row['net_pay']
			);
		}
		return $data;
	}

	public function ledger_rep_view()
	{
		$data['group_data'] = $this->db->table('groups')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('report/ledger', $data);
		echo view('template/footer');
	}
	public function ledger_rep_ref()
	{
		$group_name = $_POST['group_name'];
		$data = [];
		$dat = $this->db->table('ledgers')
			->join('groups', 'groups.id = ledgers.group_id')
			->select('ledgers.name as ledger_name,ledgers.code as ledger_code,groups.name as group_name');
		if ($group_name) {
			$dat = $dat->where('groups.id', $group_name);
		}
		$dat = $dat->get()->getResultArray();

		$i = 1;
		foreach ($dat as $row) {
			$data[] = array(
				$i++,
				$row['ledger_name'],
				$row['ledger_code'],
				$row['group_name'],
			);
		}
		$result = array(
			"draw" => 0,
			"recordsTotal" => $i - 1,
			"recordsFiltered" => $i - 1,
			"data" => $data,
		);
		echo json_encode($result);
		exit();
	}
	public function print_ledgerreport()
	{
		$group_name = $_POST['group_name'];
		$data['group_name'] = $_POST['group_name'];
		$dat = $this->db->table('ledgers')
			->join('groups', 'groups.id = ledgers.group_id')
			->select('ledgers.name as ledger_name,ledgers.code as ledger_code,groups.name as group_name');
		if ($group_name) {
			$dat = $dat->where('groups.id', $group_name);
		}
		$dat = $dat->get()->getResultArray();
		$data['data'] = $dat;

		//var_dump($data['data']);
		//exit;

		if ($_POST['pdf_ledgerreport'] == "PDF") {
			$file_name = "Ledger_Report";
			$dompdf = new \Dompdf\Dompdf();
			$options = $dompdf->getOptions();
			$options->set(array('isRemoteEnabled' => true));
			$dompdf->setOptions($options);
			$dompdf->loadHtml(view('report/pdf/ledger_print', ["pdfdata" => $data]));
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$dompdf->stream($file_name);
		} elseif ($_POST['excel_ledgerreport'] == "EXCEL") {
			$fileName = "Ledger_Report";
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();
			$sheet->getStyle('A1')->getFont()->setBold(true)->setName('Arial')->SetSize(10);
			$style = array(
				'alignment' => array(
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				)
			);

			$sheet->getStyle("A1:D1")->applyFromArray($style);
			$sheet->mergeCells('A1:D1');
			$sheet->setCellValue('A1', $_SESSION['site_title']);
			$sheet->setCellValue('A2', 'S.No');
			$sheet->setCellValue('B2', 'Ledger Name');
			$sheet->setCellValue('C2', 'Ledger Code');
			$sheet->setCellValue('D2', 'Group Name');
			$rows = 3;
			$si = 1;
			//var_dump($excel_format_data);
			//exit;
			foreach ($data['data'] as $val) {
				$sheet->setCellValue('A' . $rows, $si);
				$sheet->setCellValue('B' . $rows, $val['ledger_name']);
				$sheet->setCellValue('C' . $rows, $val['ledger_code']);
				$sheet->setCellValue('D' . $rows, $val['group_name']);
				$rows++;
				$si++;
			}
			$writer = new Xlsx($spreadsheet);
			$writer->save('uploads/excel/' . $fileName . '.xlsx');
			return $this->response->download('uploads/excel/' . $fileName . '.xlsx', null)->setFileName($fileName . '.xlsx');
		} else {
			//var_dump($data);
			//exit;
			echo view('report/ledger_print', $data);
		}
	}
	public function groups_rep_view()
	{
		echo view('template/header');
		echo view('template/sidebar');
		echo view('report/account_group');
		echo view('template/footer');
	}
	public function accountgroup_rep_ref()
	{
		$group_data = $this->db->table('groups')->where('parent_id !=', "")->get()->getResultArray();
		$datarec = array();
		foreach ($group_data as $value) {
			$datarec[] = $value['id'];
		}
		$group_result_data = $this->db->table('groups')->whereIn('parent_id', $datarec)->get()->getResultArray();
		$i = 1;
		$data = [];
		foreach ($group_result_data as $row) {
			$groups = $this->db->table('groups')->select('name')->where('id', $row['parent_id'])->get()->getRowArray();
			$data[] = array(
				$i++,
				$row['code'],
				$row['name'],
				$groups['name'],
			);
		}
		$result = array(
			"draw" => 0,
			"recordsTotal" => $i - 1,
			"recordsFiltered" => $i - 1,
			"data" => $data,
		);
		echo json_encode($result);
		exit();
	}
	public function print_accountgroupreport()
	{
		$group_data = $this->db->table('groups')->where('parent_id !=', "")->get()->getResultArray();
		$datarec = array();
		foreach ($group_data as $value) {
			$datarec[] = $value['id'];
		}
		$group_result_data = $this->db->table('groups')->whereIn('parent_id', $datarec)->get()->getResultArray();
		$data['data'] = $group_result_data;

		//var_dump($data['data']);
		//exit;

		if ($_POST['pdf_accountgroupreport'] == "PDF") {
			$file_name = "Account_Group_Report";
			$dompdf = new \Dompdf\Dompdf();
			$options = $dompdf->getOptions();
			$options->set(array('isRemoteEnabled' => true));
			$dompdf->setOptions($options);
			$dompdf->loadHtml(view('report/pdf/account_group_print', ["pdfdata" => $data]));
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$dompdf->stream($file_name);
		} elseif ($_POST['excel_accountgroupreport'] == "EXCEL") {
			$fileName = "Account_Group_Report";
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();
			$sheet->getStyle('A1')->getFont()->setBold(true)->setName('Arial')->SetSize(10);
			$style = array(
				'alignment' => array(
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				)
			);

			$sheet->getStyle("A1:D1")->applyFromArray($style);
			$sheet->mergeCells('A1:D1');
			$sheet->setCellValue('A1', $_SESSION['site_title']);
			$sheet->setCellValue('A2', 'S.No');
			$sheet->setCellValue('B2', 'Order Code');
			$sheet->setCellValue('C2', 'Group Name');
			$sheet->setCellValue('D2', 'Category');
			$rows = 3;
			$si = 1;
			//var_dump($excel_format_data);
			//exit;
			foreach ($data['data'] as $val) {
				$groups = $this->db->table('groups')->select('name')->where('id', $val['parent_id'])->get()->getRowArray();
				$sheet->setCellValue('A' . $rows, $si);
				$sheet->setCellValue('B' . $rows, $val['code']);
				$sheet->setCellValue('C' . $rows, $val['name']);
				$sheet->setCellValue('D' . $rows, $groups['name']);
				$rows++;
				$si++;
			}
			$writer = new Xlsx($spreadsheet);
			$writer->save('uploads/excel/' . $fileName . '.xlsx');
			return $this->response->download('uploads/excel/' . $fileName . '.xlsx', null)->setFileName($fileName . '.xlsx');
		} else {
			//var_dump($data);
			//exit;
			echo view('report/account_group_print', $data);
		}
	}

	public function member_report()
	{
		echo view('template/header');
		echo view('template/sidebar');
		echo view('member/member_report');
		echo view('template/footer');
	}

	public function member_report_ajax()
	{
		$fdata = $_REQUEST['fdt'];
		$tdata = $_REQUEST['tdt'];
		$type = $_REQUEST['type'];
		$status = $_REQUEST['status'];

		$qry = $this->db->table('member', 'member_type.name as tname')
			->join('member_type', 'member_type.id = member.member_type')
			->select('member_type.name as tname')
			->select('member.*')
			->where('DATE_FORMAT(member.created,"%Y-%m-%d") >=', $fdata)
			->where('DATE_FORMAT(member.created,"%Y-%m-%d") <=', $tdata);
		if ($type)
			$qry = $qry->where("member.member_type", $type);
		if ($status)
			$qry = $qry->where('member.status', $status);

		$res = $qry->get()->getResultArray();

		$data = array();
		$i = 1;
		if ($res) {
			foreach ($res as $row) {
				$data[] = array(
					$i++,
					$row['name'],
					$row['member_no'],
					(($row['member_type'] == 1) ? "ORDINARY MEMBER" : (($row['member_type'] == 3) ? "LIFETIME MEMBER" : "")),
					$row['ic_no'],
					($row['status'] == 1) ? "Active" : "Deactive",
				);

			}
		}

		$result = array(
			"draw" => 0,
			"recordsTotal" => $i - 1,
			"recordsFiltered" => $i - 1,
			"data" => $data,
		);
		echo json_encode($result);
		exit();

	}

	public function member_report_print()
	{
		$fdata = $_REQUEST['fdt'];
		$tdata = $_REQUEST['tdt'];
		$type = $_REQUEST['type'];
		$status = $_REQUEST['status'];
		$data = array();
		$data['fdate'] = $fdata;
		$data['tdate'] = $tdata;

		$qry = $this->db->table('member', 'member_type.name as tname')
			->join('member_type', 'member_type.id = member.member_type')
			->select('member_type.name as tname')
			->select('member.*')
			->where('DATE_FORMAT(member.created,"%Y-%m-%d") >=', $fdata)
			->where('DATE_FORMAT(member.created,"%Y-%m-%d") <=', $tdata);
		if ($type)
			$qry = $qry->where("member.member_type", $type);
		if ($status)
			$qry = $qry->where('member.status', $status);

		$res = $qry->get()->getResultArray();

		$data['data'] = $res;
		if ($_REQUEST['pdf_member'] == "PDF") {
			$file_name = "Member_Report";
			$dompdf = new \Dompdf\Dompdf();
			$options = $dompdf->getOptions();
			$options->set(array('isRemoteEnabled' => true));
			$dompdf->setOptions($options);
			$dompdf->loadHtml(view('report/pdf/member_report', ["pdfdata" => $data]));
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$dompdf->stream($file_name);
		} elseif ($_REQUEST['excel_member'] == "EXCEL") {
			$fileName = "Member_Report";
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();
			$sheet->getStyle('A1')->getFont()->setBold(true)->setName('Arial')->SetSize(10);
			$style = array(
				'alignment' => array(
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				)
			);

			$sheet->getStyle("A1:F1")->applyFromArray($style);
			$sheet->mergeCells('A1:F1');
			$sheet->setCellValue('A1', $_SESSION['site_title']);
			$sheet->setCellValue('A2', 'S.No');
			$sheet->setCellValue('B2', 'Member Name');
			$sheet->setCellValue('C2', 'Membsership No');
			$sheet->setCellValue('D2', 'Member Type');
			$sheet->setCellValue('E2', 'I/C No');
			$sheet->setCellValue('F2', 'Status');
			$rows = 3;
			$si = 1;
			foreach ($data['data'] as $val) {
				$sheet->setCellValue('A' . $rows, $si);
				$sheet->setCellValue('B' . $rows, $val['name']);
				$sheet->setCellValue('C' . $rows, $val['member_no']);
				$sheet->setCellValue('D' . $rows, ($val['member_type'] == 1) ? "ORDINARY MEMBER" : "LIFETIME MEMBER");
				$sheet->setCellValue('E' . $rows, $val['ic_no']);
				$sheet->setCellValue('F' . $rows, ($val['status'] == 1) ? "Active" : "Deactive");
				$rows++;
				$si++;
			}
			$writer = new Xlsx($spreadsheet);
			$writer->save('uploads/excel/' . $fileName . '.xlsx');
			return $this->response->download('uploads/excel/' . $fileName . '.xlsx', null)->setFileName($fileName . '.xlsx');
		} else {
			//var_dump($data);
			//exit;
			echo view('report/member_report', $data);
		}

	}

	public function prasadam_rep_view()
	{

		if (!$this->model->list_validate('prasadam_report')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['fltr_name'] = $this->db->table('prasadam')->select('customer_name')->groupBy('customer_name')->get()->getResultArray();
		$data['prasadam_groups'] = $this->db->table('prasadam_group')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('report/prasadam', $data);
		echo view('template/footer');
	}
	public function prasadam_rep_ref()
	{
		$fdt = date('Y-m-d', strtotime($_POST['fdt']));
		$tdt = date('Y-m-d', strtotime($_POST['tdt']));
		$cdt = isset($_POST['cdt']) && !empty($_POST['cdt']) ? date('Y-m-d', strtotime($_POST['cdt'])) : null;
		$data = [];
		$dat = $this->db->table('prasadam p')
			->select('p.`id`, `p`.`date`, p.`customer_name`, pg.group_name, p.`amount`')
			->join('prasadam_group pg', 'pg.id = p.prasadam_group_id', 'left')
			->where('DATE_FORMAT(p.date, "%Y-%m-%d") >=', $fdt);
		$dat = $dat->where('DATE_FORMAT(p.date, "%Y-%m-%d") <=', $tdt);
		if ($cdt) {
			$dat = $dat->where('DATE_FORMAT(p.collection_date, "%Y-%m-%d") =', $cdt);
		}
		if ($_POST['group_filter']) {
			$group_filter = trim($_POST['group_filter']);
			$dat = $dat->where('p.prasadam_group_id', $group_filter);
		}
		$dat = $dat->orderBy('p.date', 'desc');
		$dat = $dat->orderBy('p.id', 'desc');
		$dat = $dat->get()->getResultArray();
		$i = 1;
		foreach ($dat as $row) {
			$payfors = $this->db->table('prasadam_booking_details')
				->join('prasadam_setting', 'prasadam_setting.id = prasadam_booking_details.prasadam_id')
				->select('prasadam_setting.name_eng,prasadam_setting.name_tamil, prasadam_booking_details.quantity')
				->where('prasadam_booking_details.prasadam_booking_id', $row['id'])
				->get()->getResultArray();
			$html = "";
			foreach ($payfors as $payfor) {
				$html .= "&#x2022; " . $payfor['name_eng'] . " / " . $payfor['name_tamil'] . ' - ' . $payfor['quantity'] . "<br>";
			}
			$data[] = array(
				$i++,
				date('d-m-Y', strtotime($row['date'])),
				$row['customer_name'],
				$row['group_name'],
				"<p style='text-align: left;'>" . $html . "</p>",
				number_format($row['amount'], '2', '.', ',')
			);
		}

		$result = array(
			"draw" => 0,
			"recordsTotal" => $i - 1,
			"recordsFiltered" => $i - 1,
			"data" => $data,
		);
		echo json_encode($result);
		exit();
	}
	public function print_prasadamreport()
	{
		if (!$this->model->list_validate('prasadam_report')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['fdate'] = $_REQUEST['fdt'];
		$data['tdate'] = $_REQUEST['tdt'];
		$data['fltername'] = $_REQUEST['group_filter'];
		$data['collection_date'] = isset($_REQUEST['cdt']) && !empty($_REQUEST['cdt']) ? date('Y-m-d', strtotime($_REQUEST['cdt'])) : null;
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
		if ($_REQUEST['pdf_prasadamreport'] == "PDF") {
			$file_name = "Prasadam_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$dompdf = new \Dompdf\Dompdf();
			$options = $dompdf->getOptions();
			$options->set(array('isRemoteEnabled' => true));
			$dompdf->setOptions($options);
			$dompdf->loadHtml(view('report/pdf/prasadam_print', ["pdfdata" => $data]));
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$dompdf->stream($file_name);
		} elseif ($_REQUEST['excel_prasadamreport'] == "EXCEL") {
			$fileName = "Prasadam_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$spreadsheet = new Spreadsheet();

			$sheet = $spreadsheet->getActiveSheet();
			$sheet->getStyle('A1')->getFont()->setBold(true)->setName('Arial')->SetSize(10);
			$style = array(
				'alignment' => array(
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				)
			);

			$sheet->getStyle("A1:F1")->applyFromArray($style);
			$sheet->mergeCells('A1:F1');
			$sheet->setCellValue('A1', $_SESSION['site_title']);
			$sheet->setCellValue('A2', 'S.No');
			$sheet->setCellValue('B2', 'Date');
			$sheet->setCellValue('C2', 'Customer Name');
			$sheet->setCellValue('D2', 'Collection Date');
			$sheet->setCellValue('E2', 'Payfor');
			$sheet->setCellValue('F2', 'Amount');
			$rows = 3;
			$si = 1;
			$excel_format_data = $this->excel_format_get_prasadamreport($data['fdate'], $data['tdate'], $data['collection_date'], $data['fltername']);
			//var_dump($excel_format_data);
			//exit;
			foreach ($excel_format_data as $val) {
				$sheet->setCellValue('A' . $rows, $val['s_no']);
				$sheet->setCellValue('B' . $rows, $val['date']);
				$sheet->setCellValue('C' . $rows, $val['customer_name']);
				$sheet->setCellValue('D' . $rows, $val['collection_date']);
				$sheet->setCellValue('E' . $rows, $val['collection_name']);
				$sheet->setCellValue('F' . $rows, $val['amount']);
				$rows++;
				$si++;
			}
			$writer = new Xlsx($spreadsheet);
			$writer->save('uploads/excel/' . $fileName . '.xlsx');
			return $this->response->download('uploads/excel/' . $fileName . '.xlsx', null)->setFileName($fileName . '.xlsx');
		} else {
			echo view('report/prasadam_print', $data);
		}
	}
	public function excel_format_get_prasadamreport($fdata, $tdata, $collectiondate, $fltername)
	{
		$fdt = date('Y-m-d', strtotime($fdata));
		$tdt = date('Y-m-d', strtotime($tdata));
		$collection_date = !empty($collection_date) ? date('Y-m-d', strtotime($collection_date)) : null;
		$flternameg = $fltername;
		$data = [];
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
		$dat = $this->db->table('prasadam')
			->select('prasadam.id,prasadam.date,prasadam.customer_name,prasadam.collection_date,prasadam.amount')
			->where('DATE_FORMAT(prasadam.date, "%Y-%m-%d") >=', $fdt);
		$dat = $dat->where('DATE_FORMAT(prasadam.date, "%Y-%m-%d") <=', $tdt);
		if (!empty($collection_date)) {
			$dat = $dat->where('DATE_FORMAT(prasadam.collection_date, "%Y-%m-%d")=', $collection_date);
		}
		if ($fltername) {
			$dat = $dat->where('prasadam.customer_name', $fltername);
		}
		$dat = $dat->orderBy('prasadam.date', 'asc');
		$dat = $dat->get()->getResultArray();
		$i = 1;
		foreach ($dat as $row) {
			$payfors = $this->db->table('prasadam_booking_details')
				->join('prasadam_setting', 'prasadam_setting.id = prasadam_booking_details.prasadam_id')
				->select('prasadam_setting.name_eng,prasadam_setting.name_tamil, prasadam_booking_details.quantity')
				->where('prasadam_booking_details.prasadam_booking_id', $row['id'])
				->get()->getResultArray();
			$html = "";
			foreach ($payfors as $payfor) {
				$html .= $payfor['name_eng'] . " / " . $payfor['name_tamil'] . ' - ' . $payfor['quantity'] . '&';
			}
			$data[] = array(
				"s_no" => $i++,
				"date" => date('d-m-Y', strtotime($row['date'])),
				"customer_name" => $row['customer_name'],
				"amount" => $row['amount'],
				"collection_date" => date('d-m-Y', strtotime($row['collection_date'])),
				"collection_name" => $html
			);
		}
		return $data;
	}
	public function prasadam_collection_report()
	{

		if (!$this->model->list_validate('prasadam_collection_report')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$collection_date = date("Y-m-d");
		$data['fltr_name'] = $this->db->table('prasadam_master')->where('date', $collection_date)->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('report/prasadam_collection', $data);
		echo view('template/footer');
	}
	public function prasadam_collection_rep_ref()
	{
		$collection_date = date('Y-m-d', strtotime($_POST['collection_date']));
		$fltername = $_POST['fltername'];
		$data = [];
		$dat = $this->db->table('prasadam')
			->select('prasadam.*')
			->where('DATE_FORMAT(prasadam.collection_date, "%Y-%m-%d")', $collection_date);
		if ($fltername) {
			$dat = $dat->where('prasadam.prasadam_master_id', $fltername);
		}
		$dat = $dat->orderBy('collection_date', 'asc');
		$dat = $dat->get()->getResultArray();

		$i = 1;
		// echo $this->db->getLastQuery();
		foreach ($dat as $row) {
			$collect_name = $this->db->table('prasadam_master')->where('id', $row['prasadam_master_id'])->get()->getRowArray();
			$data[] = array(
				$i++,
				$row['customer_name'],
				$collect_name['name'],
				date('d-m-Y', strtotime($row['collection_date']))
			);
		}

		$result = array(
			"draw" => 0,
			"recordsTotal" => $i - 1,
			"recordsFiltered" => $i - 1,
			"data" => $data,
		);
		echo json_encode($result);
		exit();
	}
	public function print_collection_prasadamreport()
	{
		if (!$this->model->list_validate('prasadam_report')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['collection_date'] = $_REQUEST['collection_date'];
		$data['fltername'] = $_REQUEST['fltername'];
		if ($_REQUEST['pdf_prasadamreport'] == "PDF") {
			$file_name = "Prasadam_Collection_Report_" . $data['collection_date'];
			$dompdf = new \Dompdf\Dompdf();
			$options = $dompdf->getOptions();
			$options->set(array('isRemoteEnabled' => true));
			$dompdf->setOptions($options);
			$dompdf->loadHtml(view('report/pdf/prasadam_collection_print', ["pdfdata" => $data]));
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$dompdf->stream($file_name);
		} elseif ($_REQUEST['excel_prasadamreport'] == "EXCEL") {
			$fileName = "Prasadam_Collection_Report_" . $data['collection_date'];
			$spreadsheet = new Spreadsheet();

			$sheet = $spreadsheet->getActiveSheet();
			$sheet->getStyle('A1')->getFont()->setBold(true)->setName('Arial')->SetSize(10);
			$style = array(
				'alignment' => array(
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				)
			);

			$sheet->getStyle("A1:D1")->applyFromArray($style);
			$sheet->mergeCells('A1:D1');
			$sheet->setCellValue('A1', $_SESSION['site_title']);
			$sheet->setCellValue('A2', 'S.No');
			$sheet->setCellValue('B2', 'Customer Name');
			$sheet->setCellValue('C2', 'Name');
			$sheet->setCellValue('D2', 'Collection Date');
			$rows = 3;
			$si = 1;
			$excel_format_data = $this->excel_format_get_collection_prasadamreport($data['collection_date'], $data['fltername']);
			//var_dump($excel_format_data);
			//exit;
			foreach ($excel_format_data as $val) {
				$sheet->setCellValue('A' . $rows, $val['s_no']);
				$sheet->setCellValue('B' . $rows, $val['customer_name']);
				$sheet->setCellValue('E' . $rows, $val['name']);
				$sheet->setCellValue('G' . $rows, $val['collection_date']);
				$rows++;
				$si++;
			}
			$writer = new Xlsx($spreadsheet);
			$writer->save('uploads/excel/' . $fileName . '.xlsx');
			return $this->response->download('uploads/excel/' . $fileName . '.xlsx', null)->setFileName($fileName . '.xlsx');
		} else {
			echo view('report/prasadam_collection_print', $data);
		}
	}
	public function excel_format_get_collection_prasadamreport($fdata, $fltername)
	{
		$fdt = date('Y-m-d', strtotime($fdata));
		$flternameg = $fltername;
		$data = [];
		$dat = $this->db->table('prasadam')
			->select('prasadam.*')
			->where('DATE_FORMAT(prasadam.collection_date, "%Y-%m-%d")', $fdt);
		if ($fltername) {
			$dat = $dat->where('prasadam.prasadam_master_id', $fltername);
		}
		$dat = $dat->orderBy('collection_date', 'asc');
		$dat = $dat->get()->getResultArray();
		$i = 1;
		foreach ($dat as $row) {
			$collect_name = $this->db->table('prasadam_master')->where('id', $row['prasadam_master_id'])->get()->getRowArray();
			$data[] = array(
				"s_no" => $i++,
				"name" => $collect_name['name'],
				"customer_name" => $row['customer_name'],
				"collection_date" => date('d-m-Y', strtotime($row['collection_date'])),
			);
		}
		return $data;
	}
	public function visitors_reg_report()
	{

		$data['list'] = $this->db->table('registration_form')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('report/visitors_reg_report', $data);
		echo view('template/footer');
	}
	public function visitors_print()
	{
		$tmpid = $this->session->get('profile_id');
		if (empty($tmpid)) {
			$tmpid = 1; // Default to 1 if no profile_id in session
		}

		$data['temp_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
		$data['list'] = $this->db->table('registration_form')->get()->getResultArray();

		echo view('report/visitors_print', $data);
	}
	public function courtesy_report()
	{
		echo view('template/header');
		echo view('template/sidebar');
		echo view('report/courtesy_report');
		echo view('template/footer');
	}
	public function courtesy_report_ajax()
	{
		$tmpid = $this->session->get('profile_id');
		$temple_detail = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
		$temple_name = !empty($temple_detail['name']) ? $temple_detail['name'] : "";
		$donation_courtesy_grace_amount = floatVal($temple_detail['donation_courtesy_grace_amount']);
		$ubayam_courtesy_grace_amount = floatVal($temple_detail['ubayam_courtesy_grace_amount']);

		$fdata = $_REQUEST['fdt'];
		$tdata = $_REQUEST['tdt'];
		$type = $_REQUEST['type'];
		$mobile_no = $_REQUEST['mobile_no'];

		// Query donation table - select only existing columns
		$donation_query = $this->db->table('donation')
			->select('donation.name, donation.date, donation.amount')
			->where('donation.amount >=', $donation_courtesy_grace_amount)
			->where('DATE_FORMAT(donation.date,"%Y-%m-%d") >=', $fdata)
			->where('DATE_FORMAT(donation.date,"%Y-%m-%d") <=', $tdata);

		// Only filter by mobile if the column exists
		// If you need mobile filtering, you'll need to check your actual column name
		// Possible column names: phone, contact, mobile_no, contact_number
		if (!empty($mobile_no)) {
			// Check if mobile column exists - try common column names
			$fields = $this->db->getFieldNames('donation');
			if (in_array('mobile', $fields)) {
				$donation_query->where('donation.mobile', $mobile_no);
			} elseif (in_array('phone', $fields)) {
				$donation_query->where('donation.phone', $mobile_no);
			} elseif (in_array('contact', $fields)) {
				$donation_query->where('donation.contact', $mobile_no);
			}
		}

		$donation_result = $donation_query->get();

		// Check if query was successful
		if ($donation_result === false) {
			log_message('error', 'Donation query failed: ' . print_r($this->db->error(), true));
			$donation_datas = array();
		} else {
			$donation_datas = $donation_result->getResultArray();
		}

		$array_donation = array();
		foreach ($donation_datas as $donation_data) {
			$array_donation[] = array(
				"type" => "Cash Donation",
				"name" => $donation_data['name'],
				"ic_no" => '', // Not available in donation table
				"mobile_no" => '', // Not available in donation table
				"email_id" => '', // Not available in donation table
				"date" => $donation_data['date'],
				"amount" => $donation_data['amount']
			);
		}

		// Query ubayam table
		$ubayam_query = $this->db->table('ubayam')
			->select('ubayam.name, ubayam.mobile, ubayam.email, ubayam.dt, ubayam.paidamount, ubayam.ic_number')
			->where('ubayam.paidamount >=', $ubayam_courtesy_grace_amount)
			->where('DATE_FORMAT(ubayam.dt,"%Y-%m-%d") >=', $fdata)
			->where('DATE_FORMAT(ubayam.dt,"%Y-%m-%d") <=', $tdata);

		if (!empty($mobile_no)) {
			$ubayam_query->where('ubayam.mobile', $mobile_no);
		}

		$ubayam_result = $ubayam_query->get();

		if ($ubayam_result === false) {
			log_message('error', 'Ubayam query failed: ' . print_r($this->db->error(), true));
			$ubayam_datas = array();
		} else {
			$ubayam_datas = $ubayam_result->getResultArray();
		}

		$array_ubayam = array();
		foreach ($ubayam_datas as $ubayam_data) {
			$array_ubayam[] = array(
				"type" => "Ubayam",
				"name" => $ubayam_data['name'],
				"ic_no" => $ubayam_data['ic_number'] ?? '',
				"mobile_no" => $ubayam_data['mobile'] ?? '',
				"email_id" => $ubayam_data['email'] ?? '',
				"date" => $ubayam_data['dt'],
				"amount" => $ubayam_data['paidamount']
			);
		}

		if ($type == "1") {
			$return_data = $array_donation;
		} else if ($type == "2") {
			$return_data = $array_ubayam;
		} else {
			$return_data = array_merge($array_donation, $array_ubayam);
		}

		$i = 1;
		$data = array();

		if ($return_data) {
			foreach ($return_data as $row) {
				$name = $row['name'];
				$email_id = $row['email_id'];
				$mobile_no = $row['mobile_no'];

				// Only create WhatsApp link if mobile number exists
				$whatsapp_action = '';
				if (!empty($mobile_no)) {
					$whatsapp_msg = "Dear $name,\n\nIn sincere gratitude, we extend our heartfelt appreciation for your generous donation to $temple_name. Your support is instrumental in upholding the spiritual sanctity and community services we provide.\n\nYour commitment to our temple's well-being truly makes a significant impact, and we are honored to have you as a valued supporter. May your kindness be a source of blessings, and may it inspire others to join in nurturing our sacred space.\n\nThank you for being an integral part of our temple community.\n\nWith respect and appreciation,\n$temple_name";

					$whatsapp_url = 'https://wa.me/' . $mobile_no . '?text=' . urlencode($whatsapp_msg);
					$whatsapp_action = '<a href="' . $whatsapp_url . '" target="_blank" class="text-success" style="color: #0fc713;float:left;margin: 0px 5px;"><i class="fa fa-whatsapp" aria-hidden="true" style="font-size: 19px;"></i></a>';
				}

				// Only create email form if email exists
				$email_action = '';
				if (!empty($email_id)) {
					$email_action = '<form action="' . base_url() . '/report/courtesy_sendmail" method="post" style="float:left;margin: 0px 5px;">
                    <input type="hidden" name="mail_name" value="' . htmlspecialchars($name) . '">
                    <input type="hidden" name="temple_name" value="' . htmlspecialchars($temple_name) . '">
                    <input type="hidden" name="email_name" value="' . htmlspecialchars($email_id) . '">
                    <button type="submit" class="text-primary" style="border: none; background: none; cursor: pointer;"><i class="fa fa-envelope" aria-hidden="true" style="font-size: 18px;"></i></button>
                </form>';
				}

				$actions = '<div class="row"><div class="col-md-12" style="margin: 0px 50px;">' . $whatsapp_action . $email_action . '</div></div>';

				$data[] = array(
					$i++,
					$row['type'],
					date("d/m/Y", strtotime($row['date'])),
					$row['name'],
					$mobile_no ?: 'N/A',
					$email_id ?: 'N/A',
					number_format($row['amount'], 2),
					$actions
				);
			}
		}

		$result = array(
			"draw" => 0,
			"recordsTotal" => $i - 1,
			"recordsFiltered" => $i - 1,
			"data" => $data,
		);
		echo json_encode($result);
		exit();
	}
	function courtesy_sendmail()
	{
		$mail_name = $_POST['mail_name'];
		$temple_name = $_POST['temple_name'];
		$email_name = $_POST['email_name'];
		$email = \Config\Services::email();
		if (!empty($email_name)) {
			$subject = "COURTESY MAIL - " . $temple_name;
			$body = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml">
				<head>
					<title>' . $subject . '</title>
					<style type="text/css">
						body {
							font-family: Arial, Verdana, Helvetica, sans-serif;
							font-size: 16px;
						}
					</style>
				</head>
				<body>
					<p>Dear ' . $mail_name . ', </p>
					<p>I am writing to express our deepest gratitude for your incredibly generous donation to ' . $temple_name . '. Your support plays a pivotal role in sustaining the spiritual and community-building activities at our temple.</p>
					<p>Your selfless contribution not only aids in the maintenance of our sacred space but also enables us to continue offering valuable services and programs to our community. Your commitment to our temples well-being is truly appreciated.</p>
					<p>May your kindness and generosity be returned to you tenfold. Thank you for being a cherished member of our temple family. Your support ensures that our sacred space remains a beacon of positivity and spiritual growth for all who seek it.</p>
					<p>With heartfelt thanks,</p>
					<p>' . $temple_name . '</p>
				</body>
				</html>';
			$to = $email_name;
			$email->setTo($to);
			$email->setFrom('templetest@grasp.com.my', $temple_name);
			// $email->setNewline("\r\n");
			$email->setSubject($subject);
			$email->setMessage($body);
			if ($email->send()) {
				$this->session->setFlashdata('succ', 'Email successfully sent');
				return redirect()->to("/report/courtesy_report");
			} else {
				$data = $email->printDebugger(['headers']);
				print_r($data);
			}
		}
	}
	public function bom()
	{
		if (!$this->model->list_validate('bom_report')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['products'] = $this->db->table('product')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('report/bom', $data);
		echo view('template/footer');
	}
	public function bom_rep_ref()
	{
		$fdt = date('Y-m-d', strtotime($_POST['fdt']));
		$pid = $_POST['product_id'];
		$data_product = array();

		$stockouts = $this->db->table('stock_outward')
			->join('stock_outward_list', 'stock_outward_list.stack_out_id = stock_outward.id')
			->select('stock_outward_list.item_id,stock_outward_list.item_name,stock_outward_list.quantity,stock_outward_list.uom_id')
			->where('stock_outward.date', $fdt)
			->where('stock_outward_list.item_type', 1);
		if (!empty($pid)) {
			$stockouts = $stockouts->where('stock_outward_list.item_id', $pid);
		}
		$stockouts = $stockouts->get()->getResultArray();
		foreach ($stockouts as $row) {
			$repid = $row['item_id'];
			$uom_data = $this->db->table('uom_list')->where('id', $row['uom_id'])->get()->getRowArray();
			$dat_products = $this->db->table('product as p')
				->join('product_raw_material_items as prm', 'prm.product_id = p.id')
				->join('raw_matrial_groups as rm', 'rm.id = prm.raw_id')
				->select('rm.name,prm.qty,p.uom_id')
				->where('p.id', $repid)
				->get()
				->getResultArray();
			$array_items = "";
			foreach ($dat_products as $dat_product) {
				$uom_item_data = $this->db->table('uom_list')->where('id', $dat_product['uom_id'])->get()->getRowArray();
				$uom_item_name = $uom_item_data['symbol'];
				$pre_qty = $row['quantity'] * $dat_product['qty'];
				$pre_item_qty = $pre_qty . " [" . $uom_item_name . "]";
				$prod_itme .= '<p style="margin:0px;padding:0px;text-align:left;">' . $dat_product['name'] . " - " . $pre_item_qty . '</p>';
			}
			$uom_name = $uom_data['symbol'];
			$prod_qty = $row['quantity'] . " [" . $uom_name . "]";
			$data_product[] = array(
				'<p style="text-align:left;">' . $row['item_name'] . '</p>',
				'<p style="text-align:center;">' . $prod_qty . '</p>',
				$prod_itme
			);
		}
		//var_dump($data_product);
		$data = $data_product;
		$result = array(
			"draw" => 0,
			"recordsTotal" => $i - 1,
			"recordsFiltered" => $i - 1,
			"data" => $data,
		);
		echo json_encode($result);
		exit();
	}
	public function print_bomreport()
	{
		if (!$this->model->list_validate('bom_report')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$fdt = date('Y-m-d', strtotime($_REQUEST['fdt']));
		$pid = $_REQUEST['product_id'];
		$data_product = array();
		$result_data = array();
		$stockouts = $this->db->table('stock_outward')
			->join('stock_outward_list', 'stock_outward_list.stack_out_id = stock_outward.id')
			->select('stock_outward_list.item_id,stock_outward_list.item_name,stock_outward_list.quantity,stock_outward_list.uom_id')
			->where('stock_outward.date', $fdt)
			->where('stock_outward_list.item_type', 1);
		if (!empty($pid)) {
			$stockouts = $stockouts->where('stock_outward_list.item_id', $pid);
		}
		$stockouts = $stockouts->get()->getResultArray();
		foreach ($stockouts as $row) {
			$repid = $row['item_id'];
			$uom_data = $this->db->table('uom_list')->where('id', $row['uom_id'])->get()->getRowArray();
			$dat_products = $this->db->table('product as p')
				->join('product_raw_material_items as prm', 'prm.product_id = p.id')
				->join('raw_matrial_groups as rm', 'rm.id = prm.raw_id')
				->select('rm.name,prm.qty,p.uom_id')
				->where('p.id', $repid)
				->get()
				->getResultArray();
			$array_items = "";
			$prod_itme_excel = "";
			$prod_itme = "";
			foreach ($dat_products as $dat_product) {
				$uom_item_data = $this->db->table('uom_list')->where('id', $dat_product['uom_id'])->get()->getRowArray();
				$uom_item_name = $uom_item_data['symbol'];
				$pre_qty = $row['quantity'] * $dat_product['qty'];
				$pre_item_qty = $pre_qty . " [" . $uom_item_name . "]";
				$prod_itme_excel .= $dat_product['name'] . " - " . $pre_item_qty;
				$prod_itme .= '<p style="margin:0px;padding:0px;text-align:center;">' . $dat_product['name'] . " - " . $pre_item_qty . '</p>';
			}
			$uom_name = $uom_data['symbol'];
			$prod_qty = $row['quantity'] . " [" . $uom_name . "]";
			$data_product[] = array(
				"name" => $row['item_name'],
				"qty" => $prod_qty,
				"product_items" => $prod_itme,
				"product_items_excel" => $prod_itme_excel
			);
		}
		$data = $data_product;
		$result_data['fdate'] = $_REQUEST['fdt'];
		$result_data['product_id'] = $_REQUEST['product_id'];

		$result_data['data'] = $data;

		if ($_REQUEST['pdf_bomreport'] == "PDF") {
			$file_name = "Stock_Report_" . $result_data['fdate'];
			$dompdf = new \Dompdf\Dompdf();
			$options = $dompdf->getOptions();
			$options->set(array('isRemoteEnabled' => true));
			$dompdf->setOptions($options);
			$dompdf->loadHtml(view('report/pdf/bom_print', ["pdfdata" => $result_data]));
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$dompdf->stream($file_name);
		} elseif ($_REQUEST['excel_bomreport'] == "EXCEL") {
			$fileName = "Stock_Report_" . $result_data['fdate'];
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();
			$sheet->getStyle('A1')->getFont()->setBold(true)->setName('Arial')->SetSize(10);
			$style = array(
				'alignment' => array(
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				)
			);
			$sheet->getStyle("A1:C1")->applyFromArray($style);
			$sheet->mergeCells('A1:C1');
			$sheet->setCellValue('A1', $_SESSION['site_title']);
			$sheet->setCellValue('A2', 'Item Name');
			$sheet->setCellValue('B2', 'Quantity');
			$sheet->setCellValue('C2', 'Description');
			$rows = 3;
			$si = 1;
			//var_dump($result_data['data']);
			//exit;
			foreach ($result_data['data'] as $val) {
				$sheet->setCellValue('A' . $rows, $val['name']);
				$sheet->setCellValue('B' . $rows, $val['qty']);
				$sheet->setCellValue('C' . $rows, $val['product_items_excel']);
				$rows++;
				$si++;
			}
			$writer = new Xlsx($spreadsheet);
			$writer->save('uploads/excel/' . $fileName . '.xlsx');
			return $this->response->download('uploads/excel/' . $fileName . '.xlsx', null)->setFileName($fileName . '.xlsx');
		} else {
			echo view('report/bom_print', $result_data);
		}
	}

	// -------------------------------PRASADAM WASTAGE---------------------------
	public function prasadam_wastage()
	{
		$data['list'] = $this->db->table('prasadam_wastage')->join('prasadam_setting', 'prasadam_setting.id = prasadam_wastage.prasadam_id')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('report/prasadam_wastage', $data);
		echo view('template/footer');
	}




	public function prasadam_wastage_add()
	{
		// Assuming you have a 'prasadam_wastage' table in your database
		$yr = date('Y');
		$mon = date('m');

		// Query to get the maximum invoice number
		$query = $this->db->query("SELECT MAX(CAST(SUBSTRING(invoice_no, 9) AS UNSIGNED)) as max_invoice FROM prasadam_wastage WHERE YEAR(date) = $yr AND MONTH(date) = $mon AND invoice_no LIKE 'PW%'")->getRowArray();

		$lastFiveDigits = (int) $query['max_invoice'];

		// Generate the new invoice number

		$data['inv_no'] = 'PW' . date("ym") . sprintf("%05d", $lastFiveDigits + 1);


		// Load the saved data from prasadam_wastage table
		$savedDataQuery = $this->db->table('prasadam_wastage')->where('id', $ins_id)->get();

		if ($savedDataQuery !== false) {
			$data['saved_data'] = $savedDataQuery->getRowArray();
		} else {
			$data['saved_data'] = array();
		}

		// Assuming you have a 'prasadam' table in your database
		$productQuery = $this->db->table('prasadam')->get();

		if ($productQuery !== false) {
			$data['product'] = $productQuery->getResultArray();
		} else {
			$data['product'] = array();
		}

		$data['list'] = $this->db->table('prasadam_setting')->get()->getResultArray();

		// Load views
		echo view('template/header');
		echo view('template/sidebar');
		echo view('report/prasadam_wastage_add', $data);
		echo view('template/footer');
	}


	// public function prasadam_wastage_view()
	// {
	// 	$id = $this->request->uri->getSegment(3);
	// 	$data['data'] = $this->db->table('prasadam_wastage')->where('id', $id)->get()->getRowArray();
	// 	$data['list'] = $this->db->table('prasadam_setting')->get()->getResultArray();
	// 	$data['view'] = true;
	// 	echo view('template/header');
	// 	echo view('template/sidebar');
	// 	echo view('report/prasadam_wastage_add', $data);
	// 	echo view('template/footer');
	// }
	public function prasadam_wastage_view()
	{
		$id = $this->request->uri->getSegment(3);

		// Joining prasadam_wastage table with prasadam_setting table
		$data['data'] = $this->db->table('prasadam_wastage')
			->select('prasadam_wastage.*, prasadam_setting.*')
			->join('prasadam_setting', 'prasadam_setting.id = prasadam_wastage.prasadam_id')
			->where('prasadam_wastage.id', $id)
			->get()
			->getRowArray();

		$data['list'] = $this->db->table('prasadam_setting')->get()->getResultArray();
		$data['view'] = true;

		echo view('template/header');
		echo view('template/sidebar');
		echo view('report/prasadam_wastage_add', $data);
		echo view('template/footer');
	}






	public function prasadam_wastage_save()
	{
		// Get data from the POST request
		$data = array(
			'date' => date("Y-m-d", strtotime($_POST['date'])),
			'invoice_no' => $_POST['invno'], // Use the correct name here
			'prasadam_id' => $_POST['prasadam_id'],
			'quantity' => $_POST['quantity'],
			'modified' => date("Y-m-d H:i:s"),
			'created' => date("Y-m-d H:i:s")
		);

		// Additional validation checks go here...

		// Insert data into prasadam_wastage table
		$res = $this->db->table('prasadam_wastage')->insert($data);
		$ins_id = $this->db->insertID();

		if ($res) {
			// Redirect to prasadam_wastage page
			header("Location: " . base_url() . "/report/prasadam_wastage");
			exit();
		} else {
			$msg_data['err'] = 'Failed to insert Prasadam Wastage data';
			echo json_encode($msg_data);
			exit();
		}
	}




	public function prasadam_wastage_validation()
	{
		// Trim $_POST values
		$date = trim($_POST['date']);
		$invoice_no = trim($_POST['invoice_no']);
		$prasadam_id = trim($_POST['prasadam_id']);
		$quantity = trim($_POST['quantity']);

		$data = array();

		// Check if required fields are not empty
		if (empty($date) || empty($invoice_no) || empty($prasadam_id) || empty($quantity)) {
			$data['err'] = "Please Fill Required Fields";
			$data['succ'] = '';
		} else {
			$data['succ'] = "Form validate";
			$data['err'] = '';
		}

		echo json_encode($data);
	}



	public function vendor_report()
	{
		echo view('template/header');
		echo view('template/sidebar');
		echo view('report/vendor_report');
		echo view('template/footer');
	}

	public function vendor_rep_ref()
	{
		$fdt = date('Y-m-d', strtotime($_POST['fdt']));
		$tdt = date('Y-m-d', strtotime($_POST['tdt']));

		$dat = $this->db->table('hall_booking')
			->join('hall_booking_service_details', 'hall_booking.id = hall_booking_service_details.hall_booking_id')
			->select('hall_booking.*')
			->select('hall_booking_service_details.*')
			->groupby('hall_booking_service_details.hall_booking_id')
			->where('hall_booking.entry_date>=', $fdt)
			->where('hall_booking.entry_date<=', $tdt)
			->where('hall_booking_service_details.checklist_amount IS NOT NULL', NULL)
			->get()->getResultArray();

		$data = [];
		//echo "<pre>"; print_r($dat); exit();
		$i = 1;
		foreach ($dat as $row) {



			$data[] = array(
				$i++,
				date('d-m-Y', strtotime($row['booking_date'])),
				date('d-m-Y', strtotime($row['entry_date'])),
				$row['name'],
				$row['service_name'],
				$row['service_description'],
				$row['checklist_amount']
			);
		}

		$result = array(
			"draw" => 0,
			"recordsTotal" => $i - 1,
			"recordsFiltered" => $i - 1,
			"data" => $data,
		);
		echo json_encode($result);
		exit();
	}

	public function print_vendor_report()
	{
		$data['fdate'] = $_REQUEST['fdt'];
		$data['tdate'] = $_REQUEST['tdt'];

		$fdt = date('Y-m-d', strtotime($_REQUEST['fdt']));
		$tdt = date('Y-m-d', strtotime($_REQUEST['tdt']));

		$data['data'] = $this->db->table('hall_booking')
			->join('hall_booking_service_details', 'hall_booking.id = hall_booking_service_details.hall_booking_id')
			->select('hall_booking.*')
			->select('hall_booking_service_details.*')
			->where('hall_booking.entry_date>=', $fdt)
			->where('hall_booking.entry_date<=', $tdt)
			->get()->getResultArray();

		if ($_REQUEST['pdf_vendarreport'] == "PDF") {
			$file_name = "Vendor_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$dompdf = new \Dompdf\Dompdf();
			$options = $dompdf->getOptions();
			$options->set(array('isRemoteEnabled' => true));
			$dompdf->setOptions($options);
			$dompdf->loadHtml(view('report/pdf/vendor_print', ["pdfdata" => $data]));
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$dompdf->stream($file_name);
		} elseif ($_REQUEST['excel_vendarreport'] == "EXCEL") {
			$fileName = "Vendor_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();
			$sheet->getStyle('A1')->getFont()->setBold(true)->setName('Arial')->SetSize(10);
			$style = array(
				'alignment' => array(
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				)
			);

			$sheet->getStyle("A1:I1")->applyFromArray($style);
			$sheet->mergeCells('A1:I1');
			$sheet->setCellValue('A1', $_SESSION['site_title']);
			$sheet->setCellValue('A2', 'S.No');
			$sheet->setCellValue('B2', 'Booking Date');
			$sheet->setCellValue('C2', 'Entry Date');
			$sheet->setCellValue('D2', 'Name');
			$sheet->setCellValue('E2', 'Event Details');
			$sheet->setCellValue('F2', 'Status');
			$sheet->setCellValue('G2', 'Total Amount');
			$sheet->setCellValue('H2', 'Paid Amount');
			$sheet->setCellValue('I2', 'Balance Amount');
			$rows = 3;
			$si = 1;
			$excel_format_data = $this->excel_format_get_vendorreport($data['fdate'], $data['tdate']);
			//var_dump($excel_format_data);
			//exit;
			foreach ($excel_format_data as $val) {
				$sheet->setCellValue('A' . $rows, $val['s_no']);
				$sheet->setCellValue('B' . $rows, $val['booking_date']);
				$sheet->setCellValue('C' . $rows, $val['entry_date']);
				$sheet->setCellValue('D' . $rows, $val['name']);
				$sheet->setCellValue('E' . $rows, $val['event_name']);
				$sheet->setCellValue('F' . $rows, $val['status']);
				$sheet->setCellValue('G' . $rows, $val['total_amount']);
				$sheet->setCellValue('H' . $rows, $val['paid_amount']);
				$sheet->setCellValue('I' . $rows, $val['balance_amount']);
				$rows++;
				$si++;
			}
			$writer = new Xlsx($spreadsheet);
			$writer->save('uploads/excel/' . $fileName . '.xlsx');
			return $this->response->download('uploads/excel/' . $fileName . '.xlsx', null)->setFileName($fileName . '.xlsx');
		} else {
			echo view('report/hallbooking_print', $data);
		}
	}
	public function excel_format_get_vendorreport($fdata, $tdata, $sts)
	{
		$fdt = date('Y-m-d', strtotime($fdata));
		$tdt = date('Y-m-d', strtotime($tdata));

		$dat = $this->db->table('hall_booking')
			->join('hall_booking_service_details', 'hall_booking.id = hall_booking_service_details.hall_booking_id')
			->select('hall_booking.*')
			->select('hall_booking_service_details.*')
			->where('hall_booking.entry_date>=', $fdt)
			->where('hall_booking.entry_date<=', $tdt)
			->get()->getResultArray();

		$data = [];
		$i = 1;
		$sts = "";
		foreach ($dat as $row) {
			if ($row['status'] == 1)
				$sts = "Booked";
			else if ($row['status'] == 2)
				$sts = "Completed";
			else if ($row['status'] == 3)
				$sts = "Cancelled";
			$data[] = array(
				"s_no" => $i++,
				"booking_date" => date('d-m-Y', strtotime($row['booking_date'])),
				"entry_date" => date('d-m-Y', strtotime($row['entry_date'])),
				"event_name" => $row['event_name'],
				"status" => $sts,
				"total_amount" => $row['total_amount'],
				"paid_amount" => $row['paid_amount'],
				"balance_amount" => $row['balance_amount']
			);
		}
		return $data;
	}
	public function loan_history_report()
	{
		$data['staff_list'] = $this->db->query("SELECT s.id as staff_id,s.name FROM staff as s JOIN advancesalary AS asy ON asy.staff_id = s.id JOIN pay_slip AS ps ON ps.staff_id = s.id WHERE s.is_admin = 0 and s.status = 1 GROUP BY ps.staff_id ORDER BY s.name ")->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('report/loan_history_report', $data);
		echo view('template/footer');
	}
	public function get_loan_history_report()
	{
		$fltername = $_POST['fltername'];
		if (!empty($fltername)) {
			$res = $this->db->query("SELECT s.id as staff_id,s.staff_type,s.name,s.address1,s.mobile,s.email FROM staff as s JOIN advancesalary AS asy ON asy.staff_id = s.id JOIN pay_slip AS ps ON ps.staff_id = s.id WHERE s.id = $fltername GROUP BY ps.staff_id")->getResultArray();
		} else {
			$res = $this->db->query("SELECT s.id as staff_id,s.staff_type,s.name,s.address1,s.mobile,s.email FROM staff as s JOIN advancesalary AS asy ON asy.staff_id = s.id JOIN pay_slip AS ps ON ps.staff_id = s.id GROUP BY ps.staff_id")->getResultArray();
		}

		$i = 1;
		$data = array();
		if (!empty($res)) {
			foreach ($res as $r) {
				if ($r['staff_type'] == 1) {
					$emp_name = "MALAYSIAN";
				} else if ($r['staff_type'] == 2) {
					$emp_name = "FOREIGNER";
				} else {
					$emp_name = "";
				}
				$action = '<a class="btn btn-primary btn-rad" title="Edit" href="' . base_url() . '/report/show_loan_history/' . $r['staff_id'] . '"><i class="material-icons">&#xE417;</i></a>';
				$phone_no = $r['mobile'];
				$data[] = array(
					$i++,
					$emp_name,
					$r['name'],
					$phone_no,
					$r['email'],
					$r['address1'],
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
	public function show_loan_history($id)
	{
		$data['loan'] = $this->db->query("SELECT * FROM staff WHERE staff.is_admin = 0 and staff.status = 1 and staff.id = $id ")->getRowArray();
		$data['refdet_lists'] = $this->db->query("SELECT ref_no FROM advancesalary WHERE staff_id = $id AND type = 2 ")->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('report/show_loan_history', $data);
		echo view('template/footer');
	}
	public function print_loan_history()
	{
		$ref_no = $_POST['ref_nooo'];
		$loan_staff_id = $_POST['loan_staff_id'];
		$data['loan'] = $this->db->query("SELECT * FROM staff WHERE staff.is_admin = 0 and staff.status = 1 and staff.id = $loan_staff_id ")->getRowArray();
		$data['ref_no'] = $ref_no;
		echo view('report/print_loan_history', $data);
	}

	public function prasadam_group()
	{
		$data = array();
		$data['list'] = $this->db->table("prasadam_group")->select('*')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('report/prasadam_group', $data);
		echo view('template/footer');
	}

	public function add_prasadam_group()
	{
		$data = array();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('report/add_prasadam_group', $data);
		echo view('template/footer');
	}

	public function prasadam_group_save()
	{
		$data = array();
		if (!empty($_POST['slot_name'])) {
			$data['group_name'] = trim($_POST['slot_name']);
			$data['description'] = trim($_POST['slot_name']);
			if (isset($_POST['status']))
				$data['status'] = trim($_POST['status']);
			if (empty($_POST['id'])) {
				$data['created_by'] = $this->session->get('log_id');
				$data['created_at'] = date('Y-m-d H:i:s');
				$builder = $this->db->table('prasadam_group')->insert($data);
				$ins_id = $this->db->insertID();
			} else {
				$ins_id = $_POST['id'];
				$builder = $this->db->table('prasadam_group')->where('id', $ins_id)->update($data);
			}
			if ($ins_id) {

				$this->session->setFlashdata('succ', 'Package Group Added Successfully');
				header("Location: " . base_url() . "/report/prasadam_group");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/report/prasadam_group");
			}
		} else {
			$this->session->setFlashdata('fail', 'Please fill all required field');
			header("Location: " . base_url() . "/report/prasadam_group");
		}
		exit;

	}

	public function edit_prasadam_group()
	{
		$data = array();
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->query("SELECT * FROM `prasadam_group` where prasadam_group.id = $id ")->getRowArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('report/add_prasadam_group', $data);
		echo view('template/footer');
	}

	public function view_prasadam_group()
	{
		$data = array();
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('prasadam_group')->where('prasadam_group.id', $id)->get()->getRowArray();
		$data['view'] = true;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('report/add_prasadam_group', $data);
		echo view('template/footer');
	}

	public function denomination_rep_view()
	{

		if (!$this->model->list_validate('archanai_report')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['list'] = $this->db->table('coin_value')->orderby('order_no', 'ASC')
			->get()->getResultArray();

		echo view('template/header');
		echo view('template/sidebar');
		echo view('report/denomination', $data);
		echo view('template/footer');
	}

	public function denomination_rep_ref()
	{
		$fdt = $_REQUEST['fdt'];
		$tdt = $_REQUEST['tdt'];
		$fltername = $_REQUEST['fltername'];

		$data = [];
		$dat = $this->db->table('coin_denomination')
			->join('coin_value', 'coin_value.key = coin_denomination.coin_key')
			->select('coin_value.name, coin_value.value')
			->select('SUM(coin_denomination.quantity) as total_quantity')
			->select('SUM(coin_denomination.c_quantity) as total_c_quantity')
			->where('DATE_FORMAT(coin_denomination.date, "%Y-%m-%d") >=', $fdt)
			->where('DATE_FORMAT(coin_denomination.date, "%Y-%m-%d") <=', $tdt);

		if (!empty($fltername) && $fltername != "0") {
			$dat = $dat->where('coin_denomination.coin_key', $fltername);
		}

		$dat = $dat->groupBy('coin_value.name')
			->orderBy('coin_value.order_no', 'desc')
			->get()
			->getResultArray();

		$i = 1;
		foreach ($dat as $row) {
			$amount = $row['total_quantity'] * $row['value'];

			$data[] = array(
				$i++,
				$row['name'],
				$row['total_quantity'],
				number_format($amount, 2)
			);
		}

		$result = array(
			"draw" => 0,
			"recordsTotal" => $i - 1,
			"recordsFiltered" => $i - 1,
			"data" => $data,
		);
		echo json_encode($result);
		exit();
	}

	public function print_denomination_report()
	{

		if (!$this->model->list_validate('archanai_report')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['fdate'] = $_REQUEST['fdt'];
		$data['tdate'] = $_REQUEST['tdt'];
		$fdt = $_REQUEST['fdt'];
		$tdt = $_REQUEST['tdt'];
		$fltername = $_REQUEST['fltername'];

		$data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
		$data['denominations'] = [];
		$dat = $this->db->table('coin_denomination')
			->join('coin_value', 'coin_value.key = coin_denomination.coin_key')
			->select('coin_value.name, coin_value.value')
			->select('SUM(coin_denomination.quantity) as total_quantity')
			->where('DATE_FORMAT(coin_denomination.date, "%Y-%m-%d") >=', $fdt)
			->where('DATE_FORMAT(coin_denomination.date, "%Y-%m-%d") <=', $tdt);

		if (!empty($fltername) && $fltername != "0") {
			$dat = $dat->where('coin_denomination.coin_key', $fltername);
		}

		$dat = $dat->groupBy('coin_value.name')
			->orderBy('coin_value.order_no', 'desc')
			->get()
			->getResultArray();

		$i = 1;
		foreach ($dat as $row) {
			$amount = $row['total_quantity'] * $row['value'];
			$data['denominations'][] = array(
				$i++,
				"name" => $row['name'],
				"quantity" => $row['total_quantity'],
				"amount" => number_format($amount, 2)
			);
		}

		if ($_REQUEST['pdf_denominationreport'] == "PDF") {
			$file_name = "Coin_Denomination_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$dompdf = new \Dompdf\Dompdf();
			$options = $dompdf->getOptions();
			$options->set(array('isRemoteEnabled' => true));
			$dompdf->setOptions($options);
			$dompdf->loadHtml(view('report/pdf/archanai_denominations_print', $data), 'UTF-8');
			$dompdf->setPaper('LEGAL', 'portrait');
			$dompdf->render();
			$dompdf->stream($file_name);
		} elseif ($_REQUEST['excel_denominationreport'] == "EXCEL") {
			$fileName = "Coin_Denomination_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$spreadsheet = new Spreadsheet();

			$sheet = $spreadsheet->getActiveSheet();
			$sheet->getStyle('A1')->getFont()->setBold(true)->setName('Arial')->SetSize(10);
			$style = array(
				'alignment' => array(
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				)
			);

			$sheet->getStyle("A1:F1")->applyFromArray($style);
			$sheet->mergeCells('A1:F1');
			$sheet->setCellValue('A1', $_SESSION['site_title']);
			$sheet->setCellValue('A2', 'S.No');
			$sheet->setCellValue('B2', 'Name');
			$sheet->setCellValue('C2', 'Quantity');
			$sheet->setCellValue('D2', 'Amount');
			$rows = 3;
			$si = 1;
			// $excel_format_data = $this->excel_format_get_denomination_record($fdata, $tdata, $fltername);
			$excel_format_data = $this->excel_format_get_denomination_record($fdt, $tdt, $fltername);
			// var_dump($excel_format_data);
			// exit;
			foreach ($excel_format_data as $val) {
				$sheet->setCellValue('A' . $rows, $val['s_no']);
				$sheet->setCellValue('B' . $rows, $val['name']);
				$sheet->setCellValue('C' . $rows, $val['qty']);
				$sheet->setCellValue('D' . $rows, $val['amount']);
				$rows++;
				$si++;
			}
			$writer = new Xlsx($spreadsheet);
			$writer->save('uploads/excel/' . $fileName . '.xlsx');
			return $this->response->download('uploads/excel/' . $fileName . '.xlsx', null)->setFileName($fileName . '.xlsx');
		} else {
			// var_dump($data);
			// exit;
			echo view('report/archanai_denominations_print', $data);
		}
	}

	public function excel_format_get_denomination_record($fdt, $tdt, $fltername)
	{
		$data = [];
		$dat = $this->db->table('coin_denomination')
			->join('coin_value', 'coin_value.key = coin_denomination.coin_key')
			->select('coin_value.name, coin_value.value')
			->select('SUM(coin_denomination.quantity) as total_quantity')
			->where('DATE_FORMAT(coin_denomination.date, "%Y-%m-%d") >=', $fdt)
			->where('DATE_FORMAT(coin_denomination.date, "%Y-%m-%d") <=', $tdt);
		if (!empty($fltername) && $fltername != "0") {
			$dat = $dat->where('coin_denomination.coin_key', $fltername);
		}

		$dat = $dat->groupBy('coin_value.name')
			->orderBy('coin_value.order_no', 'desc')
			->get()
			->getResultArray();

		$i = 1;
		foreach ($dat as $row) {
		// if (!empty($fltername) && $fltername != "0") {
		// 	$dat = $dat->where('coin_denomination.coin_key', $fltername);
		// }

		// // if (!$dat) {
		// // 	// Fetch the error details
		// // 	print_r($this->db->error());
		// // 	exit;
		// // }

		// $i = 1;
		// foreach ($dat as $row) {
			$amount = $row['total_quantity'] * $row['value'];
			$data[] = array(
				"s_no" => $i++,
				"name" => $row['name'],
				"qty" => $row['total_quantity'],
				"amount" => number_format($amount, 2)
			);
		}

		return $data;
	}


	public function deity_rep_view()
	{

		if (!$this->model->list_validate('archanai_report')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['diety'] = $this->db->table('archanai_diety')->orderby('id', 'ASC')
			->get()->getResultArray();

		echo view('template/header');
		echo view('template/sidebar');
		echo view('report/deityreport', $data);
		echo view('template/footer');
	}

	public function deity_rep_ref()
	{
		$fdt = $_REQUEST['fdt'];
		$tdt = $_REQUEST['tdt'];
		$fltername = $_REQUEST['fltername'];

		$data = [];
		$dat = $this->db->table('archanai_booking_details as abd')
			->join('archanai_diety as ad', 'ad.id = abd.diety_id')
			->join('archanai as a', 'a.id = abd.archanai_id')
			->join('archanai_booking as ab', 'ab.id = abd.archanai_booking_id')
			->select('ad.name as deity_name, a.name_eng, a.name_tamil, ab.date')
			->select('SUM(abd.quantity) as total_quantity')
			->select('SUM(abd.amount) as total_amount')
			->where('DATE_FORMAT(ab.date, "%Y-%m-%d") >=', $fdt)
			->where('DATE_FORMAT(ab.date, "%Y-%m-%d") <=', $tdt);


		if (!empty($fltername) && $fltername != "0") {
			$dat = $dat->where('abd.diety_id', $fltername);
		}

		$dat = $dat->groupBy('abd.diety_id, abd.archanai_id')
			// ->orderBy('coin_value.order_no', 'desc')
			->get()
			->getResultArray();

		$i = 1;
		foreach ($dat as $row) {

			$data[] = array(
				$i++,
				$row['date'],
				$row['name_eng'],
				$row['name_tamil'],
				$row['deity_name'],
				$row['total_quantity'],
				$row['total_amount']
			);
		}

		$result = array(
			"draw" => 0,
			"recordsTotal" => $i - 1,
			"recordsFiltered" => $i - 1,
			"data" => $data,
		);
		echo json_encode($result);
		exit();
	}

	public function print_deity_report()
	{
		if (!$this->model->list_validate('archanai_report')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['fdate'] = $_REQUEST['fdt'];
		$data['tdate'] = $_REQUEST['tdt'];
		$fdata = $_REQUEST['fdt'];
		$tdata = $_REQUEST['tdt'];
		$grp = $_REQUEST['grp'];
		$fltername = $_REQUEST['fltername'];
		$tmpid = $this->session->get('profile_id');
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
		if (!empty($fltername)) {
			$pfltername = $fltername;
			$flternameg = " and a.archanai_id = '" . $pfltername . "' ";
		} else {
			$flternameg = '';
		}
		$data['grp'] = $grp;
		$data['fltername'] = $fltername;
		$query1 = $this->db->query("select date, COUNT(date) as tcnt FROM archanai_booking where date >= '$fdata' and date <= '$tdata' GROUP BY date HAVING COUNT(date) > 0");
		$res = $query1->getResultArray();
		$i = 0;
		foreach ($res as $r) {
			$rd = $r['date'];
			$query2 = $this->db->query("select id from archanai_booking where date = '$rd'");
			$res1 = $query2->getResultArray();
			foreach ($res1 as $r1) {
				$rid[] = $r1['id'];
			}
			$string_version = implode(',', $rid);
			if (empty($fltername)) {
				$query3 = $this->db->query("select a.archanai_id,a.diety_id, sum(a.quantity) as qunty, sum(a.total_amount) as amt, sum(a.total_commision) as comm, count(a.archanai_id) as cnt
										from archanai_booking_details a, archanai_booking b
										where a.archanai_booking_id in ($string_version) and a.archanai_booking_id = b.id  and b.date like '%$rd%' group by a.diety_id,a.archanai_id having count(a.archanai_id) > 0");
			} else {
				$query3 = $this->db->query("select a.archanai_id,a.diety_id, sum(a.quantity) as qunty, sum(a.total_amount) as amt, sum(a.total_commision) as comm, count(a.archanai_id) as cnt
				from archanai_booking_details a, archanai_booking c,archanai_diety d
				where a.diety_id ='$fltername' and d.id = a.diety_id and c.id = a.archanai_booking_id and a.archanai_booking_id in ($string_version) and c.date like '%$rd%' group by a.diety_id,a.archanai_id having count(a.archanai_id) > 0");
			}

			$res2 = $query3->getResultArray();

			// echo '<pre>';
			// print_r($res2); exit;
			// $sqla="select a.archanai_id, sum(a.quantity) as qunty, a.amount+a.commision as tot, count(a.archanai_id) as cnt from archanai_booking_details a,archanai b where b.groupname=a and a.archanai_booking_id=b.id and a.archanai_booking_id in  group by a.archanai_id having count(a.archanai_id) > 0"


			foreach ($res2 as $row) {
				$bname = $this->db->table('archanai')->where('id', $row['archanai_id'])->get()->getRowArray();
				$aname = $this->db->table('archanai_diety')->where('archanai_diety.id', $row['diety_id'])->get()->getRowArray();
				$total = $row['amt'] + $row['comm'];
				$data['data'][$i]['date'] = date("d-m-Y", strtotime($rd));
				$data['data'][$i]['name_eng'] = $bname['name_eng'];
				$data['data'][$i]['name_tamil'] = $bname['name_tamil'];
				$data['data'][$i]['name'] = $aname['name'];
				$data['data'][$i]['qunt'] = $row['qunty'];
				$data['data'][$i++]['rate'] = $total;
			}
		}
		if ($_REQUEST['pdf_deityreport'] == "PDF") {
			$file_name = "Deity_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$dompdf = new \Dompdf\Dompdf();
			$options = $dompdf->getOptions();
			$options->set(array('isRemoteEnabled' => true));
			$dompdf->setOptions($options);
			$dompdf->loadHtml(view('report/pdf/deity_print', ["pdfdata" => $data]), 'UTF-8');
			$dompdf->setPaper('LEGAL', 'portrait');
			$dompdf->render();
			$dompdf->stream($file_name);
		} elseif ($_REQUEST['excel_deityreport'] == "EXCEL") {
			$fileName = "Deity_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$spreadsheet = new Spreadsheet();

			$sheet = $spreadsheet->getActiveSheet();
			$sheet->getStyle('A1')->getFont()->setBold(true)->setName('Arial')->SetSize(10);
			$style = array(
				'alignment' => array(
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				)
			);

			$sheet->getStyle("A1:G1")->applyFromArray($style);
			$sheet->mergeCells('A1:G1');
			$sheet->setCellValue('A1', $_SESSION['site_title']);
			$sheet->setCellValue('A2', 'S.No');
			$sheet->setCellValue('B2', 'Date');
			$sheet->setCellValue('C2', 'Product Name in English');
			$sheet->setCellValue('D2', 'Product Name in Tamil');
			$sheet->setCellValue('E2', 'Deity Name');
			$sheet->setCellValue('F2', 'Quantity');
			$sheet->setCellValue('G2', 'Amount');
			$rows = 3;
			$si = 1;
			$excel_format_data = $this->excel_format_get_deityrecord($fdata, $tdata, $grp, $fltername);
			//var_dump($excel_format_data);
			//exit;
			foreach ($excel_format_data as $val) {
				$sheet->setCellValue('A' . $rows, $val['s_no']);
				$sheet->setCellValue('B' . $rows, $val['date']);
				$sheet->setCellValue('C' . $rows, $val['name_eng']);
				$sheet->setCellValue('D' . $rows, $val['name_tamil']);
				$sheet->setCellValue('E' . $rows, $val['name']);
				$sheet->setCellValue('F' . $rows, $val['qty']);
				$sheet->setCellValue('G' . $rows, $val['total']);
				$rows++;
				$si++;
			}
			$writer = new Xlsx($spreadsheet);
			$writer->save('uploads/excel/' . $fileName . '.xlsx');
			return $this->response->download('uploads/excel/' . $fileName . '.xlsx', null)->setFileName($fileName . '.xlsx');
		} else {
			echo view('report/deity_print', $data);
		}
	}

	public function excel_format_get_deityrecord($fdata, $tdata, $grp, $nameid)
	{
		$fltername = $_REQUEST['fltername'];
		$query1 = $this->db->query("select date, COUNT(date) as tcnt FROM archanai_booking where date >= '$fdata' and date <= '$tdata' GROUP BY date HAVING COUNT(date) > 0");
		$res = $query1->getResultArray();
		$i = 0;
		$i = 1;
		$data = array();
		if (!empty($res)) {
			foreach ($res as $r) {
				$rd = $r['date'];
				$query2 = $this->db->query("select id from archanai_booking where date = '$rd'");
				$res1 = $query2->getResultArray();

				foreach ($res1 as $r1) {
					$rid[] = $r1['id'];
				}
				$string_version = implode(',', $rid); //print_r($string_version);die;
				if (empty($fltername)) {
					$query3 = $this->db->query("select a.archanai_id,a.diety_id, sum(a.quantity) as qunty, sum(a.total_amount) as amt, sum(a.total_commision) as comm, count(a.archanai_id) as cnt
											from archanai_booking_details a, archanai_booking b
											where a.archanai_booking_id in ($string_version) and a.archanai_booking_id = b.id  and b.date like '%$rd%' group by a.diety_id,a.archanai_id having count(a.archanai_id) > 0");
				} else {
					$query3 = $this->db->query("select a.archanai_id,a.diety_id, sum(a.quantity) as qunty, sum(a.total_amount) as amt, sum(a.total_commision) as comm, count(a.archanai_id) as cnt
					from archanai_booking_details a, archanai_booking c,archanai_diety d
					where a.diety_id ='$fltername' and d.id = a.diety_id and c.id = a.archanai_booking_id and a.archanai_booking_id in ($string_version) and c.date like '%$rd%' group by a.diety_id,a.archanai_id having count(a.archanai_id) > 0");
				}

				//echo $this->db->getLastQuery();die;
				$res2 = $query3->getResultArray();
				//print_r($res2);die;
				foreach ($res2 as $row) {
					//print_r($row);
					$total = $row['amt'] + $row['comm'];
					$bname = $this->db->table('archanai')->where('id', $row['archanai_id'])->get()->getRowArray();
					$aname = $this->db->table('archanai_diety')->where('archanai_diety.id', $row['diety_id'])->get()->getRowArray();
					$data[] = array(
						"s_no" => $i++,
						"date" => date("d-m-Y", strtotime($rd)),
						"name_eng" => $bname['name_eng'],
						"name" => $aname['name'],
						"qty" => $row['qunty'],
						"total" => $total
					);
				}
			}
		}
		return $data;
	}

	public function offering_rep_ref()
	{
		$fdt = date('Y-m-d', strtotime($_POST['fdt']));
		$tdt = date('Y-m-d', strtotime($_POST['tdt']));
		$type = $_POST['type'];
		$ptype = $_POST['ptype'];
		$data = [];
		//$qry = $this->db->query("select * from `product_offering` where date >= '$fdt' and date <= '$tdt'")->getResultArray();
		$qry = $this->db->query("SELECT 
											product_offering.*,
											product_offering_detail.*,
											product_category.name as product_name,  
											offering_category.name as category_name
										FROM 
											`product_offering`
										INNER JOIN 
											product_offering_detail ON product_offering_detail.pro_off_id = product_offering.id
										INNER JOIN 
											product_category ON product_offering_detail.product_id = product_category.id
										INNER JOIN 
											offering_category ON product_offering_detail.offering_id = offering_category.id
										ORDER BY 
											product_offering.id DESC")->getResultArray();

		if (!empty($type)) {
			// $qry = $this->db->query("select * from `product_offering` inner join product_offering_detail on product_offering_detail.pro_off_id = product_offering.id inner join product_category on product_offering_detail.product_id = product_category.id where product_offering_detail.offering_id = $type")->getResultArray();
			$qry = $this->db->query("SELECT 
											product_offering.*,
											product_offering_detail.*,
											product_category.name as product_name,  
											offering_category.name as category_name
										FROM 
											`product_offering`
										INNER JOIN 
											product_offering_detail ON product_offering_detail.pro_off_id = product_offering.id
										INNER JOIN 
											product_category ON product_offering_detail.product_id = product_category.id
										INNER JOIN 
											offering_category ON product_offering_detail.offering_id = offering_category.id
										WHERE 
											product_offering_detail.offering_id = ?
										ORDER BY 
											product_offering.id DESC", [$type])->getResultArray();

		}
		if (!empty($type) && !empty($ptype)) {
			//$qry = $this->db->query("select * from `product_offering` inner join product_offering_detail on product_offering_detail.pro_off_id = product_offering.id inner join product_category on product_offering_detail.product_id = product_category.id where product_offering_detail.offering_id = $type and product_offering_detail.product_id = $ptype")->getResultArray();
			$qry = $this->db->query("SELECT 
										product_offering.*,
										product_offering_detail.*,
										product_category.name AS product_name,  
										offering_category.name AS category_name
									FROM 
										`product_offering`
									INNER JOIN 
										product_offering_detail ON product_offering_detail.pro_off_id = product_offering.id
									INNER JOIN 
										product_category ON product_offering_detail.product_id = product_category.id
									INNER JOIN 
										offering_category ON product_offering_detail.offering_id = offering_category.id
									WHERE 
										product_offering_detail.offering_id = ? AND product_offering_detail.product_id = ?
									ORDER BY 
										product_offering.id DESC", [$type, $ptype])->getResultArray();
		}

		//$qry = $this->db->table('product_offering')->select('*')->where('created' >= '$fdt')->orderBy('id', 'desc')->get()->getResultArray();
		$totalGramsByCategory = [];
		$i = 1;
		foreach ($qry as $row) {

			$data[] = array(
				$i++,
				'<p style="text-align:left;">' . $row['name'] . '</p>',
				$row['phone'],
				$row['category_name'],
				$row['product_name'],
				$row['grams']
			);
			if (isset($totalGramsByCategory[$row['category_name']])) {
				$totalGramsByCategory[$row['category_name']] += $row['grams'];
			} else {
				$totalGramsByCategory[$row['category_name']] = $row['grams'];
			}
		}
		$result = array(
			"draw" => 0,
			"recordsTotal" => $i - 1,
			"recordsFiltered" => $i - 1,
			"data" => $data,
			"totals" => $totalGramsByCategory
		);
		echo json_encode($result);
		exit();
	}

	public function print_offeringreport()
	{
		$fdt = date('Y-m-d', strtotime($_REQUEST['fdt']));
		$tdt = date('Y-m-d', strtotime($_REQUEST['tdt']));
		$type = $_REQUEST['offering_id'] ?? '';
		$ptype = $_REQUEST['product_id'] ?? '';

		$data['fdate'] = $fdt;
		$data['tdate'] = $tdt;
		$data['type'] = $type;
		$data['ptype'] = $ptype;

		$tmpid = $this->session->get('profile_id') ?: 1;
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();

		// ── Build query matching offering_rep_ref() logic exactly ────────
		$builder = $this->db->table('product_offering')
			->select('
            product_offering.*,
            product_offering_detail.*,
            product_category.name   AS product_name,
            offering_category.name  AS category_name
        ')
			->join('product_offering_detail', 'product_offering_detail.pro_off_id = product_offering.id')
			->join('product_category', 'product_offering_detail.product_id   = product_category.id')
			->join('offering_category', 'product_offering_detail.offering_id  = offering_category.id')
			->orderBy('offering_category.name', 'ASC')
			->orderBy('product_category.name', 'ASC')
			->orderBy('product_offering.date', 'ASC');

		// Only apply category/product filters (same as AJAX)
		if (!empty($type)) {
			$builder->where('product_offering_detail.offering_id', $type);
		}
		if (!empty($ptype)) {
			$builder->where('product_offering_detail.product_id', $ptype);
		}

		$data['list'] = $builder->get()->getResultArray();
		// ─────────────────────────────────────────────────────────────────

		if (!empty($_REQUEST['pdf_offeringreport']) && $_REQUEST['pdf_offeringreport'] === 'PDF') {

			$file_name = "Offering_Report_{$fdt}_to_{$tdt}";
			$dompdf = new \Dompdf\Dompdf();
			$options = $dompdf->getOptions();
			$options->set(['isRemoteEnabled' => true]);
			$dompdf->setOptions($options);
			$dompdf->loadHtml(view('report/pdf/offering_print', ['pdfdata' => $data]));
			$dompdf->setPaper('A4', 'landscape');
			$dompdf->render();
			$dompdf->stream($file_name);

		} elseif (!empty($_REQUEST['excel_offeringreport']) && $_REQUEST['excel_offeringreport'] === 'EXCEL') {

			$fileName = "Offering_Report_{$fdt}_to_{$tdt}";
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();
			$sheet->getStyle('A1')->getFont()->setBold(true)->setName('Arial')->setSize(10);
			$style = ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]];
			$sheet->getStyle("A1:I1")->applyFromArray($style);
			$sheet->mergeCells('A1:I1');
			$sheet->setCellValue('A1', $_SESSION['site_title']);
			$sheet->setCellValue('A2', 'S.No');
			$sheet->setCellValue('B2', 'Date');
			$sheet->setCellValue('C2', 'Ref No');
			$sheet->setCellValue('D2', 'Name');
			$sheet->setCellValue('E2', 'Phone');
			$sheet->setCellValue('F2', 'Offering Category');
			$sheet->setCellValue('G2', 'Product Name');
			$sheet->setCellValue('H2', 'Grams');
			$sheet->setCellValue('I2', 'Quantity');
			$rows = 3;
			$si = 1;

			foreach ($data['list'] as $val) {
				$sheet->setCellValue('A' . $rows, $si++);
				$sheet->setCellValue('B' . $rows, date('d-m-Y', strtotime($val['date'])));
				$sheet->setCellValue('C' . $rows, $val['ref_no'] ?? '');
				$sheet->setCellValue('D' . $rows, $val['name']);
				$sheet->setCellValue('E' . $rows, $val['phone']);
				$sheet->setCellValue('F' . $rows, $val['category_name']);
				$sheet->setCellValue('G' . $rows, $val['product_name']);
				$sheet->setCellValue('H' . $rows, $val['grams']);
				$sheet->setCellValue('I' . $rows, $val['quantity'] ?? '');
				$rows++;
			}

			$writer = new Xlsx($spreadsheet);
			$writer->save('uploads/excel/' . $fileName . '.xlsx');
			return $this->response->download('uploads/excel/' . $fileName . '.xlsx', null)->setFileName($fileName . '.xlsx');

		} else {
			echo view('report/offering_print', $data);
		}
	}
	public function excel_format_get_offering($fdata, $tdata, $cdata, $type, $ptype)
	{
		$fdt = date('Y-m-d', strtotime($fdata));
		$tdt = date('Y-m-d', strtotime($tdata));
		$group_filter_fill = $group_filter;
		if (!empty($cdata)) {
			$cdt = date('Y-m-d', strtotime($cdata));
		}
		// $flternameg = $fltername;
		$data = [];

		// $dat = $this->db->table('templebooking', 'booked_packages.name as pname')
		// 	->join('booked_packages', 'booked_packages.booking_id = templebooking.id')
		// 	->select('booked_packages.name as pname')
		// 	->select('templebooking.*')
		// 	->where('DATE_FORMAT(templebooking.entry_date, "%Y-%m-%d") >=', $fdt);
		// $dat = $dat->where('DATE_FORMAT(templebooking.entry_date, "%Y-%m-%d") <=', $tdt);

		// if ($booking_type) {
		// 	$dat = $dat->where('booked_packages.booking_type', $booking_type);
		// }
		// if (!empty($cdt)) {
		// 	$dat = $dat->where('templebooking.booking_date =', $cdt);
		// }

		// if (!empty($group_filter_fill) && $group_filter_fill != "0") {
		// 	$dat = $dat->where('templebooking.payment_type', $group_filter_fill);
		// }

		// $dat = $dat->orderBy('entry_date', 'desc');
		// $dat = $dat->get()->getResultArray();


		$builder = $this->db->table('product_offering')
			->select('
        product_offering.*,
        product_offering_detail.*,
        product_category.name AS product_name,
        offering_category.name AS category_name
    ')
			->join('product_offering_detail', 'product_offering_detail.pro_off_id = product_offering.id')
			->join('product_category', 'product_offering_detail.product_id = product_category.id')
			->join('offering_category', 'product_offering_detail.offering_id = offering_category.id');

		// Apply condition if $type is not empty
		if (!empty($type)) {
			$builder->where('product_offering_detail.offering_id', $type);
		}

		// Apply condition if $ptype is not empty
		if (!empty($ptype)) {
			$builder->where('product_offering_detail.product_id', $ptype);
		}

		// Order the results
		$builder->orderBy('product_offering.id', 'DESC');

		// Execute the query
		$qry = $builder->get()->getResultArray();

		$i = 1;
		foreach ($qry as $row) {

			$data[] = array(
				"s_no" => $i++,
				"name" => $row['name'],
				"phone" => $row['phone'],
				"category_name" => $row['category_name'],
				"product_name" => $row['product_name'],
				"grams" => $row['grams']
			);
		}
		return $data;
	}

	public function annathanam_rep_view()
	{
		$data['fltr_name'] = $this->db->table('annathanam_new')->select('name')->groupBy('name')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('report/annathanam', $data);
		echo view('template/footer');
	}

	public function annathanam_rep_ref()
	{
		$fdt = date('Y-m-d', strtotime($_POST['fdt']));
		$tdt = date('Y-m-d', strtotime($_POST['tdt']));
		//$cdt = date('Y-m-d', strtotime($_POST['cdt']))  || 0;
		$group_filter = $_POST['group_filter'];
		$data = [];
		$qry = $this->db->table('annathanam_new a')
			->select('a.*, ap.name_eng, ap.name_tamil, apgd.pay_method')
			->join('annathanam_packages ap', 'ap.id = a.package_id', 'left')
			->join('annathanam_payment_gateway_datas apgd', 'a.id = apgd.annathanam_booking_id')
			->orderBy('a.id', 'desc')
			->where('a.booking_type !=', 3)
			->where('a.date >=', $fdt);
		$qry = $qry->where('a.date <=', $tdt);

		if (!empty($group_filter) && $group_filter != "0") {
			if ($group_filter === 'full') {
				$qry = $qry->where('a.total_amount = a.paid_amount');
			} elseif ($group_filter === 'partial') {
				$qry = $qry->where('a.paid_amount > 0')->where('a.paid_amount < a.total_amount');
			} elseif ($group_filter === 'only_booked') {
				$qry = $qry->where('a.paid_amount =', 0);
			}
		}

		$qry = $qry->get()->getResultArray();

		$i = 1;
		foreach ($qry as $row) {
			$balance_amount = (float) $row['total_amount'] - (float) $row['paid_amount'];
			if ($balance_amount < 0)
				$balance_amount = 0;

			if ($row['booking_status'] == 3) {
				$txt = '<span class="cancel_text">Cancelled</span>';
			} else {

				if (empty($balance_amount)) {
					$txt = '<span class="paid_text">Paid</span>';
				} else {
					$txt = '<span class="unpaid_text">Partially Paid</span>';
				}
			}

			if ($row['booking_type'] == 1) {
				$data[] = array(
					$i++,
					date('d-m-Y', strtotime($row['date'])),
					$row['ref_no'],
					$type = 'Hall Booking',
					$row['name'],
					$row['name_eng'] . '/' . $row['name_tamil'],
					$txt = '-',
					$pay_method = '-',
					$amount = '-',
					$paid_amount = '-',
					$print = '-',
				);
			} elseif ($row['booking_type'] == 2) {
				$data[] = array(
					$i++,
					date('d-m-Y', strtotime($row['date'])),
					$row['ref_no'],
					$type = 'Ubayam',
					$row['name'],
					$row['name_eng'] . '/' . $row['name_tamil'],
					$txt = '-',
					$pay_method = '-',
					$amount = '-',
					$paid_amount = '-',
					$print = '-',
				);
			} else {
				$data[] = array(
					$i++,
					date('d-m-Y', strtotime($row['date'])),
					$row['ref_no'],
					$type = 'Annathanam',
					$row['name'],
					$row['name_eng'] . '/' . $row['name_tamil'],
					$txt,
					$row['pay_method'],
					number_format($row['total_amount'], '2', '.', ','),
					number_format($row['paid_amount'], '2', '.', ','),
					$print = '<a class="btn btn-primary btn-rad" href="' . base_url() . '/annathanam_new/print_annathanam/' . $row['id'] . '" target="_blank"><i class="fa fa-print"></i> </a>'
				);
			}
		}
		$result = array(
			"draw" => 0,
			"recordsTotal" => $i - 1,
			"recordsFiltered" => $i - 1,
			"data" => $data,
		);
		echo json_encode($result);
		exit();
	}

	public function print_annathanamreport()
	{
		$data['fdate'] = $_REQUEST['fdt'];
		$data['tdate'] = $_REQUEST['tdt'];
		$data['group_filter'] = $_REQUEST['group_filter'];
		$tmpid = 1;
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
		if ($_REQUEST['pdf_annathanamreport'] == "PDF") {
			$file_name = "Annathanam_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$dompdf = new \Dompdf\Dompdf();
			$options = $dompdf->getOptions();
			$options->set(array('isRemoteEnabled' => true));
			$dompdf->setOptions($options);
			$dompdf->loadHtml(view('report/pdf/annathanam_print', ["pdfdata" => $data]));
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$dompdf->stream($file_name);
		} elseif ($_REQUEST['excel_annathanamreport'] == "EXCEL") {
			$fileName = "Annathanam_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$spreadsheet = new Spreadsheet();

			$sheet = $spreadsheet->getActiveSheet();
			$sheet->getStyle('A1')->getFont()->setBold(true)->setName('Arial')->SetSize(10);
			$style = array(
				'alignment' => array(
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				)
			);

			$sheet->getStyle("A1:F1")->applyFromArray($style);
			$sheet->mergeCells('A1:F1');
			$sheet->setCellValue('A1', $data['temp_details']['name']);
			$sheet->setCellValue('A2', 'S.No');
			$sheet->setCellValue('B2', 'Date');
			$sheet->setCellValue('C2', 'Invoice No');
			$sheet->setCellValue('D2', 'Name');
			$sheet->setCellValue('E2', 'Package');
			$sheet->setCellValue('F2', 'Paid Amount');
			$sheet->setCellValue('G2', 'Total Amount');
			$rows = 3;
			$si = 1;
			$excel_format_data = $this->excel_format_get_annathanamreport($data['fdate'], $data['tdate'], $data['group_filter']);

			foreach ($excel_format_data as $val) {
				$sheet->setCellValue('A' . $rows, $val['s_no']);
				$sheet->setCellValue('B' . $rows, $val['date']);
				$sheet->setCellValue('C' . $rows, $val['ref_no']);
				$sheet->setCellValue('D' . $rows, $val['name']);
				$sheet->setCellValue('E' . $rows, $val['package']);
				$sheet->setCellValue('F' . $rows, $val['paid_amount']);
				$sheet->setCellValue('G' . $rows, $val['total_amount']);
				$rows++;
				$si++;
			}
			$writer = new Xlsx($spreadsheet);
			$writer->save('uploads/excel/' . $fileName . '.xlsx');
			return $this->response->download('uploads/excel/' . $fileName . '.xlsx', null)->setFileName($fileName . '.xlsx');
		} else {
			echo view('report/annathanam_print', $data);
		}
	}

	public function excel_format_get_annathanamreport($fdata, $tdata, $group_filter)
	{
		$fdt = date('Y-m-d', strtotime($fdata));
		$tdt = date('Y-m-d', strtotime($tdata));

		$data = [];

		$qry = $this->db->table('annathanam_new a')
			->select('a.*, ap.name_eng, ap.name_tamil, apgd.pay_method')
			->join('annathanam_packages ap', 'ap.id = a.package_id', 'left')
			->join('annathanam_payment_gateway_datas apgd', 'a.id = apgd.annathanam_booking_id')
			->orderBy('a.id', 'desc')
			->where('a.booking_type !=', 3)
			->where('a.date >=', $fdt);
		$qry = $qry->where('a.date <=', $tdt);

		if (!empty($group_filter) && $group_filter != "0") {
			if ($group_filter === 'full') {
				$qry = $qry->where('a.total_amount = a.paid_amount');
			} elseif ($group_filter === 'partial') {
				$qry = $qry->where('a.paid_amount > 0')->where('a.paid_amount < a.total_amount');
			} elseif ($group_filter === 'only_booked') {
				$qry = $qry->where('a.paid_amount =', 0);
			}
		}

		$dat = $qry->get()->getResultArray();

		$i = 1;
		foreach ($dat as $row) {

			$data[] = array(
				"s_no" => $i++,
				"date" => date('d-m-Y', strtotime($row['date'])),
				"ref_no" => $row['ref_no'],
				"name" => $row['name'],
				"package" => $row['name_eng'] . '/' . $row['name_tamil'],
				"paid_amount" => $row['paid_amount'],
				"total_amount" => $row['total_amount']
			);
		}
		return $data;
	}

	public function catering_rep_view()
	{
		$data['fltr_name'] = $this->db->table('annathanam_new')->select('name')->groupBy('name')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('report/catering', $data);
		echo view('template/footer');
	}

	public function catering_rep_ref()
	{
		$fdt = date('Y-m-d', strtotime($_POST['fdt']));
		$tdt = date('Y-m-d', strtotime($_POST['tdt']));
		$group_filter = $_POST['group_filter'];

		$data = [];
		$qry = $this->db->table('annathanam_new a')
			->select('a.*, ap.name_eng, ap.name_tamil, apgd.pay_method')
			->join('annathanam_packages ap', 'ap.id = a.package_id', 'left')
			->join('annathanam_payment_gateway_datas apgd', 'a.id = apgd.annathanam_booking_id')
			->orderBy('a.id', 'desc')
			->where('a.booking_type', 3)
			->where('a.date >=', $fdt);
		$qry = $qry->where('a.date <=', $tdt);

		if (!empty($group_filter) && $group_filter != "0") {
			if ($group_filter === 'full') {
				$qry = $qry->where('a.total_amount = a.paid_amount');
			} elseif ($group_filter === 'partial') {
				$qry = $qry->where('a.paid_amount > 0')->where('a.paid_amount < a.total_amount');
			} elseif ($group_filter === 'only_booked') {
				$qry = $qry->where('a.paid_amount =', 0);
			}
		}

		$qry = $qry->get()->getResultArray();

		$i = 1;
		foreach ($qry as $row) {
			$balance_amount = (float) $row['total_amount'] - (float) $row['paid_amount'];
			if ($balance_amount < 0)
				$balance_amount = 0;

			if ($row['booking_status'] == 3) {
				$txt = '<span class="cancel_text">Cancelled</span>';
			} else {

				if (empty($balance_amount)) {
					$txt = '<span class="paid_text">Paid</span>';
				} else {
					$txt = '<span class="unpaid_text">Partially Paid</span>';
				}
			}


			$data[] = array(
				$i++,
				date('d-m-Y', strtotime($row['date'])),
				$row['ref_no'],
				$row['name'],
				date('d-m-Y', strtotime($row['event_date'])),
				$txt,
				$row['pay_method'],
				number_format($row['total_amount'], '2', '.', ','),
				number_format($row['paid_amount'], '2', '.', ','),
				$print = '<a class="btn btn-primary btn-rad" href="' . base_url() . '/catering/print_page/' . $row['id'] . '" target="_blank"><i class="fa fa-print"></i> </a>'
			);

		}
		$result = array(
			"draw" => 0,
			"recordsTotal" => $i - 1,
			"recordsFiltered" => $i - 1,
			"data" => $data,
		);
		echo json_encode($result);
		exit();
	}

	public function print_cateringreport()
	{
		$data['fdate'] = $_REQUEST['fdt'];
		$data['tdate'] = $_REQUEST['tdt'];
		$data['group_filter'] = $_REQUEST['group_filter'];
		$tmpid = 1;
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
		if ($_REQUEST['pdf_cateringreport'] == "PDF") {
			$file_name = "Catering_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$dompdf = new \Dompdf\Dompdf();
			$options = $dompdf->getOptions();
			$options->set(array('isRemoteEnabled' => true));
			$dompdf->setOptions($options);
			$dompdf->loadHtml(view('report/pdf/catering_print', ["pdfdata" => $data]));
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$dompdf->stream($file_name);
		} elseif ($_REQUEST['excel_cateringreport'] == "EXCEL") {
			$fileName = "Catering_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$spreadsheet = new Spreadsheet();

			$sheet = $spreadsheet->getActiveSheet();
			$sheet->getStyle('A1')->getFont()->setBold(true)->setName('Arial')->SetSize(10);
			$style = array(
				'alignment' => array(
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				)
			);

			$sheet->getStyle("A1:F1")->applyFromArray($style);
			$sheet->mergeCells('A1:F1');
			$sheet->setCellValue('A1', $data['temp_details']['name']);
			$sheet->setCellValue('A2', 'S.No');
			$sheet->setCellValue('B2', 'Date');
			$sheet->setCellValue('C2', 'Invoice No');
			$sheet->setCellValue('D2', 'Name');
			$sheet->setCellValue('E2', 'Event Date');
			$sheet->setCellValue('F2', 'Paid Amount');
			$sheet->setCellValue('G2', 'Total Amount');
			$rows = 3;
			$si = 1;
			$excel_format_data = $this->excel_format_get_cateringreport($data['fdate'], $data['tdate'], $data['group_filter']);

			foreach ($excel_format_data as $val) {
				$sheet->setCellValue('A' . $rows, $val['s_no']);
				$sheet->setCellValue('B' . $rows, $val['date']);
				$sheet->setCellValue('C' . $rows, $val['ref_no']);
				$sheet->setCellValue('D' . $rows, $val['name']);
				$sheet->setCellValue('E' . $rows, $val['event_date']);
				$sheet->setCellValue('F' . $rows, $val['paid_amount']);
				$sheet->setCellValue('G' . $rows, $val['total_amount']);
				$rows++;
				$si++;
			}
			$writer = new Xlsx($spreadsheet);
			$writer->save('uploads/excel/' . $fileName . '.xlsx');
			return $this->response->download('uploads/excel/' . $fileName . '.xlsx', null)->setFileName($fileName . '.xlsx');
		} else {
			echo view('report/catering_print', $data);
		}
	}

	public function excel_format_get_cateringreport($fdata, $tdata, $group_filter)
	{
		$fdt = date('Y-m-d', strtotime($fdata));
		$tdt = date('Y-m-d', strtotime($tdata));

		$data = [];

		$qry = $this->db->table('annathanam_new a')
			->select('a.*, ap.name_eng, ap.name_tamil, apgd.pay_method')
			->join('annathanam_packages ap', 'ap.id = a.package_id', 'left')
			->join('annathanam_payment_gateway_datas apgd', 'a.id = apgd.annathanam_booking_id')
			->orderBy('a.id', 'desc')
			->where('a.booking_type', 3)
			->where('a.date >=', $fdt);
		$qry = $qry->where('a.date <=', $tdt);

		if (!empty($group_filter) && $group_filter != "0") {
			if ($group_filter === 'full') {
				$qry = $qry->where('a.total_amount = a.paid_amount');
			} elseif ($group_filter === 'partial') {
				$qry = $qry->where('a.paid_amount > 0')->where('a.paid_amount < a.total_amount');
			} elseif ($group_filter === 'only_booked') {
				$qry = $qry->where('a.paid_amount =', 0);
			}
		}

		$dat = $qry->get()->getResultArray();

		$i = 1;
		foreach ($dat as $row) {

			$data[] = array(
				"s_no" => $i++,
				"date" => date('d-m-Y', strtotime($row['date'])),
				"ref_no" => $row['ref_no'],
				"name" => $row['name'],
				"event_date" => date('d-m-Y', strtotime($row['event_date'])),
				"paid_amount" => $row['paid_amount'],
				"total_amount" => $row['total_amount']
			);
		}
		return $data;
	}
	public function get_booked_dates()
	{
		$booking_id = isset($_POST['booking_id']) ? $_POST['booking_id'] : 0;
		$booking_type = isset($_POST['booking_type']) ? $_POST['booking_type'] : 0;

		$dat = $this->db->table('templebooking')
			->join('booked_packages', 'booked_packages.booking_id = templebooking.id')
			->select('templebooking.booking_date')
			->where('templebooking.id !=', $booking_id)
			->where('templebooking.booking_status !=', 3);

		if ($booking_type) {
			$dat = $dat->where('booked_packages.booking_type', $booking_type);
		}

		$dat = $dat->groupBy('templebooking.booking_date')
			->get()->getResultArray();

		$booked_dates = array();
		foreach ($dat as $row) {
			$booked_dates[] = $row['booking_date'];
		}

		echo json_encode(array('booked_dates' => $booked_dates));
		exit();
	}

	public function update_booking_name_date()
	{
		$booking_id = $_POST['booking_id'];
		$name = trim($_POST['name']);
		$booking_date = date('Y-m-d', strtotime($_POST['booking_date']));
		$booking_type = isset($_POST['booking_type']) ? $_POST['booking_type'] : 0;

		// Validate: check if date is already booked
		$existing = $this->db->table('templebooking')
			->join('booked_packages', 'booked_packages.booking_id = templebooking.id')
			->where('templebooking.booking_date', $booking_date)
			->where('templebooking.id !=', $booking_id)
			->where('templebooking.booking_status !=', 3);

		if ($booking_type) {
			$existing = $existing->where('booked_packages.booking_type', $booking_type);
		}

		$existing = $existing->get()->getResultArray();

		if (!empty($existing)) {
			echo json_encode(array('status' => 'error', 'message' => 'This event date is already booked. Please select another date.'));
			exit();
		}
		$update_data = array(
			'name' => $name,
			'booking_date' => $booking_date,
			'remarks' => trim($_POST['remarks'] ?? '')
		);

		$res = $this->db->table('templebooking')->where('id', $booking_id)->update($update_data);

		if ($res) {
			echo json_encode(array('status' => 'success', 'message' => 'Booking updated successfully.'));
		} else {
			echo json_encode(array('status' => 'error', 'message' => 'Failed to update. Please try again.'));
		}
		exit();
	}
	public function print_courtesyreport()
	{
		$tmpid = $this->session->get('profile_id');
		$temple_detail = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
		$temple_name = !empty($temple_detail['name']) ? $temple_detail['name'] : "";
		$donation_courtesy_grace_amount = floatVal($temple_detail['donation_courtesy_grace_amount']);
		$ubayam_courtesy_grace_amount = floatVal($temple_detail['ubayam_courtesy_grace_amount']);

		$fdata = $_REQUEST['fdt'];
		$tdata = $_REQUEST['tdt'];
		$type = $_REQUEST['type'];
		$mobile_no = $_REQUEST['mobile_no'];

		$data['fdate'] = $fdata;
		$data['tdate'] = $tdata;
		$data['temp_details'] = $temple_detail;

		/* ---------- Donation ---------- */
		$donation_query = $this->db->table('donation')
			->select('donation.name, donation.date, donation.amount')
			->where('donation.amount >=', $donation_courtesy_grace_amount)
			->where('DATE_FORMAT(donation.date,"%Y-%m-%d") >=', $fdata)
			->where('DATE_FORMAT(donation.date,"%Y-%m-%d") <=', $tdata);

		if (!empty($mobile_no)) {
			$fields = $this->db->getFieldNames('donation');
			if (in_array('mobile', $fields))
				$donation_query->where('donation.mobile', $mobile_no);
			elseif (in_array('phone', $fields))
				$donation_query->where('donation.phone', $mobile_no);
			elseif (in_array('contact', $fields))
				$donation_query->where('donation.contact', $mobile_no);
		}

		$donation_result = $donation_query->get();
		$donation_datas = ($donation_result !== false) ? $donation_result->getResultArray() : [];

		$array_donation = [];
		foreach ($donation_datas as $d) {
			$array_donation[] = [
				'type' => 'Cash Donation',
				'name' => $d['name'],
				'ic_no' => '',
				'mobile_no' => '',
				'email_id' => '',
				'date' => $d['date'],
				'amount' => $d['amount'],
			];
		}

		/* ---------- Ubayam ---------- */
		$ubayam_query = $this->db->table('ubayam')
			->select('ubayam.name, ubayam.mobile, ubayam.email, ubayam.dt, ubayam.paidamount, ubayam.ic_number')
			->where('ubayam.paidamount >=', $ubayam_courtesy_grace_amount)
			->where('DATE_FORMAT(ubayam.dt,"%Y-%m-%d") >=', $fdata)
			->where('DATE_FORMAT(ubayam.dt,"%Y-%m-%d") <=', $tdata);

		if (!empty($mobile_no)) {
			$ubayam_query->where('ubayam.mobile', $mobile_no);
		}

		$ubayam_result = $ubayam_query->get();
		$ubayam_datas = ($ubayam_result !== false) ? $ubayam_result->getResultArray() : [];

		$array_ubayam = [];
		foreach ($ubayam_datas as $u) {
			$array_ubayam[] = [
				'type' => 'Ubayam',
				'name' => $u['name'],
				'ic_no' => $u['ic_number'] ?? '',
				'mobile_no' => $u['mobile'] ?? '',
				'email_id' => $u['email'] ?? '',
				'date' => $u['dt'],
				'amount' => $u['paidamount'],
			];
		}

		if ($type == "1")
			$return_data = $array_donation;
		elseif ($type == "2")
			$return_data = $array_ubayam;
		else
			$return_data = array_merge($array_donation, $array_ubayam);

		$data['list'] = $return_data;

		/* ---------- PDF ---------- */
		if (!empty($_REQUEST['pdf_courtesyreport']) && $_REQUEST['pdf_courtesyreport'] == "PDF") {
			$file_name = "Courtesy_Report_" . $fdata . "_to_" . $tdata;
			$dompdf = new \Dompdf\Dompdf();
			$options = $dompdf->getOptions();
			$options->set(['isRemoteEnabled' => true]);
			$dompdf->setOptions($options);
			$dompdf->loadHtml(view('report/pdf/courtesy_print', ['pdfdata' => $data]));
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$dompdf->stream($file_name);

			/* ---------- Excel ---------- */
		} elseif (!empty($_REQUEST['excel_courtesyreport']) && $_REQUEST['excel_courtesyreport'] == "EXCEL") {
			$fileName = "Courtesy_Report_" . $fdata . "_to_" . $tdata;
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();
			$sheet->getStyle('A1')->getFont()->setBold(true)->setName('Arial')->setSize(10);
			$style = ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]];
			$sheet->getStyle("A1:G1")->applyFromArray($style);
			$sheet->mergeCells('A1:G1');
			$sheet->setCellValue('A1', $_SESSION['site_title']);
			$sheet->setCellValue('A2', 'S.No');
			$sheet->setCellValue('B2', 'Type');
			$sheet->setCellValue('C2', 'Date');
			$sheet->setCellValue('D2', 'Name');
			$sheet->setCellValue('E2', 'Mobile No');
			$sheet->setCellValue('F2', 'Email');
			$sheet->setCellValue('G2', 'Amount');
			$rows = 3;
			$si = 1;
			foreach ($data['list'] as $val) {
				$sheet->setCellValue('A' . $rows, $si++);
				$sheet->setCellValue('B' . $rows, $val['type']);
				$sheet->setCellValue('C' . $rows, date('d-m-Y', strtotime($val['date'])));
				$sheet->setCellValue('D' . $rows, $val['name']);
				$sheet->setCellValue('E' . $rows, $val['mobile_no'] ?: 'N/A');
				$sheet->setCellValue('F' . $rows, $val['email_id'] ?: 'N/A');
				$sheet->setCellValue('G' . $rows, number_format($val['amount'], 2));
				$rows++;
			}
			$writer = new Xlsx($spreadsheet);
			$writer->save('uploads/excel/' . $fileName . '.xlsx');
			return $this->response->download('uploads/excel/' . $fileName . '.xlsx', null)->setFileName($fileName . '.xlsx');

			/* ---------- Print (window.print) ---------- */
		} else {
			echo view('report/courtesy_print', $data);
		}
	}
}