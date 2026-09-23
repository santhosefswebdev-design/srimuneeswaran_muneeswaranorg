<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/vendors/typicons/typicons.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/vendors/css/vendor.bundle.base.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/css/vertical-layout-light/style.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/style.css">
<link rel="shortcut icon" href="<?php echo base_url(); ?>/assets/archanai/images/favicon.png" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
    body {
        height: 100vh;
        width: 100%;
    }

    .prod::-webkit-scrollbar {
        width: 3px;
    }

    .prod::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .prod::-webkit-scrollbar-thumb {
        background: #d4aa00;
    }

    .prod::-webkit-scrollbar-thumb:hover {
        background: #e91e63;
    }

    a {
        text-decoration: none !important;
    }

    .table tr th {
        border: 1px solid #f7e086;
        font-size: 14px;
        background: #f7ebbb;
        color: #333232;
    }

    .pack,
    .pay {
        margin-bottom: 15px;
    }

    .form-label {
        text-transform: uppercase;
        font-size: 13px;
        letter-spacing: 1px;
        color: #333333;
        text-align: left;
        width: 100%;
    }

    .input {
        width: 100%;
        text-align: left;
    }

    select.input {
        color: #000;
    }

    .sidebar-icon-only .sidebar .nav .nav-item .nav-link .menu-title {
        display: block !important;
        font-size: 11px;
        color: #FFFFFF;
    }

    .sidebar .nav .nav-item.active>.nav-link i.menu-icon {
        background: #edc10f;
        padding: 1px;
        list-style: outside;
        border-radius: 5px;
        box-shadow: 2px 5px 15px #00000017;
    }

    .sidebar-icon-only .sidebar .nav .nav-item .nav-link {
        display: block;
        padding-left: 0.25rem;
        padding-right: 0.25rem;
        text-align: center;
        position: static;
    }

    .sidebar-icon-only .sidebar .nav .nav-item .nav-link[aria-expanded] .menu-title {
        padding-top: 7px;
    }

    .sidebar-icon-only .main-panel {
        width: calc(100% - 0px);
    }

    .back {
        background: #00000087;
        padding: 15px;
        color: white;
        min-height: 120px;
    }

    .back h5 {
        min-height: 80px;
        font-size: 15px;
        font-weight: bold;
        color: #FFFFFF;
    }

    .greensubmit {
        background: #ab8a04 !important;
        font-weight: bold !important;
        color: #ffffff !important;
        box-shadow: -1px 10px 20px #ab8a04;
        background: #ab8a04 !important;
        background: -moz-linear-gradient(left, #ab8a04 0%, #ab8a04 80%, #ab8a04 100%) !important;
        background: -webkit-linear-gradient(left, #ab8a04 0%, #ab8a04 80%, #ab8a04 100%) !important;
        background: linear-gradient(to right, #ab8a04 0%, #ab8a04 80%, #ab8a04 100%) !important;
    }

    .ar_btn {
        background: linear-gradient(179deg, rgb(0 126 212) 0%, rgb(16 197 180) 35%, rgb(59 134 209) 100%);
        border-radius: 15px;
        font-weight: bold;
        height: 2.75em;
        margin: 10px;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;

        background-color: rgb(0, 0, 0);
        background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
        background-color: #fefefe;
        margin: 155px auto 20px auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-height: 60vh;
        overflow-y: auto;
    }

    .body-no-scroll {
        overflow: hidden;
        height: 100%;
    }


    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    .capitalize {
        text-transform: capitalize;
    }

    .card .header1 {
        color: #555;
        padding: 10px 20px;
        position: relative;
        border-bottom: 1px solid rgba(204, 204, 204, 0.35);
    }

    .card .body {
        font-size: 14px;
        color: #222222;
        padding: 20px;
    }

    .modal-backdrop.show {
        opacity: 0;
        z-index: -1;
    }

    @media (min-width: 576px) {
        .modal-dialog {
            max-width: 80%;
            margin: 1.75rem auto;
        }
    }
</style>

<body class="sidebar-icon-only">
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->

        <div class="container-fluid page-body-wrapper">

            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">

                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card">

                                <!-- Popup Modal -->
                                <div class="col-md-12">
                                    <h3 style="text-align: center">Prasadam Report</h3>
                                </div><br>

                                <div class="header1">
                                    <form action="<?php echo base_url(); ?>/report_online/print_prasadamreport"
                                        method="POST">
                                        <div class="container-fluid">
                                            <div class="row clearfix">
                                                <div class="col-md-2 col-sm-4">
                                                    <div class="form-group form-float">
                                                        <div class="form-line" id="bs_datepicker_container">
                                                            <input type="date" name="fdt" id="fdt" class="form-control"
                                                                value="<?php echo $from_date; ?>">
                                                            <label class="form-label"><?php echo $lang->from; ?></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 col-sm-4">
                                                    <div class="form-group form-float">
                                                        <div class="form-line" id="bs_datepicker_container">
                                                            <input type="date" name="tdt" id="tdt" class="form-control"
                                                                value="<?php echo $to_date; ?>">
                                                            <label class="form-label"><?php echo $lang->to; ?></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- <div class="col-md-2 col-sm-4">
                                            <div class="form-group form-float">
                                                <div class="form-line" id="bs_datepicker_container">
                                                    <label class="form-label" for="cdt">Collection Date</label>
                                                    <input type="date" name="cdt" id="cdt" class="form-control" value="" >
                                                </div>                                                        
                                            </div>                                            
                                        </div> -->
                                                <div class="col-md-2 col-sm-4">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <select class="form-control" name="group_filter"
                                                                id="group_filter">
                                                                <option value="0">Both Groups</option>
                                                                <?php
                                                                if (count($prasadam_groups) > 0) {
                                                                    foreach ($prasadam_groups as $row) {
                                                                        ?>
                                                                        <option value="<?php echo $row['id']; ?>">
                                                                            <?php echo $row['group_name']; ?></option>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                            <label class="form-label"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 col-sm-4">
                                                    <div class="form-group form-float">
                                                        <label type="submit" class="btn btn-success btn-lg waves-effect"
                                                            id="submit">Submit</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-12" style="margin:0px;">
                                                    <button type="submit" class="btn btn-primary btn-lg waves-effect"
                                                        id="submit">Print</button>
                                                    <input name="pdf_prasadamreport" type="submit"
                                                        class="btn btn-danger btn-lg waves-effect"
                                                        id="pdf_prasadamreport" value="PDF">
                                                    <input name="excel_prasadamreport" type="submit"
                                                        class="btn btn-success btn-lg waves-effect"
                                                        id="excel_prasadamreport" value="EXCEL">
                                                </div>

                                            </div>
                                        </div>
                                </div>
                                </form>

                                <div class="body">
                                    <div class="table-responsive col-md-12 det" align="center"
                                        style="background:#FFF; float:none;">
                                        <table style="width:100%;" align="center" class="table table-striped dataTable"
                                            id="datatables">
                                            <thead>
                                                <tr>
                                                    <th style="width:5%;">S.No</th>
                                                    <th style="width:8%;">Date</th>
                                                    <th style="width:8%;">Ref No</th>
                                                    <th style="width:8%;">Booking type</th>
                                                    <th style="width:8%;">Devotee Name</th>
                                                    <th style="width:8%;">Mobile Number</th>
                                                    <th style="width:8%;">Prasadam Type</th>
                                                    <th style="width:10%;text-align:left;">Items</th>
                                                    <th style="width:7%;">Payment Status</th>
                                                    <th style="width:8%;">Payment Mode</th>
                                                    <th style="width:8%;">Amount</th>
                                                    <th style="width:8%;">Paid Amount</th>
                                                    <th style="width:7%;">Print</th>
                                                    <th style="width:8%;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>

                                        </table>
                                    </div>
                                </div>

                                <div class="modal fade" id="alert-modal_payment" tabindex="-1" role="dialog"
                                    aria-labelledby="repaymentModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" style="text-align: center;"
                                                    id="repaymentModalLabel">Prasadam Repayment</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <table>
                                                <tr>
                                                    <td><b>Total Amount (RM): <span id="totalAmount"></span></b></td>
                                                    <td><b>Paid Amount (RM): <span id="paidAmount"></span></b></td>
                                                    <td><b>Balance Amount (RM): <span id="balAmount"></span></b></td>
                                                </tr>
                                            </table>
                                            <div class="modal-body">
                                                <form id="repaymentForm">
                                                    <div class="form-group">
                                                        <label for="repaymentDate">Date</label>
                                                        <input type="date" class="form-control" id="repaymentDate"
                                                            name="date" value="<?php echo date('Y-m-d'); ?>" required>
                                                    </div>
                                                    <div class="form-group form-float">
                                                        <label for="payAmount">Amount</label>
                                                        <input type="number" id="payAmount" min="0" class="form-control"
                                                            step=".01" placeholder="0.00" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="paymentMode">Payment Mode</label>
                                                        <select class="form-control" id="paymentMode"
                                                            name="payment_mode" required>
                                                            <?php foreach ($payment_modes as $payment_mode) { ?>
                                                                <option value="<?php echo $payment_mode['id']; ?>">
                                                                    <?php echo $payment_mode['name']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <input type="hidden" id="bookingId" name="booking_id">
                                                    <a href="#" id="del" class="btn btn-danger my-3"
                                                        data-dismiss="modal">Cancel</a>
                                                    <button type="button" class="btn btn-primary"
                                                        id="saveRepayment">Save</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="alert-modal1" class="modal fade" tabindex="-1" role="dialog"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content" style="width: 32%;">
                                            <div class="modal-body p-4">
                                                <div class="text-center">
                                                    <i class="dripicons-information h1 text-info"></i>
                                                    <table>
                                                        <tr><span
                                                                id="spndeddelid"><b></b></span>&nbsp;&nbsp;&nbsp;<button
                                                                type="button" class="btn btn-info my-3"
                                                                data-dismiss="modal"> &times;</button></tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div>
                                </div>

                                <div class="modal" id="alert_modal_paymode" tabindex="-1" role="dialog"
                                    aria-labelledby="paymentchangeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" style="text-align: center;"
                                                    id="repaymentModalLabel">Change Payment Mode</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="repaymentForm">
                                                    <!-- <input type="hidden" id="paymentMethod" class="form-control" readonly>
                                                <input type="hidden" id="amount" class="form-control" readonly> -->
                                                    <div class="form-group">
                                                        <label for="repaymentDate">Date</label>
                                                        <input type="date" class="form-control" id="repaymentDate"
                                                            name="date" value="<?php echo date('Y-m-d'); ?>" readonly
                                                            required>
                                                    </div>
                                                    <div class="form-group form-float">
                                                        <label for="oldPaymentMethod">Old Payment Method</label>
                                                        <input type="text" id="oldPaymentMethod" class="form-control"
                                                            readonly>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="new_paymentMode">New Payment Mode</label>
                                                        <select class="form-control" id="new_paymentMode"
                                                            name="new_payment_mode" required>
                                                            <?php foreach ($payment_modes as $payment_mode) { ?>
                                                                <option value="<?php echo $payment_mode['id']; ?>">
                                                                    <?php echo $payment_mode['name']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <input type="hidden" id="pay_bookingid" name="pay_bookingid">
                                                    <a href="#" id="del" class="btn btn-danger my-3"
                                                        data-dismiss="modal">Cancel</a>
                                                    <button type="button" class="btn btn-primary"
                                                        id="savePaymodechange">Save</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </div>
        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
    </div>

    <script src="<?php echo base_url(); ?>/assets/archanai/js/jquery.min.js"></script>
    <!-- base:js -->
    <script src="<?php echo base_url(); ?>/assets/archanai/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page-->
    <script src="<?php echo base_url(); ?>/assets/archanai/vendors/chart.js/Chart.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/archanai/js/jquery.cookie.js" type="text/javascript"></script>
    <!-- End plugin js for this page-->
    <!-- inject:js -->
    <script src="<?php echo base_url(); ?>/assets/archanai/js/off-canvas.js"></script>
    <script src="<?php echo base_url(); ?>/assets/archanai/js/hoverable-collapse.js"></script>
    <script src="<?php echo base_url(); ?>/assets/archanai/js/template.js"></script>
    <script src="<?php echo base_url(); ?>/assets/archanai/js/settings.js"></script>
    <script src="<?php echo base_url(); ?>/assets/archanai/js/todolist.js"></script>
    <!-- Custom js for this page-->
    <script src="<?php echo base_url(); ?>/assets/archanai/js/dashboard.js"></script>



    <!--script src='https://code.jquery.com/jquery-2.2.4.min.js'></script-->
    <script src="<?php echo base_url(); ?>/assets/archanai/script.js"></script>

    <link
        href="https://panel.srimuneeswaran.org/dev/assets/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css"
        rel="stylesheet">

    <!-- Jquery DataTable Plugin Js -->
    <script src="https://panel.srimuneeswaran.org/dev/assets/plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script
        src="https://panel.srimuneeswaran.org/dev/assets/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <script
        src="https://panel.srimuneeswaran.org/dev/assets/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
    <script
        src="https://panel.srimuneeswaran.org/dev/assets/plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
    <script
        src="https://panel.srimuneeswaran.org/dev/assets/plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
    <script
        src="https://panel.srimuneeswaran.org/dev/assets/plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
    <script
        src="https://panel.srimuneeswaran.org/dev/assets/plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
    <script
        src="https://panel.srimuneeswaran.org/dev/assets/plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
    <script
        src="https://panel.srimuneeswaran.org/dev/assets/plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>

    <!-- Custom Js -->
    <!-- <script src="https://panel.srimuneeswaran.org/dev/assets/js/pages/tables/jquery-datatable.js"></script> -->

    <!-- <script>
    $(document).ready(function(){        
        report = $('#datatables').DataTable({
            dom: 'Bfrtip',
            buttons: [],
            paging: false,
            "ajax":{
                url: "<?php echo base_url(); ?>/report_online/prasadam_rep_ref",
                dataType: "json",
                type: "POST",
                data: function ( data ) {
                    data.fdt = $('#fdt').val();
                    data.tdt = $('#tdt').val();
                    data.group_filter = $('#group_filter').val();
                    }
            },
        });

        $('#submit').click(function() {
            report.ajax.reload();
        });

    });
</script>

<script>
    $(document).ready(function(){
        $(".btn-payment").click(function(e){
            e.preventDefault();
            var bookingId = $(this).attr('href').split('/').pop();

            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>/prasadam_online/gtpaymentdata",
                data: {
                    id: bookingId
                },
                success: function(response){
                    console.log(response);
                    var obj = JSON.parse(response);
                    var totalAmount = formatAmount(obj.amt);
                    var paidAmount = formatAmount(obj.paid_amount);
                    var balAmount = formatAmount(obj.amt - obj.paid_amount);
                    
                    $("#bookingId").val(bookingId);
                    $("#totalAmount").text(totalAmount);
                    $("#paidAmount").text(paidAmount);
                    $("#balAmount").text(balAmount);
                
                    $("#alert-modal_payment").modal('show');
                    // $(".modal-backdrop").remove();
                    
                    
                },
                error: function(){
                    $("#spndeddelid").css("color", "red").text('Error while fetching repayment data.');
                }
            });
            
        });

        function formatAmount(amount){
            amount = parseFloat(amount);
            return isNaN(amount) ? '0.00' : amount.toFixed(2);
        }

        $("#saveRepayment").click(function(){
            var date = $("#repaymentDate").val();
            var payAmount = parseFloat($("#payAmount").val());
            var paymentMode = $("#paymentMode").val();
            var bookingId = $("#bookingId").val();
            var balAmount = parseFloat($("#balAmount").text());

            if (payAmount > balAmount) {
                $("#alert-modal_payment").modal('hide');
                $('#alert-modal1').modal('show', { backdrop: 'static' });
                $("#spndeddelid").css("color", "red").text('Pay amount cannot be greater than balance amount.');
                return;
            }

            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>/prasadam_online/save_repayment", 
                data: {
                    date: date,
                    pay_amount: payAmount,
                    payment_mode: paymentMode,
                    booking_id: bookingId
                },
                success: function(response){
                    var obj = JSON.parse(response);
                    if(obj.status){
                        $("#payAmount").val("");
                        $("#alert-modal_payment").modal('hide');
                        $("#spndeddelid").css("color", "green").text(obj.message);
                        $('#alert-modal1').modal('show', { backdrop: 'static' });
                        $("#spndeddelid").css("color", "green");

                        setTimeout(function(){
                            location.reload(); // Reloads the page
                        }, 2000);
                        
                    } else {
                        $("#spndeddelid").css("color", "red").text(obj.message);
                    }
                },
                error: function(){
                    $("#spndeddelid").css("color", "red").text('Error while saving repayment.');
                }
            });
        });
    });

    function confirm_modal(id)
    {
        $('#alert-modal').modal('show', {backdrop: 'static'});
        document.getElementById('del').setAttribute('onclick' , 'Del('+id+')');
        $("#spndelid").text("Are you sure to Delete "+$("#pay"+id).attr("data-id") + " prasadam?" );    
    }    
    function Del(id)
    {
        var act = "<?php echo base_url(); ?>/prasadam/delete/"+id;
        $( "#delete-form" ).append( "<form action='"+act+"'><button type='submit' id='delete"+id+"'>submit</button></form>");
        $( "#delete"+id).trigger( "click" );
    }

    $('.btn-cancel').click(function(e) {
        e.preventDefault(); // Prevent default action

        var bookingId = $(this).attr('href').split('/').pop();

        if (confirm('Are you sure you want to cancel this booking?')) {
            // If "Yes" is clicked, send an AJAX request to update the booking status
            $.ajax({
                url: "<?php echo base_url(); ?>/templeubayam/update_booking_status", 
                type: 'POST',
                data: {
                    id: bookingId,
                    status: 3
                },
                success: function(response) {
                    var res = JSON.parse(response);
                    if(res.success) {
                        $('#alert-modal').modal('show', { backdrop: 'static' });
                       $("#spndeddelid").css("color", "green").text('Successfully cancelled. Thank you.');
                    } else {
                        $('#alert-modal').modal('show', { backdrop: 'static' });
                       $("#spndeddelid").css("color", "red").text('Error while updating booking status.');
                    }
                },
                error: function() {
                    alert('An error occurred. Please try again.');
                }
            });
        }
    });

    $(document).on("click", ".btn-paychange", function(e) {
        e.preventDefault(); 
        //var bookingId = $(this).data('booking-id');  // Get the booking ID from the data attribute
        var bookingId = $(this).attr('href').split('/').pop();
        console.log("paychange clicked");
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>/report_online/get_prasadam_payment_mode",
            data: {
                id: bookingId
            },
            success: function(response) {
                console.log('return:', response);
                var obj = JSON.parse(response);
                var paymentMethod = obj.pay_method;
                var paymentMode = obj.payment_mode;

                $("#pay_bookingid").val(bookingId);
                $("#oldPaymentMethod").val(paymentMethod); 
                $("#alert_modal_paymode").modal('show');
            },
            error: function() {
                $("#spndeddelid").css("color", "red").text('Error while fetching payment data.');
            }
        });
    });

    $(document).on("click", "#savePaymodechange", function() {
        console.log("save button clicked");
        var paymentMode = $("#new_paymentMode").val();
        var bookingId = $("#pay_bookingid").val();

        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>/report_online/save_prasadam_payment_mode", 
            data: {
                payment_mode: paymentMode,
                booking_id: bookingId,
            },
            dataType: "json", 
            success: function(response){
                console.log("Response:", response);

                var obj = (typeof response === "string") ? JSON.parse(response) : response;

                if (obj.status) {
                    $("#payAmount").val("");
                    $("#alert_modal_paymode").modal('hide');
                    $("#spndeddelid").css("color", "green").text(obj.message);
                    $('#alert-modal1').modal('show', { backdrop: 'static' });

                    setTimeout(function() {
                        $('#alert-modal1').modal('hide');  // Optionally hide the modal before reloading
                        window.location.reload();  // Reload the current page
                    }, 2000);

                } else {
                    $("#spndeddelid").css("color", "red").text(obj.message);
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error);
                $("#spndeddelid").css("color", "red").text('Error while saving repayment. Please try again.');
            }
        });
    });
