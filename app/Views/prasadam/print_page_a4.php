<title>
  <?php echo $_SESSION['site_title']; ?>
</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Barlow&display=swap" rel="stylesheet">
<style>
  body {
    font-family: 'Barlow', sans-serif;
  }

  table {
    border-collapse: collapse;
  }

  table td {
    padding: 5px;
  }

  .dot_line {
    display: flex;
    justify-content: center;
    align-items: center;

  }
</style>
<style>
        body {
            font-family: Arial, sans-serif;
        }
        .invoice-container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .header, .footer {
            text-align: center;
        }
        .header h1, .header p {
            margin: 0;
        }
        .details, .items, .payment-details, .footer-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .details th, .details td, .items th, .items td, .payment-details th, .payment-details td, .footer-table th, .footer-table td {
            border: 1px solid #000;
            padding: 8px;
        }
        .details th {
            background-color: #f4f4f4;
        }
        .items th {
            background-color: #f0f0f0;
        }
        .right-align {
            text-align: center;
        }
        .footer p {
            margin: 5px 0;
        }
        .footer-table th, .footer-table td {
            border: none;
        }
    </style>
<?php
// Create a function for converting the amount in words
function AmountInWords(float $amount)
{
  $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
  $get_paise = ($amount_after_decimal > 0) ? " and Cents " . trim(NumToWords($amount_after_decimal)) : '';
  return (NumToWords($amount) ? 'Ringgit ' . trim(NumToWords($amount)) . '' : '') . $get_paise . ' Only';

}
function NumToWords($num)
{
  $num = floor($num);
  $amt_hundred = null;
  $count_length = strlen($num);
  $x = 0;
  $string = array();
  $change_words = array(
    0 => '',
    1 => 'One',
    2 => 'Two',
    3 => 'Three',
    4 => 'Four',
    5 => 'Five',
    6 => 'Six',
    7 => 'Seven',
    8 => 'Eight',
    9 => 'Nine',
    10 => 'Ten',
    11 => 'Eleven',
    12 => 'Twelve',
    13 => 'Thirteen',
    14 => 'Fourteen',
    15 => 'Fifteen',
    16 => 'Sixteen',
    17 => 'Seventeen',
    18 => 'Eighteen',
    19 => 'Nineteen',
    20 => 'Twenty',
    30 => 'Thirty',
    40 => 'Forty',
    50 => 'Fifty',
    60 => 'Sixty',
    70 => 'Seventy',
    80 => 'Eighty',
    90 => 'Ninety'
  );
  $here_digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
  while ($x < $count_length) {
    $get_divider = ($x == 2) ? 10 : 100;
    $amount = floor($num % $get_divider);
    $num = floor($num / $get_divider);
    $x += $get_divider == 10 ? 1 : 2;
    if ($amount) {
      $add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
      $amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
      $string[] = ($amount < 21) ? $change_words[$amount] . ' ' . $here_digits[$counter] . $add_plural . ' ' . $amt_hundred : $change_words[floor($amount / 10) * 10] . ' ' . $change_words[$amount % 10] . ' ' . $here_digits[$counter] . $add_plural . ' ' . $amt_hundred;
    } else
      $string[] = null;
  }
  //$implode_to_Rupees = implode('', array_reverse($string));
  return (implode('', array_reverse($string)));
}
?>
<table align="center" width="100%">
	<tr>
		<td colspan="2">
			<table style="width:100%">
				<tr>
                    <td width="10%" align="left"><img src="<?php echo base_url(); ?>/uploads/main/<?php echo $temp_details['image']; ?>" style="width:120px;" align="left"></td>										
                    <td width="90%" align="left">
                        <h2 style="text-align:center;margin-bottom: 0; margin-top:8px;"><?php echo $temp_details['name']; ?></h2>
                        <p style="text-align:center; font-size:16px; margin:0px;"><?php echo $temp_details['city']; ?> <?php echo $temp_details['since_eng']; ?><br>
                            <?php echo $temp_details['address1']; ?>, <?php echo $temp_details['city']; ?> <?php echo $temp_details['postcode']; ?> </br>
                            GST Reg.No: <?php echo $temp_details['gstno']; ?> </br>
                            Tel: <?php echo $_SESSION['telephone']; ?>  Fax: <?php echo $temp_details['fax_no']; ?>
                        </p>
                    </td>
                </tr>
			</table>
        </td>
    </tr>
</table>


<h2 style="text-align:center;"> Prasadam Voucher </h2>
<table class="details">
  <tr>
      <th>Booked Date</th>		
      <td style="white-space: nowrap;"><?php $date = new DateTime($data['date']); echo $date->format('d-m-Y'); ?></td>	
      <th>Collection Date</th>		
      <td style="white-space: nowrap;"><?php $date = new DateTime($data['collection_date']); echo $date->format('d-m-Y'); ?></td>	
      <th>Collection Time</th>
      <td style="text-align: center; white-space: nowrap;"> <?php echo $data['start_time']; ?></td>
  </tr>
</table>

<?php if ($data['prasadam_group_id'] == 1){ ?>
  <table class="details">
    <tr>
        <th>Name</th>
        <td class="right-align" ><?php echo $data['customer_name']; ?></td>
        <th>Ph.No</th>
        <td class="right-align" ><?php echo $data['mobile_no']; ?></td>
    </tr>
  </table>
<?php } ?>

		<table class="items">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Amount</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($booking_details as $bd){ ?>
                  <tr>
                    <td><?php echo $bd['name_eng'] . ' / ' . $bd['name_tamil']; ?></td>
                    <td style="text-align: center"><?php echo $bd['quantity']; ?></td>
                    <td class="right-align">$<?php echo $bd['amount']; ?></td>
                    <td class="right-align">$<?php echo $bd['quantity'] * $bd['amount']; ?></td>
                  </tr>
                <?php } ?> 
            </tbody>
        </table>
		<table class="details">
            <tr>
                <th style="text-align: center">Total</th>
                <td style="text-align: right">$<?php echo $data['amount']; ?></td>
            </tr>
        </table>

		<div>
            <p class="right-align">(GST has been absorbed by the Temple)</p>
        </div>
        <table class="payment-details">
            <tr>
                <th>Payment Details</th>
                <td class="right-align">$<?php echo number_format(($data['paid_amount'] === '0.00' || $data['paid_amount'] === NULL ? $data['amount'] : $data['paid_amount']), 2); ?></td>
            </tr>
            <tr>
                <th>Total Invoice value</th>
                <td class="right-align">$<?php echo number_format($data['amount'], 2); ?></td>
            </tr>
            <tr>
                <th>Balance Payable</th>
                <td class="right-align">$<?php echo ($data['paid_amount'] === '0.00' || $data['paid_amount'] === NULL) ? '0' : number_format(($data['amount'] - $data['paid_amount']), 2); ?></td>
            </tr>
            
            <tr>
                <th colspan="2"><?php echo $data['ref_no'] . '/' . date('d-m-Y', strtotime($data['date'])); ?></th>
            </tr>
        </table>

		<div class="footer">
            
            <p>Note: All cheques should be crossed and made payable to "Muneeswaran Temple Society"</p>
            <p>PAYNOW - S67SS0012K (Please Quote Tax Invoice Number As Reference)</p>
            
        </div>

<!-- <p class="dot_line" style="bottom:0;position:relative;margin-top: 100px;">
      <span>---------------------------------</span>GRASP SOFTWARE SOLUTIONS SDN. BHD.<span>---------------------------------</span>
    </p> -->
<script>
 
</script> 