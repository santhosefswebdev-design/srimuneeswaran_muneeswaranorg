<style>
.form-label{
	color:#fff;
}
input.largerCheckbox {
	width: 18px;
	height: 18px;
}
.error{
	color:red;
}
</style>
<style>
      #go-button {
         position: fixed;
         padding: 5px;
         border-radius: 50%;
         width: 60px;
         height: 60px;
         bottom: 50px;
      }

      #go-button i {
         font-size: 32px;
         color: #FFF;
         line-height: 1.5;
      }
	  .default-btn:hover {
    color: #fff;
}
input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    margin: 0; 
}
   </style>
<div class="pageheader" style=""><!--background: url(<?php echo base_url(); ?>/assets/website/img/banner.png);background-repeat: no-repeat;-->
	<div class="container">
		<div class="row">
			<div class="col-md-12" style="    text-align: center;">
				<h2 style="font-family: Roboto;font-size: 30px;text-transform: uppercase;color: #000;font-weight: bold;">Cash Donation</h2>
			</div>
		</div>
	</div>
</div>
<!-- ================> Contact section start here <================== -->
    <div class="contact padding--top padding--bottom" style="padding: 40px 0 100px 0;background:#ffffff">
        <div class="container">
			<?php if($_SESSION['succ'] != '') { ?>
			<div class="row" style="padding: 0 30%;" id="content_alert">
				<div class="alert alert-success alert-dismissible">
					<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
					<strong>Success!</strong> <?php echo $_SESSION['succ']; ?>
				</div>
			</div> 
			<?php } ?>
			<?php if($_SESSION['fail'] != '') { ?>
			<div class="row" style="padding: 0 30%;" id="content_alert">
				<div class="alert alert-danger alert-dismissible">
					<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
					<strong>Failed!</strong> <?php echo $_SESSION['fail']; ?>
				</div>
			</div>
			<?php } ?>
			<div class="row">
				<div class="col-lg-12 col-12">
					<div class="section__wrapper">
						<form id="form_validation">
                            <div class="row">
                                <div class="col-md-8 det" style="border-bottom: 2px solid #7e45555c;border-top: 2px solid #7e45555c;border-left: 2px solid #7e45555c;padding: 20px;">
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group form-float">
												<div class="form-line">
													<label class="form-label" style="color:#000;">Donation Date</label>
													<input type="date" class="form-control" id="donation_date" name="donation_date" value="<?= $date; ?>" required>
												</div>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<div class="form-line">
													<label class="form-label" style="color:#000;">Pay for </label>
													<select class="form-control" id="pay_for" name="pay_for">
													<option value="">-- Select Donation --</option>
													<?php foreach($donation_setting as $row) { ?>
													<option value="<?php echo $row['id']; ?>" <?php if($data['pay_for'] == $row['id']){ echo "selected"; } ?>><?php echo $row['name']; ?></option>
													<?php } ?>
													</select>
												</div>
											</div>
										</div>
                                    </div>
									<div class="row">&nbsp;</div>
									
									<div class="row">&nbsp;</div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input type="number" id="total_amt" class="form-control" name="total_amt"  style="height: calc(1.5em + 0.75rem + 2px);font-size: 36px;text-align: center;" autocomplete="off" min="0" step="any" placeholder="0.00">
                                                    <label class="form-label">Total Amount</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
									
                                </div>
                                                        
                                <div class="col-md-4 det" style="background: #7e4555;padding: 15px;">
                                    
                                    <div class="cart">
                                        <h3 style="margin-top:0px;font-family: Roboto;color: #f1c152;font-size: 21px;text-transform: uppercase;">Register Details</h3>
                                            <div class="row" style="margin-top: 25px;">
                                                
                                                <div class="col-sm-12">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
															<label class="form-label">Name <span style="color: red;">*</span></label>
                                                            <input type="text" class="form-control" name="name" id="name">
                                                           
                                                        </div>
                                                    </div>
                                                </div>
												<div class="col-sm-12">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
															<label class="form-label">Email Address [optional]</label>
                                                            <input type="email" class="form-control" name="email" id="email" > 
                                                            
                                                        </div>
                                                    </div>
                                                </div>
												<div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="mobile">Mobile No <span style="color: red;">*</span></label>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <select class="form-control" name="phonecode" id="phonecode">
                                                                    <option value="">Dialing code</option>
                                                                    <?php
                                                                    if(!empty($phone_codes))
                                                                    {
                                                                        foreach($phone_codes as $phone_code)
                                                                        {
                                                                    ?>
                                                                    <option value="<?php echo $phone_code['dailing_code']; ?>" <?php if($phone_code['dailing_code'] == "+60"){ echo "selected";}?>><?php echo $phone_code['dailing_code']; ?></option>
                                                                    <?php
                                                                        }
                                                                    }              
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input class="form-control" type="number" id="mobile" name="mobile" min="0" autocomplete="off" >
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
															<label class="form-label">IC Number / Passport No [optional]</label>
                                                            <input type="number" min="0" class="form-control" name="ic_num" id="ic_num">
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
															<label class="form-label">Address</label>
                                                            <input type="text" class="form-control" name="address" id="address" >
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
															<label class="form-label">Remarks</label>
                                                            <textarea class="form-control" id="description" name="description" style="width:100%;" autocomplete="off"></textarea>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>

                                    </div>
                                </div>
								<div class="row">
									<div class="col-sm-12 col-md-12 col-xs-12">&nbsp;</div>
									<div class="col-sm-12 col-md-12 col-xs-12" style="text-align: center;">
										<div class="form-group">
											<div class="form-line" style="border: none;">				
												<button type="submit" class="btn btn-success btn-lg" id="submit_donation">Pay Now</button>
											</div>
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
	<!-- The Modal -->
