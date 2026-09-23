<?php 
if($view == true){
    $readonly = 'readonly';
}
?>
<style>
      .itemcountrr .value-button {
display: inline-block;
    border: 1px solid #ddd;
    margin: 0px;
    width: 25px;
    height: 25px;
    text-align: center;
    vertical-align: middle;
    padding: 0px 0px 8px 0px;
    background: #eee;
  -webkit-touch-callout: none;
  -webkit-user-select: none;
  -khtml-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

.itemcountrr .value-button:hover {
  cursor: pointer;
}

.itemcountrr #decrease {
  margin-right: 0px;
  border-radius: 4px 0 0 4px;
  margin-top:-2px;
}

.itemcountrr #increase {
  margin-left: 0px;
  border-radius: 0 4px 4px 0;
  margin-top:-2px;
}

.itemcountrr #input-wrap {
  margin: 0px;
  padding: 0px;
}

.itemcountrr input.number {
    text-align: center;
    border: none;
    border-top: 1px solid #ddd;
    border-bottom: 1px solid #ddd;
    margin: 0px;
    width: 35px;
    height: 25px;
}

.itemcountrr input[type=number]::-webkit-inner-spin-button,
.itemcountrr input[type=number]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}


.addon_itemcountrr .value-button {
display: inline-block;
    border: 1px solid #ddd;
    margin: 0px;
    width: 25px;
    height: 25px;
    text-align: center;
    vertical-align: middle;
    padding: 0px 0px 8px 0px;
    background: #eee;
  -webkit-touch-callout: none;
  -webkit-user-select: none;
  -khtml-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

.addon_itemcountrr .value-button:hover {
  cursor: pointer;
}

.addon_itemcountrr #decrease {
  margin-right: 0px;
  border-radius: 4px 0 0 4px;
  margin-top:-2px;
}

.addon_itemcountrr #increase {
  margin-left: 0px;
  border-radius: 0 4px 4px 0;
  margin-top:-2px;
}

.addon_itemcountrr #input-wrap {
  margin: 0px;
  padding: 0px;
}

.addon_itemcountrr input.number {
    text-align: center;
    border: none;
    border-top: 1px solid #ddd;
    border-bottom: 1px solid #ddd;
    margin: 0px;
    width: 35px;
    height: 25px;
}

.addon_itemcountrr input[type=number]::-webkit-inner-spin-button,
.addon_itemcountrr input[type=number]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
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

<?php if($view == true) { ?>
label.form-label span { display:none !important; color:transporant; }
<?php } ?>

