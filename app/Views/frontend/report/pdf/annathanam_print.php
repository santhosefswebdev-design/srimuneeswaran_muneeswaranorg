<?php
$db = db_connect();
$temp_details = $pdfdata['temp_details'];
$fdate = $pdfdata['fdate'];
$tdate = $pdfdata['tdate'];
$group_filter = isset($pdfdata['group_filter']) ? $pdfdata['group_filter'] : '';
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>Annathanam Report</title>
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

		.paid_text {
			color: green;
			font-weight: 600;
		}

		.unpaid_text {
			color: blue;
			font-weight: 600;
		}

		.cancel_text {
			color: red;
			font-weight: 600;
		}

		.total-row {
			background-color: #e2dfdf;
			font-weight: bold;
		}
	</style>
</head>

<body>
	<!-- Header Section -->
	<table class="header-table">
		<tr>
			<td class="logo-cell">
				<img src="https://panel.srimuneeswaran.org/uploads/main/1720513577_Logo_image.png" alt="Logo">
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
				ANNATHANAM REPORT
				<?php echo date("d/m/Y", strtotime($fdate)) . ' - ' . date("d/m/Y", strtotime($tdate)); ?>
			</td>
		</tr>
	</table>

	<!-- Data Table -->
	<table class="data-table">
		<thead>
			<tr>
				<th width="5%" style="text-align: center;">S.No</th>
				<th width="12%">Date</th>
				<th width="15%">Invoice No</th>
				<th width="20%">Name</th>
				<th width="28%">Package</th>
				<th width="10%" style="text-align: right;">Amount</th>
				<th width="10%" style="text-align: center;">Status</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$fdt = date('Y-m-d', strtotime($fdate));
			$tdt = date('Y-m-d', strtotime($tdate));

			$builder = $db->table('annathanam_new')
				->select('annathanam_new.*, annathanam_packages.name_eng, annathanam_packages.name_tamil')
				->join('annathanam_packages', 'annathanam_packages.id = annathanam_new.package_id', 'left')
				->where('annathanam_new.date >=', $fdt)
				->where('annathanam_new.date <=', $tdt)
				->where('annathanam_new.booking_status !=', 3);

			// Apply group filter if set
			if (!empty($group_filter) && $group_filter != "0") {
				$builder->where('annathanam_new.payment_type', $group_filter);
			}

			$builder->orderBy('annathanam_new.id', 'desc');
			$results = $builder->get()->getResultArray();

			$sn = 1;
			$total_amount = 0;
			$total_paid = 0;

			if (!empty($results)) {
				foreach ($results as $row) {
					$balance_amount = (float) $row['total_amount'] - (float) $row['paid_amount'];
					if ($balance_amount < 0) {
						$balance_amount = 0;
					}
					$total_amount += (float) $row['total_amount'];
					$total_paid += (float) $row['paid_amount'];

					// Determine status
					if ($row['booking_status'] == 3) {
						$status = '<span class="cancel_text">Cancelled</span>';
					} else {
						if (empty($balance_amount)) {
							$status = '<span class="paid_text">Paid</span>';
						} else {
							$status = '<span class="unpaid_text">Partially Paid</span>';
						}
					}

					$package_name = '';
					if (!empty($row['name_eng'])) {
						$package_name = $row['name_eng'];
					}
					?>
					<tr>
						<td class="center"><?php echo $sn++; ?></td>
						<td><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>
						<td><?php echo $row['ref_no']; ?></td>
						<td><?php echo $row['name']; ?></td>
						<td><?php echo $package_name; ?></td>
						<td class="right"><?php echo number_format($row['total_amount'], 2, '.', ','); ?></td>
						<td class="center"><?php echo $status; ?></td>
					</tr>
					<?php
				}
			} else {
				?>
				<tr>
					<td colspan="7" class="center">No records found</td>
				</tr>
			<?php } ?>

			<!-- Total Row -->
			<?php if (!empty($results)) { ?>
				<tr class="total-row">
					<td colspan="5" style="text-align: right;"><strong>Total:</strong></td>
					<td class="right"><strong><?php echo number_format($total_amount, 2, '.', ','); ?></strong></td>
					<td></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
</body>

</html>