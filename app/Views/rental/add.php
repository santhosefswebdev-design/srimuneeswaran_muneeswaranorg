<?php
$db = db_connect();
if ($view == true) {
	$readonly = "readonly";
	$disabled = "disabled";
}
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/jquery-ui.css">
<script src="<?php echo base_url(); ?>/assets/jquery-ui.js"></script>
<link href="<?php echo base_url(); ?>/assets/monthpicker/MonthPicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>/assets/monthpicker/MonthPicker.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/jquery.validate.js"></script>
<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>RENTAL<small>rental / <b>Add</b></small></h2>
		</div>
		<!-- Basic Examples -->
		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<div class="row">
							<div class="col-md-8"></div>
							<div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/properties"><button
										type="button" class="btn bg-deep-purple waves-effect">Property List</button></a>
							</div>
						</div>
					</div>
					<div class="body">
						<form id="form_validation">
							<input type="hidden" value="<?php echo isset($rental['id']) ? $rental['id'] : ""; ?>"
								name="id" id="updateid">
							<div class="container-fluid">
								<div class="row clearfix">
									<div class="col-sm-8">
										<div class="form-group form-float">
											<div class="form-line focused">
												<input type="text" class="form-control"
													value="<?php echo $property['name']; ?>" readonly>
												<!--select name="property_id_old" id="property_id_old" class="form-control"
													required <?php echo $disabled; ?>>

													<?php
													foreach ($property_lists as $property_list) {
														?>
														<option value="<?php echo $property_list['id']; ?>" <?php if (isset($rental['property_id'])) {
															   if ($rental['property_id'] == $property_list['id']) {
																   echo "selected";
															   }
														   } ?>><?php echo $property_list['name']; ?>
														</option>
														<?php
													}
													?>
													<select-->
											</div>
											<input type="hidden" name="property_id" id="property_id"
												value="<?php echo $property['id']; ?>">
											<input type="hidden" name="tenn_prop_id" id="tenn_prop_id">
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group form-float">
											<div class="form-line focused">
												<input type="text" id="property_amount" class="form-control" value="<?php if (!empty($rental_amt)) {
													echo $rental_amt;
												} else {
													echo 0;
												} ?>" readonly>
												<label class="form-label">Amount</label>
											</div>
										</div>
									</div>
									<div style="clear:both"></div>
									  <div class="col-sm-4">
            <!-- Main dropdown for selecting Single or Multiple -->
            <div class="form-group form-float">
			<div class="form-line focused">
                <select class="form-control" id="typeSelection" name="typeSelection" onchange="toggleInput()" required>
                    <option value="">Choose Month Type<span style="color: red;">*</span></option>
                    <option value="single">Single</option>
                    <option value="multiple">Multiple</option>
                </select>
			  </div>
            </div>
        </div> 

        <!-- Container for the month input, initially hidden -->
        <div class="col-sm-4" id="singleInput" style="display: none;">
            <div class="form-group form-float">
                <div class="form-line focused">
                    <input type="month" name="rental_monthyear" id="rental_monthyear" class="form-control rental_monthyear" value="<?php echo isset($rental['month_year']) ? $rental['month_year'] : ""; ?>" autocomplete="off" required min="">
                    <label class="form-label">Month<span style="color: red;">*</span></label>
                </div>
            </div>
        </div>

        <!-- Container for the numeric dropdown, initially hidden -->
         <div class="col-sm-4" id="multipleInput" style="display: none;">
            <div class="form-group form-float">
			<div class="form-line focused">
                <select class="form-control" id="numericSelection" name="numericSelection">
                    <option value="">Select number of months</option>
                </select>
            </div>
			</div>
        </div> 
	

									<div class="col-sm-4">
										<div class="form-group form-float">
											<div class="form-line focused">
												<input type="number" name="rental_amount" id="rental_amount"
													class="form-control"
													value="<?php echo isset($rental['amount']) ? $rental['amount'] : 0; ?>"
													step=".01" readonly>
												<label class="form-label">Payee Amount <span
														style="color: red;">*</span></label>
											</div>
										</div>
									</div>
									
									<div class="col-sm-6">
										<div class="form-group form-float">
											<div class="form-line focused">
												<input type="text" name="rental_paynee_name" id="rental_paynee_name"
													class="form-control"
													value="<?php echo isset($rental['payee_name']) ? $rental['payee_name'] : ""; ?>"
													required>
												<label class="form-label">Payee Name<span
														style="color: red;">*</span></label>
											</div>
										</div>
									</div>
									<div class="col-sm-6">
    <div class=" form-group form-float" id="Total_amount" style="display: none;">
        <div class="form-line">
            <input type="text" name="totalAmount" id="totalAmount" class="form-control" readonly>
            <label class="form-label">Total Amount</label>
        </div>
    </div>
