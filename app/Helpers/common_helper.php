<?php
function get_ledger_name($id)
{
	$db = db_connect();
	$tot_groups = $db->table('ledgers')->where('id', $id)->get()->getRowArray();
	if ($tot_groups) {
		if (!empty($tot_groups['code']))
			$name = "(" . $tot_groups['code'] . ") - " . $tot_groups['name'];
		else {
			$name = '';
			if (!empty($tot_groups['left_code'])) {
				$name .= '(';
				$name .= $tot_groups['left_code'];
				$name .= '/';
				if (!empty($tot_groups['right_code']))
					$name .= $tot_groups['right_code'];
				$name .= ')';
			}
			$name .= $tot_groups['name'];
		}
	}
	return $name;
}
function get_ledger_name_only($id)
{
	$db = db_connect();
	$tot_groups = $db->table('ledgers')->where('id', $id)->get()->getRowArray();
	if ($tot_groups) {
		if (!empty($tot_groups['name'])) {
			$name = $tot_groups['name'];
		} else {
			$name = "";
		}
	}
	return $name;
}
function get_ledger_code_only($id)
{
	$db = db_connect();
	$tot_groups = $db->table('ledgers')->where('id', $id)->get()->getRowArray();
	if ($tot_groups) {
		$name = '';
		if (!empty($tot_groups['left_code'])) {
			$name .= $tot_groups['left_code'];
		}
		$name .= '/';
		if (!empty($tot_groups['right_code'])) {
			$name .= $tot_groups['right_code'];
		}
	}
	return $name;
}
function total_group_amt_new_rightcode_triplezero($id, $sdate = '', $tdate = '', $fund_id = '')
{
	$db = db_connect();
	$sub_tot = 0;
	$tot_groups = $db->table('groups')->where('parent_id', $id)->get()->getResult();
	if ($tot_groups) {
		foreach ($tot_groups as $tr) {
			$sub_tot += get_group_amt_new_rightcode_triplezero($tr->id, $sdate, $tdate, $fund_id);
		}
	}
	return $sub_tot;
}
function get_group_amt_new_rightcode_triplezero($id, $sdate = '', $tdate = '', $fund_id = '')
{
	$db = db_connect();
	@$group_amt += get_ledgers_amt_new_rightcode_triplezero($id, $sdate, $tdate, $fund_id);
	$groups = $db->table('groups')->where('parent_id', $id)->get()->getResult();
	if ($groups) {
		foreach ($groups as $r) {
			$group_amt += get_ledgers_amt_new_rightcode_triplezero($r->id, $sdate, $tdate, $fund_id);
			get_group_amt_new_rightcode_triplezero($r->id, $sdate, $tdate, $fund_id);
		}
	}
	return $group_amt;
}
function total_group_amt_new_rightcode_triplezero_previousyear($id, $sdate = '', $tdate = '', $fund_id = '')
{
	$db = db_connect();
	$sub_tot = 0;
	$tot_groups = $db->table('groups')->where('parent_id', $id)->get()->getResult();
	if ($tot_groups) {
		foreach ($tot_groups as $tr) {
			$sub_tot += get_group_amt_new_rightcode_triplezero_previousyear($tr->id, $sdate, $tdate, $fund_id);
		}
	}
	return $sub_tot;
}
function get_group_amt_new_rightcode_triplezero_previousyear($id, $sdate = '', $tdate = '', $fund_id = '')
{
	$db = db_connect();
	@$group_amt += get_ledgers_amt_new_rightcode_triplezero_previousyear($id, $sdate, $tdate, $fund_id);
	$groups = $db->table('groups')->where('parent_id', $id)->get()->getResult();
	if ($groups) {
		foreach ($groups as $r) {
			$group_amt += get_ledgers_amt_new_rightcode_triplezero_previousyear($r->id, $sdate, $tdate, $fund_id);
			get_group_amt_new_rightcode_triplezero_previousyear($r->id, $sdate, $tdate, $fund_id);
		}
	}
	return $group_amt;
}
function get_ledgers_amt_new_rightcode_triplezero_previousyear($id, $sdate = '', $tdate = '', $fund_id = '')
{
	$db = db_connect();
	$op_balance = 0;
	$ac_id = $db->table("ac_year")->where('status', 1)->get()->getRowArray();
	$op_list = $db->table('ledgers')->where('group_id', $id)->where('right_code', '000')->get()->getResult();
	if ($op_list) {
		foreach ($op_list as $op) {
			$op_balance_new = $db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id', $op->id)->where('ac_year_id', $ac_id['id'])->get()->getRowArray();
			if ($op_balance_new['dr_amount'] == "0.00" || $op_balance_new['dr_amount'] == "") {
				$op_balance_amt = $op_balance_new['cr_amount'];
			} else {
				$op_balance_amt = $op_balance_new['dr_amount'];
			}
			$op_balance += $op_balance_amt;
		}
	}
	return $op_balance;
}
function get_ledger_amt_new_rightcode_triplezero($id, $sdate = '', $tdate = '', $fund_id = '')
{
	$db = db_connect();
	$op_balance = 0;
	// $op = $db->table('ledgers')->where('id', $id)->get()->getRow();
	// $ac_id = $db->table("ac_year")->where('status', 1)->get()->getRowArray();
	// $op_balance_new = $db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id', $id)->where('ac_year_id', $ac_id['id'])->get()->getRowArray();
	// if ($op_balance_new['dr_amount'] == "0.00" || $op_balance_new['dr_amount'] == "") {
	// $op_balance_amt = $op_balance_new['cr_amount'];
	// } else {
	// $op_balance_amt = $op_balance_new['dr_amount'];
	// }
	// $op_balance += $op_balance_amt;
	$op_balance -= get_ledger_cr_amt_new_rightcode_triplezero($id, $sdate, $tdate, $fund_id);
	$op_balance += get_ledger_dr_amt_new_rightcode_triplezero($id, $sdate, $tdate, $fund_id);
	$op_balance += get_ledger_op_amt_new_rightcode_triplezero($id, $sdate, $tdate, $fund_id);
	/* echo $op->name;
	   echo '<br>';
	   echo get_ledger_op_amt_new_rightcode_triplezero($id, $sdate, $tdate, $fund_id);
	   echo '<br>';
	   echo get_ledger_cr_amt_new_rightcode_triplezero($id, $sdate, $tdate, $fund_id);
	   echo '<br>';
	   echo get_ledger_dr_amt_new_rightcode_triplezero($id, $sdate, $tdate, $fund_id);
	   echo '<br>'; */
	return $op_balance;
}
function get_ledger_amt_new_rightcode_triplezero_previousyear($id, $sdate = '', $tdate = '', $fund_id = '')
{
	$db = db_connect();
	$op_balance = 0;
	$ac_id = $db->table("ac_year")->where('status', 1)->get()->getRowArray();
	$op_balance_new = $db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id', $id)->where('ac_year_id', $ac_id['id'])->get()->getRowArray();
	if ($op_balance_new['dr_amount'] == "0.00" || $op_balance_new['dr_amount'] == "") {
		$op_balance_amt -= $op_balance_new['cr_amount'];
	} else {
		$op_balance_amt = $op_balance_new['dr_amount'];
	}
	$op_balance += $op_balance_amt;
	return $op_balance;
}
function get_ledgers_amt_new_rightcode_triplezero($id, $sdate = '', $tdate = '', $fund_id = '')
{
	$db = db_connect();
	$op_balance = 0;
	$ac_id = $db->table("ac_year")->where('status', 1)->get()->getRowArray();
	$op_list = $db->table('ledgers')->where('group_id', $id)->where('right_code', '000')->get()->getResult();
	if ($op_list) {
		foreach ($op_list as $op) {
			$op_balance_new = $db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id', $op->id)->where('ac_year_id', $ac_id['id'])->get()->getRowArray();
			if ($op_balance_new['dr_amount'] == "0.00" || $op_balance_new['dr_amount'] == "") {
				$op_balance_amt = $op_balance_new['cr_amount'];
			} else {
				$op_balance_amt = $op_balance_new['dr_amount'];
			}
			//$op_balance += $op_balance_amt;
			$op_balance -= get_ledger_cr_amt_new_rightcode_triplezero($op->id, $sdate, $tdate, $fund_id);
			$op_balance += get_ledger_dr_amt_new_rightcode_triplezero($op->id, $sdate, $tdate, $fund_id);
			$op_balance += get_ledger_op_amt_new_rightcode_triplezero($op->id, $sdate, $tdate, $fund_id);
			/* echo $op->name;
					 echo '<br>';
					 echo get_ledger_op_amt_new_rightcode_triplezero($op->id, $sdate, $tdate, $fund_id);
					 echo '<br>';
					 echo get_ledger_cr_amt_new_rightcode_triplezero($op->id, $sdate, $tdate, $fund_id);
					 echo '<br>';
					 echo get_ledger_dr_amt_new_rightcode_triplezero($op->id, $sdate, $tdate, $fund_id);
					 echo '<br>'; */
		}
	}
	return $op_balance;
}
// this function not required but subtotal without zero check plus and minus included
function get_ledger_amt_new_rightcode_triplezero_subtotal($id, $sdate = '', $tdate = '', $fund_id = '')
{
	$db = db_connect();
	$op_balance = 0;
	$ac_id = $db->table("ac_year")->where('status', 1)->get()->getRowArray();
	$op_balance_new = $db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id', $id)->where('ac_year_id', $ac_id['id'])->get()->getRowArray();
	if ($op_balance_new['dr_amount'] == "0.00" || $op_balance_new['dr_amount'] == "") {
		$op_balance_amt = $op_balance_new['cr_amount'];
	} else {
		$op_balance_amt = $op_balance_new['dr_amount'];
	}
	$op_balance += $op_balance_amt;
	$op_balance += get_ledger_cr_amt_new_rightcode_triplezero($id, $sdate, $tdate, $fund_id);
	$op_balance += get_ledger_dr_amt_new_rightcode_triplezero($id, $sdate, $tdate, $fund_id);
	return $op_balance;
}
function get_group_amt_new_rightcode_triplezero_subtotal($id, $sdate = '', $tdate = '', $fund_id = '')
{
	$db = db_connect();
	@$group_amt += get_ledgers_amt_new_rightcode_triplezero_subtotal($id, $sdate, $tdate, $fund_id);
	$groups = $db->table('groups')->where('parent_id', $id)->get()->getResult();
	if ($groups) {
		foreach ($groups as $r) {
			$group_amt += get_ledgers_amt_new_rightcode_triplezero_subtotal($r->id, $sdate, $tdate, $fund_id);
			get_group_amt_new_rightcode_triplezero_subtotal($r->id, $sdate, $tdate, $fund_id);
		}
	}
	return $group_amt;
}
function get_ledgers_amt_new_rightcode_triplezero_subtotal($id, $sdate = '', $tdate = '', $fund_id = '')
{ // this function not required but subtotal without zero check plus and minus included
	$db = db_connect();
	$op_balance = 0;
	$ac_id = $db->table("ac_year")->where('status', 1)->get()->getRowArray();
	$op_list = $db->table('ledgers')->where('group_id', $id)->where('right_code', '000')->get()->getResult();
	if ($op_list) {
		foreach ($op_list as $op) {
			$op_balance_new = $db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id', $op->id)->where('ac_year_id', $ac_id['id'])->get()->getRowArray();
			if ($op_balance_new['dr_amount'] == "0.00" || $op_balance_new['dr_amount'] == "") {
				$op_balance_amt = $op_balance_new['cr_amount'];
			} else {
				$op_balance_amt = $op_balance_new['dr_amount'];
			}
			$op_balance += $op_balance_amt;
			$op_balance += get_ledger_cr_amt_new_rightcode_triplezero($op->id, $sdate, $tdate, $fund_id);
			$op_balance += get_ledger_dr_amt_new_rightcode_triplezero($op->id, $sdate, $tdate, $fund_id);
		}
	}
	return $op_balance;
}
function get_ledger_op_amt_new_rightcode_triplezero($id, $sdate = '', $tdate = '', $fund_id = '')
{
	$db = db_connect();
	$led_ids = get_ledger_ids_leftcode($id);
	$ac_id = $db->table("ac_year")->where('status', 1)->get()->getRowArray();
	$fund_where = '';
	if (!empty($fund_id))
		$fund_where = " and entries.fund_id = '$fund_id'";
	$op_balance_amt = 0;
	if (!empty($led_ids)) {
		$led_ids_arr = explode(',', $led_ids);
		foreach ($led_ids_arr as $ld) {
			$op_balance_new = $db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id', $ld)->where('ac_year_id', $ac_id['id'])->get()->getRowArray();
			if ($op_balance_new['dr_amount'] == "0.00" || $op_balance_new['dr_amount'] == "") {
				$op_balance_amt -= $op_balance_new['cr_amount'];
			} else {
				$op_balance_amt += $op_balance_new['dr_amount'];
			}
		}
	}
	return $op_balance_amt;
}
function get_ledger_cr_amt_new_rightcode_triplezero($id, $sdate = '', $tdate = '', $fund_id = '')
{
	$db = db_connect();
	$led_ids = get_ledger_ids_leftcode($id);
	$fund_where = '';
	if (!empty($fund_id))
		$fund_where = " and entries.fund_id = '$fund_id'";
	if (!empty($led_ids)) {
		$c_sql = "select sum(entryitems.amount) as amount 
				from entryitems 
				inner join entries on entries.id = entryitems. entry_id
				where entryitems.dc = 'C' and entryitems.ledger_id IN($led_ids) and entries.date >= '$sdate' and entries.date <= '$tdate'$fund_where";
		$res = $db->query($c_sql)->getRowArray();
	} else {
		$res = 0;
	}
	if (!empty($res['amount'])) {
		$cr_amount = $res['amount'];
	} else {
		$cr_amount = 0;
	}
	return $cr_amount;
}
function get_ledger_dr_amt_new_rightcode_triplezero($id, $sdate = '', $tdate = '', $fund_id = '')
{
	$db = db_connect();
	$led_ids = get_ledger_ids_leftcode($id);
	$fund_where = '';
	if (!empty($fund_id))
		$fund_where = " and entries.fund_id = '$fund_id'";
	if (!empty($led_ids)) {
		$d_sql = "select sum(entryitems.amount) as amount 
					from entryitems 
					inner join entries on entries.id = entryitems. entry_id
					where entryitems.dc = 'D' and entryitems.ledger_id IN($led_ids) and entries.date >= '$sdate' and entries.date <= '$tdate'$fund_where";
		$res = $db->query($d_sql)->getRowArray();
	} else {
		$res = 0;
	}
	if (!empty($res['amount'])) {
		$dr_amount = $res['amount'];
	} else {
		$dr_amount = 0;
	}
	return $dr_amount;
}
function get_ledger_amt_new_rightcode_triplezero_single($id, $sdate = '', $tdate = '', $fund_id = '')
{
	$db = db_connect();
	$op_balance = 0;
	$ac_id = $db->table("ac_year")->where('status', 1)->get()->getRowArray();
	$op_balance_new = $db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id', $id)->where('ac_year_id', $ac_id['id'])->get()->getRowArray();
	if ($op_balance_new['dr_amount'] == "0.00" || $op_balance_new['dr_amount'] == "") {
		$op_balance_amt -= $op_balance_new['cr_amount'];
	} else {
		$op_balance_amt += $op_balance_new['dr_amount'];
	}
	$op_balance += $op_balance_amt;
	$op_balance -= get_ledger_cr_amt_new_rightcode_triplezero_single($id, $sdate, $tdate, $fund_id);
	$op_balance += get_ledger_dr_amt_new_rightcode_triplezero_single($id, $sdate, $tdate, $fund_id);
	return $op_balance;
}
function get_ledger_cr_amt_new_rightcode_triplezero_single($id, $sdate = '', $tdate = '', $fund_id = '')
{
	$db = db_connect();
	$fund_where = '';
	if (!empty($fund_id))
		$fund_where = " and entries.fund_id = '$fund_id'";
	if (!empty($id)) {
		$c_sql = "select sum(entryitems.amount) as amount 
				from entryitems 
				inner join entries on entries.id = entryitems. entry_id
				where entryitems.dc = 'C' and entryitems.ledger_id = '$id' and entries.date >= '$sdate' and entries.date <= '$tdate'$fund_where";
		$res = $db->query($c_sql)->getRowArray();
	} else {
		$res = 0;
	}
	if (!empty($res['amount'])) {
		$cr_amount = $res['amount'];
	} else {
		$cr_amount = 0;
	}
	return $cr_amount;
}
function get_ledger_dr_amt_new_rightcode_triplezero_single($id, $sdate = '', $tdate = '', $fund_id = '')
{
	$db = db_connect();
	$fund_where = '';
	if (!empty($fund_id))
		$fund_where = " and entries.fund_id = '$fund_id'";
	if (!empty($id)) {
		$d_sql = "select sum(entryitems.amount) as amount 
					from entryitems 
					inner join entries on entries.id = entryitems. entry_id
					where entryitems.dc = 'D' and entryitems.ledger_id = '$id' and entries.date >= '$sdate' and entries.date <= '$tdate'$fund_where";
		$res = $db->query($d_sql)->getRowArray();
	} else {
		$res = 0;
	}
	if (!empty($res['amount'])) {
		$dr_amount = $res['amount'];
	} else {
		$dr_amount = 0;
	}
	return $dr_amount;
}
function get_ledger_ids_leftcode($id)
{
	$db = db_connect();
	$led_da = $db->table("ledgers")->where('id', $id)->get()->getRowArray();
	$left_code = $led_da['left_code'];
	if (!empty($left_code)) {
		$ledger_ids = $db->query("select id from ledgers where id IN (select id from ledgers where left_code = $left_code)")->getResultArray();
	} else {
		$ledger_ids = array();
	}
	$array_ledgerids = array();
	if (count($ledger_ids) > 0) {
		foreach ($ledger_ids as $ledger_id) {
			$array_ledgerids[] = $ledger_id['id'];
		}
	}
	$ledger_ids_implode = implode(',', $array_ledgerids);
	return $ledger_ids_implode;
}

