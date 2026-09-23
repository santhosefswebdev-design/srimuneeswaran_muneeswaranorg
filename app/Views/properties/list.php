<?php global $lang; ?>
<?php $db = db_connect(); ?>
<!-- Bootstrap CSS CDN -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    integrity="sha384-JcKb8q3pVutmAdZrJ7Sk7wYoVmG+R8HbA6Mo2aLvPAwl6iUyAAXc8JbckojeVX/X" crossorigin="anonymous">
<style>
    .custom-tab {
        background-color: #4a81d4;
        /* Replace with your desired color */
    }

    .custom-tab.active {
        background-color: #ff0000;
        /* Color for active tab, replace with your desired color */
    }

    .custom-tab .nav-link {
        color: #ffffff !important;
        /* Forces the text color to white */
    }

    .custom-tab .nav-link:hover {
        color: #dddddd !important;
        /* Forces the hover color to a lighter shade of white */
    }


    .listnav {
        display: flex;
        flex-direction: row;
        justify-content: center;
        color: white;
    }

    .nav-tabs>li>a {
        border: none !important;
        color: #fff !important;
        -webkit-border-radius: 0;
        -moz-border-radius: 0;
        -ms-border-radius: 0;
        border-radius: 0;
    }
</style>
<section class="content">
    <div class="container-fluid " style="margin-top:70px;">
        <div class="block-header">
            <h2><?php echo $lang->properties; ?><small><?php echo $lang->properties; ?> /
                    <b><?php echo $lang->list; ?></b></small></h2>
            <ul class="listnav nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active custom-tab" href="<?php echo base_url(); ?>/properties">Properties</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  custom-tab " href="<?php echo base_url(); ?>/tennant">Tennancy Details</a>
                </li>
              
                <li class="nav-item">
                    <a class="nav-link custom-tab"
                        href="<?php echo base_url(); ?>/properties/property_collection_report">Property Collection
                        Reports</a>
                </li>
            </ul>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row">
                            <div class="col-md-8">
                                <!-- Tabs -->

                            </div>
                            <div class="col-md-4" align="right">

                                <a href="<?php echo base_url(); ?>/properties/add"><button type="button"
                                        class="btn bg-deep-purple waves-effect"><?php echo $lang->add; ?></button></a>
                            </div>
                        </div>
                    </div>
                    <div class="body">
                        <?php if ($_SESSION['succ'] != '') { ?>
                            <div class="row" style="padding: 0 30%;" id="content_alert">
                                <div class="suc-alert">
                                    <span class="suc-closebtn"
                                        onclick="this.parentElement.style.display='none';">&times;</span>
                                    <p><?php echo $_SESSION['succ']; ?></p>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($_SESSION['fail'] != '') { ?>
                            <div class="row" style="padding: 0 30%;" id="content_alert">
                                <div class="alert">
                                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                                    <p><?php echo $_SESSION['fail']; ?></p>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="table-responsive col-md-12 det" style="background:#FFF; float:none;">
                            <table class="table table-bordered table-striped table-hover dataTable" id="datatables">
                                <thead>
                                    <tr>
                                        <th><?php echo $lang->no; ?>.</th>
                                        <th><?php echo $lang->property; ?> <?php echo $lang->name; ?></th>
                                        <th><?php echo $lang->property; ?> <?php echo $lang->type; ?></th>
                                        

                                        <th><?php echo $lang->rental; ?> <?php echo $lang->value; ?></th>
                                        <th>Tennant Name</th>
                                        <th>Due Months<br> Count</th>
                                        <th><?php echo $lang->action; ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($properties as $property) { ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo $property['name']; ?></td>
                                            <td>
                                                <?php
                                                $property_category_name = $db->table('property_category')->where('id', $property['property_category_id'])->get()->getRowArray();
                                                echo $property_category_name['name'];
                                                ?>
                                            </td>
                                          
                                            <td><?php echo $property['rental_value']; ?></td>
                                            <td>
                                            <?php
                                                // Check the property_status and display the appropriate icon
                                                if ($property['property_status'] == 1): ?>
                                                    
                                                    <?php
                                                
                                                $rent = $db->table('tennant_property')->where('property_id', $property['id'])->get()->getRowArray();
                                                $res= $db->table('tennant')->where('id', $rent['tennant_id'])->get()->getRowArray();
                                                echo $res['name'];
                                                ?>
                                                <?php elseif ($property['property_status'] == 3): ?>
                                                    <p>-</p>
                                                <?php endif; ?>
                                                
                                               
                                            </td>
                                            <td>
                                                <?php 
                                                 
                                                 $rent = $db->table('tennant_property')->where('property_id', $property['id'])->get()->getRowArray();
                                                 $ten_prop_id=$rent['id'];
                                                 $prop_id=$property['id'];
                                                $count =  getpropertyduemonthcount($ten_prop_id,$prop_id);

                                               echo $count['unpaid_count'];
                                                ?>
                                            </td>
                                            <td>
                                                <a class="btn btn-primary btn-rad" title="Edit"
                                                    href="<?php echo base_url(); ?>/properties/edit/<?php echo $property['id']; ?>"><i
                                                        class="material-icons">&#xE3C9;</i></a> &nbsp;
                                                <a class="btn btn-success btn-rad" title="View"
                                                    href="<?php echo base_url(); ?>/properties/view/<?php echo $property['id']; ?>"><i
                                                        class="material-icons">&#xE417;</i></a> &nbsp;
                                                <a class="btn btn-danger btn-rad" title="Delete"
                                                    onclick="confirm_modal(<?php echo $property['id']; ?>)"><i
                                                        class="material-icons">&#xE872;</i></a> &nbsp;

                                                <?php
                                                // Check the property_status and display the appropriate icon
                                                if ($property['property_status'] == 1): ?>
                                                    <!-- Display pay icon for properties available for rent -->
                                                    <a class="btn btn-success btn-rad" title="Pay"
                                                        href="<?php echo base_url(); ?>/rental/add/<?php echo $property['id']; ?>"><i
                                                            class="material-icons">attach_money</i></a>
                                                <?php elseif ($property['property_status'] == 3): ?>
                                                    <!-- Display add icon for properties available for sale -->
                                                    <a class="btn btn-info btn-rad" title="Assign"
                                                        href="<?php echo base_url(); ?>/properties/add_assign_property/<?php echo $property['id']; ?>"><i
                                                            class="material-icons">add_home</i></a>
                                                <?php endif; ?>
                                                <a class="btn btn-warning btn-rad" title="Report"
                                                    href="<?php echo base_url(); ?>/properties/show_property_history/<?php echo $property['id']; ?>"><i
                                                        class="material-icons">summarize</i></a>
                                                <?php
                                                $default_rental_current_month = get_default_rental_current_month($ten_prop_id);
                                                if(count($default_rental_current_month) > 0){
                                                    $temple_name = $_SESSION['site_title'];
                                                    $tennant_name = $default_rental_current_month[0]['tennant_name'];
                                                    $property_address = $default_rental_current_month[0]['property_name'];
                                                    $rental_amount = $default_rental_current_month[0]['amount'];
                                                    $due_month = $default_rental_current_month[0]['due_month'];
                                                    $whatsapp_msg = <<<PRITHIVI
                                                    Dear $tennant_name,
                                                    This is a friendly reminder that your rent payment for the month of $due_month.
                                                    Here are the details for your reference:
                                                    Rental Property: $property_address
                                                    Rental Amount: $rental_amount
                                                    We kindly request that you submit your payment on or before the due date to avoid any late fees or disruptions to your tenancy.
                                                    If you have already made the payment, we sincerely thank you for your promptness. Your cooperation in this matter is greatly appreciated, and it contributes to the smooth operation of the property.
                                                    Thank you for being a valued tenant.

                                                    Best regards,
                                                    $temple_name
                                                    PRITHIVI;
                                                    $whatsapp_url = 'https://wa.me/' . $default_rental_current_month[0]['phone_no'] . '?text=' . urlencode($whatsapp_msg);
                                                ?>
                                                <a href="<?php echo $whatsapp_url; ?>" target="_blank" title="Rental Default" class="text-success"><img src="<?php echo base_url(); ?>/assets/images/whatsapp.png" style="width:25px;"></a>
                                                <?php
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php } ?>


                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div id="alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body p-4">
                        <div class="text-center">
                            <i class="dripicons-information h1 text-info"></i>
                            <h4 class="mt-2"><?php echo $lang->delete; ?> <?php echo $lang->property; ?></h4>
                            <table>

                                <tr><span id="spndeddelid"><b></b></span></tr>
                            </table>

                            <a href="#" id="del" class="btn btn-danger my-3"
                                data-dismiss="modal"><?php echo $lang->yes; ?></a> &nbsp;
                            <button type="button" class="btn btn-info my-3"
                                data-dismiss="modal"><?php echo $lang->no; ?></button>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div>
        </div>
        <div id="del-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body p-4">
                        <div class="text-center">
                            <i class="dripicons-information h1 text-info"></i>
                            <table>
                                <tr><span id="delmol"><b></b></span>&nbsp;&nbsp;&nbsp;<button type="button"
                                        class="btn btn-info my-3" data-dismiss="modal"> &times;</button></tr>
                            </table>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div>
        </div>
        <!--Delete Form-->
        <div id=delete-form>

        </div>
        <!--End Delete Form-->

</section>
<script>
    $("document").ready(function () {
        $("#datatables").dataTable({
            "searching": true
        });
        var table = $('#datatables').DataTable();
        // Apply the filter
        $("#categoryFilter").on('keyup change', function () {
            table
                .column(1)
                .search(this.value)
                .draw();
        });
    });

    function confirm_modal(id) {
        //alert(id)
        $.ajax({
            url: "<?php echo base_url(); ?>/properties/del_property_check",
            type: "post",
            data: { id: id },
            success: function (data) {
                if (data == 0) {
                    $('#alert-modal').modal('show', { backdrop: 'static' });
                    document.getElementById('del').setAttribute('onclick', 'dedDel(' + id + ')');
                    $("#spndeddelid").text("Are You Sure You Want To Delete This?");
                } else {
                    //alert(id)
                    $('#del-modal').modal('show', { backdrop: 'static' });
                    $("#delmol").text("We used for this Property, So cant delete this Property");
                }
            }
        });
    }

    function dedDel(id) {
        var act = "<?php echo base_url(); ?>/properties/delete_property/" + id;
        $("#delete-form").append("<form action='" + act + "'><button type='submit' id='delete" + id + "' >submit</button></form>");
        $("#delete" + id).trigger("click");
    }

</script>
<!-- Bootstrap JS, Popper.js, and jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.5.2/dist/umd/popper.min.js"
    integrity="sha384-CIwgDFiPj48o2795wq8Uw7nZ9JGiISWl5KLvS07YmNbAMsF4El+oiThO4NPVZJ4N"
    crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
    integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8sh+PQ4C4Vp9Bt5rMJ6KL2zTvIZsCn9DKjl84S"
    crossorigin="anonymous"></script>