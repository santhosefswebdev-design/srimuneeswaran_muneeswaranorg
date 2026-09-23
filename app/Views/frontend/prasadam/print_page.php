<body>
  <script src="<?php echo base_url(); ?>/assets/js/mui.min.js"
    integrity="sha512-5LSZkoyayM01bXhnlp2T6+RLFc+dE4SIZofQMxy/ydOs3D35mgQYf6THIQrwIMmgoyjI+bqjuuj4fQcGLyJFYg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="<?php echo base_url(); ?>/assets/js/vconsole.min.js"></script>
  <script src="<?php echo base_url(); ?>/assets/plugins/jquery/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>/assets/js/imin-printer-2.min.js"></script>
  <script src="<?php echo base_url(); ?>/assets/js/dom-to-image.js"></script>

  <div style="width: 150mm;font-weight: 600;font-family: monospace;" id="booking_tickets">
    <div style="width: 150mm;font-weight: 600;font-family: monospace;" class="booking_ticket" id="booking_ticket_1">
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
          font-size: 26px;
          text-align: center;
          font-weight: 600;
          font-family: monospace;
          margin: 0px
        }

        h3 {
          font-size: 34px;
          text-align: center;
          font-weight: 600;
          font-family: monospace;
          text-transform: uppercase;
        }

        tr td,
        tr th {
          font-size: 26px;
        }

        .booking_ticket {
          color: #000;
          background: #fff;
          padding: 5px;
          display: block;
        }

        #ticket_loader {
          display: flex;
          justify-content: center;
          align-items: center;
          width: 100%;
          height: 100%;
        }

        img {
          max-width: 100%;
        }
      </style>
      <p style="border-bottom: 3px dotted #9E9E9E;max-width: 150mm;"></p>
      <h3 style="max-width: 150mm;margin: 5px 0;">Office Copy</h3>
      <p style="border-bottom: 3px dotted #9E9E9E;max-width: 150mm;"></p>
      <br>

      <p style="text-align: center; font-size: 22px;">ஓம் சக்தி</p>
      <p><img src="<?php echo base_url(); ?>/uploads/main/<?php echo $temp_details['image']; ?>" style="width:120px;"
          align="center"></p>
      <h2 style="text-align:center; margin:0;font-size: 26px;"><?php echo $temp_details['name']; ?></h2>
      <p style="font-size: 26px;"><?php echo $temp_details['address1']; ?>,
        <?php echo $temp_details['address2']; ?></br>
        <?php echo $temp_details['city'] . '-' . $temp_details['postcode']; ?>.
        Tel: <?= $temp_details['telephone']; ?>
      </p>
      <hr>
      <p style="text-align: center;">Bill No:
        <?php echo $qry1['ref_no']; ?>
      </p>
      <p style="text-align: center;">Date:
        <?php echo date('d-m-Y', strtotime($qry1['date'])); ?>
      </p>
      <p style="text-align: center;">Collection Date:
        <?php echo date('d-m-Y h:i A', strtotime($qry1['collection_date'] . ' ' . $qry1['start_time'])); ?>
      </p>
      <p style="text-align: center;">Customer Name:
        <?php echo $qry1['customer_name']; ?>
      </p>
      <?php if (!empty($qry1['address'])) { ?>
      
      <p style="text-align: center;">Address:
        <?php echo $qry1['address']; ?>
      </p>
      
      <?php } ?>
      <p style="text-align: center;">Mobile No:
        <?php echo $qry1['mobile_no']; ?>
      </p>
      <hr>
      <p style="text-align: left;">SNO&nbsp;&nbsp;PARTICULARS</p>
      <hr>
      <?php $total = 0;
      $i = 1;
      $printed_groups = [];
      foreach ($qry1_payfor as $row) { ?>
        <p style="text-align: left;">
          <?= $i++; ?>&nbsp;&nbsp;
          <?= $row['name_eng']; ?><br>&nbsp;&nbsp;
          <?= $row['name_tamil']; ?><br>&nbsp;&nbsp;
          <span style="">[SGD
            <?= $row['amount']; ?> x
            <?= $row['quantity']; ?> = SGD
            <?= number_format($row['quantity'] * $row['amount'], 2); ?>]
          </span>
        </p>


        <br>
        <?php $total += $row['quantity'] * $row['amount'];
      } ?><br><br>

      <hr>
         <p style="text-align: center;">Paid
        <?= number_format($qry1['paid_amount'], 2); ?>
      </p>
      <p style="text-align: center;">Total: SGD
        <?= number_format($total, 2); ?>
      </p>
      <hr>
      <br>
      <br>
      <br>

    </div>
    <div style="width: 150mm;font-weight: 600;font-family: monospace;" class="booking_ticket" id="booking_ticket_1">
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
          font-size: 22px;
          text-align: center;
          font-weight: 600;
          font-family: monospace;
          margin: 0px
        }

        h3 {
          font-size: 34px;
          text-align: center;
          font-weight: 600;
          font-family: monospace;
          text-transform: uppercase;
        }

        tr td,
        tr th {
          font-size: 22px;
        }

        .booking_ticket {
          color: #000;
          background: #fff;
          padding: 5px;
          display: block;
        }

        #ticket_loader {
          display: flex;
          justify-content: center;
          align-items: center;
          width: 100%;
          height: 100%;
        }

        img {
          max-width: 100%;
        }
      </style>
      <p style="border-bottom: 3px dotted #9E9E9E;max-width: 150mm;"></p>
      <h3 style="max-width: 150mm;margin: 5px 0;">Customer Copy</h3>
      <p style="border-bottom: 3px dotted #9E9E9E;max-width: 150mm;"></p>
      <br>
      <p style="text-align: center; font-size: 22px;">ஓம் சக்தி</p>

      <p><img src="<?php echo base_url(); ?>/uploads/main/<?php echo $temp_details['image']; ?>" style="width:120px;"
          align="center"></p>
      <h2 style="text-align:center; margin:0"><?php echo $temp_details['name']; ?></h2>
      <p><?php echo $temp_details['address1']; ?>, <?php echo $temp_details['address2']; ?></br>
        <?php echo $temp_details['city'] . '-' . $temp_details['postcode']; ?>.
        Tel: <?= $temp_details['telephone']; ?></p>
      <hr>
      <p style="text-align: center;">Bill No:
        <?php echo $qry1['ref_no']; ?>
      </p>
      <p style="text-align: center;">Date:
        <?php echo date('d-m-Y', strtotime($qry1['date'])); ?>
      </p>
      <p style="text-align: center;">Collection Date:
        <?php echo date('d-m-Y h:i A', strtotime($qry1['collection_date'] . ' ' . $qry1['start_time'])); ?>
      </p>
      <p style="text-align: center;">Customer Name:
        <?php echo $qry1['customer_name']; ?>
      </p>
      <?php if (!empty($qry1['address'])) { ?>
      
      <p style="text-align: center;">Address:
        <?php echo $qry1['address']; ?>
      </p>
      
      <?php } ?>
      <p style="text-align: center;">Mobile No:
        <?php echo $qry1['mobile_no']; ?>
      </p>

      <hr>
      <p style="text-align: left;">SNO&nbsp;&nbsp;PARTICULARS</p>
      <hr>
      <?php $total = 0;
      $i = 1;
      $printed_groups = [];
      foreach ($qry1_payfor as $row) { ?>
        <p style="text-align: left;">
          <?= $i++; ?>&nbsp;&nbsp;
          <?= $row['name_eng']; ?><br>&nbsp;&nbsp;
          <?= $row['name_tamil']; ?><br>&nbsp;&nbsp;
          <span style="">[SGD
            <?= $row['amount']; ?> x
            <?= $row['quantity']; ?> = SGD
            <?= number_format($row['quantity'] * $row['amount'], 2); ?>]
          </span>
        </p>


        <br>
        <?php $total += $row['quantity'] * $row['amount'];
      } ?>
      <hr>
         <p style="text-align: center;">Paid
        <?= number_format($qry1['paid_amount'], 2); ?>
      </p>
      <p style="text-align: center;">Total: SGD
        <?= number_format($total, 2); ?>
      </p>
      <hr>
    </div>
    <?php /*
<div style="width: 150mm;font-weight: 600;font-family: monospace;" class="booking_ticket" id="booking_ticket_1">
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
     font-size: 26px;
     text-align: center;
     font-weight: 600;
     font-family: monospace;
     margin: 0px
   }

   h3 {
     font-size: 34px;
     text-align: center;
     font-weight: 600;
     font-family: monospace;
     text-transform: uppercase;
   }

   tr td,
   tr th {
     font-size: 26px;
   }

   .booking_ticket {
     color: #000;
     background: #fff;
     padding: 5px;
     display: block;
   }

   #ticket_loader {
     display: flex;
     justify-content: center;
     align-items: center;
     width: 100%;
     height: 100%;
   }

   img {
     max-width: 100%;
   }
 </style>
 <p style="border-bottom: 3px dotted #9E9E9E;max-width: 150mm;"></p>
 <h3 style="max-width: 150mm;margin: 5px 0;">Madapalli Report</h3>
 <p style="border-bottom: 3px dotted #9E9E9E;max-width: 150mm;"></p>
 <br>





 <p style="text-align: center;">Collection Date:
   <?php echo date('d-m-Y', strtotime($qry1['collection_date'])); ?>

 </p>
 <?php /*
 <p style="text-align: center;">Collection Time:
   <?php echo $qry1['collection_session']; ?>

 </p>

 <p style="text-align: center;">Session:
   <?php echo $qry1['session']; ?> 
 </p>
 <p style="text-align: center;">
   Time: <?php echo $qry1['serve_time']; ?>
 </p>
 <hr>
 <table border="1" width="100%" style="border-collapse: collapse; text-align: left;">
   <thead>
     <tr>
       <th style="padding: 5px;text-align: center;">S.No</th>
       <th style="padding: 5px;text-align: center;">Particulars</th>
       <th style="padding: 5px;text-align: center;">Qty</th>
       <th style="padding: 5px;text-align: center;">Amount</th>
     </tr>
   </thead>
   <tbody>
     <?php
     $total = 0;
     $i = 1;
     foreach ($qry1_payfor as $row) { ?>
       <tr>
         <td style="padding: 5px;text-align: center;"><?= $i++; ?></td>
         <td style="padding: 5px;text-align: center;">
           <?= $row['name_eng']; ?><br>
           <?= $row['name_tamil']; ?>
         </td>
         <td style="padding: 5px;text-align: center;"><?= $row['quantity']; ?></td>
         <td style="padding: 5px;text-align: center;"><?= $row['amount']; ?></td>
       </tr>
     <?php } ?>
   </tbody>
 </table>

 <hr>







</div>
*/ ?>
  </div>
  <div class="ticket_loader">
    <img src="<?php echo base_url(); ?>/assets/images/loader.gif" />
  </div>
  <?php /* <div class="test_img"></div> */ ?>
  <?php /* <img src="" id="test_img" /> */ ?>
  <?php /* <div>
<button class="btn btn-primary" id="web_print">Web Print</button>
<button class="btn btn-success" id="imin_print">Imin Print</button>
</div> */ ?>
  <script>
    var vConsole = new VConsole();
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
      <?php /* if($('#booking_tickets .booking_ticket').length > 0){
     $('.ticket_loader').hide();
     $('.booking_ticket').show();
     $('#booking_tickets .booking_ticket').each(function(){
       var node_id = $(this).attr('id');
       var node = document.getElementById(node_id);
       domtoimage.toJpeg(this).then(function (dataUrl) {
         $('.test_img').append('<img src="' + dataUrl + '" />');
       }).catch(function (error) {
         console.error('oops, something went wrong!', error);
       });
     });
   } */
      /* var node = document.getElementById('archanai_ticket');
           domtoimage.toJpeg(node).then(function (dataUrl) {
             $('#test_img').attr('src', dataUrl);
           }); */ ?>
    });
    var IminPrintInstance = new IminPrinter();
    console.log('IminPrintInstance');
    console.log(IminPrintInstance);
    let isConnect = false;
    IminPrintInstance.connect().then(async (connect) => {
      if (connect) {
        isConnect = true;
        $('.ticket_loader').hide();
        $('.booking_ticket').show();
        initiate_load();
      } else {
        alert('error printer');
      }
    });
    <?php /*
 function initiate_load(){
   if(isConnect){
     var tot_count = $('#booking_tickets .booking_ticket').length;
     var ticket = [];
     console.log( IminPrintInstance.getPrinterStatus());
     IminPrintInstance.initPrinter();

     var i = 0;
     $('#booking_tickets .booking_ticket').each(function(){
       var node = this;
       domtoimage.toJpeg(node).then(function (dataUrl) {
         console.log('i=' + i);
         ticket[i] = dataUrl;
         if(i >= (tot_count - 1)){
           print_queue(IminPrintInstance, ticket, 0);
         }
         i++;
       });
     });
   }
 }
CHange this function because of madapalli report print in first ,, now it will print in correct order */ ?>
    async function initiate_load() {
      if (isConnect) {
        var tickets = [];
        var bookingTickets = $('#booking_tickets .booking_ticket');

        IminPrintInstance.initPrinter();

        for (let i = 0; i < bookingTickets.length; i++) {
          let node = bookingTickets[i];
          let dataUrl = await domtoimage.toJpeg(node);
          tickets.push(dataUrl);
        }

        <?php /* Start printing in correct order */ ?>
        await print_queue(IminPrintInstance, tickets, 0);
      }
    }
    async function print_queue(IminPrintInstance, ticket, i) {
      if (i < ticket.length) {
        console.log(IminPrintInstance.getPrinterStatus());
        console.log('test');

        await IminPrintInstance.printSingleBitmap(ticket[i]);
        await IminPrintInstance.printAndFeedPaper(100);
        await IminPrintInstance.partialCut();
        print_queue(IminPrintInstance, ticket, i + 1);
      } else {
        setTimeout(function () { window.close(); }, 500);
      }
    }
  </script>
</body>