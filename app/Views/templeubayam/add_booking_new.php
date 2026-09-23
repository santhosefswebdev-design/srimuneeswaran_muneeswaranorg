<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/demo.css">
<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">-->
<style>
    .custom-checkbox {
        position: relative;
        padding-left: 25px;
        cursor: pointer;
        font-size: 16px;
        user-select: none;
    }

    .custom-checkbox input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    .custom-checkbox input:checked~.checkmark {
        background-color: #2196F3;
    }

    .custom-checkbox input:checked~.checkmark:after {
        display: block;
    }

    .custom-checkbox .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 20px;
        width: 20px;
        background-color: #eee;
        border: 1px solid #ddd;
    }

    .custom-checkbox .checkmark:after {
        content: "";
        position: absolute;
        display: none;
        left: 7px;
        top: 3px;
        width: 5px;
        height: 10px;
        border: solid white;
        border-width: 0 3px 3px 0;
        transform: rotate(45deg);
    }

    .itemcountrr .value-button {
        display: inline-block;
        border: 1px solid #ddd;
        margin: 0px;
        width: 25px;
        height: 25px;
        text-align: center;
        vertical-align: middle;
        padding: 0px 0px 8px 0px;
        background: #eee;
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    .itemcountrr .value-button:hover {
        cursor: pointer;
    }

    .itemcountrr #decrease {
        margin-right: 0px;
        border-radius: 4px 0 0 4px;
        margin-top: -2px;
    }

    .itemcountrr #increase {
        margin-left: 0px;
        border-radius: 0 4px 4px 0;
        margin-top: -2px;
    }

    .itemcountrr #input-wrap {
        margin: 0px;
        padding: 0px;
    }

    .itemcountrr input.number {
        text-align: center;
        border: none;
        border-top: 1px solid #ddd;
        border-bottom: 1px solid #ddd;
        margin: 0px;
        width: 35px;
        height: 25px;
    }

    .itemcountrr input[type=number]::-webkit-inner-spin-button,
    .itemcountrr input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .heading {
        text-align: center;
        background: #000;
        color: #FFF;
        padding: 10px;
    }

    .products {
        background: #FFF;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
    }

    .prod {
        background: #CCCCCC;
        padding: 10px 3px;
        margin-top: 10px;
        margin-bottom: 10px;
        cursor: pointer;
    }

    .prod img {
        width: 30%;
        float: left;
        border-right: 1px dashed #999999;
    }

    .prod .detail {
        width: 60%;
        position: relative;
        margin-left: 40%;
    }

    .prod .detail h4,
    .prod .detail h5 {
        font-weight: bold;
    }

    .vl {
        border-left: 2px dashed #999999;
        height: 82%;
        position: absolute;
        left: 38%;
        margin-left: -3px;
        top: 0;
        bottom: 0;
        margin-top: 10px;
    }

    .cart-table {
        width: 100%;
    }

    .cart-table tr th {
        font-weight: normal;
        padding: 10px;
    }

    .cart-table tr td {
        padding: 10px;
        font-size: 12px;
        border: none;
    }

    .row_amt {
        border: none;
        width: 40%;
    }

    .row_qty {
        border: none;
        width: 40%;
    }

    .row_tot {
        border: none;
        width: 60%;
    }

    .detail h5 {
        font-size: 12px;
    }

    form.example input[type=text] {
        padding: 10px;
        font-size: 17px;
        border: 1px solid grey;
        float: left;
        width: 90%;
        background: #f1f1f1;
    }

    form.example button {
        float: left;
        width: 10%;
        padding: 10px;
        background: #000;
        color: white;
        font-size: 17px;
        border: 1px solid grey;
        border-left: none;
        cursor: pointer;
    }

    form.example button:hover {
        background: #333333;
    }

    form.example::after {
        content: "";
        clear: both;
        display: table;
    }

    .form-group {
        margin-bottom: 0;
    }

    .btn-rad {
        padding: 6px !important;
        border-radius: 13% !important;
        width: 23%;
        color: #fff !important;
    }

    .products .smal_marg {
        padding-right: 4px;
        padding-left: 4px;
    }


    .time tr td,
    .time tr th {
        padding: 3px 7px !important;
        border: 1px solid #eee;
    }

    .card .body .col-xs-12,
    .card .body,
    .card .body .col-md-12,
    .card .body .col-lg-12 {
        margin-bottom: 10px !important;
    }

    .card .body .col-xs-8,
    .card .body .col-sm-8,
    .card .body .col-md-8,
    .card .body .col-lg-8 {
        margin-bottom: 10px !important;
    }

    .sub tr th {
        padding: 1px 5px !important;
    }

    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }

    .section {
        margin-bottom: 40px;
    }

    .section h3 {
        margin-bottom: 20px;
    }

    .table-responsive {
        margin-bottom: 60px !important;
    }
</style>
<style>
    /* Styles to center-align table content */
    #selectedPrasadamTable td, #selectedPrasadamTable th, #selectedAnnathanamTable td, #selectedAnnathanamTable th{
        text-align: center;
        vertical-align: middle;
    }
    /* Adjust input width and alignment */
    .qty, .amount-per-pax {
        width: 70px; /* Set a standard width for inputs */
        text-align: center; /* Center text inside input fields */
    }
    /* Button styling adjustments, if needed */
    .delete {
        background-color: red;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 5px;
        cursor: pointer;
    }
    #prasadamTotal, #annathanamTotal {
        font-size: 18px;
        padding-right: 20px; /* Ensure it aligns nicely to the right */
    }

</style>

