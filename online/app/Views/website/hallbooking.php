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
				<h2 style="font-family: Roboto;font-size: 30px;text-transform: uppercase;color: #000;font-weight: bold;">Hall Booking</h2>
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
					<!--div class="section__header text-left">
						<h2 style="font-family: Roboto;font-size: 30px;text-transform: uppercase;">Hall Booking</h2>
						<p></p>
					</div-->
					<div class="section__wrapper">
						<form id="form_validation">
                            <div class="row">
                                <div class="col-md-8 det" style="border-bottom: 2px solid #7e45555c;border-top: 2px solid #7e45555c;border-left: 2px solid #7e45555c;padding: 20px;">
									<div class="col-sm-12">
										<h3 style="margin-bottom:5px; margin-top:5px;font-family: Roboto;font-size: 18px;text-transform: uppercase;">Choose Date</h3>
									</div>
									<div class="col-sm-12">
										<div class="form-group form-float">
											<div class="form-line">
												<input type="date" class="form-control reg_det" id="event_date" name="event_date" value="<?= $date; ?>" required>
											</div>
										</div>
									</div>
									<br>
                                    <div class="scroll products row" >
                                        <div class="col-sm-12">
                                            <h3 style="margin-bottom:5px; margin-top:5px;font-family: Roboto;font-size: 18px;text-transform: uppercase;">Slot Details</h3>
                                        </div>
                                        <div class="col-sm-12">
                                            <table class="table" style="margin-bottom:0px;">
                                                <tbody id="booking_slot">
                                                </tbody>
                                            </table>
											<label id="timing[]-error" class="error" for="timing[]"></label><!--class='text-danger alert-danger'-->
                                        </div>
                                    </div>
                                    <div class="scroll products row">
                                        <div class="col-sm-12">
                                            <h3 style="margin-bottom:5px; margin-top:5px;font-family: Roboto;font-size: 18px;text-transform: uppercase;">Package Details</h3>
                                        </div>
                                        <div class="col-sm-6 ">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <!--<label class="form-lable">Package Name</label>-->
                                                    <select class="form-control" id="add_one">
                                                        <option value="">Select From</option> 
                                                        <?php foreach($package as $row) { ?>
                                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 ">
                                            <div class="form-group form-float">
                                                <div class="form-line focused">
                                                    <input type="hidden" id="pack_name">
                                                    <input type="number" class="form-control" id="get_pack_amt" placeholder="0.00" readonly>
                                                    <label class="form-label">RM</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 ">
                                            <div class="form-group form-float">
                                                <div class="form-line" style="border: none;">
                                                    <label id="pack_add" class="btn btn-success" style="padding: 5px 12px !important;">Add</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row scroll" style="overflow-y:scroll; overflow-x:hidden; height: 200px;">
                                        <div class="col-sm-12">
                                            <div class="table-responsive">
                                                <table class="table table-bordered" style="width:100%" id="package_table" style="height: 150px;">
                                                    <thead style="background: #7e4555;">
                                                        <tr>
                                                            <th width="20%" style="color:#fff">Package Name</th>
                                                            <th width="20%" style="color:#fff">Service Name</th>
                                                            <th width="35%" style="color:#fff">Description</th>
                                                            <th width="15%" style="color:#fff">Total RM</th>
                                                            <th width="10%" style="color:#fff">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="package_table_body">
                                                    </tbody>
                                                </table>
                                            </div>
                                            <input type="hidden" id="pack_row_count" value="0">
                                        </div>
                                    </div>
									<div class="row">&nbsp;</div>
									<div class="row">
										<div class="col-sm-12" style="text-align:right;">
											<p  class="default-btn" style="background: #f1c152;"><span id="total_amt_label" style="font-size: 30px;">RM 0.00</span></p>
										</div>
										<input type="hidden" id="total_amt" class="form-control" name="total_amt" value="0">
										<label id="total_amt-error" class="error text-danger alert-danger" for="total_amt"></label>
									</div>
									
									
                                </div>
                                                        
                                <div class="col-md-4 det" style="background: #7e4555;padding: 15px;">
                                    
                                    <div class="cart">
                                        <h3 style="margin-top:0px;font-family: Roboto;color: #f1c152;font-size: 21px;text-transform: uppercase;">Register Details</h3>
                                            <div class="row" style="margin-top: 25px;">
                                                
                                                <div class="col-sm-12">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
															<label class="form-label">Event Details <span style="color: red;">*</span></label>
                                                            <input type="text" class="form-control reg_det" name="event_name" id="event_name">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
															<label class="form-label">Register By <span style="color: red;">*</span></label>
                                                            <input type="text" class="form-control reg_det" name="register" id="register">
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
															<label class="form-label">Name <span style="color: red;">*</span></label>
                                                            <input type="text" class="form-control reg_det" name="name" id="name">
                                                           
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
															<label class="form-label">Address</label>
                                                            <input type="text" class="form-control reg_det" name="address" id="address" >
                                                            
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
															<label class="form-label">Email ID </label>
                                                            <input type="email" class="form-control reg_det" name="email" id="email" > 
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
															<label class="form-label">IC No / Passport No</label>
                                                            <input type="number" min="0" class="form-control reg_det" name="ic_num" id="ic_num">
                                                            
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
												<button type="submit" class="btn btn-success btn-lg" id="submit_hallbooking" >Pay Now</button>
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
$(document).ready(function(){
	loadbookingslots(<?= strtotime($date); ?>);
});
$("#add_one").change(function(){
	var id = $("#add_one").val();
	if(id != ''){
		$.ajax({
			url: "<?php echo base_url();?>/online_hallbooking/getpack_amt",
			type: "post",
			data: {id: id},
			dataType: "json",
			success: function(data){
				console.log(data)
				////Number(data['amt']).toFixed(2)
				$("#get_pack_amt").val(Number(data['amt']).toFixed(2));
				$("#pack_name").val(data['name']);
			}
		});
	}else{
		$("#get_pack_amt").val(0);
	}
});
function get_service_name(id,cmlp){
	//alert(id);
	if(id != ''){
		$.ajax({
			url: "<?php echo base_url();?>/online_hallbooking/get_service_name",
			type: "post",
			data: {id: id},
			dataType: "json",
			success: function(data){
				$("#service_name_"+cmlp).val(data['name']);
				$("#service_description_"+cmlp).val(data['description']);
			}
		});
	}
}
$("#pack_add").click(function(){
	// alert(0);
	//var id = $("#add_one option:selected").val();
	var id = $("#add_one option:selected").val();
	var pack_name = $( "#add_one option:selected" ).text();
	var cnt = parseInt($("#pack_row_count").val());
	amt = $("#get_pack_amt").val();
	//alert(amt);
	if(id != '' && parseFloat(amt)>0){
		var status_check = 0;
		$( ".package_category").each(function() {
			arcat = parseInt($(this).val());
			if(arcat == id){
				status_check++;
			}
		});
		if(status_check > 0)
		{
			alert("Already choosed this package please choose another package.");
		}
		else
		{
			$.ajax({
				url: "<?php echo base_url();?>/online_hallbooking/get_service_list",
				type: "post",
				data: {id: id},
				//dataType: "json",
				success: function(response){
					response = JSON.parse(response);
					if(response.length > 0) {
						$.each(response, function(key,value) {
							var countid = value.id;
							var serviceid = value.service_id;
							var serviceamount = value.service_amount;
							get_service_name(serviceid,countid);
							var html = '<tr id="rmv_packrow'+countid+'">';
								html += '<td style="width: 20%;">'+pack_name+'</td>';
								html += '<td style="width: 20%;"><input type="hidden" readonly name="service['+countid+'][service_id]" value="'+countid+'"><input type="text" style="border: none;width: 100%;" readonly id="service_name_'+countid+'" name="service['+countid+'][service_name]"></td>';
								html += '<td style="width: 35%;"><input type="text" style="border: none;width: 100%;" id="service_description_'+countid+'" name="service['+countid+'][description]" ></td>';
								html += '<td style="width: 15%;"><input type="text" style="border: none;width: 100%;" class="package_amt" name="service['+countid+'][service_amt]" value="'+Number(serviceamount).toFixed(2)+'" onkeyup="serviceamount()"></td>';
								html += '<td style="width: 10%;"><a class="btn btn-danger btn-rad" onclick="rmv_pack('+ countid +')" style="width:auto;padding: 0px 3px !important;"><i class="fas fa-trash"></i></a><input type="hidden" class="package_category" value='+id+'></td>';
								html += '</tr>';
							$("#package_table").append(html);
						});
						sum_amount();
					}
				}
			});
			$("#get_pack_amt").val('');
			$('#add_one').val('');
		}
	}
});
function rmv_pack(id){
	$("#rmv_packrow"+id).remove();
	sum_amount();
}
function serviceamount()
{
	sum_amount(); 
}
function sum_amount(){
	var total = 0;
	$(".package_amt").each(function(){
	   total += parseFloat($(this).val());
	});

	$("#total_amt").val(Number(total).toFixed(2));
	$("#total_amt_label").html("RM "+Number(total).toFixed(2));
}

$("#event_date").change(function(){
	var date = $(this).val();
	loadbookingslots(date);
});
function loadbookingslots(date)
{
    $.ajax({
        type:"POST",
        url: "<?php echo base_url(); ?>/online_hallbooking/loadbookingslots",
        data: {bookeddate:date},
        success:function(data)
        {
            $("#booking_slot").html(data);
        }
    });
}
$('#form_validation').validate({
	rules: {
		"event_date": {
			required: true,
		},
		"event_name": {
			required: true,
		},
		"register": {
			required: true,
		},
		"name": {
			required: true,
		},
		"mobile": {
			required: true,
		},
		"timing[]": {
			required: true,
		}
	},
	messages: {
		"event_date": {
			required: "Date is required"
		},
		"event_name": {
			required: "Event name is required"
		},
		"register": {
			required: "Register is required"
		},
		"name": {
			required: "Name is required"
		},
		"mobile": {
			required: "Phone no is required"
		},
		"timing[]": {
			required: "Slot timing is required"
		}
	},
	// error message
    highlight: function (form) { 
        $(form).closest('.form-control').addClass('is-invalid');
    },
    unhighlight: function (form) {
        $(form).closest(".form-control").removeClass("is-invalid");
    },
    focusInvalid: false,
    invalidHandler: function(form, validator) {
        if (!validator.numberOfInvalids())
            return;
        $('html, body').animate({
            scrollTop: $(validator.errorList[0].element).offset().top
        }, 1000);
    },
	submitHandler: function (form) {
		var cartArray_login = loginDetail.listLogin();
		if(cartArray_login.length > 0){
			var customer_id = cartArray_login[0].login_id;
			var total_amt = parseFloat($("#total_amt").val());
			if (total_amt == 0){
				$('#alert-modal').modal('show');
				$("#spndeddelid").text("Package amount lees than zero.");
			}
			else{
				$.ajax({
					url: '<?php echo base_url(); ?>/online_hallbooking/save_booking',
					type: 'post',
					data: $('#form_validation').serialize() + "&user_login_id="+customer_id,
					success: function (response) {
						obj = jQuery.parseJSON(response);
						if(obj.err != ''){
							$('#alert-modal').modal('show');
							$("#spndeddelid").text(obj.err);
						}else{
							window.open("<?php echo base_url(); ?>/online_hallbooking/payment_process/" + obj.id, "_blank", "width=680,height=500");
							window.location.reload(true);
						}
					}
				});
			}
		}
		else{
			customerLogin();
		}
	}
});

</script>