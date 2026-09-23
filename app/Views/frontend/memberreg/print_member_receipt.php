<title>Member Receipt - <?php echo $member['name']; ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Barlow&display=swap" rel="stylesheet">
<style>
    body {
        font-family: 'Barlow', sans-serif;
        margin: 20px;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    table td,
    table th {
        padding: 8px;
        border: 1px solid #000;
    }

    .table1 td {
        border: 0 !important;
    }

    .header-section {
        margin-bottom: 20px;
    }

    .title-section {
        text-align: center;
        font-weight: bold;
        padding: 10px;
        background: #f7ebbb;
        margin: 20px 0;
    }

    .info-row td {
        padding: 10px;
    }

    .label {
        font-weight: bold;
        width: 30%;
    }
</style>

<?php
// function AmountInWords(float $amount)
// {
//     $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
//     $get_paise = ($amount_after_decimal > 0) ? " and Cents " . trim(NumToWords($amount_after_decimal)) : '';
//     return (NumToWords($amount) ? 'Ringgit ' . trim(NumToWords($amount)) . '' : '') . $get_paise . ' Only';
// }

// function NumToWords($num)
// {
//     $num = floor($num);
//     $amt_hundred = null;
//     $count_length = strlen($num);
//     $x = 0;
//     $string = array();
//     $change_words = array(
//         0 => '',
//         1 => 'One',
//         2 => 'Two',
//         3 => 'Three',
//         4 => 'Four',
//         5 => 'Five',
//         6 => 'Six',
//         7 => 'Seven',
//         8 => 'Eight',
//         9 => 'Nine',
//         10 => 'Ten',
//         11 => 'Eleven',
//         12 => 'Twelve',
//         13 => 'Thirteen',
//         14 => 'Fourteen',
//         15 => 'Fifteen',
//         16 => 'Sixteen',
//         17 => 'Seventeen',
//         18 => 'Eighteen',
//         19 => 'Nineteen',
//         20 => 'Twenty',
//         30 => 'Thirty',
//         40 => 'Forty',
//         50 => 'Fifty',
//         60 => 'Sixty',
//         70 => 'Seventy',
//         80 => 'Eighty',
//         90 => 'Ninety'
//     );
//     $here_digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');

//     while ($x < $count_length) {
//         $get_divider = ($x == 2) ? 10 : 100;
//         $amount = floor($num % $get_divider);
//         $num = floor($num / $get_divider);
//         $x += $get_divider == 10 ? 1 : 2;
//         if ($amount) {
//             $add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
//             $amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
//             $string[] = ($amount < 21) ? $change_words[$amount] . ' ' . $here_digits[$counter] . $add_plural . ' ' . $amt_hundred : $change_words[floor($amount / 10) * 10] . ' ' . $change_words[$amount % 10] . ' ' . $here_digits[$counter] . $add_plural . ' ' . $amt_hundred;
//         } else {
//             $string[] = null;
//         }
//     }
//     return (implode('', array_reverse($string)));
// }
?>

<!-- HEADER SECTION -->
<table border="1" style="border-collapse: collapse; width: 100%;">
    <tbody>
        <tr>
            <td width="15%" style="border: 1px solid #000; vertical-align: top;">
                <img src="<?php echo base_url(); ?>/uploads/main/<?php echo $temple_details['image']; ?>"
                    style="width:120px;" align="left">
            </td>
            <td width="85%" style="padding: 0px; border: 1px solid #000;">
                <table class="table1" style="width: 100%;">
                    <tr>
                        <td>
                            <h2 style="text-align:center; margin-bottom: 0; font-size: 18px;">
                                <?php echo $temple_details['name']; ?>
                            </h2>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="text-align:center; font-size:16px; margin:0;">
                                <?php echo $temple_details['address1']; ?>, <?php echo $temple_details['city']; ?> -
                                <?php echo $temple_details['postcode']; ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="text-align:center; font-size:16px; margin:0;">
                                GST Reg.No: <?php echo $temple_details['gstno']; ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="text-align:center; font-size:16px; margin:0;">
                                Tel: <?php echo $temple_details['telephone']; ?>
                                Fax: <?php echo $temple_details['fax_no']; ?>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="title-section">
                MEMBER REGISTRATION RECEIPT
            </td>
        </tr>
    </tbody>
</table>

<!-- MEMBER DETAILS -->
<table style="margin-top: 20px;">
    <tr class="info-row">
        <td style="width:20%" class="label">Member Number:</td>
        <td style="width:25%"><?php echo $member['member_no']; ?></td>
        <td style="width:25%" class="label">Registration Date:</td>
        <td style="width:25%;white-space:nowrap;"><?php echo date('d-m-Y', strtotime($member['created'])); ?></td>
    </tr>
    <tr class="info-row">
        <td class="label">Name:</td>
        <td colspan="3"><?php echo $member['name']; ?></td>
    </tr>
    <tr class="info-row">
        <td class="label">IC Number:</td>
        <td><?php echo $member['ic_no']; ?></td>
    <td style="width: 100px;" class="label">Date of Birth:</td>
<td><?php echo (!empty($member['dob']) && $member['dob'] != '0000-00-00') ? date('d-m-Y', strtotime($member['dob'])) : '-'; ?>
    </td>
    </tr>
    <tr class="info-row">
        <td class="label">Mobile Number:</td>
        <td><?php echo $member['mobile']; ?></td>
        <td class="label">Email:</td>
        <td><?php echo !empty($member['email_address']) ? $member['email_address'] : 'N/A'; ?></td>
    </tr>
    <tr class="info-row">
        <td class="label">Address:</td>
        <td colspan="3"><?php echo $member['address']; ?></td>
    </tr>
    <tr class="info-row">
        <td class="label">Member Type:</td>
        <td><?php echo $member['type_name']; ?></td>
        <td class="label">Status:</td>
        <td><?php echo ($member['status'] == 1) ? 'Active' : 'Inactive'; ?></td>
    </tr>
    <!-- <tr class="info-row">
        <td class="label">Start Date:</td>
        <td><?php echo date('d-m-Y', strtotime($member['start_date'])); ?></td>
        <td class="label">End Date:</td>
        <td><?php echo !empty($member['end_date']) ? date('d-m-Y', strtotime($member['end_date'])) : 'Lifetime'; ?></td>
    </tr> -->
</table>

<!-- PAYMENT DETAILS -->
<table style="margin-top: 20px;">
    <tr>
        <th colspan="4" style="text-align: center; background: #f7ebbb;">PAYMENT DETAILS</th>
    </tr>
    <tr class="info-row">
        <td class="label">Description</td>
        <td class="label">Amount</td>
    </tr>
    <tr class="info-row">
        <td><?php echo $member['type_name']; ?> Membership Fee</td>
        <td style="text-align: right;">SGD <?php echo number_format($member['payment'], 2); ?></td>
    </tr>
    <tr class="info-row">
        <td class="label">Total Amount:</td>
        <td style="text-align: right;"><strong>SGD <?php echo number_format($member['payment'], 2); ?></strong></td>
    </tr>
    <!-- <tr class="info-row">
        <td colspan="2">
            <strong>Amount in Words:</strong> <?php /*echo AmountInWords($member['payment']);*/ ?>
        </td>
    </tr> -->
    <tr class="info-row">
        <td colspan="2" style="text-align: center;">
            (GST has been absorbed by the Temple)
        </td>
    </tr>
</table>

<!-- FOOTER -->
<div style="margin-top: 30px; text-align: center;">
    <p>Note: All cheques should be crossed and made payable to "<?php echo $temple_details['name']; ?>"</p>
    <p>PAYNOW - S67SS0012K (Please Quote Member Number As Reference)</p>
</div>

<script>
    window.print();
</script>