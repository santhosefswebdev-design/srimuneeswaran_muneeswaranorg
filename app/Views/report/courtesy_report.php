<?php global $lang;?>
<?php $booking_calendar_range_year = booking_calendar_range_year($_SESSION['booking_range_year']); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
.btn-default, .btn-default:hover, .btn-default:active, .btn-default:focus {
    background: transparent !important;
}
.form-group { margin-bottom:0 !important; }
.col-sm-3 { margin-bottom:10px !important; }
.table tr th, .table tr td { text-align:center; }
</style>
  <section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2><?php echo $lang->courtesy; ?> <?php echo $lang->report; ?> <small><?php echo $lang->member; ?> / <b><?php echo $lang->courtesy; ?> <?php echo $lang->report; ?></b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                        <div class="body">
                        <?php if($_SESSION['succ'] != '') { ?>
                            <div class="row" style="padding: 0 30%;" id="content_alert">
                                <div class="suc-alert">
                                    <span class="suc-closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                                    <p><?php echo $_SESSION['succ']; ?></p> 
                                </div>
                            </div>
                        <?php } ?>
                            <?php if($_SESSION['fail'] != '') { ?>
                            <div class="row" style="padding: 0 30%;" id="content_alert">
                                <div class="alert">
                                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                                    <p><?php echo $_SESSION['fail']; ?></p>
                                </div>
                            </div>
                        <?php } ?>   
                        <form method="get" >
                            <div class="container-fluid">
                                <div class="row clearfix">
                                    <div class="col-md-2 col-sm-3">
                                        <div class="form-group form-float">
                                            <div class="form-line" id="bs_datepicker_container" >
                                                <input type="date" name="fdt" id="fdt" class="form-control" value="<?php echo date('Y-m-01'); ?>"  max="<?php echo $booking_calendar_range_year; ?>">
                                                <label class="form-label"><?php echo $lang->from; ?></label>
                                            </div>                                                        
                                        </div>                                            
                                    </div>
                                    <div class="col-md-2 col-sm-3">
                                        <div class="form-group form-float">
                                            <div class="form-line" id="bs_datepicker_container" >
                                                <input type="date" name="tdt" id="tdt" class="form-control" value="<?php echo date('Y-m-d'); ?>"  max="<?php echo $booking_calendar_range_year; ?>">
                                                <label class="form-label"><?php echo $lang->to; ?></label>
                                            </div>                                                        
                                        </div>                                            
                                    </div>
                                    <div class="col-md-2 col-sm-3">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <select class="form-control" name="type" id="type">
                                                    <option value="0"><?php echo $lang->all; ?></option>
                                                    <option value="1"><?php echo $lang->cash; ?> <?php echo $lang->donation; ?></option>
                                                    <option value="2"><?php echo $lang->ubayam; ?></option>
                                                </select>
                                                <label class="form-label"><?php echo $lang->type; ?></label>
                                            </div>
                                        </div>                                            
                                    </div>
                                    <div class="col-md-2 col-sm-3">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="mobile_no" id="mobile_no" class="form-control"  >
                                                <label class="form-label"><?php echo $lang->mobile; ?></label>
                                            </div>
                                        </div>                                            
                                    </div>

                                        <div class="col-md-2 col-sm-3">
                                            <div class="form-group form-float">                                        
                                                    <label type="submit" class="btn btn-success btn-lg waves-effect" id="submit"><?php echo $lang->submit; ?></label>                                          		</div>
                                        </div>
                                    </div>
                                </div>
                            </form>
<!-- Print / PDF / Excel buttons -->
<div class="row" style="margin-bottom:10px;">
    <div class="col-md-12" style="text-align:right;">
        <button type="button" class="btn btn-default waves-effect" id="btn_print">
            <i class="fa fa-print"></i> Print
        </button>
        <button type="button" class="btn btn-danger waves-effect" id="btn_pdf">
            <i class="fa fa-file-pdf-o"></i> PDF
        </button>
        <button type="button" class="btn btn-success waves-effect" id="btn_excel">
            <i class="fa fa-file-excel-o"></i> Excel
        </button>
    </div>
</div>

<!-- Hidden export form -->
<form id="exportForm" action="<?php echo base_url(); ?>/report/print_courtesyreport" method="POST" target="_blank">
    <input type="hidden" name="fdt" id="exp_fdt">
    <input type="hidden" name="tdt" id="exp_tdt">
    <input type="hidden" name="type" id="exp_type">
    <input type="hidden" name="mobile_no" id="exp_mobile_no">
    <input type="hidden" name="pdf_courtesyreport" id="exp_pdf" value="">
    <input type="hidden" name="excel_courtesyreport" id="exp_excel" value="">
    <input type="hidden" name="print_courtesyreport" id="exp_print" value="">
</form>
                            <div class="table-responsive col-md-12 det" style="background:#FFF; float:none;">
                                <table class="table table-striped dataTable" id="datatables">
                                    
                                <thead>
                                        <tr>
                                            <th style="width:5%;"><?php echo $lang->sno; ?></th>
                                            <th style="width:10%;"><?php echo $lang->type; ?></th>
                                            <th style="width:10%;"><?php echo $lang->date; ?></th>
                                            <th style="width:20%;"><?php echo $lang->name; ?></th>
                                            <th style="width:10%;"><?php echo $lang->mobile; ?></th>
                                            <th style="width:10%;"><?php echo $lang->email_id; ?></th>
                                            <th style="width:10%;"><?php echo $lang->amount; ?></th>
                                            <th style="width:15%;"><?php echo $lang->action; ?></th>
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
                url: "<?php echo base_url(); ?>/report/courtesy_report_ajax",
                dataType: "json",
                type: "POST",
                data: function ( data ) {
                    data.fdt    = $('#fdt').val();
                    data.tdt    = $('#tdt').val();
                    data.type   = $('#type').val();
                    data.mobile_no = $('#mobile_no').val();
                }
            },
        });
        $('#submit').click(function() {
            report.ajax.reload();
        });
    });
function fillExportForm() {
    $('#exp_fdt').val($('#fdt').val());
    $('#exp_tdt').val($('#tdt').val());
    $('#exp_type').val($('#type').val());
    $('#exp_mobile_no').val($('#mobile_no').val());
}

$('#btn_print').click(function () {
    $('#exp_pdf').val(''); $('#exp_excel').val(''); $('#exp_print').val('PRINT');
    fillExportForm();
    $('#exportForm').submit();
});

$('#btn_pdf').click(function () {
    $('#exp_pdf').val('PDF'); $('#exp_excel').val(''); $('#exp_print').val('');
    fillExportForm();
    $('#exportForm').submit();
});

$('#btn_excel').click(function () {
    $('#exp_pdf').val(''); $('#exp_excel').val('EXCEL'); $('#exp_print').val('');
    fillExportForm();
    $('#exportForm').submit();
});
</script>
