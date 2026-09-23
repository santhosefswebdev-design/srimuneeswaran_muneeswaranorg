<?php        
$db = db_connect();
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
                        <div class="row"><div class="col-md-8"></div>
                        <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/properties"><button type="button" class="btn bg-deep-purple waves-effect">Properties List</button></a></div></div>
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
                                    <td colspan="3"><?php echo !empty($properties['square_feet']) ? $properties['square_feet'] : ""; ?></td>
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
                                    <td>
                                        <?php 
                                        $rental_type_row = $db->table('rental_type')->where('id', $properties['rental_type'])->get()->getRowArray();
                                        $rental_type_name = !empty($rental_type_row['name']) ? $rental_type_row['name'] : "";
                                        echo $rental_type_name; 
                                        ?>
                                    </td>
                                    <td style="background: #9e9e9e0a;font-weight:bold;">Due Date</td>
                                    <td>
                                        <?php 
                                        $property_due_date = $db->table('property_due_date')->where('id', $properties['due_date'])->get()->getRowArray();
                                        $property_due_date_name = !empty($property_due_date['name']) ? $property_due_date['name'] : "";
                                        echo $property_due_date_name; 
                                        ?>
                                    </td>
                                    <td style="background: #9e9e9e0a;font-weight:bold;">Property Status</td>
                                    <td>
                                        <?php 
                                        $property_status_row = $db->table('property_status')->where('id', $properties['property_status'])->get()->getRowArray();
                                        $property_status_name = !empty($property_status_row['name']) ? $property_status_row['name'] : "";
                                        if($properties['property_status'] == '1'){
                                        ?>
                                            <span style="background:<?php echo $property_status_row['color_code']; ?>;padding: 2px 5px;color: #fff;font-size: 12px;font-weight: bold;">
                                            <?php echo $property_status_name; ?></span>
                                        <?php
                                        }
                                        if($properties['property_status'] == '2'){
                                        ?>
                                        <span style="background:<?php echo $property_status_row['color_code']; ?>;padding: 2px 5px;color: #fff;font-size: 12px;font-weight: bold;">
                                            <?php echo $property_status_name; ?></span>
                                        <?php
                                        }
                                        if($properties['property_status'] == '3'){
                                        ?>
                                        <span style="background:<?php echo $property_status_row['color_code']; ?>;padding: 2px 5px;color: #fff;font-size: 12px;font-weight: bold;">
                                            <?php echo $property_status_name; ?></span>
                                        <?php
                                        }
                                        
                                        ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <h3 class="col-md-12" style="font-size: 15px;text-transform: uppercase;margin-top: 0px;">Property Tennant Details</h3>

                        <div class="table-responsive col-md-12 det" style="background:#FFF; float:none;">
                            <table class="table table-bordered table-striped table-hover dataTable" id="datatables">
                                <thead>
                                    <tr>
                                        <th>SNo</th>
                                        <th>Name</th>
                                        <th>Phone No</th>
                                        <th>Email ID</th>
                                        <th>Business Name</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Rental Start Month</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i=1;
                                    $property_id = $properties['id'];
                                    $propery_tennant_details = $db->query("SELECT tennant.name as tennant_name,tennant.phonecode,tennant.phone,tennant.email,tennant.company,tennant_property.start_date,tennant_property.end_date,tennant_property.due_start_month,tennant_property.status FROM tennant_property JOIN tennant ON tennant.id = tennant_property.tennant_id WHERE tennant_property.property_id = $property_id ")->getResultArray();
                                    if(count($propery_tennant_details) > 0){
                                        foreach($propery_tennant_details as $row){
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $row['tennant_name']; ?></td>
                                        <td><?php echo $row['phonecode']."".$row['phone']; ?></td>
                                        <td><?php echo $row['email']; ?></td>
                                        <td><?php echo $row['company']; ?></td>
                                        <td><?php echo date('d-m-Y', strtotime($row['start_date'])); ?></td>
                                        <td><?php echo date('d-m-Y', strtotime($row['end_date'])); ?></td>
                                        <td><?php echo date('F, Y', strtotime($row['due_start_month'])); ?></td>
                                        <td>
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
                                        </td>
                                    </tr>
                                    <?php
                                        $i++;
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