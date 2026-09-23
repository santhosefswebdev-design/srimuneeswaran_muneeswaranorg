<title><?php echo $_SESSION['site_title']; ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Barlow&display=swap" rel="stylesheet">
<style>
body { font-family: 'Barlow', sans-serif; }
table { border-collapse:collapse; }
.inner_table tr:nth-child(even) { background:#F3F3F3; }
.inner_table tr:last-child { background:#e2dfdf; }
.table tr th, .table tr td { text-align:center; }
table td { padding:5px; line-height:1.5em; }
h2 { font-size: 20px; }
.level_1  { padding-left:20px !important; }
.level_2  { padding-left:40px !important; }
.level_ledger { padding-left:60px !important; }
.level_total { text-align:center !important; }

.table1{ border:1px solid #CCCCCC; }
.table1 tr th { background-color:#EFEFEF; padding:5px; min-width:120px; font-size:16px; }
.table1 tr td:first-child { padding:5px; text-align:left; }
.table1 tr td { padding:5px;  }
/*.table1 tr td:last-child { font-weight:bold;  }*/ 
</style>
<tr><td colspan="2">
    <table style="width:100%">
    <tr><td width="100%" colspan="2" style="text-align:center;"><img src="<?php echo base_url(); ?>/uploads/header/temple_header.jpg"></td></tr>
    </table>
</td></tr>
<tr><td colspan="2"><hr></td></tr>
<tr><td colspan="2"><h2 style="text-align:center;">Income and Expenditure Statement <?php echo date("d/m/Y", strtotime($dailyclosing_start_date)); ?></h2></td></tr>
<tr><td colspan="2">
	<table class="table1" style="width:100%;" border="1">
    <thead><tr>
    <th align="left"  style="width: 300px; min-width:300px !important;">Account Name</th>
    <th align="right">Amount</th>
    </tr></thead>
    <tbody>
    <?php foreach($table as $row) { ?>
		<?php print_r($row); ?>
    <?php } ?>
    </tbody>
    </table>
</td></tr>
</table>
<div calss="row">
    <div class="col-md-12">
        <h1 align="center"><?php echo $profit; ?></h1>
    </div>
</div>
<script>
// window.print();
</script>