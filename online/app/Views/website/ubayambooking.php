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
				<h2 style="font-family: Roboto;font-size: 30px;text-transform: uppercase;color: #000;font-weight: bold;">Ubayam Booking</h2>
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
													<label class="form-label" style="color:#000;">Ubayam Date</label>
													<input type="date" class="form-control" id="ubhayam_date" name="ubhayam_date" value="<?= $date; ?>" required>
												</div>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<div class="form-line">
													<label class="form-label" style="color:#000;">Pay for </label>
													<select class="form-control" id="pay_for" name="pay_for">

													</select>
												</div>
											</div>
										</div>
                                    </div>
									<div class="col-sm-12">&nbsp;</div>
									<div class="pack">
										<div class="row">
											<div class="col-sm-12">
												<h4 style="color:#FFFFFF; background:#7e4555;font-family: Roboto;font-size: 18px;padding: 7px 15px;text-transform: uppercase;">Family Details</h4>
											</div>
											<div class="col-sm-4">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
														<label class="form-label" style="color:#000;">Name</label>
                                                        <input type="text" class="form-control" id="family_name">
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
														<label class="form-label" style="color:#000;">IC No</label>
                                                        <input type="number" id="family_icno" min="0" class="form-control">
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
														<label class="form-label" style="color:#000;">Relationship</label>
                                                        <input type="text" class="form-control" id="family_relationship">
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group form-float">
                                                    <div class="form-line" style="border: none;"><br>
                                                        <label id="family_add" class="btn btn-success"
                                                            style="padding: 6px 12px !important;height: 2.35rem; margin-top: 6px;">Add</label>
                                                    </div>
                                                </div>
                                            </div>
										</div>
										<div class="row">&nbsp;</div>
										<div class="row">
											<div class="col-md-12 table-responsive"> 
												<table class="table table-bordered" style="width:100%; height: 150px;" id="family_table"> 
													<thead style="background:#7e4555;color:#FFFFFF;">
														<tr>
															<th width="30%">Name</th>
															<th width="30%">IC No</th>
															<th width="25%">Relationship</th>
															<th width="15%">Action</th>
														</tr>
													</thead>
													<tbody class="prod" style="overflow-y:scroll; overflow-x:hidden; max-height: 200px;">
													</tbody>
												</table>   
											</div>
											<input type="hidden" id="family_row_count" value="0">
										</div>
									</div>
									<div class="row">&nbsp;</div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input type="hidden" id="total_amt" class="form-control" name="total_amt" value="0">
                                                    <label class="form-label">Total Amount</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
									<div class="row">
										<div class="col-sm-12" style="text-align:right;">
											<label class="default-btn" style="background: #f1c152;"><span id="total_amt_label" style="font-size: 30px;">RM 0.00</span></label>
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
															<label class="form-label">Email Address </label>
                                                            <input type="email" class="form-control" name="email" id="email" > 
                                                            
                                                        </div>
                                                    </div>
                                                </div>
												<div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="mobile">Mobile No <span style="color: red;">*</span></label>
                                                        <div class="row">
                                                            <div class="col-md-3">
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
                                                            <div class="col-md-9">
                                                                <input class="form-control" type="number" id="mobile" name="mobile" min="0" autocomplete="off" >
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
															<label class="form-label">IC Number / Passport No </label>
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
												<button type="submit" class="btn btn-success btn-lg" id="submit_ubayam">Pay Now</button>
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
$('#ubhayam_date').change(function () {
	$("#total_amt").val(0);
	$("#total_amt_label").html("RM "+Number(0).toFixed(2));
	get_booking_ubhayam();
});
function get_booking_ubhayam() {
	var ubhayam_date = $("#ubhayam_date").val();
	if (ubhayam_date != '') {
		$.ajax({
			url: "<?php echo base_url(); ?>/online_ubayam/get_booking_ubhayam",
			type: "post",
			data: { ubhayamdate: ubhayam_date },
			success: function (data) {
				$("#pay_for").html(data);
			}
		});
	}
}
$(document).ready(function () {
	get_booking_ubhayam();
});

$("#pay_for").change(function () {
	var payfor = $(this).val();
	$.ajax({
		url: "<?php echo base_url() ?>/online_ubayam/get_payfor_collection",
		type: "POST",
		data: { id: payfor },
		success: function (data) {
			obj = jQuery.parseJSON(data);
			if (obj.target_amount)
			{
				$("#total_amt").val(Number(obj.target_amount).toFixed(2));
				$("#total_amt_label").html("RM "+Number(obj.target_amount).toFixed(2));
			} 
			else{
				$("#total_amt").val(0);
				$("#total_amt_label").html("RM "+Number(0).toFixed(2));
			}
		}
	})
});
$("#family_add").click(function () {
	var family_name = $("#family_name").val();
	var family_icno = $("#family_icno").val();
	var family_relationship = $("#family_relationship").val();
	var cnt_fmy = parseInt($("#family_row_count").val());
	if (family_name != '' && family_icno != '' && family_relationship != '') {
		var html = '<tr id="rmv_familyrow' + cnt_fmy + '">';
		html += '<td style="width: 25%;"><input type="text" style="border: none;" readonly name="familly[' + cnt_fmy + '][name]" value="' + family_name + '"></td>';
		html += '<td style="width: 25%;"><input type="text" style="border: none;" readonly name="familly[' + cnt_fmy + '][icno]" value="' + family_icno + '"></td>';
		html += '<td style="width: 25%;"><input type="text" style="border: none;" readonly name="familly[' + cnt_fmy + '][relationship]" value="' + family_relationship + '"></td>';
		html += '<td style="width: 25%;"><a class="btn btn-danger btn-rad" onclick="rmv_family(' + cnt_fmy + ')" style="width:auto;"><i class="fas fa-trash"></i></a></td>';
		html += '</tr>';
		$("#family_table").append(html);
		var ct_fmy = parseInt(cnt_fmy + 1);
		$("#family_row_count").val(ct_fmy);
		$("#family_name").val('');
		$("#family_icno").val('');
		$("#family_relationship").val('');
	}
});
function rmv_family(id) {
	$("#rmv_familyrow" + id).remove();
}

</script>
<script>
$('#form_validation').validate({
	rules: {
		"ubhayam_date": {
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
		}
	},
	messages: {
		"ubhayam_date": {
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
		}
	},
	submitHandler: function (form) {
		var cartArray_login = loginDetail.listLogin();
		if(cartArray_login.length > 0){
			var customer_id = cartArray_login[0].login_id;
			$.ajax({
				url: '<?php echo base_url(); ?>/online_ubayam/save_booking',
				type: 'post',
				data: $('#form_validation').serialize() + "&user_login_id="+customer_id,
				success: function (response) {
					obj = jQuery.parseJSON(response);
					if(obj.err != ''){
						$('#alert-modal').modal('show');
						$("#spndeddelid").text(obj.err);
					}else{
						window.open("<?php echo base_url(); ?>/online_ubayam/payment_process/" + obj.id, "_blank", "width=680,height=500");
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