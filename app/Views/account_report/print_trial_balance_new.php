<title><?php echo $_SESSION['site_title']; ?></title>
<style>
table { border-collapse:collapse; }
.inner_table tr:nth-child(even) { background:#F3F3F3; }
.inner_table tr:last-child { background:#e2dfdf; }
.table tr th, .table tr td { text-align:center; }
table td { padding:5px; line-height:1.5em; }
h2 { font-size: 20px; }

.table1{ border:1px solid #CCCCCC; }
.table1 tr th { background-color:#EFEFEF; padding:5px; min-width:130px; font-size:16px; }
.table1 tr td { padding:5px; width: 130px; min-width:130px !important;  }
</style>
<tr><td colspan="2">
<table style="width:100%">
                    <tr><td width="15%" align="left"><img src="<?php echo base_url(); ?>/uploads/main/<?php echo $_SESSION['logo_img']; ?>"
        style="width:120px;" align="left"></td>
    <td width="85%" align="left">
      <!--<p style="text-align:center; font-size:12px;">ஓம் சக்தி</p>-->
      <h3 style="text-align:center;margin-bottom: 0;"><?php echo $_SESSION['name_tamil']; ?></h3>
      <!--<p style="text-align:center; font-size:16px; margin:0;"><?php echo $_SESSION['city_tamil']; ?> <?php echo $_SESSION['since_tamil']; ?>-->
      <h2 style="text-align:center;margin-bottom: 0; margin-top:2px;"><?php echo $_SESSION['site_title']; ?></h2>
      <p style="text-align:center; font-size:16px; margin:0px;"><?php echo $_SESSION['city']; ?> <span
          style="position:absolute; right:9.1%;"><?php echo $_SESSION['since_eng']; ?></span><br>
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
<!--<tr><td colspan="2"><hr></td></tr>-->
<tr><td colspan="2"><h2 style="text-align:center;">Trial Balance <?php echo date("d/m/Y", strtotime($sdate)).' - '.date("d/m/Y", strtotime($tdate)); ?></h2></td></tr>
<tr><td colspan="2">
	<table class="table1" style="width:100%;" border="1">
    <thead><tr style="border-bottom:1px solid black;">
    <th style="width: 20%;" align="left">A/C No</th>
    <th style="width: 60%;" align="left">Description</th>
    <th style="width: 10%;text-align:right;" align="right">Debit</th>
    <th style="width: 10%;text-align:right;" align="right">Credit</th>
    </tr></thead>
    <tbody>
    <?php foreach($list as $row) { ?>
		<?php print_r($row); ?>
    <?php } ?>
    </tbody>
    </table>
</td></tr>
</table>
<script>
window.print();
</script>