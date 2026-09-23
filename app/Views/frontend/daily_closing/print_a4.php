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
  @media print {
            .page-break { display: block; page-break-before: always; }
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
									<table border="0">
										<tbody>
											<tr>
												<td width="15%" align="left"><img src="<?php echo base_url(); ?>/uploads/main/<?php echo $temp_details['image']; ?>" style="width:120px;" align="left"></td>
												<td width="84%" align="left" style="padding: 0px 5px;"><h2 style="text-align:left;margin-bottom: 0;font-size: 18px;"><?php echo $temp_details['name']; ?></h2>
												<p style="text-align:left; font-size:16px; margin:5px 0px;"><?php echo $temp_details['address1']; ?> <?php echo $temp_details['address2']; ?><br>
												<?php echo $temp_details['city'].'-'.$temp_details['postcode']; ?><br>
												Tel : <?= $temp_details['telephone']; ?></p>
												</td>
											</tr>
										</tbody>
									</table>
									<hr>
								</div>
								<div class="body">
									<div class="col-md-12">
										<h3 style="text-transform: uppercase;text-align:center;">
											<?php
											if($dailyclosing_start_date == $dailyclosing_end_date){
												echo "Date - [".date('d-m-Y', strtotime($dailyclosing_start_date))."]";
											}
											else{
												echo "Date - [".date('d-m-Y', strtotime($dailyclosing_start_date))." - ".date('d-m-Y', strtotime($dailyclosing_end_date))."]";
											}
											?>
										</h3>
									</div>
									<div class="col-md-12">
									<h3 style="text-align: center">Archanai Selling Details</h3>
										<?php if (!empty($arch_inv_no['first_ref_no']) && !empty($arch_inv_no['last_ref_no'])) { ?>
											<?php if ($arch_inv_no['first_ref_no'] != $arch_inv_no['last_ref_no']) { ?>
												<h5 style="text-align: center">( <?php echo $arch_inv_no['first_ref_no']; ?> - <?php echo $arch_inv_no['last_ref_no']; ?> )</h5>
											<?php } else { ?>
												<h5 style="text-align: center">( <?php echo $arch_inv_no['first_ref_no']; ?>)</h5>
											<?php }
										} ?>
									</div>
									<div class="table-responsive col-md-12 det"
										style="background:#FFF; float:none;margin-bottom:0px;">
										<table class="table table-bordered table-striped table-hover">
											<thead style="background: #3F51B5;color: #fff;">
												<tr>
													<th style="padding: 5px 10px!important;">S.NO</th>
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
												$sale_summary['Archanai'] = array();
												$sale_summary['Archanai']['total_amount'] = 0;
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
																if (empty($sale_summary['Archanai'][$archanai_detail['archanai_id']]['name_eng']))
																	$sale_summary['Archanai'][$archanai_detail['archanai_id']]['name_eng'] = $archanai_detail['name_in_english'];
																if (empty($sale_summary['Archanai'][$archanai_detail['archanai_id']]['name_tamil']))
																	$sale_summary['Archanai'][$archanai_detail['archanai_id']]['name_in_tamil'] = $archanai_detail['name_in_tamil'];
																if (empty($sale_summary['Archanai'][$archanai_detail['archanai_id']]['ledger_code']))
																	$sale_summary['Archanai'][$archanai_detail['archanai_id']]['ledger_code'] = $archanai_detail['ledger_code'];
																if (empty($sale_summary['Archanai'][$archanai_detail['archanai_id']]['ledger_name']))
																	$sale_summary['Archanai'][$archanai_detail['archanai_id']]['ledger_name'] = $archanai_detail['ledger_name'];
																if (empty($sale_summary['Archanai'][$archanai_detail['archanai_id']]['qty']))
																	$sale_summary['Archanai'][$archanai_detail['archanai_id']]['qty'] = 0;
																$sale_summary['Archanai'][$archanai_detail['archanai_id']]['qty'] += $archanai_detail['qty'];
																if (empty($sale_summary['Archanai'][$archanai_detail['archanai_id']]['amount']))
																	$sale_summary['Archanai'][$archanai_detail['archanai_id']]['amount'] = 0;
																$sale_summary['Archanai'][$archanai_detail['archanai_id']]['amount'] = $archanai_detail['unit_price'];
																if (empty($sale_summary['Archanai'][$archanai_detail['archanai_id']]['total']))
																	$sale_summary['Archanai'][$archanai_detail['archanai_id']]['total'] = 0;
																$sale_summary['Archanai'][$archanai_detail['archanai_id']]['total'] += $archanai_detail['amount'];

																if(empty($summary_total['sales'][$archanai_detail['paymentmode']])) $summary_total['sales'][$archanai_detail['paymentmode']] = 0;
																$summary_total['sales'][$archanai_detail['paymentmode']] += $archanai_detail['amount'];

																$sale_summary['Archanai']['total_amount'] += $archanai_detail['amount'];
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
																		echo $archanai_detail['paymentmode'];
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
									$donation_total = 0;
									$sale_summary['Donation'] = array();
									$sale_summary['Donation']['total_amount'] = 0;
									if (count($donation_details) > 0) {
									?>
									<div class="col-md-12">
										<h3 style="text-align: center">Cash Donation Details</h3>
											<?php if (!empty($don_inv_no['first_ref_no']) && !empty($don_inv_no['last_ref_no'])) { ?>
												<?php if ($don_inv_no['first_ref_no'] != $don_inv_no['last_ref_no']) { ?>
													<h5 style="text-align: center">( <?php echo $don_inv_no['first_ref_no']; ?> - <?php echo $don_inv_no['last_ref_no']; ?> )</h5>
												<?php } else { ?>
													<h5 style="text-align: center">( <?php echo $don_inv_no['first_ref_no']; ?> )</h5>
												<?php } ?>
											<?php } ?>
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
													if(empty($summary_total['sales'][$donation_detail['paymentmode']])) $summary_total['sales'][$donation_detail['paymentmode']] = 0;
													$summary_total['sales'][$donation_detail['paymentmode']] += $donation_detail['paidamount'];
													if (empty($sale_summary['Donation'][$donation_detail['package_name']]['name_eng']))
														$sale_summary['Donation'][$donation_detail['package_name']]['name_eng'] = $donation_detail['package_name'];
													if (empty($sale_summary['Donation'][$donation_detail['package_name']]['name_tamil']))
														$sale_summary['Donation'][$donation_detail['package_name']]['name_in_tamil'] = '';
													$sale_summary['Donation'][$donation_detail['package_name']]['qty'] += 1;
													if (empty($sale_summary['Donation'][$donation_detail['package_name']]['total']))
														$sale_summary['Donation'][$donation_detail['package_name']]['total'] = 0;
													$sale_summary['Donation'][$donation_detail['package_name']]['total'] += $donation_detail['paidamount'];
													if (empty($sale_summary['Donation'][$donation_detail['package_name']]['ledger_code']))
														$sale_summary['Donation'][$donation_detail['package_name']]['ledger_code'] = $donation_detail['ledger_code'];

													$sale_summary['Donation']['total_amount'] += $donation_detail['paidamount'];
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
									$sale_summary['Prasadam'] = array();
									$sale_summary['Prasadam']['total_amount'] = 0;
									$sale_summary['Prasadam']['paid_amount'] = 0;
									if (count($prasadam_details) > 0) {
									?>
									<div class="col-md-12">
										<h3 style="text-align: center">Prasadam Details</h3>
											<?php if (!empty($pras_inv_no['first_ref_no']) && !empty($pras_inv_no['last_ref_no'])) { ?>
												<?php if ($pras_inv_no['first_ref_no'] != $pras_inv_no['last_ref_no']) { ?>
													<h5 style="text-align: center">( <?php echo $pras_inv_no['first_ref_no']; ?> - <?php echo $pras_inv_no['last_ref_no']; ?> )</h5>
												<?php } else { ?>
													<h5 style="text-align: center">( <?php echo $pras_inv_no['first_ref_no']; ?> )</h5>
												<?php } 
											}?>
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
														$prasadam_total += $prasadam_detail['paidamount'];
														
														foreach ($prasadam_detail['products'] as $product) {
															$productName = $product['package_name'];
															
															if (!isset($sale_summary['Prasadam'][$productName])) {
																$sale_summary['Prasadam'][$productName] = [
																	'name_eng' => $productName,
																	'ledger_code' => $product['ledger_code'],
																	'qty' => 0,
																	'total' => 0
																];
															}
													
															$sale_summary['Prasadam'][$productName]['qty'] += $product['quantity'];  // Use actual quantity from the products array
															$sale_summary['Prasadam'][$productName]['total'] += $product['amount'];
														}
														$sale_summary['Prasadam']['total_amount'] += $prasadam_detail['amount'];
														$sale_summary['Prasadam']['paid_amount'] += $prasadam_detail['paidamount'];

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
											<h3 style="text-align: center">Annathanam Details</h3>
												<?php if (!empty($anna_inv_no['first_ref_no']) && !empty($anna_inv_no['last_ref_no'])) { ?>
													<?php if ($anna_inv_no['first_ref_no'] != $anna_inv_no['last_ref_no']) { ?>
														<h5 style="text-align: center">( <?php echo $anna_inv_no['first_ref_no']; ?> - <?php echo $anna_inv_no['last_ref_no']; ?> )</h5>
													<?php } else { ?>
														<h5 style="text-align: center">( <?php echo $anna_inv_no['first_ref_no']; ?> )</h5>
													<?php } 
												}?>
										</div>
										<div class="table-responsive col-md-12 det"
											style="background:#FFF; float:none;margin-bottom:0px;">
											<table class="table table-bordered table-striped table-hover">
												<thead style="background: #3F51B5;color: #fff;">
													<tr>
														<th style="padding: 5px 10px!important;">#</th>
														<th style="padding: 5px 10px!important;">Name</th>
														<th style="padding: 5px 10px!important;">Time</th>
														<th style="padding: 5px 10px!important;">Payment Mode</th>
														
														<th style="padding: 5px 10px!important;text-align:right;">Amount (S$)</th>
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
																<?php echo $annathanam_detail['customer_name']; ?>
															</td>
															<td style="padding: 5px 10px!important;">
																<?php
																echo $annathanam_detail['time'];
																?>
															</td>
															<td style="padding: 5px 10px!important;">
																<?php
																echo $annathanam_detail['paymentmode'];
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
									$hallbooking_total = 0;
									if (count($hallbooking_details) > 0) {
									?>
									<div class="col-md-12">
										<h3 style="text-align: center">Hall Booking Details</h3>
										<?php if (!empty($hall_inv_no['first_ref_no']) && !empty($hall_inv_no['last_ref_no'])) { ?>
												<?php if ($hall_inv_no['first_ref_no'] != $hall_inv_no['last_ref_no']) { ?>
													<h5 style="text-align: center">( <?php echo $hall_inv_no['first_ref_no']; ?> - <?php echo $hall_inv_no['last_ref_no']; ?> )</h5>
												<?php } else { ?>
													<h5 style="text-align: center">( <?php echo $hall_inv_no['first_ref_no']; ?>)</h5>
												<?php }
											} ?>
									</div>
									<div class="table-responsive col-md-12 det"
										style="background:#FFF; float:none;margin-bottom:0px;">
										<table class="table table-bordered table-striped table-hover">
											<thead style="background: #3F51B5;color: #fff;">
												<tr>
													<th style="padding: 5px 10px!important;">#</th>
													<th style="padding: 5px 10px!important;">Event Date</th>
													<th style="padding: 5px 10px!important;">Name</th>
													<th style="padding: 5px 10px!important;">Payment Mode</th>
													<th style="padding: 5px 10px!important;text-align:right;">Total Amount (S$)</th>
													<th style="padding: 5px 10px!important;text-align:right;">Paid Amount (S$)</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$hb_i = 1;
												foreach ($hallbooking_details as $hallbooking_detail) {
													$hallbooking_total += $hallbooking_detail['paidamount'];
													
													foreach ($hallbooking_detail['products'] as $product) {
														$productName = $product['package_name'];
														
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
													$sale_summary['hallbooking']['total_amount'] += $hallbooking_detail['amount'];
													$sale_summary['hallbooking']['paid_amount'] += $hallbooking_detail['paidamount'];


													if (empty($summary_total['sales'][$hallbooking_detail['paymentmode']]))
														$summary_total['sales'][$hallbooking_detail['paymentmode']] = 0;
													$summary_total['sales'][$hallbooking_detail['paymentmode']] += $hallbooking_detail['paidamount'];
													?>
													<tr>
														<td style="padding: 5px 10px!important;">
															<?php echo $hb_i; ?>
														</td>
														<td style="padding: 5px 10px!important;">
															<?php
															echo date('d-m-Y', strtotime($hallbooking_detail['date']));
															?>
														</td>
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
											<tfoot>
												<tr>
													<td colspan="5">&nbsp;</td>
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
									$sale_summary['Ubayam'] = array();
									$sale_summary['Ubayam']['total_amount'] = 0;
									$sale_summary['Ubayam']['paid_amount'] = 0;
									if (count($ubayam_details) > 0) {
									?>
									<div class="col-md-12">
										<h3 style="text-align: center">Ubayam Details</h3>
											<?php if (!empty($ubayam_inv_no['first_ref_no']) && !empty($ubayam_inv_no['last_ref_no'])) { ?>
												<?php if ($ubayam_inv_no['first_ref_no'] != $ubayam_inv_no['last_ref_no']) { ?>
													<h5 style="text-align: center">( <?php echo $ubayam_inv_no['first_ref_no']; ?> - <?php echo $ubayam_inv_no['last_ref_no']; ?> )</h5>
												<?php } else { ?>
													<h5 style="text-align: center">( <?php echo $ubayam_inv_no['first_ref_no']; ?> )</h5>
												<?php } 
											}?>
									</div>
									<div class="table-responsive col-md-12 det"
										style="background:#FFF; float:none;margin-bottom:0px;">
										<table class="table table-bordered table-striped table-hover">
											<thead style="background: #3F51B5;color: #fff;">
												<tr>
													<th style="padding: 5px 10px!important;">#</th>
													<th style="padding: 5px 10px!important;">Package Name</th>
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

													foreach ($ubayam_detail['products'] as $product) {
														$productName = $product['package_name'];
														
														if (!isset($sale_summary['Ubayam'][$productName])) {
															$sale_summary['Ubayam'][$productName] = [
																'name_eng' => $productName,
																'ledger_code' => $product['ledger_code'],
																'qty' => 0,
																'total' => 0
															];
														}
														$sale_summary['Ubayam'][$productName]['qty'] += $product['quantity'];  // Use actual quantity from the products array
														$sale_summary['Ubayam'][$productName]['total'] += $product['amount'];
													}
													$sale_summary['Ubayam']['total_amount'] += $ubayam_detail['amount'];
													$sale_summary['Ubayam']['paid_amount'] += $ubayam_detail['paidamount'];


													if(empty($summary_total['sales'][$ubayam_detail['paymentmode']])) $summary_total['sales'][$ubayam_detail['paymentmode']] = 0;
													$summary_total['sales'][$ubayam_detail['paymentmode']] += $ubayam_detail['paidamount'];
													?>
													<tr>
														<td style="padding: 5px 10px!important;">
															<?php echo $u_i; ?>
														</td>
														<td style="padding: 5px 10px!important;">
															<?php echo $productName; ?>
														</td>
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
														<th style="width: 10%; padding: 5px 10px!important;">Payment Type</th>
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
													<h5 style="text-align: center">( <?php echo $catering_inv_no['first_ref_no']; ?> - <?php echo $catering_inv_no['last_ref_no']; ?> )</h5>
												<?php } else { ?>
													<h5 style="text-align: center">( <?php echo $catering_inv_no['first_ref_no']; ?> )</h5>
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
														<th style="padding: 5px 10px!important;">Time</th>
														<th style="padding: 5px 10px!important;">Payment Mode</th>
														<th style="padding: 5px 10px!important;">Payment Type</th>
														<th style="padding: 5px 10px!important;">Booking Status</th>
														<th style="padding: 5px 10px!important;text-align:right;">Total Amount (S$) 
														<th style="padding: 5px 10px!important;text-align:right;">Paid Amount (S$) </th>
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
																<?php echo $catering_detail['paymentmode'];?>
															</td>
															<td style="padding: 5px 10px!important;">
																<?php
																echo $catering_detail['payment_type'];
																?>
															</td>
															<td style="padding: 5px 10px!important;">
																<?php
																if ($catering_detail['booking_status'] == 1){
																	$status = 'BOOKED';
																} elseif ($catering_detail['booking_status'] == 2){
																	$status = 'COMPLETED';
																} elseif ($catering_detail['booking_status'] == 3){
																	$status = 'CANCELLED';
																} else {
																	$status = 'PENDING';
																}
																echo $status ;
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
									<h3 style="text-align: center">Product Offering Details</h3>
								</div>
								<div class="table-responsive col-md-12 det" style="background:#FFF; float:none;margin-bottom:0px;">
									<table class="table table-bordered table-striped table-hover">
										<thead style="background: #3F51B5;color: #fff;">
											<tr>
												<th style="padding: 5px 10px!important;">S.No</th>
												<th style="padding: 5px 10px!important;">Name</th>
												<th style="padding: 5px 10px!important;">Category</th>
												<th style="padding: 5px 10px!important;">Product</th>
												<th style="padding: 5px 10px!important;text-align:right;">Grams</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$po_i = 1;
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
														<?php echo $po_i; ?>
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
														<?php echo number_format($details['grams'], 2); ?>
													</td>
												</tr>
												<?php
												$po_i++;
											}
											?>
										</tbody>
										<tfoot>
											<tr>
												<td colspan="4" style="text-align: center;">
													<h6>Total Grams</h6>
												</td>
												<td style="padding: 5px 10px!important;text-align:right;font-weight:bold;">
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
									$sale_summary['Member'] = array();
									$sale_summary['Member']['total_amount'] = 0;
									$sale_summary['Member']['paid_amount'] = 0;
									if (count($member_details) > 0) {
										?>
										<div class="col-md-12">
											<h3 style="text-align: center">Member Registration Details</h3>
										</div>
										<div class="table-responsive col-md-12 det" style="background:#FFF; float:none;margin-bottom:20px;">
											<table class="table table-bordered table-striped table-hover">
												<thead style="background: #3F51B5;color: #fff;">
													<tr>
														<th style="padding: 5px 10px!important;">S.No</th>
														<th style="padding: 5px 10px!important;">Member No</th>
														<th style="padding: 5px 10px!important;">Name</th>
														<th style="padding: 5px 10px!important;">Member Type</th>
														<!-- <th style="padding: 5px 10px!important;">IC No</th> -->
														<th style="padding: 5px 10px!important;">Mobile</th>
														<th colspan="4" style="padding: 5px 10px!important;">Payment Mode</th>
														<th style="padding: 5px 10px!important;text-align:right;">Amount (S$)</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$mem_i = 1;
													foreach ($member_details as $member_detail) {
														$member_total += floatval($member_detail['payment']);
														$memberTypeName = $member_detail['member_type_name'];

														if (!isset($sale_summary['Member'][$memberTypeName])) {
															$sale_summary['Member'][$memberTypeName] = [
																'name_eng' => $memberTypeName,
																'ledger_code' => 0,
																'qty' => 0,
																'total' => 0
															];
														}

														$sale_summary['Member'][$memberTypeName]['qty'] += 1;
														$sale_summary['Member'][$memberTypeName]['total'] += floatval($member_detail['payment']);
														$sale_summary['Member']['total_amount'] += floatval($member_detail['payment']);
														$sale_summary['Member']['paid_amount'] += floatval($member_detail['payment']);

														if (empty($summary_total['sales'][$member_detail['paymentmode']]))
															$summary_total['sales'][$member_detail['paymentmode']] = 0;
														$summary_total['sales'][$member_detail['paymentmode']] += floatval($member_detail['payment']);
														?>
														<tr>
															<td style="padding: 5px 10px!important;"><?php echo $mem_i; ?></td>
															<td style="padding: 5px 10px!important;"><?php echo $member_detail['member_no']; ?></td>
															<td style="padding: 5px 10px!important;"><?php echo $member_detail['name']; ?></td>
															<td style="padding: 5px 10px!important;"><?php echo $member_detail['member_type_name']; ?></td>
															<!-- <td style="padding: 5px 10px!important;"><?php echo $member_detail['ic_no']; ?></td> -->
															<td style="padding: 5px 10px!important;"><?php echo $member_detail['mobile']; ?></td>
															<td colspan="4" style="padding: 5px 10px!important;"><?php echo $member_detail['paymentmode']; ?></td>
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
														<td colspan="7">&nbsp;</td>
														<td colspan="4" style="padding: 5px 10px!important;text-align:right;font-weight:bold;">
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
																echo $details['paymentmode'];
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


									<br>
										
										<?php
										if (!empty($coin_denominations)) {
											 $sno = 1;
											$totalAmount = 0;
											$totalQuantity = 0;
											$totalCounterQuantity = 0;
											 echo '<div class="page-break"></div>'; 
											?>
											<div class="col-md-12">
												<h3>Cash Denominations</h3>
											</div>
										
											<div class="table-responsive col-md-12" style="background:#FFF; float:none;margin-bottom:0px;">
											<table class="table table-bordered table-striped table-hover">
										<thead style="background: #3F51B5;color: #fff;">
											<tr>
												<th style="padding: 5px 10px!important;">S.No</th>
												<th style="padding: 5px 10px!important;">Denomination</th>
												<!-- Quantity -->
												<th style="padding: 5px 10px!important;text-align:right;">Counter</th> 
												<th style="padding: 5px 10px!important;text-align:right;">Camphor Tray</th> 
												
												<th style="padding: 5px 10px!important;">Amount (S$)</th>
											</tr>
										</thead>
										<tbody>
											<?php
											foreach ($coin_denominations as $denomination) {
												
												$totalAmount = $denomination->c_amount + $denomination->amount;
												$totalQuantity += $denomination->quantity;
												$totalc_Quantity += $denomination->c_quantity;
												$totalquan=$totalQuantity+$totalc_Quantity;
												$denominationtotal += $totalAmount; // Sum up the amount
												$totalCounterQuantity += $denomination->quantity;

												?>
												<tr>
													<td style="padding: 5px 10px!important;"><?php echo $sno++; ?></td>
													<td style="padding: 5px 10px!important;"><?php echo $denomination->name; ?></td>
												
													<td style="padding: 5px 10px!important;text-align:right;">
														<?php echo $denomination->quantity; ?></td>
														<td style="padding: 5px 10px!important;text-align:right;">
														<?php echo $denomination->c_quantity; ?>
														</td>
															<td style="padding: 5px 10px!important;"><?php echo   "$" . number_format($totalAmount,2); ?></td>

												</tr>
												<?php
											}
											?>
										</tbody>
										<tfoot>
										<!-- Display the totals -->
											<tr >
												<td  style="text-align:right; padding: 5px 10px!important;"><strong>Sub Total:</strong></td>
												  <td colspan="2" style="padding: 5px 10px!important;text-align:right;"><strong><?php echo  $totalCounterQuantity; ?></strong></td>
											
												<td style="padding: 5px 10px!important;text-align:right;"><strong><?php echo $totalquan; ?></strong>
													<td style="padding: 5px 10px!important;"><strong><?php echo "$" . number_format($denominationtotal, 2); ?></strong></td>
												</td>
											</tr>
											<?php if(!empty($denominationtotal) && !empty($floating_cash['amount'])){ ?>
											<tr >
												<td colspan="4" style="text-align:right; padding: 5px 10px!important;"><strong>Float Cash:</strong></td>
											
												<td style="padding: 5px 10px!important;"><strong><?php echo "$" . number_format($floating_cash['amount'], 2); ?></strong></td>
												</td>
											</tr>
											<tr >
												<td colspan="4" style="text-align:right; padding: 5px 10px!important;"><strong>Total Cash:</strong></td>
											
												<td style="padding: 5px 10px!important;"><strong><?php echo "$" . number_format($denominationtotal - $floating_cash['amount'], 2); ?></strong></td>
												</td>
											</tr>
											<?php } ?>
										</tfoot>
									</table>
											</div>
											<?php
										}
										?>
										<div class="page-break"></div>
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
													echo '<tr><td colspan="4" style="text-align: center"><h4 style="margin-top: 10px;" class="capitalize">' . $key . '</h4></td></tr>';
													foreach ($category as $item) {
														if (is_array($item)) {
															$sale_summary_qty += $item['qty'];
															echo '<tr>';
															echo '<td>' . $item['name_eng'] . '</td>';
															echo '<td>' . $item['ledger_code'] . '</td>';
															echo '<td>' . $item['qty'] . '</td>';
															echo '<td>' . number_format($item['total'], 2) . '</td>';
															echo '</tr>';
														}
													}

													if($category['paid_amount'] != 0){
														echo '<tr><th colspan="3" style="text-align:left;" class="capitalize">' . $key . ' Paid Amount</th><th>' . number_format($category['paid_amount'], 2) . '</th></tr>';
													 		$sale_summary_amount += $category['paid_amount']; 
													}

													// if ($category['total_amount'] != 0.00) {
													// 	if (isset($category['paid_amount'])) {
													// 		echo '<tr><th colspan="3" style="text-align:left;" class="capitalize">' . $key . ' Total</th><th>' . number_format($category['total_amount'], 2) . '</th></tr>';
													// 		echo '<tr><th colspan="3" style="text-align:left;" class="capitalize">' . $key . ' Paid Amount</th><th>' . number_format($category['paid_amount'], 2) . '</th></tr>';
													// 		$sale_summary_amount += $category['paid_amount']; 
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

									<div class="row">
										
										<div class="col-md-9"></div>
										<div class="col-md-3 det" style="float:right;margin-bottom:0px;">
											<h3 style="text-align:center;font-weight: bold;">
												Summary
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
														$paymentname = 'NETS';
													} elseif ($vl_lower == 'pay_now' || $vl_lower == 'paynow') {
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

											$payment_order = ['CASH', 'NETS', 'PAY NOW', 'CHEQUE', 'ONLINE'];
											if (count($summary_totals)) {
												echo '<h4 class>Incomes</h4>';
												foreach ($payment_order as $mode) {
													if (isset($summary_totals[$mode])) {
														echo '<p>' . $mode . ' Sales: ' . number_format($summary_totals[$mode], 2) . '</p>';
													}
												}
											}
											
											?>
										</div>

										<div class="col-md-12 det" style="background:#FFF; float:none;margin-bottom:0px;">
											<h3 style="text-align:center;font-weight: bold;">
												Total Income :
												<?php
												$total = $archanai_total + $prasadam_total + $donation_total + $annathanam_total + $ubayam_total + $hallbooking_total + $Kattalai_archanai_total + $outdoor_services_total + $repayment_total + $catering_total + $member_total;
												echo number_format($total, 2);
												?>
											</h3>
										</div>
										
										<?php /* <div class="col-md-12">
											<?php echo '<h3 style="text-align:center;font-weight: bold;">Total Cash Balance: ' . number_format($cash_total, 2) . '</h3>'; ?>
										</div>    */ ?>
									</div>
								</div>
								<h3>Checked by : <?php echo $floating_cash['checked_by'] ?></h3>
								
								
								

								<h4>SIGN</h4>
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