function get_profit_loss_subtotal($sub_val = array())
{
	$subtotal_income = 0;
	foreach ($sub_val as $sval) {
		foreach ($sval as $amt) {
			$subtotal_income += $amt;
		}
	}
	return $subtotal_income;
}
function get_consolidate_profit_loss_subtotal($sub_val = array())
{
	$subtotal_income = 0;
	foreach ($sub_val as $sval) {
		foreach ($sval as $amt) {
			$subtotal_income += array_sum($amt);
		}
	}
	return $subtotal_income;
}
function get_ledger_amt_new_rightcode_triplezero_subtotal_multiplejobcode($id, $sdate = '', $tdate = '', $fund_id = '')
{ // this function not required but subtotal without zero check plus and minus included
	$db = db_connect();
	$op_balance = 0;
	$ac_id = $db->table("ac_year")->where('status', 1)->get()->getRowArray();
	$op_balance_new = $db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id', $id)->where('ac_year_id', $ac_id['id'])->get()->getRowArray();
	if ($op_balance_new['dr_amount'] == "0.00" || $op_balance_new['dr_amount'] == "") {
		$op_balance_amt = $op_balance_new['cr_amount'];
	} else {
		$op_balance_amt = $op_balance_new['dr_amount'];
	}
	$op_balance += $op_balance_amt;
	$op_balance += get_ledger_cr_amt_new_rightcode_triplezero($id, $sdate, $tdate, $fund_id);
	$op_balance += get_ledger_cr_amt_new_rightcode_triplezero($id, $sdate, $tdate, $fund_id);
	return $op_balance;
}
function get_group_amt_new_rightcode_triplezero_subtotal_multiplejobcode($id, $sdate = '', $tdate = '', $fund_id = '')
{
	$db = db_connect();
	@$group_amt += get_ledgers_amt_new_rightcode_triplezero_subtotal_multiplejobcode($id, $sdate, $tdate, $fund_id);
	$groups = $db->table('groups')->where('parent_id', $id)->get()->getResult();
	if ($groups) {
		foreach ($groups as $r) {
			$group_amt += get_ledgers_amt_new_rightcode_triplezero_subtotal_multiplejobcode($r->id, $sdate, $tdate, $fund_id);
			get_group_amt_new_rightcode_triplezero_subtotal_multiplejobcode($r->id, $sdate, $tdate, $fund_id);
		}
	}
	return $group_amt;
}
// this function not required but subtotal without zero check plus and minus included
function get_ledgers_amt_new_rightcode_triplezero_subtotal_multiplejobcode($id, $sdate = '', $tdate = '', $fund_id = '')
{
	$db = db_connect();
	$op_balance = 0;
	$ac_id = $db->table("ac_year")->where('status', 1)->get()->getRowArray();
	$op_list = $db->table('ledgers')->where('group_id', $id)->where('right_code', '000')->get()->getResult();
	if ($op_list) {
		foreach ($op_list as $op) {
			$op_balance_new = $db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id', $op->id)->where('ac_year_id', $ac_id['id'])->get()->getRowArray();
			if ($op_balance_new['dr_amount'] == "0.00" || $op_balance_new['dr_amount'] == "") {
				$op_balance_amt = $op_balance_new['cr_amount'];
			} else {
				$op_balance_amt = $op_balance_new['dr_amount'];
			}
			$op_balance += $op_balance_amt;
			$op_balance += get_ledgers_amt_new_rightcode_triplezero($op->id, $sdate, $tdate, $fund_id);
			$op_balance += get_ledgers_amt_new_rightcode_triplezero($op->id, $sdate, $tdate, $fund_id);
		}
	}
	return $op_balance;
}
function archanai_charts()
{
	$jan = archanai_monthwise_count($month = "01");
	$feb = archanai_monthwise_count($month = "02");
	$mar = archanai_monthwise_count($month = "03");
	$apr = archanai_monthwise_count($month = "04");
	$may = archanai_monthwise_count($month = "05");
	$jun = archanai_monthwise_count($month = "06");
	$jul = archanai_monthwise_count($month = "07");
	$aug = archanai_monthwise_count($month = "08");
	$sep = archanai_monthwise_count($month = "09");
	$oct = archanai_monthwise_count($month = "10");
	$nov = archanai_monthwise_count($month = "11");
	$dec = archanai_monthwise_count($month = "12");
	$rtn_arry = array($jan, $feb, $mar, $apr, $may, $jun, $jul, $aug, $sep, $oct, $nov, $dec);
	return json_encode($rtn_arry);
}
function archanai_monthwise_count($month)
{
	$db = db_connect();
	$current_year = date('Y');
	$archanai_charts = $db->query("SELECT COUNT(id) AS count FROM archanai_booking where YEAR(date) = $current_year AND MONTH(date) = $month ")->getResultArray();
	if (count($archanai_charts) > 0) {
		$countdata = intVal($archanai_charts[0]['count']);
	} else {
		$countdata = 0;
	}
	return $countdata;
}
// function hallbooking_charts()
// {
// 	$jan = hallbooking_monthwise_count($month = "01");
// 	$feb = hallbooking_monthwise_count($month = "02");
// 	$mar = hallbooking_monthwise_count($month = "03");
// 	$apr = hallbooking_monthwise_count($month = "04");
// 	$may = hallbooking_monthwise_count($month = "05");
// 	$jun = hallbooking_monthwise_count($month = "06");
// 	$jul = hallbooking_monthwise_count($month = "07");
// 	$aug = hallbooking_monthwise_count($month = "08");
// 	$sep = hallbooking_monthwise_count($month = "09");
// 	$oct = hallbooking_monthwise_count($month = "10");
// 	$nov = hallbooking_monthwise_count($month = "11");
// 	$dec = hallbooking_monthwise_count($month = "12");
// 	$rtn_arry = array($jan, $feb, $mar, $apr, $may, $jun, $jul, $aug, $sep, $oct, $nov, $dec);
// 	return json_encode($rtn_arry);
// }


// function archanai_booking_range($from_date = '', $to_date = '', $booking_type = '', $login_id = '')
// {
// 	$db = db_connect();
// 	$archanai_data = array();
// 	$data_direct = array();
// 	$data_counter = array();
// 	$data_online = array();
// 	$where = '';
// 	if (!empty($from_date))
// 		$where .= " and b.date >= '$from_date'";
// 	if (!empty($to_date))
// 		$where .= " and b.date <= '$to_date'";
// 	if (!empty($booking_type))
// 		$where .= " and b.paid_through = '$booking_type'";
// 	if (!empty($login_id))
// 		$where .= " and b.entry_by = '$login_id'";
// 	$query = $db->query("select l.name as counter_name, b.date, a.archanai_id, a.archanai_booking_id, 
// 	sum(a.quantity) as qty, sum(a.total_amount) as amt, sum(a.total_commision) as comm, 
// 	count(a.archanai_id) as cnt, b.paid_through, (case when b.paid_through = 'DIRECT' then b.payment_mode 
// 	else c.pay_method end) as payment_mode from archanai_booking_details a left join archanai_booking b on b.id = a.archanai_booking_id 
// 	left join archanai_payment_gateway_datas c on c.archanai_booking_id = b.id left join login l on b.entry_by = l.id 
// 	where (b.payment_status not in(1,3) or b.payment_status is NULL)
// 	$where group by payment_mode, b.paid_through, a.archanai_id having count(a.archanai_id) > 0");
// 	$res2 = $query->getResultArray();
// 	if (count($res2)) {
// 		foreach ($res2 as $row) {
// 			$paymentname = '';
// 			$total = $row['amt'] + $row['comm'];
// 			$aname = $db->table('archanai')->where('id', $row['archanai_id'])->get()->getRowArray();
// 			if ($row['paid_through'] == 'DIRECT') {
// 				$payment_mode = $db->table('payment_mode')->where('id', $row['payment_mode'])->get()->getRowArray();
// 				$paymentname = $payment_mode['name'];
// 			} else {
// 				if ($row['payment_mode'] == "ipay_merch_qr") {
// 					$paymentname = "QR PAYMENT";
// 				} elseif ($row['payment_mode'] == "ipay_merch_online") {
// 					$paymentname = "ONLINE PAYMENT";
// 				} elseif ($row['payment_mode'] == "cash") {
// 					$paymentname = "CASH";
// 				}

// 			}

// 			$archanai_data[] = array(
// 				"name_in_english" => $aname['name_eng'],
// 				"name_in_tamil" => $aname['name_tamil'],
// 				"paymentmode" => $paymentname,
// 				"counter_name" => $row['counter_name'],
// 				"paid_through" => $row['paid_through'],
// 				"date" => $row['date'],
// 				"qty" => $row['qty'],
// 				"amount" => $total
// 			);
// 		}
// 	}
// 	return $archanai_data;
// }


