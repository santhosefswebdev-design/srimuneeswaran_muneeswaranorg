<?php        
$db = db_connect();
?>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
        <h2>Tennant<small>Tennant / <b>History</b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row"><div class="col-md-8"></div>
                        <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/tennant"><button type="button" class="btn bg-deep-purple waves-effect">Tennancy List</button></a></div></div>
                    </div>
                    <div class="body">
                        <h3 class="col-md-12" style="font-size: 15px;text-transform: uppercase;">Tennant Details</h3>
                        <div class="table-responsive col-md-12" style="background:#FFF; float:none;">
                            <table class="table table-bordered">
                                <tr>
                                    <td style="background: #9e9e9e0a;font-weight:bold;">Name</td>
                                    <td><?php echo !empty($tennant['name']) ? $tennant['name'] : ""; ?></td>
                                    <td style="background: #9e9e9e0a;font-weight:bold;">Mobile No</td>
                                    <td>
                                        <?php 
                                            $phonecode = !empty($tennant['phonecode']) ? $tennant['phonecode'] : ""; 
                                            $phone = !empty($tennant['phone']) ? $tennant['phone'] : ""; 
                                            echo $phonecode."".$phone;
                                        ?>
                                    </td>
                                    <td style="background: #9e9e9e0a;font-weight:bold;">Email ID</td>
                                    <td><?php echo !empty($tennant['email']) ? $tennant['email'] : ""; ?></td>
                                </tr>
                                <tr>
                                    <td style="background: #9e9e9e0a;font-weight:bold;">Address</td>
                                    <td><?php echo !empty($tennant['address']) ? $tennant['address'] : ""; ?></td>
                                    <td style="background: #9e9e9e0a;font-weight:bold;">Business Name</td>
                                    <td><?php echo !empty($tennant['company']) ? $tennant['company'] : ""; ?></td>
                                    <td style="background: #9e9e9e0a;font-weight:bold;">Status</td>
                                    <td>
                                        <?php  
                                        if($tennant['status'] == '1'){
                                        ?>
                                            <span style="background: #4CAF50;padding: 2px 5px;color: #fff;font-size: 12px;font-weight: bold;">ACTIVE</span>
                                        <?php 
                                        }
                                        ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <h3 class="col-md-12" style="font-size: 15px;text-transform: uppercase;margin-top: 0px;">Tennant Property Details</h3>

                        <div class="table-responsive col-md-12 det" style="background:#FFF; float:none;">
                            <table class="table table-bordered table-striped table-hover dataTable" id="datatables">
                                <thead>
                                    <tr>
                                        <th>SNo</th>
                                        <th>Name</th>
                                        <th>Property Category</th>
                                        <th>Purchased Year</th>
                                        <th>Rental Amount</th>
                                        <th>Property Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $i=1;
                                    $tennant_id = $tennant['id'];
                                    $tennant_property_details = $db->query("SELECT properties.name as property_name,properties.property_category_id,properties.purchased_year,properties.rental_value,tennant_property.status FROM tennant_property JOIN properties ON properties.id = tennant_property.property_id WHERE tennant_property.tennant_id = $tennant_id ")->getResultArray();
                                    if(count($tennant_property_details) > 0){
                                        foreach($tennant_property_details as $row){
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $row['property_name']; ?></td>
                                        <td>
                                            <?php
                                            $property_category_row = $db->table('property_category')->where('id', $row['property_category_id'])->get()->getRowArray();
                                            $property_category_name = !empty($property_category_row['name']) ? $property_category_row['name'] : "";
                                            echo $property_category_name;
                                            ?>
                                        </td>
                                        <td><?php echo $row['purchased_year']; ?></td>
                                        <td><?php echo $row['rental_value']; ?></td>
                                        <td>
                                        <?php 
                                            if($row['status'] == '1'){
                                            ?>
                                                <span style="background:#4CAF50;padding: 2px 5px;color: #fff;font-size: 12px;font-weight: bold;">
                                                OCCUPIED</span>
                                            <?php
                                            }
                                            if($row['status'] == '0'){
                                            ?>
                                            <span style="background:#f44336d6;padding: 2px 5px;color: #fff;font-size: 12px;font-weight: bold;">
                                            VACANT</span>
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