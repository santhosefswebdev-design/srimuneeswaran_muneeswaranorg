<!-- File: app/Views/frontend/report/pdf/offering_print.php -->
<?php
// Handle both PDF (pdfdata array) and Print (separate variables)
if (isset($pdfdata)) {
	// PDF Export - extract from pdfdata array
	$temp_details = $pdfdata['temp_details'];
	$fdate = $pdfdata['fdate'];
	$tdate = $pdfdata['tdate'];
	$type = $pdfdata['type'] ?? '';
	$ptype = $pdfdata['ptype'] ?? '';
	$offering_details = $pdfdata['offering_details'];
	$totalByCategory = $pdfdata['totalByCategory'];
	$totalGrams = $pdfdata['totalGrams'];
} else {
	// Regular Print - use !empty() for proper fallback
	$fdate = !empty($fdate) ? $fdate : date('Y-m-01');
	$tdate = !empty($tdate) ? $tdate : date('Y-m-d');
	$offering_details = isset($offering_details) ? $offering_details : [];
	$totalByCategory = isset($totalByCategory) ? $totalByCategory : [];
	$totalGrams = isset($totalGrams) ? $totalGrams : 0;
	$temp_details = isset($temp_details) ? $temp_details : [];
}

// Validate dates - prevent 1970 issue
if (strtotime($fdate) === false || strtotime($fdate) < strtotime('2000-01-01')) {
	$fdate = date('Y-m-01');
}
if (strtotime($tdate) === false || strtotime($tdate) < strtotime('2000-01-01')) {
	$tdate = date('Y-m-d');
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>Offering Report</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			font-size: 12px;
			margin: 0;
			padding: 10px;
		}

		.header-table {
			width: 100%;
			border-collapse: collapse;
			margin-bottom: 10px;
		}

		.header-table td {
			border: 1px solid #000;
			vertical-align: top;
		}

		.logo-cell {
			width: 15%;
			padding: 5px;
		}

		.logo-cell img {
			width: 100px;
			height: auto;
		}

		.info-cell {
			width: 85%;
			padding: 0;
		}

		.info-cell table {
			width: 100%;
			border-collapse: collapse;
		}

		.info-cell td {
			border: none;
			text-align: center;
			padding: 3px;
		}

		.temple-name {
			font-size: 16px;
			font-weight: bold;
			margin: 0;
		}

		.temple-address {
			font-size: 12px;
			margin: 0;
		}

		.report-title {
			text-align: center;
			font-size: 14px;
			font-weight: bold;
			padding: 8px;
		}

		.data-table {
			width: 100%;
			border-collapse: collapse;
			margin-top: 10px;
		}

		.data-table th,
		.data-table td {
			border: 1px solid #000;
			padding: 5px;
			font-size: 11px;
		}

		.data-table th {
			background-color: #f0f0f0;
			font-weight: bold;
			text-align: left;
		}

		.data-table td.center {
			text-align: center;
		}

		.data-table td.right {
			text-align: right;
		}

		.total-row {
			background-color: #e2dfdf;
			font-weight: bold;
		}

		@media print {
			.no-print {
				display: none !important;
			}
		}
	</style>
</head>

