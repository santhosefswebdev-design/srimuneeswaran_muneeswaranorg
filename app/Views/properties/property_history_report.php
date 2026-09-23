<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3pVutmAdZrJ7Sk7wYoVmG+R8HbA6Mo2aLvPAwl6iUyAAXc8JbckojeVX/X" crossorigin="anonymous">
<style>
.custom-tab {
  background-color: #4a81d4; /* Replace with your desired color */
}

.custom-tab.active {
  background-color: #ff0000; /* Color for active tab, replace with your desired color */
}

.custom-tab .nav-link {
  color: #ffffff !important; /* Forces the text color to white */
}

.custom-tab .nav-link:hover {
  color: #dddddd !important; /* Forces the hover color to a lighter shade of white */
}


.listnav {
  display: flex;
  flex-direction: row;
  justify-content: center;
  color: white;
}

</style>
<section class="content">
    <div class="container-fluid" style="margin-top:70px;">
        <div class="block-header">
        <h2>Property<small>Property / <b>History Report</b></small></h2>
        <ul class="listnav nav nav-tabs">
                             <li class="nav-item">
      <a class="nav-link  custom-tab"  href="<?php echo base_url(); ?>/properties">Properties</a>
    </li>
    <li class="nav-item">
      <a class="nav-link  custom-tab " href="<?php echo base_url(); ?>/properties/assign_property">Assign Property</a>
    </li>
   
    <li class="nav-item">
      <a class="nav-link active custom-tab" href="<?php echo base_url(); ?>/properties/property_history_report">Property History Reports</a>
    </li>
    <li class="nav-item">
      <a class="nav-link custom-tab" href="<?php echo base_url(); ?>/properties/property_collection_report">Property Collection Reports</a>
    </li>
  </ul>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="body">
                        <form action="#" method="get" target="_blank">
                            <div class="container-fluid">
                                <div class="row clearfix">
                                    <div class="col-md-3 col-sm-3">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <select class="form-control search_box" name="fltername" id="fltername" data-live-search="true">
                                                    <option value="">select property name</option>
                                                    <?php
                                                    foreach($properties as $row)
                                                    {
                                                    ?>
                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
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
                                            <label type="submit" class="btn btn-success btn-lg waves-effect" id="submit">
                                                Filter</label>                                          		
                                            </div>
                                        </div>
                                        <div class="col-md-6" align="right">
                        <a href="<?php echo base_url(); ?>/tennant/tennant_history_report"> <button type="button" class="btn bg-deep-purple waves-effect">Tennant History Report</button></a>
                           </div>
                                        <!--div class="col-md-12 col-sm-12" style="margin:0px;">                                    
                                            <button type="submit" class="btn btn-primary btn-lg waves-effect" id="submit">Print</button>
                                            <input name="pdf_archanaireport" type="submit" class="btn btn-danger btn-lg waves-effect" id="pdf_archanaireport" value="PDF">
                                            <input name="excel_archanaireport" type="submit" class="btn btn-success btn-lg waves-effect" id="excel_archanaireport" value="EXCEL">
                                        </div-->
                                    </div>
                                </div>
                            </form>
                            <div class="table-responsive col-md-12 det" style="background:#FFF; float:none;">
								<table class="table table-bordered table-striped table-hover dataTable" id="datatables">
									<thead>
										<tr>
											<th>SNo</th>
											<th>Name</th>
											<th>Property Category</th>
											<th>Purchased Year</th>
											<th>Rental Amount</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>

									</tbody>
								</table>
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
                url: "<?php echo base_url(); ?>/properties/get_property_history_report",
                dataType: "json",
                type: "POST",
                data: function ( data ) {
                    data.fltername = $('#fltername').val();
                }
            },
        });

        $('#submit').click(function() {
            report.ajax.reload();
        });
    });
</script>