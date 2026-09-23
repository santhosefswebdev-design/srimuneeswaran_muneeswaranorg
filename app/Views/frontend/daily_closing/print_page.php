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
	?>
	</p>
	<hr>
	<p style="text-align:center; font-size:13px;text-transform: uppercase;"> ARCHANAI SELLING DETAILS </p>
	<?php if (!empty($arch_inv_no['first_ref_no']) && !empty($arch_inv_no['last_ref_no'])) { ?>
		<?php if ($arch_inv_no['first_ref_no'] != $arch_inv_no['last_ref_no']) { ?>
			<p style="text-align: center">( <?php echo $arch_inv_no['first_ref_no']; ?> - <?php echo $arch_inv_no['last_ref_no']; ?> )</p>
		<?php } else { ?>
			<p style="text-align: center">( <?php echo $arch_inv_no['first_ref_no']; ?>)</p>
		<?php }
	} ?>
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
	$donation_total = 0;
	$sale_summary['donation'] = array();
	if (count($donation_details) > 0) {
	?>
	<hr>
	<p style="text-align:center; font-size:13px;text-transform: uppercase;"> Cash Donation Details</p>
	<?php if (!empty($don_inv_no['first_ref_no']) && !empty($don_inv_no['last_ref_no'])) { ?>
		<?php if ($don_inv_no['first_ref_no'] != $don_inv_no['last_ref_no']) { ?>
			<p style="text-align: center">( <?php echo $don_inv_no['first_ref_no']; ?> - <?php echo $don_inv_no['last_ref_no']; ?> )</p>
		<?php } else { ?>
			<p style="text-align: center">( <?php echo $don_inv_no['first_ref_no']; ?> )</p>
		<?php } ?>
	<?php } ?>
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
			if(empty($sale_summary['donation'][$donation_detail['package_name']]['name_eng'])) $sale_summary['donation'][$donation_detail['package_name']]['name_eng'] = $donation_detail['package_name'];
			if(empty($sale_summary['donation'][$donation_detail['package_name']]['name_tamil'])) $sale_summary['donation'][$donation_detail['package_name']]['name_in_tamil'] = '';
			$sale_summary['donation'][$donation_detail['package_name']]['qty'] += 1;
			if(empty($sale_summary['donation'][$donation_detail['package_name']]['total'])) $sale_summary['donation'][$donation_detail['package_name']]['total'] = 0;
			$sale_summary['donation'][$donation_detail['package_name']]['total'] += $donation_detail['paidamount'];
			if(empty($sale_summary['donation'][$donation_detail['package_name']]['ledger_code'])) $sale_summary['donation'][$donation_detail['package_name']]['ledger_code'] = $donation_detail['ledger_code'];
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
	<?php if (!empty($pras_inv_no['first_ref_no']) && !empty($pras_inv_no['last_ref_no'])) { ?>
		<?php if ($pras_inv_no['first_ref_no'] != $pras_inv_no['last_ref_no']) { ?>
			<p style="text-align: center">( <?php echo $pras_inv_no['first_ref_no']; ?> - <?php echo $pras_inv_no['last_ref_no']; ?> )</p>
		<?php } else { ?>
			<p style="text-align: center">( <?php echo $pras_inv_no['first_ref_no']; ?> )</p>
		<?php } 
	}?>
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

			foreach ($prasadam_detail['products'] as $products) {
				if(empty($sale_summary['prasadam'][$products['package_name']]['name_eng'])) $sale_summary['prasadam'][$products['package_name']]['name_eng'] = $products['package_name'];
				$sale_summary['prasadam'][$products['package_name']]['qty'] += $products['quantity'];
				if(empty($sale_summary['prasadam'][$products['package_name']]['total'])) $sale_summary['prasadam'][$products['package_name']]['total'] = 0;
				$sale_summary['prasadam'][$products['package_name']]['total'] += $products['total_amount'];
				if(empty($sale_summary['prasadam'][$products['package_name']]['ledger_code'])) $sale_summary['prasadam'][$products['package_name']]['ledger_code'] = $products['ledger_code'];
				
				$productName = $products['package_name'];
			?>
			<tr>
				<td align="left">
					<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">
						<?php echo $productName; ?>
					</p>
				</td>
				<td align="left">
					<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">
						<?php echo $prasadam_detail['customer_name']; ?>
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
	?>
	
	<?php
	$annathanam_total = 0;
	$sale_summary['annathanam'] = array();
	if (count($annathanam_details) > 0) {
	?>
	<hr>
	<p style="text-align:center; font-size:13px;text-transform: uppercase;"> Annathanam Details</p>
	<?php if (!empty($anna_inv_no['first_ref_no']) && !empty($anna_inv_no['last_ref_no'])) { ?>
		<?php if ($anna_inv_no['first_ref_no'] != $anna_inv_no['last_ref_no']) { ?>
			<p style="text-align: center">( <?php echo $anna_inv_no['first_ref_no']; ?> - <?php echo $anna_inv_no['last_ref_no']; ?> )</p>
		<?php } else { ?>
			<p style="text-align: center">( <?php echo $anna_inv_no['first_ref_no']; ?> )</p>
		<?php } 
	}?>
	<hr>
	<table style="width:100%;">
		<tr>
			<th align="left">
				<p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;">Package NAme</p>
			</th>
			<th align="left">
				<p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;"> Name</p>
			</th>
			<th align="right">
				<p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;">Amount (S$)</p>
			</th>
		</tr>
		<?php
		foreach ($annathanam_details as $annathanam_detail) {
			$annathanam_total = $annathanam_total + $annathanam_detail['total_amount'];
			if (empty($summary_total['sales'][$annathanam_detail['paymentmode']]))
				$summary_total['sales'][$annathanam_detail['paymentmode']] = 0;
			$summary_total['sales'][$annathanam_detail['paymentmode']] += $annathanam_detail['paidamount'];

			foreach ($annathanam_detail['products'] as $products) {
				if(empty($sale_summary['annathanam'][$products['package_name']]['name_eng'])) $sale_summary['annathanam'][$products['package_name']]['name_eng'] = $products['package_name'];
				$sale_summary['annathanam'][$products['package_name']]['qty'] += $products['quantity'];
				if(empty($sale_summary['annathanam'][$products['package_name']]['total'])) $sale_summary['annathanam'][$products['package_name']]['total'] = 0;
				$sale_summary['annathanam'][$products['package_name']]['total'] += $products['total_amount'];
				if(empty($sale_summary['annathanam'][$products['package_name']]['ledger_code'])) $sale_summary['annathanam'][$products['package_name']]['ledger_code'] = $products['ledger_code'];
				
				$productName = $products['package_name'];
				?>
				<tr>
					<td align="left">
						<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">
							<?php echo $productName; ?>
						</p>
					</td>
					<td align="left">
						<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">
							<?php echo $annathanam_detail['customer_name']; ?>
						</p>
					</td>
					<td align="right">
						<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;font-weight:bold;">
							<?php echo number_format($annathanam_detail['paidamount'], 2); ?>
						</p>
					</td>
				</tr>
			<?php
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
					<?php echo number_format($annathanam_total, 2); ?>
				</p>
			</td>
		</tr>
	</table>
	<?php
	}
	?>
	<?php
	$hallbooking_total = 0;
	$sale_summary['hall booking'] = array();
	if (count($hallbooking_details) > 0) {
	?>
	<hr>
	<p style="text-align:center; font-size:13px;text-transform: uppercase;"> Hall Booking Details </p>
	<?php if (!empty($hall_inv_no['first_ref_no']) && !empty($hall_inv_no['last_ref_no'])) { ?>
		<?php if ($hall_inv_no['first_ref_no'] != $hall_inv_no['last_ref_no']) { ?>
			<p style="text-align: center">( <?php echo $hall_inv_no['first_ref_no']; ?> - <?php echo $hall_inv_no['last_ref_no']; ?> )</p>
		<?php } else { ?>
			<p style="text-align: center">( <?php echo $hall_inv_no['first_ref_no']; ?>)</p>
		<?php }
	} ?>
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


			foreach ($hallbooking_detail['products'] as $products) {
				if(empty($sale_summary['hall booking'][$products['package_name']]['name_eng'])) $sale_summary['hall booking'][$products['package_name']]['name_eng'] = $products['package_name'];
				$sale_summary['hall booking'][$products['package_name']]['qty'] += $products['quantity'];
				if(empty($sale_summary['hall booking'][$products['package_name']]['total'])) $sale_summary['hall booking'][$products['package_name']]['total'] = 0;
				$sale_summary['hall booking'][$products['package_name']]['total'] += $products['amount'];
				if(empty($sale_summary['hall booking'][$products['package_name']]['ledger_code'])) $sale_summary['hall booking'][$products['package_name']]['ledger_code'] = $products['ledger_code'];
				
				$productName = $products['package_name'];
				?>
				<tr>
					<td align="left">
						<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">
							<?php echo $productName; ?>
						</p>
					</td>
					<td align="left">
						<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">
							<?php echo $hallbooking_detail['customer_name']; ?>
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
	?>

	<?php
	$ubayam_total = 0;
	$sale_summary['ubayam'] = array();
	if (count($ubayam_details) > 0) {
	?>
	<hr>
	<p style="text-align:center; font-size:13px;text-transform: uppercase;"> Ubayam Details </p>
	<?php if (!empty($ubayam_inv_no['first_ref_no']) && !empty($ubayam_inv_no['last_ref_no'])) { ?>
		<?php if ($ubayam_inv_no['first_ref_no'] != $ubayam_inv_no['last_ref_no']) { ?>
			<p style="text-align: center">( <?php echo $ubayam_inv_no['first_ref_no']; ?> - <?php echo $ubayam_inv_no['last_ref_no']; ?> )</p>
		<?php } else { ?>
			<p style="text-align: center">( <?php echo $ubayam_inv_no['first_ref_no']; ?> )</p>
		<?php } 
	}?>
	<hr>
	<table style="width:100%;">
		<tr>
			<th align="left">
				<p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;"> Package Name</p>
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

			foreach ($ubayam_detail['products'] as $products) {
				if(empty($sale_summary['ubayam'][$products['package_name']]['name_eng'])) $sale_summary['ubayam'][$products['package_name']]['name_eng'] = $products['package_name'];
				$sale_summary['ubayam'][$products['package_name']]['qty'] += $products['quantity'];
				if(empty($sale_summary['ubayam'][$products['package_name']]['total'])) $sale_summary['ubayam'][$products['package_name']]['total'] = 0;
				$sale_summary['ubayam'][$products['package_name']]['total'] += $products['amount'];
				if(empty($sale_summary['ubayam'][$products['package_name']]['ledger_code'])) $sale_summary['ubayam'][$products['package_name']]['ledger_code'] = $products['ledger_code'];

				$productName = $products['package_name'];
				?>
				<tr>
					<td align="left">
						<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">
							<?php echo $productName; ?>
						</p>
					</td>
					<td align="left">
						<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">
							<?php echo $ubayam_detail['customer_name']; ?>
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
	?>
	<?php
	$Kattalai_archanai_total = 0;
	$sale_summary['kattalai archanai'] = array();
	if (count($Kattalai_archanai_details) > 0) {
		?>
	<hr>
	<p style="text-align:center; font-size:13px;text-transform: uppercase;"> Kattalai Archanai Details</p>
	<?php if (!empty($katt_inv_no['first_ref_no']) && !empty($katt_inv_no['last_ref_no'])) { ?>
		<?php if ($katt_inv_no['first_ref_no'] != $katt_inv_no['last_ref_no']) { ?>
			<p style="text-align: center">( <?php echo $katt_inv_no['first_ref_no']; ?> - <?php echo $katt_inv_no['last_ref_no']; ?> )</p>
		<?php } else { ?>
			<p style="text-align: center">( <?php echo $katt_inv_no['first_ref_no']; ?> )</p>
		<?php } 
	}?>
	<hr>
	<table style="width:100%;">
		<tr>
			<th align="left" colspan="2">
				<p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;">Product</p>
			</th>
			<th align="right">
				<p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;">Amount (S$)</p>
			</th>
		</tr>
		<?php
		foreach ($Kattalai_archanai_details as $Kattalai_archanai_detail) {
			$Kattalai_archanai_total += $Kattalai_archanai_detail['paidamount'];

			if (empty($summary_total['sales'][$Kattalai_archanai_detail['paymentmode']]))
					$summary_total['sales'][$Kattalai_archanai_detail['paymentmode']] = 0;
				$summary_total['sales'][$Kattalai_archanai_detail['paymentmode']] += $Kattalai_archanai_detail['paidamount'];

			foreach ($Kattalai_archanai_detail['products'] as $product) {
				if(empty($sale_summary['kattalai archanai'][$products['package_name']]['name_eng'])) $sale_summary['kattalai archanai'][$products['package_name']]['name_eng'] = $products['package_name'];
				$sale_summary['kattalai archanai'][$products['package_name']]['qty'] += $products['quantity'];
				if(empty($sale_summary['kattalai archanai'][$products['package_name']]['total'])) $sale_summary['kattalai archanai'][$products['package_name']]['total'] = 0;
				$sale_summary['kattalai archanai'][$products['package_name']]['total'] += $products['amount'];
				if(empty($sale_summary['kattalai archanai'][$products['package_name']]['ledger_code'])) $sale_summary['kattalai archanai'][$products['package_name']]['ledger_code'] = $products['ledger_code'];

				$productName = $product['package_name'];
				?>
				<tr>
					<td align="left" colspan="2">
						<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">
							<?php echo $productName; ?>
						</p>
					</td>
					<td align="right">
						<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;font-weight:bold;">
							<?php echo number_format($Kattalai_archanai_detail['paidamount'], 2); ?>
						</p>
					</td>
				</tr>
				<?php
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
					<?php echo number_format($Kattalai_archanai_total, 2); ?>
				</p>
			</td>
		</tr>
	</table>
	<?php
	}
	?>
	<?php
	$outdoor_services_total = 0;
	$sale_summary['outdoor services'] = array();
	if (count($outdoor_services_details) > 0) {
		// echo '<pre>';
		// print_r($outdoor_services_details);
		// exit;
		?>
	<hr>
	<p style="text-align:center; font-size:13px;text-transform: uppercase;"> Outdoor Services</p>
	<hr>
	<table style="width:100%;">
		<tr>
			<th align="left" colspan="2">
				<p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;"> Product</p>
			</th>
			<th align="right">
				<p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;">Amount (S$)</p>
			</th>
		</tr>
		<?php
		foreach ($outdoor_services_details as $outdoor_services_detail) {
			$outdoor_services_total += $outdoor_services_detail['paidamount'];
			
			if (empty($summary_total['sales'][$outdoor_services_detail['paymentmode']]))
					$summary_total['sales'][$outdoor_services_detail['paymentmode']] = 0;
				$summary_total['sales'][$outdoor_services_detail['paymentmode']] += $outdoor_services_detail['paidamount'];

			foreach ($outdoor_services_detail['products'] as $product) {
				if(empty($sale_summary['outdoor services'][$products['package_name']]['name_eng'])) $sale_summary['outdoor services'][$products['package_name']]['name_eng'] = $products['package_name'];
				$sale_summary['outdoor services'][$products['package_name']]['qty'] += $products['quantity'];
				if(empty($sale_summary['outdoor services'][$products['package_name']]['total'])) $sale_summary['outdoor services'][$products['package_name']]['total'] = 0;
				$sale_summary['outdoor services'][$products['package_name']]['total'] += $products['amount'];
				if(empty($sale_summary['outdoor services'][$products['package_name']]['ledger_code'])) $sale_summary['outdoor services'][$products['package_name']]['ledger_code'] = $products['ledger_code'];

				$productName = $product['package_name'];
				?>
				<tr>
					<td align="left" colspan="2">
						<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">
							<?php echo $productName; ?>
						</p>
					</td>
					<td align="right">
						<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;font-weight:bold;">
							<?php echo number_format($outdoor_services_detail['paidamount'], 2); ?>
						</p>
					</td>
				</tr>
				<?php
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
					<?php echo number_format($outdoor_services_total, 2); ?>
				</p>
			</td>
		</tr>
	</table>
	<?php
	}
	?>
	<?php
	$repayment_total = 0;
	if (count($repayment_details) > 0) {
		?>
	<hr>
	<p style="text-align:center; font-size:13px;text-transform: uppercase;"> Repayment Details</p>
	<hr>
	<table style="width:100%;">
		<tr>
			<th align="left" colspan="2">
				<p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;"> Product</p>
			</th>
			<th align="right">
				<p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;">Amount (S$)</p>
			</th>
		</tr>
		<?php
		foreach ($repayment_details as $details) {
			$repayment_total += $details['repaid_amount'];
			$productName = $details['type'];
			
			if (empty($summary_total['sales'][$details['paymentmode']]))
				$summary_total['sales'][$details['paymentmode']] = 0;
			$summary_total['sales'][$details['paymentmode']] += $details['repaid_amount'];
			?>
			<tr>
				<td align="left" colspan="2">
					<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">
						<?php echo $productName; ?>
					</p>
				</td>
				<td align="right">
					<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;font-weight:bold;">
						<?php echo number_format($details['repaid_amount'], 2); ?>
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
					<?php echo number_format($repayment_total, 2); ?>
				</p>
			</td>
		</tr>
	</table>
	<?php
	}
	?>
	<?php
	$catering_total = 0;
	$sale_summary['catering'] = array();
	if (count($catering_details) > 0) {
	?>
	<hr>
	<p style="text-align:center; font-size:13px;text-transform: uppercase;"> Catering Details</p>
	<?php if (!empty($cat_inv_no['first_ref_no']) && !empty($cat_inv_no['last_ref_no'])) { ?>
		<?php if ($cat_inv_no['first_ref_no'] != $cat_inv_no['last_ref_no']) { ?>
			<p style="text-align: center">( <?php echo $cat_inv_no['first_ref_no']; ?> - <?php echo $cat_inv_no['last_ref_no']; ?> )</p>
		<?php } else { ?>
			<p style="text-align: center">( <?php echo $cat_inv_no['first_ref_no']; ?> )</p>
		<?php } 
	}?>
	<hr>
	<table style="width:100%;">
		<tr>
			<th align="left">
				<p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;"> Name</p>
			</th>
			<th colspan="2" align="right">
				<p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;">Amount (S$)</p>
			</th>
		</tr>
		<?php
		foreach ($catering_details as $catering_detail) {
			$catering_total = $catering_total + $catering_detail['total_amount'];
			if (empty($summary_total['sales'][$catering_detail['paymentmode']]))
				$summary_total['sales'][$catering_detail['paymentmode']] = 0;
			$summary_total['sales'][$catering_detail['paymentmode']] += $catering_detail['paidamount'];

			foreach ($catering_detail['products'] as $products) {
				if(empty($sale_summary['catering'][$products['package_name']]['name_eng'])) $sale_summary['catering'][$products['package_name']]['name_eng'] = $products['package_name'];
				$sale_summary['catering'][$products['package_name']]['qty'] += $products['quantity'];
				if(empty($sale_summary['catering'][$products['package_name']]['total'])) $sale_summary['catering'][$products['package_name']]['total'] = 0;
				$sale_summary['catering'][$products['package_name']]['total'] += $products['total_amount'];
				if(empty($sale_summary['catering'][$products['package_name']]['ledger_code'])) $sale_summary['catering'][$products['package_name']]['ledger_code'] = $products['ledger_code'];
				
				$productName = $products['package_name'];
				?>
				<tr>
					<td align="left">
						<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">
							<?php echo $catering_detail['customer_name']; ?>
						</p>
					</td>
					<td colspan="2" align="right">
						<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;font-weight:bold;">
							<?php echo number_format($catering_detail['paidamount'], 2); ?>
						</p>
					</td>
				</tr>
			<?php
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
					<?php echo number_format($catering_total, 2); ?>
				</p>
			</td>
		</tr>
	</table>
	<?php
	}
	?>
	<?php
	$total_grams = 0;
	if (count($product_offering_details) > 0) {
		?>
	<hr>
	<p style="text-align:center; font-size:13px;text-transform: uppercase;"> Product Offering</p>
	<hr>
	<table style="width:100%;">
		<tr>
			<th align="left" colspan="2">
				<p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;">Product</p>
			</th>
			<th align="right">
				<p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;">Amount (S$)</p>
			</th>
		</tr>
		<?php
		foreach ($product_offering_details as $details) {
			$total_grams += $details['grams'];
			$productName = $details['product_name'];

			if (empty($summary_total['sales'][$details['paymentmode']]))
				$summary_total['sales'][$details['paymentmode']] = 0;
			$summary_total['sales'][$details['paymentmode']] += $details['grams'];
				?>
				<tr>
					<td align="left" colspan="2">
						<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">
							<?php echo $productName; ?>
						</p>
					</td>
					<td align="right">
						<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;font-weight:bold;">
							<?php echo $details['grams']; ?> Grams
						</p>
					</td>
				</tr>
				<?php
		}
		?>
	</table>
	<?php
	}
	?>
<?php
$member_total = 0;
$sale_summary['member'] = array();
if (count($member_details) > 0) {
	?>
	<hr>
	<p style="text-align:center; font-size:13px;text-transform: uppercase;"> Member Registration Details</p>
	<hr>
	<table style="width:100%;">
		<tr>
			<th align="left">
				<p style="margin:2px 0px;font-size:11px;font-weight:bold;">Name</p>
			</th>
			<th align="left">
				<p style="margin:2px 0px;font-size:11px;font-weight:bold;">Type</p>
			</th>
			<th align="right">
				<p style="margin:2px 0px;font-size:11px;font-weight:bold;">Amount (S$)</p>
			</th>
		</tr>
		<?php
		foreach ($member_details as $member_detail) {
			$member_total += floatval($member_detail['payment']);
			$memberTypeName = $member_detail['member_type_name'];

			if (!isset($sale_summary['member'][$memberTypeName])) {
				$sale_summary['member'][$memberTypeName] = [
					'name_eng' => $memberTypeName,
					'ledger_code' => 0,
					'qty' => 0,
					'total' => 0
				];
			}

			$sale_summary['member'][$memberTypeName]['qty'] += 1;
			$sale_summary['member'][$memberTypeName]['total'] += floatval($member_detail['payment']);

			if (empty($summary_total['sales'][$member_detail['paymentmode']]))
				$summary_total['sales'][$member_detail['paymentmode']] = 0;
			$summary_total['sales'][$member_detail['paymentmode']] += floatval($member_detail['payment']);
			?>
			<tr>
				<td align="left">
					<p style="margin:2px 0px;font-size:9px;">
						<?php echo substr($member_detail['name'], 0, 15); ?>
					</p>
				</td>
				<td align="left">
					<p style="margin:2px 0px;font-size:9px;">
						<?php echo substr($member_detail['member_type_name'], 0, 10); ?>
					</p>
				</td>
				<td align="right">
					<p style="margin:2px 0px;font-size:10px;font-weight:bold;">
						<?php echo number_format($member_detail['payment'], 2); ?>
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
					<?php echo number_format($member_total, 2); ?>
				</p>
			</td>
		</tr>
	</table>
	<?php
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
												<th style="padding: 5px 10px!important;">S.No</th>
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
		<?php
		if (count($sale_summary)) {
			$sale_summary_qty = 0;
			$sale_summary_amount = 0;
			echo '<div class="col-md-12"><h3>Sale Summary</h3></div><div class="table-responsive col-md-12" style="background:#FFF; float:none;margin-bottom:0px;"><table class="table-responsive col-md-12" style="width:100%;"><thead><tr><th align="left">Item</th><th align="right">Qty</th><th align="right">Amount (S$)</th></tr></thead><tbody>';
			foreach ($sale_summary as $key => $values) {
				if (!empty($values)){
					echo '<tr><td colspan="3"><h4 class="capitalize">' . $key . '</h4></td></tr>';
					if (count($values)) {
						foreach ($values as $item) {
							$sale_summary_qty += $item['qty'];
							$sale_summary_amount += $item['total'];
							echo '<tr>';
							echo '<td><p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">' . $item['name_eng'] . '(' . $item['ledger_code'] . ')</p></td>';
							echo '<td align="right"><p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">' . $item['qty'] . '</p></td>';
							echo '<td align="right"><p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">' . number_format($item['total'], 2) . '</p></td>';
							echo '</tr>';
						}
					}
				}
			}
			echo '</tbody><tfoot><tr><th>Total</th><th align="right">' . $sale_summary_qty . '</th><th align="right">' . number_format($sale_summary_amount, 2) . '</th></tr></tfoot></table></div>';
		}

		?>
		<hr>
		<?php
		if (count($summary_total['sales'])) {
			$cash_total = 0;

			// Define your preferred order
			$payment_order = ['CASH', 'NETS', 'PAY NOW', 'CHEQUE', 'ONLINE'];

			echo '<div class="col-md-12"><h3>Payment Summary</h3></div>';
			echo '<div class="table-responsive col-md-12" style="background:#FFF; float:none;margin-bottom:0px;">';
			echo '<table class="table-responsive col-md-12" style="width:100%;">';
			echo '<thead><tr><th align="left">Payment</th><th align="right">Amount (S$)</th></tr></thead><tbody>';

			// Loop through the preferred order first
			foreach ($payment_order as $ordered_name) {
				foreach ($summary_total['sales'] as $vl => $st) {
					$paymentname = strtoupper(str_replace('_', ' ', $vl));
					if ($paymentname == $ordered_name && $st > 0) {
						if ($paymentname == 'CASH') {
							$cash_total += $st;
						}
						echo '<tr>';
						echo '<td><p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">' . $paymentname . '</p></td>';
						echo '<td align="right"><p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">' . number_format($st, 2) . '</p></td>';
						echo '</tr>';
					}
				}
			}

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
					$total = $archanai_total + $prasadam_total + $donation_total + $annathanam_total + $ubayam_total + $hallbooking_total + $Kattalai_archanai_total + $outdoor_services_total + $repayment_total + $catering_total + $member_total;
					echo number_format($total, '2', '.', ',');
					?>
				</p>
			</td>
		</tr>
	</table>
<br>
<h3>Checked by : <?php echo $floating_cash['checked_by'] ?></h3>



		<br>
		<br>
		<h4>SIGN</h4>
	<hr>
</div>
<br>
<!-- <p  class="dot_line" style="max-width: 80mm;font-weight: 600;font-family: monospace;text-align: center;"><span>--</span>GRASP SOFTWARE SOLUTIONS SDN. BHD.<span>--</span></p> -->
<script>
	window.print();
	//setTimeout(function(){window.close();},4500);
</script>