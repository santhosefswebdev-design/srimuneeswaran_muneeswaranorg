<title><?php echo $_SESSION['site_title']; ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Barlow&display=swap" rel="stylesheet">
<style>
body { font-family: 'Barlow', sans-serif; }
table { border-collapse:collapse; }
table td, table th { padding:5px; text-align:center; }
.inner_table tr:nth-child(even) { background:#F3F3F3; }
.inner_table tr:last-child { background:#e2dfdf; }
.print_header *{
	color: #fff;
}
.print_header{
	
    margin: 0 auto;
    position: relative;
}
.since{
	position: absolute;
    font-size: 10px;
    z-index: 9999;
    right: 55px;
}
</style>
<table border="1" align="center" style="border-collapse: collapse; width: 100%;">
	<tbody>
		<tr>
			<td width="15%" style="border: 1px solid #000; vertical-align: top;">
				<img src="<?php echo base_url(); ?>/uploads/main/<?php echo $temp_details['image']; ?>" style="width:120px;" align="left">
			</td>
			<td width="85%" style="padding: 0px; border: 1px solid #000;">
				<table style="width: 100%; border-collapse: collapse;">
					<tr>
						<td>
							<h2 style="text-align:center; margin-bottom: 0; font-size: 18px;">
								<?php echo $temp_details['name']; ?>
							</h2>
						</td>
					</tr>
					<tr>
						<td>
							<p style="text-align:center; font-size:16px; margin:0;">
								<?php echo $temp_details['address1']; ?>, <?php echo $temp_details['address2']; ?>
							</p>
						</td>
					</tr>
					<tr>
						<td>
							<p style="text-align:center; font-size:16px; margin:0;">
								<?php echo $temp_details['city'].'-'.$temp_details['postcode']; ?>
							</p>
						</td>
					</tr>
					<tr>
						<td>
							<p style="text-align:center; font-size:16px; margin:0;">
								Tel : <?= $temp_details['telephone']; ?>
							</p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2" style="width: 100%;">
				<h3 style="text-align:center;"> DEITY REPORT <?php echo date("d/m/Y", strtotime($fdate)).' - '.date("d/m/Y", strtotime($tdate)); ?></h3>
			</td>
		</tr>
	</tbody>
</table>

<?php 
if ($grp != '0' && $grp != '' ){
	echo ' - '.$grp;
}
?>
 
<h3 style="text-align:center;"> [From : <?= date('d-m-Y', strtotime($fdate)); ?> To <?= date('d-m-Y', strtotime($tdate));?>] </h3>
    <table border="1" width="100%" align="center">
        <thead>
            <tr>
                <th>SNO</th>
                <th width="15%">Date</th>
                <th>Product Name in English</th>
                <th>Product Name in Tamil</th>
                <th>Deity Name</th>
                <th>Quantity</th>
                
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php 
			
			// echo '<pre>';
			// print_r($grp);
			// die;
			$data['data'] = array();
			$total = 0; $i=1;foreach($data as $row) { 
                if($row['status'] == 1) $status = 'Booked';
                else if($row['status'] == 2) $status = 'Completed';
                else $status = 'Canceled';
                $amt = number_format((float)$row['rate'], 2, '.', '');
                if(!empty($row['name'])){
                ?>
            <tr>
                    <td><?= $i++;?></td>
                    <td><?= date('d-m-Y', strtotime($row['date'])); ?></td>
                    <td><?= $row['name_eng']; ?></td>
                    <td><?= $row['name_tamil']; ?></td>
                    <td><?= $row['name']; ?></td>
                    <td><?= $row['qunt']; ?></td>
                    <!--<td align="right"><?= $row['rate']; ?></td>-->
                    <td><?= $row['rate']; ?></td>
            </tr>
            <?php $total += $amt; } } ?>
            <tr>
                    <td colspan="6" style="text-align:right !important;">Total</td>
                    <td align="right"><?= number_format((float)$total, 2, '.', '');  ?></td>
            </tr>
        </tbody>
    </table>

<script>
window.print();
</script>


