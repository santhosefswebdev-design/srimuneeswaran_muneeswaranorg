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
.show-cart { max-height:350px; overflow:auto; }
.show-cart tr { border-radius:10px; }
.show-cart td { font-size:11px; padding:5px; }
.total { margin-top:15px; padding-bottom:10px; } 
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
.cart-clm { max-width: 33%; }
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
	max-height: 620px;
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
    width: 60px; /* Adjust the width as needed */
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
    padding: 10px 20px;
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
    padding: 10px; /* Additional padding for better spacing */
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
    margin: 0 10px; /* Adds some space between the buttons */
}
.button-container {
    display: flex;
    justify-content: center;  /* Centers the content horizontally */
    align-items: center;      /* Centers the content vertically if needed */
    padding: 10px;            /* Adds some padding around the button for spacing */
}

.product-card.selected-product {
        background-color: #f0f8ff; /* Light blue background for selected product */
        border: 2px solid #007bff; /* Highlight the border */
    }

    .value-button {
    background-color: #f0f0f0;
    border: 1px solid #ddd;
    padding: 5px 10px;
    cursor: pointer;
    user-select: none;
}

.value-button:hover {
    background-color: #ddd;
}

.qty_amt {
    width: 50px; /* To keep the quantity input small */
    text-align: center;
}


</style>

<body class="sidebar-icon-only">
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    
    
    <div class="container-fluid page-body-wrapper">

      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
          <form method="post">
        	<div class="row">
            <div class="col-xl-8 col-sm-6 col-lg-6 col-md-7 stretch-card flex-column">  

              <div class="products row scroll">
                <?php foreach($products as $product): ?>
                    <div class="col-xl-3 col-sm-6 col-lg-3 col-md-4">
                        <div class="card">
                            <div class="card-body product-card d-flex flex-column justify-content-between" name="package_id" id="<?= $product['id']; ?>" data-id="prod<?= $product['id']; ?>" onclick="addtocart(<?= $product['id']; ?>)">
                                <img class="img-fluid prod_img" src="<?= base_url('/uploads/package/' . $product['image']); ?>" alt="image" />
                                <div class="d-flex justify-content-between align-items-center mb-2 mt-2" style="flex-direction: column;">
                                    <p class="mb-0 text-muted arch" id="nm_<?= $product['id']; ?>" data-id="<?= $product['id']; ?>"><?= $product['name']; ?></p>
                                    <h4 style="display: none" id="amt_<?= $product['id']; ?>" data-id="<?= $product['amount']; ?>">SGD <?= number_format($product['amount'], 2); ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
              </div>
              <input type="hidden" name="term_setting" id="term_setting" class="form-control" value="<?php echo $setting['enable_terms']; ?>">
              <h4 style="margin-bottom:5px; text-align:center; margin-top:5px; color:#FFFFFF; background:#d4aa00;">Add-on</h4><br>
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

                <div class="row scroll" style="overflow-y:scroll; overflow-x:hidden; height: 180px;">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered" style="width:100%" id="package_table_addon" style="height: 150px;">
                                <thead>
                                    <tr>
                                        <th width="20%">Name</th>
                                        <th width="30%">Description</th>
                                        <th width="20%">Quantity</th>
                                        <th width="20%">Total($)</th>
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
            </div>


            <div class="col-xl-4 col-sm-6 col-lg-6 col-md-5 stretch-card flex-column cart-clm">
              <div class="h-100">
                <div class="stretch-card" style="height:100%;">
                  <div class="card">
                    <div class="card-body">
                      
                        <input type="hidden" name="date" id="date" value="<?php echo date('Y-m-d'); ?>">
                        <div class="d-flex align-items-start flex-wrap">
                          <div class="d-flex justify-content-between" style="width:100%;">
                            <button type="button" class="btn btn-info btn-lg ar_btn" onClick="userModalOpen();">Add Detail</button>
                            <!-- <button type="button" class="btn btn-warning btn-lg ar_btn" onClick="rePrint();" style="background: #FFC107;border: 1px solid #FFC107;color: #fff;">Reprint</button> -->
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
                                              <span id="error_msg"></span></div>
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
                                                <span id="error_msg"></span>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-md-6">
                                          <div class="form-group">  
                                            <label class="form-label" for="collection_date">Event Date </label>
                                            <input class="form-control" type="date" id="collection_date" name="collection_date" autocomplete="off" min="<?php echo date('d-m-Y'); ?>">
                                            <!-- <span id="error_msg"></span> -->
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div class="form-group">  
                                            <label class="form-label" for="s_time">Estimated Time </label>
                                            <input class="form-control" type="time" id="s_time" name="s_time" autocomplete="off" >
                                            <!-- <span id="error_msg"></span> -->
                                          </div> 
                                        </div>
                                      </div> 
                                          
                                      <div class="row">  
                                        <div class="col-md-6">
                                          <div class="form-group">  
                                            <label class="form-label" for="dob">DOB <span style="color:red;"></span></label>
                                            <input class="form-control" type="date" id="dob" name="dob" autocomplete="off">
                                            <span id="error_msg"></span>
                                          </div>
                                        </div> 
                                        <div class="col-md-6"><div class="form-group">
                                          <label class="form-label" for="address">Address</label>
                                          <textarea class="form-control" id="address" name="address" style="width:100%;" rows="2">  </textarea>
                                        </div>
                                      </div>      
                                    </div>
                                    <div class="row">
                                      <div class="col-md-6"><div class="form-group">  
                                        <label class="form-label" for="description">Remarks</label>
                                        <textarea class="form-control" id="description" name="description" style="width:100%;" rows="2" autocomplete="off"></textarea>
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
                            <p class="mb-0">SGD : <span class="total-cart"></span></p>
                            <input type="hidden" id="tot_amt" name="tot_amt">
                         </div>

                          <!-- <div class="row clearfix" style="width:105%; border-bottom:1px dashed #CCC; display: flex; justify-content: center; align-items: center;">
                              <div class="payment-options" style="flex-grow: 1; display: flex; justify-content: center;">
                                  <div class="form-group">
                                      <input type="radio" name="payment_type" id="payment_type_full" class="payment_type" value="full" 
                                          <?php echo (empty($data['payment_type']) || $data['payment_type'] == 'full') ? 'checked' : ''; ?>>
                                      <label for="payment_type_full" class="pay-label btn-payment">Full Payment</label>
                                  </div>
                                  <div class="form-group">
                                      <input type="radio" name="payment_type" id="payment_type_partial" class="payment_type" value="partial" 
                                          <?php echo ($data['payment_type'] == 'partial') ? 'checked' : ''; ?>>
                                      <label for="payment_type_partial" class="pay-label btn-payment">Partial Payment</label>
                                  </div>
                              </div>
                              <div class="col-sm-6 partial_paid_sec" align="center" style="<?php echo (!empty($data['payment_type']) && $data['payment_type'] == 'partial') ? '' : 'display: none;'; ?>">
                                  <label class="form-label" align="center">Pay Amount</label>
                                  <input type="number" name="paid_amount" id="paid_amount" step=".01" class="form-control" value="<?php echo $data['paid_amount'] ?? '0.00'; ?>">
                              </div>
                          </div> -->


                        <!--h5 class="pay_mode">Payment Mode</h5-->
                        <div class="col-md-12">
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
                        </div>

                        <div <?php if(!empty($setting['enable_terms'])){ echo ' style="display: block;"'; }else echo ' style="display: none;"'; ?>>
                          <div class="col-sm-12" style="text-align: left;color: #f44336;">
                              <div class="form-group">
                                  <label for="termsLink" id="termsLabel" style="cursor: pointer;"><i class="fa fa-check-square-o" style="color:red"></i>Terms and conditions</label>
                              </div>
                          </div>
                        </div>

                              <div class="col-xl-12 col-sm-12 col-lg-12 col-md-12">
                                  <div class="row justify-content-center">
                                      <div class="col-sm-6 d-flex justify-content-center"> <!-- Ensures button is centered in the column -->
                                          <label id="submit" class="btn btn-info submit_btn btn-lg waves-effect">Save</label>
                                      </div>
                                  </div>
                              </div>




                             <!--div class="col-xl-6 col-sm-6 col-lg-6 col-md-6">
                                 <input type="submit" disabled value="Sep.PRINT" class="btn btn-info submit_btn" id="submit_sep">
                             </div-->
                         
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
  
  <!--script src='https://code.jquery.com/jquery-2.2.4.min.js'></script-->
  <script  src="<?php echo base_url(); ?>/assets/archanai/script.js"></script>

  <script>
    $(document).on('change', '.payment_type', function(){
			if(this.value == 'partial'){
				$('.partial_paid_sec').show();
				$('#full_paid_amount').prop('disabled', true);
			}else{
				$('.partial_paid_sec').hide();
				$('#full_paid_amount').prop('disabled', false);
			}
		});

    $('#termsLabel').on('click', function(event) {
        event.preventDefault();
        var name = $("#name").val();
        var today = new Date();
        var formattedDate = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);           
        //var ic_number = $("#ic_number").val();
        var address = $("#address").val();
        var booking_date = $("#ubhayam_date").val();
        var booking_slot = $('input[name="booking_slot[]"]:checked').closest('td').text().trim();
        var package_id = $('.package_id').val();
        var pay_id = selectedProductId;
        //var pay_id = $("input[name='pay_for']:checked").val();
        console.log('package id:', pay_id);
        if(name){
            $.ajax({
                url: "<?php echo base_url() ?>/outdoor_online/get_terms",
                type: "POST",
                data: { id: pay_id },
                dataType: "json",
                success: function (data) {
                
                    if (data.terms.length > 0) {
                        var t_html = '';
                        data.terms.forEach(function(value, key) {
                            var replacedValue = value.replace(/\[person_name\]/g, name).replace(/\[Address\]/g, address).replace(/\[booking_date\]/g, booking_date).replace(/\[booking_slot\]/g, booking_slot).replace(/\[entry_date\]/g, formattedDate);
                            t_html += '<div class="form-group">' +
                                    '<label class="custom-checkbox">' + replacedValue +
                                    '<input type="checkbox" class="term-checkbox" name="terms[]" value="' + replacedValue + '">' +
                                    '<span class="checkmark"></span>' +
                                    '</label>' +
                                    '</div>';
                        });
                        $('#termsModal .modal-body').html(t_html);
                        $('#termsModal').modal('show');
                    }
                }
            });
        } else{
            alert("Kindly fill all details");
        }
    });
  </script>

  <script>
