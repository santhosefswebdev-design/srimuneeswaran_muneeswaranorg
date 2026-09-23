<?php        
$db = db_connect();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Archanai Report</title>
    <style>
        body { 
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 10px;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        .header-table td {
            border: 1px solid #000;
            padding: 5px;
        }
        .logo-cell {
            width: 15%;
            vertical-align: top;
            text-align: center;
        }
        .logo-cell img {
            width: 100px;
            height: auto;
        }
        .info-cell {
            width: 85%;
            padding: 0;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 3px;
            text-align: center;
        }
        .temple-name {
            font-size: 18px;
            font-weight: bold;
            margin: 5px 0;
        }
        .temple-info {
            font-size: 14px;
            margin: 3px 0;
        }
        .report-title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            padding: 10px;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .data-table th {
            background-color: #f0f0f0;
            border: 1px solid #000;
            padding: 8px;
            font-weight: bold;
            text-align: left;
        }
        .data-table td {
            border: 1px solid #000;
            padding: 6px;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .total-row {
            background-color: #e2dfdf;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <table class="header-table">
        <tr>
            <td class="logo-cell">
                <?php if (!empty($pdfdata['temp_details']['image'])): ?>
                    <img src="<?php echo base_url(); ?>/uploads/main/<?php echo $pdfdata['temp_details']['image']; ?>" alt="Logo">
                <?php endif; ?>
            </td>
            <td class="info-cell">
                <table class="info-table">
                    <tr>
                        <td>
                            <div class="temple-name"><?php echo $pdfdata['temp_details']['name']; ?></div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="temple-info">
                                <?php echo $pdfdata['temp_details']['address1']; ?>, <?php echo $pdfdata['temp_details']['address2']; ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="temple-info">
                                <?php echo $pdfdata['temp_details']['city'] . '-' . $pdfdata['temp_details']['postcode']; ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="temple-info">
                                Tel: <?php echo $pdfdata['temp_details']['telephone']; ?>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="report-title">
                ARCHANAI REPORT<br>
                <?php echo date("d/m/Y", strtotime($pdfdata['fdate'])) . ' - ' . date("d/m/Y", strtotime($pdfdata['tdate'])); ?>
            </td>
        </tr>
    </table>

    <!-- Data Table -->
    <table class="data-table">
        <thead>
            <tr>
                <th width="10%" class="text-center">S.No</th>
                <th width="20%">Date</th>
                <th width="30%">Invoice No</th>
                <th width="40%" class="text-right">Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $fdt = date('Y-m-d', strtotime($pdfdata['fdate']));
            $tdt = date('Y-m-d', strtotime($pdfdata['tdate']));
            
            $dat = $db->table('archanai_booking')
                ->select('archanai_booking.*')
                ->where('archanai_booking.date >=', $fdt)
                ->where('archanai_booking.date <=', $tdt)
                ->orderBy('archanai_booking.date', 'DESC')
                ->get()->getResultArray();
            
            $sn = 1;
            $total_amount = 0;
            
            foreach($dat as $row) {
                $total_amount += (float)$row['amount'];
            ?>
            <tr>
                <td class="text-center"><?php echo $sn++; ?></td>
                <td><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>
                <td><?php echo $row['ref_no']; ?></td>
                <td class="text-right">$<?php echo number_format($row['amount'], 2); ?></td>
            </tr>
            <?php } ?>
            
            <!-- Total Row -->
            <tr class="total-row">
                <td colspan="3" class="text-right"><strong>Total Amount:</strong></td>
                <td class="text-right"><strong>$<?php echo number_format($total_amount, 2); ?></strong></td>
            </tr>
        </tbody>
    </table>
</body>
</html>