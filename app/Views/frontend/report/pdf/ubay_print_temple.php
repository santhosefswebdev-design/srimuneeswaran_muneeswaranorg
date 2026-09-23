<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title><?php echo ($pdfdata['report_type'] == 1) ? 'Hall Booking Report' : 'Ubayam Report'; ?></title>
	<style>
		@page {
			margin: 20px;
		}

		body {
			font-family: 'DejaVu Sans', sans-serif;
			font-size: 10px;
			margin: 0;
			padding: 10px;
		}

		.header {
			margin-bottom: 20px;
			overflow: hidden;
		}

		.header-container {
			display: table;
			width: 100%;
		}

		.logo-section {
			display: table-cell;
			width: 80px;
			vertical-align: top;
			padding-right: 15px;
		}

		.logo-section img {
			width: 70px;
			height: auto;
		}

		.details-section {
			display: table-cell;
			vertical-align: top;
			text-align: center;
		}

		.details-section h2 {
			margin: 5px 0;
			font-size: 16px;
			font-weight: bold;
		}

		.details-section p {
			margin: 3px 0;
			font-size: 10px;
		}

		.report-info {
			margin: 15px 0;
			text-align: center;
			font-weight: bold;
		}

		.report-info h3 {
			margin: 5px 0;
			font-size: 14px;
		}

		.report-info p {
			margin: 3px 0;
			font-size: 10px;
		}

		table {
			width: 100%;
			border-collapse: collapse;
			margin-top: 10px;
		}

		table th {
			background-color: #f0f0f0;
			border: 1px solid #000;
			padding: 8px;
			text-align: left;
			font-weight: bold;
			font-size: 10px;
		}

		table td {
			border: 1px solid #000;
			padding: 6px;
			font-size: 9px;
		}

		.text-right {
			text-align: right;
		}

		.text-center {
			text-align: center;
		}

		.total-row {
			font-weight: bold;
			background-color: #f5f5f5;
		}

		.footer {
			margin-top: 30px;
			text-align: center;
			font-size: 9px;
		}
	</style>
</head>

<body>
	<!-- Header with Logo -->
	<div class="header">
		<div class="header-container">
			<div class="logo-section">
				<img src="https://panel.srimuneeswaran.org/uploads/main/1720513577_Logo_image.png" alt="Temple Logo">
			</div>
			<div class="details-section">
				<h2><?php echo $pdfdata['temp_details']['name'] ?? 'Temple Name'; ?></h2>
				<?php if (!empty($pdfdata['temp_details']['address1'])): ?>
					<p><?php echo $pdfdata['temp_details']['address1']; ?></p>
				<?php endif; ?>
				<?php if (!empty($pdfdata['temp_details']['address2'])): ?>
					<p><?php echo $pdfdata['temp_details']['address2']; ?></p>
				<?php endif; ?>
				<?php if (!empty($pdfdata['temp_details']['city'])): ?>
					<p><?php echo $pdfdata['temp_details']['city']; ?><?php if (!empty($pdfdata['temp_details']['postcode'])): ?>
							- <?php echo $pdfdata['temp_details']['postcode']; ?><?php endif; ?></p>
				<?php endif; ?>
				<?php if (!empty($pdfdata['temp_details']['telephone'])): ?>
					<p>Tel: <?php echo $pdfdata['temp_details']['telephone']; ?></p>
				<?php endif; ?>
				<?php if (!empty($pdfdata['temp_details']['email'])): ?>
					<p>Email: <?php echo $pdfdata['temp_details']['email']; ?></p>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<!-- Horizontal line separator -->
	<div style="border-bottom: 2px solid #000; margin: 10px 0;"></div>

	<!-- Report Title -->
	<div class="report-info">
		<h3><?php echo ($pdfdata['report_type'] == 1) ? 'HALL BOOKING REPORT' : 'UBAYAM REPORT'; ?></h3>
		<p>From: <?php echo date('d-m-Y', strtotime($pdfdata['fdate'])); ?>
			To: <?php echo date('d-m-Y', strtotime($pdfdata['tdate'])); ?></p>
		<?php if (!empty($pdfdata['cdate'])): ?>
			<p>Collection Date: <?php echo date('d-m-Y', strtotime($pdfdata['cdate'])); ?></p>
		<?php endif; ?>
	</div>

	<!-- Data Table -->
	<table>
		<thead>
			<tr>
				<th class="text-center" style="width: 5%;">S.No</th>
				<th style="width: 12%;">Booking Date</th>
				<th style="width: 12%;">Event Date</th>
				       <th style="width: 10%;">Ref No</th>
				<th style="width: 25%;">Event Name</th>
				<th style="width: 20%;">Name</th>
				<th class="text-right" style="width: 10%;">Amount</th>
				<th class="text-right" style="width: 10%;">Paid</th>
				        <th style="width: 12%;">Remarks</th>
				<th class="text-center" style="width: 6%;">Status</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$si = 1;
			$total_amount = 0;
			$total_paid = 0;

			if (!empty($pdfdata['report_data'])):
				foreach ($pdfdata['report_data'] as $row):
					$total_amount += $row['amount'];
					$total_paid += $row['paid_amount'];

					$balance_amount = (float) $row['amount'] - (float) $row['paid_amount'];
					if ($balance_amount < 0)
						$balance_amount = 0;

					// Status text
					if ($row['booking_status'] == 3) {
						$status = 'Cancelled';
					} else {
						if (empty($balance_amount)) {
							$status = 'Paid';
						} else {
							$status = 'Partially Paid';
						}
					}
					?>
					<tr>
						<td class="text-center"><?php echo $si++; ?></td>
						<td><?php echo date('d-m-Y', strtotime($row['entry_date'])); ?></td>
						<td><?php echo date('d-m-Y', strtotime($row['booking_date'])); ?></td>
								   <td><?php echo $row['ref_no'] ?? '-'; ?></td>  
						<td><?php echo $row['pname']; ?></td>
						<td><?php echo $row['name']; ?></td>
						<td class="text-right"><?php echo number_format($row['amount'], 2); ?></td>
						<td class="text-right"><?php echo number_format($row['paid_amount'], 2); ?></td>
								       <td><?php echo $row['description'] ?? '-'; ?></td> 
						<td class="text-center"><?php echo $status; ?></td>
					</tr>
				<?php
				endforeach;
			else:
				?>
				<tr>
					<td colspan="8" class="text-center">No records found</td>
				</tr>
			<?php endif; ?>

			<?php if (!empty($pdfdata['report_data'])): ?>
				<tr class="total-row">
					<td colspan="5" class="text-right"><strong>Total:</strong></td>
					<td class="text-right"><strong><?php echo number_format($total_amount, 2); ?></strong></td>
					<td class="text-right"><strong><?php echo number_format($total_paid, 2); ?></strong></td>
					<td></td>
				</tr>
			<?php endif; ?>
		</tbody>
	</table>

	<!-- Footer -->
	<div class="footer">
		<p>Generated on: <?php echo date('d-m-Y h:i A'); ?></p>
	</div>
</body>

</html>