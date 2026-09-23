<!-- ================> Footer section start here <================== -->
    <footer class="footer">
        <div class="footer__top padding--top padding--bottom" style="padding: 0px;color: #fff;
    text-align: center;    background: #7e4555;">
            <div class="container">
                <div class="row g-4">
                    <div class="col-xl-12 col-sm-12 col-12">
                        <div class="footer__about">
						<a class="text-white me-3" href="<?php echo base_url(); ?>/privacy"> Privacy </a>
						<span></span> <a class="text-white" href="<?php echo base_url(); ?>/terms"> Terms </a>
                            <p style="text-transform: uppercase;">© <?php echo date("Y"); ?> ARULMIGU RAJAMAARIAMMAN DEVASTHANAM, JOHOR BAHRU SINCE 1911. All Rights Reserved.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>


<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="myModal" >
	<div class="modal-dialog modal-lg">
		<div class="modal-content" style="border-radius: 20px;border: 3px solid #7e4555;box-shadow: 0px 5px 50px 5px #7e4555c4;padding-bottom: 20px;">
		  <!-- Modal Header -->
		  <div class="modal-header" style="background: #0d6efd;padding: 10px 30px;">
			<h4 class="modal-title" style="font-family: Roboto;color:#fff;font-size: 21px;
    text-transform: uppercase;">Login</h4>
			<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
		  </div>
		  <!-- Modal body -->
			<div class="modal-body" style="padding: 30px 40px;">
				<form id="frmlogin" method="POST">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label class="form-label" for="user_name" style="color:#000;font-size: 18px;font-weight: bold;">User Name</label>
							<input class="input1 form-control" type="text" name="user_name" id="user_name" autocomplete="off">
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label class="form-label" for="password" style="color:#000;font-size: 18px;font-weight: bold;">Password</label>
							<input class="input1 form-control" type="password" name="password" id="password" autocomplete="off">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">&nbsp;</div>
					<div class="col-md-4">
						<div class="form-group">
							<button type="submit" class="btn btn-success" id="customer_login">Login</button>
							<button type="reset" class="btn btn-danger" style="">Clear</button>
						</div>
					</div>
					<div class="col-md-8" style="text-align: right;">
						<p style="margin-top: 10px;color: #000;font-weight: 800;">*If you not register. please click here to <a onclick="customerRegister();" style="color:red;cursor: pointer;">Register</a></p>
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="myModal_register" >
	<div class="modal-dialog modal-lg">
		<div class="modal-content" style="border-radius: 20px;border: 3px solid #7e4555;box-shadow: 0px 5px 50px 5px #7e4555c4;padding-bottom: 20px;">
		  <!-- Modal Header -->
		  <div class="modal-header" style="background: #0d6efd;padding: 10px 30px;">
			<h4 class="modal-title" style="font-family: Roboto;color:#fff;font-size: 21px;
    text-transform: uppercase;">Register</h4>
			<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
		  </div>
		  <!-- Modal body -->
			<div class="modal-body" style="padding: 30px 40px;">
				<form id="frmSignIn" method="POST">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="form-label" for="cust_name" style="color:#000;font-size: 18px;font-weight: bold;">Name</label>
							<input class="input1 form-control" type="text" name="cust_name" id="cust_name" autocomplete="off">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="form-label" for="cust_ic_no" style="color:#000;font-size: 18px;font-weight: bold;">IC No</label>
							<input class="input1 form-control" type="text" name="cust_ic_no" id="cust_ic_no" autocomplete="off">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="form-label" for="cust_email" style="color:#000;font-size: 18px;font-weight: bold;">Email ID</label>
							<input class="input1 form-control" type="email" name="cust_email" id="cust_email" autocomplete="off">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="form-label" for="cust_username" style="color:#000;font-size: 18px;font-weight: bold;">User Name</label>
							<input class="input1 form-control" type="text" name="cust_username" id="cust_username" autocomplete="off">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="form-label" for="cust_password" style="color:#000;font-size: 18px;font-weight: bold;">Password</label>
							<input class="input1 form-control" type="text" name="cust_password" id="cust_password" autocomplete="off">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="form-label" for="cust_confirm_password" style="color:#000;font-size: 18px;font-weight: bold;">Confirm Password</label>
							<input class="input1 form-control" type="text" name="cust_confirm_password" id="cust_confirm_password" autocomplete="off">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">&nbsp;</div>
					<div class="col-md-5">
						<div class="form-group">
							<button type="submit" class="btn btn-success" style="" id="customer_register">Submit</button>
							<button type="reset" class="btn btn-danger" >Clear</button>
						</div>
					</div>
					<div class="col-md-7" style="text-align:right">
						<p style="margin-top: 10px;color: #000;font-weight: 800;">Please click here to <a onclick="customerLogin();" style="color:red;cursor: pointer;">Login</a></p>
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script>
function customerLogin()
{
	$("#myModal").modal("show");
	$("#myModal_register").modal("hide");
}
function customerRegister()
{
	$("#myModal_register").modal("show");
	$("#myModal").modal("hide");
}
$(document).ready(function(){
	$("#myModal_register").modal("hide");
	$("#myModal").modal("hide");
});
$(document).ready(function () {
	$('#frmlogin').validate({
        rules: {
          user_name: {
            required: true
          },
          password: {
            required: true
          }
        },
        messages: {
          user_name: 'Please enter user name.',
          password: 'Please enter password.',
        },
        submitHandler: function (form) {
          //form.submit();
			$.ajax({
				type:"POST",
				url: "<?php echo base_url();?>/online_common/check_login",
				data: $(form).serialize(),
				dataType:"JSON",
				success:function(data)
				{
					var obj = data;
					if(obj.msg != ""){
						alert(obj.msg);
					}
					else
					{
						var loginid = obj.id;
						var name_re = obj.name;
						var icnumber = obj.ic_number;
						var username_re = obj.username;
						var password_re = obj.password;
						var email_re = obj.email;
						var role_re = obj.role;
						var profileid = obj.profile_id;
						//$('#alert-modal').modal('show');
						//$("#spndeddelid").text(obj.succ);
						loginDetail.addLoginToCart(loginid,name_re,icnumber,username_re,password_re,email_re,role_re,profileid);
						window.location.reload(true);
					}
				}
			});
        }
    });
	
	
    $('#frmSignIn').validate({
        rules: {
          cust_name: {
            required: true
          },
          cust_ic_no: {
            required: true
          },
          cust_email: {
            required: true,
            email: true,
            remote: {
              url: "<?php echo base_url(); ?>/online_common/email_check",
              data: {
                cust_email: $(this).data('cust_email')
              },
              type: "post",
            },
          },
          cust_username: {
            required: true,
            remote: {
              url: "<?php echo base_url(); ?>/online_common/username_check",
              data: {
                cust_username: $(this).data('cust_username')
              },
              type: "post",
            },
          },
          cust_password: {
            required: true,
            minlength: 6
          },
          cust_confirm_password: {
            required: true,
            equalTo: "#cust_password"
          }
        },
        messages: {
          cust_name: 'Please enter name.',
          cust_ic_no: 'Please enter ic no.',
          cust_email: {
            required: 'Please enter email address.',
            email: 'Please enter a valid email address.',
            remote: "email address already exist.",
          },
          cust_username: {
            required: 'Please enter username.',
            remote: "username already exist.",
          },
          cust_password: {
            required: 'Please enter password.',
            minlength: 'Password must be at least 6 characters long.',
          },
          cust_confirm_password: {
            required: 'Please enter confirm password.',
            equalTo: 'Confirm password do not match with password.',
          }
        },
        submitHandler: function (form) {
          //form.submit();
			$.ajax({
				type:"POST",
				url: "<?php echo base_url();?>/online_common/save_register",
				data: $(form).serialize(),
				beforeSend: function() {    
					$("#loader").show();
				},
				success:function(data)
				{
					$("#myModal_register").modal("hide");
					obj = jQuery.parseJSON(data);
					var loginid = obj.id;
					var name_re = obj.name;
					var icnumber = obj.ic_number;
					var username_re = obj.username;
					var password_re = obj.password;
					var email_re = obj.email;
					var role_re = obj.role;
					var profileid = obj.profile_id;
					//$('#alert-modal').modal('show');
                    //$("#spndeddelid").text(obj.succ);
                    loginDetail.addLoginToCart(loginid,name_re,icnumber,username_re,password_re,email_re,role_re,profileid);
					window.location.reload(true);
				},
				complete:function(data){
					// Hide image container
					$("#loader").hide();
				}
			});
        }
    });
});
</script>
<!-- ================> Footer section end here <================== -->
    <!-- scrollToTop start here -->
    <a href="#" class="scrollToTop"><i class="fas fa-arrow-up"></i><span class="pluse_1"></span><span class="pluse_2"></span></a>
    <!-- scrollToTop ending here -->
    <!-- vendor plugins -->
	
	<script src="<?php echo base_url(); ?>/assets/website/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/website/js/waypoints.min.js"></script>
    <!-- <script src="<?php echo base_url(); ?>/assets/website/js/all.min.js"></script> -->
    <script src="<?php echo base_url(); ?>/assets/website/js/swiper.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/website/js/lightcase.js"></script>
    <script src="<?php echo base_url(); ?>/assets/website/js/isotope.pkgd.min.js"></script>
    <!--script src="<?php echo base_url(); ?>/assets/website/js/donate-range.js"></script-->
    <script src="<?php echo base_url(); ?>/assets/website/js/jquery.counterup.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/website/js/wow.js"></script>
    <script src="<?php echo base_url(); ?>/assets/website/js/custom.js"></script>
		


	
	
</body>
</html>