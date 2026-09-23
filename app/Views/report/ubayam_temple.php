<?php global $lang; ?>
<?php $booking_calendar_range_year = booking_calendar_range_year($_SESSION['booking_range_year']); ?>
<style>
    .btn-default,
    .btn-default:hover,
    .btn-default:active,
    .btn-default:focus {
        background: transparent !important;
    }

    .form-group {
        margin-bottom: 0 !important;
    }

    .col-sm-3 {
        margin-bottom: 10px !important;
    }

    .table tr th,
    .table tr td {
        text-align: center;
    }

    .paid_text {
        color: green;
        font-weight: 600;
    }

    .unpaid_text {
        color: orange;
        font-weight: 600;
    }

    .cancel_text {
        color: red;
        font-weight: 600;
    }

    /* Edit Modal Styles */
    .modal-backdrop {
        z-index: 1040;
    }

    #editBookingModal .modal-dialog {
        z-index: 1050;
    }

    #editBookingModal .modal-header {
        background: #2196F3;
        color: #fff;
    }

    #editBookingModal .modal-header .close {
        color: #fff;
        opacity: 1;
    }

    #editBookingModal .form-label-custom {
        font-weight: 600;
        margin-bottom: 5px;
        display: block;
    }

    #editBookingModal .date-error {
        color: red;
        font-size: 12px;
        display: none;
        margin-top: 3px;
    }

    #editBookingModal .date-booked {
        background-color: #ffcccc !important;
        cursor: not-allowed !important;
    }
</style>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2><?php // echo $lang->ubayam; ?> <?php echo $lang->report; ?>
                <small><?php // echo $lang->ubayam; ?> <b><?php // echo $lang->ubayam; ?>
                        <?php // echo $lang->report; ?></b></small>
            </h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="body">
                      <form action="<?php echo base_url(); ?>/report/print_ubayamreport_temple" method="get" target="_blank">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-md-2 col-sm-4">
                <div class="form-group form-float">
                    <div class="form-line" id="bs_datepicker_container">
                        <input type="date" name="fdt" id="fdt" class="form-control"
                            value="<?php echo date('Y-m-01'); ?>"
                            max="<?php echo $booking_calendar_range_year; ?>">
                        <label class="form-label">Booking From</label>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-4">
                <div class="form-group form-float">
                    <div class="form-line" id="bs_datepicker_container">
                        <input type="date" name="tdt" id="tdt" class="form-control"
                            value="<?php echo date('Y-m-d'); ?>"
                            max="<?php echo $booking_calendar_range_year; ?>">
                        <label class="form-label">Booking To</label>
                    </div>
                </div>
            </div>
            
            <!-- NEW: Event Date Filter -->
            <div class="col-md-2 col-sm-4">
                <div class="form-group form-float">
                    <div class="form-line">
                        <input type="date" name="event_date" id="event_date" class="form-control"
                            max="<?php echo $booking_calendar_range_year; ?>">
                        <label class="form-label">Event Date</label>
                    </div>
                </div>
            </div>
            
            <div class="col-md-2 col-sm-4">
                <div class="form-group form-float">
                    <div class="form-line">
                        <select class="form-control" name="payfor" id="payfor">
                            <option value="0"><?php echo $lang->select; ?> <?php echo $lang->pay_for; ?></option>
                            <?php foreach ($ubyam_set as $row) { ?>
                                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                            <?php } ?>
                        </select>
                        <label class="form-label"></label>
                    </div>
                </div>
            </div>
            
            <div class="col-md-2 col-sm-4">
                <div class="form-group form-float">
                    <div class="form-line">
                        <select class="form-control" name="booking_type" id="booking_type">
                            <option value=""><?php echo $lang->select; ?> Booking type</option>
                            <option value="1">Hall Booking</option>
                            <option value="2">Ubayam</option>
                            <option value="3">Sannathi</option>
                        </select>
                        <label class="form-label"></label>
                    </div>
                </div>
            </div>
            
            <div class="col-md-2 col-sm-4">
                <div class="form-group form-float">
                    <div class="form-line">
                        <select class="form-control" name="payment_type" id="payment_type">
                            <option value=""><?php echo $lang->select; ?> Payment Status</option>
                            <option value="paid">Paid</option>
                            <option value="partial">Partial Paid</option>
                            <option value="only_booking">Only Booking</option>
                        </select>
                        <label class="form-label"></label>
                    </div>
                </div>
            </div>
            
            <div class="col-md-2 col-sm-4" style="display:none">
                <div class="form-group form-float">
                    <div class="form-line">
                        <select class="form-control" name="fltername" id="fltername">
                            <option value="0"><?php echo $lang->select; ?> <?php echo $lang->name; ?></option>
                            <?php if (!empty($fltr_name)): ?>
                                <?php foreach ($fltr_name as $row): ?>
                                    <option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <label class="form-label"></label>
                    </div>
                </div>
            </div>
            
            <div class="col-md-2 col-sm-4">
                <div class="form-group form-float">
                    <label type="submit" class="btn btn-success btn-lg waves-effect" id="submit"><?php echo $lang->submit; ?></label>
                </div>
            </div>
            
            <div class="col-md-12 col-sm-12" style="margin:0px;">
                <button type="submit" class="btn btn-primary btn-lg waves-effect" id="submit">PRINT</button>
                <input name="pdf_ubayamreport" type="submit" class="btn btn-danger btn-lg waves-effect" id="pdf_ubayamreport" value="PDF">
                <input name="excel_ubayamreport" type="submit" class="btn btn-success btn-lg waves-effect" id="excel_ubayamreport" value="EXCEL">
            </div>
        </div>
    </div>
