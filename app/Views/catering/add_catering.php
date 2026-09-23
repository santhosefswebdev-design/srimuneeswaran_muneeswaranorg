<?php 
if($view == true){
    $readonly = 'readonly';
    $disable = "disabled";
}
if($edit == true){
    $readonly_edit = 'readonly';
    $disable_edit = "disabled";
}
?>
<style>
    <?php if($view == true) { ?>
        label.form-label span { display:none !important; color:transporant; }
    <?php } ?>
    
    body div .bootstrap-select.btn-group .dropdown-menu.inner {
        padding-bottom: 0px!important;
    }
    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        margin: 0; 
    }
    .inputbox_valid label.error{
        margin-bottom: -17px!important;
        margin-top: 0px!important;
    }
    .addon-dropdown option {
            display: flex;
            justify-content: space-between;
        }

    .addon-dropdown .amount-right {
        margin-left: auto;
        color: gray;
        font-size: 12px;
    }
    .form-control.text-center {
            text-align: center;
    }
    .total-amount {
        padding: 8px;
        border: none;
        background: none;
    }
    .highlight {
        border: 2px solid red;
    }
    .modal-dialog {
            max-width: 300px; /* Adjust the width as needed */
            
        }
        .highlight {
            border: 2px solid red;
        }

    .bootstrap-select .dropdown-header {
        font-weight: bold;  /* Make the text bold */
        color: #333;       /* Dark color for the text */
        background-color: #eaebeb;  /* Light background to make the text stand out */
    }

    .bal_amnt_div{
        display: none;
    }
</style>

