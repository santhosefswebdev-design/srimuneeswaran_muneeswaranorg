<?php        
$db = db_connect();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Prasadam Report</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Barlow', sans-serif;
            margin: 0;
            padding: 10px;
        }
        .header-container {
            display: table;
            width: 100%;
            margin-bottom: 10px;
        }
        .logo-section {
            display: table-cell;
            width: 120px;
            vertical-align: top;
            padding-right: 15px;
        }
        .logo-section img {
            width: 120px;
            height: auto;
        }
        .details-section {
            display: table-cell;
            vertical-align: top;
        }
        .details-section h2 {
            margin: 0 0 5px 0;
            font-size: 18px;
        }
        .details-section p {
            margin: 5px 0;
            font-size: 14px;
            line-height: 1.4;
        }
        hr {
            border: none;
            border-top: 2px solid #000;
            margin: 10px 0;
        }
        h3 {
            text-align: center;
            margin: 10px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table th {
            background-color: #444242 !important;
            color: #fff;
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }
        table td {
            border: 1px solid #000;
            padding: 6px;
        }
        .text-center {
            text-align: center;
        }
        .text-left {
            text-align: left;
        }
    </style>
</head>
<body>
    <?php 
    $fdate = $pdfdata['fdate'];
    $tdate = $pdfdata['tdate'];
    $fltername = $pdfdata['fltername'];
    $temp_details = $pdfdata['temp_details'];
    ?>

    <!-- Header with Logo -->
    <div class="header-container">
        <div class="logo-section">
            <img src="https://panel.srimuneeswaran.org/uploads/main/1720513577_Logo_image.png" alt="Temple Logo">
        </div>
        <div class="details-section">
            <h2><?php echo $temp_details['name'] ?? 'Temple Name'; ?></h2>
            <p>
                <?php echo $temp_details['address1'] ?? ''; ?><?php if(!empty($temp_details['address1'])): ?>,<?php endif; ?><br>
                <?php echo $temp_details['city'] ?? ''; ?><?php if(!empty($temp_details['postcode'])): ?> - <?php echo $temp_details['postcode']; ?><?php endif; ?><br>
                <?php if(!empty($temp_details['telephone'])): ?>Tel: <?php echo $temp_details['telephone']; ?><?php endif; ?>
            </p>
        </div>
    </div>

    <hr>

    <!-- Report Title -->
    <h3>PRASADAM VOUCHER <?php echo date("d/m/Y", strtotime($fdate)).' - '.date("d/m/Y", strtotime($tdate)); ?></h3>

    <!-- Data Table -->
    <table>
        <thead>
            <tr>
                <th style="width:5%;">S.No</th>
                <th style="width:10%;">Date</th>
                <th style="width:12%;">Ref No</th>
                <th style="width:13%;">Customer Name</th>
                <th style="width:50%;">Payfor</th>
                <th style="width:10%;">Amount</th>
            </tr>
        </thead>
        <tbody>
        <?php 
            $fdt = date('Y-m-d', strtotime($fdate));
            $tdt = date('Y-m-d', strtotime($tdate));
            $fltername_fil = $fltername;
            
            $dat = $db->table('prasadam')
                ->select('prasadam.id, prasadam.date, prasadam.ref_no, prasadam.customer_name, prasadam.amount')
                ->where('DATE_FORMAT(prasadam.date, "%Y-%m-%d") >=', $fdt)
                ->where('DATE_FORMAT(prasadam.date, "%Y-%m-%d") <=', $tdt);
            
            if($fltername_fil && $fltername_fil != '0') {
                $dat = $dat->where('prasadam.prasadam_group_id', $fltername_fil);
            }
            
            $dat = $dat->orderBy('prasadam.date', 'asc')
                ->get()
                ->getResultArray();
            
            $sn = 1;
            $total_amount = 0;
            
            foreach($dat as $row) {
                $payfors = $db->table('prasadam_booking_details as pbd')
                    ->join('prasadam_setting', 'prasadam_setting.id = pbd.prasadam_id')
                    ->select('prasadam_setting.name_eng, prasadam_setting.name_tamil, pbd.quantity')
                    ->where('pbd.prasadam_booking_id', $row['id'])
                    ->get()
                    ->getResultArray();
                
                $html = "";
                foreach($payfors as $payfor) {
                    $html .= "&#x2022; " . $payfor['name_eng'] . ' - ' . $payfor['quantity'] . "<br>";
                }
                
                $total_amount += (float)$row['amount'];
        ?>
            <tr>
                <td class="text-center"><?php echo $sn++; ?></td>
                <td class="text-center"><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>
                <td class="text-center"><?php echo $row['ref_no'] ?? '-'; ?></td>
                <td class="text-center"><?php echo $row['customer_name']; ?></td>
                <td class="text-left"><?php echo $html; ?></td>
                <td class="text-center"><?php echo number_format($row['amount'], 2, '.', ','); ?></td>
            </tr>
        <?php } ?>
        
        <?php if(!empty($dat)): ?>
            <tr style="background-color: #e2dfdf; font-weight: bold;">
                <td colspan="5" class="text-center">Total</td>
                <td class="text-center"><?php echo number_format($total_amount, 2, '.', ','); ?></td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

    <!-- Footer -->
    <div style="margin-top: 20px; text-align: center; font-size: 9px;">
        <p>Generated on: <?php echo date('d-m-Y h:i A'); ?></p>
    </div>
</body>
</html>