document.getElementById("submit").addEventListener("click", function () {
          const paymentSelected = document.querySelector('input[name="pay_method"]:checked');
         // const addOnServicesCount = document.querySelectorAll("#package_table_addon tbody tr").length;

          if (!paymentSelected) {
              alert("Please select a payment mode.");
              return;
          }
          // if (addOnServicesCount === 0) {
          //     alert("Please select at least one add-on service.");
          //     return;
          // }
      });
  </script>

  <script>
      $(document).ready(function() {
          var selectedProductId = null; // Global variable to store the selected product ID

          // Event listener for product card clicks
          $('.product-card').click(function() {
              $('.product-card').removeClass('selected');
              $(this).addClass('selected');
              selectedProductId = $(this).attr('id'); // Get the ID of the selected product
              loadAddons(selectedProductId); // Load add-ons for the selected product
          });

          // Function to load add-ons into the dropdown
          function loadAddons(productId) {
              $.ajax({
                  url: "<?php echo base_url(); ?>/outdoor_online/fetch_outdoor_services",
                  type: "POST",
                  data: { product_id: productId },
                  dataType: "json",
                  success: function(response) {
                      var addonDropdown = $('#add_one_addon');
                      addonDropdown.empty(); // Clear previous add-ons
                      addonDropdown.append('<option value="">Select From</option>'); // Default option
                      $.each(response, function(index, addon) {
                          addonDropdown.append(`<option value="${addon.id}" data-amount="${addon.amount}">${addon.name}</option>`);
                      });
                  },
                  error: function(xhr, status, error) {
                      console.error("Error fetching addons:", error);
                  }
              });
          }

          // Event listener for add-on selection changes
          $("#add_one_addon").change(function() {
              var selectedOption = $(this).find('option:selected');
              var amount = selectedOption.data('amount');
              $("#get_pack_amt_addon").val(parseFloat(amount).toFixed(2)); // Set the add-on amount in the input field
              $("#pack_name_addon").val(selectedOption.text()); // Set the add-on name
          });

          // Event listener for the "Add" button click
          $("#pack_add_addon").click(function() {
              var addonId = $("#add_one_addon").val();
              console.log('addon_id', addonId);
              var amount = $("#get_pack_amt_addon").val();

              if (!selectedProductId) {
                  alert('Please select a product.');
                  return;
              }

              if (!addonId) {
                  alert('Please select an addon from the dropdown.');
                  return;
              }

              // $("#package_table_addon tbody tr").each(function() {
              //     var rowId = $(this).find('input[type="hidden"]').val();
              //     console.log("Checking against Row ID:", rowId);
              //     console.log("Checking against Addon ID:", rowId); 

              //     if (rowId === addonId) {
              //         alert('This add-on has already been added. Please choose another add-on.');
              //         return;
              //     }
              // });

              // var duplicateFound = false;
              // $("#package_table_addon tbody tr").each(function() {
              //     // Fetch the add-on ID from the hidden input
              //     var rowId = $(this).find('input[type="hidden"]').val();
              //     console.log("Checking against Row ID:", rowId);
              //     console.log("Checking against Addon ID:", addonId);

              //     // Compare using a strict equality check after ensuring both are strings
              //     if (rowId === addonId.toString()) {
              //         alert('This add-on has already been added. Please choose another add-on.');
              //         duplicateFound = true;
              //         return false; // Break out of the .each() loop
              //     }
              // });

              // if (duplicateFound) return; // Stop further execution if duplicate was found

              // Make an AJAX call to get detailed information and update the table
              $.ajax({
                  url: "<?php echo base_url();?>/outdoor_online/get_service_list_addon",
                  type: "POST",
                  data: {
                      id: addonId,
                      package_id: selectedProductId
                  },
                  dataType: "json",
                  success: function(response) {
                    console.log('service list:', response);
                      updateAddonTable(response);
                  },
                  error: function(xhr, status, error) {
                      console.error("Error fetching addon details:", error);
                  }
              });
          });

        });

        $.ajax({
              url: "<?php echo base_url('outdoor_online/fetch_package_settings'); ?>", // Replace with your actual backend path
              type: 'POST',
              data: { package_id: ids },
              success: function (response) {
                  var packageDetails = ''; // To store package details in table format

                  // Create a table structure for services
                  packageDetails += '<table style="width: 100%; font-size: 14px;">';
                  packageDetails += '<thead><tr><th style="width: 25%;">Name</th><th style="width: 20%;">Description</th><th style="width: 13%;">Quantity</th></tr></thead>';
                  packageDetails += '<tbody>';

                  // Iterate over the response and append service name, description, and quantity
                  $.each(response, function (index, item) {
                      packageDetails += `<tr>
                          <td style="font-size: 14px">${item.name}</td>
                          <td style="font-size: 14px">${item.description}</td>
                          <td style="font-size: 14px">${item.quantity}</td>
                      </tr>`;
                  });
              }
            }); 

        //   function updateAddonTable(data) {
        //     console.log('updateAddonTable function called');
        //     var table = $('#package_table_addon tbody');
        //     //table.empty(); // Clear previous entries

        //     $.each(data, function(index, item) {  
        //         var rowId = item.id;
        //         var row = `
        //             <tr id="addon_row_${rowId}">
        //                 <td style="width: 20%;"><input type="hidden" name="add_on[${rowId}][id]" value="${item.id}" id="service_id_${rowId}">${item.name}</td>
        //                 <td style="width: 45%;">${item.description}</td>
        //                 <td>
        //                     <div class="itemcountrr" style="display: flex; align-items: center; justify-content: center;">
        //                         <button class="value-button" id="decrease_${rowId}" onclick="decreaseValue(${rowId})" style="font-weight: bold; font-size: 16px; cursor: pointer;">-</button>
        //                         <input type="text" name="add_on[${rowId}][quantity]" min="1" id="quantity${rowId}" value="1" class="qty_amt form-control" style="text-align: center; width: 50px;" readonly max="${item.quantity}"/>
        //                         <button class="value-button" id="increase_${rowId}" onclick="increaseValue(${rowId})" style="font-weight: bold; font-size: 16px; cursor: pointer;">+</button>
        //                     </div>
        //                 </td>
        //                 <td style="width: 25%;">
        //                     <input type="text" class="form-control package_amt_addon" 
        //                     id="package_amt_addon_${rowId}" 
        //                     name="add_on[${rowId}][amount]" 
        //                     value="${Number(item.amount).toFixed(2)}" 
        //                     readonly 
        //                     data-unit-price="${Number(item.amount).toFixed(2)}">
        //                 </td>
        //                 <td style="width: 10%;"><label class="btn btn-danger" onclick="rmv_pack_addon(${rowId})"><i class="material-icons">X</i></label></td>
        //             </tr>`;
        //         table.append(row);
        //         updateAmount(rowId, item.amount); // Pass the amount directly here
        //     });
        //     sum_total(); // Call sum_total after updating the table
        // }

        function updateAddonTable(data) {
    console.log('updateAddonTable function called');
    var table = $('#package_table_addon tbody');

    $.each(data, function(index, item) {
        var rowId = item.id;
        var isDuplicate = false;

        // Check for duplicates in the existing table rows
        $("#package_table_addon tbody tr").each(function() {
            var existingId = $(this).find('input[type="hidden"]').val(); // Ensure this selector matches your hidden input structure
            if (existingId === rowId.toString()) {
                isDuplicate = true;
                console.log('Duplicate found for Addon ID:', rowId); // Debugging output
                alert('This add-on has already been added. Please choose another add-on.');
                return false; // Exit the .each() loop
            }
        });

        if (!isDuplicate) {
            // If not a duplicate, append the row
            var row = `
                <tr id="addon_row_${rowId}">
                    <td style="width: 20%;"><input type="hidden" name="add_on[${rowId}][id]" value="${item.id}" id="service_id_${rowId}">${item.name}</td>
                    <td style="width: 45%;">${item.description}</td>
                    <td style="width: 20%;">
                        <div class="itemcountrr" style="display: flex; align-items: center; justify-content: center;">
                            <button class="value-button" id="decrease_${rowId}" onclick="decreaseValue(${rowId})" style="font-weight: bold; font-size: 16px; cursor: pointer;">-</button>
                            <input type="text" name="add_on[${rowId}][quantity]" min="1" id="quantity${rowId}" value="1" class="qty_amt form-control" style="text-align: center;border-radius:0; width: 50px; height:28px;" readonly max="${item.quantity}"/>
                            <button class="value-button" id="increase_${rowId}" onclick="increaseValue(${rowId})" style="font-weight: bold; font-size: 16px; cursor: pointer;">+</button>
                        </div>
                    </td>
                    <td style="width: 25%;">
                        <input type="text" class="form-control package_amt_addon" 
                        id="package_amt_addon_${rowId}" 
                        name="add_on[${rowId}][amount]" 
                        value="${Number(item.amount).toFixed(2)}" 
                        readonly style="height:28px;" 
                        data-unit-price="${Number(item.amount).toFixed(2)}">
                    </td>
                    <td style="width: 10%;"><label class="btn btn-danger" style="height:28px;line-height: 1em;" onclick="rmv_pack_addon(${rowId})"><i class="material-icons" style="font-size:12px">X</i></label></td>
                </tr>`;
            table.append(row);
            updateAmount(rowId, item.amount); // Assuming you have a function to update some amounts
        }
    });
    sum_total(); // Assuming you have a function to calculate total sums
}


      function updateAmount(rowId, unitPrice) {
          var quantity = parseInt($("#quantity" + rowId).val(), 10);

          if (unitPrice === undefined) {
              unitPrice = parseFloat($("#package_amt_addon_" + rowId).attr('data-unit-price')); 
          }

          if (!isNaN(quantity) && !isNaN(unitPrice)) {
              var totalPrice = quantity * unitPrice; 
              $("#package_amt_addon_" + rowId).val(totalPrice.toFixed(2)); 
          } else {
              console.error("Error in calculation: ", { quantity, unitPrice });
              $("#package_amt_addon_" + rowId).val('0.00'); 
          }
          sum_total(); 
      }


      function increaseValue(rowId) {
          event.preventDefault();
          var quantity = $("#quantity" + rowId);
          var currentVal = parseInt(quantity.val(), 10);
          var maxVal = parseInt(quantity.attr('max'), 10); // Get max value from input field
          console.log('max value:', maxVal)

          if (currentVal < maxVal) {
              quantity.val(currentVal + 1);
              updateAmount(rowId);
              sum_total(); // Recalculate total after updating amount
          } else {
              console.log(`Maximum quantity of ${maxVal} reached for product ${rowId}`);
          }
      }

      function decreaseValue(rowId) {
        console.log('decreaseValue called')
          event.preventDefault();
          var quantity = $("#quantity" + rowId);
          var currentVal = parseInt(quantity.val(), 10);

          if (currentVal > 1) {
              quantity.val(currentVal - 1);
              updateAmount(rowId);
              sum_total(); // Recalculate total after updating amount
          }
      }


      function qtykeyup(rowId) {
          var quantity = $("#quantity" + rowId);
          var currentVal = parseInt(quantity.val(), 10);
          var maxVal = parseInt(quantity.attr('max'), 10);

          if (currentVal >= 1 && currentVal <= maxVal) {
              updateAmount(rowId);
          } else if (currentVal > maxVal) {
              quantity.val(maxVal); // Set to max if overflown
              updateAmount(rowId);
          } else {
              quantity.val(1); // Set to 1 if underflown or invalid
              updateAmount(rowId);
          }
          sum_total();
      }

      // function updateAmount(rowId, unitPrice) {
      //     var quantity = parseInt($("#quantity" + rowId).val(), 10);

      //     if (!isNaN(quantity) && !isNaN(unitPrice)) {
      //         var totalPrice = quantity * unitPrice;
      //         $("#package_amt_addon_" + rowId).val(totalPrice.toFixed(2));
      //     } else {
      //         console.error("Error in calculation: ", {quantity, unitPrice});
      //         $("#package_amt_addon_" + rowId).val('0.00'); // Resetting to 0.00 if there's a calculation error
      //     }
      //     sum_total(); // Ensure this function recalculates the overall total, if present
      // }

      // function updateAmount(rowId, unitPrice) {
      //     var quantity = parseInt($("#quantity" + rowId).val(), 10);
      //     //var price = unitPrice || parseFloat($("#package_amt_addon_" + rowId).val());
      //     var price = unitPrice || parseFloat($("#package_amt_addon_" + rowId).val()) / quantity; // Calculate price per unit

      //     if (!isNaN(quantity) && !isNaN(price)) {
      //         var totalPrice = quantity * price;
      //         $("#package_amt_addon_" + rowId).val(totalPrice.toFixed(2));
      //     } else {
      //         console.error("Error in calculation: ", {quantity, price});
      //         $("#package_amt_addon_" + rowId).val('0.00'); // Resetting to 0.00 if there's a calculation error
      //     }
      //     sum_total(); // Ensure this function recalculates the overall total
      // }

      // function updateAmount(rowId, unitPrice) {
      //     // Get the current quantity for the row
      //     var quantity = parseInt($("#quantity" + rowId).val(), 10);

      //     // Get the unit price (if passed), or fetch it from the initial data set in the DOM
      //     if (unitPrice === undefined) {
      //         unitPrice = parseFloat($("#package_amt_addon_" + rowId).attr('data-unit-price')); // Store the original unit price in a data attribute
      //     }

      //     // Ensure quantity and unitPrice are valid numbers
      //     if (!isNaN(quantity) && !isNaN(unitPrice)) {
      //         var totalPrice = quantity * unitPrice; // Recalculate the row's total price
      //         $("#package_amt_addon_" + rowId).val(totalPrice.toFixed(2)); // Update the row's total field
      //     } else {
      //         console.error("Error in calculation: ", { quantity, unitPrice });
      //         $("#package_amt_addon_" + rowId).val('0.00'); // Reset to 0.00 if there's a calculation error
      //     }
      //     sum_total(); // Recalculate overall total after updating the row's total
      // }

      function sum_total() {
            console.log('sum_total function called')
            var total_qty = 0;
            $(".row_qty").each(function() {
                total_qty += parseFloat($(this).val());
            });

            var total_amt = 0;
            $(".row_tot").each(function() {
                total_amt += parseFloat($(this).val());
            });

            $(".package_amt_addon").each(function() {
              var addon_amt = parseFloat($(this).val());  // Get addon amount from the addon rows
              console.log('addon_amt:', addon_amt); 
              if (!isNaN(addon_amt)) {
                  total_amt += addon_amt; // Add it to the total amount
              }
          });

            $("#tot_amt").val(Number(total_amt).toFixed(2));
            $(".total-cart").text(Number(total_amt).toFixed(2)); // Ensure this is correct and visible
            $(".tot_amt_txt").text(Number(total_amt).toFixed(2));
          }

        // function rmv_pack_addon(id) {
        //   console.log('remove function called', id);
        //     $("#rmv_pack_addon" + id).remove();
        //     sum_total();
        // }

        function rmv_pack_addon(id) {
            console.log('remove function called', id);
            $("#addon_row_" + id).remove();  // Corrected to match the ID assigned to the row
            sum_total();  // Recalculate the total if necessary
        }

        function save_prasadam(){
          $.ajax
            ({
              type:"POST",
              url: "<?php echo base_url(); ?>/outdoor_online/save",
              data: $("form").serialize(),
              beforeSend: function() {    
                //$("#loader").show();
              },
              success:function(data)
              {
                obj = jQuery.parseJSON(data);
                console.log('return data:', obj);
                if(obj.err != ''){
                    $('#alert-modal').modal('show', {backdrop: 'static'});
                    $("#spndeddelid").text(obj.err);
                }else{
                    userDetail.clearUser();
                    shoppingCart.clearCart();
                    displayCart();
                    window.open("<?php echo base_url(); ?>/outdoor_online/print_page/" + obj.id, "_blank");
                    window.location.reload(true);
                }
              },
              complete:function(data){
                  // Hide image container
                  $("#loader").hide();
              },
              error:function(err)
                {
                  $("#submit, #submit_sep").prop('disabled', false);
                  console.log('err');
                  console.log(err);
                }
            });	
        }

    </script>

