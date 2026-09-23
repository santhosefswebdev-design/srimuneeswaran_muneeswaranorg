<script>
if(loginDetail.listLogin().length == 0 ){
    var baseurl_js = "<?php echo base_url(); ?>";
    window.location.replace(baseurl_js);
}
</script>

<link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.bootstrap5.css">
<script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.bootstrap5.js"></script>
<style>
.nav .nav-item button{
    color: #000 !important;
  text-transform: uppercase;
    font-weight: bold;
}
.nav .nav-item button.active {
  background-color: transparent;
  color: #000 !important;
  text-transform: uppercase;
    font-weight: bold;
}
.nav .nav-item button.active::after {
  content: "";
  border-bottom: 4px solid #f1c152;
  width: 100%;
  position: absolute;
  left: 0;
  bottom: -1px;
  border-radius: 5px 5px 0 0;
}
.border-bottom {
    border-bottom: 1px solid #f1c1525c !important;
}
td, th {
    padding: 2px!important;
    vertical-align:middle;
}
.page-link {
    padding: 0rem .5rem;
}
.pagination .page-item .page-link {
    margin: 1px;
    outline: none;
    box-shadow: none;
    color: #0d0d0d;
}
.form-control {
    padding: .0rem .5rem;
}
.form-select-sm {
    padding-top: .0rem;
    padding-bottom: .0rem;
    padding-left: .5rem;
    font-size: .875rem;
    border-radius: .2rem;
}
div.dt-container div.dt-search input {
    margin-left: 0.5em;
    display: inline-block;
    width: auto;
    font-size: 10px;
}
.page-item.active .page-link {
    z-index: 3;
    color: #fff;
    background-color: #f1c152;
    border-color: #f1c152;
}
</style>
<div class="container p-5">
  <ul class="nav nav-pills mb-3 border-bottom border-2" id="pills-tab" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link text-primary fw-semibold active position-relative" id="pills-archanai-tab" data-bs-toggle="pill" data-bs-target="#pills-archanai" type="button" role="tab" aria-controls="pills-archanai" aria-selected="true">Archanai</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link text-primary fw-semibold position-relative" id="pills-donation-tab" data-bs-toggle="pill" data-bs-target="#pills-donation" type="button" role="tab" aria-controls="pills-donation" aria-selected="false">Donation</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link text-primary fw-semibold position-relative" id="pills-prasadam-tab" data-bs-toggle="pill" data-bs-target="#pills-prasadam" type="button" role="tab" aria-controls="pills-prasadam" aria-selected="false">Prasadam</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link text-primary fw-semibold position-relative" id="pills-annathanam-tab" data-bs-toggle="pill" data-bs-target="#pills-annathanam" type="button" role="tab" aria-controls="pills-annathanam" aria-selected="false">Annathanam</button>
    </li>
  </ul>
  <div class="tab-content border rounded-1 border-primary p-3 text-danger" id="pills-tabContent" style="border-color: #f1c1525c !important;">
    <div class="tab-pane fade show active" id="pills-archanai" role="tabpanel" aria-labelledby="pills-archanai-tab">
            <div class="row">
                <div class="col-md-2 col-sm-4">
                    <div class="form-group">
                        <div class="form-line" >
                            <input type="date" name="fdt_archanai" id="fdt_archanai" class="form-control" value="<?php echo date('Y-m-01'); ?>"  >
                        </div>                                                        
                    </div>                                            
                </div>
                <div class="col-md-2 col-sm-4">
                    <div class="form-group">
                        <div class="form-line" >
                            <input type="date" name="tdt_archanai" id="tdt_archanai" class="form-control" value="<?php echo date('Y-m-d'); ?>"  >
                        </div>                                                        
                    </div>                                            
                </div>
                <div class="col-md-2 col-sm-4">
                    <div class="form-group">
                        <div class="form-line" >
                            <select name="booking_status_archanai" id="booking_status_archanai" class="form-control">
                                <option value="">booking status</option>
                                <option value="2">Confirmed</option>
                                <option value="3">Failed</option>
                            </select>
                        </div>                                                        
                    </div>                                            
                </div>
                <div class="col-md-2 col-sm-4">
                    <div class="form-group">                                        
                        <label type="submit" class="btn btn-success btn-lg waves-effect" id="submit_archanai" style="padding: .0rem .5rem;font-size: 14px;text-transform: uppercase;font-weight: bold;">Submit</label>
                    </div>
                </div>
            </div>
        <div class="row">
            <div class="col-md-12">
                <table id="Table_archanai" class="table table-striped nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th style="text-align:center;">#</th>
                            <th style="text-align:center;">Booked Date</th>
                            <th style="text-align:center;">Ref No</th>
                            <th style="text-align:center;">Total Amount</th>
                            <th style="text-align:center;">Action</th>
                        </tr>
                    </thead>
                    <tbody >                                    

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="pills-donation" role="tabpanel" aria-labelledby="pills-donation-tab">
        <div class="row">
            <div class="col-md-2 col-sm-4">
                <div class="form-group">
                    <div class="form-line" >
                        <input type="date" name="fdt_donation" id="fdt_donation" class="form-control" value="<?php echo date('Y-m-01'); ?>"  >
                    </div>                                                        
                </div>                                            
            </div>
            <div class="col-md-2 col-sm-4">
                <div class="form-group">
                    <div class="form-line" >
                        <input type="date" name="tdt_donation" id="tdt_donation" class="form-control" value="<?php echo date('Y-m-d'); ?>"  >
                    </div>                                                        
                </div>                                            
            </div>
            <div class="col-md-2 col-sm-4">
                <div class="form-group">
                    <div class="form-line" >
                        <select name="booking_status_donation" id="booking_status_donation" class="form-control">
                            <option value="">booking status</option>
                            <option value="2">Confirmed</option>
                            <option value="3">Failed</option>
                        </select>
                    </div>                                                        
                </div>                                            
            </div>
            <div class="col-md-2 col-sm-4">
                <div class="form-group">                                        
                    <label type="submit" class="btn btn-success btn-lg waves-effect" id="submit_donation" style="padding: .0rem .5rem;font-size: 14px;text-transform: uppercase;font-weight: bold;">Submit</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table id="Table_donation" class="table table-striped nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th style="text-align:center;">#</th>
                            <th style="text-align:center;">Booked Date</th>
                            <th style="text-align:center;">Ref No</th>
                            <th style="text-align:center;">Total Amount</th>
                            <th style="text-align:center;">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="pills-prasadam" role="tabpanel" aria-labelledby="pills-prasadam-tab">
        <div class="row">
            <div class="col-md-2 col-sm-4">
                <div class="form-group">
                    <div class="form-line" >
                        <input type="date" name="fdt_prasadam" id="fdt_prasadam" class="form-control" value="<?php echo date('Y-m-01'); ?>"  >
                    </div>                                                        
                </div>                                            
            </div>
            <div class="col-md-2 col-sm-4">
                <div class="form-group">
                    <div class="form-line" >
                        <input type="date" name="tdt_prasadam" id="tdt_prasadam" class="form-control" value="<?php echo date('Y-m-d'); ?>"  >
                    </div>                                                        
                </div>                                            
            </div>
            <div class="col-md-2 col-sm-4">
                <div class="form-group">
                    <div class="form-line" >
                        <select name="booking_status_prasadam" id="booking_status_prasadam" class="form-control">
                            <option value="">booking status</option>
                            <option value="2">Confirmed</option>
                            <option value="3">Failed</option>
                        </select>
                    </div>                                                        
                </div>                                            
            </div>
            <div class="col-md-2 col-sm-4">
                <div class="form-group">                                        
                    <label type="submit" class="btn btn-success btn-lg waves-effect" id="submit_prasadam" style="padding: .0rem .5rem;font-size: 14px;text-transform: uppercase;font-weight: bold;">Submit</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table id="Table_prasadam" class="table table-striped nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th style="text-align:center;">#</th>
                            <th style="text-align:center;">Booked Date</th>
                            <th style="text-align:center;">Ref No</th>
                            <th style="text-align:center;">Total Amount</th>
                            <th style="text-align:center;">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="pills-annathanam" role="tabpanel" aria-labelledby="pills-annathanam-tab">
        <div class="row">
            <div class="col-md-2 col-sm-4">
                <div class="form-group">
                    <div class="form-line" >
                        <input type="date" name="fdt_annathanam" id="fdt_annathanam" class="form-control" value="<?php echo date('Y-m-01'); ?>"  >
                    </div>                                                        
                </div>                                            
            </div>
            <div class="col-md-2 col-sm-4">
                <div class="form-group">
                    <div class="form-line" >
                        <input type="date" name="tdt_annathanam" id="tdt_annathanam" class="form-control" value="<?php echo date('Y-m-d'); ?>"  >
                    </div>                                                        
                </div>                                            
            </div>
            <div class="col-md-2 col-sm-4">
                <div class="form-group">
                    <div class="form-line" >
                        <select name="booking_status_annathanam" id="booking_status_annathanam" class="form-control">
                            <option value="">booking status</option>
                            <option value="2">Confirmed</option>
                            <option value="3">Failed</option>
                        </select>
                    </div>                                                        
                </div>                                            
            </div>
            <div class="col-md-2 col-sm-4">
                <div class="form-group">                                        
                    <label type="submit" class="btn btn-success btn-lg waves-effect" id="submit_annathanam" style="padding: .0rem .5rem;font-size: 14px;text-transform: uppercase;font-weight: bold;">Submit</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table id="Table_annathanam" class="table table-striped nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th style="text-align:center;">#</th>
                            <th style="text-align:center;">Booked Date</th>
                            <th style="text-align:center;">Ref No</th>
                            <th style="text-align:center;">Total Amount</th>
                            <th style="text-align:center;">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>






  </div>
