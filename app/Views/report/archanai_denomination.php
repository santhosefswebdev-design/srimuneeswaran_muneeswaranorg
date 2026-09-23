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
            <h2> ARCHANAI REPORT <small>Archanai / <b>Archanai Booking Report</b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                        <div class="body">
                            
                        <form action="<?php echo base_url(); ?>/report/print_denominations_report" method="get" target="_blank">
							<div class="container-fluid">
								<div class="row clearfix">
									<div class="col-md-2 col-sm-3">
										<div class="form-group form-float">
											<div class="form-line" id="bs_datepicker_container" >
												<input type="date" name="fdt" id="fdt" class="form-control" value="<?php echo date('Y-m-01'); ?>"  >
												<label class="form-label">From</label>
											</div>                                                        
										</div>                                            
									</div>
									<div class="col-md-2 col-sm-3">
										<div class="form-group form-float">
											<div class="form-line" id="bs_datepicker_container" >
												<input type="date" name="tdt" id="tdt" class="form-control" value="<?php echo date('Y-m-d'); ?>"  >
												<label class="form-label">To</label>
											</div>                                                        
										</div>                                            
									</div>
									
									<div class="col-md-2 col-sm-3">
										<div class="form-group form-float">
											<div class="form-line">
												<select class="form-control" name="coin" id="coin">
												
												<option value="0">All</option>
												<?php foreach($coin_value as $row) { ?>
												<option value="<?php echo $row['key']; ?>"><?php echo $row['name'];?></option>
												<?php } ?> 
												</select>
												<label class="form-label">Coin</label>
											</div>
										</div>                                            
									</div>
									<div class="col-md-2 col-sm-3">
										<div class="form-group form-float">                                        
												<label type="submit" class="btn btn-success btn-lg waves-effect" id="submit">Submit</label>                                          		</div>
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
                                            <th style="width:5%;">S.No</th>
                                            <th style="width:40%;">Coin</th>
                                            <th style="width:40%;">Quantity</th>
                                            <th style="width:36%;">Amount</th>
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
                url: "<?php echo base_url(); ?>/report/arch_denomination_ref",
                dataType: "json",
                type: "POST",
                
                data: function ( data ) {
                    data.fdt = $('#fdt').val();
                    data.tdt = $('#tdt').val();
                    data.coin = $('#coin').val();
                }
            },
        });



        $('#submit').click(function() {
			report.ajax.reload();
        });



    });
</script>
