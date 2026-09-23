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
</style>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Kattalai <?php echo $lang->archanai; ?><?php echo $lang->report; ?>
                <small><?php echo $lang->archanai; ?> / <b>Kattalai <?php echo $lang->archanai; ?>
                        <?php echo $lang->booking; ?> <?php echo $lang->report; ?></b></small></h2>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="body">

                        <form id="filter_form">
                            <div class="container-fluid">
                                <div class="row clearfix">
                                    <div class="col-md-2 col-sm-3">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="date" name="fdt" id="fdt" class="form-control"
                                                    value="<?php echo date('Y-m-01'); ?>"
                                                    max="<?php echo $booking_calendar_range_year; ?>">
                                                <label class="form-label"><?php echo $lang->from; ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-3">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="date" name="tdt" id="tdt" class="form-control"
                                                    value="<?php echo date('Y-m-d'); ?>"
                                                    max="<?php echo $booking_calendar_range_year; ?>">
                                                <label class="form-label"><?php echo $lang->to; ?></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2 col-sm-4">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <select class="form-control" name="group_filter" id="group_filter">
                                                    <option value="0">Select Type</option>
                                                    <option value="daily">Daily</option>
                                                    <option value="weekly">Weekly</option>
                                                    <option value="days">Multiple Dated</option>
                                                    <option value="years">Yearly</option>
                                                </select>
                                                <label class="form-label"></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2 col-sm-4">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <select class="form-control" name="archanai_type_filter" id="archanai_type_filter">
                                                    <option value="0">Select</option>
                                                    <option value="1">Kattalai Archanai</option>
                                                    <option value="2">Kattalai Abishegam</option>
                                                </select>
                                                <label class="form-label"></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-sm-4">
                                        <button type="button" class="btn btn-success waves-effect" id="submit">
                                            <i class="material-icons">search</i> Filter
                                        </button>
                                        <button type="button" class="btn btn-danger waves-effect" id="btn_pdf">
                                            <i class="material-icons">picture_as_pdf</i> PDF
                                        </button>
                                        <button type="button" class="btn btn-primary waves-effect" id="btn_excel">
                                            <i class="material-icons">table_chart</i> Excel
                                        </button>
                                        <button type="button" class="btn btn-warning waves-effect" id="btn_print">
                                            <i class="material-icons">print</i> Print
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive col-md-12 det"
                            style="background:#FFF; float:none; margin-top:15px;">
                            <table style="width:100%;" align="center" class="table table-striped dataTable"
                                id="datatables">
                                <thead>
                                    <tr>
                                        <th style="width:5%;">S.No</th>
                                        <th style="width:8%;">Date</th>
                                        <th style="width:15%;text-align:left;">Devotee Name</th>
                                        <th style="width:12%;">Ref No</th>
                                        <th style="width:9%;">Types</th>
                                        <th style="width:12%;">Payment Type</th>
                                        <th style="width:10%;">Amount</th>
                                        <th style="width:10%;">Paid Amount</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                        <!-- Hidden print form for PDF/Excel -->
                        <form id="print_form"
                            action="<?php echo base_url(); ?>/kattalai_archanai/print_kattalai_archanai_report"
                            method="POST" target="_blank">
                            <input type="hidden" name="fdt" id="p_fdt">
                            <input type="hidden" name="tdt" id="p_tdt">
                            <input type="hidden" name="group_filter" id="p_group_filter">
                            <input type="hidden" name="pdf_kattalai_report" id="p_pdf" value="">
                            <input type="hidden" name="excel_kattalai_report" id="p_excel" value="">
                            <input type="hidden" name="archanai_type_filter" id="p_archanai_type_filter" value="">
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function () {

        var report = $('#datatables').DataTable({
            dom: 'Bfrtip',
            buttons: [],
            "ajax": {
                url: "<?php echo base_url(); ?>/kattalai_archanai/kattalai_archanai_report_ref",
                dataType: "json",
                type: "POST",
                data: function (data) {
                    data.fdt = $('#fdt').val();
                    data.tdt = $('#tdt').val();
                    data.group_filter = $('#group_filter').val();
                    data.archanai_type_filter = $('#archanai_type_filter').val();
                }
            },
        });

        $('#submit').click(function () {
            report.ajax.reload();
        });

        // PDF Export
        $('#btn_pdf').click(function () {
            $('#p_fdt').val($('#fdt').val());
            $('#p_tdt').val($('#tdt').val());
            $('#p_group_filter').val($('#group_filter').val());
            $('#p_archanai_type_filter').val($('#archanai_type_filter').val());
            $('#p_pdf').val('PDF');
            $('#p_excel').val('');
            $('#print_form').submit();
        });

        // Excel Export
        $('#btn_excel').click(function () {
            $('#p_fdt').val($('#fdt').val());
            $('#p_tdt').val($('#tdt').val());
            $('#p_group_filter').val($('#group_filter').val());
            $('#p_archanai_type_filter').val($('#archanai_type_filter').val());
            $('#p_pdf').val('');
            $('#p_excel').val('EXCEL');
            $('#print_form').submit();
        });

        // Print
        $('#btn_print').click(function () {
            $('#p_fdt').val($('#fdt').val());
            $('#p_tdt').val($('#tdt').val());
            $('#p_group_filter').val($('#group_filter').val());
            $('#p_archanai_type_filter').val($('#archanai_type_filter').val());
            $('#p_pdf').val('');
            $('#p_excel').val('');
            $('#print_form').submit();
        });

    });
</script>