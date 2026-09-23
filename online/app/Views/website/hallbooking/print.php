<title><?php echo $temp_details['name']; ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Barlow&display=swap" rel="stylesheet">
<style>
body { font-family: 'Barlow', sans-serif; }
table { border-collapse:collapse; }
table td { padding:5px; }
</style>
<?php 
if($qry1['status'] == 1) { $status = "Booked"; }
else if($qry1['status'] == 2) { $status = "Completed"; }
else { $status = "Cancelled"; }
?>
<table align="center" width="100%">
	<tr>
		<td colspan="2">
	<table style="width:100%">
	<tr>
	<td width="15%" align="left"><img
			src="<?php echo base_url(); ?>/uploads/main/<?php echo $temp_details['image']; ?>"
			style="width:120px;" align="left"></td>
	<td width="85%" align="left">
    <h3 style="text-align:center;margin-bottom: 0;"><?php echo $temp_details['name_tamil']; ?></h3>
    <p style="text-align:center; font-size:16px; margin:5px 0px;"><?php echo $temp_details['since_tamil']; ?>
    <h2 style="text-align:center;margin-bottom: 0;"><?php echo $temp_details['name']; ?></h2>
    <p style="text-align:center; font-size:16px; margin:5px 0px;"><?php echo $temp_details['since_eng']; ?><br><?php echo $temp_details['address1']; ?>, <?php echo $temp_details['address2']; ?>,
	<?php echo $temp_details['postcode']; ?> <?php echo $temp_details['city']; ?>  <br>
    Tel : <?php echo $temp_details['telephone']; ?></p></td></tr>
    </table>
</td></tr>
<tr><td colspan="2"><hr></td></tr>
<tr><td colspan="2"><h2 style="text-align:center;"> HALL BOOKING INVOICE  </h2></td></tr>
<tr><td align="left"><b>Date :</b> <?php $date= new DateTime($qry1['entry_date']) ;  echo $date->format('d-m-Y H:i:s A'); ?></td>
<td align="right"><p style="text-align:right; line-height:1.7em;"><b>Invoice :</b> <?php echo $qry1['ref_no']; ?></p></td></tr>
<tr><td colspan="2">
    <table border="1" style="border:1px solid #CCC;" width="90%" align="center">
    <tr><td width="20%"><b>Event Details</b> </td><td width="30%"><?php echo $qry1['event_name']; ?></td>
    <td width="20%"><b>Event Date</b> </td><td width="30%"><?php echo $qry1['booking_date']; ?></td></tr>
    <tr><td><b>Name </b> </td><td><?php echo $qry1['name']; ?></td>
    <td><b>Total Amount </b> </td><td><?php echo $qry1['total_amount']; ?></td></tr>
    <tr><td><b>Mobile No</b> </td><td><?php echo $qry1['mobile_number']; ?></td>
    <td><b>Deposit Amount</b> </td><td><?php echo $qry1['paid_amount']; ?></td></tr>
    <tr><td><b>Register By</b> </td><td><?php echo $qry1['register_by']; ?></td>
    <td><b>Balance Amount</b> </td><td><?php echo $qry1['balance_amount']; ?></td></tr>
    <tr><td><b>Slot Time</b> </td>
	<td>
	<?php 
	if(count($hall_booking_slot_details) > 0){
		$i = 0;
		foreach($hall_booking_slot_details as $hbsd){
			if(!empty($i)) echo '<br>';
			echo $hbsd['slot_time'];
			$i++;
		}
	}
	?>
	</td>
    <td><b>Status</b> </td><td><?php echo $status; ?></td></tr>
    </table>
</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<?php
if(count($hall_booking_details) > 0){
?>
<tr><td colspan="2">
	<table border="1" style="width:60%" align="center">
		<tr><td width="50%">Package Name</td><td width="50%">Amount</td></tr>
		<?php
		foreach($hall_booking_details as $hbd){
		?>
		<tr><td><?php echo $hbd['name']; ?></td><td><?php $total_amount = $hbd['amount'] + $hbd['commission']; echo number_format((float)$total_amount, 2, '.', '');; ?></td></tr>
		<?php
		}
		?>
    </table>
</td>
</tr>
<?php 
}
?>
<tr><td colspan="2"><p><b>Declaration</b></p>
<p>To the best of my knowledge, this Hall booking emanated from a clean source by virtue of any law. This booking is done willingly without any duress purported for the Temple usefor whatsoever reason. Henceforth.</p></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td> Approved By :</td>
<td>Received By :</td></tr>
</table>

<script>
window.print();
</script>