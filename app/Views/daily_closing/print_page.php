<?php $db = db_connect(); ?>
<?php
	$summary_total = array();
	$summary_total['sales'] = array();
	$summary_total['expense'] = array();
?>
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
<div style="max-width: 80mm;max-height: 355px;font-weight: 600;font-family: monospace;">
<div style="text-align:center">
				<p><img src="<?php echo base_url(); ?>/uploads/main/<?php echo $_SESSION['logo_img']; ?>" style="width:120px;"
						align="center"></p>
						<p style="font-size:11px; font-weight:bold;">
					<?php echo $temp_details['name_tamil']; ?>
				</p>
				<p style="font-size:9px;">
				<?php echo $_SESSION['city_tamil']; ?> <?php echo $temp_details['since_tamil']; ?>
					
				</p>
				<p style="font-size:16px;">
					<?php echo $_SESSION['site_title']; ?>
				</p>
				<p style="font-size:12px;">
				<?php echo $_SESSION['city']; ?> <?php echo $temp_details['since_eng']; ?>,<br>
					<?php echo $temp_details['address1']; ?>,
					<?php echo $temp_details['address2']; ?>,
					<?php echo $temp_details['postcode']; ?>
					<?php echo $temp_details['city'];?>.
					<br>Tel:
					<?= $temp_details['telephone']; ?>
				</p>
