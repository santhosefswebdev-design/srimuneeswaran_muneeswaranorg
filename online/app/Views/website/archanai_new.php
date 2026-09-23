<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/website/archanai_style.css">
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
.show-cart {
    max-height: 350px;
    overflow: auto;
}
.show-cart tr {
    border-radius: 10px;
}
.show-cart td {
    font-size: 11px;
    padding: 5px;
}
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
.item-count {
    background: #dfdbdb;
    padding: 5px 1px;
    margin: 0 3px;
    border-radius: 5px;
    max-width: 27px;
    min-width: 27px;
    text-align: center;
    font-size: 14px;
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
    padding: 0.5rem 0.15rem;
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
#filters {
    margin: 0 0 10px;
    padding: 0;
    list-style: none;
    width: 100%;
    overflow: auto;
    display: inherit;
}
.clearfix {
    zoom: 1;
}
#filters li:first-child {
    margin-left: 0;
}
#filters li {
    float: left;
    background: #ffefe2;
    margin: 0 3px;
    width: 110px;
    max-height: 75px;
    min-width: 110px;
}
#filters li span.active {
  background: linear-gradient(179deg, rgb(126 69 85) 0%, rgb(126 69 85) 35%, rgb(126 69 85 / 79%) 100%);
    color: #fff;
}

#filters li span {
    display: block;
    padding: 10px 2px;
    text-decoration: none;
    color: #000;
    cursor: pointer;
    transition: color 300ms ease-in-out;
    text-align: center;
    line-height: 1.5em;
    font-size: 13px;
    height: 60px;
}
.prod1::-webkit-scrollbar {
    height: 3px;
}
.prod::-webkit-scrollbar-thumb:hover, .prod1::-webkit-scrollbar-thumb:hover {
    background: #e91e63;
}
.prod::-webkit-scrollbar-thumb, .prod1::-webkit-scrollbar-thumb {
    background: #7e4555;
}
.prod::-webkit-scrollbar-track, .prod1::-webkit-scrollbar-track {
    background: #f1f1f1;
}
.cl_btn {
    background: linear-gradient(179deg, rgb(212 0 0) 0%, rgb(242 105 105) 35%, rgb(209 59 59) 100%);
    border-radius: 15px;
    font-weight: bold;
}

