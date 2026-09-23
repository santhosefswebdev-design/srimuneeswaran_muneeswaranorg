<style>
    .table-responsive{
        overflow-x: hidden;
    }
	.paid_text { color:green; font-weight:600; }
	.unpaid_text { color:red; font-weight:600; }
</style>
<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2> Prasadam <small><b>Entry</b></small></h2>
            </div>
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                    <div id="alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body p-4">
                        <div class="text-center">
                            <i class="dripicons-information h1 text-info"></i>
                            <h4 class="mt-2">Delete Prasadam</h4>
                            <table>
        
                            <tr><span id="spndelid"><b></b></span></tr><br>
                          </table>
                            <br>
                            <a href="#" id="del" class="btn btn-danger my-3" data-dismiss="modal">Yes</a> &nbsp;
                            <button type="button" class="btn btn-info my-3" data-dismiss="modal">No</button>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div>
        </div>
        <!--Delete Form-->
        <div id=delete-form>
            
        </div>
        <!--End Delete Form-->
							<div class="header">
								<div class="row"><div class="col-md-8"><!--<h2>prasadam</h2>--></div>
								<div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/prasadam/add"><button type="button" class="btn bg-deep-purple waves-effect">Add Prasadam</button></a></div></div>
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
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th style="width:5%;">S.No</th>
                                            <th style="width:22%;">Prasadam Name</th>
                                            <th style="width:22%;">Description</th>
                                            <th style="width:7%;">Date</th>
                                            <th style="width:7%;">Customer Name</th>
                                            <th style="width:7%;">Amount</th>
                                            <th style="width:7%;">Collection Date</th>
											<th style="width:12% !important;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; foreach($list as $row) {
										?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo $row['name']; ?></td>
                                            <td><?php echo $row['desciption']; ?></td>
											<td><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>
											<td><?php echo $row['customer_name']; ?></td>
                                            <td><?php if($row['amount'] =='') 
											{ echo $row['amount']; } 
											else { echo number_format($row['amount'], '2','.',','); } ?></td>
											<td><?php echo date('d-m-Y', strtotime($row['collection_date'])); ?></td>
                                            <td style="width: 12%;">
                                                <a class="btn btn-warning btn-rad" href="<?= base_url()?>/prasadam/view/<?php echo $row['id'];?>"><i class="material-icons">&#xE417;</i></a>
												<a class="btn btn-primary btn-rad" href="<?= base_url()?>/prasadam/print_page/<?php echo $row['id'];?>" target="_blank"><i class="material-icons">print</i> </a>
                                               <a class="btn btn-primary btn-rad" href="<?= base_url()?>/prasadam/edit/<?php echo $row['id'];?>"><i class="material-icons">&#xE3C9;</i></a>
                                                <!--<a class="btn btn-danger btn-rad" onclick="confirm_modal(<?php echo $row['id'];?>)"><i class="material-icons">&#xE872;</i></a>-->
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
        </div>
    </section>
    <script>
    function confirm_modal(id)
    {
        $('#alert-modal').modal('show', {backdrop: 'static'});
        document.getElementById('del').setAttribute('onclick' , 'Del('+id+')');
        $("#spndelid").text("Are you sure to Delete "+$("#pay"+id).attr("data-id") + " prasadam?" );    
    }    
    function Del(id)
    {
        var act = "<?php echo base_url(); ?>/prasadam/delete/"+id;
        $( "#delete-form" ).append( "<form action='"+act+"'><button type='submit' id='delete"+id+"'>submit</button></form>");
        $( "#delete"+id).trigger( "click" );
    }
</script>