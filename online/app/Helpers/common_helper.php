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
function total_group_amt_new_rightcode_triplezero($id, $sdate = '', $tdate = '')
{
	$db = db_connect();
	$sub_tot = 0;
	$tot_groups = $db->table('groups')->where('parent_id', $id)->get()->getResult();
	if ($tot_groups) {
		foreach ($tot_groups as $tr) {
			$sub_tot += get_group_amt_new_rightcode_triplezero($tr->id, $sdate, $tdate);
		}
	}
	return $sub_tot;
}
function get_group_amt_new_rightcode_triplezero($id, $sdate = '', $tdate = '')
{
	$db = db_connect();
	@$group_amt += get_ledgers_amt_new_rightcode_triplezero($id, $sdate, $tdate);
	$groups = $db->table('groups')->where('parent_id', $id)->get()->getResult();
	if ($groups) {
		foreach ($groups as $r) {
			$group_amt += get_ledgers_amt_new_rightcode_triplezero($r->id, $sdate, $tdate);
			get_group_amt_new_rightcode_triplezero($r->id, $sdate, $tdate);
		}
	}
	return $group_amt;
}
function total_group_amt_new_rightcode_triplezero_previousyear($id, $sdate = '', $tdate = '')
{
	$db = db_connect();
	$sub_tot = 0;
	$tot_groups = $db->table('groups')->where('parent_id', $id)->get()->getResult();
	if ($tot_groups) {
		foreach ($tot_groups as $tr) {
			$sub_tot += get_group_amt_new_rightcode_triplezero_previousyear($tr->id, $sdate, $tdate);
		}
	}
	return $sub_tot;
}
function get_group_amt_new_rightcode_triplezero_previousyear($id, $sdate = '', $tdate = '')
{
	$db = db_connect();
	@$group_amt += get_ledgers_amt_new_rightcode_triplezero_previousyear($id, $sdate, $tdate);
	$groups = $db->table('groups')->where('parent_id', $id)->get()->getResult();
	if ($groups) {
		foreach ($groups as $r) {
			$group_amt += get_ledgers_amt_new_rightcode_triplezero_previousyear($r->id, $sdate, $tdate);
			get_group_amt_new_rightcode_triplezero_previousyear($r->id, $sdate, $tdate);
		}
	}
	return $group_amt;
}
function get_ledgers_amt_new_rightcode_triplezero_previousyear($id, $sdate = '', $tdate = '')
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
function get_ledger_amt_new_rightcode_triplezero($id, $sdate = '', $tdate = '')
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
	$op_balance -= get_ledger_cr_amt_new_rightcode_triplezero($id, $sdate, $tdate);
	$op_balance += get_ledger_dr_amt_new_rightcode_triplezero($id, $sdate, $tdate);
	return $op_balance;
}
function get_ledger_amt_new_rightcode_triplezero_previousyear($id, $sdate = '', $tdate = '')
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
	return $op_balance;
}
function get_ledgers_amt_new_rightcode_triplezero($id, $sdate = '', $tdate = '')
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
			$op_balance -= get_ledger_cr_amt_new_rightcode_triplezero($op->id, $sdate, $tdate);
			$op_balance += get_ledger_dr_amt_new_rightcode_triplezero($op->id, $sdate, $tdate);
		}
	}
	return $op_balance;
}
// this function not required but subtotal without zero check plus and minus included
function get_ledger_amt_new_rightcode_triplezero_subtotal($id, $sdate = '', $tdate = '')
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
	$op_balance += get_ledger_cr_amt_new_rightcode_triplezero($id, $sdate, $tdate);
	$op_balance += get_ledger_dr_amt_new_rightcode_triplezero($id, $sdate, $tdate);
	return $op_balance;
}
function get_group_amt_new_rightcode_triplezero_subtotal($id, $sdate = '', $tdate = '')
{
	$db = db_connect();
	@$group_amt += get_ledgers_amt_new_rightcode_triplezero_subtotal($id, $sdate, $tdate);
	$groups = $db->table('groups')->where('parent_id', $id)->get()->getResult();
	if ($groups) {
		foreach ($groups as $r) {
			$group_amt += get_ledgers_amt_new_rightcode_triplezero_subtotal($r->id, $sdate, $tdate);
			get_group_amt_new_rightcode_triplezero_subtotal($r->id, $sdate, $tdate);
		}
	}
	return $group_amt;
}
function get_ledgers_amt_new_rightcode_triplezero_subtotal($id, $sdate = '', $tdate = '')
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
			$op_balance += get_ledger_cr_amt_new_rightcode_triplezero($op->id, $sdate, $tdate);
			$op_balance += get_ledger_dr_amt_new_rightcode_triplezero($op->id, $sdate, $tdate);
		}
	}
	return $op_balance;
}
function get_ledger_cr_amt_new_rightcode_triplezero($id, $sdate = '', $tdate = '')
{
	$db = db_connect();
	$led_ids = get_ledger_ids_leftcode($id);
	if (!empty($led_ids)) {
		$c_sql = "select sum(entryitems.amount) as amount 
				from entryitems 
				inner join entries on entries.id = entryitems. entry_id
				where entryitems.dc = 'C' and entryitems.ledger_id IN($led_ids) and entries.date >= '$sdate' and entries.date <= '$tdate'";
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
function get_ledger_dr_amt_new_rightcode_triplezero($id, $sdate = '', $tdate = '')
{
	$db = db_connect();
	$led_ids = get_ledger_ids_leftcode($id);
	if (!empty($led_ids)) {
		$d_sql = "select sum(entryitems.amount) as amount 
					from entryitems 
					inner join entries on entries.id = entryitems. entry_id
					where entryitems.dc = 'D' and entryitems.ledger_id IN($led_ids) and entries.date >= '$sdate' and entries.date <= '$tdate'";
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
function get_ledger_amt_new_rightcode_triplezero_single($id, $sdate = '', $tdate = '')
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
	$op_balance -= get_ledger_cr_amt_new_rightcode_triplezero_single($id, $sdate, $tdate);
	$op_balance += get_ledger_dr_amt_new_rightcode_triplezero_single($id, $sdate, $tdate);
	return $op_balance;
}
function get_ledger_cr_amt_new_rightcode_triplezero_single($id, $sdate = '', $tdate = '')
{
	$db = db_connect();
	if (!empty($id)) {
		$c_sql = "select sum(entryitems.amount) as amount 
				from entryitems 
				inner join entries on entries.id = entryitems. entry_id
				where entryitems.dc = 'C' and entryitems.ledger_id = '$id' and entries.date >= '$sdate' and entries.date <= '$tdate'";
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
function get_ledger_dr_amt_new_rightcode_triplezero_single($id, $sdate = '', $tdate = '')
{
	$db = db_connect();
	if (!empty($id)) {
		$d_sql = "select sum(entryitems.amount) as amount 
					from entryitems 
					inner join entries on entries.id = entryitems. entry_id
					where entryitems.dc = 'D' and entryitems.ledger_id = '$id' and entries.date >= '$sdate' and entries.date <= '$tdate'";
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
function get_ledger_amt_new_rightcode_triplezero_subtotal_multiplejobcode($id, $sdate = '', $tdate = '')
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
	$op_balance += get_ledger_cr_amt_new_rightcode_triplezero($id, $sdate, $tdate);
	$op_balance += get_ledger_cr_amt_new_rightcode_triplezero($id, $sdate, $tdate);
	return $op_balance;
}
function get_group_amt_new_rightcode_triplezero_subtotal_multiplejobcode($id, $sdate = '', $tdate = '')
{
	$db = db_connect();
	@$group_amt += get_ledgers_amt_new_rightcode_triplezero_subtotal_multiplejobcode($id, $sdate, $tdate);
	$groups = $db->table('groups')->where('parent_id', $id)->get()->getResult();
	if ($groups) {
		foreach ($groups as $r) {
			$group_amt += get_ledgers_amt_new_rightcode_triplezero_subtotal_multiplejobcode($r->id, $sdate, $tdate);
			get_group_amt_new_rightcode_triplezero_subtotal_multiplejobcode($r->id, $sdate, $tdate);
		}
	}
	return $group_amt;
}
// this function not required but subtotal without zero check plus and minus included
function get_ledgers_amt_new_rightcode_triplezero_subtotal_multiplejobcode($id, $sdate = '', $tdate = '')
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
			$op_balance += get_ledgers_amt_new_rightcode_triplezero($op->id, $sdate, $tdate);
			$op_balance += get_ledgers_amt_new_rightcode_triplezero($op->id, $sdate, $tdate);
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
function hallbooking_charts()
{
	$jan = hallbooking_monthwise_count($month = "01");
	$feb = hallbooking_monthwise_count($month = "02");
	$mar = hallbooking_monthwise_count($month = "03");
	$apr = hallbooking_monthwise_count($month = "04");
	$may = hallbooking_monthwise_count($month = "05");
	$jun = hallbooking_monthwise_count($month = "06");
	$jul = hallbooking_monthwise_count($month = "07");
	$aug = hallbooking_monthwise_count($month = "08");
	$sep = hallbooking_monthwise_count($month = "09");
	$oct = hallbooking_monthwise_count($month = "10");
	$nov = hallbooking_monthwise_count($month = "11");
	$dec = hallbooking_monthwise_count($month = "12");
	$rtn_arry = array($jan, $feb, $mar, $apr, $may, $jun, $jul, $aug, $sep, $oct, $nov, $dec);
	return json_encode($rtn_arry);
}


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
				$payment_mode = $db->table('payment_mode')->where('id', $row['payment_mode'])->get()->getRowArray();
				$paymentname = $payment_mode['name'];
			} else {
				if ($row['payment_mode'] == "ipay_merch_qr") {
					$paymentname = "QR PAYMENT";
				} elseif ($row['payment_mode'] == "ipay_merch_online") {
					$paymentname = "ONLINE PAYMENT";
				} elseif ($row['payment_mode'] == "cash") {
					$paymentname = "CASH";
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






function hallbooking_monthwise_count($month)
{
	$db = db_connect();
	$current_year = date('Y');
	$hallbooking_charts = $db->query("SELECT COUNT(id) AS count FROM hall_booking where YEAR(booking_date) = $current_year AND MONTH(booking_date) = $month ")->getResultArray();
	if (count($hallbooking_charts) > 0) {
		$countdata = intVal($hallbooking_charts[0]['count']);
	} else {
		$countdata = 0;
	}
	return $countdata;
}
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


function daily_archanai_booking_withcurrentdate($current_date,$current_date_two,$booking_type = '', $login_id = '')
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
	$query = $db->query("select a.archanai_id, a.archanai_booking_id, sum(a.quantity) as qunty, sum(a.total_amount) as amt, sum(a.total_commision) as comm, count(a.archanai_id) as cnt, b.paid_through, (case when b.paid_through = 'DIRECT' then b.payment_mode else c.pay_method end) as payment_mode from archanai_booking_details a left join archanai_booking b on b.id = a.archanai_booking_id left join archanai_payment_gateway_datas c on c.archanai_booking_id = b.id where b.date >= '$current_date' and b.date <= '$current_date_two' $where and (b.payment_status not in(1,3) or b.payment_status is NULL) group by payment_mode, b.paid_through, a.archanai_id having count(a.archanai_id) > 0");
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
				if ($row['payment_mode'] == "ipay_merch_qr") {
					$paymentname = "QR PAYMENT";
				} elseif ($row['payment_mode'] == "ipay_merch_online") {
					$paymentname = "ONLINE PAYMENT";
				} elseif ($row['payment_mode'] == "cash") {
					$paymentname = "CASH";
				}

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
	$query = $db->query("select a.archanai_id, a.archanai_booking_id, a.diety_id, ad.name as diety_name, sum(a.quantity) as qunty, sum(a.total_amount) as amt, sum(a.total_commision) as comm, count(a.archanai_id) as cnt, b.paid_through, (case when b.paid_through = 'DIRECT' then b.payment_mode else c.pay_method end) as payment_mode from archanai_booking_details a left join archanai_booking b on b.id = a.archanai_booking_id left join archanai_payment_gateway_datas c on c.archanai_booking_id = b.id left join archanai_diety ad on ad.id = a.diety_id where b.date >= '$current_date' and b.date <= '$current_date_two' $where and (b.payment_status not in(1,3) or b.payment_status is NULL) group by payment_mode, b.paid_through, a.archanai_id, a.diety_id having count(a.archanai_id) > 0 order by a.diety_id");
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
				if ($row['payment_mode'] == "ipay_merch_qr") {
					$paymentname = "QR PAYMENT";
				} elseif ($row['payment_mode'] == "ipay_merch_online") {
					$paymentname = "ONLINE PAYMENT";
				} elseif ($row['payment_mode'] == "cash") {
					$paymentname = "CASH";
				}

			}
			$archanai_data[$row['diety_id']]['title'] = $row['diety_name'];
			$archanai_data[$row['diety_id']]['data'][] = array(
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



function daily_hall_booking_withcurrentdate($current_date,$current_date_two,$booking_type = '', $login_id = '')
{
	$db = db_connect();
	$builder = $db->table("hall_booking as hb")
		->join('hall_booking_pay_details as hbp', 'hbp.hall_booking_id = hb.id')
		->join('payment_mode as pm', 'pm.id = hbp.payment_mode')
		->join('hall_booking_service_details as hbd', 'hbd.hall_booking_id = hb.id')
		->join('hall_booking_payment_gateway_datas as hbpgd', 'hbpgd.hall_booking_id = hb.id', 'left')
		->select("hbp.amount as paidamount,hb.event_name, hb.name as person_name,(case when hb.paid_through = 'DIRECT' then pm.name else hbpgd.pay_method end) as paymentmode,hb.paid_through");
	if (!empty($login_id))
		$builder->where("hb.entry_by", $login_id);
	if (!empty($booking_type))
		$builder->where("hb.paid_through", $booking_type);
	$hallbooking_data = $builder->where("DATE_FORMAT(hbp.date, '%Y-%m-%d') >=", $current_date)
								->where("DATE_FORMAT(hbp.date, '%Y-%m-%d') <=", $current_date_two)
		->groupStart()
		->whereNotIn("hb.payment_status", array(1, 3))
		->Orwhere('hb.payment_status IS NULL')
		->groupEnd()
		->whereIn("hb.status", array(1, 2))
		->groupBy('hb.id')
		->groupBy('hbp.payment_mode')
		->get()
		->getResultArray();
	return $hallbooking_data;
}
function daily_ubayam_withcurrentdate($current_date,$current_date_two,$booking_type = '', $login_id = '')
{
	$db = db_connect();
	$builder = $db->table("ubayam as u")
		->join('ubayam_setting as us', 'us.id = u.pay_for')
		->join('ubayam_pay_details as upd', 'upd.ubayam_id = u.id', 'left')
		->join('payment_mode as pm', 'pm.id = upd.payment_mode', 'left')
		->join('ubayam_payment_gateway_datas as upgd', 'upgd.ubayam_id = u.id', 'left')
		->select("upd.amount as paidamount, us.name as package_name,u.name as person_name,(case when u.paid_through = 'DIRECT' then pm.name else upgd.pay_method end) as paymentmode, u.paid_through");
	if (!empty($login_id))
		$builder->where("u.added_by", $login_id);
	if (!empty($booking_type))
		$builder->where("u.paid_through", $booking_type);
	$ubayam_data = $builder->where("DATE_FORMAT(upd.date, '%Y-%m-%d') >=", $current_date)
							->where("DATE_FORMAT(upd.date, '%Y-%m-%d') <=", $current_date_two)
		->groupStart()
		->whereNotIn("u.payment_status", array(1, 3))
		->Orwhere('u.payment_status IS NULL')
		->groupEnd()
		->groupBy('u.id')
		->get()
		->getResultArray();
	/* echo $db->getLastQuery();
				die; */
	return $ubayam_data;
}
function daily_donation_withcurrentdate($current_date,$current_date_two,$booking_type = '', $login_id = '')
{
	$db = db_connect();
	$builder = $db->table("donation as d")
		->join('donation_setting as ds', 'ds.id = d.pay_for')
		->join('payment_mode as pm', 'pm.id = d.payment_mode', 'left')
		->join('donation_payment_gateway_datas as dpgd', 'dpgd.donation_booking_id = d.id', 'left')
		->select("d.amount as paidamount, ds.name as package_name,d.name as person_name,(case when d.paid_through = 'DIRECT' then pm.name else dpgd.pay_method end) as paymentmode, d.paid_through");
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
function daily_prasadam_withcurrentdate($current_date,$current_date_two,$booking_type = '', $login_id = '') {
	$db = db_connect();
	$builder = $db->table("prasadam as p")
									->join('prasadam_booking_details as pbd', 'pbd.prasadam_booking_id = p.id')
									->join('prasadam_setting as ps', 'ps.id = pbd.prasadam_id')
									->join('payment_mode as pm', 'pm.id = p.payment_mode', 'left')
									->join('prasadam_payment_gateway_datas as ppgd', 'ppgd.prasadam_id = p.id', 'left')
									->select("p.amount as paidamount, ps.name_eng as package_name,p.customer_name as person_name,(case when p.paid_through = 'DIRECT' then pm.name else ppgd.pay_method end) as paymentmode, p.paid_through");
	if(!empty($login_id)) $builder->where("p.added_by", $login_id);
	if(!empty($booking_type)) $builder->where("p.paid_through", $booking_type);
	$prasadam_data = 	$builder->where("DATE_FORMAT(p.date, '%Y-%m-%d') >=", $current_date)
								->where("DATE_FORMAT(p.date, '%Y-%m-%d') <=", $current_date_two)
					->groupStart()
						->whereNotIn("p.payment_status", array(1,3))
						->Orwhere('p.payment_status IS NULL')
					->groupEnd()
					->groupBy('p.id')
					->get()
					->getResultArray();
	return $prasadam_data;
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
	$data['apiKey'] = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjY1Njg0MGI1M2Y0NmRlMGJlMWFmYmYzNyIsIm5hbWUiOiJHUkFTUCBTT0ZUV0FSRSBTT0xVVElPTlMiLCJhcHBOYW1lIjoiQWlTZW5zeSIsImNsaWVudElkIjoiNjU2ODQwYjQzZjQ2ZGUwYmUxYWZiZjMyIiwiYWN0aXZlUGxhbiI6IkJBU0lDX01PTlRITFkiLCJpYXQiOjE3MDEzMzExMjV9.FiR2rGZ_AAlhSfSJ08evlCHddlsjg8UQuH72sCWefx0';
	$data['campaignName'] = $template_name;
	$data['destination'] = $number;
	$data['userName'] = 'prithivibiz004';
	$data['templateParams'] = $templateParams;
	if (!empty($media))
		$data['media'] = $media;
	$url = 'https://backend.aisensy.com/campaign/t1/api/v2';
	$ch = curl_init($url);
	# Setup request to send json via POST.
	$payload = json_encode($data);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
	# Return response instead of printing.
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	# Send request.
	$result = curl_exec($ch);
	curl_close($ch);
	# Print response.
	//echo "<pre>$result</pre>";
	return json_decode($result, true);
}
	if (!function_exists('getMonthName'))
	{
		function getMonthName($month = "")
		{
			if($month == "01" || $month == "1")
			{
				$monthname = "january";
			}
			if($month == "02" || $month == "2")
			{
				$monthname = "february";
			}
			if($month == "03" || $month == "3")
			{
				$monthname = "march";
			}
			if($month == "04" || $month == "4")
			{
				$monthname = "april";
			}
			if($month == "05" || $month == "5")
			{
				$monthname = "may";
			}
			if($month == "06" || $month == "6")
			{
				$monthname = "june";
			}
			if($month == "07" || $month == "7")
			{
				$monthname = "july";
			}
			if($month == "08" || $month == "8")
			{
				$monthname = "august";
			}
			if($month == "09" || $month == "9")
			{
				$monthname = "september";
			}
			if($month == "10")
			{
				$monthname = "october";
			}
			if($month == "11")
			{
				$monthname = "november";
			}
			if($month == "12")
			{
				$monthname = "december";
			}
			return $monthname;
		}
	}