</script> -->
    <!-- Custom Js -->
    <script src="https://panel.srimuneeswaran.org/dev/assets/js/pages/tables/jquery-datatable.js"></script>

    <script>
        $(document).ready(function () {
            report = $('#datatables').DataTable({
                dom: 'Bfrtip',
                buttons: [],
                paging: false,
                "ajax": {
                    url: "<?php echo base_url(); ?>/report_online/prasadam_rep_ref",
                    dataType: "json",
                    type: "POST",
                    data: function (data) {
                        data.fdt = $('#fdt').val();
                        data.tdt = $('#tdt').val();
                        data.group_filter = $('#group_filter').val();
                    }
                },
            });

            $('#submit').click(function (e) {
                e.preventDefault();
                report.ajax.reload();
            });
        });
    </script>

    <script>
        $(document).ready(function () {

            // Format amount helper function
            function formatAmount(amount) {
                amount = parseFloat(amount);
                return isNaN(amount) ? '0.00' : amount.toFixed(2);
            }

            // REPAYMENT MODAL - Handle btn-payment click
            $(document).on("click", ".btn-payment", function (e) {
                e.preventDefault();

                var bookingId = $(this).data('id');
                if (!bookingId) {
                    var href = $(this).attr('href');
                    if (href && href !== 'javascript:void(0)') {
                        bookingId = href.split('/').pop();
                    }
                }

                if (!bookingId) {
                    console.error('No booking ID found');
                    $('#alert-modal1').modal('show');
                    $("#spndeddelid").css("color", "red").text('Error: Booking ID not found.');
                    return;
                }

                console.log('Fetching repayment data for booking ID:', bookingId);

                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>/prasadam_online/gtpaymentdata",
                    data: { id: bookingId },
                    success: function (response) {
                        console.log('Response:', response);
                        var obj = JSON.parse(response);
                        var totalAmount = formatAmount(obj.amt);
                        var paidAmount = formatAmount(obj.paid_amount);
                        var balAmount = formatAmount(obj.bal_amount);

                        $("#bookingId").val(bookingId);
                        $("#totalAmount").text(totalAmount);
                        $("#paidAmount").text(paidAmount);
                        $("#balAmount").text(balAmount);

                        $("#alert-modal_payment").modal('show');
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                        $('#alert-modal1').modal('show');
                        $("#spndeddelid").css("color", "red").text('Error while fetching repayment data.');
                    }
                });
            });

            // SAVE REPAYMENT
            $("#saveRepayment").click(function () {
                var date = $("#repaymentDate").val();
                var payAmount = parseFloat($("#payAmount").val());
                var paymentMode = $("#paymentMode").val();
                var bookingId = $("#bookingId").val();
                var balAmount = parseFloat($("#balAmount").text());

                if (!date || !payAmount || !paymentMode) {
                    $('#alert-modal1').modal('show');
                    $("#spndeddelid").css("color", "red").text('Please fill all required fields.');
                    return;
                }

                if (payAmount <= 0) {
                    $('#alert-modal1').modal('show');
                    $("#spndeddelid").css("color", "red").text('Payment amount must be greater than zero.');
                    return;
                }

                if (payAmount > balAmount) {
                    $("#alert-modal_payment").modal('hide');
                    $('#alert-modal1').modal('show');
                    $("#spndeddelid").css("color", "red").text('Pay amount cannot be greater than balance amount.');
                    return;
                }

                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>/prasadam_online/save_repayment",
                    data: {
                        date: date,
                        pay_amount: payAmount,
                        payment_mode: paymentMode,
                        booking_id: bookingId
                    },
                    success: function (response) {
                        console.log('Save response:', response);
                        var obj = JSON.parse(response);

                        if (obj.status) {
                            $("#payAmount").val("");
                            $("#alert-modal_payment").modal('hide');
                            $('#alert-modal1').modal('show');
                            $("#spndeddelid").css("color", "green").text(obj.message);

                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        } else {
                            $("#alert-modal_payment").modal('hide');
                            $('#alert-modal1').modal('show');
                            $("#spndeddelid").css("color", "red").text(obj.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Save Error:', status, error);
                        $("#alert-modal_payment").modal('hide');
                        $('#alert-modal1').modal('show');
                        $("#spndeddelid").css("color", "red").text('Error while saving repayment.');
                    }
                });
            });

            // PAYMENT MODE CHANGE MODAL
            $(document).on("click", ".btn-paychange", function (e) {
                e.preventDefault();

                var bookingId = $(this).data('booking-id');
                if (!bookingId) {
                    var href = $(this).attr('href');
                    if (href && href !== 'javascript:void(0)') {
                        bookingId = href.split('/').pop();
                    }
                }

                if (!bookingId) {
                    console.error('No booking ID found');
                    $('#alert-modal1').modal('show');
                    $("#spndeddelid").css("color", "red").text('Error: Booking ID not found.');
                    return;
                }

                console.log("Fetching payment mode for booking ID:", bookingId);

                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>/report_online/get_prasadam_payment_mode",
                    data: { id: bookingId },
                    success: function (response) {
                        console.log('Payment mode response:', response);
                        var obj = JSON.parse(response);
                        var paymentMethod = obj.pay_method;
                        var currentPaymentMode = obj.payment_mode;

                        $("#pay_bookingid").val(bookingId);
                        $("#oldPaymentMethod").val(paymentMethod);

                        if (currentPaymentMode) {
                            $("#new_paymentMode").val(currentPaymentMode);
                        }

                        $("#alert_modal_paymode").modal('show');
                    },
                    error: function (xhr, status, error) {
                        console.error('Fetch Error:', status, error);
                        $('#alert-modal1').modal('show');
                        $("#spndeddelid").css("color", "red").text('Error while fetching payment data.');
                    }
                });
            });

            // SAVE PAYMENT MODE CHANGE
            $(document).on("click", "#savePaymodechange", function () {
                console.log("Save payment mode change clicked");

                var paymentMode = $("#new_paymentMode").val();
                var bookingId = $("#pay_bookingid").val();
                var oldPaymentMethod = $("#oldPaymentMethod").val();

                if (!paymentMode || !bookingId) {
                    $('#alert-modal1').modal('show');
                    $("#spndeddelid").css("color", "red").text('Please select a payment mode.');
                    return;
                }

                var selectedText = $("#new_paymentMode option:selected").text();
                if (selectedText.toLowerCase() === oldPaymentMethod.toLowerCase()) {
                    $('#alert-modal1').modal('show');
                    $("#spndeddelid").css("color", "red").text('Please select a different payment mode.');
                    return;
                }

                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>/report_online/save_prasadam_payment_mode",
                    data: {
                        payment_mode: paymentMode,
                        booking_id: bookingId,
                    },
                    dataType: "json",
                    success: function (response) {
                        console.log("Save response:", response);
                        var obj = (typeof response === "string") ? JSON.parse(response) : response;

                        if (obj.status) {
                            $("#alert_modal_paymode").modal('hide');
                            $('#alert-modal1').modal('show');
                            $("#spndeddelid").css("color", "green").text(obj.message);

                            setTimeout(function () {
                                window.location.reload();
                            }, 2000);
                        } else {
                            $("#alert_modal_paymode").modal('hide');
                            $('#alert-modal1').modal('show');
                            $("#spndeddelid").css("color", "red").text(obj.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX Error:", status, error);
                        $("#alert_modal_paymode").modal('hide');
                        $('#alert-modal1').modal('show');
                        $("#spndeddelid").css("color", "red").text('Error while saving payment mode. Please try again.');
                    }
                });
            });

            // BOOKING CANCELLATION
            $(document).on('click', '.btn-cancel', function (e) {
                e.preventDefault();

                var bookingId = $(this).data('id');
                if (!bookingId) {
                    var href = $(this).attr('href');
                    if (href && href !== 'javascript:void(0)') {
                        bookingId = href.split('/').pop();
                    }
                }

                if (confirm('Are you sure you want to cancel this booking?')) {
                    $.ajax({
                        url: "<?php echo base_url(); ?>/templeubayam/update_booking_status",
                        type: 'POST',
                        data: {
                            id: bookingId,
                            status: 3
                        },
                        success: function (response) {
                            var res = JSON.parse(response);
                            if (res.success) {
                                $('#alert-modal1').modal('show');
                                $("#spndeddelid").css("color", "green").text('Successfully cancelled. Thank you.');

                                setTimeout(function () {
                                    location.reload();
                                }, 2000);
                            } else {
                                $('#alert-modal1').modal('show');
                                $("#spndeddelid").css("color", "red").text('Error while updating booking status.');
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error('Cancel Error:', status, error);
                            $('#alert-modal1').modal('show');
                            $("#spndeddelid").css("color", "red").text('An error occurred. Please try again.');
                        }
                    });
                }
            });

        });

        // DELETE CONFIRMATION (if needed)
        function confirm_modal(id) {
            $('#alert-modal').modal('show', { backdrop: 'static' });
            document.getElementById('del').setAttribute('onclick', 'Del(' + id + ')');
            $("#spndelid").text("Are you sure to Delete " + $("#pay" + id).attr("data-id") + " prasadam?");
        }

        function Del(id) {
            var act = "<?php echo base_url(); ?>/prasadam/delete/" + id;
            $("#delete-form").append("<form action='" + act + "'><button type='submit' id='delete" + id + "'>submit</button></form>");
            $("#delete" + id).trigger("click");
        }
    </script>

</body>