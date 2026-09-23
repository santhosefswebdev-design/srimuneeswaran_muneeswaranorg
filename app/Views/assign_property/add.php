<?php
$db = db_connect();
if ($view == true) {
    $view_readonly = "readonly";
    $view_disabled = "disabled";
}
if ($edit == true) {
    $readonly = "readonly";
    $disabled = "disabled";
}
?>
<script src="<?php echo base_url(); ?>/assets/jquery.validate.js"></script>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Property<small>Assign Property / <b>Add</b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row">
                            <div class="col-md-8"></div>
                            <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/properties"><button
                                        type="button" class="btn bg-deep-purple waves-effect">Properties
                                        List</button></a></div>
                        </div>
                    </div>
                    <div class="body">
                        <form action="<?php echo base_url(); ?>/properties/store_assign_property" method="POST"
                            id="form_validation" enctype="multipart/form-data">
                            <input type="hidden"
                                value="<?php echo isset($tennant_property['id']) ? $tennant_property['id'] : ""; ?>"
                                name="id" id="updateid">
                            <div class="container-fluid">
                                <div class="row clearfix">
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line focused">
                                                <input name="property_id" id="property_id" class="form-control"
                                                    value="<?php echo isset($property['name']) ? $property['name'] : ""; ?>">

                                                </input>
                                                <input type="hidden" name="property_id"
                                                    value="<?php echo isset($property['id']) ? $property['id'] : ""; ?>">
                                                <label class="form-label">Property Name<span
                                                        style="color: red;">*</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line focused">
                                                <select name="tennant_id" id="tennant_id" class="form-control" required
                                                    <?php echo $readonly; ?> <?php echo $view_disabled; ?>>
                                                    <option value="">Tenant Name</option>
                                                    <?php
                                                    foreach ($tennancies as $tennancy) {
                                                        ?>
                                                        <option value="<?php echo $tennancy['id']; ?>" <?php if (!empty($tennant_property['tennant_id'])) {
                                                               if ($tennant_property['tennant_id'] == $tennancy['id']) {
                                                                   echo "selected";
                                                               }
                                                           } ?>><?php echo $tennancy['name']; ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                                <label class="form-label">Tenant Name<span
                                                        style="color: red;">*</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="clear:both"></div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <div class="form-line focused">
                                                <input type="date" name="start_date" id="start_date"
                                                    class="form-control"
                                                    value="<?php echo isset($tennant_property['start_date']) ? $tennant_property['start_date'] : date('Y-m-d'); ?>"
                                                    required <?php echo $readonly; ?> <?php echo $view_readonly; ?>
                                                    max="<?php echo date('Y-m-d'); ?>">
                                                <label class="form-label">Start Date<span
                                                        style="color: red;">*</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <div class="form-line focused">
                                                <input type="date" name="end_date" id="end_date" class="form-control"
                                                    value="<?php echo isset($tennant_property['end_date']) ? $tennant_property['end_date'] : date('Y-m-d'); ?>"
                                                    required <?php echo $readonly; ?> <?php echo $view_readonly; ?>>
                                                <label class="form-label">End Date<span
                                                        style="color: red;">*</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <div class="form-line focused">
                                                <input type="month" name="due_start_month" id="due_start_month"
                                                    class="form-control"
                                                    value="<?php echo isset($tennant_property['due_start_month']) ? date('Y-m', strtotime($tennant_property['due_start_month'])) : date('Y-m'); ?>"
                                                    required <?php echo $readonly; ?> <?php echo $view_readonly; ?> min="<?php echo date('Y-m'); ?>">
                                                <label class="form-label">Rental Start Month<span
                                                        style="color: red;">*</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="clear:both"></div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line focused">
                                                <input type="number" min="0" name="deposit_amount" step="any"
                                                    id="deposit_amount" class="form-control"
                                                    value="<?php echo isset($tennant_property['deposit_amount']) ? $tennant_property['deposit_amount'] : ""; ?>"
                                                    required <?php echo $view_readonly; ?>>
                                                <label class="form-label">Deposit Amount<span
                                                        style="color: red;">*</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line focused">
                                                <input type="number" min="0" name="utility_deposit" step="any"
                                                    id="utility_deposit" class="form-control"
                                                    value="<?php echo isset($tennant_property['utility_deposit']) ? $tennant_property['utility_deposit'] : ""; ?>"
                                                    required <?php echo $view_readonly; ?>>
                                                <label class="form-label">Utility Deposit<span
                                                        style="color: red;">*</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    if ($view == true || $edit == true) {
                                        ?>
                                        <div style="clear:both"></div>
                                        <div class="col-sm-6">
                                            <div class="form-group form-float">
                                                <div class="form-line focused">
                                                    <select name="status" id="status" class="form-control" required <?php echo $view_disabled; ?>>
                                                        <option value="">select status</option>
                                                        <option value="1" <?php if ($tennant_property['status'] == 1) {
                                                            echo "selected";
                                                        } ?>>Active</option>
                                                        <option value="0" <?php if ($tennant_property['status'] == 0) {
                                                            echo "selected";
                                                        } ?>>Inactive</option>
                                                    </select>
                                                    <label class="form-label">Status<span
                                                            style="color: red;">*</span></label>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <?php
                                if ($view != true) {
                                    ?>
                                    <div class="row">
                                        <div class="col-sm-12" align="center"
                                            style="background-color: white;padding-bottom: 1%;">
                                            <button type="submit"
                                                class="btn btn-success btn-lg waves-effect">SUBMIT</button>
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
    $(document).ready(function () {
        $("#due_start_month").prop("readonly", true);
    });
    $('#form_validation').validate();
    $("#tennant_id").change(function () {
        $("#due_start_month").prop("readonly", false);
    });
    $("#start_date").change(function () {
        $("#due_start_month").prop("min", "");
        $("#due_start_month").val("");
        var date = $("#start_date").val();
        loadstartmonth(date);
    });
    function loadstartmonth(stdate) {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>/properties/loadstartmonth",
            data: { start_date: stdate },
            success: function (response) {
                $("#due_start_month").prop("min", response);
                $("#due_start_month").prop("readonly", false);
                $("#due_start_month").val(response);
            }
        });
    }
</script>

<script type="text/javascript">
    $("#document_upload").click(function () {
        var cnt = parseInt($("#pay_row_count").val());
        var html = '<tr id="rmv_payrow' + cnt + '">';
        html += '<td style="width: 20%;"><input type="date" style="border: none;" name="date[]"></td>';
        html += '<td style="width: 60%;"><input type="file" style="border: none;" name="file[]"></td>';
        html += '<td style="width: 20%;"><a class="btn btn-danger btn-rad" onclick="rmv_pay(' + cnt + ')" style="width:auto;"><i class="material-icons"></i></a></td>';
        html += '</tr>';
        $("#pay_table").append(html);
        var ct = parseInt(cnt + 1);
        $("#pay_row_count").val(ct);
    });
    function rmv_pay(id) {
        $("#rmv_payrow" + id).remove();
    }
    $("form").on("submit", function () {
        // $('input[type=submit]').prop('disabled', true);
        // $("#loader").show();
    });
</script>