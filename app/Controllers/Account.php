<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Account extends BaseController
{
	function __construct()
	{
		parent::__construct();
		helper('url');
		helper("common");
		$this->model = new PermissionModel();
		if (($this->session->get('login')) == false && $this->session->get('role') != 1) {
			$data['dn_msg'] = 'Please Login';
			header('Location: ' . base_url() . '/login');
			exit;
		}
	}
	//future reference
    public function wrapHTML(&$datas,$row,$group_p,$group_e,$group_d,$ledger_p,$ledgere,$ledgerd,$all_ledgers,$entry_datas,$open_bal_datas,$sub_datas,$nsub,$i = 0,$op_dis = false)
    {
        
        //print_r($row);
            $nthrow = $nsub[$row["parent_id"]];
            $lid = $row['id'] . ',1';
			$nid = $row['id'] . '_1';
			if($i == 0)
			{
    			$in_ex_group = array(4000,5000,6000,8000,9000);
    			if (in_array($row['code'], $in_ex_group)) $op_dis = false;
    			else $op_dis = true;
			}
			
			$empstr ="";
			$empstrsub ="";
			for($j=0;$j<$nthrow+1;$j++)
			{
			    $empstr .= "&emsp;";
			}
			$empstrsub .= "&emsp;&emsp;&emsp;";
			//print_r($row);
			/*
			if($nthrow == 2)
			print_r($row);
			else;
			*/
			
    			$datas[] = '<tr>
    					   		<td>'.$empstr.'<span id="name_' . $nid . '">(' . $row['code'] . ') ' . $row['name'] . '</span></td>
    							<td>Group</td>
    							<td>-</td>
    							<td>-</td>';
			if ($group_p == 1) {
				$datas[] = '	<td>';
				if ($group_e == 1) {
					if(empty($row['fixed'])){
						$datas[] = '<a style="color: #fff;" href="' . base_url() . '/account/edit_group/' . $row['id'] . '">
                                            <button class="btn btn-primary  btn-rad"><i class="material-icons">&#xE3C9;</i></button>
                                        </a>';
					}

				}
				if($group_d == 1){	
					if(empty($row['fixed'])){
						$datas[] = '<a style="color: #fff;" href="#">	<button class="btn btn-danger btn-rad" onclick="confirm_modal('.$lid.')"><i class="material-icons">&#xE872;</i></button></a>';
					}
				}

				$datas[] = '	</td>';
			}
			
			$datas[] = '<tr>';
			$id = $row['id'];
			if (!empty($_POST['ledger'])) {
				$ledger_id = $_POST['ledger'];
				$res = (isset($all_ledgers_with_ids[$id][$ledger_id])?$all_ledgers_with_ids[$id][$ledger_id]:[]);
			} else {
				$res = (isset($all_ledgers[$id])?$all_ledgers[$id]:[]);
			}
			
			if (count($res) > 0) {
				foreach ($res as $dd) {
				    $nthsub = (
				        $i == 0?1:
				            (isset($sub_datas[$row['id']])?$sub_datas[$row['id']]:1)
				            );
					$lid = $dd['id'] . ',2';
					$nid = $dd['id'] . '_2';
					$led_id = $dd['id'];
					$group_id = $dd['group_id'];
					//if($nthrow == 2)
					$ledgername = (isset($dd["name"])?"(".$dd["left_code"]."/".$dd["right_code"].") ".$dd["name"]:"-");
					//else
				    //$ledgername = (isset($dd["name"])?$dd["name"]:"-");//get_ledger_name($led_id);
					$amt_arr = (isset($entry_datas[$led_id])?$entry_datas[$led_id]:[]);
					$debitamt['amount'] = (isset($amt_arr["dr_total"])?$amt_arr["dr_total"]:'');
					$creditamt['amount'] = (isset($amt_arr["cr_total"])?$amt_arr["cr_total"]:'');
					if ($debitamt['amount'] == '')
						$debitamt['amount'] = 0;
					if ($creditamt['amount'] == '')
						$creditamt['amount'] = 0;
						
					$op_balance = (isset($open_bal_datas[$dd['id']])?$open_bal_datas[$dd['id']]:[]);
					$op_balance_amt = 0;
					if(isset($op_balance['dr_amount']))
					{
    					if ($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == "") {
    						$op_balance_amt -= $op_balance['cr_amount'];
    					} else {
    						$op_balance_amt += $op_balance['dr_amount'];
    					}
					}
					
					$clbal = ($op_balance_amt - $creditamt['amount']) + $debitamt['amount'];
					if($op_balance_amt < 0){
						$op_balance_amt_amount = '(' . number_format(abs($op_balance_amt), "2", ".", ",") . ')';
					}else{
						$op_balance_amt_amount = number_format(abs($op_balance_amt), "2", ".", ",");
					}
					if($clbal < 0){
						$clbal_amount = '(' . number_format(abs($clbal), "2", ".", ",") . ')';
					}else{
						$clbal_amount = number_format(abs($clbal), "2", ".", ",");
					}
					//<td>&emsp;<span id="name_' . $nid . '">(' . $crow['code'] . ') ' . $crow['name'] . '</span></td>
					//echo $clbal.'<br>'; 
					$datas[] = '<tr>
                                    <td>'.$empstrsub.'<a style="margin-left: 5%;" href="' . base_url() . '/accountreport/ledger_statement/' . $dd['id'] . '" id="name_' . $nid . '">' . $ledgername . '</a></td>
                                    <td>Ledger</td>
                                    <td>' . $op_balance_amt_amount . '</td>
                                    <td>' . $clbal_amount . '</td>';
					if ($ledger_p == 1) {
						$datas[] = '	<td>';
						if ($ledgere == 1) {
							$action = '<a style="color: #fff;" href="' . base_url() . '/account/edit_ledger/' . $dd['id'] . '">
                                                <button class="btn btn-primary  btn-rad" style="color: #fff;"><i class="material-icons">&#xE3C9;</i></button>
                                            </a>';
							if($op_dis) $action .= '<a style="color: #fff;" href="' . base_url() . '/account/edit_opbal/' . $dd['id'] . '">
                                                <button class="btn btn-success  btn-rad"><i class="material-icons">attach_money</i></button>
                                            </a>';
							$datas[] = $action;
						}
						if ($ledgerd == 1) {
							$datas[] = '
                                        <a style="color: #fff;" href="#">
                                            <button class="btn btn-danger  btn-rad" onclick="confirm_modal(' . $lid . ')" style="color: #fff;"><i class="material-icons">&#xE872;</i></button>
                                        </a>';
						}
						$datas[] = '
                                    </td>';
					}
					$datas[] = '<tr>';
				}
			}
			
			if(isset($sub_datas[$row['id']]) && !empty($sub_datas[$row['id']]))
			{
			    //print_r($sub_datas[$row['id']]);
			    //die("rr");
			    if($i<=26) //avoid loop
			    {
			        foreach($sub_datas[$row['id']] as $subgroup)
			            $this->wrapHTML($datas,$subgroup,$group_p,$group_e,$group_d,$ledger_p,$ledgere,$ledgerd,$all_ledgers,$entry_datas,$open_bal_datas,$sub_datas,$nsub,$i=$i+1,$op_dis);
			    }
			    
			}
    }
    public function findSub($sub_datas,$gids,&$nsub)
    {
       //find nth subcolumn
	   foreach($sub_datas as $parent_id=>$iter)
	   {
	       $main = false;
	       $i = 2;
	       $parent_id1 = $parent_id;
	       while(!$main)
	       {
	           if($i > 40) //avoid loop
	           {   
	               $i = 2;
	               break;
	           }
	           
    	        $parent_id1 = (isset($gids[$parent_id1])?$gids[$parent_id1]:0);
    	        if($parent_id1 == 0)
    	        {
    	            $main = true;
    	            break;
    	        }
    	        
    	        $i++;
	       }
	       $nsub[$parent_id] = $i;
	   }
    }
    public function index()
	{
	    
		if (!$this->model->list_validate('ac_creation_accounts')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['permission'] = $this->model->get_permission('ac_creation_accounts');
		$data['add_group'] = $this->model->get_permission('group');
		$data['add_ledger'] = $this->model->get_permission('ledger');

		if (!empty($_POST['ledger']))
			$ledger_id = $_POST['ledger'];
		else
			$ledger_id = "";

		$financial_year = $this->db->table("ac_year")->where('status', 1)->get()->getRowArray();
		$ac_year_id = $financial_year['id'];
		
		$ac_start_balance = $this->db->query("SELECT COALESCE(sum(if(dr_amount != '', dr_amount, 0)), 0) as dr_total, COALESCE(sum(if(cr_amount != '', cr_amount, 0)), 0) as cr_total FROM `ac_year_ledger_balance` where ac_year_id = $ac_year_id")->getRowArray();
		$data['ac_op_diff']  = $ac_start_balance['dr_total'] - $ac_start_balance['cr_total'];
		
		$group = $this->db->table("groups")->orderBy('code', 'asc')->get()->getResultArray();
		$all_ledgers_data = $res = $this->db->table("ledgers")->orderBy('left_code', 'asc')->orderBy('right_code', 'asc')->get()->getResultArray();
		$all_ledgers = [];
		$all_ledgers_with_ids = []; //addition id key
		foreach($all_ledgers_data as $iter)
		{
		    if(!isset($all_ledgers[$iter['group_id']]))
		        $all_ledgers[$iter['group_id']] = [];
		       
		    if(!isset($all_ledgers_with_ids[$iter['group_id']][$iter['id']]))
		        $all_ledgers_with_ids[$iter['group_id']][$iter['id']] = [];
		        
		    $all_ledgers[$iter['group_id']][] = $iter;
		    $all_ledgers_with_ids[$iter['group_id']][$iter['id']][] = $iter;
		}
		//print_r($all_ledgers);
		$ledger[] = '<option value="">--Select Ledger--</option>';
		foreach ($group as $row) {
			//$res = $this->db->table("ledgers")->where('group_id', $row['id'])->orderBy('left_code', 'asc')->orderBy('right_code', 'asc')->get()->getResultArray();
			$res = (isset($all_ledgers[$row['id']])?$all_ledgers[$row['id']]:[]);
			foreach ($res as $r) {
				$id = $r['id'];
				$ledgername = $r['left_code'] . '/' . $r['right_code'] . ' - ' . $r['name'];
				if ($ledger_id == $id)
					$selected = 'selected';
				else
					$selected = '';
				$ledger[] .= '<option ' . $selected . ' value="' . $id . '">' . $ledgername . '</option>';
			}
		}
		$data['ledger'] = $ledger;
		$data['group'] = $group;
		//$ac_id = $this->db->table("ac_year")->where('status', 1)->get()->getRowArray();
		$ac_id = $financial_year;
		$sdate = $ac_id['from_year_month'] . "-01";
		$tdate = $ac_id['to_year_month'] . "-31";
		
		$datas = array();
		$group = $this->model->get_permission('group');
		if ($group['edit'] == 1 || $group['delete_p'] == 1)
			$group_p = 1;
		else
			$group_p = 0;
		if ($group['edit'] == 1)
			$group_e = 1;
		else
			$group_e = 0;
		if ($group['delete_p'] == 1)
			$group_d = 1;
		else
			$group_d = 0;
		$ledgerp = $this->model->get_permission('ledger');
		if ($ledgerp['edit'] == 1 || $ledgerp['delete_p'] == 1)
			$ledger_p = 1;
		else
			$ledger_p = 0;
		if ($ledgerp['edit'] == 1)
			$ledgere = 1;
		else
			$ledgere = 0;
		if ($ledgerp['delete_p'] == 1)
			$ledgerd = 1;
		else
			$ledgerd = 0;
			
		//Parent Group
		$datas = array();
		$parent = $this->db->query("select * from groups where parent_id is NULL or parent_id ='' or parent_id = 0 order by code asc")->getResultArray();
		//get all entry data
		$entry_data = $this->db->query("select sum(if(dc='D', amount, 0)) as dr_total,sum(if(dc='C', amount, 0)) as cr_total,entryitems.ledger_id as ledger_id 
								from entryitems 
								inner join entries on entries.id = entryitems. entry_id
								where entries.date >= '$sdate' and entries.date <= '$tdate' group by entryitems.ledger_id")->getResultArray();
		
		$entry_datas = [];
		foreach($entry_data as $iter)
		{
		    if(intval($iter['ledger_id']) == 0)continue;
		    
		     $entry_datas[$iter['ledger_id']] = $iter; 
		}
		
		//get all subgroup
	    $parent_sub = $this->db->query("select * from groups where parent_id > 0 order by code asc")->getResultArray();
	    $sub_datas = [];
	    $gids = $nsub = [];
	    //print_r($parent);
	    foreach($parent as $iter)
	    {
	        $gids[$iter["id"]] = 0;
	    }
	    foreach($parent_sub as $iter)
		{
		    if(!isset($sub_datas[$iter['parent_id']]))
		        $sub_datas[$iter['parent_id']] = [];
		     
		     $gids[$iter["id"]] = $iter["parent_id"];
		     $sub_datas[$iter['parent_id']][] = $iter; 
		}
		$nsub[0] = 1;
	   //get nth group
	   $this->findSub($sub_datas,$gids,$nsub);
	 
		//get all opening balance
		$open_bal_data = $this->db->table('ac_year_ledger_balance')->select('sum(dr_amount) as dr_amount,sum(cr_amount) as cr_amount,ac_year_id,ledger_id')->groupBy('ledger_id,ac_year_id')->get()->getResultArray();
		$open_bal_datas = [];
		foreach($open_bal_data as $iter)
		{
		    if(intval($iter['ac_year_id']) == 0 || intval($iter['ledger_id']) == 0)continue;
		        
		     $open_bal_datas[$iter['ledger_id']] = $iter; 
		}	
		
		foreach ($parent as $row) {
			$this->wrapHTML($datas,$row,$group_p,$group_e,$group_d,$ledger_p,$ledgere,$ledgerd,$all_ledgers,$entry_datas,$open_bal_datas,$sub_datas,$nsub,$i = 0);
		}
		$data['list'] = $datas;
		$data['check_financial_year'] = $this->db->table("ac_year")->where('status', 1)->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('account/index', $data);
		echo view('template/footer');
	}
	public function index_old()
	{
		if (!$this->model->list_validate('ac_creation_accounts')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['permission'] = $this->model->get_permission('ac_creation_accounts');
		$data['add_group'] = $this->model->get_permission('group');
		$data['add_ledger'] = $this->model->get_permission('ledger');

		if (!empty($_POST['ledger']))
			$ledger_id = $_POST['ledger'];
		else
			$ledger_id = "";

		$financial_year = $this->db->table("ac_year")->where('status', 1)->get()->getRowArray();
		$ac_year_id = $financial_year['id'];
		
		$ac_start_balance = $this->db->query("SELECT COALESCE(sum(if(dr_amount != '', dr_amount, 0)), 0) as dr_total, COALESCE(sum(if(cr_amount != '', cr_amount, 0)), 0) as cr_total FROM `ac_year_ledger_balance` where ac_year_id = $ac_year_id")->getRowArray();
		$data['ac_op_diff']  = $ac_start_balance['dr_total'] - $ac_start_balance['cr_total'];
		
		$group = $this->db->table("groups")->orderBy('code', 'asc')->get()->getResultArray();
		$ledger[] = '<option value="">--Select Ledger--</option>';
		foreach ($group as $row) {
			$res = $this->db->table("ledgers")->where('group_id', $row['id'])->orderBy('left_code', 'asc')->orderBy('right_code', 'asc')->get()->getResultArray();
			foreach ($res as $r) {
				$id = $r['id'];
				$ledgername = $r['left_code'] . '/' . $r['right_code'] . ' - ' . $r['name'];
				if ($ledger_id == $id)
					$selected = 'selected';
				else
					$selected = '';
				$ledger[] .= '<option ' . $selected . ' value="' . $id . '">' . $ledgername . '</option>';
			}
		}
		$data['ledger'] = $ledger;
		$data['group'] = $group;
		$ac_id = $this->db->table("ac_year")->where('status', 1)->get()->getRowArray();
		$sdate = $ac_id['from_year_month'] . "-01";
		$tdate = $ac_id['to_year_month'] . "-31";
		//var_dump($sdate);
		//var_dump($tdate);
		//var_dump($ac_id);
		//exit;
		$datas = array();
		$group = $this->model->get_permission('group');
		if ($group['edit'] == 1 || $group['delete_p'] == 1)
			$group_p = 1;
		else
			$group_p = 0;
		if ($group['edit'] == 1)
			$group_e = 1;
		else
			$group_e = 0;
		if ($group['delete_p'] == 1)
			$group_d = 1;
		else
			$group_d = 0;
		$ledgerp = $this->model->get_permission('ledger');
		if ($ledgerp['edit'] == 1 || $ledgerp['delete_p'] == 1)
			$ledger_p = 1;
		else
			$ledger_p = 0;
		if ($ledgerp['edit'] == 1)
			$ledgere = 1;
		else
			$ledgere = 0;
		if ($ledgerp['delete_p'] == 1)
			$ledgerd = 1;
		else
			$ledgerd = 0;
		//Parent Group
		$datas = array();
		$parent = $this->db->query("select * from groups where parent_id is NULL or parent_id ='' or parent_id = 0 order by code asc")->getResultArray();
		foreach ($parent as $row) {
			$lid = $row['id'] . ',1';
			$nid = $row['id'] . '_1';
			$in_ex_group = array(4000,5000,6000,8000,9000);
			if (in_array($row['code'], $in_ex_group)) $op_dis = false;
			else $op_dis = true;
			//print_r($row);
			$datas[] = '<tr>
					   		<td><span id="name_' . $nid . '">(' . $row['code'] . ') ' . $row['name'] . '</span></td>
							<td>Group</td>
							<td>-</td>
							<td>-</td>';
			if ($group_p == 1) {
				$datas[] = '	<td>';
				if ($group_e == 1) {
					if(empty($row['fixed'])){
						$datas[] = '<a style="color: #fff;" href="' . base_url() . '/account/edit_group/' . $row['id'] . '">
                                            <button class="btn btn-primary  btn-rad"><i class="material-icons">&#xE3C9;</i></button>
                                        </a>';
					}

				}
				if($group_d == 1){	
					if(empty($row['fixed'])){
						$datas[] = '<a style="color: #fff;" href="#">	<button class="btn btn-danger btn-rad" onclick="confirm_modal('.$lid.')"><i class="material-icons">&#xE872;</i></button></a>';
					}
				}

				$datas[] = '	</td>';
			}
			$datas[] = '<tr>';
			$id = $row['id'];
			if (!empty($_POST['ledger'])) {
				$ledger_id = $_POST['ledger'];
				$res = $this->db->query("select * from ledgers where group_id = '" . $id . "' and id = '" . $ledger_id . "' order by left_code,right_code asc")->getResultArray();
			} else {
				$res = $this->db->query("select * from `ledgers` where group_id = '" . $id . "' order by left_code,right_code asc")->getResultArray();
			}
			//$res = $this->db->query("select * from ledgers where group_id = '".$id."' ")->getResultArray();
			if (count($res) > 0) {
				foreach ($res as $dd) {
					$lid = $dd['id'] . ',2';
					$nid = $dd['id'] . '_2';
					$led_id = $dd['id'];
					$ledgername = get_ledger_name($led_id);
					$debitamt = 0;
					$creditamt = 0;
					$debitamt = $this->db->query("select sum(entryitems.amount) as amount 
								from entryitems 
								inner join entries on entries.id = entryitems. entry_id
								where entryitems.dc = 'D' and entryitems.ledger_id = $led_id and entries.date >= '$sdate' and entries.date <= '$tdate'")->getRowArray();
					$creditamt = $this->db->query("select sum(entryitems.amount) as amount 
								from entryitems 
								inner join entries on entries.id = entryitems. entry_id
								where entryitems.dc = 'C' and entryitems.ledger_id = $led_id and entries.date >= '$sdate' and entries.date <= '$tdate'")->getRowArray();
					if ($debitamt['amount'] == '')
						$debitamt['amount'] = 0;
					if ($creditamt['amount'] == '')
						$creditamt['amount'] = 0;
					$op_balance = $this->db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id', $dd['id'])->where('ac_year_id', $ac_id['id'])->get()->getRowArray();
					$op_balance_amt = 0;
					if ($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == "") {
						$op_balance_amt -= $op_balance['cr_amount'];
					} else {
						$op_balance_amt += $op_balance['dr_amount'];
					}
					//echo $creditamt['amount'];
					//exit;
					$clbal = ($op_balance_amt - $creditamt['amount']) + $debitamt['amount'];
					
					if($op_balance_amt < 0){
						$op_balance_amt_amount = '(' . number_format(abs($op_balance_amt), "2", ".", ",") . ')';
					}else{
						$op_balance_amt_amount = number_format(abs($op_balance_amt), "2", ".", ",");
					}
					if($clbal < 0){
						$clbal_amount = '(' . number_format(abs($clbal), "2", ".", ",") . ')';
					}else{
						$clbal_amount = number_format(abs($clbal), "2", ".", ",");
					}
					//echo $clbal.'<br>'; 
					$datas[] = '<tr>
                                    <td><a style="margin-left: 5%;" href="' . base_url() . '/accountreport/ledger_statement/' . $dd['id'] . '" id="name_' . $nid . '">' . $ledgername . '</a></td>
                                    <td>Ledger</td>
                                    <td>' . $op_balance_amt_amount . '</td>
                                    <td>' . $clbal_amount . '</td>';
					if ($ledger_p == 1) {
						$datas[] = '	<td>';
						if ($ledgere == 1) {
							$action = '<a style="color: #fff;" href="' . base_url() . '/account/edit_ledger/' . $dd['id'] . '">
                                                <button class="btn btn-primary  btn-rad" style="color: #fff;"><i class="material-icons">&#xE3C9;</i></button>
                                            </a>';
							if($op_dis) $action .= '<a style="color: #fff;" href="' . base_url() . '/account/edit_opbal/' . $dd['id'] . '">
                                                <button class="btn btn-success  btn-rad"><i class="material-icons">attach_money</i></button>
                                            </a>';
							$datas[] = $action;
						}
						if ($ledgerd == 1) {
							$datas[] = '
                                        <a style="color: #fff;" href="#">
                                            <button class="btn btn-danger  btn-rad" onclick="confirm_modal(' . $lid . ')" style="color: #fff;"><i class="material-icons">&#xE872;</i></button>
                                        </a>';
						}
						$datas[] = '
                                    </td>';
					}
					$datas[] = '<tr>';
				}
			}
			// Child Group
			$cgroup = $this->db->query("select * from groups where parent_id = $id order by code asc")->getResultArray();
			foreach ($cgroup as $crow) {
				$lid = $crow['id'] . ',1';
				$nid = $crow['id'] . '_1';
				//print_r($row);
				$datas[] = '<tr>
                                <td>&emsp;<span id="name_' . $nid . '">(' . $crow['code'] . ') ' . $crow['name'] . '</span></td>
                                <td>Group</td>
                                <td>-</td>
                                <td>-</td>';
				if ($group_p == 1) {
					$datas[] = '	<td>';
					if ($group_e == 1) {
						if(empty($crow['fixed'])){
							$datas[] = '<a style="color: #fff;" href="' . base_url() . '/account/edit_group/' . $crow['id'] . '">
                                                <button class="btn btn-primary  btn-rad"><i class="material-icons">&#xE3C9;</i></button>
                                            </a>';
						}

					}
					if($group_d == 1) {
						if(empty($crow['fixed'])){
							$datas[] = '<a style="color: #fff;" href="#"><button class="btn btn-danger btn-rad" onclick="confirm_modal('.$lid.')"><i class="material-icons">&#xE872;</i></button></a>';
						}
						
					}
					$datas[] = '</td>';
				}
				$datas[] = '<tr>';
				$id = $crow['id'];
				if (!empty($_POST['ledger'])) {
					$ledger_id = $_POST['ledger'];
					$res = $this->db->query("select * from ledgers where group_id = '" . $id . "' and id = '" . $ledger_id . "' order by left_code, right_code asc")->getResultArray();
				} else {
					$res = $this->db->query("select * from `ledgers` where group_id = '" . $id . "' order by left_code, right_code asc")->getResultArray();
				}
				if (count($res) > 0) {
					foreach ($res as $dd) {
						$lid = $dd['id'] . ',2';
						$nid = $dd['id'] . '_2';
						$led_id = $dd['id'];
						$ledgername = $dd['name'];
						$debitamt = 0;
						$creditamt = 0;
						$debitamt = $this->db->query("select sum(entryitems.amount) as amount 
								from entryitems 
								inner join entries on entries.id = entryitems. entry_id
								where entryitems.dc = 'D' and entryitems.ledger_id = $led_id and entries.date >= '$sdate' and entries.date <= '$tdate'")->getRowArray();
						$creditamt = $this->db->query("select sum(entryitems.amount) as amount 
								from entryitems 
								inner join entries on entries.id = entryitems. entry_id
								where entryitems.dc = 'C' and entryitems.ledger_id = $led_id and entries.date >= '$sdate' and entries.date <= '$tdate'")->getRowArray();
						if ($debitamt['amount'] == '')
							$debitamt['amount'] = 0;
						if ($creditamt['amount'] == '')
							$creditamt['amount'] = 0;
						$op_balance = $this->db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id', $dd['id'])->where('ac_year_id', $ac_id['id'])->get()->getRowArray();
						$op_balance_amt = 0;
						if ($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == "") {
							$op_balance_amt -= $op_balance['cr_amount'];
						} else {
							$op_balance_amt += $op_balance['dr_amount'];
						}
						$clbal = ($op_balance_amt - $creditamt['amount']) + $debitamt['amount'];
						if($op_balance_amt < 0){
							$op_balance_amt_amount = '(' . number_format(abs($op_balance_amt), "2", ".", ",") . ')';
						}else{
							$op_balance_amt_amount = number_format(abs($op_balance_amt), "2", ".", ",");
						}
						if($clbal < 0){
							$clbal_amount = '(' . number_format(abs($clbal), "2", ".", ",") . ')';
						}else{
							$clbal_amount = number_format(abs($clbal), "2", ".", ",");
						}
						$datas[] = '<tr>
                                        <td>&emsp;&emsp;<a style="margin-left: 5%;" href="' . base_url() . '/accountreport/ledger_statement/' . $dd['id'] . '" id="name_' . $nid . '">('.$dd['left_code'] .'/'. $dd['right_code'] .') ' . $ledgername . '</a></td>
                                        <td>Ledger</td>
                                        <td>' . $op_balance_amt_amount . '</td>
                                        <td>' . $clbal_amount . '</td>';
						if ($ledger_p == 1) {
							$datas[] = '	<td>';
							if ($ledgere == 1) {
								$action = '
                                                <a style="color: #fff;" href="' . base_url() . '/account/edit_ledger/' . $dd['id'] . '">
                                                    <button class="btn btn-primary  btn-rad" style="color: #fff;"><i class="material-icons">&#xE3C9;</i></button>
                                                </a>';
												
                                if($op_dis) $action .= '<a style="color: #fff;" href="' . base_url() . '/account/edit_opbal/' . $dd['id'] . '">
                                                    <button class="btn btn-success  btn-rad"><i class="material-icons">attach_money</i></button>
                                                </a>';
								$datas[] = $action;
							}
							if ($ledgerd == 1) {
								$datas[] = '
                                            <a style="color: #fff;" href="#">
                                                <button class="btn btn-danger  btn-rad" onclick="confirm_modal(' . $lid . ')" style="color: #fff;"><i class="material-icons">&#xE872;</i></button>
                                            </a>';
							}
							$datas[] = '
                                        </td>';
						}
						$datas[] = '<tr>';
					}
				}
				// 2nd child
				$mcgroup = $this->db->query("select * from groups where parent_id = $id")->getResultArray();
				foreach ($mcgroup as $mcrow) {
					$lid = $mcrow['id'] . ',1';
					$nid = $mcrow['id'] . '_1';
					//print_r($row);
					$datas[] = '<tr>
                                    <td>&emsp;&emsp;&emsp;<span id="name_' . $nid . '">(' . $mcrow['code'] . ') ' . $mcrow['name'] . '</span></td>
                                    <td>Group</td>
                                    <td>-</td>
                                    <td>-</td>';
					if ($group_p == 1) {
						$datas[] = '	<td>';
						if ($group_e == 1) {
							if(empty($mcrow['fixed'])){
								$datas[] = '<a style="color: #fff;" href="' . base_url() . '/account/edit_group/' . $mcrow['id'] . '">
                                                    <button class="btn btn-primary  btn-rad"><i class="material-icons">&#xE3C9;</i></button>
                                                </a>';
							}

						}
						if($group_d == 1) {
							if(empty($mcrow['fixed'])){
								$datas[] = '<a style="color: #fff;" href="#"><button class="btn btn-danger btn-rad" onclick="confirm_modal('.$lid.')"><i class="material-icons">&#xE872;</i></button></a>';
							}
						}
						$datas[] = '	</td>';
					}
					$datas[] = '<tr>';
					$id = $mcrow['id'];
					if (!empty($_POST['ledger'])) {
						$ledger_id = $_POST['ledger'];
						$res = $this->db->query("select * from ledgers where group_id = '" . $id . "' and id = '" . $ledger_id . "'  order by left_code, right_code asc")->getResultArray();
					} else {
						$res = $this->db->query("select * from `ledgers` where group_id = '" . $id . "' order by left_code, right_code asc")->getResultArray();
					}
					if (count($res) > 0) {
						foreach ($res as $dd) {
							$led_id = $dd['id'];
							$ledgername = $dd['name'];
							$lid = $dd['id'] . ',2';
							$nid = $dd['id'] . '_2';
							$debitamt = 0;
							$creditamt = 0;
							$debitamt = $this->db->query("select sum(entryitems.amount) as amount 
								from entryitems 
								inner join entries on entries.id = entryitems. entry_id
								where entryitems.dc = 'D' and entryitems.ledger_id = $led_id and entries.date >= '$sdate' and entries.date <= '$tdate'")->getRowArray();
							$creditamt = $this->db->query("select sum(entryitems.amount) as amount 
									from entryitems 
									inner join entries on entries.id = entryitems. entry_id
									where entryitems.dc = 'C' and entryitems.ledger_id = $led_id and entries.date >= '$sdate' and entries.date <= '$tdate'")->getRowArray();
							if ($debitamt['amount'] == '')
								$debitamt['amount'] = 0;
							if ($creditamt['amount'] == '')
								$creditamt['amount'] = 0;
							$op_balance = $this->db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id', $dd['id'])->where('ac_year_id', $ac_id['id'])->get()->getRowArray();
							$op_balance_amt = 0;
							if ($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == "") {
								$op_balance_amt -= $op_balance['cr_amount'];
							} else {
								$op_balance_amt += $op_balance['dr_amount'];
							}
							$clbal = ($op_balance_amt - $creditamt['amount']) + $debitamt['amount'];
							if($op_balance_amt < 0){
								$op_balance_amt_amount = '(' . number_format(abs($op_balance_amt), "2", ".", ",") . ')';
							}else{
								$op_balance_amt_amount = number_format(abs($op_balance_amt), "2", ".", ",");
							}
							if($clbal < 0){
								$clbal_amount = '(' . number_format(abs($clbal), "2", ".", ",") . ')';
							}else{
								$clbal_amount = number_format(abs($clbal), "2", ".", ",");
							}
							$datas[] = '<tr>
                                            <td>&emsp;&emsp;&emsp;&emsp;<a style="margin-left: 5%;" href="' . base_url() . '/accountreport/ledger_statement/' . $dd['id'] . '" id="name_' . $nid . '">('.$dd['left_code'] .'/'. $dd['right_code'] .') ' . $ledgername . '</a></td>
                                            <td>Ledger</td>
                                            <td>' . $op_balance_amt_amount . '</td>
                                            <td>' . $clbal_amount . '</td>';
							if ($ledger_p == 1) {
								$datas[] = '	<td>';
								if ($ledgere == 1) {
									$action = '
                                                    <a style="color: #fff;" href="' . base_url() . '/account/edit_ledger/' . $dd['id'] . '">
                                                        <button class="btn btn-primary  btn-rad" style="color: #fff;"><i class="material-icons">&#xE3C9;</i></button>
                                                    </a>';
														
                                    if($op_dis) $action .= '<a style="color: #fff;" href="' . base_url() . '/account/edit_opbal/' . $dd['id'] . '">
                                                        <button class="btn btn-success  btn-rad"><i class="material-icons">attach_money</i></button>
                                                    </a>';
									$datas[] = $action;
								}
								if ($ledgerd == 1) {
									$datas[] = '
                                                <a style="color: #fff;" href="#">
                                                    <button class="btn btn-danger  btn-rad" onclick="confirm_modal(' . $lid . ')" style="color: #fff;"><i class="material-icons">&#xE872;</i></button>
                                                </a>';
								}
								$datas[] = '
                                            </td>';
							}
							$datas[] = '<tr>';
						}
					}
				}
			}
		}
		$data['list'] = $datas;
		$data['check_financial_year'] = $this->db->table("ac_year")->where('status', 1)->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('account/index', $data);
		echo view('template/footer');
	}
	
	
	
	
	
	
	public function index_new()
	{
	
		if (!$this->model->list_validate('ac_creation_accounts')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['permission'] = $this->model->get_permission('ac_creation_accounts');
		$data['add_group'] = $this->model->get_permission('group');
		$data['add_ledger'] = $this->model->get_permission('ledger');

		if (!empty($_POST['ledger']))
			$ledger_id = $_POST['ledger'];
		else
			$ledger_id = "";

		$group = $this->db->table("groups")->orderBy('code', 'asc')->get()->getResultArray();
		$ledger[] = '<option value="">--Select Ledger--</option>';
		foreach ($group as $row) {
			$res = $this->db->table("ledgers")->where('group_id', $row['id'])->orderBy('code', 'asc')->get()->getResultArray();
			foreach ($res as $r) {
				$id = $r['id'];
				$ledgername = $r['left_code'] . '/' . $r['right_code'] . ' - ' . $r['name'];
				if ($ledger_id == $id)
					$selected = 'selected';
				else
					$selected = '';
				$ledger[] .= '<option ' . $selected . ' value="' . $id . '">' . $ledgername . '</option>';
			}
		}
		$data['ledger'] = $ledger;
		$data['group'] = $group;
		$ac_id = $this->db->table("ac_year")->where('status', 1)->get()->getRowArray();
		$sdate = $ac_id['from_year_month'] . "-01";
		$tdate = $ac_id['to_year_month'] . "-31";
		//var_dump($sdate);
		//var_dump($tdate);
		//var_dump($ac_id);
		//exit;
		$datas = array();
		$group = $this->model->get_permission('group');
		if ($group['edit'] == 1 || $group['delete_p'] == 1)
			$group_p = 1;
		else
			$group_p = 0;
		if ($group['edit'] == 1)
			$group_e = 1;
		else
			$group_e = 0;
		if ($group['delete_p'] == 1)
			$group_d = 1;
		else
			$group_d = 0;
		$ledgerp = $this->model->get_permission('ledger');
		if ($ledgerp['edit'] == 1 || $ledgerp['delete_p'] == 1)
			$ledger_p = 1;
		else
			$ledger_p = 0;
		if ($ledgerp['edit'] == 1)
			$ledgere = 1;
		else
			$ledgere = 0;
		if ($ledgerp['delete_p'] == 1)
			$ledgerd = 1;
		else
			$ledgerd = 0;
		//Parent Group
		$datas = array();
		$parent = $this->db->query("select * from groups where parent_id is NULL or parent_id ='' or parent_id = 0 order by code asc")->getResultArray();
		foreach ($parent as $row) {
			$lid = $row['id'] . ',1';
			$nid = $row['id'] . '_1';
			//print_r($row);
			$datas[] = '<tr class="parent_1">
					   		<td><a><span id="name_' . $nid . '">(' . $row['code'] . ') ' . $row['name'] . '</span></a> </td>
							<td>Group</td>
							<td>-</td>
							<td>-</td>';
			if ($group_p == 1) {
				$datas[] = '	<td>';
				if ($group_e == 1) {
					$datas[] = '		<a style="color: #fff;" href="' . base_url() . '/account/edit_group/' . $row['id'] . '">
                                            <button class="btn btn-primary  btn-rad"><i class="material-icons">&#xE3C9;</i></button>
                                        </a>';

				}
				/*if($group_d == 1) {				
																																																																																																													$datas[] = '		<a style="color: #fff;" href="#">
																																																																																																																		<button class="btn btn-danger btn-rad" onclick="confirm_modal('.$lid.')"><i class="material-icons">&#xE872;</i></button>
																																																																																																																	</a>';
																																																																																																													}*/

				$datas[] = '	</td>';
			}
			$datas[] = '</tr>';
			$id = $row['id'];
			if (!empty($_POST['ledger'])) {
				$ledger_id = $_POST['ledger'];
				$res = $this->db->query("select * from ledgers where group_id = '" . $id . "' and id = '" . $ledger_id . "' ")->getResultArray();
			} else {
				$res = $this->db->query("select * from `ledgers` where group_id = '" . $id . "' ")->getResultArray();
			}
			//$res = $this->db->query("select * from ledgers where group_id = '".$id."' ")->getResultArray();
			if (count($res) > 0) {
				foreach ($res as $dd) {
					$lid = $dd['id'] . ',2';
					$nid = $dd['id'] . '_2';
					$led_id = $dd['id'];
					$ledgername = get_ledger_name($led_id);
					$debitamt = 0;
					$creditamt = 0;
					$debitamt = $this->db->query("select sum(entryitems.amount) as amount 
								from entryitems 
								inner join entries on entries.id = entryitems. entry_id
								where entryitems.dc = 'D' and entryitems.ledger_id = $led_id and entries.date >= '$sdate' and entries.date <= '$tdate'")->getRowArray();
					$creditamt = $this->db->query("select sum(entryitems.amount) as amount 
								from entryitems 
								inner join entries on entries.id = entryitems. entry_id
								where entryitems.dc = 'C' and entryitems.ledger_id = $led_id and entries.date >= '$sdate' and entries.date <= '$tdate'")->getRowArray();
					if ($debitamt['amount'] == '')
						$debitamt['amount'] = 0;
					if ($creditamt['amount'] == '')
						$creditamt['amount'] = 0;
					$op_balance = $this->db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id', $dd['id'])->where('ac_year_id', $ac_id['id'])->get()->getRowArray();
					if ($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == "") {
						$op_balance_amt = $op_balance['cr_amount'];
					} else {
						$op_balance_amt = $op_balance['dr_amount'];
					}
					//echo $creditamt['amount'];
					//exit;
					$clbal = ($op_balance_amt - $creditamt['amount']) + $debitamt['amount'];
					//echo $clbal.'<br>'; 
					$datas[] = '<tr class="child">
                                    <td><a style="margin-left: 5%;" href="' . base_url() . '/accountreport/ledger_statement/' . $dd['id'] . '" id="name_' . $nid . '">' . $ledgername . '</a></td>
                                    <td>Ledger</td>
                                    <td>' . number_format($op_balance_amt, "2", ".", ",") . '</td>
                                    <td>' . number_format(abs($clbal), "2", ".", ",") . '</td>';
					if ($ledger_p == 1) {
						$datas[] = '	<td>';
						if ($ledgere == 1) {
							$datas[] = '
                                            <a style="color: #fff;" href="' . base_url() . '/account/edit_ledger/' . $dd['id'] . '">
                                                <button class="btn btn-primary  btn-rad" style="color: #fff;"><i class="material-icons">&#xE3C9;</i></button>
                                            </a> 
                                            <a style="color: #fff;" href="' . base_url() . '/account/edit_opbal/' . $dd['id'] . '">
                                                <button class="btn btn-success  btn-rad"><i class="material-icons">attach_money</i></button>
                                            </a>';
						}
						if ($ledgerd == 1) {
							$datas[] = '
                                        <a style="color: #fff;" href="#">
                                            <button class="btn btn-danger  btn-rad" onclick="confirm_modal(' . $lid . ')" style="color: #fff;"><i class="material-icons">&#xE872;</i></button>
                                        </a>';
						}
						$datas[] = '
                                    </td>';
					}
					$datas[] = '</tr>';
				}
			}
			// Child Group
			$cgroup = $this->db->query("select * from groups where parent_id = $id order by code asc")->getResultArray();
			foreach ($cgroup as $crow) {
				$lid = $crow['id'] . ',1';
				$nid = $crow['id'] . '_1';
				//print_r($row);
				$datas[] = '<tr class="parent">
                                <td>&emsp; <a><span id="name_' . $nid . '">(' . $crow['code'] . ') ' . $crow['name'] . '</span></a></td>
                                <td>Group</td>
                                <td>-</td>
                                <td>-</td>';
				if ($group_p == 1) {
					$datas[] = '	<td>';
					if ($group_e == 1) {
						$datas[] = '		<a style="color: #fff;" href="' . base_url() . '/account/edit_group/' . $crow['id'] . '">
                                                <button class="btn btn-primary  btn-rad"><i class="material-icons">&#xE3C9;</i></button>
                                            </a>';

					}
					/*if($group_d == 1) {				
																																																																																																																																								 $datas[] = '		<a style="color: #fff;" href="#">
																																																																																																																																													 <button class="btn btn-danger btn-rad" onclick="confirm_modal('.$lid.')"><i class="material-icons">&#xE872;</i></button>
																																																																																																																																												 </a>';
																																																																																																																																								 }	*/

					$datas[] = '	</td>';
				}
				$datas[] = '</tr>';
				$id = $crow['id'];
				if (!empty($_POST['ledger'])) {
					$ledger_id = $_POST['ledger'];
					$res = $this->db->query("select * from ledgers where group_id = '" . $id . "' and id = '" . $ledger_id . "' order by left_code asc")->getResultArray();
				} else {
					$res = $this->db->query("select * from `ledgers` where group_id = '" . $id . "' order by left_code asc")->getResultArray();
				}
				if (count($res) > 0) {
					foreach ($res as $dd) {
						$lid = $dd['id'] . ',2';
						$nid = $dd['id'] . '_2';
						$led_id = $dd['id'];
						$ledgername = $dd['name'];
						$debitamt = 0;
						$creditamt = 0;
						$debitamt = $this->db->query("select sum(entryitems.amount) as amount 
								from entryitems 
								inner join entries on entries.id = entryitems. entry_id
								where entryitems.dc = 'D' and entryitems.ledger_id = $led_id and entries.date >= '$sdate' and entries.date <= '$tdate'")->getRowArray();
						$creditamt = $this->db->query("select sum(entryitems.amount) as amount 
								from entryitems 
								inner join entries on entries.id = entryitems. entry_id
								where entryitems.dc = 'C' and entryitems.ledger_id = $led_id and entries.date >= '$sdate' and entries.date <= '$tdate'")->getRowArray();
						if ($debitamt['amount'] == '')
							$debitamt['amount'] = 0;
						if ($creditamt['amount'] == '')
							$creditamt['amount'] = 0;
						$op_balance = $this->db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id', $dd['id'])->where('ac_year_id', $ac_id['id'])->get()->getRowArray();
						if ($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == "") {
							$op_balance_amt = $op_balance['cr_amount'];
						} else {
							$op_balance_amt = $op_balance['dr_amount'];
						}
						$clbal = ($op_balance_amt - $creditamt['amount']) + $debitamt['amount'];
						$datas[] = '<tr class="child">
                                        <td>&emsp;&emsp;<a style="margin-left: 5%;" href="' . base_url() . '/accountreport/ledger_statement/' . $dd['id'] . '" id="name_' . $nid . '">('.$dd['left_code'] .'/'. $dd['right_code'] .') ' . $ledgername . '</a></td>
                                        <td>Ledger</td>
                                        <td>' . number_format($op_balance_amt, "2", ".", ",") . '</td>
                                        <td>' . number_format(abs($clbal), "2", ".", ",") . '</td>';
						if ($ledger_p == 1) {
							$datas[] = '	<td>';
							if ($ledgere == 1) {
								$datas[] = '
                                                <a style="color: #fff;" href="' . base_url() . '/account/edit_ledger/' . $dd['id'] . '">
                                                    <button class="btn btn-primary  btn-rad" style="color: #fff;"><i class="material-icons">&#xE3C9;</i></button>
                                                </a> 
                                                <a style="color: #fff;" href="' . base_url() . '/account/edit_opbal/' . $dd['id'] . '">
                                                    <button class="btn btn-success  btn-rad"><i class="material-icons">attach_money</i></button>
                                                </a>';
							}
							if ($ledgerd == 1) {
								$datas[] = '
                                            <a style="color: #fff;" href="#">
                                                <button class="btn btn-danger  btn-rad" onclick="confirm_modal(' . $lid . ')" style="color: #fff;"><i class="material-icons">&#xE872;</i></button>
                                            </a>';
							}
							$datas[] = '
                                        </td>';
						}
						$datas[] = '</tr>';
					}
				}
				// 2nd child
				$mcgroup = $this->db->query("select * from groups where parent_id = $id")->getResultArray();
				foreach ($mcgroup as $mcrow) {
					$lid = $mcrow['id'] . ',1';
					$nid = $mcrow['id'] . '_1';
					//print_r($row);
					$datas[] = '<tr class="parent">
                                    <td>&emsp;&emsp;&emsp; <a><span id="name_' . $nid . '">(' . $mcrow['code'] . ') ' . $mcrow['name'] . '</span></a></td>
                                    <td>Group</td>
                                    <td>-</td>
                                    <td>-</td>';
					if ($group_p == 1) {
						$datas[] = '	<td>';
						if ($group_e == 1) {
							$datas[] = '		<a style="color: #fff;" href="' . base_url() . '/account/edit_group/' . $mcrow['id'] . '">
                                                    <button class="btn btn-primary  btn-rad"><i class="material-icons">&#xE3C9;</i></button>
                                                </a>';

						}
						/* if($group_d == 1) {				
																																																																																																																																																																			   $datas[] = '		<a style="color: #fff;" href="#">
																																																																																																																																																																								   <button class="btn btn-danger btn-rad" onclick="confirm_modal('.$lid.')"><i class="material-icons">&#xE872;</i></button>
																																																																																																																																																																							   </a>';
																																																																																																																																																																			   }	*/

						$datas[] = '	</td>';
					}
					$datas[] = '</tr>';
					$id = $mcrow['id'];
					if (!empty($_POST['ledger'])) {
						$ledger_id = $_POST['ledger'];
						$res = $this->db->query("select * from ledgers where group_id = '" . $id . "' and id = '" . $ledger_id . "' ")->getResultArray();
					} else {
						$res = $this->db->query("select * from `ledgers` where group_id = '" . $id . "' ")->getResultArray();
					}
					if (count($res) > 0) {
						foreach ($res as $dd) {
							$led_id = $dd['id'];
							$ledgername = $dd['name'];
							$lid = $dd['id'] . ',2';
							$nid = $dd['id'] . '_2';
							$debitamt = 0;
							$creditamt = 0;
							$debitamt = $this->db->query("select sum(entryitems.amount) as amount 
								from entryitems 
								inner join entries on entries.id = entryitems. entry_id
								where entryitems.dc = 'D' and entryitems.ledger_id = $led_id and entries.date >= '$sdate' and entries.date <= '$tdate'")->getRowArray();
							$creditamt = $this->db->query("select sum(entryitems.amount) as amount 
									from entryitems 
									inner join entries on entries.id = entryitems. entry_id
									where entryitems.dc = 'C' and entryitems.ledger_id = $led_id and entries.date >= '$sdate' and entries.date <= '$tdate'")->getRowArray();
							if ($debitamt['amount'] == '')
								$debitamt['amount'] = 0;
							if ($creditamt['amount'] == '')
								$creditamt['amount'] = 0;
							$op_balance = $this->db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id', $dd['id'])->where('ac_year_id', $ac_id['id'])->get()->getRowArray();
							if ($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == "") {
								$op_balance_amt = $op_balance['cr_amount'];
							} else {
								$op_balance_amt = $op_balance['dr_amount'];
							}
							$clbal = ($op_balance_amt - $creditamt['amount']) + $debitamt['amount'];
							$datas[] = '<tr class="child">
                                            <td>&emsp;&emsp;&emsp;&emsp;<a style="margin-left: 5%;" href="' . base_url() . '/accountreport/ledger_statement/' . $dd['id'] . '" id="name_' . $nid . '">('.$dd['left_code'] .'/'. $dd['right_code'] .') ' . $ledgername . '</a></td>
                                            <td>Ledger</td>
                                            <td>' . number_format($op_balance_amt, "2", ".", ",") . '</td>
                                            <td>' . number_format(abs($clbal), "2", ".", ",") . '</td>';
							if ($ledger_p == 1) {
								$datas[] = '	<td>';
								if ($ledgere == 1) {
									$datas[] = '
                                                    <a style="color: #fff;" href="' . base_url() . '/account/edit_ledger/' . $dd['id'] . '">
                                                        <button class="btn btn-primary  btn-rad" style="color: #fff;"><i class="material-icons">&#xE3C9;</i></button>
                                                    </a> 
                                                    <a style="color: #fff;" href="' . base_url() . '/account/edit_opbal/' . $dd['id'] . '">
                                                        <button class="btn btn-success  btn-rad"><i class="material-icons">attach_money</i></button>
                                                    </a>';
								}
								if ($ledgerd == 1) {
									$datas[] = '
                                                <a style="color: #fff;" href="#">
                                                    <button class="btn btn-danger  btn-rad" onclick="confirm_modal(' . $lid . ')" style="color: #fff;"><i class="material-icons">&#xE872;</i></button>
                                                </a>';
								}
								$datas[] = '
                                            </td>';
							}
							$datas[] = '<tr>';
						}
					}
				}
			}
		}
		$data['list'] = $datas;
		$data['check_financial_year'] = $this->db->table("ac_year")->where('status', 1)->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('account/index_new', $data);
		echo view('template/footer');
	
	}

	public function add_group()
	{

		if (!$this->model->permission_validate('group', 'create_p')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['group'] = $this->db->table('groups')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('account/add_group', $data);
		echo view('template/footer');
	}

	public function edit_group()
	{
		if (!$this->model->permission_validate('group', 'edit')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('groups')->where("id", $id)->get()->getRowArray();
		$data['group'] = $this->db->table('groups')->get()->getResultArray();
		//print_r($data);die;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('account/edit_group', $data);
		echo view('template/footer');
	}

	public function save_add_group()
	{
		$id = $_POST['id'];

		if(!empty($_POST['pgroup'])) $data['parent_id'] = $_POST['pgroup'];
		$data['name'] = $_POST['gname'];
		$data['code'] = $_POST['gcode'];
		$data['added_by'] = $this->session->get('log_id');

		if (empty($id)) {
			$data['created'] = date('Y-m-d H:i:s');
			$data['modified'] = date('Y-m-d H:i:s');
			$builder = $this->db->table('groups')->insert($data);
			if ($builder) {
				$this->session->setFlashdata('succ', 'Groups Added Successfully');
				header("Location: " . base_url() . "/account");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/account");
			}
		} else {
			$data['modified'] = date('Y-m-d H:i:s');
			$builder = $this->db->table('groups')->where('id', $id)->update($data);
			if ($builder) {
				$this->session->setFlashdata('succ', 'Groups Update Successfully');
				header("Location: " . base_url() . "/account");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/account");
			}
		}
	}

	public function add_ledger()
	{
		if (!$this->model->permission_validate('ledger', 'create_p')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['group'] = $this->db->table('groups')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('account/add_ledger', $data);
		echo view('template/footer');
	}

	public function edit_ledger()
	{
		if (!$this->model->permission_validate('ledger', 'edit')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('ledgers')->where("id", $id)->get()->getRowArray();
		$data['group'] = $this->db->table('groups')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('account/edit_ledger', $data);
		echo view('template/footer');
	}

	public function entries()
	{
		if (!$this->model->list_validate('entries_accounts')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['permission'] = $this->model->get_permission('entries_accounts');
		$data['data'] = $this->db->table('entries')->where('inv_id', null)->where('type', null)->orderBy('id', 'desc')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('entries/index', $data);
		echo view('template/footer');
	}

	public function save_add_ledger()
	{
		$id = $_POST['id'];
		if(!empty($_POST['ledger_subgroup'])){
			$data['group_id'] = $_POST['ledger_subgroup'];
		}else{
			$data['group_id'] = $_POST['lgroup'];
		}
		$data['name'] = $_POST['lname'];
		$data['code'] = $_POST['lcode'];
		$data['op_balance'] = $_POST['op_bal'];
		$data['op_balance_dc'] = $_POST['op_dc'];
		$data['type'] = $_POST['type'];
		$data['reconciliation'] = $_POST['reconciliation'];
		$data['right_code'] = $_POST['right_code'];
		//echo '<pre>';
		//print_r($data);die;
		$ac_id = $this->db->table("ac_year")->where('status', 1)->get()->getRowArray();
		if(!empty($data['name']) && !empty($data['right_code']) && !empty($data['group_id']) ){
			$group_name_left_code = $this->db->table("groups")->where('id', $data['group_id'])->get()->getRowArray();
			$data['left_code'] = $group_name_left_code['code'];
			if (empty($id)) {
				$res = $this->db->table('ledgers')->insert($data);
				if ($res) {
					$ledger_id = $this->db->insertID();
					if ($_POST['op_dc'] == "D") {
						$acdata['dr_amount'] = $_POST['op_bal'];
						$acdata['cr_amount'] = "0.00";
					} else {
						$acdata['cr_amount'] = $_POST['op_bal'];
						$acdata['dr_amount'] = "0.00";
					}
					$acdata['ledger_id'] = $ledger_id;
					$acdata['ac_year_id'] = $ac_id['id'];
					$data_exists = $this->db->table('ac_year_ledger_balance')->where('ledger_id', $ledger_id)->where('ac_year_id', $ac_id['id'])->get()->getNumRows();
					if ($data_exists > 0) {
						$res = $this->db->table('ac_year_ledger_balance')->where('ledger_id', $ledger_id)->where('ac_year_id', $ac_id['id'])->update($acdata);
					} else {
						$res = $this->db->table('ac_year_ledger_balance')->insert($acdata);
					}
	
					$this->session->setFlashdata('succ', 'Ledger Add Successfully');
					header("Location: " . base_url() . "/account");
				} else {
					$this->session->setFlashdata('fail', 'Please Try Again');
					header("Location: " . base_url() . "/account");
				}
			} else {
				$res = $this->db->table('ledgers')->where('id', $id)->update($data);
				if ($res) {
					$this->session->setFlashdata('succ', 'Ledger Update Successfully');
					header("Location: " . base_url() . "/account");
				} else {
					$this->session->setFlashdata('fail', 'Please Try Again');
					header("Location: " . base_url() . "/account");
				}
			}
		}
		else {
			$this->session->setFlashdata('fail', 'Please enter required fields');
			header("Location: " . base_url() . "/account");
		}
	}
	public function get_group_code(){
		$ledger_subgroup_id = $_POST['ledger_subgroup_id'];
		if(!empty($ledger_subgroup_id)){
			$group = $ledger_subgroup_id;
		}
		else{
			$group = $_POST['ledger_group_id'];
		}
		$group_name_left_code = $this->db->table("groups")->where('id', $group)->get()->getRowArray();
		echo $group_name_left_code['code'];
	}
	public function check_group()
	{
		$id = $this->request->uri->getSegment(3);
		$ent = $this->db->table('entryitems')->where('ledger_id', $id)->get()->getNumRows();
		$led = $this->db->table('ledgers')->where('group_id', $id)->get()->getNumRows();
		$grp = $this->db->table('groups')->where('parent_id', $id)->get()->getNumRows();
		if ($ent == 0 && $led == 0 && $grp == 0)
			$res = true;
		else
			$res = false;
		echo json_encode($res);
	}
	public function check_ledger()
	{
		$id = $this->request->uri->getSegment(3);
		$ent = $this->db->table('entryitems')->where('ledger_id', $id)->get()->getNumRows();
		if ($ent == 0)
			$res = true;
		else
			$res = false;
		echo json_encode($res);
	}

	public function delete_group($id)
	{
		// $id = $this->request->uri->getSegment(3);
		$num_rows = $this->db->table('ledgers')->where("group_id", $id)->get()->getNumRows();
		if($num_rows < 1){
			$res = $this->db->table('groups')->delete(['id' => $id]);
			if ($res) {
				$this->session->setFlashdata('succ', 'Group Delete Successfully');
				header("Location: " . base_url() . "/account");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again...');
				header("Location: " . base_url() . "/account");
			}
		}else{
			$this->session->setFlashdata('fail', 'Ledger found under the group. You can\'t delete the group.');
			header("Location: " . base_url() . "/account");
		}
		exit;
	}

	public function delete_ledger($id)
	{
		// $id = $this->request->uri->getSegment(3);
		$num_rows = $this->db->table('entryitems')->where("ledger_id", $id)->get()->getNumRows();
		if($num_rows < 1){
			$res = $this->db->table('ledgers')->delete(['id' => $id]);
			if ($res) {
				$this->session->setFlashdata('succ', 'Ledger Delete Successfully');
				header("Location: " . base_url() . "/account");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again...');
				header("Location: " . base_url() . "/account");
			}
		}else{
			$this->session->setFlashdata('fail', 'Entries found. You can\'t delete the ledger.');
			header("Location: " . base_url() . "/account");
		}
		exit;
	}

	public function edit_opbal()
	{
		if (!$this->model->permission_validate('ledger', 'edit')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$data['id'] = $id;
		//$data['data1'] = $this->db->table('ledgers')->where("id", $id)->get()->getRowArray();
		$data['data'] = $this->db->table('ac_year_ledger_balance')->where("ledger_id", $id)->get()->getRowArray();
		$data['year'] = $this->db->table('ac_year')->get()->getResultArray();
		$data['funds'] = $this->db->table('funds')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('account/edit_opbal', $data);
		echo view('template/footer');
	}

	public function save_add_ledger_opbal()
	{
		$year = $_POST['fyear'];
		$id = $_POST['id'];
		$data['ac_year_id'] = $year;
		$data['ledger_id'] = $id;
		$selval = $_POST['op_dc'];
		if ($selval == "D") {
			$data['dr_amount'] = $_POST['op_bal'];
			$data['cr_amount'] = "0.00";
		} else if ($selval == "C") {
			$data['dr_amount'] = "0.00";
			$data['cr_amount'] = $_POST['op_bal'];
		}
		$data_exists = $this->db->table('ac_year_ledger_balance')->where('ledger_id', $id)->where('ac_year_id', $year)->get()->getNumRows();
		/* echo '<pre>';
		print_r($data_exists);die; */
		if ($data_exists > 0) {
			$res = $this->db->table('ac_year_ledger_balance')->where('ledger_id', $id)->where('ac_year_id', $year)->update($data);
			if ($res) {
				$this->session->setFlashdata('succ', 'Opening Balance Updated Successfully');
				header("Location: " . base_url() . "/account");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/account");
			}
		} else {
			$res = $this->db->table('ac_year_ledger_balance')->insert($data);
			if ($res) {
				$this->session->setFlashdata('succ', 'Opening Balance Added Successfully');
				header("Location: " . base_url() . "/account");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/account");
			}
		}
	}

	public function get_amt()
	{
		$id = $_POST['id'];
		$yr = $_POST['yr'];
		$builder = $this->db->table("ac_year_ledger_balance")->where("ledger_id", $id)->where("ac_year_id", $yr);
		if(!empty($_POST['fund_id'])) $builder->where("fund_id", $_POST['fund_id']);
		$res = $builder->get()->getRowArray();
		if ($res['cr_amount'] == "0.00") {
			$data['select'] = "D";
			$data['amt'] = $res['dr_amount'];
		} else if ($res['dr_amount'] == "0.00") {
			$data['select'] = "C";
			$data['amt'] = $res['cr_amount'];
		} else {
			$data['select'] = "D";
			$data['amt'] = "0.00";
		}
		echo json_encode($data);
	}

	public function funds()
	{


		$data['list'] = $this->db->table('funds')->get()->getResultArray();

		echo view('template/header');
		echo view('template/sidebar');
		echo view('account/funds', $data);
		echo view('template/footer');
	}
	public function save_donation_category(){
        

		$id = $_POST['id'];
		$data['name']	 =	trim($_POST['name']);
		$data['description']	 =	trim($_POST['description']);
		$data['code'] = trim($_POST['code']);
	
		
		
		if(empty($id)){
		    $builder = $this->db->table('donation_category')->insert($data);
		    if($builder){
    		    $this->session->setFlashdata('succ', 'Donation Category Added Successfully');
    		    header("Location: ".base_url()."/master/donation_category");
    		}else{
    		    $this->session->setFlashdata('fail', 'Please Try Again');
    		    header("Location: ".base_url()."/master/donation_category");
    		}
		}else{
            
            $builder = $this->db->table('donation_category')->where('id', $id)->update($data);
		    if($builder){
    		    $this->session->setFlashdata('succ', 'Donation Category Update Successfully');
    		    header("Location: ".base_url()."/master/donation_category");
    		}else{
    		    $this->session->setFlashdata('fail', 'Please Try Again');
    		    header("Location: ".base_url()."/master/donation_category");
    		}
		}
		
	}
	public function save_funds()
	{
		
		$id = $_POST['id'];
		$data['name'] = trim($_POST['name']);
		$data['description'] = trim($_POST['description']);
		$data['code'] = trim($_POST['code']);

		
		if (empty($id)) {
			$data['created'] = date('Y-m-d H:i:s');
			$data['modified'] = date('Y-m-d H:i:s');
			$builder = $this->db->table('funds')->insert($data);

			
			if($builder){
    		    $this->session->setFlashdata('succ', 'Fund Added Successfully');
    		    header("Location: ".base_url()."/account/funds");
    		}else{
    		    $this->session->setFlashdata('fail', 'Please Try Again');
    		    header("Location: ".base_url()."/account/funds");
    		}

		} else {
			$data['modified'] = date('Y-m-d H:i:s');
			$builder = $this->db->table('funds')->where('id', $id)->update($data);
			
		    if($builder){
    		    $this->session->setFlashdata('succ', 'Fund Update Successfully');
    		    header("Location: ".base_url()."/account/funds");
    		}else{
    		    $this->session->setFlashdata('fail', 'Please Try Again');
    		    header("Location: ".base_url()."/account/funds");
    		}
			
		}


	}

	public function funds_validation(){
		$name = trim($_POST['name']);
		
		$data = array();
		if (empty($name) ) {
		  $data['err'] = "Please Fill Required Fields";
		  $data['succ']= '';
		}else{
		  $data['succ'] = "Form validate";
		  $data['err'] ='';
		}
		echo json_encode($data);
	}
	public function del_funds_check(){
		$id = $_POST['id'];
		$res = $this->db->table("funds")->where("name", $id)->get()->getResultArray();
		echo count($res);
	}
	public function delete_funds(){
	    
		$id=  $this->request->uri->getSegment(3);
		$res = $this->db->table('funds')->delete(['id' => $id]);
		if($res){
		    $this->session->setFlashdata('succ', 'Fund Delete Successfully');
		    header("Location: ".base_url()."/account/funds");
		}else{
		    $this->session->setFlashdata('fail', 'Please Try Again');
		    header("Location: ".base_url()."/account/funds");
		}
	}
	
	public function edit_funds(){
	    
		$id=  $this->request->uri->getSegment(3);
	    $data['data'] = $this->db->table('funds')->where('id', $id)->get()->getRowArray();
		
	    echo view('template/header');
		echo view('template/sidebar');
		echo view('account/add_funds', $data);
		echo view('template/footer');
	}
	
	public function view_funds(){
	   
		$id=  $this->request->uri->getSegment(3);
		
	    $data['data'] = $this->db->table('funds')->where('id', $id)->get()->getRowArray();
	    $data['view'] = true;
	    echo view('template/header');
		echo view('template/sidebar');
		echo view('account/add_funds', $data);
		echo view('template/footer');
	}

	public function add_funds() {

		$data['funds'] = $this->db->table('funds')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('account/add_funds', $data);
		echo view('template/footer');
    }
	public function get_sub_group($id, $json = true){
		$groups = $this->db->table('groups')->where("parent_id", $id)->get()->getResultArray();
		if($json){
			echo json_encode($groups);
			exit;
		}else return $groups;
	}
	
	public function save_group()
	{
		
		$data['parent_id'] = trim($_POST['g_id']);
		$data['name'] = trim($_POST['group']);
		$data['code'] = trim($_POST['code']);
		$data['added_by'] = $this->session->get('log_id');
		$data['created'] = date('Y-m-d H:i:s');
		$data['modified'] = date('Y-m-d H:i:s');
			
		$builder = $this->db->table('groups')->insert($data);
		$sub_groups = $this->get_sub_group($data['parent_id'], false);
		$data = array("status"=>"success","sub_groups" => $sub_groups);
		echo json_encode($data);
		exit;

	}
}