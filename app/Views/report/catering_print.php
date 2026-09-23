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
    background-color: #ffffff !important;
    color: #000000;

}
table { border-collapse:collapse; }
table td, table th { padding:5px; }
.inner_table tr:nth-child(even) { background:#F3F3F3; }
.inner_table tr:last-child { background:#e2dfdf; }
.paid_text { color:green; font-weight:600; }
.unpaid_text { color:red; font-weight:600; }
</style>

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
								<?php echo $temp_details['city'].'-'.$temp_details['postcode']; ?>
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
		<tr>
			<td colspan="2" style="width: 100%;">
				<h3 style="text-align:center;"> CATERING REPORT <?php echo date("d/m/Y", strtotime($fdate)).' - '.date("d/m/Y", strtotime($tdate)); ?></h3>
			</td>
		</tr>
	</tbody>
</table>


<table border="1" width="100%" align="center">
    <thead>
		<tr>
			<th style="width:5%;">S.No</th>
            <th style="width:10%;">Date</th>
            <th style="width:10%;">Invoice No</th>
            <th style="width:10%;">Name</th>
            <th style="width:20%;">Event Date</th>
			<th style="text-align: right; width:15%;">Paid Amount(S$)</th>
            <th style="text-align: right; width:15%;">Total Amount(S$)</th>
    	</tr>
    </thead>
    <tbody>
     
    <?php 
		$fdt= date('Y-m-d',strtotime($fdate));
		$tdt= date('Y-m-d',strtotime($tdate));
		
		$data = [];
		$qry = $db->table('annathanam_new a')
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


		$sn=1;
		foreach($dat as $row) {
		
		$amt=$row['total_amount'];
		$paid_amt=$row['paid_amount'];
		$bal_amt = $amt - $paid_amt;
		$rowClass = $row['booking_status'] == 3 ? 'cancelled-row' : '';
		?>
			<tr>
				<td><?php echo $sn++; ?></td>
				<td><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>
				<td><?php echo $row['ref_no']; ?></td>
				<td><?php echo $row['name']; ?></td>
				<td><?php echo date('d-m-Y', strtotime($row['event_date'])); ?></td>
				<td align="right"><?php echo $row['paid_amount']; ?></td>
				<td align="right"><?php echo $row['total_amount']; ?></td>
			</tr>
	<?php } ?>   

    </tbody>
</table>
<script>
window.print();
</script>


