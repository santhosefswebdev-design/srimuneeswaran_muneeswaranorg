<?php global $lang;?>
<style>
.btn-default, .btn-default:hover, .btn-default:active, .btn-default:focus {
    background: transparent !important;
}
.form-group { margin-bottom:0 !important; }
.col-sm-3 { margin-bottom:10px !important; }
.table tr th, .table tr td { text-align:center; }
.paid_text { color:green; font-weight:600; }
.unpaid_text { color:red; font-weight:600; }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2><?php echo $lang->annathanam; ?> <?php echo $lang->report; ?> <small><b><?php echo $lang->annathanam; ?> <?php echo $lang->report; ?></b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                        <div class="body">
                        <form action="<?php echo base_url(); ?>/report/print_annathanamreport" method="get" target="_blank">
                                <div class="container-fluid">
                                    <div class="row clearfix">
                                    <div class="col-md-2 col-sm-4">
                                            <div class="form-group form-float">
                                                <div class="form-line" id="bs_datepicker_container" >
                                                    <input type="date" name="fdt" id="fdt" class="form-control" value="<?php echo date('Y-m-01'); ?>"  >
                                                    <label class="form-label"><?php echo $lang->from; ?></label>
                                                </div>                                                        
                                            </div>                                            
                                        </div>
                                        <div class="col-md-2 col-sm-4">
                                            <div class="form-group form-float">
                                                <div class="form-line" id="bs_datepicker_container" >
                                                    <input type="date" name="tdt" id="tdt" class="form-control" value="<?php echo date('Y-m-d'); ?>"  >
                                                    <label class="form-label"><?php echo $lang->to; ?></label>
                                                </div>                                                        
                                            </div>                                            
                                        </div>
                                        <!-- <div class="col-md-2 col-sm-4">
                                            <div class="form-group form-float">
                                                <div class="form-line" id="bs_datepicker_container">
                                                    <label class="form-label" for="cdt">Event Date</label>
                                                    <input type="date" name="cdt" id="cdt" class="form-control" value="" >
                                                </div>                                                        
                                            </div>                                            
                                        </div> -->
										<div class="col-md-2 col-sm-4">
                                            <div class="form-group form-float">
												<div class="form-line">
                                                <label class="form-label">Payment Type Filter</label>
													<select class="form-control" name="group_filter" id="group_filter">
                                                        <option value="0">Select Type</option>
														<option value="full">Fully Paid</option>
														<option value="partial">Partially paid</option>
                                                    </select>
													<label class="form-label"></label>
												</div>
											</div>                                            
                                        </div>
                                            <div class="cocol-md-2 col-sm-4">
                                                <div class="form-group form-float">                                        
                                                    <label type="submit" class="btn btn-success btn-lg waves-effect" id="submit"><?php echo $lang->submit; ?></label>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-sm-12" style="margin:0px;">                                    
												<button type="submit" class="btn btn-primary btn-lg waves-effect" id="submit">Print</button>
												<input name="pdf_annathanamreport" type="submit" class="btn btn-danger btn-lg waves-effect" id="pdf_annathanamreport" value="PDF">
												<input name="excel_annathanamreport" type="submit" class="btn btn-success btn-lg waves-effect" id="excel_annathanamreport" value="EXCEL">
											</div>
                                        </div>
                                    </div>
                                </form>
                                <div class="table-responsive col-md-12 det" style="background:#FFF; float:none;">
                                    <table class="table table-striped dataTable" id="datatables">       
                                        <thead>
                                            <tr>
                                                <th style="width:5%;">S.No</th>
                                                <th style="width:5%;">Date</th>
                                                <th style="width:5%;">Invoice No</th>
                                                <th style="width:5%;">Booking Type</th>
                                                <th style="width:10%;">Name</th>
                                                <th style="width:15%;">Package</th>
                                                <th style="width:10%;">Payment Type</th>
                                                <th style="width:10%;">Payment Method</th>
                                                <th style="width:5%;">Total Amount(S$)</th>
                                                <th style="width:5%;">Paid Amount(S$)</th>
                                                <th style="width:5%;">Print</th>
                                            </tr>
                                        </thead>
                                        <tbody >                                    

                                        </tbody>
                                    </table>
                                </div>
           
                        </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function(){        
        report = $('#datatables').DataTable({
            dom: 'Bfrtip',
            buttons: [],
            "ajax":{
                url: "<?php echo base_url(); ?>/report/annathanam_rep_ref",
                dataType: "json",
                type: "POST",
                data: function ( data ) {
                    data.fdt = $('#fdt').val();
                    data.tdt = $('#tdt').val();
                    data.cdt = $('#cdt').val();
                    data.group_filter = $('#group_filter').val();

                }
            },
        });

        $('#submit').click(function() {
            report.ajax.reload();
        });

    });

</script>
