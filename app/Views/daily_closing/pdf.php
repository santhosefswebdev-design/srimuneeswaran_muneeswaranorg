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
</style>
<?php
	$summary_total = array();
	$summary_total['sales'] = array();
	$summary_total['expense'] = array();
?>
<body class="sidebar-icon-only" style="width: 100%;">
	<div class="container-scroller" style="width: 100%; margin:0 auto;">
		<div class="container-fluid page-body-wrapper" style="width: 100%;">
			<div style="width: 100%;" class="main-panel">
				<div style="width: 100%;" class="content-wrapper">
					<div style="width: 100%;" class="row clearfix">
						<div style="width: 100%;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<!-- <div class="card"> -->
							<div style="width: 100%;" class="">
								<div style="width: 100%;" class="body_head">
									<table style="width: 100%;" border="0">
										<tr><td width="100%" colspan="2" style="text-align:center;"><img src="<?php echo base_url(); ?>/uploads/header/temple_header.jpg"></td></tr>
									</table>
									<hr>
								</div>
								<div style="width: 100%;" class="body">
									<div class="col-md-12">
										<h3 style="text-transform: uppercase;text-align:center;">
											<?php
											echo "Date - [".date('d-m-Y', strtotime($dailyclosing_start_date))."]";
											?> 
										</h3>
									</div>
									<div style="width: 100%;" class="col-md-12"><h3>Archanai Selling Details</h3></div>
									<div style="width: 100%;" class="table-responsive col-md-12 det" style="background:#FFF; float:none;margin-bottom:0px;">
										<table style="width: 100%;" class="table table-bordered table-striped table-hover">
											<thead style="background: #3F51B5;color: #fff;">
												<tr>
													<th style="padding: 5px 10px!important;">#</th>
													<th style="padding: 5px 10px!important;">Archanai</th>
													<th style="padding: 5px 10px!important;">Payment Mode</th>
													<th style="padding: 5px 10px!important;">Quantity</th>
													<th style="padding: 5px 10px!important;text-align:right;">Amount</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$archanai_total = 0;
												$archanai_qty = 0;
												if(count($archanai_diety_details) > 0)
												{
													foreach($archanai_diety_details as $archanai_detail_data)
													{
														if(count($archanai_detail_data['data']) > 0){
															$ar_i = 1;
															$sannathi_total = 0;
															$sannathi_qty = 0;
															echo '<tr><td colspan="5" style="text-align: center;"><h4>' . $archanai_detail_data['title'] . '</h4></td></tr>';
															foreach($archanai_detail_data['data'] as $archanai_detail){
																$archanai_total = $archanai_total + $archanai_detail['amount'];
																$sannathi_total = $sannathi_total + $archanai_detail['amount'];
																$sannathi_qty = $sannathi_qty + $archanai_detail['qty'];
																$archanai_qty = $archanai_qty + $archanai_detail['qty'];
																if(empty($summary_total['sales'][$archanai_detail['paymentmode']])) $summary_total['sales'][$archanai_detail['paymentmode']] = 0;
																$summary_total['sales'][$archanai_detail['paymentmode']] += $archanai_detail['amount'];
																?>
																<tr>
																	<td style="padding: 5px 10px!important;"><?php echo $ar_i; ?></td>
																	<td style="padding: 5px 10px!important;">
																		<?php 
																			echo $archanai_detail['name_in_english'];
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
																				$paymentname = strtoupper($archanai_detail['paymentmode']);
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
													<td colspan="3" style="text-align: center;"><h6>Overall  Total</h6></td>
													<td style="padding: 5px 10px!important;text-align:right;font-weight:bold;"><?php echo $archanai_qty; ?></td>
													<td style="padding: 5px 10px!important;text-align:right;font-weight:bold;"><?php echo number_format($archanai_total, 2); ?></td>
												</tr>
											</tfoot>
										</table>
									</div>
									<div style="width: 100%;" class="col-md-12"><h3>Hall Booking Details</h3></div>
									<div style="width: 100%;" class="table-responsive col-md-12 det" style="background:#FFF; float:none;margin-bottom:0px;">          
										<table style="width: 100%;" class="table table-bordered table-striped table-hover">
											<thead style="background: #3F51B5;color: #fff;">
												<tr>
													<th style="padding: 5px 10px!important;">#</th>
													<th style="padding: 5px 10px!important;">Event</th>
													<th style="padding: 5px 10px!important;">Name</th>
													<th style="padding: 5px 10px!important;">Payment Mode</th>
													<th style="padding: 5px 10px!important;text-align:right;">Amount</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$hb_i = 1;
												$hallbooking_total = 0;
												if(count($hallbooking_details) > 0)
												{
													foreach($hallbooking_details as $hallbooking_detail)
													{
														$hallbooking_total = $hallbooking_total + $hallbooking_detail['paidamount'];
														if(empty($summary_total['sales'][$hallbooking_detail['paymentmode']])) $summary_total['sales'][$hallbooking_detail['paymentmode']] = 0;
														$summary_total['sales'][$hallbooking_detail['paymentmode']] += $hallbooking_detail['paidamount'];
												?>
												<tr>
													<td style="padding: 5px 10px!important;"><?php echo $hb_i; ?></td>
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
														if($hallbooking_detail['paymentmode'] == "ipay_merch_qr"){
															$paymentname = "QR PAYMENT";
														}elseif($hallbooking_detail['paymentmode'] == "ipay_merch_online"){
															$paymentname = "ONLINE PAYMENT";
														}elseif($hallbooking_detail['paymentmode'] == "cash"){
															$paymentname = "CASH";
														}else $paymentname = strtoupper($hallbooking_detail['paymentmode']);
														
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
												}
												?>
											</tbody>
											<tfoot >
												<tr>
													<td colspan="4">&nbsp;</td>
													<td style="padding: 5px 10px!important;text-align:right;font-weight:bold;"><?php echo number_format($hallbooking_total, 2); ?></td>
												</tr>
											</tfoot>
										</table>
									</div>			
									<div style="width: 100%;" class="col-md-12"><h3>Ubayam Details</h3></div>
									<div style="width: 100%;" class="table-responsive col-md-12 det" style="background:#FFF; float:none;margin-bottom:0px;">          
										<table style="width: 100%;" class="table table-bordered table-striped table-hover">
											<thead style="background: #3F51B5;color: #fff;">
												<tr>
													<th style="padding: 5px 10px!important;">#</th>
													<th style="padding: 5px 10px!important;">Type</th>
													<th style="padding: 5px 10px!important;">Name</th>
													<th style="padding: 5px 10px!important;">Payment Mode</th>
													<th style="padding: 5px 10px!important;text-align:right;">Amount</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$u_i = 1;
												$ubayam_total = 0;
												if(count($ubayam_details) > 0)
												{
													foreach($ubayam_details as $ubayam_detail)
													{
														$ubayam_total = $ubayam_total + $ubayam_detail['paidamount'];
														if(empty($summary_total['sales'][$ubayam_detail['paymentmode']])) $summary_total['sales'][$ubayam_detail['paymentmode']] = 0;
														$summary_total['sales'][$ubayam_detail['paymentmode']] += $ubayam_detail['paidamount'];
												?>
												<tr>
													<td style="padding: 5px 10px!important;"><?php echo $u_i; ?></td>
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
														if($ubayam_detail['paymentmode'] == "ipay_merch_qr"){
															$paymentname = "QR PAYMENT";
														}elseif($ubayam_detail['paymentmode'] == "ipay_merch_online"){
															$paymentname = "ONLINE PAYMENT";
														}elseif($ubayam_detail['paymentmode'] == "cash"){
															$paymentname = "CASH";
														}else $paymentname = strtoupper($ubayam_detail['paymentmode']);
														
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
												}
												?>
											</tbody>
											<tfoot >
												<tr>
													<td colspan="4">&nbsp;</td>
													<td style="padding: 5px 10px!important;text-align:right;font-weight:bold;"><?php echo number_format($ubayam_total, 2); ?></td>
												</tr>
											</tfoot>
										</table>
									</div>
									<div style="width: 100%;" class="col-md-12"><h3>Cash Donation Details</h3></div>
									<div style="width: 100%;" class="table-responsive col-md-12 det" style="background:#FFF; float:none;margin-bottom:0px;">          
										<table style="width: 100%;" class="table table-bordered table-striped table-hover">
											<thead style="background: #3F51B5;color: #fff;">
												<tr>
													<th style="padding: 5px 10px!important;">#</th>
													<th style="padding: 5px 10px!important;">Name</th>
													<th style="padding: 5px 10px!important;">Payment Mode</th>
													<th style="padding: 5px 10px!important;text-align:right;">Amount</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$d_i = 1;
												$donation_total = 0;
												if(count($donation_details) > 0)
												{
													foreach($donation_details as $donation_detail)
													{
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
														if($donation_detail['paymentmode'] == "ipay_merch_qr"){
															$paymentname = "QR PAYMENT";
														}elseif($donation_detail['paymentmode'] == "ipay_merch_online"){
															$paymentname = "ONLINE PAYMENT";
														}elseif($donation_detail['paymentmode'] == "cash"){
															$paymentname = "CASH";
														}else $paymentname = strtoupper($donation_detail['paymentmode']);
														
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
												}
												?>
											</tbody>
											<tfoot >
												<tr>
													<td colspan="3">&nbsp;</td>
													<td style="padding: 5px 10px!important;text-align:right;font-weight:bold;"><?php echo number_format($donation_total, 2); ?></td>
												</tr>
											</tfoot>
										</table>
									</div>
									<div style="width: 100%;" class="col-md-12"><h3>Prasadam Details</h3></div>
									<div style="width: 100%;" class="table-responsive col-md-12 det" style="background:#FFF; float:none;margin-bottom:0px;">          
										<table style="width: 100%;" class="table table-bordered table-striped table-hover">
											<thead style="background: #3F51B5;color: #fff;">
												<tr>
													<th style="padding: 5px 10px!important;">#</th>
													<th style="padding: 5px 10px!important;">Name</th>
													<th style="padding: 5px 10px!important;">Payment Mode</th>
													<th style="padding: 5px 10px!important;">Paid Through</th>
													<th style="padding: 5px 10px!important;text-align:right;">Amount</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$ps_i = 1;
												$prasadam_total = 0;
												if(count($prasadam_details) > 0)
												{
													foreach($prasadam_details as $prasadam_detail)
													{
														$prasadam_total = $prasadam_total + $prasadam_detail['paidamount'];
														if(empty($summary_total['sales'][$prasadam_detail['paymentmode']])) $summary_total['sales'][$prasadam_detail['paymentmode']] = 0;
														$summary_total['sales'][$prasadam_detail['paymentmode']] += $prasadam_detail['paidamount'];
												?>
												<tr>
													<td style="padding: 5px 10px!important;"><?php echo $ps_i; ?></td>
													<td style="padding: 5px 10px!important;">
														<?php 
														echo $prasadam_detail['person_name'];
														?>
													</td>
													<td style="padding: 5px 10px!important;">
														<?php 
														if($prasadam_detail['paymentmode'] == "ipay_merch_qr"){
															$paymentname = "QR PAYMENT";
														}elseif($prasadam_detail['paymentmode'] == "ipay_merch_online"){
															$paymentname = "ONLINE PAYMENT";
														}elseif($prasadam_detail['paymentmode'] == "cash"){
															$paymentname = "CASH";
														}else $paymentname = strtoupper($prasadam_detail['paymentmode']);
														
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
												}
												?>
											</tbody>
											<tfoot>
												<tr>
													<td colspan="4">&nbsp;</td>
													<td style="padding: 5px 10px!important;text-align:right;font-weight:bold;"><?php echo number_format($prasadam_total, 2); ?></td>
												</tr>
											</tfoot>
										</table>
									</div>
									<div class="row">
										<div class="col-md-9"></div>
										<div class="col-md-3 det" style="float:right;margin-bottom:0px;">
											<h3 style="text-align:center;font-weight: bold;">
												Summary
											</h3>
											<?php
											$cash_total = 0;
											if(count($summary_total['sales'])){
												echo '<h4 class>Incomes</h4>';
												foreach($summary_total['sales'] as $vl => $st){
													if($vl == 'cash') $cash_total += $st;
													echo '<p>' . strtoupper($vl) . ' Sales: ' . number_format($st, 2) . '</p>';
												}
											}
											
											?>
										</div>
										<div class="col-md-12 det" style="background:#FFF; float:none;margin-bottom:0px;">
											<h3 style="text-align:center;font-weight: bold;">
												Total Income :
												<?php
												$total = $archanai_total + $hallbooking_total + $ubayam_total + $donation_total + $prasadam_total;
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
	<script>
		window.print();
	</script>
</body>
</html>