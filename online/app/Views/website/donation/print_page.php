<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Barlow&display=swap" rel="stylesheet">
<style>
	body {
		font-family: 'Barlow', sans-serif;
	}

	table {
		border-collapse: collapse;
	}

	table td {
		padding: 5px;
	}
</style>
<table align="center" width="100%">
	<tr>
		<td colspan="2">
			<table style="width:100%">
				<tr>
					<td width="15%" align="left">
						<img
							src="<?php echo base_url(); ?>/uploads/main/<?php echo $temp_details['image']; ?>"
							style="width:120px; display:block;" align="left" /></td>
					<td width="85%" align="left">
						<h2 style="text-align:left;margin-bottom: 0;">
							<?php echo $temp_details['name']; ?>
						</h2>
						<p style="text-align:left; font-size:16px; margin:5px;">
						<?php echo $temp_details['address1']; ?>, <br>
						<?php echo $temp_details['address2']; ?>,<br>
						<?php echo $temp_details['city']; ?> -
						<?php echo $temp_details['postcode']; ?><br>
							Tel :
							<?php echo $temp_details['telephone']; ?>
						</p>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<hr>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<h2 style="text-align:center;"> Cash Donation Voucher </h2>
		</td>
	</tr>
	<tr>
		<td align="left">
			<b>Date :</b>
			<?php echo date("d-m-Y", strtotime($qry1['date'])); ?>
		</td>
		<td align="right">
			<p style="text-align:right; line-height:1.7em;"><b>Invoice :</b>
			<?php echo $qry1['ref_no']; ?>
			</p>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<table border="1" style="border:1px solid #CCC;" width="90%" align="center">
				<tr>
					<td width="40%"><b>Name </b> </td>
					<td width="60%">
					<?php echo $qry1['name']; ?>
					</td>
				</tr>
				<tr>
					<td><b>Pay For </b> </td>
					<td>
					<?php echo $qry1['pname']; ?>
					</td>
				</tr>
				<tr>
					<td><b>Amount(RM) </b> </td>
					<td>
					<?php echo number_format($qry1['amount'], '2', '.', ','); ?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2"><b>Remarks :</b>
		<?php echo $qry1['description']; ?>
		</td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2">
			<p><b>Declaration by the donor</b></p>
			<p>To the best of my knowledge, this cash donation emanated from a clean source by virtue of any law. This
				donation is done willingly without any duress purported for the Temple usefor whatsoever reason.
				Henceforth, it shall be the property of the Temple and I shall reserve no rights and locus on the said
				donations that entitle me to make any claim whatsoever in the future</p>
		</td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td> Donated By :</td>
		<td>Received By :</td>
	</tr>
	<tr>
		<td colspan="2">
		<?php if (!empty($terms['cash_donation'])) { ?>
				<p>
				<?php echo $terms['cash_donation']; ?>
				</p>
				<?php } ?>
		</td>
	</tr>
</table>
<script>
	window.print();
</script>


