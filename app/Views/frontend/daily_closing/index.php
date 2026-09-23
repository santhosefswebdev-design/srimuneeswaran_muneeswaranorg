<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/vendors/typicons/typicons.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/vendors/css/vendor.bundle.base.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/css/vertical-layout-light/style.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/style.css">
<link rel="shortcut icon" href="<?php echo base_url(); ?>/assets/archanai/images/favicon.png" />
<style>
	body {
		height: 100vh;
		width: 100%;
	}

	.prod::-webkit-scrollbar {
		width: 3px;
	}

	.prod::-webkit-scrollbar-track {
		background: #f1f1f1;
	}

	.prod::-webkit-scrollbar-thumb {
		background: #d4aa00;
	}

	.prod::-webkit-scrollbar-thumb:hover {
		background: #e91e63;
	}

	a {
		text-decoration: none !important;
	}

	.table tr th {
		border: 1px solid #f7e086;
		font-size: 14px;
		background: #f7ebbb;
		color: #333232;
	}

	.pack,
	.pay {
		margin-bottom: 15px;
	}

	.form-label {
		text-transform: uppercase;
		font-size: 13px;
		letter-spacing: 1px;
		color: #333333;
		text-align: left;
		width: 100%;
	}

	.input {
		width: 100%;
		text-align: left;
	}

	select.input {
		color: #000;
	}

	.sidebar-icon-only .sidebar .nav .nav-item .nav-link .menu-title {
		display: block !important;
		font-size: 11px;
		color: #FFFFFF;
	}

	.sidebar .nav .nav-item.active>.nav-link i.menu-icon {
		background: #edc10f;
		padding: 1px;
		list-style: outside;
		border-radius: 5px;
		box-shadow: 2px 5px 15px #00000017;
	}

	.sidebar-icon-only .sidebar .nav .nav-item .nav-link {
		display: block;
		padding-left: 0.25rem;
		padding-right: 0.25rem;
		text-align: center;
		position: static;
	}

	.sidebar-icon-only .sidebar .nav .nav-item .nav-link[aria-expanded] .menu-title {
		padding-top: 7px;
	}

	.sidebar-icon-only .main-panel {
		width: calc(100% - 0px);
	}

	.back {
		background: #00000087;
		padding: 15px;
		color: white;
		min-height: 120px;
	}

	.back h5 {
		min-height: 80px;
		font-size: 15px;
		font-weight: bold;
		color: #FFFFFF;
	}

	.greensubmit {
		background: #ab8a04 !important;
		font-weight: bold !important;
		color: #ffffff !important;
		box-shadow: -1px 10px 20px #ab8a04;
		background: #ab8a04 !important;
		background: -moz-linear-gradient(left, #ab8a04 0%, #ab8a04 80%, #ab8a04 100%) !important;
		background: -webkit-linear-gradient(left, #ab8a04 0%, #ab8a04 80%, #ab8a04 100%) !important;
		background: linear-gradient(to right, #ab8a04 0%, #ab8a04 80%, #ab8a04 100%) !important;
	}

	.ar_btn {
		background: linear-gradient(179deg, rgb(0 126 212) 0%, rgb(16 197 180) 35%, rgb(59 134 209) 100%);
		border-radius: 15px;
		font-weight: bold;
		height: 2.75em;
		margin: 10px;
	}

	.modal {
		display: none;
		position: fixed;
		z-index: 1;
		left: 0;
		top: 0;
		width: 100%;
		height: 100%;

		background-color: rgb(0, 0, 0);
		background-color: rgba(0, 0, 0, 0.4);
	}

	.modal-content {
		background-color: #fefefe;
		margin: 155px auto 20px auto;
		padding: 20px;
		border: 1px solid #888;
		width: 80%;
		max-height: 60vh;
		overflow-y: auto;
	}

	.body-no-scroll {
		overflow: hidden;
		height: 100%;
	}


	.close {
		color: #aaa;
		float: right;
		font-size: 28px;
		font-weight: bold;
	}

	.close:hover,
	.close:focus {
		color: black;
		text-decoration: none;
		cursor: pointer;
	}

	.capitalize {
		text-transform: capitalize;
		text-align: center;
	}
</style>
<?php
$summary_total = array();
$summary_total['sales'] = array();
$summary_total['expense'] = array();
$summary_total['offering'] = array();
?>

<body class="sidebar-icon-only">
	<div class="container-scroller">
		<div class="container-fluid page-body-wrapper">
			<div class="main-panel">
				<div class="content-wrapper">
					<div class="row clearfix">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="card">
								<div class="header">
									<form action="<?php echo base_url(); ?>/dailyclosing_online" method="post">
										<div class="row" style="margin: 10px 0px">
											<div class="col-md-2">
												<input type="date" name="dailyclosing_start_date"
													id="dailyclosing_start_date" class="form-control"
													value="<?php echo $dailyclosing_start_date; ?>">
											</div>
											<div class="col-md-2">
												<input type="date" name="dailyclosing_end_date"
													id="dailyclosing_end_date" class="form-control"
													value="<?php echo $dailyclosing_end_date; ?>">
											</div>
											<div class="col-md-2">
												<button type="submit" id="dailyclosing_filter"
													class="btn btn-success">Filter</button>
											</div>
											<div class="col-md-1" align="left">
												<button type="button" id="loadData" class="btn btn-info btn-lg ar_btn"
													onclick="openModal()">Today Closing</button>
											</div>
											<!-- Popup Modal -->
											<div class="col-md-1 " align="right" style="margin-left:30px">
												<a href="<?php echo base_url(); ?>/dailyclosing_online/print_a4/<?php echo strtotime($dailyclosing_start_date); ?>/<?php echo strtotime($dailyclosing_end_date); ?>"
													target="_blank"><button type="button"
														class="btn btn-info btn-lg ar_btn">Print A4</button></a>
											</div>
											<div class="col-md-1" align="right">
												<a href="<?php echo base_url(); ?>/dailyclosing_online/print/<?php echo strtotime($dailyclosing_start_date); ?>/<?php echo strtotime($dailyclosing_end_date); ?>"
													target="_blank"><button type="button"
														class="btn btn-info btn-lg ar_btn">Print</button></a>
											</div>
											<!-- <div class="col-md-1" align="right">
												<a href="<?php echo base_url(); ?>/dailyclosing_online/summary_print/<?php echo strtotime($dailyclosing_start_date); ?>/<?php echo strtotime($dailyclosing_end_date); ?>"
													target="_blank"><button type="button"
														class="btn btn-info btn-lg ar_btn">Summary</button></a>
											</div>
											<div class="col-md-1" align="right">
												<a href="<?php echo base_url(); ?>/dailyclosing_online/summary_print_a4/<?php echo strtotime($dailyclosing_start_date); ?>/<?php echo strtotime($dailyclosing_end_date); ?>"
													target="_blank"><button type="button"
														class="btn btn-info btn-lg ar_btn">Summary A4</button></a>
											</div> -->
											<div class="col-md-2" align="right">
												<a href="<?php echo base_url(); ?>/dailyclosing_online/summary_print_a4/<?php echo strtotime($dailyclosing_start_date); ?>/<?php echo strtotime($dailyclosing_end_date); ?>"
													target="_blank"><button type="button"
														class="btn btn-info btn-lg ar_btn">Daily Sales
														Report</button></a>
											</div>
											<div class="col-md-2" align="right">
												<a href="<?php echo base_url(); ?>/dailyclosing_online/summary_cash_denomination_a4/<?php echo strtotime($dailyclosing_start_date); ?>/<?php echo strtotime($dailyclosing_end_date); ?>"
													target="_blank"><button type="button"
														class="btn btn-info btn-lg ar_btn">Cash Denomination
														Report</button></a>
											</div>
											<!-- <div class="col-md-2" align="right">
												<a href="<?php echo base_url(); ?>/dailyclosing_online/daily_sales_report"
													target="_blank"><button type="button"
														class="btn btn-info btn-lg ar_btn">Daily Sales Report</button></a>
											</div> -->

											<!-- <form id="saleSummaryForm" action="<?php echo base_url(); ?>/dailyclosing_online/daily_sales_report" method="post">
												<input type="hidden" name="sale_summary" value='<?php echo json_encode($sale_summary); ?>'>
												<input type="submit" value="Print">
											</form> -->
										</div>
									</form>
								</div>
								<!-- Popup Modal -->


								<div class="body">
									<div class="col-md-12">
										<h3 style="text-align: center">Archanai Selling Details</h3>
										<?php if (!empty($arch_inv_no['first_ref_no']) && !empty($arch_inv_no['last_ref_no'])) { ?>
											<?php if ($arch_inv_no['first_ref_no'] != $arch_inv_no['last_ref_no']) { ?>
												<h5 style="text-align: center">( <?php echo $arch_inv_no['first_ref_no']; ?> -
													<?php echo $arch_inv_no['last_ref_no']; ?> )</h5>
											<?php } else { ?>
												<h5 style="text-align: center">( <?php echo $arch_inv_no['first_ref_no']; ?>)
												</h5>
											<?php }
										} ?>
									</div>
									<div class="table-responsive col-md-12 det"
										style="background:#FFF; float:none;margin-bottom:0px;">
										<table class="table table-bordered table-striped table-hover">
											<thead style="background: #3F51B5;color: #fff;">
												<tr>
													<th style="padding: 5px 10px!important;">S.No</th>
													<th style="padding: 5px 10px!important;">Archanai</th>
													<th style="padding: 5px 10px!important;">Payment Mode</th>
													<th style="padding: 5px 10px!important;">Quantity</th>
													<th style="padding: 5px 10px!important;text-align:right;">Amount
														(S$)
													</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$archanai_total = 0;
												$archanai_qty = 0;
												$sale_summary = array();
												$sale_summary['archanai'] = array();
												$sale_summary['archanai']['total_amount'] = 0;
												if (count($archanai_diety_details) > 0) {
													foreach ($archanai_diety_details as $archanai_detail_data) {
														if (count($archanai_detail_data['data']) > 0) {
															$ar_i = 1;
															$sannathi_total = 0;
															$sannathi_qty = 0;
															echo '<tr><td colspan="5" style="text-align: center;"><h4>' . $archanai_detail_data['title'] . '</h4></td></tr>';
															foreach ($archanai_detail_data['data'] as $archanai_detail) {
																$archanai_total = $archanai_total + $archanai_detail['amount'];
																$sannathi_total = $sannathi_total + $archanai_detail['amount'];
																$sannathi_qty = $sannathi_qty + $archanai_detail['qty'];
																$archanai_qty = $archanai_qty + $archanai_detail['qty'];
																if (empty($sale_summary['archanai'][$archanai_detail['archanai_id']]['name_eng']))
																	$sale_summary['archanai'][$archanai_detail['archanai_id']]['name_eng'] = $archanai_detail['name_in_english'];
																if (empty($sale_summary['archanai'][$archanai_detail['archanai_id']]['name_tamil']))
																	$sale_summary['archanai'][$archanai_detail['archanai_id']]['name_in_tamil'] = $archanai_detail['name_in_tamil'];
																if (empty($sale_summary['archanai'][$archanai_detail['archanai_id']]['ledger_code']))
																	$sale_summary['archanai'][$archanai_detail['archanai_id']]['ledger_code'] = $archanai_detail['ledger_code'];
																if (empty($sale_summary['archanai'][$archanai_detail['archanai_id']]['ledger_name']))
																	$sale_summary['archanai'][$archanai_detail['archanai_id']]['ledger_name'] = $archanai_detail['ledger_name'];
																if (empty($sale_summary['archanai'][$archanai_detail['archanai_id']]['qty']))
																	$sale_summary['archanai'][$archanai_detail['archanai_id']]['qty'] = 0;
																$sale_summary['archanai'][$archanai_detail['archanai_id']]['qty'] += $archanai_detail['qty'];
																if (empty($sale_summary['archanai'][$archanai_detail['archanai_id']]['amount']))
																	$sale_summary['archanai'][$archanai_detail['archanai_id']]['amount'] = 0;
																$sale_summary['archanai'][$archanai_detail['archanai_id']]['amount'] = $archanai_detail['unit_price'];
																if (empty($sale_summary['archanai'][$archanai_detail['archanai_id']]['total']))
																	$sale_summary['archanai'][$archanai_detail['archanai_id']]['total'] = 0;
																$sale_summary['archanai'][$archanai_detail['archanai_id']]['total'] += $archanai_detail['amount'];
																if (empty($summary_total['sales'][$archanai_detail['paymentmode']]))
																	$summary_total['sales'][$archanai_detail['paymentmode']] = 0;
																$summary_total['sales'][$archanai_detail['paymentmode']] += $archanai_detail['amount'];

																// $sale_summary['archanai']['total_amount'] += $archanai_detail['amount'];
																$sale_summary['archanai']['paid_amount'] += $archanai_detail['amount'];
																?>
																<tr>
																	<td style="padding: 5px 10px!important;"><?php echo $ar_i; ?></td>
																	<td style="padding: 5px 10px!important;">
																		<?php
																		echo $archanai_detail['name_in_english'] . " / " . $archanai_detail['name_in_tamil'];
																		?>
																	</td>
																	<td style="padding: 5px 10px!important;text-align:right;">
																		<?php
																		echo $archanai_detail['paymentmode'];
																		?>
																	</td>
																	<td style="padding: 5px 10px!important; text-align: right;">
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
															echo '<tr><td colspan="3" style="text-align: center;"><h6>' . $archanai_detail_data['title'] . ' Total</h4></td><td style="padding: 5px 10px!important;text-align:right;font-weight:bold;">' . $sannathi_qty . '</td><td style="padding: 5px 10px!important;text-align:right;font-weight:bold;">' . number_format($sannathi_total, 2) . '</td></tr>';
														}
													}
												}
												?>
											</tbody>
											<tfoot>
												<tr>
													<td colspan="3" style="text-align: center;">
														<h6>Overall Total</h6>
													</td>
													<td
														style="padding: 5px 10px!important;text-align:right;font-weight:bold;">
														<?php echo $archanai_qty; ?>
													</td>
													<td
														style="padding: 5px 10px!important;text-align:right;font-weight:bold;">
														<?php echo number_format($archanai_total, 2); ?>
													</td>
												</tr>
											</tfoot>
										</table>
									</div>

									<?php
									$donation_total = 0;
									$sale_summary['donation'] = array();
									$sale_summary['donation']['total_amount'] = 0;
									if (count($donation_details) > 0) {
										?>
										<div class="col-md-12">
											<h3 style="text-align: center">Cash Donation Details</h3>
											<?php if (!empty($don_inv_no['first_ref_no']) && !empty($don_inv_no['last_ref_no'])) { ?>
												<?php if ($don_inv_no['first_ref_no'] != $don_inv_no['last_ref_no']) { ?>
													<h5 style="text-align: center">( <?php echo $don_inv_no['first_ref_no']; ?> -
														<?php echo $don_inv_no['last_ref_no']; ?> )</h5>
												<?php } else { ?>
													<h5 style="text-align: center">( <?php echo $don_inv_no['first_ref_no']; ?> )
													</h5>
												<?php } ?>
											<?php } ?>
										</div>
										<div class="table-responsive col-md-12 det"
											style="background:#FFF; float:none;margin-bottom:0px;">
											<table class="table table-bordered table-striped table-hover">
												<thead style="background: #3F51B5;color: #fff;">
													<tr>
														<th style="padding: 5px 10px!important;">S.No</th>
														<th style="padding: 5px 10px!important;">Name</th>
														<th style="padding: 5px 10px!important;">Payment Mode</th>
														<th style="padding: 5px 10px!important;text-align:right;">Amount
															(S$)
														</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$d_i = 1;
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

														// $sale_summary['donation']['total_amount'] += $donation_detail['paidamount'];
														$sale_summary['donation']['paid_amount'] += $donation_detail['paidamount'];
														?>
														<tr>
															<td style="padding: 5px 10px!important;">
																<?php echo $d_i; ?>
															</td>
															<td style="padding: 5px 10px!important;">
																<?php
																echo $donation_detail['person_name'];
																?>
															</td>
															<td style="padding: 5px 10px!important;">
																<?php
																echo $donation_detail['paymentmode'];
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
												<tfoot>
													<tr>
														<td colspan="3">&nbsp;</td>
														<td
															style="padding: 5px 10px!important;text-align:right;font-weight:bold;">
															<?php echo number_format($donation_total, 2); ?>
														</td>
													</tr>
												</tfoot>
											</table>
										</div>
										<?php
									}
									?>
									<?php
									$prasadam_total = 0;
									$sale_summary['prasadam'] = array();
									$sale_summary['prasadam']['total_amount'] = 0;
									$sale_summary['prasadam']['paid_amount'] = 0;
									if (count($prasadam_details) > 0) {
										?>
										<div class="col-md-12">
											<h3 style="text-align: center">Prasadam Details</h3>
											<?php if (!empty($pras_inv_no['first_ref_no']) && !empty($pras_inv_no['last_ref_no'])) { ?>
												<?php if ($pras_inv_no['first_ref_no'] != $pras_inv_no['last_ref_no']) { ?>
													<h5 style="text-align: center">( <?php echo $pras_inv_no['first_ref_no']; ?> -
														<?php echo $pras_inv_no['last_ref_no']; ?> )</h5>
												<?php } else { ?>
													<h5 style="text-align: center">( <?php echo $pras_inv_no['first_ref_no']; ?> )
													</h5>
												<?php }
											} ?>
										</div>
										<div class="table-responsive col-md-12 det"
											style="background:#FFF; float:none;margin-bottom:0px;">
											<table class="table table-bordered table-striped table-hover">
												<thead style="background: #3F51B5;color: #fff;">
													<tr>
														<th style="padding: 5px 10px!important;">S.No</th>
														<th style="padding: 5px 10px!important;">Name</th>
														<th style="padding: 5px 10px!important;">Payment Mode</th>
														<th style="padding: 5px 10px!important;">Payment Type</th>
														<th style="padding: 5px 10px!important;text-align:right;">Total
															Amount (S$)
														<th style="padding: 5px 10px!important;text-align:right;">Paid
															Amount (S$) </th>
													</tr>
												</thead>
												<tbody>
													<?php
													$ps_i = 1;

													foreach ($prasadam_details as $prasadam_detail) {
														$prasadam_total += $prasadam_detail['paidamount'];

														foreach ($prasadam_detail['products'] as $product) {
															$productName = $product['package_name'];

															if (!isset($sale_summary['prasadam'][$productName])) {
																$sale_summary['prasadam'][$productName] = [
																	'name_eng' => $productName,
																	'ledger_code' => $product['ledger_code'],
																	'qty' => 0,
																	'total' => 0
																];
															}

															$sale_summary['prasadam'][$productName]['qty'] += $product['quantity'];  // Use actual quantity from the products array
															$sale_summary['prasadam'][$productName]['total'] += $product['amount'];
														}
														$sale_summary['prasadam']['total_amount'] += $prasadam_detail['amount'];
														$sale_summary['prasadam']['paid_amount'] += $prasadam_detail['paidamount'];

														if (empty($summary_total['sales'][$prasadam_detail['paymentmode']]))
															$summary_total['sales'][$prasadam_detail['paymentmode']] = 0;
														$summary_total['sales'][$prasadam_detail['paymentmode']] += $prasadam_detail['paidamount'];
														?>

														<tr>
															<td style="padding: 5px 10px!important;">
																<?php echo $ps_i; ?>
															</td>
															<td style="padding: 5px 10px!important;">
																<?php
																echo $prasadam_detail['customer_name'];
																?>
															</td>
															<td style="padding: 5px 10px!important;">
																<?php
																echo $prasadam_detail['paymentmode'];
																?>
															</td>
															<td style="padding: 5px 10px!important;">
																<?php
																echo $prasadam_detail['payment_type'];
																?>
															</td>
															<td style="padding: 5px 10px!important;text-align:right;">
																<?php
																echo number_format($prasadam_detail['amount'], 2);
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
												<tfoot>
													<tr>
														<td colspan="5">&nbsp;</td>
														<td
															style="padding: 5px 10px!important;text-align:right;font-weight:bold;">
															<?php echo number_format($prasadam_total, 2); ?>
														</td>
													</tr>
												</tfoot>
											</table>
										</div>
										<?php
									}
									?>
									<?php
									$annathanam_total = 0;
									$sale_summary['annathanam'] = array();
									$sale_summary['annathanam']['total_amount'] = 0;
									$sale_summary['annathanam']['paid_amount'] = 0;
									if (count($annathanam_details) > 0) {
										?>
										<div class="col-md-12">
											<h3 style="text-align: center">Annathanam Details</h3>
											<?php if (!empty($anna_inv_no['first_ref_no']) && !empty($anna_inv_no['last_ref_no'])) { ?>
												<?php if ($anna_inv_no['first_ref_no'] != $anna_inv_no['last_ref_no']) { ?>
													<h5 style="text-align: center">( <?php echo $anna_inv_no['first_ref_no']; ?> -
														<?php echo $anna_inv_no['last_ref_no']; ?> )</h5>
												<?php } else { ?>
													<h5 style="text-align: center">( <?php echo $anna_inv_no['first_ref_no']; ?> )
													</h5>
												<?php }
											} ?>
										</div>
										<div class="table-responsive col-md-12 det"
											style="background:#FFF; float:none;margin-bottom:0px;">
											<table class="table table-bordered table-striped table-hover">
												<thead style="background: #3F51B5;color: #fff;">
													<tr>
														<th style="padding: 5px 10px!important;">S.No</th>
														<th style="padding: 5px 10px!important;">Name</th>
														<th style="padding: 5px 10px!important;">Time</th>
														<th style="padding: 5px 10px!important;">Payment Mode</th>
														<th style="padding: 5px 10px!important;">Payment Type</th>
														<th style="padding: 5px 10px!important;">Booking Status</th>
														<th style="padding: 5px 10px!important;text-align:right;">Total
															Amount (S$)
														<th style="padding: 5px 10px!important;text-align:right;">Paid
															Amount (S$) </th>
													</tr>
												</thead>
												<tbody>
													<?php
													$ans_i = 1;

													foreach ($annathanam_details as $annathanam_detail) {
														$annathanam_total += $annathanam_detail['paidamount'];

														foreach ($annathanam_detail['products'] as $product) {
															$productName = $product['package_name'];

															if (!isset($sale_summary['annathanam'][$productName])) {
																$sale_summary['annathanam'][$productName] = [
																	'name_eng' => $productName,
																	'ledger_code' => $product['ledger_code'],
																	'qty' => 0,
																	'total' => 0
																];
															}
															$sale_summary['annathanam'][$productName]['qty'] += $product['quantity'];  // Use actual quantity from the products array
															$sale_summary['annathanam'][$productName]['total'] += $product['amount'];
														}
														$sale_summary['annathanam']['total_amount'] += $annathanam_detail['amount'];
														$sale_summary['annathanam']['paid_amount'] += $annathanam_detail['paidamount'];


														if (empty($summary_total['sales'][$annathanam_detail['paymentmode']]))
															$summary_total['sales'][$annathanam_detail['paymentmode']] = 0;
														$summary_total['sales'][$annathanam_detail['paymentmode']] += $annathanam_detail['paidamount'];
														?>
														<tr>
															<td style="padding: 5px 10px!important;">
																<?php echo $ans_i; ?>
															</td>
															<td style="padding: 5px 10px!important;">
																<?php echo $annathanam_detail['customer_name']; ?>
															</td>
															<td style="padding: 5px 10px!important;">
																<?php echo $annathanam_detail['time']; ?>
															</td>
															<td style="padding: 5px 10px!important;">
																<?php
																echo $annathanam_detail['paymentmode'];
																?>
															</td>
															<td style="padding: 5px 10px!important;">
																<?php
																echo $annathanam_detail['payment_type'];
																?>
															</td>
															<td style="padding: 5px 10px!important;">
																<?php
																if ($annathanam_detail['booking_status'] == 1) {
																	$status = 'BOOKED';
																} elseif ($annathanam_detail['booking_status'] == 2) {
																	$status = 'COMPLETED';
																} elseif ($annathanam_detail['booking_status'] == 3) {
																	$status = 'CANCELLED';
																} else {
																	$status = 'PENDING';
																}
																echo $status;
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
														$ans_i++;
													}
													?>
												</tbody>
												<tfoot>
													<tr>
														<td colspan="7">&nbsp;</td>
														<td
															style="padding: 5px 10px!important;text-align:right;font-weight:bold;">
															<?php echo number_format($annathanam_total, 2); ?>
														</td>
													</tr>
												</tfoot>
											</table>
										</div>
										<?php
									}
									?>
									<?php
									$hallbooking_total = 0;
									$sale_summary['hallbooking'] = array();
									$sale_summary['hallbooking']['total_amount'] = 0;
									$sale_summary['hallbooking']['paid_amount'] = 0;

									if (count($hallbooking_details) > 0) {
										?>
										<div class="col-md-12">
											<h3 style="text-align: center">Hall Booking Details</h3>
											<?php if (!empty($hall_inv_no['first_ref_no']) && !empty($hall_inv_no['last_ref_no'])) { ?>
												<?php if ($hall_inv_no['first_ref_no'] != $hall_inv_no['last_ref_no']) { ?>
													<h5 style="text-align: center">( <?php echo $hall_inv_no['first_ref_no']; ?> -
														<?php echo $hall_inv_no['last_ref_no']; ?> )</h5>
												<?php } else { ?>
													<h5 style="text-align: center">( <?php echo $hall_inv_no['first_ref_no']; ?>)
													</h5>
												<?php }
											} ?>
										</div>
										<div class="table-responsive col-md-12 det"
											style="background:#FFF; float:none;margin-bottom:0px;">
											<table class="table table-bordered table-striped table-hover">
												<thead style="background: #3F51B5;color: #fff;">
													<tr>
														<th style="padding: 5px 10px!important;">S.No</th>
														<th style="padding: 5px 10px!important;">Package Name</th>
														<th style="padding: 5px 10px!important;">Name</th>
														<th style="padding: 5px 10px!important;">Event date</th>
														<th style="padding: 5px 10px!important;">Payment Mode</th>
														<th style="padding: 5px 10px!important;">Booking Status</th>
														<th style="padding: 5px 10px!important;text-align:right;">Total
															Amount (S$)
														<th style="padding: 5px 10px!important;text-align:right;">Paid
															Amount (S$) </th>
													</tr>
												</thead>
												<tbody>
													<?php
													$ans_i = 1;

													foreach ($hallbooking_details as $hallbooking_detail) {
														$hallbooking_total += $hallbooking_detail['paidamount'];

														foreach ($hallbooking_detail['products'] as $product) {
															$productName = $product['package_name'];

															if ($hallbooking_detail['paidamount'] > 0) {
																if (!isset($sale_summary['hallbooking'][$productName])) {
																	$sale_summary['hallbooking'][$productName] = [
																		'name_eng' => $productName,
																		'ledger_code' => $product['ledger_code'],
																		'qty' => 0,
																		'total' => 0
																	];
																}
																$sale_summary['hallbooking'][$productName]['qty'] += $product['quantity'];  // Use actual quantity from the products array
																$sale_summary['hallbooking'][$productName]['total'] += $product['amount'];
															}
														}
														$sale_summary['hallbooking']['total_amount'] += $hallbooking_detail['amount'];
														$sale_summary['hallbooking']['paid_amount'] += $hallbooking_detail['paidamount'];


														if (empty($summary_total['sales'][$hallbooking_detail['paymentmode']]))
															$summary_total['sales'][$hallbooking_detail['paymentmode']] = 0;
														$summary_total['sales'][$hallbooking_detail['paymentmode']] += $hallbooking_detail['paidamount'];
														?>
														<tr>
															<td style="padding: 5px 10px!important;">
																<?php echo $ans_i; ?>
															</td>
															<td style="padding: 5px 10px!important;">
																<?php echo $product['package_name']; ?>
															</td>
															<td style="padding: 5px 10px!important;">
																<?php echo $hallbooking_detail['customer_name']; ?>
															</td>
															<td style="padding: 5px 10px!important;">
																<?php echo $hallbooking_detail['date']; ?>
															</td>
															<td style="padding: 5px 10px!important;">
																<?php
																echo $hallbooking_detail['paymentmode'];
																;
																?>
															</td>
															<td style="padding: 5px 10px!important;">
																<?php
																if ($hallbooking_detail['booking_status'] == 1) {
																	$status = 'BOOKED';
																} elseif ($hallbooking_detail['booking_status'] == 2) {
																	$status = 'COMPLETED';
																} elseif ($hallbooking_detail['booking_status'] == 3) {
																	$status = 'CANCELLED';
																} else {
																	$status = 'PENDING';
																}
																echo $status;
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
														$ans_i++;
													}
													?>
												</tbody>
												<tfoot>
													<tr>
														<td colspan="7">&nbsp;</td>
														<td
															style="padding: 5px 10px!important;text-align:right;font-weight:bold;">
															<?php echo number_format($hallbooking_total, 2); ?>
														</td>
													</tr>
												</tfoot>
											</table>
										</div>
										<?php
									}
									?>
									<?php
									$ubayam_total = 0;
									$sale_summary['ubayam'] = array();
									$sale_summary['ubayam']['total_amount'] = 0;
									$sale_summary['ubayam']['paid_amount'] = 0;

									if (count($ubayam_details) > 0) {
										?>
										<div class="col-md-12">
											<h3 style="text-align: center">Ubayam Details</h3>
											<?php if (!empty($ubayam_inv_no['first_ref_no']) && !empty($ubayam_inv_no['last_ref_no'])) { ?>
												<?php if ($ubayam_inv_no['first_ref_no'] != $ubayam_inv_no['last_ref_no']) { ?>
													<h5 style="text-align: center">( <?php echo $ubayam_inv_no['first_ref_no']; ?> -
														<?php echo $ubayam_inv_no['last_ref_no']; ?> )</h5>
												<?php } else { ?>
													<h5 style="text-align: center">( <?php echo $ubayam_inv_no['first_ref_no']; ?> )
													</h5>
												<?php }
											} ?>
										</div>
										<div class="table-responsive col-md-12 det"
											style="background:#FFF; float:none;margin-bottom:0px;">
											<table class="table table-bordered table-striped table-hover">
												<thead style="background: #3F51B5;color: #fff;">
													<tr>
														<th style="padding: 5px 10px!important;">S.No</th>
														<th style="padding: 5px 10px!important;">Package Name</th>
														<th style="padding: 5px 10px!important;">Name</th>
														<th style="padding: 5px 10px!important;">Event date</th>
														<th style="padding: 5px 10px!important;">Payment Mode</th>
														<th style="padding: 5px 10px!important;">Booking Status</th>
														<th style="padding: 5px 10px!important;text-align:right;">Total
															Amount (S$)
														<th style="padding: 5px 10px!important;text-align:right;">Paid
															Amount (S$) </th>
													</tr>
												</thead>
												<tbody>
													<?php
													$ans_i = 1;

													foreach ($ubayam_details as $ubayam_detail) {
														$ubayam_total += $ubayam_detail['paidamount'];

														foreach ($ubayam_detail['products'] as $product) {
															$productName = $product['package_name'];

															if ($ubayam_detail['paidamount'] > 0) {
																if (!isset($sale_summary['ubayam'][$productName])) {
																	$sale_summary['ubayam'][$productName] = [
																		'name_eng' => $productName,
																		'ledger_code' => $product['ledger_code'],
																		'qty' => 0,
																		'total' => 0
																	];
																}
																$sale_summary['ubayam'][$productName]['qty'] += $product['quantity'];  // Use actual quantity from the products array
																$sale_summary['ubayam'][$productName]['total'] += $ubayam_detail['paidamount'];
															}
														}
														$sale_summary['ubayam']['total_amount'] += $ubayam_detail['amount'];
														$sale_summary['ubayam']['paid_amount'] += $ubayam_detail['paidamount'];


														if (empty($summary_total['sales'][$ubayam_detail['paymentmode']]))
															$summary_total['sales'][$ubayam_detail['paymentmode']] = 0;
														$summary_total['sales'][$ubayam_detail['paymentmode']] += $ubayam_detail['paidamount'];
														?>
														<tr>
															<td style="padding: 5px 10px!important;">
																<?php echo $ans_i; ?>
															</td>
															<td style="padding: 5px 10px!important;">
																<?php echo $product['package_name']; ?>
															</td>
															<td style="padding: 5px 10px!important;">
																<?php echo $ubayam_detail['customer_name']; ?>
															</td>
															<td style="padding: 5px 10px!important;">
																<?php echo $ubayam_detail['date']; ?>
															</td>
															<td style="padding: 5px 10px!important;">
																<?php
																$ubayam_detail['paymentmode'];

																echo $ubayam_detail['paymentmode'];
																?>
															</td>
															<td style="padding: 5px 10px!important;">
																<?php
																if ($ubayam_detail['booking_status'] == 1) {
																	$status = 'BOOKED';
																} elseif ($ubayam_detail['booking_status'] == 2) {
																	$status = 'COMPLETED';
																} elseif ($ubayam_detail['booking_status'] == 3) {
																	$status = 'CANCELLED';
																} else {
																	$status = 'PENDING';
																}
																echo $status;
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
														$ans_i++;
													}
													?>
												</tbody>
												<tfoot>
													<tr>
														<td colspan="7">&nbsp;</td>
														<td
															style="padding: 5px 10px!important;text-align:right;font-weight:bold;">
															<?php echo number_format($ubayam_total, 2); ?>
														</td>
													</tr>
												</tfoot>
											</table>
										</div>
										<?php
									}
									?>


									<?php
									$Kattalai_archanai_total = 0;
									$sale_summary['Kattalai archanai'] = array();
									$sale_summary['Kattalai archanai']['total_amount'] = 0;
									$sale_summary['Kattalai archanai']['paid_amount'] = 0;
									if (count($Kattalai_archanai_details) > 0) {
										?>
										<div class="col-md-12">
											<h3 style="text-align: center">Kattalai Archanai Details</h3>
											<?php if (!empty($katt_inv_no['first_ref_no']) && !empty($katt_inv_no['last_ref_no'])) { ?>
												<?php if ($katt_inv_no['first_ref_no'] != $katt_inv_no['last_ref_no']) { ?>
													<h5 style="text-align: center">( <?php echo $katt_inv_no['first_ref_no']; ?> -
														<?php echo $katt_inv_no['last_ref_no']; ?> )</h5>
												<?php } else { ?>
													<h5 style="text-align: center">( <?php echo $katt_inv_no['first_ref_no']; ?> )
													</h5>
												<?php }
											} ?>
										</div>
										<div class="table-responsive col-md-12 det"
											style="background:#FFF; float:none;margin-bottom:0px;">
											<table class="table table-bordered table-striped table-hover">
												<thead style="background: #3F51B5;color: #fff;">
													<tr>
														<th style="width: 5%; padding: 5px 10px!important;">S.No</th>
														<th style="width: 10%; padding: 5px 10px!important;">Devotee Name
														</th>
														<th style="width: 10%; padding: 5px 10px!important;">Type</th>
														<!-- <th style="width: 40%; padding: 5px 10px!important;">Deity</th> -->
														<th style="width: 15%; padding: 5px 10px!important;">Payment Mode
														</th>
														<th style="width: 10%; padding: 5px 10px!important;">Booking Status
														</th>
														<th
															style="width: 10%; padding: 5px 10px!important;text-align:right;">
															Total Amount (S$)
														<th
															style="width: 10%; padding: 5px 10px!important;text-align:right;">
															Paid Amount (S$) </th>
													</tr>
												</thead>
												<tbody>
													<?php
													$ps_i = 1;

													foreach ($Kattalai_archanai_details as $Kattalai_archanai_detail) {
														$Kattalai_archanai_total += $Kattalai_archanai_detail['paidamount'];

														foreach ($Kattalai_archanai_detail['products'] as $product) {
															$productName = $product['package_name'];

															if (!isset($sale_summary['Kattalai archanai'][$productName])) {
																$sale_summary['Kattalai archanai'][$productName] = [
																	'name_eng' => $productName,
																	'ledger_code' => $product['ledger_code'],
																	'qty' => 0,
																	'total' => 0
																];
															}

															// $sale_summary['Kattalai_archanai'][$productName]['qty'] += isset($product['quantity']) && $product['quantity'] > 0 ? $product['quantity'] : 1;
															//$total = $product['quantity'] * $product['unit_amount'];
															//$sale_summary['Kattalai_archanai'][$productName]['qty'] += $product['quantity'];
															//$sale_summary['Kattalai_archanai'][$productName]['total'] += $total;
												
															$sale_summary['Kattalai archanai'][$productName]['qty'] += 1;
															$sale_summary['Kattalai archanai'][$productName]['total'] += $product['unit_amount'];
														}
														$sale_summary['Kattalai archanai']['total_amount'] += $Kattalai_archanai_detail['amount'];
														$sale_summary['Kattalai archanai']['paid_amount'] += $Kattalai_archanai_detail['paidamount'];

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
																echo $Kattalai_archanai_detail['daytype'];
																?>
															</td>
															<!-- <td style="padding: 5px 10px!important;">
																<?php
																//echo $Kattalai_archanai_detail['deity_name'];
																?>
															</td> -->
															<td style="padding: 5px 10px!important;">
																<?php
																$Kattalai_archanai_detail['paymentmode'];

																echo $Kattalai_archanai_detail['paymentmode'];
																?>
															</td>
															<td style="padding: 5px 10px!important;">
																<?php
																echo $Kattalai_archanai_detail['payment_type'];
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
														<td colspan="6">&nbsp;</td>
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
									$sale_summary['Kattalai abishegam'] = array();
									$sale_summary['Kattalai abishegam']['total_amount'] = 0;
									$sale_summary['Kattalai abishegam']['paid_amount'] = 0;
									if (count($Kattalai_abishegam_details) > 0) {
										?>
										<div class="col-md-12">
											<h3 style="text-align: center">Kattalai Abishegam Details</h3>
											<?php if (!empty($katt_ainv_no['first_ref_no']) && !empty($katt_ainv_no['last_ref_no'])) { ?>
												<?php if ($katt_ainv_no['first_ref_no'] != $katt_ainv_no['last_ref_no']) { ?>
													<h5 style="text-align: center">( <?php echo $katt_ainv_no['first_ref_no']; ?> - <?php echo $katt_ainv_no['last_ref_no']; ?> )</h5>
												<?php } else { ?>
													<h5 style="text-align: center">( <?php echo $katt_ainv_no['first_ref_no']; ?> )</h5>
												<?php } 
											}?>
										</div>
										<div class="table-responsive col-md-12 det"
											style="background:#FFF; float:none;margin-bottom:0px;">
											<table class="table table-bordered table-striped table-hover">
												<thead style="background: #3F51B5;color: #fff;">
													<tr>
														<th style="width: 5%; padding: 5px 10px!important;">S.No</th>
														<th style="width: 10%; padding: 5px 10px!important;">Devotee Name</th>
														<th style="width: 10%; padding: 5px 10px!important;">Type</th>
														<!-- <th style="width: 40%; padding: 5px 10px!important;">Deity</th> -->
														<th style="width: 15%; padding: 5px 10px!important;">Payment Mode</th>
														<th style="width: 10%; padding: 5px 10px!important;">Booking Status</th>
														<th style="width: 10%; padding: 5px 10px!important;text-align:right;">Total Amount (S$) 
														<th style="width: 10%; padding: 5px 10px!important;text-align:right;">Paid Amount (S$) </th>
													</tr>
												</thead>
												<tbody>
													<?php
													$ps_i = 1;
													
													foreach ($Kattalai_abishegam_details as $Kattalai_abishegam_detail) {
														$Kattalai_abishegam_total += $Kattalai_abishegam_detail['paidamount'];
														
														foreach ($Kattalai_abishegam_detail['products'] as $product) {
															$productName = $product['package_name'];
															
															if (!isset($sale_summary['Kattalai abishegam'][$productName])) {
																$sale_summary['Kattalai abishegam'][$productName] = [
																	'name_eng' => $productName,
																	'ledger_code' => $product['ledger_code'],
																	'qty' => 0,
																	'total' => 0
																];
															}
													
															// $sale_summary['Kattalai_archanai'][$productName]['qty'] += isset($product['quantity']) && $product['quantity'] > 0 ? $product['quantity'] : 1;
															//$total = $product['quantity'] * $product['unit_amount'];
															//$sale_summary['Kattalai_archanai'][$productName]['qty'] += $product['quantity'];
															//$sale_summary['Kattalai_archanai'][$productName]['total'] += $total;

															$sale_summary['Kattalai abishegam'][$productName]['qty'] += 1;
															$sale_summary['Kattalai abishegam'][$productName]['total'] += $product['unit_amount'];
														}
														$sale_summary['Kattalai abishegam']['total_amount'] += $Kattalai_abishegam_detail['amount'];
														$sale_summary['Kattalai abishegam']['paid_amount'] += $Kattalai_abishegam_detail['paidamount'];

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
																echo $Kattalai_abishegam_detail['daytype'];
																?>
															</td>
															<!-- <td style="padding: 5px 10px!important;">
																<?php
																//echo $Kattalai_archanai_detail['deity_name'];
																?>
															</td> -->
															<td style="padding: 5px 10px!important;">
																<?php
																$Kattalai_abishegam_detail['paymentmode'];

																echo $Kattalai_abishegam_detail['paymentmode'];
																?>
															</td>
															<td style="padding: 5px 10px!important;">
																<?php
																echo $Kattalai_abishegam_detail['payment_type'];
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
														<td colspan="6">&nbsp;</td>
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
									$sale_summary['outdoor services'] = array();
									$sale_summary['outdoor services']['total_amount'] = 0;
									$sale_summary['outdoor services']['paid_amount'] = 0;

									if (count($outdoor_services_details) > 0) {
										?>
										<div class="col-md-12">
											<h3 style="text-align: center">Outdoor Services Details</h3>
											<?php if (!empty($outdoor_inv_no['first_ref_no']) && !empty($outdoor_inv_no['last_ref_no'])) { ?>
												<?php if ($outdoor_inv_no['first_ref_no'] != $outdoor_inv_no['last_ref_no']) { ?>
													<h5 style="text-align: center">( <?php echo $outdoor_inv_no['first_ref_no']; ?>
														- <?php echo $outdoor_inv_no['last_ref_no']; ?> )</h5>
												<?php } else { ?>
													<h5 style="text-align: center">( <?php echo $outdoor_inv_no['first_ref_no']; ?>
														)</h5>
												<?php }
											} ?>
										</div>
										<div class="table-responsive col-md-12 det"
											style="background:#FFF; float:none;margin-bottom:0px;">
											<table class="table table-bordered table-striped table-hover">
												<thead style="background: #3F51B5;color: #fff;">
													<tr>
														<th style="padding: 5px 10px!important;">S.No</th>
														<th style="padding: 5px 10px!important;">Name</th>
														<th style="padding: 5px 10px!important;">Event date</th>
														<th style="padding: 5px 10px!important;">Payment Mode</th>
														<th style="padding: 5px 10px!important;">Payment Type</th>
														<th style="padding: 5px 10px!important;text-align:right;">Total
															Amount (S$)
														<th style="padding: 5px 10px!important;text-align:right;">Paid
															Amount (S$) </th>
													</tr>
												</thead>
												<tbody>
													<?php
													$ans_i = 1;
													foreach ($outdoor_services_details as $outdoor_services_detail) {
														$outdoor_services_total += $outdoor_services_detail['paidamount'];

														foreach ($outdoor_services_detail['products'] as $product) {
															$productName = $product['package_name'];

															if (!isset($sale_summary['outdoor services'][$productName])) {
																$sale_summary['outdoor services'][$productName] = [
																	'name_eng' => $productName,
																	'ledger_code' => $product['ledger_code'],
																	'qty' => 0,
																	'total' => 0
																];
															}
															$sale_summary['outdoor services'][$productName]['qty'] += $product['quantity'];  // Use actual quantity from the products array
															$sale_summary['outdoor services'][$productName]['total'] += $product['amount'];
														}
														$sale_summary['outdoor services']['total_amount'] += $outdoor_services_detail['amount'];
														$sale_summary['outdoor services']['paid_amount'] += $outdoor_services_detail['paidamount'];

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
																<?php echo $outdoor_services_detail['date']; ?>
															</td>
															<td style="padding: 5px 10px!important;">
																<?php
																$outdoor_services_detail['paymentmode'];

																echo $outdoor_services_detail['paymentmode'];
																?>
															</td>
															<td style="padding: 5px 10px!important;">
																<?php
																echo $outdoor_services_detail['payment_type'];
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
														<td colspan="6">&nbsp;</td>
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
									$catering_total = 0;
									$sale_summary['catering'] = array();
									$sale_summary['catering']['total_amount'] = 0;
									$sale_summary['catering']['paid_amount'] = 0;
									if (count($catering_details) > 0) {
										?>
										<div class="col-md-12">
											<h3 style="text-align: center">Catering Details</h3>
											<?php if (!empty($catering_inv_no['first_ref_no']) && !empty($catering_inv_no['last_ref_no'])) { ?>
												<?php if ($catering_inv_no['first_ref_no'] != $catering_inv_no['last_ref_no']) { ?>
													<h5 style="text-align: center">( <?php echo $catering_inv_no['first_ref_no']; ?>
														- <?php echo $catering_inv_no['last_ref_no']; ?> )</h5>
												<?php } else { ?>
													<h5 style="text-align: center">( <?php echo $catering_inv_no['first_ref_no']; ?>
														)</h5>
												<?php }
											} ?>
										</div>
										<div class="table-responsive col-md-12 det"
											style="background:#FFF; float:none;margin-bottom:0px;">
											<table class="table table-bordered table-striped table-hover">
												<thead style="background: #3F51B5;color: #fff;">
													<tr>
														<th style="padding: 5px 10px!important;">S.No</th>
														<th style="padding: 5px 10px!important;">Name</th>
														<th style="padding: 5px 10px!important;">Time</th>
														<th style="padding: 5px 10px!important;">Payment Mode</th>
														<th style="padding: 5px 10px!important;">Payment Type</th>
														<th style="padding: 5px 10px!important;">Booking Status</th>
														<th style="padding: 5px 10px!important;text-align:right;">Total
															Amount (S$)
														<th style="padding: 5px 10px!important;text-align:right;">Paid
															Amount (S$) </th>
													</tr>
												</thead>
												<tbody>
													<?php
													$ans_i = 1;

													foreach ($catering_details as $catering_detail) {
														$catering_total += $catering_detail['paidamount'];

														foreach ($catering_detail['products'] as $product) {
															$productName = $product['package_name'];

															if (!isset($sale_summary['catering'][$productName])) {
																$sale_summary['catering'][$productName] = [
																	'name_eng' => $productName,
																	'ledger_code' => $product['ledger_code'],
																	'qty' => 0,
																	'total' => 0
																];
															}
															$sale_summary['catering'][$productName]['qty'] += $product['quantity'];  // Use actual quantity from the products array
															$sale_summary['catering'][$productName]['total'] += $product['amount'];
														}
														$sale_summary['catering']['total_amount'] += $catering_detail['amount'];
														$sale_summary['catering']['paid_amount'] += $catering_detail['paidamount'];


														if (empty($summary_total['sales'][$catering_detail['paymentmode']]))
															$summary_total['sales'][$catering_detail['paymentmode']] = 0;
														$summary_total['sales'][$catering_detail['paymentmode']] += $catering_detail['paidamount'];
														?>
														<tr>
															<td style="padding: 5px 10px!important;">
																<?php echo $ans_i; ?>
															</td>
															<td style="padding: 5px 10px!important;">
																<?php echo $catering_detail['customer_name']; ?>
															</td>
															<td style="padding: 5px 10px!important;">
																<?php echo $catering_detail['time']; ?>
															</td>
															<td style="padding: 5px 10px!important;">
																<?php echo $catering_detail['paymentmode']; ?>
															</td>
															<td style="padding: 5px 10px!important;">
																<?php
																echo $catering_detail['payment_type'];
																?>
															</td>
															<td style="padding: 5px 10px!important;">
																<?php
																if ($catering_detail['booking_status'] == 1) {
																	$status = 'BOOKED';
																} elseif ($catering_detail['booking_status'] == 2) {
																	$status = 'COMPLETED';
																} elseif ($catering_detail['booking_status'] == 3) {
																	$status = 'CANCELLED';
																} else {
																	$status = 'PENDING';
																}
																echo $status;
																?>
															</td>
															<td style="padding: 5px 10px!important;text-align:right;">
																<?php
																echo number_format($catering_detail['amount'], 2);
																?>
															</td>
															<td style="padding: 5px 10px!important;text-align:right;">
																<?php
																echo number_format($catering_detail['paidamount'], 2);
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
														<td colspan="7">&nbsp;</td>
														<td
															style="padding: 5px 10px!important;text-align:right;font-weight:bold;">
															<?php echo number_format($catering_total, 2); ?>
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
														<!-- <th style="padding: 5px 10px!important;text-align:right;">Amount (S$)  -->
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

														if (empty($summary_total['offering'][$details['paymentmode']]))
															$summary_total['offering'][$details['paymentmode']] = 0;
														$summary_total['offering'][$details['paymentmode']] += $details['grams'];
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
										$member_total = 0;
										$sale_summary['member'] = array();
										$sale_summary['member']['total_amount'] = 0;
										$sale_summary['member']['paid_amount'] = 0;
										if (count($member_details) > 0) {
											?>
											<div class="col-md-12">
												<h3 style="text-align: center">Member Registration Details</h3>
											</div>
											<div class="table-responsive col-md-12 det" style="background:#FFF; float:none;margin-bottom:0px;">
												<table class="table table-bordered table-striped table-hover">
													<thead style="background: #3F51B5;color: #fff;">
														<tr>
															<th style="padding: 5px 10px!important;">S.No</th>
															<th style="padding: 5px 10px!important;">Member No</th>
															<th style="padding: 5px 10px!important;">Name</th>
															<th style="padding: 5px 10px!important;">Member Type</th>
															<th style="padding: 5px 10px!important;">IC No</th>
															<th style="padding: 5px 10px!important;">Mobile</th>
															<th style="padding: 5px 10px!important;">Payment Mode</th>
															<th style="padding: 5px 10px!important;text-align:right;">Application Fee (S$)</th>
															<th style="padding: 5px 10px!important;text-align:right;">Amount (S$)</th>
														</tr>
													</thead>
													<tbody>
														<?php
														$mem_i = 1;
														foreach ($member_details as $member_detail) {
															// payment = base membership fee only; use total_amount (fee included) for actual cash collected.
															$member_detail['payment'] = $member_detail['total_amount'] ?? $member_detail['payment'];
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
															$sale_summary['member']['total_amount'] += floatval($member_detail['payment']);
															$sale_summary['member']['paid_amount'] += floatval($member_detail['payment']);

															if (empty($summary_total['sales'][$member_detail['paymentmode']]))
																$summary_total['sales'][$member_detail['paymentmode']] = 0;
															$summary_total['sales'][$member_detail['paymentmode']] += floatval($member_detail['payment']);
															?>
															<tr>
																<td style="padding: 5px 10px!important;">
																	<?php echo $mem_i; ?>
																</td>
																<td style="padding: 5px 10px!important;">
																	<?php echo $member_detail['member_no']; ?>
																</td>
																<td style="padding: 5px 10px!important;">
																	<?php echo $member_detail['name']; ?>
																</td>
																<td style="padding: 5px 10px!important;">
																	<?php echo $member_detail['member_type_name']; ?>
																</td>
																<td style="padding: 5px 10px!important;">
																	<?php echo $member_detail['ic_no']; ?>
																</td>
																<td style="padding: 5px 10px!important;">
																	<?php echo $member_detail['mobile']; ?>
																</td>
																<td style="padding: 5px 10px!important;">
																	<?php echo $member_detail['paymentmode']; ?>
																</td>
																<td style="padding: 5px 10px!important;text-align:right;">
																	<?php echo number_format($member_detail['application_fee'] ?? 0, 2); ?>
																</td>
																<td style="padding: 5px 10px!important;text-align:right;">
																	<?php echo number_format($member_detail['payment'], 2); ?>
																</td>
															</tr>
															<?php
															$mem_i++;
														}
														?>
													</tbody>
													<tfoot>
														<tr>
															<td colspan="8">&nbsp;</td>
															<td style="padding: 5px 10px!important;text-align:right;font-weight:bold;">
																<?php echo number_format($member_total, 2); ?>
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
									$sale_summary['Repayment'] = array();
									$sale_summary['Repayment']['total_amount'] = 0;
									$sale_summary['Repayment']['paid_amount'] = 0;
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
														<!-- <th style="padding: 5px 10px!important;">Amount</th>
														<th style="padding: 5px 10px!important;">Paid Amount</th> -->
														<th style="padding: 5px 10px!important;">Payment Mode</th>
														<th
															style="width: 15%; padding: 5px 10px!important; text-align:right;">
															Booking Amount</th>
														<th style="padding: 5px 10px!important;text-align:right;">Repaid
															Amount (S$)
														</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$ans_i = 1;
													foreach ($repayment_details as $details) {
														$repayment_total += $details['repaid_amount'];
														$productName = $details['type'] . ' - ' . $details['customer_name'];

														if (!isset($sale_summary['Repayment'][$productName])) {
															$sale_summary['Repayment'][$productName] = [
																'name_eng' => $productName,
																'ledger_code' => 0,
																'qty' => 0,
																'total' => $details['repaid_amount']
															];
														}

														$sale_summary['Repayment']['total_amount'] += $details['repaid_amount'];
														$sale_summary['Repayment']['paid_amount'] += $details['repaid_amount'];

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

															<!-- <td style="padding: 5px 10px!important;">
																<?php /*
														   $details['paymentmode'];

														   echo $paymentname;
														   */ ?>
															</td> -->
															<td style="padding: 5px 10px!important;">
																<?php echo $details['paymentmode']; ?>
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



									<div id="closingModal" class="modal">
										<div class="modal-content">
											<span class="close" onclick="closeModal()">&times;</span>
											<h2>Today's Closing Denominations</h2>
											<form id="denominationsForm"
												action="<?php echo base_url(); ?>/dailyclosing_online/save_coin_denominations"
												method="post" enctype="multipart/form-data">

												<table id="denominationsTable" class="table">
													<thead>
														<tr>
															<th>Name</th>
															<th>Counter</th>
															<th>Camphor Tray</th>
															<th>Amount (S$)</th>
														</tr>
													</thead>
													<tbody>

													</tbody>
													<tfoot>
														<tr>
															<td>Total:</td>
															<td><span id="totalQuantity">0</span></td>
															<td></td>
															<td><span id="totalAmount">0.00</span></td>
														</tr>

													</tfoot>
												</table>
												<div class="row">
													<div class="col-md-8">
														<div class="form-group row">
															<label for="floating_cash"
																class="col-md-2 col-form-label ">Float Cash:</label>
															<div class="col-md-4">
																<input type="number" name="floating_cash"
																	id="floating_cash" class="form-control"
																	style="margin-bottom: 25px;">
															</div>
														</div>
														<div class="form-group row">
															<label for="calculated_total"
																class="col-md-2 col-form-label">Total:</label>
															<div class="col-md-4">
																<input type="number" name="calculated_total"
																	id="calculated_total" class="form-control"
																	style="margin-bottom: 25px;" readonly>
															</div>
														</div>
														<div class="form-group row">
															<label for="checked_by"
																class="col-md-2 col-form-label ">Checked By:</label>
															<div class="col-md-4">
																<input type="text" name="checked_by" id="checked_by"
																	class="form-control" style="margin-bottom: 25px;">
															</div>
														</div>
													</div>
													<div class="col-md-3 det" style="float:none;margin-bottom:0px;">
														<h3 style="text-align:center;font-weight: bold;">
															Payment Summary
														</h3>
														<!-- <?php
														$cash_total = 0;
														if (count($summary_total['sales'])) {
															echo '<h4 class>Incomes</h4>';
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

																echo '<p>' . $paymentname . ' Sales: ' . number_format($st, 2) . '</p>';
															}
														}

														?> -->
														<?php
														$cash_total = 0;
														$summary_totals = [];

														foreach ($summary_total['sales'] as $vl => $st) {
															if ($vl == 'cash') {
																$paymentname = 'CASH';
																$cash_total += $st;
															} elseif ($vl == "ipay_merch_qr") {
																$paymentname = "QR PAYMENT";
															} elseif ($vl == "ipay_merch_online") {
																$paymentname = "ONLINE PAYMENT";
															} elseif ($vl == "nets_pay") {
																$paymentname = 'NETS';
															} else {
																$paymentname = strtoupper(str_replace('_', ' ', $vl));
															}

															if (isset($summary_totals[$paymentname])) {
																$summary_totals[$paymentname] += $st;
															} else {
																$summary_totals[$paymentname] = $st;
															}
														}
														// echo '<pre>';
														// print_r($summary_totals);
														// echo '</pre>';
														
														if (count($summary_totals)) {
															echo '<h4 class>Incomes</h4>';
															foreach ($summary_totals as $paymentname => $total) {
																echo '<p>' . $paymentname . ' Sales: ' . number_format($total, 2) . '</p>';
															}
														}
														?>
													</div>
												</div>
												<div style="text-align: center;">
													<button type="submit" class="btn btn-success"
														style="width: 50%;">Save</button>
												</div>
											</form>
										</div>
									</div>

									<?php

									if (!empty($coin_denominations)) {
										$sno = 1;
										$denominationtotal = 0;
										$totalQuantity = 0;

										?>
										<div class="col-md-12">
											<h3>Cash Denominations</h3>
										</div>

										<div class="table-responsive col-md-12"
											style="background:#FFF; float:none;margin-bottom:0px;">
											<table class="table table-bordered table-striped table-hover">
												<thead style="background: #3F51B5;color: #fff;">
													<tr>
														<th style="padding: 5px 10px!important;">S.No</th>
														<th style="padding: 5px 10px!important;">Name</th>
														<!-- Quantity -->
														<th style="padding: 5px 10px!important;text-align:right;">Counter
														</th>
														<th style="padding: 5px 10px!important;text-align:right;">Camphor
															Tray</th>

														<th style="padding: 5px 10px!important;">Amount (S$)</th>
													</tr>
												</thead>
												<tbody>
													<?php
													foreach ($coin_denominations as $denomination) {

														$totalAmount = $denomination->c_amount + $denomination->amount;
														$totalQuantity += $denomination->quantity;
														$totalc_Quantity += $denomination->c_quantity;
														$totalquan = $totalQuantity + $totalc_Quantity;
														$denominationtotal += $totalAmount; // Sum up the amount
														?>
														<tr>
															<td style="padding: 5px 10px!important;"><?php echo $sno++; ?></td>
															<td style="padding: 5px 10px!important;">
																<?php echo $denomination->name; ?>
															</td>

															<td style="padding: 5px 10px!important;text-align:right;">
																<?php echo $denomination->quantity; ?>
															</td>
															<td style="padding: 5px 10px!important;text-align:right;">
																<?php echo $denomination->c_quantity; ?>
															</td>
															<td style="padding: 5px 10px!important;">
																<?php echo "$" . $totalAmount; ?>
															</td>
														</tr>
														<?php
													}
													?>
												</tbody>
												<tfoot>
													<!-- Display the totals -->
													<tr>
														<td colspan="3"
															style="text-align:right; padding: 5px 10px!important;">
															<strong>Sub Total:</strong>
														</td>

														<td style="padding: 5px 10px!important;text-align:right;">
															<strong><?php echo $totalquan; ?></strong>
														<td style="padding: 5px 10px!important;">
															<strong><?php echo "$" . number_format($denominationtotal, 2); ?></strong>
														</td>
														</td>
													</tr>
													<?php if (!empty($denominationtotal) && !empty($floating_cash['amount'])) { ?>
														<tr>
															<td colspan="4"
																style="text-align:right; padding: 5px 10px!important;">
																<strong>Float Cash:</strong>
															</td>

															<td style="padding: 5px 10px!important;">
																<strong><?php echo "$" . number_format($floating_cash['amount'], 2); ?></strong>
															</td>
															</td>
														</tr>
														<tr>
															<td colspan="4"
																style="text-align:right; padding: 5px 10px!important;">
																<strong>Total Cash:</strong>
															</td>

															<td style="padding: 5px 10px!important;">
																<strong><?php echo "$" . number_format($denominationtotal - $floating_cash['amount'], 2); ?></strong>
															</td>
															</td>
														</tr>
													<?php } ?>
												</tfoot>
											</table>
										</div>
										<?php
									}
									?>

									<div class="row">
										<!-- <div class="col-md-4">
											<h3 style="text-align:center;font-weight: bold;">
											Sale Summary
											</h3>
											<?php
											// $cash_total = 0;
											// if (count($sale_summary)) {
											// 	$sale_summary_qty = 0;
											// 	$sale_summary_amount = 0;
											// 	echo '<table class="table"><thead><tr><th>Item</th><th>Code</th><th>Qty</th><th>Amount (S$)</th></tr></thead><tbody>';
											// 	foreach ($sale_summary as $key => $values) {
											// 		echo '<tr><td colspan="4"><h4 class="capitalize">' . $key . '</h4></td></tr>';
											// 		if (count($values)) {
											// 			foreach ($values as $item) {
											// 				$sale_summary_qty += $item['qty'];
											// 				$sale_summary_amount += $item['total'];
											// 				echo '<tr>';
											// 				echo '<td><p>' . $item['name_eng'] . '</p></td>';
											// 				echo '<td><p>' . $item['ledger_code'] . '</p></td>';
											// 				echo '<td><p>' . $item['qty'] . '</p></td>';
											// 				echo '<td><p>' . number_format($item['total'], 2) . '</p></td>';
											// 				echo '</tr>';
											// 			}
											// 		}
											// 	}
											// 	echo '</tbody><tfoot><tr><th colspan="2">Total</th><th>' . $sale_summary_qty . '</th><th>' . number_format($sale_summary_amount, 2) . '</th></tr></tfoot></table>';
											// }
											?>
										</div> -->

										<div class="col-md-4">
											<h3 style="text-align:center;font-weight: bold;">Sale Summary</h3>
											<?php
											// echo '<pre>';
											// print_r($sale_summary);
											// echo '</pre>';
											
											if (!empty($sale_summary)) {
												$sale_summary_qty = 0;
												$sale_summary_amount = 0;
												echo '<table class="table"><thead><tr><th>Item</th><th>Code</th><th>Qty</th><th>Amount (S$)</th></tr></thead><tbody>';

												foreach ($sale_summary as $key => $category) {
													//if (!empty($category['total_amount'] == )) {
													echo '<tr><td colspan="4"><h4 style="margin-top: 10px;" class="capitalize">' . $key . '</h4></td></tr>';
													foreach ($category as $item) {
														if (is_array($item)) {
															$sale_summary_qty += $item['qty'];
															echo '<tr>';
															echo '<td>' . $item['name_eng'] . '</td>';
															echo '<td class="centered"><p>' . ($item['ledger_code'] > 0 ? $item['ledger_code'] : '-') . '</p></td>';
															echo '<td>' . $item['qty'] . '</td>';
															$total_display = $key == "Product Offering" ? $item['total'] . ' Grams ' : number_format($item['total'], 2);
															echo '<td class="centered"><p>' . $total_display . '</p></td>';
															echo '</tr>';
														}
													}
													//}
											
													if ($category['paid_amount'] != 0) {
														echo '<tr><th colspan="3" style="text-align:left;" class="capitalize">' . $key . ' Paid Amount</th><th>' . number_format($category['paid_amount'], 2) . '</th></tr>';
														$sale_summary_amount += $category['paid_amount'];
													}

													// if ($category['total_amount'] != 0.00) {
													// 	if (isset($category['paid_amount'])) {
													// 		echo '<tr><th colspan="3" style="text-align:left;" class="capitalize">' . $key . ' Total</th><th>' . number_format($category['total_amount'], 2) . '</th></tr>';
													// 		
													// 	} else {
													// 		echo '<tr><th colspan="3" style="text-align:left;" class="capitalize">' . $key . ' Total</th><th>' . number_format($category['total_amount'], 2) . '</th></tr>';
													// 		$sale_summary_amount += $category['total_amount']; 
													// 	}
													// }
												}

												echo '</tbody><tfoot><tr><th colspan="3" style="text-align:right;">Grand Total</th><th>' . number_format($sale_summary_amount, 2) . '</th></tr></tfoot></table>';
											} else {
												echo '<p>No sale summary data available.</p>';
											}
											?>
										</div>

										<div class="col-md-5"></div>
										<div class="col-md-3 det" style="float:none;margin-bottom:0px;">
											<h3 style="text-align:center;font-weight: bold;">
												Payment Summary
											</h3>
									<?php
									$cash_total = 0;
									$summary_totals = [];
									foreach ($summary_total['sales'] as $vl => $st) {
										if (!empty($st) && $st > 0) {
											$vl_lower = strtolower($vl); // Convert to lowercase for comparison
									
											if ($vl_lower == 'cash') {
												$paymentname = 'CASH';
												$cash_total += $st;
											} elseif ($vl_lower == 'nets_pay' || $vl_lower == 'nets' || $vl_lower == 'netspay' || $vl_lower == 'nets pay') {
												$paymentname = 'NETS';
											} elseif ($vl_lower == 'pay_now' || $vl_lower == 'paynow' || $vl_lower == 'pay now') {
												$paymentname = 'PAY NOW';
											} elseif ($vl_lower == 'cheque' || $vl_lower == 'check') {
												$paymentname = 'CHEQUE';
											} elseif ($vl_lower == 'online') {
												$paymentname = 'ONLINE';
											} else {
												$paymentname = strtoupper(str_replace('_', ' ', $vl));
											}

											if (isset($summary_totals[$paymentname])) {
												$summary_totals[$paymentname] += $st;
											} else {
												$summary_totals[$paymentname] = $st;
											}
										}
									}

									$payment_order = ['CASH', 'NETS', 'PAY NOW', 'CHEQUE'];

									if (count($summary_totals)) {
										echo '<h4>Incomes</h4>';

										// First show ordered payment modes
										foreach ($payment_order as $mode) {
											if (isset($summary_totals[$mode])) {
												echo '<p>' . $mode . ' Sales: ' . number_format($summary_totals[$mode], 2) . '</p>';
											}
										}

										// Then show any other payment modes not in the order list
										foreach ($summary_totals as $paymentname => $total) {
											if (!in_array($paymentname, $payment_order)) {
												echo '<p>' . $paymentname . ' Sales: ' . number_format($total, 2) . '</p>';
											}
										}
									}
									?>
										</div>
										<div class="col-md-12 det"
											style="background:#FFF; float:none;margin-bottom:0px;">
											<h3 style="text-align:center;font-weight: bold;">
												Total Income :
												<?php
												/*$total = $archanai_total + $hallbooking_total + $ubayam_total + $donation_total + $prasadam_total + $annathanam_total + $repayment_total + $Kattalai_archanai_total + $outdoor_services_total + $catering_total + $member_total;*/
												$total = $archanai_total + $hallbooking_total + $ubayam_total + $donation_total + $prasadam_total + $annathanam_total + $repayment_total + $Kattalai_archanai_total + $Kattalai_abishegam_total + $outdoor_services_total + $catering_total + $member_total;
												echo number_format($total, 2);
												?>
											</h3>
										</div>
										<?php /* <div class="col-md-12">
															<?php echo '<h3 style="text-align:center;font-weight: bold;">Total Cash Balance: ' . number_format($cash_total, 2) . '</h3>'; ?>
														</div>    */ ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<script>
	function openModal() {
		$('#closingModal').show();
		document.getElementById("closingModal").style.display = "block";
		document.body.classList.add("body-no-scroll");

	}

	function closeModal() {
		$('#closingModal').hide();
		document.getElementById("closingModal").style.display = "none";
		document.body.classList.remove("body-no-scroll");
	}

	$(document).ready(function () {
		function calculateTotal() {
			var total = 0;
			var totalQty = 0;
			$('#denominationsTable tbody tr').each(function () {
				var quantity = parseInt($(this).find('.quantity').val()) || 0;
				var cQuantity = parseInt($(this).find('.c_quantity').val()) || 0; // Get corrected quantity
				var combinedQuantity = quantity + cQuantity; // Sum both quantities
				var value = parseFloat($(this).find('.quantity').data('value'));
				var amount = combinedQuantity * value;
				totalQty += combinedQuantity;
				$(this).find('.amount').val('S$ ' + amount.toFixed(2));
				total += amount;
			});
			$('#totalAmount').text('S$ ' + total.toFixed(2)); // Format the total amount
			$('#totalQuantity').text(totalQty); // Update total quantity display

			// Calculate total after deducting float cash
			var floatCash = parseFloat($('#floating_cash').val()) || 0;
			var calculatedTotal = total - floatCash;
			$('#calculated_total').val(calculatedTotal.toFixed(2));
		}

		// Event to recalculate totals whenever the quantity changes
		$('#denominationsTable').on('input', '.quantity, .c_quantity', calculateTotal);

		$('#loadData').on('click', function () {
			$.ajax({
				url: "<?php echo base_url(); ?>/dailyclosing_online/get_coin_values",
				type: 'GET',
				dataType: 'json',
				success: function (data) {
					var tbody = $('#denominationsTable tbody');
					tbody.empty(); // Clear previous entries
					$.each(data, function (i, item) {
						tbody.append(
							`<tr>
								<td><label>${item.name}</label></td>
								<td><input name="quantity[${item.key}]" type="number" class="form-control quantity" value="0" data-value="${item.value}" min="0"></td>
								<td><input name="c_quantity[${item.key}]" type="number" class="form-control c_quantity" value="0" min="0"></td>
								<td><input type="text" class="form-control amount" readonly></td>
							</tr>`
						);
					});
					calculateTotal(); // Call the function to update totals initially
				},
				error: function () {
					alert('Error loading data.');
				}
			});
		});



		// Handle form submission
		$('#denominationsForm').submit(function (event) {
			event.preventDefault();

			// Send AJAX request
			$.ajax({
				url: "<?php echo base_url(); ?>/dailyclosing_online/save_coin_denominations",
				type: 'POST',
				data: $("#denominationsForm").serialize(),
				success: function (response) {
					alert('Data saved successfully!');
					closeModal();
					window.location.reload(true);
				},
				error: function () {
					alert('Error saving data.');
				}
			});
		});
		// Calculate total when float cash input changes
		$('#floating_cash').on('input', calculateTotal);
	});
</script>


</html>