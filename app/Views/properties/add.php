<script src="<?php echo base_url(); ?>/assets/yearpicker/bootstrap-datepicker.js"></script>
<link href="<?php echo base_url(); ?>/assets/yearpicker/bootstrap-datepicker.css" rel="stylesheet"/>
<?php
$db = db_connect();
?>
<?php 
if($view == true){
    $readonly = 'readonly';
    $disable = "disabled";
}
?>
<script src="<?php echo base_url(); ?>/assets/jquery.validate.js"></script>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
        <h2>PROPERTIES<small>Properties / <b>Add</b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
					<div class="header">
                        <div class="row"><div class="col-md-8"></div>
                        <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/properties"><button type="button" class="btn bg-deep-purple waves-effect">List</button></a></div></div>
                    </div>
                    <div class="body">
                    <form action="<?php echo base_url(); ?>/properties/store" method="POST" id="form_validation" enctype="multipart/form-data">
						<input type="hidden" value="<?php echo isset($property['id']) ? $property['id'] : ""; ?>" name="id" id="updateid">
                        <div class="container-fluid">
                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line focused">
                                        <input type="text" name="property_name" id="property_name" class="form-control" value="<?php echo isset($property['name']) ? $property['name'] : ""; ?>" required <?php echo $readonly; ?>>
                                        <label class="form-label">Property Name<span style="color: red;">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line focused">
                                        <input type="text" name="lotno" id="lotno" class="form-control" value="<?php echo isset($property['lot_no']) ? $property['lot_no'] : ""; ?>" required <?php echo $readonly; ?>>
                                        <label class="form-label">Lot No. <span style="color: red;">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div style="clear:both"></div>
                            <div class="col-sm-4">
                                <div class="form-group form-float">
                                    <div class="form-line focused">
                                        <input type="text" name="area" id="area" class="form-control" value="<?php echo isset($property['area']) ? $property['area'] : ""; ?>" <?php echo $readonly; ?>>
                                        <label class="form-label">Area </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group form-float">
                                    <div class="form-line focused">
                                        <input type="text" step=".01" name="square_feet" id="square_feet" class="form-control" value="<?php echo isset($property['square_feet']) ? $property['square_feet'] : ""; ?>" <?php echo $readonly; ?>>
                                        <label class="form-label">Square Feet </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group form-float">
                                    <div class="form-line focused">
                                        <input type="number" min="0" step="any" name="amount" id="amount" class="form-control" value="<?php echo isset($property['amount']) ? $property['amount'] : ""; ?>" <?php echo $readonly; ?>>
                                        <label class="form-label">Property Value </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 hide">
                                <div class="form-group form-float">
                                    <div class="form-line focused">
                                        <input type="text"  name="type" id="type" class="form-control" value="<?php echo isset($property['type']) ? $property['type'] : ""; ?>" required <?php echo $readonly; ?>>
                                        <label class="form-label">Type <span style="color: red;">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div style="clear:both"></div>
                            <div class="col-sm-5">
                                <div class="form-group form-float">
                                    <div class="form-line focused">
                                        <select name="property_category" id="property_category" class="form-control" required <?php echo $disable; ?>>
											<option value="">select property type</option>
											<?php
											foreach($property_category as $property_category_row)
											{
											?>
											<option value="<?php echo $property_category_row['id']; ?>" <?php if(isset($property['property_category_id'])){ if($property['property_category_id'] == $property_category_row['id']){ echo "selected"; } }?>><?php echo $property_category_row['name']; ?></option>
											<?php
											}
											?>
										</select>
                                        <label class="form-label">Property Type <span style="color: red;">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <?php
                            if($view != true){
                            ?>
                            <div class="col-sm-1">
                                <a class="btn btn-primary btn-rad" onclick="property_type_modal()" style="cursor:pointer;padding: 0px 12px !important;font-size: 25px;">+</a>
                            </div>
                            <?php 
                            }
                            ?>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line focused">
                                        <input type="text" name="purchased_year" id="purchased_year" class="form-control" value="<?php echo isset($property['purchased_year']) ? $property['purchased_year'] : ""; ?>" required <?php echo $disable; ?>>
                                        <label class="form-label">Purchased Year <span style="color: red;">*</span></label>
                                    </div>
                                    
                                </div>
                            </div>
                            <div style="clear:both"></div>
                            <div class="col-sm-5">
                                <div class="form-group form-float">
                                    <div class="form-line focused">
                                        <select name="rental_type" id="rental_type" class="form-control" required <?php echo $disable; ?>>
											<option value="">select rental type</option>
											<?php
                                                foreach($rental_types as $rental_type)
                                                {
                                                ?>
                                                <option value="<?php echo $rental_type['id']; ?>" <?php if(!empty($property['rental_type'])){ if($property['rental_type'] == $rental_type['id']){ echo "selected"; } }?>><?php echo $rental_type['name']; ?></option>
                                                <?php
                                                }
                                            ?>
										</select>
                                        <label class="form-label">Rental Type <span style="color: red;">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <?php
                            if($view != true){
                            ?>
                            <div class="col-sm-1">
                                <a class="btn btn-primary btn-rad" onclick="rental_type_modal()" style="cursor:pointer;padding: 0px 12px !important;font-size: 25px;">+</a>
                            </div>
                            <?php 
                            }
                            ?>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line focused">
                                        <input type="number" step="any" min="0" name="rental_value" id="rental_value" class="form-control" value="<?php echo isset($property['rental_value']) ? $property['rental_value'] : ""; ?>" required <?php echo $readonly; ?>>
                                        <label class="form-label">Rental Value<span style="color: red;">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div style="clear:both"></div>
                            <div class="col-sm-4">
                                <div class="form-group form-float">
                                    <div class="form-line focused">
                                        <select name="due_date" id="due_date" class="form-control" required <?php echo $disable; ?>>
                                            <option value="">Select Due Date</option>
                                            <?php
                                                foreach($property_duedates as $duedates){
                                                ?>
                                                <option value="<?php echo $duedates['id']; ?>" <?php if(isset($property['due_date'])){ if($property['due_date'] == $duedates['id']){ echo 'selected'; } }?> > <?php echo $duedates['name']; ?> </option>
                                                <?php
                                                }
                                            ?>
                                        </select>
                                        <label class="form-label">Due Date <span style="color: red;">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <?php
                            if(!empty($property['property_status'])){
                                $property_status = $property['property_status'];
                                $properties_status_row = $db->query("SELECT name FROM property_status where status = 1 and id = $property_status ")->getRowArray();
                                $properties_status_name = !empty($properties_status_row['name']) ? $properties_status_row['name'] : "";
                            ?>
                            <div class="col-sm-4">
                                <div class="form-group form-float">
                                    <div class="form-line focused">
                                        <input type="text" class="form-control" value="<?php echo $properties_status_name; ?>" readonly>
                                        <label class="form-label">Status</label>
                                    </div>
                                </div>
                            </div>
                            <?php
                            if($property_status == 2){
                                $prop_id = $property['id'];
                                $tannant_row = $db->query("SELECT end_date FROM tennant where status = 1 and property_id = $prop_id ")->getRowArray();
                                $tannant_name = !empty($tannant_row['end_date']) ? date('d/m/Y',strtotime($tannant_row['end_date'])) : "";
                            ?>
                            <div class="col-sm-4">
                                <div class="form-group form-float">
                                    <div class="form-line focused">
                                        <input type="text" class="form-control" value="<?php echo $tannant_name; ?>" readonly>
                                        <label class="form-label">Status</label>
                                    </div>
                                </div>
                            </div>

                            <?php
                                }
                            }
                            ?>

                        </div>
                        
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
                                            if(!empty($property_documents)){
                                                $i=1;
                                                foreach($property_documents as $row) {
                                                    if(!empty($row['document_name'])){
                                                ?>
                                                <tr>
                                                    <td><?php echo date("d/m/Y", strtotime($row['date'])); ?></td>
                                                    <td><a href="<?php echo base_url(); ?>/uploads/properties/<?php echo $row['document_name']; ?>" download><?php echo $row['document_name']; ?></a></td>
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
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <input type="hidden" id="pay_row_count" value="1">
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
                    </form>
                    
                    </div>
             
            </div>
        </div>
    </div>
    </div>
    <!--Property Type Modal-->
    <style>
        .modal-dialog {
            min-height: calc(100vh - 60px);
            display: flex;
            flex-direction: column;
            justify-content: center;
            overflow: auto;
        }
        @media(max-width: 768px) {
            .modal-dialog {
                min-height: calc(100vh - 20px);
            }
        }
    </style>
    <div class="modal fade" id="property_type_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Property Type</h5>
                </div>
                <form id="form_propery_type">
                    <div class="modal-body">
                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <input type="text" class="form-control" name="property_type" id="property_type" required>
                                <label class="form-label">Name</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="property_type_submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="rental_type_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="example1ModalLabel">Rental Type</h5>
                </div>
                <form id="form_rental_type">
                    <div class="modal-body">
                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <input type="text" class="form-control" name="rental_type_add" id="rental_type_add" required>
                                <label class="form-label">Name</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="rental_type_submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</section>
<script>

    $('#form_propery_type').validate({
        rules: {
            "property_type": {
                required: true,
                remote: {
                    url: "<?php echo base_url(); ?>/properties/findpropertytypenameExists",
                    data: {
                        property_type: $(this).data('property_type')
                    },
                    type: "post",
                },
            }
        },
        messages: {
            "property_type": {
                required: "property type is required",
                remote: "already exist property type"
            }
        },
        submitHandler: function(form) {
            $.ajax({
                url: '<?php echo base_url(); ?>/properties/save_property_type',
                type: 'post',
                data: $('#form_propery_type').serialize(),
                success: function(response) {
                    location.reload();
                }            
            });
        }
    });
    $('#form_rental_type').validate({
        rules: {
            "rental_type_add": {
                required: true,
                remote: {
                    url: "<?php echo base_url(); ?>/properties/findrentaltypenameExists",
                    data: {
                        rental_type_add: $(this).data('rental_type_add')
                    },
                    type: "post",
                },
            }
        },
        messages: {
            "rental_type_add": {
                required: "rental type is required",
                remote: "already exist rental type"
            }
        },
        submitHandler: function(form) {
            $.ajax({
                url: '<?php echo base_url(); ?>/properties/save_rental_type',
                type: 'post',
                data: $('#form_rental_type').serialize(),
                success: function(response) {
                    location.reload();
                }            
            });
        }
    });

$('#form_validation').validate({
	rules: {
		"property_category": {
			required: true,
		}
	},
	messages: {
		"property_category": {
			required: "property name is required"
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

function property_type_modal()
{
    $('#property_type').val("");
    $('#property_type-error').hide();
    $('#property_type_modal').modal('show', {backdrop: 'static'});
}
function rental_type_modal()
{
    $('#rental_type_add').val("");
    $('#rental_type_add-error').hide();
    $('#rental_type_modal').modal('show', {backdrop: 'static'});
}
</script>

<script type="text/javascript">
    $("#document_upload").click(function(){
        var cnt = parseInt($("#pay_row_count").val());
        var html = '<tr id="rmv_payrow'+cnt+'">';
        html += '<td style="width: 20%;"><input type="date" value="<?php echo date("Y-m-d"); ?>" style="border: none;" name="date[]" max="<?php echo date("Y-m-d"); ?>"></td>';
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
    $("form").on("submit", function(){
       // $('input[type=submit]').prop('disabled', true);
       // $("#loader").show();
    });

    function rmv_document(id){
        if(id != ""){
            $.ajax({
                url: "<?php echo base_url();?>/properties/del_property_document",
                type: "post",
                data: {p_d_id: id},
                success:function(data){
                    location.reload();
                }
            });
        }
    }
</script>

<script>
	//Month picker
	$('#purchased_year').datepicker({
		autoclose: true,
		format: "yyyy",
		viewMode: "years",
		minViewMode: "years",
        endDate:new Date()
	});
  </script>