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
				<h2 style="font-family: Roboto;font-size: 30px;text-transform: uppercase;color: #000;font-weight: bold;">Annathanam</h2>
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
										<div class="col-sm-4">
											<div class="form-group form-float">
												<div class="form-line">
													<label class="form-label" style="color:#000;">Date</label>
													<input type="date" class="form-control" id="date" name="date" value="<?php echo date("Y-m-d");?>" required>
												</div>
											</div>
										</div>
										<div class="col-md-2" style="margin: 30px 0;text-align:right">
                                            <b>Time :</b> 
                                        </div>
										<div class="col-md-6" style="margin: 30px 0;text-align:left">
                                            <input type="checkbox" id="breakfast" name="time" value="Breakfast" class="check_time">
                                            <label for="breakfast"> Breakfast &nbsp;&nbsp; </label>
                                            <input type="checkbox" id="tiffin" name="time" value="Tiffin" class="check_time">
                                            <label for="tiffin"> Tiffin &nbsp;&nbsp; </label>
                                            <input type="checkbox" id="lunch" name="time" value="Lunch" class="check_time">
                                            <label for="lunch"> Lunch &nbsp;&nbsp; </label>
                                            <input type="checkbox" id="dinner" name="time" value="Dinner" class="check_time">
                                            <label for="dinner"> Dinner &nbsp;&nbsp; </label>

                                            <label id="time-error" class="error" for="time"></label>
                                        </div>
                                    </div>
									<div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="rice_category">Rice Category <span style="color: red;">*</span></label>
                                                <select class="form-control" id="rice_category" name="rice_category" required>
                                                    <option value="">-- select rice category --</option>
                                                    <?php
                                                    if (count($annathanam_rice_category) > 0) {
                                                        foreach ($annathanam_rice_category as $arc) {
                                                        ?>
                                                        <option value="<?php echo $arc['id']; ?>">
                                                        <?php echo $arc['name_eng']." - ".$arc['name_tamil']; ?>
                                                        </option>
                                                        <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input type="hidden" name="kuruma_count_id" id="kuruma_count_id" value="0">
                                                <label for="kuruma_id">Kuruma <span style="color: red;">*</span></label>
                                                <select class="form-control" id="kuruma_id" name="kuruma_id" required>
                                                    <option value="">-- select kuruma --</option>
                                                    <?php
                                                    if (count($annathanam_kuruma_type) > 0) {
                                                        foreach ($annathanam_kuruma_type as $akt) {
                                                        ?>
                                                        <option value="<?php echo $akt['id']; ?>">
                                                        <?php echo $akt['name_eng']." - ".$akt['name_tamil']; ?>
                                                        </option>
                                                        <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>	
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
										    <div class="form-group">
										        <label for="rice_type_id">Rice Type <span style="color: red;">*</span></label>
                                                <select class="form-control" id="rice_type_id" name="rice_type_id" required>
                                                    <option value="">-- select rice type --</option>
                                                    <?php
                                                    if (count($annathanam_rice_type) > 0) {
                                                        foreach ($annathanam_rice_type as $art) {
                                                        ?>
                                                        <option value="<?php echo $art['id']; ?>">
                                                        <?php echo $art['name']; ?>
                                                        </option>
                                                        <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="amount">Amount </label>
                                                <input type="number" name="amount" id="amount" min="0" step=".01" class="form-control" value="0.00" readonly>
                                            </div>
                                        </div>
                                    </div>                              
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="no_of_pax" id="no_of_pax_label" >No of Pax <span style="color: red;">*</span></label>
                                                <input type="number" name="no_of_pax" id="no_of_pax" min="0" class="form-control" placeholder="0" required="" aria-required="true" fdprocessedid="uosabi">
                                            </div>
                                        </div>
                                    </div>
										
                                    <div class="row">&nbsp;</div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h5 style="text-align:left;font-family: timesnewroman;">காய்கறி வகைகள் / TYPE OF VEGETABLES</h5>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="row scroll" style="overflow-y:scroll; overflow-x:hidden; height: 200px;">
                                                <div class="col-sm-12">
                                                    <div class="table-responsive" style="background: #9e9e9e17;">
                                                        <table style="width:100%" class="table table-bordered" id="pay_table">
                                                            <?php 
                                                                $i = 1;
                                                                foreach($annathanam_vegetables as $row) {
                                                                ?>
                                                                <tr>
                                                                    <td><?php echo $i++; ?></td>
                                                                    <td><?php echo $row['name_tamil']; ?></td>
                                                                    <td><?php echo $row['name_eng']; ?></td>
                                                                    <td>
                                                                        <input id="vegetables_id_<?php echo $row['id']; ?>" name="vegetables[<?php echo $row['id']; ?>][vegetble_id]" type="checkbox" value="<?php echo $row['id']; ?>" class="vegetables_id" onclick="vegatables_click(<?php echo $row['id']; ?>)">
                                                                        <label for ='vegetables_id_<?php echo $row['id']; ?>' ></label>
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>                          
                                        </div>
                                    </div>
                                    <div class="row">&nbsp;</div>
                                    <div class="row">
                                        <div class="col-sm-12" style="text-align:right;">
                                            <input type="hidden" id="total_amount" class="form-control" name="total_amount" value="0">
                                            <label class="default-btn" style="background: #7e4555;"><span id="total_amt_label" style="font-size: 30px;">RM 0.00</span></label>
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
												    <div class="form-group">
                                                        <label class="form-label">Bill No</label>
                                                        <input type="text" class="form-control" name="billno" id="billno" value="<?php echo $bill_no; ?>" readonly>
                                                    </div>
                                                </div>
												
												<div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label">DOB </label>
                                                        <input type="date" class="form-control" name="dob" id="dob" max="<?php echo date('Y-m-d'); ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="mobile">Mobile No</label>
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
                                                                <input class="form-control" type="number" id="phone_no" name="phone_no" min="0" autocomplete="off" >
                                                            </div>
                                                        </div>
                                                        
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
                                            <input type="submit" value="Pay Now" class="btn btn-success btn-lg" id="submit">                        
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
  $('#form_validation').validate({
		rules: {
			"name": {
				required: true,
			},
			"rice_category": {
				required: true,
			},
      "kuruma_id": {
				required: true,
			},
      "rice_type_id": {
				required: true,
			},
      "no_of_pax": {
				required: true,
			},
      "phone_no": {
				required: true,
			},
            "time": {
				required: true,
			}
		},
		messages: {
			"name": {
				required: "Name is required"
			},
			"rice_category": {
				required: "Rice category is required"
			},
      "kuruma_id": {
				required: "Kuruma type is required"
			},
      "rice_type_id": {
				required: "Rice type is required"
			},
      "no_of_pax": {
				required: "No of fax is required"
			},
      "phone_no": {
				required: "Phone no is required"
			},
            "time": {
				required: "Time slot is required"
			}
		},
		submitHandler: function (form) {
            var cartArray = loginDetail.listLogin();
	        if(cartArray.length > 0){
                var customer_id = cartArray[0].login_id;
                $.ajax({
                    url: '<?php echo base_url(); ?>/online_annathanam/save_annathanam',
                    type: 'post',
                    data: $('#form_validation').serialize() + "&user_login_id="+customer_id,
                    success: function (response) {
                    obj = jQuery.parseJSON(response);
                    if(obj.err != ''){
                        $('#alert-modal').modal('show');
                        $("#spndeddelid").text(obj.err);
                    }else{
                        window.open("<?php echo base_url(); ?>/online_annathanam/payment_process/" + obj.id, "_blank", "width=680,height=500");
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
<script>
$(document).ready(function(){
    $('.check_time').click(function() {
        $('.check_time').not(this).prop('checked', false);
    });
});
$(document).ready(function(){
    vegatables_click();
});
$("#rice_category, #rice_type_id").change(function(){
    getriceAmount();
});
$("#kuruma_id").change(function(){
    $(".vegetables_id").prop("checked",false);
    $(".vegetables_id").prop("disabled",false);
    var krm_id = $(this).val();
    $.ajax({
        url: "<?php echo base_url(); ?>/online_annathanam/getkurumaCount",
        type: 'POST',
        data: {kurm_id:krm_id},
        success: function (data) {
            $("#kuruma_count_id").val(data);
            getriceAmount();
        }
    });
});
$("#no_of_pax").on("keyup", function() {
    sum_amount();
});
function vegatables_click()
{
    //var total_vegetables = $(".vegetables_id").each(function(){ }).length;
    var total_kuruma_count = $("#kuruma_count_id").val();
    var array = [];
    $('.vegetables_id').each(function () {
        if (this.checked) {
        array.push($(this).val());
        //total_veg_checked++;
        }
    });
    var total_veg_checked = array.length;
    if(total_kuruma_count > total_veg_checked)
    {
        $(".vegetables_id").prop("disabled",false);
    }
    else
    {
        $('.vegetables_id').each(function () {
            if (this.checked) {
                var chj_tr = $(this).val();
                $("#vegetables_id_"+chj_tr).prop("disabled",false);
            }
            else
            {
                var chj_tre = $(this).val();
                $("#vegetables_id_"+chj_tre).prop("disabled",true);
            }
        });
    }
}
function getriceAmount()
{
    var rice_category = $("#rice_category").val();
    var kuruma_id = $("#kuruma_id").val();
    var rice_type_id = $("#rice_type_id").val();
    $.ajax({
        url: "<?php echo base_url(); ?>/online_annathanam/getriceAmount",
        type: 'POST',
        data: {rice_cat:rice_category,kurm_id:kuruma_id,ricetype_id:rice_type_id},
        success: function (data) {
            $("#amount").val(data);
            sum_amount();
        }
    });
}
function sum_amount(){
    var nooffax = $("#no_of_pax").val();
    var amount = $("#amount").val();
    var total_amount = nooffax * amount;
    $("#total_amount").val(Number(total_amount).toFixed(2));
    $("#total_amt_label").html("RM "+Number(total_amount).toFixed(2));
}
</script>