<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title><?php echo $_SESSION['site_title']; ?></title>
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

		table {
			width: 100%;
			border-collapse: collapse;
		}

		td,
		th {
			padding: 10px;
			/* Adjust padding as needed */
			text-align: left;
		}

		.details {
			margin: 25px 0;
		}

		.details p {
			margin: 10px 0;
			/* Reduce space between paragraphs */
		}
		.since { position: absolute;margin-left: 487px; }
		.since1 { position: absolute;margin-left: 387px; }
	</style>
</head>

<body>
	<!--<div class="header">
	<table style="width:100%">
    <tr><td width="15%" align="left"><img src="<?php echo base_url(); ?>/uploads/main/<?php echo $_SESSION['logo_img']; ?>" style="width:120px;" align="left"></td>
    <td width="85%" align="left">
        <h2 style="text-align:center;margin-bottom: 0;font-size: 18px;"><?php echo $_SESSION['site_title']; ?></h2>
        <span class="since"><?php echo $_SESSION['since_eng']; ?></span>
        <p style="text-align:center; font-size:16px; margin:5px 0px;"><span><?php echo $_SESSION['city']; ?></span></p>
        <p style="text-align:center; font-size:16px; margin:5px 0px;"><?php echo $_SESSION['address1']; ?>, <?php echo $_SESSION['address2']; ?>,
        <?php echo $_SESSION['postcode']; ?> <?php echo $_SESSION['city']; ?>  <br>
        Tel : <?php echo $_SESSION['telephone']; ?></p></td></tr>
    </table>-->
    <table style="width:100%">
        <tr><td width="15%" align="left"><img src="<?php echo base_url(); ?>/uploads/main/<?php echo $_SESSION['logo_img']; ?>" style="width:120px;" align="left"></td>
        <td width="85%" align="left">
        <h3 style="text-align:center;margin-bottom: 0;"><?php echo $_SESSION['name_tamil']; ?></h3>
        <p style="text-align:center; font-size:16px; margin:0;"><?php echo $_SESSION['city_tamil']; ?> <?php echo $_SESSION['since_tamil']; ?>
        <h2 style="text-align:center;margin-bottom: 0; margin-top:8px;"><?php echo $_SESSION['site_title']; ?></h2>
        <p style="text-align:center; font-size:16px; margin:0px;"><?php echo $_SESSION['city']; ?> <?php echo $_SESSION['since_eng']; ?><br><?php echo $_SESSION['address1']; ?>, <?php echo $_SESSION['address2']; ?>,
        <?php echo $_SESSION['postcode']; ?> <?php echo $_SESSION['city']; ?>  <br>
        Tel : <?php echo $_SESSION['telephone']; ?></p>
        </td></tr>
    </table>
	<br>
	<hr>
	</div>
	<div class="details">
		<p><strong>Dear Sir/Madam,</strong></p>
		<p>1st reminder on Rental Due.</p>
		<br>
		<p>Greetings from Arulmigu Rajamariamman Devasthanam!</p>
		<br>
		<p>2. Please be informed on the rental due.</p>
		<br>
		<p>Details as per below:</p>
		<br>
		<p>Lot no: <strong><?php echo $rental['lot_no']; ?></strong></p>
		<p>Rent Due: <strong><?php echo $rental['amount']; ?></strong></p>
		<p>Month: <strong><?php echo $rental['month_year']; ?></strong></p>
		<?php
		// Calculate late payment fees
		$late_payment_fees = $rental['amount'] * 0.05;

		// Calculate total amount due
		$total_due = $rental['amount'] + $late_payment_fees;
		?>

		<p>
			Late payment fees (5%): <strong><?php echo number_format($late_payment_fees, 2); ?></strong>
		</p>
		<p>
			Total due: <strong><?php echo number_format($total_due, 2); ?></strong>
		</p>
		<br>
		<p>3. Kindly made the payment to avoid any legal action.</p>
		<br>
		<p style="text-align: center;">Thank you.</p>
		<p style="text-align: center;">This is a computer generated document. No signature is required.</p>
	<!--</div>-->
	<script>
		window.print();
	</script>
</body>

</html>