<script>

    var userDetail = (function() {
        user = [];
        // Constructor
        function Item(name,email_id,ic_number,phonecode,mobile,collection_date,s_time,address,description) {
            this.name = name;
            this.email_id = email_id;
            this.ic_number = ic_number;
            this.phonecode = phonecode;
            this.mobile = mobile;
            this.collection_date = collection_date;
            this.s_time = s_time;
            //this.e_time = e_time;
            this.address = address;
            this.description = description;
        }
        // Save user
        function saveUser() {
            sessionStorage.setItem('prasadam_userdetails', JSON.stringify(user));
        }
            // Load user
        function loadUser() {
            user = JSON.parse(sessionStorage.getItem('prasadam_userdetails'));
        }
        if (sessionStorage.getItem("prasadam_userdetails") != null) {
            loadUser();
        }
        var obj = {};
        // Add to user
        obj.addUserToCart = function(name,email_id,ic_number,phonecode,mobile,collection_date,s_time,address,description) {
            var item = new Item(name,email_id,ic_number,phonecode,mobile,collection_date,s_time,address,description);
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

    function userModalOpen()
    {
        $("#myModal").modal("show");
        var cartArray = userDetail.listUser();
        if(cartArray.length > 0)
        {
            $('#name').val(cartArray[0].name);
            $('#email_id').val(cartArray[0].email_id);
            $('#ic_number').val(cartArray[0].ic_number);
            $('#phonecode').val(cartArray[0].phonecode);
            $('#mobile').val(cartArray[0].mobile);
            $('#collection_date').val(cartArray[0].collection_date);
            $('#s_time').val(cartArray[0].s_time);
            $('#address').val(cartArray[0].address);
            $('#description').val(cartArray[0].description);
            $('.show-cart1').show();
        }
        else
        {
            $('#name').val("");
            $('#email_id').val("");
            $('#ic_number').val("");
            $('#phonecode').val("+65");
            $('#mobile').val("");
            $('#collection_date').val("");
            $('#s_time').val("");
            $('#address').val("");
            $('#description').val("");
            $('.show-cart1').empty();
            $('.show-cart1').hide();
        }
    }
    
$('#ar_add_btn').click(function(event) {
    userDetail.clearUser();
    event.preventDefault();
    var name = $('#name').val();
    var email_id = $('#email_id').val();
    var ic_number = $('#ic_number').val();
    var phonecode = $('#phonecode').val();
    var mobile = $('#mobile').val();
    var collection_date = $('#collection_date').val();
    var s_time = $('#s_time').val();
    var address = $('#address').val();
    var description = $('#description').val();
    
    // $('.form-control').each(function() {
    //     if ($(this).val() == "") {
    //       $(this).siblings('#error_msg').text('Field needs to Fill');
    //     } else {    
    //       $(this).siblings('#error_msg').text('');
    //     }
    // });
    /*
    if(email_id != "") {
        if(IsEmail(email_id)==false){
            $('#invalid_email').show();
            return false;
        }
    }
    
    function IsEmail(email_id) {
        var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if(!regex.test(email_id)) {
           return false;
        }else{
           return true;
        }
    }
    */
    
    if(name != "" && mobile !="" )
    {
        $("#myModal").modal("hide");
        userDetail.addUserToCart(name,email_id,ic_number,phonecode,mobile,collection_date,s_time,address,description);
        displayCart_prasadam_user();
    }
});
function formatDateString(dateStr) {
    var dateObj = new Date(dateStr);
    var day = dateObj.getDate();
    var month = dateObj.getMonth() + 1; // JavaScript months are 0-based
    var year = dateObj.getFullYear();
    return ((day < 10) ? '0' + day : day) + '-' + ((month < 10) ? '0' + month : month) + '-' + year.toString();
}
function displayCart_prasadam_user() {
    var cartArray = userDetail.listUser();
    if(cartArray.length > 0)
    {
        //console.log(cartArray);
        //var formattedDate = [tempDate.getMonth() + 1, tempDate.getDate(), tempDate.getFullYear()].join('/');
        var formattedDate = formatDateString(cartArray[0].collection_date);
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
        + "<th style='padding: 5px 10px;line-height: 20px;width:10%'>Event Date </th><td style='background: #fff;border: 1px solid #dee2e6;padding: 5px 10px;line-height: 20px;'>"+ formattedDate +"</td>"
        + "</tr>";
        $('.show-cart1').html(output);
        $('.show-cart1').show();
    }
    else
    {
        $('#name').val("");
        $('#email_id').val("");
        $('#ic_number').val("");
        $('#phonecode').val("+65");
        $('#mobile').val("");
        $('#collection_date').val("");
        $('#s_time').val("");
        $('#address').val("");
        $('#description').val("");
        $('.show-cart1').empty();
        $('.show-cart1').hide();
    }
    //alert(cartArray.length);
}
displayCart_prasadam_user();


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
        filter: '.archanai'
      }
    });

  }

};
// Run the show!
filterList.init();
});

