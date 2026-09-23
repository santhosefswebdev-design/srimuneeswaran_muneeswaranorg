<?php 
if($view == true){
    $readonly = 'readonly';
}
?>
<style>
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

<?php if($view == true) { ?>
label.form-label span { display:none !important; color:transporant; }
<?php } ?>

</style>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Temple Event<small>Deity / <b>Add </b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    
                    <div class="header">
                        <div class="row">
                            <div class="col-md-8"><!--<h2>Hall</h2>--></div>
                            <div class="col-md-4" align="right"><a
                                    href="<?php echo base_url(); ?>/deity"><button type="button"
                                        class="btn bg-deep-purple waves-effect">List</button></a></div>
                        </div>
                    </div>
                    
                    <form action="<?php echo base_url(); ?>/deity/save_deity" method="POST">
                        <div class="body">
                            <input type="hidden" name="id" value="<?php echo $data['id'];?>">
                            <div class="container-fluid">
                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text"  class="form-control" name="name_eng" required value="<?php echo $data['name_eng'];?>" <?php echo $readonly; ?>>
                                                <label class="form-label">Name in English <span style="color: red;"> *</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text"  class="form-control" name="name_tamil" required value="<?php echo $data['name_tamil'];?>" <?php echo $readonly; ?>>
                                                <label class="form-label">Name in Tamil <span style="color: red;"> *</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <select class="form-control search_box" data-live-search="true" data-live-search-style="startsWith" name="ledger_id" id="ledger_id">
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
                                </div>
                                <div class="row clearfix">
                                    <div class="col-sm-1">
                                        <div class="form-check" style="margin-top:15px;">
                                        <input class="form-check-input" id="abi_status" name="abi_status" <?php if($data['abishegam_status'] == '1'){ echo "checked"; } ?> type="checkbox" value="1">
                                        <label class="form-check-label" for="abi_status">
                                            Abisheagm
                                        </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" id="abi_amount" class="form-control" name="abi_amount" value="<?php echo $data['abishegam_amount'];?>" <?php echo $readonly; ?>>
                                                <label class="form-label">Amount <span id="req" style="color: red;"> *</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-1">
                                        <div class="form-check" style="margin-top:15px;">
                                        <input class="form-check-input" id="hom_status" name="hom_status" <?php if($data['homam_status'] == '1'){ echo "checked"; } ?> type="checkbox" value="1">
                                        <label class="form-check-label" for="hom_status">
                                            Homam
                                        </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" id="hom_amount" class="form-control" name="hom_amount" value="<?php echo $data['homam_amount'];?>" <?php echo $readonly; ?>>
                                                <label class="form-label">Amount <span id="req1" style="color: red;"> *</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <select class="form-control" name="status" id="status" <?php echo $readonly; ?>>
                                                    <option value="">-- Select Status --</option>
                                                    <option value="1" <?php if($data['status'] == '1'){ echo "selected"; } ?>>Active</option>
                                                    <option value="2" <?php if($data['status'] == '2'){ echo "selected"; } ?>>Inactive</option>
                                                </select>
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
    $("form")[0].reset();
    $("input[type=checkbox]").prop('checked', false);
    $("select").prop('selectedIndex', 0);
});

$(function () {
    $('#req').hide();
    $('#abi_status').change(function () {
        if ($(this).is(':checked')) {
            $('#abi_amount').attr('required', 'true');
            $('#req').show();
        } else {
            $('#abi_amount').removeAttr('required'); 
            $('#req').hide();
        }
    });
});

$(function () {
    $('#req1').hide();
    $('#hom_status').change(function () {
        if ($(this).is(':checked')) {
            $('#hom_amount').attr('required', 'true');
            $('#req1').show();
        } else {
            $('#hom_amount').removeAttr('required'); 
            $('#req1').hide();
        }
    });
});

function validations() {
    $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>/deity/validation2",
        data: $("form").serialize(),
        success: function(data) {
            obj = jQuery.parseJSON(data);
            if (obj.err != '') {
                $('#alert-modal').modal('show', {backdrop: 'static'});
                $("#spndeddelid").text(obj.err);
            } else {
                $('input[type=submit]').prop('disabled', true);
                $("#loader").show();
                $("form").unbind('submit').submit(); // Prevent double submission
            }
        }
    });
}
</script>
