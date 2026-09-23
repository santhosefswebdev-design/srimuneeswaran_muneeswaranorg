<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Accountsetting extends BaseController
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
		if(!$this->model->permission_validate('account_setting', 'create_p')){
			header('Location: '.base_url().'/dashboard');
		}
		echo view('template/header');
		echo view('template/sidebar');
		echo view('accountsetting/add');
		echo view('template/footer');
	}
    public function save(){
		if(!$this->model->list_validate('account_setting')){
			header('Location: '.base_url().'/dashboard');
		}
		if($_POST['start_month']) {
			$styear = date('Y-m-d', strtotime('-1 years'));
			$sdate = date("Y", strtotime($styear))."-".str_pad($_POST['start_month'], 2, '0', STR_PAD_LEFT)."-01";
		}
        else {
			$sdate = date("Y-m-01");
		}
        if($_POST['end_month']) {
			if($_POST['start_month'] > $_POST['end_month']) {
				$edyear = date('Y-m-d', strtotime('+1 years'));
				$eyear = date("Y", strtotime($edyear));
				//next year
			}
			else {
				$eyear = date("Y");//currect year
			}
			$eyear = date("Y");
			$emonth = str_pad($_POST['end_month'], 2, '0', STR_PAD_LEFT);
			$edates = cal_days_in_month(CAL_GREGORIAN, $emonth, $eyear);
			$tdate = $eyear."-".$emonth."-".$edates;
		}
        else {
			$tdate = date("Y-m-t");
		}
		
		$exist_fr_year_month = date("Y-m", strtotime($sdate));
		$exist_to_year_month = date("Y-m", strtotime($tdate));
		//var_dump($exist_fr_year_month);
		//var_dump($exist_to_year_month);
		//exit;
		$checkexist = $this->db->table('ac_year')->where('from_year_month', $exist_fr_year_month)->where('to_year_month', $exist_to_year_month)->where('status', 1)->get()->getResultArray();
		
		
		if(count($checkexist) == 0)
		{
			//exit;
			//Parent Group INCOME
			$total_income_amount_bf_cr = 0;
			$total_income_amount_bf_dr = 0;
			$parent_income = $this->db->query("select * from groups where parent_id ='26' ")->getResultArray();
			foreach($parent_income as $row){
				$datas_income = array();
				$id =$row['id'];
				$res = $this->db->query("select * from `ledgers` where group_id = $id")->getResultArray();
				if(count($res) >0){
					$debitamt_tot = 0;
					$creditamt_tot = 0;
					foreach($res as $dd){
						$led_id = $dd['id'];
						$debitamt =	$this->db->query("select sum(entryitems.amount) as amount 
									from entryitems 
									inner join entries on entries.id = entryitems. entry_id
									where entryitems.dc = 'D' and entryitems.ledger_id = $led_id and entries.date >= '$sdate' and entries.date <= '$tdate'")->getRowArray();
						$creditamt = $this->db->query("select sum(entryitems.amount) as amount 
										from entryitems 
										inner join entries on entries.id = entryitems. entry_id
										where entryitems.dc = 'C' and entryitems.ledger_id = $led_id and entries.date >= '$sdate' and entries.date <= '$tdate'")->getRowArray();
						$debitamt_tot = $debitamt_tot + $debitamt['amount'];
						$creditamt_tot = $creditamt_tot + $creditamt['amount'];
					}
					if($debitamt_tot > $creditamt_tot)
					{
						$datas_income['DR'][] = $debitamt_tot;
					}
					else
					{
						$datas_income['CR'][] = $creditamt_tot;
					}	
				}
				// Child Group
				$cgroup = $this->db->query("select * from groups where parent_id = $id")->getResultArray();
				foreach($cgroup as $crow){
					$id =$crow['id'];
					$res = $this->db->query("select * from `ledgers` where group_id = $id")->getResultArray();
					if(count($res) >0){
						$debitamt_tot = 0;
						$creditamt_tot = 0;
						foreach($res as $dd){
							$led_id = $dd['id'];
							$debitamt =	$this->db->query("select sum(entryitems.amount) as amount 
									from entryitems 
									inner join entries on entries.id = entryitems. entry_id
									where entryitems.dc = 'D' and entryitems.ledger_id = $led_id and entries.date >= '$sdate' and entries.date <= '$tdate'")->getRowArray();
							$creditamt = $this->db->query("select sum(entryitems.amount) as amount 
										from entryitems 
										inner join entries on entries.id = entryitems. entry_id
										where entryitems.dc = 'C' and entryitems.ledger_id = $led_id and entries.date >= '$sdate' and entries.date <= '$tdate'")->getRowArray();
							$debitamt_tot = $debitamt_tot + $debitamt['amount'];
							$creditamt_tot = $creditamt_tot + $creditamt['amount'];
						}
						if($debitamt_tot > $creditamt_tot)
						{
							$datas_income['DR'][] = $debitamt_tot;
						}
						else
						{
							$datas_income['CR'][] = $creditamt_tot;
						}	
					}
					// 2nd child
					$mcgroup = $this->db->query("select * from groups where parent_id = $id")->getResultArray();
					foreach($mcgroup as $mcrow){
						$id =$mcrow['id'];
						$res = $this->db->query("select * from `ledgers` where group_id = $id")->getResultArray();
						if(count($res) >0){
							$debitamt_tot = 0;
							$creditamt_tot = 0;
							foreach($res as $dd){
								$led_id = $dd['id'];
								$debitamt =	$this->db->query("select sum(entryitems.amount) as amount 
									from entryitems 
									inner join entries on entries.id = entryitems. entry_id
									where entryitems.dc = 'D' and entryitems.ledger_id = $led_id and entries.date >= '$sdate' and entries.date <= '$tdate'")->getRowArray();
								$creditamt = $this->db->query("select sum(entryitems.amount) as amount 
										from entryitems 
										inner join entries on entries.id = entryitems. entry_id
										where entryitems.dc = 'C' and entryitems.ledger_id = $led_id and entries.date >= '$sdate' and entries.date <= '$tdate'")->getRowArray();
								$debitamt_tot = $debitamt_tot + $debitamt['amount'];
								$creditamt_tot = $creditamt_tot + $creditamt['amount'];
							}
								
							if($debitamt_tot > $creditamt_tot)
							{
								$datas_income['DR'][] = $debitamt_tot;
							}
							else
							{
								$datas_income['CR'][] = $creditamt_tot;
							}	
						}
					}
				}
				if(!empty($datas_income["CR"]))
				{
					foreach($datas_income["CR"] as $rowin)
					{
						$total_income_amount_bf_cr = $total_income_amount_bf_cr + $rowin;	
					}
				}
				if(!empty($datas_income["DR"]))
				{
					foreach($datas_income["DR"] as $rowin)
					{
						$total_income_amount_bf_dr = $total_income_amount_bf_dr + $rowin;	
					}
				}
			}
			//Parent Group EXPENSES
			$total_expense_amount_bf_cr = 0;
			$total_expense_amount_bf_dr = 0;
			$parent_expense = $this->db->query("select * from groups where parent_id ='30' ")->getResultArray();
			foreach($parent_expense as $row){
				$datas_expense = array();
				$id =$row['id'];
				$res = $this->db->query("select * from `ledgers` where group_id = $id")->getResultArray();
				if(count($res) >0){
					$debitamt_tot = 0;
					$creditamt_tot = 0;
					foreach($res as $dd){
						$led_id = $dd['id'];
						$debitamt =	$this->db->query("select sum(entryitems.amount) as amount 
									from entryitems 
									inner join entries on entries.id = entryitems. entry_id
									where entryitems.dc = 'D' and entryitems.ledger_id = $led_id and entries.date >= '$sdate' and entries.date <= '$tdate'")->getRowArray();
						$creditamt = $this->db->query("select sum(entryitems.amount) as amount 
								from entryitems 
								inner join entries on entries.id = entryitems. entry_id
								where entryitems.dc = 'C' and entryitems.ledger_id = $led_id and entries.date >= '$sdate' and entries.date <= '$tdate'")->getRowArray();
						$debitamt_tot = $debitamt_tot + $debitamt['amount'];
						$creditamt_tot = $creditamt_tot + $creditamt['amount'];
					}
					if($debitamt_tot > $creditamt_tot)
					{
						$datas_expense['DR'][] = $debitamt_tot;
					}
					else
					{
						$datas_expense['CR'][] = $creditamt_tot;
					}	
				}
				// Child Group
				$cgroup = $this->db->query("select * from groups where parent_id = $id")->getResultArray();
				foreach($cgroup as $crow){
					$id =$crow['id'];
					$res = $this->db->query("select * from `ledgers` where group_id = $id")->getResultArray();
					if(count($res) >0){
						$debitamt_tot = 0;
						$creditamt_tot = 0;
						foreach($res as $dd){
							$led_id = $dd['id'];
							$debitamt =	$this->db->query("select sum(entryitems.amount) as amount 
									from entryitems 
									inner join entries on entries.id = entryitems. entry_id
									where entryitems.dc = 'D' and entryitems.ledger_id = $led_id and entries.date >= '$sdate' and entries.date <= '$tdate'")->getRowArray();
							$creditamt = $this->db->query("select sum(entryitems.amount) as amount 
									from entryitems 
									inner join entries on entries.id = entryitems. entry_id
									where entryitems.dc = 'C' and entryitems.ledger_id = $led_id and entries.date >= '$sdate' and entries.date <= '$tdate'")->getRowArray();
							$debitamt_tot = $debitamt_tot + $debitamt['amount'];
							$creditamt_tot = $creditamt_tot + $creditamt['amount'];
						}
						if($debitamt_tot > $creditamt_tot)
						{
							$datas_expense['DR'][] = $debitamt_tot;
						}
						else
						{
							$datas_expense['CR'][] = $creditamt_tot;
						}	
					}
					// 2nd child
					$mcgroup = $this->db->query("select * from groups where parent_id = $id")->getResultArray();
					foreach($mcgroup as $mcrow){
						$id =$mcrow['id'];
						$res = $this->db->query("select * from `ledgers` where group_id = $id")->getResultArray();
						if(count($res) >0){
							$debitamt_tot = 0;
							$creditamt_tot = 0;
							foreach($res as $dd){
								$led_id = $dd['id'];
								$debitamt =	$this->db->query("select sum(entryitems.amount) as amount 
									from entryitems 
									inner join entries on entries.id = entryitems. entry_id
									where entryitems.dc = 'D' and entryitems.ledger_id = $led_id and entries.date >= '$sdate' and entries.date <= '$tdate'")->getRowArray();
								$creditamt = $this->db->query("select sum(entryitems.amount) as amount 
									from entryitems 
									inner join entries on entries.id = entryitems. entry_id
									where entryitems.dc = 'C' and entryitems.ledger_id = $led_id and entries.date >= '$sdate' and entries.date <= '$tdate'")->getRowArray();
								$debitamt_tot = $debitamt_tot + $debitamt['amount'];
								$creditamt_tot = $creditamt_tot + $creditamt['amount'];
							}
								
							if($debitamt_tot > $creditamt_tot)
							{
								$datas_expense['DR'][] = $debitamt_tot;
							}
							else
							{
								$datas_expense['CR'][] = $creditamt_tot;
							}	
						}
					}
				}
				if(!empty($datas_expense["CR"]))
				{
					foreach($datas_expense["CR"] as $rowex)
					{
						$total_expense_amount_bf_cr = $total_expense_amount_bf_cr + $rowex;	
					}
				}
				if(!empty($datas_expense["DR"]))
				{
					foreach($datas_expense["DR"] as $rowex)
					{
						$total_expense_amount_bf_dr = $total_expense_amount_bf_dr + $rowex;	
					}
				}
			}
			//number_format($debitamt_tot, "2",".",",")
			//number_format($creditamt_tot, "2",".",",")
			$final_income = 0;
			if($total_income_amount_bf_dr > $total_income_amount_bf_cr)
			{
				$final_income = $total_income_amount_bf_dr - $total_income_amount_bf_cr;
			}
			else
			{
				$final_income = $total_income_amount_bf_cr - $total_income_amount_bf_dr;
			}
			$final_expense = 0;
			if($total_expense_amount_bf_dr > $total_expense_amount_bf_cr)
			{
				$final_expense = $total_expense_amount_bf_dr - $total_expense_amount_bf_cr;
			}
			else
			{
				$final_expense = $total_expense_amount_bf_cr - $total_expense_amount_bf_dr;
			}
			
			$total_amount="";
			if($final_income > $final_expense)
			{
				$type_ie = "C_";
				$ie_amt = $final_income - $final_expense;
				$total_amount = $type_ie.$ie_amt;
			}
			else
			{
				$type_ie = "D_";
				$ie_amt = $final_expense - $final_income;
				$total_amount = $type_ie.$ie_amt;
			}
			
			//echo $total_amount."<br>";
			//echo $total_income_amount_bf_cr."<br>";
			//echo $total_income_amount_bf_dr."<br>";
			//echo $total_expense_amount_bf_cr."<br>";
			//echo $total_expense_amount_bf_dr."<br>";
			//echo $total_expense_amount;
			//exit;
			if(!empty($total_amount))
			{
				$ledger2 = $this->db->table('ledgers')->where('name', 'Retained Earnings')->where('group_id', 55)->get()->getRowArray(); /* Current Assets Group */
				if(!empty($ledger2['id'])){
					$cr_id = $ledger2['id'];
				}else{
					/* Create Retained Earnings Ledger Under Current Assets Group */
					$led1['group_id'] 		= 55;
					$led1['name'] 			= 'Retained Earnings';
					$led1['op_balance'] 	= '0';
					$led1['op_balance_dc'] 	= 'D';
					$led_ins1 = $this->db->table('ledgers')->insert($led1);
					$cr_id = $this->db->insertID();
				}
								
				$retined_row = $this->db->table('ledgers')->where('id', $cr_id)->get()->getRowArray();
				$retined_row_amt = $retined_row['op_balance'];
				$explode_type = explode("_",$total_amount);
				if($explode_type[0] == "C")
				{
					$cr_amt = $retined_row_amt + $explode_type[1];
					$cr_data['op_balance'] = $cr_amt;
					$cr_data['op_balance_dc'] = "C";
					$this->db->table('ledgers')->where('id', $retined_row['id'])->update($cr_data);
					$ac_lb_data['dr_amount'] = "0.00";
					$ac_lb_data['cr_amount'] = $cr_amt;
				}
				if($explode_type[0] == "D")
				{
					$dr_amt = $retined_row_amt - $explode_type[1];
					$dr_data['op_balance'] = $dr_amt;
					$dr_data['op_balance_dc'] = "D";
					$this->db->table('ledgers')->where('id', $retined_row['id'])->update($dr_data);
					$ac_lb_data['dr_amount'] = $dr_amt;
					$ac_lb_data['cr_amount'] = "0.00";
				}
				
				$succ_fr_year_month = date("Y-m", strtotime($sdate));
				$succ_to_year_month = date("Y-m", strtotime($tdate));
				$ac_data['from_year_month'] = $succ_fr_year_month;
				$ac_data['to_year_month'] = $succ_to_year_month;
				$ac_data['status'] = "1";
				$ac_data['user_id'] = $this->session->get('log_id');
				$this->db->table('ac_year')->insert($ac_data);
				$ac_year_id = $this->db->insertID();
				$ac_lb_data['ac_year_id'] = $ac_year_id;
				$ac_lb_data['ledger_id'] = $cr_id;
				$this->db->table('ac_year_ledger_balance')->insert($ac_lb_data);
				$this->session->setFlashdata('succ', 'Account closed successfully');
				return redirect()->to(base_url('/accountsetting'));
			}
			else
			{
				$this->session->setFlashdata('fail', 'Please Try Again');
				return redirect()->to(base_url('/accountsetting'));
			}
		}
		else
		{
			$this->session->setFlashdata('fail', 'Already account closed');
			return redirect()->to(base_url('/accountsetting'));
		}	
		
		
    }

	public function yearendclose()
	{
		$total_income_amount_bf_cr = 0;
		$total_income_amount_bf_dr = 0;
		$sdate = "1969-04-01";
		$tdate = "2022-03-31";
	/*	$led_id = "19031";
		$debitamt =	$this->db->query("select sum(entryitems.amount) as amount 
								from entryitems 
								inner join entries on entries.id = entryitems. entry_id
								where entryitems.dc = 'D' and entryitems.ledger_id = $led_id and entries.date >= '$sdate' and entries.date <= '$tdate'")->getRowArray();
					$creditamt = $this->db->query("select sum(entryitems.amount) as amount 
									from entryitems 
									inner join entries on entries.id = entryitems. entry_id
									where entryitems.dc = 'C' and entryitems.ledger_id = $led_id and entries.date >= '$sdate' and entries.date <= '$tdate'")->getRowArray();
					//$debitamt_tot = $debitamt_tot + $debitamt['amount'];
					//$creditamt_tot = $creditamt_tot + $creditamt['amount'];

		*/
		$datas_income = array();
		$group = $this->db->table("groups")->get()->getResultArray();
		foreach($group as $row){
			
			$res = $this->db->table("ledgers")->where('group_id', $row['id'])->get()->getResultArray();
			if(count($res) >0){
				foreach($res as $dd){
					$led_id = $dd['id'];
					$debitamt =	$this->db->query("select sum(entryitems.amount) as amount 
								from entryitems 
								inner join entries on entries.id = entryitems. entry_id
								where entryitems.dc = 'D' and entryitems.ledger_id = $led_id and entries.date >= '$sdate' and entries.date <= '$tdate'")->getRowArray();
					$creditamt = $this->db->query("select sum(entryitems.amount) as amount 
									from entryitems 
									inner join entries on entries.id = entryitems. entry_id
									where entryitems.dc = 'C' and entryitems.ledger_id = $led_id and entries.date >= '$sdate' and entries.date <= '$tdate'")->getRowArray();
					$debitamt_tot = $debitamt['amount'];
					$creditamt_tot = $creditamt['amount'];
					if($debitamt_tot > $creditamt_tot)
					{
						$datas_income[$led_id]['DR'][] = $debitamt_tot - $creditamt_tot;
					}
					else
					{
						$datas_income[$led_id]['CR'][] = $creditamt_tot - $debitamt_tot;
					}
				}
			}
			/*
			if(!empty($datas_income["CR"]))
			{
				foreach($datas_income["CR"] as $rowin)
				{
					$total_income_amount_bf_cr = $total_income_amount_bf_cr + $rowin;	
				}
			}
			if(!empty($datas_income["DR"]))
			{
				foreach($datas_income["DR"] as $rowin)
				{
					$total_income_amount_bf_dr = $total_income_amount_bf_dr + $rowin;	
				}
			}*/
		}
		print_r($datas_income);
		$final_income = 0;
		if($total_income_amount_bf_dr > $total_income_amount_bf_cr)
		{
			$final_income = "dr_".($total_income_amount_bf_dr - $total_income_amount_bf_cr);
		}
		else
		{
			$final_income = "cr_".($total_income_amount_bf_cr - $total_income_amount_bf_dr);
		}

		

	}
	
}
