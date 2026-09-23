<style>
body { height:100vh; width:100%;background: #fff; }
.page-body-wrapper{
	background: #fff;
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
a { text-decoration:none !important; }
.table tr th {
    font-size: 14px;
    background: #f7ebbb;
    color: #333232;
}
.pack, .pay {
    margin-bottom: 15px;
}
.form-label {
    text-transform: uppercase;
    font-size: 13px;
    letter-spacing: 1px;
    color:#333333;
    text-align: left;
    width: 100%;
}
table tr td, table tr th{
	border-collapse: collapse;
	border: 1px solid;
}
.body_head table tr td, .body_head table tr th{
	border: 0;
}
table{
	width: 100%;
	border-collapse: collapse;
}
.input { width:100%; text-align:left; }
select.input { color:#000; }

.sidebar-icon-only .sidebar .nav .nav-item .nav-link .menu-title { display:block !important; font-size:11px; color:#FFFFFF; }
.sidebar .nav .nav-item.active > .nav-link i.menu-icon {
    background: #edc10f;
    padding: 1px; list-style:outside;
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
	min-height:120px;
 }
.back h5 { min-height:80px; font-size:15px; font-weight:bold; color:#FFFFFF; }
.greensubmit{
    background: #ab8a04!important;
    font-weight: bold!important;
    color: #ffffff!important;
    box-shadow: -1px 10px 20px #ab8a04;
    background: #ab8a04!important;
    background: -moz-linear-gradient(left, #ab8a04 0%, #ab8a04 80%, #ab8a04 100%)!important;
    background: -webkit-linear-gradient(left, #ab8a04 0%, #ab8a04 80%, #ab8a04 100%)!important;
    background: linear-gradient(to right, #ab8a04 0%, #ab8a04 80%, #ab8a04 100%)!important;
}
.ar_btn {
    background: linear-gradient(179deg, rgb(0 126 212) 0%, rgb(16 197 180) 35%, rgb(59 134 209) 100%);
    border-radius: 15px;
    font-weight: bold;
    height: 2.75em;
    margin: 10px;
}
.capitalize{
	text-transform: capitalize;
	text-align: center;
}
</style>
<?php
	$summary_total = array();
	$summary_total['sales'] = array();
	$summary_total['expense'] = array();
?>
<body class="sidebar-icon-only">
	<div class="container-scroller" style="width: 100%;max-width: 710px; margin:0 auto;">
		<div class="container-fluid page-body-wrapper">
			<div class="main-panel">
				<div class="content-wrapper">
					<div class="row clearfix">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<!-- <div class="card"> -->
							<div class="">
								<div class="body_head">
									<!-- <table border="1" align="center">
										<tbody>
											<tr>
												<td width="15%" ><img src="<?php echo base_url(); ?>/uploads/main/<?php echo $temp_details['image']; ?>" style="width:120px;" align="left"></td>
												<td width="84%"  style="padding: 0px 5px;"><h2 style="text-align:left;margin-bottom: 0;font-size: 18px;"><?php echo $temp_details['name']; ?></h2>
												<p style="text-align:left; font-size:16px; margin:5px 0px;"><?php echo $temp_details['address1']; ?>, <?php echo $temp_details['address2']; ?><br>
												<?php echo $temp_details['city'].'-'.$temp_details['postcode']; ?><br>
												Tel : <?= $temp_details['telephone']; ?></p>
												</td>
											</tr>
										</tbody>
									</table> -->

									<table border="1" align="center" style="border-collapse: collapse; width: 100%;">
										<tbody>
											<tr>
												<td width="15%" style="border: 1px solid #000; vertical-align: top;">
													<img src="<?php echo base_url(); ?>/uploads/main/<?php echo $temp_details['image']; ?>" style="width:120px;" align="left">
												</td>
												<td width="85%" style="padding: 0px; border: 1px solid #000;">
													<table style="width: 100%; border-collapse: collapse;">
														<tr>
															<td>
																<h2 style="text-align:center; margin-bottom: 0; font-size: 18px;">
																	<?php echo $temp_details['name']; ?>
																</h2>
															</td>
														</tr>
														<tr>
															<td>
																<p style="text-align:center; font-size:16px; margin:0;">
																	<?php echo $temp_details['address1']; ?>, <?php echo $temp_details['city']; ?> - <?php echo $temp_details['postcode']; ?>
																</p>
															</td>
														</tr>
														<tr>
															<td>
																<p style="text-align:center; font-size:16px; margin:0;">
																	GST Reg.No: <?php echo $temp_details['gstno']; ?>
																</p>
															</td>
														</tr>
														<tr>
															<td>
																<p style="text-align:center; font-size:16px; margin:0;">
																	Tel: <?php echo $temp_details['telephone']; ?>  Fax: <?php echo $temp_details['fax_no']; ?>
																</p>
															</td>
														</tr>
													</table>
												</td>
											</tr>
											<tr>
												<td colspan="2" style="text-align: center; font-weight: bold; padding: 10px; border: 1px solid #000;">
													Cash Denominations Report- <?php if($dailyclosing_start_date == $dailyclosing_end_date){
												echo "Date : [".date('d-m-Y', strtotime($dailyclosing_start_date))."]";
											}else{
												echo "Date : [".date('d-m-Y', strtotime($dailyclosing_start_date))." - ".date('d-m-Y', strtotime($dailyclosing_end_date))."]";
											}?>
												</td>
											</tr>
										</tbody>
									</table>

								</div>
								<div class="body">
									<!-- <div class="col-md-12">
										<h4 style="text-transform: uppercase;text-align:center;">
											<?php if($dailyclosing_start_date == $dailyclosing_end_date){
												echo "Date - [".date('d-m-Y', strtotime($dailyclosing_start_date))."]";
											}else{
												echo "Date - [".date('d-m-Y', strtotime($dailyclosing_start_date))." - ".date('d-m-Y', strtotime($dailyclosing_end_date))."]";
											}?>
											
										</h4>
									</div> -->
									<?php ob_start(); ?>
									<div class="col-md-12">
										<h3>Archanai Selling Details</h3>
									</div>
									<div class="table-responsive col-md-12 det"
										style="background:#FFF; float:none;margin-bottom:0px;">
										<table class="table table-bordered table-striped table-hover">
											<thead style="background: #3F51B5;color: #fff;">
												<tr>
													<th style="padding: 5px 10px!important;">#</th>
													<th style="padding: 5px 10px!important;">Archanai</th>
													<th style="padding: 5px 10px!important;">Payment Mode</th>
													<th style="padding: 5px 10px!important;">Quantity</th>
													<th style="padding: 5px 10px!important;text-align:right;">Amount (S$)
													</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$archanai_total = 0;
												$archanai_qty = 0;
												$sale_summary = array();
												$sale_summary['archanai'] = array();
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
																?>
																<tr>
																	<td style="padding: 5px 10px!important;"><?php echo $ar_i; ?></td>
																	<td style="padding: 5px 10px!important;">
																		<?php
																		echo $archanai_detail['name_in_english'] . " / " . $archanai_detail['name_in_tamil'];
																		?>
																	</td>
																	<td style="padding: 5px 10px!important;text-transform: uppercase;">
																		<?php
																		if ($archanai_detail['paid_through'] == 'DIRECT') {
																			$paymentname = strtoupper($archanai_detail['paymentmode']);
																		} else {
																			if ($archanai_detail['paymentmode'] == "ipay_merch_qr") {
																				$paymentname = "QR PAYMENT";
																			} elseif ($archanai_detail['paymentmode'] == "ipay_merch_online") {
																				$paymentname = "ONLINE PAYMENT";
																			} elseif ($archanai_detail['paymentmode'] == "cash") {
																				$paymentname = strtoupper($archanai_detail['paymentmode']);
																			} else {
																				$paymentname = strtoupper(str_replace('_', ' ', $archanai_detail['paymentmode']));
																			}
																		}
																		echo $paymentname;
																		?>
																	</td>
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
														<?php echo $archanai_qty; ?></td>
													<td
														style="padding: 5px 10px!important;text-align:right;font-weight:bold;">
														<?php echo number_format($archanai_total, 2); ?></td>
												</tr>
											</tfoot>
										</table>
									</div>
									<?php 
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
													<th style="padding: 5px 10px!important;">Event</th>
													<th style="padding: 5px 10px!important;">Name</th>
													<th style="padding: 5px 10px!important;">Payment Mode</th>
													<th style="padding: 5px 10px!important;text-align:right;">Amount (S$)
													</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$hb_i = 1;
												foreach ($hallbooking_details as $hallbooking_detail) {
													$hallbooking_total = $hallbooking_total + $hallbooking_detail['paidamount'];
													if(empty($summary_total['sales'][$hallbooking_detail['paymentmode']])) $summary_total['sales'][$hallbooking_detail['paymentmode']] = 0;
													$summary_total['sales'][$hallbooking_detail['paymentmode']] += $hallbooking_detail['paidamount'];
													?>
													<tr>
														<td style="padding: 5px 10px!important;">
															<?php echo $hb_i; ?>
														</td>
														<td style="padding: 5px 10px!important;">
															<?php
															echo $hallbooking_detail['event_name'];
															?>
														</td>
														<td style="padding: 5px 10px!important;">
															<?php
															echo $hallbooking_detail['person_name'];
															?>
														</td>
														<td style="padding: 5px 10px!important;">
															<?php
															if ($hallbooking_detail['paymentmode'] == "ipay_merch_qr") {
																$paymentname = "QR PAYMENT";
															} elseif ($hallbooking_detail['paymentmode'] == "ipay_merch_online") {
																$paymentname = "ONLINE PAYMENT";
															} elseif ($hallbooking_detail['paymentmode'] == "cash") {
																$paymentname = "CASH";
															} else
																$paymentname = strtoupper(str_replace('_', ' ', $hallbooking_detail['paymentmode']));

															echo $paymentname;
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
											<tfoot>
												<tr>
													<td colspan="4">&nbsp;</td>
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
													<th style="padding: 5px 10px!important;">#</th>
													<th style="padding: 5px 10px!important;">Type</th>
													<th style="padding: 5px 10px!important;">Name</th>
													<th style="padding: 5px 10px!important;">Payment Mode</th>
													<th style="padding: 5px 10px!important;text-align:right;">Amount (S$)
													</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$u_i = 1;
												foreach ($ubayam_details as $ubayam_detail) {
													$ubayam_total = $ubayam_total + $ubayam_detail['paidamount'];
													if(empty($summary_total['sales'][$ubayam_detail['paymentmode']])) $summary_total['sales'][$ubayam_detail['paymentmode']] = 0;
													$summary_total['sales'][$ubayam_detail['paymentmode']] += $ubayam_detail['paidamount'];
													?>
													<tr>
														<td style="padding: 5px 10px!important;">
															<?php echo $u_i; ?>
														</td>
														<td style="padding: 5px 10px!important;">
															<?php
															echo $ubayam_detail['package_name'];
															?>
														</td>
														<td style="padding: 5px 10px!important;">
															<?php
															echo $ubayam_detail['person_name'];
															?>
														</td>
														<td>
															<?php
															if ($ubayam_detail['paymentmode'] == "ipay_merch_qr") {
																$paymentname = "QR PAYMENT";
															} elseif ($ubayam_detail['paymentmode'] == "ipay_merch_online") {
																$paymentname = "ONLINE PAYMENT";
															} elseif ($ubayam_detail['paymentmode'] == "cash") {
																$paymentname = "CASH";
															} else
																$paymentname = strtoupper(str_replace('_', ' ', $ubayam_detail['paymentmode']));

															echo $paymentname;
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
											<tfoot>
												<tr>
													<td colspan="4">&nbsp;</td>
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
													<th style="padding: 5px 10px!important;">#</th>
													<th style="padding: 5px 10px!important;">Name</th>
													<th style="padding: 5px 10px!important;">Payment Mode</th>
													<th style="padding: 5px 10px!important;text-align:right;">Amount (S$)
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
													if(empty($sale_summary['donation'][$donation_detail['package_name']]['name_eng'])) $sale_summary['donation'][$donation_detail['package_name']]['name_eng'] = $donation_detail['package_name'];
													if(empty($sale_summary['donation'][$donation_detail['package_name']]['name_tamil'])) $sale_summary['donation'][$donation_detail['package_name']]['name_in_tamil'] = '';
													$sale_summary['donation'][$donation_detail['package_name']]['qty'] += 1;
													if(empty($sale_summary['donation'][$donation_detail['package_name']]['total'])) $sale_summary['donation'][$donation_detail['package_name']]['total'] = 0;
													$sale_summary['donation'][$donation_detail['package_name']]['total'] += $donation_detail['paidamount'];
													if(empty($sale_summary['donation'][$donation_detail['package_name']]['ledger_code'])) $sale_summary['donation'][$donation_detail['package_name']]['ledger_code'] = $donation_detail['ledger_code'];
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
															if ($donation_detail['paymentmode'] == "ipay_merch_qr") {
																$paymentname = "QR PAYMENT";
															} elseif ($donation_detail['paymentmode'] == "ipay_merch_online") {
																$paymentname = "ONLINE PAYMENT";
															} elseif ($donation_detail['paymentmode'] == "cash") {
																$paymentname = "CASH";
															} else
																$paymentname = strtoupper(str_replace('_', ' ', $donation_detail['paymentmode']));

															echo $paymentname;
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
													<th style="padding: 5px 10px!important;">#</th>
													<th style="padding: 5px 10px!important;">Name</th>
													<th style="padding: 5px 10px!important;">Payment Mode</th>
													<th style="padding: 5px 10px!important;text-align:right;">Amount (S$)
													</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$ps_i = 1;
												foreach ($prasadam_details as $prasadam_detail) {
													$prasadam_total = $prasadam_total + $prasadam_detail['paidamount'];
													if(empty($summary_total['sales'][$prasadam_detail['paymentmode']])) $summary_total['sales'][$prasadam_detail['paymentmode']] = 0;
													$summary_total['sales'][$prasadam_detail['paymentmode']] += $prasadam_detail['paidamount'];
													if(empty($sale_summary['prasadam'][$prasadam_detail['package_name']]['name_eng'])) $sale_summary['prasadam'][$prasadam_detail['package_name']]['name_eng'] = $prasadam_detail['package_name'];
													if(empty($sale_summary['prasadam'][$prasadam_detail['package_name']]['name_tamil'])) $sale_summary['prasadam'][$prasadam_detail['package_name']]['name_in_tamil'] = '';
													$sale_summary['prasadam'][$prasadam_detail['package_name']]['qty'] += 1;
													if(empty($sale_summary['prasadam'][$prasadam_detail['package_name']]['total'])) $sale_summary['prasadam'][$prasadam_detail['package_name']]['total'] = 0;
													$sale_summary['prasadam'][$prasadam_detail['package_name']]['total'] += $prasadam_detail['paidamount'];
													if(empty($sale_summary['prasadam'][$prasadam_detail['package_name']]['ledger_code'])) $sale_summary['prasadam'][$prasadam_detail['package_name']]['ledger_code'] = $prasadam_detail['ledger_code'];
													?>
													<tr>
														<td style="padding: 5px 10px!important;">
															<?php echo $ps_i; ?>
														</td>
														<td style="padding: 5px 10px!important;">
															<?php
															echo $prasadam_detail['person_name'];
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
																$paymentname = strtoupper(str_replace('_', ' ', $prasadam_detail['paymentmode']));

															echo $paymentname;
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
													<td colspan="3">&nbsp;</td>
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
														<th style="padding: 5px 10px!important;">#</th>
														<th style="padding: 5px 10px!important;">Time</th>
														<th style="padding: 5px 10px!important;">Payment Mode</th>
														<th style="padding: 5px 10px!important;">Paid Through</th>
														<th style="padding: 5px 10px!important;text-align:right;">Amount (S$)</th>
													</tr>
												</thead>
												<tbody>
													<?php
													foreach ($annathanam_details as $annathanam_detail) {
														$annathanam_total = $annathanam_total + $annathanam_detail['total_amount'];
														if (empty($summary_total['sales'][$annathanam_detail['paymentmode']]))
															$summary_total['sales'][$annathanam_detail['paymentmode']] = 0;
														$summary_total['sales'][$annathanam_detail['paymentmode']] += $annathanam_detail['paidamount'];
														?>
														<tr>
															<td style="padding: 5px 10px!important;"><?php echo $ps_i; ?></td>
															<td style="padding: 5px 10px!important;">
																<?php
																echo $annathanam_detail['slot_time'];
																?>
															</td>
															<td style="padding: 5px 10px!important;">
																<?php
																if ($annathanam_detail['paymentmode'] == "ipay_merch_qr") {
																	$paymentname = "QR PAYMENT";
																} elseif ($annathanam_detail['paymentmode'] == "ipay_merch_online") {
																	$paymentname = "ONLINE PAYMENT";
																} elseif ($annathanam_detail['paymentmode'] == "cash") {
																	$paymentname = "CASH";
																} else
																	$paymentname = strtoupper(str_replace('_', ' ', $annathanam_detail['paymentmode']));

																echo $paymentname;
																?>
															</td>
															<td style="padding: 5px 10px!important;">
																<?php
																echo $annathanam_detail['paid_through'];
																?>
															</td>
															<td style="padding: 5px 10px!important;text-align:right;">
																<?php
																echo number_format($annathanam_detail['total_amount'], 2);
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
															<?php echo number_format($annathanam_total, 2); ?></td>
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
													<h5 style="text-align: center">( <?php echo $katt_inv_no['first_ref_no']; ?> - <?php echo $katt_inv_no['last_ref_no']; ?> )</h5>
												<?php } else { ?>
													<h5 style="text-align: center">( <?php echo $katt_inv_no['first_ref_no']; ?> )</h5>
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
																if ($Kattalai_archanai_detail['paymentmode'] == "ipay_merch_qr") {
																	$paymentname = "QR PAYMENT";
																} elseif ($Kattalai_archanai_detail['paymentmode'] == "ipay_merch_online") {
																	$paymentname = "ONLINE PAYMENT";
																} elseif ($Kattalai_archanai_detail['paymentmode'] == "cash") {
																	$paymentname = "CASH";
																} elseif ($Kattalai_archanai_detail['paymentmode'] == "nets_pay") {
																	$paymentname = 'NETS';
																} else
																	$paymentname = strtoupper(str_replace('_', ' ', $Kattalai_archanai_detail['paymentmode']));

																echo $paymentname;
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
													<h5 style="text-align: center">( <?php echo $outdoor_inv_no['first_ref_no']; ?> - <?php echo $outdoor_inv_no['last_ref_no']; ?> )</h5>
												<?php } else { ?>
													<h5 style="text-align: center">( <?php echo $outdoor_inv_no['first_ref_no']; ?> )</h5>
												<?php } 
											}?>
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
														<th style="padding: 5px 10px!important;text-align:right;">Total Amount (S$) 
														<th style="padding: 5px 10px!important;text-align:right;">Paid Amount (S$) </th>
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
																if ($outdoor_services_detail['paymentmode'] == "ipay_merch_qr") {
																	$paymentname = "QR PAYMENT";
																} elseif ($outdoor_services_detail['paymentmode'] == "ipay_merch_online") {
																	$paymentname = "ONLINE PAYMENT";
																} elseif ($outdoor_services_detail['paymentmode'] == "cash" || $outdoor_services_detail['paymentmode'] == "Cash") {
																	$paymentname = "CASH";
																} elseif ($outdoor_services_detail['paymentmode'] == "nets_pay") {
																	$paymentname = 'NETS';
																} elseif ($outdoor_services_detail['paymentmode'] == "pay_now" || $outdoor_services_detail['paymentmode'] == "Pay Now") {
																	$paymentname = 'PAY NOW';
																}else
																	$paymentname = strtoupper(str_replace('_', ' ', $outdoor_services_detail['paymentmode']));

																echo $paymentname;
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
									$repayment_total = 0;
									// echo '<pre>';
									// print_r($repayment_details);
									// echo '</pre>';

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
														<th style="padding: 5px 10px!important;text-align:right;">Amount (S$) 
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
														<td colspan="5">&nbsp;</td>
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
										
										<?php ob_end_clean(); ?>
										
										<?php
										// Aggregate member registration payments into summary_total
										if (!empty($member_details)) {
											foreach ($member_details as $member_detail) {
												// payment = base membership fee only; use total_amount (fee included) for actual cash collected.
												$member_payment = floatval($member_detail['total_amount'] ?? $member_detail['payment']);
												$member_paymentmode = $member_detail['paymentmode'];

												if (empty($summary_total['sales'][$member_paymentmode])) {
													$summary_total['sales'][$member_paymentmode] = 0;
												}
												$summary_total['sales'][$member_paymentmode] += $member_payment;
											}
										}
										?>
										
										<?php
										// echo '<pre>';
										// print_r($coin_denominations);
										// echo '</pre>';
										if (!empty($coin_denominations)) {
											 $sno = 1;
											 $ch_counter = 0;
											 $ch_camphor = 0;
											 $totalAmount = 0;
											 $totalQuantity = 0;
											 $totalc_Quantity = 0;
											 $total_final_qty = 0;
											 $denominationtotal = 0;
											?>
	
											<div class="table-responsive col-md-12" style="background:#FFF; float:none;margin-bottom:0px;">
												<table class="table table-bordered table-striped table-hover">
													<thead style="background: #3F51B5;color: #fff;">
										
														<tr>
															<th style="padding: 5px 10px!important;">S.No</th>
															<th style="padding: 5px 10px!important;">Name</th>
															
															<th style="padding: 5px 10px!important;text-align:center;">Counter</th> 
															<th style="padding: 5px 10px!important;text-align:center;">Camphor Tray</th> 
															<th style="padding: 5px 10px!important;text-align:center;">Total Qty</th> 
															<th style="padding: 5px 10px!important;text-align:right;">Amount (S$)</th>
														</tr>
													</thead>
													<tbody>
														<?php
														foreach ($coin_denominations as $denomination) {
															$totalAmount = $denomination->c_amount + $denomination->amount;
															$totalQuantity += $denomination->quantity;
															$totalc_Quantity += $denomination->c_quantity;
															$final_quantity = $denomination->quantity + $denomination->c_quantity;
															$totalquan=$totalQuantity+$totalc_Quantity;
															$denominationtotal += $totalAmount; 

															$ch_counter += $denomination->quantity * $denomination->value;
    														$ch_camphor += $denomination->c_quantity * $denomination->value;

															?>
															<tr>
																<td style="padding: 5px 10px!important; text-align:center;"><?php echo $sno++; ?></td>
																<td style="padding: 5px 10px!important;"><?php echo $denomination->name; ?></td>
															
																<td style="padding: 5px 10px!important;text-align:center;">
																	<?php echo $denomination->quantity; ?></td>
																<td style="padding: 5px 10px!important;text-align:center;">
																	<?php echo $denomination->c_quantity; ?>
																</td>
																<td style="padding: 5px 10px!important;text-align:center;">
																	<?php echo $final_quantity; ?>
																</td>
																<td style="padding: 5px 10px!important; text-align:right;"><?php  echo "$" . number_format($totalAmount, 2); ?></td>
															</tr>
															<?php
														}
														?>
														<tr>
															<td style="padding: 5px 10px!important; text-align:center;">12</td>
															<td style="padding: 5px 10px!important;"><strong>Cash In Hand</strong></td>
															<td style="padding: 5px 10px!important; text-align:center;">$ <?php echo number_format($ch_counter, 2); ?></td>
															<td style="padding: 5px 10px!important; text-align:center;">$ <?php echo number_format($ch_camphor, 2); ?></td>
															<td style="padding: 5px 10px!important; text-align:center;"><?php echo $totalquan; ?></td>
															<td style="padding: 5px 10px!important; text-align:right;">$ <strong><?php echo number_format($denominationtotal, 2); ?></strong></td>
														</tr>
														<tr><td colspan="6">&nbsp;</td></tr>
														<?php
															$sno = 12;
															$cash_total = 0;
															$summary_totals = [];
															$summarytotal = 0;

															foreach ($summary_total['sales'] as $vl => $st) {
																if ($vl == 'cash') {
																	$paymentname = 'CASH';
																	$cash_total += $st;
																} elseif ($vl == "ipay_merch_qr") $paymentname = "QR PAYMENT";
																elseif ($vl == "ipay_merch_online") $paymentname = "ONLINE PAYMENT";
																elseif ($vl == "nets_pay") $paymentname = 'NETS';
																else $paymentname = strtoupper(str_replace('_', ' ', $vl));

																if (isset($summary_totals[$paymentname])) {
																	$summary_totals[$paymentname] += $st;
																} else {
																	$summary_totals[$paymentname] = $st;
																}
															}
															if (count($summary_totals)) {
																foreach ($summary_totals as $paymentname => $total) { 
																if ($paymentname == 'CASH') {
																	continue;
																}
																$summarytotal += $total;
																$sno++;
																?>
																	<tr>
																	<td style="padding: 5px 10px!important; text-align:center;"><?php echo $sno; ?></td>
																	<td style="padding: 5px 10px!important; text-align:left;" colspan="4"><strong><?php echo $paymentname; ?></strong></td>
																	<td style="padding: 5px 10px!important; text-align:right;"><strong>$ <?php echo number_format($total, 2); ?></strong></td>
																</tr>
																<?php
																}
															}
														?>
														<tr><td colspan="6">&nbsp;</td></tr>
													</tbody>
													<?php 
    /*$today_cash = $denominationtotal - $floating_cash['amount'];

    // Expected cash = CASH sales only
    $expected_cash = $cash_total;

    $difference = $today_cash - $expected_cash;

    $shortage = 0;
    $excess = 0;

    if ($difference < 0) {
        $shortage = abs($difference);
    } else {
        $excess = $difference;
    }*/
?>
													<tfoot>
													    
													    <!--<tr>
        <td style="padding: 5px 10px!important; text-align:center;"><?php //echo $sno+1; ?></td>
        <td colspan="4" style="text-align:left; padding: 5px 10px!important;">
            <strong>Sub Total:</strong>
        </td>
        <td style="padding: 5px 10px!important; text-align:right;">
            <strong>$ <?php //echo number_format($denominationtotal + $summarytotal, 2); ?></strong>
        </td>
    </tr>-->

    <?php if(!empty($denominationtotal) && !empty($floating_cash['amount'])){ ?>

    <!--<tr>
        <td style="padding: 5px 10px!important; text-align:center;">
            <?php //echo $sno + 2; ?>
        </td>
        <td colspan="4" style="text-align:left; padding: 5px 10px!important;">
            <strong>Less Float Cash:</strong>
        </td>
        <td style="padding: 5px 10px!important; text-align:right;">
            <strong>$ <?php //echo number_format($floating_cash['amount'], 2); ?></strong>
        </td>
    </tr>

    <tr>
        <td style="padding: 5px 10px!important; text-align:center;">
            <?php //echo $sno + 3; ?>
        </td>
        <td colspan="4" style="text-align:left; padding: 5px 10px!important;">
            <strong>Total Amount:</strong>
        </td>
        <td style="padding: 5px 10px!important; text-align:right;">
            <strong>$ <?php //echo number_format($denominationtotal + $summarytotal - $floating_cash['amount'], 2); ?></strong>
        </td>
    </tr>-->

    <tr>
        <td style="padding: 5px 10px!important; text-align:center;">
            <?php //echo $sno + 1; ?>
        </td>
        <td colspan="4" style="text-align:left; padding: 5px 10px!important;">
            <strong>Today Cash</strong>
        </td>
        <td style="padding: 5px 10px!important; text-align:right;">
            <strong><!--$ <?php //echo number_format($today_cash, 2); ?>--></strong>
        </td>
    </tr>

    <tr>
        <td style="padding: 5px 10px!important; text-align:center;">
            <?php echo $sno + 1; ?>
        </td>
        <td colspan="4" style="text-align:left; padding: 5px 10px!important;">
            <strong>Shortage:</strong>
        </td>
        <td style="padding: 5px 10px!important; text-align:right;">
            <strong><!--$ <?php //echo number_format($shortage, 2); ?>--></strong>
        </td>
    </tr>

    <tr>
        <td style="padding: 5px 10px!important; text-align:center;">
            <?php echo $sno + 2; ?>
        </td>
        <td colspan="4" style="text-align:left; padding: 5px 10px!important;">
            <strong>Excess:</strong>
        </td>
        <td style="padding: 5px 10px!important; text-align:right;">
            <strong><!--$ <?php //echo number_format($excess, 2); ?>--></strong>
        </td>
    </tr>

    <?php } ?>


														<tr>
															<td style="padding: 5px 10px!important; text-align:center;"><?php echo $sno+3; ?></td>
															<td colspan="4" style="text-align:left; padding: 5px 10px!important;"><strong>Sub Total:</strong></td>
															<td style="padding: 5px 10px!important; text-align:right;"><strong>$ <?php echo number_format($denominationtotal + $summarytotal, 2); ?></strong></td>
														</tr>
														<?php if(!empty($denominationtotal) && !empty($floating_cash['amount'])){ ?>
														<tr>
															<td style="padding: 5px 10px!important; text-align:center;"><?php echo $sno + 4; ?>
															<td colspan="4" style="text-align:left; padding: 5px 10px!important;"><strong>Less Float Cash:</strong></td>
															<td style="padding: 5px 10px!important; text-align:right;"><strong>$ <?php echo number_format($floating_cash['amount'], 2); ?></strong></td>
														</tr>
														<tr >
															<td style="padding: 5px 10px!important; text-align:center;"><?php echo $sno + 5; ?>
															<td colspan="4" style="text-align:left; padding: 5px 10px!important;"><strong>Total Amount:</strong></td>
															<td style="padding: 5px 10px!important; text-align:right;"><strong>$ <?php echo number_format($denominationtotal + $summarytotal - $floating_cash['amount'], 2); ?></strong></td>
															</td>
														</tr>
														<?php } ?>
													</tfoot>
												</table>
											</div>
										<?php } ?>
													
							
										<!-- <div class="col-md-5"></div>
										<div class="col-md-3 det" style="float:none;margin-bottom:0px;">
											<h3 style="text-align:center;font-weight: bold;">
												Payment Summary
											</h3>
											<?php
											// $cash_total = 0;
											// $summary_totals = [];

											// foreach ($summary_total['sales'] as $vl => $st) {
											// 	if ($vl == 'cash') {
											// 		$paymentname = 'CASH';
											// 		$cash_total += $st;
											// 	} elseif ($vl == "ipay_merch_qr") {
											// 		$paymentname = "QR PAYMENT";
											// 	} elseif ($vl == "ipay_merch_online") {
											// 		$paymentname = "ONLINE PAYMENT";
											// 	} elseif ($vl == "nets_pay") {
											// 		$paymentname = 'NETS';
											// 	} else {
											// 		$paymentname = strtoupper(str_replace('_', ' ', $vl));
											// 	}

											// 	if (isset($summary_totals[$paymentname])) {
											// 		$summary_totals[$paymentname] += $st;
											// 	} else {
											// 		$summary_totals[$paymentname] = $st;
											// 	}
											// }

											// if (count($summary_totals)) {
											// 	echo '<h4 class>Incomes</h4>';
											// 	foreach ($summary_totals as $paymentname => $total) {
											// 		echo '<p>' . $paymentname . ' Sales: ' . number_format($total, 2) . '</p>';
											// 	}
											// }
											?>
										</div> -->
											<!-- <div class="col-md-12 det"
												style="background:#FFF; float:none;margin-bottom:0px;">
												<h3 style="text-align:center;font-weight: bold;">
													Total Income :
													<?php
													$total = $archanai_total + $hallbooking_total + $ubayam_total + $donation_total + $prasadam_total ;
													echo number_format($total, 2);
													?>
												</h3>
											</div> -->
											<?php /* <div class="col-md-12">
																	<?php echo '<h3 style="text-align:center;font-weight: bold;">Total Cash Balance: ' . number_format($cash_total, 2) . '</h3>'; ?>
																</div>    */ ?>
										<?php /* </div>    */ ?>
									</div>
								<br><br><div>
									<h3>Checked by : <?php echo $floating_cash['checked_by'] ?></h3>
									<h4>SIGN: </h4>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
		window.print();
	</script>

</body>
</html>
