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
                                    <input type="hidden" name="date" id="date" value="<?php echo date('Y-m-d'); ?>"  >
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
                                                        <label class="form-label">RM</label>
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
                                  