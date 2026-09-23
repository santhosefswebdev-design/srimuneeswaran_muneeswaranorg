<?php
$db = db_connect();
if($view == true)
{
    $view_readonly = "readonly";
    $view_disabled = "disabled";
}
if($edit == true)
{
    $readonly = "readonly";
    $disabled = "disabled";
}
?>
<script src="<?php echo base_url(); ?>/assets/jquery.validate.js"></script>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
        <h2>Tennant<small>Rental / <b>Add</b></small></h2>
       
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
					<div class="header">
                        <div class="row"><div class="col-md-8"></div>
                        <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/tennant"><button type="button" class="btn bg-deep-purple waves-effect">List</button></a></div></div>
                    </div>
                    <div class="body">
                    <form action="<?php echo base_url(); ?>/tennant/store" method="POST" id="form_validation" enctype="multipart/form-data">
						<input type="hidden" value="<?php echo isset($tennant['id']) ? $tennant['id'] : ""; ?>" name="id" id="updateid">
                        <div class="container-fluid">
                        <div class="row clearfix">
                            
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line focused">
                                        <input type="text" name="tennant_name" id="tennant_name" class="form-control" value="<?php echo isset($tennant['name']) ? $tennant['name'] : ""; ?>" required <?php echo $view_readonly; ?>>
                                        <label class="form-label">Tenant Name <span style="color: red;">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line focused">
                                        <input type="text" name="company_organisation" id="company_organisation" class="form-control" value="<?php echo isset($tennant['company']) ? $tennant['company'] : ""; ?>" required <?php echo $view_readonly; ?>>
                                        <label class="form-label">Business Name<span style="color: red;">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div style="clear:both"></div>
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-md-3" style="margin: 0px;">
                                        <div class="form-group form-float">
                                            <div class="form-line focused">
                                                <?php $phonecode =  !empty($tennant['phonecode']) ? $tennant['phonecode'] : "+60"; ?>
                                                <select class="form-control" name="phonecode" id="phonecode" >
                                                    <?php
                                                    if (!empty($phone_codes)) {
                                                        foreach ($phone_codes as $phone_code) {
                                                            ?>
                                                    <option value="<?php echo $phone_code['dailing_code']; ?>" <?php if ($phone_code['dailing_code'] == $phonecode) {
                                                        echo "selected";
                                                    } ?>><?php echo $phone_code['dailing_code']; ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                   
                                    <div class="col-md-9" style="margin: 0px;">
                                        <div class="form-group form-float">
                                            <div class="form-line focused">
                                                <input type="number" min="0" maxlength="15" name="tennant_phoneno" step="any" id="tennant_phoneno" class="form-control" value="<?php echo isset($tennant['phone']) ? $tennant['phone'] : ""; ?>" required <?php echo $view_readonly; ?>>
                                                <label class="form-label">Mobile No <span style="color: red;">*</span></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
							<div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line focused">
                                        <input type="email" name="tennant_emailid" id="tennant_emailid" class="form-control" value="<?php echo isset($tennant['email']) ? $tennant['email'] : ""; ?>" required <?php echo $view_readonly; ?>>
                                        <label class="form-label">Email ID <span style="color: red;">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div style="clear:both"></div>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line focused">
										<textarea name="tennant_address" id="tennant_address" class="form-control" required <?php echo $view_readonly; ?> ><?php echo isset($tennant['address']) ? $tennant['address'] : ""; ?></textarea>
                                        <label class="form-label">Address <span style="color: red;">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6" style="margin: 0px;">
                                        <div class="form-group form-float">
                                            <div class="form-line focused">
                                                <input type="number" min="0" maxlength="20" name="tennant_icno" step="any" id="tennant_icno" class="form-control" value="<?php echo isset($tennant['icno']) ? $tennant['icno'] : ""; ?>" required <?php echo $view_readonly; ?>>
                                                <label class="form-label">IC No <span style="color: red;"></span></label>
                                            </div>
                                        </div>
                                    </div>
                            <?php
                            if($view == true || $edit == true)
                            {
                            ?>
                            <div style="clear:both"></div>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line focused">
                                        <select name="status" id="status" class="form-control" required <?php echo $view_readonly; ?> >
                                            <option value="">select status</option>
											<option value="1" <?php if($tennant['status'] == 1){ echo "selected"; }?>>Active</option>
											<option value="0" <?php if($tennant['status'] == 0){ echo "selected"; }?>>Inactive</option>
										</select>
                                    </div>
                                </div>
                            </div>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <h3 style="margin-bottom:5px; margin-top:5px;">Document Details</h3>
                            </div>
                            <?php
                            if($view != true){
                            ?>
                            <div class="col-sm-12" style="text-align:right">
                                <div class="form-group form-float">
                                    <div class="form-line" style="border: none;">
                                        <label id="document_upload" class="btn btn-success" style="padding: 5px 12px !important;">Add</label>
                                    </div>
                                </div>
                            </div>
                            <?php
                            }
                            ?>
                            <input type="hidden" id="pay_row_count" value="1">
                            <div class="col-sm-12">
                                <div class="">
                                    <table style="width:100%" class="table table-bordered" id="pay_table">
                                        <thead>
                                            <tr>
                                                <th width="20%">Date</th>
                                                <th width="20%">Document</th>
                                                <th width="50%">Remark</th>
                                                <th width="10%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i=1;
                                            foreach($tenancy_documents as $row) {
                                            ?>
                                            <tr>
                                                <td><?php echo date("d/m/Y", strtotime($row['date'])); ?></td>
                                                <td><a href="<?php echo base_url(); ?>/uploads/tenant/<?php echo $row['document_name']; ?>" download><?php echo $row['document_name']; ?></a></td>
                                                <td><?php echo $row['remark']; ?></td>
                                                <td>
                                                <?php
                                                if($view != true){
                                                ?>
                                                    <a class="btn btn-danger btn-rad" onclick="rmv_document(<?php echo $row['id']; ?>)" style="width:auto;"><i class="material-icons"></i></a>
                                                    <?php
                                                }
                                                ?>
                                                </td>
                                            </tr>
                                            <?php
                                                $i++;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <?php
                        if($view != true){
                        ?>
                        <div class="row">
                            <div class="col-sm-12" align="center" style="background-color: white;padding-bottom: 1%;">
                                <button type="submit" class="btn btn-success btn-lg waves-effect">SUBMIT</button>
                            </div>
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                    </form>
                    
                    </div>
             
            </div>
        </div>
    </div>
    </div>

</section>
<script>
$('#form_validation').validate({
	rules: {
		"tennant_name": {
			required: true,
			remote: {
				url: "<?php echo base_url(); ?>/tennant/findNameExists",
				data: {
					update_id: function() {
						return $("#updateid").val();
					},
					tennant_name: $(this).data('tennant_name')
				},
				type: "post",
			},
		}
	},
	messages: {
		"tennant_name": {
			required: "tenant name is required",
			remote: "Already tenant name exist"
		}
	},
	highlight: function (input) {
		$(input).parents('.form-line').addClass('error');
	},
	unhighlight: function (input) {
		$(input).parents('.form-line').removeClass('error');
	},
	errorPlacement: function (error, element) {
		$(element).parents('.form-group').append(error);
	}
});


</script>

<script type="text/javascript">
    $("#document_upload").click(function(){
        var cnt = parseInt($("#pay_row_count").val());
        var html = '<tr id="rmv_payrow'+cnt+'">';
        html += '<td style="width: 20%;"><input type="date" style="border: none;" name="date[]" value="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d'); ?>"></td>';
        html += '<td style="width: 20%;"><input type="file" style="border: none;" name="file[]"></td>';
        html += '<td style="width: 50%;"><input type="text" style="border: none;" name="remark[]" placeholder="Enter remark"></td>';
        html += '<td style="width: 10%;"><a class="btn btn-danger btn-rad" onclick="rmv_pay('+ cnt +')" style="width:auto;"><i class="material-icons"></i></a></td>';
        html += '</tr>';
        $("#pay_table").append(html);
        var ct = parseInt(cnt + 1);
        $("#pay_row_count").val(ct);
    });
    function rmv_pay(id){
        $("#rmv_payrow"+id).remove();
    }
    function rmv_document(id){
        if(id != ""){
            $.ajax({
                url: "<?php echo base_url();?>/tennant/del_tennant_document",
                type: "post",
                data: {t_d_id: id},
                success:function(data){
                    location.reload();
                }
            });
        }
    }
    $("form").on("submit", function(){
       // $('input[type=submit]').prop('disabled', true);
       // $("#loader").show();
    });
</script>