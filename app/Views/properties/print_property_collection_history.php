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
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Barlow&display=swap" rel="stylesheet">
<style>
body { font-family: 'Barlow', sans-serif; }
table { border-collapse:collapse; }
.inner_table tr:nth-child(even) { background:#F3F3F3; }
.inner_table tr:last-child { background:#e2dfdf; }
.tab tr th, .tab tr td { text-align:center; }
</style>
<table style="width:100%">
                    <tr><td width="15%" align="left"><img src="<?php echo base_url(); ?>/uploads/main/<?php echo $_SESSION['logo_img']; ?>" style="width:120px;"
									align="left"></td>
							<td width="85%" align="left">
								<h3 style="text-align:center;margin-bottom: 0;"><?php echo $_SESSION['name_tamil']; ?></h3>
								<p style="text-align:center; font-size:13px; margin:0;"><?php echo $_SESSION['city_tamil']; ?> <?php echo $_SESSION['since_tamil']; ?>
								<h2 style="text-align:center;margin-bottom: 0; margin-top:2px;"><?php echo $_SESSION['site_title']; ?></h2>
								<p style="text-align:center; font-size:16px; margin:0px;"><?php echo $_SESSION['city']; ?> <span
										style="position:absolute; right:8.5%;"><?php echo $_SESSION['since_eng']; ?></span><br>
									<?php echo $_SESSION['address1']; ?>, <?php echo $_SESSION['address2']; ?>,
									<?php echo $_SESSION['postcode']; ?> <?php echo $_SESSION['city']; ?> <br>
									Email : <?php echo $_SESSION['email']; ?>, Tel : <?php echo $_SESSION['telephone']; ?>, Whatsapp :
									<?php echo $_SESSION['mobile']; ?><br>
									Website : <?php echo $_SESSION['website']; ?>, ISO <?php echo $_SESSION['iso']; ?>
								</p>
							</td>
						</tr>
					</table>
    </td></tr>
    <tr><td colspan="2"><hr></td></tr>
<tr>
    <td colspan="2">
        <h3 style="text-align:center;"> PROPERTY DETAIL </h3>
    </td>
</tr>
<tr>
    <td colspan="2">
        <table class="tab" border="1" width="100%" align="center">
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
                <td colspan="5" style="text-align:left;">
                    <?php 
                    $rental_type_row = $db->table('rental_type')->where('id', $properties['rental_type'])->get()->getRowArray();
                    $rental_type_name = !empty($rental_type_row['name']) ? $rental_type_row['name'] : "";
                    echo $rental_type_name; 
                    ?>
                </td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td colspan="2">&nbsp;
        
    </td>
</tr>
<tr>
    <td colspan="2">
        <h3 style="text-align:center;"> PROPERTY TENNANT DETAILS </h3>
    </td>
</tr>
<tr>
    <td colspan="2">
        <table border="1" width="100%" >
            <tr>
                <th style="text-align:center;">Due Month</th>
                <th style="text-align:center;">Payment Mode</th>
                <th style="text-align:center;">Cheque /<br> Transaction Date</th>
                <th style="text-align:center;">Cheque /<br> Ref No</th>
                <th style="text-align:center;">Paid Date</th>
                <th style="text-align:center;">Amount</th>
                <th style="text-align:center;">Status</th>
            </tr>
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
                        OCCUPIED
                    <?php 
                    }
                    if($row['status'] == '0'){
                    ?>
                        VACANT
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
                            $paid_status = 'PAID';
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
                            $paid_status = 'UNPAID';
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
        </table>
    </td>
</tr>
</table>

<script>
window.print();
</script>