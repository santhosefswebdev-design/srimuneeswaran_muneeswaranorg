<div class="pageheader" style="">
	<div class="container">
		<div class="row">
			<div class="col-md-12" style="    text-align: center;">
				<h2 style="font-family: Roboto;font-size: 30px;text-transform: uppercase;color: #000;font-weight: bold;">Contact Us</h2>
			</div>
		</div>
	</div>
</div>
<!-- ================> Contact section start here <================== -->
<div class="contact padding--top padding--bottom bg-light" style="background-color: #ffefe2!important;padding-top: 20px;padding-bottom: 30px;">
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
				<div class="col-lg-6 col-12">
					<div class="section__wrapper">
						<div class="contact__form">
							<form class="d-flex flex-wrap justify-content-between" action="<?php echo base_url(); ?>/online_contactus/sendmail" method="POST">
								<input type="text" placeholder="Your Name" id="name" name="name" required="required">
								<input type="text" placeholder="Your Email" id="email" name="email" required>
								<input class="w-100" type="text" placeholder="Subject" id="subject" name="subject" required>
								<textarea placeholder="Your Message" rows="8" name="message" id="message" required></textarea>
								<div class="text-center w-100">
									<button type="submit" class="default-btn move-right" style="margin-bottom:30px;"><span>SEND NOW</span></button>
								</div>
							</form>
						</div> 
					</div>
				</div>
				<div class="col-lg-6 col-12">
                    <div class="location__right padding--top padding--bottom" style="background: #7e4555;padding-bottom: 40px;padding-top: 40px;">
                        <div class="location__info">
                            <div class="location__info-top">
                                <div class="section__header">
                                    <h2 style="font-family: Roboto;">Contact Person</h2>
                                </div>
                                <div class="section__wrapper">
                                    <div class="location__info-content">
                                        <h6>V.RAJA SELAN</h6>
                                        <span style="color: #f1c152;">President</span>
										
										<h6>V.NAGALINGAM</h6>
                                        <span style="color: #f1c152;">Deputy President</span>
										
                                        <ul> 
                                            <li style="color: #f1c152;"><b>Phone:</b>+6011-67470071</li>
                                            <li style="color: #f1c152;"><b >Email:</b>info.armd1911@gmail.com</li>
                                            <li style="color: #f1c152;"><b>Reg No:</b>PPM-005-01-28041951</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="location__info-bottom">
                                <div class="section__header">
                                    <h2 style="font-family: Roboto;">Contact Info</h2>
                                </div>
                                <div class="section__wrapper">
                                    <div class="location__info-list">
										<h3 style="font-size: 17px;color: #fff;font-family: Roboto;">ARULMIGU RAJAMARIAMMAN DEVASTHANAM</h3>
                                        <ul>
                                            <li>
                                                <div class="location__info-left">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                </div> 
                                                <div class="location__info-right">
                                                    <p style="color: #f1c152;">No.1A, Jalan Ungku Puan, Johor Bahru Since 1911, Johor, 80000, Malaysia</p>
                                                </div> 
                                            </li>
                                            <li>
                                                <div class="location__info-left">
                                                    <i class="far fa-clock"></i>
                                                </div> 
                                                <div class="location__info-right">
                                                    <ul>
                                                        <li style="color: #f1c152;"><b>Monday-Sunday :</b> 06:00 am - 09:00 pm</li>
                                                    </ul>
                                                </div> 
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
        </div>
    </div>
<!-- ================> Contact section end here <================== -->
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d419.24204160682496!2d103.7635805726441!3d1.4589291515950704!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31da12dd4c9d5a1b%3A0xf2539cf3a5bfcce3!2sRaja%20Maha%20Mariamman%20Temple!5e0!3m2!1sen!2sin!4v1707709056964!5m2!1sen!2sin" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>