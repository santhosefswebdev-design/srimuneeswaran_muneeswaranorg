<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ARULMIGU RAJAMARIAMMAN DEVASTHANAM</title>
    <link rel="shortcut icon" href="<?php echo base_url(); ?>/assets/website/img/logo_tr.png" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/website/css/animate.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/website/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/website/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/website/css/swiper.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/website/css/lightcase.css">
    <!-- main css for template -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/website/css/style.min.css">
	<script src="<?php echo base_url(); ?>/assets/website/js/jquery-3.6.0.min.js"></script>
		<script src="<?php echo base_url(); ?>/assets/website/js/jquery.validate.js"></script>
	<script>
	$(document).ready(function(){
		logincheck();
	});
	var loginDetail = (function() {
		user_login = [];
		// Constructor
		function Item(login_id,name,ic_no,username,password,email,role,profile_id) {
			this.login_id = login_id;
			this.name = name;
			this.ic_no = ic_no;
			this.username = username;
			this.password = password;
			this.email = email;
			this.role = role;
			this.profile_id = profile_id;
		}
		// Save user
		function saveLogin() {
			sessionStorage.setItem('logindetails', JSON.stringify(user_login));
		}
			// Load user
		function loadLogin() {
			user_login = JSON.parse(sessionStorage.getItem('logindetails'));
		}
		if (sessionStorage.getItem("logindetails") != null) {
			loadLogin();
		}
		var obj = {};
		// Add to user
		obj.addLoginToCart = function(login_id,name,ic_no,username,password,email,role,profile_id) {
			var item = new Item(login_id,name,ic_no,username,password,email,role,profile_id);
			user_login.push(item);
			saveLogin();
		}
		// clear user
		obj.clearLogin = function() {
			user_login = [];
			saveLogin();
		}
		// List user
		obj.listLogin = function() {
			return user_login;
		}
		return obj;
	})();
	
	function logincheck(){
		var cartArray = loginDetail.listLogin();
		if(cartArray.length > 0){
			var html = "<a class='' style='background:#f1c152;color: #fff!important;cursor:pointer;'>"+cartArray[0].name+"</a><ul><li><a href='<?php echo base_url(); ?>/online_mybooking' style='background: #fff!important;color: #f1c152!important;' >MY BOOKINGS</a></li><li><a onclick='logout_customer();' style='cursor: pointer;background: #fff!important;color: #f1c152!important;' >LOGOUT</a></li></ul>";
			$("#logincheck").append(html);
		}
		else{
			$("#logincheck").empty();
		}
	}
	function logout_customer(){
		loginDetail.clearLogin();
		window.location.reload(true);
	}


document.addEventListener("DOMContentLoaded", function(){
// make it as accordion for smaller screens
if (window.innerWidth < 992) {

  // close all inner dropdowns when parent is closed
  document.querySelectorAll('.navbar .dropdown').forEach(function(everydropdown){
    everydropdown.addEventListener('hidden.bs.dropdown', function () {
      // after dropdown is hidden, then find all submenus
        this.querySelectorAll('.submenu').forEach(function(everysubmenu){
          // hide every submenu as well
          everysubmenu.style.display = 'none';
        });
    })
  });

  document.querySelectorAll('.dropdown-menu a').forEach(function(element){
    element.addEventListener('click', function (e) {
        let nextEl = this.nextElementSibling;
        if(nextEl && nextEl.classList.contains('submenu')) {	
          // prevent opening link if link needs to open dropdown
          e.preventDefault();
          if(nextEl.style.display == 'block'){
            nextEl.style.display = 'none';
          } else {
            nextEl.style.display = 'block';
          }

        }
    });
  })
}
// end if innerWidth
}); 
   
</script>
<style>	
@import url('https://fonts.googleapis.com/css2?family=Radio+Canada+Big:ital,wght@0,400..700;1,400..700&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Meera+Inimai&display=swap');	
body {
	margin: 0;
	font-family: "Radio Canada Big", sans-serif !important;
}


