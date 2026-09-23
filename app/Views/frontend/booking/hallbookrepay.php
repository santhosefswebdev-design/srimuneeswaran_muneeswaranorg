<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
<div id="banner-area" class="banner-area" style="background-image:url(<?php echo base_url(); ?>/assets/frontend/images/banner/banner5.jpg)">
  <div class="container">
     <div class="row">
        <div class="col-sm-12">
           <div class="banner-heading">
              <h1 class="banner-title">Hall Booking</h1>
              <ol class="breadcrumb">
                 <li>Home</li>
                 <li><a href="#">Hall Booking Repayment</a></li>
              </ol>
           </div>
        </div>
     </div>
  </div>
</div> 
<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                            <div class="row"><div class="col-md-8 col-xs-6"><h2><a href="<?php echo base_url(); ?>/booking"><button type="button" class="btn bg-blue waves-effect">Back</button></a></h2></div>
                            <div class="col-md-4" align="right"></div></div>
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
                        <div class="container-fluid">
                            <form action="<?php echo base_url();?>/booking/save_repay/<?php echo $hall_datas['id']; ?>">
								<div class="row">
									<div class="col-md-8 col-lg-8 det"> 
										<div class="row">
											<div class="col-sm-12">
												<h3 class="heading">Booking Details</h3>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-2 col-form-label" for="animals">Event Name:</label>
									<div class="col-4"><span><?php echo $hall_datas['event_name']; ?></span></div>
								</div>
								<div class="form-group row">
									<label class="col-2 col-form-label" for="animals">Registerer Name:</label>
									<div class="col-4"><span><?php echo $hall_datas['name']; ?></span></div>
								</div>
								<div class="form-group row">
									<label class="col-2 col-form-label" for="animals">Total Amount:</label>
									<div class="col-4"><span><?php echo $hall_datas['total_amount']; ?></span></div>
								</div>
								<div class="form-group row">
									<label class="col-2 col-form-label" for="animals">Paid Amount:</label>
									<div class="col-4"><span><?php echo $hall_datas['paid_amount']; ?></span></div>
								</div>
								<div class="form-group row">
									<label class="col-2 col-form-label" for="animals">Balance Amount:</label>
									<div class="col-4"><span><?php echo $hall_datas['balance_amount']; ?></span></div>
									<input type="hidden" class="form-control" id="balance_amount" value="<?php echo $hall_datas['balance_amount']; ?>">
								</div>
								<div class="form-group row">
									<label class="col-2 col-form-label" for="animals">Enter the Amount:</label>
									<div class="col-4"><input type="number" class="form-control" id="pay_amount" value="0.00"></div>
								</div>
								<div class="form-group row">
									<div class="col-sm-3 col-md-3 col-xs-3">
										<div class="form-group">
											<div class="form-line" style="border: none; text-align: right;">
												<label class="btn btn-success" id="submit">Save</label>
											</div>
										</div>
									</div>
								</div>
                            </form>
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<div id="alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content" style="width: 360px;">
                <div class="modal-body p-4">
                    <div class="text-center">
                        <i class="dripicons-information h1 text-info"></i>
                        <table>
                            <tr><span id="spndeddelid"><b></b></span>&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-danger my-3" data-dismiss="modal"> &times;</button></tr>
                        </table>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div>
    </div>
<script>
$(document).ready(function(){
	$("#submit").click(function(e){
		e.preventDefault();
		var elm = $(this);
        var pay_amount       = parseFloat($("#pay_amount").val());
        var balance_amount       = parseFloat($("#balance_amount").val());
        if (pay_amount > 0 && pay_amount <= balance_amount){
			elm.prop('disabled', true);
			elm.text('Processing...');
			$.ajax({
				type:"POST",
				url: "<?php echo base_url();?>/booking/save_repay/<?php echo $hall_datas['id']; ?>",
				data: {pay_amount: pay_amount},
				success:function(data){
					elm.prop('disabled', false);
					elm.text('Save');
					console.log(data);
					obj = jQuery.parseJSON(data);
					$('#alert-modal').find('button').removeClass('btn-danger').addClass('btn-success');
					$('#alert-modal').modal('show', {backdrop: 'static'});
					setTimeout(function(){
						window.location.href = '<?php echo base_url();?>/booking/';
					}, 1500);
					$("#spndeddelid").text(obj.succ);
				},
				error:function(err){
					elm.prop('disabled', false);
					elm.text('Save');
					$('#alert-modal').modal('show', {backdrop: 'static'});
					$("#spndeddelid").text("Please try again later.");
					console.log('err');
					console.log(err);
				}
			});
        }else{
			$('#alert-modal').modal('show', {backdrop: 'static'});
            $("#spndeddelid").text("Pay amount must less than or equal the balance amount.");
        }
    });
});
</script>