<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Salesreport extends BaseController
{
    function __construct(){
        parent:: __construct();
        helper('url');
		helper('common_helper');
        $this->model = new PermissionModel();
        if( ($this->session->get('log_id') ) == false && $this->session->get('role') != 1){
            $data['dn_msg'] = 'Please Login';
            header('Location: '.base_url().'/login');
            exit;
		}
    }

	public function index() {
		$reportType = $this->request->getVar('reportType');
		$data = [];
	
		switch ($reportType) {
			case 'daily':
				$fromDate = $this->request->getVar('dailyclosing_start_date');
				$toDate = $this->request->getVar('dailyclosing_end_date');
				$data['salesData'] = archanai_chart_daily($fromDate, $toDate);
				$data['reportTitle'] = "Daily Sales Report from $fromDate to $toDate";
				$data['reportType'] = $reportType; 
				break;
				
			case 'weekly':
				$monthYear = $this->request->getVar('monthYear');
				$data['salesData'] = archanai_chart_weekly($monthYear);
				$data['reportTitle'] = "Weekly Sales Report for $monthYear";
				$data['reportType'] = $reportType;
				break;

			case 'monthly':
				$fromMonthYear = $this->request->getVar('fromMonthYear');
				$toMonthYear = $this->request->getVar('toMonthYear');
				$data['salesData'] = archanai_chart_monthly($fromMonthYear, $toMonthYear);
				$data['reportTitle'] = "Monthly Sales Report from $fromMonthYear to $toMonthYear";
				$data['reportType'] = $reportType;
				break;
			default:
				$data['reportTitle'] = "Select a report type";
				$data['salesData'] = [];
				$data['reportType'] = '';
				break;
		}
	
		// echo "<pre>";
		// print_r($data); 
		// echo "</pre>";
		// exit;

		echo view('template/header');
		echo view('template/sidebar');
		echo view('daily_closing/analytics_report', $data);
		echo view('template/footer');
	}

}