<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>Catering<small>Catering / <b>Add Catering</b></small></h2>
            </div>
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <div class="row"><div class="col-md-8"></div>
                            <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/catering"><button type="button" class="btn bg-deep-purple waves-effect">List</button></a></div></div>
                        </div>
                        <form id="form_validation" action="" method="post">
                        <input type="hidden" name="date" id="date" class="form-control" value="<?php echo date('Y-m-d'); ?>"  >
                        <input type="hidden" name="term_setting" id="term_setting" class="form-control" value="<?php echo $setting['enable_terms']; ?>">
                        <div class="body">
                            <input type="hidden" name="id" value="<?php echo $data['id'];?>">
                            <div class="container-fluid">
                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line" id="bs_datepicker_component_container">
                                            <input type="event_date" name="event_date" class="form-control" value="<?php if($view == true) echo date("d-m-Y",strtotime($data['event_date'])); else echo date("d-m-Y");?>" <?php echo $readonly; ?> <?php echo $disable_edit; ?> required>
                                            <label class="form-label">Event Date <span style="color: red;">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4" style="margin: 0px;">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" name="billno"  id="billno" class="form-control" value="<?php echo !empty($data['ref_no']) ? $data['ref_no'] : $bill_no; ?>" readonly>
                                            <label class="form-label">Invoice No</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group form-float inputbox_valid">
                                        <div class="form-line">
                                            <input type="text" name="name" id="name" class="form-control" value="<?php echo $data['name'];?>" <?php echo $readonly; ?> required>
                                            <label class="form-label">Name <span style="color: red;">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-md-1">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <select class="form-control" name="phone_code" id="phone_code" <?php echo $disable; ?>>
                                                        <option value="0">select</option>
                                                        <?php
                                                            if(!empty($phone_codes))
                                                            {
                                                                foreach($phone_codes as $phone_code)
                                                                {
                                                            ?>
                                                            <option value="<?php echo $phone_code['dailing_code']; ?>" <?php if($phone_code['dailing_code'] == "+65"){ echo "selected";}?>><?php echo $phone_code['dailing_code']; ?></option>
                                                            <?php
                                                                }
                                                            }              
                                                        ?>
                                                    </select>
                                                    <label class="form-label">&nbsp;</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group form-float inputbox_valid">
                                                <div class="form-line">
                                                    <input type="number" min="0" name="phone_no" id="phone_no" class="form-control " value="<?php echo $data['phone_no'];?>" <?php echo $readonly; ?> >
                                                    <label class="form-label">Mobile Number <span style="color: red;">*</span></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group form-float">
                                                <div class="form-line focused" >
                                                    <input type="date" name="dob" id="dob" class="form-control" max="<?php echo date('Y-m-d'); ?>" value="<?php echo $data['dob'];?>">
                                                    <label class="form-label ">DOB <span style="color: red;"></span></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Select Slot <span style="color: red;">*</span></label>
                                            <div class="form-group form-float">
                                                <input  type="checkbox" id="breakfast" name="time" value="Breakfast" class="check_time" >
                                                <label for ='breakfast'> Breakfast &nbsp;&nbsp; </label>
                                                <input  type="checkbox" id="lunch" name="time" value="Lunch" class="check_time" >
                                                <label for ='lunch'> Lunch &nbsp;&nbsp; </label>
                                                <input  type="checkbox" id="dinner" name="time" value="Dinner" class="check_time" >
                                                <label for ='dinner'> Dinner &nbsp;&nbsp; </label>
                                            </div>
                                        </div>
                                        <div class="col-md-3" id="time-picker-container">
                                            <div class="form-group form-float">                                      
                                                <label for="hour">Select Time </label>
                                                <div style="display: flex; gap: 10px;">
                                                    <select id="hour" name="hour" class="form-control" style="display:inline-block;"> 
                                                        <option value="">Hour</option>
                                                    </select>
                                                    :
                                                    <select id="minute" name="minute" class="form-control" style="display:inline-block;">
                                                        <option value="">Minute</option>
                                                    </select>
                                                    <select id="ampm" name="ampm" class="form-control" style="display:inline-block;" disabled>
                                                        <option value="AM">AM</option>
                                                        <option value="PM">PM</option>
                                                    </select>
                                                </div>                                            
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-sm-6" style="display: none">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <select class="form-control" name="package_id" id="package_id" required>
                                                <option value="">--select Annathanam Package--</option>
                                                <?php if (count($packages) > 0): ?>
                                                    <?php foreach ($packages as $pack): ?>
                                                        <option value="<?php echo $pack['id']; ?>" data-amount="<?php echo $pack['amount']; ?>" <?php if(!empty($pack['id'])){ if($pack['id'] == 1){ echo "selected"; } } ?>> 
                                                            <?php echo $pack['name_eng'] . ' / ' . $pack['name_tamil']; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <input type="hidden" name="package_name" id="package_name" value="">
                                </div>

                                <div class="col-sm-8">
                                    <div class="form-group form-float inputbox_valid">
                                        <div class="form-line">
                                            <input type="text" name="address" id="name" class="form-control" value="<?php echo $data['address'];?>" <?php echo $readonly; ?> required>
                                            <label class="form-label">Address <span style="color: red;">*</span></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group form-float inputbox_valid">
                                        <div class="form-line">
                                            <input type="time" name="pickup_time" id="pickup_time" class="form-control" value="<?php echo $data['pickup_time'];?>" <?php echo $readonly; ?> required>
                                            <label class="form-label">Pick-Up Time <span style="color: red;">*</span></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4" style="display: none">
                                    <div class="form-group form-float">
                                        <div class="form-line focused">
                                            <label class="form-label">No of Pax (*Minimum <?php echo $setting['catering_min_pax']; ?> pax)<span style="color: red;">*</span></label>
                                            <input type="number" id="no_of_pax" min="<?php echo $setting['catering_min_pax']; ?>" name="no_of_pax" class="form-control" value="<?php echo !empty($data['no_of_pax']) ? $data['no_of_pax'] : ""; ?>" <?php echo $readonly; ?> required placeholder="0" >
                                        </div>
                                    </div>
                                </div>

                                <div class="row" style="padding: 45px">
                                    <div class="annathanam_special_items">
                                        <div class="col-md-12">&nbsp;</div> 
                                        <h3>Items<small><b></b></small></h3>
                                            <div class="row clearfix">
                                                <div class="col-sm-5">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <select class="form-control" id="special_dropdown">
                                                                <option value="">-- Select Service --</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="form-group form-float">
                                                        <div class="form-line focused">
                                                            <input type="number" class="form-control" id="get_pack_amt_special" placeholder="0.00" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2" align="left">
                                                    <div class="form-group form-float">
                                                        <a class="btn btn-success" id="add_special_item">Add</a>
                                                    </div>
                                                </div>
                                            </div>
                                        <div class="row" style="">
                                            <div class="col-sm-12">
                                                <div class="table-responsive">
                                                    <table class="table" id="annathanam_special_table" style="background: #fff; border: none; width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th style="text-align: center" width="10%">S.no</th>
                                                                <th style="text-align: center" width="20%">Type</th>
                                                                <th style="text-align: center" width="30%">Service</th>
                                                                <th style="text-align: center" width="10%">Quantity</th>
                                                                <th style="text-align: center" width="10%">Amount</th>
                                                                <th style="text-align: center" width="10%">Total</th>
                                                                <th style="text-align: center" width="10%">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <!-- Items will be dynamically added here -->
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <input type="hidden" id="pack_row_count_special" value="1">
                                            </div>
                                        </div>
                                    </div>

                                    <br>
                                    <h3>Add-on Items<small><b></b></small></h3>
                                    <?php if($view != true) { ?>
                                        <div class="row clearfix">
                                            <div class="col-sm-5">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <select class="form-control addon-dropdown" id="annathanamAddonDropdown">                                            
                                                            <option value="">-- Select Service --</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group form-float">
                                                    <div class="form-line focused">
                                                        <input type="hidden" id="pack_name_addon">
                                                        <input type="number" class="form-control" id="get_pack_amt_addon" placeholder="0.00" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-2" align="left">
                                                <div class="form-group form-float">
                                                    <button class="btn btn-success" id="add_annathanam_addon" type="button">Add</button>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="row" style="">
                                        <div class="col-sm-12">
                                            <div class="table-responsive">
                                                <table class="table" id="annathanam_addon_items_table" style="background: #fff; border: none; width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th style="text-align: center" width="10%">S.no</th>
                                                            <th style="text-align: center" width="30%">Addon</th>
                                                            <th style="text-align: center" width="15%">Quantity</th>
                                                            <th style="text-align: center" width="15%">Item Amount</th>
                                                            <th style="text-align: center" width="15%">Item Total</th>
                                                            <th style="text-align: center" width="15%">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!-- Addon items will be dynamically added here -->
                                                    </tbody>
                                                </table>
                                            </div>
                                            <input type="hidden" id="pack_row_count_addon" value="1">
                                        </div>
                                    </div>

                                    <br>
                                    <div class="col-md-12">
                                        <div class="addi_hide" style="display: none">
                                            <h3 style="text-align:center;">Additional Items<small><b></b></small></h3><br>
                                            <div class="scroll row">
                                                <div class="col-sm-6">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <input type="text" id="addi_item_name" class="form-control" placeholder="Item Name">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <input type="number" id="addi_item_amount" class="form-control" placeholder="Amount">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group form-float">
                                                        <label id="add_addi_item" class="btn btn-success" style="padding: 5px 12px !important;">Add</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <table id="addi_item_table" class="table">
                                                <thead>
                                                    <tr>
                                                        <th>S.No</th>
                                                        <th>Item Name</th>
                                                        <th>Quantity</th>
                                                        <th>Amount(S$)</th>
                                                        <th>Total Amount(S$)</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- Dynamically added rows will appear here -->
                                                </tbody>
                                                <input type="hidden" id="pack_row_count_addi" value="1">
                                            </table>
                                        </div><br><br>
                                    </div><br><br>
                                

                                    <div class="row clearfix">
                                        <div class="col-sm-3" <?php if(!empty($setting['catering_discount'])){ echo ' style="display: block;"'; }else echo ' style="display: none;"'; ?>>
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input type="number" name="discount_amount" id="discount_amount" min="0" step=".01" class="form-control" value="0">
                                                    <label class="form-label" style="text-align: center">Discount</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input type="number" min="0" id="total_amount" name="total_amount" class="form-control" step="any"  value="<?php echo !empty($data['total_amount']) ? $data['total_amount'] : "0.00"; ?>" readonly>
                                                    <label class="form-label">Total Amount </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                
                                    <div class="row clearfix">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <input type="radio" name="payment_type" id="payment_type_2" class="payment_type" value="full" 
                                                    <?php echo (empty($data['payment_type']) || $data['payment_type'] == 'full') ? 'checked' : ''; ?>>  
                                                <label for="payment_type_2" class="pay-label">Full Payment</label>  

                                                <input type="radio" name="payment_type" id="payment_type_1" class="payment_type" value="partial" 
                                                    <?php echo ($data['payment_type'] == 'partial') ? 'checked' : ''; ?>>  
                                                <label for="payment_type_1" class="pay-label">Partial Payment</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 partial_paid_sec" style="<?php echo (!empty($data['payment_type']) && $data['payment_type'] == 'partial') ? '' : 'display: none;'; ?>">
                                            <label class="form-label">Paid Amount</label>
                                            <input type="number" name="paid_amount" id="paid_amount" step=".01" class="form-control" value="<?php echo htmlspecialchars($data['paid_amount'] ?? '0.00'); ?>">
                                        </div>
                                    </div>

                                    <div class="row clearfix">
                                        <div class="col-md-6">
                                            <div class="form-group form-float">
                                                <div class="form-line focused">
                                                    <select class="form-control" name="payment_mode" id="payment_mode" <?php echo $disable; ?> <?php echo $disable_edit; ?> required>
                                                        <option value="">Select</option>
                                                        <?php foreach($payment_modes as $payment_mode) { ?>
                                                        <option value="<?php echo $payment_mode['id']; ?>" <?php if(!empty($booked_payment_mode['payment_mode_id'])){ if($booked_payment_mode['payment_mode_id'] == $payment_mode['id']){ echo "selected"; } } ?>><?php echo $payment_mode['name'];?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <label class="form-label">Paymentmode <span style="color: red;">*</span></label>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if($view != true) { ?>
                                        <div class="col-sm-12" align="center">
                                            <input type="submit" class="btn btn-success btn-lg waves-effect" value="SAVE" id="saveButton">
                                        </div>
                                        <?php } ?>
                                    </div>
							    </div>
                            </div>
                        </div>
                    </form>
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
                        <table>
                            <tr><span id="spndeddelid"><b></b></span>&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-info my-3" data-dismiss="modal"> &times;</button></tr>
                        </table>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="validationModal" tabindex="-1" role="dialog" aria-labelledby="validationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="validationModalLabel" style="Text-align:center">Attention here!!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="validationModalBody" style="Text-align:center; font-size: 16px;">
                    <!-- Validation messages will be inserted here -->
                </div>
            </div>
        </div>
    </div>

</section>

<link href="<?php echo base_url(); ?>/assets/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
<!-- jQuery MUST load first, only once, before any plugins -->
<script src="<?php echo base_url(); ?>/assets/plugins/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>
<script src="<?php echo base_url(); ?>/assets/jquery.validate.js"></script>

<!-- Slot Time Picker -->
<script>
    $(document).ready(function() {
        $('.check_time').change(function() {
            $('#time-picker-container').hide();
            
            $('#hour').empty();
            $('#minute').empty();

            if ($('#breakfast').is(':checked')) {
                for (let i = 6; i <= 11; i++) {
                    $('#hour').append(`<option value="${i < 10 ? '0' + i : i}">${i < 10 ? '0' + i : i}</option>`);
                }
                for (let i = 0; i < 60; i += 5) {
                    $('#minute').append(`<option value="${i < 10 ? '0' + i : i}">${i < 10 ? '0' + i : i}</option>`);
                }
                $('#ampm').val('AM');
                $('#time-picker-container').show();
            } else if ($('#lunch').is(':checked')) {
                for (let i = 12; i <= 15; i++) {
                    var time_val = i > 12 ? '0' + (i - 12) : i;
                    $('#hour').append(`<option value="${time_val}">${time_val}</option>`);
                }
                for (let i = 0; i < 60; i += 5) {
                    $('#minute').append(`<option value="${i < 10 ? '0' + i : i}">${i < 10 ? '0' + i : i}</option>`);
                }
                $('#ampm').val('PM');
                $('#time-picker-container').show();
            } else if ($('#dinner').is(':checked')) {
                for (let i = 6; i <= 9; i++) {
                    $('#hour').append(`<option value="${i < 10 ? '0' + i : i}">${i < 10 ? '0' + i : i}</option>`);
                }
                for (let i = 0; i < 60; i += 5) {
                    $('#minute').append(`<option value="${i < 10 ? '0' + i : i}">${i < 10 ? '0' + i : i}</option>`);
                }
                $('#ampm').val('PM');
                $('#time-picker-container').show();
            }
            // REMOVED: selectpicker("refresh") on hour/minute/ampm - they are plain <select>, not selectpicker
        });
    });
</script>

<!-- Add Items and functions -->
<script>
    $(document).ready(function() {
        var min_pax = <?php echo !empty($setting['annathanam_min_pax']) ? intval($setting['annathanam_min_pax']) : (!empty($setting['catering_min_pax']) ? intval($setting['catering_min_pax']) : 1); ?>;
        $.ajax({
            url: '<?php echo base_url(); ?>/catering/get_special_items',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                console.log('special data:', data);
                var $dropdown = $('#special_dropdown');
                $dropdown.empty().append('<option value="">-- Select Service --</option>');

                $.each(data.special, function(typeName, typeData) {
                    var $group = $('<optgroup>', {
                        label: typeName,
                        style: "font-weight: bold"
                    });

                    $.each(typeData.items, function(index, item) {
                        $group.append($('<option>', {
                            value: item.id,
                            text: item.name_eng + ' / ' + item.name_tamil,
                            'data-amount': item.amount,
                            'data-type-id': item.type_id
                        }));
                    });

                    $dropdown.append($group);
                    // NO selectpicker("refresh") inside the loop
                });

                // Refresh ONCE after all optgroups are built
                if ($.fn.selectpicker) {
                    try { $dropdown.selectpicker("refresh"); } catch(e) {}
                }

                var a_html = '';
                if (data.addons.length > 0) {
                    a_html = '<option value="">Select From</option>';
                    data.addons.forEach(function(value, key) {
                        a_html += '<option data-addon="' + value.add_on + '" data-amount="' + value.amount + '" value="' + value.id + '">' + value.name_eng + ' / ' + value.name_tamil + '</option>';
                    });
                } else {
                    a_html = '<option value="">No Addons Found</option>';
                }
                $('#annathanamAddonDropdown').html(a_html);
                if ($.fn.selectpicker) {
                    try { $('#annathanamAddonDropdown').selectpicker("refresh"); } catch(e) {}
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error fetching special items: ' + textStatus);
            }
        });           
        sum_amount();  
    });

    $("#annathanamAddonDropdown").change(function(){
        var addon_value = $("#annathanamAddonDropdown option:selected").data('addon'); 
        if (addon_value == 2) {
            $('.addi_hide').show();
        } else {
            var amount = $("#annathanamAddonDropdown option:selected").data('amount'); 
            $("#get_pack_amt_addon").val(Number(amount).toFixed(2));
        }
    });

    $("#special_dropdown").change(function(){
        var amount = $("#special_dropdown option:selected").data('amount'); 
        $("#get_pack_amt_special").val(Number(amount).toFixed(2));
    });

    $("#no_of_pax").change(function(){
        sum_amount();
    });
</script>

<!-- Add Addon Item -->
<script>
    var cnt = 1;
    $("#add_annathanam_addon").click(function(){
        var validationMessage = '';
        var addon_value = $("#annathanamAddonDropdown option:selected").data('addon'); 
        if (addon_value == 2) {
            validationMessage += 'You have choosen Additional Items, Kindly provide details about the Additional Item below.<br>';
        } else {
            var id = $("#annathanamAddonDropdown option:selected").val();
            var name = $("#annathanamAddonDropdown option:selected").text();
            var amt = $("#annathanamAddonDropdown option:selected").data('amount'); 
            var pack_pax = <?php echo !empty($setting['catering_min_pax']) ? $setting['catering_min_pax'] : 1; ?>;
            
            if (pack_pax != 0) {
                if (id != '' && parseFloat(amt) > 0) {
                    var status_check = 0;
                    var rowId;

                    $(".package_category_addon").each(function() {
                        var arcat = parseInt($(this).val());
                        if (arcat == id) {
                            status_check++;
                            rowId = $(this).closest('tr').attr('id').replace('rmv_packrow_addon', '');
                        }
                    });

                    if (status_check > 0) {
                        var quantity = $("#quantity" + rowId);
                        var currentVal = parseInt(quantity.val());
                        quantity.val(currentVal + 1);
                        updateAmount(rowId);
                        sum_amount();
                        $("#get_pack_amt_addon").val('');
                        $('#annathanamAddonDropdown').prop('selectedIndex', 0);
                        // REMOVED: selectpicker("refresh") - not needed, plain select
                    } else {
                        var countid = id;
                        var serviceid = id;
                        var quantity = 1;
                        var serviceamount = amt;
            
                        var html = '<tr id="rmv_packrow_addon' + countid + '">';
                        html += '<td style="width: 10%; text-align: center;">' + cnt + '</td>';
                        html += '<td style="width: 20%; text-align: center;"><input type="hidden" readonly name="add_on[' + countid + '][id]" value="' + serviceid + '"><input type="text" style="border: none;width: 100%; text-align: center;" readonly id="service_name_addon_' + countid + '" data-amount="' + serviceamount + '"></td>';
                        html += '<td style="width: 20%; text-align: center;">';
                        html += '<div class="itemcountrr" style="display: flex; justify-content: center; align-items: center;">';
                        html += '<div class="value-button" id="decrease" onclick="decreaseValue(' + countid + ')" value="Decrease Value" style="font-weight: bold;font-size: 16px; cursor: pointer; padding: 5px;">-</div>';
                        html += '<input type="number" name="add_on[' + countid + '][quantity]" id="quantity' + countid + '" value="' + pack_pax + '" pattern="[0-9]*" class="qty_amt" style="text-align: center;border: none;border-top: 1px solid #ddd;border-bottom: 1px solid #ddd;margin: 0px;width: 35px;height: 25px;" min="1" onkeyup="qtykeyup(' + countid + ')" />';
                        html += '<div class="value-button" id="increase" onclick="increaseValue(' + countid + ')" value="Increase Value" style="font-weight: bold;font-size: 16px; cursor: pointer; padding: 5px;">+</div></div></td>';
                        html += '<td style="width: 20%; text-align: center;"><input type="text" style="border: none;width: 100%; text-align: center;" class="editable_amt_addon" id="editable_amt_addon_' + countid + '" name="add_on[' + countid + '][amount]" value="' + Number(serviceamount).toFixed(2) + '" onkeyup="editableAmountKeyUp(' + countid + ')"></td>';
                        html += '<td style="width: 25%; text-align: center;"><input type="text" style="border: none;width: 100%; text-align: center;" class="package_amt_addon" id="package_amt_addon_' + countid + '" name="add_on[' + countid + '][total_amount]" value="' + (Number(serviceamount).toFixed(2) * pack_pax).toFixed(2) + '" readonly></td>';
                        html += '<td style="width: 10%; text-align: center;"><a class="btn btn-danger btn-rad" onclick="rmv_pack_addon(' + countid + ')" style="width:auto;padding: 0px 3px !important;"><i class="material-icons">X</i></a><input type="hidden" class="package_category_addon" value=' + id + '></td>';
                        html += '</tr>';
                        $("#annathanam_addon_items_table").append(html);
                        // REMOVED: $('#annathanam_addon_items_table').selectpicker("refresh") - table is NOT a selectpicker element
                        sum_amount();
                        $("#service_name_addon_" + countid).val(name);

                        $("#get_pack_amt_addon").val('');
                        $('#annathanamAddonDropdown').prop('selectedIndex', 0);
                        // REMOVED: $('#annathanamAddonDropdown').selectpicker("refresh") - plain select, not selectpicker
                        updateSerialNumbers();
                        cnt++;
                    }
                }
            } else {
                var validationMessage = '';

                if (!pack_pax || pack_pax <= 0) {
                    validationMessage += 'The number of Pax is invalid, Please ensure it is greater than 0.<br>';
                }
                
                if (id == '' || parseFloat(amt) <= 0) {
                    validationMessage += 'The selected item is invalid. Please select a valid item.<br>';
                }
            }
        }
        if (validationMessage != ''){
            $("#validationModalBody").html(validationMessage);
            // REMOVED: $('#validationModalBody').selectpicker("refresh") - div is NOT a selectpicker element
            $("#validationModal").modal('show');
        }
        
    });

    function increaseValue(cnt) {
        adjustQuantity(cnt, 1);
    }

    function decreaseValue(cnt) {
        adjustQuantity(cnt, -1);
    }

    function adjustQuantity(cnt, adjustment) {
        var quantity = $("#quantity" + cnt);
        var currentVal = parseInt(quantity.val());
        if (!isNaN(currentVal)) {
            var newQuantity = currentVal + adjustment;
            if(newQuantity > parseInt(quantity.attr('max'))) {
                newQuantity = parseInt(quantity.attr('max'));
            } else if (newQuantity < 1) {
                newQuantity = 1;
            }
            quantity.val(newQuantity);
            updateAmount(cnt);
        }
    }

    function qtykeyup(cnt) {
        var quantityInput = $("#quantity" + cnt);
        var val = parseInt(quantityInput.val()) || 0;
        if (val < 1) {
            quantityInput.val(1);
        }
        updateAmount(cnt);
    }

    function editableAmountKeyUp(cnt) {
        var amountInput = $("#editable_amt_addon_" + cnt);
        var val = parseFloat(amountInput.val()) || 0;
        if (val < 0.01) {
            amountInput.val("0.01");
        }
        updateAmount(cnt, true);
    }

    function updateAmount(cnt, fromAmountField = false) {
        var quantity = parseInt($("#quantity" + cnt).val()) || 1;
        if(quantity < 1) {
            quantity = 1;
            $("#quantity" + cnt).val(quantity);
        }
        
        var unitPrice = parseFloat($("#editable_amt_addon_" + cnt).val()) || 0.01;
        if(unitPrice < 0.01) {
            unitPrice = 0.01;
            $("#editable_amt_addon_" + cnt).val(unitPrice.toFixed(2));
        }

        var totalPrice = quantity * unitPrice;
        $("#package_amt_addon_" + cnt).val(Number(totalPrice).toFixed(2));

        if (!fromAmountField) {
            $("#editable_amt_addon_" + cnt).val(unitPrice.toFixed(2));
        }
        sum_amount();
    }

    function rmv_pack_addon(id) {
        $("#rmv_packrow_addon" + id).remove();
        updateSerialNumbers();
        sum_amount();
    }

    function updateSerialNumbers() {
        $(".package_category_addon").each(function(index) {
            var countId = index + 1;
            $(this).closest('tr').find('td:first').text(countId);
        });
    }

    function serviceamount() {
        sum_amount();
    }
</script>

<!-- Add special Item -->
<script>
    var cnt = 1;
    $("#add_special_item").click(function(){
        var selectedOption = $('#special_dropdown option:selected');
        var id = selectedOption.val();
        var name = selectedOption.text();
        var type_name = selectedOption.closest('optgroup').attr('label');
        var type_id = selectedOption.data('type-id'); 
        var amount = parseFloat(selectedOption.data('amount')); 
        var min_pax = <?php echo !empty($setting['catering_min_pax']) ? $setting['catering_min_pax'] : 50; ?>;

        if (id != '' && parseFloat(amount) > 0) {
            var status_check = 0;
            var rowId;

            $(".package_category_special").each(function() {
                var arcat = parseInt($(this).val());
                if (arcat == id) {
                    status_check++;
                    rowId = $(this).closest('tr').attr('id').replace('rmv_packrow_special', '');
                }
            });

            if (status_check > 0) {
                var quantity = $("#special_quantity" + rowId);
                var currentVal = parseInt(quantity.val());
                quantity.val(currentVal + 1);
                updateAmount1(rowId);
                sum_amount();
                $('#special_dropdown').prop('selectedIndex', 0);
                // REMOVED: $('#special_dropdown').selectpicker("refresh") - plain select, not selectpicker
            } else {
                var countid = id;
                var serviceid = id;
                var quantity = min_pax;
                var serviceamount = amount;
    
                var html = '<tr id="rmv_packrow_special' + countid + '">';
                html += '<td style="width: 5%; text-align: center;">' + cnt + '</td>';
                html += '<td style="width: 20%; text-align: center;"><input type="hidden" readonly name="special[' + countid + '][type_id]" value="' + type_id + '"><input type="text" style="border: none;width: 100%; text-align: center;" readonly id="service_type_special_' + countid + '"></td>';
                html += '<td style="width: 25%; text-align: center;"><input type="hidden" readonly name="special[' + countid + '][id]" value="' + serviceid + '"><input type="text" style="border: none;width: 100%; text-align: center;" readonly id="service_name_special_' + countid + '" data-amount="' + serviceamount + '"></td>';
                html += '<td style="width: 15%; text-align: center;"><div class="itemcountrr" style="display: flex; justify-content: center; align-items: center;">';
                html += '<div class="value-button" id="decrease" onclick="decreaseValue1(' + countid + ')" value="Decrease Value" style="font-weight: bold;font-size: 16px; cursor: pointer; padding: 5px;">-</div>';
                html += '<input type="number" name="special[' + countid + '][quantity]" id="special_quantity' + countid + '" value="' + min_pax + '" pattern="[0-9]*" class="qty_amt" style="text-align: center;border: none;border-top: 1px solid #ddd;border-bottom: 1px solid #ddd;margin: 0px;width: 35px;height: 25px;" min="1" onkeyup="qtykeyup1(' + countid + ')" />';
                html += '<div class="value-button" id="increase" onclick="increaseValue1(' + countid + ')" value="Increase Value" style="font-weight: bold;font-size: 16px; cursor: pointer; padding: 5px;">+</div></div></td>';
                html += '<td style="width: 10%; text-align: center;"><input type="text" style="border: none;width: 100%; text-align: center;" class="editable_amt_special" id="editable_amt_special_' + countid + '" name="special[' + countid + '][amount]" value="' + Number(serviceamount).toFixed(2) + '" onkeyup="editableAmountKeyUp1(' + countid + ')"></td>';
                html += '<td style="width: 15%; text-align: center;"><input type="text" style="border: none;width: 100%; text-align: center;" class="package_amt_special" id="package_amt_special_' + countid + '" name="special[' + countid + '][total_amount]" value="' + (Number(serviceamount).toFixed(2) * min_pax).toFixed(2) + '" readonly></td>';
                html += '<td style="width: 10%; text-align: center;"><a class="btn btn-danger btn-rad" onclick="rmv_pack_special(' + countid + ')" style="width:auto;padding: 0px 3px !important;"><i class="material-icons">X</i></a><input type="hidden" class="package_category_special" value=' + id + '></td>';
                html += '</tr>';
                $("#annathanam_special_table").append(html);
                // REMOVED: $('#annathanam_special_table').selectpicker("refresh") - table is NOT a selectpicker element
                sum_amount();

                $("#service_name_special_" + countid).val(name);
                $("#service_type_special_" + countid).val(type_name);
                
                $('#special_dropdown').prop('selectedIndex', 0);
                // REMOVED: $('#special_dropdown').selectpicker("refresh") - plain select, not selectpicker
                $("#get_pack_amt_special").val('');
                updateSerialNumbers1();
                cnt++;
            }   
        }
    });

    function increaseValue1(cnt) {
        adjustQuantity1(cnt, 1);
    }

    function decreaseValue1(cnt) {
        adjustQuantity1(cnt, -1);
    }

    function adjustQuantity1(cnt, adjustment) {
        var quantity = $("#special_quantity" + cnt);
        var currentVal = parseInt(quantity.val());
        if (!isNaN(currentVal)) {
            var newQuantity = currentVal + adjustment;
            if(newQuantity > parseInt(quantity.attr('max'))) {
                newQuantity = parseInt(quantity.attr('max'));
            } else if (newQuantity < 1) {
                newQuantity = 1;
            }
            quantity.val(newQuantity);
            updateAmount1(cnt);
        }
    }

    function qtykeyup1(cnt) {
        var quantityInput = $("#special_quantity" + cnt);
        var val = parseInt(quantityInput.val()) || 0;
        if (val < 1) {
            quantityInput.val(1);
        }
        updateAmount1(cnt);
    }

    function editableAmountKeyUp1(cnt) {
        var amountInput = $("#editable_amt_special_" + cnt);
        var val = parseFloat(amountInput.val()) || 0;
        if (val < 0.01) {
            amountInput.val("0.01");
        }
        updateAmount1(cnt, true);
    }

    function updateAmount1(cnt, fromAmountField = false) {
        var quantity = parseInt($("#special_quantity" + cnt).val()) || 1;
        if(quantity < 1) {
            quantity = 1;
            $("#special_quantity" + cnt).val(quantity);
        }

        var unitPrice = parseFloat($("#editable_amt_special_" + cnt).val()) || 0.01;
        if(unitPrice < 0.01) {
            unitPrice = 0.01;
            $("#editable_amt_special_" + cnt).val(unitPrice.toFixed(2));
        }

        var totalPrice = quantity * unitPrice;
        $("#package_amt_special_" + cnt).val(Number(totalPrice).toFixed(2));
        
        if (!fromAmountField) {
            $("#editable_amt_special_" + cnt).val(Number(unitPrice).toFixed(2));
        }
        sum_amount();
    }

    function rmv_pack_special(id) {
        $("#rmv_packrow_special" + id).remove();
        updateSerialNumbers1();
        sum_amount();
    }

    function updateSerialNumbers1() {
        $(".package_category_special").each(function(index) {
            var countId = index + 1;
            $(this).closest('tr').find('td:first').text(countId);
        });
    }

    function serviceamount() {
        sum_amount();
    }
</script>

<!-- Add Additional Item -->
<script>
    var cnt = 1;
    $("#add_addi_item").click(function(){
        var name = $("#addi_item_name").val();
        var amt = $("#addi_item_amount").val(); 
        var pack_pax = <?php echo !empty($setting['catering_min_pax']) ? $setting['catering_min_pax'] : 1; ?>;

        if (name != '' && parseFloat(amt) > 0) {
            var status_check = 0;
            var rowId;

            $(".package_category_addi").each(function() {
                var arcat = parseInt($(this).val());
                if (arcat == cnt) {
                    status_check++;
                    rowId = $(this).closest('tr').attr('id').replace('rmv_packrow_addi', '');
                }
            });

            if (status_check > 0) {
                var quantity = $("#addi_quantity" + rowId);
                var currentVal = parseInt(quantity.val());
                quantity.val(currentVal + 1);
                updateAmount2(rowId);
                sum_amount();
                $("#get_pack_amt_addi").val('');
                $("#addi_item_name").text('');
            } else {
                var countid = cnt;
                var serviceid = cnt;
                var quantity = 1;
                var serviceamount = amt;
    
                var html = '<tr id="rmv_packrow_addi' + countid + '">';
                html += '<td style="width: 10%; text-align: center;">' + cnt + '</td>';
                html += '<td style="width: 20%; text-align: center;"><input type="text" style="border: none;width: 100%; text-align: center;" readonly id="service_name_addi_' + countid + '" data-amount="' + serviceamount + '" name="addi_item[' + countid + '][name]" value="'+ name +'"></td>';
                html += '<td style="width: 20%; text-align: center;">';
                html += '<div class="itemcountrr" style="display: flex; justify-content: center; align-items: center;">';
                html += '<div class="value-button" id="decrease" onclick="decreaseValue2(' + countid + ')" value="Decrease Value" style="font-weight: bold;font-size: 16px; cursor: pointer; padding: 5px;">-</div>';
                html += '<input type="number" name="addi_item[' + countid + '][quantity]" id="addi_quantity' + countid + '" value="' + pack_pax + '" pattern="[0-9]*" class="qty_amt" style="text-align: center;border: none;border-top: 1px solid #ddd;border-bottom: 1px solid #ddd;margin: 0px;width: 35px;height: 25px;" min="1" onkeyup="qtykeyup2(' + countid + ')" />';
                html += '<div class="value-button" id="increase" onclick="increaseValue2(' + countid + ')" value="Increase Value" style="font-weight: bold;font-size: 16px; cursor: pointer; padding: 5px;">+</div></div></td>';
                html += '<td style="width: 20%; text-align: center;"><input type="text" style="border: none;width: 100%; text-align: center;" class="editable_amt_addi" id="editable_amt_addi_' + countid + '" name="addi_item[' + countid + '][amount]" value="' + Number(serviceamount).toFixed(2) + '" onkeyup="editableAmountKeyUp2(' + countid + ')"></td>';
                html += '<td style="width: 25%; text-align: center;"><input type="text" style="border: none;width: 100%; text-align: center;" class="package_amt_addi" id="package_amt_addi_' + countid + '" name="addi_item[' + countid + '][total_amount]" value="' + (Number(serviceamount).toFixed(2) * pack_pax).toFixed(2) + '" readonly></td>';
                html += '<td style="width: 10%; text-align: center;"><a class="btn btn-danger btn-rad" onclick="rmv_pack_addi2(' + countid + ')" style="width:auto;padding: 0px 3px !important;"><i class="material-icons">X</i></a><input type="hidden" class="package_category_addi" value=' + cnt + '></td>';
                html += '</tr>';
                $("#addi_item_table").append(html);
                // REMOVED: $('#addi_item_table').selectpicker("refresh") - table is NOT a selectpicker element
                sum_amount();
                $("#service_name_addi_" + countid).val(name);

                $("#addi_item_amount").val('');
                $("#addi_item_name").val('');
                updateSerialNumbers2();
                cnt++;
            }
        } else {
            var validationMessage = '';

            if (!pack_pax || pack_pax <= 0) {
                validationMessage += 'The number of Pax is invalid, Please ensure it is greater than 0.<br>';
            }
            
            if (name == '' || parseFloat(amt) <= 0) {
                validationMessage += 'Entered Item or Amount is Invalid.<br>';
            }
            $("#validationModalBody").html(validationMessage);
            // REMOVED: $('#validationModalBody').selectpicker("refresh") - div is NOT a selectpicker element
            $("#validationModal").modal('show');
        }
    });

    function increaseValue2(cnt) {
        adjustQuantity2(cnt, 1);
    }

    function decreaseValue2(cnt) {
        adjustQuantity2(cnt, -1);
    }

    function adjustQuantity2(cnt, adjustment) {
        var quantity = $("#addi_quantity" + cnt);
        var currentVal = parseInt(quantity.val());
        if (!isNaN(currentVal)) {
            var newQuantity = currentVal + adjustment;
            if(newQuantity > parseInt(quantity.attr('max'))) {
                newQuantity = parseInt(quantity.attr('max'));
            } else if (newQuantity < 1) {
                newQuantity = 1;
            }
            quantity.val(newQuantity);
            updateAmount2(cnt);
        }
    }

    function qtykeyup2(cnt) {
        updateAmount2(cnt);
    }

    function editableAmountKeyUp2(cnt) {
        updateAmount2(cnt, true);
    }

    function updateAmount2(cnt, fromAmountField = false) {
        var quantity = parseInt($("#addi_quantity" + cnt).val()) || 0;
        var unitPrice = parseFloat($("#editable_amt_addi_" + cnt).val()) || 0;
        var totalPrice = quantity * unitPrice;
        $("#package_amt_addi_" + cnt).val(Number(totalPrice).toFixed(2));
        
        if (!fromAmountField) {
            $("#editable_amt_addi_" + cnt).val(Number(unitPrice).toFixed(2));
        }
        sum_amount();
    }

    function rmv_pack_addi2(cnt) {
        $("#rmv_packrow_addi" + cnt).remove();
        updateSerialNumbers2();
        sum_amount();
    }

    function updateSerialNumbers2() {
        $(".package_category_addi").each(function(index) {
            var countId = index + 1;
            $(this).closest('tr').find('td:first').text(countId);
        });
    }

    function serviceamount2() {
        sum_amount();
    }
</script>

<!-- Payment type and clear -->
<script>
    $("#clear").click(function(){
        $("input").val("");
    });
    $(document).ready(function(){
        $('.check_time').click(function() {
            $('.check_time').not(this).prop('checked', false);
        });
		$(document).on('change', '.payment_type', function(){
			if(this.value == 'partial'){
				$('.partial_paid_sec').show();
				$('#full_paid_amount').prop('disabled', true);
			}else{
				$('.partial_paid_sec').hide();
				$('#full_paid_amount').prop('disabled', false);
			}
		});
    });
</script>

<!-- Sum amount -->
<script>
    $('#discount_amount').on('blur change', function () {
        sum_amount();
    });

    function sum_amount() {
        var total = 0;

        $(".package_amt_special").each(function () {
            total += parseFloat($(this).val()) || 0;
        });
        
        $(".package_amt_addon").each(function () {
            total += parseFloat($(this).val()) || 0;
        });

        $(".package_amt_addi").each(function () {
            total += parseFloat($(this).val()) || 0;
        });

        var discount_amount = $('#discount_amount').val();
        var max_discount = 0;
        if (discount_amount) {
            discount_amount = Number(discount_amount);
            max_discount = total - 1;
            if (max_discount < 0) max_discount = 0;
            if (discount_amount > max_discount) {
                discount_amount = max_discount;
                $('#discount_amount').val(discount_amount.toFixed(2));
            }
            total = total - discount_amount;
        }

        $("#total_amount").val(Number(total).toFixed(2));
    }
</script>

<!-- Save function -->
<script>
    $(document).ready(function() {
        $('#saveButton').click(function(event) {
            event.preventDefault();

            var errors = [];
            var highlightClass = 'highlight';

            var timeSlots = document.querySelectorAll('.check_time');
            var timeSelected = Array.from(timeSlots).some(slot => slot.checked);
            
            if (!timeSelected) {
                errors.push("Please select any time slot.");
                timeSlots.forEach(slot => slot.classList.add(highlightClass));
            } else {
                timeSlots.forEach(slot => slot.classList.remove(highlightClass));
            }

            var paymentModeSelect = document.getElementById('payment_mode');
            if (!paymentModeSelect || !paymentModeSelect.value) {
                errors.push("Please select a payment mode.");
                if (paymentModeSelect) paymentModeSelect.classList.add(highlightClass);
            } else {
                paymentModeSelect.classList.remove(highlightClass);
            }

            if (errors.length > 0) {
                showValidationModal(errors);
                return; // Stop here, don't proceed with AJAX
            }

            var totalAmount = parseFloat($("#total_amount").val());
            var paidAmount = parseFloat($("#paid_amount").val());

            if (paidAmount > totalAmount) {
                $('#alert-modal').modal('show', { backdrop: 'static' });
                $("#spndeddelid").text("Pay Amount should be less than the Total Amount.");
                return;
            }

            var term_setting = $("#term_setting").val();
            if (term_setting == 1) {
                var checkboxes = document.querySelectorAll('.term-checkbox');
                var allChecked = true;

                checkboxes.forEach(function(checkbox) {
                    if (!checkbox.checked) {
                        allChecked = false;
                    }
                });

                if (!allChecked) {
                    alert('Please check all Terms & Conditions before saving.');
                    return;
                }
            }

            $.ajax({
                url: '<?php echo base_url(); ?>/catering/save_catering',
                type: 'post',
                data: $('#form_validation').serialize(), 
                success: function(response) {
                    console.log("Success response:", response);
                    try {
                        var obj = jQuery.parseJSON(response);
                        if (obj.err) {
                            $('#alert-modal').modal('show', { backdrop: 'static' });
                            $("#spndeddelid").text(obj.err);
                        } else {
                            window.open("<?php echo base_url(); ?>/catering/print_page/" + obj.id);
                            window.location.replace("<?php echo base_url(); ?>/catering");
                        }
                    } catch (e) {
                        console.error("Response parsing error:", e);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX error:", status, error);
                }
            });
        });
    });

    function showValidationModal(messages) {
        var modalBody = document.getElementById('validationModalBody');
        modalBody.innerHTML = messages.join('<br>');
        $('#validationModal').modal('show');
    }
</script>