var shoppingCart = (function() {
  cart = [];
  // Constructor
  function Item(name, price, count, src,product_id,category) {
    this.name = name;
    this.price = price;
    this.count = count;
	  this.src = src;
	  this.product_id = product_id;
	  this.category = category;
  }
  
  // Save cart
  function saveCart() {
    sessionStorage.setItem('prasadamCart', JSON.stringify(cart));
  }
  
    // Load cart
  function loadCart() {
    cart = JSON.parse(sessionStorage.getItem('prasadamCart'));
  }
  if (sessionStorage.getItem("prasadamCart") != null) {
    loadCart();
  }
  
  var obj = {};
  
  // Add to cart
  obj.addItemToCart = function(name, price, count, src,product_id,category) {
    for(var item in cart) {
      if(cart[item].name === name) {
        cart[item].count ++;
        saveCart();
        return;
      }
    }
    var item = new Item(name, price, count, src,product_id,category);
    cart.push(item);
    saveCart();
  }
  // Set count from item
  obj.setCountForItem = function(name, count) {
    for(var i in cart) {
      if (cart[i].name === name) {
        cart[i].count = count;
        break;
      }
    }
  };
  // Remove item from cart
  obj.removeItemFromCart = function(name) {
      for(var item in cart) {
        if(cart[item].name === name) {
          cart[item].count --;
          if(cart[item].count === 0) {
            cart.splice(item, 1);
          }
          break;
        }
    }
    saveCart();
  }

  // Remove all items from cart
  obj.removeItemFromCartAll = function(name) {
    for(var item in cart) {
      if(cart[item].name === name) {
        cart.splice(item, 1);
        break;
      }
    }
    saveCart();
  }

  // Clear cart
  obj.clearCart = function() {
    cart = [];
    saveCart();
  }

  // Count cart 
  obj.totalCount = function() {
    var totalCount = 0;
    for(var item in cart) {
      totalCount += cart[item].count;
    }
    return totalCount;
  }

  // Total cart
  obj.totalCart = function() {
    var totalCart = 0;
    for(var item in cart) {
      totalCart += cart[item].price * cart[item].count;
    }
    return Number(totalCart.toFixed(2));
  }

  // List cart
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


// Add item
$('.add-to-cart').click(function(event) {
  event.preventDefault();
  var src = $(this).data('src');
  var name = $(this).data('name');
  var price = Number($(this).data('price'));
  var product_id = Number($(this).data('product_id'));
  var category = Number($(this).data('category'));
  shoppingCart.addItemToCart(name, price, 1, src,product_id,category);
  displayCart();
});

// Clear items
$('.clear-cart').click(function() {
  shoppingCart.clearCart();
  userDetail.clearUser();
  displayCart();
  $('#package_table_addon tbody').empty();
  $('.show-cart1').hide();
});


function displayCart() {
  var cartArray = shoppingCart.listCart();
  //  console.log("Cart Array:", cartArray);
  //alert(cartArray.length);
  var output = "";
  var popup = "";
  //var output = '<tr><td colspan="4" align="center"><img src="images/cart_is_empty.png" class="img-fluid" style="width:100px; margin:0 auto;"></td></tr>';
  if(cartArray.length == 0)
  {
    output += "tr><td colspan='4' align='center'><img src='./assets/archanai/images/cart_is_empty.png' class='img-fluid' style='width:150px; margin:0 auto;'></td></tr>";
  }
  else
  {
    for(var i in cartArray) {
      output += "<tr style='background:#d4aa0014;'>"
        + "<td style='width:10%'><input type='hidden' name='prasadam["+i+"][id]' value='"+cartArray[i].product_id+"' ><img data-name=" + cartArray[i].name + " src='" + cartArray[i].src + "' style='width:35px; border:1px solid #e9e6e6; background:#FFF; border-radius:5px;'></td>"
        + "<td style='width:42%'><input type='hidden' name='prasadam["+i+"][amt]' value='"+(Number(cartArray[i].price).toFixed(2))+"' ><span class='archa_name' style='text-transform:uppercase;'>" + cartArray[i].name + "</span><br>" 
        + "SGD : " + (Number(cartArray[i].price).toFixed(2)) + "</td>"
        + "<td style='width:35%'><div class='input-group'><button class='minus-item input-group-addon btn btn-primary' data-name=" + cartArray[i].name + ">-</button>"
        + "<input type='number' min='1' class='item-count_new' data-name='" + cartArray[i].name + "' value='"+cartArray[i].count+"'>"
        + "<button class='plus-item btn btn-primary input-group-addon' data-name=" + cartArray[i].name + ">+</button><input type='hidden' name='prasadam["+i+"][qty]' value='"+cartArray[i].count+"'></div></td>"
        + "<td style='width:8%'><button class='delete-item btn btn-danger' data-name=" + cartArray[i].name + ">X</button></td>"
        +  "</tr><tr><td colspan='4'></td></tr>";
      $('#submit, #submit_sep').removeAttr('disabled');
    }
    for(var i in cartArray) {
      popup += "<tr>"
        + "<td>" + i + "</td>"
      + "<td><span style='text-transform:uppercase;'>" + cartArray[i].name + "</span><br>SGD : " + Number(cartArray[i].price).toFixed(2) + "</td>"
        + "<td><p data-name='" + cartArray[i].name + "'>" + cartArray[i].count + "</p></td>"
      + "<td style='text-align:right;'>" + Number(cartArray[i].total).toFixed(2) + "</td></tr>";
    }
  }
  
  $('.show-cart').html(output);
  var totalCart = Number(shoppingCart.totalCart()).toFixed(2);
  // console.log("Total Cart:", totalCart);
  $('.total-cart').html(Number(shoppingCart.totalCart()).toFixed(2));
  $('#tot_amt').val(Number(shoppingCart.totalCart()).toFixed(2));
  $('.total-count').html(shoppingCart.totalCount());
  $('.show-cart_popup').html(popup);
  
  var tot =  shoppingCart.totalCount();
  if(tot==0) { 
  	$('#submit, #submit_sep').prop('disabled', true); 
  }
  //open_vehicle_entry();
}

function displayCart1() {
  var cartArray = shoppingCart.listCart();
  var output = '<tr><td colspan="4" align="center"><img src="./assets/archanai/images/cart_is_empty.png" class="img-fluid" style="width:100px; margin:0 auto;"></td></tr>';
  $('.show-cart').html(output);
  $('.total-cart').html(shoppingCart.totalCart());
  $('.total-count').html(shoppingCart.totalCount());
  $('.show-cart_popup').html(popup);
}

// Delete item button

$('.show-cart').on("click", ".delete-item", function(event) {
  var name = $(this).data('name')
  shoppingCart.removeItemFromCartAll(name);
  displayCart();
  open_vehicle_entry();
})


// -1
$('.show-cart').on("click", ".minus-item", function(event) {
  var name = $(this).data('name')
  shoppingCart.removeItemFromCart(name);
  displayCart();
  //open_vehicle_entry();
})
// +1
$('.show-cart').on("click", ".plus-item", function(event) {
  var name = $(this).data('name')
  shoppingCart.addItemToCart(name);
  displayCart();
  //open_vehicle_entry();
})

// Item count input
$('.show-cart').on("change", ".item-count_new", function(event) {
   var name = $(this).data('name');
   var count = Number($(this).val());
   shoppingCart.setCountForItem(name, count);
    displayCart();
});


displayCart();

function submit_modal()
{
	$('#modal').show().addClass('show');
}

function print_page()
{
  var cartArray = shoppingCart.listCart();
  var result = "";
  for(var i in cartArray) {
    result += "<tr>"
      + "<td>" + i + "</td>"
	    + "<td><span style='text-transform:uppercase;' class='archname'>" + cartArray[i].name + "</span><br>SGD : " + cartArray[i].price + "</td>"
      + "<td><p data-name='" + cartArray[i].name + "'>" + cartArray[i].count + "</p></td>"
	    + "<td style='text-align:right;'>" + cartArray[i].total + "</td></tr>";
  }
  $('#prin_page').html(result);
  shoppingCart.clearCart();
  displayCart();
  window.print();
}

</script>

<script>
    $(function () {
        $("[data-dismiss='modal']").on('click', function () {
             $('.modal').hide();
        })
    })

    $(document).on('click', '.package_id', function(){
            shoppingCart.clearCart();
            var package_id = this.value;
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>/outdoor_online/fetch_outdoor_services",
                data: {package_id: package_id},
                dataType: 'json',
                beforeSend: function() {    
                    // $("#loader").show();
                },
                success: function(data) {
                    console.log('packages data received:', data);
                    if (data.success) {
                        
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
                      
                    }
                },
                complete: function() {
                    // $("#loader").hide();
                }
            });
          });