<body>
	<!-- Print Button (hidden in PDF) -->
	<?php if (!isset($pdfdata)) { ?>
		<div class="no-print" style="text-align: center; margin-bottom: 10px;">
			<button onclick="window.print();" style="padding: 10px 20px; font-size: 14px; cursor: pointer;">
				🖨️ Print Report
			</button>
			<button onclick="window.close();"
				style="padding: 10px 20px; font-size: 14px; cursor: pointer; margin-left: 10px;">
				❌ Close
			</button>
		</div>
	<?php } ?>
	<table class="header-table">
		<tr>
			<td class="logo-cell">
				<img src="<?php echo base_url(); ?>/uploads/main/<?php echo $temp_details['image'] ?? ''; ?>" alt="Logo"
					style="width:100px;">
			</td>
			<td class="info-cell">
				<table>
					<tr>
						<td>
							<p class="temple-name"><?php echo $temp_details['name']; ?></p>
						</td>
					</tr>
					<tr>
						<td>
							<p class="temple-address"><?php echo $temp_details['address1']; ?>,
								<?php echo $temp_details['address2']; ?>
							</p>
						</td>
					</tr>
					<tr>
						<td>
							<p class="temple-address">
								<?php echo $temp_details['city'] . '-' . $temp_details['postcode']; ?>
							</p>
						</td>
					</tr>
					<tr>
						<td>
							<p class="temple-address">Tel: <?php echo $temp_details['telephone']; ?></p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2" class="report-title">
				OFFERING REPORT
				<?php echo date("d/m/Y", strtotime($fdate)) . ' - ' . date("d/m/Y", strtotime($tdate)); ?>
			</td>
		</tr>
	</table>
	<!-- Header Section -->
	<!-- <table class="header-table">
		<tr>
			<td class="logo-cell">
				<?php if (isset($pdfdata)) { ?>
					<img src="https://panel.srimuneeswaran.org/uploads/main/<?php echo $temp_details['image'] ?? '1720513577_Logo_image.png'; ?>"
						alt="Logo">
				<?php } else { ?>
					<img src="<?php echo base_url(); ?>/uploads/main/<?php echo $temp_details['image'] ?? ''; ?>" alt="Logo"
						style="width:100px;">
				<?php } ?>
			</td>
			<td class="info-cell">
				<table>
					<tr>
						<td>
							<p class="temple-name"><?php echo $temp_details['name'] ?? 'Temple Name'; ?></p>
						</td>
					</tr>
					<tr>
						<td>
							<p class="temple-address">
								<?php echo $temp_details['address1'] ?? ''; ?><?php echo !empty($temp_details['address2']) ? ', ' . $temp_details['address2'] : ''; ?>
							</p>
						</td>
					</tr>
					<tr>
						<td>
							<p class="temple-address">
								<?php
								$city = $temp_details['city'] ?? '';
								$postcode = $temp_details['postcode'] ?? '';
								echo !empty($city) || !empty($postcode) ? $city . '-' . $postcode : '';
								?>
							</p>
						</td>
					</tr>
					<tr>
						<td>
							<p class="temple-address">Tel: <?php echo $temp_details['telephone'] ?? ''; ?></p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2" class="report-title">
				OFFERING REPORT
				<?php echo date("d/m/Y", strtotime($fdate)) . ' - ' . date("d/m/Y", strtotime($tdate)); ?>
			</td>
		</tr>
	</table> -->

	<!-- Data Table -->
	<table class="data-table">
		<thead>
			<tr>
				<th width="5%" style="text-align: center;">S.No</th>
				<th width="12%">Date</th>
				  <th width="10%">Ref No</th>
				<th width="20%">Name</th>
				<th width="13%">Phone</th>
				<th width="15%">Category</th>
				<th width="20%">Product</th>
				<th width="17%">Quantity</th>
				<th width="15%" style="text-align: right;">Grams</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$sn = 1;
			if (!empty($offering_details)) {
				foreach ($offering_details as $row) {
					?>
					<tr>
						<td class="center"><?php echo $sn++; ?></td>
						<td><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>
						 <td><?php echo $row['ref_no'] ?? ''; ?></td>
						<td><?php echo $row['name'] ?? ''; ?></td>
						<td><?php echo $row['phone'] ?? ''; ?></td>
						<td><?php echo $row['category_name'] ?? ''; ?></td>
						<td><?php echo $row['product_name'] ?? ''; ?></td>
						<td><?php echo $row['quantity'] ?? ''; ?></td>
						<td class="right"><?php echo number_format($row['grams'] ?? 0, 2); ?></td>
					</tr>
					<?php
				}
			} else {
				?>
				<tr>
					<td colspan="7" class="center">No records found</td>
				</tr>
			<?php } ?>

			<!-- Category Totals -->
			<?php if (!empty($totalByCategory)) { ?>
				<?php foreach ($totalByCategory as $category => $grams) { ?>
					<tr class="total-row">
						<td colspan="7" style="text-align: right;"><strong>Total <?php echo $category; ?>:</strong></td>
						<td class="right"><strong><?php echo number_format($grams, 2); ?></strong></td>
					</tr>
				<?php } ?>
			<?php } ?>

			<!-- Grand Total -->
			<?php if (!empty($offering_details)) { ?>
				<tr class="total-row">
					<td colspan="7" style="text-align: right;"><strong>Grand Total:</strong></td>
					<td class="right"><strong><?php echo number_format($totalGrams ?? 0, 2); ?></strong></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>

	<!-- Auto print for regular view -->
	<?php if (!isset($pdfdata)) { ?>
		<script>
			window.onload = function () {
				window.print();
			}
		</script>
	<?php } ?>
</body>

</html>