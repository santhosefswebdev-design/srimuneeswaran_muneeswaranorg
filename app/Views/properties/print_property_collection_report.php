<?php        
$db = db_connect();
?>
<title><?php echo $_SESSION['site_title']; ?></title>
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
<table align="center"style="width: 100%;max-width: 800px;">
<tr><td colspan="2">
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
<h3 style="text-align:center;"> Property Collection Report - <?php echo date('d/m/Y'); ?></h3>

    <table class="tab" border="1" width="100%" align="center" id="datatables">
        <thead>
                                        <tr>
											<th>SNo</th>
											<th>Name</th>
											<!--th>Property Category</th-->
											<th>Property No</th>
											<th>Monthly Rental</th>
                                            <th>Tenant Name</th>
											<th>⁠Due Months<br> Count</th>
                                            <th style="width:20%;">⁠Outstanding<br> Amount</th>
											<th>Last Paid<br> Due Month</th>
										</tr>
        </thead>
        <tbody>
        <?php
        if (!empty($res)) {
            $i = 1;
            $total_outstanding_amt = 0;
			foreach ($res as $r) {
				$property_category_row = $db->table('property_category')->where('id', $r['property_category_id'])->get()->getRowArray();
				$property_category_name = !empty($property_category_row['name']) ? $property_category_row['name'] : "";

				$totalrentalamount = getpropertyTotalrentalamount($r['propid']);
				$paid_amt = getpropertyTotalrentalpaidamount($r['propid']);
				$pending_amt = $totalrentalamount - $paid_amt;

				$duemonthcount = getpropertyduemonthcount($r['tns_propid'], $r['propid']);
				$lastpaidmonth = getproperty_lastpaidmonth($r['tns_propid'], $r['propid']);
                $total_outstanding_amt = $total_outstanding_amt + $duemonthcount['unpaid_amount'];
            ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo $r['property_name']; ?></td>
                <td><?php echo $r['lot_no']; ?></td>
                <td><?php echo $r['rental_value']; ?></td>
                <td><?php echo $r['tennant_name']; ?></td>
                <td><?php echo $duemonthcount['unpaid_count']; ?></td>
                <td><?php echo number_format($duemonthcount['unpaid_amount'], 2); ?></td>
                <td><?php echo $lastpaidmonth; ?></td>
            </tr>
        <?php
			}
		}
        ?>
        </tbody>
        <!--tfoot>
            <tr>
                <td colspan="6" style="text-align:right;padding:0px 20px;">
                    <b>TOTAL OUTSTANDING</b>
                </td>
                <td>
                <b>RM <?php //echo number_format($total_outstanding_amt, 2); ?></b>
                </td>
                <td></td>
            </tr>
        </tfoot-->
    </table>
</td>
</tr>
</table>
<div style="width:100%">
    <p style="text-align:center;font-size:20px;"><b>TOTAL OUTSTANDING</b> <b>RM <?php echo number_format($total_outstanding_amt, 2); ?></b></p>
</div>
<script>
window.print();
</script>