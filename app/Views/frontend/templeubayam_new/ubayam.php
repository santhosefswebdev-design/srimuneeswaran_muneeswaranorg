<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/vendors/typicons/typicons.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/vendors/css/vendor.bundle.base.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/css/vertical-layout-light/style.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/vendors/mdi/css/materialdesignicons.min.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/style.css">
<link rel="shortcut icon" href="<?php echo base_url(); ?>/assets/archanai/images/favicon.png" />
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/demo.css">
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

    .custom-checkbox input:checked ~ .checkmark {
        background-color: #2196F3;
    }

    .custom-checkbox input:checked ~ .checkmark:after {
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
        margin-top:-2px;
    }

    .itemcountrr #increase {
        margin-left: 0px;
        border-radius: 0 4px 4px 0;
        margin-top:-2px;
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
    body {
        height: 100vh;
        width: 100%;
    }

    .prod::-webkit-scrollbar {
        width: 3px;
    }

    .prod::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .prod::-webkit-scrollbar-thumb {
        background: #d4aa00;
    }

    .prod::-webkit-scrollbar-thumb:hover {
        background: #e91e63;
    }

    a {
        text-decoration: none !important;
    }

    .table tr th {
        border: 1px solid #f7e086;
        font-size: 15px;
        background: #f7ebbb;
        color: #000000;
        font-weight: 500;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table th, .table td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: left;
    }

    .table th {
        background-color: #f2f2f2;
    }

    .table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .pack,
    .pay {
        margin-bottom: 15px;
    }

    .form-label {
        text-transform: uppercase;
        font-size: 13px;
        letter-spacing: 1px;
        color: #333333;
        text-align: left;
        width: 100%;
    }

    .input {
        width: 100%;
        text-align: left;
    }

    select.input {
        color: #000;
    }

    .sidebar-icon-only .sidebar .nav .nav-item .nav-link .menu-title {
        display: block !important;
        font-size: 11px;
        color: #FFFFFF;
    }

    .sidebar .nav .nav-item.active>.nav-link i.menu-icon {
        background: #edc10f;
        padding: 1px;
        list-style: outside;
        border-radius: 5px;
        box-shadow: 2px 5px 15px #00000017;
    }

    .sidebar-icon-only .sidebar .nav .nav-item .nav-link {
        display: block;
        padding-left: 0.25rem;
        padding-right: 0.25rem;
        text-align: center;
        position: static;
    }

    .sidebar-icon-only .sidebar .nav .nav-item .nav-link[aria-expanded] .menu-title {
        padding-top: 7px;
    }

    .sidebar-icon-only .main-panel {
        width: calc(100% - 0px);
    }

    .back {
        background: #00000087;
        padding: 13px;
        color: white;
        min-height: 120px;
    }

    .form-control:focus {
        color: #495057;
        background-color: #fff;
        border-color: #F44336 !important;
        outline: 0;
        box-shadow: none;
    }

    select.form-control:focus {
        outline: 1px solid #F44336;
    }

    .error-input {
        border-color: #F44336 !important;
    }

    .back h5 {
        min-height: 80px;
        font-size: 15px;
        font-weight: bold;
        color: #FFFFFF;
    }

    #error_msg,
    .form_error {
        color: red;
    }

    .greensubmit {
        background: #ab8a04 !important;
        font-weight: bold !important;
        color: #ffffff !important;
        box-shadow: -1px 10px 20px #ab8a04;
        background: #ab8a04 !important;
        background: -moz-linear-gradient(left, #ab8a04 0%, #ab8a04 80%, #ab8a04 100%) !important;
        background: -webkit-linear-gradient(left, #ab8a04 0%, #ab8a04 80%, #ab8a04 100%) !important;
        background: linear-gradient(to right, #ab8a04 0%, #ab8a04 80%, #ab8a04 100%) !important;
    }




    #filters {
        margin: 0 0 10px;
        padding: 0;
        list-style: none;
        width: 100%;
        overflow: auto;
        display: inherit;
    }

    #filters li:first-child {
        margin-left: 0;
    }

    #filters li {
        float: left;
        background: white;
        margin: 0 7px;
        /*width:100px;
        max-height:95px;
        min-width:95px;*/
    }

    #filters li span {
        display: block;
        padding: 10px;
        text-decoration: none;
        color: #000;
        cursor: pointer;
        transition: color 300ms ease-in-out;
        text-align: center;
        line-height: 1.5em;
        font-size: 14px;
        text-transform: uppercase;
        font-weight: bold;
    }

    #filters li span:hover {
        color: #d4aa00;
    }

    #filters li span.active {
        /*background: #d4aa00;*/
        background: linear-gradient(179deg, rgb(212 170 0) 0%, rgb(197 191 16) 35%, rgb(252 245 6) 100%);
        color: #000;
    }



    #portfoliolist .portfolio {
        display: none;
        float: left;
        overflow: hidden;
        width: 20%;
        padding: 10px;
        
    }

    .portfolio-wrapper {
        overflow: hidden;
        position: relative !important;
        cursor: pointer;
    }

    .portfolio img {
        max-width: 100%;
        position: relative;
        top: 0;
    }

    .portfolio .label {
        position: absolute;
        width: 100%;
        height: 40px;
        bottom: -40px;
    }

    .portfolio .label-bg {
        background: #222;
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
    }

    .portfolio .label-text {
        color: #fff;
        position: relative;
        z-index: 500;
        padding: 5px 8px;
    }

    .portfolio .text-category {
        display: block;
        font-size: 9px;
    }

    ul.payment {
        list-style-type: none;
        width: 100%;
        display: flex;
        justify-content: flex-start;
        margin-bottom:0;
        padding-left:0;
        -webkit-column-count: 3;
        column-count: 3;
        flex-wrap: wrap;
        height:300px;
        overflow:auto;
    }

    .payment li {
        display: inline-block;
        width: 20%;
    }

    input[type="radio"][id^="pay_for"] {
        display: none;
    }
    input[type="radio"][name="payment_mode"] {
        display: none;
    }
    input[type="radio"] {
        /* display: none; */
    }


    .payment li label {
        border: 1px solid #CCC;
        border-radius: 5px;
        line-height: 1.5;
        display: block;
        position: relative;
        margin:10px 10px;
        font-family: inherit;
        min-height: 120px;
        background: #fff;
        cursor: pointer;
        color: #6d5804;
        font-weight: bold;
    }
    .payment li label p {
        font-size:18px;
        margin-bottom:0;
    }

    label:before {
        background-color: white;
        color: white;
        content: " ";
        display: block;
        border-radius: 50%;
        border: 1px solid grey;
        position: absolute;
        top: -10px;
        left: -5px;
        width: 30px;
        height: 30px;
        text-align: center;
        line-height: 28px;
        transition-duration: 0.4s;
        transform: scale(0);
    }

    label i.mdi {
        transition-duration: 0.2s;
        transform-origin: 50% 50%;
        font-size:18px;
        color:#0d2f95;
    }

    :checked + label {
        background:#f6ef08;
        transition-duration: 0.4s;
    }

    :checked + i.mdi{
        transform: scale(0.9);
    }

    ul.payment1 {
        list-style-type: none;
        width: 100%;
        display: flex;
        justify-content: space-between;
        margin-bottom:0;
        padding-left:0;
    }

    .payment1 li {
        display: inline-block;
        text-align:center;
        width:50%;
    }

    .payment1 li label {
        border: 1px solid #CCC;
        border-radius: 5px;
        line-height: 1;
        padding: 5px 2px;
        display: block;
        position: relative;
        margin: 10px 3px;
        cursor: pointer;
        font-weight: bold;
        font-size: 13px;
    }

    .payment1 li label:before {
        background-color: white;
        color: white;
        content: " ";
        display: block;
        border-radius: 50%;
        border: 1px solid grey;
        position: absolute;
        top: -5px;
        left: -5px;
        width: 18px;
        height: 18px;
        text-align: center;
        line-height: 18px;
        transition-duration: 0.4s;
        transform: scale(0);
    }

    .payment1 li label i.mdi {
        transition-duration: 0.2s;
        transform-origin: 50% 50%;
        font-size:18px;
        color:#0d2f95;
    }

    .payment1 li :checked + label {
        
    }

    .payment1 li :checked + label:before {
        /*content: "✓";
        background-color: green;
        transform: scale(1);*/
    }

    .payment1 li label :checked + i.mdi{
        transform: scale(0.9);
    }
    .prod_img { width:90px; min-width:90px; margin:0 auto; border-radius: 50%; min-height:90px; max-height:90px;
        background: #e1e1d68a;
        padding: 5px; }
    .text-muted.arch { 
        color:#000000 !important; 
        font-size:14px;
        text-align:center; padding:10px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis; 
        max-height:50px;
        min-height:50px;
        text-transform:uppercase;
    }
    .ar_btn {
        background: linear-gradient(179deg, rgb(0 126 212) 0%, rgb(16 197 180) 35%, rgb(59 134 209) 100%);
        border-radius: 15px;
        font-weight: bold;
        height: 1.75em;
    }
    .btn { padding: 0.25rem 0.5rem; height: 2rem; }
    .show-cart1 { max-height:350px; overflow:auto; }
    .show-cart1 tr { border-radius:10px; }
    .show-cart1 td { font-size:13px; padding:3px 10px; }
    .total { margin-top:15px; padding-bottom:10px; } 
    .total p { font-size: 24px; font-weight: bold; }
    .tot_amt_txt {
        display: inline;
        width: 126px;
        text-align: right;
        font-size: 26px;
        font-weight: bold;
        border: 0;
        background: white;
        color: black;
    }

    @media (max-width: 960px) {
    .prod_img { width:50px; min-width:50px; margin:0 auto; border-radius: 50%; min-height:50px; max-height:50px;}
    .payment li { width: 25%; }
    .payment1 li label { padding: 15px 1px; margin: 15px 5px; }
    }
    .cal_head {
        background: #f34c22;
        color: #FFF;
        padding: 2px 5px;
    }
    
    #selectedAnnathanamTable {
        width: 100%;  /* Full width to ensure responsiveness */
        table-layout: fixed; /* Keeps the table layout consistent */
    }

    #selectedAnnathanamTable th, #selectedAnnathanamTable td {
        padding: 8px; /* Padding for better readability */
        overflow: hidden; /* Prevents content from spilling out */
        text-overflow: ellipsis; /* Shows ellipsis when text overflows */
        white-space: normal; /* Ensures text stays on a single line */
        cursor: pointer; /* Indicates that the cell is interactive */
    }

        /* Basic reset and box sizing */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* Style the container */
    .payment-options {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 5px; /* space between buttons */
    }

    /* Hide the actual radio input */
    .payment-options .payment_type {
        display: none;
    }

    /* Style labels to look like buttons */
    .payment-options .btn-payment {
        padding: 5px 8px;
        cursor: pointer;
        background-color: #f0f0f0;
        border: 1px solid #ccc;
        transition: background-color 0.3s, color 0.3s;
        display: inline-block;
        border-radius: 5px;
    }

    /* Change style when radio is checked */
    .payment-options .payment_type:checked + .btn-payment {
        background-color: #008000; /* Green */
        color: white;
    }

    /* Hover effect for the buttons */
    .payment-options .btn-payment:hover {
        background-color: #45a049;
    }

    .row.clearfix {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        border-bottom: 1px dashed #CCC;
        padding: 10px;
    }

    .payment-options {
        flex-grow: 1; /* Takes up the full width of the container */
        display: flex;
        justify-content: center; /* Centers the payment options */
        padding: 5px; /* Additional padding for better spacing */
        background-color: #f9f9f9; /* Optional: for better visibility of padding */
    }

    .partial_paid_sec {
        flex-grow: 1; /* Optional: Allows this section to take equal space */
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .pay-label {
        margin: 0 5px; /* Adds some space between the buttons */
    }
    .button-container {
        display: flex;
        justify-content: center;  /* Centers the content horizontally */
        align-items: center;      /* Centers the content vertically if needed */
        padding: 10px;            /* Adds some padding around the button for spacing */
    }
    .head_sec {
        text-align: left;
        color: white;
        background: #00add4;
        padding: 5px;
    }
    .head_sec:after {
        content: "";
        position: absolute;
        height: 0;
        width: 0;
        left: 96%;
        top: 0;
        border: 20px solid transparent;
        border-left: 20px solid #00add4;
    }
    .text {
        background-color:#ff0000;
        color:#fff;
        display:inline-block;
        padding-left:4px;
    }
    .arrow {
        border-style: dashed;
        border-color: transparent;
        border-width: 0.20em;
        display: -moz-inline-box;
        display: inline-block;
        /* Use font-size to control the size of the arrow. */
        font-size: 100px;
        height: 0;
        line-height: 0;
        position: relative;
        vertical-align: middle;
        width: 0;
        background-color:#fff; /* change background color acc to bg color */ 
        border-left-width: 0.2em;
        border-left-style: solid;
        border-left-color: #ff0000;
        left:0.25em;
    }

</style>


</head>

<body class="sidebar-icon-only">
	<?php if($_SESSION['succ'] != '') { ?>
	  <div class="row" style="padding: 0 30%;margin: 0px 0 15px 0;" id="content_alert">
		  <div class="suc-alert" style="width: 100%;">
			  <span class="suc-closebtn" onClick="this.parentElement.style.display='none';">&times;</span> 
			  <p><?php echo $_SESSION['succ']; ?></p> 
		  </div>
	  </div>
  <?php } ?>
	<?php if($_SESSION['fail'] != '') { ?>
	  <div class="row" style="padding: 0 30%;margin: 0px 0 15px 0;" id="content_alert">
		  <div class="alert" style="width: 100%;">
			  <span class="closebtn" onClick="this.parentElement.style.display='none';">&times;</span> 
			  <p><?php echo $_SESSION['fail']; ?></p>
		  </div>
	  </div>
  <?php } ?>
    <div class="container-scroller">


        <div class="container-fluid page-body-wrapper">

            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="content w-100">
                                <div class="calendar-container">
                                    <div class="calendar">
                                        <div class="year-header">
                                            <span class="left-button fa fa-chevron-left" id="prev">
                                                << </span>
                                                    <span class="year" id="label"></span>
                                                    <span class="right-button fa fa-chevron-right" id="next"> >> </span>
                                        </div>
                                        <table class="months-table w-100">
                                            <tbody>
                                                <tr class="months-row">
                                                    <td class="month">Jan</td>
                                                    <td class="month">Feb</td>
                                                    <td class="month">Mar</td>
                                                    <td class="month">Apr</td>
                                                    <td class="month">May</td>
                                                    <td class="month">Jun</td>
                                                    <td class="month">Jul</td>
                                                    <td class="month">Aug</td>
                                                    <td class="month">Sep</td>
                                                    <td class="month">Oct</td>
                                                    <td class="month">Nov</td>
                                                    <td class="month">Dec</td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <table class="days-table w-100">
                                            <td class="day">Sun</td>
                                            <td class="day">Mon</td>
                                            <td class="day">Tue</td>
                                            <td class="day">Wed</td>
                                            <td class="day">Thu</td>
                                            <td class="day">Fri</td>
                                            <td class="day">Sat</td>
                                        </table>
                                        <div class="frame">
                                            <table class="dates-table w-100">
                                                <tbody class="tbody">
                                                </tbody>
                                            </table>
                                        </div>
                                        <button class="button" disabled id="add-button">Add Event</button>
                                    </div>
                                </div>
                                <div class="events-container"></div>
                                <div class="dialog prod" id="dialog"> 
                                    <!--h4 class="dialog-header" style=" background:#d4aa00;color:#FFFFFF;"> Add New Event </h4-->
                                    <form class="form" id="form" method="post">
                                        <input type="hidden" id="ubhayam_date" name="ubhayam_date" class="form-control" value="<?php echo date("Y-m-d"); ?>">
                                        <input type="hidden" id="booking_date" name="booking_date" class="form-control" value="<?php echo date("Y-m-d"); ?>">
                                        <input type="hidden" id="booking_type" name="booking_type" value="2">
                                        <input type="hidden" id="save_booking" name="save_booking" value="1">
                                        <!-- <input type="hidden" id="payment_type" name="payment_type" value="full"> -->
                                        <input type="hidden" id="booking_through" name="booking_through" value="COUNTER">
                                        <?php $user_id = $_SESSION['log_id_frend']; ?>
                                        <input type="hidden" id="user_id" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>">
                                        <input type="hidden" name="block_day_count" id="block_day_count" value="<?php echo $setting['block_day_count']; ?>">
                                        <input class="input1" type="hidden" id="date" name="date" value="<?php echo date('Y-m-d'); ?>">
                                        <input type="hidden" name="term_setting" id="term_setting" class="form-control" value="<?php echo $setting['enable_terms']; ?>">
                                        <div class="form-container card-body" align="center">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <h4 style="margin-bottom:5px; margin-top:5px; color:#FFFFFF; background:#d4aa00;">Choose Slot</h4>
                                                        <table class="table table-bordered ">
                                                            <tbody>
                                                                <tr>
                                                                    <?php // echo print_r($time_list);
                                                                    $i=0; foreach($time_list as $row) { 
                                                                        // if (in_array($row['id'], $data_time)) { $disabled = ""; $t_name = $time_name[$row['id']];}
                                                                        // else  { $disabled = ""; $t_name = ''; };
                                                                    ?>
                                                                    <td>
                                                                        <input style="left: 2%; opacity: 1;position: inherit;" type="radio" class="booking_slot" name="booking_slot[]" value="<?php echo $row['id']; ?>">
                                                                        <?php echo $row['slot_name'];?>
                                                                    </td>
                                                                    <?php } ?>
                                                                </tr>
                                                                
                                                            </tbody>
                                                        </table>
                                                        <h4 style="margin-bottom:5px; margin-top:5px; color:#FFFFFF; background:#d4aa00;">Choose Any Packages</h4>
                                                            <!-- <ul class="payment prod" id="pay_for"></ul> -->

                                                            <div class="row prod product" id="add_one" style="min-height:120px;">
                                                                <?php // print_r($package); 
                                                                foreach($package as $row) { ?>
                                                                            
                                                                    <div class="portfolio col-md-3" data-cat="">
                                                                        <input type="radio" class="ubayam_slot" name="pay_for" value="<?php echo $row['id']; ?>" id="pay_for<?php echo $row['id']; ?>" />
                                                                        <label class="card" for="pay_for<?php echo $row['id']; ?>" onclick="payfor(<?php echo $row['id']; ?>)">
                                                                            <img class="img-fluid prod_img" src="<?php  echo base_url(); ?>/uploads/package/<?php  echo $row['image']; ?>">
                                                                            <div class="d-flex justify-content-between align-items-center mb-2 mt-2" style="flex-direction: column;">
                                                                                <p class="mb-0 text-muted arch" id="pay_name<?php echo $row['id']; ?>"><?php echo $row['name']; ?></p>
                                                                            </div>
                                                                        </label>
                                                                    </div>
                                                                <?php } ?>
                                                                
                                                                                        
                                                                <?php 
                                                                foreach($package as $row) { ?>
                                                                    <!-- <div class="col-xl-3 col-sm-6 col-lg-3 col-md-4 grid-margin stretch-card portfolio <?php if(!empty($key)) { echo str_replace(' ', '_', strtolower($key)); } ?>" data-cat="<?php if(!empty($key)) { echo str_replace(' ', '_', strtolower($key)); } ?>" >
                                                                    <div class="card">
                                                                            <a href="#" data-product_id="<?php echo $row['id']; ?>" data-name="<?php echo str_replace(' ', '_', strtolower($row['name'])); ?>" data-price="<?php echo number_format((float)($row['amount']), 2);?>" class="add-to-cart"  data-category="<?php echo $row['name']; ?>" data-group="<?php echo $row['name']; ?>">
                                                                        <div class="card-body d-flex flex-column justify-content-between">
                                                                        
                                                                            <div class="d-flex justify-content-between align-items-center mb-2 mt-2" style="flex-direction: column;">
                                                                                <?php
                                                                                $englishName = $row['name'];
                                                                                $tamilName = "";
                                                                                    if (strlen($englishName) > 15) {
                                                                                    
                                                                                        echo '<p class="mb-0 text-muted arch">' . $englishName . '</p>';
                                                                                    } else {
                                                                                        
                                                                                        echo '<p class="mb-0 text-muted arch">' . $englishName . '<br>' . $tamilName . '</p>';
                                                                                    }
                                                                                ?>
                                                                            </div>
                                                                        </div>
                                                                        </a>
                                                                    </div>
                                                                    </div> -->
                                                                <?php } ?>
                        
                                                            </div>

                                                            <div class="row scroll" style="overflow-y:scroll; overflow-x:hidden; height: 200px;display:none;">
                                                                <div class="col-sm-12">
                                                                    <div class="table-responsive">
                                                                        <table class="table table-bordered" style="width:100%" id="package_table" style="height: 150px;">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th width="20%">Name</th>
                                                                                    <th width="45%">Description</th>
                                                                                    <th width="25%">Total(S$)</th>
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

                                                            <h4 style="margin-bottom:5px; margin-top:5px; color:#FFFFFF; background:#d4aa00;">Ubayam Services</h4>
                                                            <br>
                                                            <div style="min-height:150px;">
                                                            <div class="row" style="align-items: center;">
                                                                <div class="col-sm-4">
                                                                    <h5 class="head_sec">Abishegam Detail</h5>
                                                                    <!--h5 class="text">Abishegam Detail<span class="arrow"></span></h5-->
                                                                </div>
                                                                <div class="col-sm-8" align="left">
                                                                    <label style="margin-bottom:0;">Do you wish to add Abishegam for Ubayam?</label><br>
                                                                    <label><input type="radio" class="clear-radio" style="left: 2%; opacity: 1;position: inherit;" name="abishegam" value="yes" onClick="toggleAbishegamSelection(true)"> Yes</label>
                                                                    <label><input type="radio" class="clear-radio" style="left: 2%; opacity: 1;position: inherit;" name="abishegam" value="no" onClick="toggleAbishegamSelection(false)"> No</label>
                                                                </div>
                                                            </div>

                                                            <div id="abishegamSelection" style="display:none;">
                                                                <div class="col-sm-12">
                                                                    <div class="form-group form-float">
                                                                        <div class="form-line">
                                                                            <select class="form-control" id="abishegamDropdown" onChange="addAbishegamToTable()">
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
                                                                                <th width="35%">Amount(S$)</th>
                                                                                <th width="20%">Action</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="selectedAbishegamTable">
                                                                        </tbody>
                                                                    </table>
                                                                    <div style="text-align: right; margin-top: 10px; display: none">
                                                                        <strong>Abishegam Total(S$): <span id="abishegamTotal">0.00</span></strong>
                                                                    </div>
                                                                </div>
                                                                <input type="hidden" id="abishegam_details" name="abishegam_details">
                                                            </div> 
                                                            </div>                                      
                                                            <hr>    
                                                            
                                                            <br>
                                                            <div style="min-height:150px;">
                                                            <div class="row">
                                                                <div class="col-sm-4">
                                                                    <h5 class="head_sec">Homam Detail</h5>
                                                                </div>
                                                                <div class="col-sm-8" align="left">
                                                                    <label style="margin-bottom:0;">Do you wish to add Homam for Ubayam?</label><br>
                                                                    <label><input type="radio" class="clear-radio" style="left: 2%; opacity: 1;position: inherit;" name="homam" value="yes" onClick="toggleHomamSelection(true)"> Yes</label>
                                                                    <label><input type="radio" class="clear-radio" style="left: 2%; opacity: 1;position: inherit;" name="homam" value="no" onClick="toggleHomamSelection(false)"> No</label>
                                                                </div>
                                                            </div>                                       
                                                            <div id="homamSelection" style="display:none;">
                                                                <div class="col-sm-12">
                                                                    <div class="form-group form-float">
                                                                        <div class="form-line">
                                                                            <select class="form-control" id="homamDropdown" onChange="addHomamToTable()">
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
                                                                                <th width="35%">Amount(S$)</th>
                                                                                <th width="20%">Action</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="selectedHomamTable">
                                                                        </tbody>
                                                                    </table>
                                                                    <div style="text-align: right; margin-top: 10px; display: none">
                                                                        <strong>Homam Total(S$): <span id="homamTotal">0.00</span></strong>
                                                                    </div>
                                                                </div>
                                                                <input type="hidden" id="homam_details" name="homam_details">
                                                            </div>
                                                            </div>                                        
                                                            
                                                            
                                                        </div><br><br><br>
                                                            
                                                        <div class="col-md-4">

                                                        <div class="row">
                                                            <div class="col-md-6" style="text-align:left;">
                                                                <p style="margin-top:10px;">
                                                                    <button type="button" class="btn ar_btn btn-info btn-lg" onClick="userModalOpen();">Add Detail</button>    
                                                                </p>
                                                            </div>
                                                            <div class="col-md-6" style="text-align:right;">
                                                                    <p style="margin-top:10px;">
                                                                        <button type="button" class="btn btn-danger btn-lg cl_btn clear-cart" id="clear_all">Clear All</button>
                                                                    </p>
                                                                </div>
                                                        </div>
                                                        

                                                        <table class="show-cart table table-bordered"
                                                            style="width:100%;display:none;">
                                                        </table>
                                                        
                                                        <table class="table table-bordered" style="width:100%;">                                                        
                                                            <tr>
                                                                <th style='padding: 5px 10px;line-height: 20px;width:10%'>Package Name </th>
                                                                <td style='background: #fff;border: 1px solid #dee2e6;padding: 5px 10px;line-height: 20px;'><span id="packname"></span></td>
                                                            </tr>   
                                                        </table>

                                                        <table class="table table-bordered" id="servicesTable" style="width:100%;">
                                                            <thead>
                                                                <tr><th colspan="3" style="text-align: center; font-weight: bold;">Services</th></tr>
                                                                <tr id="serviceDetailsHeader" style="display: none; text-align: center; font-weight: bold;">
                                                                    <th>Name</th>
                                                                    <th>Description</th>
                                                                    <th>Quantity</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="servicesList">
                                                            </tbody>
                                                        </table>

                                                        <div <?php if (!empty($setting['ubayam_discount'])) {
                                                            echo ' style="display: block;"';
                                                        } else
                                                            echo ' style="display: none;"'; ?>>
                                                            <div style="display: flex; gap: 20px; align-items: center;">
                                                                <div>
                                                                    <h5 style="margin-bottom:5px; font-size:16px; margin-top:5px; color:#FFFFFF; background:#d4aa00;">Package Amount</h5>  
                                                                    <input style="text-align: center" type="number" min="0" step="any" id="sub_total" class="form-control" name="sub_total" value="0" readonly>      
                                                                </div>

                                                                <div>
                                                                    <h5 style="margin-bottom:5px; font-size:16px; margin-top:5px; color:#FFFFFF; background:#d4aa00;">Discount</h5>
                                                                    <input style="text-align: center" type="number" min="0" step="any" id="discount_amount" class="form-control" name="discount_amount" value="0">     
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <h4 style="margin-bottom:5px; margin-top:5px; color:#FFFFFF; background:#d4aa00;">Total Amount(S$)</h4>  
                                                        <input type="number" min="0" step="any" id="total_amt" class="form-control" name="total_amt" value="0"
                                                            style="margin-top:20px;font-weight:bold;font-size: 36px;text-align: center;" readonly>

                                                        <div class="row clearfix" style="width:100%; border-bottom:1px dashed #CCC; display: flex; justify-content: center; align-items: center;">
                                                            <div class="payment-options" style="flex-grow: 1; display: flex; justify-content: center;">
                                                                <div class="form-group" style="margin-bottom:0;">
                                                                    <input type="radio" name="payment_type" id="payment_type_full" class="payment_type" value="full" 
                                                                        <?php echo (empty($data['payment_type']) || $data['payment_type'] == 'full') ? 'checked' : ''; ?>>
                                                                    <label for="payment_type_full" class="pay-label btn-payment">Full Payment</label>
                                                                </div>
                                                                <div class="form-group" style="margin-bottom:0;">
                                                                    <input type="radio" name="payment_type" id="payment_type_partial" class="payment_type" value="partial" 
                                                                        <?php echo ($data['payment_type'] == 'partial') ? 'checked' : ''; ?>>
                                                                    <label for="payment_type_partial" class="pay-label btn-payment">Partial Payment</label>
                                                                </div>
                                                                <div class="form-group" style="margin-bottom:0;">
                                                                    <input type="radio" name="payment_type" id="payment_type_only_booking" class="payment_type" value="only_booking" 
                                                                        <?php echo ($data['payment_type'] == 'only_booking') ? 'checked' : ''; ?>>
                                                                    <label for="payment_type_only_booking" class="pay-label btn-payment">Only Booking</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 partial_paid_sec" align="center" style="<?php echo (!empty($data['payment_type']) && $data['payment_type'] == 'partial') ? '' : 'display: none;'; ?>">
                                                                <label class="form-label" align="center">Pay Amount</label>
                                                                <input type="number" name="pay_amt" id="pay_amt" step=".01" class="form-control" value="<?php echo $data['paid_amount'] ?? '0.00'; ?>">
                                                            </div>
                                                        </div>
                                                            
                                                        <ul class="payment1">
                                                        <?php foreach ($payment_mode as $key => $pay) { ?>
                                                                <li>
                                                                    <input type="radio" name="payment_mode" id="cb<?php echo $pay['id']; ?>" value="<?php echo $pay['id']; ?>" data-name="<?php echo $pay['name']; ?>" <?php echo $key === 0 ? 'checked' : ''; ?> />
                                                                    <label for="cb<?php echo $pay['id']; ?>">
                                                                        <?php echo $pay['name']; ?>
                                                                    </label>
                                                                </li>
                                                            <?php } ?>
                                                        </ul>


                                                        <div class="col-sm-12" <?php if(!empty($setting['enable_terms'])){ echo ' style="display: block;"'; }else echo ' style="display: none;"'; ?>>
                                                            <div class="col-sm-12" style="text-align: left;color: #f44336;">
                                                                <div class="form-group">
                                                                    <label for="termsLink" id="termsLabel" style="cursor: pointer;"><i class="fa fa-check-square-o" style="color:red"></i>Terms and conditions</label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <input type="button" value="Save & Book" class="button button-white greensubmit" id="submit">
                                                            
                                                    </div><br><br><br>
                                                        
                                                        

                                                        <div class="col-md-12">
                                                        <hr>
                                                            <h4 style="margin-bottom:5px; margin-top:5px; color:#FFFFFF; background:#d4aa00;">Add-on</h4><br>
                                                            <div class="row">
                                                                <!--<div class="col-sm-4">
                                                                    <h5 style="margin-bottom:5px; margin-top:5px; color:#FFFFFF; background:#d4aa00;">Add-on</h5>
                                                                </div>-->
                                                                <div class="col-sm-8" align="left">
                                                                    <div class="row">
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
                                                                        <input type="hidden" id="pack_amount" name="pack_amount" class="form-control">
                                                                        <div class="col-sm-3 ">
                                                                            <div class="form-group form-float">
                                                                            
                                                                                <div class="form-line focused">
                                                                                    <input type="hidden" id="pack_name_addon">
                                                                                    <input type="number" class="form-control" id="get_pack_amt_addon" placeholder="0.00" >
                                                                                    <!-- <label class="form-label">RM</label> -->
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
                                                                </div>
                                                            </div> 

                                                            <div class="row scroll" style="overflow-y:scroll; overflow-x:hidden; height: 100px;">
                                                                <div class="col-sm-12">
                                                                    <div class="table-responsive">
                                                                        <table class="table table-bordered" style="width:100%" id="package_table_addon" style="height: 150px;">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th width="20%">Name</th>
                                                                                    <th width="20%">Description</th>
                                                                                    <th width="20%">Qty</th>
                                                                                    <th width="10%">Amount(S$)</th>
                                                                                    <th width="20%">Total(S$)</th>
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
                                                            <hr> <br>

                                                            <!-- <h4 style="margin-bottom:5px; margin-top:5px; color:#FFFFFF; background:#d4aa00;">Prasadam</h4><br>
                                                            <div class="scroll products">
                                                                <div class="row">
                                                                    <div class="col-sm-9" align="left">
                                                                        <div class="row">
                                                                            <div class="col-sm-1" style="display: none;">
                                                                                <div class="form-group form-float">
                                                                                    <div class="form-line">
                                                                                        <select id="prasadam_group_select" name="prasadam_group_select" class="form-control">
                                                                                            <option value="">Select Prasadam</option>
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
                                                                                    <select id="prasadam_details_select" name="prasadam_details_select" class="form-control">
                                                                                        <option value="" disabled selected>Select Prasadam Details</option>
                                                                                        
                                                                                    </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            
                                                                            <div class="col-sm-1 ">
                                                                                <div class="form-group form-float">
                                                                                    <div class="form-line" style="border: none;">
                                                                                        <label id="prasadam_add" class="btn btn-success" style="padding: 5px 12px !important;">+</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-3" style="text-align:left">
                                                                                <label style="margin-bottom: 0rem; text-align: center;" align="center"><strong> Select Slot</strong></label><br>
                                                                                <input  type="radio" id="breakfast" name="time" value="Breakfast" class="check_time" >
                                                                                <label for ='breakfast'> Breakfast &nbsp;&nbsp; </label>
                                                                                <input  type="radio" id="lunch" name="time" value="Lunch" class="check_time" >
                                                                                <label for ='lunch'> Lunch &nbsp;&nbsp; </label>
                                                                                <input  type="radio" id="dinner" name="time" value="Dinner" class="check_time" >
                                                                                <label for ='dinner'> Dinner &nbsp;&nbsp; </label>
                                                                            </div>
                                                                            <div class="col-md-3" id="time-picker-container" style="margin-bottom: 15px;">
                                                                                <label for="hour"><strong>Select Time: </strong></label>
                                                                                <div style="display: flex; gap: 10px;">
                                                                                    <select id="hour" name="hour" class="form-control" style="display:inline-block;">
                                                                                        
                                                                                    </select>
                                                                                    :
                                                                                    <select id="minute" name="minute" class="form-control" style="display:inline-block;">
                                                                                    
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
                                                            </div>                                       
                                                            <div class="row scroll" style="overflow-y:scroll; overflow-x:hidden; height: 150px;">
                                                                <div class="col-sm-12">
                                                                    <div class="table-responsive">
                                                                        <table class="table table-bordered" id="selectedPrasadamTable">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th width="5%">S.No</th>
                                                                                    <th width="17%">Prasadam Group</th>
                                                                                    <th width="35%">Prasadam Name</th>
                                                                                    <th width="14%">Qty</th>
                                                                                    <th width="12%">Amount(S$)</th>
                                                                                    <th width="12%">Total(S$)</th>
                                                                                    <th width="5%">Action</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                            </tbody>
                                                                        </table>
                                                                        <input type="hidden" id="prasadamTotal" name="prasadamTotal">
                                                                        <div style="text-align: right; margin-top: 10px; display: none">
                                                                            <strong>Prasadam Total(S$): <span id="prasadamTotalDisplay">0.00</span></strong>
                                                                        </div>
                                                                    </div>
                                                                    <input type="hidden" id="prasadam_details" name="prasadam_details">
                                                                </div>
                                                            </div>  -->

                                                            <div class="col-md-12">
                                                                <h4 style="margin-bottom:5px; margin-top:5px; color:#FFFFFF; background:#d4aa00;">Prasadam</h4><br>
                                                                <div class="row">
                                                                    <div class="col-md-5">                                                                                <label style="margin-bottom: 0rem; text-align: center;" align="center"><strong> Select Slot</strong></label><br>
                                                                        <input  type="radio" id="breakfast" name="time" value="Breakfast" class="check_time" >
                                                                        <label for ='breakfast'> Breakfast &nbsp;&nbsp; </label>
                                                                        <input  type="radio" id="lunch" name="time" value="Lunch" class="check_time" >
                                                                        <label for ='lunch'> Lunch &nbsp;&nbsp; </label>
                                                                        <input  type="radio" id="dinner" name="time" value="Dinner" class="check_time" >
                                                                        <label for ='dinner'> Dinner &nbsp;&nbsp; </label>
                                                                    </div>
                                                                    <div class="col-md-5" id="time-picker-container" style="margin-bottom: 15px;">
                                                                        <label for="hour"><strong>Select Time: </strong></label>
                                                                        <div style="display: flex; gap: 10px;">
                                                                            <select id="hour" name="hour" class="form-control" style="display:inline-block;">
                                                                                
                                                                            </select>
                                                                            :
                                                                            <select id="minute" name="minute" class="form-control" style="display:inline-block;">
                                                                            
                                                                            </select>
                                                                            <select id="ampm" name="ampm" class="form-control" style="display:inline-block;" disabled>
                                                                                <option value="AM">AM</option>
                                                                                <option value="PM">PM</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div><br>

                                                                <div class="scroll products row">
                                                                    <div class="col-sm-5 ">
                                                                        <div class="form-group form-float">
                                                                            <div class="form-line">
                                                                                <select class="form-control" id="add_one_prasadam">
                                                                                    <option value="">Select From</option>
                                                                                    <?php foreach ($prasadam as $row) { ?>
                                                                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name_eng']; ?></option>
                                                                                    <?php } ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                        
                                                                    <div class="col-sm-2 ">
                                                                        <div class="form-group form-float">
                                                                            <div class="form-line focused">
                                                                                <input type="hidden" id="prasadam_name">
                                                                                <input type="number" class="form-control ub_prasadam" id="get_prasadam_amt" placeholder="0.00">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-2 ">
                                                                        <div class="form-group form-float">
                                                                            <div class="form-line" style="border: none;">
                                                                                <label id="prasadam_add" class="btn btn-success" style="padding: 5px 12px !important;">Add</label>       
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row scroll" style="overflow-y:scroll; overflow-x:hidden; height: 200px;">
                                                                    <div class="col-sm-12">
                                                                        <div class="table-responsive">
                                                                            <table class="table table-bordered" style="width:100%" id="prasadam_table" style="height: 150px;">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th style="text-align: center;" width="5%">S.No</th>
                                                                                        <th style="text-align: center;" width="35%">Name</th>
                                                                                        <th style="text-align: center;" width="10%">Qty</th>
                                                                                        <th style="text-align: center;" width="20%">Amount(S$)</th>
                                                                                        <th style="text-align: center;" width="20%">Total Amount(S$)</th>
                                                                                        <th style="text-align: center;" width="10%">Action</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>                
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <h4 style="margin-bottom:5px; margin-top:5px; color:#FFFFFF; background:#d4aa00;">Meals</h4><br>
                                                            <div class="row">
                                                                <div class="col-sm-9" align="left">
                                                                <label>Do you wish to add Meals for Ubayam?</label><br>
                                                                    <label><input type="radio" class="clear-radio" style="left: 2%; opacity: 1;position: inherit;" name="annathanam" value="yes" onClick="toggleAnnathanamSelection(true)"> Yes</label>
                                                                    <label><input type="radio" class="clear-radio" style="left: 2%; opacity: 1;position: inherit;" name="annathanam" value="no" onClick="toggleAnnathanamSelection(false)"> No</label>
                                                                </div>
                                                            </div>  <hr>

                                                            <div id="annathanamSelection" style="display:none;">
                                                                <div class="row">
                                                                    <div class="col-sm-5">
                                                                        <div class="form-group form-float">
                                                                            <div class="form-line">
                                                                                <select class="form-control" name="annathanam_package_select" id="annathanam_package_select">
                                                                                    <option value="">Select meals Types</option>
                                                                                    <?php foreach ($annathanam_packages as $row) { ?>
                                                                                    <option value="<?php echo $row['id']; ?>" data-amount="<?php echo $row['amount']; ?>">
                                                                                        <?php echo $row['name_eng'] . ' / ' . $row['name_tamil']; ?>
                                                                                    </option>
                                                                                    <?php } ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-1 ">
                                                                        <div class="form-group form-float">
                                                                            <div class="form-line" style="border: none;">
                                                                                <label id="annathanam_add" class="btn btn-success" style="padding: 5px 12px !important;">+</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3" style="text-align:left">
                                                                        <label style="margin-bottom: 0rem; text-align: center;" align="center"><strong> Select Slot</strong></label><br>
                                                                        <input  type="radio" id="breakfast1" name="time1" value="Breakfast" class="check_time1" >
                                                                        <label for ='breakfast'> Breakfast &nbsp;&nbsp; </label>
                                                                        <input  type="radio" id="lunch1" name="time1" value="Lunch" class="check_time1" >
                                                                        <label for ='lunch1'> Lunch &nbsp;&nbsp; </label>
                                                                        <input  type="radio" id="dinner1" name="time1" value="Dinner" class="check_time1" >
                                                                        <label for ='dinner1'> Dinner &nbsp;&nbsp; </label>
                                                                    </div>
                                                                    <div class="col-md-3" id="time-picker-container1" style="margin-bottom: 15px;">
                                                                        <label for="hour1"><strong>Select Time: </strong></label>
                                                                        <div style="display: flex; gap: 10px;">
                                                                            <select id="hour1" name="hour1" class="form-control" style="display:inline-block;">
                                                                                
                                                                            </select>
                                                                            :
                                                                            <select id="minute1" name="minute1" class="form-control" style="display:inline-block;">
                                                                            
                                                                            </select>
                                                                            <select id="ampm1" name="ampm1" class="form-control" style="display:inline-block;" disabled>
                                                                                <option value="AM">AM</option>
                                                                                <option value="PM">PM</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="table-responsive col-sm-12">
                                                                        <table class="table table-bordered" id="selectedAnnathanamTable">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th width="6%">S.no</th>
                                                                                    <th width="20%" class="wrap-text">Package Names</th>
                                                                                    <th width="36%" class="wrap-text">Items</th>
                                                                                    <th width="8%">Qty</th>
                                                                                    <th width="11%">Amount(S$)</th>
                                                                                    <th width="8%">Total(S$)</th>
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
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group form-float">
                                                                            <div class="form-line">
                                                                                <select class="form-control" id="annathanam_addon_select">
                                                                                    <option value="">Select addon</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-1 ">
                                                                        <div class="form-group form-float">
                                                                            <div class="form-line" style="border: none;">
                                                                                <label id="addon_add" class="btn btn-success" style="padding: 5px 12px !important;">+</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="table-responsive col-sm-12">
                                                                        <table class="table table-bordered" id="selectedAddonTable">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th width="10%">S.no</th>
                                                                                    <th width="40%">Addon</th>
                                                                                    <th width="10%">Qty</th>
                                                                                    <th width="10%">Amount(S$)</th>
                                                                                    <th width="15%">Total(S$)</th>
                                                                                    <th width="15%">Action</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                            </tbody>
                                                                        </table>
                                                                        <div style="text-align: right; margin-top: 10px; margin-bottom:20px; display: none">
                                                                            <strong>Meals Total(S$): <span id="annathanamDisplayTotal">0.00</span></strong>
                                                                        </div>
                                                                    </div>
                                                                    <input type="hidden" id="annathanamTotal" name="annathanamTotal">
                                                                    <input type="hidden" id="annathanam_addon_details" name="annathanam_addon_details">
                                                                </div>
                                                            </div>

                                                            <div <?php if(!empty($setting['enable_extra_charges'])){ echo ' style="display: block;"'; }else echo ' style="display: none;"'; ?>>
                                                                <h4 style="margin-bottom:5px; margin-top:5px; color:#FFFFFF; background:#d4aa00;">Additional Charges</h4><br>
                                                                <div class="scroll extra-charges row">
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

                                                                <!-- Table to display the added extra charges -->
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

                                                            
                                                            <br><br>

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
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <div class="modal fade" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="termsModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="width:fit-content;">
                <div class="modal-header">
                    <h5 class="modal-title" id="termsModalLabel">Terms and Conditions</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body-terms">
                <?php foreach ($terms as $term): ?>
                    <div class="form-group">
                        <label class="custom-checkbox">
                            <?php echo htmlspecialchars($term); ?>
                            <input type="checkbox" class="term-checkbox" name="terms[]" value="<?php echo htmlspecialchars($term); ?>">
                            <span class="checkmark"></span>
                        </label>
                    </div>
                <?php endforeach; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>


	<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close"
						data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body p-4" style="padding-bottom:10px;">
					<div class="text-center">
						<div class="row">
                             <!-- <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="dt">Ubayam Date <span style="color:red;">*</span></label>
                                                        <input class="input1 form-control" type="date" id="dt" name="dt" autocomplete="off" >
                                                        <span id="error_msg"></span>
                                                    </div>
                                                </div> -->
							<div class="col-md-6">
								<div class="form-group">
									<label class="form-label" for="name">Name <span
											style="color:red;">*</span></label>
									<input class="input1 form-control" type="text" id="name"
										name="name" autocomplete="off">
									<span id="error_msg"></span>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label class="form-label" for="email_id">Email Address
										<!-- <span style="color:red;">*</span> -->
									</label>
									<input class="form-control" type="email" id="email_id"
										name="email" autocomplete="off">
									<!-- <span id="error_msg"></span> -->
									<span class="form_error" id="invalid_email">This email
										is not valid</span>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="form-label" for="mobile">Mobile No<span
											style="color:red;"> *</span></label>
									<div class="row">
										<div class="col-md-4">
											<select class="form-control" name="mobile_code"
												id="phonecode">
												<option value="">Dialing code</option>
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
										<div class="col-md-8">
											<input class="form-control" type="number"
												id="mobile" name="mobile_no" min="0"
												autocomplete="off">
											<span id="error_msg"></span>
										</div>
									</div>

								</div>
							</div>

							<!-- <div class="col-md-6">
								<div class="form-group">
									<label class="form-label" for="ic_number">Ic No /
										Passport No</label>
									<input class="form-control" type="text" id="ic_number"
										name="ic_number" autocomplete="off">
									<span id="error_msg"></span>
								</div>
							</div> -->

							<!-- <div class="col-md-6">
								<div class="form-group">
									<label class="form-label" for="rasi_id">Rasi <span style="color:red;"></span></label>
									    <select class="form-control" name="rasi_id" id="rasi_id">
										    <option value="">Select Rasi</option>
										    <?php foreach ($rasi as $row) { ?>
											    <option value="<?php echo $row['id']; ?>">
												    <?php echo $row['name_eng']; ?>
											    </option>
										    <?php } ?>
									    </select>
									<span id="error_msg"></span>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="form-label" for="natchathra_id">Natchathram <span style="color:red;"></span></label>		
									<input type="hidden" id="natchathram_id" name="natchathram_id" class="form-control">
									<select class="form-control" name="natchathra_id" id="natchathra_id">
										<option value="">Select Natchiram</option>
									</select>
									<span id="error_msg"></span>
								</div>
							</div> -->

							<div class="col-md-6">
								<div class="form-group">
									<label class="form-label" for="address">Address</label>
									<textarea class="form-control" id="address"
										name="address" style="width:100%;"
										autocomplete="off"></textarea>
									<span id="error_msg"></span>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="form-label"
										for="description">Remarks</label>
									<textarea class="form-control" id="description"
										name="description" style="width:100%;"
										autocomplete="off"></textarea>
									<span id="error_msg"></span>
								</div>
							</div>
						</div>


						<button type="button" name="ar_add_btn" id="ar_add_btn"
							class="btn btn-info my-3"
							style="width:100%; font-size:24px; height:auto;margin-bottom: 0 !important;">Submit</button>
					</div>
				</div>
			</div>
		</div>
	</div>


    <div id="alertModal" class="modal fade" tabindex="-1" rele="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!--div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div-->
                <div class="modal-body">
                    <p style="text-align:center;"><br><i class="mdi mdi-alert-circle-outline"
                            style="font-size:42px; color:red;"></i></p>
                    <h5 style="text-align:center;" id="modalMsg"></h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>


    <!--REPRINT SECTION START-->
    <div id="myModal_reprint" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true"> 
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body p-4" style="padding-bottom:10px;">
                    <div class="text-center">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered" style="width:100%">
                                    <thead>
                                        <tr style="font-size: 13px;text-align: left;background: #3F51B5;color: #fff;">
                                            <th style="width: 10%;padding: 5px 10px;text-align:center;">S.No</th>
                                            <th style="width: 40%;padding: 5px 10px;text-align:center;">Invoice No</th>
                                            <th style="width: 40%;padding: 5px 10px;text-align:center;">Amount</th>
                                            <th style="width: 10%;padding: 5px 10px;text-align:center;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody style="height:auto; margin-bottom:30px;">
                                        <?php
                                        if (count($reprintlists) > 0) {
                                            $ire = 1;
                                            foreach ($reprintlists as $reprintlist) {
                                                ?>
                                                <tr>
                                                    <td style="width: 10%;padding: 5px 0px!important;text-align:center;">
                                                        <?php echo $ire; ?>
                                                    </td>
                                                    <td style="width: 40%;padding: 5px 0px!important;text-align:center;">
                                                        <?php echo $reprintlist['ref_no']; ?>
                                                    </td>
                                                    <td style="width: 40%;padding: 5px 0px!important;text-align:center;">
                                                        <?php echo $reprintlist['paidamount']; ?>
                                                    </td>
                                                    <td style="width: 10%;padding: 5px 0px!important;text-align:center;">
                                                        <a class='btn btn-primary'
                                                            style='font-size: 13px;font-weight: bold;padding: 6px 10px;background: #2196F3;border: 1px solid #2196F3;'
                                                            title='Print'
                                                            href='<?php echo base_url(); ?>/ubayam_online/reprint_booking/<?php echo $reprintlist['id']; ?>'
                                                            target='_blank'>Print</a>
                                                    </td>
                                                </tr>
                                                <?php
                                                $ire++;
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="prin_page"></div>
    <!-- container-scroller -->
    <script src="<?php echo base_url(); ?>/assets/archanai/js/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> 
    <!-- base:js -->
    <script src="<?php echo base_url(); ?>/assets/archanai/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page-->
    <script src="<?php echo base_url(); ?>/assets/archanai/vendors/chart.js/Chart.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/archanai/js/jquery.cookie.js" type="text/javascript"></script>
    <!-- End plugin js for this page-->
    <!-- inject:js -->
    <script src="<?php echo base_url(); ?>/assets/archanai/js/off-canvas.js"></script>
    <script src="<?php echo base_url(); ?>/assets/archanai/js/hoverable-collapse.js"></script>
    <script src="<?php echo base_url(); ?>/assets/archanai/js/template.js"></script>
    <script src="<?php echo base_url(); ?>/assets/archanai/js/settings.js"></script>
    <script src="<?php echo base_url(); ?>/assets/archanai/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="<?php echo base_url(); ?>/assets/archanai/js/dashboard.js"></script>
    <script  src="<?php echo base_url(); ?>/assets/archanai/script.js"></script>

    <script src="<?php echo base_url(); ?>/assets/archanai/js/popper.js"></script>
    
    <link href="<?php echo base_url(); ?>/assets/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
    <script src="<?php echo base_url(); ?>/assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/ui_jquery/jquery-ui.css">
    <script src="<?php echo base_url(); ?>/assets/ui_jquery/jquery-ui.js"></script>
    <script src="<?php echo base_url(); ?>/assets/ui_jquery/moment.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#clear_all').click(function () {
                var servicesList = $('#servicesList');
                servicesList.empty(); 
                userDetail.clearUser();
                $("#serviceDetailsHeader").hide(); 
                $('#add_one, .ubayam_slot, .booking_slot, .clear-radio').prop('checked', false);
                $("#extra_charges_table tbody, selectedHomamTable tbody").empty(); 
                $("#selectedAddonTable tbody, selectedAbishegamTable tbody").empty(); 
                $('input[name="payment_mode"]').prop('checked', false);
                $("#total_amt").val('');
                $("#deposit_amt").val('');
                $('#add_one').html('');
                $("#package_table_addon tbody").empty();
                $("#selectedAnnathanamTable tbody").empty();
                $("#selectedPrasadamTable tbody").empty();
                $('.show-cart').hide();
                toggleAnnathanamSelection(false);
                toggleAbishegamSelection(false);
                toggleHomamSelection(false);
            });

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
            });

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
            });
        });

        $(document).ready(function() {
            $('#rasi_id').change(function() {
                var rasiId = $(this).val();  // Get the selected rasi id

                if (rasiId != "") {
                    $.ajax({
                        url: '<?php echo base_url(); ?>/templeubayam_online/get_natchathram',
                        type: 'post',
                        data: { rasi_id: rasiId },
                        dataType: 'json',
                        success: function(response) {
                            console.log('natchathiram:', response);
                            var natchathramDropdown = $('#natchathra_id');
                            natchathramDropdown.empty();  // Clear existing options
                            natchathramDropdown.append('<option value="">Select Natchathiram</option>');

                            if (response.natchathra_id) {
                                var str = response.natchathra_id;

                                $.each(str.split(','), function(key, value) {
                                    $.ajax({
                                        url: '<?php echo base_url(); ?>/templeubayam_online/get_natchathram_name',
                                        type: 'post',
                                        data: { id: value },
                                        dataType: 'json',
                                        success: function(natchathraResponse) {
                                            natchathramDropdown.append('<option value="' + natchathraResponse.id + '">' + natchathraResponse.name_eng + '</option>');
                                        }
                                    });
                                });
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                        }
                    });
                } else {
                    $('#natchathra_id').empty().append('<option value="">Select Natchathiram</option>');
                }
            });
        });

        $('#termsLabel').on('click', function(event) {
            event.preventDefault();
            var name = $("#name").val();
            var address = $("#address").val();
            var booking_date = $("#ubhayam_date").val();
            var booking_slot = $('input[name="booking_slot[]"]:checked').closest('td').text().trim();
            
            if (name) {
                $.ajax({
                    url: '<?php echo base_url(); ?>/templeubayam_online/get_terms',
                    method: 'POST',
                    data: { name: name },
                    success: function(response) {
                        if (response.success) {
                            $('.modal-body-terms').html(response.terms);
                            $('#termsModal').modal('show');
                        } else {
                            alert('Failed to load terms. Please try again.');
                        }
                    },
                    error: function() {
                        alert('An error occurred. Please try again.');
                    }
                });
            } else {
                alert('Please Add details to view Terms and Conditions.');
            }
        });
    </script>

    <script>
        $("#add_one_prasadam").change(function () {
            var id = $("#add_one_prasadam").val();
            if (id != '') {
                $.ajax({
                    url: "<?php echo base_url(); ?>/templeubayam_online/get_prasadam_amt",
                    type: "post",
                    data: { id: id },
                    dataType: "json",
                    success: function (data) {
                        console.log(data)
                        $("#get_prasadam_amt").val(Number(data['amt']).toFixed(2));
                        $("#prasadam_name").val(data['name']);
                    }
                });
            } else {
                $("#get_prasadam_amt").val(0);
            }
            sum_amount();
        });

        function get_prasadam_name(id, cmlp) {
            if (id != '') {
                $.ajax({
                    url: "<?php echo base_url(); ?>/templeubayam_online/get_prasadam_name",
                    type: "post",
                    data: { id: id },
                    dataType: "json",
                    success: function (data) {
                        console.log('name response:', data);
                        $("#prasadam_name_" + cmlp).val(data['name']);
                    }
                });
            }
        }

        var cnt = 1;
        $("#prasadam_add").click(function () {
            var id = $("#add_one_prasadam option:selected").val();
            var amt = $("#get_prasadam_amt").val();
            var min_qty = 1;

            if (id != '' && parseFloat(amt) > 0) {
                var status_check = 0;
                var rowId;

                $(".prasadam_category").each(function () {
                    var arcat = parseInt($(this).val());
                    if (arcat == id) {
                        status_check++;
                        rowId = $(this).closest('tr').attr('id').replace('rmv_packrow_addon', '');
                    }
                });

                if (status_check > 0) {
                    alert('Product already added to cart');
                } else {
                    $.ajax({
                        url: "<?php echo base_url(); ?>/templeubayam_online/get_prasadam_list",
                        type: "post",
                        data: { id: id },
                        success: function (response) {
                            response = JSON.parse(response);
                            if (response.length > 0) {
                                $.each(response, function (key, value) {
                                    var countid = value.id;
                                    var serviceid = value.id;
                                    var serviceamount = value.amount;
                                    get_prasadam_name(serviceid, countid);
                                    var html_p = '<tr id="rmv_pack_prasadam1' + countid + '">';
                                    html_p += '<td style="width: 5%; text-align: center;">' + cnt + '</td>';
                                    html_p += '<td style="width: 35%; text-align: center;"><input type="hidden" readonly name="prasadam[' + countid + '][id]" value="' + serviceid + '"><input type="text" style="border: none;width: 100%;" readonly id="prasadam_name_' + countid + '" data-amount1="' + serviceamount + '"></td>';
                                    html_p += '<td style="width: 10%; text-align: center;"><div class="itemcountrr"><div class="value-button" id="decrease" onclick="decreaseValue1(' + countid + ')" value="Decrease Value" style="font-weight: bold;font-size: 16px; cursor: pointer;">-</div><input type="number" name="prasadam[' + countid + '][quantity]" min="1" id="quantity1' + countid + '" value="1" pattern="[0-9]*" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" class="qty_amt" style="text-align: center;border: none;border-top: 1px solid #ddd;border-bottom: 1px solid #ddd;margin: 0px;width: 35px;height: 25px;" onkeyup="qtykeyup1(' + countid + ')" /><div class="value-button" id="increase" onclick="increaseValue1(' + countid + ')" value="Increase Value" style="font-weight: bold;font-size: 16px; cursor: pointer;">+</div></div></td>';
                                    html_p += '<td style="width: 20%; text-align: center;"><input type="text" style="border: none;width: 100%; text-align: center;" class="editable_amt_prasadam" id="editable_amt_prasadam_' + countid + '" name="prasadam[' + countid + '][amount]" value="' + Number(serviceamount).toFixed(2) + '" onkeyup="editableAmountKeyUp1(' + countid + ')"></td>';
                                    html_p += '<td style="width: 20%; text-align: center;"><input type="text" style="border: none;width: 100%;" class="package_amt_prasadam" id="package_amt_prasadam_' + countid + '" name="prasadam[' + countid + '][total_amount]" value="' + (Number(serviceamount) * Number(min_qty)).toFixed(2) + '" onkeyup="serviceamount()"></td>';
                                    html_p += '<td style="width: 10%; text-align: center;"><a class="btn btn-danger btn-rad" onclick="rmv_pack_prasadam1(' + countid + ')" style="width:auto;padding: 0px 3px !important;"><i class="material-icons">X</i></a><input type="hidden" class="prasadam_category" value=' + id + '></td>';
                                    html_p += '</tr>';
                                    $("#prasadam_table").append(html_p);
                                });
                                sum_amount();
                                updateSerialNumbers1();
                            }
                        }
                    });
                    $("#get_prasadam_amt").val('');
                    $('#add_one_prasadam').prop('selectedIndex', 0);
                }
            }
        });

        function increaseValue1(cnt) {
            var quantity = $("#quantity1" + cnt);
            var currentVal = parseInt(quantity.val());
            if (!isNaN(currentVal)) {
                quantity.val(currentVal + 1);
                updateAmount1(cnt);
            } else {
                quantity.val(1);
            }
            sum_amount();
        }

        function decreaseValue1(cnt) {
            var quantity = $("#quantity1" + cnt);
            var currentVal = parseInt(quantity.val());
            if (!isNaN(currentVal) && currentVal > 1) {
                quantity.val(currentVal - 1);
                updateAmount1(cnt);
            } else {
                quantity.val(1);
            }
            sum_amount();
        }

        function qtykeyup1(cnt) {
            var quantity = $("#quantity1" + cnt);
            var currentVal = parseInt(quantity.val());
            console.log(currentVal);
            if (!isNaN(currentVal) && currentVal >= 0) {
                if (currentVal > quantity.attr('max')) quantity.val(quantity.attr('max'));
            } else {
                quantity.val(1);
            }
            updateAmount1(cnt);
            sum_amount();
        }

        function editableAmountKeyUp1(cnt) {
            var amountInput = $("#editable_amt_prasadam_" + cnt);
            var val = parseFloat(amountInput.val()) || 0;
            if (val < 0.01) {
                amountInput.val("0.01");
            }
            updateAmount1(cnt, true);
        }

        function updateAmount1(cnt, fromAmountField = false) {
            var quantity = parseInt($("#quantity1" + cnt).val()) || 1;
            if(quantity < 1) {
                quantity = 1;
                $("#quantity1" + cnt).val(quantity);
            }

            var unitPrice = parseFloat($("#editable_amt_prasadam_" + cnt).val()) || 0.01;
            if(unitPrice < 0.01) {
                unitPrice = 0.01;
                $("#editable_amt_prasadam_" + cnt).val(unitPrice.toFixed(2));
            }

            var totalPrice = quantity * unitPrice;
            $("#package_amt_prasadam_" + cnt).val(Number(totalPrice).toFixed(2));
            
            if (!fromAmountField) {
                $("#editable_amt_prasadam_" + cnt).val(Number(unitPrice).toFixed(2));
            }
            sum_amount();
        }

        function rmv_pack_prasadam1(id) {
            $("#rmv_pack_prasadam1" + id).remove();
            sum_amount();
            updateSerialNumbers1();
        }

        function updateSerialNumbers1() {
            $(".prasadam_category").each(function(index) {
                var countId = index + 1;
                $(this).closest('tr').find('td:first').text(countId);
            });
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
            cell4.innerHTML = '<button onclick="deleteAbishegam(this)" style="border: none; background: none; color: red;"><i class="fas fa-trash-alt">X</i></button>';
            

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
        //console.log('abishegam Data:', data);
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
            cell4.innerHTML = '<button onclick="deleteHomam(this)" style="border: none; background: none; color: red;"><i class="fas fa-trash-alt">X</i></button>';

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
        //console.log('Homam Data:', data);
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
                <td data-group-id="${prasadamGroupId}">${prasadamGroup}</td>  <!-- Store prasadam group ID -->
                <td data-prasadam-id="${prasadamId}">${prasadamDetails}</td>  <!-- Store prasadam ID -->
                <td><input type='number' class='qtyy' value='${qty}' min='1' style='width: 50px;'></td>
                <td><input type='number' class='amount-per-pax' value='${amountPerPax}' min='0' step='0.01' style='width: 70px;'></td>
                <td class='total'>${total.toFixed(2)}</td>
                <td><button class='delete' style="border: none; background: none; color: red;"><i class="fas fa-trash-alt">X</i></button></td>
            </tr>`);
            $('#prasadam_details_select').prop('selectedIndex', 0);
            updatePrasadamInput(); // Update the hidden input
        });


        // $('#selectedPrasadamTable').on('input', '.qty, .amount-per-pax', function() {
        //     var row = $(this).closest('tr');
        //     var qty = parseFloat(row.find('.qty').val()) || 0; // Default to 0 if empty
        //     var amountPerPax = parseFloat(row.find('.amount-per-pax').val()) || 0; // Default to 0 if empty
        //     var total = qty * amountPerPax;
        //     row.find('.total').text(total.toFixed(2));
        //     updatePrasadamInput();
        // });

        $('#selectedPrasadamTable').on('input', '.qtyy, .amount-per-pax, .total', function() {
            var row = $(this).closest('tr');
            var qty = parseFloat(row.find('.qtyy').val()) || 0; // Default to 0 if empty or invalid
            var amountPerPax = parseFloat(row.find('.amount-per-pax').val()) || 0; // Default to 0 if empty or invalid
            var total = qty * amountPerPax;
            //console.log('Calculating total:', qty, '*', amountPerPax, '=', total); // Confirm the values in console

            row.find('.total').text(total.toFixed(2)); 
            var new_total = row.find('.total').text();
            console.log('Updated row total:', new_total);
            updatePrasadamInput();
        });

        $('#selectedPrasadamTable').on('click', '.delete', function() {
            $(this).closest('tr').remove();
            updatePrasadamInput();
        });
    });

    function loadPrasadamDetails() {
        var selectedId = $('#prasadam_group_select').val();
        $.ajax({
            url: '<?php echo base_url(); ?>/templeubayam_online/get_prasadam_details', 
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
                //detailsDropdown.selectpicker('refresh');
            }
        });
    }

    function updatePrasadamInput() {
        console.log('Update prsadam function called');
        var data = [];
        $('#selectedPrasadamTable tr').each(function() {
            var cells = $(this).find('td');
            var prasadamGroup = cells.eq(1).text().trim();  // Get prasadam group name
            var prasadamGroupId = cells.eq(1).data('group-id');  // Get prasadam group ID from data attribute
            var prasadamDetails = cells.eq(2).text();  // Get prasadam name
            var prasadamId = cells.eq(2).data('prasadam-id');  // Get prasadam ID
            var qty = $(this).find('.qtyy').val();  // Get quantity
            var amountPerPax = $(this).find('.amount-per-pax').val();  // Get amount per item
            var total = $(this).find('.total').text();  // Get total for the row

            if (prasadamDetails && qty && amountPerPax && total) {
                data.push({
                    prasadam_group: prasadamGroup,
                    prasadam_group_id: prasadamGroupId,  // Include prasadam_group_id
                    prasadam: prasadamDetails,
                    id: prasadamId,
                    qty: qty,
                    amountPerPax: amountPerPax,
                    amount: total
                });
            }
        });

        console.log('Prasadam Data:', JSON.stringify(data));  // Debug the data
        document.getElementById('prasadam_details').value = JSON.stringify(data);  // Update hidden input
        updatePrasadamTotal();  // Update the total
    }

    function updatePrasadamTotal() {
        var prasadamTotal = 0;
        $('#selectedPrasadamTable .total').each(function() {
            prasadamTotal += parseFloat($(this).text()) || 0;
        });
        $('#prasadamTotalDisplay').text(prasadamTotal.toFixed(2));
        $('#prasadamTotal').val(prasadamTotal.toFixed(2));

        sum_amount();
    }

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
                    url: '<?php echo base_url(); ?>/templeubayam_online/getAddonsForPackage',
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
                            <td title="${packageDetails}">${packageDetails}</td>
                            <td title="${itemsDescription}">${itemsDescription}</td>
                            <td><input type='number' class='form-control qty' value='${qty}'></td>
                            <td><input type='number' class='form-control amount' value='${amountPerPax}'></td>
                            <td class='total'>${total.toFixed(2)}</td>
                            <td><button class='btn btn-danger delete'>X</button></td>
                        </tr>`;
            $('#selectedAnnathanamTable tbody').append(newRow);
            $('#annathanam_package_select').prop('selectedIndex', 0);

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
            //addonSelect.selectpicker('refresh');
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
            //console.log('deity_id:', addonId);
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
                            <td><button class='btn btn-danger delete'>X</button></td>
                        </tr>`;
            $('#selectedAddonTable tbody').append(newRow);
            $('#annathanam_addon_select').prop('selectedIndex', 0);
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
                annathanamDetails.push({
                    //packageDetails: $(this).find('td:eq(1)').text().trim(),
                    packageId: $(this).data('package-id'),  // Include package ID
                    qty: $(this).find('.qty').val(),
                    amountPerPax: $(this).find('.amount').val(),
                    total: $(this).find('.total').text()
                });
            });
            $('#selectedAddonTable tbody tr').each(function() {
                annathanamAddonDetails.push({
                    //addonDetails: $(this).find('td:eq(1)').text().trim(),
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
    function updatePaymentSections() {
      var paymentType = $('.payment_type:checked').val(); 

      if (paymentType === 'partial') {
        $('.partial_paid_sec').show();  
        $('.payment1').show();          
        $('#full_paid_amount').prop('disabled', true);  
      } else if (paymentType === 'full') {
        $('.partial_paid_sec').hide();  
        $('.payment1').show();         
        $('#full_paid_amount').prop('disabled', false); 
      } else if (paymentType === 'only_booking') {
        $('.partial_paid_sec').hide();  
        $('.payment1').hide();          
        $('#full_paid_amount').prop('disabled', false); 
      }
    }
    $(document).on('change', '.payment_type', function() {
      updatePaymentSections();  
    });

    updatePaymentSections();  
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
    function sum_amount() {
        var total = 0;
        var pack_amount = parseFloat($("#pack_amount").val());
            total += pack_amount;

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
        $('.package_amt_prasadam').each(function() {
            total += parseFloat($(this).val());
        });
        $("#sub_total").val(Number(total).toFixed(2));


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

        $("#total_amt").val(Number(total).toFixed(2));

    }

</script>


<script>
// $(document).ready(function() {
//     function updatePaymentDetails() {
//         let paymentType = $('input[name="payment_type"]:checked').val();
//         if (paymentType === 'partial') {
//             let payAmount = $('#pay_amt').val();
//             let paymentMode = $('#payment_mode').val();
//             let paymentDetails = {
//                 1: {
//                     paid_date: new Date().toISOString().split('T')[0],  // Current date in YYYY-MM-DD format
//                     amount: parseFloat(payAmount).toFixed(2),  // Ensure two decimal places
//                     payment_mode: paymentMode  // Assuming '1' as a placeholder for the actual payment mode
//                 }
//             };
//             $('#payment_details').val(JSON.stringify(paymentDetails));  
//         } else {
//             $('#payment_details').val('');  
//         }
//     }

//     $('.payment_type').change(function() {
//         updatePaymentDetails();
//     });

//     $('#pay_amt').change(function() {
//         updatePaymentDetails();
//     });
// });
</script>


   <script>

//$(function() {
//var filterList = {
//   init: function() {
    // MixItUp plugin
    // http://mixitup.io
//     $('#portfoliolist').mixItUp({
//       selectors: {
//         target: '.portfolio',
//         filter: '.filter'
//       },
//       load: {
//         filter: '.<?php /*echo $default;*/ ?>'
//       }
//     });

//   }

//};
// Run the show!
//filterList.init();
//});




    function rePrint()
    {
        $("#myModal_reprint").modal("show");
    }
    var userDetail = (function() {
        user = [];
        // Constructor
        function Item(date,name,email_id,phonecode,mobile,rasi_id,rasi_text,natchathra_id,natchathra_text,address,description) {
            this.date = date;
            this.name = name;
            this.email_id = email_id;
            this.phonecode = phonecode;
            this.mobile = mobile;
            this.rasi_id = rasi_id;
            this.rasi_text = rasi_text;
            this.natchathra_id = natchathra_id;
            this.natchathra_text = natchathra_text;
            this.address = address;
            this.description = description;
        }
        // Save user
        function saveUser() {
            sessionStorage.setItem('ubayam_userdetails', JSON.stringify(user));
        }
            // Load user
        function loadUser() {
            user = JSON.parse(sessionStorage.getItem('ubayam_userdetails'));
        }
        if (sessionStorage.getItem("ubayam_userdetails") != null) {
            loadUser();
        }
        var obj = {};
        // Add to user
        obj.addUserToCart = function(date,name,email_id,phonecode,mobile,rasi_id,rasi_text,natchathra_id,natchathra_text,address,description) {
            var item = new Item(date,name,email_id,phonecode,mobile,rasi_id,rasi_text,natchathra_id,natchathra_text,address,description);
            user.push(item);
            saveUser();
        }
        // clear user
        obj.clearUser = function() {
            user = [];
            saveUser();
        }
        // List user
        obj.listUser = function() {
            return user;
        }
        return obj;
    })();

    // var userDetail = (function() {
    // var user = [];

    // // Constructor
    // function Item(date, name, email_id, phonecode, mobile, rasi_id, rasi_text, natchathra_id, natchathra_text, address, description) {
    //     this.date = date;
    //     this.name = name;
    //     this.email_id = email_id;
    //     this.phonecode = phonecode;
    //     this.mobile = mobile;
    //     this.rasi_id = rasi_id;
    //     this.rasi_text = rasi_text;
    //     this.natchathra_id = natchathra_id;
    //     this.natchathra_text = natchathra_text;
    //     this.address = address;
    //     this.description = description;
    // }

    // var obj = {};

    // // Add user to the list
    // obj.addUser = function(date, name, email_id, phonecode, mobile, rasi_id, rasi_text, natchathra_id, natchathra_text, address, description) {
    //     var item = new Item(date, name, email_id, phonecode, mobile, rasi_id, rasi_text, natchathra_id, natchathra_text, address, description);
    //     user.push(item);
    // };

    // // Clear all users from the list
    // obj.clearUser = function() {
    //     user = [];
    // };

    // // List all users
    // obj.listUser = function() {
    //     return user;
    // };

    // return obj;
    // })();

             function userModalOpen() {
                $("#myModal").modal("show");
                var cartArray = userDetail.listUser();
                if (cartArray.length > 0) {
                    $('#name').val(cartArray[0].name);
                    $('#email_id').val(cartArray[0].email_id);
                    $('#phonecode').val(cartArray[0].phonecode);
                    $('#mobile').val(cartArray[0].mobile);
                    $('#rasi_id').val(cartArray[0].rasi_id);
                    $('#natchathra_id').val(cartArray[0].natchathra_id);
                    $('#address').val(cartArray[0].address);
                    $('#description').val(cartArray[0].description);
                    $('.show-cart').show();
                } else {
                    $('#name').val("");
                    $('#email_id').val("");
                    $('#phonecode').val("+65");
                    $('#mobile').val("");
                    $('#rasi_id').val("");
                    $('#natchathra_id').val("");
                    $('#address').val("");
                    $('#description').val("");
                    $('.show-cart').empty();
                    $('.show-cart').hide();
                }
            }

            $('.form_error').hide();

            $('#ar_add_btn').click(function (event) {
                userDetail.clearUser();
                event.preventDefault();

                var name = $('#name').val();
                var mobile = $('#mobile').val();

                // Validate required fields
                if (name == "") {
                    $('#name').siblings('#error_msg').text('Name is required');
                } else {
                    $('#name').siblings('#error_msg').text('');
                }

                if (mobile == "") {
                    $('#mobile').siblings('#error_msg').text('Mobile is required');
                } else {
                    $('#mobile').siblings('#error_msg').text('');
                }

                // Validate optional fields
                $('.form-control').not('#name, #mobile').each(function () {
                    if ($(this).val() != "") {
                        $(this).siblings('#error_msg').text('');
                    }
                });

                // Check if any required field is empty
                if (name == "" || mobile == "") {
                    return; // Stop form submission if required fields are not filled
                }

                var email_id = $('#email_id').val();
                var address = $('#address').val();
                var rasi_id = $('#rasi_id').val();
                var rasi_text = $("#rasi_id option:selected").text();
                var natchathra_id = $('#natchathra_id').val();
                var natchathra_text = $("#natchathra_id option:selected").text();
                var phonecode = $('#phonecode').val();
                var description = $('#description').val();

                //if(name == "") { $(this).siblings("#error_msg").html("Field needs filling"); }
                //if(email_id == "") { $(this).siblings("#error_msg").html("Field needs filling"); }


                // $('.form-control').each(function () {
                //     if ($(this).val() == "") {
                //         $(this).siblings('#error_msg').text('Field needs to Fill');
                //     } else {
                //         $(this).siblings('#error_msg').text('');
                //     }
                // });

                // if(email_id != "") {
                //     if(IsEmail(email_id)==false){
                //         $('#invalid_email').show();
                //         return false;
                //     }
                // }

                function IsEmail(email_id) {
                    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                    if (!regex.test(email_id)) {
                        return false;
                    } else {
                        return true;
                    }
                }


                if (name != "" && mobile != "") {
                    $("#myModal").modal("hide");
                    userDetail.addUserToCart(date, name, email_id, phonecode, mobile, rasi_id, rasi_text, natchathra_id, natchathra_text, address, description);
                    displayCart();
                }
                console.log('Cart Contents:', userDetail.listUser());
            });




            function displayCart() {
                var cartArray = userDetail.listUser();
                if (cartArray.length > 0) {
                    console.log(cartArray);
                    var output = "";
                    output += "<tr>"
                        + "<th style='padding: 5px 10px;line-height: 20px;width:10%'>Name </th><td style='background: #fff;border: 1px solid #dee2e6;padding: 5px 10px;line-height: 20px;'>" + cartArray[0].name + "</td>"
                        + "</tr>";
                    // output += "<tr>"
                    //     + "<th style='padding: 5px 10px;line-height: 20px;width:10%'>Email ID</th><td style='background: #fff;border: 1px solid #dee2e6;padding: 5px 10px;line-height: 20px;'>" + cartArray[0].email_id + "</td>"
                    //     + "</tr>";
                    output += "<tr>"
                        + "<th style='padding: 5px 10px;line-height: 20px;width:10%'>Mobile No </th><td style='background: #fff;border: 1px solid #dee2e6;padding: 5px 10px;line-height: 20px;'>" + cartArray[0].phonecode + " " + cartArray[0].mobile + "</td>"
                        + "</tr>";
                    // output += "<tr>"
                    //     + "<th style='padding: 5px 10px;line-height: 20px;width:10%'>Rasi </th><td style='background: #fff;border: 1px solid #dee2e6;padding: 5px 10px;line-height: 20px;'>" + cartArray[0].rasi_text + "</td>"
                    //     + "</tr>";
                    // output += "<tr>"
                    //     + "<th style='padding: 5px 10px;line-height: 20px;width:10%'>Natchathiram</th><td style='background: #fff;border: 1px solid #dee2e6;padding: 5px 10px;line-height: 20px;'>" + cartArray[0].natchathra_text + "</td>"
                    //     + "</tr>";
                    output += "<tr>"
                    // + "<th style='padding: 5px 10px;line-height: 20px;width:10%'>Address </th><td style='background: #fff;border: 1px solid #dee2e6;padding: 5px 10px;line-height: 20px;'>"+cartArray[0].address+"</td>"
                    + "<th style='padding: 5px 10px;line-height: 20px;width:10%'>Remarks</th><td style='background: #fff;border: 1px solid #dee2e6;padding: 5px 10px;line-height: 20px;'>"+cartArray[0].description+"</td>"
                    + "</tr>";
					output += '<input type="hidden" name="name" value="' + cartArray[0].name + '" />\
						<input type="hidden" name="email" value="' + cartArray[0].email_id + '" />\
						<input type="hidden" name="mobile_code" value="' + cartArray[0].phonecode + '" />\
						<input type="hidden" name="mobile_no" value="' + cartArray[0].mobile + '" />\
						<input type="hidden" name="mobile_code" value="' + cartArray[0].phonecode + '" />\
						<input type="hidden" name="rasi_id" value="' + cartArray[0].rasi_id + '" />\
						<input type="hidden" name="natchathra_id" value="' + cartArray[0].natchathra_id + '" />\
						<input type="hidden" name="address" value="' + cartArray[0].address + '" />\
						<input type="hidden" name="description" value="' + cartArray[0].description + '" />';
                    $('.show-cart').html(output);
                    $('.show-cart').show();
                }
                else {
                    $('#name').val("");
                    $('#email_id').val("");
                    $('#phonecode').val("+65");
                    $('#mobile').val("");
                    $('#rasi_id').val("");
                    $('#natchathra_id').val("");
                    $('#address').val("");
                    $('#description').val("");
                    $('.show-cart').empty();
                    $('.show-cart').hide();
                }
                //alert(cartArray.length);
            }
            displayCart();
           /*  $('#ubhayam_date').change(function () {
                get_booking_ubhayam();
            }); */
            function formatDate(dateString) {
                var options = { day: '2-digit', month: '2-digit', year: 'numeric' };
                var date = new Date(dateString);
                return date.toLocaleDateString('en-GB', options);
            }

            function get_booking_ubhayam(date) {
				// ubhayam_date = $("#ubhayam_date").val(date);
				console.log('ubhayam_date');
				console.log(date);
                if (date != '') {
                    $.ajax({
                        url: "<?php echo base_url(); ?>/ubayam_online/get_booking_ubhayam",
                            type: "post",
                            data: { ubhayamdate: date },
                            success: function (data) {
                                console.log('ubhayam_date');
                                console.log(date);
                                $("#pay_for").html(data);
                            }
                        });
                    }
                }

                $('#discount_amount').on('blur change', function () {
                    sum_amount();
                });

                function payfor(pay_id) {
                    
                    $.ajax({
                        url: "<?php echo base_url() ?>/templeubayam_online/get_payfor_collection",
                        type: "POST",
                        data: { id: pay_id },
                        dataType: "json",
                        success: function (data) {

                            var discount_amount = $('#discount_amount').val();
                            var total_amt = Number(data.amt);
                            var sub_total = Number(data.amt);
                            var max_discount = 0;
                            if (discount_amount) {
                                discount_amount = Number(discount_amount);
                                max_discount = total_amt - 1;
                                if (discount_amount > max_discount) {
                                    discount_amount = max_discount;
                                    $('#discount_amount').val(discount_amount.toFixed(2))
                                }
                                total_amt = total_amt - discount_amount;
                            }

                            $("#total_amt").val(total_amt.toFixed(2));
                            $("#sub_total").val(sub_total.toFixed(2));
                            $("#pack_amount").val(Number(data.amt).toFixed(2));
                            $("#packname").text(data.name);
                            $("#total_amt").prop("max", total_amt.toFixed(2));
                            $("#discount_amount").prop("max", max_discount.toFixed(2));
                            $("#pay_for" + pay_id).prop("checked", true);
                            $("input[name='pay_for']").removeClass("error-input");
                            $(".payment li label").removeClass("error-input");
                            

                            var servicesList = $('#servicesList');
                            servicesList.empty(); 
                            if (data.services && data.services.length > 0) {
                                $("#serviceDetailsHeader").show();

                                data.services.forEach(function(service) {
                                    var row = `<tr>
                                                    <td>${service.name}</td>
                                                    <td>${service.description}</td>
                                                    <td>${service.quantity}</td>
                                            </tr>`;
                                    servicesList.append(row);
                                });
                            } else {
                                $("#serviceDetailsHeader").hide();
                                servicesList.append('<tr><td colspan="3">No services found</td></tr>');
                            }

        
                            if (data.addons.length > 0) {
                                var a_html = '<option value="">Select From</option>';
                                data.addons.forEach(function(value, key) {
                                    a_html += '<option value="' + value.id + '">' + value.name + '</option>';
                                });
                            } else {
                                var a_html = '<option value="">No Addons Found</option>';
                            }
                            $('#add_one_addon').html(a_html);  

                            $("#package_table_addon tbody").empty();
                            $("#pack_row_count_addon").val(0);
                            sum_amount();
                        }
                    });
                }


                // $("#family_add").click(function () {
                //     var family_name = $("#family_name").val();
                //     var family_relationship = $("#family_relationship").val();
                //     var cnt_fmy = parseInt($("#family_row_count").val());
                //     if (family_name != '' && family_relationship != '') {
                //         var html = '<tr id="rmv_familyrow' + cnt_fmy + '">';
                //         html += '<td style="width: 33%;"><input type="text" style="border: none;" readonly name="familly[' + cnt_fmy + '][name]" value="' + family_name + '"></td>';
                //         html += '<td style="width: 33%;"><input type="text" style="border: none;" readonly name="familly[' + cnt_fmy + '][relationship]" value="' + family_relationship + '"></td>';
                //         html += '<td style="width: 33%;"><a class="btn btn-danger btn-rad" onclick="rmv_family(' + cnt_fmy + ')" style="width:auto;padding: 0px 3px !important; color:#fff;"><i class="fa fa-remove"></i></a></td>';
                //         html += '</tr>';
                //         $("#family_table").append(html);
                //         var ct_fmy = parseInt(cnt_fmy + 1);
                //         $("#family_row_count").val(ct_fmy);
                //         $("#family_name").val('');
                //         $("#family_relationship").val('');
                //     }
                // });
                // function rmv_family(id) {
                //     $("#rmv_familyrow" + id).remove();
                // }
                // $(document).ready(function () {
                //     $("#rasi_id").change(function () {
                //         var rasi = $("#rasi_id").val();
                //         if (rasi != "") {
                //             $.ajax({
                //                 url: '<?php echo base_url(); ?>/ubayam_online/get_natchathram',
                //                 type: 'post',
                //                 data: { rasi_id: rasi },
                //                 dataType: 'json',
                //                 success: function (response) {
                //                     $('#natchathram_id').val(response.natchathra_id);

                //                     var str = response.natchathra_id;
                //                     console.log(str);
                //                     //return;
                //                     if (str != "") {
                //                         $("#natchathra_id").empty();

                //                         $('#natchathra_id').append('<option value="">Select Natchiram</option>');
                //                         $.each(str.split(','), function (key, value) {
                //                             //$('#natchathra_id').append('<option value="' + value + '">' + value + '</option>');
                //                             $.ajax({
                //                                 url: '<?php echo base_url(); ?>/ubayam_online/get_natchathram_name',
                //                                 type: 'post',
                //                                 data: { id: value },
                //                                 dataType: 'json',
                //                                 success: function (response) {
                //                                     $('#natchathra_id').append('<option value="' + response.id + '">' + response.name_eng + '</option>');
                //                                     //$('#natchathra_id').prop('selectedIndex',0);
                //                                     //$("#natchathra_id").selectpicker("refresh");
                //                                 }
                //                             });
                //                         });
                //                     }
                //                 }
                //             });
                //         }
                //     });
                // });

                // $("#submit").click(function () {
                //     var total_amt = parseFloat($("#total_amt").val());

                //     var pack_row_count = parseInt($("#pack_row_count").val());
                //     var pay_for = $('.ubayam_slot').filter(':checked').length;
                //     var name = $("#name").val();
                //     //var email_id = $("#email_id").val();
                //     var mobile = $("#mobile").val();
                //     //var rasi_id = $("#rasi_id").val();
                //     //var natchathra_id = $("#natchathra_id").val();
                //     var dt = $("#dt").val();
                //     if (pay_for === 0) {
                //         $("input[name='pay_for']").addClass("error-input");
                //         $(".payment li label").addClass("error-input");
                //         $('html, body').animate({
                //             scrollTop: $("input[name='pay_for']").focus().offset().top - 25
                //         }, 500);
                //     }
                //     else if (total_amt.length === 0 || total_amt == '') {
                //         $("#total_amt").addClass("error-input");
                //         $('html, body').animate({
                //             scrollTop: $("#total_amt").focus().offset().top - 25
                //         }, 500);
                //     }
                //     // else if (dt == "") {
                //     //     //alert("Please enter user details.");
                //     //     $("#modalMsg").text('Please enter user details.');
                //     //     $('#alertModal').modal();
                //     // }
                //     else if (name == "") {
                //         //alert("Please enter user details.");
                //         $("#modalMsg").text('Please enter user details.');
                //         $('#alertModal').modal();
                //     }
                //     // else if(email_id == "")
                //     // {
                //     //     //alert("Please enter user details.");
                //     //     $("#modalMsg").text('Please enter user details.');
                //     //     $('#alertModal').modal();
                //     // }
                //     else if (mobile == "") {
                //         //alert("Please enter user details.");
                //         $("#modalMsg").text('Please enter user details.');
                //         $('#alertModal').modal();
                //     }
                //     // else if(rasi_id == "")
                //     // {
                //     //     //alert("Please enter user details.");
                //     //     $("#modalMsg").text('Please enter user details.');
                //     //     $('#alertModal').modal();
                //     // }
                //     // else if(natchathra_id == "")
                //     // {
                //     //     //alert("Please enter user details.");
                //     //     $("#modalMsg").text('Please enter user details.');
                //     //     $('#alertModal').modal();
                //     // }
                //     else {
                //         $.ajax
                //             ({
                //                 type: "POST",
                //                 url: "<?php echo base_url(); ?>/ubayam_online/save",
                //                 data: $("form").serialize(),
                //                 beforeSend: function () {
                //                     $("#loader").show();
                //                 },
                //                 success: function (data) {
                //                     userDetail.clearUser();
                //                     //location.reload();
                //                     obj = jQuery.parseJSON(data);
                //                     if (obj.err != '') {
                //                         $('#alertModal').modal('show', { backdrop: 'static' });
                //                         $("#spndeddelid").text(obj.err);
                //                     } else {
                //                         window.open("<?php echo base_url(); ?>/ubayam_online/payment_process/" + obj.id, "_blank", "width=680,height=500");
                //                         window.location.reload(true);
                //                     }
                //                 },
                //                 complete: function (data) {
                //                     // Hide image container
                //                     $("#loader").hide();
                //                 }
                //             });
                //     }
                // });
                
$("#submit").click(function(){
    var date = $("#date").val();
    var amount = $("#pay_amt").val();
    var paymentMode = $('input[name="payment_mode"]:checked').val();
    console.log('payment mode:', paymentMode);
    var paymentType = $('input[name="payment_type"]:checked').val();

    if (paymentType === 'partial') {
        var cnt = $("#paymentForm input[type='hidden']").length;  
        
        var hiddenInputs = `<input type="hidden" name="payment_details[${cnt}][paid_date]" value="${date}">
                            <input type="hidden" name="payment_details[${cnt}][amount]" value="${Number(amount).toFixed(2)}">
                            <input type="hidden" name="payment_details[${cnt}][payment_mode]" value="${paymentMode}">`;
        
        $("#form").append(hiddenInputs);
    }

    var pack_row_count = parseInt($("#pack_row_count").val());
    var pay_for = $('.ubayam_slot').filter(':checked').length;
    var name = $("#name").val();
    //var email_id = $("#email_id").val();
    var mobile = $("#mobile").val();
    //var rasi_id = $("#rasi_id").val();
    //var natchathra_id = $("#natchathra_id").val();
    var date = $("#date").val();
	var total_amt       = parseFloat($("#total_amt").val());
	//var check_dep       = parseFloat((total_amt / 100) * 30).toFixed(2);
	//console.log(check_dep);
    // if (pay_for === 0) {
    //     $("input[name='pay_for']").addClass("error-input");
    //     $(".payment li label").addClass("error-input");
    //     $('html, body').animate({
    //         scrollTop: $("input[name='pay_for']").focus().offset().top - 25
    //     }, 500);
    // }
    // else if (total_amt.length === 0 || total_amt == '') {
    //     $("#total_amt").addClass("error-input");
    //     $('html, body').animate({
    //         scrollTop: $("#total_amt").focus().offset().top - 25
    //     }, 500);
    // }
                
    // else

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
            event.preventDefault();
            alert('Please check all Terms & Conditions before saving.');
            exit();
        }
    }

    if (name == "") {
        //alert("Please enter user details.");
        $("#modalMsg").text('Please enter user details.');
        $('#alertModal').modal();
    }
    
    else if (mobile == "") {
        //alert("Please enter user details.");
        $("#modalMsg").text('Please enter user details.');
        $('#alertModal').modal();
    } else {        
	
	$.ajax({
		type: "POST",
		url: "<?php echo base_url();?>/ajax/save_booking",
		data: $("form").serialize(),
		beforeSend: function() {    
			$("#loader").show();
		},
		success: function(data) {
			console.log(data);
			if (typeof data === 'string') {
				try {
					data = JSON.parse(data);
				} catch (e) {
					console.error("Failed to parse JSON response: ", e);
					$('#alertModal').modal('show', { backdrop: 'static' });
					$("#modalMsg").text("An error occurred while processing the response.");
					$("#modalMsg").css("color", "red");
					return;
				}
			}

			if (data.success) {
				if (data.data.status) {
					$('#alertModal').modal('show', { backdrop: 'static' });
					$("#modalMsg").text(data.data.message);
					$("#modalMsg").css("color", "green");
					/* setTimeout(function(){
					}, 2000); */
					var bookingId = data.data.booking_id;
					console.log("Booking ID: " + bookingId);
					// window.location.replace("<?php echo base_url();?>/templeubayam/ubayambook_list?date="+$('#event_date').val());
					// Perform additional actions if needed, e.g., redirect to a confirmation page
                    window.open("<?php echo base_url();?>/templeubayam_online/print_page_ubayam/" + bookingId, '_blank');
                    setTimeout(function() {
                        // Optionally clear user details from the frontend storage if needed
                        if (typeof userDetail !== 'undefined') {
                            userDetail.clearUser();
                        }

                        // Reload the current page
                        window.location.reload();
                    }, 2000);
				} else {
					$('#alertModal').modal('show', { backdrop: 'static' });
					$("#modalMsg").text(data.data.message);
					$("#modalMsg").css("color", "red");
				}
			} else {
				$('#alertModal').modal('show', { backdrop: 'static' });
				$("#modalMsg").text("An error occurred. Please try again later");
				$("#modalMsg").css("color", "red");
			}
		},
		error: function() {
			$('#alertModal').modal('show', { backdrop: 'static' });
			$("#modalMsg").text("An error occurred. Please try again later");
			$("#modalMsg").css("color", "red");
		},
		complete: function() {
			$("#loader").hide();
		}
	});

}
});   

window.onbeforeunload = () => {
  userDetail.clearUser();  
};
                function IsEmail(email) {
                    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                    if (!regex.test(email)) {
                        return 0;
                    } else {
                        return 1;
                    }
                }
                $("#cancel-button").click(function () {
                    $("#name").removeClass("error-input");
                    $("#address").removeClass("error-input");
                    $("#mobile").removeClass("error-input");
                    $("#ic_number").removeClass("error-input");
                    $("#email_id").removeClass("error-input");
                    $("#total_amt").removeClass("error-input");
                    $("input[name='pay_for']").removeClass("error-input");
                    $(".payment li label").removeClass("error-input");
                });
                $('#name').keyup(function () {
                    $("#name").removeClass("error-input");
                });
                $('#address').keyup(function () {
                    $("#address").removeClass("error-input");
                });
                $('#mobile').keyup(function () {
                    $("#mobile").removeClass("error-input");
                });
                $('#ic_number').keyup(function () {
                    $("#ic_number").removeClass("error-input");
                });
                $('#email_id').keyup(function () {
                    $("#email_id").removeClass("error-input");
                });
                $('#total_amt').keyup(function () {
                    $("#total_amt").removeClass("error-input");
                });
            </script>
    
    
    <script>
        
        // MAIN JS FILE START
        (function($) {

	"use strict";

	// Setup the calendar with the current date
$(document).ready(function(){
    var date = new Date();
    var today = date.getDate();
    // Set click handlers for DOM elements
    $(".right-button").click({date: date}, next_year);
    $(".left-button").click({date: date}, prev_year);
    $(".month").click({date: date}, month_click);
    $("#add-button").click({date: date}, new_event);
    // Set current month as active
    $(".months-row").children().eq(date.getMonth()).addClass("active-month");
    init_calendar(date);
    var events = check_events(today, date.getMonth()+1, date.getFullYear());
    show_events(events, months[date.getMonth()], today);
});

// Initialize the calendar by appending the HTML dates
function init_calendar(date) {
    $(".tbody").empty();
    $(".events-container").empty();
    var calendar_days = $(".tbody");
    var month = date.getMonth();
    var year = date.getFullYear();
    var day_count = days_in_month(month, year);
    var row = $("<tr class='table-row'></tr>");
    var today = date.getDate();
    // Set date to 1 to find the first day of the month
    date.setDate(1);
	get_booking_ubhayam(today);
    var first_day = date.getDay();
    // 35+firstDay is the number of date elements to be added to the dates table
    // 35 is from (7 days in a week) * (up to 5 rows of dates in a month)
    for(var i=0; i<35+first_day; i++) {
        // Since some of the elements will be blank, 
        // need to calculate actual date from index
        var day = i-first_day+1;
        // If it is a sunday, make a new row
        if(i%7===0) {
            calendar_days.append(row);
            row = $("<tr class='table-row'></tr>");
        }
        // if current index isn't a day in this month, make it blank
        if(i < first_day || day > day_count) {
            var curr_date = $("<td class='table-date nil'>"+"</td>");
            row.append(curr_date);
        }   
        else {
            var curr_date = $("<td class='table-date'>"+day+"</td>");
            var events = check_events(day, month+1, year);
            if(today===day && $(".active-date").length===0) {
                curr_date.addClass("active-date");
                show_events(events, months[month], day);
            }
            // If this date has any events, style it with .event-date
            if(events.length!==0) {
                curr_date.addClass("event-date");
            }
            // Set onClick handler for clicking a date
            curr_date.click({events: events, month: months[month], day:day, year: year}, date_click);
            row.append(curr_date);
        }
    }
    // Append the last row and set the current year
    calendar_days.append(row);
    $(".year").text(year);
}

// Get the number of days in a given month/year
function days_in_month(month, year) {
    var monthStart = new Date(year, month, 1);
    var monthEnd = new Date(year, month + 1, 1);
    return (monthEnd - monthStart) / (1000 * 60 * 60 * 24);    
}

// Event handler for when a date is clicked
function date_click(event) {
	var today = new Date();
    var cur_day = new Date(event.data.year + '-' + event.data.month + '-' + event.data.day);
    var day_count = parseInt($("#block_day_count").val(), 10);

    var threeDaysAfterToday = new Date(today);
    threeDaysAfterToday.setDate(today.getDate() + day_count); // Add 3 days to today

    if (cur_day <= threeDaysAfterToday) {
        $('#add-button').prop('disabled', true);
        alert("You can book after " + day_count + " days from today's date");
    } else {
        $('#add-button').prop('disabled', false);
    }
    console.log('today:', today);
    console.log('day count:', day_count);
    console.log('cur_date:', cur_day);
    console.log('three days after:', threeDaysAfterToday);

    $(".events-container").show(250);
    $("#dialog").hide(250);
    $(".active-date").removeClass("active-date");
    $(this).addClass("active-date");
	// console.log(event);
    show_events(event.data.events, event.data.month, event.data.day);
};

// Event handler for when a month is clicked
function month_click(event) {
    $(".events-container").show(250);
    $("#dialog").hide(250);
    var date = event.data.date;
    $(".active-month").removeClass("active-month");
    $(this).addClass("active-month");
    var new_month = $(".month").index(this);
    date.setMonth(new_month);
    init_calendar(date);
}

// Event handler for when the year right-button is clicked
function next_year(event) {
    $("#dialog").hide(250);
    var date = event.data.date;
    var new_year = date.getFullYear()+1;
    $("year").html(new_year);
    date.setFullYear(new_year);
    init_calendar(date);
}

// Event handler for when the year left-button is clicked
function prev_year(event) {
    $("#dialog").hide(250);
    var date = event.data.date;
    var new_year = date.getFullYear()-1;
    $("year").html(new_year);
    date.setFullYear(new_year);
    init_calendar(date);
}

// Event handler for clicking the new event button
function new_event(event) {
    // if a date isn't selected then do nothing
    if($(".active-date").length===0)
        return;
    // remove red error input on click
    $("input").click(function(){
        $(this).removeClass("error-input");
    });
    $(function() {
var filterList = {
  init: function() {
    // MixItUp plugin
    // http://mixitup.io
    $('#portfoliolist').mixItUp({
      selectors: {
        target: '.portfolio',
        filter: '.filter'
      },
      load: {
        filter: '.<?php echo $default; ?>'
                    }
                });

            }

        };
        // Run the show!
        filterList.init();
    });
	console.log('event.data.date');
	console.log(event.data);
	var curdate = event.data.date;
	var curday = parseInt($(".active-date").html());
	var event_date = curdate.getFullYear() + "-" + (curdate.getMonth() + 1) + "-" + curday;
	/* $('#dt').val(event_date); */
	$("#ubhayam_date").val(event_date);
	//$("#booking_date").val(event_date);
	get_booking_ubhayam(event_date);
    // loadbookingslots(event_date);
    // empty inputs and hide events
    $("#dialog input[type=text]").val('');
    $("#dialog input[type=number]").val('');
    $(".events-container").hide(250);
    $("#dialog").show(250);
    // Event handler for cancel button
    $("#cancel-button").click(function() {
        $("#name").removeClass("error-input");
        $("#count").removeClass("error-input");
        $("#dialog").hide(250);
        $(".events-container").show(250);
    });
    // Event handler for ok button
    $("#ok-button").unbind().click({date: event.data.date}, function() {
        var date = event.data.date;
        var name = $("#name").val().trim();
        var count = parseInt($("#count").val().trim());
        var day = parseInt($(".active-date").html());
        // Basic form validation
        if(name.length === 0) {
            $("#name").addClass("error-input");
        }
        else if(isNaN(count)) {
            $("#count").addClass("error-input");
        }
        else {
            $("#dialog").hide(250);
            console.log("new event");
            new_event_json(name, count, date, day);
            date.setDate(day);
            init_calendar(date);
        }
    });
}
function loadbookingslots(date)
{
    $.ajax({
        type:"POST",
        url: "<?php echo base_url(); ?>/templeubayam_online/loadbookingslots",
        data: {bookeddate:date},
        success:function(data)
        {
            $("#booking_slot").html(data);
        }
    });
}
// Adds a json event to event_data
function new_event_json(name, count, date, day) {
    var event = {
        "occasion": name,
        "invited_count": count,
        "year": date.getFullYear(),
        "month": date.getMonth()+1,
        "day": day
    };
    event_data["events"].push(event);
}

// Display all events of the selected date in card views
function show_events(events, month, day) {
    // Clear the dates container
    $(".events-container").empty();
    $(".events-container").show(250);
    console.log(event_data["events"]);
    // If there are no events for this date, notify the user
    if(events.length===0) {
        var event_card = $("<div class='event-card'></div>");
        var event_name = $("<div class='event-name'>There are no events planned for "+month+" "+day+".</div>");
        $(event_card).css({ "border-left": "10px solid #FF1744" });
        $(event_card).append(event_name);
        $(".events-container").append(event_card);
    }
    else {
        // Go through and add each event as a card to the events container
        for(var i=0; i<events.length; i++) {
            var event_card = $("<div class='event-card'></div>");
            var event_name = $("<div class='event-name'>Event Detail: "+events[i]["event_name"]+":</div>");
            var event_count = $("<div class='cal_head'>Booked By: "+events[i]["name"]+"</div>");
            $(event_card).append(event_name).append(event_count);
            $(".events-container").append(event_card);
        }
    }
}

// Checks if a specific date has any events
function check_events(day, month, year) {
    var events = [];
    for(var i=0; i<event_data["events"].length; i++) {
        var event = event_data["events"][i];
        if(event["day"]===day &&
            event["month"]===month &&
            event["year"]===year) {
                events.push(event);
            }
    }
    return events;
}

// Given data for events in JSON format
var event_data = <?php echo $ubayams; ?>;

const months = [ 
    "January", 
    "February", 
    "March", 
    "April", 
    "May", 
    "June", 
    "July", 
    "August", 
    "September", 
    "October", 
    "November", 
    "December" 
];

})(jQuery);

// function increaseValue(cnt) {
//     var quantity = $("#quantity" + cnt);
//     var currentVal = parseInt(quantity.val());
//     if (!isNaN(currentVal)) {
// 		if((currentVal + 1) > quantity.attr('max')) quantity.val(quantity.attr('max'));
//         else quantity.val(currentVal + 1);
//         updateAmount(cnt);
//     } else {
//         quantity.val(1);
//     }
//     sum_amount();
// }

//         function decreaseValue(cnt) {
//             console.log("decreaseValue called with cnt: " + cnt);
//             var quantity = $("#quantity" + cnt);
//             var currentVal = parseInt(quantity.val());
//             if (!isNaN(currentVal) && currentVal > 1) {
//                 quantity.val(currentVal - 1);
//                 updateAmount(cnt);
//             } else {
//                 quantity.val(1);
//             }
//             sum_amount();
//         }

//         function qtykeyup(cnt) {
//     var quantity = $("#quantity" + cnt);
//     var currentVal = parseInt(quantity.val());
// 	console.log(currentVal);
// 	console.log();
//     if (!isNaN(currentVal) && currentVal >= 0) {
// 		if(currentVal > quantity.attr('max')) quantity.val(quantity.attr('max'));
//         updateAmount(cnt);
//     } else {
//         quantity.val(1);
//     }
//     sum_amount();
// }

//         function updateAmount(cnt) {
//             console.log("updateAmount called with cnt: " + cnt);
//             var quantity = $("#quantity" + cnt).val();
//             var unitPrice = parseFloat($("#service_name_addon_" + cnt).data('amount'));
//             var totalPrice = quantity * unitPrice;
//             $("#package_amt_addon_" + cnt).val(Number(totalPrice).toFixed(2));
//         }
        
//         function rmv_pack_addon(id) {
//             console.log("rmv_pack_addon called with id: " + id);
//             $("#rmv_packrow_addon" + id).remove();
//             sum_amount();
//         }

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
    updateAmount(cnt);
}

function editableAmountKeyUp(cnt) {
    updateAmount(cnt, true);
}

function updateAmount(cnt, fromAmountField = false) {
    var quantity = parseInt($("#quantity" + cnt).val());
    var unitPrice = parseFloat($("#editable_amt_addon_" + cnt).val()); // Always use the current value from the editable amount input
    var totalPrice = quantity * unitPrice;
    $("#package_amt_addon_" + cnt).val(Number(totalPrice).toFixed(2));
    
    // Only update the editable amount field if the change was not triggered by it
    if (!fromAmountField) {
        $("#editable_amt_addon_" + cnt).val(Number(unitPrice).toFixed(2));
    }
    sum_amount();
}

function rmv_pack_addon(id) {
    $("#rmv_packrow_addon" + id).remove();
    sum_amount();
}


        function serviceamount() {
            sum_amount();
        }

//         function sum_amount() {
//     var total = 0;

//     // Sum the amounts from the package_amt_addon fields
//     $(".package_amt_addon").each(function() {
//         var amount = parseFloat($(this).val());
//         if (!isNaN(amount)) {
//             total += amount;
//         }
//     });
    
//     var pack_amount = parseFloat($("#pack_amount").val());
//     var total_val = total + pack_amount;
//     // Update the total amount field with the new total
//     //$("#total_amt").val(Number(total_val).toFixed(2));
//     //console.log("Total Amount: " + total);
// }

        function get_service_name_addon(id, cmlp) {
            console.log("get_service_name_addon called with id: " + id + " and cmlp: " + cmlp);
            if (id != '') {
                $.ajax({
                    url: "<?php echo base_url();?>/templeubayam_online/get_service_name_addon",
                    type: "post",
                    data: {id: id},
                    dataType: "json",
                    success: function(data){
                        $("#service_name_addon_" + cmlp).val(data['name']);
                        $("#service_description_addon_" + cmlp).val(data['description']);
                    }
                });
            }
        }
        $("#add_one_addon").change(function(){
            var id = $("#add_one_addon").val();
            if(id != ''){
                $.ajax({
                    url: "<?php echo base_url();?>/templeubayam_online/getpack_amt_addon",
                    type: "post",
                    data: {id: id},
                    dataType: "json",
                    success: function(data){
                        console.log(data)
                        $("#get_pack_amt_addon").val(Number(data['amt']).toFixed(2));
                        $("#pack_name_addon").val(data['name']);
                    }
                });
            }else{
                $("#get_pack_amt_addon").val(0);
            }
            sum_amount();
        });
        $("#pack_add_addon").click(function(){
            var id = $("#add_one_addon option:selected").val();
            var cnt = parseInt($("#pack_row_count_addon").val());
            var amt = $("#get_pack_amt_addon").val();
            var package_id = $('.package_id').val();

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
                    $('#add_one_addon').prop('selectedIndex', 0);
                    // $("#add_one_addon").selectpicker("refresh");
                } else {
                    $.ajax({
                        url: "<?php echo base_url();?>/templeubayam_online/get_service_list_addon",
                        type: "post",
                        data: {id: id, package_id: package_id},
                        success: function(response) {
                            response = JSON.parse(response);
                            console.log('received addon', response);
                            if (response.length > 0) {
                                $.each(response, function(key, value) {
                                    var countid = value.id;
                                    var serviceid = value.id;
                                    var quantity = value.quantity;
                                    var serviceamount = value.amount;
                                    get_service_name_addon(serviceid, countid);
                                    var html = '<tr id="rmv_packrow_addon' + countid + '">';
                                    html += '<td style="width: 20%;"><input type="hidden" readonly name="add_on[' + countid + '][id]" value="' + serviceid + '"><input type="text" style="border: none;width: 100%;" readonly id="service_name_addon_' + countid + '" data-amount="' + serviceamount + '"></td>';
                                    html += '<td style="width: 20%;"><input type="text" style="border: none;width: 100%;" id="service_description_addon_' + countid + '"></td>';
                                    html += '<td><div class="itemcountrr"><div class="value-button" id="decrease" onclick="decreaseValue(' + countid + ')" value="Decrease Value" style="font-weight: bold;font-size: 16px; cursor: pointer;">-</div><input type="number" name="add_on[' + countid + '][quantity]" id="quantity' + countid + '" value="1" pattern="[0-9]*" class="qty_amt" style="text-align: center;border: none;border-top: 1px solid #ddd;border-bottom: 1px solid #ddd;margin: 0px;width: 35px;height: 25px;" min="1" max="' + quantity + '" onkeyup="qtykeyup(' + countid + ')" /><div class="value-button" id="increase" onclick="increaseValue(' + countid + ')" value="Increase Value" style="font-weight: bold;font-size: 16px; cursor: pointer;">+</div></div></td>';
                                    html += '<td style="width: 20%;"><input type="text" style="border: none;width: 100%;" class="editable_amt_addon" id="editable_amt_addon_' + countid + '" name="add_on[' + countid + '][amount]" value="' + Number(serviceamount).toFixed(2) + '" onkeyup="editableAmountKeyUp(' + countid + ')"></td>';
                                    html += '<td style="width: 25%;"><input type="text" style="border: none;width: 100%;" class="package_amt_addon" id="package_amt_addon_' + countid + '" name="add_on[' + countid + '][total_amount]" value="' + (Number(serviceamount).toFixed(2) * 1).toFixed(2) + '"></td>';
                                    html += '<td style="width: 10%;"><a class="btn btn-danger btn-rad" onclick="rmv_pack_addon(' + countid + ')" style="width:auto;padding: 0px 3px !important;"><i class="material-icons">X</i></a><input type="hidden" class="package_category_addon" value=' + id + '></td>';
                                    html += '</tr>';
                                    $("#package_table_addon").append(html);
                                });
                                sum_amount();
                            }
                        }
                    });
                    $("#get_pack_amt_addon").val('');
                    $('#add_one_addon').prop('selectedIndex', 0);
                    // $("#add_one_addon").selectpicker("refresh");
                }
            }
        });
        $(document).on('click', '.booking_slot', function(){
            var booking_slot = this.value;
            var booking_date = $('#ubhayam_date').val();
            console.log(booking_slot);
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>/ajax/get_packages_list_new",
                data: {slot_id: booking_slot, booking_date: booking_date, package_type: 2},
                dataType: 'json',
                beforeSend: function() {    
                    // $("#loader").show();
                },
                success: function(data) {
                    console.log('packages data received:', data);
                    if (data.success) {
                        // Generate HTML for packages
                        var packageHtml = '';
                        if(data.data.packages.length > 0){
                            data.data.packages.forEach(function(value, key){
                                packageHtml += '<div class="portfolio col-md-3" data-cat="">';
                                packageHtml += '<input type="radio" class="ubayam_slot" name="pay_for" value="' + value.id + '" id="pay_for' + value.id + '" onclick="createHiddenInput(' + value.id + ')"/>';
                                packageHtml += '<label class="card" style="margin: 10px;" for="pay_for' + value.id + '" onclick="payfor(' + value.id + ')">';
                                packageHtml += '<img class="img-fluid prod_img" src="<?php echo base_url(); ?>/uploads/package/' + value.image + '">';
                                packageHtml += '<div class="d-flex justify-content-between align-items-center mb-2 mt-2" style="flex-direction: column;">';
                                packageHtml += '<p class="mb-0 text-muted arch" id="pay_name' + value.id + '">' + value.name + '</p>';
                                packageHtml += '</div></label></div>';
                            });
                        } else {
                            packageHtml = '<p>No Packages Found</p>';
                        }
                        $('#add_one').html(packageHtml);
                        // $("#add_one").selectpicker("refresh");

                        // Generate HTML for addons
                        var addonHtml = '<option value="">Select From</option>';
                        if(data.data.addons.length > 0){
                            data.data.addons.forEach(function(value, key){
                                addonHtml += '<option value="' + value.id + '">' + value.name + '</option>';
                            });
                        } else {
                            // addonHtml += '<option value="">No Addons Found</option>';
                        }
                        $('#add_one_addon').html(addonHtml);
                        // $("#add_one_addon").selectpicker("refresh");
                        
                        $("#pack_amount").val(0);
                        $("#package_table_addon tbody").empty();
                        $("#pack_row_count_addon").val(0);
                        sum_amount();
                    }
                },
                error: function() {
                    // $('#alert-modal').modal('show', { backdrop: 'static' });
                    // $("#spndeddelid").text("An error occurred. Please try again later");
                    // $("#spndeddelid").css("color", "red");
                    // var packageHtml = '<p>No Packages Found</p>';
                    // $('#add_one').html(packageHtml);
                    // $("#add_one").selectpicker("refresh");
                    // var addonHtml = '<option value="">No Addons Found</option>';
                    // $('#add_one_addon').html(addonHtml);
                    // $("#add_one_addon").selectpicker("refresh");
                },
                complete: function() {
                    // $("#loader").hide();
                }
            });
});

function createHiddenInput(packageId) {
    // Remove any existing hidden input
    $('input[name^="packages["]').remove();

    // Create a new hidden input with the selected package ID
    var hiddenInput = '<input type="hidden" name="packages[' + packageId + '][id]" class="package_id" value="' + packageId + '">';
    $('form').append(hiddenInput);
}
// $('#termsLabel').on('click', function(event) {
//     event.preventDefault();
//     var name = $("#name").val();
//     var ic_number = $("#ic_number").val();
    
//     if (name && ic_number) {
//         // Both name and IC number are provided
//         $.ajax({
//             url: '<?php echo base_url(); ?>/templeubayam_online/get_terms',
//             method: 'POST',
//             data: { name: name, ic_number: ic_number },
//             success: function(response) {
//                 if (response.success) {
//                     $('.modal-body-terms').html(response.terms);
//                     $('#termsModal').modal('show');
//                 } else {
//                     alert('Failed to load terms. Please try again.');
//                 }
//             },
//             error: function() {
//                 alert('An error occurred. Please try again.');
//             }
//         });
//     } else {
//         alert('Please enter both name and IC number.');
//     }
// });
    </script>

<script>
    $(document).ready(function(){
        console.log("Script loaded successfully");
    });
</script>



<script>
function toggleAnnathanamSelection(show) {
    document.getElementById('annathanamSelection').style.display = show ? 'block' : 'none';
}

function addAnnathanamToTable() {
    var select = document.getElementById('annathanamDropdown');
    var table = document.getElementById('selectedAnnathanamTable');
    var rowCount = table.rows.length;
    var deityName = select.options[select.selectedIndex].text.split(' - ')[0];
    var amount = "6.00"; // Fixed amount as per each deity

    if (select.value !== "") {
        var row = table.insertRow();
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);
        cell1.innerHTML = rowCount + 1;
        cell2.innerHTML = deityName;
        cell3.innerHTML = "SGD " + amount;
        cell4.innerHTML = '<button onclick="deleteAnnathanam(this)" style="border: none; background: none; color: red;"><i class="fas fa-trash-alt"></i></button>';

        // Reset the dropdown
        select.selectedIndex = 0;
    }
}

function deleteAnnathanam(button) {
    var row = button.parentNode.parentNode;
    row.parentNode.removeChild(row);

    // Update serial numbers
    var table = document.getElementById('selectedAnnathanamTable');
    for (var i = 0, row; row = table.rows[i]; i++) {
        row.cells[0].innerHTML = i + 1;
    }
}
</script>


<script>

    document.getElementById('termsForm').addEventListener('submit', function(event) {
    
});
//     function togglePayDetails() {
//     var payType = document.querySelector('input[name="payment_type"]:checked').value;
//     var partialDetails = document.querySelectorAll('.partial-payment-details');
    
//     if (payType === 'full') {
//         partialDetails.forEach(function(element) {
//             element.style.display = 'none';
//         });
//         clearPartialPaymentDetails();
//         recalculateBalanceFull();
//     } else {
//         partialDetails.forEach(function(element) {
//             element.style.display = 'block';
//         });
//     }
// }

// function clearPartialPaymentDetails() {
//     document.querySelector("#pay_table tbody").innerHTML = '';
//     document.querySelector("#pay_row_count").value = '1';
    
//     document.querySelector("#deposite_amt").value = '0';
// }

// function recalculateBalanceFull() {
//     var totalAmount = parseFloat(document.querySelector("#total_amt").value) || 0;
//     document.querySelector("#balance").value = totalAmount.toFixed(2);
// }

// document.addEventListener('DOMContentLoaded', function() {
//     togglePayDetails();
// });


    // function get_staff_commision_name(id,cmlp){
    //     //alert(id);
    //     if(id != ''){
    //         $.ajax({
    //             url: "<?php echo base_url(); ?>/hallbooking/get_staff_commision_name",
    //             type: "post",
    //             data: { id: id },
    //             dataType: "json",
    //             success: function (data) {
    //                 //$("#commisiion_name_"+cmlp).addClass("focused");
    //                 $("#commisiion_name_" + cmlp).text("Commission to " + data['name'] + " * ");
    //             }
    //         });
    //     }
    // }
    // function getSelectedOptions(sel) {
    //     $("#commission_append_input_box").empty();
    //     var opts = [],
    //         opt;
    //     var length = $('#commission_to > option').length;
    //     for (var i = 1; i < length; i++) {
    //         opt = sel.options[i];
    //         if (opt.selected) {
    //             opts.push(opt);
    //             //alert(opt);
    //             //alert(i);
    //             //if(opt.value == i)
    //             //{
    //             var staff_id = opt.value;
    //             //alert(staff_id);
    //             get_staff_commision_name(staff_id, i);
    //             var html = '<div class="row" id="rmv_commins' + i + '">';
    //             html += '<div class="col-md-4"><p id="commisiion_name_' + i + '"></p></div>';
    //             html += '<div class="col-md-8"><input type="hidden" name="staff_additional[' + i + '][id]" value="' + staff_id + '"><input type="number" min="0" step="any" style="width:100%" class="form-control" name="staff_additional[' + i + '][amount]" >';
    //             html += '</div>';
    //             html += '</div>';
    //             $("#commission_append_input_box").append(html);
    //             // }
    //         }
    //     }
    //     //return opts;
    // }

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
                url: "<?php echo base_url(); ?>/templeubayam_online/get_service_name_addon",
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
    
</script>
</body>

</html>