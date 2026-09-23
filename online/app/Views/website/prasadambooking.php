
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

.product { /*height:500px;*/ max-height:77vh; overflow:auto; }
.product::-webkit-scrollbar {
      width:10px; // manage scrollbar width here
    }
    .product::-webkit-scrollbar * {
      background:transparent; // manage scrollbar background color here
    }
    .product::-webkit-scrollbar-thumb {
      background:#ffefe2 !important; // manage scrollbar thumb background color here
    }
.cart { /*height:330px;*/ height:32vh; max-height:32vh; overflow:auto; width:100%; margin-bottom:10px; margin-top:10px; }
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


.portfolio img {
    max-width: 100%;
    position: relative;
    top: 0;
}
.prod_img {
    width: 90px;
    margin: 0 auto;
    border-radius: 50%;
    min-height: 90px;
    max-height: 90px;
    background: #e1e1d68a;
    padding: 5px;
}
.card {
    box-shadow: 0 5px 10px 0 rgba(230, 230, 243, 0.88);
    -webkit-box-shadow: 0 5px 10px 0 rgba(230, 230, 243, 0.88);
    -moz-box-shadow: 0 5px 10px 0 rgba(230, 230, 243, 0.88);
    -ms-box-shadow: 0 5px 10px 0 rgba(230, 230, 243, 0.88);
}
.card .card-body {
    padding: 0.5rem 0.55rem;
}
.justify-content-between {
    -webkit-box-pack: justify !important;
    -ms-flex-pack: justify !important;
    justify-content: space-between !important;
}

.flex-column {
    -webkit-box-orient: vertical !important;
    -webkit-box-direction: normal !important;
    -ms-flex-direction: column !important;
    flex-direction: column !important;
}
.d-flex {
    display: -webkit-box !important;
    display: -ms-flexbox !important;
    display: flex !important;
}
.card-body {
    -webkit-box-flex: 1;
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
    padding: 1.25rem;
}
.justify-content-between {
    justify-content: space-between !important;
}
.flex-column {
    flex-direction: column !important;
}
.d-flex, .loader-demo-box, .layouts-preview-main-wrapper .layouts-preview-wrapper .preview-item a .item-title, .navbar .navbar-menu-wrapper .navbar-nav, .navbar .navbar-menu-wrapper .navbar-nav .nav-item, .navbar .navbar-menu-wrapper .navbar-nav .nav-item.dropdown .navbar-dropdown .dropdown-item {
    display: flex !important;
}
.card {
    padding: 0;
}
.card {
   	margin-bottom: 15px;
}
.mb-2, .my-2 {
    margin-bottom: 0.5rem !important;
}
.mt-2, .my-2 {
    margin-top: 0.5rem !important;
}
.align-items-center {
    -webkit-box-align: center !important;
    -ms-flex-align: center !important;
    align-items: center !important;
}

.justify-content-between {
    -webkit-box-pack: justify !important;
    -ms-flex-pack: justify !important;
    justify-content: space-between !important;
}
.d-flex {
    display: -webkit-box !important;
    display: -ms-flexbox !important;
    display: flex !important;
}
.mb-2, .my-2 {
    margin-bottom: 0.5rem !important;
}
.mt-2, .template-demo > .btn-group, .template-demo > .btn-group-vertical, .template-demo .circle-progress, .my-2 {
    margin-top: 0.5rem !important;
}
.align-items-center, .loader-demo-box, .layouts-preview-main-wrapper .layouts-preview-wrapper .preview-item a .item-title, .navbar .navbar-menu-wrapper .navbar-nav .nav-item, .navbar .navbar-menu-wrapper .navbar-nav .nav-item.nav-settings, .navbar .navbar-menu-wrapper .navbar-nav .nav-item.nav-profile, .navbar .navbar-menu-wrapper .navbar-nav .nav-item.dropdown .navbar-dropdown .dropdown-item {
    align-items: center !important;
}
.justify-content-between {
    justify-content: space-between !important;
}
.d-flex, .loader-demo-box, .layouts-preview-main-wrapper .layouts-preview-wrapper .preview-item a .item-title, .navbar .navbar-menu-wrapper .navbar-nav, .navbar .navbar-menu-wrapper .navbar-nav .nav-item, .navbar .navbar-menu-wrapper .navbar-nav .nav-item.dropdown .navbar-dropdown .dropdown-item {
    display: flex !important;
}
.text-muted.arch {
    color: #000000 !important;
    font-size: 14px;
    text-align: center;
    padding: 10px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    max-height: 50px;
    min-height: 50px;
    text-transform: uppercase;
}

