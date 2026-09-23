<?php $db = db_connect(); ?>

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
	<div style="width: 150mm;font-weight: 600;font-family: monospace;" id="archanai_ticket">
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="<?php echo base_url(); ?>/assets/css/Barlow.css" rel="stylesheet">
		<style>
			body {
				font-family: 'Barlow', sans-serif;
				background: #fff;
				box-sizing: border-box;
			}

			table {
				border-collapse: collapse;
			}

			table td {
				padding: 5px;
			}

			hr {
				border: none;
				border-top: 1px dashed #000;
				color: #fff;
				background-color: #fff;
				height: 1px;
			}

			p {
				font-size: 14px;
				text-align: center;
				font-weight: 600;
				font-family: monospace;
				margin: 0px
			}

			#archanai_ticket {
				color: #000;
				background: #fff;
				padding: 5px;
				display: block;

			}

			#archanai_loader {
				display: flex;
				justify-content: center;
				align-items: center;
				width: 100%;
				height: 100%;
			}

			img {
				max-width: 100%;
			}

			h2 {
				text-align: center;
				margin: 6px 0;
			}

			.box {
				border: 2px solid #000;
				padding-top: 14px;
				align-items: center;

			}

			.last_line {
				font-size: 14px;
			}

			table tr th,
			table tr td {
				padding: 4px;
				font-size: 20px;
			}

			.table tr th,
			table tr td {
				padding: 4px;
				font-size: 20px;
			}

			table.vechi tr th,
			table.vechi tr td {
				padding: 4px;
				font-size: 22px;
			}
		</style>
		<!-- <p>ஓம் சக்தி</p> -->
		<p><?php if (!empty($temp_details['ar_image'])) { ?>
				<img src="<?php echo base_url(); ?>/uploads/main/<?php echo $temp_details['ar_image']; ?>"
					style="width:120px;" align="center">
			<?php } else { ?>
				<img src="<?php echo base_url(); ?>/uploads/main/<?php echo $temp_details['image']; ?>" style="width:120px;"
					align="center">
			<?php } ?>
		</p>
		<!--p><img src="<?php echo base_url(); ?>/uploads/main/<?php echo $temp_details['image']; ?>" style="width:120px;" align="center"></p-->
		<h2><?php echo $temp_details['name_tamil']; ?></h2>
		<p><?php echo $temp_details['since_tamil']; ?></p>
		<h2><?php echo $temp_details['name']; ?></h2>
		<p><?php echo $temp_details['since_eng']; ?></p>
		<p><?php echo $temp_details['address1'] .','; ?>
			<?php echo $temp_details['city'] . ' ' . $temp_details['postcode']; ?>. <br>
			Mobile Number : <?= $temp_details['telephone']; ?>
		</p>
		
		<?php $total = 0;
		$i = 1;
		foreach ($booking as $row) { ?>
		<hr style="border-top: 4px dotted #000;">
			<h3 style="text-align: center; font-size: 30px;"><?= $row['diety_tamil']; ?></h3>
			<h3 style="text-align: center; font-size: 30px;"><?= $row['diety_name']; ?></h3>
			

			<?php /* <h3 class="box mt-3" style="text-align:center; font-weight: bold; font-size: 26px;">&nbsp;&nbsp;<?= $row['name_eng']; ?><br>&nbsp;&nbsp;
											 <?= $row['name_tamil']; ?><br>&nbsp;&nbsp;</h3> */ ?>

		<div class="row" align="center">
		<?php if($row['name_eng'] == 'Coconut' || $row['name_eng'] == 'Coconut Archanai') { ?>
    		<img src="<?php echo base_url(); ?>/uploads/main/coconut_vector.png" style="width:120px;" align="center">
		<?php } ?>

			</div>

		<h3 class="mt-3" style="text-align:center; font-weight: bold; font-size: 26px; border: 3px solid black; padding: 2px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); background-color: #f9f9f9;">
				&nbsp;&nbsp;<?php echo ($row['quantity'] > 1 ? $row['name_eng'] . ' X ' . $row['quantity'] : $row['name_eng']); ?><br>&nbsp;&nbsp;
				<?php 
				echo ($row['quantity'] > 1 ? $row['name_tamil'] . ' X ' . $row['quantity'] : $row['name_tamil']); ?></h3>
				<?php
					$descriptions = json_decode($row['description'], true);
					if (is_array($descriptions) && !empty($descriptions)) {
						foreach ($descriptions as $description) {
							// Adjust margin-bottom to control the space between the descriptions
							echo '<h3 style="text-align:center; font-weight: bold; font-size: 24px; margin-top: 5px; margin-bottom: 5px;">' . htmlspecialchars($description) . '</h3>';
						}
					}
				?>

			<?php $total += $row['quantity'] * $row['amount'];
		} ?>

		<p style="text-align:right">NO:<?php echo $qry1['ref_no']; ?></p>

		<p style="text-align: center; font-weight: bold; font-size: 30px;">SGD :<?= number_format($total, 2); ?></p>
		<?php
		$check_amt = $db->table('archanai_booking')->where('id', $archanai_book_id)->get()->getResultArray();
		if (count($check_amt) > 0) {
			$paid_amt = !empty($check_amt[0]['paid_amount']) ? $check_amt[0]['paid_amount'] : 0;
		} else {
			$paid_amt = 0;
		}
		$balance_amt = (float) $paid_amt - (float) $total;
		?>
		<br>
		<p style="text-align: center; font-weight: bold; font-size: 18px;">PAID AMOUNT : SGD
			<?= number_format($paid_amt, 2); ?>
		</p>

		<p style="text-align: center; font-weight: bold; font-size: 18px;">BALANCE AMOUNT : SGD
			<?= number_format($balance_amt, 2); ?>
		</p>
		<br>
		<?php if (!empty($qry1['description'])) { ?>
			<p style="text-align: center; font-weight: bold; font-size: 18px;">Remarks : 
				<?php echo $qry1['description'] ?>
			</p>
		<?php } ?>
		<?php if (!empty($rasi)) { ?>
			<hr>
			<table style="width:100%;" border="1">
				<tr>
					<th align="left">Name</th>
					<th align="left">Rasi</th>
					<th align="left">Natchathram</th>
				</tr>
				<?php foreach ($rasi as $res) { ?>
					<tr>
						<td><?= $res['name']; ?></td>
						<td><?= $res['rasi_name_tamil']; ?><br><?= $res['rasi_name_eng']; ?></td>
						<td><?= $res['nat_name_tamil']; ?><br><?= $res['nat_name_eng']; ?></td>
					</tr>
				<?php } ?>
			</table>
		<?php } ?>
		<?php if (!empty($vehicles)) { ?>
			<hr>
			<table style="width:100%;" class="vechi" border="1">
				<tr>
					<th align="center">Vehicle Details</th>
				</tr>
				<?php foreach ($vehicles as $vehicle) { ?>
					<tr>
						<td align="center"><?= $vehicle['name'] . ' ' . $vehicle['vehicle_no']; ?></td>
					</tr>
				<?php } ?>
			</table>
		<?php } ?>
		<p class="last_line">அர்ச்சனை முடிவுற்றதும்</p>

		<p class="last_line"> அர்ச்சனைப் பொருளைப் பெற்றுக் கொள்ளலாம்</p>
		</br>
		<p class="last_line">For Archanai produce it and collect offerings</p>
		<hr style="border-top: 4px dotted #000;">
		<?php

		$dateTime = new DateTime($qry1['created']);


		$formattedDate = $dateTime->format('d/m/Y');


		$formattedTime = $dateTime->format('g:i:s A');
		?>
		<?php
		$j = 0;
		foreach ($booking as $row) {
			if ($row['archanai_category'] == 3) {
				$j = $j + 1;
			}
		}
		if ($j > 0) {
			?>
			<img src="<?php echo base_url(); ?>/assets/1671017506_fruit_arsanai.jpg" width="200" height="160" alt="image"
				style="display:block;margin:0 auto;">
			<p style="text-align:center;font-size:30px;">Archanai Kazhanji <br> அர்ச்சனை களஞ்சி </p>
			<?php
		}
		?>
		<br>
		<br>
		<br>
		<p style="text-align: center;"> <?php echo $formattedDate . ' ' . $formattedTime; ?></p><br>
		<p><span>---</span>GRASP SOFTWARE SOLUTIONS SDN. BHD.<span>---</span></p>
	</div>


	</div>
	<div class="archanai_loader">
		<img src="<?php echo base_url(); ?>/assets/images/loader.gif" />
	</div>
	<?php /* <img src="" id="test_img" /> */ ?>
	<?php /* <div>
<button class="btn btn-primary" id="web_print">Web Print</button>
<button class="btn btn-success" id="imin_print">Imin Print</button>
</div> */ ?>
	<script>
		//var vConsole = new VConsole();
		function printDiv() {

			var divToPrint = document.getElementById('archanai_ticket');

			var newWin = window.open('', 'Print-Window');

			newWin.document.open();

			newWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</body></html>');

			newWin.document.close();

			setTimeout(function () { newWin.close(); }, 1500);

		}
		$(document).ready(function () {
			$(document).on('click', '#web_print', function () {
				printDiv();
			});
			/* var node = document.getElementById('archanai_ticket');
			domtoimage.toJpeg(node).then(function (dataUrl) {
				$('#test_img').attr('src', dataUrl);
			}); */
		});
		var IminPrintInstance = new IminPrinter();

		IminPrintInstance.connect().then(async (isConnect) => {
			if (isConnect) {
				$('.archanai_loader').hide();
				$('#archanai_ticket').show();
				console.log(await IminPrintInstance.getPrinterStatus());
				var QrCodeSize;
				//mui('body').on('tap', '#imin_print', async function (e) {
				IminPrintInstance.initPrinter();
				console.log(await IminPrintInstance.getPrinterStatus());
				var node = document.getElementById('archanai_ticket');
				domtoimage.toJpeg(node).then(function (dataUrl) {
					IminPrintInstance.printSingleBitmap(dataUrl).then(() => {
						console.log(' sucess');
						IminPrintInstance.printAndFeedPaper(100);
						IminPrintInstance.partialCut();
						IminPrintInstance.openCashBox();
						setTimeout(function () { window.close(); }, 500);
					});

				});
				//});
			} else {
				alert('error printer');
			}
		});
	</script>
</body>