</div>
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
				<p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;">Amount</p>
			</th>
		</tr>

		<?php
												$archanai_total = 0;
												$archanai_qty = 0;
												$archanai_diety_details = $archanai_diety_details ?? [];
												if(count($archanai_diety_details) > 0)
												{
													foreach($archanai_diety_details as $archanai_detail_data)
													{
														if(count($archanai_detail_data['data']) > 0){
															$ar_i = 1;
															$sannathi_total = 0;
															$sannathi_qty = 0;
															// echo '<tr><td colspan="5" style="text-align: center;"><h4>' . $archanai_detail_data['title'] . '</h4></td></tr>';
															foreach($archanai_detail_data['data'] as $archanai_detail){
																$archanai_total = $archanai_total + $archanai_detail['amount'];
																$sannathi_total = $sannathi_total + $archanai_detail['amount'];
																$sannathi_qty = $sannathi_qty + $archanai_detail['qty'];
																$archanai_qty = $archanai_qty + $archanai_detail['qty'];
																if(empty($summary_total['sales'][$archanai_detail['paymentmode']])) $summary_total['sales'][$archanai_detail['paymentmode']] = 0;
																$summary_total['sales'][$archanai_detail['paymentmode']] += $archanai_detail['amount'];
																?>
																<tr>
																	<!-- <td style="padding: 5px 10px!important;"><?php echo $ar_i; ?></td>
																	<td style="padding: 5px 10px!important;">
																		<?php 
																			echo $archanai_detail['name_in_english']." / ".$archanai_detail['name_in_tamil'];
																		?>
																	</td> -->
																	<!-- <td style="padding: 5px 10px!important;text-transform: uppercase;"> -->
																	<?php if ($archanai_detail['paid_through'] == 'DIRECT') {
																			$paymentname = strtoupper($archanai_detail['paymentmode']);
																		} else {
																			if ($archanai_detail['paymentmode'] == "ipay_merch_qr") {
																				$paymentname = "QR PAYMENT";
																			} elseif ($archanai_detail['paymentmode'] == "ipay_merch_online") {
																				$paymentname = "ONLINE PAYMENT";
																			} elseif ($archanai_detail['paymentmode'] == "cash") {
																				$paymentname = strtoupper($archanai_detail['paymentmode']);
																			} else {
																				$paymentname = strtoupper($archanai_detail['paymentmode']);
																			}
																		}
																		// echo $paymentname; ?>
																	</td>
																	
																</tr>
																<?php
																	$ar_i++;
															}
															//echo '<tr><td colspan="3" style="text-align: center;"><h6>' . $archanai_detail_data['title'] . ' Total</h4></td><td style="padding: 5px 10px!important;text-align:right;font-weight:bold;">' . $sannathi_qty . '</td><td style="padding: 5px 10px!important;text-align:right;font-weight:bold;">' . number_format($sannathi_total, 2) . '</td></tr>';
														}
													}
												}
												?>

		<?php
		$archanai_total = 0;
		if (count($archanai_details) > 0) {
			foreach ($archanai_details as $archanai_detail) {
				$archanai_total = $archanai_total + $archanai_detail['amount'];
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
				<p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;">Amount</p>
			</th>
		</tr>
		<?php
		foreach ($hallbooking_details as $hallbooking_detail) {
			$hallbooking_total = $hallbooking_total + $hallbooking_detail['paidamount'];
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
				<p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;">Amount</p>
			</th>
		</tr>
		<?php
		foreach ($ubayam_details as $ubayam_detail) {
			$ubayam_total = $ubayam_total + $ubayam_detail['paidamount'];
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
				<p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;">Amount</p>
			</th>
		</tr>
		<?php
		foreach ($donation_details as $donation_detail) {
			$donation_total = $donation_total + $donation_detail['paidamount'];
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
				<p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;">Amount</p>
			</th>
		</tr>
		<?php
		foreach ($prasadam_details as $prasadam_detail) {
			$prasadam_total = $prasadam_total + $prasadam_detail['paidamount'];
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
	?>
	<?php
	$receipt_voucher_total = 0;
	if (count($receipt_voucher_details) > 0) {
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
				<p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;">Amount</p>
			</th>
		</tr>
		<?php
		foreach ($receipt_voucher_details as $receipt_voucher_detail) {
			$receipt_voucher_total = $receipt_voucher_total + $receipt_voucher_detail['paidamount'];
			?>
			<tr>
				<td align="left" colspan="2">
					<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">
						<?php echo $receipt_voucher_detail['paid_to']; ?>
					</p>
				</td>
				<td align="right">
					<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;font-weight:bold;">
						<?php echo number_format($receipt_voucher_detail['paidamount'], 2); ?>
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
					<?php echo number_format($receipt_voucher_total, 2); ?>
				</p>
			</td>
		</tr>
	</table>
	<?php
	}
	?>
	<hr>
	<?php
	$repayment_total = 0;
	if (!empty($repayment_details) && count($repayment_details) > 0) {
		?>
		<hr>
		<p style="text-align:center; font-size:13px;text-transform: uppercase;"> Repayment Details</p>
		<hr>
		<table style="width:100%;">
			<tr>
				<th align="left">
					<p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;">Type</p>
				</th>
				<th align="left">
					<p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;">Name</p>
				</th>
				<th align="right">
					<p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;">Amount</p>
				</th>
			</tr>
			<?php
			foreach ($repayment_details as $details) {
				$repayment_total += $details['repaid_amount'];
				?>
				<tr>
					<td align="left">
						<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">
							<?php echo $details['type']; ?>
						</p>
					</td>
					<td align="left">
						<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">
							<?php echo $details['customer_name']; ?>
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
	<h3 style="text-align: center; font-weight: bold;">Summary</h3>
        <table style="width:100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $cash_total = 0;
                if (isset($summary_total['sales']) && count($summary_total['sales'])) {
                    foreach ($summary_total['sales'] as $payment_type => $amount) {
                        if ($payment_type == 'cash') {
                            $cash_total += $amount;
                        }
                        echo "<tr>
                                <td style='padding: 5px; text-align: left;'>" . strtoupper($payment_type) . " Sales</td>
                                <td style='padding: 5px; text-align: right;'>" . number_format($amount, 2) . "</td>
                              </tr>";
                    }
                }
                ?>
            </tbody>
			</table>
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
					$total = $archanai_total + $hallbooking_total + $ubayam_total + $donation_total + $prasadam_total + $receipt_voucher_total + $repayment_total;
					echo number_format($total, '2', '.', ',');
					?>
				</p>
			</td>
		</tr>
	</table>

	<hr>
</div>
<br>
<!-- <p  class="dot_line" style="max-width: 80mm;font-weight: 600;font-family: monospace;text-align: center;"><span>--</span>GRASP SOFTWARE SOLUTIONS SDN. BHD.<span>--</span></p> -->
<script>
	window.print();
	//setTimeout(function(){window.close();},4500);
</script>