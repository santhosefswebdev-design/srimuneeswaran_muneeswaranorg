<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\PermissionModel;

class Revenuecapture extends BaseController{
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
	function index(){
		if(!empty($_POST['ledger'])) $ledger_id = $_POST['ledger'];
        else $ledger_id = '';
        if($_POST['fdate']) $fdate = $_POST['fdate'];
        else $fdate = date("Y-m-01");
        if($_POST['tdate']) $tdate = $_POST['tdate'];
        else $tdate = date("Y-m-d");

        $group = $this->db->table("groups")->get()->getResultArray();
		if(count($group) > 0){
			foreach($group as $row){
				$rows = $this->db->table("ledgers")->where('group_id', $row['id'])->where('type', 1)->like('name', 'cash', 'both')->get()->getNumRows();
				if($rows > 0){
					$ledger[] = '<optgroup label="'.$row['name'].'">';
					$res = $this->db->table("ledgers")->where('group_id', $row['id'])->where('type', 1)->like('name', 'cash', 'both')->get()->getResultArray();
					foreach($res as $r){
						$id = $r['id'];
						$ledgername = $r['left_code'] . '/' . $r['right_code'] . '-' . $r['name'];
						if($id == $ledger_id) $selected = 'selected';
						else $selected = '';
						$ledger[] .= '<option value="'.$id.'" '.$selected.'>'.$ledgername.'</option>';
					}
					$ledger[] .='</optgroup>';
				}
			}
        }
		$datas = array();
		$query = $this->db->query("select max(entryitems.ledger_id) as ledger_id, sum(entryitems.amount) as amount, max(entries.date) as date, max(l.name) as ledger_name from entryitems left join entries on entries.id = entryitems.entry_id left join ledgers l on l.id = entryitems.ledger_id where entry_id in (SELECT entry_id FROM entryitems ei left join entries e on e.id = ei.entry_id where ei.ledger_id = '$ledger_id' and e.date >= '$fdate' and e.date <= '$tdate') and dc = 'C' group by entries.date, entryitems.ledger_id");
        $datas = $query->getResultArray();

        $data['ledger_id'] = $ledger_id;
        $data['fdate'] = $fdate;
        $data['tdate'] = $tdate;
        $data['ledger'] = $ledger;
        $data['income_list'] = $datas;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('revenuecapture/index', $data);
		echo view('template/footer');
	}
	function print_revenuecapture(){
		if(!empty($_POST['fledger'])) $ledger_id = $_POST['fledger'];
        else $ledger_id = '';
        if($_POST['pfdate']) $fdate = $_POST['pfdate'];
        else $fdate = date("Y-m-01");
        if($_POST['ptdate']) $tdate = $_POST['ptdate'];
        else $tdate = date("Y-m-d");
        $group = $this->db->table("groups")->get()->getResultArray();
		if(count($group) > 0){
			foreach($group as $row){
				$rows = $this->db->table("ledgers")->where('group_id', $row['id'])->where('type', 1)->like('name', 'cash', 'both')->get()->getNumRows();
				if($rows > 0){
					$ledger[] = '<optgroup label="'.$row['name'].'">';
					$res = $this->db->table("ledgers")->where('group_id', $row['id'])->where('type', 1)->like('name', 'cash', 'both')->get()->getResultArray();
					foreach($res as $r){
						$id = $r['id'];
						$ledgername = $r['left_code'] . '/' . $r['right_code'] . '-' . $r['name'];
						if($id == $ledger_id) $selected = 'selected';
						else $selected = '';
						$ledger[] .= '<option value="'.$id.'" '.$selected.'>'.$ledgername.'</option>';
					}
					$ledger[] .='</optgroup>';
				}
			}
        }
		$datas = array();
		$query = $this->db->query("select max(entryitems.ledger_id) as ledger_id, sum(entryitems.amount) as amount, max(entries.date) as date, max(l.name) as ledger_name from entryitems left join entries on entries.id = entryitems.entry_id left join ledgers l on l.id = entryitems.ledger_id where entry_id in (SELECT entry_id FROM entryitems ei left join entries e on e.id = ei.entry_id where ei.ledger_id = '$ledger_id' and e.date >= '$fdate' and e.date <= '$tdate') and dc = 'C' group by entries.date, entryitems.ledger_id");
        $datas = $query->getResultArray();

        $data['ledger_id'] = $ledger_id;
        $data['fdate'] = $fdate;
        $data['tdate'] = $tdate;
        $data['ledger'] = $ledger;
        $data['income_list'] = $datas;
		echo view('revenuecapture/print_revenuecapture', $data);
	}
}