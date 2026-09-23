<?php
	$summary_total = array();
	$summary_total['sales'] = array();
	$summary_total['expense'] = array();
?>
<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>Daily Closing<small>Print / <b>Daily Closing</b></small></h2>
		</div>
		<!-- Basic Examples -->
		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<form action="<?php echo base_url(); ?>/dailyclosing" method="post">
    <div class="row" style="align-items: center;">
        <div class="col-md-2">
            <label>From Date</label>
            <input type="date" name="dailyclosing_start_date" id="dailyclosing_start_date"
                class="form-control" value="<?php echo $dailyclosing_start_date; ?>">
        </div>
        <div class="col-md-2">
            <label>To Date</label>
            <input type="date" name="dailyclosing_end_date" id="dailyclosing_end_date"
                class="form-control" value="<?php echo $dailyclosing_end_date; ?>">
        </div>
        <div class="col-md-2">
            <label>Login User</label>
            <select name="login_id" id="login_id" class="form-control">
                <option value="">All Users</option>
                <?php foreach($login_users as $user): ?>
                    <option value="<?php echo $user['id']; ?>"
                        <?php echo ($selected_login_id == $user['id']) ? 'selected' : ''; ?>>
                        <?php echo strtoupper($user['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-2" style="padding-top:20px;">
            <button type="submit" id="dailyclosing_filter" class="btn btn-success">Filter</button>
        </div>
        <div class="col-md-2" align="right" style="padding-top:20px;">
            <a href="<?php echo base_url(); ?>/dailyclosing/print_a4/<?php echo strtotime($dailyclosing_start_date); ?>/<?php echo strtotime($dailyclosing_end_date); ?>"
                target="_blank">
                <button type="button" class="btn bg-deep-purple waves-effect">Print A4</button>
            </a>
        </div>
        <div class="col-md-1" align="right" style="padding-top:20px;">
            <a href="<?php echo base_url(); ?>/dailyclosing/print/<?php echo strtotime($dailyclosing_start_date); ?>/<?php echo strtotime($dailyclosing_end_date); ?>"
                target="_blank">
                <button type="button" class="btn bg-deep-purple waves-effect">Print</button>
            </a>
        </div>
    </div>
</form>
					</div>
					<div class="body">
						<div class="col-md-12">
							<h3>Archanai Selling Details</h3>
						</div>
						<div class="table-responsive col-md-12 det"
							style="background:#FFF; float:none;margin-bottom:0px;">
							<table class="table table-bordered table-striped table-hover">
								<thead style="background: #3F51B5;color: #fff;">
									<tr>
										<th style="padding: 5px 10px!important;">S.No</th>
										<th style="padding: 5px 10px!important;">Archanai</th>
										<th style="padding: 5px 10px!important;">Payment Mode</th>
										<th style="padding: 5px 10px!important;">Booking Through</th>
										<th style="padding: 5px 10px!important;">Quantity</th>
										<th style="padding: 5px 10px!important;text-align:right;">Amount</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$archanai_total = 0;
									$ar_i = 1;
									if (count($archanai_details) > 0) {
										foreach ($archanai_details as $archanai_detail) {
											$archanai_total = $archanai_total + $archanai_detail['amount'];
											if(empty($summary_total['sales'][$archanai_detail['paymentmode']])) $summary_total['sales'][$archanai_detail['paymentmode']] = 0;
											$summary_total['sales'][$archanai_detail['paymentmode']] += $archanai_detail['amount'];
											?>
											<tr>
												<td style="padding: 5px 10px!important;"><?php echo $ar_i; ?></td>
												<td style="padding: 5px 10px!important;">
													<?php
													echo $archanai_detail['name_in_english'] . " / " . $archanai_detail['name_in_tamil'];
													?>
												</td>
												<td style="padding: 5px 10px!important;text-transform: uppercase;">
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
														echo $paymentname; ?>
												</td>
												<td style="padding: 5px 10px!important;text-transform: uppercase;">
													<?php echo $archanai_detail['paid_through']; ?></td>
												<td style="padding: 5px 10px!important;">
													<?php
													echo $archanai_detail['qty'];
													?>
												</td>
												<td style="padding: 5px 10px!important;text-align:right;">
													<?php
													echo number_format($archanai_detail['amount'], 2);
													?>
												</td>
											</tr>
											<?php
											$ar_i++;
										}
									}
									?>
								</tbody>
								<tfoot style="background: #a1a09f;color: #fff;">
									<tr>
										<td colspan="5">&nbsp;</td>
										<td style="padding: 5px 10px!important;text-align:right;font-weight:bold;">
											<?php echo number_format($archanai_total, 2); ?></td>
									</tr>
								</tfoot>
							</table>
						</div>

						<?php
						$d_i = 1;
						$donation_total = 0;
						if (count($donation_details) > 0) {
							?>
							<div class="col-md-12">
								<h3>Cash Donation Details</h3>
							</div>
							<div class="table-responsive col-md-12 det"
								style="background:#FFF; float:none;margin-bottom:0px;">
								<table class="table table-bordered table-striped table-hover">
									<thead style="background: #3F51B5;color: #fff;">
										<tr>
											<th style="padding: 5px 10px!important;">S.No</th>
											<th style="padding: 5px 10px!important;">Name</th>
											<th style="padding: 5px 10px!important;">Payment Mode</th>
											<th style="padding: 5px 10px!important;">Booking Through</th>
											<th style="padding: 5px 10px!important;text-align:right;">Amount</th>
										</tr>
									</thead>
									<tbody>
										<?php
										foreach ($donation_details as $donation_detail) {
											$donation_total = $donation_total + $donation_detail['paidamount'];
											if(empty($summary_total['sales'][$donation_detail['paymentmode']])) $summary_total['sales'][$donation_detail['paymentmode']] = 0;
											$summary_total['sales'][$donation_detail['paymentmode']] += $donation_detail['paidamount'];
											?>
											<tr>
												<td style="padding: 5px 10px!important;"><?php echo $d_i; ?></td>
												<td style="padding: 5px 10px!important;">
													<?php
													echo $donation_detail['person_name'];
													?>
												</td>
												<td style="padding: 5px 10px!important;">
													<?php
													if ($donation_detail['paymentmode'] == "ipay_merch_qr") {
														$paymentname = "QR PAYMENT";
													} elseif ($donation_detail['paymentmode'] == "ipay_merch_online") {
														$paymentname = "ONLINE PAYMENT";
													} elseif ($donation_detail['paymentmode'] == "cash") {
														$paymentname = "CASH";
													} else
														$paymentname = strtoupper($donation_detail['paymentmode']);

													echo $paymentname;
													?>
												</td>
												<td style="padding: 5px 10px!important;">
													<?php
													echo $donation_detail['paid_through'];
													?>
												</td>
												<td style="padding: 5px 10px!important;text-align:right;">
													<?php
													echo number_format($donation_detail['paidamount'], 2);
													?>
												</td>
											</tr>
											<?php
											$d_i++;
										}
										?>
									</tbody>
									<tfoot style="background: #a1a09f;color: #fff;">
										<tr>
											<td colspan="4">&nbsp;</td>
											<td style="padding: 5px 10px!important;text-align:right;font-weight:bold;">
												<?php echo number_format($donation_total, 2); ?></td>
										</tr>
									</tfoot>
								</table>
							</div>
							<?php
						}
						$ps_i = 1;
						$prasadam_total = 0;
						if (count($prasadam_details) > 0) {
							?>
							<div class="col-md-12">
								<h3>Prasadam Details</h3>
							</div>
							<div class="table-responsive col-md-12 det"
								style="background:#FFF; float:none;margin-bottom:0px;">
								<table class="table table-bordered table-striped table-hover">
									<thead style="background: #3F51B5;color: #fff;">
										<tr>
											<th style="padding: 5px 10px!important;">S.No</th>
											<th style="padding: 5px 10px!important;">Name</th>
											<th style="padding: 5px 10px!important;">Payment Mode</th>
											<th style="padding: 5px 10px!important;">Booking Through</th>
											<th style="padding: 5px 10px!important;text-align:right;">Amount</th>
										</tr>
									</thead>
									<tbody>
										<?php
										foreach ($prasadam_details as $prasadam_detail) {
											$prasadam_total = $prasadam_total + $prasadam_detail['paidamount'];
											if(empty($summary_total['sales'][$prasadam_detail['paymentmode']])) $summary_total['sales'][$prasadam_detail['paymentmode']] = 0;
											$summary_total['sales'][$prasadam_detail['paymentmode']] += $prasadam_detail['paidamount'];
											?>
											<tr>
												<td style="padding: 5px 10px!important;"><?php echo $ps_i; ?></td>
												<td style="padding: 5px 10px!important;">
													<?php
													echo $prasadam_detail['customer_name'];
													?>
												</td>
												<td style="padding: 5px 10px!important;">
													<?php
													if ($prasadam_detail['paymentmode'] == "ipay_merch_qr") {
														$paymentname = "QR PAYMENT";
													} elseif ($prasadam_detail['paymentmode'] == "ipay_merch_online") {
														$paymentname = "ONLINE PAYMENT";
													} elseif ($prasadam_detail['paymentmode'] == "cash") {
														$paymentname = "CASH";
													} else
														$paymentname = strtoupper($prasadam_detail['paymentmode']);

													echo $paymentname;
													?>
												</td>
												<td style="padding: 5px 10px!important;">
													<?php
													echo $prasadam_detail['paid_through'];
													?>
												</td>
												<td style="padding: 5px 10px!important;text-align:right;">
													<?php
													echo number_format($prasadam_detail['paidamount'], 2);
													?>
												</td>
											</tr>
											<?php
											$ps_i++;
										}
										?>
									</tbody>
									<tfoot style="background: #a1a09f;color: #fff;">
										<tr>
											<td colspan="4">&nbsp;</td>
											<td style="padding: 5px 10px!important;text-align:right;font-weight:bold;">
												<?php echo number_format($prasadam_total, 2); ?></td>
										</tr>
									</tfoot>
								</table>
							</div>
							<?php
						}
						?>
						<?php
						$ps_i = 1;
						$annathanam_total = 0;
						if (count($annathanam_details) > 0) {
							?>
							<div class="col-md-12">
								<h3>Annathanam Details</h3>
							</div>
							<div class="table-responsive col-md-12 det"
								style="background:#FFF; float:none;margin-bottom:0px;">
								<table class="table table-bordered table-striped table-hover">
									<thead style="background: #3F51B5;color: #fff;">
										<tr>
											<th style="padding: 5px 10px!important;">S.No</th>
											<th style="padding: 5px 10px!important;">Name</th>
											<th style="padding: 5px 10px!important;">Payment Mode</th>
											<th style="padding: 5px 10px!important;">Booking Through</th>
											<th style="padding: 5px 10px!important;text-align:right;">Total Amount</th>
											<th style="padding: 5px 10px!important;text-align:right;">Paid Amount</th>
										</tr>
									</thead>
									<tbody>
										<?php
										foreach ($annathanam_details as $annathanam_detail) {
											$annathanam_total = $annathanam_total + $annathanam_detail['paidamount'];
											if(empty($summary_total['sales'][$annathanam_detail['paymentmode']])) $summary_total['sales'][$annathanam_detail['paymentmode']] = 0;
											$summary_total['sales'][$annathanam_detail['paymentmode']] += $annathanam_detail['paidamount'];
											?>
											<tr>
												<td style="padding: 5px 10px!important;"><?php echo $ps_i; ?></td>
												<td style="padding: 5px 10px!important;">
													<?php
													echo $annathanam_detail['customer_name'];
													?>
												</td>
												<td style="padding: 5px 10px!important;">
													<?php
													echo $annathanam_detail['paymentmode'];
													?>
												</td>
												<td style="padding: 5px 10px!important;">
													<?php
													echo $annathanam_detail['booking_through'];
													?>
												</td>
												<td style="padding: 5px 10px!important;text-align:right;">
													<?php
													echo number_format($annathanam_detail['amount'], 2);
													?>
												</td>
												<td style="padding: 5px 10px!important;text-align:right;">
													<?php
													echo number_format($annathanam_detail['paidamount'], 2);
													?>
												</td>
											</tr>
											<?php
											$ps_i++;
										}
										?>
									</tbody>
									<tfoot style="background: #a1a09f;color: #fff;">
										<tr>
											<td colspan="5">&nbsp;</td>
											<td style="padding: 5px 10px!important;text-align:right;font-weight:bold;">
												<?php echo number_format($annathanam_total, 2); ?></td>
										</tr>
									</tfoot>
								</table>
							</div>
							<?php
						}
						?>

<?php
						$hb_i = 1;
						$hallbooking_total = 0;
						if (count($hallbooking_details) > 0) {
							?>
							<div class="col-md-12">
								<h3>Hall Booking Details</h3>
							</div>
							<div class="table-responsive col-md-12 det"
								style="background:#FFF; float:none;margin-bottom:0px;">
								<table class="table table-bordered table-striped table-hover">
									<thead style="background: #3F51B5;color: #fff;">
										<tr>
											<th style="padding: 5px 10px!important;">#</th>
											<th style="padding: 5px 10px!important;">Name</th>
											<th style="padding: 5px 10px!important;">Payment Mode</th>
											<th style="padding: 5px 10px!important;">Booking Through</th>
											<th style="padding: 5px 10px!important;text-align:right;">Total Amount</th>
											<th style="padding: 5px 10px!important;text-align:right;">Paid Amount</th>
										</tr>
									</thead>
									<tbody>
										<?php
										foreach ($hallbooking_details as $hallbooking_detail) {
											$hallbooking_total = $hallbooking_total + $hallbooking_detail['paidamount'];
											if(empty($summary_total['sales'][$hallbooking_detail['paymentmode']])) $summary_total['sales'][$hallbooking_detail['paymentmode']] = 0;
											$summary_total['sales'][$hallbooking_detail['paymentmode']] += $hallbooking_detail['paidamount'];
											?>
											<tr>
												<td style="padding: 5px 10px!important;"><?php echo $hb_i; ?></td>
												<td style="padding: 5px 10px!important;">
													<?php
													echo $hallbooking_detail['customer_name'];
													?>
												</td>
												<td style="padding: 5px 10px!important;">
													<?php
													echo $hallbooking_detail['paymentmode'];
													?>
												</td>
												<td style="padding: 5px 10px!important;">
													<?php
													echo $hallbooking_detail['booking_through'];
													?>
												</td>
												<td style="padding: 5px 10px!important;text-align:right;">
													<?php
													echo number_format($hallbooking_detail['amount'], 2);
													?>
												</td>
												<td style="padding: 5px 10px!important;text-align:right;">
													<?php
													echo number_format($hallbooking_detail['paidamount'], 2);
													?>
												</td>
											</tr>
											<?php
											$hb_i++;
										}
										?>
									</tbody>
									<tfoot style="background: #a1a09f;color: #fff;">
										<tr>
											<td colspan="5">&nbsp;</td>
											<td style="padding: 5px 10px!important;text-align:right;font-weight:bold;">
												<?php echo number_format($hallbooking_total, 2); ?></td>
										</tr>
									</tfoot>
								</table>
							</div>
							<?php
						} ?>

						<?php
						$u_i = 1;
						$ubayam_total = 0;
						if (count($ubayam_details) > 0) {
							?>
							<div class="col-md-12">
								<h3>Ubayam Details</h3>
							</div>
							<div class="table-responsive col-md-12 det"
								style="background:#FFF; float:none;margin-bottom:0px;">
								<table class="table table-bordered table-striped table-hover">
									<thead style="background: #3F51B5;color: #fff;">
										<tr>
											<th style="padding: 5px 10px!important;">S.No</th>
											<th style="padding: 5px 10px!important;">Name</th>
											<th style="padding: 5px 10px!important;">Payment Mode</th>
											<th style="padding: 5px 10px!important;">Booking Through</th>
											<th style="padding: 5px 10px!important;text-align:right;">Total Amount</th>
											<th style="padding: 5px 10px!important;text-align:right;">Paid Amount</th>
										</tr>
									</thead>
									<tbody>
										<?php
										foreach ($ubayam_details as $ubayam_detail) {
											$ubayam_total = $ubayam_total + $ubayam_detail['paidamount'];
											if(empty($summary_total['sales'][$ubayam_detail['paymentmode']])) $summary_total['sales'][$ubayam_detail['paymentmode']] = 0;
											$summary_total['sales'][$ubayam_detail['paymentmode']] += $ubayam_detail['paidamount'];
											?>
											<tr>
												<td style="padding: 5px 10px!important;"><?php echo $u_i; ?></td>
												<td style="padding: 5px 10px!important;">
													<?php
													echo $ubayam_detail['customer_name'];
													?>
												</td>
												<td>
													<?php
													echo $ubayam_detail['paymentmode'];
													?>
												</td>
												<td style="padding: 5px 10px!important;">
													<?php
													echo $ubayam_detail['booking_through'];
													?>
												</td>
												<td style="padding: 5px 10px!important;text-align:right;">
													<?php
													echo number_format($ubayam_detail['amount'], 2);
													?>
												</td>
												<td style="padding: 5px 10px!important;text-align:right;">
													<?php
													echo number_format($ubayam_detail['paidamount'], 2);
													?>
												</td>
											</tr>
											<?php
											$u_i++;
										}
										?>
									</tbody>
									<tfoot style="background: #a1a09f;color: #fff;">
										<tr>
											<td colspan="5">&nbsp;</td>
											<td style="padding: 5px 10px!important;text-align:right;font-weight:bold;">
												<?php echo number_format($ubayam_total, 2); ?></td>
										</tr>
									</tfoot>
								</table>
							</div>
							<?php
						} ?>

						<?php
						$Kattalai_archanai_total = 0;
						if (count($Kattalai_archanai_details) > 0) {
							?>
							<div class="col-md-12">
								<h3>Kattalai Archanai Details</h3>
							</div>
							<div class="table-responsive col-md-12 det"
								style="background:#FFF; float:none;margin-bottom:0px;">
								<table class="table table-bordered table-striped table-hover">
									<thead style="background: #3F51B5;color: #fff;">
										<tr>
											<th style="width: 5%; padding: 5px 10px!important;">S.No</th>
											<th style="width: 10%; padding: 5px 10px!important;">Name</th>
											<th style="width: 15%; padding: 5px 10px!important;">Payment Mode</th>
											<th style="width: 10%; padding: 5px 10px!important;">Booking Through</th>
											<th style="width: 10%; padding: 5px 10px!important;text-align:right;">Total Amount </th>
											<th style="width: 10%; padding: 5px 10px!important;text-align:right;">Paid Amount </th>
										</tr>
									</thead>
									<tbody>
										<?php
										$ps_i = 1;
										
										foreach ($Kattalai_archanai_details as $Kattalai_archanai_detail) {
											$Kattalai_archanai_total += $Kattalai_archanai_detail['paidamount'];

											if (empty($summary_total['sales'][$Kattalai_archanai_detail['paymentmode']]))
												$summary_total['sales'][$Kattalai_archanai_detail['paymentmode']] = 0;
											$summary_total['sales'][$Kattalai_archanai_detail['paymentmode']] += $Kattalai_archanai_detail['paidamount'];
											?>

											<tr>
												<td style="padding: 5px 10px!important;">
													<?php echo $ps_i; ?>
												</td>
												<td style="padding: 5px 10px!important;">
													<?php
													echo $Kattalai_archanai_detail['name'];
													?>
												</td>
												<td style="padding: 5px 10px!important;">
													<?php
													echo $Kattalai_archanai_detail['paymentmode'];
													?>
												</td>
												<td style="padding: 5px 10px!important;">
													<?php
													echo $Kattalai_archanai_detail['booking_through'];
													?>
												</td>
										
												<td style="padding: 5px 10px!important;text-align:right;">
													<?php
													echo number_format($Kattalai_archanai_detail['amount'], 2);
													?>
												</td>
												<td style="padding: 5px 10px!important;text-align:right;">
													<?php
													echo number_format($Kattalai_archanai_detail['paidamount'], 2);
													?>
												</td>
											</tr>
											<?php
											$ps_i++;
										}
										?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="5">&nbsp;</td>
											<td
												style="padding: 5px 10px!important;text-align:right;font-weight:bold;">
												<?php echo number_format($Kattalai_archanai_total, 2); ?>
											</td>
										</tr>
									</tfoot>
								</table>
							</div>
							<?php
						}
						?>
<?php
						$Kattalai_abishegam_total = 0;
						if (count($Kattalai_abishegam_details) > 0) {
							?>
							<div class="col-md-12">
								<h3>Kattalai Abishegam Details</h3>
							</div>
							<div class="table-responsive col-md-12 det"
								style="background:#FFF; float:none;margin-bottom:0px;">
								<table class="table table-bordered table-striped table-hover">
									<thead style="background: #3F51B5;color: #fff;">
										<tr>
											<th style="width: 5%; padding: 5px 10px!important;">S.No</th>
											<th style="width: 10%; padding: 5px 10px!important;">Name</th>
											<th style="width: 15%; padding: 5px 10px!important;">Payment Mode</th>
											<th style="width: 10%; padding: 5px 10px!important;">Booking Through</th>
											<th style="width: 10%; padding: 5px 10px!important;text-align:right;">Total Amount </th>
											<th style="width: 10%; padding: 5px 10px!important;text-align:right;">Paid Amount </th>
										</tr>
									</thead>
									<tbody>
										<?php
										$ps_i = 1;
										
										foreach ($Kattalai_abishegam_details as $Kattalai_abishegam_detail) {
											$Kattalai_abishegam_total += $Kattalai_abishegam_detail['paidamount'];

											if (empty($summary_total['sales'][$Kattalai_abishegam_detail['paymentmode']]))
												$summary_total['sales'][$Kattalai_abishegam_detail['paymentmode']] = 0;
											$summary_total['sales'][$Kattalai_abishegam_detail['paymentmode']] += $Kattalai_abishegam_detail['paidamount'];
											?>

											<tr>
												<td style="padding: 5px 10px!important;">
													<?php echo $ps_i; ?>
												</td>
												<td style="padding: 5px 10px!important;">
													<?php
													echo $Kattalai_abishegam_detail['name'];
													?>
												</td>
												<td style="padding: 5px 10px!important;">
													<?php
													echo $Kattalai_abishegam_detail['paymentmode'];
													?>
												</td>
												<td style="padding: 5px 10px!important;">
													<?php
													echo $Kattalai_abishegam_detail['booking_through'];
													?>
												</td>
										
												<td style="padding: 5px 10px!important;text-align:right;">
													<?php
													echo number_format($Kattalai_abishegam_detail['amount'], 2);
													?>
												</td>
												<td style="padding: 5px 10px!important;text-align:right;">
													<?php
													echo number_format($Kattalai_abishegam_detail['paidamount'], 2);
													?>
												</td>
											</tr>
											<?php
											$ps_i++;
										}
										?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="5">&nbsp;</td>
											<td
												style="padding: 5px 10px!important;text-align:right;font-weight:bold;">
												<?php echo number_format($Kattalai_abishegam_total, 2); ?>
											</td>
										</tr>
									</tfoot>
								</table>
							</div>
							<?php
						}
						?>
						<?php
						$outdoor_services_total = 0;
						if (count($outdoor_services_details) > 0) {
							?>
							<div class="col-md-12">
								<h3>Outdoor Services Details</h3>
							</div>
							<div class="table-responsive col-md-12 det"
								style="background:#FFF; float:none;margin-bottom:0px;">
								<table class="table table-bordered table-striped table-hover">
									<thead style="background: #3F51B5;color: #fff;">
										<tr>
										<th style="padding: 5px 10px!important;">S.No</th>
											<th style="padding: 5px 10px!important;">Name</th>
											<th style="padding: 5px 10px!important;">Payment Mode</th>
											<th style="padding: 5px 10px!important;">Booking Through</th>
											<th style="padding: 5px 10px!important;text-align:right;">Total Amount </th>
											<th style="padding: 5px 10px!important;text-align:right;">Paid Amount </th>
										</tr>
									</thead>
									<tbody>
										<?php
										$ans_i = 1;
										foreach ($outdoor_services_details as $outdoor_services_detail) {
											$outdoor_services_total += $outdoor_services_detail['paidamount'];
										
											if (empty($summary_total['sales'][$outdoor_services_detail['paymentmode']]))
												$summary_total['sales'][$outdoor_services_detail['paymentmode']] = 0;
											$summary_total['sales'][$outdoor_services_detail['paymentmode']] += $outdoor_services_detail['paidamount'];
											?>
											<tr>
												<td style="padding: 5px 10px!important;">
													<?php echo $ans_i; ?>
												</td>
												<td style="padding: 5px 10px!important;">
													<?php echo $outdoor_services_detail['customer_name']; ?>
												</td>
												<td style="padding: 5px 10px!important;">
													<?php
													echo $outdoor_services_detail['paymentmode'];
													?>
												</td>
												<td style="padding: 5px 10px!important;">
													<?php
													echo $outdoor_services_detail['paid_through'];
													?>
												</td>
												<td style="padding: 5px 10px!important;text-align:right;">
													<?php
													echo number_format($outdoor_services_detail['amount'], 2);
													?>
												</td>
												<td style="padding: 5px 10px!important;text-align:right;">
													<?php
													echo number_format($outdoor_services_detail['paidamount'], 2);
													?>
												</td>
											</tr>
											<?php
											$ans_i++;
										}
										?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="5">&nbsp;</td>
											<td
												style="padding: 5px 10px!important;text-align:right;font-weight:bold;">
												<?php echo number_format($outdoor_services_total, 2); ?>
											</td>
										</tr>
									</tfoot>
								</table>
							</div>
							<?php
						}
						?>

						<?php
						$total_grams = 0;
						if (!empty($product_offering_details)) {
							?>
							<div class="col-md-12">
								<h3>Product Offering Details</h3>
							</div>
							<div class="table-responsive col-md-12 det"
								style="background:#FFF; float:none;margin-bottom:0px;">
								<table class="table table-bordered table-striped table-hover">
									<thead style="background: #3F51B5;color: #fff;">
										<tr>
											<th style="padding: 5px 10px!important;">S.No</th>
											<th style="padding: 5px 10px!important;">Name</th>
											<th style="padding: 5px 10px!important;">Category</th>
											<th style="padding: 5px 10px!important;">Product </th>
											<th style="padding: 5px 10px!important;">Grams</th>
											</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$ans_i = 1;
										foreach ($product_offering_details as $details) {
											$total_grams += $details['grams'];
											$productName = $details['category_name'];
												
											if (!isset($sale_summary['Product Offering'][$productName])) {
												$sale_summary['Product Offering'][$productName] = [
													'name_eng' => $productName,
													'ledger_code' => 0,
													'qty' => 0,
													'total' => 0
												];
											}
									
											$sale_summary['Product Offering'][$productName]['qty'] += 1;
											$sale_summary['Product Offering'][$productName]['total'] += $details['grams'];

											if (empty($summary_total['sales'][$details['paymentmode']]))
												$summary_total['sales'][$details['paymentmode']] = 0;
											$summary_total['sales'][$details['paymentmode']] += $details['grams'];
											?>
											<tr>
												<td style="padding: 5px 10px!important;">
													<?php echo $ans_i; ?>
												</td>

												<td style="padding: 5px 10px!important;">
													<?php echo $details['customer_name']; ?>
												</td>

												<td style="padding: 5px 10px!important;">
													<?php echo $details['category_name']; ?>
												</td>

												<td style="padding: 5px 10px!important;">
													<?php echo $details['product_name']; ?>
												</td>

												<td style="padding: 5px 10px!important;text-align:right;">
													<?php
													echo $details['grams'];
													?>
												</td>
											</tr>
											<?php
											$ans_i++;
										}
										?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="4">&nbsp;</td>
											<td
												style="padding: 5px 10px!important;text-align:right;font-weight:bold;">
												<?php echo number_format($total_grams, 2); ?>
											</td>
										</tr>
									</tfoot>
								</table>
							</div>
							<?php
						}
						?>


						<?php
						$repayment_total = 0;
						if (!empty($repayment_details)) {
							?>
							<div class="col-md-12">
								<h3>Repayment Details</h3>
							</div>
							<div class="table-responsive col-md-12 det"
								style="background:#FFF; float:none;margin-bottom:0px;">
								<table class="table table-bordered table-striped table-hover">
									<thead style="background: #3F51B5;color: #fff;">
										<tr>
											<th style="padding: 5px 10px!important;">S.No</th>
											<th style="padding: 5px 10px!important;">Type</th>
											<th style="padding: 5px 10px!important;">Name</th>
											<th style="padding: 5px 10px!important;">Booked Date</th>
											<th style="padding: 5px 10px!important;">Payment Mode</th>
											<th style="width: 15%; padding: 5px 10px!important; text-align:right;">Booking Amount</th>
											<th style="padding: 5px 10px!important;text-align:right;">Repaid Amount (S$) 
											</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$ans_i = 1;
										foreach ($repayment_details as $details) {
											$repayment_total += $details['repaid_amount'];
											if (empty($summary_total['sales'][$details['paymentmode']]))
												$summary_total['sales'][$details['paymentmode']] = 0;
											$summary_total['sales'][$details['paymentmode']] += $details['repaid_amount'];
											?>
											<tr>
												<td style="padding: 5px 10px!important;">
													<?php echo $ans_i; ?>
												</td>

												<td style="padding: 5px 10px!important;">
													<?php echo $details['type']; ?>
												</td>

												<td style="padding: 5px 10px!important;">
													<?php echo $details['customer_name']; ?>
												</td>

												<td style="padding: 5px 10px!important;">
													<?php echo $details['date']; ?>
												</td>

												<td style="padding: 5px 10px!important;">
													<?php
													if ($details['paymentmode'] == "ipay_merch_qr") {
														$paymentname = "QR PAYMENT";
													} elseif ($details['paymentmode'] == "ipay_merch_online") {
														$paymentname = "ONLINE PAYMENT";
													} elseif ($details['paymentmode'] == "cash") {
														$paymentname = "CASH";
													} elseif ($details['paymentmode'] == "nets_pay") {
														$paymentname = 'NETS';
													} else
														$paymentname = strtoupper(str_replace('_', ' ', $details['paymentmode']));

													echo $paymentname;
													?>
												</td>
												<td style="padding: 5px 10px!important; text-align:right;">
													<?php echo $details['amount']; ?>
												</td>
												<td style="padding: 5px 10px!important;text-align:right;">
													<?php
													echo number_format($details['repaid_amount'], 2);
													?>
												</td>
											</tr>
											<?php
											$ans_i++;
										}
										?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="6">&nbsp;</td>
											<td
												style="padding: 5px 10px!important;text-align:right;font-weight:bold;">
												<?php echo number_format($repayment_total, 2); ?>
											</td>
										</tr>
									</tfoot>
								</table>
							</div>
							<?php
						}
						?>

						<?php 
						$receipt_voucher_total = 0;
						if (count($receipt_voucher_details) > 0) {
						?>
						<div class="col-md-12">
							<h3>Receipt Details</h3>
						</div>
						<div class="table-responsive col-md-12 det"
							style="background:#FFF; float:none;margin-bottom:0px;">
							<table class="table table-bordered table-striped table-hover">
								<thead style="background: #3F51B5;color: #fff;">
									<tr>
										<th style="padding: 5px 10px!important;">#</th>
										<th style="padding: 5px 10px!important;">Paid To</th>
										<th style="padding: 5px 10px!important;">Payment Mode</th>
										<th style="padding: 5px 10px!important;text-align:right;">Amount
										</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$pv_i = 1;
									foreach ($receipt_voucher_details as $receipt_voucher_detail) {
										$receipt_voucher_total = $receipt_voucher_total + $receipt_voucher_detail['paidamount'];
										if(empty($summary_total['sales'][$receipt_voucher_detail['paymentmode']])) $summary_total['sales'][$receipt_voucher_detail['paymentmode']] = 0;
											$summary_total['sales'][$receipt_voucher_detail['paymentmode']] += $receipt_voucher_detail['paidamount'];
										?>
										<tr>
											<td style="padding: 5px 10px!important;">
												<?php echo $pv_i; ?>
											</td>
											<td style="padding: 5px 10px!important;">
												<?php echo $receipt_voucher_detail['paid_to']; ?>
											</td>
											<td style="padding: 5px 10px!important;">
												<?php
												$paymentname = strtoupper($receipt_voucher_detail['paymentmode']);
												echo $paymentname;
												?>
											</td>
											<td style="padding: 5px 10px!important;text-align:right;">
												<?php
												echo number_format($receipt_voucher_detail['paidamount'], 2);
												?>
											</td>
										</tr>
										<?php
										$pv_i++;
									}
									?>
								</tbody>
								<tfoot>
									<tr>
										<td colspan="2">&nbsp;</td>
										<td
											style="padding: 5px 10px!important;text-align:right;font-weight:bold;">
											<?php echo number_format($receipt_voucher_total, 2); ?>
										</td>
									</tr>
								</tfoot>
							</table>
						</div>
						<?php
						}
						?>
						<div class="row">
							<div class="col-md-9"></div>
							<div class="col-md-3 det" style="margin-bottom:0px;">
								<h3 style="text-align:center;font-weight: bold;">
									Summary
								</h3>
								<?php
								$cash_total = 0;
								if(count($summary_total['sales'])){
									echo '<h4 class>Incomes</h4>';
									foreach($summary_total['sales'] as $vl => $st){
										if($vl == 'cash') $cash_total += $st;
										if ($vl == "ipay_merch_qr") {
											$paymentname = "QR PAYMENT";
										} elseif ($vl == "ipay_merch_online") {
											$paymentname = "ONLINE PAYMENT";
										} elseif ($vl == "cash") {
											$paymentname = "CASH";
										} elseif ($vl == "nets_pay") {
											$paymentname = 'NETS';
										} else
											$paymentname = strtoupper($vl);
										echo '<p>' . $paymentname . ' Sales: ' . number_format($st, 2) . '</p>';
									}
								}
								
								?>
							</div>
							<div class="col-md-12 det" style="background:#FFF; margin-bottom:0px;">
								<h3 style="text-align:center;">
									TOTAL AMOUNT :
									<?php
									/*$total = $archanai_total + $hallbooking_total + $ubayam_total + $donation_total + $prasadam_total + $receipt_voucher_total + $annathanam_total + $Kattalai_archanai_total + $outdoor_services_total + $repayment_total;*/
									$total = $archanai_total + $hallbooking_total + $ubayam_total + $donation_total + $prasadam_total + $receipt_voucher_total + $annathanam_total + $Kattalai_archanai_total + $Kattalai_abishegam_total + $outdoor_services_total + $repayment_total;
									echo number_format($total, 2);
									?>
								</h3>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>