.btn {
    padding: 2px 15px;
    font-size: 16px;
}
.ar_btn {
    background: linear-gradient(179deg, rgb(0 126 212) 0%, rgb(16 197 180) 35%, rgb(59 134 209) 100%);
    border-radius: 15px;
    font-weight: bold;
	color:#FFFFFF;
}
.form-group { margin:10px 0; }
.table th { background:#642738; color:#FFFFFF; }
.table tr td { border: 1px solid #CCCCCC; }
.table>:not(:first-child) {
     border-top: 0px solid currentColor; 
}
</style>
<div class="pageheader" style=""><!--background: url(<?php echo base_url(); ?>/assets/website/img/banner.png);background-repeat: no-repeat;-->
	<div class="container">
		<div class="row">
			<div class="col-md-12" style="    text-align: center;">
				<h2 style="font-family: Roboto;font-size: 30px;text-transform: uppercase;color: #000;font-weight: bold;">Archanai</h2>
			</div>
		</div>
	</div>
</div>
<div class="contact padding--top padding--bottom" style="padding: 40px 0 100px 0;background:#ffffff">
    <div class="container-fluid" style="padding:0 4%;">
        <?php if ($_SESSION['succ'] != '') { ?>
            <div class="row" style="padding: 0 30%;margin: 0px 0 15px 0;" id="content_alert">
                <div class="suc-alert" style="width: 100%;">
                    <span class="suc-closebtn" onClick="this.parentElement.style.display='none';">&times;</span> 
                    <p><?php echo $_SESSION['succ']; ?></p> 
                </div>
            </div>
        <?php } ?>
        <?php if ($_SESSION['fail'] != '') { ?>
            <div class="row" style="padding: 0 30%;margin: 0px 0 15px 0;" id="content_alert">
                <div class="alert" style="width: 100%;">
                    <span class="closebtn" onClick="this.parentElement.style.display='none';">&times;</span> 
                    <p><?php echo $_SESSION['fail']; ?></p>
                </div>
            </div>
        <?php } ?>
        
        
        
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="selectbasic">Select Archanai Category :</label>
                    <select class="form-control" data-val="true" id="arch_cat" name="arch_cat" required="">
                    <option value="">Select Category</option>
                    <?php foreach ($arch_ctry as $row) { ?>
                    <option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
                    <?php } ?>
                    </select>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="selectbasic">Select Archanai :</label>
                    <select class="form-control" id="archanai" name="archanai" >
                    <option value="">Select Archanai</option>
                    </select>
                </div>
            </div>
            
            <!--<div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="selectbasic">Select Archanai :</label>
                    <input type="text" placeholder="Enter Name.." name="ar_name"  id="ar_name" class="form-control" value="" />
                </div>
            </div>-->
            
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="selectbasic">Name :</label>
                    <input type="text" placeholder="Enter Name.." name="ar_name"  id="ar_name" class="form-control" value="" />
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="selectbasic">Rasi :</label>
                    <select class="form-control" name="rasi_id" id="rasi_id">
                        <option value="">Select Rasi</option>
                        <?php foreach ($rasi as $row) { ?>
                          <option value="<?php echo $row['id']; ?>"><?php echo $row['name_eng']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label" for="selectbasic">Natchathiram :</label>
                    <select class="form-control" name="natchathra_id" id="natchathra_id">
                        <option>Select Natchathiram</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4" align="right">
                <div class="form-group">
                    <br>
                    <button class="btn btn-info" onclick="appen()" type="button">Add</button>
                </div>
            </div>
        </div>  
        
        
        <div class="row">
            <div class="col-md-12">
            <div class="table-responsive">
            <table class="table" id="table" border="1">
            <thead>
            <tr><th>Archanai Group</th><th>Archanai</th>
            <th>Name</th><th>Rasi</th><th>Natchathram</th><th></th></tr>
            </thead>
            <tbody>
            </tbody>
            </table>
            </div>
            </div>
            <input type="hidden" id="tot_count" value="0">
        </div>
        
        <div class="row">
        	<div class="col-md-6">
                <p>Total (RM) : <span class="total-cart"></span></p>
                <input type="hidden" id="tot_amt" name="tot_amt">
            </div>
            <div class="col-md-6" align="right">
                <button class="btn btn-success" type="submit">Proceed</button>
                <button class="btn btn-danger" type="reset">Clear</button> 
            </div>
        </div>
    
       
        </div>    


    </div>
  </div>


  
  

<div id="alert_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
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
<script  src="<?php echo base_url(); ?>/assets/archanai/script.js"></script>

<script>
function open_vehicle_entry()
{
    var status_check = 0;
    $( ".archanai_category").each(function() {
        arcat = parseInt($(this).val());
        if(arcat == 2){
            status_check++;
        }
    });
    if(status_check > 0)
    {
        $("#vehicle_input_box").css({"display":"block"});
        $("#vehicle_table_box").css({"display":"block"});
    }
    else
    {
        $("#vehicle_input_box").css({"display":"none"});
        $("#vehicle_table_box").css({"display":"none"});
    }
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
          filter: '.<?php echo $default; ?>'
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
  function Item(name, price, count, src,product_id,category,diety_id) {
    this.name = name;
    this.price = price;
    this.count = count;
    this.src = src;
    this.product_id = product_id;
    this.category = category;
    this.diety_id = diety_id;
  }
  // Save cart
  function saveCart() {
    sessionStorage.setItem('shoppingCart', JSON.stringify(cart));
  }
  // Load cart
  function loadCart() {
    cart = JSON.parse(sessionStorage.getItem('shoppingCart'));
  }
  if (sessionStorage.getItem("shoppingCart") != null) {
    loadCart();
  }
  var obj = {};
  // Add to cart
  obj.addItemToCart = function(name, price, count, src,product_id,category,diety_id) {
    for(var item in cart) {
      if(cart[item].name === name) {
        cart[item].count ++;
        saveCart();
        return;
      }
    }
    var item = new Item(name, price, count, src,product_id,category,diety_id);
    cart.push(item);
    saveCart();
  }
  // Set count from item
  obj.setCountForItem = function(name, count) {
    for(var i in cart) {
      if (cart[i].name === name) {
        cart[i].count = count;
    saveCart();
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
    name = name.replace("_", " ");
    var price = Number($(this).data('price'));
    var product_id = Number($(this).data('product_id'));
    var category = Number($(this).data('category'));
    var diety_id = $(this).data('diety_id');
    shoppingCart.addItemToCart(name, price, 1, src,product_id,category,diety_id);
    displayCart();
});
// Clear items
$('.clear-cart').click(function() {
    shoppingCart.clearCart();
    displayCart();
});
function displayCart() {
  var cartArray = shoppingCart.listCart();
  var output = "";
  var popup = "";
  if(cartArray.length == 0)
  {
    output += "tr><td colspan='4' align='center'><img src='<?php echo base_url(); ?>/assets/archanai/images/cart_is_empty.png' class='img-fluid' style='width:150px; margin:0 auto;'></td></tr>";
  }
  else
  {
    for(var i in cartArray) {
      output += "<tr style='background:#ffefe2;'>"
        + "<td style='width:10%'><input type='hidden' name='arch["+i+"][id]' value='"+cartArray[i].product_id+"' ><input type='hidden' name='arch["+i+"][diety_id]' value='"+cartArray[i].diety_id+"' ><img data-name=" + cartArray[i].name + " src='" + cartArray[i].src + "' style='width:35px; border:1px solid #e9e6e6; background:#FFF; border-radius:5px;'></td>"
      + "<td style='width:42%'><input type='hidden' name='arch["+i+"][amt]' value='"+(Number(cartArray[i].price).toFixed(2))+"' ><span class='archa_name' style='text-transform:uppercase;'>" + cartArray[i].name + "</span><br>" 
        + "RM : " + (Number(cartArray[i].price).toFixed(2)) + "</td>"
        + "<td style='width:35%'><div class='input-group'><button style='padding: 2px 7px;margin: 0px 5px;' class='minus-item input-group-addon btn btn-primary' data-name='" + cartArray[i].name + "'>-</button>"
        + "<input type='number' min='1' class='item-count_new' data-name='" + cartArray[i].name + "' value='"+cartArray[i].count+"'>"
        + "<button style='padding: 2px 5px;margin: 0px 5px;' class='plus-item btn btn-primary input-group-addon' data-name='" + cartArray[i].name + "'>+</button><input type='hidden' name='arch["+i+"][qty]' value='"+cartArray[i].count+"' class='item-count'><input type='hidden' class='archanai_category' value='"+cartArray[i].category+"'></div></td>"
        + "<td style='width:8%'><button style='padding: 2px 7px;' class='delete-item btn btn-danger' data-name='" + cartArray[i].name + "'>X</button></td>"
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
  $('.total-cart').html(Number(shoppingCart.totalCart()).toFixed(2));
  $('#tot_amt').val(Number(shoppingCart.totalCart()).toFixed(2));
  $('.total-count').html(shoppingCart.totalCount());
  $('.show-cart_popup').html(popup);
  var tot =  shoppingCart.totalCount();
  open_vehicle_entry();
}
// Delete item button
$('.show-cart').on("click", ".delete-item", function(event) {
  var name = $(this).data('name');
  shoppingCart.removeItemFromCartAll(name);
  displayCart();
  open_vehicle_entry();
})
// -1
$('.show-cart').on("click", ".minus-item", function(event) {
  var name = $(this).data('name')
  shoppingCart.removeItemFromCart(name);
  displayCart();
  open_vehicle_entry();
})
// +1
$('.show-cart').on("click", ".plus-item", function(event) {
  var name = $(this).data('name')
  shoppingCart.addItemToCart(name);
  displayCart();
  open_vehicle_entry();
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
<script>
$(function () {
    $("[data-dismiss='modal']").on('click', function () {
          $('.modal').hide();
    })
})
</script>
<script>
function userModalRasi()
{
  var rowCount = $('.rasi-table1 tbody tr').length;
  if(rowCount >= "6")
  {
     alert("It allow's only 6 names."); 
  }
  else {
      $(".rasi-table").empty();
      $("#myModal_rasi").modal("show");
  }
}
</script>
<script src="<?php echo base_url(); ?>/assets/website/jquery-ui.min.js"></script>
<script>
$(document).ready(function(){
  $("#rasi_id").change(function(){
    var rasi = $("#rasi_id").val();
    if(rasi != "")
    {
      $.ajax({
      url: '<?php echo base_url(); ?>/online_archanai/get_natchathram',
      type: 'post',
      data: {rasi_id:rasi},
      dataType: 'json',
      success:function(response)
      {
        $('#natchathram_id').val(response.natchathra_id);
        var str = response.natchathra_id;
        if(str !="") {
          $("#natchathra_id").empty();
          $('#natchathra_id').append('<option value="">Select Natchathiram</option>');
            $.each(str.split(','), function(key, value) {
            $.ajax({
            url: '<?php echo base_url(); ?>/online_archanai/get_natchathram_name',
            type: 'post',
            data: {id:value},
            dataType: 'json',
            success:function(response)
            {
              $('#natchathra_id').append('<option value="' + response.id + '">' + response.name_eng + '</option>');
            }
            });
          });
        }
        }
      });
    }
  });
  $("#ar_name").autocomplete({
    source: function( request, response ) {
      $.ajax({
        url: "<?php echo site_url('online_archanai/get_member_rasi'); ?>",
        type: 'post',
        data: {term: request.term},
        dataType: 'json',
        success: function(data){
          console.log(data);
          response(data);
        },
        error: function(jqXHR, textStatus, errorThrown){
          console.log("error handler!");
          console.log(jqXHR);
          console.log(errorThrown);
        }
      });
    },
    minLength: 1,
    select: function( event, ui ) {
      console.log( ui );
      var count1 = $('#count1').val(); 
      var max_fields = 6;
      if(count1 < max_fields) {
        var html = '';
        html += '<tr id="remove_row'+count1+'">';
        html += '<td style="width: 38%;"><input type="hidden" name="rasi['+count1+'][arc_name]" value="' + ui.item.name + '" />' + ui.item.name + '</td>';
        html += '<td style="width: 27%;"><input type="hidden" name="rasi['+count1+'][rasi_ids]" value="' + ui.item.rasi_id + '" />' + ui.item.rasi_eng + '</td>';
        html += '<td style="width: 30%;"><input type="hidden" name="rasi['+count1+'][natchathra_ids]" value="' + ui.item.natchathram_id + '" />' + ui.item.natchathram_eng + '</td>';
        html += '<td style="width: 5%;"><a class="" onclick="remove_arch('+ count1 +')" style="width:auto;"><i class="fa fa-trash"></i></a></td>';
        html += '</tr>';
        
        var html1 = '';
        html1 += '<tr>';
        html1 += '<td style="width: 38%;"><input type="hidden" name="rasi['+count1+'][arc_name]" value="' + ui.item.name + '" />' + ui.item.name + '</td>';
        html1 += '<td style="width: 27%;"><input type="hidden" name="rasi['+count1+'][rasi_ids]" value="' + ui.item.rasi_id + '" />' + ui.item.rasi_eng + '</td>';
        html1 += '<td style="width: 30%;"><input type="hidden" name="rasi['+count1+'][natchathra_ids]" value="' + ui.item.natchathram_id + '" />' + ui.item.natchathram_eng + '</td>';
        html1 += '</tr>';
        
        $('.rasi-table').append(html1);
        $('.rasi-table1').append(html);
        count1++;
        $("#count1").val(count1);
        setTimeout(function(){$('#ar_name').val("")}, 300);
        $('#rasi_id').val("");
        $('#natchathra_id').val("");
      } 
      else { alert("It allow's only 6 names."); }
    }
  });
  $('#ar_add_btn_more').on('click', function(){
    var ar_name = $('#ar_name').val();
    var rasi_id = $('#rasi_id').val();
    var rasi_text = $( "#rasi_id option:selected" ).text();
    var natchathra_id = $('#natchathra_id').val();
    var natchathra_text = $( "#natchathra_id option:selected" ).text();
    var count1 = $('#count1').val(); 
    var max_fields      = 6;
    var rowCount = $('.rasi-table1 tbody tr').length;
    if(ar_name != "" && rasi_id != "" && natchathra_id != "")
    { 
    if(count1 < max_fields) {
      var html = '';
      html += '<tr id="remove_row'+count1+'">';
      html += '<td style="width: 38%;"><input type="hidden" name="rasi['+count1+'][arc_name]" value="' + ar_name + '" />' + ar_name + '</td>';
      html += '<td style="width: 27%;"><input type="hidden" name="rasi['+count1+'][rasi_ids]" value="' + rasi_id + '" />' + rasi_text + '</td>';
      html += '<td style="width: 30%;"><input type="hidden" name="rasi['+count1+'][natchathra_ids]" value="' + natchathra_id + '" />' + natchathra_text + '</td>';
      html += '<td style="width: 5%;"><a class="" onclick="remove_arch('+ count1 +')" style="width:auto;"><i class="fa fa-trash" style="color: #ea5e5e;"></i></a></td>';
      html += '</tr>';
      
      var html1 = '';
      html1 += '<tr>';
      html1 += '<td style="width: 38%;text-align: left;"><input type="hidden" name="rasi['+count1+'][arc_name]" value="' + ar_name + '" />' + ar_name + '</td>';
      html1 += '<td style="width: 27%;text-align: left;"><input type="hidden" name="rasi['+count1+'][rasi_ids]" value="' + rasi_id + '" />' + rasi_text + '</td>';
      html1 += '<td style="width: 30%;text-align: left;"><input type="hidden" name="rasi['+count1+'][natchathra_ids]" value="' + natchathra_id + '" />' + natchathra_text + '</td>';
      html1 += '</tr>';
      
      $('.rasi-table').append(html1);
      $('.rasi-table1').append(html);
      count1++;
      $("#count1").val(count1);
      $('#ar_name').val("");
      $('#rasi_id').val("");
      $('#natchathra_id').val("");
    } 
    else { alert("It allow's only 6 names."); }    
    }

  });
  $('#ar_add_btn').on('click', function(){
    $('#ar_name').val("");
    $('#rasi_id').val("");
    $('#natchathra_id').val("");
    $("#myModal_rasi").modal("hide");
    return;
  });
});
function remove_arch(id){
    $("#remove_row"+id).remove();
    var count1 = $('#count1').val(); 
    count1--;
    $("#count1").val(count1);
}
function remove_vehicle(id){
    $(".vehicle-table #remov_vehicle_"+id).remove();
    $("#count_vehicle").val(parseInt($("#count_vehicle").val())-1);
}
$('#remove_vehicle').click(function() {
  $(this).css({"display":"block"});
});
$('#vle_add_btn').on('click', function(){
    var vle_name = $('#vle_name').val();
    var vle_no = $('#vle_no_name').val();
    var count2 = $('#count_vehicle').val(); 
    if(vle_name != "" && vle_no != "")
    {
        var html = '';
        html += '<tr id="remov_vehicle_'+count2 +'">';
        html += '<td width="50%"><input type="hidden" name="vehicle['+count2+'][vle_name]" value="' + vle_name + '" />' + vle_name + '</td>';
        html += '<td width="50%"><input type="hidden" name="vehicle['+count2+'][vle_no]" value="' + vle_no + '" />' + vle_no + '</td>';
        html += '</tr>';
        $('.vehicle-table').append(html);
        count2++;
        $("#count_vehicle").val(count2);
        $('#vle_name').val("");
        $('#vle_no_name').val("");
    }
});


</script>
<script src="<?php echo base_url(); ?>/assets/jquery.validate.js"></script>
<script>
  $('#form_validation').validate({
		submitHandler: function (form) {
      var cartArray_login = loginDetail.listLogin();
      if(cartArray_login.length > 0){
            var customer_id = cartArray_login[0].login_id;
            var tot_item =  shoppingCart.totalCount();
           // alert(tot_item);
            //return;
            if(tot_item == 0){
                $('#alert_modal').modal('show');
                $("#spndeddelid").text('Please select atleast one archanai.');
            }
            else{
              $.ajax({
                  url: '<?php echo base_url(); ?>/online_archanai/save_archanai',
                  type: 'post',
                  data: $('#form_validation').serialize() + "&user_login_id="+customer_id,
                  success: function (response) {
                  obj = jQuery.parseJSON(response);
                  if(obj.err != ''){
                      $('#alert_modal').modal('show');
                      $("#spndeddelid").text(obj.err);
                  }else{
                      shoppingCart.clearCart();
                      window.open("<?php echo base_url(); ?>/online_archanai/payment_process/" + obj.id, "_blank", "width=680,height=500");
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







<script>
function appen() {
  var count = parseInt($("#tot_count").val());
  var a = $("#arch_cat").val();
  var b = $("#archanai").val();
  var c = $("#ar_name").val();
  var d = $("#rasi_id").val();
  var e = $("#natchathra_id").val();

  //if(a >0 && c>0  && d>0  ){
      var html = "<tr id='row_"+count+"'>";
          html += "<td><input type='hidden' name='sout["+count+"][arch_cat]' value='"+a+"' >" + a + "</td>";
          html += "<td><input type='hidden' name='sout["+count+"][archanai]' value='"+b+"' >" + b + "</td>";
          html += "<td><input type='hidden' name='sout["+count+"][ar_name]' value='"+c+"' >" + c + "</td>";
          html += "<td><input type='hidden' name='sout["+count+"][rasi_id]' value='"+d+"' >" + d + "</td>";
          html += "<td><input type='hidden' name='sout["+count+"][natchathra_id]' value='"+e+"'>" + e + "</td>";
          html += "<td><button class='btn btn-danger remove' onclick='remove_row("+count+")' type='button'>X</button></td></tr>";
      $("#table tbody").append(html);
      /*$(".add_list").val('');*/
	  $('#arch_cat').prop('selectedIndex',0);
	  $("#arch_cat").trigger("change");
	  $('#rasi_id').prop('selectedIndex',0);
	  $("#rasi_id").trigger("change");
	  $('#natchathra_id').prop('selectedIndex',0);
	  $("#natchathra_id").trigger("change");
      var cnt = count + 1;
      $("#tot_count").val(cnt);
      //total_amount();
  //}
}

function remove_row(id){
    $('#row_'+id).remove();
    total_amount();
}
$("#arch_cat").change(function(){
    var arch = $("#arch_cat").val();
    if(arch != "")
    {
	//alert(arch);
      $("#archanai").empty();
      $('#archanai').append('<option value="">Select Archanai</option>');
	  $.ajax({
      url: '<?php echo base_url(); ?>/online_archanai/get_archanai',
      type: 'post',
      data: {arch_cat:arch},
      dataType: 'json',
      success:function(data)
        {
			console.log(data);
			$.each(data, function() {
				$('#archanai').append('<option value="' + data.id + '">' + data.name_eng + '</option>');
			});
		}
      });
    }
  });
</script>