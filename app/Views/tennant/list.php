<?php global $lang;?>
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
</style>
<section class="content">
    <div class="container-fluid " style="margin-top:70px;">
        <div class="block-header">
        <h2><?php echo $lang->tennant; ?><small> <?php echo $lang->rental; ?> / <b><?php echo $lang->list; ?></b></small></h2>
        <ul class="listnav nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link  custom-tab" href="<?php echo base_url(); ?>/properties">Properties</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active custom-tab " href="<?php echo base_url(); ?>/tennant">Tennancy Details</a>
                </li>

                
                <li class="nav-item">
                    <a class="nav-link custom-tab"
                        href="<?php echo base_url(); ?>/properties/property_collection_report">Property Collection
                        Reports</a>
                </li>
            </ul>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row"><div class="col-md-8"></div>
                        <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/tennant/add"><button type="button" class="btn bg-deep-purple waves-effect"><?php echo $lang->add; ?></button></a></div></div>
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
											<th><?php echo $lang->no; ?>.</th>
											<th><?php echo $lang->tennant; ?> <?php echo $lang->name; ?></th>
											<th><?php echo $lang->mobile; ?></th>
                                            
											<th><?php echo $lang->email_id; ?></th>
                                            <th>IC No</th>
											<th><?php echo $lang->address; ?></th>
											<th><?php echo $lang->action; ?></th>
										</tr>
									</thead>
									<tbody>
										<?php 
										$i = 1; 
										foreach($tennants as $tennant) {
                                            $phonecode = !empty($tennant['phonecode'])?$tennant['phonecode']:"";
                                            $phoneno = !empty($tennant['phone'])?$tennant['phone']:"";    
                                        ?>
										<tr>
											<td><?php echo $i++; ?></td>
											<td><?php echo $tennant['name']; ?></td>
											<td><?php echo $phonecode.$phoneno; ?></td>
											<td><?php echo $tennant['email']; ?></td>
                                            <td><?php echo $tennant['icno']; ?></td>
											<td><?php echo $tennant['address']; ?></td>
											<td>
                                                <a class="btn btn-primary btn-rad" title="Edit" href="<?php echo base_url(); ?>/tennant/edit/<?php echo $tennant['id']; ?>"><i class="material-icons">&#xE3C9;</i></a> &nbsp;
                                                <a class="btn btn-success btn-rad" title="View" href="<?php echo base_url(); ?>/tennant/view/<?php echo $tennant['id']; ?>"><i class="material-icons">&#xE417;</i></a> &nbsp;
                                                <a class="btn btn-danger btn-rad" title="Delete" onclick="confirm_modal(<?php echo $tennant['id'];?>)"><i class="material-icons">&#xE872;</i></a>
                                                <a class="btn btn-warning btn-rad" title="report" href="<?php echo base_url(); ?>/tennant/show_tennant_history/<?php echo $tennant['id']; ?>"><i class="material-icons "
                                                        >summarize</i></a>
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
                        <h4 class="mt-2"><?php echo $lang->delete; ?> Tennant Detail</h4>
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
<script>
    function confirm_modal(id)
    {
        $.ajax({
            url: "<?php echo base_url();?>/tennant/del_tennant_check",
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
                    $("#delmol").text("We used for this Tennant, So cant delete this Tennant" );
                }
            }
        });
    }
    function dedDel(id)
    {
        var act = "<?php echo base_url(); ?>/tennant/delete_tennant/"+id;
        $( "#delete-form" ).append( "<form action='"+act+"'><button type='submit' id='delete"+id+"' >submit</button></form>");
        $( "#delete"+id).trigger( "click" );
    }
</script>
