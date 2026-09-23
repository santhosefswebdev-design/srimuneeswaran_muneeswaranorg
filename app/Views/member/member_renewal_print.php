<!DOCTYPE html>
<html>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Barlow&display=swap" rel="stylesheet">
<style>
@font-face {
font-family: "Baamini";           
src: url('<?php echo base_url(); ?>/assets/font/Baamini.ttf');
font-weight: normal;
font-style: normal;
} 
</style>
</head>
<body>
<style>
body { font-family: 'Barlow', sans-serif; }
table { border-collapse:collapse; }
table td, table th { padding:5px; text-align:center; }
.inner_table tr:nth-child(even) { background:#F3F3F3; }
.inner_table tr:last-child { background:#e2dfdf; }
</style>
<div style="width: 100%;max-width: 210mm;margin:0 auto;">
<table align="center">
<tr>
	<td colspan="2">
    <table style="width:100%">
        <tr><td width="15%" align="left"><img src="<?php echo base_url(); ?>/uploads/main/<?php echo $_SESSION['logo_img']; ?>" style="width:120px;" align="left"></td>
        <td width="85%" align="left">
        <h3 style="text-align:center;margin-bottom: 0;"><?php echo $_SESSION['name_tamil']; ?></h3>
        <p style="text-align:center; font-size:16px; margin:0;"><?php echo $_SESSION['city_tamil']; ?> <?php echo $_SESSION['since_tamil']; ?>
        <h2 style="text-align:center;margin-bottom: 0; margin-top:8px;"><?php echo $_SESSION['site_title']; ?></h2>
        <p style="text-align:center; font-size:16px; margin:0px;"><?php echo $_SESSION['city']; ?> <?php echo $_SESSION['since_eng']; ?><br><?php echo $_SESSION['address1']; ?>, <?php echo $_SESSION['address2']; ?>,
        <?php echo $_SESSION['postcode']; ?> <?php echo $_SESSION['city']; ?>  <br>
        Tel : <?php echo $_SESSION['telephone']; ?></p>
        </td></tr>
    </table>
	</td>
</tr>
<tr><td colspan="2"><hr></td></tr>
</table>
<div>
<h3 style="text-align:center;"> Member Renewal </h3>
 <?php 
	//var_dump($pdfdata['data']);
	//exit;
 ?>
<h3 style="text-align:center;"> [From : <?= date('d-m-Y', strtotime($fdate)); ?> To <?= date('d-m-Y', strtotime($tdate));?>] </h3>
    <table border="1" width="100%" align="center">
        <thead>
            <tr>
                <th>SNO</th>
                <th>Member Name</th>
                <th>Member No</th>
                <th>Member Type</th>
                <th>Renewal Start Date</th>
                <th>Renewal End Date</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php 
			if(!empty($member_data))
			{
                $total = 0; $i=1;
                foreach($member_data as $row) { 
                    $row['payment'] = !empty($row['renewal_amount']) ? $row['renewal_amount'] : $row['payment'];
                    $amt = number_format((float)$row['payment'], 2, '.', '');
                    ?>
                <tr>
                        <td><?= $i++;?></td>
                        <td><?= $row['name']; ?></td>
                        <td><?= $row['member_no']; ?></td>
                        <td><?= $row['tname']; ?></td>
                        <td><?= date('d/m/Y', strtotime($row['renewal_start_date'])); ?></td>
                        <td><?= date('d/m/Y', strtotime($row['renewal_end_date'])); ?></td>
                        <td><?= $row['payment']; ?></td>
                </tr>
                <?php $total += $amt; } ?>
                <tr>
                        <td colspan="6" style="text-align:right !important;">Total</td>
                        <td align="right"><?= number_format((float)$total, 2, '.', '');  ?></td>
                </tr>
            
            <?php
            }
            ?>
        </tbody>
    </table>
</div></div>
<script>
window.print();
</script>
</body>
</html>


 