</script>
<script>

function rePrint()
{
    $("#myModal_reprint").modal("show");
}

function validateFormDetails() {
        var isValid = true;
        var name = $('#name').val().trim();
        var mobile = $('#mobile').val().trim();
        var eventDate = $('#collection_date').val().trim();
        var estimatedTime = $('#s_time').val().trim();

        if (!name || !mobile || !eventDate || !estimatedTime) {
            isValid = false;
        }
        
        return isValid;
    }

$("#submit").click(function(){
    // Check if total amount is 0
    var totalAmount = parseFloat($('#tot_amt').val()) || 0;
    
    if (totalAmount === 0 || totalAmount === 0.00) {
        $('#errorModalBody').text("Total amount cannot be zero. Please select a package or add services/add-ons before submitting.");
        $('#errorModal').modal('show');
        setTimeout(function() {
            $('#errorModal').modal('hide');
        }, 3000);
        return false;
    }
    
    if (!validatePaymentDetails()) {
        $('#errorModalBody').text("Please select a payment method.");
        $('#errorModal').modal('show');
        setTimeout(function() {
            $('#errorModal').modal('hide');
        }, 2000);
    } else if (!validateFormDetails()) {
        $('#errorModalBody').text("Please fill in all required fields.");
        $('#errorModal').modal('show');
        setTimeout(function() {
            $('#errorModal').modal('hide');
        }, 2000);
    } else {
        save_prasadam();
    }
});

