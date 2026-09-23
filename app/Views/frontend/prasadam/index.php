<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/vendors/typicons/typicons.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/vendors/css/vendor.bundle.base.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/vendors/mdi/css/materialdesignicons.min.css"/>
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/css/vertical-layout-light/style.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/style.css">
<link rel="shortcut icon" href="<?php echo base_url(); ?>/assets/archanai/images/favicon.png" />
<link href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css" rel="stylesheet">
<style>
  
    .prod-rr img { float: unset !important;
      border-right: 0px !important; }
body { height:100vh; width:100%; }

/*.row { width:100%; }*/
.btn { padding: 0.25rem 0.5rem; height: 2rem; }

.cart { /*height:330px;*/ height:32vh; max-height:32vh; overflow:auto; width:100%; margin-bottom:10px; margin-top:10px; }
select.form-control:not([size]):not([multiple]) {
    height: calc(1.625rem + 2px);
}
.prod::-webkit-scrollbar {
  width: 3px;
}
.prod::-webkit-scrollbar-track, .prod1::-webkit-scrollbar-track {
  background: #f1f1f1; 
}
.prod::-webkit-scrollbar-thumb, .prod1::-webkit-scrollbar-thumb {
  background: #d4aa00; 
}
.prod::-webkit-scrollbar-thumb:hover, .prod1::-webkit-scrollbar-thumb:hover {
  background: #e91e63; 
}

