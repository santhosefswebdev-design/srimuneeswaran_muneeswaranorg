<title><?php echo $_SESSION['site_title']; ?></title>
<?php        
$db = db_connect();
?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Barlow&display=swap" rel="stylesheet">
<style>
body { font-family: 'Barlow', sans-serif; }
.tbor, th{
    border: 1px solid;
}
table th
{
    background-color: #fff !important;
    color: #444242;
}
table { border-collapse:collapse; }
table td, table th { padding:5px; }
.inner_table tr:nth-child(even) { background:#F3F3F3; }
.inner_table tr:last-child { background:#e2dfdf; }
.paid_text { color:green; font-weight:600; }
.unpaid_text { color:blue; font-weight:600; }
.cancel_text { color:red; font-weight:600; }
</style>

<table align="center" style="width: 100%;max-width: 800px;">
<tr><td colspan="2">
	<table border="1" align="center" style="border-collapse: collapse; width: 100%;">
	<tbody>
		<tr>
			<td width="15%" style="border: 1px solid #000; vertical-align: top;">
				<img src="<?php echo base_url(); ?>/uploads/main/<?php echo $temp_details['image']; ?>" style="width:120px;" align="left">
			</td>
			<td width="85%" style="padding: 0px; border: 1px solid #000;">
				<table style="width: 100%; border-collapse: collapse;">
					<tr>
						<td>
							<h2 style="text-align:center; margin-bottom: 0; font-size: 18px;">
								<?php echo $temp_details['name']; ?>
							</h2>
						</td>
					</tr>
					<tr>
						<td>
							<p style="text-align:center; font-size:16px; margin:0;">
								<?php echo $temp_details['address1']; ?>, <?php echo $temp_details['address2']; ?>
							</p>
						</td>
					</tr>
					<tr>
						<td>
							<p style="text-align:center; font-size:16px; margin:0;">
								<?php echo $temp_details['city'] . '-' . $temp_details['postcode']; ?>
							</p>
						</td>
					</tr>
					<tr>
						<td>
							<p style="text-align:center; font-size:16px; margin:0;">
								Tel : <?= $temp_details['telephone']; ?>
							</p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<?php if ($report_type == 1) {
				$file_name = "HALLBOOKING REPORT";
			} else {
				$file_name = "UBAYAM REPORT";
			} ?>
		<tr>
			<td colspan="2" style="width: 100%;">
				<h3 style="text-align:center;"> <?php echo strtoupper($file_name).' '. date("d/m/Y", strtotime($fdate)).' - '.date("d/m/Y", strtotime($tdate)); ?></h3>
			</td>
		</tr>
	</tbody>
</table>

</td></tr>
<tr><td colspan="2"><hr></td></tr>
</table>

<table border="1" width="100%" align="center">
    <thead>
        <tr>
            <th width="4%">S.No</th>
            <th align="left" width="9%">Booking Date</th>
            <th align="left" width="9%">Event Date</th>
            <th align="left" width="10%">Ref No</th>
            <th align="left" width="18%">Event Name</th>
            <th align="left" width="15%">Name</th>
            <th align="right" width="8%">Amount</th>
            <th align="right" width="8%">Paid</th>
            <th align="right" width="8%">Balance</th>
            <th align="left" width="12%">Remarks</th>
            <th align="right" width="7%">Status</th>
        </tr>
    </thead>
    <tbody>
     
    <?php 
		$total_amount = 0;
		$total_paid = 0;
		$total_balance = 0;
		
		$fdt = date('Y-m-d', strtotime($fdate));
		$tdt = date('Y-m-d', strtotime($tdate));
		$cdt = null;
		if (!empty($cdate)) {
			$cdt = date('Y-m-d', strtotime($cdate));
		}
		
		$group_filter_fill = $group_filter;
		$booking_type_val = $booking_type;
		
		$dat = $db->table('templebooking')
			->join('booked_packages', 'booked_packages.booking_id = templebooking.id')
			->select('booked_packages.name as pname')
			->select('templebooking.*')
			->where('templebooking.booking_type', $booking_type_val)
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
		
		$sn = 1;
		foreach($results as $row) {
			// Get actual paid amount from booked_pay_details
			$getpaid = $db->table("booked_pay_details")
				->selectSum('amount')
				->where("booking_id", $row['id'])
				->get()
				->getRowArray();
			
			$paidAmount = (float) ($getpaid['amount'] ?? 0);
			$balance_amount = (float) $row['total_amount'] - $paidAmount;
			
			if($balance_amount < 0) {
				$balance_amount = 0;
			}
			
			// Calculate totals
			$total_amount += (float) $row['total_amount'];
			$total_paid += $paidAmount;
			$total_balance += $balance_amount;
			
			// Determine status
			if ($row['booking_status'] == 3) {
				$status = 'Cancelled';
			} else {
				if (empty($balance_amount)) {
					$status = 'Paid';
				} elseif ($paidAmount > 0) {
					$status = 'Partially Paid';
				} else {
					$status = 'Only Booked';
				}
			}
	?>
	<tr>
		<td align="center"><?php echo $sn++; ?></td>
        <td><?php echo date('d-m-Y', strtotime($row['entry_date'])); ?></td>
        <td><?php echo date('d-m-Y', strtotime($row['booking_date'])); ?></td>
        <td><?php echo $row['ref_no'] ?? '-'; ?></td>
        <td><?php echo $row['pname']; ?></td>
        <td><?php echo $row['name']; ?></td>
        <td align="right"><?php echo number_format($row['total_amount'], 2); ?></td>
        <td align="right"><?php echo number_format($paidAmount, 2); ?></td>
        <td align="right"><?php echo number_format($balance_amount, 2); ?></td>
        <td><?php echo $row['description'] ?? '-'; ?></td>
        <td align="center"><?php echo $status; ?></td>
	</tr>
	<?php } ?>
	
	<!-- Totals Row -->
	<tr style="background-color: #e2dfdf; font-weight: bold;">
		<td colspan="6" align="right">TOTAL:</td>
		<td align="right"><?php echo number_format($total_amount, 2); ?></td>
		<td align="right"><?php echo number_format($total_paid, 2); ?></td>
		<td align="right"><?php echo number_format($total_balance, 2); ?></td>
		<td colspan="2"></td>
	</tr>

    </tbody>
</table>

<script>
window.print();
</script>