<body>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/mui/3.7.1/js/mui.min.js"
    integrity="sha512-5LSZkoyayM01bXhnlp2T6+RLFc+dE4SIZofQMxy/ydOs3D35mgQYf6THIQrwIMmgoyjI+bqjuuj4fQcGLyJFYg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="<?php echo base_url(); ?>/assets/plugins/jquery/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>/assets/js/imin-printer-1.min.js"></script>
	<script src="<?php echo base_url(); ?>/assets/js/dom-to-image.js"></script>
	<script src="https://cdn.bootcdn.net/ajax/libs/vConsole/3.9.1/vconsole.min.js"></script>
	<div style="max-width: 80mm;font-weight: 600;font-family: monospace;" id="archanai_ticket">
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="<?php echo base_url(); ?>/assets/css/Barlow.css" rel="stylesheet">
		<style>
		body { font-family: 'Barlow', sans-serif; background: #fff; box-sizing: border-box;}
		table { border-collapse:collapse; }
		table td { padding:5px; }
		hr {
		  border:none;
		  border-top:1px dashed #000;
		  color:#fff;
		  background-color:#fff;
		  height:1px;
		}
		p{font-size: 13px;text-align: center;font-weight: 600;font-family: monospace;margin: 0px}
		#archanai_ticket{
			color: #000;
			background: #fff;
			padding: 5px;
			
		}
		#archanai_loader{
			display: flex;
			justify-content: center;
			align-items: center;
			width: 100%;
			height: 100%;
		}
		img{
			max-width: 100%;
		}
        h2 {
      text-align: center;
    }
    .box {
            border: 2px solid #000; 
           padding-top:14px;
            align-items:center;
            
        }
      
        .last_line{
            font-size: 9px;
        }
		</style>
		<p>உ சிவமயம்</p>
        <p><?php if(!empty($temp_details['ar_image'])) { ?>
            <img src="<?php echo base_url(); ?>/uploads/main/<?php echo $temp_details['ar_image']; ?>" style="width:120px;" align="center">
        <?php } else { ?>
            <img src="<?php echo base_url(); ?>/uploads/main/<?php echo $temp_details['image']; ?>" style="width:120px;" align="center">
        <?php } ?></p>
        <!--p><img src="<?php echo base_url(); ?>/uploads/main/<?php echo $temp_details['image']; ?>" style="width:120px;" align="center"></p-->
		<h2>ARULMIGU SIVAMUNISWARAR </br> THIRUKOVIL</h2>
		<p>BATU 10, JALAN MASAI LAMA, PLENTONG,81750</br>MASAI, JOHOR. </br></br>
		H/P :012-7777161</p>
    </br>
		


        
		<?php $total = 0; $i=1; foreach($booking as $row) { ?>
            <p style="text-align: center;"><?= $row['diety_name']; ?></p>
            </br>
			<p class="box mt-3">&nbsp;&nbsp;<?= $row['name_eng']; ?><br>&nbsp;&nbsp;
			   <?= $row['name_tamil']; ?><br>&nbsp;&nbsp;
        </p>
		<?php $total += $row['quantity'] * $row['amount']; } ?>
        </br>
		<p style="text-align:right">NO:<?php echo $qry1['ref_no']; ?></p>
	    </br>
		<p style="text-align: center; font-size: 24px;">RM <?= number_format($total,2); ?></p>
		<br>
		<p class="last_line">அர்ச்சனை முடிவுற்றதும் அர்ச்சகரிடம் கொடுத்து</p>
        
        <p class="last_line"> அர்ச்சனைப் பொருளைப் பெற்றுக் கொள்ளலாம்</p>
        </br>
        <p class="last_line">For Archanai produce it to the priest and collect offerings</p>
		<hr>
		<?php

            $dateTime = new DateTime($qry1['created']);


            $formattedDate = $dateTime->format('d/m/Y');


            $formattedTime = $dateTime->format('g:i:s A');
          ?>

        <p style="text-align: center;"> <?php echo $formattedDate . ' ' . $formattedTime; ?></p>
		<br>
<br>
<br>
<br>
<p><span>---</span>GRASP SOFTWARE SOLUTIONS SDN. BHD.<span>---</span></p>
	<script>
	//window.print();
	</script>
</body>