<title><?php echo $_SESSION['site_title']; ?></title>
<?php        
$db = db_connect();
?>
<style>
body { font-family: 'Barlow', sans-serif; }
table { border-collapse:collapse; }
.inner_table tr:nth-child(even) { background:#F3F3F3; }
.inner_table tr:last-child { background:#e2dfdf; }
.tab tr th, .tab tr td { text-align:center; }
</style>
<?php 
//echo '<pre>'; print_r($pdfdata['data']); 
//exit;
?>
<table align="center"style="width: 100%;">
<tr><td colspan="2">
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
</td></tr>
<tr><td colspan="2"><hr></td></tr>
	<tr>
		<td colspan="2" style="width: 100%;">
			<h3 style="text-align:center;text-transform: uppercase;"> Rental List </h3>
		</td>
	</tr>
    </table>

    <table border="1" width="100%" align="center">
        <thead>
            <tr>
                <th>SNo.</th>
				<th>Property Name</th>
				<th>Month / Year</th>
				<th>Amount</th>
				<th>Payee Name</th>
            </tr>
        </thead>
		<tbody>
        <?php 
		$i = 1;
		foreach($data as $key => $row) {
		?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row['propertyname']; ?></td>
				<td><?php echo $row['month_year']; ?></td>
				<td><?php echo $row['amount']; ?></td>
				<td><?php echo $row['payee_name']; ?></td>
			</tr>
        <?php 
		$i++;
		} 
		?>
		</tbody>
    </table>
</br></br></br>


<script>
	/*
var css = '@page { size: landscape; }',
    head = document.head || document.getElementsByTagName('head')[0],
    style = document.createElement('style');

style.type = 'text/css';
style.media = 'print';

if (style.styleSheet){
  style.styleSheet.cssText = css;
} else {
  style.appendChild(document.createTextNode(css));
}

head.appendChild(style);
*/
window.print();
//window.onafterprint = window.close;
</script>
