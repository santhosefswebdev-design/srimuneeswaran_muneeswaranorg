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
				<h3 style="text-align:center;"> MADAPALLI REPORT - <?php echo date("d/m/Y", strtotime($from_date)); ?></h3>
			</td>
		</tr>
	</tbody>
</table>

<h3 style="text-align:center;">--- Prasadam Details ---</h3>
<?php foreach($prasadam as $key => $session) { ?>
	<h4 style="text-align: center"><?php echo $key ?></h4><br>
	<table border="1" width="100%" align="center">
		<thead>
			<tr>
				<th style="width:5%;text-align: center;">S.No</th>
				<th style="width:8%;text-align: center;">Products</th>
				<th style="width:9%;text-align: center;">Quantity</th>
				<th style="width:12%;text-align: center;">Preparation Time</th>
				<th style="width:15%;text-align: center;">Serving Time</th>
			</tr>
		</thead>
		<tbody>

		<?php $sn = 1; foreach($session as $row) { ?>
			<tr>
				<td style='text-align: center;'><?php echo $sn++; ?></td>
				<td style='text-align: center;'><?php echo $row['name']; ?></td>
				<td style='text-align: center;'> <?php echo $row ['quantity']; ?></td>
				<?php if ($row['session'] == 'AM') $prep = "AM";
				else $prep = "PM"; ?>
				<td style='text-align: center;'><?php echo $prep; ?></td>
				<td style='text-align: center;'><?php echo !empty($row['session']) ?  $row['session'] : '-'; ?></td>
			</tr>
		<?php } ?>

		</tbody>
	</table><br>
<?php } ?>

<h3 style="text-align:center;">--- Annathanam Details ---</h3>
<?php foreach($annathanam as $key => $session) { ?>
	<h4 style="text-align:center;"><?php echo $key; ?></h4>
	<table border="1" width="100%" align="center">
		<thead>
			<tr>
				<th style="width:5%;text-align: center;">S.No</th>
				<th style="width:8%;text-align: center;">Products</th>
				<th style="width:9%;text-align: center;">Quantity</th>
				<th style="width:12%;text-align: center;">Preparation Time</th>
				<th style="width:15%;text-align: center;">Serving Time</th>
			</tr>
		</thead>
		<tbody>

		<?php $sn = 1; foreach($session as $row) { ?>
			<tr>
				<td style='text-align: center;'><?php echo $sn++; ?></td>
				<td style='text-align: center;'><?php echo $row['name']; ?></td>
				<td style='text-align: center;'> <?php echo $row ['quantity']; ?></td>
				<?php if ($row['session'] == 'Breakfast') $prep = "AM";
				elseif ($row['session'] == 'Lunch') $prep = "AM";
				else $prep = "PM" ?>
				<td style='text-align: center;'><?php echo $prep; ?></td>
				<td style='text-align: center;'><?php echo !empty($row['session']) ?  $row['session'] : '-'; ?></td>
			</tr>
		<?php } ?>

		</tbody>
	</table>
<?php } ?>

<?php if (!empty($additional['annathanam'])) { ?>
	<h3 style="text-align: center">Additional Items</h3><br>
	<?php 
	foreach($additional['annathanam'] as $key => $session) { ?>
		<h4 style="text-align: center"><?php echo $key ?></h4><br>
		<table style="width:100%;" align="center" class="table table-striped dataTable" id="datatables">
			<thead>
				<tr>
					<th style="width:10%;">S.No</th>
					<th style="width:20%;">Products</th>
					<th style="width:30%;">Quantity</th>
					<th style="width:20%;">Session</th>
					<th style="width:20%;">Details</th>
				</tr>
			</thead>
			<tbody>
				<?php $i = 1; foreach($session as $row) { ?>
				<tr>
					<td><?php echo $i++; ?></td>
					<td><?php echo $row['name']; ?></td>
					<td><?php echo $row['quantity']; ?></td>
					<td><?php echo $row['session']; ?></td>
					<td><a class="btn btn-warning btn-reprint btn-rad" data-id="<?php echo $row['product_id']; ?>" data-type="3" data-additional="1" data-date="<?php echo $from_date; ?>" data-slot="<?php echo $row['session']; ?>" data-name="<?php echo $row['name']; ?>" title="Payment Mode"  target="_blank"> Details </a></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	<?php } 
} ?>

<h3 style="text-align:center;">--- Catering Details ---</h3>
<?php foreach($catering as $key => $session) { ?>
	<h4 style="text-align:center;"><?php echo $key; ?></h4>
	<table border="1" width="100%" align="center">
		<thead>
			<tr>
				<th style="width:5%;text-align: center;">S.No</th>
				<th style="width:8%;text-align: center;">Products</th>
				<th style="width:9%;text-align: center;">Quantity</th>
				<th style="width:12%;text-align: center;">Preparation Time</th>
				<th style="width:15%;text-align: center;">Serving Time</th>
			</tr>
		</thead>
		<tbody>

		<?php $sn = 1; foreach($session as $row) { ?>
			<tr>
				<td style='text-align: center;'><?php echo $sn++; ?></td>
				<td style='text-align: center;'><?php echo $row['name']; ?></td>
				<td style='text-align: center;'> <?php echo $row ['quantity']; ?></td>
				<?php if ($row['session'] == 'Breakfast') $prep = "AM";
				elseif ($row['session'] == 'Lunch') $prep = "AM";
				else $prep = "PM" ?>
				<td style='text-align: center;'><?php echo $prep; ?></td>
				<td style='text-align: center;'><?php echo !empty($row['session']) ?  $row['session'] : '-'; ?></td>
			</tr>
		<?php } ?>

		</tbody>
	</table>
<?php } ?>

<?php if (!empty($additional['catering'])) { ?>
	<h3 style="text-align: center">Additional Items</h3><br>
	<?php 
	foreach($additional['catering'] as $key => $session) { ?>
		<h4 style="text-align: center"><?php echo $key ?></h4><br>
		<table style="width:100%;" align="center" class="table table-striped dataTable" id="datatables">
			<thead>
				<tr>
					<th style="width:10%;">S.No</th>
					<th style="width:20%;">Products</th>
					<th style="width:30%;">Quantity</th>
					<th style="width:20%;">Session</th>
					<th style="width:20%;">Details</th>
				</tr>
			</thead>
			<tbody>
				<?php $i = 1; foreach($session as $row) { ?>
				<tr>
					<td><?php echo $i++; ?></td>
					<td><?php echo $row['name']; ?></td>
					<td><?php echo $row['quantity']; ?></td>
					<td><?php echo $row['session']; ?></td>
					<td><a class="btn btn-warning btn-reprint btn-rad" data-id="<?php echo $row['product_id']; ?>" data-type="3" data-additional="1" data-date="<?php echo $from_date; ?>" data-slot="<?php echo $row['session']; ?>" data-name="<?php echo $row['name']; ?>" title="Payment Mode"  target="_blank"> Details </a></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	<?php } 
} ?>

<script>
window.print();
</script>


