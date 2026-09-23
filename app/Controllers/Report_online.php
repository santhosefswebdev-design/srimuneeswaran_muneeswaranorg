<?php

namespace App\Controllers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Controllers\BaseController;
use App\Models\PermissionModel;
use Dompdf\Options;
use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class Report_online extends BaseController
{
	function __construct()
	{
		parent::__construct();
		helper('url');
		helper('common_helper');
		$this->model = new PermissionModel();
		if (($this->session->get('log_id_frend')) == false) {
			$data['dn_msg'] = 'Please Login';
			header('Location: ' . base_url() . '/member_login');
			exit;
		}
	}

	public function log()
	{

		if (!empty($_POST['fdt']))
			$from_date = $_POST['fdt'];
		else
			$from_date = date('Y-m-01');

		if (!empty($_POST['tdt']))
			$to_date = $_POST['tdt'];
		else
			$to_date = date('Y-m-d');

		$data['list'] = $this->db->table('log_paymode_change as lpc')
			->select('lpc.*,')
			->where('lpc.date >=', $from_date)
			->where('lpc.date <=', $to_date)
			->orderBy('lpc.id', 'desc')
			->get()
			->getResultArray();

		$data['from_date'] = $from_date;
		$data['to_date'] = $to_date;

		echo view('frontend/layout/header');
		echo view('frontend/report/log', $data);
	}

	public function archanai_report()
	{

		if (!empty($_POST['fdt']))
			$from_date = $_POST['fdt'];
		else
			$from_date = date('Y-m-01');

		if (!empty($_POST['tdt']))
			$to_date = $_POST['tdt'];
		else
			$to_date = date('Y-m-d');

		$data['payment_modes'] = $this->db->table('payment_mode')->where('status', 1)->where('paid_through', 'COUNTER')->get()->getResultArray();
		$data['from_date'] = $from_date;
		$data['to_date'] = $to_date;

		echo view('frontend/layout/header');
		echo view('frontend/report/archanai_report', $data);
	}

	public function archanai_rep_ref()
	{

		$fdt = date('Y-m-d', strtotime($_POST['fdt']));
		$tdt = date('Y-m-d', strtotime($_POST['tdt']));

		$data = [];
		$dat = $this->db->table('archanai_booking as ab')
			->join('archanai_payment_gateway_datas as apgd', 'apgd.archanai_booking_id = ab.id')
			->select('ab.*, apgd.pay_method')
			->where('DATE_FORMAT(ab.date, "%Y-%m-%d") >=', $fdt);
		$dat = $dat->where('DATE_FORMAT(ab.date, "%Y-%m-%d") <=', $tdt);

		$dat = $dat->orderBy('ab.id', 'desc');
		$dat = $dat->get()->getResultArray();
		$print = "";

		$i = 1;
		foreach ($dat as $row) {

			//$action = '<a class="btn btn-warning btn-payment btn-rad" title="Pay" href=" ' .base_url(). '/annathanam_new/payment/' . $aname['id']. '" target="_blank"><i class="fa fa-credit-card"></i> </a>';

			$data[] = array(
				$i++,
				date('d-m-Y', strtotime($row['date'])),
				$row['ref_no'],
				$row['amount'],
				$row['pay_method'],
				$print = '<a class="btn btn-warning btn-rad" title="Print" href="' . base_url() . '/archanai_booking/print_booking/' . $row['id'] . '" target="_blank"><i class="fa fa-print"></i> </a>     <a class="btn btn-warning btn-payment btn-rad" title="Payment Mode" href=" ' . base_url() . '/annathanam_new/payment/' . $row['id'] . '" target="_blank"><i class="fa fa-credit-card"></i> </a>',

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

	public function get_archanai_payment_mode()
	{

		$id = $_POST['id'];
		$res = $this->db->table("archanai_booking")->where("id", $id)->get()->getRowArray();
		$data['amt'] = $res['amount'];
		$data['ref_no'] = $res['ref_no'];

		$res1 = $this->db->table("archanai_payment_gateway_datas")->select('pay_method')->where("archanai_booking_id", $id)->get()->getRowArray();
		$data['pay_method'] = $pay_method = $res1['pay_method'];
		$query = "SELECT id FROM payment_mode WHERE LOWER(REPLACE(REPLACE(REPLACE(name, ' ', ''), '_', ''), '-', '')) = LOWER(REPLACE(REPLACE(REPLACE(?, ' ', ''), '_', ''), '-', '')) AND paid_through = 'COUNTER' ";
		$result = $this->db->query($query, [$pay_method])->getRowArray();
		$data['payment_mode'] = $result['id'];

		echo json_encode($data);
	}

	public function save_archanai_payment_mode_old()
	{

		$date = $_POST['date'];
		$oldPayModeId = $_POST['old_paymode'];
		$oldPayMethod = $_POST['old_paymethod'];
		$newPayModeId = $_POST['payment_mode'];
		$bookingId = $_POST['booking_id'];
		$amount = $_POST['amount'];

		$payMode = $this->db->table('payment_mode')->select('name')->where('id', $newPayModeId)->get()->getRowArray();

		if (empty($payMode) || !isset($payMode['name'])) {
			echo json_encode(['status' => false, 'message' => 'Invalid new payment mode selected.']);
			return;
		}

		if ($payMode['name'] == "Cash") {
			$newPayMethodName = "cash";
		} elseif ($payMode['name'] == "Online") {
			$newPayMethodName = "online";
		} elseif ($payMode['name'] == "Nets Pay") {
			$newPayMethodName = "nets_pay";
		} elseif ($payMode['name'] == "Pay Now") {
			$newPayMethodName = "pay_now";
		} elseif ($payMode['name'] == "Cheque") {
			$newPayMethodName = "cheque";
		}

		$updatePaymentMethod = $this->db->table("archanai_payment_gateway_datas")->where('archanai_booking_id', $bookingId)->update(['pay_method' => $newPayMethodName]);

		$entry = $this->db->table("entries")->select('id')->where('type', 3)->where('inv_id', $bookingId)->get()->getRowArray();
		$entryItem = $this->db->table("entryitems")->where('entry_id', $entry['id'])->where('dc', 'D')->update(['ledger_id' => $newPayModeId]);

		$logData = [
			'type' => 1,
			'date' => date('Y-m-d'),
			'amount' => $amount,
			'old_pay_id' => $oldPayModeId,
			'old_pay_method' => $oldPayMethod,
			'new_pay_id' => $newPayModeId,
			'new_pay_method' => $newPayMethodName,
			'booking_id' => $bookingId,
			'entryitems_id' => $entryItem['id']
		];

		$logEntry = $this->db->table("log_paymode_change")->insert($logData);

		if ($logEntry) {
			echo json_encode(['status' => true, 'message' => 'Payment Mode Changed successfully.']);
		} else {
			echo json_encode(['status' => false, 'message' => 'Failed to log payment mode change.']);
		}
	}

	public function save_archanai_payment_mode()
	{

		if (!empty($_POST['booking_id']) && !empty($_POST['payment_mode'])) {

			$newPayModeId = $_POST['payment_mode'];
			$bookingId = $_POST['booking_id'];
			$bookings = $this->db->table('archanai_booking')->where('id', $bookingId)->get()->getRowArray();
			$gateway_data = $this->db->table('archanai_payment_gateway_datas')->where('archanai_booking_id', $bookingId)->get()->getRowArray();
			if (!empty($gateway_data['id'])) {

				$new_payMode = $this->db->table('payment_mode')->where('id', $newPayModeId)->get()->getRowArray();
				$old_payMode = $this->db->table('payment_mode')->where('id', $gateway_data['payment_mode'])->get()->getRowArray();

				if (!empty($old_payMode['ledger_id'])) {
					if (!empty($new_payMode['ledger_id'])) {

						$old_ledgers = $this->db->table('ledgers')->where('id', $old_payMode['ledger_id'])->get()->getRowArray();
						$new_ledgers = $this->db->table('ledgers')->where('id', $new_payMode['ledger_id'])->get()->getRowArray();

						if (!empty($old_ledgers['id'])) {
							if (!empty($new_ledgers['id'])) {

								$newPayMethodName = $new_payMode['name'];
								$newLedgerId = $new_ledgers['id'];

								$entry = $this->db->table("entries")->where('type', 3)->where('entrytype_id', 1)->where('inv_id', $bookingId)->get()->getRowArray();
								if (!empty($entry['id'])) {

									$entryItem = $this->db->table("entryitems")->where('entry_id', $entry['id'])->where('ledger_id', $old_ledgers['id'])->get()->getRowArray();
									if (!empty($entryItem['id'])) {

										if ($old_ledgers['reconciliation'] == 1) {
											if ($entryItem['clearancemode'] == 'CLEARED') {
												echo json_encode(['status' => false, 'message' => 'This Transaction has been Reconcialated, We cannot change this Payment Mode']);
												return;
											}
										} elseif ($old_ledgers['aging'] == 1) {
											if ($entryItem['agingmode'] == 'CLEARED') {
												echo json_encode(['status' => false, 'message' => 'Aging is done for this Transaction, We cannot change this Payment Mode']);
												return;
											}
										}

										$updatePaymentMethod = $this->db->table("archanai_payment_gateway_datas")->where('archanai_booking_id', $bookingId)->update(['pay_method' => $newPayMethodName, 'payment_mode' => $newPayModeId]);
										$entryItem = $this->db->table("entryitems")->where('entry_id', $entry['id'])->where('ledger_id', $old_ledgers['id'])->update(['ledger_id' => $newLedgerId]);

										$logData = [
											'type' => 1,
											'date' => date('Y-m-d'),
											'amount' => $bookings['amount'],
											'old_pay_id' => $old_payMode['id'],
											'old_pay_method' => $old_payMode['name'],
											'new_pay_id' => $newPayModeId,
											'new_pay_method' => $newPayMethodName,
											'booking_id' => $bookingId,
											'entryitems_id' => $entryItem['id']
										];
										$logEntry = $this->db->table("log_paymode_change")->insert($logData);

										if ($logEntry) {
											echo json_encode(['status' => true, 'message' => 'Payment Mode Changed successfully.']);
										} else {
											echo json_encode(['status' => false, 'message' => 'Failed to change Payment mode.']);
										}
									} else {
										echo json_encode(['status' => false, 'message' => 'Entryitems not found for this transaction']);
									}
								} else {
									echo json_encode(['status' => false, 'message' => 'Entry not found for this transaction']);
								}
							} else {
								echo json_encode(['status' => false, 'message' => 'Invalid New Ledger Id']);
							}
						} else {
							echo json_encode(['status' => false, 'message' => 'Invalid Old Ledger Id']);
						}
					} else {
						echo json_encode(['status' => false, 'message' => 'Invalid New Payment Mode']);
					}
				} else {
					echo json_encode(['status' => false, 'message' => 'Invalid Old Payment Mode.']);
				}
			} else {
				echo json_encode(['status' => false, 'message' => 'Booking details not found']);
			}
		} else {
			echo json_encode(['status' => false, 'message' => 'Invalid Details.']);
		}
		exit;
	}

	public function print_archanai_report()
	{

		$data['fdate'] = $_REQUEST['fdt'];
		$data['tdate'] = $_REQUEST['tdt'];

		$tmpid = 1;
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
		if ($_REQUEST['pdf_archanaireport'] == "PDF") {

			$file_name = "Archanai_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$dompdf = new \Dompdf\Dompdf();
			$options = $dompdf->getOptions();
			$options->set(array('isRemoteEnabled' => true));
			$dompdf->setOptions($options);
			$dompdf->loadHtml(view('frontend/report/pdf/archanai_print', ["pdfdata" => $data]));
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$dompdf->stream($file_name);
		} elseif ($_REQUEST['excel_archanaireport'] == "EXCEL") {
			$fileName = "Archanai_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
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
			$sheet->setCellValue('A1', $data['temp_details']['name']);
			$sheet->setCellValue('A2', 'S.No');
			$sheet->setCellValue('B2', 'Date');
			$sheet->setCellValue('C2', 'Invoice No');
			$sheet->setCellValue('D2', 'Amount');
			$rows = 3;
			$si = 1;
			$excel_format_data = $this->excel_format_get_archanai_report($data['fdate'], $data['tdate']);
			// var_dump($excel_format_data);
			// exit;
			foreach ($excel_format_data as $val) {
				$sheet->setCellValue('A' . $rows, $val['s_no']);
				$sheet->setCellValue('B' . $rows, $val['date']);
				$sheet->setCellValue('C' . $rows, $val['ref_no']);
				$sheet->setCellValue('D' . $rows, $val['amount']);
				$rows++;
				$si++;
			}
			$writer = new Xlsx($spreadsheet);
			$writer->save('uploads/excel/' . $fileName . '.xlsx');
			return $this->response->download('uploads/excel/' . $fileName . '.xlsx', null)->setFileName($fileName . '.xlsx');
		} else {
			echo view('frontend/report/print/archanai_print', $data);
		}
	}

	public function excel_format_get_archanai_report($fdata, $tdata)
	{
		$fdt = date('Y-m-d', strtotime($fdata));
		$tdt = date('Y-m-d', strtotime($tdata));

		$data = [];
		$dat = $this->db->table('archanai_booking')
			->select('archanai_booking.*')
			->where('DATE_FORMAT(archanai_booking.date, "%Y-%m-%d") >=', $fdt);
		$dat = $dat->where('DATE_FORMAT(archanai_booking.date, "%Y-%m-%d") <=', $tdt);

		$dat = $dat->orderBy('archanai_booking.date', 'desc');
		$dat = $dat->get()->getResultArray();

		$i = 1;
		foreach ($dat as $row) {

			$data[] = array(
				"s_no" => $i++,
				"date" => date('d-m-Y', strtotime($row['date'])),
				"ref_no" => $row['ref_no'],
				"amount" => $row['amount']
			);
		}
		return $data;
	}

	public function hall_booking_report()
	{

		if (!empty($_POST['fdt']))
			$from_date = $_POST['fdt'];
		else
			$from_date = date('Y-m-01');

		if (!empty($_POST['tdt']))
			$to_date = $_POST['tdt'];
		else
			$to_date = date('Y-m-d');

		$cdt = isset($_POST['cdt']) && !empty($_POST['cdt']) ? date('Y-m-d', strtotime($_POST['cdt'])) : null;
		$group_filter = $_POST['group_filter'];

		$builder = $this->db->table('templebooking as tb')
			->select('tb.id, tb.entry_date, tb.booking_date, tb.name, tb.amount, tb.paid_amount, tb.payment_type, bp.name as package_name,tb.booking_status')
			->join('booked_packages as bp', 'bp.booking_id = tb.id')
			->where('tb.booking_type', 1)
			->where('tb.entry_date >=', $from_date)
			->where('tb.entry_date <=', $to_date)
			->orderBy('tb.entry_date', 'DESC');

		if (!empty($cdt)) {
			$builder->where('tb.booking_date =', $cdt);
		}

		if (!empty($group_filter) && $group_filter != "0") {
			$builder->where('tb.payment_type', $group_filter);
		}

		$data['list'] = $builder->get()->getResultArray();

		$data['payment_modes'] = $this->db->table('payment_mode')->where("paid_through", "COUNTER")->where("hall_booking", 1)->where('status', 1)->orderby('menu_order', "ASC")->get()->getResultArray();
		$data['from_date'] = $from_date;
		$data['to_date'] = $to_date;
		$data['cdt'] = $cdt;
		$data['group_filter'] = $group_filter;
		// var_dump($data);
		// exit;
		echo view('frontend/layout/header');
		echo view('frontend/report/hall_booking_report', $data);
	}

	public function ubayam_report()
	{

		if (!empty($_POST['fdt']))
			$from_date = $_POST['fdt'];
		else
			$from_date = date('Y-m-01');

		if (!empty($_POST['tdt']))
			$to_date = $_POST['tdt'];
		else
			$to_date = date('Y-m-d');

		$cdt = isset($_POST['cdt']) && !empty($_POST['cdt']) ? date('Y-m-d', strtotime($_POST['cdt'])) : null;
		$group_filter = $_POST['group_filter'];

		$builder = $this->db->table('templebooking as tb')
			->select('tb.id, tb.entry_date, tb.booking_date, tb.name, tb.amount, tb.paid_amount, tb.payment_type, bp.name as package_name')
			->join('booked_packages as bp', 'bp.booking_id = tb.id')
			->where('tb.booking_type', 2)
			->where('tb.entry_date >=', $from_date)
			->where('tb.entry_date <=', $to_date)
			->orderBy('tb.entry_date', 'DESC');

		if (!empty($cdt)) {
			$builder->where('tb.booking_date =', $cdt);
		}

		if (!empty($group_filter) && $group_filter != 0) {
			$builder->where('tb.payment_type', $group_filter);
		}
		$data['list'] = $builder->get()->getResultArray();

		$data['payment_modes'] = $this->db->table('payment_mode')->where("paid_through", "COUNTER")->where("ubayam", 1)->where('status', 1)->orderby('menu_order', "ASC")->get()->getResultArray();
		$data['fdt'] = $from_date;
		$data['tdt'] = $to_date;
		$data['cdt'] = $cdt;
		// var_dump($data);
		// exit;
		echo view('frontend/layout/header');
		echo view('frontend/report/ubayam_report', $data);
	}

	public function donation_report()
	{

		if (!empty($_POST['fdt']))
			$from_date = $_POST['fdt'];
		else
			$from_date = date('Y-m-01');

		if (!empty($_POST['tdt']))
			$to_date = $_POST['tdt'];
		else
			$to_date = date('Y-m-d');

		$data['list'] = $this->db->table('donation')
			->select('donation.*, , donation.mobile_code, donation.mobile_no,donation_category.name as type_name')
			->join('donation_category', 'donation_category.id = donation.pay_for', 'left')
			->orderBy('donation.id', 'desc')
			->where('donation.date >=', $from_date)
			->where('donation.date <=', $to_date)
			->get()
			->getResultArray();
		foreach ($data['list'] as &$item) {
			$item['mobile_display'] = '-';
			if (!empty($item['mobile_no'])) {
				$mobile_code = !empty($item['mobile_code']) ? $item['mobile_code'] : '';
				$item['mobile_display'] = $mobile_code . ' ' . $item['mobile_no'];
			}
		}
		$data['payment_modes'] = $this->db->table('payment_mode')->where('status', 1)->where('paid_through', 'COUNTER')->get()->getResultArray();
		$data['from_date'] = $from_date;
		$data['to_date'] = $to_date;
		$data['dons_set'] = $this->db->table('donation_setting')->get()->getResultArray();
		$data['dons_name'] = $this->db->table('donation')->groupby('name')->get()->getResultArray();
		echo view('frontend/layout/header');
		echo view('frontend/report/donation_report', $data);
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
			->join('donation_payment_gateway_datas as dpgd', 'dpgd.donation_booking_id = donation.id')
			->select('donation_setting.name as pname, dpgd.pay_method')
			->select('donation.*, donation.description,donation.mobile_code, donation.mobile_no,donation.ref_no')
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

			$mobile_display = '-';
			if (!empty($row['mobile_no'])) {
				$mobile_code = !empty($row['mobile_code']) ? $row['mobile_code'] : '';
				$mobile_display = $mobile_code . ' ' . $row['mobile_no'];
			}
			$data[] = array(
				$i++,
				date('d-m-Y', strtotime($row['date'])),
				$row['ref_no'] ?? '-',
				$row['pname'],
				$row['name'],
				$mobile_display,
				number_format($row['amount'], '2', '.', ','),
				$row['pay_method'],
				$row['description'],
				$print = '<a class="btn btn-warning btn-rad" title="Print" href="' . base_url() . '/donation_online/print_booking/' . $row['id'] . '" target="_blank"><i class="fa fa-print"></i> </a>     <a class="btn btn-warning btn-payment btn-rad" title="Payment Mode" href=" ' . base_url() . '/annathanam_new/payment/' . $row['id'] . '" target="_blank"><i class="fa fa-credit-card"></i> </a>',
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

	public function get_donation_payment_mode()
	{

		$id = $_POST['id'];

		$res1 = $this->db->table("donation_payment_gateway_datas")->select('pay_method')->where("donation_booking_id", $id)->get()->getRowArray();
		$data['pay_method'] = $pay_method = $res1['pay_method'];
		$query = "SELECT id FROM payment_mode WHERE LOWER(REPLACE(REPLACE(REPLACE(name, ' ', ''), '_', ''), '-', '')) = LOWER(REPLACE(REPLACE(REPLACE(?, ' ', ''), '_', ''), '-', '')) AND paid_through = 'COUNTER' ";
		$result = $this->db->query($query, [$pay_method])->getRowArray();
		$data['payment_mode'] = $result['id'];

		echo json_encode($data);
	}

	public function save_donation_payment_mode()
	{
		if (!empty($_POST['booking_id']) && !empty($_POST['payment_mode'])) {

			$newPayModeId = $_POST['payment_mode'];
			$bookingId = $_POST['booking_id'];

			$bookings = $this->db->table('donation')->where('id', $bookingId)->get()->getRowArray();
			$gateway_data = $this->db->table('donation_payment_gateway_datas')->where('donation_booking_id', $bookingId)->get()->getRowArray();
			if (!empty($gateway_data['id'])) {

				$new_payMode = $this->db->table('payment_mode')->where('id', $newPayModeId)->get()->getRowArray();
				$old_payMode = $this->db->table('payment_mode')->where('id', $bookings['payment_mode'])->get()->getRowArray();

				if (!empty($old_payMode['ledger_id'])) {
					if (!empty($new_payMode['ledger_id'])) {

						$old_ledgers = $this->db->table('ledgers')->where('id', $old_payMode['ledger_id'])->get()->getRowArray();
						$new_ledgers = $this->db->table('ledgers')->where('id', $new_payMode['ledger_id'])->get()->getRowArray();

						if (!empty($old_ledgers['id'])) {
							if (!empty($new_ledgers['id'])) {

								$newPayMethodName = $new_payMode['name'];
								$newLedgerId = $new_ledgers['id'];

								$entry = $this->db->table("entries")->where('type', 2)->where('entrytype_id', 1)->where('inv_id', $bookingId)->get()->getRowArray();
								if (!empty($entry['id'])) {

									$entryItem = $this->db->table("entryitems")->where('entry_id', $entry['id'])->where('ledger_id', $old_ledgers['id'])->get()->getRowArray();
									if (!empty($entryItem['id'])) {

										if ($old_ledgers['reconciliation'] == 1) {
											if ($entryItem['clearancemode'] == 'CLEARED') {
												echo json_encode(['status' => false, 'message' => 'This Transaction has been Reconcialated, We cannot change this Payment Mode']);
												return;
											}
										} elseif ($old_ledgers['aging'] == 1) {
											if ($entryItem['agingmode'] == 'CLEARED') {
												echo json_encode(['status' => false, 'message' => 'Aging is done for this Transaction, We cannot change this Payment Mode']);
												return;
											}
										}
										$updatebookingtable = $this->db->table("donation")->where('id', $bookingId)->update(['payment_mode' => $newPayModeId]);
										$updatePaymentMethod = $this->db->table("donation_payment_gateway_datas")->where('donation_booking_id', $bookingId)->update(['pay_method' => $newPayMethodName]);
										$entryItem = $this->db->table("entryitems")->where('entry_id', $entry['id'])->where('ledger_id', $old_ledgers['id'])->update(['ledger_id' => $newLedgerId]);

										$logData = [
											'type' => 2,
											'date' => date('Y-m-d'),
											'amount' => $bookings['amount'],
											'old_pay_id' => $old_payMode['id'],
											'old_pay_method' => $old_payMode['name'],
											'new_pay_id' => $newPayModeId,
											'new_pay_method' => $newPayMethodName,
											'booking_id' => $bookingId,
											'entryitems_id' => $entryItem['id']
										];
										$logEntry = $this->db->table("log_paymode_change")->insert($logData);

										if ($logEntry) {
											echo json_encode(['status' => true, 'message' => 'Payment Mode Changed successfully.']);
										} else {
											echo json_encode(['status' => false, 'message' => 'Failed to change Payment mode.']);
										}
									} else {
										echo json_encode(['status' => false, 'message' => 'Entryitems not found for this transaction']);
									}
								} else {
									echo json_encode(['status' => false, 'message' => 'Entry not found for this transaction']);
								}
							} else {
								echo json_encode(['status' => false, 'message' => 'Invalid New Ledger Id']);
							}
						} else {
							echo json_encode(['status' => false, 'message' => 'Invalid Old Ledger Id']);
						}
					} else {
						echo json_encode(['status' => false, 'message' => 'Invalid New Payment Mode']);
					}
				} else {
					echo json_encode(['status' => false, 'message' => 'Invalid Old Payment Mode.']);
				}
			} else {
				echo json_encode(['status' => false, 'message' => 'Booking details not found']);
			}
		} else {
			echo json_encode(['status' => false, 'message' => 'Invalid Details.']);
		}
		exit;
	}

	public function print_cashreport()
	{
		$data['fdate'] = $_REQUEST['fdt'];
		$data['tdate'] = $_REQUEST['tdt'];
		$data['payfor'] = $_REQUEST['payfor'];
		$data['fltername'] = $_REQUEST['fltername'];
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();

		if (isset($_REQUEST['pdf_cashdonationreport']) && $_REQUEST['pdf_cashdonationreport'] == "PDF") {
			$file_name = "Cash_Donation_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$dompdf = new \Dompdf\Dompdf();
			$options = $dompdf->getOptions();
			$options->set(array('isRemoteEnabled' => true));
			$dompdf->setOptions($options);
			$dompdf->loadHtml(view('frontend/report/pdf/cashdonation_print', ["pdfdata" => $data]));
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$dompdf->stream($file_name);
		} elseif (isset($_REQUEST['excel_cashdonationreport']) && $_REQUEST['excel_cashdonationreport'] == "EXCEL") {
			$fileName = "Cash_Donation_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
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
			$sheet->setCellValue('A1', $data['temp_details']['name']);

			// Add donation setting info if payfor is selected
			if ($_REQUEST['payfor']) {
				$res_don_set = $this->db->table('donation_setting ds')
					->join('donation d', 'ds.id = d.pay_for', 'left')
					->select('max(ds.amount) as total_amount')
					->select('COALESCE(sum(d.amount), 0) as collected_amount')
					->where(['ds.id' => $_REQUEST['payfor']])
					->get()
					->getRowArray();

				$balance_amount = $res_don_set['total_amount'] - $res_don_set['collected_amount'];
				if ($balance_amount >= 0) {
					$re_balance_amount = $balance_amount;
				} else {
					$re_balance_amount = 0;
				}

				$sheet->setCellValue('A2', '');
				$sheet->setCellValue('B2', 'Target Amount : ' . number_format($res_don_set['total_amount'], 2, '.', ','));
				$sheet->setCellValue('C2', 'Collected Amount : ' . number_format($res_don_set['collected_amount'], 2, '.', ','));
				$sheet->setCellValue('D2', 'Balance Amount : ' . number_format($re_balance_amount, 2, '.', ','));
				$sheet->setCellValue('E2', '');

				$headerRow = 3;
			} else {
				$headerRow = 2;
			}

			// Set column headers
			$sheet->setCellValue('A' . $headerRow, 'S.No');
			$sheet->setCellValue('B' . $headerRow, 'Date');
			$sheet->setCellValue('C' . $headerRow, 'Ref No');
			$sheet->setCellValue('D' . $headerRow, 'Pay for');
			$sheet->setCellValue('E' . $headerRow, 'Name');
			$sheet->setCellValue('F' . $headerRow, 'Amount');
			$sheet->setCellValue('G' . $headerRow, 'Payment Method');
			$sheet->setCellValue('H' . $headerRow, 'Remarks');

			$rows = $headerRow + 1;
			$si = 1;
			$totalAmount = 0;

			$excel_format_data = $this->excel_format_get_cashdonationreport(
				$data['fdate'],
				$data['tdate'],
				$data['payfor'],
				$data['fltername']
			);

			// Set number format for Amount column
			$sheet->getStyle('F' . $rows . ':F' . ($rows + count($excel_format_data)))
				->getNumberFormat()
				->setFormatCode('#,##0.00');

			foreach ($excel_format_data as $val) {
				$sheet->setCellValue('A' . $rows, $val['s_no']);
				$sheet->setCellValue('B' . $rows, $val['date']);
				$sheet->setCellValue('C' . $rows, $val['ref_no']);
				$sheet->setCellValue('D' . $rows, $val['pname']);
				$sheet->setCellValue('E' . $rows, $val['name']);
				$sheet->setCellValue('F' . $rows, $val['amount']);
				$sheet->setCellValue('G' . $rows, $val['pay_method']);
				$sheet->setCellValue('H' . $rows, $val['description']);
				$totalAmount += $val['amount'];
				$rows++;
				$si++;
			}

			// Add Total row
			$sheet->setCellValue('E' . $rows, 'Total');
			$sheet->setCellValue('F' . $rows, $totalAmount);

			$sheet->getStyle('F' . $rows)
				->getNumberFormat()
				->setFormatCode('#,##0.00');

			// Make total row bold
			$sheet->getStyle('E' . $rows . ':F' . $rows)->getFont()->setBold(true);

			// Auto-size columns
			foreach (range('A', 'H') as $col) {
				$sheet->getColumnDimension($col)->setAutoSize(true);
			}

			$writer = new Xlsx($spreadsheet);
			$writer->save('uploads/excel/' . $fileName . '.xlsx');
			return $this->response->download('uploads/excel/' . $fileName . '.xlsx', null)->setFileName($fileName . '.xlsx');
		} else {
			echo view('frontend/report/print/cashdonation_print', $data);
		}
	}

	public function excel_format_get_cashdonationreport($fdata, $tdata, $payfor, $name)
	{
		$fdt = date('Y-m-d', strtotime($fdata));
		$tdt = date('Y-m-d', strtotime($tdata));
		$payforg = $payfor;
		$nameg = $name;
		$data = [];

		$dat = $this->db->table('donation')
			->join('donation_setting', 'donation_setting.id = donation.pay_for')
			->join('donation_payment_gateway_datas as dpgd', 'dpgd.donation_booking_id = donation.id')
			->select('donation_setting.name as pname, dpgd.pay_method')
			->select('donation.*, donation.description, donation.ref_no')
			->where('donation.date>=', $fdt)
			->where('donation.date<=', $tdt);

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
				"ref_no" => $row['ref_no'] ?? '-',
				"pname" => $row['pname'],
				"name" => $row['name'],
				"amount" => $row['amount'],
				"pay_method" => $row['pay_method'] ?? '-',
				"description" => $row['description'] ?? '-'
			);
		}
		return $data;
	}

	public function annathanam_report()
	{
		if (!empty($_POST['fdt']))
			$from_date = $_POST['fdt'];
		else
			$from_date = date('Y-m-01');

		if (!empty($_POST['tdt']))
			$to_date = $_POST['tdt'];
		else
			$to_date = date('Y-m-d');

		$data['list'] = $this->db->table('annathanam_new')
			->select('annathanam_new.*, annathanam_packages.name_eng, annathanam_packages.name_tamil')
			->join('annathanam_packages', 'annathanam_packages.id = annathanam_new.package_id', 'left')
			->orderBy('annathanam_new.id', 'desc')
			->where('annathanam_new.date >=', $from_date)
			->where('annathanam_new.date <=', $to_date)
			->where('annathanam_new.booking_status !=', 3)
			->get()
			->getResultArray();
		$data['payment_modes'] = $this->db->table('payment_mode')->where("paid_through", "COUNTER")->where("annathanam", 1)->where('status', 1)->orderby('menu_order', "ASC")->get()->getResultArray();
		$data['from_date'] = $from_date;
		$data['to_date'] = $to_date;
		echo view('frontend/layout/header');
		echo view('frontend/report/annathanam_report', $data);
	}

	public function annathanam_rep_ref()
	{
		$fdt = date('Y-m-d', strtotime($_POST['fdt']));
		$tdt = date('Y-m-d', strtotime($_POST['tdt']));
		$group_filter = isset($_POST['group_filter']) ? $_POST['group_filter'] : '';

		$data = [];

		$qry = $this->db->table('annathanam_new')
			->select('annathanam_new.*, annathanam_new.phone_code, annathanam_new.phone_no, annathanam_packages.name_eng, annathanam_packages.name_tamil')
			->join('annathanam_packages', 'annathanam_packages.id = annathanam_new.package_id', 'left')
			->where('annathanam_new.date >=', $fdt)
			->where('annathanam_new.date <=', $tdt)
			->where('annathanam_new.booking_status !=', 3);

		// Apply group filter if set
		if (!empty($group_filter) && $group_filter != "0") {
			if ($group_filter === 'full') {
				$qry = $qry->where('annathanam_new.total_amount = annathanam_new.paid_amount');
			} elseif ($group_filter === 'partial') {
				$qry = $qry->where('annathanam_new.paid_amount > 0')
					->where('annathanam_new.paid_amount < annathanam_new.total_amount');
			} elseif ($group_filter === 'only_booked') {
				$qry = $qry->where('annathanam_new.paid_amount', 0);
			}
		}

		$qry = $qry->orderBy('annathanam_new.id', 'desc')
			->get()
			->getResultArray();

		$print = "";
		$i = 1;

		foreach ($qry as $row) {
			$balance_amount = (float) $row['total_amount'] - (float) $row['paid_amount'];
			if ($balance_amount < 0) {
				$balance_amount = 0;
			}

			// Status text
			if ($row['booking_status'] == 3) {
				$txt = '<span class="cancel_text">Cancelled</span>';
			} else {
				if (empty($balance_amount)) {
					$txt = '<span class="paid_text">Paid</span>';
				} else {
					$txt = '<span class="unpaid_text">Partially Paid</span>';
				}
			}

			// Print/Payment buttons
			if ($row['payment_status'] == 1 && $row['booking_status'] == 1) {
				$print = '<a class="btn btn-primary btn-rad" href="' . base_url() . '/annathanam_counter/print_annathanam/' . $row['id'] . '" target="_blank"><i class="fa fa-print"></i> </a>  <a class="btn btn-warning btn-payment btn-rad" title="Pay" data-id="' . $row['id'] . '"><i class="fa fa-credit-card"></i></a>';
			} else if ($row['payment_status'] == 2 || $row['booking_status'] == 2 || $row['booking_status'] == 3) {
				$print = '<a class="btn btn-primary btn-rad" href="' . base_url() . '/annathanam_counter/print_annathanam/' . $row['id'] . '" target="_blank"><i class="fa fa-print"></i> </a>';
			} else {
				$print = "";
			}

			// Cancel button
			if ($row['booking_status'] != 3) {
				$action = '<a class="btn btn-danger btn-cancel btn-rad" title="Cancel" data-id="' . $row['id'] . '"><i class="fa fa-times"></i> </a>';
			} else {
				$action = "";
			}

			// Combine phone code and phone number
			$phone_display = '-';
			if (!empty($row['phone_no'])) {
				$phone_code = !empty($row['phone_code']) ? $row['phone_code'] : '';
				$phone_display = $phone_code . ' ' . $row['phone_no'];
			}

			// Package name
			$package_name = '-';
			if (!empty($row['name_eng']) || !empty($row['name_tamil'])) {
				$package_name = $row['name_eng'] . '/' . $row['name_tamil'];
			}

			$data[] = array(
				$i++,
				date('d-m-Y', strtotime($row['date'])),
				$row['ref_no'],
				$row['name'],
				$phone_display,
				$package_name,
				$txt,
				number_format($row['total_amount'], 2, '.', ','),
				number_format($row['paid_amount'], 2, '.', ','),
				$print,
				$action
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

	public function print_annathanam_report()
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
			$dompdf->loadHtml(view('frontend/report/pdf/annathanam_print', ["pdfdata" => $data]));
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
			$sheet->setCellValue('F2', 'Amount');
			// $sheet->setCellValue('G2', 'No of Pax');
			$rows = 3;
			$si = 1;
			$excel_format_data = $this->excel_format_get_annathanam_report($data['fdate'], $data['tdate'], $data['group_filter']);
			//var_dump($excel_format_data);
			//exit;
			foreach ($excel_format_data as $val) {
				$sheet->setCellValue('A' . $rows, $val['s_no']);
				$sheet->setCellValue('B' . $rows, $val['date']);
				$sheet->setCellValue('C' . $rows, $val['ref_no']);
				$sheet->setCellValue('D' . $rows, $val['name']);
				$sheet->setCellValue('E' . $rows, $val['package']);
				$sheet->setCellValue('F' . $rows, $val['amount']);
				// $sheet->setCellValue('G' . $rows, $val['no_pax']);
				$rows++;
				$si++;
			}
			$writer = new Xlsx($spreadsheet);
			$writer->save('uploads/excel/' . $fileName . '.xlsx');
			return $this->response->download('uploads/excel/' . $fileName . '.xlsx', null)->setFileName($fileName . '.xlsx');
		} else {
			echo view('frontend/report/print/annathanam_print', $data);
		}
	}

	public function excel_format_get_annathanam_report($fdata, $tdata, $group_filter)
	{
		$fdt = date('Y-m-d', strtotime($fdata));
		$tdt = date('Y-m-d', strtotime($tdata));

		$data = [];

		$dat = $this->db->table('annathanam_new')
			->select('annathanam_new.*, annathanam_packages.name_eng, annathanam_packages.name_tamil')
			->join('annathanam_packages', 'annathanam_packages.id = annathanam_new.package_id', 'left')
			->orderBy('annathanam_new.id', 'desc')
			->where('annathanam_new.date >=', $fdt)
			->where('annathanam_new.date <=', $tdt)
			->where('annathanam_new.booking_status !=', 3);

		if (!empty($group_filter) && $group_filter != "0") {
			$dat = $dat->where('annathanam_new.payment_type', $group_filter);
		}

		$dat = $dat->get()->getResultArray();

		$i = 1;
		foreach ($dat as $row) {

			$data[] = array(
				"s_no" => $i++,
				"date" => date('d-m-Y', strtotime($row['date'])),
				"ref_no" => $row['ref_no'],
				"name" => $row['name'],
				"package" => $row['name_eng'] . '/' . $row['name_tamil'],
				"amount" => $row['total_amount'],
				// "no_pax" => $row['no_of_pax']
			);
		}
		return $data;
	}

	public function prasadam_report()
	{

		$from_date = !empty($_POST['fdt']) ? $_POST['fdt'] : date('Y-m-01');
		$to_date = !empty($_POST['tdt']) ? $_POST['tdt'] : date('Y-m-d');

		$group_filter = $_POST['group_filter'];
		$cdt = isset($_POST['cdt']) && !empty($_POST['cdt']) ? date('Y-m-d', strtotime($_POST['cdt'])) : null;

		$builder = $this->db->table('prasadam p')
			->select('p.id, p.date, p.customer_name, p.amount, pg.group_name, p.collection_date, p.ref_no, p.payment_type, p.paid_amount,p.mobile_no')
			->join('prasadam_group pg', 'pg.id = p.prasadam_group_id', 'left')
			->orderBy('p.id', 'desc')
			->where('p.date >=', $from_date)
			->where('p.date <=', $to_date)
			->where('p.payment_status !=', 3);

		if (!empty($cdt)) {
			$builder->where('p.collection_date =', $cdt);
		}

		if (!empty($group_filter) && $group_filter != 0) {
			$builder->where('p.prasadam_group_id', $group_filter);
		}

		$data['list'] = $builder->get()->getResultArray();

		foreach ($data['list'] as &$row) {
			$prasadam_details = $this->db->table('prasadam_booking_details')
				->where('prasadam_booking_id', $row['id'])
				->get()
				->getResultArray();

			$prasadam_list = [];
			foreach ($prasadam_details as $detail) {
				$prasadam_info = $this->db->table('prasadam_setting')
					->select('name_eng, name_tamil')
					->where('id', $detail['prasadam_id'])
					->get()
					->getRowArray();

				$prasadam_list[] = $prasadam_info['name_eng'] . ' / ' . $prasadam_info['name_tamil'] . ' - ' . $detail['quantity'];
			}
			$row['prasadam_str'] = implode('<br><br>', $prasadam_list);
		}

		$data['payment_modes'] = $this->db->table('payment_mode')
			->where('status', 1)
			->where('paid_through', 'COUNTER')
			->get()
			->getResultArray();

		$data['prasadam_groups'] = $this->db->table('prasadam_group')
			->get()
			->getResultArray();

		$data['from_date'] = $from_date;
		$data['to_date'] = $to_date;
		$data['group_filter'] = $group_filter;

		echo view('frontend/layout/header');
		echo view('frontend/report/prasadam_report', $data);
	}

	public function print_prasadamreport()
	{
		$data['fdate'] = $_REQUEST['fdt'];
		$data['tdate'] = $_REQUEST['tdt'];
		// $data['cdate'] = $_REQUEST['cdt'];
		$data['fltername'] = $_REQUEST['group_filter'];
		//$data['collection_date'] = isset($_REQUEST['cdt']) && !empty($_REQUEST['cdt']) ? date('Y-m-d', strtotime($_REQUEST['cdt'])) : null;
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
		if ($_REQUEST['pdf_prasadamreport'] == "PDF") {
			$file_name = "Prasadam_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$dompdf = new \Dompdf\Dompdf();
			$options = $dompdf->getOptions();
			$options->set(array('isRemoteEnabled' => true));
			$dompdf->setOptions($options);
			$dompdf->loadHtml(view('frontend/report/pdf/prasadam_pdf', ["pdfdata" => $data]));
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
			$sheet->getStyle("A1:F1")->applyFromArray($style);  // Changed from F1 to G1
			$sheet->mergeCells('A1:F1');  // Changed from F1 to G1
			$sheet->setCellValue('A1', $data['temp_details']['name']);
			$sheet->setCellValue('A2', 'S.No');
			$sheet->setCellValue('B2', 'Date');
			$sheet->setCellValue('C2', 'Ref No');  // NEW COLUMN
			$sheet->setCellValue('D2', 'Customer Name');  // Shifted from C
			$sheet->setCellValue('E2', 'Payfor');  // Shifted from D
			$sheet->setCellValue('F2', 'Amount');  // Shifted from E

			$rows = 3;
			$si = 1;
			$excel_format_data = $this->excel_format_get_prasadamreport($data['fdate'], $data['tdate'], $data['collection_date'], $data['fltername']);

			foreach ($excel_format_data as $val) {
				$sheet->setCellValue('A' . $rows, $val['s_no']);
				$sheet->setCellValue('B' . $rows, $val['date']);
				$sheet->setCellValue('C' . $rows, $val['ref_no']);  // NEW COLUMN
				$sheet->setCellValue('D' . $rows, $val['customer_name']);  // Shifted from C
				$sheet->setCellValue('E' . $rows, $val['collection_name']);  // Shifted from D
				$sheet->setCellValue('F' . $rows, $val['amount']);  // Shifted from E
				$rows++;
				$si++;
			}
			$writer = new Xlsx($spreadsheet);
			$writer->save('uploads/excel/' . $fileName . '.xlsx');
			return $this->response->download('uploads/excel/' . $fileName . '.xlsx', null)->setFileName($fileName . '.xlsx');
		} else {
			echo view('frontend/report/print/prasadam_print', $data);
		}
	}

	public function excel_format_get_prasadamreport($fdata, $tdata, $collectiondate, $fltername)
	{
		$fdt = date('Y-m-d', strtotime($fdata));
		$tdt = date('Y-m-d', strtotime($tdata));
		$flternameg = $fltername;
		$data = [];

		$dat = $this->db->table('prasadam p')
			->select('p.`id`, `p`.`date`, p.`customer_name`, p.`ref_no`, pg.group_name, p.`amount`')  // Added p.ref_no
			->join('prasadam_booking_details pbd', 'p.id = pbd.prasadam_booking_id', 'left')
			->join('prasadam_setting ps', 'ps.id = pbd.prasadam_id', 'left')
			->join('prasadam_setting_group psp', 'psp.prasadam_id = ps.id', 'left')
			->join('prasadam_group pg', 'pg.id = psp.prasadam_group_id', 'left')
			->where('DATE_FORMAT(p.date, "%Y-%m-%d") >=', $fdt);
		$dat = $dat->where('DATE_FORMAT(p.date, "%Y-%m-%d") <=', $tdt);

		if ($flternameg) {
			$dat = $dat->where('psp.prasadam_group_id', $flternameg);
		}

		$dat = $dat->orderBy('p.date', 'asc');
		$dat = $dat->get()->getResultArray();

		$i = 1;
		foreach ($dat as $row) {
			$payfors = $this->db->table('prasadam_booking_details')
				->join('prasadam_setting', 'prasadam_setting.id = prasadam_booking_details.prasadam_id')
				->select('prasadam_setting.name_eng, prasadam_setting.name_tamil, prasadam_booking_details.quantity')
				->where('prasadam_booking_details.prasadam_booking_id', $row['id'])
				->get()->getResultArray();

			$html = "";
			foreach ($payfors as $payfor) {
				$html .= $payfor['name_eng'] . " / " . $payfor['name_tamil'] . ' - ' . $payfor['quantity'] . '&';
			}

			$data[] = array(
				"s_no" => $i++,
				"date" => date('d-m-Y', strtotime($row['date'])),
				"ref_no" => $row['ref_no'] ?? '-',  // NEW FIELD
				"customer_name" => $row['customer_name'],
				"amount" => $row['amount'],
				"collection_name" => $html
			);
		}
		return $data;
	}
	public function prasadam_rep_ref()
	{
		$fdt = date('Y-m-d', strtotime($_POST['fdt']));
		$tdt = date('Y-m-d', strtotime($_POST['tdt']));
		$data = [];
		$dat = $this->db->table('prasadam p')
			->select('p.`id`, `p`.`date`, p.`customer_name`, pg.group_name, p.`amount`, p.`ref_no`, p.`payment_status`, p.payment_type, p.paid_amount, ppgd.pay_method, p.booking_type,p.mobile_no')
			->join('prasadam_booking_details pbd', 'p.id = pbd.prasadam_booking_id', 'left')
			->join('prasadam_setting ps', 'ps.id = pbd.prasadam_id', 'left')
			->join('prasadam_group pg', 'pg.id = p.prasadam_group_id', 'left')
			->join('prasadam_payment_gateway_datas ppgd', 'p.id = ppgd.prasadam_id', 'left')
			->groupby('p.id')
			->where('DATE_FORMAT(p.date, "%Y-%m-%d") >=', $fdt);
		$dat = $dat->where('DATE_FORMAT(p.date, "%Y-%m-%d") <=', $tdt);
		if ($_POST['group_filter']) {
			$group_filter = trim($_POST['group_filter']);
			$dat = $dat->where('psp.prasadam_group_id', $group_filter);
		}
		$dat = $dat->orderBy('p.id', 'desc');
		$dat = $dat->get()->getResultArray();

		$i = 1;
		foreach ($dat as $row) {
			$payfors = $this->db->table('prasadam_booking_details')
				->join('prasadam_setting', 'prasadam_setting.id = prasadam_booking_details.prasadam_id')
				->select('prasadam_setting.name_eng,prasadam_setting.name_tamil')
				->where('prasadam_booking_details.prasadam_booking_id', $row['id'])
				->get()->getResultArray();

			$html = "";
			foreach ($payfors as $payfor) {
				$html .= "&#x2022; " . $payfor['name_eng'] . " / " . $payfor['name_tamil'] . "<br>";
			}

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

			$print = '<a class="btn btn-warning btn-rad" title="Print" href="' . base_url() . '/prasadam_online/print_booking_report/' . $row['id'] . '" target="_blank"><i class="fa fa-print"></i> </a> <a class="btn btn-success btn-rad" title="Print" href="' . base_url() . '/prasadam_online/print_booking/' . $row['id'] . '" target="_blank"><i class="fa fa-print"></i> </a>';

			// CORRECTED SECTION - Using data-id and javascript:void(0)
			if ($row['payment_status'] == 1) {
				if ($balance_amount > 0) {
					$action = '<a class="btn btn-warning btn-paychange btn-rad" title="Payment Mode" href="javascript:void(0)" data-booking-id="' . $row['id'] . '"><i class="fa-solid fa-dollar-sign"></i> </a>  <a class="btn btn-primary btn-rad btn-payment" title="Repayment" href="javascript:void(0)" data-id="' . $row['id'] . '"><i class="fa fa-credit-card"></i></a>';
				} else {
					$action = '<a class="btn btn-warning btn-paychange btn-rad" title="Payment Mode" href="javascript:void(0)" data-booking-id="' . $row['id'] . '"><i class="fa-solid fa-dollar-sign"></i> </a>';
				}
			} elseif ($row['payment_status'] == 2) {
				$action = '<a class="btn btn-warning btn-paychange btn-rad" title="Payment Mode" href="javascript:void(0)" data-booking-id="' . $row['id'] . '"><i class="fa-solid fa-dollar-sign"></i> </a>';
			} else {
				$action = "";
			}

			$mobile_no = !empty($row['mobile_no']) ? $row['mobile_no'] : '-';

			if ($row['booking_type'] == 1) {
				$data[] = array(
					$i++,
					date('d-m-Y', strtotime($row['date'])),
					$row['ref_no'] ?? '-',
					$type = 'Hall Booking',
					$row['customer_name'],
					$mobile_no,
					$row['group_name'],
					"<p style='text-align: left;'>" . $html . "</p>",
					$txt = '-',
					$pay_method = '-',
					$amount = '-',
					$paid_amount = '-',
					$print = '-',
					$action = '-',
				);
			} elseif ($row['booking_type'] == 2) {
				$data[] = array(
					$i++,
					date('d-m-Y', strtotime($row['date'])),
					$row['ref_no'] ?? '-',
					$type = 'Ubayam',
					$row['customer_name'],
					$mobile_no,
					$row['group_name'],
					"<p style='text-align: left;'>" . $html . "</p>",
					$txt = '-',
					$pay_method = '-',
					$amount = '-',
					$paid_amount = '-',
					$print = '-',
					$action = '-',
				);
			} else {
				$data[] = array(
					$i++,
					date('d-m-Y', strtotime($row['date'])),
					$row['ref_no'] ?? '-',
					$type = 'prasadam',
					$row['customer_name'],
					$mobile_no,
					$row['group_name'],
					"<p style='text-align: left;'>" . $html . "</p>",
					$txt,
					$row['pay_method'],
					number_format($row['amount'], '2', '.', ','),
					number_format($row['paid_amount'], '2', '.', ','),
					$print,
					$action
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

	public function kattalai_archanai_report()
	{
		if (!empty($_POST['fdt']))
			$from_date = $_POST['fdt'];
		else
			$from_date = date('Y-m-01');

		if (!empty($_POST['tdt']))
			$to_date = $_POST['tdt'];
		else
			$to_date = date('Y-m-d');
		$group_filter = $_POST['group_filter'];

		$builder = $this->db->table('kattalai_archanai_booking as kab')
			->select('kab.id, kab.name, kab.date, kab.daytype, kab.amount, kab.paid_amount, kab.payment_type')
			//->join('booked_packages as bp', 'bp.booking_id = kab.id')
			->where('kab.date >=', $from_date)
			->where('kab.date <=', $to_date);

		if (!empty($group_filter) && $group_filter != '0') {
			$builder->where('kab.daytype', $group_filter);
		}

		$builder->orderBy('kab.date', 'DESC');

		$data['list'] = $builder->get()->getResultArray();

		$data['payment_modes'] = $this->db->table('payment_mode')->where("paid_through", "COUNTER")->where("kattalai_archanai", 1)->where('status', 1)->orderby('menu_order', "ASC")->get()->getResultArray();
		$data['from_date'] = $from_date;
		$data['to_date'] = $to_date;
		$data['group_filter'] = $group_filter;

		echo view('frontend/layout/header');
		echo view('frontend/report/kattalai_archanai_report', $data);
	}

	public function kattalai_archanai_report_ref()
	{
		if (!empty($_POST['fdt']))
			$from_date = $_POST['fdt'];
		else
			$from_date = date('Y-m-01');

		if (!empty($_POST['tdt']))
			$to_date = $_POST['tdt'];
		else
			$to_date = date('Y-m-d');
		$group_filter = $_POST['group_filter'];
		//echo $group_filter; die();

		$builder = $this->db->table('kattalai_archanai_booking as kab')
			->select('kab.id, kab.name, kab.date, kab.daytype, kab.amount, kab.paid_amount, kab.payment_type, kab.ref_no, kab.payment_status, kab.booking_status')
			->where('kab.date >=', $from_date)
			->where('kab.date <=', $to_date);

		if (!empty($group_filter) && $group_filter != '0') {
			$builder->where('kab.daytype', $group_filter);
		}
		// echo $group_filter; die();
		$builder->orderBy('kab.id', 'DESC');

		$res = $builder->get()->getResultArray();

		$data['payment_modes'] = $this->db->table('payment_mode')->where("paid_through", "COUNTER")->where("kattalai_archanai", 1)->where('status', 1)->orderby('menu_order', "ASC")->get()->getResultArray();
		$data['from_date'] = $from_date;
		$data['to_date'] = $to_date;
		$data['group_filter'] = $group_filter;

		$i = 0;
		//print_r($res);die;
		$i = 1;
		$data = array();
		if (!empty($res)) {
			foreach ($res as $aname) {

				if ($aname['daytype'] == 'daily') {
					$daytype = 'Daily';
				} elseif ($aname['daytype'] == 'weekly') {
					$daytype = 'Weekly';
				} elseif ($aname['daytype'] == 'days') {
					$daytype = 'Multiple Dates';
				} elseif ($aname['daytype'] == 'years') {
					$daytype = 'Yearly';
				}

				$balance_amount = (float) $aname['amount'] - (float) $aname['paid_amount'];
				if ($balance_amount < 0)
					$balance_amount = 0;

				if ($aname['booking_status'] == 3) {
					$txt = '<span class="cancel_text">Cancelled</span>';
				} else {

					if (empty($balance_amount)) {
						$txt = '<span class="paid_text">Paid</span>';
					} else {
						$txt = '<span class="unpaid_text">Partially Paid</span>';
					}
				}

				if ($aname['payment_status'] == 1) {
					$print = '<a class="btn btn-warning btn-rad" title="Print" href="' . base_url() . '/kattalai_archanai_online/print_booking_report/' . $aname['id'] . '" target="_blank"><i class="fa fa-print"></i> </a>  <a class="btn btn-success btn-rad" title="Print" href="' . base_url() . '/kattalai_archanai_online/print_booking/' . $aname['id'] . '" target="_blank"><i class="fa fa-print"></i> </a>  <a class="btn btn-primary btn-rad btn-payment" title="Edit" href="' . base_url() . '/report/show_loan_history/' . $aname['id'] . '"><i class="fa fa-credit-card"></i></a>';
					//$action = '<a class="btn btn-primary btn-rad btn-payment" title="Edit" href="'.base_url().'/report/show_loan_history/'.$r['staff_id'].'"><i class="material-icons">&#xE417;</i></a>';
				} else if ($aname['payment_status'] == 2) {
					$print = '<a class="btn btn-warning btn-rad" title="Print" href="' . base_url() . '/kattalai_archanai_online/print_booking_report/' . $aname['id'] . '" target="_blank"><i class="fa fa-print"></i> </a> <a class="btn btn-success btn-rad" title="Print" href="' . base_url() . '/kattalai_archanai_online/print_booking/' . $aname['id'] . '" target="_blank"><i class="fa fa-print"></i> </a>';
				} else {
					$print = "";
				}


				$data[] = array(
					$i++,
					date("d-m-Y", strtotime($aname['date'])),
					$aname['ref_no'],
					$aname['name'],
					$daytype,
					$aname['payment_type'],
					$aname['amount'],
					$aname['paid_amount'],
					$print,
					//$action
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

	public function print_kattalaireport()
	{
		$data['fdate'] = $_REQUEST['fdt'];
		$data['tdate'] = $_REQUEST['tdt'];
		if (!empty($_REQUEST['cdt'])) {
			$data['cdate'] = $_REQUEST['cdt'];
		}
		$data['group_filter'] = $_REQUEST['group_filter'];
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
		if ($_REQUEST['pdf_ubayamreport'] == "PDF") {
			$data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
			$file_name = "KattalaiArchanai_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$dompdf = new \Dompdf\Dompdf();
			$options = $dompdf->getOptions();
			$options->set(array('isRemoteEnabled' => true));
			$dompdf->setOptions($options);
			$dompdf->loadHtml(view('frontend/report/pdf/kattalai_archanai_pdf', ["pdfdata" => $data]));
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$dompdf->stream($file_name);
		} elseif ($_REQUEST['excel_ubayamreport'] == "EXCEL") {
			$fileName = "KattalaiArchanai_Report_" . $data['fdate'] . "_to_" . $data['tdate'];

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
			$sheet->setCellValue('A1', $data['temp_details']['name']);
			$sheet->setCellValue('A2', 'S.No');
			$sheet->setCellValue('B2', 'Date');
			$sheet->setCellValue('C2', 'Devotee Name');
			$sheet->setCellValue('D2', 'Types');
			$sheet->setCellValue('E2', 'Payment Type');
			$sheet->setCellValue('F2', 'Amount($)');
			// $sheet->setCellValue('F2', 'Paid');
			// $sheet->setCellValue('G2', 'Balance');
			$sheet->setCellValue('G2', 'Paid Amount($)');
			$rows = 3;
			$si = 1;
			$excel_format_data = $this->excel_format_get_kattalai($data['fdate'], $data['tdate'], $data['cdate'], $data['group_filter'], $data['booking_type']);
			//var_dump($excel_format_data);
			//exit;
			foreach ($excel_format_data as $val) {
				$sheet->setCellValue('A' . $rows, $val['s_no']);
				$sheet->setCellValue('B' . $rows, $val['date']);
				$sheet->setCellValue('C' . $rows, $val['name']);
				$sheet->setCellValue('D' . $rows, $val['daytype']);
				$sheet->setCellValue('E' . $rows, $val['payment_type']);
				$sheet->setCellValue('F' . $rows, $val['amount']);
				// $sheet->setCellValue('F' . $rows, $val['paid']);
				// $sheet->setCellValue('G' . $rows, $val['bal']);
				$sheet->setCellValue('G' . $rows, $val['paid_amount']);
				$rows++;
				$si++;
			}
			$writer = new Xlsx($spreadsheet);
			$writer->save('uploads/excel/' . $fileName . '.xlsx');
			return $this->response->download('uploads/excel/' . $fileName . '.xlsx', null)->setFileName($fileName . '.xlsx');
		} else {
			echo view('frontend/report/kattalai_archanai_print', $data);
		}
	}
	
public function kattalai_abishegam_report() {
		if (!empty($_POST['fdt'])) $from_date = $_POST['fdt'];
		else $from_date = date('Y-m-01');

		if (!empty($_POST['tdt'])) $to_date = $_POST['tdt'];
		else $to_date = date('Y-m-d');
		$group_filter = $_POST['group_filter'];

		$builder = $this->db->table('kattalai_archanai_booking as kab')
            ->select('kab.id, kab.name, kab.date, kab.daytype, kab.amount, kab.paid_amount, kab.payment_type')
            //->join('booked_packages as bp', 'bp.booking_id = kab.id')
            ->where('kab.date >=', $from_date)
            ->where('kab.date <=', $to_date)->where("kab.archanai_type_id", 3);

		if (!empty($group_filter) && $group_filter != '0') {
			$builder->where('kab.daytype', $group_filter);
		}
		
		$builder->orderBy('kab.date', 'DESC');

		$data['list'] = $builder->get()->getResultArray();

		$data['payment_modes'] = $this->db->table('payment_mode')->where("paid_through", "COUNTER")->where("kattalai_archanai", 1)->where('status', 1)->orderby('menu_order', "ASC")->get()->getResultArray();
		$data['from_date'] = $from_date;
		$data['to_date'] = $to_date;
		$data['group_filter'] = $group_filter;

		echo view('frontend/layout/header');
		echo view('frontend/report/kattalai_abishegam_report', $data);
	}
	
    public function kattalai_abishegam_report_ref() {
		if (!empty($_POST['fdt'])) $from_date = $_POST['fdt'];
		else $from_date = date('Y-m-01');

		if (!empty($_POST['tdt'])) $to_date = $_POST['tdt'];
		else $to_date = date('Y-m-d');
		$group_filter = $_POST['group_filter'];
		//echo $group_filter; die();

		$builder = $this->db->table('kattalai_archanai_booking as kab')
            ->select('kab.id, kab.name, kab.date, kab.daytype, kab.amount, kab.paid_amount, kab.payment_type, kab.ref_no, kab.payment_status, kab.booking_status')
            ->where('kab.date >=', $from_date)
            ->where('kab.date <=', $to_date)->where("kab.archanai_type_id", 3);

		if (!empty($group_filter) && $group_filter != '0') {
			$builder->where('kab.daytype', $group_filter);
		}
		// echo $group_filter; die();
		$builder->orderBy('kab.id', 'DESC');

		$res = $builder->get()->getResultArray();

		$data['payment_modes'] = $this->db->table('payment_mode')->where("paid_through", "COUNTER")->where("kattalai_archanai", 1)->where('status', 1)->orderby('menu_order', "ASC")->get()->getResultArray();
		$data['from_date'] = $from_date;
		$data['to_date'] = $to_date;
		$data['group_filter'] = $group_filter;
		
		$i = 0;
		//print_r($res);die;
		$i = 1;
		$data = array();
		if (!empty($res)) {
			foreach ($res as $aname) {

				if ($aname['daytype'] == 'daily'){
					$daytype = 'Daily';
				} elseif ($aname['daytype'] == 'weekly'){
					$daytype = 'Weekly';
				} elseif ($aname['daytype'] == 'days'){
					$daytype = 'Multiple Dates';
				} elseif ($aname['daytype'] == 'years'){
					$daytype = 'Yearly';
				}

				$balance_amount = (float) $aname['amount'] - (float) $aname['paid_amount'];
				if ($balance_amount < 0)
					$balance_amount = 0;

				if($aname['booking_status'] == 3) {
					$txt = '<span class="cancel_text">Cancelled</span>';
				}	else {

					if (empty($balance_amount)) {
						$txt = '<span class="paid_text">Paid</span>';
					} else {
						$txt = '<span class="unpaid_text">Partially Paid</span>';
					}
				}

				if($aname['payment_status'] == 1) {
					$print = '<a class="btn btn-warning btn-rad" title="Print" href="'.base_url().'/kattalai_archanai_online/print_booking_report/'. $aname['id'].'" target="_blank"><i class="fa fa-print"></i> </a>  <a class="btn btn-success btn-rad" title="Print" href="'.base_url().'/kattalai_archanai_online/print_booking/'. $aname['id'].'" target="_blank"><i class="fa fa-print"></i> </a>  <a class="btn btn-primary btn-rad btn-payment" title="Edit" href="'.base_url().'/report/show_loan_history/'.$aname['id'].'"><i class="fa fa-credit-card"></i></a>';
					//$action = '<a class="btn btn-primary btn-rad btn-payment" title="Edit" href="'.base_url().'/report/show_loan_history/'.$r['staff_id'].'"><i class="material-icons">&#xE417;</i></a>';
				}	else if($aname['payment_status'] == 2) {
					$print = '<a class="btn btn-warning btn-rad" title="Print" href="'.base_url().'/kattalai_archanai_online/print_booking_report/'. $aname['id'].'" target="_blank"><i class="fa fa-print"></i> </a> <a class="btn btn-success btn-rad" title="Print" href="'.base_url().'/kattalai_archanai_online/print_booking/'. $aname['id'].'" target="_blank"><i class="fa fa-print"></i> </a>';
				} else {
					$print = "";
				}


				$data[] = array(
					$i++,
					date("d-m-Y", strtotime($aname['date'])),
					$aname['ref_no'],
					$aname['name'],
					$daytype,
					$aname['payment_type'],
					$aname['amount'],
					$aname['paid_amount'],
					$print,
					//$action
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

    public function print_kattalai_abreport() {
		$data['fdate'] = $_REQUEST['fdt'];
		$data['tdate'] = $_REQUEST['tdt'];
		if (!empty($_REQUEST['cdt'])) {
			$data['cdate'] = $_REQUEST['cdt'];
		}
		$data['group_filter'] = $_REQUEST['group_filter'];
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
		if ($_REQUEST['pdf_ubayamreport'] == "PDF") {
			$data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
			$file_name = "KattalaiAbishegam_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$dompdf = new \Dompdf\Dompdf();
			$options = $dompdf->getOptions();
			$options->set(array('isRemoteEnabled' => true));
			$dompdf->setOptions($options);
			$dompdf->loadHtml(view('frontend/report/pdf/kattalai_abishegam_pdf', ["pdfdata" => $data]));
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$dompdf->stream($file_name);
		} elseif ($_REQUEST['excel_ubayamreport'] == "EXCEL") {
			$fileName = "KattalaiAbishegam_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			
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
			$sheet->setCellValue('A1', $data['temp_details']['name']);
			$sheet->setCellValue('A2', 'S.No');
			$sheet->setCellValue('B2', 'Date');
			$sheet->setCellValue('C2', 'Devotee Name');
			$sheet->setCellValue('D2', 'Types');
			$sheet->setCellValue('E2', 'Payment Type');
			$sheet->setCellValue('F2', 'Amount($)');
			// $sheet->setCellValue('F2', 'Paid');
			// $sheet->setCellValue('G2', 'Balance');
			$sheet->setCellValue('G2', 'Paid Amount($)');
			$rows = 3;
			$si = 1;
			$excel_format_data = $this->excel_format_get_kattalai_ab($data['fdate'], $data['tdate'], $data['cdate'], $data['group_filter'], $data['booking_type']);
			//var_dump($excel_format_data);
			//exit;
			foreach ($excel_format_data as $val) {
				$sheet->setCellValue('A' . $rows, $val['s_no']);
				$sheet->setCellValue('B' . $rows, $val['date']);
				$sheet->setCellValue('C' . $rows, $val['name']);
				$sheet->setCellValue('D' . $rows, $val['daytype']);
				$sheet->setCellValue('E' . $rows, $val['payment_type']);
				$sheet->setCellValue('F' . $rows, $val['amount']);
				// $sheet->setCellValue('F' . $rows, $val['paid']);
				// $sheet->setCellValue('G' . $rows, $val['bal']);
				$sheet->setCellValue('G' . $rows, $val['paid_amount']);
				$rows++;
				$si++;
			}
			$writer = new Xlsx($spreadsheet);
			$writer->save('uploads/excel/' . $fileName . '.xlsx');
			return $this->response->download('uploads/excel/' . $fileName . '.xlsx', null)->setFileName($fileName . '.xlsx');
		} else {
			echo view('frontend/report/kattalai_abishegam_print', $data);
		}
	}

	public function excel_format_get_kattalai($fdata, $tdata, $cdata, $group_filter, $booking_type)
	{
		$fdt = date('Y-m-d', strtotime($fdata));
		$tdt = date('Y-m-d', strtotime($tdata));
		$group_filter_fill = $group_filter;
		if (!empty($cdata)) {
			$cdt = date('Y-m-d', strtotime($cdata));
		}
		// $flternameg = $fltername;
		$data = [];

		$builder = $this->db->table('kattalai_archanai_booking as kab')
			->select('kab.id, kab.name, kab.date, kab.daytype, kab.amount, kab.paid_amount, kab.payment_type')
			->where('kab.date >=', $fdt)
			->where('kab.date <=', $tdt);

		if (!empty($group_filter_fill) && $group_filter_fill != '0') {
			$builder->where('kab.daytype', $group_filter_fill);
		}
		// echo $group_filter; die();
		$builder->orderBy('kab.date', 'DESC');

		$res = $builder->get()->getResultArray();

		$i = 1;
		foreach ($res as $row) {

			$data[] = array(
				"s_no" => $i++,
				"date" => date('d-m-Y', strtotime($row['date'])),
				"name" => $row['name'],
				"daytype" => $row['daytype'],
				"payment_type" => $row['payment_type'],
				"amount" => $row['amount'],
				"paid_amount" => $row['paid_amount'],

			);
		}
		return $data;
	}

	public function excel_format_get_kattalai_ab($fdata, $tdata, $cdata, $group_filter, $booking_type)
	{
		$fdt = date('Y-m-d', strtotime($fdata));
		$tdt = date('Y-m-d', strtotime($tdata));
		$group_filter_fill = $group_filter;
		if (!empty($cdata)) {
			$cdt = date('Y-m-d', strtotime($cdata));
		}
		// $flternameg = $fltername;
		$data = [];

		$builder = $this->db->table('kattalai_archanai_booking as kab')
			->select('kab.id, kab.name, kab.date, kab.daytype, kab.amount, kab.paid_amount, kab.payment_type')
			->where('kab.date >=', $fdt)
			->where('kab.date <=', $tdt)->where("kab.archanai_type_id", 3);

		if (!empty($group_filter_fill) && $group_filter_fill != '0') {
			$builder->where('kab.daytype', $group_filter_fill);
		}
		// echo $group_filter; die();
		$builder->orderBy('kab.date', 'DESC');

		$res = $builder->get()->getResultArray();

		$i = 1;
		foreach ($res as $row) {

			$data[] = array(
				"s_no" => $i++,
				"date" => date('d-m-Y', strtotime($row['date'])),
				"name" => $row['name'],
				"daytype" => $row['daytype'],
				"payment_type" => $row['payment_type'],
				"amount" => $row['amount'],
				"paid_amount" => $row['paid_amount'],

			);
		}
		return $data;
	}

	public function print_gurukalreport()
	{
		// if (!$this->model->list_validate('ubayam_report')) {
		// 	header('Location: ' . base_url() . '/dashboard');
		// }
		$data['fdate'] = $_REQUEST['fdt'];
		$data['tdate'] = $_REQUEST['tdt'];
		if (!empty($_REQUEST['cdt'])) {
			$data['cdate'] = $_REQUEST['cdt'];
		}
		$data['group_filter'] = $_REQUEST['group_filter'];
		// $data['report_type'] = $_REQUEST['report_type'];
		// $report_type = $_REQUEST['report_type'];
		// $data['booking_type'] = $_REQUEST['booking_type'];
		$tmpid = 1;
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
		// $data['payfor'] = $_REQUEST['payfor'];
		// $data['fltername'] = $_REQUEST['fltername'];
		if ($_REQUEST['pdf_ubayamreport'] == "PDF") {
			// if ($report_type == 1) {
			// 	$file_name = "Hallbooking_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			// } else {
			// 	$file_name = "Ubayam_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			// }
			$file_name = "KattalaiArchanai_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$dompdf = new \Dompdf\Dompdf();
			$options = $dompdf->getOptions();
			$options->set(array('isRemoteEnabled' => true));
			$dompdf->setOptions($options);
			$dompdf->loadHtml(view('frontend/report/pdf/kattalai_archanai_pdf', ["pdfdata" => $data]));
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$dompdf->stream($file_name);
		} elseif ($_REQUEST['excel_ubayamreport'] == "EXCEL") {
			$fileName = "KattalaiArchanai_Report_" . $data['fdate'] . "_to_" . $data['tdate'];

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
			$sheet->setCellValue('A1', $data['temp_details']['name']);
			$sheet->setCellValue('A2', 'S.No');
			$sheet->setCellValue('B2', 'Date');
			$sheet->setCellValue('C2', 'Devotee Name');
			$sheet->setCellValue('D2', 'Types');
			$sheet->setCellValue('E2', 'Payment Type');
			$sheet->setCellValue('F2', 'Amount');
			// $sheet->setCellValue('F2', 'Paid');
			// $sheet->setCellValue('G2', 'Balance');
			$sheet->setCellValue('G2', 'Paid Amount');
			$rows = 3;
			$si = 1;
			$excel_format_data = $this->excel_format_get_kattalai($data['fdate'], $data['tdate'], $data['cdate'], $data['group_filter'], $data['booking_type']);
			//var_dump($excel_format_data);
			//exit;
			foreach ($excel_format_data as $val) {
				$sheet->setCellValue('A' . $rows, $val['s_no']);
				$sheet->setCellValue('B' . $rows, $val['date']);
				$sheet->setCellValue('C' . $rows, $val['name']);
				$sheet->setCellValue('D' . $rows, $val['daytype']);
				$sheet->setCellValue('E' . $rows, $val['payment_type']);
				$sheet->setCellValue('F' . $rows, $val['amount']);
				// $sheet->setCellValue('F' . $rows, $val['paid']);
				// $sheet->setCellValue('G' . $rows, $val['bal']);
				$sheet->setCellValue('G' . $rows, $val['paid_amount']);
				$rows++;
				$si++;
			}
			$writer = new Xlsx($spreadsheet);
			$writer->save('uploads/excel/' . $fileName . '.xlsx');
			return $this->response->download('uploads/excel/' . $fileName . '.xlsx', null)->setFileName($fileName . '.xlsx');
		} else {
			echo view('frontend/report/kattalai_gurukal_print', $data);
		}
	}

	public function print_notificationreport()
	{

		$data['fdate'] = $_REQUEST['fdt'];
		$data['tdate'] = $_REQUEST['tdt'];
		if (!empty($_REQUEST['cdt'])) {
			$data['cdate'] = $_REQUEST['cdt'];
		}
		$data['group_filter'] = $_REQUEST['group_filter'];
		$tmpid = 1;
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
		// $data['payfor'] = $_REQUEST['payfor'];
		// $data['fltername'] = $_REQUEST['fltername'];
		if ($_REQUEST['pdf_ubayamreport'] == "PDF") {
			// if ($report_type == 1) {
			// 	$file_name = "Hallbooking_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			// } else {
			// 	$file_name = "Ubayam_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			// }
			$file_name = "KattalaiArchanai_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$dompdf = new \Dompdf\Dompdf();
			$options = $dompdf->getOptions();
			$options->set(array('isRemoteEnabled' => true));
			$dompdf->setOptions($options);
			$dompdf->loadHtml(view('frontend/report/pdf/kattalai_archanai_pdf', ["pdfdata" => $data]));
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$dompdf->stream($file_name);
		} elseif ($_REQUEST['excel_ubayamreport'] == "EXCEL") {
			$fileName = "KattalaiArchanai_Report_" . $data['fdate'] . "_to_" . $data['tdate'];

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
			$sheet->setCellValue('A1', $data['temp_details']['name']);
			$sheet->setCellValue('A2', 'S.No');
			$sheet->setCellValue('B2', 'Date');
			$sheet->setCellValue('C2', 'Devotee Name');
			$sheet->setCellValue('D2', 'Types');
			$sheet->setCellValue('E2', 'Payment Type');
			$sheet->setCellValue('F2', 'Amount');
			// $sheet->setCellValue('F2', 'Paid');
			// $sheet->setCellValue('G2', 'Balance');
			$sheet->setCellValue('G2', 'Paid Amount');
			$rows = 3;
			$si = 1;
			$excel_format_data = $this->excel_format_get_kattalai($data['fdate'], $data['tdate'], $data['cdate'], $data['group_filter'], $data['booking_type']);
			//var_dump($excel_format_data);
			//exit;
			foreach ($excel_format_data as $val) {
				$sheet->setCellValue('A' . $rows, $val['s_no']);
				$sheet->setCellValue('B' . $rows, $val['date']);
				$sheet->setCellValue('C' . $rows, $val['name']);
				$sheet->setCellValue('D' . $rows, $val['daytype']);
				$sheet->setCellValue('E' . $rows, $val['payment_type']);
				$sheet->setCellValue('F' . $rows, $val['amount']);
				// $sheet->setCellValue('F' . $rows, $val['paid']);
				// $sheet->setCellValue('G' . $rows, $val['bal']);
				$sheet->setCellValue('G' . $rows, $val['paid_amount']);
				$rows++;
				$si++;
			}
			$writer = new Xlsx($spreadsheet);
			$writer->save('uploads/excel/' . $fileName . '.xlsx');
			return $this->response->download('uploads/excel/' . $fileName . '.xlsx', null)->setFileName($fileName . '.xlsx');
		} else {
			echo view('frontend/report/kattalai_notification_print', $data);
		}
	}

	public function kattalai_notification_ref()
	{
		$from_date = !empty($_POST['fdt']) ? $_POST['fdt'] : date('Y-m-01');
		$to_date = !empty($_POST['tdt']) ? $_POST['tdt'] : date('Y-m-d');
		$group_filter = $_POST['group_filter'] ?? null;
		$current_date = date('Y-m-d');

		$builder = $this->db->table('kattalai_archanai_booking as kab')
			->select('kab.id, kab.name, kab.date, kab.daytype, kab.dayofweek, kab.amount, kab.paid_amount, kab.payment_type, kab.start_date, kab.end_date')
			->select("(SELECT GROUP_CONCAT(d.deity_name SEPARATOR ', ') 
				FROM kattalai_archanai_deity_details d 
				WHERE d.booking_id = kab.id) as deity_names")
			->select("(SELECT GROUP_CONCAT(CONCAT(d2.name, '-', r.name_eng, '-', n.name_eng) SEPARATOR ', ')
					FROM kattalai_archanai_details d2
					JOIN rasi r ON d2.rasi = r.id
					JOIN natchathram n ON d2.natchathiram = n.id
					WHERE d2.booking_id = kab.id) as devotee_details");

		if ($group_filter == 'daily' || $group_filter == 'weekly' || $group_filter == 'years') {
			$builder->where("(kab.start_date <= '{$to_date}' AND kab.end_date >= '{$from_date}')");
		} else if ($group_filter == 'days') {
			$builder->where("(kab.start_date IS NULL OR kab.end_date IS NULL)");
		} else {
			$builder->where("(kab.start_date <= '{$to_date}' AND kab.end_date >= '{$from_date}') OR kab.start_date IS NULL OR kab.end_date IS NULL");
		}

		if (!empty($group_filter) && $group_filter != '0') {
			$builder->where('kab.daytype', $group_filter);
		}

		$res = $builder->orderby('kab.id', 'desc')->get()->getResultArray();

		$groupedData = [];

		foreach ($res as $record) {
			$status = '';
			$enddate = $record['end_date'];
			$startdate = $record['start_date'];

			if ($record['start_date'] == null || $record['end_date'] == null) {
				// Check the kattalai_archanai_dates table for the effective end date
				$datesRes = $this->db->table('kattalai_archanai_dates')
					->select('MAX(date) as end_date')
					->where('booking_id', $record['id'])
					->where('date IS NOT NULL')
					->where('date !=', '1970-01-01')
					->get()
					->getRowArray();

				// if ($datesRes['end_date']) {
				if (!empty($datesRes['end_date']) && $datesRes['end_date'] > $from_date) {
					$enddate = $datesRes['end_date'];
				} else {
					// Skip this record if both start_date and end_date are null and kattalai_archanai_dates table has no valid end date
					continue;
				}
			}

			if ($enddate <= $current_date) {
				$status = 'COMPLETED';
			} elseif ($enddate < $to_date) {
				$status = 'GOING TO COMPLETE';
			} elseif ($startdate > $current_date) {
				$status = 'NOT STARTED';
			} else {
				$status = 'ONGOING';
			}

			// $startdate = date("d-m-Y", strtotime($record['start_date']));
			$formattedDate = date("d-m-Y", strtotime($record['date']));

			if ($record['daytype'] == 'days') {
				$startdate = "";
			} else {
				$startdate = date("d-m-Y", strtotime($record['start_date']));
			}

			$daytype = "";
			if ($record['daytype'] == 'daily') {
				$daytype = 'Daily';
			} elseif ($record['daytype'] == 'weekly') {
				$daytype = 'Weekly';
			} elseif ($record['daytype'] == 'days') {
				$daytype = 'Multiple Dates';
			} elseif ($record['daytype'] == 'years') {
				$daytype = 'Yearly';
			}

			$groupedData[] = array(
				'Id' => $record['id'],
				'Date' => $formattedDate,
				'Start Date' => $startdate,
				'End Date' => date("d-m-Y", strtotime($enddate)),
				'Devotee Name' => $record['name'],
				'Types' => $daytype,
				'Payment Type' => $record['payment_type'],
				'Amount' => $record['amount'],
				'deity_names' => $record['deity_names'],
				'devotee_details' => $record['devotee_details'],
				'Paid Amount' => $record['paid_amount'],
				'Status' => $status
			);
		}

		$data = [
			'list' => $groupedData,
			'from_date' => $from_date,
			'to_date' => $to_date,
			'group_filter' => $group_filter,
			'payment_modes' => $this->db->table('payment_mode')->where('status', 1)->where('paid_through', 'COUNTER')->get()->getResultArray()
		];

		echo view('frontend/layout/header');
		echo view('frontend/report/kattalai_notification_report', $data);
	}

	public function kattalai_notification_ref_withoutDays()
	{
		$from_date = !empty($_POST['fdt']) ? $_POST['fdt'] : date('Y-m-01');
		$to_date = !empty($_POST['tdt']) ? $_POST['tdt'] : date('Y-m-d');
		$group_filter = $_POST['group_filter'] ?? null;
		$current_date = date('Y-m-d');

		$builder = $this->db->table('kattalai_archanai_booking as kab')
			->select('kab.id, kab.name, kab.date, kab.daytype, kab.dayofweek, kab.amount, kab.paid_amount, kab.payment_type, kab.start_date, kab.end_date')
			->where("(kab.start_date <= '{$to_date}' AND kab.end_date >= '{$from_date}')");

		if (!empty($group_filter) && $group_filter != '0') {
			$builder->where('kab.daytype', $group_filter);
		}

		$res = $builder->get()->getResultArray();

		$groupedData = [];

		foreach ($res as $record) {
			$status = '';
			if ($record['end_date'] <= $current_date) {
				$status = 'COMPLETED';
			} elseif ($record['end_date'] <= $to_date) {
				$status = 'GOING TO COMPLETE';
			} else {
				$status = 'ONGOING';
			}

			$startdate = date("d-m-Y", strtotime($record['start_date']));
			$enddate = date("d-m-Y", strtotime($record['end_date']));
			$formattedDate = date("d-m-Y", strtotime($record['date']));

			$groupedData[] = array(
				'Id' => $record['id'],
				'Date' => $formattedDate,
				'Start Date' => $startdate,
				'End Date' => $enddate,
				'Devotee Name' => $record['name'],
				'Types' => $record['daytype'],
				'Payment Type' => $record['payment_type'],
				'Amount' => $record['amount'],
				'Paid Amount' => $record['paid_amount'],
				'Status' => $status
			);
		}

		$data = [
			'list' => $groupedData,
			'from_date' => $from_date,
			'to_date' => $to_date,
			'group_filter' => $group_filter,
			'payment_modes' => $this->db->table('payment_mode')->where("paid_through", "COUNTER")->where("kattalai_archanai", 1)->where('status', 1)->orderby('menu_order', "ASC")->get()->getResultArray()
		];

		echo view('frontend/layout/header');
		echo view('frontend/report/kattalai_notification_report', $data);
	}

	public function kattalai_notification_ref_ORIGINAl()
	{
		$from_date = !empty($_POST['fdt']) ? $_POST['fdt'] : date('Y-m-01');
		$to_date = !empty($_POST['tdt']) ? $_POST['tdt'] : date('Y-m-d');
		$group_filter = $_POST['group_filter'] ?? null;

		// Create a period for each day between from_date and to_date
		$period = new \DatePeriod(
			new \DateTime($from_date),
			new \DateInterval('P1D'),
			(new \DateTime($to_date))->modify('+1 day')
		);

		$groupedData = [];

		foreach ($period as $dt) {
			$currentDate = $dt->format("Y-m-d");

			// $currentDate = date("Y-m-d");



			if ($group_filter == 'daily' || $group_filter == 'weekly' || $group_filter == 'years') {
				$builder = $this->db->table('kattalai_archanai_booking as kab')
					->select('kab.id, kab.name, kab.date, kab.daytype, kab.dayofweek, kab.amount, kab.paid_amount, kab.payment_type, kab.start_date, kab.end_date')
					->where("(kab.start_date <= '{$to_date}' AND kab.end_date >= '{$from_date}')");
				if (!empty($group_filter) && $group_filter != '0') {
					$builder->where('kab.daytype', $group_filter);
				}
				$res = $builder->get()->getResultArray();
			} else if ($group_filter == 'days') {
				$builder = $this->db->table('kattalai_archanai_booking as kab')
					->select('kab.id, kab.name, kab.date, kab.daytype, kab.dayofweek, kab.amount, kab.paid_amount, kab.payment_type, kab.start_date, kab.end_date')
					->where("(kab.start_date IS NULL OR kab.end_date IS NULL)");
				if (!empty($group_filter) && $group_filter != '0') {
					$builder->where('kab.daytype', $group_filter);
				}
				$res = $builder->get()->getResultArray();
			} else {

				$builder = $this->db->table('kattalai_archanai_booking as kab')
					->select('kab.id, kab.name, kab.date, kab.daytype, kab.dayofweek, kab.amount, kab.paid_amount, kab.payment_type, kab.start_date, kab.end_date')
					->where("(kab.start_date <= '{$to_date}' AND kab.end_date >= '{$from_date}') OR kab.start_date IS NULL OR kab.end_date IS NULL");
				if (!empty($group_filter) && $group_filter != '0') {
					$builder->where('kab.daytype', $group_filter);
				}
				$res = $builder->get()->getResultArray();
			}


			foreach ($res as $record) {
				$matchesDate = false;
				if ($record['daytype'] == 'days') {
					$datesRes1 = $this->db->table('kattalai_archanai_dates')
						->select('date')
						->where('booking_id', $record['id'])
						->get()
						->getResultArray();

					foreach ($datesRes1 as $dateRow1) {
						if ($dateRow1['date'] == $currentDate) {
							$matchesDate = true;
							break;
						}
					}
				} else {


					switch ($record['daytype']) {

						case 'weekly':


							$weekday = date('N', strtotime($currentDate));
							$weekday = $weekday % 7 + 1;
							if (($record['start_date'] <= $currentDate && $record['end_date'] >= $currentDate) && $record['dayofweek'] == $weekday) {
								$matchesDate = true;
							}
							break;
						case 'years':
						case 'daily':
							if ($record['start_date'] <= $currentDate && $record['end_date'] >= $currentDate) {
								$matchesDate = true;
							}
							break;
					}
				}

				if ($matchesDate) {
					if ($record['daytype'] == 'days') {
						$startdate = "";
						$enddate = "";
					} else {
						$startdate = date("d-m-Y", strtotime($record['start_date']));
						$enddate = date("d-m-Y", strtotime($record['end_date']));
					}
					$formattedDate = date("d-m-Y", strtotime($currentDate));
					$groupedData[$formattedDate][] = array(
						'Id' => $record['id'],
						'Date' => $formattedDate,
						'Start Date' => $startdate,
						'End Date' => $enddate,
						'Devotee Name' => $record['name'],
						'Types' => $record['daytype'],
						'Payment Type' => $record['payment_type'],
						'Amount' => $record['amount'],
						'Paid Amount' => $record['paid_amount']
					);
				}
			}
		}

		$data = [
			'list' => $groupedData,
			'from_date' => $from_date,
			'to_date' => $to_date,
			'group_filter' => $group_filter,
			'payment_modes' => $this->db->table('payment_mode')->where("paid_through", "COUNTER")->where("kattalai_archanai", 1)->where('status', 1)->orderby('menu_order', "ASC")->get()->getResultArray()
		];

		echo view('frontend/layout/header');
		echo view('frontend/report/kattalai_notification_report', $data);
	}

	private function matchesDate($record, $currentDate)
	{
		switch ($record['daytype']) {
			case 'daily':
			case 'years':

				return $record['start_date'] <= $currentDate && $record['end_date'] >= $currentDate;

			case 'days':
				// For 'days', bookings are set for specific dates within the start and end dates
				$datesRes = $this->db->table('kattalai_archanai_dates')
					->select('date')
					->where('booking_id', $record['id'])
					->get()
					->getResultArray();
				foreach ($datesRes as $dateRow) {
					if ($dateRow['date'] == $currentDate) {
						return true;
					}
				}
				return false;

			case 'weekly':
				// For 'weekly', bookings occur on a specific day of the week, between the start and end dates
				$weekday = date('N', strtotime($currentDate)); // N = 1 (for Monday) through 7 (for Sunday)
				if ($record['dayofweek'] == $weekday) {
					return $record['start_date'] <= $currentDate && $record['end_date'] >= $currentDate;
				}
				return false;

			default:
				// Handle unknown daytypes
				error_log("Unhandled daytype: {$record['daytype']}");
				return false;
		}
	}

	public function print_kattalai_gurukal_report()
	{
		$data['fdate'] = $_REQUEST['fdt'];
		$data['tdate'] = $_REQUEST['tdt'];
		if (!empty($_REQUEST['cdt'])) {
			$data['cdate'] = $_REQUEST['cdt'];
		}
		$data['group_filter'] = $_REQUEST['group_filter'];
		// $data['report_type'] = $_REQUEST['report_type'];
		// $report_type = $_REQUEST['report_type'];
		// $data['booking_type'] = $_REQUEST['booking_type'];
		$tmpid = 1;
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
		// $data['payfor'] = $_REQUEST['payfor'];
		// $data['fltername'] = $_REQUEST['fltername'];
		if ($_REQUEST['pdf_ubayamreport'] == "PDF") {
			// if ($report_type == 1) {
			// 	$file_name = "Hallbooking_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			// } else {
			// 	$file_name = "Ubayam_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			// }
			$file_name = "KattalaiArchanai_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$dompdf = new \Dompdf\Dompdf();
			$options = $dompdf->getOptions();
			$options->set(array('isRemoteEnabled' => true));
			$dompdf->setOptions($options);
			$dompdf->loadHtml(view('frontend/report/pdf/kattalai_archanai_pdf', ["pdfdata" => $data]));
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$dompdf->stream($file_name);
		} elseif ($_REQUEST['excel_ubayamreport'] == "EXCEL") {
			$fileName = "KattalaiArchanai_Report_" . $data['fdate'] . "_to_" . $data['tdate'];

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
			$sheet->setCellValue('A1', $data['temp_details']['name']);
			$sheet->setCellValue('A2', 'S.No');
			$sheet->setCellValue('B2', 'Date');
			$sheet->setCellValue('C2', 'Devotee Name');
			$sheet->setCellValue('D2', 'Types');
			$sheet->setCellValue('E2', 'Payment Type');
			$sheet->setCellValue('F2', 'Amount');
			// $sheet->setCellValue('F2', 'Paid');
			// $sheet->setCellValue('G2', 'Balance');
			$sheet->setCellValue('G2', 'Paid Amount');
			$rows = 3;
			$si = 1;
			$excel_format_data = $this->excel_format_get_kattalai($data['fdate'], $data['tdate'], $data['cdate'], $data['group_filter'], $data['booking_type']);
			//var_dump($excel_format_data);
			//exit;
			foreach ($excel_format_data as $val) {
				$sheet->setCellValue('A' . $rows, $val['s_no']);
				$sheet->setCellValue('B' . $rows, $val['date']);
				$sheet->setCellValue('C' . $rows, $val['name']);
				$sheet->setCellValue('D' . $rows, $val['daytype']);
				$sheet->setCellValue('E' . $rows, $val['payment_type']);
				$sheet->setCellValue('F' . $rows, $val['amount']);
				// $sheet->setCellValue('F' . $rows, $val['paid']);
				// $sheet->setCellValue('G' . $rows, $val['bal']);
				$sheet->setCellValue('G' . $rows, $val['paid_amount']);
				$rows++;
				$si++;
			}
			$writer = new Xlsx($spreadsheet);
			$writer->save('uploads/excel/' . $fileName . '.xlsx');
			return $this->response->download('uploads/excel/' . $fileName . '.xlsx', null)->setFileName($fileName . '.xlsx');
		} else {
			echo view('frontend/report/kattalai_archanai_print', $data);
		}
	}

	public function kattalai_gurukal_report_ref()
	{
		$from_date = !empty($_POST['fdt']) ? $_POST['fdt'] : date('Y-m-01');
		$to_date = !empty($_POST['tdt']) ? $_POST['tdt'] : date('Y-m-d');
		$group_filter = $_POST['group_filter'] ?? null;

		// Create a period for each day between from_date and to_date
		$period = new \DatePeriod(
			new \DateTime($from_date),
			new \DateInterval('P1D'),
			(new \DateTime($to_date))->modify('+1 day')
		);

		$groupedData = [];

		foreach ($period as $dt) {
			$currentDate = $dt->format("Y-m-d");

			if ($group_filter == 'daily' || $group_filter == 'weekly' || $group_filter == 'years') {
				$builder = $this->db->table('kattalai_archanai_booking as kab')
					->select('kab.id, kab.name, kab.date, kab.daytype, kab.dayofweek, kab.amount, kab.paid_amount, kab.payment_type, kab.start_date, kab.end_date')
					->select("(SELECT GROUP_CONCAT(ad.name_tamil SEPARATOR ', ')
				FROM kattalai_archanai_deity_details d
				JOIN archanai_diety ad ON ad.id = d.deity_id
				WHERE d.booking_id = kab.id) as deity_names")
					->select("(SELECT GROUP_CONCAT(CONCAT(d2.name, '-', r.name_tamil, '-', n.name_tamil) SEPARATOR ', ')
				FROM kattalai_archanai_details d2
				JOIN rasi r ON d2.rasi = r.id
				JOIN natchathram n ON d2.natchathiram = n.id
				WHERE d2.booking_id = kab.id) as devotee_details")
					->where("(kab.start_date <= '{$to_date}' AND kab.end_date >= '{$from_date}')");
				if (!empty($group_filter) && $group_filter != '0') {
					// Apply the filter for 'daytype' only if it's not empty or '0'
					$builder->where('kab.daytype', $group_filter);
				}
				$res = $builder->orderby('kab.id', 'desc')->get()->getResultArray();
			} else if ($group_filter == 'days') {
				$builder = $this->db->table('kattalai_archanai_booking as kab')
					->select('kab.id, kab.name, kab.date, kab.daytype, kab.dayofweek, kab.amount, kab.paid_amount, kab.payment_type, kab.start_date, kab.end_date')
					// ->select("(SELECT GROUP_CONCAT(d.deity_name SEPARATOR ', ') 
					//        FROM kattalai_archanai_deity_details d 
					//        WHERE d.booking_id = kab.id) as deity_names")
					->select("(SELECT GROUP_CONCAT(ad.name_tamil SEPARATOR ', ')
				FROM kattalai_archanai_deity_details d
				JOIN archanai_diety ad ON ad.id = d.deity_id
				WHERE d.booking_id = kab.id) as deity_names")
					->select("(SELECT GROUP_CONCAT(CONCAT(d2.name, '-', r.name_tamil, '-', n.name_tamil) SEPARATOR ', ')
				FROM kattalai_archanai_details d2
				JOIN rasi r ON d2.rasi = r.id
				JOIN natchathram n ON d2.natchathiram = n.id
				WHERE d2.booking_id = kab.id) as devotee_details")
					->where("(kab.start_date IS NULL OR kab.end_date IS NULL)");
				if (!empty($group_filter) && $group_filter != '0') {
					// Apply the filter for 'daytype' only if it's not empty or '0'
					$builder->where('kab.daytype', $group_filter);
				}
				$res = $builder->orderby('kab.id', 'desc')->get()->getResultArray();
			} else {

				$builder = $this->db->table('kattalai_archanai_booking as kab')
					->select('kab.id, kab.name, kab.date, kab.daytype, kab.dayofweek, kab.amount, kab.paid_amount, kab.payment_type, kab.start_date, kab.end_date')
					->select("(SELECT GROUP_CONCAT(ad.name_tamil SEPARATOR ', ')
				FROM kattalai_archanai_deity_details d
				JOIN archanai_diety ad ON ad.id = d.deity_id
				WHERE d.booking_id = kab.id) as deity_names")
					->select("(SELECT GROUP_CONCAT(CONCAT(d2.name, '-', r.name_tamil, '-', n.name_tamil) SEPARATOR ', ')
				FROM kattalai_archanai_details d2
				JOIN rasi r ON d2.rasi = r.id
				JOIN natchathram n ON d2.natchathiram = n.id
				WHERE d2.booking_id = kab.id) as devotee_details")
					->where("(kab.start_date <= '{$to_date}' AND kab.end_date >= '{$from_date}') OR kab.start_date IS NULL OR kab.end_date IS NULL");
				if (!empty($group_filter) && $group_filter != '0') {
					// Apply the filter for 'daytype' only if it's not empty or '0'
					$builder->where('kab.daytype', $group_filter);
				}
				$res = $builder->orderby('kab.id', 'desc')->get()->getResultArray();
			}

			foreach ($res as $record) {
				$matchesDate = false;
				if ($record['daytype'] == 'days') {
					$datesRes1 = $this->db->table('kattalai_archanai_dates')
						->select('date')
						->where('booking_id', $record['id'])
						->get()
						->getResultArray();

					$dateCollection = array_column($datesRes1, 'date');
					if (!empty($dateCollection)) {
						$start = min($dateCollection);  // Get the earliest date
						$end = max($dateCollection);    // Get the latest date
					}

					foreach ($datesRes1 as $dateRow1) {
						if ($dateRow1['date'] == $currentDate) {
							$matchesDate = true;
							break;
						}
					}
				} else {


					switch ($record['daytype']) {
						case 'weekly':
							$weekday = date('N', strtotime($currentDate));
							$weekday = $weekday % 7 + 1;
							if (($record['start_date'] <= $currentDate && $record['end_date'] >= $currentDate) && $record['dayofweek'] == $weekday) {
								$matchesDate = true;
							}
							break;
						case 'years':
						case 'daily':
							// Check if the date falls within the booking period
							if ($record['start_date'] <= $currentDate && $record['end_date'] >= $currentDate) {
								$matchesDate = true;
							}
							break;
					}
				}

				if ($matchesDate) {
					if ($record['daytype'] == 'days') {
						$startdate = date("d-m-Y", strtotime($start));
						$enddate = date("d-m-Y", strtotime($end));
					} else {
						$startdate = date("d-m-Y", strtotime($record['start_date']));
						$enddate = date("d-m-Y", strtotime($record['end_date']));
					}

					$formattedDate = date("d-m-Y", strtotime($currentDate));
					$groupedData[$formattedDate][] = array(
						'Id' => $record['id'],
						'Date' => $formattedDate,
						'Start Date' => $startdate,
						'End Date' => $enddate,
						'Devotee Name' => $record['name'],
						'Types' => $record['daytype'],
						'Payment Type' => $record['payment_type'],
						'Amount' => $record['amount'],
						'deity_names' => $record['deity_names'],
						'devotee_details' => $record['devotee_details'],
						'Paid Amount' => $record['paid_amount']
					);
				}
			}
		}

		// Pass data to the view
		$data = [
			'list' => $groupedData,
			'from_date' => $from_date,
			'to_date' => $to_date,
			'group_filter' => $group_filter,
			'payment_modes' => $this->db->table('payment_mode')->where("paid_through", "COUNTER")->where("kattalai_archanai", 1)->where('status', 1)->orderby('menu_order', "ASC")->get()->getResultArray()
		];

		echo view('frontend/layout/header');
		echo view('frontend/report/kattalai_gurukal_report', $data);
	}

	public function hall_rep_ref()
	{
		$fdt = date('Y-m-d', strtotime($_POST['fdt']));
		$tdt = date('Y-m-d', strtotime($_POST['tdt']));
		$cdt = isset($_POST['cdt']) && !empty($_POST['cdt']) ? date('Y-m-d', strtotime($_POST['cdt'])) : null;
		$group_filter = $_POST['group_filter'];
		$booking_type = $_POST['booking_type'];

		$data = [];
		$dat = $this->db->table('templebooking')
			->join('booked_packages', 'booked_packages.booking_id = templebooking.id')
			->join('booked_deposit_details', 'booked_deposit_details.booking_id = templebooking.id')
			->select('booked_packages.name as pname, booked_deposit_details.amount as deposit_amount, booked_deposit_details.deposit_status')
			->select('templebooking.*, templebooking.mobile_code, templebooking.mobile_no')
			->where('templebooking.booking_type', 1)
			->where('DATE_FORMAT(templebooking.entry_date, "%Y-%m-%d") >=', $fdt);
		$dat = $dat->where('DATE_FORMAT(templebooking.entry_date, "%Y-%m-%d") <=', $tdt);

		if (!empty($cdt)) {
			$dat = $dat->where('templebooking.booking_date =', $cdt);
		}
		if (!empty($group_filter) && $group_filter != "0") {
			if ($group_filter === 'full') {
				$dat = $dat->where('templebooking.total_amount = templebooking.paid_amount');
			} elseif ($group_filter === 'partial') {
				$dat = $dat->where('templebooking.paid_amount > 0')->where('templebooking.paid_amount < templebooking.total_amount');
			} elseif ($group_filter === 'only_booked') {
				$dat = $dat->where('templebooking.paid_amount =', 0);
			}
		}

		$dat = $dat->orderBy('templebooking.id', 'desc');
		$dat = $dat->get()->getResultArray();

		$i = 1;
		$total_amount = 0;
		$total_paid = 0;
		$total_balance = 0;
		$totalByCategory = [];
		foreach ($dat as $row) {
			$paidFull = ($row['total_amount'] == $row['paid_amount']);
			$total_amount += (float) $row['total_amount'];
			$total_paid += (float) $row['paid_amount'];
			$balance_amount = (float) $row['total_amount'] - (float) $row['paid_amount'];
			if ($balance_amount < 0)
				$balance_amount = 0;
			$total_balance += $balance_amount;

			if ($row['booking_status'] == 3) {
				$txt = '<span class="cancel_text">Cancelled</span>';
			} else {

				if (empty($balance_amount)) {
					$txt = '<span class="paid_text">Paid</span>';
				} else {
					$txt = '<span class="unpaid_text">Partially Paid</span>';
				}
			}

			if ($row['payment_status'] == 1 && $row['booking_status'] == 1) {
				$print = '<a class="btn btn-warning btn-rad" title="Print" href="' . base_url() . '/hallbooking_online/print_page_hall/' . $row['id'] . '" target="_blank"><i class="fa fa-print"></i> </a>  <a class="btn btn-primary btn-rad btn-payment" title="Edit" href="' . base_url() . '/report/show_loan_history/' . $row['id'] . '"><i class="fa fa-credit-card"></i></a>';
			} else if ($row['payment_status'] == 2 || $row['booking_status'] == 2 || $row['booking_status'] == 3) {
				$print = '<a class="btn btn-warning btn-rad" title="Print" href="' . base_url() . '/hallbooking_online/print_page_hall/' . $row['id'] . '" target="_blank"><i class="fa fa-print"></i> </a>';
			} else {
				$print = "";
			}

			if ($row['booking_status'] != 3) {
				$action1 = '<a class="btn btn-warning btn-rad btn-cancel btn-danger" title="Print" href="' . base_url() . '/hallbooking_online/print_page_hall/' . $row['id'] . '" target="_blank"><i class="fa fa-times"></i> </a>';
			} else {
				$action1 = "";
			}

			if ($row['payment_status'] == 2 && $row['booking_status'] == 2 && $row['deposit_status'] == 1) {
				$action2 = '<a class="btn btn-primary btn-rad btn-success btn-deprepay" title="Edit" href="' . base_url() . '/report/show_loan_history/' . $row['id'] . '"><i class="fa fa-redo">Repay</i></a>';
			} else {
				$action2 = "";
			}
			// Combine mobile code and mobile number
			$mobile_display = '-';
			if (!empty($row['mobile_no'])) {
				$mobile_code = !empty($row['mobile_code']) ? $row['mobile_code'] : '';
				$mobile_display = $mobile_code . ' ' . $row['mobile_no'];
			}
			$data[] = array(
				$i++,
				date('d-m-Y', strtotime($row['entry_date'])),
				date('d-m-Y', strtotime($row['booking_date'])),
				$row['ref_no'] ?? '-',
				$row['pname'],
				$row['name'],
				$mobile_display,
				$row['total_amount'],
				$row['paid_amount'],
				$txt,
				$print,
				'<p>' . $action1 . '' . $action2 . '</p>'
				//$action1

			);
		}

		$totalByCategory[] = array(
			'total_amount' => $total_amount,
			'paid_amount' => $total_paid,
			'balance_amount' => $total_balance
		);

		$result = array(
			"draw" => 0,
			"recordsTotal" => $i - 1,
			"recordsFiltered" => $i - 1,
			"data" => $data,
			"totals" => $totalByCategory,
		);

		echo json_encode($result);
		exit();
	}

	public function hall_event_status()
	{
		$fdt = date('Y-m-d', strtotime($_POST['fdt']));
		$tdt = date('Y-m-d', strtotime($_POST['tdt']));
		$data = [];
		$dat = $this->db->table('templebooking')
			->join('booked_packages', 'booked_packages.booking_id = templebooking.id')
			->select('booked_packages.name as pname, templebooking.*')
			->where('templebooking.booking_type', 1)
			->where('DATE_FORMAT(templebooking.entry_date, "%Y-%m-%d") >=', $fdt)
			->where('DATE_FORMAT(templebooking.entry_date, "%Y-%m-%d") <=', $tdt)
			->orderBy('templebooking.id', 'desc')
			->get()->getResultArray();

		$i = 1;
		foreach ($dat as $row) {
			$currentDate = date('Y-m-d');
			$bookingDate = date('Y-m-d', strtotime($row['booking_date']));
			$paidFull = ($row['total_amount'] == $row['paid_amount']);
			$isPastBooking = ($bookingDate < $currentDate);
			$iscompleted = ($row['booking_status'] == 2);

			$data[] = [
				'S.No' => $i++,
				'id' => $row['id'],
				'Booking Date' => date('d-m-Y', strtotime($row['entry_date'])),
				'Event Date' => date('d-m-Y', strtotime($row['booking_date'])),
				'Package Name' => $row['pname'],
				'Name' => $row['name'],
				'Payment Status' => $paidFull ? '<span class="paid_text">Paid</span>' : '<span class="unpaid_text">Partially Paid</span>',
				'isPastBooking' => $isPastBooking,
				'paidFull' => $paidFull,
				'iscompleted' => $iscompleted
			];
		}

		echo json_encode($data);
		exit();
	}
	public function print_hallreport_temple()
	{
		$data['fdate'] = $_REQUEST['fdt'];
		$data['tdate'] = $_REQUEST['tdt'];
		if (!empty($_REQUEST['cdt'])) {
			$data['cdate'] = $_REQUEST['cdt'];
		} else {
			$data['cdate'] = null;
		}
		$data['group_filter'] = $_REQUEST['group_filter'] ?? '';
		$data['report_type'] = $_REQUEST['report_type'];
		$report_type = $_REQUEST['report_type'];
		$data['booking_type'] = $_REQUEST['booking_type'];
		$tmpid = 1;
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();

		// Fetch the report data
		$data['report_data'] = $this->get_hallreport_temple_data(
			$data['fdate'],
			$data['tdate'],
			$data['cdate'],
			$data['group_filter'],
			$data['booking_type']
		);

		// PDF Export
		if (isset($_REQUEST['pdf_ubayamreport']) && $_REQUEST['pdf_ubayamreport'] == "PDF") {
			if ($report_type == 1) {
				$file_name = "Hallbooking_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			} else {
				$file_name = "Ubayam_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			}
			$dompdf = new \Dompdf\Dompdf();
			$options = $dompdf->getOptions();
			$options->set(array('isRemoteEnabled' => true));
			$dompdf->setOptions($options);
			$dompdf->loadHtml(view('frontend/report/pdf/ubay_print_temple', ["pdfdata" => $data]));
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$dompdf->stream($file_name);
			exit;
		}
		// Excel Export
		elseif (isset($_REQUEST['excel_ubayamreport']) && $_REQUEST['excel_ubayamreport'] == "EXCEL") {
			if ($report_type == 1) {
				$fileName = "Hallbooking_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			} else {
				$fileName = "Ubayam_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			}

			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();

			// Set title style
			$sheet->getStyle('A1')->getFont()->setBold(true)->setName('Arial')->SetSize(14);
			$style = array(
				'alignment' => array(
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				)
			);

			// Temple name header
			$sheet->getStyle("A1:K1")->applyFromArray($style);
			$sheet->mergeCells('A1:K1');
			$sheet->setCellValue('A1', $data['temp_details']['name']);

			// Column headers
			$sheet->setCellValue('A2', 'S.No');
			$sheet->setCellValue('B2', 'Booking Date');
			$sheet->setCellValue('C2', 'Event Date');
			$sheet->setCellValue('D2', 'Ref No');
			$sheet->setCellValue('E2', 'Event Name');
			$sheet->setCellValue('F2', 'Name');
			$sheet->setCellValue('G2', 'Amount(S$)');
			$sheet->setCellValue('H2', 'Paid Amount(S$)');
			$sheet->setCellValue('I2', 'Balance Amount(S$)');
			$sheet->setCellValue('J2', 'Remarks');
			$sheet->setCellValue('K2', 'Status');

			// Style header row
			$headerStyle = [
				'font' => ['bold' => true],
				'fill' => [
					'fillType' => Fill::FILL_SOLID,
					'startColor' => ['rgb' => 'F7EBBB']
				],
				'borders' => [
					'allBorders' => ['borderStyle' => Border::BORDER_THIN]
				],
				'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
			];
			$sheet->getStyle('A2:K2')->applyFromArray($headerStyle);

			// Get data for Excel and calculate totals
			$excel_format_data = $this->excel_format_get_hallreport_temple(
				$data['fdate'],
				$data['tdate'],
				$data['cdate'],
				$data['group_filter'],
				$data['booking_type']
			);

			// Initialize totals
			$totalAmount = 0;
			$totalPaid = 0;
			$totalBalance = 0;

			// Fill data rows
			$rows = 3;
			foreach ($excel_format_data as $val) {
				$sheet->setCellValue('A' . $rows, $val['s_no']);
				$sheet->setCellValue('B' . $rows, $val['entry_date']);
				$sheet->setCellValue('C' . $rows, $val['date']);
				$sheet->setCellValue('D' . $rows, $val['ref_no']);
				$sheet->setCellValue('E' . $rows, $val['pname']);
				$sheet->setCellValue('F' . $rows, $val['name']);
				$sheet->setCellValue('G' . $rows, $val['amount']);
				$sheet->setCellValue('H' . $rows, $val['paid']);
				$sheet->setCellValue('I' . $rows, $val['bal']);
				$sheet->setCellValue('J' . $rows, $val['remarks']);
				$sheet->setCellValue('K' . $rows, $val['status']);

				// Calculate totals
				$totalAmount += (float) str_replace(',', '', $val['amount']);
				$totalPaid += (float) str_replace(',', '', $val['paid']);
				$totalBalance += (float) str_replace(',', '', $val['bal']);

				$rows++;
			}

			// Apply borders to data
			if ($rows > 3) {
				$dataStyle = [
					'borders' => [
						'allBorders' => ['borderStyle' => Border::BORDER_THIN]
					]
				];
				$lastDataRow = $rows - 1;
				$sheet->getStyle('A3:K' . $lastDataRow)->applyFromArray($dataStyle);
			}

			// Add empty row for spacing
			$rows++;

			// Add TOTALS SECTION
			$totalsRow = $rows;

			// Total Amount
			$sheet->setCellValue('F' . $totalsRow, 'Total Amount:');
			$sheet->setCellValue('G' . $totalsRow, number_format($totalAmount, 2, '.', ''));
			$sheet->mergeCells('F' . $totalsRow . ':F' . $totalsRow);

			// Total Paid Amount
			$totalsRow++;
			$sheet->setCellValue('F' . $totalsRow, 'Total Paid Amount:');
			$sheet->setCellValue('H' . $totalsRow, number_format($totalPaid, 2, '.', ''));
			$sheet->mergeCells('F' . $totalsRow . ':F' . $totalsRow);

			// Total Balance Amount
			$totalsRow++;
			$sheet->setCellValue('F' . $totalsRow, 'Total Balance Amount:');
			$sheet->setCellValue('I' . $totalsRow, number_format($totalBalance, 2, '.', ''));
			$sheet->mergeCells('F' . $totalsRow . ':F' . $totalsRow);

			// Style totals section
			$totalStyle = [
				'font' => [
					'bold' => true,
					'size' => 12
				],
				'fill' => [
					'fillType' => Fill::FILL_SOLID,
					'startColor' => ['rgb' => 'E2EFDA']
				],
				'borders' => [
					'allBorders' => ['borderStyle' => Border::BORDER_MEDIUM]
				],
				'alignment' => [
					'horizontal' => Alignment::HORIZONTAL_RIGHT
				]
			];

			$startTotalRow = $rows;
			$endTotalRow = $totalsRow;
			$sheet->getStyle('F' . $startTotalRow . ':I' . $endTotalRow)->applyFromArray($totalStyle);

			// Auto-size columns
			$sheet->getColumnDimension('A')->setWidth(8);
			$sheet->getColumnDimension('B')->setWidth(12);
			$sheet->getColumnDimension('C')->setWidth(12);
			$sheet->getColumnDimension('D')->setWidth(15);
			$sheet->getColumnDimension('E')->setWidth(25);
			$sheet->getColumnDimension('F')->setWidth(20);
			$sheet->getColumnDimension('G')->setWidth(12);
			$sheet->getColumnDimension('H')->setWidth(12);
			$sheet->getColumnDimension('I')->setWidth(12);
			$sheet->getColumnDimension('J')->setWidth(25);
			$sheet->getColumnDimension('K')->setWidth(12);

			// Make sure the uploads/excel directory exists
			$uploadPath = FCPATH . 'uploads/excel/';
			if (!is_dir($uploadPath)) {
				mkdir($uploadPath, 0755, true);
			}

			// Save the file
			$writer = new Xlsx($spreadsheet);
			$filePath = $uploadPath . $fileName . '.xlsx';
			$writer->save($filePath);

			// Check if file was created
			if (!file_exists($filePath)) {
				log_message('error', 'Excel file creation failed: ' . $filePath);
				die('Error: Unable to create Excel file. Please check server permissions.');
			}

			// Download the file
			return $this->response->download($filePath, null)->setFileName($fileName . '.xlsx');
		}
		// Print View
		else {
			echo view('frontend/report/ubay_print_temple', $data);
		}
	}

	// public function print_hallreport_temple()
	// {
	// 	$data['fdate'] = $_REQUEST['fdt'];
	// 	$data['tdate'] = $_REQUEST['tdt'];
	// 	if (!empty($_REQUEST['cdt'])) {
	// 		$data['cdate'] = $_REQUEST['cdt'];
	// 	}
	// 	$data['group_filter'] = $_REQUEST['group_filter'];
	// 	$data['report_type'] = $_REQUEST['report_type'];
	// 	$report_type = $_REQUEST['report_type'];
	// 	$data['booking_type'] = $_REQUEST['booking_type'];
	// 	$tmpid = 1;
	// 	$data['temp_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();

	// 	// **ADD THIS: Fetch the report data**
	// 	$data['report_data'] = $this->get_hallreport_temple_data(
	// 		$data['fdate'],
	// 		$data['tdate'],
	// 		$data['cdate'] ?? null,
	// 		$data['group_filter'],
	// 		$data['booking_type']
	// 	);

	// 	if ($_REQUEST['pdf_ubayamreport'] == "PDF") {
	// 		if ($report_type == 1) {
	// 			$file_name = "Hallbooking_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
	// 		} else {
	// 			$file_name = "Ubayam_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
	// 		}
	// 		$dompdf = new \Dompdf\Dompdf();
	// 		$options = $dompdf->getOptions();
	// 		$options->set(array('isRemoteEnabled' => true));
	// 		$dompdf->setOptions($options);
	// 		$dompdf->loadHtml(view('frontend/report/pdf/ubay_print_temple', ["pdfdata" => $data]));
	// 		$dompdf->setPaper('A4', 'portrait');
	// 		$dompdf->render();
	// 		$dompdf->stream($file_name);
	// 	} elseif ($_REQUEST['excel_ubayamreport'] == "EXCEL") {
	// 		// Excel code remains the same...
	// 	} else {
	// 		echo view('frontend/report/ubay_print_temple', $data);
	// 	}
	// }

	// **ADD THIS NEW METHOD**
	private function get_hallreport_temple_data($fdate, $tdate, $cdate, $group_filter, $booking_type)
	{
		$fdt = date('Y-m-d', strtotime($fdate));
		$tdt = date('Y-m-d', strtotime($tdate));

		$dat = $this->db->table('templebooking')
			->join('booked_packages', 'booked_packages.booking_id = templebooking.id')
			->select('booked_packages.name as pname')
			->select('templebooking.*')
			->where('templebooking.booking_type', $booking_type)
			->where('DATE_FORMAT(templebooking.entry_date, "%Y-%m-%d") >=', $fdt)
			->where('DATE_FORMAT(templebooking.entry_date, "%Y-%m-%d") <=', $tdt);

		if (!empty($cdate)) {
			$cdt = date('Y-m-d', strtotime($cdate));
			$dat = $dat->where('templebooking.booking_date =', $cdt);
		}

		if (!empty($group_filter) && $group_filter != "0") {
			if ($group_filter === 'full') {
				$dat = $dat->where('templebooking.total_amount = templebooking.paid_amount');
			} elseif ($group_filter === 'partial') {
				$dat = $dat->where('templebooking.paid_amount > 0')
					->where('templebooking.paid_amount < templebooking.total_amount');
			} elseif ($group_filter === 'only_booked') {
				$dat = $dat->where('templebooking.paid_amount =', 0);
			}
		}

		$dat = $dat->orderBy('templebooking.entry_date', 'desc');
		return $dat->get()->getResultArray();
	}
	public function excel_format_get_hallreport_temple($fdata, $tdata, $cdata, $group_filter, $booking_type)
	{
		$fdt = date('Y-m-d', strtotime($fdata));
		$tdt = date('Y-m-d', strtotime($tdata));
		$group_filter_fill = $group_filter;
		$cdt = null;
		if (!empty($cdata)) {
			$cdt = date('Y-m-d', strtotime($cdata));
		}

		$data = [];

		$dat = $this->db->table('templebooking')
			->join('booked_packages', 'booked_packages.booking_id = templebooking.id')
			->select('booked_packages.name as pname')
			->select('templebooking.*')  // This includes ref_no
			->where('templebooking.booking_type', $booking_type)
			->where('DATE_FORMAT(templebooking.entry_date, "%Y-%m-%d") >=', $fdt)
			->where('DATE_FORMAT(templebooking.entry_date, "%Y-%m-%d") <=', $tdt);

		if (!empty($cdt)) {
			$dat = $dat->where('templebooking.booking_date =', $cdt);
		}

		if (!empty($group_filter_fill) && $group_filter_fill != "0") {
			if ($group_filter_fill === 'full') {
				$dat = $dat->where('templebooking.total_amount = templebooking.paid_amount');
			} elseif ($group_filter_fill === 'partial') {
				$dat = $dat->where('templebooking.paid_amount > 0')
					->where('templebooking.paid_amount < templebooking.total_amount');
			} elseif ($group_filter_fill === 'only_booking') {
				$dat = $dat->where('templebooking.paid_amount =', 0);
			}
		}

		$dat = $dat->orderBy('templebooking.entry_date', 'desc');
		$results = $dat->get()->getResultArray();

		$i = 1;
		foreach ($results as $row) {
			// Get actual paid amount from booked_pay_details
			$getpaid = $this->db->table("booked_pay_details")
				->selectSum('amount')
				->where("booking_id", $row['id'])
				->get()
				->getRowArray();

			$paidAmount = (float) ($getpaid['amount'] ?? 0);
			$balance_amount = (float) $row['total_amount'] - $paidAmount;

			if ($balance_amount < 0) {
				$balance_amount = 0;
			}

			// Determine status
			if ($row['booking_status'] == 3) {
				$txt = 'Cancelled';
			} else {
				if (empty($balance_amount)) {
					$txt = 'Paid';
				} elseif ($paidAmount > 0) {
					$txt = 'Partially Paid';
				} else {
					$txt = 'Only Booked';
				}
			}

			$data[] = array(
				"s_no" => $i++,
				"entry_date" => date('d-m-Y', strtotime($row['entry_date'])),
				"date" => date('d-m-Y', strtotime($row['booking_date'])),
				"ref_no" => $row['ref_no'] ?? '-',  // ENSURE THIS LINE EXISTS
				"pname" => $row['pname'],
				"name" => $row['name'],
				"amount" => number_format($row['total_amount'], 2, '.', ''),
				"paid" => number_format($paidAmount, 2, '.', ''),
				"bal" => number_format($balance_amount, 2, '.', ''),
				"remarks" => $row['description'] ?? '-',
				"status" => $txt
			);
		}

		return $data;
	}
	// public function excel_format_get_hallreport_temple($fdata, $tdata, $cdata, $group_filter, $booking_type)
	// {
	// 	$fdt = date('Y-m-d', strtotime($fdata));
	// 	$tdt = date('Y-m-d', strtotime($tdata));
	// 	$group_filter_fill = $group_filter;
	// 	if (!empty($cdata)) {
	// 		$cdt = date('Y-m-d', strtotime($cdata));
	// 	}
	// 	// $flternameg = $fltername;
	// 	$data = [];
	// 	// $dat = $this->db->table('ubayam', 'ubayam_setting.name as pname')
	// 	// 	->join('ubayam_setting', 'ubayam_setting.id = ubayam.pay_for')
	// 	// 	->select('ubayam_setting.name as pname')
	// 	// 	->select('ubayam.*')
	// 	// 	->where('DATE_FORMAT(ubayam.ubayam_date, "%Y-%m-%d") >=', $fdt);
	// 	// $dat = $dat->where('DATE_FORMAT(ubayam.ubayam_date, "%Y-%m-%d") <=', $tdt);
	// 	// if ($payfor) {
	// 	// 	$dat = $dat->where('ubayam_setting.id', $payfor);
	// 	// }
	// 	// if ($fltername) {
	// 	// 	$dat = $dat->where('ubayam.name', $fltername);
	// 	// }
	// 	// $dat = $dat->orderBy('ubayam_date', 'asc');
	// 	// $dat = $dat->get()->getResultArray();
	// 	$dat = $this->db->table('templebooking', 'booked_packages.name as pname')
	// 		->join('booked_packages', 'booked_packages.booking_id = templebooking.id')
	// 		->select('booked_packages.name as pname')
	// 		->select('templebooking.*')
	// 		->where('DATE_FORMAT(templebooking.entry_date, "%Y-%m-%d") >=', $fdt);
	// 	$dat = $dat->where('DATE_FORMAT(templebooking.entry_date, "%Y-%m-%d") <=', $tdt);
	// 	// if ($payforg) {
	// 	// 	$dat = $dat->where('booked_packages.package_id', $payforg);
	// 	// }
	// 	if ($booking_type) {
	// 		$dat = $dat->where('booked_packages.booking_type', $booking_type);
	// 	}
	// 	if (!empty($cdt)) {
	// 		$dat = $dat->where('templebooking.booking_date =', $cdt);
	// 	}

	// 	if (!empty($group_filter_fill) && $group_filter_fill != "0") {
	// 		$dat = $dat->where('templebooking.payment_type', $group_filter_fill);
	// 	}
	// 	// if ($fltername) {
	// 	// 	$dat = $dat->where('templebooking.name', $fltername);
	// 	// }
	// 	$dat = $dat->orderBy('entry_date', 'desc');
	// 	$dat = $dat->get()->getResultArray();

	// 	$i = 1;
	// 	foreach ($dat as $row) {
	// 		$balance_amount = (float) $row['amount'] - (float) $row['paid_amount'];
	// 		if ($balance_amount < 0)
	// 			$balance_amount = 0;
	// 		if ($row['booking_status'] == 3) {
	// 			$txt = 'Cancelled';
	// 		} else {

	// 			if (empty($balance_amount)) {
	// 				$txt = 'Paid';
	// 			} else {
	// 				$txt = 'Partially Paid';
	// 			}
	// 		}
	// 		$data[] = array(
	// 			"s_no" => $i++,
	// 			"entry_date" => date('d-m-Y', strtotime($row['entry_date'])),
	// 			"date" => date('d-m-Y', strtotime($row['booking_date'])),
	// 			"pname" => $row['pname'],
	// 			"name" => $row['name'],
	// 			"amount" => $row['amount'],
	// 			"paid" => $row['paid_amount'],
	// 			// "bal" => $balance_amount,
	// 			"status" => $txt
	// 		);
	// 	}
	// 	return $data;
	// }

	// public function ubayam_rep_ref_temple()
	// {
	// 	$fdt = date('Y-m-d', strtotime($_POST['fdt']));
	// 	$tdt = date('Y-m-d', strtotime($_POST['tdt']));
	// 	$cdt = isset($_POST['cdt']) && !empty($_POST['cdt']) ? date('Y-m-d', strtotime($_POST['cdt'])) : null;
	// 	$group_filter = $_POST['group_filter'];
	// 	$booking_type = $_POST['booking_type'];

	// 	$data = [];
	// 	$dat = $this->db->table('templebooking')
	// 		->join('booked_packages', 'booked_packages.booking_id = templebooking.id')
	// 		->select('booked_packages.name as pname')
	// 		->select('templebooking.*,templebooking.mobile_code, templebooking.mobile_no,templebooking.ref_no, templebooking.description')
	// 		->where('templebooking.booking_type', $booking_type)
	// 		->where('DATE_FORMAT(templebooking.entry_date, "%Y-%m-%d") >=', $fdt);
	// 	$dat = $dat->where('DATE_FORMAT(templebooking.entry_date, "%Y-%m-%d") <=', $tdt);

	// 	if (!empty($cdt)) {
	// 		$dat = $dat->where('templebooking.booking_date =', $cdt);
	// 	}

	// 	if (!empty($group_filter) && $group_filter != "0") {
	// 		if ($group_filter === 'full') {
	// 			$dat = $dat->where('templebooking.total_amount = templebooking.paid_amount');
	// 		} elseif ($group_filter === 'partial') {
	// 			$dat = $dat->where('templebooking.paid_amount > 0')->where('templebooking.paid_amount < templebooking.total_amount');
	// 		} elseif ($group_filter === 'only_booking') {
	// 			$dat = $dat->where('templebooking.paid_amount =', 0);
	// 		}
	// 	}

	// 	$dat = $dat->orderBy('templebooking.id', 'desc');
	// 	$dat = $dat->get()->getResultArray();

	// 	$i = 1;
	// 	$total_amount = 0;
	// 	$total_paid = 0;
	// 	$total_balance = 0;
	// 	$totalByCategory = [];
	// 	foreach ($dat as $row) {
	// 		$total_amount += (float) $row['total_amount'];
	// 		$total_paid += (float) $row['paid_amount'];

	// 		//$balance_amount = (float) $row['total_amount'] - (float) $row['paid_amount'];
	// 		$getpaid = $this->db->table("booked_pay_details")->selectSum('amount')->where("booking_id", $row['id'])->get()->getRowArray();
	// 		$paidamount = (float) $getpaid['amount'];
	// 		$balance_amount = (float) $row['total_amount'] - (float) $getpaid['amount'];

	// 		if ($balance_amount < 0)
	// 			$balance_amount = 0;
	// 		$total_balance += $balance_amount;

	// 		if ($row['booking_status'] == 3) {
	// 			$txt = '<span class="cancel_text">Cancelled</span>';
	// 		} else {
	// 			if (empty($balance_amount)) {
	// 				$txt = '<span class="paid_text">Paid</span>';
	// 			} elseif ($row['paid_amount'] > 0) {
	// 				$txt = '<span class="unpaid_text">Partially Paid</span>';
	// 			} else {
	// 				$txt = '<span class="not_paid">Only Booked</span>';
	// 			}
	// 		}

	// 		if ($balance_amount && $row['payment_status'] == 1 || $row['payment_status'] == 0) {
	// 			$print = '<a class="btn btn-warning btn-rad" title="Print" href="' . base_url() . '/templeubayam_online/print_page_ubayam/' . $row['id'] . '" target="_blank"><i class="fa fa-print"></i> </a>  <a class="btn btn-primary btn-rad btn-payment" title="Edit" href="' . base_url() . '/report/show_loan_history/' . $row['id'] . '"><i class="fa fa-credit-card"></i></a>';
	// 		} else if ($row['payment_status'] == 2 || $row['booking_status'] == 3) {
	// 			$print = '<a class="btn btn-warning btn-rad" title="Print" href="' . base_url() . '/templeubayam_online/print_page_ubayam/' . $row['id'] . '" target="_blank"><i class="fa fa-print"></i> </a>';
	// 		} else {
	// 			$print = "";
	// 		}

	// 		if ($row['booking_status'] != 3) {
	// 			$action = '<a class="btn btn-warning btn-rad btn-cancel btn-danger" title="Print" href="' . base_url() . '/hallbooking_online/print_page_hall/' . $row['id'] . '" target="_blank"><i class="fa fa-times"></i> </a>';
	// 		} else {
	// 			$action = "";
	// 		}
	// 		// Combine mobile code and mobile number
	// 		$mobile_display = '-';
	// 		if (!empty($row['mobile_no'])) {
	// 			$mobile_code = !empty($row['mobile_code']) ? $row['mobile_code'] : '';
	// 			$mobile_display = $mobile_code . ' ' . $row['mobile_no'];
	// 		}
	// 		$data[] = array(
	// 			$i++,
	// 			date('d-m-Y', strtotime($row['entry_date'])),
	// 			date('d-m-Y', strtotime($row['booking_date'])),
	// 			$row['ref_no'] ?? '-',
	// 			$row['pname'],

	// 			$row['name'],
	// 			$mobile_display,
	// 			$row['total_amount'],
	// 			//$row['paid_amount'],
	// 			number_format($paidamount, 2),
	// 			number_format($balance_amount, 2),
	// 			$row['description'] ?? '-',
	// 			$txt,
	// 			$print,
	// 			$action
	// 		);
	// 	}

	// 	$totalByCategory[] = array(
	// 		'total_amount' => $total_amount,
	// 		'paid_amount' => $total_paid,
	// 		'balance_amount' => $total_balance
	// 	);

	// 	$result = array(
	// 		"draw" => 0,
	// 		"recordsTotal" => $i - 1,
	// 		"recordsFiltered" => $i - 1,
	// 		"data" => $data,
	// 		"totals" => $totalByCategory,
	// 	);

	// 	echo json_encode($result);
	// 	exit();
	// }
	public function ubayam_rep_ref_temple()
	{
		$fdt = date('Y-m-d', strtotime($_POST['fdt']));
		$tdt = date('Y-m-d', strtotime($_POST['tdt']));
		$cdt = isset($_POST['cdt']) && !empty($_POST['cdt']) ? date('Y-m-d', strtotime($_POST['cdt'])) : null;
		$group_filter = $_POST['group_filter'];
		$booking_type = $_POST['booking_type'];

		$data = [];
		$dat = $this->db->table('templebooking')
			->join('booked_packages', 'booked_packages.booking_id = templebooking.id')
			->select('booked_packages.name as pname')
			->select('templebooking.*,templebooking.mobile_code, templebooking.mobile_no,templebooking.ref_no, templebooking.description')
			->where('templebooking.booking_type', $booking_type)
			->where('DATE_FORMAT(templebooking.entry_date, "%Y-%m-%d") >=', $fdt);
		$dat = $dat->where('DATE_FORMAT(templebooking.entry_date, "%Y-%m-%d") <=', $tdt);

		if (!empty($cdt)) {
			$dat = $dat->where('templebooking.booking_date =', $cdt);
		}

		if (!empty($group_filter) && $group_filter != "0") {
			if ($group_filter === 'full') {
				$dat = $dat->where('templebooking.total_amount = templebooking.paid_amount');
			} elseif ($group_filter === 'partial') {
				$dat = $dat->where('templebooking.paid_amount > 0')->where('templebooking.paid_amount < templebooking.total_amount');
			} elseif ($group_filter === 'only_booking') {
				$dat = $dat->where('templebooking.paid_amount =', 0);
			}
		}

		$dat = $dat->orderBy('templebooking.id', 'desc');
		$dat = $dat->get()->getResultArray();

		$i = 1;
		$total_amount = 0;
		$total_paid = 0;
		$total_balance = 0;
		$totalByCategory = [];
		foreach ($dat as $row) {
			$total_amount += (float) $row['total_amount'];
			$total_paid += (float) $row['paid_amount'];

			//$balance_amount = (float) $row['total_amount'] - (float) $row['paid_amount'];
			$getpaid = $this->db->table("booked_pay_details")->selectSum('amount')->where("booking_id", $row['id'])->get()->getRowArray();
			$paidamount = (float) $getpaid['amount'];
			$balance_amount = (float) $row['total_amount'] - (float) $getpaid['amount'];

			if ($balance_amount < 0)
				$balance_amount = 0;
			$total_balance += $balance_amount;

			if ($row['booking_status'] == 3) {
				$txt = '<span class="cancel_text">Cancelled</span>';
			} else {
				if (empty($balance_amount)) {
					$txt = '<span class="paid_text">Paid</span>';
				} elseif ($row['paid_amount'] > 0) {
					$txt = '<span class="unpaid_text">Partially Paid</span>';
				} else {
					$txt = '<span class="not_paid">Only Booked</span>';
				}
			}

			if ($balance_amount && $row['payment_status'] == 1 || $row['payment_status'] == 0) {
				$print = '<a class="btn btn-warning btn-rad" title="Print" href="' . base_url() . '/templeubayam_online/print_page_ubayam/' . $row['id'] . '" target="_blank"><i class="fa fa-print"></i> </a>  <a class="btn btn-primary btn-rad btn-payment" title="Edit" href="' . base_url() . '/report/show_loan_history/' . $row['id'] . '"><i class="fa fa-credit-card"></i></a>';
			} else if ($row['payment_status'] == 2 || $row['booking_status'] == 3) {
				$print = '<a class="btn btn-warning btn-rad" title="Print" href="' . base_url() . '/templeubayam_online/print_page_ubayam/' . $row['id'] . '" target="_blank"><i class="fa fa-print"></i> </a>';
			} else {
				$print = "";
			}

			if ($row['booking_status'] != 3) {
				$action = '<a class="btn btn-warning btn-rad btn-cancel btn-danger" title="Cancel" href="' . base_url() . '/hallbooking_online/print_page_hall/' . $row['id'] . '" target="_blank"><i class="fa fa-times"></i> </a>';
				$action .= ' <a class="btn btn-primary btn-rad btn-edit-booking" title="Edit" data-id="' . $row['id'] . '" data-name="' . htmlspecialchars($row['name'], ENT_QUOTES) . '" data-booking-date="' . $row['booking_date'] . '" data-booking-type="' . $row['booking_type'] . '" data-remarks="' . htmlspecialchars($row['remarks'] ?? '', ENT_QUOTES) . '" href="javascript:void(0);"><i class="fa fa-edit"></i></a>';
			} else {
				$action = "";
			}
			// Combine mobile code and mobile number
			$mobile_display = '-';
			if (!empty($row['mobile_no'])) {
				$mobile_code = !empty($row['mobile_code']) ? $row['mobile_code'] : '';
				$mobile_display = $mobile_code . ' ' . $row['mobile_no'];
			}
			$data[] = array(
				$i++,
				date('d-m-Y', strtotime($row['entry_date'])),
				date('d-m-Y', strtotime($row['booking_date'])),
				$row['ref_no'] ?? '-',
				$row['pname'],

				$row['name'],
				$mobile_display,
				$row['total_amount'],
				//$row['paid_amount'],
				number_format($paidamount, 2),
				number_format($balance_amount, 2),
				$row['description'] ?? '-',
				$txt,
				$print,
				$action
			);
		}

		$totalByCategory[] = array(
			'total_amount' => $total_amount,
			'paid_amount' => $total_paid,
			'balance_amount' => $total_balance
		);

		$result = array(
			"draw" => 0,
			"recordsTotal" => $i - 1,
			"recordsFiltered" => $i - 1,
			"data" => $data,
			"totals" => $totalByCategory,
		);

		echo json_encode($result);
		exit();
	}
	public function offering_report()
	{
		$data['list'] = $this->db->table('product_offering')->get()->getResultArray();
		$data['offer'] = $this->db->table('offering_category')->get()->getResultArray();
		echo view('frontend/layout/header');
		echo view('frontend/report/offering_report', $data);
	}

	public function offering_rep_ref()
	{
		$fdt = date('Y-m-d', strtotime($_POST['fdt']));
		$tdt = date('Y-m-d', strtotime($_POST['tdt']));
		$type = $_POST['type'];
		$ptype = $_POST['ptype'];
		$data = [];

		$dat = $this->db->table('product_offering po')
			->join('product_offering_detail pod', 'pod.pro_off_id = po.id')
			->join('product_category pc', 'pc.id = pod.product_id')
			->join('offering_category oc', 'oc.id = pod.offering_id')
			->select('po.*, pod.*, po.id as main_id, pc.name as product_name, oc.name as category_name')
			->where('DATE_FORMAT(po.date, "%Y-%m-%d") >=', $fdt);
		$dat = $dat->where('DATE_FORMAT(po.date, "%Y-%m-%d") <=', $tdt);

		if (!empty($type)) {
			$dat = $dat->where('pod.offering_id =', $type);
		}

		if (!empty($ptype)) {
			$dat = $dat->where('pod.product_id =', $ptype);
		}

		$dat = $dat->orderBy('po.id', 'desc');
		$qry = $dat->get()->getResultArray();

		$totalGramsByCategory = [];
		$i = 1;
		foreach ($qry as $row) {
			$data[] = array(
				$i++,
				$row['date'],
				$row['ref_no'],
				'<p style="text-align:left;">' . $row['name'] . '</p>',
				$row['phone'],
				$row['category_name'],
				$row['product_name'],
				$row['grams'],
				$row['quantity'],
				$print = '<a class="btn btn-warning btn-rad" title="Print" href="' . base_url() . '/offering_online/print_offering/' . $row['main_id'] . '" target="_blank"><i class="fa fa-print"></i> </a>'
				//$print
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

	public function outdoor_report()
	{
		if (!empty($_POST['fdt']))
			$from_date = $_POST['fdt'];
		else
			$from_date = date('Y-m-01');

		if (!empty($_POST['tdt']))
			$to_date = $_POST['tdt'];
		else
			$to_date = date('Y-m-d');

		$cdt = isset($_POST['cdt']) && !empty($_POST['cdt']) ? date('Y-m-d', strtotime($_POST['cdt'])) : null;
		$group_filter = $_POST['group_filter'];
		$data['fdt'] = $from_date;
		$data['tdt'] = $to_date;
		$data['cdt'] = $cdt;
		$data['payment_modes'] = $this->db->table('payment_mode')->where("paid_through", "COUNTER")->where("outdoor", 1)->where('status', 1)->orderby('menu_order', "ASC")->get()->getResultArray();
		echo view('frontend/layout/header');
		echo view('frontend/report/outdoor_report', $data);
	}

	public function outdoor_rep_ref()
	{
		$fdt = date('Y-m-d', strtotime($_POST['fdt']));
		$tdt = date('Y-m-d', strtotime($_POST['tdt']));
		$cdt = isset($_POST['cdt']) && !empty($_POST['cdt']) ? date('Y-m-d', strtotime($_POST['cdt'])) : null;
		$group_filter = $_POST['group_filter'];

		$data = [];
		$dat = $this->db->table('outdoor_booking', 'temple_packages.name as pname')
			->join('temple_packages', 'temple_packages.id = outdoor_booking.package_id')
			->select('temple_packages.name as pname')
			->select('outdoor_booking.*')
			->where('DATE_FORMAT(outdoor_booking.date, "%Y-%m-%d") >=', $fdt);
		$dat = $dat->where('DATE_FORMAT(outdoor_booking.date, "%Y-%m-%d") <=', $tdt);

		if (!empty($cdt)) {
			$dat = $dat->where('outdoor_booking.event_date =', $cdt);
		}

		if (!empty($group_filter) && $group_filter != "0") {
			$dat = $dat->where('outdoor_booking.payment_type', $group_filter);
		}

		$dat = $dat->orderBy('outdoor_booking.date', 'desc');
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

			if ($row['amount'] - $row['paid_amount'] && $row['payment_type'] == "partial") {
				$print = '<a class="btn btn-warning btn-rad" title="Print" href="' . base_url() . '/outdoor_online/print_page/' . $row['id'] . '" target="_blank"><i class="fa fa-print"></i> </a>   <a class="btn btn-warning btn-payment btn-rad" title="Pay" href=" ' . base_url() . '/annathanam_new/payment/' . $row['id'] . '" target="_blank"><i class="fa fa-credit-card"></i> </a>';
			} else if ($row['payment_type'] == 'full') {
				$print = '<a class="btn btn-warning btn-rad" title="Print" href="' . base_url() . '/outdoor_online/print_page/' . $row['id'] . '" target="_blank"><i class="fa fa-print"></i> </a>';
			} else {
				$print = "";
			}

			$data[] = array(
				$i++,
				date('d-m-Y', strtotime($row['date'])),
				date('d-m-Y', strtotime($row['event_date'])),
				$row['pname'],
				$row['name'],
				$row['amount'],
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

	public function print_outdoor_report()
	{
		$data['fdate'] = $_REQUEST['fdt'];
		$data['tdate'] = $_REQUEST['tdt'];
		if (!empty($_REQUEST['cdt'])) {
			$data['cdate'] = $_REQUEST['cdt'];
		}
		$data['group_filter'] = $_REQUEST['group_filter'];
		$tmpid = 1;
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
		if ($_REQUEST['pdf_outdoorreport'] == "PDF") {

			$file_name = "Outdoor_services_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$dompdf = new \Dompdf\Dompdf();
			$options = $dompdf->getOptions();
			$options->set(array('isRemoteEnabled' => true));
			$dompdf->setOptions($options);
			$dompdf->loadHtml(view('frontend/report/pdf/outdoor_print_temple', ["pdfdata" => $data]));
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$dompdf->stream($file_name);
		} elseif ($_REQUEST['excel_outdoorreport'] == "EXCEL") {
			$fileName = "Outdoor_services_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
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
			$sheet->setCellValue('A1', $data['temp_details']['name']);
			$sheet->setCellValue('A2', 'S.No');
			$sheet->setCellValue('B2', 'Booking Date');
			$sheet->setCellValue('C2', 'Event Date');
			$sheet->setCellValue('D2', 'Event Name');
			$sheet->setCellValue('E2', 'Name');
			$sheet->setCellValue('F2', 'Amount');
			$sheet->setCellValue('G2', 'Status');
			$rows = 3;
			$si = 1;
			$excel_format_data = $this->excel_format_get_outdoor_report($data['fdate'], $data['tdate'], $data['cdate'], $data['group_filter']);
			//var_dump($excel_format_data);
			//exit;
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
			echo view('frontend/report/outdoor_print_temple', $data);
		}
	}

	public function excel_format_get_outdoor_report($fdata, $tdata, $cdata, $group_filter)
	{
		$fdt = date('Y-m-d', strtotime($fdata));
		$tdt = date('Y-m-d', strtotime($tdata));
		$group_filter_fill = $group_filter;
		if (!empty($cdata)) {
			$cdt = date('Y-m-d', strtotime($cdata));
		}
		$data = [];
		$dat = $this->db->table('outdoor_booking')
			->join('temple_packages', 'temple_packages.id = outdoor_booking.package_id')
			->select('temple_packages.name as pname')
			->select('outdoor_booking.*')
			->where('DATE_FORMAT(outdoor_booking.date, "%Y-%m-%d") >=', $fdt);
		$dat = $dat->where('DATE_FORMAT(outdoor_booking.date, "%Y-%m-%d") <=', $tdt);

		if (!empty($cdt)) {
			$dat = $dat->where('outdoor_booking.event_date =', $cdt);
		}

		if (!empty($group_filter_fill) && $group_filter_fill != "0") {
			$dat = $dat->where('outdoor_booking.payment_type', $group_filter_fill);
		}
		$dat = $dat->orderBy('date', 'desc');
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
				"entry_date" => date('d-m-Y', strtotime($row['date'])),
				"date" => date('d-m-Y', strtotime($row['event_date'])),
				"pname" => $row['pname'],
				"name" => $row['name'],
				"amount" => $row['amount'],
				"status" => $txt
			);
		}
		return $data;
	}

	public function madapalli()
	{
		if (!empty($_POST['fdt']))
			$from_date = $_POST['fdt'];
		else
			$from_date = date('Y-m-d');

		$details = $this->db->table('madapalli_preparation_details')
			->select('type, product_id, pro_name_eng, pro_name_tamil, SUM(quantity) as total_quantity, session')
			->where('date', $from_date)
			->where('is_additional', 0)
			->groupBy('product_id, session')
			->orderBy('session', 'asc')
			->get()
			->getResultArray();

		$prasadam = [];
		$annathanam = [];
		$catering = [];

		foreach ($details as $detail) {
			$product_data = [
				'product_id' => $detail['product_id'],
				'name' => $detail['pro_name_eng'] . ' / ' . $detail['pro_name_tamil'],
				'quantity' => $detail['total_quantity'],
				'session' => $detail['session']
			];

			if ($detail['type'] == 1) {
				if (!isset($prasadam[$detail['session']])) {
					$prasadam[$detail['session']] = [];
				}
				$prasadam[$detail['session']][$detail['product_id']] = $product_data;
			} elseif ($detail['type'] == 2) {
				if (!isset($annathanam[$detail['session']])) {
					$annathanam[$detail['session']] = [];
				}
				$annathanam[$detail['session']][$detail['product_id']] = $product_data;
			} elseif ($detail['type'] == 3) {
				if (!isset($catering[$detail['session']])) {
					$catering[$detail['session']] = [];
				}
				$catering[$detail['session']][$detail['product_id']] = $product_data;
			}
		}

		$additional = [];
		$addi_details = $this->db->table('madapalli_preparation_details')
			->select('type, product_id, pro_name_eng, SUM(quantity) as total_quantity, session')
			->where('date =', $from_date)
			->whereIn('type', [2, 3])
			->where('is_additional', 1)
			->groupBy('pro_name_eng, session')
			->orderBy('session', 'asc')
			->get()
			->getResultArray();

		if (!empty($addi_details)) {
			foreach ($addi_details as $addi) {
				if ($addi['type'] == 2) {
					$type_key = 'annathanam';
				} elseif ($addi['type'] == 3) {
					$type_key = 'catering';
				}

				if (!isset($additional[$type_key][$addi['session']])) {
					$additional[$type_key][$addi['session']] = [];
				}

				$product_name = $addi['pro_name_eng'];

				if (isset($additional[$type_key][$addi['session']][$product_name])) {
					$additional[$type_key][$addi['session']][$product_name]['quantity'] += $addi['total_quantity'];
				} else {
					$additional[$type_key][$addi['session']][$product_name] = [
						'product_id' => $addi['product_id'],  // keep product id
						'name' => $product_name,
						'quantity' => $addi['total_quantity'],
						'session' => $addi['session']
					];
				}
			}
		}


		$data['from_date'] = $from_date;
		$data['prasadam'] = $prasadam;
		$data['annathanam'] = $annathanam;
		$data['catering'] = $catering;
		$data['additional'] = $additional;

		// echo '<pre>';
		// print_r($data);
		// exit;

		echo view('frontend/layout/header');
		echo view('frontend/report/madapalli_report', $data);
	}

	public function madapalli_print_a4()
	{
		$from_date = $this->request->getGet('from_date');

		$data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
		$details = $this->db->table('madapalli_preparation_details')
			->select('type, product_id, pro_name_eng, pro_name_tamil, SUM(quantity) as total_quantity, session')
			->where('date', $from_date)
			->where('is_additional', 0)
			->groupBy('product_id, session')
			->orderBy('session', 'asc')
			->get()
			->getResultArray();

		$prasadam = [];
		$annathanam = [];
		$catering = [];

		foreach ($details as $detail) {
			$product_data = [
				'product_id' => $detail['product_id'],
				'name' => $detail['pro_name_eng'] . ' / ' . $detail['pro_name_tamil'],
				'quantity' => $detail['total_quantity'],
				'session' => $detail['session']
			];

			if ($detail['type'] == 1) {
				if (!isset($prasadam[$detail['session']])) {
					$prasadam[$detail['session']] = [];
				}
				$prasadam[$detail['session']][$detail['product_id']] = $product_data;
			} elseif ($detail['type'] == 2) {
				if (!isset($annathanam[$detail['session']])) {
					$annathanam[$detail['session']] = [];
				}
				$annathanam[$detail['session']][$detail['product_id']] = $product_data;
			} elseif ($detail['type'] == 3) {
				if (!isset($catering[$detail['session']])) {
					$catering[$detail['session']] = [];
				}
				$catering[$detail['session']][$detail['product_id']] = $product_data;
			}
		}

		$additional = [];
		$addi_details = $this->db->table('madapalli_preparation_details')
			->select('type, product_id, pro_name_eng, SUM(quantity) as total_quantity, session')
			->where('date =', $from_date)
			->whereIn('type', [2, 3])
			->where('is_additional', 1)
			->groupBy('pro_name_eng, session')
			->orderBy('session', 'asc')
			->get()
			->getResultArray();

		if (!empty($addi_details)) {
			foreach ($addi_details as $addi) {
				if ($addi['type'] == 2) {
					$type_key = 'annathanam';
				} elseif ($addi['type'] == 3) {
					$type_key = 'catering';
				}

				if (!isset($additional[$type_key][$addi['session']])) {
					$additional[$type_key][$addi['session']] = [];
				}

				$product_name = $addi['pro_name_eng'];

				if (isset($additional[$type_key][$addi['session']][$product_name])) {
					$additional[$type_key][$addi['session']][$product_name]['quantity'] += $addi['total_quantity'];
				} else {
					$additional[$type_key][$addi['session']][$product_name] = [
						'product_id' => $addi['product_id'],
						'name' => $product_name,
						'quantity' => $addi['total_quantity'],
						'session' => $addi['session']
					];
				}
			}
		}

		$data['from_date'] = $from_date;
		$data['prasadam'] = $prasadam;
		$data['annathanam'] = $annathanam;
		$data['catering'] = $catering;
		$data['additional'] = $additional;

		echo view('frontend/report/madapalli_print', $data);
	}

	public function madapalli_print_a4_old()
	{
		$from_date = $this->request->getGet('from_date');

		$data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
		$details = $this->db->table('madapalli_preparation_details')
			->select('type, product_id, pro_name_eng, pro_name_tamil, SUM(quantity) as total_quantity, session')
			->where('date 	=', $from_date)
			->groupBy('product_id, session')
			->orderBy('session', 'asc')
			->get()
			->getResultArray();

		$prasadam = [];
		$annathanam = [];

		foreach ($details as $detail) {
			$product_data = [
				'product_id' => $detail['product_id'],
				'name' => $detail['pro_name_eng'] . ' / ' . $detail['pro_name_tamil'],
				'quantity' => $detail['total_quantity'],
				'session' => $detail['session']
			];

			if ($detail['type'] == 1) {
				if (!isset($prasadam[$detail['session']])) {
					$prasadam[$detail['session']] = [];
				}

				$prasadam[$detail['session']][$detail['product_id']] = $product_data;
			} elseif ($detail['type'] == 2) {
				if (!isset($annathanam[$detail['session']])) {
					$annathanam[$detail['session']] = [];
				}

				$annathanam[$detail['session']][$detail['product_id']] = $product_data;
			}
		}

		$data['from_date'] = $from_date;
		$data['prasadam'] = $prasadam;
		$data['annathanam'] = $annathanam;

		echo view('frontend/report/madapalli_print', $data);
	}

	public function get_madapalli_user_details()
	{
		$date = !empty($_POST['date']) ? $_POST['date'] : date('Y-m-d');
		$id = !empty($_POST['id']) ? $_POST['id'] : null;
		$session = !empty($_POST['session']) ? $_POST['session'] : null;
		$type = !empty($_POST['type']) ? $_POST['type'] : null;
		$name = !empty($_POST['name']) ? $_POST['name'] : null;
		$additional = !empty($_POST['additional']) ? $_POST['additional'] : null;

		$dat = $this->db->table('madapalli_booking_details')
			->select('customer_name as name, customer_mobile as mobile, amount, quantity, session, serve_time')
			->where('date', $date)
			->where('session', $session)
			->where('type', $type);
		if ($additional == 1) {
			$dat = $dat->where('pro_name_eng', $name);
		} else {
			$dat = $dat->where('product_id', $id);
		}
		$data['list'] = $dat->get()->getResultArray();

		echo json_encode($data);
	}

	public function get_prasadam_payment_mode()
	{
		$id = $_POST['id'];
		$res = $this->db->table("prasadam")->where("id", $id)->get()->getRowArray();

		$res1 = $this->db->table("prasadam_payment_gateway_datas")->select('pay_method')->where("prasadam_id", $id)->get()->getRowArray();
		$data['pay_method'] = $res1['pay_method'];
		$data['payment_mode'] = $res['payment_mode'];

		echo json_encode($data);
	}

	public function save_prasadam_payment_mode()
	{
		if (!empty($_POST['booking_id']) && !empty($_POST['payment_mode'])) {

			$newPayModeId = $_POST['payment_mode'];
			$bookingId = $_POST['booking_id'];

			$bookings = $this->db->table('prasadam')->where('id', $bookingId)->get()->getRowArray();
			$gateway_data = $this->db->table('prasadam_payment_gateway_datas')->where('prasadam_id', $bookingId)->get()->getRowArray();
			if (!empty($gateway_data['id'])) {

				$new_payMode = $this->db->table('payment_mode')->where('id', $newPayModeId)->get()->getRowArray();
				$old_payMode = $this->db->table('payment_mode')->where('id', $bookings['payment_mode'])->get()->getRowArray();
				if (!empty($old_payMode['ledger_id'])) {
					if (!empty($new_payMode['ledger_id'])) {

						$old_ledgers = $this->db->table('ledgers')->where('id', $old_payMode['ledger_id'])->get()->getRowArray();
						$new_ledgers = $this->db->table('ledgers')->where('id', $new_payMode['ledger_id'])->get()->getRowArray();

						if (!empty($old_ledgers['id'])) {
							if (!empty($new_ledgers['id'])) {

								$newPayMethodName = $new_payMode['name'];
								$newLedgerId = $new_ledgers['id'];

								$entry = $this->db->table("entries")->where('type', 10)->where('entrytype_id', 1)->where('inv_id', $bookingId)->get()->getRowArray();
								if (!empty($entry['id'])) {

									$entryItem = $this->db->table("entryitems")->where('entry_id', $entry['id'])->where('ledger_id', $old_ledgers['id'])->get()->getRowArray();
									if (!empty($entryItem['id'])) {

										if ($old_ledgers['reconciliation'] == 1) {
											if ($entryItem['clearancemode'] == 'CLEARED') {
												echo json_encode(['status' => false, 'message' => 'This Transaction has been Reconcialated, We cannot change this Payment Mode']);
												return;
											}
										} elseif ($old_ledgers['aging'] == 1) {
											if ($entryItem['agingmode'] == 'CLEARED') {
												echo json_encode(['status' => false, 'message' => 'Aging is done for this Transaction, We cannot change this Payment Mode']);
												return;
											}
										}
										$updatebookingtable = $this->db->table("prasadam")->where('id', $bookingId)->update(['payment_mode' => $newPayModeId]);
										$updatePaymentMethod = $this->db->table("prasadam_payment_gateway_datas")->where('prasadam_id', $bookingId)->update(['pay_method' => $newPayMethodName]);
										$entryItem = $this->db->table("entryitems")->where('entry_id', $entry['id'])->where('ledger_id', $old_ledgers['id'])->update(['ledger_id' => $newLedgerId]);

										$logData = [
											'type' => 3,
											'date' => date('Y-m-d'),
											'amount' => $bookings['amount'],
											'old_pay_id' => $old_payMode['id'],
											'old_pay_method' => $old_payMode['name'],
											'new_pay_id' => $newPayModeId,
											'new_pay_method' => $newPayMethodName,
											'booking_id' => $bookingId,
											'entryitems_id' => $entryItem['id']
										];
										$logEntry = $this->db->table("log_paymode_change")->insert($logData);

										if ($logEntry) {
											echo json_encode(['status' => true, 'message' => 'Payment Mode Changed successfully.']);
										} else {
											echo json_encode(['status' => false, 'message' => 'Failed to change Payment mode.']);
										}
									} else {
										echo json_encode(['status' => false, 'message' => 'Entryitems not found for this transaction']);
									}
								} else {
									echo json_encode(['status' => false, 'message' => 'Entry not found for this transaction']);
								}
							} else {
								echo json_encode(['status' => false, 'message' => 'Invalid New Ledger Id']);
							}
						} else {
							echo json_encode(['status' => false, 'message' => 'Invalid Old Ledger Id']);
						}
					} else {
						echo json_encode(['status' => false, 'message' => 'Invalid New Payment Mode']);
					}
				} else {
					echo json_encode(['status' => false, 'message' => 'Invalid Old Payment Mode.']);
				}
			} else {
				echo json_encode(['status' => false, 'message' => 'Booking details not found']);
			}
		} else {
			echo json_encode(['status' => false, 'message' => 'Invalid Details.']);
		}
		exit;
	}

	public function catering_report()
	{
		if (!empty($_POST['fdt']))
			$from_date = $_POST['fdt'];
		else
			$from_date = date('Y-m-01');

		if (!empty($_POST['tdt']))
			$to_date = $_POST['tdt'];
		else
			$to_date = date('Y-m-d');

		$data['payment_modes'] = $this->db->table('payment_mode')->where("paid_through", "COUNTER")->where("catering", 1)->where('status', 1)->orderby('menu_order', "ASC")->get()->getResultArray();
		$data['from_date'] = $from_date;
		$data['to_date'] = $to_date;
		echo view('frontend/layout/header');
		echo view('frontend/report/catering_report', $data);
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

			if ($balance_amount && $row['payment_status'] == 1 && $row['booking_status'] == 1) {
				$print = '<a class="btn btn-primary btn-rad" href="' . base_url() . '/catering_counter/print_page/' . $row['id'] . '" target="_blank"><i class="fa fa-print"></i> </a>  <a class="btn btn-warning btn-payment btn-rad" title="Pay" data-id="' . $row['id'] . '"><i class="fa fa-credit-card"></i></a>';
			} else if ($row['payment_status'] == 2 || $row['booking_status'] == 2 || $row['booking_status'] == 3) {
				$print = '<a class="btn btn-primary btn-rad" href="' . base_url() . '/catering_counter/print_page/' . $row['id'] . '" target="_blank"><i class="fa fa-print"></i> </a>';
			} else {
				$print = "";
			}

			if ($row['booking_status'] != 3) {
				$action = '<a class="btn btn-danger btn-cancel btn-rad" title="Cancel" data-id="' . $row['id'] . '"><i class="fa fa-times"></i> </a>';
			} else {
				$action = "";
			}

			$data[] = array(
				$i++,
				date('d-m-Y', strtotime($row['date'])),
				$row['ref_no'],
				$row['name'],
				$txt,
				$row['pay_method'],
				number_format($row['total_amount'], '2', '.', ','),
				number_format($row['paid_amount'], '2', '.', ','),
				$print,
				$action
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
	// Replace the existing member_report() function and add these methods to Report_online.php

	public function member_report()
	{
		if (!empty($_POST['fdt']))
			$from_date = $_POST['fdt'];
		else
			$from_date = date('Y-m-01');

		if (!empty($_POST['tdt']))
			$to_date = $_POST['tdt'];
		else
			$to_date = date('Y-m-d');

		// Get member status types for filter
		$data['member_status'] = [
			['id' => 'active', 'name' => 'Active'],
			['id' => 'inactive', 'name' => 'Inactive']
		];

		$data['from_date'] = $from_date;
		$data['to_date'] = $to_date;

		echo view('frontend/layout/header');
		echo view('frontend/report/member_report', $data);
	}

	public function member_rep_ref()
	{
		$fdt = date('Y-m-d', strtotime($_POST['fdt']));
		$tdt = date('Y-m-d', strtotime($_POST['tdt']));
		$status_filter = isset($_POST['status_filter']) ? $_POST['status_filter'] : '';
		$name_filter = isset($_POST['name_filter']) ? $_POST['name_filter'] : '';

		$data = [];

		$dat = $this->db->table('member as m')
			->select('m.id, m.name, m.member_no, m.email_address, m.mobile, m.address, m.ic_no, m.created, m.status, m.payment, m.application_fee, m.total_amount')
			->where('DATE_FORMAT(m.created, "%Y-%m-%d") >=', $fdt)
			->where('DATE_FORMAT(m.created, "%Y-%m-%d") <=', $tdt);

		if (!empty($status_filter) && $status_filter !== '') {
			$dat = $dat->where('m.status', $status_filter);
		}

		if (!empty($name_filter)) {
			$dat = $dat->like('m.name', $name_filter);
		}

		$dat = $dat->orderBy('m.id', 'desc');
		$results = $dat->get()->getResultArray();

		foreach ($results as $row) {
			// Format mobile number
			$mobile_display = !empty($row['mobile']) ? $row['mobile'] : '-';

			// Format address
			$address = !empty($row['address']) ? $row['address'] : '-';

			// Return data as associative array with keys matching DataTable columns
			$data[] = array(
				'id' => $row['id'],
				'created' => $row['created'],
				'name' => $row['name'],
				'email_address' => $row['email_address'] ?: '-',
				'mobile' => $mobile_display,
				'member_no' => $row['member_no'] ?: '-',
				'address' => $address,
				'status' => $row['status'],
				'payment' => $row['payment'],
				'application_fee' => $row['application_fee'],
				'total_amount' => $row['total_amount']
			);
		}

		$result = array(
			"draw" => 0,
			"recordsTotal" => count($data),
			"recordsFiltered" => count($data),
			"data" => $data,
		);

		echo json_encode($result);
		exit();
	}

	public function print_memberreport()
	{
		$data['fdate'] = $_REQUEST['fdt'];
		$data['tdate'] = $_REQUEST['tdt'];
		$data['status_filter'] = $_REQUEST['status_filter'] ?? '';
		$data['name_filter'] = $_REQUEST['name_filter'] ?? '';

		$data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();

		if (isset($_REQUEST['pdf_memberreport']) && $_REQUEST['pdf_memberreport'] == "PDF") {
			$file_name = "Member_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$dompdf = new \Dompdf\Dompdf();
			$options = $dompdf->getOptions();
			$options->set(array('isRemoteEnabled' => true));
			$dompdf->setOptions($options);
			$dompdf->loadHtml(view('frontend/report/pdf/member_print', ["pdfdata" => $data]));
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$dompdf->stream($file_name);
		} elseif (isset($_REQUEST['excel_memberreport']) && $_REQUEST['excel_memberreport'] == "EXCEL") {
			$fileName = "Member_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
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
			$sheet->setCellValue('A1', $data['temp_details']['name']);
			$sheet->setCellValue('A2', 'S.No');
			$sheet->setCellValue('B2', 'Registration Date');
			$sheet->setCellValue('C2', 'Member No');
			$sheet->setCellValue('D2', 'Name');
			$sheet->setCellValue('E2', 'Email');
			$sheet->setCellValue('F2', 'Mobile Number');
			$sheet->setCellValue('G2', 'IC Number');
			$sheet->setCellValue('H2', 'Address');
			$sheet->setCellValue('I2', 'Status');

			$rows = 3;
			$excel_format_data = $this->excel_format_get_memberreport($data['fdate'], $data['tdate'], $data['status_filter'], $data['name_filter']);

			foreach ($excel_format_data as $val) {
				$sheet->setCellValue('A' . $rows, $val['s_no']);
				$sheet->setCellValue('B' . $rows, $val['date']);
				$sheet->setCellValue('C' . $rows, $val['member_no']);
				$sheet->setCellValue('D' . $rows, $val['name']);
				$sheet->setCellValue('E' . $rows, $val['email']);
				$sheet->setCellValue('F' . $rows, $val['mobile']);
				$sheet->setCellValue('G' . $rows, $val['ic_no']);
				$sheet->setCellValue('H' . $rows, $val['address']);
				$sheet->setCellValue('I' . $rows, $val['status']);
				$rows++;
			}

			$writer = new Xlsx($spreadsheet);
			$writer->save('uploads/excel/' . $fileName . '.xlsx');
			return $this->response->download('uploads/excel/' . $fileName . '.xlsx', null)->setFileName($fileName . '.xlsx');
		} else {
			echo view('frontend/report/print/member_print', $data);
		}
	}

	public function excel_format_get_memberreport($fdata, $tdata, $status_filter, $name_filter)
	{
		$fdt = date('Y-m-d', strtotime($fdata));
		$tdt = date('Y-m-d', strtotime($tdata));

		$data = [];
		$dat = $this->db->table('member as m')
			->select('m.id, m.name, m.member_no, m.email_address, m.mobile, m.address, m.ic_no, m.created, m.status, m.payment, m.application_fee, m.total_amount')
			->where('DATE_FORMAT(m.created, "%Y-%m-%d") >=', $fdt)
			->where('DATE_FORMAT(m.created, "%Y-%m-%d") <=', $tdt);

		if (!empty($status_filter) && $status_filter !== '') {
			$dat = $dat->where('m.status', $status_filter);
		}

		if (!empty($name_filter)) {
			$dat = $dat->like('m.name', $name_filter);
		}

		$dat = $dat->orderBy('m.created', 'desc');
		$results = $dat->get()->getResultArray();

		$i = 1;
		foreach ($results as $row) {
			$mobile_display = !empty($row['mobile']) ? $row['mobile'] : '-';
			$status = $row['status'] == '1' ? 'Active' : 'Inactive';
			$address = !empty($row['address']) ? $row['address'] : '-';

			$data[] = array(
				"s_no" => $i++,
				"date" => date('d-m-Y', strtotime($row['created'])),
				"member_no" => $row['member_no'] ?: '-',
				"name" => $row['name'],
				"email" => $row['email_address'] ?: '-',
				"mobile" => $mobile_display,
				"ic_no" => $row['ic_no'] ?: '-',
				"address" => $address,
				"status" => $status
			);
		}

		return $data;
	}

	// public function print_offeringreport()
	// {
	// 	// Debug: Use $_POST directly as fallback
	// 	$fdt_input = $this->request->getPost('fdt') ?? $_POST['fdt'] ?? '';
	// 	$tdt_input = $this->request->getPost('tdt') ?? $_POST['tdt'] ?? '';

	// 	// Handle empty dates with proper fallback
	// 	if (!empty($fdt_input) && $fdt_input != '') {
	// 		$fdt = date('Y-m-d', strtotime($fdt_input));
	// 	} else {
	// 		$fdt = date('Y-m-01');
	// 	}

	// 	if (!empty($tdt_input) && $tdt_input != '') {
	// 		$tdt = date('Y-m-d', strtotime($tdt_input));
	// 	} else {
	// 		$tdt = date('Y-m-d');
	// 	}

	// 	// Validate dates - if strtotime failed, use defaults
	// 	if ($fdt == '1970-01-01' || $fdt === false) {
	// 		$fdt = date('Y-m-01');
	// 	}
	// 	if ($tdt == '1970-01-01' || $tdt === false) {
	// 		$tdt = date('Y-m-d');
	// 	}

	// 	$type = $this->request->getPost('offering_id') ?? $_POST['offering_id'] ?? '';
	// 	$ptype = $this->request->getPost('product_id') ?? $_POST['product_id'] ?? '';

	// 	// Get admin/temple profile
	// 	$temp_details = $this->db->table('admin_profile')
	// 		->where('id', 1)
	// 		->get()
	// 		->getRowArray();

	// 	// Fallback if empty
	// 	if (empty($temp_details)) {
	// 		$temp_details = [
	// 			'name' => 'Temple Name',
	// 			'address1' => '',
	// 			'address2' => '',
	// 			'city' => '',
	// 			'postcode' => '',
	// 			'telephone' => '',
	// 			'image' => ''
	// 		];
	// 	}

	// 	// Build query
	// 	$dat = $this->db->table('product_offering po')
	// 		// ->join('product_offering_detail pod', 'pod.pro_off_id = po.id')
	// 		// ->join('product_category pc', 'pc.id = pod.product_id')
	// 		// ->join('offering_category oc', 'oc.id = pod.offering_id')
	// 		// ->select('po.*, pod.*, po.id as main_id, pc.name as product_name, oc.name as category_name')
	// 		->join('product_offering_detail pod', 'pod.pro_off_id = po.id')
	// 		->join('product_category pc', 'pc.id = pod.product_id')
	// 		->join('offering_category oc', 'oc.id = pod.offering_id')
	// 		->select('po.*, pod.*, po.id as main_id, po.ref_no, pc.name as product_name, oc.name as category_name')

	// 		->where('DATE(po.date) >=', $fdt)
	// 		->where('DATE(po.date) <=', $tdt);

	// 	if (!empty($type)) {
	// 		$dat = $dat->where('pod.offering_id', $type);
	// 	}

	// 	if (!empty($ptype)) {
	// 		$dat = $dat->where('pod.product_id', $ptype);
	// 	}

	// 	$dat = $dat->orderBy('po.id', 'desc');
	// 	$offering_details = $dat->get()->getResultArray();

	// 	// Calculate totals by category
	// 	$totalGramsByCategory = [];
	// 	$totalGrams = 0;
	// 	foreach ($offering_details as $row) {
	// 		$totalGrams += (float) $row['grams'];
	// 		if (isset($totalGramsByCategory[$row['category_name']])) {
	// 			$totalGramsByCategory[$row['category_name']] += (float) $row['grams'];
	// 		} else {
	// 			$totalGramsByCategory[$row['category_name']] = (float) $row['grams'];
	// 		}
	// 	}

	// 	// PDF EXPORT
	// 	if (isset($_POST['pdf_stockreport'])) {
	// 		$options = new Options();
	// 		$options->set('isHtml5ParserEnabled', true);
	// 		$options->set('isRemoteEnabled', true);

	// 		$dompdf = new Dompdf($options);

	// 		// Pass data for PDF view
	// 		$pdfdata = [
	// 			'temp_details' => $temp_details,
	// 			'fdate' => $fdt,
	// 			'tdate' => $tdt,
	// 			'type' => $type,
	// 			'ptype' => $ptype,
	// 			'offering_details' => $offering_details,
	// 			'totalByCategory' => $totalGramsByCategory,
	// 			'totalGrams' => $totalGrams
	// 		];

	// 		$html = view('frontend/report/pdf/offering_print', ['pdfdata' => $pdfdata]);

	// 		$dompdf->loadHtml($html);
	// 		$dompdf->setPaper('A4', 'portrait');
	// 		$dompdf->render();

	// 		$filename = 'Offering_Report_' . date('d-m-Y', strtotime($fdt)) . '_to_' . date('d-m-Y', strtotime($tdt)) . '.pdf';
	// 		$dompdf->stream($filename, array('Attachment' => true));
	// 		exit;
	// 	}

	// 	// EXCEL EXPORT
	// 	elseif (isset($_POST['excel_stockreport'])) {
	// 		$spreadsheet = new Spreadsheet();
	// 		$sheet = $spreadsheet->getActiveSheet();
	// 		$sheet->setTitle('Offering Report');

	// 		// Temple Header
	// 		$templeName = $temp_details['name'] ?? 'Temple';
	// 		$sheet->setCellValue('A1', $templeName);
	// 		$sheet->mergeCells('A1:G1');
	// 		$sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
	// 		$sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

	// 		// Address
	// 		$sheet->setCellValue('A2', ($temp_details['address1'] ?? '') . ', ' . ($temp_details['address2'] ?? ''));
	// 		$sheet->mergeCells('A2:G2');
	// 		$sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

	// 		// Report Title
	// 		$sheet->setCellValue('A4', 'OFFERING REPORT');
	// 		$sheet->mergeCells('A4:G4');
	// 		$sheet->getStyle('A4')->getFont()->setBold(true)->setSize(14);
	// 		$sheet->getStyle('A4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

	// 		// Date Range
	// 		$sheet->setCellValue('A5', 'Period: ' . date('d-m-Y', strtotime($fdt)) . ' to ' . date('d-m-Y', strtotime($tdt)));
	// 		$sheet->mergeCells('A5:G5');
	// 		$sheet->getStyle('A5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

	// 		// Headers
	// 		$headers = ['S.No', 'Date', 'Name', 'Phone', 'Category', 'Product', 'Grams'];
	// 		$col = 'A';
	// 		foreach ($headers as $header) {
	// 			$sheet->setCellValue($col . '7', $header);
	// 			$col++;
	// 		}

	// 		// Header Styling
	// 		$headerStyle = [
	// 			'font' => ['bold' => true],
	// 			'fill' => [
	// 				'fillType' => Fill::FILL_SOLID,
	// 				'startColor' => ['rgb' => 'F7EBBB']
	// 			],
	// 			'borders' => [
	// 				'allBorders' => ['borderStyle' => Border::BORDER_THIN]
	// 			],
	// 			'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
	// 		];
	// 		$sheet->getStyle('A7:G7')->applyFromArray($headerStyle);

	// 		// Data Rows
	// 		$row = 8;
	// 		$i = 1;
	// 		foreach ($offering_details as $detail) {
	// 			$sheet->setCellValue('A' . $row, $i++);
	// 			$sheet->setCellValue('B' . $row, date('d-m-Y', strtotime($detail['date'])));
	// 			$sheet->setCellValue('C' . $row, $detail['name']);
	// 			$sheet->setCellValue('D' . $row, $detail['phone']);
	// 			$sheet->setCellValue('E' . $row, $detail['category_name']);
	// 			$sheet->setCellValue('F' . $row, $detail['product_name']);
	// 			$sheet->setCellValue('G' . $row, $detail['grams']);
	// 			$row++;
	// 		}

	// 		// Apply borders to data
	// 		$dataStyle = [
	// 			'borders' => [
	// 				'allBorders' => ['borderStyle' => Border::BORDER_THIN]
	// 			]
	// 		];
	// 		$lastDataRow = $row - 1;
	// 		if ($lastDataRow >= 8) {
	// 			$sheet->getStyle('A8:G' . $lastDataRow)->applyFromArray($dataStyle);
	// 		}

	// 		// Category Totals Section
	// 		$row += 1;
	// 		foreach ($totalGramsByCategory as $category => $grams) {
	// 			$sheet->setCellValue('E' . $row, 'Total ' . $category . ':');
	// 			$sheet->setCellValue('G' . $row, number_format($grams, 2));
	// 			$sheet->getStyle('E' . $row . ':G' . $row)->getFont()->setBold(true);
	// 			$row++;
	// 		}

	// 		// Grand Total
	// 		$sheet->setCellValue('E' . $row, 'Grand Total:');
	// 		$sheet->setCellValue('G' . $row, number_format($totalGrams, 2));
	// 		$sheet->getStyle('E' . $row . ':G' . $row)->getFont()->setBold(true);
	// 		$sheet->getStyle('E' . $row . ':G' . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('E2DFDF');

	// 		// Column Widths
	// 		$sheet->getColumnDimension('A')->setWidth(8);
	// 		$sheet->getColumnDimension('B')->setWidth(12);
	// 		$sheet->getColumnDimension('C')->setWidth(25);
	// 		$sheet->getColumnDimension('D')->setWidth(15);
	// 		$sheet->getColumnDimension('E')->setWidth(20);
	// 		$sheet->getColumnDimension('F')->setWidth(20);
	// 		$sheet->getColumnDimension('G')->setWidth(12);

	// 		// Output
	// 		$filename = 'Offering_Report_' . date('d-m-Y', strtotime($fdt)) . '_to_' . date('d-m-Y', strtotime($tdt)) . '.xlsx';

	// 		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	// 		header('Content-Disposition: attachment;filename="' . $filename . '"');
	// 		header('Cache-Control: max-age=0');

	// 		$writer = new Xlsx($spreadsheet);
	// 		$writer->save('php://output');
	// 		exit;
	// 	}

	// 	// REGULAR PRINT VIEW
	// 	else {
	// 		$data = [
	// 			'temp_details' => $temp_details,
	// 			'fdate' => $fdt,
	// 			'tdate' => $tdt,
	// 			'type' => $type,
	// 			'ptype' => $ptype,
	// 			'offering_details' => $offering_details,
	// 			'totalByCategory' => $totalGramsByCategory,
	// 			'totalGrams' => $totalGrams
	// 		];
	// 		return view('frontend/report/offering_print', $data);
	// 	}
	// }
	public function print_offeringreport()
	{
		// Debug: Use $_POST directly as fallback
		$fdt_input = $this->request->getPost('fdt') ?? $_POST['fdt'] ?? '';
		$tdt_input = $this->request->getPost('tdt') ?? $_POST['tdt'] ?? '';

		// Handle empty dates with proper fallback
		if (!empty($fdt_input) && $fdt_input != '') {
			$fdt = date('Y-m-d', strtotime($fdt_input));
		} else {
			$fdt = date('Y-m-01');
		}

		if (!empty($tdt_input) && $tdt_input != '') {
			$tdt = date('Y-m-d', strtotime($tdt_input));
		} else {
			$tdt = date('Y-m-d');
		}

		// Validate dates - if strtotime failed, use defaults
		if ($fdt == '1970-01-01' || $fdt === false) {
			$fdt = date('Y-m-01');
		}
		if ($tdt == '1970-01-01' || $tdt === false) {
			$tdt = date('Y-m-d');
		}

		$type = $this->request->getPost('offering_id') ?? $_POST['offering_id'] ?? '';
		$ptype = $this->request->getPost('product_id') ?? $_POST['product_id'] ?? '';

		// Get admin/temple profile
		$temp_details = $this->db->table('admin_profile')
			->where('id', 1)
			->get()
			->getRowArray();

		// Fallback if empty
		if (empty($temp_details)) {
			$temp_details = [
				'name' => 'Temple Name',
				'address1' => '',
				'address2' => '',
				'city' => '',
				'postcode' => '',
				'telephone' => '',
				'image' => ''
			];
		}

		// Build query
		$dat = $this->db->table('product_offering po')
			->join('product_offering_detail pod', 'pod.pro_off_id = po.id')
			->join('product_category pc', 'pc.id = pod.product_id')
			->join('offering_category oc', 'oc.id = pod.offering_id')
			->select('po.*, pod.*, po.id as main_id, po.ref_no, pc.name as product_name, oc.name as category_name')
			->where('DATE(po.date) >=', $fdt)
			->where('DATE(po.date) <=', $tdt);

		if (!empty($type)) {
			$dat = $dat->where('pod.offering_id', $type);
		}

		if (!empty($ptype)) {
			$dat = $dat->where('pod.product_id', $ptype);
		}

		$dat = $dat->orderBy('po.id', 'desc');
		$offering_details = $dat->get()->getResultArray();

		// Calculate totals by category
		$totalGramsByCategory = [];
		$totalGrams = 0;
		foreach ($offering_details as $row) {
			$totalGrams += (float) $row['grams'];
			if (isset($totalGramsByCategory[$row['category_name']])) {
				$totalGramsByCategory[$row['category_name']] += (float) $row['grams'];
			} else {
				$totalGramsByCategory[$row['category_name']] = (float) $row['grams'];
			}
		}

		// PDF EXPORT
		if (isset($_POST['pdf_stockreport'])) {
			$options = new Options();
			$options->set('isHtml5ParserEnabled', true);
			$options->set('isRemoteEnabled', true);

			$dompdf = new Dompdf($options);

			// Pass data for PDF view
			$pdfdata = [
				'temp_details' => $temp_details,
				'fdate' => $fdt,
				'tdate' => $tdt,
				'type' => $type,
				'ptype' => $ptype,
				'offering_details' => $offering_details,
				'totalByCategory' => $totalGramsByCategory,
				'totalGrams' => $totalGrams
			];

			$html = view('frontend/report/pdf/offering_print', ['pdfdata' => $pdfdata]);

			$dompdf->loadHtml($html);
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();

			$filename = 'Offering_Report_' . date('d-m-Y', strtotime($fdt)) . '_to_' . date('d-m-Y', strtotime($tdt)) . '.pdf';
			$dompdf->stream($filename, array('Attachment' => true));
			exit;
		}

		// EXCEL EXPORT
		elseif (isset($_POST['excel_stockreport'])) {
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();
			$sheet->setTitle('Offering Report');

			// Temple Header
			$templeName = $temp_details['name'] ?? 'Temple';
			$sheet->setCellValue('A1', $templeName);
			$sheet->mergeCells('A1:I1');
			$sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
			$sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

			// Address
			$sheet->setCellValue('A2', ($temp_details['address1'] ?? '') . ', ' . ($temp_details['address2'] ?? ''));
			$sheet->mergeCells('A2:I2');
			$sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

			// Report Title
			$sheet->setCellValue('A4', 'OFFERING REPORT');
			$sheet->mergeCells('A4:I4');
			$sheet->getStyle('A4')->getFont()->setBold(true)->setSize(14);
			$sheet->getStyle('A4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

			// Date Range
			$sheet->setCellValue('A5', 'Period: ' . date('d-m-Y', strtotime($fdt)) . ' to ' . date('d-m-Y', strtotime($tdt)));
			$sheet->mergeCells('A5:I5');
			$sheet->getStyle('A5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

			// Headers - Added Ref No
			$headers = ['S.No', 'Ref No', 'Date', 'Name', 'Phone', 'Category', 'Product', 'Quantity', 'Grams'];
			$col = 'A';
			foreach ($headers as $header) {
				$sheet->setCellValue($col . '7', $header);
				$col++;
			}

			// Header Styling
			$headerStyle = [
				'font' => ['bold' => true],
				'fill' => [
					'fillType' => Fill::FILL_SOLID,
					'startColor' => ['rgb' => 'F7EBBB']
				],
				'borders' => [
					'allBorders' => ['borderStyle' => Border::BORDER_THIN]
				],
				'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
			];
			$sheet->getStyle('A7:I7')->applyFromArray($headerStyle);

			// Data Rows
			$row = 8;
			$i = 1;
			foreach ($offering_details as $detail) {
				$sheet->setCellValue('A' . $row, $i++);
				$sheet->setCellValue('B' . $row, $detail['ref_no'] ?? ''); // Ref No
				$sheet->setCellValue('C' . $row, date('d-m-Y', strtotime($detail['date'])));
				$sheet->setCellValue('D' . $row, $detail['name']);
				$sheet->setCellValue('E' . $row, $detail['phone']);
				$sheet->setCellValue('F' . $row, $detail['category_name']);
				$sheet->setCellValue('G' . $row, $detail['product_name']);
				$sheet->setCellValue('H' . $row, $detail['quantity'] ?? 0);
				$sheet->setCellValue('I' . $row, $detail['grams']);
				$row++;
			}

			// Apply borders to data
			$dataStyle = [
				'borders' => [
					'allBorders' => ['borderStyle' => Border::BORDER_THIN]
				]
			];
			$lastDataRow = $row - 1;
			if ($lastDataRow >= 8) {
				$sheet->getStyle('A8:I' . $lastDataRow)->applyFromArray($dataStyle);
			}

			// Category Totals Section
			$row += 1;
			foreach ($totalGramsByCategory as $category => $grams) {
				$sheet->setCellValue('F' . $row, 'Total ' . $category . ':');
				$sheet->setCellValue('I' . $row, number_format($grams, 2));
				$sheet->getStyle('F' . $row . ':I' . $row)->getFont()->setBold(true);
				$row++;
			}

			// Grand Total
			$sheet->setCellValue('F' . $row, 'Grand Total:');
			$sheet->setCellValue('I' . $row, number_format($totalGrams, 2));
			$sheet->getStyle('F' . $row . ':I' . $row)->getFont()->setBold(true);
			$sheet->getStyle('F' . $row . ':I' . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('E2DFDF');

			// Column Widths
			$sheet->getColumnDimension('A')->setWidth(8);
			$sheet->getColumnDimension('B')->setWidth(15); // Ref No
			$sheet->getColumnDimension('C')->setWidth(12); // Date
			$sheet->getColumnDimension('D')->setWidth(25); // Name
			$sheet->getColumnDimension('E')->setWidth(15); // Phone
			$sheet->getColumnDimension('F')->setWidth(20); // Category
			$sheet->getColumnDimension('G')->setWidth(20); // Product
			$sheet->getColumnDimension('H')->setWidth(12); // Quantity
			$sheet->getColumnDimension('I')->setWidth(12); // Grams

			// Output
			$filename = 'Offering_Report_' . date('d-m-Y', strtotime($fdt)) . '_to_' . date('d-m-Y', strtotime($tdt)) . '.xlsx';

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="' . $filename . '"');
			header('Cache-Control: max-age=0');

			$writer = new Xlsx($spreadsheet);
			$writer->save('php://output');
			exit;
		}

		// REGULAR PRINT VIEW
		else {
			$data = [
				'temp_details' => $temp_details,
				'fdate' => $fdt,
				'tdate' => $tdt,
				'type' => $type,
				'ptype' => $ptype,
				'offering_details' => $offering_details,
				'totalByCategory' => $totalGramsByCategory,
				'totalGrams' => $totalGrams
			];
			return view('frontend/report/offering_print', $data);
		}
	}
	public function get_booked_dates_online()
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

	public function update_booking_name_date_online()
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
}
