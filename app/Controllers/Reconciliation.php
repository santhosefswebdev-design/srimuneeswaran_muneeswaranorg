<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Reconciliation extends BaseController
{
    function __construct(){
        parent:: __construct();
        helper('url');
		helper("common");
		$this->model = new PermissionModel(); 
        if( ($this->session->get('login') ) == false && $this->session->get('role') != 1){
            $data['dn_msg'] = 'Please Login';
            header('Location: '.base_url().'/login');
            exit;
		}
    }
    
    public function index(){
        $ledger_id = !empty($_REQUEST['ledger']) ? $_REQUEST['ledger'] : 1;
		$res = $this->db->table("ledgers")->where('reconciliation', 1)->get()->getResultArray();
		$ac_year = $this->db->table("ac_year")->where('status', 1)->get()->getRowArray();
		$ac_year_start_date = $ac_year['from_year_month'] . '-01';
		$ac_year_end_date = date("Y-m-t", strtotime($ac_year['to_year_month'] . '-01'));
		$data['from_year_month'] = $ac_year['from_year_month'];
		$data['to_year_month'] = $ac_year['to_year_month'];
		foreach($res as $r){
			$id = $r['id'];
			$ledgername = get_ledger_name($id);
			if($ledger_id == $id) $selected = 'selected';
			else $selected = '';
			$ledger[] .= '<option '.$selected.' value="'.$id.'">'.$ledgername.'</option>';
		}
		/* if(empty($_REQUEST['fdate'])) $fdate = $ac_year_start_date;
		else $fdate = date("Y-m-d", strtotime(str_replace('-', '/', $_REQUEST['fdate'])));
		if(empty($_REQUEST['tdate'])) $tdate = $ac_year_end_date;
		else $tdate = date("Y-m-d", strtotime(str_replace('-', '/', $_REQUEST['tdate']))); */
		$recon_month = !empty($_REQUEST['recon_month']) ? $_REQUEST['recon_month'] : date('Y-m');
		// $fund_id = !empty($_REQUEST['fund_id']) ? $_REQUEST['fund_id'] : 1;
		$fdate = $recon_month . '-01';
		$tdate = date("Y-m-t", strtotime($fdate));
		$res = array();
		$ac_year = $this->db->table("ac_year")->where('status', 1)->get()->getRowArray();
		$reconcil_bank_balance = 0;
		$undo_reconcil = '';
        if(!empty($_REQUEST['ledger'])){
			$undo_reconcil = $this->db->table("entryitems")->select('COALESCE(max(DATE_FORMAT(reconciliation_date, "%Y-%m")), \'\') as reconciliation_date')->get()->getRowArray()['reconciliation_date'];
			$reconcil_bank = $this->db->table("reconcil_bank_balance")->where('ac_year_id', $ac_year['id'])->where('ledger_id', $ledger_id)->where('month', $recon_month)->get()->getRowArray();
			if(!empty($reconcil_bank['amount'])) $reconcil_bank_balance = $reconcil_bank['amount'];
			// echo $this->db->getLastQuery();
			// die;
			$res = $this->db->table("entryitems")
			->select('entries.*, entryitems.id as entryitem_id, entryitems.details, entryitems.amount, entryitems.dc, entryitems.clearancemode, entryitems.reconciliation_date, entryitems.ledger_id, ledgers.name as ledger_name, ledgers.code as ledger_code')
			->join('entries', 'entries.id = entryitems.entry_id', 'left')
			->join('ledgers', 'ledgers.id = entryitems.ledger_id', 'left')
			->where('entryitems.ledger_id', $ledger_id)
			->where('entries.date <=', $tdate)
			->where('entryitems.clearancemode', 'FLOAT')
			->orderBy('entries.date', 'ASC')
			->get()->getResultArray();
			$current_year_op_bal = $this->db->table("ac_year_ledger_balance")->where('ledger_id', $ledger_id)->where('ac_year_id', $ac_year['id'])->get()->getRowArray();
			$total_transactions_before_start = $this->db->table("entryitems")
			->select("sum(if(entryitems.dc = 'D', entryitems.amount, 0)) as dr_total, sum(if(entryitems.dc = 'C', entryitems.amount, 0)) as cr_total")
			->join('entries', 'entries.id = entryitems.entry_id', 'left')
			->where('entryitems.ledger_id', $ledger_id)
			->where('entries.date >=', $ac_year_start_date)
			->where('entries.date <=', $fdate)
			->orderBy('entries.date', 'ASC')
			->get()->getResultArray();
			$total_transactions = $this->db->table("entryitems")
			->select("sum(if(entryitems.dc = 'D', entryitems.amount, 0)) as dr_total, sum(if(entryitems.dc = 'C', entryitems.amount, 0)) as cr_total")
			->join('entries', 'entries.id = entryitems.entry_id', 'left')
			->where('entryitems.ledger_id', $ledger_id)
			->where('entries.date <=', $tdate)
			->orderBy('entries.date', 'ASC')
			->get()->getRowArray();
			//echo $this->db->getLastQuery();
			// $pending_transactions = $this->db->table("entryitems")
			// ->select("sum(if(entryitems.dc = 'D', entryitems.amount, 0)) as dr_total, sum(if(entryitems.dc = 'C', entryitems.amount, 0)) as cr_total")
			// ->join('entries', 'entries.id = entryitems.entry_id', 'left')
			// ->where('entryitems.ledger_id', $ledger_id)
			// ->where('entries.date >=', $fdate)
			// ->where('entries.date <=', $tdate)
			// ->where('entryitems.clearancemode', 'FLOAT')
			// ->orderBy('entries.date', 'ASC')
			// ->get()->getRowArray();
			$pending_transactions = $this->db->query("SELECT sum(if(entryitems.dc = 'D', `entryitems`.`amount`, 0)) as dr_total, sum(if(entryitems.dc = 'C', `entryitems`.`amount`, 0)) as cr_total FROM `entryitems` LEFT JOIN `entries` ON `entries`.`id` = `entryitems`.`entry_id` WHERE `entryitems`.`ledger_id` = '$ledger_id' AND (`entries`.`date` <= '$tdate' AND `entryitems`.`clearancemode` = 'FLOAT') or (`entries`.`date` <= '$tdate' and `entryitems`.`clearancemode` = 'CLEARED' and `entryitems`.`reconciliation_date` > '$tdate') ORDER BY `entries`.`date` ASC")->getRowArray();
			$cleared_transactions = $this->db->table("entryitems")
			->select("sum(if(entryitems.dc = 'D', entryitems.amount, 0)) as dr_total, sum(if(entryitems.dc = 'C', entryitems.amount, 0)) as cr_total")
			->join('entries', 'entries.id = entryitems.entry_id', 'left')
			->where('entryitems.ledger_id', $ledger_id)
			->where('entries.date <=', $tdate)
			->where('entryitems.reconciliation_date <=', $tdate)
			->where('entryitems.clearancemode', 'CLEARED')
			->orderBy('entries.date', 'ASC')
			->get()->getRowArray();
			$op_dr = $current_year_op_bal['dr_amount'] + $total_transactions_before_start['dr_total']; //
			$op_cr = $current_year_op_bal['cr_amount'] + $total_transactions_before_start['cr_total']; //
			$opening_balance = $op_dr - $op_cr;
			$cl_dr = $total_transactions['dr_total'];
			$cl_cr =$total_transactions['cr_total'];
			$closing_balance = ($op_dr + $cl_dr) - ($op_cr + $cl_cr);
			$clr_dr = $cleared_transactions['dr_total']; //
			$clr_cr = $cleared_transactions['cr_total']; //
			$cleared_balance = ($op_dr + $clr_dr) - ($op_cr + $clr_cr);
			$data['opening_balance'] = $opening_balance;
			$data['closing_balance'] = $closing_balance;
			$data['cleared_balance'] =$cleared_balance;
			$data['debit_balance'] = $pending_transactions['dr_total'];
			$data['credit_balance'] = $pending_transactions['cr_total'];
		}
		$data['res'] = $res;
		$data['fdate'] = $fdate;
		$data['tdate'] = $tdate;
        $data['recon_month'] =$recon_month;
        $data['ledger'] =$ledger;
        $data['ledger_id'] =$ledger_id;
        // $data['fund_id'] = $fund_id;
        $data['undo_reconcil'] = $undo_reconcil;
		$data['funds'] = $this->db->table('funds')->get()->getResultArray();
        $data['reconcil_bank_balance'] =$reconcil_bank_balance;
        echo view('template/header');
		echo view('template/sidebar');
		echo view('reconciliation/index', $data);
		echo view('template/footer');
    }
	public function save(){
		$rec_tick = !empty($_POST['rec_tick']) ? $_POST['rec_tick'] : array();
		if(!empty($_REQUEST['ledger'])){
			$ledger_id = trim($_REQUEST['ledger']);
			if(count($rec_tick) > 0){
				$length = count($_POST['rec_tick']);
				$recon_month = !empty($_REQUEST['recon_month']) ? $_REQUEST['recon_month'] : date('Y-m');
				// $fund_id = !empty($_REQUEST['fund_id']) ? $_REQUEST['fund_id'] : 1;
				$fdate = $recon_month . '-01';
				$tdate = date("Y-m-t", strtotime($fdate));
				foreach($rec_tick as $i => $entryitem_id){
					$entryitems_date =$this->db->table("entryitems")->join("entries", 'entries.id = entryitems.entry_id')->select('entries.date')->where('entryitems.id', $entryitem_id)->get()->getRowArray();
					/* $clearance = $_POST['clearance'][$i];
					$reconcil_date = !empty($_POST['reconcil_date'][$i]) ? $_POST['reconcil_date'][$i] : NULL;
					$items = array(
						'clearancemode'=>$clearance,
						'reconciliation_date'=>$reconcil_date
					); */
					$items = array(
						'clearancemode'=>'CLEARED',
						'reconciliation_date'=>$tdate
					);
					$this->db->table("entryitems")->where('id', $entryitem_id)->update($items);
				}
				return redirect()->to("/reconciliation/print/" . $ledger_id . '?recon_month=' . $recon_month);
			}
			else{
				return redirect()->to("/reconciliation");
			}
		}
		else{
			return redirect()->to("/reconciliation");
		}
	}
	public function print($ledger_id){
		//var_dump($cleared_balance);
		//var_dump($entryitem);
		//exit;
		$ac_year = $this->db->table("ac_year")->where('status', 1)->get()->getRowArray();
		$recon_month = !empty($_REQUEST['recon_month']) ? $_REQUEST['recon_month'] : date('Y-m');
		// $fund_id = !empty($_REQUEST['fund_id']) ? $_REQUEST['fund_id'] : 1;
		$fdate = $recon_month . '-01';
		$tdate = date("Y-m-t", strtotime($fdate));
		$cleared_transactions = $this->db->table("entryitems")
			->select("sum(if(entryitems.dc = 'D', entryitems.amount, 0)) as dr_total, sum(if(entryitems.dc = 'C', entryitems.amount, 0)) as cr_total")
			->join('entries', 'entries.id = entryitems.entry_id', 'left')
			->where('entryitems.ledger_id', $ledger_id)
			->where('entries.date <=', $tdate)
			->where('entryitems.reconciliation_date <=', $tdate)
			->where('entryitems.clearancemode', 'CLEARED')
			->orderBy('entries.date', 'ASC')
			->get()->getRowArray();
		$current_year_op_bal = $this->db->table("ac_year_ledger_balance")->where('ledger_id', $ledger_id)->where('ac_year_id', $ac_year['id'])->get()->getRowArray();
		$op_dr = $current_year_op_bal['dr_amount'] + $total_transactions_before_start['dr_total']; //
		$op_cr = $current_year_op_bal['cr_amount'] + $total_transactions_before_start['cr_total']; //
		$clr_dr = $cleared_transactions['dr_total']; //
		$clr_cr = $cleared_transactions['cr_total']; //
		$cleared_balance = ($op_dr + $clr_dr) - ($op_cr + $clr_cr);
		$data['cleared_balance'] = $cleared_balance;
		$ac_year_start_date = $ac_year['from_year_month'] . '-01';
		$ac_year_end_date = $ac_year['from_year_month'] . '-31';
		$ledger_details = $this->db->table("ledgers")->where('id', $ledger_id)->get()->getRowArray();
		$current_year_op_bal = $this->db->table("ac_year_ledger_balance")->where('ledger_id', $ledger_id)->where('ac_year_id', $ac_year['id'])->get()->getRowArray();
		// if(empty($_REQUEST['fdate'])) $fdate = $ac_year_start_date;
		// else $fdate = date("Y-m-d", strtotime(str_replace('-', '/', $_REQUEST['fdate'])));
		// if(empty($_REQUEST['tdate'])) $fdate = $ac_year_end_date;
		// else $tdate = date("Y-m-d", strtotime(str_replace('-', '/', $_REQUEST['tdate'])));
		$pending_debit_transactions = $this->db->query("SELECT ledgers.*, `entries`.`date`, entries.narration, entries.entry_code, `entryitems`.`amount` FROM `entryitems` LEFT JOIN `entries` ON `entries`.`id` = `entryitems`.`entry_id` left join ledgers on ledgers.id = `entryitems`.`ledger_id` WHERE `entryitems`.`ledger_id` = '$ledger_id' AND entryitems.dc = 'D' and (`entries`.`date` <= '$tdate' AND `entryitems`.`clearancemode` = 'FLOAT') or (`entries`.`date` <= '$tdate' and `entryitems`.`clearancemode` = 'CLEARED' and `entryitems`.`reconciliation_date` > '$tdate') ORDER BY `entries`.`date` ASC")->getResultArray();
		$pending_credit_transactions = $this->db->query("SELECT ledgers.*, `entries`.`date`, entries.narration, entries.entry_code, `entryitems`.`amount` FROM `entryitems` LEFT JOIN `entries` ON `entries`.`id` = `entryitems`.`entry_id` left join ledgers on ledgers.id = `entryitems`.`ledger_id` WHERE `entryitems`.`ledger_id` = '$ledger_id' AND entryitems.dc = 'C' and (`entries`.`date` <= '$tdate' AND `entryitems`.`clearancemode` = 'FLOAT') or (`entries`.`date` <= '$tdate' and `entryitems`.`clearancemode` = 'CLEARED' and `entryitems`.`reconciliation_date` > '$tdate') ORDER BY `entries`.`date` ASC")->getResultArray();
		$total_transactions_before_start = $this->db->table("entryitems")
			->select("sum(if(entryitems.dc = 'D', entryitems.amount, 0)) as dr_total, sum(if(entryitems.dc = 'C', entryitems.amount, 0)) as cr_total")
			->join('entries', 'entries.id = entryitems.entry_id', 'left')
			->where('entryitems.ledger_id', $ledger_id)
			->where('entries.date >=', $ac_year_start_date)
			->where('entries.date <=', $fdate)
			->get()->getResultArray();
		$total_transactions = $this->db->table("entryitems")
			->select("sum(if(entryitems.dc = 'D', entryitems.amount, 0)) as dr_total, sum(if(entryitems.dc = 'C', entryitems.amount, 0)) as cr_total")
			->join('entries', 'entries.id = entryitems.entry_id', 'left')
			->where('entryitems.ledger_id', $ledger_id)
			->where('entries.date <=', $tdate)
			->orderBy('entries.date', 'ASC')
			->get()->getRowArray();
		$op_dr = $current_year_op_bal['dr_amount'] + $total_transactions_before_start['dr_total']; //
		$op_cr = $current_year_op_bal['cr_amount'] + $total_transactions_before_start['cr_total']; //
		$cl_dr = $total_transactions['dr_total'];
		$cl_cr = $total_transactions['cr_total'];
		$opening_balance = $op_dr - $op_cr;
		$closing_balance = ($op_dr + $cl_dr) - ($op_cr + $cl_cr);
		$data['opening_balance'] = $opening_balance;
		$data['closing_balance'] = $closing_balance;
		$data['pending_debit_transactions'] = $pending_debit_transactions;
		$data['pending_credit_transactions'] = $pending_credit_transactions;
		$data['fdate'] = $fdate;
		$data['tdate'] = $tdate;
		$data['$recon_month'] = $recon_month;
		$data['ledger_details'] = $ledger_details;

		// $res = $this->db->table("entryitems")
						// ->select('entries.date as entry_date,entries.narration,entries.entry_code, entryitems.reconciliation_date,entryitems.amount,entryitems.dc,ledgers.name as ledger_name')
						// ->join('entries', 'entries.id = entryitems.entry_id', 'left')
						// ->join('ledgers', 'ledgers.id = entryitems.ledger_id', 'left')
						// ->whereIn('entryitems.id', $entryitem)
						// ->get()->getResultArray();
		// $data['entryitems'] = $res;
		echo view('reconciliation/print',$data);
	}
	public function save_bank_balance(){
		if(!empty($_REQUEST['ledger_id']) && !empty($_REQUEST['recon_month']) && !empty($_REQUEST['bank_balance'])){
			$ledger_id = trim($_REQUEST['ledger_id']);
			$recon_month = trim($_REQUEST['recon_month']);
			$amount = trim($_REQUEST['bank_balance']);
			// $fund_id = trim($_REQUEST['fund_id']);
			$ac_year = $this->db->table("ac_year")->where('status', 1)->get()->getRowArray();
			$data = array();
			$data['ac_year_id'] = $ac_year['id'];
			$data['ledger_id'] = $ledger_id;
			// $data['fund_id'] = $fund_id;
			$data['month'] = $recon_month;
			$data['amount'] = $amount;
			$reconcil_bank_balance = $this->db->table("reconcil_bank_balance")->where('ac_year_id', $ac_year['id'])->where('ledger_id', $ledger_id)->where('month', $recon_month)->get()->getResultArray();
			if(count($reconcil_bank_balance) > 0){
				$data['updated'] = date('Y-m-d H:i:s');
				$res = $this->db->table("reconcil_bank_balance")->where('id', $reconcil_bank_balance[0]['id'])->update($data);
			}else{
				$this->db->table('reconcil_bank_balance')->insert($data);
			}
			return redirect()->to("/reconciliation?ledger=$ledger_id&recon_month=$recon_month");
		}
		else{
			return redirect()->to("/reconciliation");
		}
	}
	public function undo_reconcil($ledger_id){
		$ac_year = $this->db->table("ac_year")->where('status', 1)->get()->getRowArray();
		$recon_month = !empty($_REQUEST['recon_month']) ? $_REQUEST['recon_month'] : date('Y-m');
		// $fund_id = !empty($_REQUEST['fund_id']) ? $_REQUEST['fund_id'] : 1;
		$fdate = $recon_month . '-01';
		$tdate = date("Y-m-t", strtotime($fdate));
		// $this->db->query("UPDATE `entryitems` set clearancemode = 'FLOAT', reconciliation_date=NULL WHERE `ledger_id` LIKE $ledger_id and entry_id in (select id from entries where fund_id = $fund_id) and reconciliation_date='$tdate' and clearancemode = 'CLEARED'");
		$this->db->query("UPDATE `entryitems` set clearancemode = 'FLOAT', reconciliation_date=NULL WHERE `ledger_id` LIKE $ledger_id and reconciliation_date='$tdate' and clearancemode = 'CLEARED'");
		return redirect()->to("/reconciliation?ledger=$ledger_id&recon_month=$recon_month");
	}
}