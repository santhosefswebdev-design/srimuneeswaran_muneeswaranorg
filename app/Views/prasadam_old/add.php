<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/demo.css"> 
<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">-->

<style>
.links li img { display:none !important; }
.navbar1 .links li .sub-menu { top: 23px; }
.navbar1 .links li { min-width: 80px; }
[type="checkbox"] + label {
	display:none;
}
[type="checkbox"] + label.s_print {
	display:block;
}
.heading { text-align:center; background:#000; color:#FFF; padding:10px; }
.products { 
	background:#FFF;
	display: flex;
    flex-wrap: wrap;
    align-items: center; 
	max-height: 420px;
    overflow-y: scroll;
}
.products .col-md-3{ 
	margin-bottom: 0px;
}
.prod { background:#CCCCCC; padding:5px 3px; margin-top:3px; margin-bottom:3px; cursor:pointer; }
.prod img { width:30%; float:left; border-right:1px dashed #999999; }
.prod .detail { width:60%; position:relative; margin-left:40%; }
.prod .detail h4,.prod .detail h5 { font-weight:bold; }
.vl { border-left: 2px dashed #999999; height: 82%; position: absolute; left: 38%; margin-left: -3px; top: 0; bottom:0; margin-top:10px; }
.cart-table { width:100%; } 
.cart-table tr th, .rasi-table tr th { font-weight:600; padding:4px;  }
.cart-table tr td, .rasi-table tr td { padding:2px; font-size:12px; border :none;}
.row_amt,.row_qty,.row_tot,.tot  {border :none;width: 100%;}
.detail h5 { font-size:11px; }
form.example input[type=text] {
  padding: 10px;
  font-size: 17px;
  border: 1px solid grey;
  float: left;
  width: 90%;
  background: #f1f1f1;
}

form.example button {
  float: left;
  width: 10%;
  padding: 10px;
  background: #000;
  color: white;
  font-size: 17px;
  border: 1px solid grey;
  border-left: none;
  cursor: pointer;
}

form.example button:hover {
  background:#333333;
}

form.example::after {
  content: "";
  clear: both;
  display: table;
}
.all_close{
	height: auto;
}
.cart-body{
    overflow-y: scroll;
    overflow-x: hidden;
    /*height: 220px;*/
	height:120px;
	display: block;
}
.rasi-body { 
	overflow-y: scroll;
    overflow-x: hidden;
    /*height: 220px;*/
	height:50px;
	display: block; 
}
.cart-table thead, tbody.cart-body tr {
    display: table;
    width: 100%;
    table-layout: fixed;
}
.rasi-table thead, tbody.rasi-body tr {
    display: table;
    width: 100%;
    table-layout: fixed;
}
.arch_total { background:#CCC; color:#000; font-weight:bold; text-align:center; font-size:38px; padding:0px; line-height:40px; } 

.card .body .col-xs-12, .card .body .col-sm-12, .card .body .col-md-12, .card .body .col-lg-12 {
    margin-bottom: 0px !important;
}
.detail h4 { font-size:19px; }
.prod { min-height:110px; }
@media (min-width: 992px) and (max-width: 1285px) {
.detail h4 { font-size:19px; }
}






/*@media screen and (orientation:portrait) {
body {
    transform: rotate(-90deg);
    transform-origin: 50% 50%;
}
}*/
.name { min-height:45px; max-height:45px; }
.form-group { margin-bottom: 20px; }
hr { margin: 2px auto;}
.cart { padding: 5px 20px 0 !important;  }
.btn {
    padding: 5px 7px !important;
}
.card { margin-bottom: 10px !important; }
.form-control { height: 27px; }
.card .body { padding: 15px 20px; }
section.content { min-height: 470px; }
@media (min-width: 1020px) {
    .card .body, .btn, .form-control { font-size: 12px !important; }
    .arch_total { font-size: 22px !important; line-height: 30px !important; }
    .cart-table tr td, .rasi-table tr td { font-size: 10px !important; }
    .dropdown-menu > li > a { font-size: 12px; line-height: 14px; }
    .btn { padding: 5px 2px !important; }
    .submit_btn, .clear_btn { font-size:14px !important;padding:5px 15px !important; }
}
</style>  
<section class="content">
    <div class="container-fluid">
        <!-- <div class="block-header">
            <h2> ARCHANAI Ticket Entry<small>Archanai / <b>Archanai Ticket</b></small></h2>
        </div>
        Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="body">
                            <?php if($_SESSION['succ'] != '') { ?>
                                <div class="row" style="padding: 0 30%;" id="content_alert">
                                    <div class="suc-alert">
                                        <span class="suc-closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                                        <p><?php echo $_SESSION['succ']; ?></p> 
                                    </div>
                                </div>
                            <?php } ?>
                             <?php if($_SESSION['fail'] != '') { ?>
                                <div class="row" style="padding: 0 30%;" id="content_alert">
                                    <div class="alert">
                                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                                        <p><?php echo $_SESSION['fail']; ?></p>
                                    </div>
                                </div>
                            <?php } ?>
                        <div class="container-fluid">
                            <div class="row">
                                  <div class="col-md-8" style="margin-bottom: 0;">
                                    <div class="row">
                                        <div class="col-md-12 search-container" style="padding:0;">
                                          <!--input type="text" class="form-control" placeholder="Search.." name="search" id="search"-->
                                          <!--<button type="submit"><i class="fa fa-search"></i></button>-->
                                        </div>
                                    </div>
                                    <div id="products" class="products row scroll">

                                        <?php 
                                            if(!empty($prasadam_settings)) {
                                            ?>
                                            <?php foreach($prasadam_settings as $row) { ?>
                                                <div class="col-md-4 col-lg-3 col-sm-6 col-xs-12" style="padding-left: 0px;">
                                                    <div class="prod" id="<?php echo $row['id']; ?>" data-id="prod<?php echo $row['id']; ?>" onclick="addtocart(<?php echo $row['id']; ?>)"><img src="<?php echo base_url(); ?>/uploads/prasadam_setting/<?php echo $row['image']; ?>" width="200" height="80" alt="image" />
                                                        <!--<div class="vl"></div>-->
                                                        <div class="detail">
                                                            <h5 class="name" id="nm_<?php echo $row['id']; ?>" data-id="<?php echo $row['id']; ?>"><?php echo $row['name_tamil'].' <br>'.$row['name_eng']; ?></h5><h4 id="amt_<?php echo $row['id'];?>" data-id="<?php echo $row['amount']; ?>" >SGD <?php echo number_format((float)($row['amount']), 2);?></h4>
                                                            <input type="hidden">
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        <?php } ?> 
                                    </div> 
                                </div>
                                        <div class="col-md-4 det" style="margin-bottom: 0;">
                                            <div class="cart">
                                                
                                                <div class="row">
                                                <!--<h3 style="margin-top:0px; margin-bottom: 15px;">Archanai Items</h3>-->
                                                <form method="post">
                                                <div class="row" style="margin-top:20px; display:none;">
													<div class="col-sm-6" style="margin: 0px;">
														<div class="form-group form-float">
															<div class="form-line" id="bs_datepicker_container" >
																<input type="hidden" name="date" id="date" class="form-control" value="<?php echo date('Y-m-d'); ?>"  >
																<label class="form-label">Date</label>
															</div>
														</div>
													</div>
													<div class="col-sm-6" style="margin: 0px;">
														<div class="form-group form-float">
															<div class="form-line">
																<input type="text"  name="billno"  id="billno" class="form-control" value="<?php echo $bill_no; ?>" readonly>
																<label class="form-label">Bill No</label>
															</div>
														</div>
													</div>
                                                </div>
                                                
                                                <div class="row" style="margin-top:20px;">
													<div class="col-sm-12">
														<div class="form-group form-float">
															<div class="form-line" id="bs_datepicker_container" >
																<input type="text" name="customer_name" id="customer_name" class="form-control"  >
																<label class="form-label">Customer Name </label>
															</div>
														</div>
													</div>
													<div class="col-sm-6">
														<div class="form-group form-float">
															<div class="form-line focused">
																<input type="date" name="collection_date"  id="collection_date" class="form-control" min="<?php echo date('Y-m-d'); ?>">
																<label class="form-label">Collection Date</label>
															</div>
														</div>
													</div>
												
													<div class="col-sm-6">
                                                        <div class="form-group form-float">
                                                            <div class="form-line" id="" >
                                                                <input type="time" name="start_time" id="start_time" class="form-control bs-timepicker" value="<?php echo isset($data['start_time']) ? $data['start_time'] : date("H:i");  ?>" <?php echo $readonly; ?> >
                                                                <label class="form-label">Estimated Time <span style="color: red;">*</span></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--div class="col-sm-6">
                                                        <div class="form-group form-float">
                                                            <div class="form-line" id="" >
                                                                <input type="time" name="end_time" id="end_time" class="form-control bs-timepicker" value="<?php echo isset($data['end_time']) ? $data['end_time'] : date("H:i");  ?>" <?php echo $readonly; ?> >
                                                                <label class="form-label">End Time <span style="color: red;">*</span></label>
                                                            </div>
                                                        </div>
                                                    </div-->
                                                    
                                                    <div class="col-md-4">
                                                        <div class="form-group form-float">
                                                            <div class="form-line">
                                                                <select class="form-control" name="paymentmode" id="paymentmode" <?php echo $disable; ?>>
                                                                    <?php foreach($payment_modes as $payment_mode) { ?>
                                                                    <option value="<?php echo $payment_mode['id']; ?>" <?php if(!empty($data['payment_mode'])){ if($data['payment_mode'] == $payment_mode['id']){ echo "selected"; } } ?>><?php echo $payment_mode['name'];?></option>
                                                                    <?php } ?>
                                                                </select>
                                                                <label class="form-label">Paymentmode <span style="color: red;">*</span></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group form-float">
                                                            <div class="form-line">
                                                                <select class="form-control" name="phonecode" id="phonecode" <?php echo $disable; ?>>
                                                                    <option value="0">select</option>
                                                                    <?php
                                                                        if(!empty($phone_codes))
                                                                        {
                                                                            foreach($phone_codes as $phone_code)
                                                                            {
                                                                        ?>
                                                                        <option value="<?php echo $phone_code['dailing_code']; ?>" <?php if($phone_code['dailing_code'] == "+60"){ echo "selected";}?>><?php echo $phone_code['dailing_code']; ?></option>
                                                                        <?php
                                                                            }
                                                                        }              
                                                                    ?>
                                                                </select>
                                                                <label class="form-label">&nbsp;</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group form-float">
                                                            <div class="form-line" id="" >
                                                                <input type="number" name="mobile" id="mobile" class="form-control" >
                                                                <label class="form-label">Mobile No <span style="color: red;">*</span></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
														<div class="form-group form-float">
															<div class="form-line focused">
																<input type="date" name="dob"  id="dob" class="form-control" >
																<label class="form-label">DOB</label>
															</div>
														</div>
													</div>

                                                </div>
                                                

                                                    <input type="hidden" value="0" name="cnt" id="count">
													<div class="cart_tab_outer">
														<table class="cart-table">
															<thead>
																<th style="width: 40%;">Prasadam Name</th>
																<th style="width: 20%; text-align: center;">SGD</th>
																<th style="width: 8%; text-align: center;">Qty</th>
																<th style="width: 20%; text-align: center;">Total</th>
																<th style="width: 12%; text-align: center;">&nbsp;</th>
															</thead>
															<tbody class="cart-body scroll">
															</tbody>
														</table>
													</div>
                                                    <hr>
													<div class="arch_total">
														<input type="hidden" class="tot" id="tot_amt" name="tot_amt" value="0.00">
														<strong>Total SGD</strong> <span class="tot_amt_txt">0.00</span>
													</div>
                                                    <!--div class="row">
                                                        <div class="col-md-2" style="margin: 5px 0px!important;"></div>
                                                        <div class="col-md-4" style="margin: 5px 0px!important;">
                                                            <p style="font-size: 18px;text-align: right;"><strong>Amount RM</strong></p>
                                                        </div>
                                                        <div class="col-md-6" style="margin: 5px 0px!important;">
                                                            <input type="number" class="form-control" min="0" step="any" id="entered_amount" name="entered_amount" placeholder="0.00" style="text-align: right;font-size: 18px !important;">
                                                        </div>
                                                    </div>
                                                    <div class="arch_total">
														<input type="hidden" class="tot_balance" id="tot_balance_amt" name="tot_balance_amt" value="0.00">
														<strong>Balance RM</strong> <span class="tot_balance_amt_txt">0.00</span>
													</div-->
                                                    <div class="row">
                                                        <div class="col-md-12" style="background:#FFFFFF;margin-top:5px;">                                                        
														<!--div class="col-md-4 col-xs-4" align="center" style="margin-bottom: 0;padding: 0px 12px">
                                                            <input  type="checkbox" id="s_print" name="s_print" value="Separate">
                                                            <label class="s_print sep_pri" for ='s_print'> Separate </label>
                                                        </div-->
                                                        <div class="col-md-4 col-xs-4" align="left" style="margin-bottom: 0;">
                                                        
                                                            <input  type="checkbox" checked="checked" id="print" name="print" value="Print">
                                                            <label for ='print'> &nbsp;&nbsp; </label>
                                                            <?php /* <label id="submit" class="btn btn-success btn-lg waves-effect">PRINT</label> */ ?>
															<label id="submit_mob" class="btn submit_btn btn-success btn-lg waves-effect">Print</label>
                                                        </div>
                                                        
														<div class="col-md-4 col-xs-4" align="right" style="margin-bottom: 0;">
                                                        <a style="float:right;"><button type="submit" class="btn clear_btn btn-danger btn-lg waves-effect" id="clear">Clear All</button></a>
                                                        </div>
                                                        </div>
                                                    </div>
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
    <!-- Image loader -->
    <div id='loader' style='display: none;'>
        <img src='./assets/Loading_2.gif' width='32px' height='32px'>
    </div>
    <!-- Image loader -->                                                        
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
</section>
<link href="<?php echo base_url(); ?>/assets/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>/assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>
<script>
$(document).ready(function() {

    $('#date').change(function() {
        $.ajax
            ({
                type:"POST",
                url: "<?php echo base_url();?>/prasadam/getbillno",
                data:{date:$('#date').val()},
                success:function(data)
                {
                    //alert(data);
                   $('#billno').val(data);
                }
            })
    });

    $('#search').keyup(function() {

    //alert($('#search').val());
    $.ajax
        ({
            type:"POST",
            url: "<?php echo base_url();?>/prasadam/show_product",
            data:{prod:$('#search').val()},
            success: function (response) {
                //alert($('#search').val());
        		var obj=jQuery.parseJSON(response);
                console.log(obj.row)
                $('#products').empty();
                $('#products').append(obj.row);
                //alert(data);
            //$('#billno').val(data);
            }
        })
    });
	
	$("#clear").click(function() {
       $(".cart-table .all_close").empty();
       $("#count").val(0);
        sum_total();
    });
	
	$('tr td #remove').click(function() {
    	$(this).css({"display":"block"});
	}); 
    
});

    function sum_total(){
        var total_qty = 0;
        $( ".row_qty" ).each(function() {
            total_qty += parseFloat($( this ).val());
        });
        /* $("#tot_qty").text(total_qty); */

        var total_amt = 0;
        $( ".row_tot" ).each(function() {
            total_amt += parseFloat($( this ).val());
        });
        $("#tot_amt").val(Number(total_amt).toFixed(2));
        $(".tot_amt_txt").text(Number(total_amt).toFixed(2));

        
    }
    function remove(id){
        $(".cart-table #remov"+id).remove();

        $("#count").val(  parseInt($("#count").val())-1);
         sum_total();
         sum_balance();
    }

    function addtocart(ids){
        var text = $("#nm_"+ids).text();
        var amt = Number($("#amt_"+ids).attr("data-id")).toFixed(2);
        let exist_id=$("#remov"+ids).attr("data-id");
        exist_id = exist_id || 0;

        let exist_qty=$("#qty_"+ids).val();
        exist_qty = exist_qty || 0;
        
        
        if (exist_id==0 || exist_qty==0)
        {
            var count = $('#count').val();        
		
            var text1 = '<tr class="all_close" data-id="'+ids+'" id="remov'+ids +'"><td style="width: 40%;"><input type="hidden" id="id_'+ids+'" name="prasadam['+count+'][id]" value="'+ids+'" ><p>'+text+'</p></td>';
            text1 += '<td style="width: 20%;"><input type="text" style="text-align: center;" class="row_amt" readonly name="prasadam['+count+'][amt]" value="'+amt+'"></td>';
            text1 += '<td style="width: 8%;"><input type="text" style="text-align: center;" class="row_qty" name="prasadam['+count+'][qty]" onkeyup="man_qun('+ids+')" id="qty_'+ids+'" value="1"></td>';
            text1 += '<td style="width: 20%;"><input type="text" style="text-align: center;" class="row_tot"readonly  name="tot" id="tot_'+ids+'" value="'+amt+'"></td>';
            text1 += '<td style="width: 12%;"><button class="btn btn-info" style="font-size:10px;" onclick="remove('+ids+')" id="remove">X</button></td></tr>';
            $(".cart-table").append(text1);
            count++;
		
        $("#count").val(count);
		
        }
       
        else
        {
            $("#qty_"+ids).val(parseInt($("#qty_"+ids).val())+1);
            $("#tot_"+ids).val(Number(parseInt($("#qty_"+ids).val())*amt).toFixed(2));
        }
        sum_total();
        sum_balance();
    }

    function man_qun(ids){
        //alert(ids)
        sum_total();
        var amt = Number($("#amt_"+ids).attr("data-id")).toFixed(2);
        var cnt = $("#qty_"+ids).val();
        var tot = amt * cnt;
        $("#tot_"+ids).val(tot.toFixed(2));
        sum_total();
        sum_balance();
    }

    $('#entered_amount').keyup(function() {
        sum_balance();
    });

    function sum_balance(){
        var enter_amt = $("#entered_amount").val();
        var tot_amt = $("#tot_amt").val();
        var balance_amt = Number(tot_amt).toFixed(2) - Number(enter_amt).toFixed(2);
        var convert_val = Math.abs(balance_amt);
        $("#tot_balance_amt").val(convert_val.toFixed(2));
        $(".tot_balance_amt_txt").text(convert_val.toFixed(2));
    }
</script>
<script>
    $("#submit").click(function(){
        $.ajax
        ({
            type:"POST",
            url: "<?php echo base_url(); ?>/prasadam/save",
            data: $("form").serialize(),
            beforeSend: function() {    
				$("#loader").show();
				$("#submit").prop('disabled', true);
			},
            success:function(data)
            {
				console.log(data);
                obj = jQuery.parseJSON(data);
                if(obj.err != ''){
                    $('#alert-modal').modal('show', {backdrop: 'static'});
                    $("#spndeddelid").text(obj.err);
                }else{					
					if ($("#print").prop('checked')==true && $("#s_print").prop('checked')==false)	
                    {
                        printData(obj.id);
                    }
					else if ($("#print").prop('checked')==true && $("#s_print").prop('checked')==true)
                    {
                        printData_sep(obj.id);
                    }
					else
                    {
                        window.location.reload(true);
                    }
                }
            },error:function(err)
            {
				$("#submit").prop('disabled', false);
				console.log('err');
				console.log(err);
			},
			complete:function(data){
                // Hide image container
                $("#loader").hide();
            }
        });
    });  
    
	$("#submit_mob").click(function(){
        $.ajax
        ({
            type:"POST",
            url: "<?php echo base_url(); ?>/prasadam/save",
            data: $("form").serialize(),
            beforeSend: function() {    
				//$("#submit").prop('disabled', true);
                $("#loader").show();
			},
            success:function(data)
            {
				//console.log(data);
                obj = jQuery.parseJSON(data);
                //alert(obj.id);
                //return;
                if(obj.err != ''){
                    $('#alert-modal').modal('show', {backdrop: 'static'});
                    $("#spndeddelid").text(obj.err);
                }else{
                    printData(obj.id);
                }
            },
            complete:function(data){
                // Hide image container
                $("#loader").hide();
            }
        });
    });  
    function printData(id) {
		
		// if ($("#print").prop('checked')==true)	
		// {
			$.ajax({
				url: "<?php echo base_url(); ?>/prasadam/print_booking/"+id,
				type: 'POST',
				success: function (result) {
					//console.log(result)
					popup(result);
				}
			});
		// }
		// else window.location.reload(true);
    }
	function printData_sep(id) {
		
			$.ajax({
				url: "<?php echo base_url(); ?>/prasadam/print_booking_sep/"+id,
				type: 'POST',
				success: function (result) {
					//console.log(result)
					popup_sep(result);
				}
			});
    }

    function popup(data)
    {
        var frame1 = $('<iframe />');
        frame1[0].name = "frame1";
        frame1.css({"position": "absolute", "top": "-1000000px"});
        $("body").append(frame1);
        var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
        
		frameDoc.document.open();
		window.frameDoc = frameDoc;
        //Create a new HTML document.
        frameDoc.document.write('<html>');
        frameDoc.document.write('<head>');
        frameDoc.document.write('<title></title>');
        frameDoc.document.write('</head>');
        frameDoc.document.write('<body >');
        frameDoc.document.write(data);
        frameDoc.document.write('</body>');
        frameDoc.document.write('</html>');
        frameDoc.document.close();
        setTimeout(function () {
            window.frames["frame1"].focus();
            window.frames["frame1"].print();
            frame1.remove();
            window.location.reload(true);
        }, 500);

        frame1.remove();
        window.location.reload(true);
    }
	
	function popup_sep(data)
    {
        var frame1 = $('<iframe />');
        frame1[0].name = "frame1";
        frame1.css({"position": "absolute", "top": "-1000000px"});
        $("body").append(frame1);
        var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
        
		frameDoc.document.open();
		window.frameDoc = frameDoc;
        //Create a new HTML document.
        frameDoc.document.write('<html>');
        frameDoc.document.write('<head>');
        frameDoc.document.write('<title></title>');
        frameDoc.document.write('</head>');
        frameDoc.document.write('<body >');
        frameDoc.document.write(data);
        frameDoc.document.write('</body>');
        frameDoc.document.write('</html>');
        frameDoc.document.close();
        setTimeout(function () {
            window.frames["frame1"].focus();
            window.frames["frame1"].print();
            frame1.remove();
            window.location.reload(true);
        }, 500);

        frame1.remove();
        window.location.reload(true);
    }
</script>
  