</div>
									<div style="clear:both"></div>
									<div class="col-sm-6">
										<div class="form-group form-float">
											<div class="form-line focused">
												<textarea name="rental_description" id="rental_description"
													class="form-control"><?php echo isset($rental['payee_description']) ? $rental['payee_description'] : ""; ?></textarea>
												<label class="form-label">Description</label>
											</div>
										</div>
									</div>
									<?php 
                                                 
                                                 $rent = $db->table('tennant_property')->where('property_id', $property['id'])->get()->getRowArray();
                                                 $ten_prop_id=$rent['id'];
                                                 $prop_id=$property['id'];
                                                $count =  getpropertyduemonthcount($ten_prop_id,$prop_id);

                                               
                                                ?>
									<div class="col-sm-6">
    <div class=" form-group form-float" id="extracharges">
        <div class="form-line">
			
            <input type="number" name="extracharges" id="extracharges" class="form-control" >
            <label class="form-label">Extra Charges / Month</label>
        </div>
    </div>
</div>
									<div style="clear:both"></div>
									<div class="col-md-4">
										<div class="form-group form-float">
											<div class="form-line focused">
												<select class="form-control" name="paymentmode" id="paymentmode"
													required>
													<option value="">Select Payment Mode</option>
													<?php
													foreach ($payment_modes as $payment_mode) {
														// Check if the current option should be selected
														$selected = isset($rental['payment_mode']) && $rental['payment_mode'] == $payment_mode['id'] ? 'selected' : '';
														echo '<option value="' . $payment_mode['id'] . '" ' . $selected . '>' . $payment_mode['name'] . '</option>';
													}
													?>
												</select>
											</div>
										</div>
									</div>
									<?php
									if (!empty($rental['payment_mode'])) {
										$check_payment_mode_data = $db->query("SELECT payment_mode.name FROM payment_mode WHERE id = '" . $rental['payment_mode'] . "' ")->getRowArray();
										$check_payment_mode = $check_payment_mode_data['name'];
									} else {
										$check_payment_mode = "";
									}
									?>
									<div class="col-sm-4" id="paymentmode_cheque_date_hide_show" style="display:<?php if (strtolower($check_payment_mode) == 'cheque') {
										echo 'block';
									} else {
										echo 'none';
									} ?>">
										<div class="form-group form-float">
											<div class="form-line focused">
												<input type="date" name="paymentmode_cheque_date"
													id="paymentmode_cheque_date" class="form-control"
													value="<?php echo isset($rental['cheque_date']) ? $rental['cheque_date'] : ""; ?>">
												<label class="form-label">Cheque Date</label>
											</div>
										</div>
									</div>
									<div class="col-sm-4" id="paymentmode_cheque_no_hide_show" style="display:<?php if (strtolower($check_payment_mode) == 'cheque') {
										echo 'block';
									} else {
										echo 'none';
									} ?>">
										<div class="form-group form-float">
											<div class="form-line focused">
												<input type="text" name="paymentmode_cheque_no"
													id="paymentmode_cheque_no" class="form-control"
													value="<?php echo isset($rental['cheque_no']) ? $rental['cheque_no'] : ""; ?>">
												<label class="form-label">Cheque No</label>
											</div>
										</div>
									</div>

									<div class="col-sm-4" id="paymentmode_transaction_date_hide_show" style="display:<?php if (strtolower($check_payment_mode) == 'online') {
										echo 'block';
									} else {
										echo 'none';
									} ?>">
										<div class="form-group form-float">
											<div class="form-line focused">
												<input type="date" name="paymentmode_transaction_date"
													id="paymentmode_transaction_date" class="form-control"
													value="<?php echo isset($rental['transaction_date']) ? $rental['transaction_date'] : ""; ?>">
												<label class="form-label">Transaction Date</label>
											</div>
										</div>
									</div>
									<div class="col-sm-4" id="paymentmode_transaction_no_hide_show" style="display:<?php if (strtolower($check_payment_mode) == 'online') {
										echo 'block';
									} else {
										echo 'none';
									} ?>">
										<div class="form-group form-float">
											<div class="form-line focused">
												<input type="text" name="paymentmode_transaction_no"
													id="paymentmode_transaction_no" class="form-control"
													value="<?php echo isset($rental['ref_no']) ? $rental['ref_no'] : ""; ?>">
												<label class="form-label">Ref No</label>
											</div>
										</div>
									</div>

								</div>


								<div class="col-sm-12" align="center"
									style="background-color: white;padding-bottom: 1%;">
									<input type="checkbox" checked="checked" id="print" name="print" value="Print">
									<label for='print'> Print &nbsp;&nbsp; </label>
									<button type="submit" class="btn btn-success btn-lg waves-effect">SUBMIT</button>
								</div>
							</div>
						</form>

					</div>

				</div>
			</div>
		</div>
	</div>