<section class="content">
    <div class="container-fluid">
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="body">
                        <?php if ($_SESSION['succ'] != '') { ?>
                            <div class="row" style="padding: 0 30%;" id="content_alert">
                                <div class="suc-alert">
                                    <span class="suc-closebtn"
                                        onclick="this.parentElement.style.display='none';">&times;</span>
                                    <p><?php echo $_SESSION['succ']; ?></p>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($_SESSION['fail'] != '') { ?>
                            <div class="row" style="padding: 0 30%;" id="content_alert">
                                <div class="alert">
                                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                                    <p><?php echo $_SESSION['fail']; ?></p>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="container-fluid">
                            <div class="row">
                                <form id="termsForm">
                                    <input type="hidden" id="booking_type" name="booking_type" value="2">
                                    <input type="hidden" id="save_booking" name="save_booking" value="1">
                                    <input type="hidden" name="booking_date" id="date" value="<?php echo date('Y-m-d'); ?>"  >
                                    <div class="col-md-8 det">
                                        <div class="scroll products row">
                                            <div class="col-sm-12">
                                                <h3 style="margin-bottom:5px; margin-top:5px;">Slot Details</h3>
                                            </div>
                                            <div class="col-sm-12">
                                                <table class="table table-bordered ">
                                                    <tbody>
                                                    <?php if(empty($time_list)) { ?>
                                                        <tr>
                                                            <td colspan="5" style="color: red; text-align: center;">Today's slot has been blocked by Management, please choose other dates.</td>
                                                        </tr>
                                                    <?php } else { ?>
                                                        <tr>
                                                            <?php $i = 0; foreach($time_list as $row) { ?>           
                                                            <td>
                                                                <input style="left: 2%; opacity: 1; position: inherit;" type="radio" class="booking_slot" name="booking_slot[]" value="<?php echo $row['id']; ?>">
                                                                <?php echo $row['slot_name']; ?>
                                                            </td>
                                                            <?php } ?>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="scroll products row">
                                            <div class="col-sm-12">
                                                <h3 style="margin-bottom:5px; margin-top:5px;">Package Details</h3>
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
                                                        <input type="number" class="form-control" id="get_pack_amt" placeholder="0.00">
                                                        <label class="form-label">SGD</label>
                                                    </div>
                                                </div>
                                            </div>
                                        
                                            <input type="hidden" id="booking_type" name="booking_type" value="2">
                                            <input type="hidden" id="save_booking" name="save_booking" value="1">
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
                                                        <thead>
                                                            <tr>
                                                                <th width="20%">Name</th>
                                                                <th width="45%">Description</th>
                                                                <th width="25%">Total RM</th>
                                                                <th width="10%">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <input type="hidden" id="pack_row_count" value="0">
                                            </div>
                                        </div>

                                        <div class="section">
                                            <hr style="height: 1px; background: #33333336;">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <h3 style="margin-bottom:5px; margin-top:5px;">Abishegam Details</h3>
                                                    <label>Do you wish to add Abishegam for Ubayam?</label>
                                                    <label><input type="radio" style="left: 2%; opacity: 1;position: inherit;" name="abishegam" value="yes" onclick="toggleAbishegamSelection(true)"> Yes</label>
                                                    <label><input type="radio" style="left: 2%; opacity: 1;position: inherit;" name="abishegam" value="no" onclick="toggleAbishegamSelection(false)"> No</label>                
                                                </div>
                                            </div>

                                            <div id="abishegamSelection" style="display:none;">
                                                <div class="col-sm-6">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <select class="form-control" id="abishegamDropdown" onchange="addAbishegamToTable()">      
                                                                <option value="">Select Deity</option>
                                                                <?php foreach ($abishegam_deities as $row) { ?>
                                                                    <option value="<?php echo $row['id']; ?>" data-amount="<?php echo $row['abishegam_amount']; ?>">
                                                                        <?php echo $row['name_eng'] . ' / ' . $row['name_tamil']; ?>
                                                                    </option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Table to display selected deities -->
                                                <div class="table-responsive col-sm-12" style="margin-bottom: 40px">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th width="10%">S.no</th>
                                                                <th width="35%">Deity Name</th>
                                                                <th width="35%">Amount (SGD)</th>
                                                                <th width="20%">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="selectedAbishegamTable">
                                                        </tbody>
                                                    </table>
                                                    <div style="text-align: right; margin-top: 10px;">
                                                        <strong>Abishegam Total: <span id="abishegamTotal">0.00</span></strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" id="abishegam_details" name="abishegam_details">
                                        </div><br><br>






                                        <div class="section">
                                            <hr style="height: 1px; background: #33333336;">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <h3 style="margin-bottom:5px; margin-top:5px;">Homam Details</h3>
                                                    <label>Do you wish to add Homam for Ubayam?</label>
                                                    <label><input type="radio"
                                                            style="left: 2%; opacity: 1;position: inherit;"
                                                            name="homam" value="yes"
                                                            onclick="toggleHomamSelection(true)"> Yes</label>
                                                    <label><input type="radio"
                                                            style="left: 2%; opacity: 1;position: inherit;"
                                                            name="homam" value="no"
                                                            onclick="toggleHomamSelection(false)"> No</label>
                                                </div>
                                            </div>

                                            <div id="homamSelection" style="display:none;">
                                                <div class="col-sm-6">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <select class="form-control" id="homamDropdown" onchange="addHomamToTable()">
                                                                <option value="">Select deity</option>
                                                                <?php foreach ($homam_deities as $row) { ?>
                                                                    <option value="<?php echo $row['id']; ?>" data-amount="<?php echo $row['homam_amount']; ?>">
                                                                        <?php echo $row['name_eng'] . ' / ' . $row['name_tamil']; ?>
                                                                    </option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Table to display selected deities -->
                                                <div class="table-responsive col-sm-12" style="margin-bottom: 40px">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th width="10%">S.no</th>
                                                                <th width="35%">Deity Name</th>
                                                                <th width="35%">Amount (SGD)</th>
                                                                <th width="20%">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="selectedHomamTable">
                                                        </tbody>
                                                    </table>
                                                    <div style="text-align: right; margin-top: 10px;">
                                                        <strong>Hoamam Total: <span id="homamTotal">0.00</span></strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" id="homam_details" name="homam_details">
                                        </div><br><br>
                                    </div>

                                    <div class="col-md-4 det">

                                        <div class="cart">
                                            <h3 style="margin-top:0px;">Register Details</h3>
                                            <!-- <form action="" method="post"></form> -->
                                                <div class="row" style="margin-top: 25px;">
                                                    <div class="col-sm-12">
                                                        <div class="form-group form-float">
                                                            <div class="form-line">
                                                                <input type="date" class="form-control reg_det"
                                                                    id="event_date" name="ubhayam_date"
                                                                    value="<?= $date; ?>" required readonly>
                                                                <label class="form-label">Event Date <span
                                                                        style="color: red;">*</span></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group form-float">
                                                            <div class="form-line">
                                                                <input type="text" class="form-control reg_det" name="name"
                                                                    id="name" value="" required>
                                                                <label class="form-label">Name <span
                                                                        style="color: red;">*</span></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group form-float">
                                                            <div class="form-line">
                                                                <input type="text" class="form-control reg_det"
                                                                    name="address" value="">
                                                                <label class="form-label">Address</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="row">
                                                            <div class="col-md-4" style="margin: 0px;">
                                                                <div class="form-group form-float">
                                                                    <div class="form-line">
                                                                        <select class="form-control" name="mobile_code"
                                                                            id="phonecode">
                                                                            <?php
                                                                            if (!empty($phone_codes)) {
                                                                                foreach ($phone_codes as $phone_code) {
                                                                                    ?>
                                                                                    <option
                                                                                        value="<?php echo $phone_code['dailing_code']; ?>"
                                                                                        <?php if ($phone_code['dailing_code'] == "+65") {
                                                                                            echo "selected";
                                                                                        } ?>>
                                                                                        <?php echo $phone_code['dailing_code']; ?>
                                                                                    </option>
                                                                                    <?php
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8" style="margin: 0px;">
                                                                <div class="form-group form-float">
                                                                    <div class="form-line">
                                                                        <input class="form-control reg_det" type="number"
                                                                            min="0" name="mobile_no" id="mobile" required
                                                                            pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}"
                                                                            autocomplete="off">
                                                                        <label class="form-label">Mobile Number <span
                                                                                style="color: red;">*</span></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label class="form-label" for="rasi_id">Rasi <span style="color:red;"></span></label>
                                                                <select class="form-control" name="rasi_id" id="rasi_id">
                                                                    <option value="">Select Rasi</option>
                                                                    <?php //foreach ($rasi as $row) { ?>
                                                                        <option value="<?php //echo $row['id']; ?>">
                                                                            <?php //echo $row['name_eng']; ?>
                                                                        </option>
                                                                    <?php //} ?>
                                                                </select>
                                                            <span id="error_msg"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label class="form-label" for="natchathra_id">Natchathram <span style="color:red;"></span></label>		
                                                            <input type="hidden" id="natchathram_id" name="natchathram_id" class="form-control">
                                                            <select class="form-control" name="natchathra_id" id="natchathra_id">
                                                                <option value="">Select Natchiram</option>
                                                            </select>
                                                            <span id="error_msg"></span>
                                                        </div>
                                                    </div> -->
                                                    <div class="col-sm-12">
                                                        <div class="form-group form-float">
                                                            <div class="form-line">
                                                                <input type="text" class="form-control reg_det" name="email"
                                                                    value="">
                                                                <label class="form-label">Email ID [optional]</label>
                                                            </div>
                                                        </div>
                                                    </div>
                        
                                                    <div class="col-sm-12">
                                                        <div class="form-group form-float">
                                                            <div class="form-line">
                                                                <textarea class="form-control" id="description"
                                                                    name="description" style="width:100%;"
                                                                    autocomplete="off"></textarea>
                                                                <label class="form-label">Remarks</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 scroll"
                                                        style="overflow-y:scroll; overflow-x:hidden; height: 100px;">
                                                        <div id="commission_append_input_box"></div>
                                                    </div>
                                                    <div class="col-sm-3 col-md-3 col-xs-3">
                                                        <div class="form-group">
                                                            <div class="form-line" style="border: none;">
                                                                <a class="btn btn-info" onclick="history.go(-1)"
                                                                    style="color: #fff;">Back</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3 col-md-3 col-xs-3">
                                                        <div class="form-group">
                                                            <div class="form-line" style="border: none;">
                                                                <!-- <button class="btn btn-primary" id="clear">Clear</button> -->
                                                                <a class="btn btn-danger" id="clear"
                                                                    style="color: #fff;">Clear</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3 col-md-3 col-xs-3">
                                                        <div class="form-group">
                                                            <div class="form-line" style="border: none;">
                                                                <input type="checkbox" checked="checked" id="print"
                                                                    name="print" value="Print">
                                                                <label for='print'> Print &nbsp;&nbsp; </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3 col-md-3 col-xs-3">
                                                        <div class="form-group">
                                                            <div class="form-line" style="border: none; text-align: right;">
                                                                <label class="btn btn-success btn-lg"
                                                                    id="submit">Save</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            
                                        </div>
                                    </div>

                                    <div class="col-md-12 det">
                                        <hr style="height: 1px; background: #33333336;">
                                        <div class="section">
                                            <div class="scroll products row">
                                                <div class="col-sm-12">
                                                    <h3 style="margin-bottom:5px; margin-top:5px;">Prasadam Details</h3>
                                                </div>
                                                <div class="col-sm-1" style="display: none">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <label for="prasadam_group_select" class="form-label">Select Prasadam Group:</label>
                                                            <select id="prasadam_group_select" name="prasadam_group_select" class="form-control">
                                                                <?php foreach ($prasadam_groups as $index => $group): ?>
                                                                    <option value="<?php echo $group['id']; ?>" <?php echo $index === 1 ? 'selected' : ''; ?>>
                                                                        <?php echo $group['group_name']; ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <label for="prasadam_details_select" class="form-label">Prasadam Details:</label>
                                                            <select id="prasadam_details_select" name="prasadam_details_select" class="form-control">
                                                                <option value="" disabled selected>Select Prasadam Details</option>
                                                                <!-- Options will be added here dynamically -->
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-1 ">
                                                    <div class="form-group form-float">
                                                        <div class="form-line" style="border: none;">
                                                            <label id="prasadam_add" class="btn btn-success"
                                                                style="padding: 5px 12px !important;">Add</label>
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

                                            <div class="row scroll"
                                                style="overflow-y:scroll; overflow-x:hidden; height: 200px;">
                                                <div class="col-sm-12">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered" style="width:100%"
                                                                style="height: 150px;" id="selectedPrasadamTable">
                                                            <thead>
                                                                <tr>
                                                                    <th width="5%">S.No</th>
                                                                    <th width="10%">Prasadam Group</th>
                                                                    <th width="30%">Prasadam Name</th>
                                                                    <!-- <th width="26%">Deity Name</th> -->
                                                                    <th width="11%">Qty</th>
                                                                    <th width="13%">Amount</th>
                                                                    <th width="15%">Total SGD</th>
                                                                    <th width="11%">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                        </table>
                                                        <input type="hidden" id="prasadamTotal" name="prasadamTotal">
                                                        <div style="text-align: right; margin-top: 10px;">
                                                            <strong>Prasadam Total: <span id="prasadamTotalDisplay">0.00</span></strong>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" id="prasadam_details" name="prasadam_details">
                                                </div>
                                            </div>
                                        </div>
                        



                                        <div class="section">
                                            <hr style="height: 1px; background: #33333336;">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <h3 style="margin-bottom:5px; margin-top:5px;">Annathanam Details
                                                    </h3>
                                                    <label>Do you wish to add Annathanam for Ubayam?</label>
                                                    <label><input type="radio"
                                                            style="left: 2%; opacity: 1;position: inherit;"
                                                            name="annathanam" value="yes"
                                                            onclick="toggleAnnathanamSelection(true)"> Yes</label>
                                                    <label><input type="radio"
                                                            style="left: 2%; opacity: 1;position: inherit;"
                                                            name="annathanam" value="no"
                                                            onclick="toggleAnnathanamSelection(false)"> No</label>
                                                </div>
                                            </div>

                                            <div id="annathanamSelection" style="display:none;">
                                                <div class="row">
                                                    <div class="col-sm-5">
                                                        <div class="form-group form-float">
                                                            <div class="form-line">
                                                                <select class="form-control" name="annathanam_package_select" id="annathanam_package_select">
                                                                    <option value="">Select Annathanam Types</option>
                                                                    <?php foreach ($annathanam_packages as $row) { ?>
                                                                    <option value="<?php echo $row['id']; ?>" data-amount="<?php echo $row['amount']; ?>">
                                                                        <?php echo $row['name_eng'] . ' / ' . $row['name_tamil']; ?>
                                                                    </option>
                                                                <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-1">
                                                        <div class="form-group form-float">
                                                            <div class="form-line" style="border: none;">
                                                                <label id="annathanam_add" class="btn btn-success"
                                                                    style="padding: 5px 12px !important;">Add</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label">Select Slot <span style="color: red;">*</span></label>
                                                        <div class="form-group form-float">
                                                            <input  type="checkbox" id="breakfast1" name="time1" value="Breakfast" class="check_time1" >
                                                            <label for ='breakfast1'> Breakfast &nbsp;&nbsp; </label>
                                                            <input  type="checkbox" id="lunch1" name="time1" value="Lunch" class="check_time1" >
                                                            <label for ='lunch1'> Lunch &nbsp;&nbsp; </label>
                                                            <input  type="checkbox" id="dinner1" name="time1" value="Dinner" class="check_time1" >
                                                            <label for ='dinner1'> Dinner &nbsp;&nbsp; </label>
                                                        </div>  
                                                    </div>
                                                    <div class="col-md-3" id="time-picker-container1">
                                                        <div class="form-group form-float">                                      
                                                            <label for="hour">Select Time </label>
                                                            <div style="display: flex; gap: 10px;">
                                                                <select id="hour1" name="hour1" class="form-control" style="display:inline-block;"> 
                                                                    <option value="">Hour</option>
                                                                </select>
                                                                :
                                                                <select id="minute1" name="minute1" class="form-control" style="display:inline-block;">
                                                                    <option value="">Minute</option>
                                                                </select>
                                                                <select id="ampm1" name="ampm1" class="form-control" style="display:inline-block;" disabled>
                                                                    <option value="AM">AM</option>
                                                                    <option value="PM">PM</option>
                                                                </select>
                                                            </div>                                            
                                                        </div>
                                                    </div>

                                                    <div class="table-responsive col-sm-12" style="margin-bottom: 40px">
                                                        <table class="table table-bordered" id="selectedAnnathanamTable">
                                                            <thead>
                                                                <tr>
                                                                    <th width="5%">S.no</th>
                                                                    <th width="20%">Package Names</th>
                                                                    <th width="24%">Description(items)</th>
                                                                    <th width="7%">Qty</th>
                                                                    <th width="6%">Amount</th>
                                                                    <th width="8%">Total</th>
                                                                    <th width="5%">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <input type="hidden" id="annathanam_details" name="annathanam_details">
                                                </div><br><br>

                                                <div class="row">
                                                    <div class="col-sm-5">
                                                        <div class="form-group form-float">
                                                            <div class="form-line focused">
                                                                <select class="form-control" id="annathanam_addon_select">
                                                                    <option value="">Select addon</option>
                                                                    
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="form-group form-float">
                                                            <div class="form-line" style="border: none;">
                                                                <label id="addon_add" class="btn btn-success"
                                                                    style="padding: 5px 12px !important;">Add</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="table-responsive col-sm-12" style="margin-bottom: 40px">
                                                        <table class="table table-bordered" id="selectedAddonTable">
                                                            <thead>
                                                                <tr>
                                                                    <th width="10%">S.no</th>
                                                                    <th width="40%">Addon</th>
                                                                    <th width="10%">Qty</th>
                                                                    <th width="10%">Amount</th>
                                                                    <th width="15%">Total</th>
                                                                    <th width="15%">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                        </table>
                                                        <div style="text-align: right; margin-top: 10px;">
                                                            <strong>Annathanam Total: <span id="annathanamDisplayTotal">0.00</span></strong>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" id="annathanamTotal" name="annathanamTotal">
                                                <input type="hidden" id="annathanam_addon_details" name="annathanam_addon_details">
                                            </div>
                                        </div>



                                        <div class="scroll products row">
                                            <hr style="height: 1px; background: #33333336;">
                                            <div class="col-sm-12">
                                                <h3 style="margin-bottom:5px; margin-top:5px;">Add-on Services</h3>
                                            </div>
                                            <div class="col-sm-6 ">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <!--<label class="form-lable">Package Name</label>-->
                                                        <select class="form-control" id="add_one_addon">
                                                            <option value="">Select From</option> 
                                                            <?php foreach($package_addon as $row) { ?>
                                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3 ">
                                                <div class="form-group form-float">
                                                
                                                    <div class="form-line focused">
                                                        <input type="hidden" id="pack_name_addon">
                                                        <input type="number" class="form-control" id="get_pack_amt_addon" placeholder="0.00">
                                                        <label class="form-label">SGD</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3 ">
                                                <div class="form-group form-float">
                                                    <div class="form-line" style="border: none;">
                                                        <label id="pack_add_addon" class="btn btn-success" style="padding: 5px 12px !important;">Add</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row scroll" style="overflow-y:scroll; overflow-x:hidden; height: 200px;">
                                            <div class="col-sm-12">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" style="width:100%" id="package_table_addon" style="height: 150px;">
                                                        <thead>
                                                            <tr>
                                                                <th width="20%">Name</th>
                                                                <th width="30%">Description</th>
                                                                <th width="20%">Qty</th>
                                                                <th width="20%">Total</th>
                                                                <th width="10%">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <input type="hidden" id="pack_row_count_addon" value="0">
                                            </div>
                                        </div>

                                        <div class="scroll products extra-charges row">
                                            <hr style="height: 1px; background: #33333336;">
                                            <div class="col-sm-12">
                                                <h3 style="margin-bottom:5px; margin-top:5px;">Additional Charges</h3>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <input type="text" id="extra_desc" class="form-control" placeholder="Description">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <input type="number" id="extra_amount" class="form-control" placeholder="Amount">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group form-float">
                                                    <label id="add_extra_charge" class="btn btn-success" style="padding: 5px 12px !important;">Add</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row scroll" style="overflow-y:scroll; overflow-x:hidden; height: 200px;">
                                            <div class="col-sm-12">
                                                <div class="table-responsive">
                                                    <table id="extra_charges_table" class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Description</th>
                                                                <th>Amount(S$)</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <!-- Dynamically added rows will appear here -->
                                                        </tbody>
                                                        <input type="hidden" name="extra_charges" id="extra_charges" value="0">
                                                    </table>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="products row">
                                            <div class="col-sm-12">
                                                <h3 style="margin-bottom: 5px; margin-top: 5px;">Pay Details</h3>
                                                <label>
                                                    <input style="left: 2%; opacity: 1;position: inherit;" type="radio"
                                                        name="payment_type" value="full" checked
                                                        onclick="togglePayDetails()"> Full
                                                </label>
                                                <label>
                                                    <input style="left: 2%; opacity: 1;position: inherit;" type="radio" name="payment_type" value="partial" onclick="togglePayDetails()"> Partial
                                                </label> 
                                                <label>
                                                    <input style="left: 2%; opacity: 1;position: inherit;" type="radio" name="payment_type" value="only_booking" onclick="togglePayDetails()"> Only Booking
                                                </label> 
                                            </div>
                                            <div class="col-sm-4 partial-payment-details">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <input type="date" class="form-control" id="pay_date"
                                                            value="<?php echo date('Y-m-d'); ?>">
                                                        <label class="form-label">Pay Date</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3 partial-payment-details">
                                                <div class="form-group form-float">
                                                    <div class="form-line focused">
                                                        <input type="number" id="pay_amt" min="0" class="form-control"
                                                            step=".01" placeholder="0.00">
                                                        <label class="form-label">Amount</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 only-booking">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <select class="form-control" name="payment_mode"
                                                            id="paymentmode">
                                                            <!--option value="0">Select</option-->
                                                            <?php foreach ($payment_modes as $payment_mode) { ?>
                                                                <option value="<?php echo $payment_mode['id']; ?>">
                                                                    <?php echo $payment_mode['name']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <label class="form-label">Payment Mode</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-2 partial-payment-details">
                                                <div class="form-group form-float">
                                                    <div class="form-line" style="border: none;">
                                                        <label id="pay_add" class="btn btn-success"
                                                            style="padding: 5px 12px !important;">Add</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row scroll partial-payment-details"
                                            style="overflow-y:scroll; overflow-x:hidden; height: 200px;">
                                            <div class="col-sm-12">
                                                <div class="table-responsive">
                                                    <table style="width:100%" class="table table-bordered" id="pay_table" style="height: 150px;">
                                                        <thead>
                                                            <tr>
                                                                <th width="25%">Date</th>
                                                                <th width="25%">Total SGD</th>
                                                                <th style="width: 30%!important;">Payment Mode</th>
                                                                <th width="15%">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <input type="hidden" id="pay_row_count" value="1">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <input type="text" id="total_amt" class="form-control" readonly
                                                            name="total_amt" value=0>
                                                        <label class="form-label">Total Amount</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group form-float">
                                                    <div class="form-line focused">
                                                        <input type="number" id="discount_amount" name="discount_amount"
                                                            min="0" class="form-control" value="0" step=".01"
                                                            placeholder="0.00">
                                                        <label class="form-label">Discount Amount</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3 partial-payment-details">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <input type="text" id="deposite_amt" class="form-control"
                                                            readonly name="deposie_amt" value="0">
                                                        <label class="form-label">Deposite SGD</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3 partial-payment-details">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <input type="text" id="balance" class="form-control" readonly
                                                            name="balance" value="0">
                                                        <label class="form-label">Balance SGD</label>
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
         </div>
    </div>
    <div id="alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content" style="width: 127%;">
                <div class="modal-body p-4">
                    <div class="text-center">
                        <i class="dripicons-information h1 text-info"></i>
                        <table>
                            <tr><span id="spndeddelid"><b></b></span>&nbsp;&nbsp;&nbsp;<button type="button"
                                    class="btn btn-info my-3" data-dismiss="modal"> &times;</button></tr>
                        </table>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div>
    </div>
</section>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<script>
    $(document).ready(function() {
        $('.check_time').change(function() {
            $('#time-picker-container').hide();
            
            $('#hour').empty();
            $('#minute').empty();

            if ($('#breakfast').is(':checked')) {
                for (let i = 6; i <= 11; i++) {
                    $('#hour').append(`<option value="${i < 10 ? '0' + i : i}">${i < 10 ? '0' + i : i}</option>`); // Format hour with leading zero
                }
                for (let i = 0; i < 60; i += 5) {
                    $('#minute').append(`<option value="${i < 10 ? '0' + i : i}">${i < 10 ? '0' + i : i}</option>`); // Format minute with leading zero
                }
                $('#ampm').val('AM');
                $('#time-picker-container').show();  // Show the time picker container
            } else if ($('#lunch').is(':checked')) {

                for (let i = 12; i <= 15; i++) {
                    var time_val = i > 12 ? '0' + (i - 12) : i;
                    $('#hour').append(`<option value="${time_val}">${time_val}</option>`); // 12-hour format
                }
                for (let i = 0; i < 60; i += 5) {
                    $('#minute').append(`<option value="${i < 10 ? '0' + i : i}">${i < 10 ? '0' + i : i}</option>`); // Format minute with leading zero
                }
                $('#ampm').val('PM');
                $('#time-picker-container').show();  // Show the time picker container
            } else if ($('#dinner').is(':checked')) {
                
                for (let i = 6; i <= 9; i++) {
                    $('#hour').append(`<option value="${i < 10 ? '0' + i : i}">${i < 10 ? '0' + i : i}</option>`);// 12-hour format
                }
                for (let i = 0; i < 60; i += 5) {
                    $('#minute').append(`<option value="${i < 10 ? '0' + i : i}">${i < 10 ? '0' + i : i}</option>`); // Format minute with leading zero
                }
                $('#ampm').val('PM');
                $('#time-picker-container').show();  // Show the time picker container
            }
            $("#hour").selectpicker("refresh");
            $("#minute").selectpicker("refresh");
            $("#ampm").selectpicker("refresh");
        });
        $('.check_time').click(function() {
            $('.check_time').not(this).prop('checked', false);
        });
    });

    $(document).ready(function() {
        $('.check_time1').change(function() {
            $('#time-picker-container1').hide();
            
            $('#hour1').empty();
            $('#minute1').empty();

            if ($('#breakfast1').is(':checked')) {
                for (let i = 6; i <= 11; i++) {
                    $('#hour1').append(`<option value="${i < 10 ? '0' + i : i}">${i < 10 ? '0' + i : i}</option>`); // Format hour with leading zero
                }
                for (let i = 0; i < 60; i += 5) {
                    $('#minute1').append(`<option value="${i < 10 ? '0' + i : i}">${i < 10 ? '0' + i : i}</option>`); // Format minute with leading zero
                }
                $('#ampm1').val('AM');
                $('#time-picker-container1').show();  // Show the time picker container
            } else if ($('#lunch1').is(':checked')) {

                for (let i = 12; i <= 15; i++) {
                    var time_val = i > 12 ? '0' + (i - 12) : i;
                    $('#hour1').append(`<option value="${time_val}">${time_val}</option>`); // 12-hour format
                }
                for (let i = 0; i < 60; i += 5) {
                    $('#minute1').append(`<option value="${i < 10 ? '0' + i : i}">${i < 10 ? '0' + i : i}</option>`); // Format minute with leading zero
                }
                $('#ampm1').val('PM');
                $('#time-picker-container1').show();  // Show the time picker container
            } else if ($('#dinner1').is(':checked')) {
                
                for (let i = 6; i <= 9; i++) {
                    $('#hour1').append(`<option value="${i < 10 ? '0' + i : i}">${i < 10 ? '0' + i : i}</option>`);// 12-hour format
                }
                for (let i = 0; i < 60; i += 5) {
                    $('#minute1').append(`<option value="${i < 10 ? '0' + i : i}">${i < 10 ? '0' + i : i}</option>`); // Format minute with leading zero
                }
                $('#ampm1').val('PM');
                $('#time-picker-container1').show();  // Show the time picker container
            }
            $("#hour1").selectpicker("refresh");
            $("#minute1").selectpicker("refresh");
            $("#ampm1").selectpicker("refresh");
        });
        $('.check_time1').click(function() {
            $('.check_time1').not(this).prop('checked', false);
        });
    });
</script>

<script>
    $(document).ready(function() {
        if ($('#empty-list').length > 0) {
            $('#alert-modal').modal('show');
        }
    });

    $(document).ready(function() {
        $('#add_extra_charge').click(function() {
            var desc = $('#extra_desc').val().trim();
            var amount = $('#extra_amount').val().trim();
            if (desc === '') {
                alert('Provide a description to add extra charges.');
                return; // Stop the function if no description is given
            }
            if (amount === '' || isNaN(parseFloat(amount))) {
                alert('Please enter a valid amount.');
                return; // Stop the function if no amount is given or it's not valid
            }
            $('#extra_charges_table tbody').append(
                `<tr>
                    <td>${desc}</td>
                    <td>${amount}</td>
                    <td><button class="delete_charge btn btn-danger" style="cursor: pointer;"><i class="material-icons">X</i></button></td>
                </tr>`
            );
            
            $('#extra_desc').val('');
            $('#extra_amount').val('');
            updateExtraChargesData();
        });

        $('#extra_charges_table').on('click', '.delete_charge', function() {
            $(this).closest('tr').remove();
            updateExtraChargesData();
        });

        function updateExtraChargesData() {
            var extraCharges = [];
            $("#extra_charges_table tbody tr").each(function(index) {
                var description = $(this).find('td:eq(0)').text();
                var amount = $(this).find('td:eq(1)').text();
                extraCharges.push({ description: description, amount: amount });
            });

            $('#extra_charges').val(JSON.stringify(extraCharges));
            sum_amount();
        }
    });
</script>

<script>
$(document).ready(function() {
    $('#rasi_id').change(function() {
        var rasiId = $(this).val();  // Get the selected rasi id

        if (rasiId != "") {
            $.ajax({
                url: '<?php echo base_url(); ?>/templeubayam/get_natchathram',
                type: 'post',
                data: { rasi_id: rasiId },
                dataType: 'json',
                success: function(response) {
                    console.log('natchathiram:', response);
                    var natchathramDropdown = $('#natchathra_id');
                    natchathramDropdown.empty();  // Clear existing options
                    natchathramDropdown.append('<option value="">Select Natchathiram</option>');

                    if (response.natchathra_id) {
                        $.each(response.natchathra_id.split(','), function(key, value) {
                            $.ajax({
                                url: '<?php echo base_url(); ?>/templeubayam/get_natchathram_name',
                                type: 'post',
                                data: { id: value },
                                dataType: 'json',
                                success: function(natchathraResponse) {
                                    console.log('natchathiram name:', natchathraResponse);
                                    natchathramDropdown.append('<option value="' + natchathraResponse.id + '">' + natchathraResponse.name_eng + '</option>');
                                },
                                complete: function() {
                                    natchathramDropdown.selectpicker('refresh');
                                }
                            });
                        });
                    } else {
                        natchathramDropdown.selectpicker('refresh');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                }
            });
        } else {
            $('#natchathra_id').empty().append('<option value="">Select Natchathiram</option>');
            $('#natchathra_id').selectpicker('refresh');  // Refresh selectpicker when clearing
        }
    });
});

</script>

<script>
    function toggleAnnathanamSelection(show) {
        document.getElementById('annathanamSelection').style.display = show ? 'block' : 'none';
    }

    $(document).ready(function() {
    $('#annathanam_package_select').change(function() {
        var selectedOption = $(this).find('option:selected');
        var packageId = selectedOption.val();

        if (packageId) {
            $.ajax({
                url: '<?php echo base_url(); ?>/templeubayam/getAddonsForPackage',
                type: 'POST',
                data: { annathanam_package_id: packageId },
                dataType: 'json',
                success: function(response) {
                    // Assuming the response has two keys: 'items' and 'addons'
                    populateAddons(response.addons);
                    console.log('addons:', response.addons);
                    updateDescription(response.items);
                    console.log('items:', response.items);
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching details: " + error);
                }
            });
        } else {
            // Reset the dropdown if no package is selected
            $('#annathanam_addon_select').empty().append('<option value="">Select addon</option>');
        }
    });

    var globalItemsDescription = "";
    $('#annathanam_add').click(function() {
        if ($('#selectedAnnathanamTable tbody tr').length > 0) {
            alert("Only one package can be added at a time.");
            return;
        }

        var packageDetails = $('#annathanam_package_select option:selected').text();
        var packageId = $('#annathanam_package_select option:selected').val();  // Get package ID
        var itemsDescription = globalItemsDescription; // Stored response from earlier fetch
        var amountPerPax = $('#annathanam_package_select option:selected').data('amount');
        var qty = 50; // Default quantity

        var total = amountPerPax * qty;
        var rowCount = $('#selectedAnnathanamTable tbody tr').length + 1;
        //console.log("Items Description:", itemsDescription);

        var newRow = `<tr data-package-id="${packageId}">
                        <td>${rowCount}</td>
                        <td>${packageDetails}</td>
                        <td>${itemsDescription}</td>
                        <td><input type='number' class='form-control qty' value='${qty}'></td>
                        <td><input type='number' class='form-control amount' value='${amountPerPax}'></td>
                        <td class='total'>${total.toFixed(2)}</td>
                        <td><button class='btn btn-danger delete'>Remove</button></td>
                    </tr>`;
        $('#selectedAnnathanamTable tbody').append(newRow);
        //console.log("New Row:", newRow);

        $('.qty').last().on('input', function() {
            var updatedQty = $(this).val();
            $('#selectedAddonTable .qty').each(function() {
                $(this).val(updatedQty);  // Update each addon quantity
            });
        });
        updateAnnathanamTotal();
    });

    function populateAddons(addons) {
        var addonSelect = $('#annathanam_addon_select');
        addonSelect.empty().append('<option value="">Select addon</option>');
        $.each(addons, function(index, addon) {
            var option = $('<option></option>')
                .val(addon.id)
                .text(addon.name_eng + ' / ' + addon.name_tamil)
                .data('amount', addon.amount);  // Make sure this is set correctly
            addonSelect.append(option);
        });
        // Refresh the select picker if you are using a UI framework that requires it
        addonSelect.selectpicker('refresh');
    }

    function updateDescription(items) {
        var descriptions = items.map(function(item) {
            return item.name_eng + ' / ' + item.name_tamil;
        }).join(", ");
        
        //console.log("Formatted Descriptions:", descriptions); // Log the descriptions to console
        globalItemsDescription = descriptions; // Store it in a hidden input for later use
    }


        $(document).on('click', '.delete', function() {
            $(this).closest('tr').remove();
        });

        $('#addon_add').click(function() {
            var packageQty = $('#selectedAnnathanamTable .qty').val();  // Get the current package quantity
            var addonDetails = $('#annathanam_addon_select option:selected').text();
            var addonId = $('#annathanam_addon_select option:selected').val(); // Get add-on ID
            console.log('deity_id:', addonId);
            var amountPerPax = $('#annathanam_addon_select option:selected').data('amount');
            var qty = packageQty || 1;  // Default to 1 if no package is present (optional safety check)

            var total = parseFloat(amountPerPax) * qty;
            var rowCount = $('#selectedAddonTable tbody tr').length + 1;

            var newRow = `<tr data-addon-id="${addonId}">
                            <td>${rowCount}</td>
                            <td>${addonDetails}</td>
                            <td><input type='number' class='form-control qty' value='${qty}' min='1'></td>
                            <td><input type='number' class='form-control amount' value='${amountPerPax}' readonly></td>
                            <td class='total'>${total.toFixed(2)}</td>
                            <td><button class='btn btn-danger delete'>Remove</button></td>
                        </tr>`;
            $('#selectedAddonTable tbody').append(newRow);
            updateAnnathanamDetails();
            updateAnnathanamTotal();  // Update totals accordingly
        });



        $(document).on('input', '.qty, .amount', function() {
            var row = $(this).closest('tr');
            var qty = parseFloat(row.find('.qty').val()) || 0;
            var amountPerPax = parseFloat(row.find('.amount').val()) || 0;
            var total = qty * amountPerPax;
            row.find('.total').text(total.toFixed(2));
            updateAnnathanamTotal();
        });

        $(document).on('click', '.delete', function() {
            $(this).closest('tr').remove();
            updateAnnathanamTotal();
        });

        function updateAnnathanamTotal() {
            var total = 0;
            $('#selectedAnnathanamTable .total, #selectedAddonTable .total').each(function() {
                total += parseFloat($(this).text()) || 0;
            });
            $('#annathanamDisplayTotal').text(total.toFixed(2)); // Assuming you have a place to show the total
            $('#annathanamTotal').val(total.toFixed(2));
            updateAnnathanamDetails();
            sum_amount();
        }

        function updateAnnathanamDetails() {
            var annathanamDetails = [];
            var annathanamAddonDetails = [];
            $('#selectedAnnathanamTable tbody tr').each(function() {
                var deityFull = $(this).find('td:eq(2)').text().trim();
                var deity = deityFull.split(' / ')[0];
                annathanamDetails.push({
                    packageId: $(this).data('package-id'),  // Include package ID
                    qty: $(this).find('.qty').val(),
                    amountPerPax: $(this).find('.amount').val(),
                    total: $(this).find('.total').text()
                });
            });
            $('#selectedAddonTable tbody tr').each(function() {
                annathanamAddonDetails.push({
                    addonId: $(this).data('addon-id'),  // Retrieve addon ID
                    qty: $(this).find('.qty').val(),
                    amountPerPax: $(this).find('.amount').val(),
                    total: $(this).find('.total').text()
                });
            });

            console.log('Annathanam Data:', JSON.stringify(annathanamDetails));
            document.getElementById('annathanam_details').value = JSON.stringify(annathanamDetails);
            document.getElementById('annathanam_addon_details').value = JSON.stringify(annathanamAddonDetails);
        }
    });
</script>


<script>
    $(document).ready(function() {
        loadPrasadamDetails();
        
        $('#prasadam_group_select').on('change', function() {
            loadPrasadamDetails();
        });

        $('#prasadam_add').on('click', function() {
            var prasadamGroup = $('#prasadam_group_select option:selected').text();
            var prasadamGroupId = $('#prasadam_group_select option:selected').val();  // Get prasadam group ID
            var prasadamDetails = $('#prasadam_details_select option:selected').text();
            var prasadamId = $('#prasadam_details_select option:selected').val();  // Get prasadam ID
            var prasadamDeity = $('#prasadam_deity_select option:selected').text().trim();
            var deityId = $('#prasadam_deity_select option:selected').val();  // Get deity ID
            var amountPerPax = $('#prasadam_details_select option:selected').data('amount') || 0;  // Get amount
            var qty = 1;  // Default quantity
            var total = amountPerPax * qty;

            var table = $('#selectedPrasadamTable');
            var rowCount = table.find('tr').length;  // Adjusted to start from 1

            table.append(`<tr>
                <td>${rowCount}</td>
                <td data-group-id="${prasadamGroupId}">${prasadamGroup}</td>
                <td data-prasadam-id="${prasadamId}">${prasadamDetails}</td>
                <td><input type='number' class='qtyy' value='${qty}' min='1' style='width: 50px;'></td>
                <td><input type='number' class='amount-per-pax' value='${amountPerPax}' min='0' step='0.01' style='width: 70px;'></td>
                <td class='total'>${total.toFixed(2)}</td>
                <td><button class='delete' style="border: none; background: none; color: red;"><i class="fas fa-trash-alt"></i></button></td>
            </tr>`);
            //<td data-deity-id="${deityId}">${prasadamDeity}</td>

            updatePrasadamTotal(); // Recalculate totals
        });

        $('#selectedPrasadamTable').on('input', '.qtyy, .amount-per-pax', function() {
            var row = $(this).closest('tr');
            var qty = parseFloat(row.find('.qtyy').val()) || 0;  // Default to 0 if empty
            var amountPerPax = parseFloat(row.find('.amount-per-pax').val()) || 0;  // Default to 0 if empty
            var total = qty * amountPerPax;

            row.find('.total').html(total.toFixed(2));  // Update the total in the cell

            updatePrasadamTotal();  // Update the grand total after row total update
        });


        $('#selectedPrasadamTable').on('click', '.delete', function() {
            $(this).closest('tr').remove();
            updatePrasadamInput();
            updatePrasadamTotal();
        });
    });

    function loadPrasadamDetails() {
        var selectedId = $('#prasadam_group_select').val();
        $.ajax({
            url: '<?php echo base_url(); ?>/templeubayam/get_prasadam_details', 
            type: 'POST',
            data: { prasadam_group_id: selectedId },
            dataType: 'json',
            success: function(response) {
                //console.log('Response:', response);
                var detailsDropdown = $('#prasadam_details_select');
                detailsDropdown.empty();
                detailsDropdown.append('<option value="" disabled selected>Select Prasadam Details</option>');
                response.forEach(function(item) {
                    detailsDropdown.append(
                        $('<option></option>').val(item.prasadam_id).text(item.name_eng + ' / ' + item.name_tamil).data('amount', item.amount)
                    );
                });
                detailsDropdown.selectpicker('refresh');
            }
        });
    }

    function updatePrasadamInput() {
        var data = [];
        $('#selectedPrasadamTable tr').each(function() {
            var cells = $(this).find('td');
            var prasadamGroup = cells.eq(1).text().trim();  // Get prasadam group name
            var prasadamGroupId = cells.eq(1).data('group-id');  // Get prasadam group ID from data attribute
            var prasadamDetails = cells.eq(2).text();  // Get prasadam name
            var prasadamId = cells.eq(2).data('prasadam-id');  // Get prasadam ID
            // var prasadamDeityFull = cells.eq(3).text().trim();  // Get deity name (full)
            // var prasadamDeity = prasadamDeityFull.split(' / ')[0];  // Extract only the part before /
            // var deityId = cells.eq(3).data('deity-id');  // Get deity ID
            var qty = $(this).find('.qtyy').val();  // Get quantity
            var amountPerPax = $(this).find('.amount-per-pax').val();  // Get amount per item
            var total = $(this).find('.total').text();  // Get total for the row

            if (prasadamDetails && qty && amountPerPax && total) {
                data.push({
                    prasadam_group_id: prasadamGroupId,  // Include prasadam_group_id
                    id: prasadamId,
                    // deity: prasadamDeity,  // Use the extracted deity name before /
                    // deity_id: deityId,
                    qty: qty,
                    amountPerPax: amountPerPax,
                    amount: total
                });
            }
        });

        console.log('Prasadam Data:', JSON.stringify(data));  // Debug the data
        document.getElementById('prasadam_details').value = JSON.stringify(data);  // Update hidden input  // Update the total
    }


    function updatePrasadamTotal() {
        var prasadamTotal = 0;
        $('#selectedPrasadamTable .total').each(function() {
            prasadamTotal += parseFloat($(this).text()) || 0;
        });
        $('#prasadamTotalDisplay').text(prasadamTotal.toFixed(2));
        $('#prasadamTotal').val(prasadamTotal.toFixed(2));

        sum_amount(); // Ensure this function is defined and correctly updates the final total display
        updatePrasadamInput();
    }

</script>


<script>
    function toggleAbishegamSelection(show) {
        document.getElementById('abishegamSelection').style.display = show ? 'block' : 'none';
    }

    function addAbishegamToTable() {
        var select = document.getElementById('abishegamDropdown');
        var table = document.getElementById('selectedAbishegamTable');
        var rowCount = table.rows.length;
        var selectedOption = select.options[select.selectedIndex];
        var deityId = selectedOption.value;  // Fetch the deity ID
        var deityName = selectedOption.text;  // Fetch the deity name
        var amount = selectedOption.getAttribute('data-amount'); // Fetch the amount

        if (select.value !== "") {
            var row = table.insertRow();
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);

            $(row).data('deity-id', deityId);

            cell1.innerHTML = rowCount + 1;
            cell2.innerHTML = deityName;
            cell3.innerHTML = "SGD " + amount;
            cell4.innerHTML = '<button onclick="deleteAbishegam(this)" style="border: none; background: none; color: red;"><i class="fas fa-trash-alt"></i></button>';

            select.selectedIndex = 0;
            updateAbishegamInput();
            updateAbishegamTotal();
        }
    }

    function deleteAbishegam(button) {
        var row = button.parentNode.parentNode;
        row.parentNode.removeChild(row);

        var table = document.getElementById('selectedAbishegamTable');
        for (var i = 0, row; row = table.rows[i]; i++) {
            row.cells[0].innerHTML = i + 1;
        }
        updateAbishegamInput();
        updateAbishegamTotal();
    }

    function updateAbishegamInput() {
        var table = document.getElementById('selectedAbishegamTable');
        var data = [];

        for (var i = 0, row; row = table.rows[i]; i++) {
            var deityFullName = row.cells[1].innerText;
            var deityName = deityFullName.split(' / ')[0];
            var amount = row.cells[2].innerText.replace("SGD ", "");
            var deityId = $(row).data('deity-id');  // Retrieve the deityId stored in the row

            data.push({
                deityId: deityId,  // Add deityId to the details
                name: deityName,
                amount: amount
            });
        }
        console.log('abishegam Data:', data);
        document.getElementById('abishegam_details').value = JSON.stringify(data);
    }

    function updateAbishegamTotal() {
        var total = 0;
        var table = document.getElementById('selectedAbishegamTable');
        for (var i = 0, row; row = table.rows[i]; i++) {
            var amount = parseFloat(row.cells[2].innerText.replace("SGD ", ""));
            total += amount;
        }
        document.getElementById('abishegamTotal').textContent = total.toFixed(2);
        sum_amount();
    }
</script>


<script>
    function toggleHomamSelection(show) {
        document.getElementById('homamSelection').style.display = show ? 'block' : 'none';
    }

    function addHomamToTable() {
        var select = document.getElementById('homamDropdown');
        var table = document.getElementById('selectedHomamTable');
        var rowCount = table.rows.length;
        var selectedOption = select.options[select.selectedIndex];
        var deityId = selectedOption.value;  // Fetch the deity ID
        var deityName = selectedOption.text;  // Fetch the deity name
        var amount = selectedOption.getAttribute('data-amount'); // Fetch the amount

        if (select.value !== "") {
            var row = table.insertRow();
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);

            // Store the deityId in the row's data attribute
            $(row).data('deity-id', deityId);

            cell1.innerHTML = rowCount + 1;
            cell2.innerHTML = deityName;
            cell3.innerHTML = "SGD " + amount;
            cell4.innerHTML = '<button onclick="deleteHomam(this)" style="border: none; background: none; color: red;"><i class="fas fa-trash-alt"></i></button>';

            select.selectedIndex = 0;
            updateHomamInput();
            updateHomamTotal();
        }
    }

    function deleteHomam(button) {
        var row = button.parentNode.parentNode;
        row.parentNode.removeChild(row);

        var table = document.getElementById('selectedHomamTable');
        for (var i = 0, row; row = table.rows[i]; i++) {
            row.cells[0].innerHTML = i + 1;
        }
        updateHomamInput();
        updateHomamTotal()
    }

    function updateHomamInput() {
        var table = document.getElementById('selectedHomamTable');
        var data = [];

        for (var i = 0, row; row = table.rows[i]; i++) {
            var deityFullName = row.cells[1].innerText;
            var deityName = deityFullName.split(' / ')[0];
            var deityId = $(row).data('deity-id');  // Retrieve the deityId stored in the row
            var amount = row.cells[2].innerText.replace("SGD ", "");

            data.push({
                deityId: deityId,  // Add deityId to the details
                name: deityName,
                amount: amount
            });
        }
        console.log('Homam Data:', data);
        document.getElementById('homam_details').value = JSON.stringify(data);
    }

    function updateHomamTotal() {
        var total = 0;
        var table = document.getElementById('selectedHomamTable');
        for (var i = 0, row; row = table.rows[i]; i++) {
            var amount = parseFloat(row.cells[2].innerText.replace("SGD ", ""));
            total += amount;
        }
        document.getElementById('homamTotal').textContent = total.toFixed(2);
        sum_amount();
    }
</script>


<script>
    // document.addEventListener('DOMContentLoaded', function() {
    //     // Initialize by binding events
    //     document.getElementById('add_services').addEventListener('click', addServiceToTable);
    //     document.getElementById('addon_services_select').addEventListener('change', fillServiceAmount);
    // });

    // function fillServiceAmount() {
    //     var select = document.getElementById('addon_services_select');
    //     var amountInput = document.getElementById('service_amount');
    //     var selectedOption = select.options[select.selectedIndex];
    //     var amount = selectedOption.getAttribute('data-amount');
    //     amountInput.value = amount ? amount : '0.00';  // Default to 0.00 if no amount is found
    // }

    // function addServiceToTable() {
    //     var select = document.getElementById('addon_services_select');
    //     var amountInput = document.getElementById('service_amount');
    //     var table = document.getElementById('services_table').getElementsByTagName('tbody')[0];
    //     var selectedOption = select.options[select.selectedIndex];
    //     var serviceId = selectedOption.value;

    //     if (serviceId !== "" && parseFloat(amountInput.value) > 0) {
    //         var rowCount = table.rows.length + 1;
    //         var row = table.insertRow();
    //         var cell1 = row.insertCell(0);
    //         var cell2 = row.insertCell(1);
    //         var cell3 = row.insertCell(2);
    //         var cell4 = row.insertCell(3);

    //         $(row).data('deity-id', deityId);

    //         cell1.innerHTML = rowCount;
    //         cell2.innerHTML = selectedOption.text;
    //         cell3.innerHTML = 'SGD ' + parseFloat(amountInput.value).toFixed(2);
    //         cell4.innerHTML = '<button onclick="deleteService(this)" class="btn btn-danger">Remove</button>';

    //         select.selectedIndex = 0;  // Reset selection
    //         amountInput.value = '0.00';  // Reset amount
    //         updateServiceTotal();
    //         updateServiceDetails();
    //     } else {
    //         alert("Please select a service and enter a valid amount.");
    //     }
    // }

    // function deleteService(button) {
    //     var row = button.parentNode.parentNode;
    //     var table = document.getElementById('services_table').getElementsByTagName('tbody')[0];
    //     table.deleteRow(row.rowIndex - 1);
    //     updateServiceTotal();
    //     updateServiceDetails();
    //     renumberTable();
    // }

    // function updateServiceTotal() {
    //     var total = 0;
    //     var table = document.getElementById('services_table').getElementsByTagName('tbody')[0];
    //     for (var i = 0, row; row = table.rows[i]; i++) {
    //         var amount = parseFloat(row.cells[2].innerHTML.replace('SGD ', ''));
    //         total += amount;
    //     }
    //     document.getElementById('serviceTotal').textContent = 'SGD ' + total.toFixed(2);
    //     updateGrandTotal();
    // }

    // function updateServiceDetails() {
    //     var table = document.getElementById('services_table').getElementsByTagName('tbody')[0];
    //     var servicesDetails = [];
    //     for (var i = 0, row; row = table.rows[i]; i++) {
    //         var serviceId = row.cells[0].innerText;  // Assuming ID is stored in the first cell
    //         var amount = row.cells[2].innerText.replace('SGD ', '');
    //         servicesDetails.push({ id: serviceId, amount: amount });
    //     }
    //     document.getElementById('services_details').value = JSON.stringify(servicesDetails);
    // }

    // function renumberTable() {
    //     var table = document.getElementById('services_table').getElementsByTagName('tbody')[0];
    //     for (var i = 0, row; row = table.rows[i]; i++) {
    //         row.cells[0].innerHTML = i + 1;  // Update row numbers
    //     }
    // }
</script>

<script>
//     function updateGrandTotal() {
//     var total = 0;

//     var packageAmt = parseFloat($('#packageTotal').text()) || 0;
//     total += packageAmt;

//     var annathanamTotal = parseFloat($('#annathanamTotal').text()) || 0;
//     total += annathanamTotal;

//     var prasadamTotal = parseFloat($('#prasadamTotal').text()) || 0;
//     total += prasadamTotal;

//     var abishegamTotal = parseFloat(document.getElementById('abishegamTotal').textContent) || 0;
//     total += abishegamTotal;

//     var homamTotal = parseFloat(document.getElementById('homamTotal').textContent) || 0;
//     total += homamTotal;

//     var serviceTotal = parseFloat(document.getElementById('serviceTotal').textContent.replace('SGD ', '')) || 0;
//     total += serviceTotal;

//     $("#total_amt").val(total.toFixed(2));

//     var pay_tot = 0;
//     $(".pay_amt").each(function () {
//         pay_tot += parseFloat($(this).val()) || 0;
//     });

//     $("#deposite_amt").val(pay_tot.toFixed(2));

//     var balance = total - pay_tot;
//     $("#balance").val(balance.toFixed(2));

//     console.log("Total Amount (after calculation):", total);  // Log the final total
// }

    // Function to handle payment addition
// $("#pay_add").click(function () {
//     var date = $("#pay_date").val();
//     var amt = $("#pay_amt").val();
//     var paymentmode = $("#paymentmode").val();
//     var cnt = parseInt($("#pay_row_count").val());

//     if (date != '' && amt != 0 && paymentmode != 0) {
//         var total_amt = parseFloat($('#total_amt').val());
//         var deposite_amt = parseFloat($('#deposite_amt').val());
//         amt = parseFloat(amt);

//         if (amt <= (total_amt - deposite_amt)) {
//             get_payment_mode(paymentmode, cnt);
//             var html = '<tr id="rmv_payrow' + cnt + '">';
//             html += '<td style="width: 30%;"><input type="date" style="border: none;" readonly name="payment_details[' + cnt + '][paid_date]" value="' + date + '"></td>';
//             html += '<td style="width: 25%;"><input type="text" style="border: none;" readonly class="pay_amt" name="payment_details[' + cnt + '][amount]" value="' + Number(amt).toFixed(2) + '"></td>';
//             html += '<td style="width: 30%!important;"><input type="hidden" style="border: none; width:100%;" readonly id="payment_mode_' + cnt + '" name="payment_details[' + cnt + '][payment_mode]"><span id="payment_mode_label_' + cnt + '"></span></td>';
//             html += '<td style="width: 15%;"><a class="btn btn-danger btn-rad" onclick="rmv_pay(' + cnt + ')" style="width:auto;"><i class="material-icons"></i></a></td>';
//             html += '</tr>';

//             $("#pay_table").append(html);
//             var ct = parseInt(cnt + 1);
//             $("#pay_row_count").val(ct);

//             // Update the totals after adding payment
//             updateGrandTotal();

//             // Reset payment fields
//             $("#pay_amt").val('');
//             $('#paymentmode').prop('selectedIndex', 0);
//             $("#paymentmode").selectpicker("refresh");
//         } else {
//             alert('Can\'t add deposit amount more than Total amount');
//         }
//     }
// });

// // Function to remove a payment
// function rmv_pay(id) {
//     $("#rmv_payrow" + id).remove();
//     updateGrandTotal();  // Update the totals after removing the payment
// }

// // Payment Mode Handler (This is your custom function, ensure it's defined somewhere)
// function get_payment_mode(paymentmode, cnt) {
//     // Assuming payment_modes is already available in your system
//     var selectedText = $("#paymentmode option:selected").text();
//     $("#payment_mode_" + cnt).val(paymentmode);
//     $("#payment_mode_label_" + cnt).text(selectedText);
// }
</script>


<script>

    document.getElementById('termsForm').addEventListener('submit', function (event) {

    });
    function togglePayDetails() {
    var payType = document.querySelector('input[name="payment_type"]:checked').value;
    var partialDetails = document.querySelectorAll('.partial-payment-details');
    var paymentModeColumn = document.querySelector('.only-booking'); // Targeting the column for payment mode

    if (payType === 'full') {
        partialDetails.forEach(function (element) {
            element.style.display = 'none';
        });
        paymentModeColumn.style.display = 'block';

        clearPartialPaymentDetails();
        recalculateBalanceFull();

    } else if (payType === 'partial') {
        partialDetails.forEach(function (element) {
            element.style.display = 'block';
        });
        paymentModeColumn.style.display = 'block';

    } else if (payType === 'only_booking') {
        partialDetails.forEach(function (element) {
            element.style.display = 'none';
        });
        paymentModeColumn.style.display = 'none';

        clearPartialPaymentDetails();
    }
}


    function clearPartialPaymentDetails() {
        document.querySelector("#pay_table tbody").innerHTML = '';
        document.querySelector("#pay_row_count").value = '1';

        document.querySelector("#deposite_amt").value = '0';
    }

    function recalculateBalanceFull() {
        var totalAmount = parseFloat(document.querySelector("#total_amt").value) || 0;
        document.querySelector("#balance").value = totalAmount.toFixed(2);
    }

    document.addEventListener('DOMContentLoaded', function () {
        togglePayDetails();
    });


    function get_staff_commision_name(id, cmlp) {
        //alert(id);
        if (id != '') {
            $.ajax({
                url: "<?php echo base_url(); ?>/hallbooking/get_staff_commision_name",
                type: "post",
                data: { id: id },
                dataType: "json",
                success: function (data) {
                    //$("#commisiion_name_"+cmlp).addClass("focused");
                    $("#commisiion_name_" + cmlp).text("Commission to " + data['name'] + " * ");
                }
            });
        }
    }
    function getSelectedOptions(sel) {
        $("#commission_append_input_box").empty();
        var opts = [],
            opt;
        var length = $('#commission_to > option').length;
        for (var i = 1; i < length; i++) {
            opt = sel.options[i];
            if (opt.selected) {
                opts.push(opt);
                //alert(opt);
                //alert(i);
                //if(opt.value == i)
                //{
                var staff_id = opt.value;
                //alert(staff_id);
                get_staff_commision_name(staff_id, i);
                var html = '<div class="row" id="rmv_commins' + i + '">';
                html += '<div class="col-md-4"><p id="commisiion_name_' + i + '"></p></div>';
                html += '<div class="col-md-8"><input type="hidden" name="staff_additional[' + i + '][id]" value="' + staff_id + '"><input type="number" min="0" step="any" style="width:100%" class="form-control" name="staff_additional[' + i + '][amount]" >';
                html += '</div>';
                html += '</div>';
                $("#commission_append_input_box").append(html);
                // }
            }
        }
        //return opts;
    }

    $("#clear").click(function () {
        //alert(0);
        //$("input:text").val("");
        $(".reg_det").val("");
    });


    $("#add_one").change(function () {
        var id = $("#add_one").val();
        if (id != '') {
            $.ajax({
                url: "<?php echo base_url(); ?>/templeubayam/getpack_amt",
                type: "post",
                data: { id: id },
                dataType: "json",
                success: function (data) {
                    console.log(data)
                    ////Number(data['amt']).toFixed(2)
                    $("#get_pack_amt").val(Number(data['amt']).toFixed(2));
                    $("#pack_name").val(data['name']);
                }
            });
        } else {
            $("#get_pack_amt").val(0);
        }
    });
    $("#add_one_addon").change(function () {
        var id = $("#add_one_addon").val();
        if (id != '') {
            $.ajax({
                url: "<?php echo base_url(); ?>/templeubayam/getpack_amt_addon",
                type: "post",
                data: { id: id },
                dataType: "json",
                success: function (data) {
                    console.log(data)
                    ////Number(data['amt']).toFixed(2)
                    $("#get_pack_amt_addon").val(Number(data['amt']).toFixed(2));
                    $("#pack_name_addon").val(data['name']);
                }
            });
        } else {
            $("#get_pack_amt_addon").val(0);
        }
    });
    function get_package_description_name(id, cmlp) {
        //alert(id);
        if (id != '') {
            $.ajax({
                url: "<?php echo base_url(); ?>/hallbooking/get_package_description_name",
                type: "post",
                data: { id: id },
                dataType: "json",
                success: function (data) {
                    $("#package_description_name_" + cmlp).text(data['description']);
                }
            });
        }
    }
    function get_service_name(id, cmlp) {
        //alert(id);
        if (id != '') {
            $.ajax({
                url: "<?php echo base_url(); ?>/templeubayam/get_service_name",
                type: "post",
                data: { id: id },
                dataType: "json",
                success: function (data) {
                    $("#service_name_" + cmlp).val(data['name']);
                    $("#service_description_" + cmlp).val(data['description']);
                }
            });
        }
    }
    function get_service_name_addon(id, cmlp) {
        //alert(id);
        if (id != '') {
            $.ajax({
                url: "<?php echo base_url(); ?>/templeubayam/get_service_name_addon",
                type: "post",
                data: { id: id },
                dataType: "json",
                success: function (data) {
                    $("#service_name_addon_" + cmlp).val(data['name']);
                    $("#service_description_addon_" + cmlp).val(data['description']);
                }
            });
        }
    }
    $("#pack_add").click(function () {
        // alert(0);
        //var id = $("#add_one option:selected").val();
        var id = $("#add_one option:selected").val();
        var cnt = parseInt($("#pack_row_count").val());
        amt = $("#get_pack_amt").val();
        //alert(amt);
        if (id != '' && parseFloat(amt) > 0) {
            var status_check = 0;
            $(".package_category").each(function () {
                arcat = parseInt($(this).val());
                // if(arcat == id){
                if (arcat) {
                    status_check++;
                }
            });
            if (status_check > 0) {
                alert("You can choose only one package.");
                // alert("Already choosed this package please choose another package.");
            }
            else {
                $.ajax({
                    url: "<?php echo base_url(); ?>/templeubayam/get_service_list",
                    type: "post",
                    data: { id: id },
                    //dataType: "json",
                    success: function (response) {
                        response = JSON.parse(response);
                        if (response.data.services.length > 0) {
                            $.each(response.data.services, function (key, value) {
                                var countid = value.id;
                                var serviceid = value.id;
                                var serviceamount = value.amount;
                                get_service_name(serviceid, countid);
                                var html = '<tr id="rmv_packrow' + countid + '">';
                                html += '<td style="width: 20%;"><input type="hidden" readonly name="packages[' + countid + '][id]" class="package_id" value="' + serviceid + '"><input type="text" style="border: none;width: 100%;" readonly id="service_name_' + countid + '"></td>';
                                html += '<td style="width: 45%;"><input type="text" style="border: none;width: 100%;" id="service_description_' + countid + '" ></td>';
                                html += '<td style="width: 25%;"><input type="text" style="border: none;width: 100%;" name="pack_amount" class="package_amt" value="' + Number(serviceamount).toFixed(2) + '" onkeyup="serviceamount()"></td>';
                                html += '<td style="width: 10%;"><a class="btn btn-danger btn-rad" onclick="rmv_pack(' + countid + ')" style="width:auto;padding: 0px 3px !important;"><i class="material-icons"></i></a><input type="hidden" class="package_category" value=' + id + '></td>';
                                html += '</tr>';
                                $("#package_table").append(html);
                            });

                        }
                        if (response.data.addons.length > 0) {
                            var a_html = '<option value="">Select From</option>';
                            response.data.addons.forEach(function (value, key) {
                                a_html += '<option value="' + value.id + '">' + value.name + '</option>';
                            });
                        } else var a_html = '<option value="">No Addons Found</option>';
                        $('#add_one_addon').html(a_html);
                        $("#add_one_addon").selectpicker("refresh");

                        $("#package_table_addon tbody").empty();
                        $("#pack_row_count_addon").val(0);
                        sum_amount();
                    }
                });
                //$('#successModal').modal('show');
                $("#get_pack_amt").val('');
                $('#add_one').prop('selectedIndex', 0);
                $("#add_one").selectpicker("refresh");
            }
        }
    });
    $("#pack_add_addon").click(function () {
        var id = $("#add_one_addon option:selected").val();
        var package_id = $('.package_id').val();
        var cnt = parseInt($("#pack_row_count_addon").val());
        var amt = $("#get_pack_amt_addon").val();

        if (id != '' && parseFloat(amt) > 0) {
            var status_check = 0;
            var rowId;

            $(".package_category_addon").each(function () {
                arcat = parseInt($(this).val());
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
                $('#add_one_addon').prop('selectedIndex', 0);
                $("#add_one_addon").selectpicker("refresh");
            } else {
                $.ajax({
                    url: "<?php echo base_url(); ?>/templeubayam/get_service_list_addon",
                    type: "post",
                    data: { id: id, package_id: package_id },
                    success: function (response) {
                        response = JSON.parse(response);
                        if (response.length > 0) {
                            $.each(response, function (key, value) {
                                var countid = value.id;
                                var serviceid = value.id;
                                var quantity = value.quantity;
                                var serviceamount = value.amount;
                                get_service_name_addon(serviceid, countid);
                                var html = '<tr id="rmv_packrow_addon' + countid + '">';
                                html += '<td style="width: 20%;"><input type="hidden" readonly name="add_on[' + countid + '][id]" value="' + serviceid + '"><input type="text" style="border: none;width: 100%;" readonly id="service_name_addon_' + countid + '" data-amount="' + serviceamount + '"></td>';
                                html += '<td style="width: 45%;"><input type="text" style="border: none;width: 100%;" id="service_description_addon_' + countid + '"></td>';
                                html += '<td><div class="itemcountrr"><div class="value-button" id="decrease" onclick="decreaseValue(' + countid + ')" value="Decrease Value" style="font-weight: bold;font-size: 16px; cursor: pointer;">-</div><input type="number" name="add_on[' + countid + '][quantity]" min="1" id="quantity' + countid + '" value="1" pattern="[0-9]*" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" class="qty_amt" style="text-align: center;border: none;border-top: 1px solid #ddd;border-bottom: 1px solid #ddd;margin: 0px;width: 35px;height: 25px;" max="' + quantity + '" onkeyup="qtykeyup(' + countid + ')" /><div class="value-button" id="increase" onclick="increaseValue(' + countid + ')" value="Increase Value" style="font-weight: bold;font-size: 16px; cursor: pointer;">+</div></div></td>';
                                html += '<td style="width: 25%;"><input type="text" style="border: none;width: 100%;" class="package_amt_addon" id="package_amt_addon_' + countid + '" name="add_on[' + countid + '][amount]" value="' + Number(serviceamount).toFixed(2) + '" onkeyup="serviceamount()"></td>';
                                html += '<td style="width: 10%;"><a class="btn btn-danger btn-rad" onclick="rmv_pack_addon(' + countid + ')" style="width:auto;padding: 0px 3px !important;"><i class="material-icons"></i></a><input type="hidden" class="package_category_addon" value=' + id + '></td>';
                                html += '</tr>';
                                $("#package_table_addon").append(html);
                            });
                            sum_amount();
                        }
                    }
                });
                $("#get_pack_amt_addon").val('');
                $('#add_one_addon').prop('selectedIndex', 0);
                $("#add_one_addon").selectpicker("refresh");
            }
        }
    });
    function increaseValue(cnt) {
        var quantity = $("#quantity" + cnt);
        var currentVal = parseInt(quantity.val());
        if (!isNaN(currentVal)) {
            if ((currentVal + 1) > quantity.attr('max')) quantity.val(quantity.attr('max'));
            else quantity.val(currentVal + 1);
            updateAmount(cnt);
        } else {
            quantity.val(1);
        }
        sum_amount();
    }

    function decreaseValue(cnt) {
        var quantity = $("#quantity" + cnt);
        var currentVal = parseInt(quantity.val());
        if (!isNaN(currentVal) && currentVal > 1) {
            quantity.val(currentVal - 1);
            updateAmount(cnt);
        } else {
            quantity.val(1);
        }
        sum_amount();
    }

    function qtykeyup(cnt) {
        var quantity = $("#quantity" + cnt);
        var currentVal = parseInt(quantity.val());
        console.log(currentVal);
        console.log();
        if (!isNaN(currentVal) && currentVal >= 0) {
            if (currentVal > quantity.attr('max')) quantity.val(quantity.attr('max'));
            updateAmount(cnt);
        } else {
            quantity.val(1);
        }
        sum_amount();
    }


    function updateAmount(cnt) {
        var quantity = $("#quantity" + cnt).val();
        var unitPrice = parseFloat($("#service_name_addon_" + cnt).data('amount'));
        var totalPrice = quantity * unitPrice;
        $("#package_amt_addon_" + cnt).val(Number(totalPrice).toFixed(2));
    }
    function rmv_pack(id) {
        $("#rmv_packrow" + id).remove();
        sum_amount();
    }
    function rmv_pack_addon(id) {
        $("#rmv_packrow_addon" + id).remove();
        sum_amount();
    }
    function serviceamount() {
        sum_amount();
    }

    function get_payment_mode(id, cntno) {
        //alert(id);
        if (id != '') {
            $.ajax({
                url: "<?php echo base_url(); ?>/templeubayam/get_payment_mode",
                type: "post",
                data: { id: id },
                dataType: "json",
                success: function (data) {
                    $("#payment_mode_" + cntno).val(data['id']);
                    $("#payment_mode_label_" + cntno).text(data['name']);
                }
            });
        }
    }
    $("#pay_add").click(function () {
        var date = $("#pay_date").val();
        var amt = $("#pay_amt").val();
        var paymentmode = $("#paymentmode").val();
        var cnt = parseInt($("#pay_row_count").val());
        if (date != '' && amt != 0 && paymentmode != 0) {
            var total_amt = parseFloat($('#total_amt').val());
            var deposite_amt = parseFloat($('#deposite_amt').val());
            amt = parseFloat(amt);
            if (amt <= (total_amt - deposite_amt)) {
                get_payment_mode(paymentmode, cnt);
                var html = '<tr id="rmv_payrow' + cnt + '">';
                html += '<td style="width: 30%;"><input type="date" style="border: none;" readonly name="payment_details[' + cnt + '][paid_date]" value="' + date + '"></td>';
                html += '<td style="width: 25%;"><input type="text" style="border: none;" readonly class="pay_amt" name="payment_details[' + cnt + '][amount]" value="' + Number(amt).toFixed(2) + '"></td>';
                html += '<td style="width: 30%!important;"><input type="hidden" style="border: none; width:100%;" readonly id="payment_mode_' + cnt + '" name="payment_details[' + cnt + '][payment_mode]"><span id="payment_mode_label_' + cnt + '"></span></td>';
                html += '<td style="width: 15%;"><a class="btn btn-danger btn-rad" onclick="rmv_pay(' + cnt + ')" style="width:auto;"><i class="material-icons"></i></a></td>';
                html += '</tr>';
                $("#pay_table").append(html);
                var ct = parseInt(cnt + 1);
                $("#pay_row_count").val(ct);
                sum_amount();
                $("#pay_amt").val('');
                $('#paymentmode').prop('selectedIndex', 0);
                $("#paymentmode").selectpicker("refresh");
            } else {
                alert('Can\'t add deposit amount more than Total amount');
            }
        }
    });

    function rmv_pay(id) {
        $("#rmv_payrow" + id).remove();
        sum_amount();
    }


    function sum_amount() {
        var total = 0;
        var pay_tot = 0;
        $(".package_amt").each(function () {
            total += parseFloat($(this).val());
        });

        $(".package_amt_addon").each(function () {
            total += parseFloat($(this).val());
        });

        var annathanamTotal = parseFloat($('#annathanamDisplayTotal').text()) || 0;
        total += annathanamTotal;

        var prasadamTotal = parseFloat($('#prasadamTotalDisplay').text()) || 0;
        total += prasadamTotal;

        var abishegamTotal = parseFloat(document.getElementById('abishegamTotal').textContent) || 0;
        total += abishegamTotal;

        var homamTotal = parseFloat(document.getElementById('homamTotal').textContent) || 0;
        total += homamTotal;

        $("#extra_charges_table tbody tr").each(function() {
            var extraAmount = parseFloat($(this).find('td:eq(1)').text()); // Assuming the amount is in the second column
            if (!isNaN(extraAmount)) {
                total += extraAmount;
            }
        });

        var discount_amount = $('#discount_amount').val();
        var max_discount = 0;
        if (discount_amount) {
            discount_amount = Number(discount_amount);
            max_discount = total - 1;
            if (max_discount < 0) max_discount = 0;
            if (discount_amount > max_discount) {
                discount_amount = max_discount;
                $('#discount_amount').val(discount_amount.toFixed(2))
            }
            total = total - discount_amount;
        }

        $(".pay_amt").each(function () {
            pay_tot += parseFloat($(this).val());
        });

        $("#total_amt").val(Number(total).toFixed(2));
        $("#deposite_amt").val(Number(pay_tot).toFixed(2));

        var balance = total - pay_tot;
        $("#balance").val(Number(balance).toFixed(2));
    }

    $('#discount_amount').on('blur change', function () {
        sum_amount();
    });

    $("#submit").click(function () {


        // var checkboxes = document.querySelectorAll('.term-checkbox');
        // var allChecked = true;

        // checkboxes.forEach(function (checkbox) {
        //     if (!checkbox.checked) {
        //         allChecked = false;
        //     }
        // });

        // if (!allChecked) {
        //     event.preventDefault();
        //     alert('Please check all Terms & Conditions before saving.');
        //     exit();
        // }



        var pre_sts = $("#status option:selected").val();
        var total_amt = parseFloat($("#total_amt").val());
        var deposite_amt = parseFloat($("#deposite_amt").val());
        var balance = parseFloat($("#balance").val());
        //var check_dep = parseFloat((total_amt / 100) * 30).toFixed(2);
        // console.log(check_dep);

        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>/ajax/save_booking",
            data: $("form").serialize(),
            beforeSend: function () {
                $("#loader").show();
            },
            success: function (data) {
                console.log(data);
                if (typeof data === 'string') {
                    try {
                        data = JSON.parse(data);
                    } catch (e) {
                        console.error("Failed to parse JSON response: ", e);
                        $('#alert-modal').modal('show', { backdrop: 'static' });
                        $("#spndeddelid").text("An error occurred while processing the response.");
                        $("#spndeddelid").css("color", "red");
                        return;
                    }
                }

                if (data.success) {
                    if (data.data.status) {
                        $('#alert-modal').modal('show', { backdrop: 'static' });
                        $("#spndeddelid").text(data.data.message);
                        $("#spndeddelid").css("color", "green");
                        /* setTimeout(function(){
                            
                        }, 2000); */
                        var bookingId = data.data.booking_id;
                        console.log("Booking ID: " + bookingId);
                        window.location.replace("<?php echo base_url(); ?>/templeubayam/ubayambook_list?date="+$('#event_date').val());
                        // Perform additional actions if needed, e.g., redirect to a confirmation page
                    } else {
                        $('#alert-modal').modal('show', { backdrop: 'static' });
                        $("#spndeddelid").text(data.data.message);
                        $("#spndeddelid").css("color", "red");
                    }
                } else {
                    $('#alert-modal').modal('show', { backdrop: 'static' });
                    $("#spndeddelid").text("An error occurred. Please try again later");
                    $("#spndeddelid").css("color", "red");
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error: ", error); // Log the error details to console
                console.log("XHR Object: ", xhr);      // Log the entire XHR object for debugging
                console.log("Status: ", status);       // Log the status (e.g., "timeout", "error", etc.)

                // Show error message in modal
                $('#alert-modal').modal('show', { backdrop: 'static' });
                $("#spndeddelid").text("An error occurred: " + error);
                $("#spndeddelid").css("color", "red");
            },
            complete: function () {
                $("#loader").hide();
            }
        });


    });

    $("#submit_old").click(function () {

        $("#loader").show();

    });

    function printData(id) {
        $.ajax({
            url: "<?php echo base_url(); ?>/hallbooking/print_page/" + id,
            type: 'POST',
            success: function (result) {
                //console.log(result)
                popup(result);
            }
        });
    }
    // $('#termsLabel').on('click', function (event) {
    //     event.preventDefault();
    //     var name = $("#name").val();
    //     var ic_number = $("#ic_number").val();

    //     if (name && ic_number) {
    //         // Both name and IC number are provided
    //         $.ajax({
    //             url: '<?php echo base_url(); ?>/templeubayam/get_terms',
    //             method: 'POST',
    //             data: { name: name, ic_number: ic_number },
    //             success: function (response) {
    //                 if (response.success) {
    //                     $('.modal-body-terms').html(response.terms);
    //                     $('#termsModal').modal('show');
    //                 } else {
    //                     alert('Failed to load terms. Please try again.');
    //                 }
    //             },
    //             error: function () {
    //                 alert('An error occurred. Please try again.');
    //             }
    //         });
    //     } else {
    //         alert('Please enter both name and IC number.');
    //     }
    // });

    function popup(data) {
        var frame1 = $('<iframe />');
        frame1[0].name = "frame1";
        frame1.css({ "position": "absolute", "top": "-1000000px" });
        $("body").append(frame1);
        var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
        frameDoc.document.open();
        //Create a new HTML document.
        frameDoc.document.write('<html>');
        frameDoc.document.write('<head>');
        frameDoc.document.write('<title></title>');
        frameDoc.document.write('</head>');
        frameDoc.document.write('<body >');
        frameDoc.document.write(data);
        frameDoc.document.write('</body>');
        frameDoc.document.write('</html>');
        frameDoc.document.close();
        setTimeout(function () {
            window.frames["frame1"].focus();
            window.frames["frame1"].print();
            frame1.remove();
            window.location.reload(true);
        }, 500);

        frame1.remove();
        var dt = $('#event_date').val();
        window.location.replace("<?php echo base_url(); ?>/hallbooking/hallbook_list?date=" + dt);
        //return true;
    }
    $(document).ready(function () {
        $(document).on('click', '.booking_slot', function () {
            var booking_slot = this.value;
            var booking_date = $('#event_date').val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>/ajax/get_packages_list",
                data: { slot_id: booking_slot, booking_date: booking_date, package_type: 2 },
                dataType: 'json',
                beforeSend: function () {
                    // $("#loader").show();
                },
                success: function (data) {
                    if (data.success) {
                        console.log('package_data:',data);
                        if (data.data.packages.length > 0) {
                            var html = '<option value="">Select From</option>';
                            data.data.packages.forEach(function (value, key) {
                                html += '<option value="' + value.id + '">' + value.name + '</option>';
                            });
                        } else var html = '<option value="">No Packages Found</option>';
                        $('#add_one').html(html);
					    $("#add_one").selectpicker("refresh");
                        if (data.data.addons.length > 0) {
                            var a_html = '<option value="">Select From</option>';
                            data.data.addons.forEach(function (value, key) {
                                a_html += '<option value="' + value.id + '">' + value.name + '</option>';
                            });
                        } else var a_html = '<option value="">No Addons Found</option>';
                        $('#add_one_addon').html(a_html);
					    $("#add_one_addon").selectpicker("refresh");

                        $("#package_table tbody").empty();
                        $("#pack_row_count").val(0);
                        $("#package_table_addon tbody").empty();
                        $("#pack_row_count_addon").val(0);
                        sum_amount();
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error Status: " + status);
                    console.error("Error: " + error);
                    console.error("Response Text: " + xhr.responseText); // Logs the server response text for further inspection
                    $('#alert-modal').modal('show', { backdrop: 'static' });
                    $("#spndeddelid").text("An error occurred. Please try again later");
                    $("#spndeddelid").css("color", "red");
                    var html = '<option value="">No Packages Found</option>';
                    $('#add_one').html(html);
                    $("#add_one").selectpicker("refresh");
                    var a_html = '<option value="">No Addons Found</option>';
                    $('#add_one_addon').html(a_html);
                    $("#add_one_addon").selectpicker("refresh");

                    // Reset package table
                    $("#package_table tbody").empty();
                    $("#pack_row_count").val(0);
                    $("#package_table_addon tbody").empty();
                    $("#pack_row_count_addon").val(0);
                    sum_amount();
                },
                complete: function () {
                    // $("#loader").hide();
                }
            });
        });
    });
</script>


<!-- <script>
$('#prasadam_group_select').on('change', function() {
    var selectedId = $(this).val();

    $.ajax({
        url: '<?php echo base_url(); ?>/templeubayam/get_prasadam_details',
        type: 'POST',
        data: { prasadam_group_id: selectedId },
        dataType: 'json',
        success: function(response) {
            console.log('Response:', response);  // Confirm the response
            var detailsDropdown = $('#prasadam_details_select');
            detailsDropdown.empty(); // Clear previous options

            response.forEach(function(item) {
                detailsDropdown.append(
                    $('<option></option>').val(item.prasadam_id).text(item.name_eng + ' / ' + item.name_tamil)
                );
            });

            detailsDropdown.selectpicker('refresh');
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', status, error);
        }
    });
});

$('#prasadam_group_select').trigger('change');
</script> -->

<!-- <script>
$(document).ready(function() {
    loadPrasadamDetails();
    
    $('#prasadam_group_select').on('change', function() {
        loadPrasadamDetails();
    });

    $('#prasadam_details_select').on('change', function() {
        var amountPerPax = $(this).find('option:selected').data('amount') || 0;
        $('#amt_per_pax').val(amountPerPax);
        updateAllTotals(); // Update all totals whenever the amount per pax changes
    });

    $('#prasadam_add').on('click', function() {
        var prasadamGroup = $('#prasadam_group_select option:selected').text();
        var prasadamDetails = $('#prasadam_details_select option:selected').text();
        var amountPerPax = parseFloat($('#amt_per_pax').val()) || 0; // Ensures 0 if empty
        var qty = 1; // Initial quantity
        var total = amountPerPax * qty;

        var table = $('#selectedPrasadamTable');
        var rowCount = table.find('tr').length;
        table.append(`<tr>
            <td>${rowCount + 1}</td>
            <td>${prasadamGroup}</td>
            <td>${prasadamDetails}</td>
            <td><input type='number' class='qty' value='${qty}' min='1'></td>
            <td class='total'>${total.toFixed(2)}</td>
            <td><button class='delete' style="border: none; background: none; color: red;"><i class="fas fa-trash-alt"></i></button></td>
        </tr>`);

        updatePrasadamInput(); // Function to serialize table data into hidden input
        setupAmountAndQtyListeners(); // Setup listeners for newly added rows
    });

    function updateAllTotals() {
        $('#selectedPrasadamTable tr').each(function() {
            var row = $(this);
            var qty = parseFloat(row.find('.qty').val()) || 0; // Default to 0 if empty
            var amountPerPax = parseFloat($('#amt_per_pax').val()) || 0; // Ensures 0 if empty
            var total = qty * amountPerPax;
            row.find('.total').text(total.toFixed(2));
        });
        updatePrasadamInput();
    }

    function setupAmountAndQtyListeners() {
        $('#selectedPrasadamTable').on('input', '.qty', function() {
            var row = $(this).closest('tr');
            var qty = parseFloat(row.find('.qty').val()) || 0; // Ensures 0 if empty
            var amountPerPax = parseFloat($('#amt_per_pax').val()) || 0; // Ensures 0 if empty
            var total = qty * amountPerPax;
            row.find('.total').text(total.toFixed(2));
            updatePrasadamInput();
        });

        $('#amt_per_pax').on('input', function() {
            updateAllTotals(); // Update all totals when Amount Per Pax changes
        });

        $('#selectedPrasadamTable').on('click', '.delete', function() {
            $(this).closest('tr').remove();
            updatePrasadamInput();
        });
    }
});

function loadPrasadamDetails() {
    var selectedId = $('#prasadam_group_select').val();
    $.ajax({
        url: '<?php echo base_url(); ?>/templeubayam/get_prasadam_details', 
        type: 'POST',
        data: { prasadam_group_id: selectedId },
        dataType: 'json',
        success: function(response) {
            console.log('Response:', response);
            var detailsDropdown = $('#prasadam_details_select');
            detailsDropdown.empty();
            detailsDropdown.append('<option value="" disabled selected>Select Prasadam Details</option>');
            response.forEach(function(item) {
                detailsDropdown.append(
                    $('<option></option>').val(item.prasadam_id).text(item.name_eng + ' / ' + item.name_tamil).data('amount', item.amount)
                );
            });
            detailsDropdown.selectpicker('refresh');
        }
    });
}

function updatePrasadamInput() {
    var data = [];
    $('#selectedPrasadamTable tr').each(function() {
        var prasadamDetails = $(this).find('td:eq(2)').text();
        var qty = $(this).find('.qty').val();
        var total = $(this).find('.total').text();
        data.push({ prasadam: prasadamDetails, quantity: qty, total: total });
    });
    $('#prasadam_details').val(JSON.stringify(data));
}

</script> -->