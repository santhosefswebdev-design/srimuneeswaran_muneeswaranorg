<title><?php echo $_SESSION['site_title']; ?></title>
<style>
table { border-collapse:collapse; }
.inner_table tr:nth-child(even) { background:#F3F3F3; }
.inner_table tr:last-child { background:#e2dfdf; }
.table tr th, .table tr td { text-align:center; }
table td { padding:5px; line-height:1.5em; }
h2 { font-size: 20px; }
</style>
<table style="width:100%">
    <tr>
        <td colspan="2">
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
        </td>
    </tr>
    <tr>
        <td colspan="2"><hr></td>
    </tr>
    <tr>
        <td colspan="2"><h2 style="text-align:center;">Consolidate Balance Sheet</h2></td>
    </tr>
    <tr>
        <td colspan="2">
            <table style="width:100%;" border="0">
                <thead>
                    <tr>
                        <th style="text-align: left;">Account Name</th>
                        <?php
                        if(count($job_codes) > 0){
                            foreach($job_codes as $job_code){
                        ?>
                        <th><?php echo $job_code['job_code']; ?></th>
                        <?php
                            }
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($list as $row) { ?>
                        <?php print_r($row); ?>
                    <?php } ?>
                </tbody>
            </table>
        </td>
    </tr>
</table>
<script>
window.print();
</script>
<script>
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
window.print();
//window.onafterprint = window.close;
</script>