<div id="alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-body">
				<p style="text-align:center;"><br><i class="mdi mdi-alert-circle-outline" style="font-size:42px; color:red;"></i></p>
				<h5 style="text-align:center;font-family: Roboto;" id="spndeddelid"></h5>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-info" data-bs-dismiss="modal">OK</button>
			</div>
		</div><!-- /.modal-content -->
	</div>
</div>
<!-- ================> Contact section end here <================== -->
<script src="<?php echo base_url(); ?>/assets/jquery.validate.js"></script>
<script>
$('#donation_date').change(function () {
	$("#total_amt").val(0);
});
</script>
<script>
$('#form_validation').validate({
	rules: {
		"donation_date": {
			required: true,
		},
		"pay_for": {
			required: true,
		},
		"name": {
			required: true,
		},
		"mobile": {
			required: true,
		},
		"total_amt": {
			required: true,
		}
	},
	messages: {
		"donation_date": {
			required: "Date is required"
		},
		"pay_for": {
			required: "Pay for is required"
		},
		"name": {
			required: "Name is required"
		},
		"mobile": {
			required: "Phone no is required"
		},
		"total_amt": {
			required: "Amount is required"
		}
	},
	submitHandler: function (form) {
		var cartArray_login = loginDetail.listLogin();
		if(cartArray_login.length > 0){
			var customer_id = cartArray_login[0].login_id;
			$.ajax({
				url: '<?php echo base_url(); ?>/online_donation/save_booking',
				type: 'post',
				data: $('#form_validation').serialize() + "&user_login_id="+customer_id,
				success: function (response) {
					obj = jQuery.parseJSON(response);
					if(obj.err != ''){
						$('#alert-modal').modal('show');
						$("#spndeddelid").text(obj.err);
					}else{
						window.open("<?php echo base_url(); ?>/online_donation/payment_process/" + obj.id, "_blank", "width=680,height=500");
						window.location.reload(true);
					}
				}
			});
		}
		else{
			customerLogin();
		}
	}
});
</script>