</form>
                        <div class="table-responsive col-md-12 det" style="background:#FFF; float:none;">
                            <table class="table table-striped dataTable" id="datatables">
                                <thead>
                                    <tr>
                                        <th style="width:5%;"><?php echo $lang->sno; ?></th>
                                        <th style="width:8%;">Booking <?php echo $lang->date; ?></th>
                                        <th style="width:8%;">Event <?php echo $lang->date; ?></th>
                                        <th style="width:22%;">Event Name</th>
                                        <th style="width:20%;"><?php echo $lang->name; ?></th>
                                        <th style="width:9%;"><?php echo $lang->amount; ?></th>
                                        <th style="width:9%;"><?php echo $lang->status; ?></th>
                                        <th style="width:14%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Edit Booking Modal -->
<div class="modal fade" id="editBookingModal" tabindex="-1" role="dialog" aria-labelledby="editBookingModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="editBookingModalLabel"><i class="material-icons"
                        style="vertical-align:middle;">edit</i> Edit Booking</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="edit_booking_id">
                <input type="hidden" id="edit_booking_type">
                <div class="form-group">
                    <label class="form-label-custom">Name <span style="color:red;">*</span></label>
                    <div class="form-line">
                        <input type="text" id="edit_name" class="form-control" placeholder="Enter Name" required>
                    </div>
                </div>
                <div class="form-group" style="margin-top:15px;">
                    <label class="form-label-custom">Event Date <span style="color:red;">*</span></label>
                    <div class="form-line">
                        <input type="date" id="edit_booking_date" class="form-control" required>
                    </div>
                    <span class="date-error" id="date_error_msg"><i class="material-icons"
                            style="font-size:14px;vertical-align:middle;">warning</i> This date is already booked.
                        Please select another date.</span>
                </div>
                <div class="form-group" style="margin-top:15px;">
                    <label class="form-label-custom">Remarks</label>
                    <div class="form-line">
                        <textarea id="edit_remarks" class="form-control" rows="3"
                            placeholder="Enter Remarks"></textarea>
                    </div>
                </div>
                <div id="edit_loading" style="display:none; text-align:center; padding:10px;">
                    <i class="fa fa-spinner fa-spin"></i> Loading...
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary waves-effect" id="btn_save_booking"><i
                        class="material-icons" style="vertical-align:middle;font-size:18px;">save</i> Save
                    Changes</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    var bookedDates = [];

    report = $('#datatables').DataTable({
        dom: 'Bfrtip',
        buttons: [],
        "ajax": {
            url: "<?php echo base_url(); ?>/report/ubayam_rep_ref_temple",
        dataType: "json",
        type: "POST",
        data: function (data) {
            data.fdt = $('#fdt').val();
        data.tdt = $('#tdt').val();
        data.event_date = $('#event_date').val(); // NEW
        data.payfor = $('#payfor').val();
        data.booking_type = $('#booking_type').val();
        data.fltername = $('#fltername').val();
        data.payment_type = $('#payment_type').val();
            }
        },
    });

        $('#submit').click(function () {
            report.ajax.reload();
        $("#prt").attr("href", '<?php base_url() ?>/report/print/ubayam/' + $('#fdt').val() + '/' + $('#tdt').val());
    });

        // Open Edit Modal
        $(document).on('click', '.btn-edit-booking', function () {
            var bookingId = $(this).data('id');
            var name = $(this).data('name');
            var bookingDate = $(this).data('booking-date');
            var bookingType = $(this).data('booking-type');
            var remarks = $(this).data('remarks') || '';

            $('#edit_booking_id').val(bookingId);
            $('#edit_name').val(name);
            $('#edit_booking_date').val(bookingDate);
            $('#edit_booking_type').val(bookingType);
            $('#edit_remarks').val(remarks);
            $('#date_error_msg').hide();
            $('#btn_save_booking').prop('disabled', false);

            // Fetch booked dates
            $('#edit_loading').show();
            $.ajax({
                url: "<?php echo base_url(); ?>/report/get_booked_dates",
                type: "POST",
                data: {
                    booking_id: bookingId,
                    booking_type: bookingType
                },
                dataType: "json",
                success: function (response) {
                    bookedDates = response.booked_dates || [];
                    $('#edit_loading').hide();
                    // Validate current date
                    validateEventDate();
                },
                error: function () {
                    bookedDates = [];
                    $('#edit_loading').hide();
                }
            });

            $('#editBookingModal').modal('show');
        });

        // Validate Event Date on change
        $('#edit_booking_date').on('change', function () {
            validateEventDate();
        });

        function validateEventDate() {
            var selectedDate = $('#edit_booking_date').val();
            if (selectedDate && bookedDates.indexOf(selectedDate) !== -1) {
                $('#date_error_msg').show();
                $('#btn_save_booking').prop('disabled', true);
            } else {
                $('#date_error_msg').hide();
                $('#btn_save_booking').prop('disabled', false);
            }
        }

        // Save Booking
        $('#btn_save_booking').on('click', function () {
            var bookingId = $('#edit_booking_id').val();
            var name = $.trim($('#edit_name').val());
            var bookingDate = $('#edit_booking_date').val();
            var bookingType = $('#edit_booking_type').val();
            var remarks = $.trim($('#edit_remarks').val());

            if (name === '') {
                alert('Please enter the name.');
                $('#edit_name').focus();
                return false;
            }
            if (bookingDate === '') {
                alert('Please select the event date.');
                $('#edit_booking_date').focus();
                return false;
            }

            // Double check booked date
            if (bookedDates.indexOf(bookingDate) !== -1) {
                $('#date_error_msg').show();
                return false;
            }

            var btn = $(this);
            btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');

            $.ajax({
                url: "<?php echo base_url(); ?>/report/update_booking_name_date",
                type: "POST",
                data: {
                    booking_id: bookingId,
                    name: name,
                    booking_date: bookingDate,
                    booking_type: bookingType,
                    remarks: remarks
                },
                dataType: "json",
                success: function (response) {
                    if (response.status === 'success') {
                        $('#editBookingModal').modal('hide');
                        report.ajax.reload(null, false);
                        // Show success notification
                        if (typeof showNotification === 'function') {
                            showNotification('bg-teal', response.message, 'top', 'right', null, null);
                        } else {
                            alert(response.message);
                        }
                    } else {
                        $('#date_error_msg').text(response.message).show();
                        btn.prop('disabled', false).html('<i class="material-icons" style="vertical-align:middle;font-size:18px;">save</i> Save Changes');
                    }
                },
                error: function () {
                    alert('Something went wrong. Please try again.');
                    btn.prop('disabled', false).html('<i class="material-icons" style="vertical-align:middle;font-size:18px;">save</i> Save Changes');
                }
            });
        });
    });
</script>