.text-muted {
    color: #6c757d !important;
}
.mb-0, .my-0 {
    margin-bottom: 0 !important;
}
.text-muted, .preview-list .preview-item .preview-item-content p .content-category {
    color: #a5abcc !important;
}
.mb-0, .my-0 {
    margin-bottom: 0 !important;
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
				<h2 style="font-family: Roboto;font-size: 30px;text-transform: uppercase;color: #000;font-weight: bold;">Prasadam Booking</h2>
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
										<div class="col-md-8"></div>
										<div class="col-md-4" style="text-align: right;">
											<label style="font-size:16px;background-color: #7e4555;border-color: #7e4555;" class="btn btn-primary" onClick="cart_open();"><i class="fa fa-shopping-cart"></i>
												<span id="cart_total_count">0</span>
											</label>
										</div>
									</div>
									<div class="row">&nbsp;</div>
									<div class="row prod product" id="portfoliolist">
										<?php foreach($prasadam_settings as $row) { ?>
										<div class="col-xl-3 col-sm-6 col-lg-3 col-md-4 grid-margin stretch-card portfolio archanai" data-cat="archanai">
											<div class="card">
												<a href="#" data-product_id="<?php echo $row['id']; ?>" data-name="<?php echo str_replace(' ', '_', strtolower($row['name_eng'])); ?>" data-price="<?php echo (float)($row['amount']);?>" class="add-to-cart" data-src="<?php echo base_url(); ?>/uploads/prasadam_setting/<?php echo $row['image']; ?>" data-category="1">
													<div class="card-body d-flex flex-column justify-content-between">
													<img class="img-fluid prod_img" src="<?php echo base_url(); ?>/uploads/prasadam_setting/<?php echo $row['image']; ?>">
													<div class="d-flex justify-content-between align-items-center mb-2 mt-2" style="flex-direction: column;">
														<p class="mb-0 text-muted arch"><?php echo $row['name_tamil'].' <br>'.$row['name_eng']; ?></p>
													</div>
													</div>
												</a>
											</div>
										</div>
										<?php } ?>   
									</div>
                  <!--Cart details START-->
									<div id="cart_secton_open" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <div class="row">
                            <div class="col-md-12">
                              <h3 style="font-family: timesnewroman;font-size: 25px;font-weight: bold;">Prasadam Details</h3>
                            </div>
                          </div>													
                        </div>
                        <div class="modal-body">
                          <div class="row">
                            <div class="prod cart col-md-12">
                              <table class="show-cart" style="width:100%;"></table>
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-info" data-bs-dismiss="modal">Close</button>
                        </div>
                      </div><!-- /.modal-content -->
                    </div>
                  </div>
                  <!--Cart details END-->
									<div class="row">&nbsp;</div>
                                    
									<div class="row">
										<div class="col-sm-12" style="text-align:right;">
											<label class="default-btn" style="background: #7e4555;">
											<span id="total_amt_label" style="font-size: 30px;" class="total-cart">RM 0.00</span></label>
											<input type="hidden" id="tot_amt" name="tot_amt">
										</div>
									</div>
									
									
                                </div>
                                                        
                                <div class="col-md-4 det" style="background: #7e4555;padding: 15px;">
                                    
                                    <div >
                                        <h3 style="margin-top:0px;font-family: Roboto;color: #f1c152;font-size: 21px;text-transform: uppercase;">Register Details</h3>
                                            <div class="row" style="margin-top: 25px;">
												<div class="col-sm-12">
													<div class="form-group form-float">
														<div class="form-line">
															<label class="form-label">Date <span style="color: red;">*</span></label>
															<input type="date" class="form-control" id="date" name="date" value="<?php echo date('Y-m-d'); ?>" required>
														</div>
													</div>
												</div>
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
															<label class="form-label">Email Address</label>
                                                            <input type="email" class="form-control" name="email" id="email" > 
                                                            
                                                        </div>
                                                    </div>
                                                </div>
												<div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="phone_no">Mobile No <span style="color: red;">*</span></label>
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
                                                                <input class="form-control" type="number" id="phone_no" name="phone_no" min="0" autocomplete="off" >
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>

                                                
                                                  <div class="col-md-6">
                                                      <div class="form-group">  
                                                          <label class="form-label" for="collection_date">Collection Date <span style="color:red;">*</span></label>
                                                          <input class="form-control" type="date" id="collection_date" name="collection_date" autocomplete="off" min="<?php echo date('Y-m-d'); ?>">
                                                      </div>
                                                  </div>
                                                  <div class="col-md-6">
                                                      <div class="form-group">  
                                                          <label class="form-label" for="s_time">Estimated Time <span style="color:red;">*</span></label>
                                                          <input class="form-control" type="time" id="s_time" name="s_time" autocomplete="off" >
                                                      </div> 
                                                  </div>
                                               

                                                <div class="col-sm-6">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
															                              <label class="form-label">IC / Passport No </label>
                                                            <input type="number" class="form-control" name="ic_num" id="ic_num">
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">  
                                                        <label class="form-label" for="dob">DOB <span style="color:red;">*</span></label>
                                                        <input class="form-control" type="date" id="dob" name="dob" autocomplete="off" max="<?php echo date('Y-m-d'); ?>">
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
                          <input type="submit" value="Pay Now" class="btn btn-success btn-lg" id="submit">
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
<script  src="<?php echo base_url(); ?>/assets/archanai/script.js"></script>
<script>
	function cart_open(){
		$('#cart_secton_open').modal('show');
	}

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
  displayCart();
});