window.onbeforeunload = () => {
  userDetail.clearUser();  
};

// $("#submit_sep").click(function(){
// 	save_prasadam(1);
// }); 
</script>


<!-- <script>
     $('#search').keyup(function() {

//alert($('#search').val());
$.ajax
    ({
        type:"POST",
        url: "<?php echo base_url();?>/prasadam_online/show_product",
        data:{prod:$('#search').val()},
        success: function (response) {
            //alert($('#search').val());
        var obj=jQuery.parseJSON(response);
            console.log(obj.row)
            $('#products').empty();
            $('#products').append(obj.row);
            //alert(data);
        //$('#billno').val(data);
        }
    })
});

$("#clear").click(function() {
       $(".cart-table .all_close").empty();
       $("#count").val(0);
        sum_total();
    });
	
	$('tr td #remove').click(function() {
    	$(this).css({"display":"block"});
	}); 
</script> -->


<script>
function addtocart(ids) {
    // Clear the cart when a new product is selected
    $('#package_table_addon tbody').empty();
    $(".cart-table tr.all_close").remove(); // Remove all cart rows
    $(".cart-table tr").not(".all_close").remove(); // Remove service rows if any
    
    // Reset all product cards to the default color
    $('.product-card').removeClass('selected-product');

    if (!$(".cart-table tr.all_close").length) {
        $(".show-cart img").remove();
        $(".cart-table").show();
    }
    
    // Change the color of the selected product's card
    $("#"+ids).addClass('selected-product');

    var text = $("#nm_" + ids).text();
    var amt = Number($("#amt_" + ids).attr("data-id")).toFixed(2);
    
    // AJAX call to fetch services for the selected package
    $.ajax({
        url: "<?php echo base_url('outdoor_online/fetch_package_settings'); ?>", // Replace with your actual backend path
        type: 'POST',
        data: { package_id: ids },
        success: function (response) {
            var packageDetails = ''; // To store package details in table format

            // Create a table structure for services
            packageDetails += '<table style="width: 100%; font-size: 14px;">';
            packageDetails += '<thead><tr><th>Name</th><th>Description</th><th>Qty</th></tr></thead>';
            packageDetails += '<tbody>';

            // Iterate over the response and append service name, description, and quantity
            $.each(response, function (index, item) {
                packageDetails += `<tr>
                    <td style="font-size: 14px">${item.name}</td>
                    <td style="font-size: 14px">${item.description}</td>
                    <td style="font-size: 14px">${item.quantity}</td>
                </tr>`;
            });

            packageDetails += '</tbody></table>';

            // Create the cart row with "Package" and "Services" headings
            var text1 = `<tr class="all_close" data-id="${ids}" id="remov${ids}">
                            <td style="width: 40%;">
                                <input type="hidden" id="id_${ids}" name="package_id" value="${ids}">
                                <p><strong>Package:<br></strong> ${text}</p>
                            </td>
                            <td style="width: 20%;"><input type="hidden" style="text-align: center;" class="row_amt" readonly name="services[0][amt]" value="${amt}"></td>
                            <td style="width: 8%;"><input type="hidden" style="text-align: center;" class="row_qty" name="services[0][qty]" readonly value="1"></td>
                            <td style="width: 20%;"><input type="hidden" style="text-align: center;" class="row_tot" readonly name="tot" id="tot_${ids}" value="${amt}"></td>
                            <td style="width: 12%;"><label class="btn btn-info" style="font-size:10px;" onclick="remove(${ids})" id="remove">X</label></td>
                        </tr>`;
                        // <tr>
                        //     <td colspan="5"><p><strong>Services:</strong></p> ${packageDetails}</td>
                        // </tr>

            $(".cart-table").append(text1);

            sum_total();
            sum_balance();
        }
    });
}