.prod1::-webkit-scrollbar {
  height: 3px;
}
.form-label {
    text-transform: uppercase;
    font-size: 13px;
    letter-spacing: 1px;
    color:#333333;
    text-align: center;
    width: 100%;
}
.input { width:100%; text-align:left; }
select.input { color:#000; }

a { text-decoration:none !important; }
.text-muted.arch { 
	color:#000000 !important; 
	font-size:14px;
	text-align:center; padding:10px 0;
	display: -webkit-box;
	-webkit-line-clamp: 2;
	-webkit-box-orient: vertical;
	overflow: hidden;
	text-overflow: ellipsis; 
	max-height:50px;
	min-height:50px;
	text-transform:uppercase;
}
.show-cart { max-height:350px; overflow:auto; }
.show-cart tr { border-radius:10px; }
.show-cart td { font-size:11px; padding:5px; }
.total { margin-top:0px; padding-bottom:5px; } 
.total p { font-size: 24px; font-weight: bold; }
.submit_btn { width:100%; font-size:22px !important; padding:7px; height:50px; background: #d4aa00; border:#d4aa00; margin-top:1px; }
.amt { padding:3px 5px; font-weight:bold; color:#333333 !important; }
.prod_img { width:90px; margin:0 auto; border-radius: 50%; min-height:90px; max-height:90px;
    background: #e1e1d68a;
    padding: 5px; }
.clear-cart i, .total_cart i { font-size:28px; color:#000000bd;  }
.item-count_new {
    background: #dfdbdb;
    padding: 2px 1px;
    margin: 0 3px;
    border-radius: 5px;
    max-width: 50px;
    min-width: 27px;
    text-align: center;
    font-size: 14px;
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
.count {
    position: absolute;
    left: 28px;
    top: 7px;
    background: #051898;
    border-radius: 50%;
    padding: 2px 7px;
    font-size: 12px;
    color: #FFF;
}
.fade.show {
    opacity: 1;
    background: #abaaaad4;
}
.popup_table { height:50vh; overflow:auto; margin-top:15px; }
.show-cart_popup_table tr th { text-align:left; font-size:12px; font-weight:600; padding:5px; border-bottom:1px solid #E4E4E4; }
.show-cart_popup_table tr td, .show-cart_popup_table tr td p { text-align:left; font-size:11px; padding:5px; line-height:17px; border:0; }

.sidebar-icon-only .sidebar .nav .nav-item .nav-link .menu-title { display:block !important; font-size:11px; color:#FFFFFF; }
.sidebar .nav .nav-item.active > .nav-link i.menu-icon {
    background: #edc10f;
    padding: 1px; list-style:outside;
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
.form-group {
    margin-bottom: 0.5rem;
}
.caticon { font-size:22px; text-align:center; line-height:2em; }
@media (min-width: 1200px) {
.col-xl-3 { flex: 0 0 20%; max-width: 20%; }
}
.sidebar-icon-only .main-panel {
    width: calc(100% - 0px);
}
.ar_btn {
    background: linear-gradient(179deg, rgb(0 126 212) 0%, rgb(16 197 180) 35%, rgb(59 134 209) 100%);
    border-radius: 15px;
    font-weight: bold;
}
.cl_btn {
    background: linear-gradient(179deg, rgb(212 0 0) 0%, rgb(242 105 105) 35%, rgb(209 59 59) 100%);
    border-radius: 15px;
    font-weight: bold;
}
@media (max-width: 960px) {
span.archa_name {
    text-transform: uppercase;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    width: 100px;
    display: inline-block;
}
.btn { padding: 0.25rem 0.35rem !important; }
}

@media (min-width: 992px) {
.cart-clm { max-width: 38%; }
}
.table tr th {
    border: 1px solid #f7e086;
    font-size: 14px;
    background: #f7ebbb;
    color: #333232;
}
#error_msg, .form_error { color:red; }
.products { 
	background:#FFF;
	display: flex;
    flex-wrap: wrap;
    align-items: center; 
	max-height: 500px;
    overflow-y: scroll;
}
.products .col-md-3{ 
	margin-bottom: 0px;
}
.prod { background:#CCCCCC; padding:5px 3px; margin-top:3px; margin-bottom:3px; cursor:pointer; }
.prod img { width:30%; float:left; border-right:1px dashed #999999; }
.prod .detail { width:60%; position:relative; margin-left:40%; }
.prod .detail h4,.prod .detail h5 { font-weight:bold; }
.detail h5 { font-size:11px; }
.prod {
  min-height: 110px;
  background: #CCCCCC;
    padding: 5px 3px;
    margin-top: 3px;
    margin-bottom: 3px;
    cursor: pointer;
}

.radio-group {
        display: flex;
        flex-wrap: wrap; /* Allows wrapping to the next line if there are too many items */
    }
    .radio-item {
        display: flex;
        align-items: center;
        margin-right: 15px; /* Adjust spacing between radio buttons */
    }
    .radio-item input[type="radio"] {
        margin-right: 5px; /* Adjust spacing between radio button and label */
    }
    .col-xl-8 {
        max-width: 65.66667%;
    }
</style>
<style>


.vehicle-table thead, tbody.vehicle-body tr {
    display: table;
    width: 100%;
    table-layout: fixed;
}
.vehicle-table th { font-size:12px; text-align:left; background: #fcf8eb; }
.vehicle-table td { font-size:12px; }
.vehicle-body{
    overflow:auto;
	height:90px;
	display: block;
}

.bal-amt { background:#1def3b; padding:3px 5px; }
.pay_amt p { font-size: 17px; font-weight:bold; }
.navbar + .page-body-wrapper {
    padding-top: calc(3.625rem + 1.875rem);
}
.pay_mode{
    display: block;
    margin-bottom: 0;
    margin-top: 10px;
    width: 100%;
    background: #00d454;
    color: white;
    padding: 5px;
    text-align: center;
    font-size: 16px;
    text-transform: uppercase;
}


#portfoliolist .portfolio {
  display: none;
  float: left;
  overflow: hidden;
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

.container:after {
  content: "\0020";
  display: block;
  height: 0;
  clear: both;
  visibility: hidden;
}

.clearfix:before,
.clearfix:after{
  content: '\0020';
  display: block;
  overflow: hidden;
  visibility: hidden;
  width: 0;
  height: 0;
}

.clearfix {
  zoom: 1;
}

.clear {
  clear: both;
}

.clearfix:after {
  clear: both;
  display: block;
  overflow: hidden;
  visibility: hidden;
  width: 0;
  height: 0;
}

ul.payment {
    list-style-type: none;
    width: 100%;
    display: flex;
    justify-content: space-between;
	margin-bottom:0;
	padding-left:0;
}

.payment li {
    display: inline-block;
    text-align:center;
    width:50%;
}

input[type="radio"][id^="cb"] {
  display: none;
}

input[type="radio"][id^="prasadam_group_"] {
  display: none;
}

.payment li label {
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

.payment li label:before {
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

.payment li label i.mdi {
  transition-duration: 0.2s;
  transform-origin: 50% 50%;
  font-size:18px;
  color:#0d2f95;
}

.payment li :checked + label {
background:#f6ef08;
}
.radio-item{width:48%;}
.radio-item label {
    border: 1px solid #CCC;
    border-radius: 5px;
    line-height: 1;
    padding: 15px;
    display: block;
    position: relative;
    margin: 10px;
    cursor: pointer;
    font-weight: bold;
    text-align:center;
}


.radio-item :checked + label {
background:green;color:#fff;
}

.payment.group li :checked + label {
background:green;color:#fff;
}
.payment.group li :checked + label:before {
    content:""!important;
    background-color: transparent;
    border: 0;
}

.payment li :checked + label:before {
  content: "✓";
  background-color: green;
  transform: scale(1);
}

.payment1 li label :checked + i.mdi{
  transform: scale(0.9);
}
  
.archname { }
.show-cart1 { max-height:350px; overflow:auto; }
.show-cart1 tr { border-radius:10px; }
.show-cart1 td { font-size:13px; padding:3px 10px; }

.row_amt, .row_qty, .row_tot {
    width: 50px; /* Adjust the width as needed */
    text-align: center;
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
    gap: 10px; /* space between buttons */
}

/* Hide the actual radio input */
.payment-options .payment_type {
    display: none;
}

/* Style labels to look like buttons */
.payment-options .btn-payment {
    padding: 5px 15px;
    margin:0;
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
    padding:5px 10px;
}

.payment-options {
    flex-grow: 1; /* Takes up the full width of the container */
    display: flex;
    justify-content: center; /* Centers the payment options */
    padding: 3px 0; /* Additional padding for better spacing */
    background-color: #f9f9f9; /* Optional: for better visibility of padding */
}

.partial_paid_sec {
    flex-grow: 1; /* Optional: Allows this section to take equal space */
    display: flex;
    /*flex-direction: column;*/
    justify-content: center;
    align-items: center;
}

.pay-label {
    margin: 0 10px; /* Adds some space between the buttons */
}
.button-container {
    display: flex;
    justify-content: center;  /* Centers the content horizontally */
    align-items: center;      /* Centers the content vertically if needed */
    padding: 10px;            /* Adds some padding around the button for spacing */
}


</style>

<body class="sidebar-icon-only">
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper">
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row w-100 no-gutters">
          <form method="post" id="prasadam_form">
        	<div class="row w-100">
            <div class="col-xl-8 col-sm-6 col-lg-6 col-md-7 stretch-card flex-column">                              
              <div class="form-group form-float">
                  <div class="radio-group">
                      <?php foreach ($prasadam_groups as $index => $group): ?>
                          <div class="radio-item">
                              <input type="radio" id="prasadam_group_<?php echo $group['id']; ?>" name="prasadam_group" value="<?php echo $group['id']; ?>" class="form-control prasadam-group-radio" <?php echo $index === 0 ? 'checked' : ''; ?>>
                              <label for="prasadam_group_<?php echo $group['id']; ?>" class="form-label"><?php echo $group['group_name']; ?></label>
                          </div>
                      <?php endforeach; ?>
                  </div>
              </div>     

              <div id="products" class="products row scroll" style="background: #f4f5fa;">
                  <!-- Products will be loaded here based on the selected group -->
              </div>

            </div>
            <div class="col-xl-4 col-sm-6 col-lg-6 col-md-5 stretch-card flex-column cart-clm">
              <div class="h-100">
                <div class="stretch-card" style="height:100%;">
                  <div class="card">
                    <div class="card-body">
                      
                        <input type="hidden" name="date" id="date" value="<?php echo date('Y-m-d'); ?>">
                        <input type="hidden" name="billno" id="billno" value="">
                        <div class="d-flex align-items-start flex-wrap">
                          <div class="d-flex justify-content-between" style="width:100%;">
                            <button type="button" class="btn btn-info btn-lg ar_btn" onClick="userModalOpen();">Add Detail</button>
                            <button type="button" class="btn btn-warning btn-lg ar_btn" onClick="rePrint();" style="background: #FFC107;border: 1px solid #FFC107;color: #fff;">Reprint</button>
                            <button type="button" class="btn btn-danger btn-lg cl_btn clear-cart">Clear All</button>
                          </div>
                          <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  </div>
                                  <div class="modal-body p-4" style="padding-bottom:10px;">
                                      <div class="text-center">
                                          <div class="row">
                                              <div class="col-md-6">
                                              <div class="form-group">
                                                  <label class="form-label" for="name">Customer Name <span style="color:red;">*</span></label>
                                                  <input class="form-control" type="text" id="name" name="name" autocomplete="off">
                                              <span class="error_msg"></span></div>
                                              </div>
                                              <div class="col-md-6">
                                                  <div class="form-group">  
                                                      <label class="form-label" for="email_id">Email Address</label>
                                                      <input class="form-control" type="email" id="email_id" name="email_id" autocomplete="off" >
                                                  </div>
                                              </div> 
                                          </div>
                                          <div class="row">
                                            <div class="col-md-6">
                                              <div class="form-group">
                                                <label class="form-label" for="mobile">Mobile No<span style="color:red;">*</span></label>
                                                <div class="row">
                                                  <div class="col-md-4">
                                                    <select class="form-control" name="phonecode" id="phonecode">
                                                      <option value="">Dialing code</option>
                                                        <?php if(!empty($phone_codes))
                                                        {
                                                            foreach($phone_codes as $phone_code)
                                                            {?>
                                                      <option value="<?php echo $phone_code['dailing_code']; ?>" <?php if($phone_code['dailing_code'] == "+65"){ echo "selected";}?>><?php echo $phone_code['dailing_code']; ?></option>
                                                        <?php }   
                                                        }?>           
                                                        
                                                    </select>
                                                  </div>
                                                  <div class="col-md-8">
                                                    <input class="form-control" type="number" id="mobile" name="mobile" min="0" autocomplete="off" >
                                                    <span class="error_msg"></span>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                            <div class="col-md-6">
                                              <div class="form-group">
                                                  <label class="form-label" for="ic_number">Ic No / Passport No</label>
                                                  <input class="form-control" type="text" id="ic_number" name="ic_number" autocomplete="off">
                                              </div>
                                            </div>
                                          </div>
                                          
                                          <div class="row">
                                            <div class="col-md-6">
                                              <div class="form-group">  
                                                <label class="form-label" for="collection_date">Collection Date </label>
                                                <input class="form-control" type="date" id="collection_date" name="collection_date" autocomplete="off" min="<?php echo date('Y-m-d'); ?>">
                                              </div>
                                            </div>
                                            <div class="col-md-6" style="margin: 30px 0;text-align:center">
                                                <p style="margin-bottom: 0rem; text-align: center;"><strong> Select Slot</strong></p><br>
                                                <input  type="radio" id="breakfast" name="time" value="Breakfast" class="check_time" >
                                                <label for ='breakfast'> Breakfast &nbsp;&nbsp; </label>
                                                <input  type="radio" id="lunch" name="time" value="Lunch" class="check_time" >
                                                <label for ='lunch'> Lunch &nbsp;&nbsp; </label>
                                                <input  type="radio" id="dinner" name="time" value="Dinner" class="check_time" >
                                                <label for ='dinner'> Dinner &nbsp;&nbsp; </label>
                                            </div>
                                          </div>

                                          <div class="row">
                                            <div class="col-md-6" id="time-picker-container" style="margin: 20px 0;">
                                                <label for="hour">Select Time:</label>
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
                                            <div class="col-md-6">
                                              <div class="form-group">  
                                                <label class="form-label" for="dob">DOB <span style="color:red;"></span></label>
                                                <input class="form-control" type="date" id="dob" name="dob" autocomplete="off">
                                              </div>
                                            </div> 
                                          </div>
                                          
                                          <div class="row">  
                                            <div class="col-md-6">
                                              <div class="form-group">
                                                <label class="form-label" for="address">Address</label>
                                                <textarea class="form-control" id="address" name="address" style="width:100%;" rows="2">  </textarea>
                                              </div>
                                            </div>
                                            <div class="col-md-6">
                                              <div class="form-group">  
                                                <label class="form-label" for="description">Remarks</label>
                                                <textarea class="form-control" id="description" name="description" style="width:100%;" rows="2" autocomplete="off"></textarea>
                                              </div>
                                            </div>
                                          </div>    

                                      </div>  
                                  <button type="button"  name="ar_add_btn"  id="ar_add_btn" class="btn btn-info my-3"  style="width:100%; font-size:24px; height:auto;margin-bottom: 0 !important;">Submit</button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="prod cart col-md-12 prod-rr" style="background: #fff;">
                          <table class="show-cart cart-table" style="width:100%;">
                                <!-- Cart items will be appended here -->
                          </table>
                        </div>
                        <div class="col-md-12">
                            <table class="show-cart1 table table-bordered" style="width:100%;display:none;"></table>
                        </div>

                        <div class="total d-flex justify-content-between align-items-center" style="width:100%; border-bottom:1px dashed #CCC;">
                        	<p class="mb-0">Total </p>
                            <p class="mb-0">SGD : <span class="total-cart">0.00</span></p>
                            <input type="hidden" id="tot_amt" name="tot_amt" value="0">
                         </div>

                          <div class="row clearfix" style="width:105%; border-bottom:1px dashed #CCC; display: flex; justify-content: center; align-items: center;">
                              <div class="payment-options" style="flex-grow: 1; display: flex; justify-content: space-between;">
                                  <div class="form-group" style="margin-bottom: 0;">
                                      <input type="radio" name="payment_type" id="payment_type_full" class="payment_type" value="full" checked>
                                      <label for="payment_type_full" class="pay-label btn-payment">Full Payment</label>
                                  </div>
                                  <div class="form-group" style="margin-bottom: 0;">
                                      <input type="radio" name="payment_type" id="payment_type_partial" class="payment_type" value="partial">
                                      <label for="payment_type_partial" class="pay-label btn-payment">Partial Payment</label>
                                  </div>
                              </div>
                              <div class="col-sm-12 partial_paid_sec" align="center" style="display: none;">
                                  <label class="form-label col-sm-6" align="center">Pay Amount</label>
                                  <input type="number" name="paid_amount" id="paid_amount" step=".01" class="form-control col-sm-6" value="0.00">
                              </div>
                          </div>

                        <ul class="payment">
                        <?php foreach ($payment_mode as $key => $pay) { ?>
                            <li>
                                <input type="radio" name="pay_method" id="cb<?php echo $pay['id']; ?>" value="<?php echo $pay['id']; ?>" data-name="<?php echo $pay['name']; ?>" <?php echo $key === 0 ? 'checked' : ''; ?>/>
                                <label for="cb<?php echo $pay['id']; ?>">
                                    <?php echo $pay['name']; ?>
                                </label>
                            </li>
                        <?php } ?>
                        </ul>

                        <div class="col-xl-12 col-sm-12 col-lg-12 col-md-12">
                            <div class="row justify-content-center">
                                <div class="col-sm-6 d-flex justify-content-center">
                                    <label id="submit_mob" class="btn btn-info submit_btn btn-lg waves-effect">Pay</label>
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
    <!-- Image loader -->
    <div id='loader' style='display: none;'>
            <img src='./assets/Loading_2.gif' width='32px' height='32px'>
    </div>
    <!-- Image loader -->       
            </div>
        </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <div id="prin_page"></div>
  <!-- container-scroller -->
    <div id="alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-body">
                    <p style="text-align:center;"><br><i class="mdi mdi-alert-circle-outline" style="font-size:42px; color:red;"></i></p>
                    <h5 style="text-align:center;" id="spndeddelid"></h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">OK</button>
                </div>
            </div><!-- /.modal-content -->
        </div>
    </div>

    <!-- Error Modal -->
<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body" style="text-align: center; position: relative; padding: 20px;">
                <!-- Error message displayed here -->
                <h5 id="errorModalBody" style="color: black; display: inline-block; margin-right: 10px;">Error message goes here.</h5>
                <!-- Close button -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: red; position: absolute; top: 10px; right: 10px; font-size: 24px;">
                    <span aria-hidden="true">&times;</span>
                </button>
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
                                <th style="width: 40%;padding: 5px 10px;text-align:center;">Name</th>
                                <th style="width: 40%;padding: 5px 10px;text-align:center;">Amount</th>
                                <th style="width: 10%;padding: 5px 10px;text-align:center;">Action</th>
                              </tr>
                            </thead>
                            <tbody style="height:auto; margin-bottom:30px;">
                                <?php
                                if(count($reprintlists) > 0)
                                {
                                  $ire = 1;
                                  foreach($reprintlists as $reprintlist)
                                  {
                                ?>
                                <tr>
                                  <td style="width: 10%;padding: 5px 0px!important;text-align:center;"><?php echo $ire; ?></td>
                                  <td style="width: 40%;padding: 5px 0px!important;text-align:center;"><?php echo $reprintlist['customer_name']; ?></td>
                                  <td style="width: 40%;padding: 5px 0px!important;text-align:center;"><?php echo $reprintlist['amount']; ?></td>
                                  <td style="width: 10%;padding: 5px 0px!important;text-align:center;">
                                    <a class='btn btn-primary' style='font-size: 13px;font-weight: bold;padding: 8px 10px;background: #2196F3;border: 1px solid #2196F3;' title='Print' href='<?php echo base_url(); ?>/prasadam_online/reprint_booking/<?php echo $reprintlist['id']; ?>' target='_blank'>Print</a>
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
<!-- REPRINT SECTION END -->

<script src="<?php echo base_url(); ?>/assets/archanai/js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/archanai/vendors/js/vendor.bundle.base.js"></script>
<script src="<?php echo base_url(); ?>/assets/archanai/vendors/chart.js/Chart.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/archanai/js/jquery.cookie.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/assets/archanai/js/off-canvas.js"></script>
<script src="<?php echo base_url(); ?>/assets/archanai/js/hoverable-collapse.js"></script>
<script src="<?php echo base_url(); ?>/assets/archanai/js/template.js"></script>
<script src="<?php echo base_url(); ?>/assets/archanai/js/settings.js"></script>
<script src="<?php echo base_url(); ?>/assets/archanai/js/todolist.js"></script>
<script src="<?php echo base_url(); ?>/assets/archanai/js/dashboard.js"></script>

<script>
// Global Variables
var isSubmitting = false;
var currentGroupId = null;

$(document).ready(function() {
    // Initialize
    currentGroupId = $('input[name="prasadam_group"]:checked').val();
    loadProducts(currentGroupId);
    displayCart();
    
    // Payment type change handler
    $(document).on('change', '.payment_type', function(){
        if(this.value == 'partial'){
            $('.partial_paid_sec').show();
        }else{
            $('.partial_paid_sec').hide();
        }
    });
    
    // Time slot change handler
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
    });
    
    // Group change handler - FIXED
    $('.prasadam-group-radio').change(function() {
        var newGroupId = $(this).val();
        var cartArray = shoppingCart.listCart();
        
        // Check if cart has items
        if (cartArray.length > 0) {
            if (confirm('Changing the group will clear your current cart. Do you want to continue?')) {
                clearCartAndLoadProducts(newGroupId);
            } else {
                // Revert to previous selection
                $(this).prop('checked', false);
                $('input[name="prasadam_group"][value="' + currentGroupId + '"]').prop('checked', true);
                return false;
            }
        } else {
            clearCartAndLoadProducts(newGroupId);
        }
        
        // Update current group ID
        currentGroupId = newGroupId;
    });
    
    // User detail button
    $('#ar_add_btn').click(function(event) {
        event.preventDefault();
        if (!validateUserDetails()) {
            return false;
        }
        
        userDetail.clearUser();
        var name = $('#name').val();
        var email_id = $('#email_id').val();
        var ic_number = $('#ic_number').val();
        var phonecode = $('#phonecode').val();
        var mobile = $('#mobile').val();
        var collection_date = $('#collection_date').val();
        var time = $('input[name="time"]:checked').val();
        var hour = $('#hour').val();
        var minute = $('#minute').val();
        var s_time = hour + ':' + minute + ' ' + (time == 'Breakfast' ? 'AM' : 'PM');
        var address = $('#address').val();
        var description = $('#description').val();
        
        if(name != "" && mobile !="" ) {
            $("#myModal").modal("hide");
            userDetail.addUserToCart(name,email_id,ic_number,phonecode,mobile,collection_date,s_time,address,description);
            displayCart_prasadam_user();
        }
    });
    
    // Submit button
    $("#submit_mob").click(function(event) {
        event.preventDefault();
        
        if (isSubmitting) {
            return false;
        }
        
        if (!validatePaymentDetails()) {
            $('#errorModalBody').text("Please select a payment method.");
            $('#errorModal').modal('show');
            setTimeout(function() {
                $('#errorModal').modal('hide');
            }, 2000);
            return false;
        }
        
        if (!validateUserDetails()) {
            $('#errorModalBody').text("Please fill in all required details.");
            $('#errorModal').modal('show');
            return false;
        }
        
        // Validate cart has items
        var cartArray = shoppingCart.listCart();
        if (cartArray.length === 0) {
            $('#errorModalBody').text("Cart is empty. Please add items.");
            $('#errorModal').modal('show');
            setTimeout(function() {
                $('#errorModal').modal('hide');
            }, 2000);
            return false;
        }
        
        save_archanai();
    });
});

// Clear cart and load products - FIXED
function clearCartAndLoadProducts(groupId) {
    // Clear visual cart
    $(".cart-table .all_close").remove();
    
    // Clear session storage
    shoppingCart.clearCart();
    userDetail.clearUser();
    
    // Reset form fields
    $("#count").val(0);
    $('#tot_amt').val('0');
    
    // Reset display
    displayCart();
    displayCart_prasadam_user();
    
    // Show empty cart image
    var emptyCartHtml = '<tr><td colspan="5" align="center"><img src="<?php echo base_url(); ?>/assets/archanai/images/cart_is_empty.png" class="img-fluid" style="width:150px; margin:0 auto;"></td></tr>';
    $('.show-cart').html(emptyCartHtml);
    
    // Disable submit buttons
    $('#submit_mob').prop('disabled', true);
    
    // Load new products
    loadProducts(groupId);
}

// Load products function
function loadProducts(groupId) {
    $.ajax({
        url: "<?php echo base_url('prasadam_online/fetch_prasadam_settings'); ?>",
        type: "POST",
        data: { prasadam_group_id: groupId },
        success: function(response) {
            var productsHtml = '';
            $.each(response, function(index, product) {
                productsHtml += `
                    <div class="col-xl-3 col-sm-6 col-lg-3 col-md-4" style="padding-left: 0px;">
                        <div class="card">
                            <div class="card-body d-flex flex-column justify-content-between" style="cursor:pointer;" onclick="addtocart(${product.id}, ${product.proamt}, '${product.name_tamil}<br>${product.name_eng}', '<?php echo base_url(); ?>/uploads/prasadam_setting/${product.image}')">
                                <img class="img-fluid prod_img" src="<?php echo base_url(); ?>/uploads/prasadam_setting/${product.image}" alt="image" />
                                <div class="d-flex justify-content-between align-items-center mb-2 mt-2" style="flex-direction: column;">
                                    <p class="mb-0 text-muted arch">${product.name_tamil}<br>${product.name_eng}</p>
                                    <!--<h4>SGD ${parseFloat(product.proamt).toFixed(2)}</h4>-->
                                </div>
                            </div>
                        </div>
                    </div>`;
            });
            $('#products').html(productsHtml);
        },
        error: function() {
            $('#errorModalBody').text("Failed to load products. Please try again.");
            $('#errorModal').modal('show');
        }
    });
}

// User Detail Management
var userDetail = (function() {
    user = [];
    function Item(name,email_id,ic_number,phonecode,mobile,collection_date,s_time,address,description) {
        this.name = name;
        this.email_id = email_id;
        this.ic_number = ic_number;
        this.phonecode = phonecode;
        this.mobile = mobile;
        this.collection_date = collection_date;
        this.s_time = s_time;
        this.address = address;
        this.description = description;
    }
    
    function saveUser() {
        sessionStorage.setItem('prasadam_userdetails', JSON.stringify(user));
    }
    
    function loadUser() {
        user = JSON.parse(sessionStorage.getItem('prasadam_userdetails'));
    }
    
    if (sessionStorage.getItem("prasadam_userdetails") != null) {
        loadUser();
    }
    
    var obj = {};
    
    obj.addUserToCart = function(name,email_id,ic_number,phonecode,mobile,collection_date,s_time,address,description) {
        var item = new Item(name,email_id,ic_number,phonecode,mobile,collection_date,s_time,address,description);
        user = [item]; // Replace with new user
        saveUser();
    }
    
    obj.clearUser = function() {
        user = [];
        saveUser();
    }
    
    obj.listUser = function() {
        return user;
    }
    
    return obj;
})();

// Display user details
function displayCart_prasadam_user() {
    var cartArray = userDetail.listUser();
    if(cartArray.length > 0) {
        var output = "";
        output += "<tr>"
        + "<th style='padding: 5px 10px;line-height: 20px;width:10%'>Customer Name </th><td style='background: #fff;border: 1px solid #dee2e6;padding: 5px 10px;line-height: 20px;'>"+cartArray[0].name+"</td>"
        + "</tr>";
        output += "<tr>"
        + "<th style='padding: 5px 10px;line-height: 20px;width:10%'>Email ID </th><td style='background: #fff;border: 1px solid #dee2e6;padding: 5px 10px;line-height: 20px;'>"+cartArray[0].email_id+"</td>"
        + "</tr>";
        output += "<tr>"
        + "<th style='padding: 5px 10px;line-height: 20px;width:10%'>Mobile No </th><td style='background: #fff;border: 1px solid #dee2e6;padding: 5px 10px;line-height: 20px;'>"+cartArray[0].phonecode+" "+cartArray[0].mobile+"</td>"
        + "</tr>";
        output += "<tr>"
        + "<th style='padding: 5px 10px;line-height: 20px;width:10%'>Collection Date </th><td style='background: #fff;border: 1px solid #dee2e6;padding: 5px 10px;line-height: 20px;'>"+cartArray[0].collection_date+"</td>"
        + "</tr>";
        $('.show-cart1').html(output);
        $('.show-cart1').show();
    } else {
        $('#name').val("");
        $('#email_id').val("");
        $('#ic_number').val("");
        $('#phonecode').val("+65");
        $('#mobile').val("");
        $('#collection_date').val("");
        $('#address').val("");
        $('#description').val("");
        $('.show-cart1').empty();
        $('.show-cart1').hide();
    }
}

function userModalOpen() {
    $("#myModal").modal("show");
    var cartArray = userDetail.listUser();
    if(cartArray.length > 0) {
        $('#name').val(cartArray[0].name);
        $('#email_id').val(cartArray[0].email_id);
        $('#ic_number').val(cartArray[0].ic_number);
        $('#phonecode').val(cartArray[0].phonecode);
        $('#mobile').val(cartArray[0].mobile);
        $('#collection_date').val(cartArray[0].collection_date);
        $('#address').val(cartArray[0].address);
        $('#description').val(cartArray[0].description);
        $('.show-cart1').show();
    } else {
        $('#name').val("");
        $('#email_id').val("");
        $('#ic_number').val("");
        $('#phonecode').val("+65");
        $('#mobile').val("");
        $('#collection_date').val("");
        $('#address').val("");
        $('#description').val("");
        $('.show-cart1').empty();
        $('.show-cart1').hide();
    }
}

// Shopping Cart Management
var shoppingCart = (function() {
    cart = [];
    
    function Item(name, price, count, src, product_id, category) {
        this.name = name;
        this.price = price;
        this.count = count;
        this.src = src;
        this.product_id = product_id;
        this.category = category;
    }
    
    function saveCart() {
        sessionStorage.setItem('prasadamCart', JSON.stringify(cart));
    }
    
    function loadCart() {
        cart = JSON.parse(sessionStorage.getItem('prasadamCart'));
    }
    
    if (sessionStorage.getItem("prasadamCart") != null) {
        loadCart();
    }
    
    var obj = {};
    
    obj.addItemToCart = function(name, price, count, src, product_id, category) {
        for(var item in cart) {
            if(cart[item].product_id === product_id) {
                cart[item].count++;
                saveCart();
                return;
            }
        }
        var item = new Item(name, price, count, src, product_id, category);
        cart.push(item);
        saveCart();
    }
    
    obj.setCountForItem = function(product_id, count) {
        for(var i in cart) {
            if (cart[i].product_id === product_id) {
                cart[i].count = count;
                break;
            }
        }
        saveCart();
    };
    
    obj.removeItemFromCart = function(product_id) {
        for(var item in cart) {
            if(cart[item].product_id === product_id) {
                cart[item].count--;
                if(cart[item].count === 0) {
                    cart.splice(item, 1);
                }
                break;
            }
        }
        saveCart();
    }

    obj.removeItemFromCartAll = function(product_id) {
        for(var item in cart) {
            if(cart[item].product_id === product_id) {
                cart.splice(item, 1);
                break;
            }
        }
        saveCart();
    }

    obj.clearCart = function() {
        cart = [];
        saveCart();
    }

    obj.totalCount = function() {
        var totalCount = 0;
        for(var item in cart) {
            totalCount += cart[item].count;
        }
        return totalCount;
    }

    obj.totalCart = function() {
        var totalCart = 0;
        for(var item in cart) {
            totalCart += cart[item].price * cart[item].count;
        }
        return Number(totalCart.toFixed(2));
    }

    obj.listCart = function() {
        var cartCopy = [];
        for(i in cart) {
            item = cart[i];
            itemCopy = {};
            for(p in item) {
                itemCopy[p] = item[p];
            }
            itemCopy.total = Number(item.price * item.count).toFixed(2);
            cartCopy.push(itemCopy)
        }
        return cartCopy;
    }
    
    return obj;
})();

// Add item to cart - FIXED
function addtocart(product_id, price, name, src) {
    var category = currentGroupId;
    shoppingCart.addItemToCart(name, price, 1, src, product_id, category);
    displayCart();
}

// Display cart - FIXED
function displayCart() {
    var cartArray = shoppingCart.listCart();
    var output = "";
    
    if (cartArray.length == 0) {
        output = "<tr><td colspan='5' align='center'><img src='<?php echo base_url(); ?>/assets/archanai/images/cart_is_empty.png' class='img-fluid' style='width:150px; margin:0 auto;'></td></tr>";
        $('#submit_mob').prop('disabled', true);
    } else {
        var index = 0; // Sequential index for form fields
        for (var i in cartArray) {
            output += "<tr style='background:#d4aa0014;' class='all_close' data-id='" + cartArray[i].product_id + "' id='remov" + cartArray[i].product_id + "'>"
                + "<td style='width:10%'><input type='hidden' name='prasadam[" + index + "][id]' value='" + cartArray[i].product_id + "'><img src='" + cartArray[i].src + "' style='width:35px; border:1px solid #e9e6e6; background:#FFF; border-radius:5px;'></td>"
                + "<td style='width:42%'><input type='hidden' name='prasadam[" + index + "][amt]' value='" + (Number(cartArray[i].price).toFixed(2)) + "'><span class='archa_name' style='text-transform:uppercase;'>" + cartArray[i].name + "</span><br>SGD : " + (Number(cartArray[i].price).toFixed(2)) + "</td>"
                + "<td style='width:35%'><div class='input-group'><button type='button' class='minus-item input-group-addon btn btn-primary' data-id='" + cartArray[i].product_id + "'>-</button>"
                + "<input type='number' min='1' class='item-count_new' data-id='" + cartArray[i].product_id + "' value='" + cartArray[i].count + "'>"
                + "<button type='button' class='plus-item btn btn-primary input-group-addon' data-id='" + cartArray[i].product_id + "'>+</button><input type='hidden' name='prasadam[" + index + "][qty]' value='" + cartArray[i].count + "'></div></td>"
                + "<td style='width:8%'><button type='button' class='delete-item btn btn-danger' data-id='" + cartArray[i].product_id + "'>X</button></td>"
                + "</tr>";
            index++;
        }
        $('#submit_mob').removeAttr('disabled');
    }
    
    $('.show-cart').html(output);
    var totalCart = Number(shoppingCart.totalCart()).toFixed(2);
    $('.total-cart').html(totalCart);
    $('#tot_amt').val(totalCart);
    $('.total-count').html(shoppingCart.totalCount());
}

// Clear cart button
$('.clear-cart').click(function() {
    if (confirm('Are you sure you want to clear all items?')) {
        shoppingCart.clearCart();
        userDetail.clearUser();
        displayCart();
        displayCart_prasadam_user();
    }
});

// Delete item button - FIXED
$('.show-cart').on("click", ".delete-item", function(event) {
    event.preventDefault();
    var product_id = $(this).data('id');
    shoppingCart.removeItemFromCartAll(product_id);
    displayCart();
});

// Minus button - FIXED
$('.show-cart').on("click", ".minus-item", function(event) {
    event.preventDefault();
    var product_id = $(this).data('id');
    shoppingCart.removeItemFromCart(product_id);
    displayCart();
});

// Plus button - FIXED
$('.show-cart').on("click", ".plus-item", function(event) {
    event.preventDefault();
    var product_id = $(this).data('id');
    var cartArray = shoppingCart.listCart();
    for(var i in cartArray) {
        if(cartArray[i].product_id === product_id) {
            shoppingCart.addItemToCart(cartArray[i].name, cartArray[i].price, 1, cartArray[i].src, product_id, cartArray[i].category);
            break;
        }
    }
    displayCart();
});

// Item count input - FIXED
$('.show-cart').on("change", ".item-count_new", function(event) {
    var product_id = $(this).data('id');
    var count = Number($(this).val());
    if (count > 0) {
        shoppingCart.setCountForItem(product_id, count);
        displayCart();
    }
});

// Validation functions
function validateUserDetails() {
    var allValid = true;
    var madapalli = <?php echo $setting['enable_madapalli']; ?>;
    var groupId = $('input[name="prasadam_group"]:checked').val();
    var alwaysRequiredFields = ['#name', '#mobile'];
    var conditionallyRequiredFields = (groupId === '1' || madapalli === 1) ? ['#collection_date', 'input[name="time"]:checked'] : [];
    var fieldsToCheck = alwaysRequiredFields.concat(conditionallyRequiredFields);

    // Clear previous errors
    $('.error_msg').remove();
    $('input, select, textarea').css('border', '');

    fieldsToCheck.forEach(function(field) {
        var $input;
        if (field === 'input[name="time"]:checked') {
            $input = $('input[name="time"]:checked');
            if ($input.length === 0) {
                $('input[name="time"]').parent().css('border', '2px solid red');
                $('input[name="time"]').first().parent().after('<div class="error_msg" style="color:red;">Please select a time slot.</div>');
                allValid = false;
            }
        } else {
            $input = $(field);
            if ($input.val().trim() === '') {
                $input.css('border', '2px solid red');
                $input.after('<div class="error_msg" style="color:red;">This field is required.</div>');
                allValid = false;
            }
        }
    });

    return allValid;
}

function validatePaymentDetails() {
    if (!$('input[name="pay_method"]:checked').length) {
        return false;
    }
    return true;
}

// Save function - FIXED
function save_archanai(sep_print = 0) {
    // Validate cart
    var cartArray = shoppingCart.listCart();
    if (cartArray.length === 0) {
        $('#errorModalBody').text("Cart is empty. Please add items.");
        $('#errorModal').modal('show');
        isSubmitting = false;
        return false;
    }
    
    // Validate totals
    var calculatedTotal = shoppingCart.totalCart();
    var formTotal = parseFloat($('#tot_amt').val());
    
    if (Math.abs(calculatedTotal - formTotal) > 0.01) {
        $('#errorModalBody').text("Amount mismatch detected. Please refresh and try again.");
        $('#errorModal').modal('show');
        isSubmitting = false;
        return false;
    }
    
    isSubmitting = true;
    
    $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>/prasadam_online/save?sep_print=" + sep_print,
        data: $("#prasadam_form").serialize(),
        beforeSend: function () {
            $("#submit_mob").prop('disabled', true);
            $("#loader").show();
        },
        success: function (data) {
            try {
                var obj = jQuery.parseJSON(data);
                if (obj.err !== '') {
                    console.log("Error:", obj);
                    $("#submit_mob").prop('disabled', false);
                    $('#errorModalBody').text(obj.err);
                    $('#errorModal').modal('show');
                    isSubmitting = false;
                } else {
                    shoppingCart.clearCart();
                    userDetail.clearUser();
                    displayCart();
                    displayCart_prasadam_user();
                    window.open("<?php echo base_url(); ?>/prasadam_online/print_booking/" + obj.id, "_blank", "width=680,height=500");
                    setTimeout(function() {
                        window.location.reload(true);
                    }, 1000);
                }
            } catch(e) {
                console.error("Parse error:", e);
                $('#errorModalBody').text("An error occurred. Please try again.");
                $('#errorModal').modal('show');
                $("#submit_mob").prop('disabled', false);
                isSubmitting = false;
            }
        },
        complete: function () {
            $("#loader").hide();
        },
        error: function (err) {
            console.log('AJAX Error:', err);
            $("#submit_mob").prop('disabled', false);
            $('#errorModalBody').text("Network error. Please try again.");
            $('#errorModal').modal('show');
            isSubmitting = false;
        }
    });
}

// Reprint function
function rePrint() {
    $("#myModal_reprint").modal("show");
}

// Modal close handlers
$(function () {
    $("[data-dismiss='modal']").on('click', function () {
        $('.modal').hide();
    })
});

// Prevent page unload if cart has items
window.onbeforeunload = function() {
    var cartArray = shoppingCart.listCart();
    if (cartArray.length > 0) {
        return "You have items in your cart. Are you sure you want to leave?";
    }
};
</script>

</body>