<title>
	<?php echo $_SESSION['site_title']; ?>
</title>
<?php $db = db_connect(); ?>
<style>
    body {
			width: 100%;
			font-family: Arial, sans-serif;
			/* Ensure text is easily readable */
		}
		
		.header {
			width: 100%;
			text-align: center;
			margin-bottom: 20px;
		}

		.header img {
			width: 120px;
			/* Adjust size as needed */
			float: left;
			/* Align image to the left */
		}

		.header-text {
			text-align: center;
			display: inline-block;
			width: 80%;
			/* Adjust based on logo width */
		}
	td {
		padding: 5px;
	}

	table {
		border-collapse: collapse;
		width: 100%;
	}
	.my_table tr td{
		border: 1px solid black;
	}
	div.head {
		text-align: center;
		margin-bottom: 30px;
	}

	h2,
	h5 {
		margin: 2px;
	}

	P {
		margin: 25px 0;
	}

	ol li {
		font-weight: bold;
		line-height: 20px;
		margin-bottom: 10px;
	}

	h2 {
		font-size: 20px;
	}
	.since { position: absolute;margin-left: 487px; }
</style>

<head>

<body width="100%">
	<?php
	// Create a function for converting the amount in words
	
	if (!function_exists('AmountInWords')) {
		function AmountInWords(float $amount)
		{
			$amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
			$get_paise = ($amount_after_decimal > 0) ? " and Cents " . trim(NumToWords($amount_after_decimal)) : '';
			return (NumToWords($amount) ? 'Ringgit ' . trim(NumToWords($amount)) . '' : '') . $get_paise . ' Only';

		}
	}
	if (!function_exists('NumToWords')) {
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
	}
	
	?>
	<table align="center" width="100%">
		<tr>
			<td colspan="2">
				<table style="width:100%">
					<tr><td width="100%" colspan="2" style="text-align:center;"><img src="<?php echo base_url(); ?>/uploads/header/temple_header1.jpg"></td></tr>
				</table>
				<br>
				<hr>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<h3 style="text-align:center; margin:0;">Official Receipt</h3>
                <table style="width:100%" border="0">
					<tr>
						<td style="width:50%">
							<p style="vertical-align: middle;">Official Receipt Number  : <span style="border-bottom:1px solid #CCCCCC; width:27%; padding-top:4px; vertical-align: middle; text-align:right; padding-right:8px; display: inline-grid;">
									<?php echo ""; ?>
								</span> </p>
						</td>
						<td style="width:50%" align="right">
							<p style="vertical-align: middle;">DATE : <span style="border-bottom:1px solid #CCCCCC; width:27%; padding-top:4px; vertical-align: middle; text-align:right; padding-right:8px; display: inline-grid;">
									<?php echo date('d/m/Y', strtotime($rental['created_at'])); ?>
								</span> </p>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<table style="width:100%; border: 1px solid black;" class="my_table" border="1">
								<tr>
									<td>RECEIVED FROM : </td><td><span style="width:75%;display: inline-grid;"><?php echo $rental['payee_name']; ?></span></td>
								</tr>
								<tr>
									<td>RINGGIT MALAYSIA : </td><td><span style="width:75%;display: inline-grid;"><?php echo AmountInWords($rental['amount']); ?></span></td>
								</tr>
								<tr>
									<td>HOUSE/LAND RENT NO : </td><td><span style="width:75%;display: inline-grid;"><?php echo $rental['lot_no']; ?>(
										<?php echo $rental['area']; ?>)</span></td>
								</tr>
								<tr>
									<td>FOR THE MONTH : </td><td><span style="width:75%;display: inline-grid;"><?php echo $rental['month_year']; ?></span></td>
								</tr>
                                <tr>
									<td>RM : </td><td><span style="width:75%;display: inline-grid;"><?php echo $rental['amount']; ?></span></td>
								</tr>

							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<p style="text-align:center;"><b>REMINDER</b></p>
			</td>
		</tr>
		<tr>
			<td colspan="2" style="width:100%">
				<ol>
					<li>Strictly no transfer of tenancy is allowed by the tenant. </li>
					<li>Rental should be settled on or before 7th of each month. </li>
				</ol>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<p style="text-align:center;"><b>No signature required as this is a computer generated receipt</b></p>
			</td>
		</tr>
	</table>
	<script>
		// window.print();
	</script>
</body>