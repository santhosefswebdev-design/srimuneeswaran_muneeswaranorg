<?php $db = db_connect(); ?>
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
		padding: 0px;
	}

	hr {
		border: none;
		border-top: 1px dashed #000;
		color: #fff;
		background-color: #fff;
		height: 1px;
	}

	p {
		font-size: 10px;
		font-family: monospace;
		margin: 0px
	}
	.capitalize{
		text-transform: capitalize;
		text-align: center;
	}
</style>
<?php
// Create a function for converting the amount in words
function AmountInWords(float $amount)
{
	$amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
	$get_paise = ($amount_after_decimal > 0) ? " and Cents " . trim(NumToWords($amount_after_decimal)) : '';
	return (NumToWords($amount) ? 'Ringgit ' . trim(NumToWords($amount)) . '' : '') . $get_paise . ' Only';

}
function NumToWords($num)
{
	$num = floor($num);
	$amt_hundred = null;
	$count_length = strlen($num);
	$x = 0;
	$string = array();
	$change_words = array(
		0 => '',
		1 => 'One',
		2 => 'Two',
		3 => 'Three',
		4 => 'Four',
		5 => 'Five',
		6 => 'Six',
		7 => 'Seven',
		8 => 'Eight',
		9 => 'Nine',
		10 => 'Ten',
		11 => 'Eleven',
		12 => 'Twelve',
		13 => 'Thirteen',
		14 => 'Fourteen',
		15 => 'Fifteen',
		16 => 'Sixteen',
		17 => 'Seventeen',
		18 => 'Eighteen',
		19 => 'Nineteen',
		20 => 'Twenty',
		30 => 'Thirty',
		40 => 'Forty',
		50 => 'Fifty',
		60 => 'Sixty',
		70 => 'Seventy',
		80 => 'Eighty',
		90 => 'Ninety'
	);
	$here_digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
	while ($x < $count_length) {
		$get_divider = ($x == 2) ? 10 : 100;
		$amount = floor($num % $get_divider);
		$num = floor($num / $get_divider);
		$x += $get_divider == 10 ? 1 : 2;
		if ($amount) {
			$add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
			$amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
			$string[] = ($amount < 21) ? $change_words[$amount] . ' ' . $here_digits[$counter] . $add_plural . ' ' . $amt_hundred : $change_words[floor($amount / 10) * 10] . ' ' . $change_words[$amount % 10] . ' ' . $here_digits[$counter] . $add_plural . ' ' . $amt_hundred;
		} else
			$string[] = null;
	}
	//$implode_to_Rupees = implode('', array_reverse($string));
	return (implode('', array_reverse($string)));
}
?>
<div style="max-width: 80mm;font-weight: 600;font-family: monospace;">

	<p style="text-align:center;"><img
			src="<?php echo base_url(); ?>/uploads/main/<?php echo $temp_details['image']; ?>" style="width:70px;"
			align="center"></p>
	<p style="font-size:13px;text-align:center;font-weight:bold;">
		<?php echo $temp_details['name']; ?>
	</p>
	<p style="text-align:center;">
		<?php echo $temp_details['address1']; ?>
		<?php if (!empty($temp_details['address2'])) {
			echo "</br>" . $temp_details['address2'];
		} ?></br>
		<?php echo $temp_details['city'] . '-' . $temp_details['postcode']; ?>
		<br>Tel:
		<?= $temp_details['telephone']; ?>
	</p>
	<hr>
	<p style="text-align:center">
	<?php
	if($dailyclosing_start_date == $dailyclosing_end_date){
		echo "Date - [".date('d-m-Y', strtotime($dailyclosing_start_date))."]";
	}
	else{
		echo "Date - [".date('d-m-Y', strtotime($dailyclosing_start_date))." - ".date('d-m-Y', strtotime($dailyclosing_end_date))."]";
	}
	ob_start();
	?>
	</p>
	<hr>
	<p style="text-align:center; font-size:13px;text-transform: uppercase;"> ARCHANAI SELLING DETAILS </p>
	<hr>
	<table style="width:100%;">
		<tr>
			<th align="left">
				<p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;">Archanai</p>
			</th>
			<th align="center">
				<p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;">Quantity</p>
			</th>
			<th align="right">
				<p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;">Amount (S$)</p>
			</th>
		</tr>
		<?php
		$summary_total = array();
		$summary_total['sales'] = array();
		$summary_total['expense'] = array();
		?>
		<?php
		$archanai_total = 0;
		$nava_total = 0;
		$nava_qty = 0;
		$sale_summary = array();
		$sale_summary['archanai'] = array();
		if (count($archanai_diety_details) > 0) {
			foreach ($archanai_diety_details as $archanai_detail_data) {
				$sannathi_total = 0;
				$sannathi_qty = 0;
				echo '<tr><td colspan="5" style="text-align: center;"><h4>' . $archanai_detail_data['title'] . '</h4></td></tr>';
				if (count($archanai_detail_data['data']) > 0) {
					foreach ($archanai_detail_data['data'] as $archanai_detail) {
						$archanai_total = $archanai_total + $archanai_detail['amount'];
						$sannathi_total = $sannathi_total + $archanai_detail['amount'];
						$sannathi_qty = $sannathi_qty + $archanai_detail['qty'];
						$archanai_qty = $archanai_qty + $archanai_detail['qty'];
						if(empty($sale_summary['archanai'][$archanai_detail['archanai_id']]['name_eng'])) $sale_summary['archanai'][$archanai_detail['archanai_id']]['name_eng'] = $archanai_detail['name_in_english'];
						if(empty($sale_summary['archanai'][$archanai_detail['archanai_id']]['name_tamil'])) $sale_summary['archanai'][$archanai_detail['archanai_id']]['name_in_tamil'] = $archanai_detail['name_in_tamil'];
						if(empty($sale_summary['archanai'][$archanai_detail['archanai_id']]['ledger_code'])) $sale_summary['archanai'][$archanai_detail['archanai_id']]['ledger_code'] = $archanai_detail['ledger_code'];
						if(empty($sale_summary['archanai'][$archanai_detail['archanai_id']]['ledger_name'])) $sale_summary['archanai'][$archanai_detail['archanai_id']]['ledger_name'] = $archanai_detail['ledger_name'];
						if(empty($sale_summary['archanai'][$archanai_detail['archanai_id']]['qty'])) $sale_summary['archanai'][$archanai_detail['archanai_id']]['qty'] = 0;
						$sale_summary['archanai'][$archanai_detail['archanai_id']]['qty'] += $archanai_detail['qty'];
						if(empty($sale_summary['archanai'][$archanai_detail['archanai_id']]['amount'])) $sale_summary['archanai'][$archanai_detail['archanai_id']]['amount'] = 0;
						$sale_summary['archanai'][$archanai_detail['archanai_id']]['amount'] = $archanai_detail['unit_price'];
						if(empty($sale_summary['archanai'][$archanai_detail['archanai_id']]['total'])) $sale_summary['archanai'][$archanai_detail['archanai_id']]['total'] = 0;
						$sale_summary['archanai'][$archanai_detail['archanai_id']]['total'] += $archanai_detail['amount'];
						if (empty($summary_total['sales'][$archanai_detail['paymentmode']]))
							$summary_total['sales'][$archanai_detail['paymentmode']] = 0;
						$summary_total['sales'][$archanai_detail['paymentmode']] += $archanai_detail['amount'];
						if($archanai_detail['groupname'] == 'NAVAKIRAGAM'){
							$nava_total = $nava_total + $archanai_detail['amount'];
							$nava_qty = $nava_qty + $archanai_detail['qty'];
						}
						else{
							?>
							<tr>
								<td align="left">
									<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">
										<?php echo $archanai_detail['name_in_english'] . "<br>" . $archanai_detail['name_in_tamil']; ?>
									</p>
								</td>
								<td align="center">
									<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">
										<?php echo $archanai_detail['qty']; ?>
									</p>
								</td>
								<td align="right">
									<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;font-weight:bold;">
										<?php echo number_format($archanai_detail['amount'], 2); ?>
									</p>
								</td>
							</tr>
							<?php
						}
					}
					if($nava_total > 0){
					?>
					<tr>
						<td align="left">
							<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">
								NAVAKIRAGAM<br>நவக்கிரகம்
							</p>
						</td>
						<td align="center">
							<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">
								<?php echo $nava_qty; ?>
							</p>
						</td>
						<td align="right">
							<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;font-weight:bold;">
								<?php echo number_format($nava_total, 2); ?>
							</p>
						</td>
					</tr>
					<?php
					}
				}
				echo '<tr><td colspan="3"><hr></td>
		</tr><tr><td colspan="2"><p style="text-align:left;text-transform: uppercase;font-weight:bold;font-size:11px;">' . $archanai_detail_data['title'] . ' Total</p></td><td align="right"><p style="margin:2px 0px;font-size:11px;font-weight:bold;">' . number_format($sannathi_total, 2) . '</p></td></tr>';
			}
		}
		?>
		<tr>
			<td colspan="3">
				<hr>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<p style="text-align:left;text-transform: uppercase;font-weight:bold;font-size:11px;">SUB-TOTAL</p>
			</td>
			<td align="right">
				<p style="margin:2px 0px;font-size:11px;font-weight:bold;">
					<?php echo number_format($archanai_total, 2); ?>
				</p>
			</td>
		</tr>
	</table>
	<?php
	$hallbooking_total = 0;
	if (count($hallbooking_details) > 0) {
	?>
	<hr>
	<p style="text-align:center; font-size:13px;text-transform: uppercase;"> Hall Booking Details </p>
	<hr>
	<table style="width:100%;">
		<tr>
			<th align="left">
				<p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;">Package Name</p>
			</th>
			<th align="left">
				<p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;"> Name</p>
			</th>
			<th align="right">
				<p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;">Amount (S$)</p>
			</th>
		</tr>
		<?php
		foreach ($hallbooking_details as $hallbooking_detail) {
			$hallbooking_total = $hallbooking_total + $hallbooking_detail['paidamount'];
			if (empty($summary_total['sales'][$hallbooking_detail['paymentmode']]))
				$summary_total['sales'][$hallbooking_detail['paymentmode']] = 0;
			$summary_total['sales'][$hallbooking_detail['paymentmode']] += $hallbooking_detail['paidamount'];
			?>
			<tr>
				<td align="left">
					<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">
						<?php echo $hallbooking_detail['package_name']; ?>
					</p>
				</td>
				<td align="left">
					<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">
						<?php echo $hallbooking_detail['person_name']; ?>
					</p>
				</td>
				<td align="right">
					<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;font-weight:bold;">
						<?php echo number_format($hallbooking_detail['paidamount'], 2); ?>
					</p>
				</td>
			</tr>
			<?php
		}
		?>
		<tr>
			<td colspan="3">
				<hr>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<p style="text-align:left;text-transform: uppercase;font-weight:bold;font-size:11px;">SUB-TOTAL</p>
			</td>
			<td align="right">
				<p style="margin:2px 0px;font-size:11px;font-weight:bold;">
					<?php echo number_format($hallbooking_total, 2); ?>
				</p>
			</td>
		</tr>
	</table>
	<?php
	}
	$ubayam_total = 0;
	if (count($ubayam_details) > 0) {
	?>
	<hr>
	<p style="text-align:center; font-size:13px;text-transform: uppercase;"> Ubayam Details </p>
	<hr>
	<table style="width:100%;">
		<tr>
			<th align="left">
				<p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;"> Type</p>
			</th>
			<th align="left">
				<p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;"> Name</p>
			</th>
			<th align="right">
				<p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;">Amount (S$)</p>
			</th>
		</tr>
		<?php
		foreach ($ubayam_details as $ubayam_detail) {
			$ubayam_total = $ubayam_total + $ubayam_detail['paidamount'];
			if (empty($summary_total['sales'][$ubayam_detail['paymentmode']]))
				$summary_total['sales'][$ubayam_detail['paymentmode']] = 0;
			$summary_total['sales'][$ubayam_detail['paymentmode']] += $ubayam_detail['paidamount'];
			?>
			<tr>
				<td align="left">
					<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">
						<?php echo $ubayam_detail['package_name']; ?>
					</p>
				</td>
				<td align="left">
					<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">
						<?php echo $ubayam_detail['person_name']; ?>
					</p>
				</td>
				<td align="right">
					<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;font-weight:bold;">
						<?php echo number_format($ubayam_detail['paidamount'], 2); ?>
					</p>
				</td>
			</tr>
			<?php
		}
		?>
		<tr>
			<td colspan="3">
				<hr>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<p style="text-align:left;text-transform: uppercase;font-weight:bold;font-size:11px;">SUB-TOTAL</p>
			</td>
			<td align="right">
				<p style="margin:2px 0px;font-size:11px;font-weight:bold;">
					<?php echo number_format($ubayam_total, 2); ?>
				</p>
			</td>
		</tr>
	</table>
	<?php
	}
	
	$donation_total = 0;
	$sale_summary['donation'] = array();
	if (count($donation_details) > 0) {
	?>
	<hr>
	<p style="text-align:center; font-size:13px;text-transform: uppercase;"> Cash Donation Details</p>
	<hr>
	<table style="width:100%;">
		<tr>
			<th align="left" colspan="2">
				<p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;">Name</p>
			</th>
			<th align="right">
				<p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;">Amount (S$)</p>
			</th>
		</tr>
		<?php
		foreach ($donation_details as $donation_detail) {
			$donation_total = $donation_total + $donation_detail['paidamount'];
			if (empty($summary_total['sales'][$donation_detail['paymentmode']]))
				$summary_total['sales'][$donation_detail['paymentmode']] = 0;
			$summary_total['sales'][$donation_detail['paymentmode']] += $donation_detail['paidamount'];
			if (empty($sale_summary['donation'][$donation_detail['package_name']]['name_eng']))
				$sale_summary['donation'][$donation_detail['package_name']]['name_eng'] = $donation_detail['package_name'];
			if (empty($sale_summary['donation'][$donation_detail['package_name']]['name_tamil']))
				$sale_summary['donation'][$donation_detail['package_name']]['name_in_tamil'] = '';
			$sale_summary['donation'][$donation_detail['package_name']]['qty'] += 1;
			if (empty($sale_summary['donation'][$donation_detail['package_name']]['total']))
				$sale_summary['donation'][$donation_detail['package_name']]['total'] = 0;
			$sale_summary['donation'][$donation_detail['package_name']]['total'] += $donation_detail['paidamount'];
			if (empty($sale_summary['donation'][$donation_detail['package_name']]['ledger_code']))
				$sale_summary['donation'][$donation_detail['package_name']]['ledger_code'] = $donation_detail['ledger_code'];
			?>
			<tr>
				<td align="left" colspan="2">
					<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">
						<?php echo $donation_detail['person_name']; ?>
					</p>
				</td>
				<td align="right">
					<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;font-weight:bold;">
						<?php echo number_format($donation_detail['paidamount'], 2); ?>
					</p>
				</td>
			</tr>
			<?php
		}
		?>
		<tr>
			<td colspan="3">
				<hr>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<p style="text-align:left;text-transform: uppercase;font-weight:bold;font-size:11px;">SUB-TOTAL</p>
			</td>
			<td align="right">
				<p style="margin:2px 0px;font-size:11px;font-weight:bold;">
					<?php echo number_format($donation_total, 2); ?>
				</p>
			</td>
		</tr>
	</table>
	<?php
	}
	$prasadam_total = 0;
	$sale_summary['prasadam'] = array();
	if (count($prasadam_details) > 0) {
	?>
	<hr>
	<p style="text-align:center; font-size:13px;text-transform: uppercase;"> Prasadam Details</p>
	<hr>
	<table style="width:100%;">
		<tr>
			<th align="left" colspan="2">
				<p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;">Name</p>
			</th>
			<th align="right">
				<p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;">Amount (S$)</p>
			</th>
		</tr>
		<?php
		foreach ($prasadam_details as $prasadam_detail) {
			$prasadam_total = $prasadam_total + $prasadam_detail['paidamount'];
			if (empty($summary_total['sales'][$prasadam_detail['paymentmode']]))
				$summary_total['sales'][$prasadam_detail['paymentmode']] = 0;
			$summary_total['sales'][$prasadam_detail['paymentmode']] += $prasadam_detail['paidamount'];
			if(empty($sale_summary['prasadam'][$prasadam_detail['package_name']]['name_eng'])) $sale_summary['prasadam'][$prasadam_detail['package_name']]['name_eng'] = $prasadam_detail['package_name'];
			if(empty($sale_summary['prasadam'][$prasadam_detail['package_name']]['name_tamil'])) $sale_summary['prasadam'][$prasadam_detail['package_name']]['name_in_tamil'] = '';
			$sale_summary['prasadam'][$prasadam_detail['package_name']]['qty'] += 1;
			if(empty($sale_summary['prasadam'][$prasadam_detail['package_name']]['total'])) $sale_summary['prasadam'][$prasadam_detail['package_name']]['total'] = 0;
			$sale_summary['prasadam'][$prasadam_detail['package_name']]['total'] += $prasadam_detail['paidamount'];
			if(empty($sale_summary['prasadam'][$prasadam_detail['package_name']]['ledger_code'])) $sale_summary['prasadam'][$prasadam_detail['package_name']]['ledger_code'] = $prasadam_detail['ledger_code'];
			?>
			<tr>
				<td align="left" colspan="2">
					<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">
						<?php echo $prasadam_detail['person_name']; ?>
					</p>
				</td>
				<td align="right">
					<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;font-weight:bold;">
						<?php echo number_format($prasadam_detail['paidamount'], 2); ?>
					</p>
				</td>
			</tr>
			<?php
		}
		?>
		<tr>
			<td colspan="3">
				<hr>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<p style="text-align:left;text-transform: uppercase;font-weight:bold;font-size:11px;">SUB-TOTAL</p>
			</td>
			<td align="right">
				<p style="margin:2px 0px;font-size:11px;font-weight:bold;">
					<?php echo number_format($prasadam_total, 2); ?>
				</p>
			</td>
		</tr>
	</table>
	<?php
	}
	$annathanam_total = 0;
	if (count($annathanam_details) > 0) {
	?>
	<hr>
	<p style="text-align:center; font-size:13px;text-transform: uppercase;"> Annathanam Details</p>
	<hr>
	<table style="width:100%;">
		<tr>
			<th align="left" colspan="2">
				<p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;">Slot Time</p>
			</th>
			<th align="right">
				<p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;">Amount (S$)</p>
			</th>
		</tr>
		<?php
		foreach ($annathanam_details as $annathanam_detail) {
			$annathanam_total = $annathanam_total + $annathanam_detail['total_amount'];
			?>
			<tr>
				<td align="left" colspan="2">
					<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">
						<?php echo $annathanam_detail['person_name']; ?>
					</p>
				</td>
				<td align="right">
					<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;font-weight:bold;">
						<?php echo number_format($annathanam_detail['total_amount'], 2); ?>
					</p>
				</td>
			</tr>
			<?php
		}
		?>
		<tr>
			<td colspan="3">
				<hr>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<p style="text-align:left;text-transform: uppercase;font-weight:bold;font-size:11px;">SUB-TOTAL</p>
			</td>
			<td align="right">
				<p style="margin:2px 0px;font-size:11px;font-weight:bold;">
					<?php echo number_format($annathanam_total, 2); ?>
				</p>
			</td>
		</tr>
	</table>
	<?php
	}
	?>
	<hr>
	
	
		<hr>
		
		<?php
		ob_end_clean();
		if (count($sale_summary)) {
			$sale_summary_qty = 0;
			$sale_summary_amount = 0;
			echo '<div class="col-md-12"><h3>Summary</h3></div><div class="table-responsive col-md-12" style="background:#FFF; float:none;margin-bottom:0px;"><table class="table-responsive col-md-12" style="width:100%;"><thead><tr><th align="left">Item</th><th align="center">Code</th><th align="right">Qty</th><th align="right">Amount (S$)</th></tr></thead><tbody>';
			foreach ($sale_summary as $key => $values) {
				echo '<tr><td colspan="4"><h4 class="capitalize">' . $key . ' - Sales</h4></td></tr>';
				if (count($values)) {
					foreach ($values as $item) {
						$sale_summary_qty += $item['qty'];
						$sale_summary_amount += $item['total'];
						echo '<tr>';
						echo '<td><p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">' . $item['name_eng'] . '</p></td>';
						echo '<td align="center"><p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">' . $item['ledger_code'] . '</p></td>';
						echo '<td align="right"><p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">' . $item['qty'] . '</p></td>';
						echo '<td align="right"><p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">' . number_format($item['total'], 2) . '</p></td>';
						echo '</tr>';
					}
				}
			}
			echo '</tbody><tfoot><tr><th colspan="2">Total</th><th align="right">' . $sale_summary_qty . '</th><th align="right">' . number_format($sale_summary_amount, 2) . '</th></tr></tfoot></table></div>';
		}

		?>
		<hr>
		<?php
		if (count($summary_total['sales'])) {
			$cash_total = 0;
			echo '<div class="col-md-12"><h3>Payment Summary</h3></div><div class="table-responsive col-md-12" style="background:#FFF; float:none;margin-bottom:0px;"><table class="table-responsive col-md-12" style="width:100%;"><thead><tr><th align="left">Payment</th><th align="right">Amount (S$)</th></tr></thead><tbody>';
			foreach ($summary_total['sales'] as $vl => $st) {
				if ($vl == 'cash')
					$cash_total += $st;
				if ($vl == "ipay_merch_qr") {
					$paymentname = "QR PAYMENT";
				} elseif ($vl == "ipay_merch_online") {
					$paymentname = "ONLINE PAYMENT";
				} elseif ($vl == "cash") {
					$paymentname = "CASH";
				} elseif ($vl == "nets_pay") {
					$paymentname = 'NETS';
				} else
					$paymentname = strtoupper(str_replace('_', ' ', $vl));
				echo '<tr>';
				echo '<td><p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">' . $paymentname . '</p></td>';
				echo '<td align="right"><p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">' . number_format($st, 2) . '</p></td>';
				echo '</tr>';
			}
			echo '</tbody></table></div>';
		}

		?>
		<hr>
			<?php

			if (!empty($coin_denominations)) {

				 $sno = 1;
				$totalAmount = 0;
				$totalQuantity = 0;

				?>
				<div class="col-md-12">
					<h3>Cash Denominations</h3>
				</div>
			
				<div class="table-responsive col-md-12" style="background:#FFF; float:none;margin-bottom:0px;">
				<table class="table table-bordered table-striped table-hover">
										<thead>
											<tr>
												<th style="padding: 5px 10px!important;">S.NO</th>
												<th style="padding: 5px 10px!important;">Name</th>
												<!-- Quantity -->
												<th style="padding: 5px 10px!important;text-align:right;">Counter</th> 
												<th style="padding: 5px 10px!important;text-align:right;">Camphor Tray</th> 
												
												<th style="padding: 5px 10px!important;">Amount (S$)</th>
											</tr>
										</thead>
										<tbody>
											<?php
											foreach ($coin_denominations as $denomination) {
												
												$totalAmount = $denomination->c_amount + $denomination->amount;
												$totalQuantity += $denomination->quantity;
												$totalc_Quantity += $denomination->c_quantity;
												$totalquan=$totalQuantity+$totalc_Quantity;
												$denominationtotal += $totalAmount; // Sum up the amount
												?>
												<tr>
													<td style="padding: 5px 10px!important;"><?php echo $sno++; ?></td>
													<td style="padding: 5px 10px!important;"><?php echo $denomination->name; ?></td>
												
													<td style="padding: 5px 10px!important;text-align:right;">
														<?php echo $denomination->quantity; ?></td>
														<td style="padding: 5px 10px!important;text-align:right;">
														<?php echo $denomination->c_quantity; ?>
														</td>
															<td style="padding: 5px 10px!important;"><?php echo "$". $totalAmount; ?></td>
												</tr>
												<?php
											}
											?>
										</tbody>
										<tfoot>
										<!-- Display the totals -->
											<tr >
												<td colspan="3" style="text-align:right; padding: 5px 10px!important;"><strong>Sub Total:</strong></td>
											
												<td style="padding: 5px 10px!important;text-align:right;"><strong><?php echo $totalquan; ?></strong>
													<td style="padding: 5px 10px!important;"><strong><?php echo "$" . number_format($denominationtotal, 2); ?></strong></td>
												</td>
											</tr>
											<?php if(!empty($denominationtotal) && !empty($floating_cash['amount'])){ ?>
											<tr >
												<td colspan="4" style="text-align:right; padding: 5px 10px!important;"><strong>Float Cash:</strong></td>
											
												<td style="padding: 5px 10px!important;"><strong><?php echo "$" . number_format($floating_cash['amount'], 2); ?></strong></td>
												</td>
											</tr>
											<tr >
												<td colspan="4" style="text-align:right; padding: 5px 10px!important;"><strong>Total Cash:</strong></td>
											
												<td style="padding: 5px 10px!important;"><strong><?php echo "$" . number_format($denominationtotal - $floating_cash['amount'], 2); ?></strong></td>
												</td>
											</tr>
											<?php } ?>
										</tfoot>
									</table>
				</div>
				<?php
			}
			?>
		
		<hr>
	<table style="width:100%;">
		<tr>
			<td align="left" colsapn="2">
				<p style="text-align:left; font-size:13px;font-weight:bold;text-transform: uppercase;">GRAND TOTAL (SGD)
				</p>
			</td>
			<td align="right">
				<p style="text-align: right;margin:2px 0px;font-size:13px;font-weight:bold;">
					<?php
					$total = $archanai_total + $hallbooking_total + $ubayam_total + $donation_total + $prasadam_total;
					echo number_format($total, '2', '.', ',');
					?>
				</p>
			</td>
		</tr>
	</table>
<br>
<?php ob_start(); ?>
		<!-- <br>
		<br>
		<h4>SIGN</h4> -->
	<hr>
	<?php ob_end_clean(); ?>
</div>
<div><h3>Checked by : <?php echo $floating_cash['checked_by'] ?></h3>




<h4>SIGN</h4></div>
<br>
<!-- <p  class="dot_line" style="max-width: 80mm;font-weight: 600;font-family: monospace;text-align: center;"><span>--</span>GRASP SOFTWARE SOLUTIONS SDN. BHD.<span>--</span></p> -->
<script>
	window.print();
	//setTimeout(function(){window.close();},4500);
</script>