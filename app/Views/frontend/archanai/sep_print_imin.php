<body>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/mui/3.7.1/js/mui.min.js"
integrity="sha512-5LSZkoyayM01bXhnlp2T6+RLFc+dE4SIZofQMxy/ydOs3D35mgQYf6THIQrwIMmgoyjI+bqjuuj4fQcGLyJFYg=="
crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
<script src="<?php echo base_url(); ?>/assets/js/mui.min.js"
		integrity="sha512-5LSZkoyayM01bXhnlp2T6+RLFc+dE4SIZofQMxy/ydOs3D35mgQYf6THIQrwIMmgoyjI+bqjuuj4fQcGLyJFYg=="
		crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="<?php echo base_url(); ?>/assets/plugins/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/js/imin-printer-2.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/js/dom-to-image.js"></script>
<script src="<?php echo base_url(); ?>/assets/js/vconsole.min.js"></script>
<div id="archanai_ticket">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="<?php echo base_url(); ?>/assets/css/Barlow.css" rel="stylesheet">
	<style>
	body { font-family: 'Barlow', sans-serif; background: #fff; box-sizing: border-box;}
	table { border-collapse:collapse; }
	table td, table th { padding:5px; }
	h2 { text-align: center;margin: 6px 0; }
	hr {
	  border:none;
	  border-top:1px dashed #000;
	  color:#fff;
	  background-color:#fff;
	  height:1px;
	}
	p{font-size: 20px;text-align: center;font-weight: 600;font-family: monospace;margin: 0px}
	#archanai_ticket{
		color: #000;
		background: #fff;
		padding: 5px;
		font-weight: 600;
		font-family: monospace;
		display: none;
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
	.box {
            border: 2px solid #000; 
           padding-top:14px;
            align-items:center;
            
        }
        .last_line{
		font-size: 14px;
	}
	table tr th,  table tr td{
		padding: 4px;
		font-size: 18px;
	}
	</style>
<?php 
$i=1; foreach($booking as $row) 
	{
	$qty = $row['quantity']; 
	for($j=0; $j<$qty; $j++) 
		{ ?>

<!--div style="max-width: 80mm; height:250mm;font-weight: 600;font-family: monospace;"-->
<div style="width: 150mm; height:auto;font-weight: 600;font-family: monospace;"  class="arc">
<style>
	body { font-family: 'Barlow', sans-serif; background: #fff; box-sizing: border-box;}
	table { border-collapse:collapse; }
	table td, table th { padding:5px; }
	h2 { text-align: center;margin: 6px 0; }
	hr {
	  border:none;
	  border-top:1px dashed #000;
	  color:#fff;
	  background-color:#fff;
	  height:1px;
	}
	p{font-size: 14px;text-align: center;font-weight: 600;font-family: monospace;margin: 0px}
	.arc{
		color: #000;
		background: #fff;
		padding: 5px;
		font-weight: 600;
		font-family: monospace;
	}
	img{
		max-width: 100%;
	}
	.box {
		border: 2px solid #000; 
	   padding-top:14px;
		align-items:center;
		
	}
	.last_line{
		font-size: 14px;
	}
	.table tr th,  table tr td{
		padding: 4px;
		font-size: 20px;
	}
	table.vechi tr th, table.vechi tr td{
		padding: 4px;
		font-size: 22px;
	}
</style>
<p>உ சிவமயம்</p>
<p><?php if(!empty($temp_details['ar_image'])) { ?>
    <img src="<?php echo base_url(); ?>/uploads/main/<?php echo $temp_details['ar_image']; ?>" style="width:120px;" align="center">
<?php } else { ?>
    <img src="<?php echo base_url(); ?>/uploads/main/<?php echo $temp_details['image']; ?>" style="width:120px;" align="center">
<?php } ?></p>
<!--p><img src="<?php echo base_url(); ?>/uploads/main/<?php echo $temp_details['image']; ?>" style="width:120px;" align="center"></p-->
<h2><?php echo $temp_details['name_tamil']; ?></h2>
		<h2><?php echo $temp_details['name']; ?></h2>
		<p><?php echo $temp_details['address1']; ?> <?php echo $temp_details['address2']; ?></br>
		<?php echo $temp_details['city'].'-'.$temp_details['postcode']; ?>. 
		Mobile Number : <?= $temp_details['telephone']; ?></p>


			<?php
			//  var_dump($row)
			//  exit;
			if($row['diety_code'] != 'DT0030'){ ?>
			<hr style="border-top: 4px dotted #000;">
			<h3 style="text-align: center;font-weight: bold; font-size: 30px;"><?= $row['diety_name']; ?></h3>
			<?php } ?>
            
			<?php /* <h3 class="box mt-3" style="text-align:center; font-weight: bold; font-size: 26px;">&nbsp;&nbsp;<?= $row['name_eng']; ?><br>&nbsp;&nbsp;
			   <?= $row['name_tamil']; ?><br>&nbsp;&nbsp;</h3> */ ?>
			<h3 class="mt-3" style="text-align:center; font-weight: bold; font-size: 26px; border: 3px solid black; padding: 2px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); background-color: #f9f9f9;">
				&nbsp;&nbsp;<?= $row['name_eng']; ?><br>&nbsp;&nbsp;<?= $row['name_tamil']; ?>&nbsp;&nbsp;</h3>
			<?php
				$descriptions = json_decode($row['description'], true);
				if (is_array($descriptions) && !empty($descriptions)) {
					foreach ($descriptions as $description) {
						echo '<h3 style="text-align:center; font-weight: bold; font-size: 24px;">' . htmlspecialchars($description) . '</h3>';
					}
				}
			?>
		<p style="text-align:right">NO:<?php echo $qry1['ref_no']; ?></p>
	    
<p style="text-align: center; font-size: 30px;">SGD <?= number_format($row['amount'],2); ?></p>
<br>
<?php 
			if($row['archanai_category'] == 2){
				if(!empty($vehicles)) {  ?>
				<hr>
				<br>
				<table style="width:100%;" class="vechi" border="1">
					<tr>
						<th align="left">Name</th>
						<th align="left">Vehicle No</th>
					</tr>
					<?php foreach($vehicles as $vehicle) { ?>
						<tr>
							<td><?= $vehicle['name']; ?></td>
							<td><?= $vehicle['vehicle_no']; ?></td>
						</tr>
					<?php } ?>
				</table>
				<?php 
				}
			}
			 ?>
			 
			 <?php if(!empty($rasi) && $row['archanai_category'] == 1){ ?>
				<hr><br>
				<table style="width:100%;" border="1">
					<tr><th align="left">Name</th><th align="left">Rasi</th><th align="left">Natchathram</th></tr>
					<?php foreach($rasi as $res) { ?>
					<tr><td><?= $res['name']; ?></td>
					<td><?= $res['rasi_name_tamil']; ?><br><?= $res['rasi_name_eng']; ?></td>
					<td><?= $res['nat_name_tamil']; ?><br><?= $res['nat_name_eng']; ?></td></tr>
					<?php } ?>
				</table>
			<?php } ?>
			
			<br>
			
		<p class="last_line">அர்ச்சனை முடிவுற்றதும் </p>
        
        <p class="last_line"> அர்ச்சனைப் பொருளைப் பெற்றுக் கொள்ளலாம்</p>
        </br>
        <p class="last_line">For Archanai produce it and collect offerings</p>
		<hr>
		<?php

            $dateTime = new DateTime($qry1['created']);


            $formattedDate = $dateTime->format('d/m/Y');


            $formattedTime = $dateTime->format('g:i:s A');
          ?>

        <p style="text-align: center;"> <?php echo $formattedDate . ' ' . $formattedTime; ?></p>
		<br>
		<p><span>---</span>GRASP SOFTWARE SOLUTIONS SDN. BHD.<span>---</span></p>
<br>
<br>
<br>
<br>
<br>
</div>
<?php 
	}
} 
?>
	

</div>
<div class="archanai_loader">
		<img src="<?php echo base_url(); ?>/assets/images/loader.gif" />
	</div>
	<div class="test_div">
	</div>
	<?php /* <img src="" id="test_img" /> */ ?>
	<?php /* <div>
		<button class="btn btn-primary" id="web_print">Web Print</button>
		<button class="btn btn-success" id="imin_print">Imin Print</button>
	</div> */ ?>
<script>
	var vConsole = new VConsole();
	function printDiv(){

	  var divToPrint=document.getElementById('archanai_ticket');

	  var newWin=window.open('','Print-Window');

	  newWin.document.open();

	  newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');

	  newWin.document.close();

	  setTimeout(function(){newWin.close();},1500);

	}
	$(document).ready(function(){
		$(document).on('click', '#web_print', function(){
			printDiv();
		});
		var tot_count = $('#archanai_ticket .arc').length;
		/* $('#archanai_ticket .arc').each(function(i){
			var node = this;
			domtoimage.toJpeg(node).then(function (dataUrl) {
				$('.test_div').append('<img src="' + dataUrl + '" />');
				IminPrintInstance.printSingleBitmap(dataUrl);
				IminPrintInstance.printAndFeedPaper(100);
				if(i >= (tot_count - 1)){setTimeout(function(){window.close();}, 1500);}
			});
		}); */
		/* var node = document.getElementById('archanai_ticket');
		domtoimage.toJpeg(node).then(function (dataUrl) {
			$('#test_img').attr('src', dataUrl);
		}); */
	});
	/* domtoimage.toJpeg(node).then(function (dataUrl) {
		$('#test_img').attr('src', dataUrl);
	}); */
	var IminPrintInstance = new IminPrinter();
		let isConnect = false;
		IminPrintInstance.connect().then(async (connect) => {
			if (connect) {
				isConnect = true;
				$('.archanai_loader').hide();
				$('#archanai_ticket').show();
				initiate_load();
			}else{
				alert('error printer');
			}
		});
	function initiate_load(){
		if(isConnect){
			var tot_count = $('#archanai_ticket .arc').length;
			var ticket = [];
			console.log( IminPrintInstance.getPrinterStatus());
			IminPrintInstance.initPrinter();
			//IminPrintInstance.setPageFormat(0);
			$('#archanai_ticket .arc').each(function(i){
				var node = this;
				domtoimage.toJpeg(node).then(async function (dataUrl) {
					console.log('i=' + i);
					ticket[i] = dataUrl;
					if(i >= (tot_count - 1)){
						print_queue(IminPrintInstance, ticket, 0);
					}
				});
				// print_queue(IminPrintInstance, ticket, 0);
			});
		}
	}
	function print_queue(IminPrintInstance, ticket, i){
		console.log('queue print i=' + i);
		if(i < ticket.length){
			console.log(IminPrintInstance.getPrinterStatus());
			/* console.log(ticket[i]); */
			//IminPrintInstance.initPrinter();
			//$('.test_div').append('<img src="' + ticket[i] + '" />');
			IminPrintInstance.printSingleBitmap(ticket[i]).then(()=> {
				console.log(i + ' success');
				IminPrintInstance.printAndFeedPaper(100);
				IminPrintInstance.partialCut();
				print_queue(IminPrintInstance, ticket, i + 1);
				//setTimeout(function(){print_queue(IminPrintInstance, ticket, i + 1);},1000);
			}).catch(error => {
				console.error("Error:", error);
			});
		}else{
			setTimeout(function(){window.close();},500);
		}
	}
	</script>
</body>