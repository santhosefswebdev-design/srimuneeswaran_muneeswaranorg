<style>
	.print-wrap {
		width: 1000px;
		margin: 0 auto;
		font-family: Arial, Helvetica, sans-serif;
	}

	.table1 {
		border: 1px solid #CCCCCC;
	}

	.table1 tr th {
		background-color: #EFEFEF;
		padding: 5px;
		min-width: 130px;
		font-size: 16px;
	}

	.table1 tr td:first-child {
		padding: 5px;
		text-align: left;
	}

	.table1 tr td {
		padding: 5px;
		text-align: right;
	}
</style>

<div class="print-wrap">

	<!-- HEADER -->
	<table width="100%" border="0"
		style="border-collapse:collapse; font-family:Calibri; font-size:18px; margin-bottom:6px;">
		<tr>
			<td width="15%" align="left" valign="middle">
				<img src="<?php echo base_url(); ?>/uploads/main/<?php echo $_SESSION['logo_img']; ?>"
					style="width:120px;">
			</td>
			<td width="85%" align="center" valign="middle">
				<h3 style="margin:0 0 2px 0;"><?php echo $temp_details['name_tamil']; ?></h3>
				<h2 style="margin:0 0 4px 0;"><?php echo $_SESSION['site_title']; ?></h2>
				<p style="font-size:15px; margin:0;">
					<?php echo $_SESSION['address1']; ?>, <?php echo $_SESSION['address2']; ?>,
					<?php echo $_SESSION['postcode']; ?> <?php echo $_SESSION['city']; ?><br>
					Tel : <?php echo $_SESSION['telephone']; ?>
				</p>
			</td>
		</tr>
	</table>

	<!-- TITLE -->
	<h3
		style="text-align:center; text-transform:uppercase; border-bottom:1px solid black; padding-bottom:8px; margin:0 -126px 8px 0;">
		General Ledger Statement
	</h3>

	<!-- DATA TABLE -->
	<table class="table1" width="100%" border="1" style="border-collapse:collapse; font-size:15px;">
		<thead>
			<tr style="border-bottom:1px solid black;">
				<td width="10%" align="left"><strong>Date</strong></td>
				<td width="20%" align="left"><strong>Ref.</strong></td>
				<td width="35%" align="left"><strong>Description</strong></td>
				<td width="10%" align="right"><strong>Debit</strong></td>
				<td width="10%" align="right"><strong>Credit</strong></td>
				<td width="15%" align="right"><strong>Balance</strong></td>
			</tr>
		</thead>
		<tbody>
			<?php
			$cu_credit = 0;
			$cu_debit = 0;
			foreach ($data as $row) {
				if (!empty($row['credit_amount']))
					$cu_credit += (float) $row['credit_amount'];
				if (!empty($row['debit_amount']))
					$cu_debit += (float) $row['debit_amount'];
				?>
				<tr>
					<td><?= date('d-m-Y', strtotime($row['date'])); ?></td>
					<td align="left"><?= $row['entry_code']; ?></td>
					<td align="left"><?= $row['ledger']; ?></td>
					<td align="right"><?= $row['debit']; ?></td>
					<td align="right"><?= $row['credit']; ?></td>
					<td align="right">
						<?php
						if ($row['balance'] < 0)
							echo "( " . number_format(abs($row['balance']), 2) . " )";
						else
							echo number_format($row['balance'], 2);
						?>
					</td>
				</tr>
			<?php } ?>
			<tr style="border-top:1px double black;">
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td align="right" style="border-bottom:4px double black; font-weight:bold;">
					<?= number_format($cu_debit, 2, '.', ','); ?></td>
				<td align="right" style="border-bottom:4px double black; font-weight:bold;">
					<?= number_format($cu_credit, 2, '.', ','); ?></td>
				<td align="right" style="border-bottom:4px double black; font-weight:bold;">
					<?php
					if ($cl_bal < 0)
						echo "( " . number_format(abs($cl_bal), 2, '.', ',') . " )";
					else
						echo number_format($cl_bal, 2, '.', ',');
					?>
				</td>
			</tr>
		</tbody>
	</table>

</div>
<script>window.print();</script>