</div>

</body>
<script>
var cartArray_login_userid = loginDetail.listLogin();
//console.log(cartArray_login_userid[0]['login_id']);
archanai_report = new DataTable('#Table_archanai', {
    responsive: true,
    ajax: {
        url: "<?php echo base_url(); ?>/online_mybooking/get_archanai_list",
        dataType: "json",
        type: "POST",
        data: function (data) {
            data.fdt = $('#fdt_archanai').val();
            data.tdt = $('#tdt_archanai').val();
            data.bstatus = $('#booking_status_archanai').val();
            data.userid = cartArray_login_userid[0]['login_id'];
        },
        error: function (xhr, error, thrown) {
            console.log("Ajax error:", error);
            console.log("Status:", xhr.status);
            console.log("Thrown:", thrown);
        }
    }
});
$('#submit_archanai').click(function() {
    archanai_report.ajax.reload();
});
donation_report =new DataTable('#Table_donation', {
    responsive: true,
    ajax: {
        url: "<?php echo base_url(); ?>/online_mybooking/get_donation_list",
        dataType: "json",
        type: "POST",
        data: function (data) {
            data.fdt = $('#fdt_donation').val();
            data.tdt = $('#tdt_donation').val();
            data.bstatus = $('#booking_status_donation').val();
            data.userid = cartArray_login_userid[0]['login_id'];
        },
        error: function (xhr, error, thrown) {
            console.log("Ajax error:", error);
            console.log("Status:", xhr.status);
            console.log("Thrown:", thrown);
        }
    }
});
$('#submit_donation').click(function() {
    donation_report.ajax.reload();
});
prasadam_report =new DataTable('#Table_prasadam', {
    responsive: true,
    ajax: {
        url: "<?php echo base_url(); ?>/online_mybooking/get_prasadam_list",
        dataType: "json",
        type: "POST",
        data: function (data) {
            data.fdt = $('#fdt_prasadam').val();
            data.tdt = $('#tdt_prasadam').val();
            data.bstatus = $('#booking_status_prasadam').val();
            data.userid = cartArray_login_userid[0]['login_id'];
        },
        error: function (xhr, error, thrown) {
            console.log("Ajax error:", error);
            console.log("Status:", xhr.status);
            console.log("Thrown:", thrown);
        }
    }
});
$('#submit_prasadam').click(function() {
    prasadam_report.ajax.reload();
});
annathanam_report =new DataTable('#Table_annathanam', {
    responsive: true,
    ajax: {
        url: "<?php echo base_url(); ?>/online_mybooking/get_annathanam_list",
        dataType: "json",
        type: "POST",
        data: function (data) {
            data.fdt = $('#fdt_annathanam').val();
            data.tdt = $('#tdt_annathanam').val();
            data.bstatus = $('#booking_status_annathanam').val();
            data.userid = cartArray_login_userid[0]['login_id'];
        },
        error: function (xhr, error, thrown) {
            console.log("Ajax error:", error);
            console.log("Status:", xhr.status);
            console.log("Thrown:", thrown);
        }
    }
});
$('#submit_annathanam').click(function() {
    annathanam_report.ajax.reload();
});
</script>