//<input type="hidden" id="id_${ids}" name="services[0][id]" value="${ids}">



    // function sum_total() {
    //   var total_qty = 0;
    //   $(".row_qty").each(function() {
    //       total_qty += parseFloat($(this).val());
    //   });

    //   var total_amt = 0;
    //   $(".row_tot").each(function() {
    //       total_amt += parseFloat($(this).val());
    //   });

    //   $("#tot_amt").val(Number(total_amt).toFixed(2));
    //   $(".total-cart").text(Number(total_amt).toFixed(2)); // Ensure this is correct and visible
    //   $(".tot_amt_txt").text(Number(total_amt).toFixed(2));
    // }

  // function remove(id){
  //     $(".cart-table #remov"+id).remove();

  //     $("#count").val(  parseInt($("#count").val())-1);
  //       sum_total();
  //       sum_balance();
  // }

//   function remove(ids) {
//     // Remove the product row
//     $("#remov" + ids).remove();
    
//     // Remove the associated services row (the next row after the product)
//     $("#remov" + ids).next().remove();

//     // Check if there are no more items in the cart and hide the table
//     if (!$(".cart-table tr.all_close").length) {
//         $(".cart-table").hide();  // Hide the cart table if empty
//         $(".show-cart").html('<img src="path_to_empty_cart_image.jpg" alt="Empty Cart">'); // Optionally show empty cart image
//     }

//     sum_total();
//     sum_balance();
// }