/* ============ desktop view ============ */
@media all and (min-width: 992px) {
	.dropdown-menu li{ position: relative; 	}
	.nav-item .submenu{ 
		display: none;
		position: absolute;
		left:100%; top:-7px;
	}
	.nav-item .submenu-left{ 
		right:100%; left:auto;
	}
	.dropdown-menu > li:hover{ background-color: #f1f1f1 }
	.dropdown-menu > li:hover > .submenu{ display: block; }
}	
/* ============ desktop view .end// ============ */

/* ============ small devices ============ */
@media (max-width: 991px) {
  .dropdown-menu .dropdown-menu{
      margin-left:0.7rem; margin-right:0.7rem; margin-bottom: .5rem;
  }
}	
/* ============ small devices .end// ============ */
@media (min-width: 1200px){
.navbar-expand-xl .navbar-nav .nav-link {
    padding-right: 1rem!important;
    padding-left: 1rem!important;
}
}    
</style>
</head>
<body style="background-color: #ffefe2;font-family: Roboto;">
	<?php echo view('website/layout/loader'); ?>
    <?php
        $uri = new CodeIgniter\HTTP\URI(current_url());
        $uri_one = '';
        if ($uri->getTotalSegments() > 0 && $uri->getSegment(1))
            $uri_one = $uri->getSegment(1);
        if ($uri->getTotalSegments() > 1 && $uri->getSegment(2))
            $uri_two = $uri->getSegment(2);
    ?>
	<!-- ================> preloader start here <================ -->
    <div class="preloader">
        <div class="preloader-inner">
            <div class="preloader-icon">
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    <!-- ================> preloader ending here <================ -->
	<!-- ================> Header Search <================ -->
    <div class="header-form">
        <div class="bg-lay">
            <div class="cross">
                <i class="fas fa-times"></i>
            </div>
        </div>
        <form class="form-container">
            <input type="text" placeholder="Input Your Search" name="name">
            <button type="submit">Search</button>
        </form>
    </div>
    <!-- ================> Header Search <================ -->
	<!-- ================> header section start here <================== -->
    <header class="header">
        <div class="navbar-expand-xl">
            <div class="collapse navbar-collapse" id="menubar2">
                <div class="header__top w-100" style="padding-bottom:5px;padding-top:5px;">
                    <div class="container-fluid">
                        <div class="header__top-area">
                            <div class="header__top-left">
                                <!--ul>
                                    <li>
                                        <i class="fas fa-phone-alt"></i>
                                        072233989
                                    </li>
                                    <li>
                                        <i class="fas fa-envelope"></i>
                                        armdjb1911@gmail.com
                                    </li>
                                </ul-->
                            </div>
                            <div class="header__top-center" style="width: 70%;">
                                <div class="header__top-logo d-none d-md-block">
									<div class="row">
                                        
										<div class="col-md-4" style="text-align: right;">
											<a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>/assets/website/img/logo_2.png" alt="logo"></a>
										</div>
										<div class="col-md-6">
											<p style="font-weight: 600;color: #000;margin:0px;font-size: 17px;line-height: 1.5;text-align:center;font-family: 'Meera Inimai', sans-serif;">அருள்மிகு இராஜமாரியம்மன் தேவஸ்தானம்<br><span style='font-size:13px'> ஜொகூர் பாரு 1911 - ஆம் ஆண்டு முதல்</span></p>
											<p style="font-weight: 600;color: #000;margin:0px;font-size: 17px;line-height: 1.5;text-align:center;">ARULMIGU RAJAMARIAMMAN DEVASTHANAM<br> <span style='font-size:13px'>JOHOR BAHRU SINCE 1911</span></p>
										
										</div>
                                        <div class="col-md-2"></div>
									</div>
                                    
									
                                </div>
                            </div>
                            <div class="header__top-right">
                                <div class="header__top-socialsearch">
                                    <!--div class="header__top-social">
                                        <ul>
                                            <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                            <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                            <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                                            <li><a href="#"><i class="fab fa-pinterest-p"></i></a></li>
                                        </ul>
                                    </div>
                                    <div class="header__top-search">
                                        <ul>
                                            <li class="search__icon"><i class="fas fa-search"></i></li>
                                            <li class="cart__icon"><i class="fas fa-shopping-bag"></i><span>04</span></li>
                                        </ul>
                                    </div-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="header__bottom" style="background-color: #7e4555;">
            <div class="container">
                <div class="header__mainmenu navbar navbar-expand-xl navbar-light">
                    <div class="header__logo" style="padding:0px;width:auto;">
                        <a href="<?php echo base_url(); ?>" class="d-none d-xl-block"><img src="<?php echo base_url(); ?>/assets/website/img/logo_tr.png" alt="logo"></a>
                        <a href="<?php echo base_url(); ?>" class="d-xl-none" style="color:#fff"><img src="<?php echo base_url(); ?>/assets/website/img/logo_tr.png" alt="logo" >ARULMIGU RAJAMARIAMMAN DEVASTHANAM</a>
                    </div>
                    <div class="header__bar">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menubar" aria-controls="menubar" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                    </div>
                    <div class="header__menu navbar-expand-xl">
                        <div class="collapse navbar-collapse" id="menubar">
                            <ul class="navbar-nav">
                                <li class="nav-item <?php if ($uri_two == "") { echo 'active'; } ?>"> 
                                    <a class="nav-link" href="<?php echo base_url(); ?>">Home </a> 
                                </li>
                                <li class="nav-item <?php if ($uri_two == "online_aboutus") { echo 'active'; } ?>">
                                    <a class="nav-link" href="<?php echo base_url(); ?>/online_aboutus"> About Us </a>
                                </li>
                                <li class="nav-item <?php if ($uri_two == "online_event") { echo 'active'; } ?>">
                                    <a class="nav-link" href="<?php echo base_url(); ?>/online_event">Events </a>
                                </li>
                                <li class="nav-item <?php if ($uri_two == "online_gallery") { echo 'active'; } ?>">
                                    <a class="nav-link" href="<?php echo base_url(); ?>/online_gallery"> Gallery </a>
                                </li>
                                <li class="nav-item dropdown <?php if ($uri_two == "online_hallbooking" || $uri_two == "online_ubayam" || $uri_two == "online_donation") { echo 'active'; } ?>" id="myDropdown">
                                    <a class="nav-link " href="#" data-bs-toggle="dropdown"> Deity Booking  </a>
                                    <ul class="dropdown-menu">
                                    <li> <a style="color: #000!important;" class="dropdown-item" href="<?php echo base_url(); ?>/online_archanai"> Archanai </a></li>
                                        <!--<li> <a style="color: #000!important;" class="dropdown-item" href="<?php echo base_url(); ?>/online_hallbooking"> Hall </a></li>-->
                                        <li> <a style="color: #000!important;" class="dropdown-item" href="<?php echo base_url(); ?>/online_ubayam"> Ubayam </a></li>
                                        <li> <a style="color: #000!important;" class="dropdown-item" href="<?php echo base_url(); ?>/online_donation"> Cash Donation </a></li>
                                        <li> <a style="color: #000!important;" class="dropdown-item" href="<?php echo base_url(); ?>/online_prasadam"> Prasadam </a></li>
                                        <li> <a style="color: #000!important;" class="dropdown-item" href="<?php echo base_url(); ?>/online_annathanam"> Annathanam </a></li>
                                       
                                        <!--li> <a style="color: #000!important;" class="dropdown-item" href="#"> Other Services </a>
                                            <ul class="submenu dropdown-menu">
                                                <li><a style="color: #000!important;" class="dropdown-item" href="#">Cemetery</a></li>
                                                <li><a style="color: #000!important;" class="dropdown-item" href="#">ROM</a></li>
                                                <li><a style="color: #000!important;" class="dropdown-item" href="#">Education AID</a></li>
                                                <li><a style="color: #000!important;" class="dropdown-item" href="#">Welfare AID</a></li>
                                                <li><a style="color: #000!important;" class="dropdown-item" href="#">Heritage</a></li>
                                            </ul>
                                        </li-->
                                    </ul>
                                </li>
                                <li class="nav-item <?php if ($uri_two == "online_contactus") { echo 'active'; } ?>">
                                    <a class="nav-link" href="<?php echo base_url(); ?>/online_contactus"> Contact Us </a>
                                </li>
                                <li class="nav-item" id="logincheck">
                                        
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- ================> header section end here <================== -->
   