</style>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Package<small>Booking / <b>Add Package </b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    
                    <div class="header">
                        <div class="row">
                            <div class="col-md-8"><!--<h2>Hall</h2>--></div>
                            <div class="col-md-4" align="right"><a
                                    href="<?php echo base_url(); ?>/master/package"><button type="button"
                                        class="btn bg-deep-purple waves-effect">List</button></a></div>
                        </div>
                    </div>
                    
                    <form action="<?php echo base_url(); ?>/master/save_package" method="POST" enctype="multipart/form-data">
                    <div class="body">
						<?php if(!empty($_SESSION['succ'])) { ?>
                            <div class="row" style="padding: 0 30%;" id="content_alert">
                                <div class="suc-alert">
                                    <span class="suc-closebtn"
                                        onclick="this.parentElement.style.display='none';">&times;</span>
                                    <p>
                                        <?php echo $_SESSION['succ']; ?>
                                    </p>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if(!empty($_SESSION['fail'])) { ?>
                            <div class="row" style="padding: 0 30%;" id="content_alert">
                                <div class="alert">
                                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                                    <p>
                                        <?php echo $_SESSION['fail']; ?>
                                    </p>
                                </div>
                            </div>
                        <?php } ?>
                        <input type="hidden" name="id" value="<?php echo $data['id'];?>">
                        <div class="container-fluid">
                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text"  class="form-control" name="name" value="<?php echo $data['name'];?>" <?php echo $readonly; ?>>
                                        <label class="form-label">Name <span style="color: red;"> *</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text"  class="form-control" name="description" value="<?php echo $data['description'];?>" <?php echo $readonly; ?>>
                                        <label class="form-label">Description</label>
                                    </div>
                                </div>
                            </div> 
                            <div class="col-sm-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select class="form-control" name="package_type" id="package_type" <?php echo $readonly; ?>>
                                            <option>-- Select Package Type --</option>
                                            <option value="1" <?php if($data['package_type'] == '1'){ echo "selected"; } ?>>Hallbooking</option>
                                            <option value="2" <?php if($data['package_type'] == '2'){ echo "selected"; } ?>>Ubayam</option>
                                            <option value="3" <?php if($data['package_type'] == '3'){ echo "selected"; } ?>>Sannathi</option>
                                            <option value="4" <?php if($data['package_type'] == '4'){ echo "selected"; } ?>>Outdoor</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
							<div class="col-sm-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select class="form-control" name="package_mode" <?php echo $readonly; ?>>
                                            <option>-- Select Package Mode --</option>
                                            <option value="1" <?php if($data['package_mode'] == '1'){ echo "selected"; } ?>>Single</option>
                                            <option value="2" <?php if($data['package_mode'] == '2'){ echo "selected"; } ?>>Multiple</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
							<div class="col-sm-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="date"  class="form-control" name="pack_date" value="<?php echo $data['pack_date'];?>" <?php echo $readonly; ?>>
                                        <label class="form-label">Date</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
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
                            <div class="col-sm-3">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text"  class="form-control" name="amount" value="<?php echo $data['amount'];?>" <?php echo $readonly; ?>>
                                        <label class="form-label">Amount </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select class="form-control" name="status" <?php echo $readonly; ?>>
                                            <option>-- Select Status --</option>
                                            <option value="1" <?php if($data['status'] == '1'){ echo "selected"; } ?>>Active</option>
                                            <option value="2" <?php if($data['status'] == '2'){ echo "selected"; } ?>>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div> 
                            <?php if ($view != true) { ?>
                            <div class="col-sm-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <label class="form-label" style="display: contents;">Image</label>
                                        <input type="file" id="imgInp" name="package_image" accept="image/png,image/jpeg,image/jpg"
                                            class="form-control" <?php echo $readonly; ?>>
                                        <!--<label class="form-label">Image</label>-->
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="col-sm-4">
                            <div class="form-group form-float">
                                <div class="">
                                    <?php if (!empty ($data['image'])) { ?>
                                        <a target="_blank" href="<?php echo base_url(); ?>/uploads/package/<?php echo $data['image']; ?>">
                                            <img id="img_pre" src="<?php echo base_url(); ?>/uploads/package/<?php echo $data['image']; ?>"
                                                width="200" height="160"></img>
                                        </a>
                                    <?php } else { ?>
                        
                                        <!--<a id="img_anchor" target="_blank" href="#"> -->
                                        <img id="img_pre" src="#" width="200" height="160"></img>
                                        <!--</a>  -->
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <br>
                        </div>
                        
                        <hr>
                        <?php if($view != true) { ?>
                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select class="form-control" name="service_id" id="service_id" <?php echo $readonly; ?>>
                                            <option>-- Select Service --</option>
                                            <?php foreach($service as $row) { ?>
                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="number"  class="form-control" id="quantity" name="quantity" value="<?php echo $data['quantity'];?>" <?php echo $readonly; ?>>
                                        <label class="form-label">Quantity <span style="color: red;"> *</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2" align="right">
                                <div class="form-group form-float">
                                    <a class="btn btn-info" id="add_pack">Add</a>
                                </div>
                            </div>
                        </div>
                        <?php } ?>

                        
                        <div class="row" style="">
                            <div class="table-responsive">
                                <table class="table" id="package_services_table" style="background: #fff;border: none;width:100%">
                                    <thead>
                                        <tr>
                                            <th width="75%">Service</th>
                                            <th width="10%">Quantity</th>
                                            <th width="15%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 0; foreach($service_list as $row) { ?>
                                            <tr id="rmv_packservrow<?php echo $i; ?>">
                                                <td width="75%"><input type="hidden" style="border: none;" readonly="" name="services[<?php echo $i; ?>][service_id]" value="<?= $row['service_id']; ?>"><?= $row['name']; ?></td>
                                                <td width="10%"><div class="itemcountrr"><div class="value-button" id="decrease" onclick="decreaseValue(<?php echo $i; ?>)" value="Decrease Value" style="font-weight: bold;font-size: 16px; cursor: pointer;">-</div><input type="number" name="services[<?php echo $i; ?>][quantity]" min="1" id="quantity<?php echo $i; ?>" value="<?= $row['quantity']; ?>" class="quantity-input" style="text-align: center;border: none;border-top: 1px solid #ddd;border-bottom: 1px solid #ddd;margin: 0px;width: 35px;height: 25px;" onkeyup="qtykeyup(<?php echo $i; ?>)" /><div class="value-button" id="increase" onclick="increaseValue(<?php echo $i; ?>)" value="Increase Value" style="font-weight: bold;font-size: 16px; cursor: pointer;">+</div></div></td>
                                                <td style="width: 15%;"><a onclick="rmv_pack_serv(<?php echo $i; ?>)" style="color:red;font-weight:bold;cursor: pointer;"> X </a></td>
                                            </tr>
                                        <?php $i++; } ?>
                                    </tbody>
                                </table>
                            </div>
                            <input type="hidden" id="package_service_row_count" value="<?php echo $i; ?>">
                        </div>

                        <br>
                        <h3>Package Add-on Service<small><b></b></small></h3>
                        <?php if($view != true) { ?>
                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select class="form-control" name="addon_service_id" id="addon_service_id" <?php echo $readonly; ?>>
                                            <option>-- Select Service --</option>
                                            <?php foreach($service as $row) { ?>
                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="number"  class="form-control" id="addon_quantity" name="addon_quantity" value="<?php echo $data['quantity'];?>" <?php echo $readonly; ?>>
                                        <label class="form-label">Quantity <span style="color: red;"> *</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2" align="right">
                                <div class="form-group form-float">
                                    <a class="btn btn-info" id="addon_add_pack">Add</a>
                                </div>
                            </div>
                        </div>
                        <?php } ?>

                        <div class="row" style="">
                            <div class="table-responsive">
                                <table class="table" id="addon_package_services_table" style="background: #fff;border: none;width:100%">
                                    <thead>
                                        <tr>
                                            <th width="75%">Service</th>
                                            <th width="10%">Quantity</th>
                                            <th width="15%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 0; foreach($addon_service_list as $row) { ?>
                                            <tr id="addon_rmv_packservrow<?php echo $i; ?>">
                                                <td width="75%"><input type="hidden" style="border: none;" readonly="" name="addon_services[<?php echo $i; ?>][service_id]" value="<?= $row['service_id']; ?>"><?= $row['name']; ?></td>
                                                <td width="10%"><div class="addon_itemcountrr"><div class="value-button" id="addon_decrease" onclick="addon_decreaseValue(<?php echo $i; ?>)" value="Decrease Value" style="font-weight: bold;font-size: 16px; cursor: pointer;">-</div><input type="number" name="addon_services[<?php echo $i; ?>][quantity]" min="1" id="addon_quantity<?php echo $i; ?>" value="<?= $row['quantity']; ?>" class="addon_quantity-input" style="text-align: center;border: none;border-top: 1px solid #ddd;border-bottom: 1px solid #ddd;margin: 0px;width: 35px;height: 25px;" onkeyup="addon_qtykeyup(<?php echo $i; ?>)" /><div class="value-button" id="addon_increase" onclick="addon_increaseValue(<?php echo $i; ?>)" value="Increase Value" style="font-weight: bold;font-size: 16px; cursor: pointer;">+</div></div></td>
                                                <td style="width: 15%;"><a onclick="addon_rmv_pack_serv(<?php echo $i; ?>)" style="color:red;font-weight:bold;cursor: pointer;"> X </a></td>
                                            </tr>
                                        <?php $i++; } ?>
                                    </tbody>
                                </table>
                            </div>
                            <input type="hidden" id="addon_package_service_row_count" value="<?php echo $i; ?>">
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
</script>


<script>
// Initialize rowCounter based on the existing number of rows
var rowCounter = parseInt($("#package_service_row_count").val()) || 0;

$("#add_pack").click(function () {
    var service_id = $("#service_id").val();
    var service_id_text = $("#service_id option:selected").text();
    var quantity = parseInt($("#quantity").val());

    if (service_id != '' && !isNaN(quantity) && quantity > 0) {
        var existingRow = null;

        // Check if the service already exists in the table
        $("#package_services_table tbody tr").each(function() {
            var existingServiceId = $(this).find('input[name*="[service_id]"]').val();
            if (existingServiceId == service_id) {
                existingRow = $(this);
                return false; // break the loop
            }
        });

        if (existingRow) {
            var quantityInput = existingRow.find('input[name*="[quantity]"]');
            var currentQuantity = parseInt(quantityInput.val()) || 0;
            quantityInput.val(currentQuantity + quantity);
            existingRow.find("td:eq(1)").html('<div class="itemcountrr"><div class="value-button" id="decrease" onclick="decreaseValue(' + existingRow.attr('id').replace('rmv_packservrow', '') + ')" value="Decrease Value" style="font-weight: bold;font-size: 16px; cursor: pointer;">-</div><input type="number" name="services[' + existingRow.attr('id').replace('rmv_packservrow', '') + '][quantity]" min="1" id="quantity' + existingRow.attr('id').replace('rmv_packservrow', '') + '" value="' + (currentQuantity + quantity) + '" class="quantity-input" style="text-align: center;border: none;border-top: 1px solid #ddd;border-bottom: 1px solid #ddd;margin: 0px;width: 35px;height: 25px;" onkeyup="qtykeyup(' + existingRow.attr('id').replace('rmv_packservrow', '') + ')" /><div class="value-button" id="increase" onclick="increaseValue(' + existingRow.attr('id').replace('rmv_packservrow', '') + ')" value="Increase Value" style="font-weight: bold;font-size: 16px; cursor: pointer;">+</div></div>');
        } else {
            var html = '<tr id="rmv_packservrow' + rowCounter + '">';
            html += '<td width="75%"><input type="hidden" style="border: none;" readonly="" name="services[' + rowCounter + '][service_id]" value="' + service_id + '">' + service_id_text + '</td>';
            html += '<td width="10%"><div class="itemcountrr"><div class="value-button" id="decrease" onclick="decreaseValue(' + rowCounter + ')" value="Decrease Value" style="font-weight: bold;font-size: 16px; cursor: pointer;">-</div><input type="number" name="services[' + rowCounter + '][quantity]" min="1" id="quantity' + rowCounter + '" value="' + quantity + '" class="quantity-input" style="text-align: center;border: none;border-top: 1px solid #ddd;border-bottom: 1px solid #ddd;margin: 0px;width: 35px;height: 25px;" onkeyup="qtykeyup(' + rowCounter + ')" /><div class="value-button" id="increase" onclick="increaseValue(' + rowCounter + ')" value="Increase Value" style="font-weight: bold;font-size: 16px; cursor: pointer;">+</div></div></td>';
            html += '<td style="width: 15%;"><a onclick="rmv_pack_serv(' + rowCounter + ')" style="color:red;font-weight:bold;cursor: pointer;"> X </a><input type="hidden" class="package_category" value="' + service_id + '"></td>';
            html += '</tr>';
            $("#package_services_table tbody").append(html);
            rowCounter++;
        }

        // Clear inputs after adding
        $("#service_id").val('');
        $("#quantity").val('');
        $("#service_id").selectpicker("refresh");

        sum_amount();
    } else {
        alert("Please select a service and enter a valid quantity.");
    }
});

function increaseValue(cnt) {
    var quantity = $("#quantity" + cnt);
    var currentVal = parseInt(quantity.val());
    if (!isNaN(currentVal)) {
        quantity.val(currentVal + 1);
        updateAmount(cnt);
    } else {
        quantity.val(1);
    }
    sum_amount();
}

function decreaseValue(cnt) {
    var quantity = $("#quantity" + cnt);
    var currentVal = parseInt(quantity.val());
    if (!isNaN(currentVal) && currentVal > 1) {
        quantity.val(currentVal - 1);
        updateAmount(cnt);
    } else {
        quantity.val(1);
    }
    sum_amount();
}

function qtykeyup(cnt) {
    var quantity = $("#quantity" + cnt);
    var currentVal = parseInt(quantity.val());
    if (!isNaN(currentVal) && currentVal >= 0) {
        updateAmount(cnt);
    } else {
        quantity.val(1);
    }
    sum_amount();
}



function rmv_pack_serv(id) {
    $("#rmv_packservrow" + id).remove();
    sum_amount();
}














var addon_rowCounter = parseInt($("#addon_package_service_row_count").val()) || 0;

$("#addon_add_pack").click(function () {
    var addon_service_id = $("#addon_service_id").val();
    var addon_service_id_text = $("#addon_service_id option:selected").text();
    var addon_quantity = parseInt($("#addon_quantity").val());

    if (addon_service_id != '' && !isNaN(addon_quantity) && addon_quantity > 0) {
        var addon_existingRow = null;

        // Check if the service already exists in the table
        $("#addon_package_services_table tbody tr").each(function() {
            var addon_existingServiceId = $(this).find('input[name*="[service_id]"]').val();
            if (addon_existingServiceId == addon_service_id) {
                addon_existingRow = $(this);
                return false; // break the loop
            }
        });

        if (addon_existingRow) {
            var addon_quantityInput = addon_existingRow.find('input[name*="[quantity]"]');
            var addon_currentQuantity = parseInt(addon_quantityInput.val()) || 0;
            addon_quantityInput.val(addon_currentQuantity + addon_quantity);
            addon_existingRow.find("td:eq(1)").html('<div class="addon_itemcountrr"><div class="value-button" id="addon_decrease" onclick="addon_decreaseValue(' + addon_existingRow.attr('id').replace('addon_rmv_packservrow', '') + ')" value="Decrease Value" style="font-weight: bold;font-size: 16px; cursor: pointer;">-</div><input type="number" name="addon_services[' + addon_existingRow.attr('id').replace('addon_rmv_packservrow', '') + '][quantity]" min="1" id="addon_quantity' + addon_existingRow.attr('id').replace('addon_rmv_packservrow', '') + '" value="' + (addon_currentQuantity + addon_quantity) + '" class="addon_quantity-input" style="text-align: center;border: none;border-top: 1px solid #ddd;border-bottom: 1px solid #ddd;margin: 0px;width: 35px;height: 25px;" onkeyup="addon_qtykeyup(' + addon_existingRow.attr('id').replace('addon_rmv_packservrow', '') + ')" /><div class="value-button" id="addon_increase" onclick="addon_increaseValue(' + addon_existingRow.attr('id').replace('addon_rmv_packservrow', '') + ')" value="Increase Value" style="font-weight: bold;font-size: 16px; cursor: pointer;">+</div></div>');
        } else {
            var html = '<tr id="addon_rmv_packservrow' + addon_rowCounter + '">';
            html += '<td width="75%"><input type="hidden" style="border: none;" readonly="" name="addon_services[' + addon_rowCounter + '][service_id]" value="' + addon_service_id + '">' + addon_service_id_text + '</td>';
            html += '<td width="10%"><div class="addon_itemcountrr"><div class="value-button" id="addon_decrease" onclick="addon_decreaseValue(' + addon_rowCounter + ')" value="Decrease Value" style="font-weight: bold;font-size: 16px; cursor: pointer;">-</div><input type="number" name="addon_services[' + addon_rowCounter + '][quantity]" min="1" id="addon_quantity' + addon_rowCounter + '" value="' + addon_quantity + '" class="addon_quantity-input" style="text-align: center;border: none;border-top: 1px solid #ddd;border-bottom: 1px solid #ddd;margin: 0px;width: 35px;height: 25px;" onkeyup="addon_qtykeyup(' + addon_rowCounter + ')" /><div class="value-button" id="addon_increase" onclick="addon_increaseValue(' + addon_rowCounter + ')" value="Increase Value" style="font-weight: bold;font-size: 16px; cursor: pointer;">+</div></div></td>';
            html += '<td style="width: 15%;"><a onclick="addon_rmv_pack_serv(' + addon_rowCounter + ')" style="color:red;font-weight:bold;cursor: pointer;"> X </a><input type="hidden" class="addon_package_category" value="' + addon_service_id + '"></td>';
            html += '</tr>';
            $("#addon_package_services_table tbody").append(html);
            addon_rowCounter++;
        }

        // Clear inputs after adding
        $("#addon_service_id").val('');
        $("#addon_quantity").val('');
        $("#addon_service_id").selectpicker("refresh");

        sum_amount();
    } else {
        alert("Please select a service and enter a valid quantity.");
    }
});

function addon_increaseValue(addon_cnt) {
    var addon_quantity = $("#addon_quantity" + addon_cnt);
    var addon_currentVal = parseInt(addon_quantity.val());
    if (!isNaN(addon_currentVal)) {
        addon_quantity.val(addon_currentVal + 1);
        updateAmount(addon_cnt);
    } else {
        addon_quantity.val(1);
    }
    sum_amount();
}

function addon_decreaseValue(addon_cnt) {
    var addon_quantity = $("#addon_quantity" + addon_cnt);
    var addon_currentVal = parseInt(addon_quantity.val());
    if (!isNaN(addon_currentVal) && addon_currentVal > 1) {
        addon_quantity.val(addon_currentVal - 1);
        updateAmount(addon_cnt);
    } else {
        addon_quantity.val(1);
    }
    sum_amount();
}

function addon_qtykeyup(addon_cnt) {
    var addon_quantity = $("#addon_quantity" + addon_cnt);
    var addon_currentVal = parseInt(addon_quantity.val());
    if (!isNaN(addon_currentVal) && addon_currentVal >= 0) {
        updateAmount(addon_cnt);
    } else {
        addon_quantity.val(1);
    }
    sum_amount();
}



function addon_rmv_pack_serv(id) {
    $("#addon_rmv_packservrow" + id).remove();
    sum_amount();
}



















$('#package_type').on('change', function(){
    $('#package_services_table tbody').html('');
    $('#addon_package_services_table tbody').html('');
});
// $('#package_type').change(function(){
//     var val = $(this).val();
//     $("#service_id").html('<option>-- Select Service --</option>');
//     $("#service_id").selectpicker("refresh");
                     
//     $("#addon_service_id").html('<option>-- Select Addon Service --</option>');
//     $("#addon_service_id").selectpicker("refresh");
                     
//     $.ajax
//         ({
//             type:"POST",
//             url: "<?php echo base_url();?>/master/get_service",
//             data:{id: val},
// 			dataType: "json",
//             success:function(response)
// 			{
//                 console.log(response);
//                 if(response.row.length > 0 ){
//                     var html = '<option>-- Select Service --</option>';
//                     response.row.forEach(function(value, key){
//                         html += '<option value="' + value.id + '">' + value.name + '</option>';
//                     });
//                     console.log(html);
//                     $('#service_id').html(html);
//                     $("#service_id").selectpicker("refresh");

//                     var addon_html = '<option>-- Select Addon Service --</option>';
//                     response.addon_row.forEach(function(value, key){
//                         addon_html += '<option value="' + value.id + '">' + value.name + '</option>';
//                     });
//                     $('#addon_service_id').html(addon_html);
//                     $("#addon_service_id").selectpicker("refresh");
//                 }
               
                
//                 //$('#service_id').prop('selectedIndex',0);
//                 //$("#service_id").selectpicker("refresh");
// 			}
//         })
// });
</script>
<script>
    $(document).ready(function() {
    function populateServices(packageTypeId) {
        var val = packageTypeId;
        $("#service_id").html('<option>-- Select Service --</option>');
        $("#service_id").selectpicker("refresh");

        $("#addon_service_id").html('<option>-- Select Addon Service --</option>');
        $("#addon_service_id").selectpicker("refresh");

        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>/master/get_service",
            data: { id: val },
            dataType: "json",
            success: function(response) {
                console.log(response);
                if (response.row.length > 0) {
                    var html = '<option>-- Select Service --</option>';
                    response.row.forEach(function(value, key) {
                        html += '<option value="' + value.id + '">' + value.name + '</option>';
                    });
                    console.log(html);
                    $('#service_id').html(html);
                    $("#service_id").selectpicker("refresh");

                    var addon_html = '<option>-- Select Addon Service --</option>';
                    response.addon_row.forEach(function(value, key) {
                        addon_html += '<option value="' + value.id + '">' + value.name + '</option>';
                    });
                    $('#addon_service_id').html(addon_html);
                    $("#addon_service_id").selectpicker("refresh");
                }
            }
        });
    }

    $('#package_type').change(function() {
        var val = $(this).val();
        populateServices(val);
    });

    var initialPackageType = $('#package_type').val();
    if (initialPackageType) {
        populateServices(initialPackageType);
    }
});

</script>    
<script>
    function validations(){
        $.ajax
            ({
            type:"POST",
            url: "<?php echo base_url(); ?>/master/validation",
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