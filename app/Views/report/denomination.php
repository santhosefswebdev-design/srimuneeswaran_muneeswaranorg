<?php global $lang;?>
<?php $booking_calendar_range_year = booking_calendar_range_year($_SESSION['booking_range_year']); ?>
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
        <h2>Denomination<small>Cash Denomination / <b>Report </b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                        <div class="body">
                            
                        <form action="<?php echo base_url(); ?>/report/print_denomination_report" method="get" target="_blank">
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
													<select class="form-control" name="fltername" id="fltername">
                                                        <option value="0"><?php echo $lang->select; ?><?php echo $lang->name; ?></option>
                                                        <?php
                                                        foreach($list as $row)
                                                        {
                                                        ?>
                                                        <option value="<?php echo $row['key']; ?>"><?php echo $row['name']; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
													<label class="form-label"></label>
												</div>
											</div>                                            
                                        </div>
                                            <div class="col-md-2 col-sm-3">
                                                <div class="form-group form-float">                                        
                                                        <label type="submit" class="btn btn-success btn-lg waves-effect" id="submit"><?php echo $lang->submit; ?></label>                                          		</div>
                                            </div>
                                            <div class="col-md-12 col-sm-12" style="margin:0px;">                                    
    											<button type="submit" class="btn btn-primary btn-lg waves-effect" id="submit">Print</button>
    											<input name="pdf_denominationreport" type="submit" class="btn btn-danger btn-lg waves-effect" id="pdf_denominationreport" value="PDF">
    											<input name="excel_denominationreport" type="submit" class="btn btn-success btn-lg waves-effect" id="excel_denominationreport" value="EXCEL">
    										</div>
                                        </div>
                                    </div>
                        </form>

                            <div class="table-responsive col-md-12 det" style="background:#FFF; float:none;">
                                <table class="table table-striped dataTable" id="datatables">
                                    
                                <thead>
                                        <tr>
                                            <th style="width:10%;"><?php echo $lang->sno; ?></th>
                                            <th style="width:30%;"><?php echo $lang->name; ?></th>
                                            <th style="width:30%;"><?php echo $lang->quantity; ?></th>
                                            <th style="width:30%;"><?php echo $lang->amount; ?></th>
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
        //alert(0);
        // member_details = $('#datatables').DataTable({
		// "ajax":{
        //     url: "<?php echo base_url(); ?>/report/arch_book_rep_ref",
        //     //url: "<?php echo site_url('report/arch_book_rep_ref'); ?>",
		//      dataType: "json",
		//      type: "POST",
		//      data: function ( data ) {
        //         //alert(0);
		// 		 	// data.type = $('#btn-filter').val();
		// 			// data.zone = $('#zone_id').val();
		// 			 console.log(data);
		// 		}
		// },
        //});
         //reloadTable();
        
        report = $('#datatables').DataTable({
            dom: 'Bfrtip',
            buttons: [],
            "ajax":{
                url: "<?php echo base_url(); ?>/report/denomination_rep_ref",
                dataType: "json",
                type: "POST",
                //data:{fdt:$('#fdt').val(),tdt:$('#tdt').val()},
                
                data: function ( data ) {

                    //alert("<?php echo base_url(); ?>/report/arch_book_rep_ref/"+($('#fdt').val()));
                    data.fdt = $('#fdt').val();
                    data.tdt = $('#tdt').val();
                    data.fltername = $('#fltername').val();
                    }

                //     success:function(f)
                // {
                //     //alert(data);
                //    //$('#billno').val(data);
                //  }
            },
        });



        $('#submit').click(function() {
        //reloadTable();
        //alert($('#fdt').val());
        report.ajax.reload();
        });



    });
    
    // function reloadTable() {
    //   $.ajax({
    //     url: "<?php echo site_url('report/arch_book_rep_refresh'); ?>",
    //     type:"POST",
    //     data:{fdt:$('#fdt').val(),tdt:$('#tdt').val()},
    //     beforeSend: function (f) {
    //       $('#userTable').html('Load Table ...');
    //     },
    //     success: function (data) {
    //      //$('#userTable').removeClass();
    //       $('#userTable').html(data);
    //     //$('#userTable').addClass("table table-bordered table-striped table-hover js-basic-example dataTable");
    //     }
    //   })
    //}
</script>
