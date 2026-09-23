<!-- Bootstrap CSS CDN -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    integrity="sha384-JcKb8q3pVutmAdZrJ7Sk7wYoVmG+R8HbA6Mo2aLvPAwl6iUyAAXc8JbckojeVX/X" crossorigin="anonymous">
<style>
    .custom-tab {
        background-color: #4a81d4;
        /* Replace with your desired color */
    }

    .custom-tab.active {
        background-color: #ff0000;
        /* Color for active tab, replace with your desired color */
    }

    .custom-tab .nav-link {
        color: #ffffff !important;
        /* Forces the text color to white */
    }

    .custom-tab .nav-link:hover {
        color: #dddddd !important;
        /* Forces the hover color to a lighter shade of white */
    }


    .listnav {
        display: flex;
        flex-direction: row;
        justify-content: center;
        color: white;
    }

    .nav-tabs>li>a {
        border: none !important;
        color: #fff !important;
        -webkit-border-radius: 0;
        -moz-border-radius: 0;
        -ms-border-radius: 0;
        border-radius: 0;
    }
    body div .bootstrap-select.btn-group .dropdown-menu.inner {
        padding-bottom: 0px!important;
    }
</style>
<section class="content">
    <div class="container-fluid" style="margin-top:10px;">
        <div class="block-header">
        <h2>Property<small>Property / <b>Collection Report</b></small></h2>
        <ul class="listnav nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link  custom-tab" href="<?php echo base_url(); ?>/properties">Properties</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  custom-tab " href="<?php echo base_url(); ?>/tennant">Tennancy Details</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active custom-tab"
                        href="<?php echo base_url(); ?>/properties/property_collection_report">Property Collection
                        Reports</a>
                </li>
            </ul>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="body">
                        <form action="<?php echo base_url(); ?>/properties/print_property_collection_report" method="POST" target="_blank">
                            <div class="container-fluid">
                                <div class="row clearfix">
                                    <div class="col-md-3 col-sm-3">
                                        <div class="form-group form-float" style="margin-bottom:0px!important;">
                                            <div class="form-line">
                                                <select class="form-control search_box" name="fltername" id="fltername" data-live-search="true">
                                                    <option value="">select property name</option>
                                                    <?php
                                                    foreach($properties as $row)
                                                    {
                                                    ?>
                                                    <option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                                <label class="form-label"></label>
                                            </div>
                                        </div>                                            
                                    </div>
                                    <div class="col-md-2 col-sm-3">
                                        <div class="form-group form-float" style="margin-bottom:0px!important;">                                        
                                            <label type="submit" class="btn btn-success btn-lg waves-effect" id="submit">
                                                Filter</label>                                          		
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12" style="margin:0px;">                                    
                                            <button type="submit" class="btn btn-primary btn-lg waves-effect" >Print</button>
                                        </div>
                                        <!-- <div class="col-md-12 col-sm-12" style="margin:0px;">
                                            <button type="submit" class="btn btn-primary btn-lg waves-effect">Print</button>
                                            <a href="<?= base_url(); ?>/properties/property_collection_analytics" class="btn btn-info btn-lg waves-effect">Analytics</a>
                                        </div> -->
                                    </div>
                                </div> 
                            </form>
                            <div class="table-responsive col-md-12 det" style="background:#FFF; float:none;">
								<table class="table table-bordered table-striped table-hover dataTable" id="datatables">
									<thead>
										<tr>
											<th>SNo</th>
											<th>Name</th>
											<!-- <th>Property Category</th> -->
											<th>Property No</th>
											<th>Monthly Rental</th>
                                            <th>Tenant Name</th>
											<th>⁠Due Months<br> Count</th>
											<th>⁠Outstanding<br> Amount</th>
											<th>Last Paid<br> Due Month</th>
											<!--th>Total Rental Amount</th>
											<th>Paid Amount</th>
											<th>Balance Amount<br><span>(Untill End Due Month)</span></th-->
											<th>Action</th>
										</tr>
									</thead>
									<tbody>

									</tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="6" style="text-align:right;padding:10px 10px;">Total Outstanding</th>
                                            <th></th>
                                            <th colspan="2"></th>
                                        </tr>
                                    </tfoot>
								</table>
                                 <?php /* ?><div class="col-md-12 col-sm-12" style="margin:0px; text-align: center;">
                <h2 id="totalOutstanding" style="font-size: 18px; ">Total Outstanding: <?= number_format($property['totalOutstanding'], 2); ?>
                                    </h2>
                                
                                </div>
                                <?php
                                */
                                ?>
                            </div>
						</div>
            
            </div>
        </div>
    </div>

</section>
<script>
   $(document).ready(function () {
    var report = $('#datatables').DataTable({
        dom: 'Bfrtip',
        pageLength: 100,
        autoWidth: false,
        buttons: [],
        "ajax": {
            url: "<?php echo base_url(); ?>/properties/get_property_collection_report",
                dataType: "json",
                type: "POST",
                data: function (data) {
                    data.fltername = $('#fltername').val();
                },
                "dataSrc": function (json) {
                    // Assuming 'totalOutstanding' is part of the JSON response
                    $('#totalOutstanding').text('Total Outstanding: ' + parseFloat(json.totalOutstanding).toFixed(2));
                    return json.data;
                }
            },
            footerCallback: function (row, data, start, end, display) {
                let api = this.api();
        
                // Remove the formatting to get integer data for summation
                let intVal = function (i) {
                    return typeof i === 'string'
                        ? i.replace(/[\$,]/g, '') * 1
                        : typeof i === 'number'
                        ? i
                        : 0;
                };
        
                // Total over all pages
                total = api
                    .column(6)
                    .data()
                    .reduce((a, b) => intVal(a) + intVal(b), 0);
        
                // Total over this page
                pageTotal = api
                    .column(6, { page: 'current' })
                    .data()
                    .reduce((a, b) => intVal(a) + intVal(b), 0);
        
                // Update footer
                api.column(6).footer().innerHTML =
                    'RM ' + pageTotal.toFixed(2);
            }
        });

        $('#submit').click(function () {
            report.ajax.reload();
        });
    });

</script>