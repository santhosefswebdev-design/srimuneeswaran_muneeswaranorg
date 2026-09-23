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
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2><?php echo $lang->prasadam; ?> <?php echo $lang->report; ?> <small><b><?php echo $lang->prasadam; ?> <?php echo $lang->report; ?></b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                        <div class="body">
                        <form action="<?php echo base_url(); ?>/report/print_prasadamreport" method="get" target="_blank">
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
										<div class="col-md-2 col-sm-4">
                                            <div class="form-group form-float">
												<div class="form-line">
													<select class="form-control" name="fltername" id="fltername">
                                                        <option value="0"><?php echo $lang->select; ?> <?php echo $lang->pay_for; ?></option>
                                                        <?php
                                                        foreach($fltr_name as $row)
                                                        {
                                                        ?>
                                                        <option value="<?php echo $row['customer_name']; ?>"><?php echo $row['customer_name']; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
													<label class="form-label"></label>
												</div>
											</div>                                            
                                        </div>
                                        <div class="col-md-2 col-sm-4">
                                            <div class="form-group form-float">
                                                <div class="form-line" id="bs_datepicker_container" >
                                                    <input type="date" name="collection_date" id="collection_date" class="form-control" value="<?php echo date('Y-m-d'); ?>"  >
                                                    <label class="form-label"><?php echo $lang->collection; ?> <?php echo $lang->date; ?></label>
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
												<input name="pdf_prasadamreport" type="submit" class="btn btn-danger btn-lg waves-effect" id="pdf_prasadamreport" value="PDF">
												<input name="excel_prasadamreport" type="submit" class="btn btn-success btn-lg waves-effect" id="excel_prasadamreport" value="EXCEL">
											</div>
                                        </div>
                                    </div>
                                </form>
                                <div class="table-responsive col-md-12 det" style="background:#FFF; float:none;">
                                    <table class="table table-striped dataTable" id="datatables">       
                                        <thead>
                                            <tr>
                                            <th style="width:5%;"><?php echo $lang->sno; ?></th>
                                            <th style="width:8%;"><?php echo $lang->date; ?></th>
                                            <th style="width:9%;"><?php echo $lang->customer; ?> <?php echo $lang->name; ?></th>
                                            <th style="width:12%;"><?php echo $lang->collection; ?> <?php echo $lang->date; ?></th>
                                            <th style="width:15%;text-align:left;"><?php echo $lang->pay_for; ?></th>
                                            <th style="width:10%;"><?php echo $lang->amount; ?></th>
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
$(document).ready
(
    function()
    {        
        report = $('#datatables').DataTable({
            dom: 'Bfrtip',
            buttons: [],
            "ajax":{
                url: "<?php echo base_url(); ?>/report/prasadam_rep_ref",
                dataType: "json",
                type: "POST",
                data: function ( data ) {
                    data.fdt = $('#fdt').val();
                    data.tdt = $('#tdt').val();
                     data.fltername = $('#fltername').val();
                     data.collection_date = $('#collection_date').val();
                    }
            },
        });

        $('#submit').click(function() {
			report.ajax.reload();
        });

    });

</script>