function archanai_booking_range($from_date = '', $to_date = '', $booking_type = '', $login_id = '')
{
	$db = db_connect();
	$archanai_data = array();
	$data_direct = array();
	$data_counter = array();
	$data_online = array();
	$where = '';
	if (!empty($from_date))
		$where .= " and b.date >= '$from_date'";
	if (!empty($to_date))
		$where .= " and b.date <= '$to_date'";
	if (!empty($booking_type))
		$where .= " and b.paid_through = '$booking_type'";
	if (!empty($login_id))
		$where .= " and b.entry_by = '$login_id'";
	$query = $db->query("select l.name as counter_name, b.date, a.archanai_id, a.archanai_booking_id, 
	sum(a.quantity) as qty, sum(a.total_amount) as amt, sum(a.total_commision) as comm, 
	count(a.archanai_id) as cnt, b.paid_through, (case when b.paid_through = 'DIRECT' then b.payment_mode 
	else c.pay_method end) as payment_mode from archanai_booking_details a left join archanai_booking b on b.id = a.archanai_booking_id 
	left join archanai_payment_gateway_datas c on c.archanai_booking_id = b.id left join login l on b.entry_by = l.id 
	where (b.payment_status not in(1,3) or b.payment_status is NULL)
	$where group by payment_mode, b.paid_through, a.archanai_id having count(a.archanai_id) > 0");
	$res2 = $query->getResultArray();
	if (count($res2)) {
		foreach ($res2 as $row) {
			$paymentname = '';
			$total = $row['amt'] + $row['comm'];
			$aname = $db->table('archanai')->where('id', $row['archanai_id'])->get()->getRowArray();
			if ($row['paid_through'] == 'DIRECT') {
				if (!empty($row['payment_mode'])) {
					$payment_mode = $db->table('payment_mode')->where('id', $row['payment_mode'])->get()->getRowArray();
					$paymentname = !empty($payment_mode) ? $payment_mode['name'] : 'N/A';
				} else {
					$paymentname = 'N/A';
				}
			} else {
				if ($row['payment_mode'] == "ipay_merch_qr") {
					$paymentname = "QR PAYMENT";
				} elseif ($row['payment_mode'] == "ipay_merch_online") {
					$paymentname = "ONLINE PAYMENT";
				} elseif ($row['payment_mode'] == "cash") {
					$paymentname = "CASH";
				} else {
					if (!empty($row['payment_mode']) && is_numeric($row['payment_mode'])) {
						$payment_mode = $db->table('payment_mode')->where('id', $row['payment_mode'])->get()->getRowArray();
						$paymentname = !empty($payment_mode) ? $payment_mode['name'] : strtoupper($row['payment_mode']);
					} else {
						$paymentname = !empty($row['payment_mode']) ? strtoupper($row['payment_mode']) : 'N/A';
					}
				}
			}

			$archanai_data[] = array(
				"name_in_english" => $aname['name_eng'],
				"name_in_tamil" => $aname['name_tamil'],
				"paymentmode" => $paymentname,
				"counter_name" => $row['counter_name'],
				"paid_through" => $row['paid_through'],
				"date" => $row['date'],
				"qty" => $row['qty'],
				"amount" => $total
			);
		}
	}
	return $archanai_data;
}



// function hallbooking_monthwise_count($month)
// {
// 	$db = db_connect();
// 	$current_year = date('Y');
// 	$hallbooking_charts = $db->query("SELECT COUNT(id) AS count FROM hall_booking where YEAR(booking_date) = $current_year AND MONTH(booking_date) = $month ")->getResultArray();
// 	if (count($hallbooking_charts) > 0) {
// 		$countdata = intVal($hallbooking_charts[0]['count']);
// 	} else {
// 		$countdata = 0;
// 	}
// 	return $countdata;
// }
function send_mail_with_content($to_mail, $message = array(), $subject, $temple_title = "")
{
	$email = \Config\Services::email();
	$to_mails = $to_mail;
	$mail_count = count($to_mails);
	for ($i = 0; $i < $mail_count; $i++) {
		$mail_id = TRIM($to_mails[$i]);
		//echo $mail_id;
		$email->setTo($mail_id);
		$email->setFrom('templetest@grasp.com.my', $temple_title);
		$email->setSubject($subject);
		$email->setMessage($message);
		$email->send();
	}
}
function qrcode_generation($qr_id, $url, $height = 190, $width = 190)
{
	if (!empty($qr_id)) {
		$qr_url = "https://chart.googleapis.com/chart?cht=qr&chl=" . $url . "?id=" . $qr_id . "&chs=" . $width . "x" . $height . "&chld=L|0";
		return $qr_url;
	}

}
function get_checklist_availablity($date, $id)
{
	$db = db_connect();
	$res = $db->table("hall_booking")->select("id, name")->where("booking_date", $date)->where("status<>", 3)->get()->getResultArray();
	$data_time = array();
	$i = 0;  //echo '<pre>';
	foreach ($res as $r) {
		$ds = $db->table("hall_booking_service_details")->select("checklist_id")->where("hall_booking_id", $r['id'])->get()->getResultArray();
		foreach ($ds as $rr) {
			if (!empty($rr)) {
				$data_time[] = $rr['checklist_id'];
			}
		}
	}
	$tot_checklists = $db->table('checklist')
		->join('booking_addonn_service', 'booking_addonn_service.service_id = checklist.service_id')
		->select('checklist.*')
		->where('booking_addonn_service.id', $id)
		->get()
		->getResultArray();
	$data = array("checklists" => $tot_checklists, "availabilty" => $data_time);
	return $data;
}

function archanai_booking_count($fromDate, $toDate) {
    $db = db_connect(); // Ensure you have a connection method like this

    // SQL query to count entries, separated by paid_through, where payment_status is 2
    $sql = "SELECT paid_through, COUNT(*) as count 
            FROM archanai_booking 
            WHERE payment_status = 2 
              AND paid_through IN ('ONLINE', 'COUNTER') 
              AND DATE(created) BETWEEN ? AND ? 
            GROUP BY paid_through";

    // Prepare and execute the SQL statement
    $query = $db->query($sql, [$fromDate, $toDate]);
    $result = $query->getResultArray();

    // Prepare the data for the chart
    $data = [
        'ONLINE' => 0,
        'COUNTER' => 0
    ];

    // Populate data array with results
    foreach ($result as $row) {
        if ($row['paid_through'] === 'ONLINE') {
            $data['ONLINE'] = (int)$row['count'];
        } else if ($row['paid_through'] === 'COUNTER') {
            $data['COUNTER'] = (int)$row['count'];
        }
    }
    return $data;
}
function prasadam_booking_count($fromDate, $toDate) {
    $db = db_connect(); // Ensure you have a connection method like this

    // SQL query to count entries, separated by paid_through, where payment_status is 2
    $sql = "SELECT paid_through, COUNT(*) as count 
            FROM prasadam 
            WHERE payment_status = 2 
              AND paid_through IN ('ONLINE', 'COUNTER') 
              AND DATE(created) BETWEEN ? AND ? 
            GROUP BY paid_through";

    // Prepare and execute the SQL statement
    $query = $db->query($sql, [$fromDate, $toDate]);
    $result = $query->getResultArray();

    // Prepare the data for the chart
    $data = [
        'ONLINE' => 0,
        'COUNTER' => 0
    ];

    // Populate data array with results
    foreach ($result as $row) {
        if ($row['paid_through'] === 'ONLINE') {
            $data['ONLINE'] = (int)$row['count'];
        } else if ($row['paid_through'] === 'COUNTER') {
            $data['COUNTER'] = (int)$row['count'];
        }
    }
    return $data;
}

function daily_archanai_booking_withcurrentdate_safety($current_date, $current_date_two, $booking_type = '', $login_id = '', $passed_group_id = '')
{
    $db = db_connect();
    $grouped_data = array();
    $where = '';
    if (!empty($booking_type))
        $where .= " and b.paid_through = '$booking_type'";
    if (!empty($login_id))
        $where .= " and b.entry_by = '$login_id'";
    
    // Start building the SQL query
    $sql = "select a.archanai_id, a.archanai_booking_id, sum(a.quantity) as qunty, sum(a.total_amount) as amt, sum(a.total_commision) as comm, b.paid_through, (case when b.paid_through = 'DIRECT' then b.payment_mode else c.pay_method end) as payment_mode, a2.group_id, ag.name as group_name from archanai_booking_details a left join archanai_booking b on b.id = a.archanai_booking_id left join archanai_payment_gateway_datas c on c.archanai_booking_id = b.id left join archanai a2 on a2.id = a.archanai_id left join archanai_group ag on ag.id = a2.group_id where b.date >= '$current_date' and b.date <= '$current_date_two' $where and (b.payment_status not in(1,3) or b.payment_status is NULL)";

    // If a specific group_id is provided, add it to the where clause
    if (!empty($passed_group_id)) {
        $sql .= " and a2.group_id = '$passed_group_id'";
    }

    // Complete the SQL query with grouping and having conditions
    $sql .= " group by a2.group_id having count(a.archanai_id) > 0";

    $query = $db->query($sql);
    $res2 = $query->getResultArray();
    if (count($res2)) {
        foreach ($res2 as $row) {
            $group_id = $row['group_id'];
            if (!isset($grouped_data[$group_id])) {
                $grouped_data[$group_id] = array(
                    "group_name" => $row['group_name'],
                    "paymentmodes" => [],
                    "qty" => 0,
                    "amount" => 0
                );
            }

            // Aggregate data
            $grouped_data[$group_id]['qty'] += $row['qunty'];
            $grouped_data[$group_id]['amount'] += ($row['amt'] + $row['comm']);
            $grouped_data[$group_id]['paymentmodes'][] = $row['payment_mode'];
        }

        // Remove duplicates for payment modes
        foreach ($grouped_data as $id => $data) {
            $grouped_data[$id]['paymentmodes'] = array_unique($data['paymentmodes']);
        }
    }
    return array_values($grouped_data);
}

function daily_archanai_booking_withcurrentdate($current_date, $current_date_two, $booking_type = '', $login_id = '', $group_id = '')
{
    $db = db_connect();
    $archanai_data = array();
    $where = '';
    if (!empty($booking_type))
        $where .= " and b.paid_through = '$booking_type'";
    if (!empty($login_id))
        $where .= " and b.entry_by = '$login_id'";

    // Adding joins to fetch group_id and group_name
    $query = $db->query("select a.archanai_id, a.archanai_booking_id, sum(a.quantity) as qunty, sum(a.total_amount) as amt, sum(a.total_commision) as comm, b.paid_through, (case when b.paid_through = 'DIRECT' then b.payment_mode else c.pay_method end) as payment_mode, a2.group_id, ag.name as group_name from archanai_booking_details a left join archanai_booking b on b.id = a.archanai_booking_id left join archanai_payment_gateway_datas c on c.archanai_booking_id = b.id left join archanai a2 on a2.id = a.archanai_id left join archanai_group ag on ag.id = a2.group_id where b.date >= '$current_date' and b.date <= '$current_date_two' $where and (b.payment_status not in(1,3) or b.payment_status is NULL) group by a.archanai_id, b.payment_mode, c.pay_method, b.paid_through, a2.group_id, ag.name");

    $res2 = $query->getResultArray();
    $group_items = [];

    if (count($res2)) {
        foreach ($res2 as $row) {
            $paymentname = $row['payment_mode']; // Simplified payment name handling
            $total = $row['amt'] + $row['comm'];
            $aname = $db->table('archanai')->where('id', $row['archanai_id'])->get()->getRowArray();

            // Check if current row's group_id matches the passed group_id
            if (!empty($group_id) && $row['group_id'] == $group_id) {
                if (!isset($group_items[$group_id])) {
                    $group_items[$group_id] = [
                        "name_in_english" => $row['group_name'],
                        "name_in_tamil" => $row['group_name'], // Using group name for Tamil as well
                        "paymentmode" => [],
                        "paid_through" => [],
                        "qty" => 0,
                        "amount" => 0
                    ];
                }
                // Aggregate the quantities and amounts for the specific group_id
                $group_items[$group_id]['qty'] += $row['qunty'];
                $group_items[$group_id]['amount'] += $total;
                $group_items[$group_id]['paymentmode'][] = $paymentname;
                $group_items[$group_id]['paid_through'][] = $row['paid_through'];
            } else {
                // Handle all other items normally
                $archanai_data[] = array(
                    "name_in_english" => $aname['name_eng'],
                    "name_in_tamil" => $aname['name_tamil'],
					"group_name" => $aname['groupname'],
                    "paymentmode" => $paymentname,
                    "paid_through" => $row['paid_through'],
                    "qty" => $row['qunty'],
                    "amount" => $total
                );
            }
        }

        // Add grouped items data if any
        if (!empty($group_items)) {
            foreach ($group_items as $item) {
                $item['paymentmode'] = array_unique($item['paymentmode']);
                $item['paid_through'] = array_unique($item['paid_through']);
                $archanai_data[] = $item;
            }
        }
    }
    return $archanai_data;
}


function daily_archanai_booking_withcurrentdate_old($current_date, $current_date_two, $booking_type = '', $login_id = '')
{
	$db = db_connect();
	$archanai_data = array();
	$data_direct = array();
	$data_counter = array();
	$data_online = array();
	$where = '';
	if (!empty($booking_type))
		$where .= " and b.paid_through = '$booking_type'";
	if (!empty($login_id))
		$where .= " and b.entry_by = '$login_id'";
	$query = $db->query("select a.archanai_id, a.archanai_booking_id, sum(a.quantity) as qunty, sum(a.total_amount) as amt, sum(a.total_commision) as comm, count(a.archanai_id) as cnt, b.paid_through, (case when b.paid_through = 'DIRECT' then b.payment_mode else c.pay_method end) as payment_mode from archanai_booking_details a left join archanai_booking b on b.id = a.archanai_booking_id left join archanai_payment_gateway_datas c on c.archanai_booking_id = b.id where b.date >= '$current_date' and b.date <= '$current_date_two' $where and (b.payment_status not in(1,3) or b.payment_status is NULL) group by b.payment_mode, c.pay_method, b.paid_through, a.archanai_id having count(a.archanai_id) > 0");
	$res2 = $query->getResultArray();
	if (count($res2)) {
		foreach ($res2 as $row) {
			$paymentname = '';
			$total = $row['amt'] + $row['comm'];
			$aname = $db->table('archanai')->where('id', $row['archanai_id'])->get()->getRowArray();
			if ($row['paid_through'] == 'DIRECT') {
				$payment_mode = $db->table('payment_mode')->where('id', $row['payment_mode'])->get()->getRowArray();
				$paymentname = $payment_mode['name'];
			} else {
				// if ($row['payment_mode'] == "ipay_merch_qr") {
					// $paymentname = "QR PAYMENT";
				// } elseif ($row['payment_mode'] == "ipay_merch_online") {
					// $paymentname = "ONLINE PAYMENT";
				// } elseif ($row['payment_mode'] == "cash") {
					// $paymentname = "CASH";
				// }
				$paymentname = $row['payment_mode'];

			}

			$archanai_data[] = array(
				"name_in_english" => $aname['name_eng'],
				"name_in_tamil" => $aname['name_tamil'],
				"paymentmode" => $paymentname,
				"paid_through" => $row['paid_through'],
				"qty" => $row['qunty'],
				"amount" => $total
			);
		}
	}
	return $archanai_data;
}
function daily_diety_archanai_booking_withcurrentdate($current_date,$current_date_two,$booking_type = '', $login_id = '')
{
	$db = db_connect();
	$archanai_data = array();
	$data_direct = array();
	$data_counter = array();
	$data_online = array();
	$where = '';
	if (!empty($booking_type))
		$where .= " and b.paid_through = '$booking_type'";
	if (!empty($login_id))
		$where .= " and b.entry_by = '$login_id'";
	$query = $db->query("select a.archanai_id, concat(l.left_code, '-', l.right_code) as code, l.name as ledger_name, a.archanai_booking_id, a.diety_id, ad.name as diety_name, sum(a.quantity) as qunty, sum(a.quantity * a.amount) as amt, max(a.amount) as unit_price,  sum(a.total_commision) as comm, count(a.archanai_id) as cnt, b.paid_through, (case when b.paid_through = 'DIRECT' then b.payment_mode else c.pay_method end) as payment_mode from archanai_booking_details a left join archanai_booking b on b.id = a.archanai_booking_id left join archanai_payment_gateway_datas c on c.archanai_booking_id = b.id left join archanai_diety ad on ad.id = a.diety_id left join archanai e on e.id = a.archanai_id left join ledgers l on l.id = e.ledger_id where b.date >= '$current_date' and b.date <= '$current_date_two' $where and (b.payment_status not in(1,3) or b.payment_status is NULL) group by b.payment_mode, c.pay_method, b.paid_through, a.archanai_id, a.diety_id having count(a.archanai_id) > 0 order by a.diety_id");
	$res2 = $query->getResultArray();
	if (count($res2)) {
		foreach ($res2 as $row) {
			$paymentname = '';
			$total = $row['amt'];
			$aname = $db->table('archanai')->where('id', $row['archanai_id'])->get()->getRowArray();
			if ($row['paid_through'] == 'DIRECT') {
				$payment_mode = $db->table('payment_mode')->where('id', $row['payment_mode'])->get()->getRowArray();
				$paymentname = $payment_mode['name'];
			} else {
				$paymentname = $row['payment_mode'];

			}
			$archanai_data[$row['diety_id']]['title'] = $row['diety_name'];
			$archanai_data[$row['diety_id']]['data'][] = array(
				"archanai_id" => $row['archanai_id'],
				"ledger_code" => $row['code'],
				"ledger_name" => $row['ledger_name'],
				"name_in_english" => $aname['name_eng'],
				"name_in_tamil" => $aname['name_tamil'],
				"group_name" => $aname['groupname'],
				"paymentmode" => $paymentname,
				"paid_through" => $row['paid_through'],
				"qty" => $row['qunty'],
				"unit_price" => $row['unit_price'],
				"amount" => $total
			);
		}
	}
	return $archanai_data;
}

function daily_ubayam_withcurrentdate($current_date, $current_date_two, $booking_type = '', $login_id = '')
{
	$db = db_connect();

	$builder = $db->table("templebooking as tb")
		->join('payment_mode as pm', 'pm.id = tb.payment_mode', 'left')
		->select("tb.id as templebooking_id, 
                  tb.total_amount as amount, 
                  tb.booking_date as date, 
                  tb.name as customer_name, 
                  tb.booking_status, 
                  pm.name as paymentmode, 
                  tb.booking_through,
                  tb.ref_no,
                  tb.payment_type,
                  -- Get only the initial payment amount (is_repayment = 0)
                  COALESCE((SELECT SUM(bpd.amount) 
                   FROM booked_pay_details bpd 
                   WHERE bpd.booking_id = tb.id 
                   AND bpd.is_repayment = 0 
                   AND bpd.pay_status = 2), 0) as paidamount")
		->where('tb.booking_type', 2)
		->where("DATE_FORMAT(tb.entry_date, '%Y-%m-%d') >=", $current_date)
		->where("DATE_FORMAT(tb.entry_date, '%Y-%m-%d') <=", $current_date_two)
		->groupStart()
		->where("tb.payment_status !=", 3)
		->orWhere('tb.payment_status IS NULL')
		->groupEnd();
	//log_message('error', $db->getLastQuery());
	if (!empty($booking_type)) {
		$builder->where("tb.booking_through", $booking_type);
	}
	if (!empty($login_id)) {
		$builder->where("tb.created_by", $login_id);
	}

	$ubayam_data = $builder->get()->getResultArray();
	foreach ($ubayam_data as $key => $ubayam) {
		// Get package details
		$detailBuilder = $db->table('templebooking as tb')
			->join('booked_packages as bp', 'bp.booking_id = tb.id')
			->join('ledgers as l', 'l.id = bp.ledger_id', 'left')
			->select('bp.name as package_name, 
                      l.name as ledger_name, 
                      concat(l.left_code, "-", l.right_code) as ledger_code, 
                      bp.quantity as quantity, 
                      bp.amount as amount')
			->where('tb.id', $ubayam['templebooking_id']);

		$products = $detailBuilder->get()->getResultArray();

		// Adjust the paidamount for each product based on the proportion
		$totalAmount = $ubayam['amount'];
		$paidAmount = $ubayam['paidamount'] ?? 0;

		foreach ($products as &$product) {
			if ($totalAmount > 0) {
				// Calculate proportional paid amount for each product
				$product['paidamount'] = ($product['amount'] / $totalAmount) * $paidAmount;
			} else {
				$product['paidamount'] = 0;
			}
		}

		$ubayam_data[$key]['products'] = $products;
		$ubayam_data[$key]['package_name'] = implode(', ', array_column($products, 'package_name'));
		$ubayam_data[$key]['person_name'] = $ubayam['customer_name'];
	}

	return $ubayam_data;
}
// function daily_ubayam_withcurrentdate($current_date, $current_date_two, $booking_type = '', $login_id = '') {
//     $db = db_connect();
    
//     $builder = $db->table("templebooking as tb")
//         ->join('payment_mode as pm', 'pm.id = tb.payment_mode', 'left')
//         //->join('booked_pay_details as bpd', 'bpd.booking_id = tb.id', 'left')
//         ->select("tb.id as templebooking_id, tb.total_amount as amount, tb.booking_date as date, (SELECT bpd.amount 
// 					FROM booked_pay_details bpd 
// 					WHERE bpd.booking_id = tb.id 
// 					AND bpd.is_repayment = 0 
// 					ORDER BY bpd.id ASC LIMIT 1) as paidamount, tb.name as customer_name, tb.booking_status, pm.name as paymentmode, tb.booking_through")
// 		->where('tb.booking_type', 2)
// 		//->where('tb.booking_status', 1)
//         ->where("DATE_FORMAT(tb.entry_date, '%Y-%m-%d') >=", $current_date)
//         ->where("DATE_FORMAT(tb.entry_date, '%Y-%m-%d') <=", $current_date_two)
//         ->groupStart()
//         ->where("tb.payment_status !=", 3)
//         ->orWhere('tb.payment_status IS NULL')
//         ->groupEnd();
    
//     if (!empty($booking_type)) {
//         $builder->where("tb.booking_through", $booking_type);
//     }
//     if (!empty($login_id)) {
//         $builder->where("tb.created_by", $login_id);
//     }
    
//     $ubayam_data = $builder->get()->getResultArray();

//     foreach ($ubayam_data as $key => $ubayam) {
//         $detailBuilder = $db->table('templebooking as tb')
//             ->join('booked_packages as bp', 'bp.booking_id = tb.id')
//             ->join('ledgers as l', 'l.id = bp.ledger_id', 'left')
//             ->select('bp.name as package_name, l.name as ledger_name, concat(l.left_code, "-", l.right_code) as ledger_code, bp.quantity as quantity, tb.amount as amount, tb.paid_amount as paidamount')
//             ->where('tb.id', $ubayam['templebooking_id']);
        
//         $products = $detailBuilder->get()->getResultArray();
//         $ubayam_data[$key]['products'] = $products;  // Nest the products data under each annathanam
//     }
    
//     return $ubayam_data;
// }

function daily_hall_booking_withcurrentdate($current_date, $current_date_two, $booking_type = '', $login_id = '') {
    $db = db_connect();
    
    $builder = $db->table("templebooking as tb")
        ->join('payment_mode as pm', 'pm.id = tb.payment_mode', 'left')
        //->join('booked_pay_details as bpd', 'bpd.booking_id = tb.id', 'left')
        ->select("tb.*, tb.id as templebooking_id, tb.total_amount as amount, tb.booking_date as date, (SELECT bpd.amount 
					FROM booked_pay_details bpd 
					WHERE bpd.booking_id = tb.id 
					AND bpd.is_repayment = 0 
					ORDER BY bpd.id ASC LIMIT 1) as paidamount, tb.name as customer_name, tb.booking_status, pm.name as paymentmode, tb.booking_through")
		->where('tb.booking_type', 1)
        ->where("DATE_FORMAT(tb.entry_date, '%Y-%m-%d') >=", $current_date)
        ->where("DATE_FORMAT(tb.entry_date, '%Y-%m-%d') <=", $current_date_two)
        ->groupStart()
        ->where("tb.payment_status !=", 3)
        ->orWhere('tb.payment_status IS NULL')
        ->groupEnd();
    
    if (!empty($booking_type)) {
        $builder->where("tb.booking_through", $booking_type);
    }
    // if (!empty($login_id)) {
    //     $builder->where("tb.created_by", $login_id);
    // }
    
    $ubayam_data = $builder->get()->getResultArray();

    foreach ($ubayam_data as $key => $ubayam) {
        $detailBuilder = $db->table('templebooking as tb')
            ->join('booked_packages as bp', 'bp.booking_id = tb.id')
            ->join('ledgers as l', 'l.id = bp.ledger_id', 'left')
            ->select('bp.name as package_name, l.name as ledger_name, concat(l.left_code, "-", l.right_code) as ledger_code, bp.quantity as quantity, tb.amount as amount')
            ->where('tb.id', $ubayam['templebooking_id']);
        
        $products = $detailBuilder->get()->getResultArray();
        $ubayam_data[$key]['products'] = $products;  // Nest the products data under each annathanam
    }
    
    return $ubayam_data;
}

function daily_annathanam_withcurrentdate($current_date, $current_date_two, $booking_type = '', $login_id = '') {
    $db = db_connect();
    
    $builder = $db->table("annathanam_new as an")
        ->join('payment_mode as pm', 'pm.id = an.payment_mode', 'left')
        ->join('annathanam_payment_gateway_datas as apgd', 'apgd.annathanam_booking_id = an.id', 'left')
        ->select("an.id as annathanam_id, an.total_amount as amount, an.slot_time as time, (SELECT abpd.amount 
					FROM annathanam_booked_pay_details abpd 
					WHERE abpd.annathanam_id = an.id 
					AND abpd.is_repayment = 0 
					ORDER BY abpd.id ASC LIMIT 1) as paidamount, an.name as customer_name, an.booking_status, an.payment_type, (case when an.booking_through = 'DIRECT' then pm.name else apgd.pay_method end) as paymentmode, an.booking_through")
        ->where('an.booking_type', 0)
		->where("DATE_FORMAT(an.date, '%Y-%m-%d') >=", $current_date)
        ->where("DATE_FORMAT(an.date, '%Y-%m-%d') <=", $current_date_two)
        ->groupStart()
        ->where("an.payment_status !=", 3)
        ->orWhere('an.payment_status IS NULL')
        ->groupEnd();
    
    if (!empty($booking_type)) {
        $builder->where("an.booking_through", $booking_type);
    }
    // if (!empty($login_id)) {
    //     $builder->where("an.added_by", $login_id);
    // }
    
    $annathanam_data = $builder->get()->getResultArray();

	// print_r($data);
	// exit;

    foreach ($annathanam_data as $key => $annathanam) {
        $detailBuilder = $db->table('annathanam_new as an')
            ->join('annathanam_packages as ap', 'ap.id = an.package_id')
            ->join('ledgers as l', 'l.id = ap.ledger_id', 'left')
            ->select('ap.name_eng as package_name, l.name as ledger_name, concat(l.left_code, "-", l.right_code) as ledger_code, an.no_of_pax as quantity, an.total_amount as amount')
            ->where('an.id', $annathanam['annathanam_id']);
        
        $products = $detailBuilder->get()->getResultArray();
        $annathanam_data[$key]['products'] = $products;  // Nest the products data under each annathanam
    }
    
    return $annathanam_data;
}
function daily_catering_withcurrentdate($current_date, $current_date_two, $booking_type = '', $login_id = '') {
    $db = db_connect();
    
    $builder = $db->table("annathanam_new as an")
        ->join('payment_mode as pm', 'pm.id = an.payment_mode', 'left')
        ->join('annathanam_payment_gateway_datas as apgd', 'apgd.annathanam_booking_id = an.id', 'left')
        ->select("an.id as annathanam_id, an.total_amount as amount, an.slot_time as time, (SELECT abpd.amount 
					FROM annathanam_booked_pay_details abpd 
					WHERE abpd.annathanam_id = an.id 
					AND abpd.is_repayment = 0 
					ORDER BY abpd.id ASC LIMIT 1) as paidamount, an.name as customer_name, an.booking_status, an.payment_type, (case when an.booking_through = 'DIRECT' then pm.name else apgd.pay_method end) as paymentmode, an.booking_through")
        ->where('an.booking_type', 3)
		->where("DATE_FORMAT(an.date, '%Y-%m-%d') >=", $current_date)
        ->where("DATE_FORMAT(an.date, '%Y-%m-%d') <=", $current_date_two)
        ->groupStart()
        ->where("an.payment_status !=", 3)
        ->orWhere('an.payment_status IS NULL')
        ->groupEnd();
    
    if (!empty($booking_type)) {
        $builder->where("an.booking_through", $booking_type);
    }
    // if (!empty($login_id)) {
    //     $builder->where("an.added_by", $login_id);
    // }
    
    $catering_data = $builder->get()->getResultArray();


    foreach ($catering_data as $key => $catering) {
        $detailBuilder = $db->table('annathanam_new as an')
            ->join('annathanam_packages as ap', 'ap.id = an.package_id')
            ->join('ledgers as l', 'l.id = ap.ledger_id', 'left')
            ->select('ap.name_eng as package_name, l.name as ledger_name, concat(l.left_code, "-", l.right_code) as ledger_code, an.no_of_pax as quantity, an.total_amount as amount')
            ->where('an.id', $catering['annathanam_id']);
        
        $products = $detailBuilder->get()->getResultArray();
        $catering_data[$key]['products'] = $products;  // Nest the products data under each annathanam
    }
    
    return $catering_data;
}
function daily_donation_withcurrentdate($current_date, $current_date_two, $booking_type = '', $login_id = '')
{
	$db = db_connect();
	$builder = $db->table("donation as d")
		->join('donation_setting as ds', 'ds.id = d.pay_for')
		->join('payment_mode as pm', 'pm.id = d.payment_mode', 'left')
		->join('donation_payment_gateway_datas as dpgd', 'dpgd.donation_booking_id = d.id', 'left')
		->join('ledgers as l', 'l.id = ds.ledger_id', 'left')
		->select("d.amount as paidamount, concat(l.left_code, '-', l.right_code) as ledger_code, l.name as ledger_name, ds.name as package_name,d.name as person_name,(case when d.paid_through = 'DIRECT' then pm.name else dpgd.pay_method end) as paymentmode, d.paid_through");
	if (!empty($login_id))
		$builder->where("d.added_by", $login_id);
	if (!empty($booking_type))
		$builder->where("d.paid_through", $booking_type);
	$donation_data = $builder->where("DATE_FORMAT(d.date, '%Y-%m-%d') >=", $current_date)
		->where("DATE_FORMAT(d.date, '%Y-%m-%d') <=", $current_date_two)
		->groupStart()
		->whereNotIn("d.payment_status", array(1, 3))
		->Orwhere('d.payment_status IS NULL')
		->groupEnd()
		->groupBy('d.id')
		->get()
		->getResultArray();
	return $donation_data;
}

function daily_prasadam_withcurrentdate($current_date, $current_date_two, $booking_type = '', $login_id = '') {
    $db = db_connect();
    
    // First, get the main prasadam data
    $builder = $db->table("prasadam as p")
        ->join('payment_mode as pm', 'pm.id = p.payment_mode', 'left')
        ->join('prasadam_payment_gateway_datas as ppgd', 'ppgd.prasadam_id = p.id', 'left')
        ->select("p.id as prasadam_id, p.amount, (SELECT pbpd.amount 
					FROM prasadam_booked_pay_details pbpd 
					WHERE pbpd.prasadam_id = p.id 
					AND pbpd.is_repayment = 0 
					ORDER BY pbpd.id ASC LIMIT 1) as paidamount, p.customer_name, p.payment_type, (case when p.paid_through = 'DIRECT' then pm.name else ppgd.pay_method end) as paymentmode, p.paid_through")
        ->where('p.booking_type', 0)
		->where("DATE_FORMAT(p.date, '%Y-%m-%d') >=", $current_date)
        ->where("DATE_FORMAT(p.date, '%Y-%m-%d') <=", $current_date_two)
        ->groupStart()
        ->where("p.payment_status !=", 3)
        ->orWhere('p.payment_status IS NULL')
        ->groupEnd();
    
    if (!empty($booking_type)) {
        $builder->where("p.paid_through", $booking_type);
    }
    // if (!empty($login_id)) {
    //     $builder->where("p.added_by", $login_id);
    // }
    
    $prasadam_data = $builder->get()->getResultArray();

    foreach ($prasadam_data as $key => $prasadam) {
        $detailBuilder = $db->table('prasadam_booking_details as pbd')
            ->join('prasadam_setting as ps', 'ps.id = pbd.prasadam_id')
            ->join('ledgers as l', 'l.id = ps.ledger_id', 'left')
            ->select('ps.name_eng as package_name, l.name as ledger_name, concat(l.left_code, "-", l.right_code) as ledger_code, pbd.quantity, pbd.total_amount as total_amount, pbd.amount as amount')
            ->where('pbd.prasadam_booking_id', $prasadam['prasadam_id']);
        
        $products = $detailBuilder->get()->getResultArray();
        $prasadam_data[$key]['products'] = $products;  // Nest the products data under each prasadam
    }
    
    return $prasadam_data;
}

function daily_kattalai_archanai_withcurrentdate($current_date, $current_date_two, $booking_type = '', $login_id = '') {
    $db = db_connect();

	$builder = $db->table("kattalai_archanai_booking as kab")
			->join('payment_mode as pm', 'pm.id = kab.payment_mode', 'left')
			// ->join('kattalai_archanai_deity_details as kadd', 'kadd.booking_id = kab.id', 'left')
			// ->join('archanai_diety as ad', 'ad.id = kadd.deity_id', 'left')
			->join('kattalai_archanai_payment_gateway_datas as kapgd', 'kapgd.booking_id = kab.id', 'left')
			->select("(SELECT GROUP_CONCAT(ad.name SEPARATOR ', ') 
					FROM kattalai_archanai_deity_details d 
					JOIN archanai_diety ad ON ad.id = d.deity_id 
					WHERE d.booking_id = kab.id) as deity_name")
			->select("kab.id as booking_id, kab.name, kab.amount as amount, 
					(SELECT kapd.amount 
					FROM kattalai_archanai_pay_details kapd 
					WHERE kapd.booking_id = kab.id 
					ORDER BY kapd.id ASC LIMIT 1) as paidamount, 
					kab.payment_type, kab.daytype, 
					(CASE WHEN kab.booking_through = 'DIRECT' THEN pm.name ELSE kapgd.pay_method END) as paymentmode, 
					kab.booking_through")
			->where("DATE_FORMAT(kab.date, '%Y-%m-%d') >=", $current_date)
			->where("DATE_FORMAT(kab.date, '%Y-%m-%d') <=", $current_date_two)
			->where("kab.archanai_type_id !=", 3)
			->groupStart()
			->where("kab.payment_status !=", 3)
			->orWhere('kab.payment_status IS NULL')
			->groupEnd();


    if (!empty($booking_type)) {
        $builder->where("kab.booking_through", $booking_type);
    }

    if (!empty($login_id)) {
        $builder->where("kab.added_by", $login_id);
    }
    
    $kattalai_archanai_data = $builder->get()->getResultArray();

    foreach ($kattalai_archanai_data as $key => $ubayam) {
        $detailBuilder = $db->table('kattalai_archanai_booking as kab')
            ->join('kattalai_archanai as ka', 'ka.id = kab.archanai_type_id')
            ->join('ledgers as l', 'l.id = ka.ledger_id', 'left')
            ->select('ka.name_eng as package_name, l.name as ledger_name, concat(l.left_code, "-", l.right_code) as ledger_code, kab.no_of_days as quantity, kab.amount as unit_amount')
            ->where('kab.id', $ubayam['booking_id']);
        
        $products = $detailBuilder->get()->getResultArray();
        $kattalai_archanai_data[$key]['products'] = $products;  // Nest the products data under each annathanam
    }
    
    return $kattalai_archanai_data;
}

function daily_kattalai_abishegam_withcurrentdate($current_date, $current_date_two, $booking_type = '', $login_id = '') {
    $db = db_connect();

	$builder = $db->table("kattalai_archanai_booking as kab")
			->join('payment_mode as pm', 'pm.id = kab.payment_mode', 'left')
			// ->join('kattalai_archanai_deity_details as kadd', 'kadd.booking_id = kab.id', 'left')
			// ->join('archanai_diety as ad', 'ad.id = kadd.deity_id', 'left')
			->join('kattalai_archanai_payment_gateway_datas as kapgd', 'kapgd.booking_id = kab.id', 'left')
			->select("(SELECT GROUP_CONCAT(ad.name SEPARATOR ', ') 
					FROM kattalai_archanai_deity_details d 
					JOIN archanai_diety ad ON ad.id = d.deity_id 
					WHERE d.booking_id = kab.id) as deity_name")
			->select("kab.id as booking_id, kab.name, kab.amount as amount, 
					(SELECT kapd.amount 
					FROM kattalai_archanai_pay_details kapd 
					WHERE kapd.booking_id = kab.id 
					ORDER BY kapd.id ASC LIMIT 1) as paidamount, 
					kab.payment_type, kab.daytype, 
					(CASE WHEN kab.booking_through = 'DIRECT' THEN pm.name ELSE kapgd.pay_method END) as paymentmode, 
					kab.booking_through")
			->where("DATE_FORMAT(kab.date, '%Y-%m-%d') >=", $current_date)
			->where("DATE_FORMAT(kab.date, '%Y-%m-%d') <=", $current_date_two)
			->where("kab.archanai_type_id", 3)
			->groupStart()
			->where("kab.payment_status !=", 3)
			->orWhere('kab.payment_status IS NULL')
			->groupEnd();


    if (!empty($booking_type)) {
        $builder->where("kab.booking_through", $booking_type);
    }

    if (!empty($login_id)) {
        $builder->where("kab.added_by", $login_id);
    }
    
    $kattalai_abishegam_data = $builder->get()->getResultArray();

    foreach ($kattalai_abishegam_data as $key => $ubayam) {
        $detailBuilder = $db->table('kattalai_archanai_booking as kab')
            ->join('kattalai_archanai as ka', 'ka.id = kab.archanai_type_id')
            ->join('ledgers as l', 'l.id = ka.ledger_id', 'left')
            ->select('ka.name_eng as package_name, l.name as ledger_name, concat(l.left_code, "-", l.right_code) as ledger_code, kab.no_of_days as quantity, kab.amount as unit_amount')
            ->where('kab.id', $ubayam['booking_id']);
        
        $products = $detailBuilder->get()->getResultArray();
        $kattalai_abishegam_data[$key]['products'] = $products;  // Nest the products data under each annathanam
    }
    
    return $kattalai_abishegam_data;
}
/*
function daily_outdoor_services_withcurrentdate($current_date, $current_date_two, $booking_type = '', $login_id = '') {
    $db = db_connect();
    
    $builder = $db->table("outdoor_booking as ob")
        ->join('payment_mode as pm', 'pm.id = ob.payment_mode', 'left')
        ->join('outdoor_pay_details as opd', 'opd.booking_id = ob.id', 'left')
        ->select("ob.id as booking_id, ob.amount as amount, ob.date as date, ob.paid_amount as paidamount, ob.name as customer_name, ob.payment_type, (case when ob.paid_through = 'DIRECT' then pm.name else opd.payment_mode_title end) as paymentmode, ob.paid_through")
		->where('ob.booking_status', 1)
        ->where("DATE_FORMAT(ob.date, '%Y-%m-%d') >=", $current_date)
        ->where("DATE_FORMAT(ob.date, '%Y-%m-%d') <=", $current_date_two)
        ->groupStart()
        ->where("ob.payment_status !=", 3)
        ->orWhere('ob.payment_status IS NULL')
        ->groupEnd();
    
    if (!empty($booking_type)) {
        $builder->where("ob.paid_through", $booking_type);
    }
    // if (!empty($login_id)) {
    //     $builder->where("an.added_by", $login_id);
    // }
    
    $ubayam_data = $builder->get()->getResultArray();

    foreach ($ubayam_data as $key => $ubayam) {*/
        /*$detailBuilder = $db->table('outdoor_booking as ob')
            ->join('temple_packages as tp', 'ob.package_id = tp.id')
			->join('outdoor_booked_addon as oba', 'oba.booking_id = ob.id')
            ->join('ledgers as l', 'l.id = tp.ledger_id', 'left')
            ->select('tp.name as package_name, l.name as ledger_name, concat(l.left_code, "-", l.right_code) as ledger_code, oba.quantity as quantity, ob.amount as amount')
            ->where('ob.id', $ubayam['booking_id']);*/
            /*
        $detailBuilder = $db->table('outdoor_booking as ob')
            ->join('temple_packages as tp', 'ob.package_id = tp.id')
            ->join('ledgers as l', 'l.id = tp.ledger_id', 'left')
            ->select('
                tp.name as package_name,
                l.name as ledger_name,
                concat(l.left_code, "-", l.right_code) as ledger_code,
                1 as quantity,
                ob.amount as amount
            ')
            ->where('ob.id', $ubayam['booking_id']);
        
        $products = $detailBuilder->get()->getResultArray();
        $ubayam_data[$key]['products'] = $products;  // Nest the products data under each annathanam
    }
    
    return $ubayam_data;
}*/

function daily_outdoor_services_withcurrentdate($current_date, $current_date_two, $booking_type = '', $login_id = '') {
    $db = db_connect();
    
    $builder = $db->table("outdoor_booking as ob")
        ->join('payment_mode as pm', 'pm.id = ob.payment_mode', 'left')
        ->join(
    '(SELECT MAX(id) as max_id, booking_id 
      FROM outdoor_pay_details 
      GROUP BY booking_id) latest_opd',
    'latest_opd.booking_id = ob.id',
    'left'
)
->join(
    'outdoor_pay_details as opd',
    'opd.id = latest_opd.max_id',
    'left'
)
        ->select("ob.id as booking_id, ob.amount as amount, ob.date as date, ob.paid_amount as paidamount, ob.name as customer_name, ob.payment_type, (case when ob.paid_through = 'DIRECT' then pm.name else opd.payment_mode_title end) as paymentmode, ob.paid_through")
		->where('ob.booking_status', 1)
        ->where("DATE_FORMAT(ob.date, '%Y-%m-%d') >=", $current_date)
        ->where("DATE_FORMAT(ob.date, '%Y-%m-%d') <=", $current_date_two)
        ->groupStart()
        ->where("ob.payment_status !=", 3)
        ->orWhere('ob.payment_status IS NULL')
        ->groupEnd();
    
    if (!empty($booking_type)) {
        $builder->where("ob.paid_through", $booking_type);
    }
    // if (!empty($login_id)) {
    //     $builder->where("an.added_by", $login_id);
    // }
    
    $ubayam_data = $builder->get()->getResultArray();

    foreach ($ubayam_data as $key => $ubayam) {
        /*$detailBuilder = $db->table('outdoor_booking as ob')
            ->join('temple_packages as tp', 'ob.package_id = tp.id')
			->join('outdoor_booked_addon as oba', 'oba.booking_id = ob.id')
            ->join('ledgers as l', 'l.id = tp.ledger_id', 'left')
            ->select('tp.name as package_name, l.name as ledger_name, concat(l.left_code, "-", l.right_code) as ledger_code, oba.quantity as quantity, ob.amount as amount')
            ->where('ob.id', $ubayam['booking_id']);*/
            
        $detailBuilder = $db->table('outdoor_booking as ob')
            ->join('temple_packages as tp', 'ob.package_id = tp.id')
            ->join('ledgers as l', 'l.id = tp.ledger_id', 'left')
            ->select('
                tp.name as package_name,
                l.name as ledger_name,
                concat(l.left_code, "-", l.right_code) as ledger_code,
                1 as quantity,
                ob.amount as amount
            ')
            ->where('ob.id', $ubayam['booking_id']);
        
        $products = $detailBuilder->get()->getResultArray();
        $ubayam_data[$key]['products'] = $products;  // Nest the products data under each annathanam
    }
    
    return $ubayam_data;
}


function daily_product_offering_withcurrentdate($current_date, $current_date_two, $booking_type = '', $login_id = '') {
    $db = db_connect();
    
    $builder = $db->table("product_offering_detail as pod")
        ->join('product_offering as po', 'po.id = pod.pro_off_id', 'left')
		->join('product_category as pc', 'pc.id = pod.product_id', 'left')
        ->join('offering_category as oc', 'oc.id = pod.offering_id', 'left')
        ->select("po.name as customer_name, oc.name as category_name, pc.name as product_name, pod.grams, pod.value, oc.name as paymentmode")
        ->where("DATE_FORMAT(po.date, '%Y-%m-%d') >=", $current_date)
        ->where("DATE_FORMAT(po.date, '%Y-%m-%d') <=", $current_date_two);
        
    if (!empty($booking_type)) {
        $builder->where("po.paid_through", $booking_type);
    }

    if (!empty($login_id)) {
        $builder->where("po.added_by", $login_id);
    }
    
    $offering_data = $builder->get()->getResultArray();
    
    return $offering_data;
}

function daily_repayment_data_withcurrentdate($current_date, $current_date_two, $booking_type = '', $login_id = '')
{
	$db = db_connect();

	// Fetch Prasadam repayment data
	$prasadamBuilder = $db->table("prasadam as p")
		->join('prasadam_booked_pay_details as pbpd', 'pbpd.prasadam_id = p.id', 'inner')
		->join('payment_mode as pm', 'pm.id = p.payment_mode', 'left')
		->join('prasadam_payment_gateway_datas as ppgd', 'ppgd.prasadam_id = p.id', 'left')
		->select("p.id as id, p.date, p.customer_name, p.amount, 
            p.paid_amount as paidamount, pbpd.amount as repaid_amount,
            (case 
                when pbpd.is_repayment = 1 AND pbpd.payment_mode_title IS NOT NULL then pbpd.payment_mode_title
                when p.paid_through = 'DIRECT' then pm.name 
                else ppgd.pay_method 
            end) as paymentmode,
            p.paid_through, 'prasadam' as type")
		->where("pbpd.is_repayment", 1)
		->where("DATE_FORMAT(pbpd.paid_date, '%Y-%m-%d') >=", $current_date)
		->where("DATE_FORMAT(pbpd.paid_date, '%Y-%m-%d') <=", $current_date_two)
		->groupStart()
		->where("p.payment_status !=", 3)
		->orWhere('p.payment_status IS NULL')
		->groupEnd();
	if (!empty($booking_type)) {
		$prasadamBuilder->where("p.paid_through", $booking_type);
	}

	$prasadam_data = $prasadamBuilder->get()->getResultArray();

	$annathanamBuilder = $db->table("annathanam_new as an")
		->join('annathanam_booked_pay_details as abpd', 'abpd.annathanam_id = an.id', 'inner')
		->join('payment_mode as pm', 'pm.id = an.payment_mode', 'left')
		->join('annathanam_payment_gateway_datas as apgd', 'apgd.annathanam_booking_id = an.id', 'left')
		->select("an.id as id, an.date, an.name as customer_name, an.total_amount as amount, an.paid_amount as paidamount, abpd.amount as repaid_amount, (case when an.booking_through = 'DIRECT' then pm.name else apgd.pay_method end) as paymentmode, an.booking_through, 'annathanam' as type")
		->where("abpd.is_repayment", 1)
		->where("an.booking_type", 0)
		->where("DATE_FORMAT(abpd.paid_date, '%Y-%m-%d') >=", $current_date)
		->where("DATE_FORMAT(abpd.paid_date, '%Y-%m-%d') <=", $current_date_two)
		->groupStart()
		->where("an.payment_status !=", 3)
		->orWhere('an.payment_status IS NULL')
		->groupEnd();

	if (!empty($booking_type)) {
		$annathanamBuilder->where("an.booking_through", $booking_type);
	}

	$annathanam_data = $annathanamBuilder->get()->getResultArray();

	// $cateringBuilder = $db->table("annathanam_new as an")
	// 	->join('annathanam_booked_pay_details as abpd', 'abpd.annathanam_id = an.id', 'inner')
	// 	->join('payment_mode as pm', 'pm.id = an.payment_mode', 'left')
	// 	->join('annathanam_payment_gateway_datas as apgd', 'apgd.annathanam_booking_id = an.id', 'left')
	// 	->select("an.id as id, an.date, an.name as customer_name, an.total_amount as amount, an.paid_amount as paidamount, abpd.amount as repaid_amount, (case when an.booking_through = 'DIRECT' then pm.name else apgd.pay_method end) as paymentmode, an.booking_through, 'Catering' as type")
	// 	->where("abpd.is_repayment", 1)
	// 	->where("an.booking_type", 3)
	// 	->where("DATE_FORMAT(abpd.paid_date, '%Y-%m-%d') >=", $current_date)
	// 	->where("DATE_FORMAT(abpd.paid_date, '%Y-%m-%d') <=", $current_date_two)
	// 	->groupStart()
	// 	->where("an.payment_status !=", 3)
	// 	->orWhere('an.payment_status IS NULL')
	// 	->groupEnd();
	$cateringBuilder = $db->table("annathanam_new as an")
		->join('annathanam_booked_pay_details as abpd', 'abpd.annathanam_id = an.id', 'inner')
		->join('payment_mode as pm', 'pm.id = an.payment_mode', 'left')
		->join('annathanam_payment_gateway_datas as apgd', 'apgd.annathanam_booking_id = an.id', 'left')
		->select("an.id as id, an.date, an.name as customer_name, an.total_amount as amount, 
            an.paid_amount as paidamount, abpd.amount as repaid_amount, 
            (case 
                when abpd.is_repayment = 1 AND abpd.payment_mode_title IS NOT NULL then abpd.payment_mode_title
                when an.booking_through = 'DIRECT' then pm.name 
                else apgd.pay_method 
            end) as paymentmode, 
            an.booking_through, 'Catering' as type")
		->where("abpd.is_repayment", 1)
		->where("an.booking_type", 3)
		->where("DATE_FORMAT(abpd.paid_date, '%Y-%m-%d') >=", $current_date)
		->where("DATE_FORMAT(abpd.paid_date, '%Y-%m-%d') <=", $current_date_two)
		->groupStart()
		->where("an.payment_status !=", 3)
		->orWhere('an.payment_status IS NULL')
		->groupEnd();
	if (!empty($booking_type)) {
		$cateringBuilder->where("an.booking_through", $booking_type);
	}

	$catering_data = $cateringBuilder->get()->getResultArray();
	$ubayambuilder = $db->table("booked_pay_details as bpd")
		->join('templebooking as tb', 'tb.id = bpd.booking_id', 'inner')
		->join('payment_mode as pm', 'pm.id = bpd.payment_mode_id', 'left')
		->select("bpd.id as payment_id,
              tb.id as templebooking_id, 
              tb.total_amount as amount, 
              tb.booking_date as date, 
              tb.paid_amount as total_paidamount,
              bpd.paid_date,
              bpd.paid_through, 
              bpd.amount as repaid_amount, 
              tb.name as customer_name, 
              tb.payment_type,
              tb.ref_no,
              bpd.payment_mode_title as paymentmode, 
              tb.booking_through, 
              CONCAT('Ubayam - ', tb.name) as type")
		->where("bpd.is_repayment", 1)
		->where('bpd.booking_type', 2)
		->where('bpd.pay_status', 2)
		->where("DATE_FORMAT(bpd.paid_date, '%Y-%m-%d') >=", $current_date)
		->where("DATE_FORMAT(bpd.paid_date, '%Y-%m-%d') <=", $current_date_two)
		->groupStart()
		->where("tb.payment_status !=", 3)
		->orWhere('tb.payment_status IS NULL')
		->groupEnd()
		->orderBy('bpd.paid_date', 'ASC')
		->orderBy('bpd.id', 'ASC');

	if (!empty($booking_type)) {
		$ubayambuilder->where("bpd.paid_through", $booking_type);
	}

	$ubayam_data = $ubayambuilder->get()->getResultArray();

	$hallbuilder = $db->table("templebooking as tb")
		->join('booked_pay_details as bpd', 'bpd.booking_id = tb.id', 'left')
		->join('payment_mode as pm', 'pm.id = bpd.payment_mode_id', 'left')
		->select("tb.id as templebooking_id, tb.amount as amount, tb.booking_date as date, tb.paid_amount as paidamount, bpd.paid_through, bpd.amount as repaid_amount, tb.name as customer_name, tb.payment_type, bpd.payment_mode_title as paymentmode, tb.booking_through, 'Hall Booking' as type")
		->where("bpd.is_repayment", 1)
		->where('bpd.booking_type', 1)
		->where('bpd.pay_status', 2)
		->where("DATE_FORMAT(bpd.paid_date, '%Y-%m-%d') >=", $current_date)
		->where("DATE_FORMAT(bpd.paid_date, '%Y-%m-%d') <=", $current_date_two)
		->groupStart()
		->where("tb.payment_status !=", 3)
		->orWhere('tb.payment_status IS NULL')
		->groupEnd();

	if (!empty($booking_type)) {
		$hallbuilder->where("bpd.paid_through", $booking_type);
	}
	$hall_data = $hallbuilder->get()->getResultArray();

	$kattalaibuilder = $db->table("kattalai_archanai_booking as kab")
		->join('kattalai_archanai_pay_details as kapd', 'kapd.booking_id = kab.id', 'left')
		->join('payment_mode as pm', 'pm.id = kapd.payment_mode_id', 'left')
		->select("kab.id, kab.amount as amount, kab.date as date, kab.paid_amount as paidamount, kapd.paid_through, kapd.amount as repaid_amount, kab.name as customer_name, kab.payment_type, kapd.payment_mode_title as paymentmode, kab.booking_through, 'Kattalai Archanai' as type")
		->where("kapd.is_repayment", 1)
		->where('kapd.pay_status', 2)
		->where("DATE_FORMAT(kapd.paid_date, '%Y-%m-%d') >=", $current_date)
		->where("DATE_FORMAT(kapd.paid_date, '%Y-%m-%d') <=", $current_date_two)
		->groupStart()
		->where("kab.payment_status !=", 3)
		->orWhere('kab.payment_status IS NULL')
		->groupEnd();

	if (!empty($booking_type)) {
		$kattalaibuilder->where("kapd.paid_through", $booking_type);
	}
	$kattalai_data = $kattalaibuilder->get()->getResultArray();

	$combined_data = array_merge($hall_data, $ubayam_data, $prasadam_data, $annathanam_data, $kattalai_data, $catering_data);

	return $combined_data;
}

// function daily_repayment_data_withcurrentdate($current_date, $current_date_two, $booking_type = '', $login_id = '') {
//     $db = db_connect();
    
//     // Fetch Prasadam repayment data
//     $prasadamBuilder = $db->table("prasadam as p")
//         ->join('prasadam_booked_pay_details as pbpd', 'pbpd.prasadam_id = p.id', 'inner')
//         ->join('payment_mode as pm', 'pm.id = p.payment_mode', 'left')
//         ->join('prasadam_payment_gateway_datas as ppgd', 'ppgd.prasadam_id = p.id', 'left')
//         ->select("p.id as id, p.date, p.customer_name, p.amount, p.paid_amount as paidamount, pbpd.amount as repaid_amount, (case when p.paid_through = 'DIRECT' then pm.name else ppgd.pay_method end) as paymentmode, p.paid_through, 'prasadam' as type")
//         ->where("pbpd.is_repayment", 1)
//         ->where("DATE_FORMAT(pbpd.paid_date, '%Y-%m-%d') >=", $current_date)
//         ->where("DATE_FORMAT(pbpd.paid_date, '%Y-%m-%d') <=", $current_date_two)
//         ->groupStart()
//         ->where("p.payment_status !=", 3)
//         ->orWhere('p.payment_status IS NULL')
//         ->groupEnd();

//     if (!empty($booking_type)) {
//         $prasadamBuilder->where("p.paid_through", $booking_type);
//     }
    
//     $prasadam_data = $prasadamBuilder->get()->getResultArray();

//     $annathanamBuilder = $db->table("annathanam_new as an")
//         ->join('annathanam_booked_pay_details as abpd', 'abpd.annathanam_id = an.id', 'inner')
//         ->join('payment_mode as pm', 'pm.id = an.payment_mode', 'left')
//         ->join('annathanam_payment_gateway_datas as apgd', 'apgd.annathanam_booking_id = an.id', 'left')
//         ->select("an.id as id, an.date, an.name as customer_name, an.total_amount as amount, an.paid_amount as paidamount, abpd.amount as repaid_amount, (case when an.booking_through = 'DIRECT' then pm.name else apgd.pay_method end) as paymentmode, an.booking_through, 'annathanam' as type")
//         ->where("abpd.is_repayment", 1)
// 		->where("an.booking_type", 0)
//         ->where("DATE_FORMAT(abpd.paid_date, '%Y-%m-%d') >=", $current_date)
//         ->where("DATE_FORMAT(abpd.paid_date, '%Y-%m-%d') <=", $current_date_two)
//         ->groupStart()
//         ->where("an.payment_status !=", 3)
//         ->orWhere('an.payment_status IS NULL')
//         ->groupEnd();

//     if (!empty($booking_type)) {
//         $annathanamBuilder->where("an.booking_through", $booking_type);
//     }

//     $annathanam_data = $annathanamBuilder->get()->getResultArray();

// 	$cateringBuilder = $db->table("annathanam_new as an")
//         ->join('annathanam_booked_pay_details as abpd', 'abpd.annathanam_id = an.id', 'inner')
//         ->join('payment_mode as pm', 'pm.id = an.payment_mode', 'left')
//         ->join('annathanam_payment_gateway_datas as apgd', 'apgd.annathanam_booking_id = an.id', 'left')
//         ->select("an.id as id, an.date, an.name as customer_name, an.total_amount as amount, an.paid_amount as paidamount, abpd.amount as repaid_amount, (case when an.booking_through = 'DIRECT' then pm.name else apgd.pay_method end) as paymentmode, an.booking_through, 'Catering' as type")
//         ->where("abpd.is_repayment", 1)
// 		->where("an.booking_type", 3)
//         ->where("DATE_FORMAT(abpd.paid_date, '%Y-%m-%d') >=", $current_date)
//         ->where("DATE_FORMAT(abpd.paid_date, '%Y-%m-%d') <=", $current_date_two)
//         ->groupStart()
//         ->where("an.payment_status !=", 3)
//         ->orWhere('an.payment_status IS NULL')
//         ->groupEnd();

//     if (!empty($booking_type)) {
//         $cateringBuilder->where("an.booking_through", $booking_type);
//     }

//     $catering_data = $cateringBuilder->get()->getResultArray();

// 	$ubayambuilder = $db->table("templebooking as tb")
// 		->join('booked_pay_details as bpd', 'bpd.booking_id = tb.id', 'left')
// 		->join('payment_mode as pm', 'pm.id = bpd.payment_mode_id', 'left')
//         ->select("tb.id as templebooking_id, tb.amount as amount, tb.booking_date as date, tb.paid_amount as paidamount, bpd.paid_through, bpd.amount as repaid_amount, tb.name as customer_name, tb.payment_type, bpd.payment_mode_title as paymentmode, tb.booking_through, 'Ubayam' as type")
// 		->where("bpd.is_repayment", 1)
// 		->where('bpd.booking_type', 2)
// 		->where('bpd.pay_status', 2)
//         ->where("DATE_FORMAT(bpd.paid_date, '%Y-%m-%d') >=", $current_date)
//         ->where("DATE_FORMAT(bpd.paid_date, '%Y-%m-%d') <=", $current_date_two)
//         ->groupStart()
//         ->where("tb.payment_status !=", 3)
//         ->orWhere('tb.payment_status IS NULL')
//         ->groupEnd();
    
//     if (!empty($booking_type)) {
//         $ubayambuilder->where("bpd.paid_through", $booking_type);
//     }
// 	$ubayam_data = $ubayambuilder->get()->getResultArray();

// 	$hallbuilder = $db->table("templebooking as tb")
// 		->join('booked_pay_details as bpd', 'bpd.booking_id = tb.id', 'left')
// 		->join('payment_mode as pm', 'pm.id = bpd.payment_mode_id', 'left')
//         ->select("tb.id as templebooking_id, tb.amount as amount, tb.booking_date as date, tb.paid_amount as paidamount, bpd.paid_through, bpd.amount as repaid_amount, tb.name as customer_name, tb.payment_type, bpd.payment_mode_title as paymentmode, tb.booking_through, 'Hall Booking' as type")
// 		->where("bpd.is_repayment", 1)
// 		->where('bpd.booking_type', 1)
// 		->where('bpd.pay_status', 2)
//         ->where("DATE_FORMAT(bpd.paid_date, '%Y-%m-%d') >=", $current_date)
//         ->where("DATE_FORMAT(bpd.paid_date, '%Y-%m-%d') <=", $current_date_two)
//         ->groupStart()
//         ->where("tb.payment_status !=", 3)
//         ->orWhere('tb.payment_status IS NULL')
//         ->groupEnd();
    
//     if (!empty($booking_type)) {
//         $hallbuilder->where("bpd.paid_through", $booking_type);
//     }
// 	$hall_data = $hallbuilder->get()->getResultArray();

// 	$kattalaibuilder = $db->table("kattalai_archanai_booking as kab")
// 		->join('kattalai_archanai_pay_details as kapd', 'kapd.booking_id = kab.id', 'left')
// 		->join('payment_mode as pm', 'pm.id = kapd.payment_mode_id', 'left')
//         ->select("kab.id, kab.amount as amount, kab.date as date, kab.paid_amount as paidamount, kapd.paid_through, kapd.amount as repaid_amount, kab.name as customer_name, kab.payment_type, kapd.payment_mode_title as paymentmode, kab.booking_through, 'Kattalai Archanai' as type")
// 		->where("kapd.is_repayment", 1)
// 		->where('kapd.pay_status', 2)
//         ->where("DATE_FORMAT(kapd.paid_date, '%Y-%m-%d') >=", $current_date)
//         ->where("DATE_FORMAT(kapd.paid_date, '%Y-%m-%d') <=", $current_date_two)
//         ->groupStart()
//         ->where("kab.payment_status !=", 3)
//         ->orWhere('kab.payment_status IS NULL')
//         ->groupEnd();
    
//     if (!empty($booking_type)) {
//         $kattalaibuilder->where("kapd.paid_through", $booking_type);
//     }
// 	$kattalai_data = $kattalaibuilder->get()->getResultArray();

//     $combined_data = array_merge($hall_data, $ubayam_data, $prasadam_data, $annathanam_data, $kattalai_data);

//     return $combined_data;
// }

function daily_prasadam_withcurrentdate_summary($current_date, $current_date_two, $booking_type = '', $login_id = '')
{
	$db = db_connect();
	$builder = $db->table("prasadam as p")
		->join('prasadam_booking_details as pbd', 'pbd.prasadam_booking_id = p.id')
		->join('prasadam_setting as ps', 'ps.id = pbd.prasadam_id')
		->join('payment_mode as pm', 'pm.id = p.payment_mode', 'left')
		->join('prasadam_payment_gateway_datas as ppgd', 'ppgd.prasadam_id = p.id', 'left')
		->join('ledgers as l', 'l.id = ps.ledger_id', 'left')
		->select("pbd.total_amount as paidamount, pbd.quantity as qty, concat(l.left_code, '-', l.right_code) as ledger_code, l.name as ledger_name, ps.name_eng as package_name,p.customer_name as person_name,(case when p.paid_through = 'DIRECT' then pm.name else ppgd.pay_method end) as paymentmode, p.paid_through");
	// if (!empty($login_id))
	// 	$builder->where("p.added_by", $login_id);
	if (!empty($booking_type))
		$builder->where("p.paid_through", $booking_type);
	$prasadam_data = $builder->where("DATE_FORMAT(p.date, '%Y-%m-%d') >=", $current_date)
		->where("DATE_FORMAT(p.date, '%Y-%m-%d') <=", $current_date_two)
		->groupStart()
		->whereNotIn("p.payment_status", array(1, 3))
		->Orwhere('p.payment_status IS NULL')
		->groupEnd()
		//->groupBy('p.id')
		->get()
		->getResultArray();
	return $prasadam_data;
}


function daily_group_archanai_booking_withcurrentdate_old($current_date, $current_date_two, $booking_type = '', $login_id = '')
{
	$db = db_connect();
	$archanai_data = array();
	$data_direct = array();
	$data_counter = array();
	$data_online = array();
	$where = '';
	if (!empty($booking_type))
		$where .= " and b.paid_through = '$booking_type'";
	if (!empty($login_id))
		$where .= " and b.entry_by = '$login_id'";
	$query = $db->query("select a.archanai_id, a.archanai_booking_id, ag.id as group_id, aa.groupname, aa.name_eng, aa.name_tamil, sum(a.quantity) as qunty, sum(a.total_amount) as amt, sum(a.total_commision) as comm, count(a.archanai_id) as cnt, b.paid_through, (case when b.paid_through = 'DIRECT' then b.payment_mode else c.pay_method end) as payment_mode from archanai_booking_details a left join archanai_booking b on b.id = a.archanai_booking_id left join archanai_payment_gateway_datas c on c.archanai_booking_id = b.id left join archanai aa on aa.id = a.archanai_id left join archanai_group ag on ag.name = aa.groupname where b.date >= '$current_date' and b.date <= '$current_date_two'$where and (b.payment_status not in(1,3) or b.payment_status is NULL) group by b.payment_mode, c.pay_method, b.paid_through, a.archanai_id, ag.id having count(a.archanai_id) > 0 order by ag.order_no ASC");
	$res2 = $query->getResultArray();
	if (count($res2)) {
		foreach ($res2 as $row) {
			$paymentname = '';
			$total = $row['amt'] + $row['comm'];
			if ($row['paid_through'] == 'DIRECT') {
				$payment_mode = $db->table('payment_mode')->where('id', $row['payment_mode'])->get()->getRowArray();
				$paymentname = strtolower($payment_mode['name']);
			} else {
				// if ($row['payment_mode'] == "ipay_merch_qr") {
					// $paymentname = "QR PAYMENT";
				// } elseif ($row['payment_mode'] == "ipay_merch_online") {
					// $paymentname = "ONLINE PAYMENT";
				// } elseif ($row['payment_mode'] == "cash") {
					// $paymentname = "CASH";
				// } elseif ($row['payment_mode'] == "cash") {
					// $paymentname = "CASH";
				// }else{
					// $paymentname = strtoupper($row['payment_mode']);
				// }
				$paymentname = $row['payment_mode'];

			}
			$archanai_data[$row['group_id']]['title'] = $row['groupname'];
			$archanai_data[$row['group_id']]['data'][] = array(
				"name_in_english" => $row['name_eng'],
				"name_in_tamil" => $row['name_tamil'],
				"paymentmode" => $paymentname,
				"paid_through" => $row['paid_through'],
				"qty" => $row['qunty'],
				"amount" => $total
			);
		}
	}
	return $archanai_data;
}
function daily_member_withcurrentdate($current_date, $current_date_two, $booking_type = '', $login_id = '')
{
	$db = db_connect();

	$builder = $db->table("member as m")
		->join('payment_mode as pm', 'pm.id = m.payment_mode', 'left')
		->join('member_payment_gateway_datas as mpgd', 'mpgd.member_id = m.id', 'left')
		->join('member_type as mt', 'mt.id = m.member_type', 'left')
		->select("m.id as member_id, m.name, m.member_no, mt.name as member_type_name, m.ic_no, m.mobile, m.email_address, m.start_date, m.end_date, m.payment, m.application_fee, m.total_amount, (case when m.paid_through = 'DIRECT' then pm.name else mpgd.pay_method end) as paymentmode, m.paid_through, m.status")
		->where("DATE_FORMAT(m.created, '%Y-%m-%d') >=", $current_date)
		->where("DATE_FORMAT(m.created, '%Y-%m-%d') <=", $current_date_two)
		->groupStart()
		->where("m.payment_status !=", 3)
		->orWhere('m.payment_status IS NULL')
		->groupEnd();

	if (!empty($booking_type)) {
		$builder->where("m.paid_through", $booking_type);
	}

	$member_data = $builder->get()->getResultArray();

	return $member_data;
}
function daily_payment_voucher_withcurrentdate($current_date, $current_date_two, $booking_type = '', $login_id = '')
{
	$db = db_connect();
	$builder = $db->table("entries as e")
		->join('entryitems as ei', 'ei.entry_id = e.id')
		->select("e.dr_total as paidamount,e.payment as paymentmode,e.paid_through, e.paid_to");
	if (!empty($login_id))
		$builder->where("e.entry_by", $login_id);
	if (!empty($booking_type))
		$builder->where("e.paid_through", $booking_type);
	$payment_voucher_data = $builder->where("DATE_FORMAT(e.date, '%Y-%m-%d') >=", $current_date)
		->where("DATE_FORMAT(e.date, '%Y-%m-%d') <=", $current_date_two)
		->where('e.inv_id IS NULL')
		->groupBy('ei.entry_id')
		->get()
		->getResultArray();
	return $payment_voucher_data;
}

function archanai_chart_daily($fromDate, $toDate) {
    $db = db_connect(); // Connect to the database

    $sql = "SELECT DATE_FORMAT(ab.created, '%Y-%m-%d') as day, 
                   apgd.pay_method, 
                   COUNT(*) as count,
                   SUM(ab.amount) as total_amount
            FROM archanai_booking ab
            JOIN archanai_payment_gateway_datas apgd 
            ON ab.id = apgd.archanai_booking_id
            WHERE ab.payment_status = 2
              AND ab.created BETWEEN ? AND ?
            GROUP BY DATE_FORMAT(ab.created, '%Y-%m-%d'), apgd.pay_method
            ORDER BY DATE_FORMAT(ab.created, '%Y-%m-%d')";

    $query = $db->query($sql, [$fromDate, $toDate]);
    $results = $query->getResultArray();

    $data = [];
    $totals = [
        'SubTotal' => [
            'cash' => 0, 'qr' => 0, 'ipay_card' => 0, 'ipay_merch_qr' => 0,
            'total_amount' => 0
        ],
        'GrandTotal' => [
            'count' => 0, 'amount' => 0
        ]
    ];

    foreach ($results as $row) {
        $day = $row['day'];
        $payMethod = $row['pay_method'];
        $count = (int)$row['count'];
        $amount = (float)$row['total_amount'];

        // Initialize the day entry if it doesn't exist
        if (!isset($data[$day])) {
            $data[$day] = [
                'Counter' => ['cash' => 0, 'qr' => 0, 'total_amount' => 0],
                'Kiosk' => ['ipay_card' => 0, 'ipay_merch_qr' => 0, 'total_amount' => 0],
                'CounterCount' => ['cash' => 0, 'qr' => 0],
                'KioskCount' => ['ipay_card' => 0, 'ipay_merch_qr' => 0]
            ];
        }

        // Assign data based on payment method
        if ($payMethod === 'cash' || $payMethod === 'qr') {
            $data[$day]['Counter'][$payMethod] += $amount;
            $data[$day]['CounterCount'][$payMethod] += $count;
        } elseif ($payMethod === 'ipay_card' || $payMethod === 'ipay_merch_qr') {
            $data[$day]['Kiosk'][$payMethod] += $amount;
            $data[$day]['KioskCount'][$payMethod] += $count;
        }

        // Update totals
        $totals['SubTotal'][$payMethod] += $amount;
        $totals['SubTotal']['total_amount'] += $amount;
        $totals['GrandTotal']['count'] += $count;
        $totals['GrandTotal']['amount'] += $amount;
    }

    return ['MainData' => $data, 'Totals' => $totals];
}


function archanai_chart_weekly($monthYear) {
    $db = db_connect(); // Connect to the database

    // Calculate the first and last dates of the given month
    $fromDate = date('Y-m-01', strtotime($monthYear)); 
    $toDate = date('Y-m-t', strtotime($monthYear)); 

    // SQL query to get the count of bookings grouped by week and payment method
    $sql = "SELECT YEARWEEK(ab.created, 3) as year_week, 
                   apgd.pay_method, 
                   COUNT(*) as count,
                   SUM(ab.amount) as total_amount
            FROM archanai_booking ab
            JOIN archanai_payment_gateway_datas apgd 
            ON ab.id = apgd.archanai_booking_id
            WHERE ab.payment_status = 2
              AND ab.created BETWEEN ? AND ?
            GROUP BY YEARWEEK(ab.created, 3), apgd.pay_method
            ORDER BY YEARWEEK(ab.created, 3)";

    $query = $db->query($sql, [$fromDate, $toDate]); // Execute the query with the formatted dates
    $results = $query->getResultArray(); // Fetch the results as an associative array

    $weeklyData = [];
    $totals = [
        'SubTotal' => [
            'cash' => 0, 'qr' => 0, 'ipay_card' => 0, 'ipay_merch_qr' => 0,
            'total_amount' => 0
        ],
        'GrandTotal' => [
            'count' => 0, 'amount' => 0
        ]
    ];

    foreach ($results as $row) {
        $yearWeek = $row['year_week'];
        $payMethod = $row['pay_method'];
        $count = (int)$row['count'];
        $amount = (float)$row['total_amount'];

        if (!isset($weeklyData[$yearWeek])) {
            $weeklyData[$yearWeek] = [
                'Counter' => ['cash' => 0, 'qr' => 0, 'total_amount' => 0],
                'Kiosk' => ['ipay_card' => 0, 'ipay_merch_qr' => 0, 'total_amount' => 0],
                'CounterCount' => ['cash' => 0, 'qr' => 0],
                'KioskCount' => ['ipay_card' => 0, 'ipay_merch_qr' => 0]
            ];
        }

        if (in_array($payMethod, ['cash', 'qr'])) {
            $weeklyData[$yearWeek]['Counter'][$payMethod] += $amount;
            $weeklyData[$yearWeek]['CounterCount'][$payMethod] += $count;
            $weeklyData[$yearWeek]['Counter']['total_amount'] += $amount;
        } elseif (in_array($payMethod, ['ipay_card', 'ipay_merch_qr'])) {
            $weeklyData[$yearWeek]['Kiosk'][$payMethod] += $amount;
            $weeklyData[$yearWeek]['KioskCount'][$payMethod] += $count;
            $weeklyData[$yearWeek]['Kiosk']['total_amount'] += $amount;
        }

        $totals['SubTotal'][$payMethod] += $amount;
        $totals['SubTotal']['total_amount'] += $amount;
        $totals['GrandTotal']['count'] += $count;
        $totals['GrandTotal']['amount'] += $amount;
    }

    return ['MainData' => $weeklyData, 'Totals' => $totals]; 
}


function archanai_chart_monthly($fromMonthYear, $toMonthYear) {
    $db = db_connect(); // Connect to the database

    $fromDate = date('Y-m-01', strtotime($fromMonthYear)); 
    $toDate = date('Y-m-t', strtotime($toMonthYear)); 

    $sql = "SELECT DATE_FORMAT(ab.created, '%Y-%m') as month, 
                   apgd.pay_method, 
                   COUNT(*) as count,
                   SUM(ab.amount) as total_amount
            FROM archanai_booking ab
            JOIN archanai_payment_gateway_datas apgd 
            ON ab.id = apgd.archanai_booking_id
            WHERE ab.payment_status = 2
              AND ab.created BETWEEN ? AND ?
            GROUP BY DATE_FORMAT(ab.created, '%Y-%m'), apgd.pay_method
            ORDER BY DATE_FORMAT(ab.created, '%Y-%m')";

    $query = $db->query($sql, [$fromDate, $toDate]);
    $results = $query->getResultArray();

    $monthlyData = [];
    $totals = [
        'SubTotal' => [
            'cash' => 0, 'qr' => 0, 'ipay_card' => 0, 'ipay_merch_qr' => 0,
            'total_amount' => 0
        ],
        'GrandTotal' => [
            'count' => 0, 'amount' => 0
        ]
    ];

    foreach ($results as $row) {
        $month = $row['month'];
        $payMethod = $row['pay_method'];
        $count = (int)$row['count'];
        $amount = (float)$row['total_amount'];
        
        if (!isset($monthlyData[$month])) {
            $monthlyData[$month] = [
                'Counter' => ['cash' => 0, 'qr' => 0, 'total_amount' => 0],
                'Kiosk' => ['ipay_card' => 0, 'ipay_merch_qr' => 0, 'total_amount' => 0],
                'CounterCount' => ['cash' => 0, 'qr' => 0],
                'KioskCount' => ['ipay_card' => 0, 'ipay_merch_qr' => 0]
            ];
        }

        if (in_array($payMethod, ['cash', 'qr'])) {
            $monthlyData[$month]['Counter'][$payMethod] += $amount;
            $monthlyData[$month]['Counter']['total_amount'] += $amount;
            $monthlyData[$month]['CounterCount'][$payMethod] += $count;
        } elseif (in_array($payMethod, ['ipay_card', 'ipay_merch_qr'])) {
            $monthlyData[$month]['Kiosk'][$payMethod] += $amount;
            $monthlyData[$month]['Kiosk']['total_amount'] += $amount;
            $monthlyData[$month]['KioskCount'][$payMethod] += $count;
        }

        // Update totals
        $totals['SubTotal'][$payMethod] += $amount;
        $totals['SubTotal']['total_amount'] += $amount;
        $totals['GrandTotal']['count'] += $count;
        $totals['GrandTotal']['amount'] += $amount;
    }

    return ['MainData' => $monthlyData, 'Totals' => $totals];
}


function whatsapp_aisensy($number, $message_params, $template_name = 'hall_whatsapp_api1', $media = array())
{
	$data = array();
	/* $templateParams = [
				   "Naveen",
				   "Marriage Event",
				   "23 Dec 2023",
				   "9:00am - 12:00am",
				   "2200",
				   "1500",
				   "700"
				]; */
	$templateParams = $message_params;
	/* $data['apiKey'] = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjY1Njg0MGI1M2Y0NmRlMGJlMWFmYmYzNyIsIm5hbWUiOiJHUkFTUCBTT0ZUV0FSRSBTT0xVVElPTlMiLCJhcHBOYW1lIjoiQWlTZW5zeSIsImNsaWVudElkIjoiNjU2ODQwYjQzZjQ2ZGUwYmUxYWZiZjMyIiwiYWN0aXZlUGxhbiI6IkJBU0lDX01PTlRITFkiLCJpYXQiOjE3MDEzMzExMjV9.FiR2rGZ_AAlhSfSJ08evlCHddlsjg8UQuH72sCWefx0'; */
//  $data['apiKey'] = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjY1ZjgwY2ZkNjYxNmY1MGI5ZjMxYWJjOCIsIm5hbWUiOiJBUlVMTUlHVSBSQUpBTUFSSUFNTUFOIERFVkFTVEhBTkFNIiwiYXBwTmFtZSI6IkFpU2Vuc3kiLCJjbGllbnRJZCI6IjY1ZjgwY2ZkNjYxNmY1MGI5ZjMxYWJjMCIsImFjdGl2ZVBsYW4iOiJCQVNJQ19NT05USExZIiwiaWF0IjoxNzExMDkwMjk5fQ.BEn8LtNGomASZhxlQ2srvnBuDuv50VVxKnf2xkPhaBs';
// 	$data['campaignName'] = $template_name;
// 	$data['destination'] = $number;
// 	$data['userName'] = 'wbapi@rajamariammandevasthanam.com';
// 	$data['templateParams'] = $templateParams;
// 	if (!empty($media))
// 		$data['media'] = $media;
// 	$url = 'https://backend.aisensy.com/campaign/t1/api/v2';
// 	$ch = curl_init($url);
// 	# Setup request to send json via POST.
// 	$payload = json_encode($data);
// 	// echo $payload;
// 	curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
// 	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
// 	# Return response instead of printing.
// 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// 	# Send request.
// 	$result = curl_exec($ch);
// 	curl_close($ch);
// 	# Print response.
	// echo "<pre>$result</pre>";
	return json_decode($result, true);
}
function sync_users_all_tag($data, $tag_id = 1)
{
	$db = db_connect();
	if (!empty($data['mobile']) && !empty($data['country_phone_code'])) {
		$user_datas = $db->table("users_all")->where('mobile', $data['mobile'])->get()->getResultArray();
		if (count($user_datas) > 0) {
			$user_id = $user_datas[0]['id'];
		} else {
			$db->table('users_all')->insert($data);
			$user_id = $db->insertID();
		}
		$tag_data = array('user_id' => $user_id, 'tag_id' => $tag_id);
		$db->table('user_tag_relation')->delete($tag_data);
		$db->table('user_tag_relation')->insert($tag_data);
	}

}

function loadstaffsalary($staffid, $paytypeid, $ded_month)
{
	$db = db_connect();
	$staff_id = $staffid;
	$paytype_id = $paytypeid;
	$month_advance_salary = 0;
	$emi_advance_salary = 0;
	$basic_pay_data = $db->table('staff')->select("*")->where('id', $staff_id)->get()->getRowArray();
	//if($paytype_id == 1){
	$deduction_month = date('Y-m', strtotime($ded_month));
	$advance_salary_monthly_data = $db->query("select sum(amount) as amount from advancesalary where staff_id = '$staff_id' and deduction_month = '$deduction_month' and type = 1 ")->getResultArray();
	if (count($advance_salary_monthly_data) > 0) {
		if ($advance_salary_monthly_data[0]['amount'] > 0) {
			$month_advance_salary = $advance_salary_monthly_data[0]['amount'];
		} else {
			$month_advance_salary = 0;
		}
	} else {
		$month_advance_salary = 0;
	}
	//}
	//if($paytype_id == 2){
	$deduction_emi = date('Y-m-01', strtotime($ded_month));
	$advance_salary_emi_data = $db->query("select COALESCE(sum(amount),0) as amount,COALESCE(emi_count,0) as emi_count from advancesalary where staff_id = $staff_id and emi_start_month <= '$deduction_emi' and emi_end_month >= '$deduction_emi' and type = 2 ")->getResultArray();
	if (count($advance_salary_emi_data) > 0) {
		if ($advance_salary_emi_data[0]['amount'] > 0) {
			$emi_advance_salary = $advance_salary_emi_data[0]['amount'];
		} else {
			$emi_advance_salary = 0;
		}
	} else {
		$emi_advance_salary = 0;
	}
	//}
	$advance_sal = $month_advance_salary + $emi_advance_salary;
	//return $deduction_emi;
	if (!empty($basic_pay_data['basic_pay'])) {
		if ($basic_pay_data['staff_type'] == 1) { // malaysian
			$epf_amount = $basic_pay_data['epf_amount'];
			$socso_amount = $basic_pay_data['socso_amount'];
			$eis_amount = $basic_pay_data['eis_amount'];
			$allowance = $basic_pay_data['allowance'];
		}
		if ($basic_pay_data['staff_type'] == 2) { //Foreigner
			$epf_amount = 0;
			$socso_amount = 0;
			$eis_amount = 0;
			$allowance = $basic_pay_data['allowance'];
		}
		$earning_amt = $allowance;
		$deduction_amt = $epf_amount + $socso_amount + $eis_amount;
		$eighty_per = $basic_pay_data['basic_pay'];
		$eight_earning_deduction = ($eighty_per + $earning_amt) - $deduction_amt;
		$remaing_amt = $eight_earning_deduction - $advance_sal;
	} else {
		$remaing_amt = 0;
	}
	return $remaing_amt;

}
function loademiamount($provision_amount, $emi_type, $amount, $pay_type)
{
	if ($pay_type == 1) {
		$re_amount = $amount;
	}
	if ($pay_type == 2) {
		if (!empty($emi_type)) {
			if (!empty($provision_amount)) {
				$chck_bf = (float) $amount + (float) $provision_amount;
				$fbf_m_a = $chck_bf / $emi_type;
				$re_amount = $fbf_m_a;
			} else {
				$chck_bf = (float) $amount;
				$fbf_m_a = $chck_bf / $emi_type;
				$re_amount = $fbf_m_a;
			}
		} else {
			$re_amount = $amount;
		}
	}
	return $re_amount;
}
function get_three_level_in_group($code)
{
	$db = db_connect();
	$groups = $db->table("groups")->select('*')->whereIn('code', $code)->get()->getResultArray();
	$group_array = array();
	foreach ($groups as $group) {
		$group_array[] = $group['id'];
	}
	$subgroups = $db->table("groups")->select('*')->whereIn('parent_id', $group_array)->get()->getResultArray();
	$subgroup_array = array();
	foreach ($subgroups as $subgroup) {
		$subgroup_array[] = $subgroup['id'];
	}
	// print_r($subgroup_array);
	// die;
	$sub_subgroups = $db->table("groups")->select('*')->whereIn('parent_id', $subgroup_array)->get()->getResultArray();
	$sub_subgroup_array = array();
	foreach ($sub_subgroups as $sub_subgroup) {
		$sub_subgroup_array[] = $sub_subgroup['id'];
	}
	$combine_array = array_merge($group_array, $subgroup_array, $sub_subgroup_array);
	return $combine_array;
}
function getMonthsInRange($startDate, $endDate)
{
	$months = array();
	while (strtotime($startDate) <= strtotime($endDate)) {
		$months[]['date'] = date('Y-m', strtotime($startDate));
		// Set date to 1 so that new month is returned as the month changes.
		$startDate = date('01 M Y', strtotime($startDate . '+ 1 month'));
	}
	return $months;
}
function cal_gregorian($yearmonth)
{
	$convert_date = $yearmonth . "-14";
	$year = date("Y", strtotime($convert_date));
	$month = date("m", strtotime($convert_date));
	$day = cal_days_in_month(CAL_GREGORIAN, $month, $year);
	return $day;
}

function daily_receipt_voucher_withcurrentdate($current_date, $current_date_two, $booking_type = '', $login_id = '')
{
	$db = db_connect();
	$builder = $db->table("entries as e")
		->join('entryitems as ei', 'ei.entry_id = e.id')
		->select("e.dr_total as paidamount,e.payment as paymentmode,e.paid_through, e.paid_to");
	if (!empty($login_id))
		$builder->where("e.entry_by", $login_id);
	if (!empty($booking_type))
		$builder->where("e.paid_through", $booking_type);
	$receipt_voucher_data = $builder->where("DATE_FORMAT(e.date, '%Y-%m-%d') >=", $current_date)
		->where("DATE_FORMAT(e.date, '%Y-%m-%d') <=", $current_date_two)
		->where('e.entrytype_id',1)
		->where('e.inv_id IS NULL')
		->groupBy('ei.entry_id')
		->get()
		->getResultArray();
		//$db->getLastQuery();
	return $receipt_voucher_data;
}
function getpropertyTotalrentalamount($prop_id)
{
	$db = db_connect();
	$tennant_property = $db->query("SELECT tp.due_start_month,tp.end_date,p.rental_value FROM properties as p JOIN tennant_property as tp ON tp.property_id = p.id WHERE tp.property_id = $prop_id ")->getResultArray();
	$month_total_amount = 0;
	foreach($tennant_property as $row){
		$monthcount = monthcount($row['due_start_month'],$row['end_date']);
		$rental_amt = $row['rental_value'];
		$month_total_amount = $month_total_amount + ($monthcount * $rental_amt);
	}
	return $month_total_amount;
}
function getpropertyTotalrentalpaidamount($prop_id)
{
	$db = db_connect();
	$rental_property = $db->query("SELECT SUM(r.amount) as paid_amount FROM rental as r WHERE r.property_id = $prop_id ")->getResultArray();
	$rental_total_amount = 0;
	foreach($rental_property as $row){
		$rental_amt = $row['paid_amount'];
		$rental_total_amount = $rental_total_amount + $rental_amt;
	}
	return $rental_total_amount;
}
function monthcount($fromdate,$todate){

	$date1 = $fromdate;
	$date2 = $todate;

	$ts1 = strtotime($date1);
	$ts2 = strtotime($date2);

	$year1 = date('Y', $ts1);
	$year2 = date('Y', $ts2);

	$month1 = date('m', $ts1);
	$month2 = date('m', $ts2);

	$diff = (($year2 - $year1) * 12) + ($month2 - $month1);

	return $diff+1;
}
if(!function_exists('getpropertyduemonthcount')){
	function getpropertyduemonthcount($ten_prop_id,$prop_id)
{
	$db = db_connect();
	$propery_tennant_details = $db->table('tennant_property')->select('due_start_month,id,end_date')->where('id',$ten_prop_id)->where('tennant_property.status',1)->get()->getResultArray();
	$paid_status = 0;
	$amount_paid = 0;
	if(count($propery_tennant_details) > 0){
		foreach($propery_tennant_details as $row){
			$min_month = date("Y-m", strtotime($row['due_start_month']));
			$start_month = $min_month."-01";
			if($row['end_date'] > date("Y-m-01")){
				$end_month = date("Y-m-01");
			}
			else{
				$end_month = date("Y-m-01", strtotime($row['end_date']));
			}
			
			$available_till_month = getMonthsInRange($start_month,$end_month);
			$ten_prp_id = $row['id'];
			if(count($available_till_month) > 0){
				foreach($available_till_month as $res){
					$check_payment_status = $db->query("SELECT * FROM tennant_property JOIN tennant ON tennant.id = tennant_property.tennant_id JOIN rental ON rental.tenn_prop_id = tennant_property.id  WHERE rental.property_id = $prop_id and rental.tenn_prop_id = $ten_prp_id and rental.month_year = '" . $res['date'] . "' and tennant_property.status = 1 ")->getResultArray();
					if(count($check_payment_status) > 0){
					}
					else{
						$propery_renta_det = $db->query("SELECT rental_value FROM properties WHERE id = $prop_id ")->getResultArray();
						if(count($propery_renta_det) > 0){
							$propery_renta_amt = $propery_renta_det[0]['rental_value'];
						}
						else{
							$propery_renta_amt = 0;
						}
						$amount_paid = $amount_paid + $propery_renta_amt;
						$paid_status = $paid_status + 1;
					}
				}
			}
		}
	}
	return array('unpaid_count'=>$paid_status,'unpaid_amount'=>$amount_paid);
}
}

function getproperty_lastpaidmonth($ten_prop_id,$prop_id)
{
	$db = db_connect();
	$current_monf = date('Y-m');
	$propery_tennant_details = $db->query("SELECT r.month_year FROM tennant_property as tp JOIN rental as r ON r.tenn_prop_id = tp.id WHERE r.property_id = $prop_id and r.tenn_prop_id = $ten_prop_id and DATE_FORMAT(tp.due_start_month,'%Y-%m') < '$current_monf' order by r.month_year DESC ")->getResultArray();
	if(count($propery_tennant_details) > 0){
		$lastpaidmonth = date("M, Y", strtotime($propery_tennant_details[0]['month_year']));
	}
	else{
		$lastpaidmonth = "";
	}
	return $lastpaidmonth;
}
function getproperty_lastpaidmonth_ym($ten_prop_id,$prop_id)
{
	$db = db_connect();
	$current_monf = date('Y-m');
	$propery_tennant_details = $db->query("SELECT r.month_year FROM tennant_property as tp JOIN rental as r ON r.tenn_prop_id = tp.id WHERE r.property_id = $prop_id and r.tenn_prop_id = $ten_prop_id and DATE_FORMAT(tp.due_start_month,'%Y-%m') < '$current_monf' order by r.month_year DESC ")->getResultArray();
	if(count($propery_tennant_details) > 0){
		$lastpaidmonth = date("Y-m", strtotime($propery_tennant_details[0]['month_year']));
	}
	else{
		$lastpaidmonth = "";
	}
	return $lastpaidmonth;
}
function loanperiodendmonths($emi_start_month_paytype_two, $emi_type_paytype_two)
{
	$data_emi_start_month = date("Y-m-01", strtotime($emi_start_month_paytype_two));
	if (!empty($emi_type_paytype_two)) {
		$emi_dedection_one_month = $emi_type_paytype_two - 1;
		$data_emi_end_month = date("Y-m-t", strtotime("+$emi_dedection_one_month months", strtotime($data_emi_start_month)));
	} else {
		$data_emi_end_month = date("Y-m-t", strtotime($emi_start_month_paytype_two));
	}
	return $data_emi_end_month;
}
if(!function_exists('get_default_rental_current_month')){
	function get_default_rental_current_month($ten_prop_id)
	{
		$db = db_connect();
		if (!empty($rental_monthyear)){
			$rental_monthyear = $_POST['rental_monthyear'];
		}
		else{
			$rental_monthyear = date("m/Y");
		}
		$convert_date = explode("/", $rental_monthyear);
		$str_to_date_convert = $convert_date[1] . "-" . $convert_date[0];
		$datalist = $db->query("SELECT tennant.phone as phone_no,tennant.phonecode as areacode,tennant.name as tennant_name, properties.id as property_id, properties.name as property_name,properties.rental_value as amount FROM properties JOIN tennant_property ON tennant_property.property_id = properties.id JOIN tennant ON tennant.id = tennant_property.tennant_id  WHERE DATE_FORMAT(tennant_property.due_start_month,'%Y-%m') <= '$str_to_date_convert' AND DATE_FORMAT(tennant_property.end_date,'%Y-%m') >= '$str_to_date_convert' AND tennant_property.id = '$ten_prop_id' and tennant.status = 1  ")->getResultArray();
		$retn_array = array();
		foreach ($datalist as $roww) {
			$paid_rental = $db->table("rental")->select('SUM(rental.amount) as paidamt')->where("rental.property_id", $roww['property_id'])->where("rental.month_year", $str_to_date_convert)->get()->getRowArray();
			//echo $paid_rental['paidamt'];
			//echo $roww['amount'];
			if (floatval($paid_rental['paidamt']) == floatval($roww['amount']) || floatval($paid_rental['paidamt']) > floatval($roww['amount'])) {
				//echo "Full Paid";
			} else {
				//echo "Half Paid";
				$pending_amt = $roww['amount'] - $paid_rental['paidamt'];
				$due_date = $str_to_date_convert . "-01";
				$converted_month = date("M", strtotime($due_date));
				$phone_with_code = $roww['areacode'] . "" . $roww['phone_no'];
				$retn_array[] = array("phone_no" => $phone_with_code, "tennant_name" => $roww['tennant_name'], "property_id" => $roww['property_id'], "property_name" => $roww['property_name'], "amount" => $roww['amount'], "pending_amount" => $pending_amt, "due_month" => $converted_month);
			}
		}
		//echo $rental_monthyear;
		//exit;
		return $retn_array;
	}
}
function getMonthsInCount($fromdate,$todate){

	$date1 = $fromdate;
	$date2 = $todate;

	$ts1 = strtotime($date1);
	$ts2 = strtotime($date2);

	$year1 = date('Y', $ts1);
	$year2 = date('Y', $ts2);

	$month1 = date('m', $ts1);
	$month2 = date('m', $ts2);

	$diff = (($year2 - $year1) * 12) + ($month2 - $month1);

	return $diff+1;
}

if(!function_exists('changedateFormat')){
    function changedateFormat($format = 'd-m-Y', $originalDate){
        return date($format, strtotime($originalDate));
    }
}

if(!function_exists('booking_calendar_range_year')){
    function booking_calendar_range_year($maxyear){
		$current_date = date('Y-m-d');
		$end_date = date('Y-m-d', strtotime('+'.$maxyear.' years',strtotime($current_date)));
        return $end_date;
    }
}
if(!function_exists('get_overall_temple_block_dates')){
	function get_overall_temple_block_dates()
	{
		$db = db_connect();
		$val = array();
		$result = $db->table("overall_temple_block")->select("date")->get()->getResultArray();
		foreach($result as $row)
		{
			$val[] = date("d-m-Y", strtotime($row['date']));
		}
		$response = json_encode($val);
		return $response;
	}
}

if(!function_exists('history_of_balancing')){
	function history_of_balancing(){
		$db = db_connect();
		$result = $db->query("select sum(dr_total) as dr_total, sum(cr_total) as cr_total from(SELECT COALESCE(sum(if(dr_amount != '', dr_amount, 0)), 0) as dr_total, COALESCE(sum(if(cr_amount != '', cr_amount, 0)), 0) as cr_total FROM `ac_year_ledger_balance` where ac_year_id = 2 UNION ALL SELECT COALESCE(sum(if(dc='D', amount, 0)), 0) as dr_total, COALESCE(sum(if(dc='C', amount, 0)), 0) as cr_total FROM `entryitems` where entry_id in (select id from entries where date BETWEEN '2024-01-01' and '2024-12-31')) a")->getRowArray();
		return $result;
	}
}
if(!function_exists('loop_general_ledger_statement')){
	function loop_general_ledger_statement($ledger,$fdate, $tdate)
	{
		$db = db_connect();
		if(empty($fdate) && empty($tdate)){
            $res = $db->table('entryitems', 'entries')
					->join('entries', 'entries.id = entryitems.entry_id')
					->where('entryitems.ledger_id', $ledger)
					->select('entryitems.*')
					->select('entries.*')
					->orderBy('entries.date', 'ASC')
					->get()
					->getResultArray();
        }else{
            if(empty($tdate)) $tdate = date("Y-m-d");
            $res = $db->table('entryitems', 'entries')
					->join('entries', 'entries.id = entryitems.entry_id')
					->where('entries.date >=', $fdate )
					->where('entries.date <=', $tdate )
					->where('entryitems.ledger_id', $ledger)
					->select('entryitems.*')
					->select('entries.*')
					->orderBy('entries.date', 'ASC')
					->get()
					->getResultArray();
        }
		$ac_id = $db->table("ac_year")->where('status', 1)->get()->getRowArray();
		$op_balance = $db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id',$ledger)->where('ac_year_id',$ac_id['id'])->get()->getRowArray();
		if($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == ""){
			$op_bal -= $op_balance['cr_amount'];
		}else{
			$op_bal = $op_balance['dr_amount'];
		}
		if(!empty($fdate)){
            $date = explode('-', $fdate);
            $m = $date[1]; $de = $date[2]; $y = $date[0];
            $ydate = date('Y-m-d', mktime(0,0,0,$m,($de-1),$y)); 
            $ops = $db->table('entryitems', 'entries')
					->join('entries', 'entries.id = entryitems.entry_id')
					->where('entries.date <=', $ydate )
					->where('entryitems.ledger_id', $ledger)
					->select('entryitems.*')
					->select('entries.*')
					->get()
					->getResultArray();
					
			foreach($ops as $rd){
			    if($rd['dc'] == 'D') $op_bal = $op_bal + $rd['amount'];
                else $op_bal = $op_bal - $rd['amount'];
			}
        }
		$data['op_bal'] = $op_bal;
        $i=0;
        $datas = array();
		foreach($res as $row){
            // Ledger Name
            $getentry = $db->table('entryitems')->where('entry_id', $row['entry_id'])->get()->getResultArray();
            if($getentry[0]['dc'] == 'D') $debit_name = $db->table('ledgers')->where('id', $getentry[0]['ledger_id'])->get()->getRowArray();
            else $debit_name = $db->table('ledgers')->where('id', $getentry[1]['ledger_id'])->get()->getRowArray();
            
            if($getentry[0]['dc'] == 'C') $credit_name = $db->table('ledgers')->where('id', $getentry[0]['ledger_id'])->get()->getRowArray();
            else $credit_name = $db->table('ledgers')->where('id', $getentry[1]['ledger_id'])->get()->getRowArray();

            $ledger =  $debit_name['name'].' / Cr '.$credit_name['name'];

            //Credit Amount
            if(!empty($row['amount'])) $amount = $row['amount'];
            else $amount = 0;
            if($row['dc'] == 'D'){
				$debit = str_replace('-0', '0', number_format($amount, '2','.',','));
				$debit_amount = $amount;
            }else{
				$debit = '';
				$debit_amount = 0.00;
			}

            if($row['dc'] == 'C'){
				$credit = str_replace('-0', '0', number_format($amount, '2','.',','));
				$credit_amount = $amount;
            }else{
				$credit = '';
				$credit_amount = 0.00;
			}
            //Balance Amount
            if($row['dc'] == 'C') $op_bal -= $amount;
            else $op_bal +=  $amount;
            //Report Data
            $datas[$i]['date']      = $row['date'];
            $datas[$i]['entry_code']      = $row['entry_code'];
            $datas[$i]['entry_id']      = $row['entry_id'];
            $datas[$i]['entrytype_id']      = $row['entrytype_id'];
            $datas[$i]['inv_id']      = $row['inv_id'];
            $datas[$i]['ledger']    = $ledger;
            $datas[$i]['debit']     = $debit;
            $datas[$i]['debit_amount']     = $debit_amount;
            $datas[$i]['credit']    = $credit;
            $datas[$i]['credit_amount']    = $credit_amount;
            $datas[$i]['balance']   = $op_bal;
            $i++;
        }
		$data['cl_bal'] = $op_bal;
        $data['data'] = $datas;
		return $data;

	}
}

if(!function_exists('ledgercode_accountname')){
	function ledgercode_accountname($entid,$type,$ledgerid=""){
		$db = db_connect();
		$result = $db->table('entryitems ei')
							->join('ledgers l','l.id = ei.ledger_id')
							->select('l.left_code,l.right_code, l.name as ledger_name,ei.amount as led_amt')
							->where('ei.entry_id',$entid)
							->where('ei.dc',$type);
		if(!empty($ledgerid)){
			$result = $result->where('ei.ledger_id', $ledgerid);
		}
		$result = $result->get()->getRowArray();
		return $result;
	}
}

if (!function_exists('get_data_from_entries')) {
    function get_data_from_entries($fromMonthYear, $toMonthYear)
    {
        $db = db_connect(); // Connect to the database

        // Convert month-year strings to proper date formats
        $fromDate = date('Y-m-01', strtotime($fromMonthYear)); 
        $toDate = date('Y-m-t', strtotime($toMonthYear)); 

        // SQL query to fetch data from entries table including narration
        $sql = "SELECT id, date, narration FROM entries WHERE date BETWEEN ? AND ?";

        // Execute the query with parameters
        $query = $db->query($sql, [$fromDate, $toDate]);
        $results = $query->getResultArray();

        // Process each result to format the narration
        foreach ($results as &$entry) {
            // Remove content inside parentheses and extract the first line
            $narration = $entry['narration'];
            if (preg_match('/^(.*?)\s*\([^)]*\)/', $narration, $matches)) {
                $entry['narration'] = trim($matches[1]); // Get the first line without content in parentheses
            } else {
                // If there are no parentheses, just take the whole narration
                $entry['narration'] = trim($narration);
            }
        }

        // Return the results
        return $results;
    }
}


if (!function_exists('get_entry_items_by_entry_ids')) {
    function get_entry_items_by_entry_ids($entryIds)
    {
        $db = db_connect(); // Connect to the database

        // Ensure the entryIds is an array
        if (!is_array($entryIds) || empty($entryIds)) {
            return [];
        }

        // Convert entryIds array to comma-separated string
        $entryIdsStr = implode(',', $entryIds);

        // SQL query to fetch entry_id, ledger_id, and amount from entryitems table
        $sql = "SELECT id, entry_id, ledger_id, amount FROM entryitems WHERE entry_id IN ($entryIdsStr)";

        // Execute the query
        $query = $db->query($sql);

        if (!$query) {
            // Log the error if the query failed
            log_message('error', 'Query failed: ' . $db->error()['message']);
            return [];
        }

        $results = $query->getResultArray();

        // Return the results
        return $results;
    }
}

if (!function_exists('get_all_groups')) {
    function get_all_groups()
    {
        $db = db_connect(); // Connect to the database

        // SQL query to fetch id and name from groups table
        $sql = "SELECT id, name FROM groups";

        // Execute the query
        $query = $db->query($sql);
        $results = $query->getResultArray();

        // Return the results
        return $results;
    }
}

if (!function_exists('get_all_ledgers')) {
    function get_all_ledgers()
    {
        $db = db_connect(); // Connect to the database

        // SQL query to fetch id, name, and group_id from ledgers table
        $sql = "SELECT id, name, group_id FROM ledgers";

        // Execute the query
        $query = $db->query($sql);
        $results = $query->getResultArray();

        // Return the results
        return $results;
    }
}