</section>
<script>
	$('#rental_monthyear_old').MonthPicker({ Button: false, MinMonth: 0 });


	$('#form_validation').validate({
		rules: {
			"property_id": {
				required: true,
				remote: {
					url: "<?php echo base_url(); ?>/rental/findpropertyNameExists",
					data: {
						update_id: function () {
							return $("#updateid").val();
						},
						rental_monthyear: function () {
							return $("#rental_monthyear").val();
						},
						tenn_prop_id: function () {
							return $("#tenn_prop_id").val();
						},
						property_id: $(this).data('property_id')
					},
					type: "post",
				},
			},
			"rental_monthyear": {
				required: true,
				remote: {
					url: "<?php echo base_url(); ?>/rental/findpropertyNameExists",
					data: {
						update_id: function () {
							return $("#updateid").val();
						},
						property_id: function () {
							return $("#property_id").val();
						},
						tenn_prop_id: function () {
							return $("#tenn_prop_id").val();
						},
						rental_monthyear: $(this).data('rental_monthyear')
					},
					type: "post",
				},
			}
		},
		messages: {
			"property_id": {
				required: "property name is required",
				remote: "Already property name exist"
			},
			"rental_monthyear": {
				required: "rental month is required",
				remote: "Already rental month paid"
			}
		},
		submitHandler: function (form) {
			$.ajax({
				url: '<?php echo base_url(); ?>/rental/store',
				type: 'post',
				data: $('#form_validation').serialize(),
				success: function (response) {
					obj = jQuery.parseJSON(response);
					if ($("#print").prop('checked') == true) {
						if(obj.id != ""){
							window.open("<?php echo base_url(); ?>/rental/print_single_multiple/" + obj.id);
							window.location.replace("<?php echo base_url(); ?>/properties");
						}
						else{
							window.location.replace("<?php echo base_url(); ?>/properties");
						}
					}
					else {
						window.location.replace("<?php echo base_url(); ?>/properties");
					}
				}
			});
		}
	});
	$(document).ready(function () {
		get_property_name();
	});
	$('#property_id').change(function () {
		get_property_name();
		$("#rental_monthyear").prop("min", "").prop("max", "").val("");
	});
	function get_property_name() {
		var id = $("#property_id").val();
		$.ajax({
			url: "<?php echo base_url(); ?>/rental/get_properties_amount",
			data: { prop_id: id },
			dataType: "JSON",
			type: "POST",
			success: function (data) {
				$("#property_amount").val(data.amount);
				$("#rental_paynee_name").val(data.payee_name);
				$("#rental_description").val(data.address);
				$("#rental_amount").val(data.amount);
				$("#extracharges").val(data.extracharges);
				$("#tenn_prop_id").val(data.tenn_prop_id);
				$("#rental_monthyear").prop("min", data.min_month).prop("max", data.max_month);
			}
		});
	}

	$(document).ready(function () {
		$('#paymentmode').on('change', function () {
			var pymnt_mode = $("#paymentmode option:selected").text().toLowerCase();
			if (pymnt_mode == "cheque") {
				$("#paymentmode_cheque_date_hide_show").show();
				$("#paymentmode_cheque_no_hide_show").show();
				$("#paymentmode_transaction_date_hide_show").hide();
				$("#paymentmode_transaction_no_hide_show").hide();
				$("#paymentmode_cheque_date").prop('required', true);
				$("#paymentmode_cheque_no").prop('required', true);
				$("#paymentmode_transaction_date").prop('required', false);
				$("#paymentmode_transaction_no").prop('required', false);
			}
			else if (pymnt_mode == "online") {
				$("#paymentmode_transaction_date_hide_show").show();
				$("#paymentmode_transaction_no_hide_show").show();
				$("#paymentmode_cheque_date_hide_show").hide();
				$("#paymentmode_cheque_no_hide_show").hide();
				$("#paymentmode_cheque_date").prop('required', false);
				$("#paymentmode_cheque_no").prop('required', false);
				$("#paymentmode_transaction_date").prop('required', true);
				$("#paymentmode_transaction_no").prop('required', true);
			}
			else {
				$("#paymentmode_cheque_date_hide_show").hide();
				$("#paymentmode_cheque_no_hide_show").hide();
				$("#paymentmode_transaction_date_hide_show").hide();
				$("#paymentmode_transaction_no_hide_show").hide();
				$("#paymentmode_cheque_date").prop('required', false);
				$("#paymentmode_cheque_no").prop('required', false);
				$("#paymentmode_transaction_date").prop('required', false);
				$("#paymentmode_transaction_no").prop('required', false);
			}
		});
	});
	$("form").on("submit", function () {
		// $('input[type=submit]').prop('disabled', true);
		// $("#loader").show();
	});