function displayCart() {
  var cartArray = shoppingCart.listCart();
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
        + "RM : " + (Number(cartArray[i].price).toFixed(2)) + "</td>"
        + "<td style='width:25%'><div class='input-group'><button class='minus-item input-group-addon btn btn-primary' data-name=" + cartArray[i].name + ">-</button>"
        + "<input type='number' min='1' style='text-align: center;width: 100px;' class='item-count_new' data-name='" + cartArray[i].name + "' value='"+cartArray[i].count+"'>"
        + "<button class='plus-item btn btn-primary input-group-addon' data-name=" + cartArray[i].name + ">+</button><input type='hidden' name='prasadam["+i+"][qty]' value='"+cartArray[i].count+"'></div></td>"
        + "<td style='width:8%'><button class='delete-item btn btn-danger' data-name=" + cartArray[i].name + ">X</button></td>"
        +  "</tr><tr><td colspan='4'></td></tr>";
    }
    for(var i in cartArray) {
      popup += "<tr>"
        + "<td>" + i + "</td>"
      + "<td><span style='text-transform:uppercase;'>" + cartArray[i].name + "</span><br>RM : " + Number(cartArray[i].price).toFixed(2) + "</td>"
        + "<td><p data-name='" + cartArray[i].name + "'>" + cartArray[i].count + "</p></td>"
      + "<td style='text-align:right;'>" + Number(cartArray[i].total).toFixed(2) + "</td></tr>";
    }
  }
  
  $('.show-cart').html(output);
  $(".total-cart").html("RM "+Number(shoppingCart.totalCart()).toFixed(2));
  $('#tot_amt').val(Number(shoppingCart.totalCart()).toFixed(2));
  $('.total-count').html(shoppingCart.totalCount());
  $('.show-cart_popup').html(popup);
  
  var tot =  shoppingCart.totalCount();
  $("#cart_total_count").text(tot);
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
</script>
<script src="<?php echo base_url(); ?>/assets/jquery.validate.js"></script>
<script>
  $('#form_validation').validate({
		rules: {
			"name": {
				required: true,
			},
      "phone_no": {
				required: true,
			},
      "collection_date": {
				required: true,
			},
      "s_time": {
				required: true,
			},
      "dob": {
				required: true,
			}
		},
		messages: {
			"name": {
				required: "Name is required"
			},
      "phone_no": {
				required: "Phone no is required"
			},
      "collection_date": {
				required: "Collection date is required"
			},
      "s_time": {
				required: "Estimated time is required"
			},
      "dob": {
				required: "DOB is required"
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
        var cartArray = loginDetail.listLogin();
        if(cartArray.length > 0){
            var customer_id = cartArray[0].login_id;
            $.ajax({
                url: '<?php echo base_url(); ?>/online_prasadam/save',
                type: 'post',
                data: $('#form_validation').serialize() + "&user_login_id="+customer_id,
                success: function (response) {
                  obj = jQuery.parseJSON(response);
                  if(obj.err != ''){
                    $('#alert-modal').modal('show');
                    $("#spndeddelid").text(obj.err);
                  }else{
                    shoppingCart.clearCart();
                    window.open("<?php echo base_url(); ?>/online_prasadam/payment_process/" + obj.id, "_blank", "width=680,height=500");
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