function remove(ids) {

    $("#remov" + ids).remove();
    $("#remov" + ids).next().remove();

    // Reset the selected card's color
    $("#"+ids).removeClass('selected-product');

    // Check if cart is empty, and show the empty cart state
    if (!$(".cart-table tr.all_close").length) {
        $(".cart-table").hide();
        $(".show-cart").html('<img src="path_to_empty_cart_image.jpg" alt="Empty Cart">');
    }

    sum_total();
    sum_balance();
}



  function man_qun(ids){
      //alert(ids)
      sum_total();
      var amt = Number($("#amt_"+ids).attr("data-id")).toFixed(2);
      var cnt = $("#qty_"+ids).val();
      var tot = amt * cnt;
      $("#tot_"+ids).val(tot.toFixed(2));
      sum_total();
      sum_balance();
  }

  $('#entered_amount').keyup(function() {
      sum_balance();
  });

    function sum_balance(){
        var enter_amt = $("#entered_amount").val();
        var tot_amt = $("#tot_amt").val();
        var balance_amt = Number(tot_amt).toFixed(2) - Number(enter_amt).toFixed(2);
        var convert_val = Math.abs(balance_amt);
        $("#tot_balance_amt").val(convert_val.toFixed(2));
        $(".tot_balance_amt_txt").text(convert_val.toFixed(2));
    }

  function resetBorders() {
        var fieldsToCheck = ['#name', '#mobile', '#collection_date', '#s_time']; // Include all potential fields
        fieldsToCheck.forEach(function(field) {
            $(field).css('border', '');  // Reset border color to default or remove the red border
            $(field).next('.error_msg').remove(); // Also clear any error messages
        });
    }

    function validatePaymentDetails() {
        if (!$('input[name="pay_method"]:checked').length) {
            $('input[name="pay_method"]').closest('.payment').find('.error_msg').remove();
            //$('input[name="pay_method"]').closest('.payment').append('<div class="error_msg" style="color: red;">Please select a payment method.</div>');
            return false;
        } else {
            $('input[name="pay_method"]').closest('.payment').find('.error_msg').remove();
            return true;
        }
    }

//     function save_archanai(sep_print = 0) {
//         $.ajax({
//             type: "POST",
//             url: "<?php echo base_url(); ?>/prasadam_online/save?sep_print=" + sep_print,
//             data: $("form").serialize(),
//             beforeSend: function () {
//                 $("#submit_mob, #submit_sep").prop('disabled', true);
//                 $("#loader").show();
//             },
//             success: function (data) {
//                 var obj = jQuery.parseJSON(data);
//                 if (obj.err !== '') {
//                     console.log(obj);
//                     $("#submit_mob, #submit_sep").prop('disabled', false);
//                     $('#alert_modal').modal('show');
//                     $("#spndeddelid").text(obj.err);
//                 } else {
//                     $("#submit_mob, #submit_sep").prop('disabled', true);
//                     shoppingCart.clearCart();
//                     displayCart();
//                     window.open("<?php echo base_url(); ?>/prasadam_online/payment_process/" + obj.id, "_blank", "width=680,height=500");
//                     userDetail.clearUser();
//                     window.location.reload(true);
//                 }
//             },
//             complete: function () {
//                 $("#loader").hide();
//             },
//             error: function (err) {
//                 console.log('Error:', err);
//                 $("#submit_mob, #submit_sep").prop('disabled', false);
//             }
//         });
//     }
// });



    // $("#submit_mob").click(function () {
    //     save_archanai();
    //   });

    //   function save_archanai(sep_print = 0) {
    //     $.ajax
    //       ({
    //         type: "POST",
    //         url: "<?php echo base_url(); ?>/prasadam_online/save?sep_print=" + sep_print,
    //         data: $("form").serialize(),
    //         beforeSend: function () {
    //           $("#submit_mob, #submit_sep").prop('disabled', true);
    //           $("#loader").show();
    //         },
    //         success: function (data) {
    //           obj = jQuery.parseJSON(data);
    //           if (obj.err != '') {
    //             console.log(obj);
    //             $("#submit_mob, #submit_sep").prop('disabled', false);
    //             $('#alert_modal').modal('show');
    //             $("#spndeddelid").text(obj.err);
    //           } else {
    //             $("#submit_mob, #submit_sep").prop('disabled', true);
    //             shoppingCart.clearCart();
    //             displayCart();
    //             window.open("<?php echo base_url(); ?>/prasadam_online/payment_process/" + obj.id, "_blank", "width=680,height=500");
    //             userDetail.clearUser();
    //             window.location.reload(true);
    //           }
    //         },
    //         complete: function (data) {
    //           // Hide image container
    //           $("#loader").hide();
    //         },
    //         error: function (err) {
    //           $("#submit_mob, #submit_sep").prop('disabled', false);
    //           console.log('err');
    //           console.log(err);
    //         }
    //       });
    //   }

    // $("#submit_mob")click(function(){
    // $("#submit_mob").off().on('click', function(){
    //     $.ajax
    //     ({
    //         type:"POST",
    //         url: "<?php echo base_url(); ?>/prasadam_online/save",
    //         data: $("form").serialize(),
    //         beforeSend: function() {    
		// 		    //$("#submit").prop('disabled', true);
    //             $("#loader").show();
		// 	    },
    //         success:function(data)
    //         {
		// 		    console.log('savedata:',data);
    //             obj = jQuery.parseJSON(data);
    //             //alert(obj.id);
    //             //return;
    //             if(obj.err != ''){
    //                 $('#alert-modal').modal('show', {backdrop: 'static'});
    //                 $("#spndeddelid").text(obj.err);
    //             }else{
    //               //userDetail.clearUser();
    //                 printData(obj.id);
    //             }
    //         },
    //         complete:function(data){
    //             // Hide image container
    //             $("#loader").hide();
    //         }
    //     });
    // });  


    function printData(id) {
		
		// if ($("#print").prop('checked')==true)	
		// {
			$.ajax({
				url: "<?php echo base_url(); ?>/prasadam_online/print_booking/"+id,
				type: 'POST',
				success: function (result) {
					console.log('printData',result)
					popup1(result);
				}
			});
		// }
		 //else window.location.reload(true);
    }


function popup1(data) {
    console.log("Entering popup1 function");

    // Create and append the iframe to the body
    var frame1 = $('<iframe />', {
        name: 'frame1',
        css: {
            position: 'absolute',
            top: '-1000000px'
        }
    }).appendTo('body');

    console.log("Iframe appended to body");

    // Accessing the document of the iframe
    var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow.document : frame1[0].contentDocument;

    // Opening the document to write the HTML content
    frameDoc.open();
    frameDoc.write('<html><head><title>Print</title></head><body>');
    frameDoc.write(data); // Writing the data to be printed
    frameDoc.write('</body></html>');
    frameDoc.close();

    // Wait for 1 second to allow the content to load fully
    setTimeout(function() {
        console.log("Attempting to print after 1-second delay");
        try {
            frame1[0].contentWindow.focus();  // Focusing the iframe
            frame1[0].contentWindow.print();  // Triggering the print dialog only once
        } catch (e) {
            console.error('Printing error:', e);
        }

        // Clean up: Remove the iframe and consider whether a page reload is necessary
        setTimeout(function () {
            console.log("Removing iframe");
            frame1.remove();
            //window.location.reload(true);
        }, 1000);  // Time after user interacts with the print dialog
    }, 1000);  // Delay to ensure all content, including images, is loaded

    userDetail.clearUser();
    console.log("popup1 function complete");
}


</script>

</body>
