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
<h3 style="text-align:center;"> CEMETERY REPORT </h3>
<h3 style="text-align:center;"> [From : <?= date('d-m-Y', strtotime($fdate)); ?> To <?= date('d-m-Y', strtotime($tdate));?>] </h3>
    <table class="tab" border="1" width="100%" align="center">
        <thead>
            <tr>
                <th style="width:5%;">S.No</th>
                <th style="width:25%;">Agent Name</th>
                <th style="width:25%;">Name of Deceased</th>
                <th style="width:10%;">Age of Dec</th>
                <th style="width:15%;">Date of Demise</th>
                <th style="width:20%;">Burial No</th>
            </tr>
        </thead>
        <tbody>
            <?php 
			
			// echo '<pre>';
			// print_r(count($data));
			// die;
			$total = 0; 
			$i=1;
			foreach($data as $row) 
			{
                ?>
				<tr>
                    <td><?= $i++;?></td>
                    <td><?= $row['agent_name']; ?></td>
                    <td><?= $row['name_of_deceased']; ?></td>
                    <td><?= $row['age']; ?></td>
                    <td><?= date('d/m/Y',strtotime($row['date_of_demise'])); ?></td>
                    <td><?= $row['b_certif_no']; ?></td>
				</tr>
            <?php 
			} 
			?>
        </tbody>
    </table>
</td>
</tr>
</table>
<script>
window.print();
</script>