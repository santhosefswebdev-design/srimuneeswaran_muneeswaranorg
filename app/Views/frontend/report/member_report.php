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

	.pack, .pay {
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

	.capitalize {
		text-transform: capitalize;
		text-align: center;
	}

	.card .header1 {
		color: #555;
		padding: 10px 20px;
		position: relative;
		border-bottom: 1px solid rgba(204, 204, 204, 0.35);
	}

	.card .body {
		font-size: 14px;
		color: #222222;
		padding: 20px;
	}
</style>

<body class="sidebar-icon-only">
	<div class="container-scroller">
		<div class="container-fluid page-body-wrapper">
			<div class="main-panel">
				<div class="content-wrapper">
					<div class="row clearfix">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="card">
								<div class="col-md-12">
									<h3 style="text-align: center">Member Report</h3>
								</div><br>

								<div class="header1">
									<form action="<?php echo base_url(); ?>/report_online/print_memberreport" method="POST">
										<div class="container-fluid">
											<div class="row clearfix">
												<div class="col-md-2 col-sm-4">
													<div class="form-group form-float">
														<div class="form-line">
															<input type="date" name="fdt" id="fdt" class="form-control" value="<?php echo $from_date; ?>">
															<label class="form-label">From</label>
														</div>
													</div>
												</div>
												<div class="col-md-2 col-sm-4">
													<div class="form-group form-float">
														<div class="form-line">
															<input type="date" name="tdt" id="tdt" class="form-control" value="<?php echo $to_date; ?>">
															<label class="form-label">To</label>
														</div>
													</div>
												</div>
												<div class="col-md-2 col-sm-4">
													<div class="form-group form-float">
														<div class="form-line">
															<select class="form-control" name="status_filter" id="status_filter">
																<option value="">All Status</option>
																<?php foreach($member_status as $status) { ?>
																	<option value="<?php echo $status['id']; ?>"><?php echo $status['name']; ?></option>
																<?php } ?>
															</select>
															<label class="form-label">Status</label>
														</div>
													</div>
												</div>
												<div class="col-md-3 col-sm-4">
													<div class="form-group form-float">
														<div class="form-line">
															<input type="text" name="name_filter" id="name_filter" class="form-control" placeholder="Search by name">
															<label class="form-label">Name Filter</label>
														</div>
													</div>
												</div>
												<div class="col-md-3 col-sm-4">
													<label type="button" class="btn btn-success btn-lg waves-effect" id="submit">FILTER</label>
												</div>

												<div class="col-md-12 col-sm-12" style="margin:0px;">
													<button type="submit" class="btn btn-primary btn-lg waves-effect">PRINT</button>
													<input name="pdf_memberreport" type="submit" class="btn btn-danger btn-lg waves-effect" value="PDF">
													<input name="excel_memberreport" type="submit" class="btn btn-success btn-lg waves-effect" value="EXCEL">
												</div>
											</div>
										</div>
									</form>
								</div>

								<div class="body">
									<div class="table-responsive col-md-12 det" style="background:#FFF; float:none;">
										<table style="width:100%;" align="center" class="table table-striped dataTable" id="datatables">
											<thead>
												<tr>
													<th style="width:5%;">S.No</th>
													<th style="width:12%;">Registration Date</th>
													<th style="width:15%;">Name</th>
													<th style="width:15%;">Email</th>
													<th style="width:12%;">Mobile Number</th>
													<th style="width:12%;">Member Number</th>
													<th style="width:20%;">Address</th>
													<th style="width:15%;">Payment Details</th>
													<th style="width:10%;">Status</th>
													<th style="width:11%;">Action</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>

						<!-- Alert Modal -->
						<div id="alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog modal-sm">
								<div class="modal-content" style="width: 100%;">
									<div class="modal-body">
										<div class="text-center">
											<i class="dripicons-information h1 text-info"></i>
											<table>
												<tr>
													<span id="spndeddelid"><b></b></span>&nbsp;&nbsp;&nbsp;
													<button type="button" class="btn btn-info my-3" data-dismiss="modal"> &times;</button>
												</tr>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script src="<?php echo base_url(); ?>/assets/archanai/js/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>/assets/archanai/vendors/js/vendor.bundle.base.js"></script>
	<script src="<?php echo base_url(); ?>/assets/archanai/vendors/chart.js/Chart.min.js"></script>
	<script src="<?php echo base_url(); ?>/assets/archanai/js/jquery.cookie.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>/assets/archanai/js/off-canvas.js"></script>
	<script src="<?php echo base_url(); ?>/assets/archanai/js/hoverable-collapse.js"></script>
	<script src="<?php echo base_url(); ?>/assets/archanai/js/template.js"></script>
	<script src="<?php echo base_url(); ?>/assets/archanai/js/settings.js"></script>
	<script src="<?php echo base_url(); ?>/assets/archanai/js/todolist.js"></script>
	<script src="<?php echo base_url(); ?>/assets/archanai/js/dashboard.js"></script>
	<script src="<?php echo base_url(); ?>/assets/archanai/script.js"></script>

	<link href="https://panel.srimuneeswaran.org/dev/assets/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
	<script src="https://panel.srimuneeswaran.org/dev/assets/plugins/jquery-datatable/jquery.dataTables.js"></script>
	<script src="https://panel.srimuneeswaran.org/dev/assets/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
	<script src="https://panel.srimuneeswaran.org/dev/assets/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
	<script src="https://panel.srimuneeswaran.org/dev/assets/plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
	<script src="https://panel.srimuneeswaran.org/dev/assets/plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
	<script src="https://panel.srimuneeswaran.org/dev/assets/plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
	<script src="https://panel.srimuneeswaran.org/dev/assets/plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
	<script src="https://panel.srimuneeswaran.org/dev/assets/plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
	<script src="https://panel.srimuneeswaran.org/dev/assets/plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>

<script>
	$(document).ready(function() {
		report = $('#datatables').DataTable({
			dom: 'Bfrtip',
			paging: false,
			buttons: [],
			"ajax": {
				url: "<?php echo base_url(); ?>/report_online/member_rep_ref",
				dataType: "json",
				type: "POST",
				data: function(data) {
					data.fdt = $('#fdt').val();
					data.tdt = $('#tdt').val();
					data.status_filter = $('#status_filter').val();
					data.name_filter = $('#name_filter').val();
				}
			},
			"columns": [
				{ "data": null, "render": function(data, type, row, meta) {
					return meta.row + 1;
				}},
				{ "data": "created", "render": function(data, type, row) {
					if(data) {
						var date = new Date(data);
						return date.toLocaleDateString('en-GB');
					}
					return '';
				}},
				{ "data": "name" },
				{ "data": "email_address", "defaultContent": "-" },
				{ "data": "mobile" },
				{ "data": "member_no" },
				{ "data": "address", "defaultContent": "-" },
				{ "data": null, "render": function(data, type, row) {
					var fee = parseFloat(row.application_fee) || 0;
					var html = 'Membership: ' + parseFloat(row.payment - fee).toFixed(2);
					if (fee > 0) {
						html += '<br>Application Fee: ' + fee.toFixed(2);
					}
					html += '<br><strong>Total: ' + parseFloat(row.payment || 0).toFixed(2) + '</strong>';
					return html;
				}},
				{ "data": "status", "render": function(data, type, row) {
					return data == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>';
				}},
				{ "data": null, "render": function(data, type, row) {
					return `<a href="<?php echo base_url(); ?>/memberreg/print_member_receipt/${row.id}" 
							   target="_blank" 
							   class="btn btn-warning btn-sm" 
							   style="background: #ffc107; color: #000; padding: 5px 10px; border-radius: 4px; border: none;">
							   <i class="typcn typcn-printer"></i> Print
							</a>`;
				}}
			],
			"order": [[1, 'desc']]
		});

		$('#submit').click(function() {
			report.ajax.reload();
		});
	});
</script>
</body>