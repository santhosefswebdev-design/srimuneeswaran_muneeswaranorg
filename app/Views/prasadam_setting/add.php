<style>

.ui-autocomplete{
            padding: 0px !important;
    }
    .ui-autocomplete ul{
        background-color: #5d8dff; font-size:14px;
    }
    li a{
        color: #fff;
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

    <?php if(empty($data['image'])) {?>
        #img_pre {
            display : none;
        }
    <?php }
	if($view == true) { ?>
        label.form-label span { display:none !important; color:transporant; }
    <?php } ?>
        
</style>

<?php 
if($view == true){
    $readonly = 'readonly';
    $disable = "disabled";
}
?>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2> Prasadam Setting<small>Prasadam / <b> Add Prasadam Setting</b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row"><div class="col-md-8"><!--<h2>Add Prasadam Settings</h2>--></div>
                        <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/prasadamsetting"><button type="button" class="btn bg-deep-purple waves-effect">List</button></a></div></div>
                    </div>
                    <form action="<?php echo base_url(); ?>/prasadamsetting/save" method="POST" enctype='multipart/form-data'>
                    <div class="body">
                        <input type="hidden" name="id" value="<?php echo $data['id'];?>">
                        <div class="container-fluid">
                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" name="name_eng"  class="form-control" value="<?php echo $data['name_eng'];?>" <?php echo $readonly; ?> >
                                        <label class="form-label"> Name For English <span style="color: red;">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" name="name_tamil"  class="form-control" value="<?php echo $data['name_tamil'];?>" <?php echo $readonly; ?> >
                                        <label class="form-label"> Name for Tamil <span style="color: red;">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="number" step=".01" name="amount" class="form-control" value="<?php echo $data['amount'];?>" <?php echo $readonly; ?> >
                                        <label class="form-label">Amount <span style="color: red;">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select class="form-control" name="status" <?php echo $readonly; ?>>
                                            <option>-- Select Status --</option>
                                            <option value="1" <?php if(!empty($data['status']) && $data['status'] == '1'){ echo "selected"; } ?>>Active</option>
                                            <option value="0" <?php if(!empty($data['status']) && $data['status'] == '0'){ echo "selected"; } ?>>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div> 

                            <?php if($view != true) { ?>
                            <div class="col-sm-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <label class="form-label" style="display: contents;">Image</label>
                                        <input type="file" id="imgInp" name="prasadam_image" accept="image/png,image/jpeg,image/jpg" class="form-control" <?php echo $readonly; ?> >
                                        <!--<label class="form-label">Image</label>-->
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="">
											<?php if(!empty($data['image'])) {?>
                                                <a target="_blank" href="/uploads/prasadam_setting/<?php echo $data['image']; ?>">
                                                    <img id="img_pre" src="/uploads/prasadam_setting/<?php echo $data['image']; ?>" width="200" height="160"></img>
                                                </a>
											<?php } else { ?> 
												
												<!--<a id="img_anchor" target="_blank" href="#"> -->
                                                    <img id="img_pre" src="#" width="200" height="160"></img>
                                                <!--</a>  -->
											<?php }?>												
                                            </div>
                                        </div>
                            </div> 
                                                    
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="">
                                        <input type="checkbox" id="alpha_stock" name="stock_prasadam"  class="form-control" <?php echo $disable; ?> value="1" <?php if($data['dedection_from_stock'] == 1){ echo "checked"; }?>>
                                        <label for="alpha_stock" class="form-label">Dedection from Raw Material</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <select class="form-control search_box" data-live-search="true" name="ledger_id" id="ledger_id">
                                        <option value="">Select Ledger</option>
                                        <?php
                                        if(!empty($ledgers))
                                        {
                                            foreach($ledgers as $ledger)
                                            {
                                        ?>
                                            <option value="<?php echo $ledger["id"]; ?>"<?php if(!empty($data['ledger_id'])){ if($data['ledger_id'] == $ledger["id"]){ echo "selected"; }} ?>><?php echo $ledger['left_code'] . '/' . $ledger['right_code'] . " - ".$ledger["name"]; ?> </option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
    <div class="form-group form-float">
        <div>
            <?php foreach ($prasadam_groups as $group): ?>
                <?php
                    $isChecked = '';
                    $amountValue = '';
                    // print_r($selected_prasadam_groups);
                    foreach ($selected_prasadam_groups as $selected) {
                        if ($selected['prasadam_group_id'] == $group['id']) {
                            $isChecked = 'checked';
                            $amountValue = $selected['amount'];
                            break;
                        }
                    }
                ?>
                <div style="margin-bottom: 15px;">
                    <input type="checkbox" id="prasadam_<?php echo $group['id']; ?>" name="prasadam_group[]" value="<?php echo $group['id']; ?>" class="form-control prasadam-checkbox" <?php echo $isChecked; ?>>
                    <label for="prasadam_<?php echo $group['id']; ?>" class="form-label"><?php echo $group['group_name']; ?></label>
                    <input type="text" name="amount_<?php echo $group['id']; ?>" class="form-control amount-input" placeholder="Enter amount" value="<?php echo $amountValue; ?>" style="<?php echo $isChecked ? '' : 'display:none;'; ?>">
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
                        </div>
                    </div>
                    </div>
                    </form>
                    <?php if($view != true) { ?>
                    <div class="col-sm-12" align="center" style="background-color: white;padding-bottom: 1%;">
                        <button type="submit" onclick="validations()" class="btn btn-success btn-lg waves-effect">SAVE</button>
                        <button type="button" id="clear" class="btn btn-primary btn-lg waves-effect">CLEAR</button>
                    </div>
                    <?php } ?>
                    <div id="alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-body p-4">
                                        <div class="text-center">
                                            <i class="dripicons-information h1 text-info"></i>
                                            <table>
                                            <tr><span id="spndeddelid"><b></b></span>&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-info my-3" data-dismiss="modal"> &times;</button></tr>
                                             </table>
                                            
                                        </div>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</section> 
<script>
    $("#clear").click(function(){
		
       $("input").val("");
    });
		
		$("#imgInp").change(function(){
			// alert (0);
        readURL(this);		
		});
		
		function readURL(input) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();
				
				reader.onload = function (e) {
					//alert (URL.createObjectURL(e.target.files[0]))
					$('#img_pre').attr('src', e.target.result);
					$('#img_pre').show();
					//$('#img_anchor').attr("href", e.target.result)				
				}            
				reader.readAsDataURL(input.files[0]);
			}
		}
function validations(){
    $.ajax
        ({
        type:"POST",
        url: "<?php echo base_url(); ?>/prasadamsetting/prasadam_setting_validation",
        data: $("form").serialize(),
        success:function(data)
        {
            obj = jQuery.parseJSON(data);
            console.log(obj);
            if(obj.err != ''){
                $('#alert-modal').modal('show', {backdrop: 'static'});
                $("#spndeddelid").text(obj.err);
            }else{
                $('input[type=submit]').prop('disabled', true);
                $("#loader").show();
                $("form").submit();
            }
        }
    })
        
}
</script>

<script>
$(document).ready(function() {
    $('.prasadam-checkbox').change(function() {
        var checkbox = $(this);
        var amountInput = checkbox.closest('div').find('.amount-input');

        if (checkbox.is(':checked')) {
            amountInput.show(); 
        } else {
            amountInput.hide(); 
            amountInput.val('');
        }
    });
});
</script>
