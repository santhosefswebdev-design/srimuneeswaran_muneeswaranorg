<?php $booking_calendar_range_year = booking_calendar_range_year($_SESSION['booking_range_year']); ?>
<style>
    /*.thead{
        color: #fff;
        background-color:#EFEFEF;
    }*/
    a:hover { text-decoration: none; }
	.card .body .col-xs-3, .card .body .col-sm-3, .card .body .col-md-3, .card .body .col-lg-3 {
		 margin-bottom: 0px; 
	}
	.form-group { margin-bottom: 0; }
	.table1{ border:1px solid #CCCCCC; }
	.table1 tr th { background-color:#EFEFEF; padding:5px; min-width:130px; font-size:16px; }
	.table1 tr td:first-child { padding:5px; text-align:left; }
	.table1 tr td { padding:5px; text-align:right;  }
	/*.table1 tr td:last-child { font-weight:bold;  }*/ 
</style>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2> ACCOUNTS<small>Accounts / Income and Expenditure Statement</small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row"><div class="col-md-8"><h2>Income and Expenditure  Statement</h2></div>
                        </div>
                    </div>
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
                        <!-- <div calss="row">
                            <form action="<?php echo base_url();?>/accountreport/profile_loss" method="post">
                                <div class="col-md-12">
                                    <div class="col-md-2 col-sm-3">
                                        <div class="form-group form-float">
                                            <div class="form-line focused">
                                                <input type="date" name="sdate" id="sdate" class="form-control" value="<?php echo date("Y-m-d", strtotime($sdate)); ?>" />
                                                <label class="form-label">From</label>
                                            </div>                                                        
                                        </div>                                            
                                    </div>
                                    <div class="col-md-2 col-sm-3">
                                        <div class="form-group form-float">
                                            <div class="form-line focused">
                                                <input type="date" name="edate" id="edate" class="form-control" value="<?php echo date("Y-m-d", strtotime($edate)); ?>" />
                                                <label class="form-label">To</label>
                                            </div>                                                        
                                        </div>                                            
                                    </div> 
                                    <div class="col-md-2 col-sm-3">
                                        <div class="form-group form-float">
                                            <button type="submit" id="submit" class="btn btn-success">Submit</button>
                                            <a target="_blank" class="btn btn-primary" href="<?php echo base_url(); ?>/accountreport/print_profit_loss">Print</a>
                                        </div>                                            
                                    </div>
                                </div>
                            </form>
                        </div> -->
                        <div calss="row">
                            <form id="dateform" method="post">
                                <div class="col-md-12">
                                    <div class="col-md-2 col-sm-3">
                                        <div class="form-group form-float">
                                            <div class="form-line focused">
                                                <select class="form-control" name="breakdown" id="breakdown">
                                                    <option value="daily" <?php if($breakdown == "daily"){ echo 'selected'; } ?>>Daily</option>
                                                    <option value="monthly" <?php if($breakdown == "monthly"){ echo 'selected'; } ?>>Monthly</option>
                                                </select>
                                                <label class="form-label">Breakdown</label>
                                            </div>                                                        
                                        </div>                                            
                                    </div>
                                    <div class="col-md-2 col-sm-3" id="bd_daily_startdate_hide_show" style="display:<?php if($breakdown == 'daily'){ echo 'block'; }else{ echo 'none';} ?>;">
                                        <div class="form-group form-float">
                                            <div class="form-line focused" id="bs_datepicker_container">
                                                <input type="date" name="sdate" id="sdate" class="form-control" value="<?php echo date("Y-m-d", strtotime($sdate)); ?>" max="<?php echo $booking_calendar_range_year; ?>">
                                                <label class="form-label">From</label>
                                            </div>                                                        
                                        </div>                                            
                                    </div>
                                    <div class="col-md-2 col-sm-3" id="bd_daily_enddate_hide_show" style="display:<?php if($breakdown == 'daily'){ echo 'block'; }else{ echo 'none';} ?>;">
                                        <div class="form-group form-float">
                                            <div class="form-line focused" id="bs_datepicker_container">
                                                <input type="date" name="edate" id="edate" class="form-control" value="<?php echo date("Y-m-d", strtotime($edate)); ?>" max="<?php echo $booking_calendar_range_year; ?>">
                                                <label class="form-label">To</label>
                                            </div>                                                        
                                        </div>                                            
                                    </div>
                                    <div class="col-md-2 col-sm-3" id="bd_monthly_startdate_hide_show" style="display:<?php if($breakdown == 'monthly'){ echo 'block'; }else{ echo 'none';} ?>;">
                                        <div class="form-group form-float">
                                            <div class="form-line focused" >
                                                <input type="month" name="smonthdate" id="smonthdate" class="form-control" value="<?php echo date("Y-m", strtotime($smonthdate)); ?>" max="<?php echo date('Y-m', strtotime($booking_calendar_range_year)); ?>">
                                                <label class="form-label">From</label>
                                            </div>                                                        
                                        </div>                                            
                                    </div>
                                    <div class="col-md-2 col-sm-3" id="bd_monthly_enddate_hide_show" style="display:<?php if($breakdown == 'monthly'){ echo 'block'; }else{ echo 'none';} ?>;">
                                        <div class="form-group form-float">
                                            <div class="form-line focused" >
                                                <input type="month" name="emonthdate" id="emonthdate" class="form-control" value="<?php echo date("Y-m", strtotime($emonthdate)); ?>" max="<?php echo date('Y-m', strtotime($booking_calendar_range_year)); ?>">
                                                <label class="form-label">To</label>
                                            </div>                                                        
                                        </div>                                            
                                    </div>
									<div class="col-md-2 col-sm-2">
                                        <div class="form-group form-float">
                                            <select class="form-control search_box" data-live-search="true" name="fund_id" id="fund_id">
												<option value="">Select Job</option>
												<?php
												if(!empty($funds))
												{
													foreach($funds as $fund)
													{
												?>
													<option value="<?php echo $fund["id"]; ?>" <?php if($fund_id == $fund["id"]){ echo "selected"; } ?>><?php echo $fund['name'] . '(' . $fund['code'] . ")"; ?> </option>
												<?php
													}
												}
												?>
											</select>                                                   
                                        </div>                                            
                                    </div>
                                    <div class="col-md-2 col-sm-3">
                                        <div class="form-group form-float">
                                            <button type="submit" id="submit" class="btn btn-success">Submit</button>
                                        </div>                                            
                                    </div>
                                    <!-- <div class="col-md-2 col-sm-3">
                                        <div class="form-group form-float">
                                            <button type="button" id="analytics" class="btn btn-info">Analytics</button>
                                        </div>
                                    </div> -->
                                </div>
                            </form>
							<!-- <form id="analytics_form" style="display: none;" action="<?php echo base_url(); ?>/accountreport/profit_loss_analytics" method="post">
                                
                                <input type="hidden" name="breakdown" value="<?php echo $breakdown; ?>">
                                <input type="hidden" name="sdate" value="<?php echo $sdate; ?>">
                                <input type="hidden" name="edate" value="<?php echo $edate; ?>">
                                <input type="hidden" name="smonthdate" value="<?php echo $smonthdate; ?>">
                                <input type="hidden" name="emonthdate" value="<?php echo $emonthdate; ?>">
                                <input type="hidden" name="fund_id" value="<?php echo $fund_id; ?>">
                            </form> -->
                            <form style="display: none;" target="_blank" id="print_sheet" action="<?php echo base_url(); ?>/accountreport/print_profit_loss" method="post">
                               <input type="hidden" name="fdate" id="fdate" class="form-control" value="<?= $sdate; ?>">
                                <input type="hidden" name="tdate" id="tdate" class="form-control" value="<?= $edate; ?>">
                                <input type="hidden" name="fmonthdate" id="fmonthdate" class="form-control" value="<?= date("Y-m", strtotime($smonthdate)); ?>">
                                <input type="hidden" name="tmonthdate" id="tmonthdate" class="form-control" value="<?= date("Y-m", strtotime($emonthdate)); ?>">
                                <input type="hidden" name="pbreakdown" id="pbreakdown" class="form-control" value="<?= $breakdown; ?>">
                                <input type="hidden" name="fund_id_print" id="fund_id_print" class="form-control" value="<?= $fund_id; ?>">
                            </form>
                         </div>
                        <div class="row"><div class="table-responsive col-md-12">
                            <table class="table1" border="1" style="width:auto !important; overflow:auto;">
                                <thead>
                                    <tr>
                                        <th style="width: 300px; min-width:300px !important;" align="left" class="thead">Account Name</th>
                                        <?php
                                        if($breakdown == 'monthly'){
                                            foreach($getMonthsInRange as $getmonth){
                                        ?>
                                        <th class="thead" style="text-align:right; width:130px;" align="right"><?php echo date('F, Y',strtotime($getmonth['date'])); ?></th>
                                        <?php
                                            }
                                        ?>
                                        <th class="thead" style="text-align:right; width:130px;" align="right">Total</th>
                                        <?php
                                        }
                                        else{
                                        ?>
                                        <th class="thead" style="text-align:right; width:130px;" align="right">Amount</th>
                                        <?php
                                        }
                                        ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($table as $row) { ?>
                                        <?php echo $row; ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div><h1 align="center" style="margin-top: -19px;"><?php echo $profit; ?></h1></div>
                        <div class="row">
                            <div class="col-md-12" align="center">
                                <label id="print" class="btn btn-primary">Print</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $("#print").click(function(){
        $("#print_sheet").submit();
    });

    $('document').ready(function() {
        $('#breakdown').change(function(){
            if($('#breakdown').val() == 'monthly') {
                $('#bd_monthly_startdate_hide_show').show();
                $('#bd_monthly_enddate_hide_show').show();
                $('#bd_daily_startdate_hide_show').hide();
                $('#bd_daily_enddate_hide_show').hide();
            }
            else {
                $('#bd_daily_startdate_hide_show').show(); 
                $('#bd_daily_enddate_hide_show').show(); 
                $('#bd_monthly_startdate_hide_show').hide(); 
                $('#bd_monthly_enddate_hide_show').hide();
            } 
        });
    });
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('analytics').addEventListener('click', function () {
        // Submit the hidden analytics form
        document.getElementById('analytics_form').submit();
    });
});
</script>