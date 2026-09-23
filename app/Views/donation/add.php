
<?php 
if($view == true){
    $readonly = 'readonly';
    $disable = "disabled";
}
?>
<style>
<?php if($view == true) { ?>
label.form-label span { display:none !important; color:transporant; }
<?php } ?>
</style>
<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>CASH DONATION<small>Donation / <b>Add Cash Donation</b></small></h2>
            </div>
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <div class="row"><div class="col-md-8"><!--<h2>Cash Donation</h2>--></div>
                            <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/donation"><button type="button" class="btn bg-deep-purple waves-effect">List</button></a></div></div>
                        </div>
                        <form>
                        <div class="body">
                            <input type="hidden" name="id" value="<?php echo $data['id'];?>">
                            <div class="container-fluid">
                            <div class="row clearfix">
                                <div class="col-sm-3">
                                    <div class="form-group form-float">
                                        <div class="form-line" id="bs_datepicker_component_container">
                                            <input type="date" name="date" class="form-control" value="<?php if($view == true) echo date("Y-m-d",strtotime($data['date'])); else echo date("Y-m-d");?>" <?php echo $readonly; ?> >
                                            <label class="form-label">Date <span style="color: red;">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                        <label class="form-label" style="display: contents;">Donation <span style="color: red;">*</span></label>
                                            <select class="form-control" name="pay_for" id="pay_for" <?php echo $disable; ?>>
                                            <option value="">-- Select Donation --</option>
                                            <?php foreach($sett_don as $row) { ?>
                                            <option value="<?php echo $row['id']; ?>" <?php if($data['pay_for'] == $row['id']){ echo "selected"; } ?>><?php echo $row['name']; ?></option>
                                            <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
								<div class="col-sm-2">
									<div class="form-group form-float">
										<div class="form-line focused">
											<input type="text" id="targetamt" name="targetamt" class="form-control" value="0" readonly="">
											<label class="form-label">Target Amount </label>
										</div>
									</div>
								</div>
								<div class="col-sm-2">
									<div class="form-group form-float">
										<div class="form-line focused">
											<input type="text" id="collectedamt" name="collectedamt" class="form-control" value="0" readonly="">
											<label class="form-label">Collected Amount </label>
										</div>
									</div>
								</div>
								<div class="col-sm-2 bal_amnt_div">
									<div class="form-group form-float">
										<div class="form-line focused">
											<input type="text" id="balanceamt" class="form-control" value="0" readonly="">
											<label class="form-label">Balance Amount </label>
										</div>
									</div>
								</div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-sm-3">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" name="name" class="form-control" value="<?php echo $data['name'];?>" <?php echo $readonly; ?> >
                                            <label class="form-label">Name <span style="color: red;">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text"  name="address" class="form-control" value="<?php echo $data['address'];?>" <?php echo $readonly; ?> >
                                            <label class="form-label">Address</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" name="mobile" class="form-control" value="<?php echo $data['mobile'];?>" <?php echo $readonly; ?> >
                                            <label class="form-label">Mobile Number</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="email" name="email" class="form-control" value="<?php echo $data['email'];?>" <?php echo $readonly; ?> >
                                            <label class="form-label">Email Address</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-sm-3">
                                    <div class="form-group form-float">
                                        <div class="form-line" id="dom">
                                            <input type="date" name="dob" class="form-control" value="<?php echo date("Y-m-d");?>" >
                                            <label class="form-label">DOB <span style="color: red;"></span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" name="description" class="form-control" value="<?php echo $data['description'];?>" <?php echo $readonly; ?> >
                                            <label class="form-label">Remarks</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="number" step="0.1" name="amount" class="form-control" step=".01"  value="<?= $data['amount'] ?>" <?php echo $readonly; ?>>
                                            <label class="form-label">Amount <span style="color: red;">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <select class="form-control" name="paymentmode" id="paymentmode" <?php echo $disable; ?>>
                                                <!--option value="0">Select</option-->
                                                <?php foreach($payment_modes as $payment_mode) { ?>
                                                <option value="<?php echo $payment_mode['id']; ?>" <?php if(!empty($data['payment_mode'])){ if($data['payment_mode'] == $payment_mode['id']){ echo "selected"; } } ?>><?php echo $payment_mode['name'];?></option>
                                                <?php } ?>
                                            </select>
                                            <label class="form-label">Payment Mode <span style="color: red;">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                
                                <?php if($view != true) { ?>
                                <div class="col-sm-12" align="center">
                                    <input  type="checkbox" checked="checked" id="print" name="print" value="Print">
									<label for ='print'> Print &nbsp;&nbsp; </label>
									<label id="submit" class="btn btn-success btn-lg waves-effect">SAVE</label>
                                    <label id="clear" class="btn btn-primary btn-lg waves-effect">CLEAR</button>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                        </div>
                        </form>
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
<style>
.bal_amnt_div{
	display: none;
}
</style>
<script>
    $("#clear").click(function(){
        $("input").val("");
    });
	$('#pay_for').on('change', function(){
		var setting_id = this.value;
		$.ajax({
            type:"POST",
            url: "<?php echo base_url(); ?>/donation/get_donation_amount",
            data: {setting_id, setting_id},
			dataType: 'json',
            success:function(data){
                console.log(data.data);
				if(typeof data.data != 'undefined'){
					$('#targetamt').val(data.data.total_amount);
					$('#collectedamt').val(data.data.collected_amount);
					var balance_amount = parseFloat(data.data.total_amount) - parseFloat(data.data.collected_amount);
					if(balance_amount >= 0){
						$('.bal_amnt_div').show();
						$('#balanceamt').val(balance_amount);
					}else $('.bal_amnt_div').hide();
				}else{
					$('#targetamt').val(0);
					$('#collectedamt').val(0);
					$('#balanceamt').val(0);
					$('.bal_amnt_div').hide();
				}
            },
			error:function(err){
				console.log('err');
				console.log(err);
				$('#targetamt').val(0);
				$('#collectedamt').val(0);
				$('#balanceamt').val(0);
				$('.bal_amnt_div').hide();
			}
        });
	});
    $("#submit").click(function(){
        $.ajax
        ({
            type:"POST",
            url: "<?php echo base_url(); ?>/donation/save",
            data: $("form").serialize(),
            beforeSend: function() {    
                $('input[type=submit]').prop('disabled', true);
                $("#loader").show();
                $("#submit").attr("disabled", true);
            },
            success:function(data)
            {
                obj = jQuery.parseJSON(data);
                if(obj.err != ''){
                    $('#alert-modal').modal('show', {backdrop: 'static'});
                    $("#spndeddelid").text(obj.err);
                }else{					
					if ($("#print").prop('checked')==true)	
						{
							printData(obj.id);
						}
						else 
							window.location.reload(true);
                }
            },
            complete:function(data){
                // Hide image container
                $('input[type=submit]').prop('disabled', false);
                $("#loader").hide();
                $("#submit").attr("disabled", false);
            }
        });
    });  

    function printData(id) {
        $.ajax({
            url: "<?php echo base_url(); ?>/donation/print_page/"+id,
            type: 'POST',
            success: function (result) {
                //console.log(result)
                popup(result);
            }
        });
    }

    //setTimeout(popup(data), 500000);
	function popup(data)
    {
        var frame1 = $('<iframe />');
        frame1[0].name = "frame1";
        frame1.css({"position": "absolute", "top": "-1000000px"});
		window.frames["frame1"] = frame1;
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
            window.frameDoc.focus();
            //window.frameDoc.print();
            frame1.remove();
            window.location.reload(true);
        }, 500);
        //window.location.replace("<?php echo base_url();?>/donation");
		//window.location.reload(true);
        //return true;
    }

</script>