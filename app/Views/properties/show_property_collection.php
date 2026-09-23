<?php        
$db = db_connect();
function getMonthsInRange_internal($startDate, $endDate)
{
    $months = array();
    while (strtotime($startDate) <= strtotime($endDate)) {
        $months[] = date('Y-m', strtotime($startDate));
        // Set date to 1 so that new month is returned as the month changes.
        $startDate = date('01 M Y', strtotime($startDate . '+ 1 month'));
    }
    return $months;
}
?>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
        <h2>Property<small>Property / <b>History</b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row">
                            <div class="col-md-8">
                                <form action="<?php echo base_url(); ?>/properties/print_property_collection_history" method="post" target="_blank">
                                    <input type="hidden" value="<?php echo $properties['id']; ?>" name="collection_prop_id" id="collection_prop_id">
                                    <button type="submit" class="btn btn-primary btn-lg waves-effect" id="submit">Print</button>
                                </form>
                            </div>
                            <div class="col-md-4" align="right">
                                <a href="<?php echo base_url(); ?>/properties/property_collection_report">
                                    <button type="button" class="btn bg-deep-purple waves-effect">List</button>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="body">
                        <h3 class="col-md-12" style="font-size: 15px;text-transform: uppercase;">Property Details</h3>
                        <div class="table-responsive col-md-12" style="background:#FFF; float:none;">
                            <table class="table table-bordered">
                                <tr>
                                    <td style="background: #9e9e9e0a;font-weight:bold;">Name</td>
                                    <td><?php echo !empty($properties['name']) ? $properties['name'] : ""; ?></td>
                                    <td style="background: #9e9e9e0a;font-weight:bold;">Lot No</td>
                                    <td><?php echo !empty($properties['lot_no']) ? $properties['lot_no'] : ""; ?></td>
                                    <td style="background: #9e9e9e0a;font-weight:bold;">Area</td>
                                    <td><?php echo !empty($properties['area']) ? $properties['area'] : ""; ?></td>
                                </tr>
                                <tr>
                                    <td style="background: #9e9e9e0a;font-weight:bold;">Square Feet</td>
                                    <td ><?php echo !empty($properties['square_feet']) ? $properties['square_feet'] : ""; ?></td>
                                    <td style="background: #9e9e9e0a;font-weight:bold;">Due Date</td>
                                    <td>
                                        <?php 
                                        $property_due_date = $db->table('property_due_date')->where('id', $properties['due_date'])->get()->getRowArray();
                                        $property_due_date_name = !empty($property_due_date['name']) ? $property_due_date['name'] : "";
                                        echo $property_due_date_name; 
                                        ?>
                                    </td>
                                    <td style="background: #9e9e9e0a;font-weight:bold;">Amount</td>
                                    <td><?php echo !empty($properties['amount']) ? $properties['amount'] : ""; ?></td>
                                </tr>
                                <tr>
                                    <td style="background: #9e9e9e0a;font-weight:bold;">Category</td>
                                    <td>
                                        <?php 
                                        $property_category_row = $db->table('property_category')->where('id', $properties['property_category_id'])->get()->getRowArray();
                                        $property_category_name = !empty($property_category_row['name']) ? $property_category_row['name'] : "";
                                        echo $property_category_name; 
                                        ?>
                                    </td>
                                    <td style="background: #9e9e9e0a;font-weight:bold;">Purchased Year</td>
                                    <td><?php echo !empty($properties['purchased_year']) ? $properties['purchased_year'] : ""; ?></td>
                                    <td style="background: #9e9e9e0a;font-weight:bold;">Rental Amount</td>
                                    <td><?php echo !empty($properties['rental_value']) ? $properties['rental_value'] : ""; ?></td>
                                </tr>
                                <tr>
                                    <td style="background: #9e9e9e0a;font-weight:bold;">Rental Type</td>
                                    <td colspan="5">
                                        <?php 
                                        $rental_type_row = $db->table('rental_type')->where('id', $properties['rental_type'])->get()->getRowArray();
                                        $rental_type_name = !empty($rental_type_row['name']) ? $rental_type_row['name'] : "";
                                        echo $rental_type_name; 
                                        ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <h3 class="col-md-12" style="font-size: 15px;text-transform: uppercase;margin-top: 0px;">Property Tennant Details</h3>

                        <div class="table-responsive col-md-12 det" style="background:#FFF; float:none;">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th style="text-align:center;">Due Month</th>
                                        <th style="text-align:center;">Payment Mode</th>
                                        <th style="text-align:center;">Cheque /<br> Transaction Date</th>
                                        <th style="text-align:center;">Cheque /<br> Ref No</th>
                                        <th style="text-align:center;">Paid Date</th>
                                        <th style="text-align:center;">Amount</th>
                                        <th style="text-align:center;">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $property_id = $properties['id'];
                                    $propery_tennant_details = $db->query("SELECT tennant.name as tennant_name,tennant_property.due_start_month,tennant_property.start_date,tennant_property.end_date,tennant_property.status,tennant_property.id as tenn_prop_id,tennant.phonecode,tennant.phone,tennant.email,tennant.company FROM tennant_property JOIN tennant ON tennant.id = tennant_property.tennant_id WHERE tennant_property.property_id = $property_id ")->getResultArray();
                                    if(count($propery_tennant_details) > 0){
                                        foreach($propery_tennant_details as $row){
                                            $phonecode = !empty($row['phonecode']) ? $row['phonecode'] : "";
                                            $phone = !empty($row['phone']) ? $row['phone'] : "";
                                            $email = !empty($row['email']) ? $row['email'] : "";
                                            $company = !empty($row['company']) ? $row['company'] : "";
                                    ?>
                                    <tr>
                                        <td colspan="7">
                                            <p style="font-weight:bold;font-size: 16px;text-transform: uppercase;margin: 7px 0px;">
                                            NAME : 
                                            <?php echo $row['tennant_name']; ?> || 
                                            DUE PERIODS : 
                                            [ <?php echo date('d-m-Y', strtotime($row['start_date'])); ?> - <?php echo date('d-m-Y', strtotime($row['end_date'])); ?> ] ||
                                            Status : 
                                            <?php  
                                            if($row['status'] == '1'){
                                            ?>
                                                <span style="background: #4CAF50;padding: 2px 5px;color: #fff;font-size: 12px;font-weight: bold;">OCCUPIED</span>
                                            <?php 
                                            }
                                            if($row['status'] == '0'){
                                            ?>
                                                <span style="background: #f44336d6;padding: 2px 5px;color: #fff;font-size: 12px;font-weight: bold;">VACANT</span>
                                            <?php
                                            }
                                            ?>
                                            </p>
                                            <p style="font-size: 13px;text-transform: uppercase;margin: 3px 0px;">
                                            <span>Phone No : <?php echo $phonecode."".$phone; ?> || Email : <?php echo $email; ?> || Company : <?php echo $company; ?></span>
                                            </p>
                                        </td>
                                    </tr>
                                    <?php
                                            //$start_time = strtotime($row['start_date']);
                                            $min_month = date("Y-m", strtotime($row['due_start_month']));
                                            $max_month = date("Y-m", strtotime($row['end_date']));
                                            $start_month = $min_month."-01";
						                    $end_month = $max_month."-01";
                                            $available_till_month = getMonthsInRange_internal($start_month,$end_month);
                                           // var_dump($available_till_month);
                                            $ten_prp_id = $row['tenn_prop_id'];
                                            $pt_payment_row = $db->query("SELECT rental.month_year,rental.amount,rental.payment_mode FROM tennant_property JOIN tennant ON tennant.id = tennant_property.tennant_id JOIN rental ON rental.tenn_prop_id = tennant_property.id  WHERE rental.property_id = $property_id and rental.tenn_prop_id = $ten_prp_id ")->getRowArray();
                                            $amount = !empty($pt_payment_row['amount']) ? $pt_payment_row['amount'] : "";
                                            
                                            if(count($available_till_month) > 0){
                                                foreach($available_till_month as $res){

                                                    $check_payment_status = $db->query("SELECT rental.amount,rental.created_at,rental.cheque_date,rental.cheque_no,rental.transaction_date,rental.ref_no,rental.payment_mode FROM tennant_property JOIN tennant ON tennant.id = tennant_property.tennant_id JOIN rental ON rental.tenn_prop_id = tennant_property.id  WHERE rental.property_id = $property_id and rental.tenn_prop_id = $ten_prp_id and rental.month_year = '$res' ")->getResultArray();
                                                   // var_dump($property_id)."<br>";
                                                   // var_dump($ten_prp_id)."<br>";
                                                    //var_dump($res)."<br>";

                                                    if(count($check_payment_status) > 0){
                                                        $amount_paid = $check_payment_status[0]['amount'];
                                                        $paid_status = '<span style="background: #4CAF50;padding: 2px 5px;color: #fff;font-size: 12px;font-weight: bold;">PAID</span>';
                                                        $paid_date = date("d-m-Y", strtotime($check_payment_status[0]['created_at']));

                                                        $property_payment_mode_row = $db->table('payment_mode')->select('name')->where('id', $check_payment_status[0]['payment_mode'])->get()->getRowArray();
                                                        if(strtolower($property_payment_mode_row['name']) == "online"){
                                                            $cheque_trans_date = !empty($check_payment_status[0]['transaction_date']) ? date('d-m-Y',strtotime($check_payment_status[0]['transaction_date'])) : "";
                                                        }
                                                        else if(strtolower($property_payment_mode_row['name']) == "cheque"){
                                                            $cheque_trans_date = !empty($check_payment_status[0]['cheque_date']) ? date('d-m-Y',strtotime($check_payment_status[0]['cheque_date'])) : "";
                                                        }
                                                        else{
                                                            $cheque_trans_date = "";
                                                        }

                                                        if(strtolower($property_payment_mode_row['name']) == "online"){
                                                            $cheque_ref_no = !empty($check_payment_status[0]['ref_no']) ? $check_payment_status[0]['ref_no'] : "";
                                                        }
                                                        else if(strtolower($property_payment_mode_row['name']) == "cheque"){
                                                            $cheque_ref_no = !empty($check_payment_status[0]['cheque_no']) ? $check_payment_status[0]['cheque_no'] : "";
                                                        }
                                                        else{
                                                            $cheque_ref_no = "";
                                                        }
                                                        $property_payment_mode_name = !empty($property_payment_mode_row['name']) ? $property_payment_mode_row['name'] : "";
                                                    }
                                                    else{
                                                        $amount_paid = '0.00';
                                                        $paid_status = '<span style="background: #f44336d6;padding: 2px 5px;color: #fff;font-size: 12px;font-weight: bold;">UNPAID</span>';
                                                        $paid_date = "";
                                                        $cheque_ref_no = "";
                                                        $cheque_trans_date = "";
                                                        $property_payment_mode_name = "";
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td style="text-align:center;"><?php echo date("F, Y", strtotime($res)); ?></td>
                                                        <td style="text-align:center;">
                                                            <?php echo $property_payment_mode_name; ?>
                                                        </td>
                                                        <td style="text-align:center;">
                                                            <?php echo $cheque_trans_date; ?>
                                                        </td>
                                                        <td style="text-align:center;">
                                                            <?php echo $cheque_ref_no; ?>
                                                        </td>
                                                        <td style="text-align:center;"><?php echo $paid_date; ?></td>
                                                        <td style="text-align:center;"><?php echo $amount_paid; ?></td>
                                                        <td style="text-align:center;">
                                                            <?php echo $paid_status; ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <br>
                        <br>
                        <br>
                        <br>
                    </div>
				</div>
            </div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function(){
        $('#datatables').DataTable({dom: 'Bfrtip'});
    });
</script>