<title>
  <?php echo $_SESSION['site_title']; ?>
</title>
<?php $db = db_connect(); ?>
<style>
  td {
    padding: 5px;
  }

  table {
    border-collapse: collapse;
    width: 100%;
  }

  div.head {
    text-align: center;
    margin-bottom: 30px;
  }

  h2,
  h5 {
    margin: 2px;
  }

  P {
    margin: 25px 0;
  }

  ol li {
    font-weight: bold;
    line-height: 20px;
    margin-bottom: 10px;
  }

  h2 {
    font-size: 20px;
  }
</style>

<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />

  <style>
    body {
      font-family: Arial, sans-serif;
    }

    .letter-heading {
      text-align: center;
      margin-bottom: 30px;
    }

    .letter-heading h1 {
      font-size: 2rem;
      line-height: 1.2;
      margin-bottom: 0;
    }

    .letter-heading p {
      font-size: 1.2rem;
      margin-bottom: 0;
    }

    .address {
      text-align: left;
    }

    .greeting {
      display: flex;
      justify-content: space-between;
    }

    .footer {
      margin-top: 20px;
    }

    .footer-signature {
      margin-top: 20px;
    }
  </style>

<body width="100%">
  <?php
  // Create a function for converting the amount in words
  
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
 <table align="center"style="width: 100%;max-width: 800px;">
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
      </td>
    </tr>
    <tr>
      <td colspan="2">
        <table style="width:100%" border="0">

          <tr>
            <td colspan="2">
              <div class="row">
                <div class="col-lg-6 address mt-5 ">
                  <p>
                    <?php echo $data['rental']['tenant_name']; ?>
                  </p>
                  <p>
                    <?php echo $data['rental']['property_address']; ?>
                  </p>
                  <?php echo $rental['amount']; ?>
                  <p>Shop Lot 106-C</p>
                  <p>Jalan Trus</p>
                  <p>Johor Bahru.</p>
                </div>
              </div>
              <div class="row">
                <div class="col-12 greeting">
                  <div>Dear Sir/Madam,</div>
                  <div>26 April 2022</div>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <h3 class="mt-4">Sub: Final Rental Payment Reminder</h3>
                  <p>
                    1.With reference to the above matter, I would like to draw your
                    attention to the ARMD Management Committee's discussion with all the
                    shop tenants on 19th January 2022. It was finalised that 30 June
                    2022 was agreed as the deadline for the collection of the backlog of
                    rent.
                  </p>
                  <p>
                    2. Kindly be informed that your outstanding rent till April 2022 is
                    <strong>RM 19,606.00</strong>. Please settle the outstanding shop
                    rent before 30th June 2022 to avoid any legal action to be taken
                    against you.
                  </p>
                  <p>3. We sincerely hope you would conform to the deadline.</p>
                  <p>Thank you.</p>
                </div>
              </div>
              <div class="row">
                <div class="col-12 mt-5">
                  <div class="footer">
                    <p>Yours faithfully,</p>
                    <p>Sekharan Gopal</p>
                    <p>Hon. Secretary,</p>
                  </div>
                  <div class="footer-signature">
                    <p>Cc: ARMD President- Mr. Rajaselan</p>
                    <p>ARMD Management Committee</p>
                  </div>
                </div>
              </div>
              </div>
            </td>
          </tr>

        </table>
      </td>
    </tr>
    <!--<tr><td colspan="2"><h4 style="text-align:center;text-transform: uppercase;"> Payment Details  </h4></td></tr>
  <tr>
    <td colspan="2">
      <table border="1" style="width:100%" align="center">
        <tr>
          <th width="33%" style="text-align:left;text-transform: uppercase;">Payment Date</th>
          <th width="33%" style="text-transform: uppercase;">Payment Mode</th>
          <th width="33%" style="text-align:left;text-transform: uppercase;">Amount</th>
        </tr>
        <?php
        foreach ($pay_details as $row) {
          $payment_mode = $db->table("payment_mode")->where('id', $row['payment_mode'])->get()->getRowArray();
          $payment_mode_name = !empty($payment_mode['name']) ? $payment_mode['name'] : "";
          ?>
        <tr>
          <td><?php echo date("d/m/Y", strtotime($row['date'])); ?></td>
          <td align="center"><?php echo $payment_mode_name; ?></td>
          <td><?php echo $row['amount']; ?></td>
        </tr>
        <?php
        }
        ?>
      </table>
    </td>
  </tr>
  <tr><td colspan="2"><p style="text-align:center;"><b>REMINDER</b></p></td></tr>
  <tr>
    <td colspan="2" style="width:100%">
      <ol>
        <li>THE BOARD'S PERMISSION SHOULD BE ASKED BEFORE THE LAND TENANT'S HOUSE IS CHANGED OR THE WAQF BOARD'S HOUSE IS CHANGED TENANT. </li>
        <li>RENT SHOULD BE CLARIFIED ON OR BEFORE THE 7TH OF THE EACH MONTH. </li>
      </ol>
    </td>
  </tr>-->
  </table>
  <br>
  <br><br><br>
  <!-- <p class="dot_line" style="bottom:0;position:relative;margin-top: 10px;">
    <span>---------------------------------</span>GRASP SOFTWARE SOLUTIONS SDN.
    BHD.<span>---------------------------------</span>
  </p> -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-eHnbtsb0CFF2q1bKKV6IP2Ay5V1MOABPK8dxXpEpEKA+AnisZ6a/Z9Tzp2zqje5J"
    crossorigin="anonymous"></script>
  <script>
    window.print();
  </script>
</body>