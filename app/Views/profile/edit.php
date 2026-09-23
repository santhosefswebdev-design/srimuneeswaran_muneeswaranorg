<section class="content">
    <div class="container-fluid">
        <?php if ($_SESSION['succ'] != '') { ?>
            <div class="row" style="padding: 0 30% 2% 30%;" id="content_alert">
                <div class="suc-alert">
                    <span class="suc-closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                    <p>
                        <?php echo $_SESSION['succ']; ?>
                    </p>
                </div>
            </div>
        <?php } ?>
        <?php if ($_SESSION['fail'] != '') { ?>
            <div class="row" style="padding: 0 30% 2% 30%;" id="content_alert">
                <div class="alert">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                    <p>
                        <?php echo $_SESSION['fail']; ?>
                    </p>
                </div>
            </div>
        <?php } ?>
        <div class="block-header">
            <h2>PROFILE<small>Profile / <a href="#" target="_blank">Profile Setting</a></small></h2>
        </div>

        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row">
                            <div class="col-md-8">
                                <h2>Profile</h2>
                            </div>
                            <div class="col-md-4" align="right"></div>
                        </div>
                    </div>
                    <form action="<?php echo base_url(); ?>/profile/save" method="POST" enctype="multipart/form-data">
                        <div class="body">
                            <input type="hidden" name="id" value="<?php echo $profile['id']; ?>">
                            <div class="container-fluid">
                                <div class="row clearfix">
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" class="form-control" required name="name"
                                                    value="<?php echo $profile['name']; ?>">
                                                <label class="form-label">Name <span style="color: red;">
                                                        *</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" class="form-control" required name="name_tamil"
                                                    value="<?php echo $profile['name_tamil']; ?>">
                                                <label class="form-label">Name in Tamil</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" class="form-control" required name="since_eng"
                                                    value="<?php echo $profile['since_eng']; ?>">
                                                <label class="form-label">Since English <span style="color: red;">
                                                        *</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" class="form-control" required name="since_tamil"
                                                    value="<?php echo $profile['since_tamil']; ?>">
                                                <label class="form-label">Since Tamil <span style="color: red;">
                                                        *</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="address1"
                                                    value="<?php echo $profile['address1']; ?>">
                                                <label class="form-label">Address 1</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="address2"
                                                    value="<?php echo $profile['address2']; ?>">
                                                <label class="form-label">Address 2</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="city"
                                                    value="<?php echo $profile['city']; ?>">
                                                <label class="form-label">City</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="postcode"
                                                    value="<?php echo $profile['postcode']; ?>">
                                                <label class="form-label">Postcode</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="telephone"
                                                    value="<?php echo $profile['telephone']; ?>">
                                                <label class="form-label">Telephone</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="mobile"
                                                    value="<?php echo $profile['mobile']; ?>">
                                                <label class="form-label">Mobile</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="email"
                                                    pattern="[a-zA-Z0-9.-_]{1,}@[a-zA-Z.-]{2,}[.]{1}[a-zA-Z]{2,}"
                                                    class="form-control" name="email"
                                                    value="<?php echo $profile['email']; ?>">
                                                <label class="form-label">Email <span style="color: red;">
                                                        *</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="gstno"
                                                    value="<?php echo $profile['gstno']; ?>">
                                                <label class="form-label">GST No</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="fax_no"
                                                    value="<?php echo $profile['fax_no']; ?>">
                                                <label class="form-label">Fax No</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="iso"
                                                    value="<?php echo $profile['iso']; ?>">
                                                <label class="form-label">ISO</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="website"
                                                    value="<?php echo $profile['website']; ?>">
                                                <label class="form-label">Website</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="bankid"
                                                    value="<?php echo $profile['bankid']; ?>">
                                                <label class="form-label">Bank Id</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="number" class="form-control" name="hall_remind"
                                                    value="<?php echo $profile['hall_remind']; ?>">
                                                <label class="form-label">Hall Booking Reminder Days</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="clear:both"></div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="number" min="0" step="any" class="form-control"
                                                    name="donation_courtesy_grace_amount"
                                                    value="<?php echo $profile['donation_courtesy_grace_amount']; ?>">
                                                <label class="form-label">Cash Donation Courtesy (Mariyathai) Grace
                                                    Amount</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="number" min="0" step="any" class="form-control"
                                                    name="ubayam_courtesy_grace_amount"
                                                    value="<?php echo $profile['ubayam_courtesy_grace_amount']; ?>">
                                                <label class="form-label">Ubayam Courtesy (Mariyathai) Grace
                                                    Amount</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="clear:both"></div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <div class="form-line focused">
                                                <input name="logo_img" id="logo_img" class="form-control" type="file"
                                                    accept="image/png, image/gif, image/jpeg">
                                                <label class="form-label">Site Logo</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <?php
                                        if (!empty($profile['image'])) {
                                            ?>
                                            <img id="img_pre"
                                                src="<?php echo base_url(); ?>/uploads/main/<?php echo $profile['image']; ?>"
                                                class="img-responsive" style="width:100px;">
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <div class="form-line focused">
                                                <input name="ar_logo_img" id="ar_logo_img" class="form-control"
                                                    type="file" accept="image/png, image/gif, image/jpeg">
                                                <label class="form-label">Archanai Logo</label>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-sm-2">
                                        <?php
                                        if (!empty($profile['ar_image'])) {
                                            ?>
                                            <img id="ar_img_pre"
                                                src="<?php echo base_url(); ?>/uploads/main/<?php echo $profile['ar_image']; ?>"
                                                class="img-responsive" style="width:100px;">
                                            <?php
                                        }
                                        ?>
                                    </div>


                                    <div style="clear:both"></div>
                                    <div style="clear:both"></div>
                                        <div style="background: #8080800f;">
                                            <div class="row" style="margin: 0px;">
                                                <div class="col-md-8"><h2 style="font-size: 18px;">Daily Closing Phone No</h2></div>
                                                <div class="col-md-4" style="text-align:right"><br><button class="btn btn-warning" type="button" onclick="appen()">+</button></div>
                                            </div>
                                            <div class="add_box">
                                            <?php
                                            if(!empty($profile['daily_closing_phone']))
                                            {
                                                $i = 1;
                                                $response_daily_closing_phone = json_decode($profile['daily_closing_phone'], true);
                                                foreach($response_daily_closing_phone as $phoneno_row)
                                                {
                                            ?>
                                            <div id='dailyclosing_phone_row_<?php echo $i; ?>' class='row' style="margin: 0px;">
                                                <div class='col-sm-2'>
                                                    <div class='form-group form-float'>
                                                        <div class='form-line'>
                                                            <select class="form-control" name="phonecode[]" id="phonecode<?php echo $i; ?>">
                                                                <option value="">Dialing code</option>
                                                                <?php
                                                                if(!empty($phone_codes))
                                                                {
                                                                    foreach($phone_codes as $phone_code)
                                                                    {
                                                                ?>
                                                                <option value="<?php echo $phone_code['dailing_code']; ?>" <?php if($phone_code['dailing_code'] == $phoneno_row['phonecode']){ echo "selected";}?>><?php echo $phone_code['dailing_code']; ?></option>
                                                                <?php
                                                                    }
                                                                }              
                                                                ?>
                                                            </select>
                                                            <label class="form-label">Dialing code</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='col-sm-9'>
                                                    <div class='form-group form-float'>
                                                        <div class="form-line">
                                                            <input type="text" min="0" step="any" class="form-control" name="daily_closing_phone[]" id="daily_closing_phone<?php echo $i; ?>"
                                                                value="<?php echo $phoneno_row['phoneno']; ?>">
                                                            <label class="form-label">Daily Closing Phone</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='col-sm-1' style="text-align:right">
                                                    <button class='btn btn-warning' type='button' onclick='remove_row(<?php echo $i; ?>)' id='remove_new'>-</button>
                                                </div>
                                            </div>
                                            <?php
                                                $i++;
                                                }
                                                $total_count = count($response_daily_closing_phone);
                                            }
                                            else
                                            {
                                                $total_count = 0;
                                            }
                                            ?>
                                            <input type="hidden" id="tot_count" value="<?php echo $total_count; ?>">  
                                            </div>            
                                        </div>

                                    <div class="col-sm-12" align="center">
                                        <button type="submit"
                                            class="btn btn-success btn-lg waves-effect">UPDATE</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $("#logo_img").change(function () {
        readURL(this, '#img_pre');
    });

    $("#ar_logo_img").change(function () {
        readURL(this, '#ar_img_pre');
    });

    function readURL(input, img_id) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $(img_id).attr('src', e.target.result);
                $(img_id).show();
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<script>
function appen() {
	var count = parseInt($("#tot_count").val()) + 1;
	var html = "<div id='dailyclosing_phone_row_"+count+"' class='row' style='margin: 0px;'><div class='col-sm-2'><div class='form-group form-float'><div class='form-line'><select class='form-control' name='phonecode[]' id='phonecode"+count+"'><option value=''>Dialing code</option><?php if(!empty($phone_codes)){ foreach($phone_codes as $phone_code) { ?> <option value='<?php echo $phone_code['dailing_code']; ?>' <?php if($phone_code['dailing_code'] == '+60'){ echo 'selected';}?>><?php echo $phone_code['dailing_code']; ?></option><?php } } ?></select></div></div></div><div class='col-sm-9'><div class='form-group form-float'><div class='form-line'><input type='text' min='0' step='any' class='form-control' name='daily_closing_phone[]' id='daily_closing_phone"+count+"' ></div></div></div><div class='col-sm-1' style='text-align:right'><button class='btn btn-warning' type='button' onclick='remove_row("+count+")' id='remove_new'>-</button></div></div>";
	$(".add_box").append(html);
	$("#tot_count").val(count);
}
function remove_row(id){
    $('#dailyclosing_phone_row_'+id).remove();
	var t_count = $("#tot_count").val();
	var cnt = t_count - 1;
	$("#tot_count").val(cnt);
}
</script>