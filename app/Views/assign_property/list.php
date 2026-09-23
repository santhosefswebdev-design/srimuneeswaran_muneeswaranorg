<?php global $lang;?>
<section class="content">
    <!-- Bootstrap CSS CDN -->
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

    <div class="container-fluid " style="margin-top:70px;">
        <div class="block-header">
        <h2>Property<small>Assign Property / <b>List</b></small></h2>
        <ul class="listnav nav nav-tabs">
                             <li class="nav-item">
      <a class="nav-link  custom-tab"  href="<?php echo base_url(); ?>/properties">Properties</a>
    </li>
    <li class="nav-item">
      <a class="nav-link active custom-tab " href="<?php echo base_url(); ?>/properties/assign_property">Assign Property</a>
    </li>
   
    <li class="nav-item">
      <a class="nav-link custom-tab" href="<?php echo base_url(); ?>/properties/property_history_report">Property History Reports</a>
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
                    <div class="header">
                        <div class="row"><div class="col-md-6"></div>
                        <div class="col-md-6" align="right">
                        <a href="<?php echo base_url(); ?>/tennant"> <button type="button" class="btn bg-deep-purple waves-effect">Tennancy Details</button></a>
                            <a href="<?php echo base_url(); ?>/properties/add_assign_property"><button type="button" class="btn bg-deep-purple waves-effect">Add</button></a></div></div>
                    </div>
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
                            <div class="table-responsive col-md-12 det" style="background:#FFF; float:none;">
								<table class="table table-bordered table-striped table-hover js-basic-example dataTable">
									<thead>
										<tr>
											<th>No.</th>
											<th>Property Name</th>
											<th>Tennant Name</th>
											<th>Start Date</th>
											<th>End Date</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php 
										$i = 1; 
										foreach($properties as $propertie) { ?>
										<tr>
											<td><?php echo $i++; ?></td>
											<td><?php echo $propertie['property_name']; ?></td>
											<td><?php echo $propertie['tennant_name']; ?></td>
											<td><?php echo date("d-m-Y", strtotime($propertie['start_date'])); ?></td>
											<td><?php echo date("d-m-Y", strtotime($propertie['end_date'])); ?></td>
											<td>
                                                <a class="btn btn-primary btn-rad" title="Edit" href="<?php echo base_url(); ?>/properties/edit_assign_property/<?php echo $propertie['id']; ?>"><i class="material-icons">&#xE3C9;</i></a> &nbsp; 
                                                <a class="btn btn-success btn-rad" title="View" href="<?php echo base_url(); ?>/properties/view_assign_property/<?php echo $propertie['id']; ?>"><i class="material-icons">&#xE417;</i></a> &nbsp;
                                                <a class="btn btn-danger btn-rad" title="Delete" onclick="confirm_modal(<?php echo $propertie['id'];?>)"><i class="material-icons">&#xE872;</i></a>
                                            </td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
                            </div>
						</div>
            
            </div>
        </div>
    </div>
    <div id="alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <div class="text-center">
                        <i class="dripicons-information h1 text-info"></i>
                        <h4 class="mt-2"><?php echo $lang->delete; ?> Assign Property</h4>
                        <table>
    
                        <tr><span id="spndeddelid"><b></b></span></tr>
                        </table>
                        
                        <a href="#" id="del" class="btn btn-danger my-3" data-dismiss="modal"><?php echo $lang->yes; ?></a> &nbsp;
                        <button type="button" class="btn btn-info my-3" data-dismiss="modal"><?php echo $lang->no; ?></button>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div>
    </div>
    <div id="del-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <div class="text-center">
                        <i class="dripicons-information h1 text-info"></i>
                        <table>
                            <tr><span id="delmol"><b></b></span>&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-info my-3" data-dismiss="modal"> &times;</button></tr>
                        </table>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div>
    </div>
    <!--Delete Form-->
    <div id=delete-form>
        
    </div>
    <!--End Delete Form-->                                        
</section>
</section>
<script>
    function confirm_modal(id)
    {
        $.ajax({
            url: "<?php echo base_url();?>/properties/del_assign_property_check",
            type: "post",
            data: {id: id},
            success:function(data){
                if(data == 0){
                    $('#alert-modal').modal('show', {backdrop: 'static'});
                    document.getElementById('del').setAttribute('onclick' , 'dedDel('+id+')');
                    $("#spndeddelid").text("Are You Sure You Want To Delete This?" );
                }else{
					//alert(id)
                    $('#del-modal').modal('show', {backdrop: 'static'});
                    $("#delmol").text("We used for this Property, So cant delete this Property" );
                }
            }
        });
    }
    function dedDel(id)
    {
        var act = "<?php echo base_url(); ?>/properties/delete_assign_property/"+id;
        $( "#delete-form" ).append( "<form action='"+act+"'><button type='submit' id='delete"+id+"' >submit</button></form>");
        $( "#delete"+id).trigger( "click" );
    }
</script>