</script>
<script>
	
document.addEventListener('DOMContentLoaded', function() {
    function toggleInput() {
        var selection = document.getElementById("typeSelection").value;
        var singleInput = document.getElementById("singleInput");
        var multipleInput = document.getElementById("multipleInput");
		var Total_amount = document.getElementById("Total_amount");
        
        if (selection === "single") {
            singleInput.style.display = "block";
            multipleInput.style.display = "none";
			Total_amount.style.display ="none";
        } else if (selection === "multiple") {
            singleInput.style.display = "none";
            multipleInput.style.display = "block";
			Total_amount.style.display ="block";
			getmultiplechoosecount();
        } else {
            singleInput.style.display = "none";
            multipleInput.style.display = "none";
			Total_amount.style.display ="none";
        }
        // Reset the rental amount display when the type changes
        calculateAndDisplayTotal();
    }

    function calculateAndDisplayTotal() {
        var numberOfMonths = document.getElementById("numericSelection").value || 0;
		
		var rentalAmount = parseFloat(document.getElementById("rental_amount").value) || 0;
        var extraCharges = parseFloat(document.getElementById("extracharges").value) || 0;
		var extra = numberOfMonths * extraCharges;
        var total = numberOfMonths * rentalAmount;
		var tot = extra + total;
       // console.log(tot);
		//exit();
        // Update the displayed total; assuming you have an element to display the total
        document.getElementById("totalAmount").value = total.toFixed(2);
        // If you need to submit this total, you may want to update a hidden input field as well
    }

    // Attach event listeners
    document.getElementById("typeSelection").addEventListener('change', toggleInput);
    document.getElementById("numericSelection").addEventListener('change', calculateAndDisplayTotal);
	document.getElementById("extracharges").addEventListener('keyup', calculateAndDisplayTotal);
	

    // Initial calculation on page load
    calculateAndDisplayTotal();
});

function getmultiplechoosecount(){
	$("#numericSelection").empty();
	var propid = $("#property_id").val();
	var tenn_propid = $("#tenn_prop_id").val();
	$.ajax({
		url: "<?php echo base_url(); ?>/rental/get_multiple_choosecount",
		data: { propp_id:propid,tenn_propid:tenn_propid },
		type: "POST",
		success: function (response) {
			$("#numericSelection").html(response);
			$('#numericSelection').prop('selectedIndex',0);
			$("#numericSelection").selectpicker("refresh");
		}
	});
}
</script>
<script>
    var unpaidCount = <?php echo $count['unpaid_count']; ?>;
    document.addEventListener('DOMContentLoaded', function() {
        var extraCharges = document.getElementById('extracharges');

        // Function to show/hide extra charges based on unpaid count
        function toggleExtraCharges() {
            if (unpaidCount > 1) {
                extraCharges.style.display = 'block';
            } else {
                extraCharges.style.display = 'none';
            }
        }

        // Call toggle function on page load
        toggleExtraCharges();
    });
</script>
