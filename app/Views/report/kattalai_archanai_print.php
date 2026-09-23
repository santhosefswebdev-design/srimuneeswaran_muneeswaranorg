<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Kattalai Archanai Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .header-table {
            border: none;
            margin-bottom: 20px;
        }

        .header-table td {
            border: none;
            padding: 0;
        }

        .report-title {
            text-align: center;
            margin: 20px 0;
            font-size: 18px;
            font-weight: bold;
        }

        .date-range {
            text-align: center;
            margin-bottom: 20px;
            font-size: 14px;
        }

        tfoot tr {
            background-color: #f9f9f9;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <?php
    $tmpid = isset($_SESSION['profile_id']) ? $_SESSION['profile_id'] : 1;
    $db = \Config\Database::connect();
    $temp_details = $db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();

    $from_date = $pdfdata['fdate'];
    $to_date = $pdfdata['tdate'];
    $group_filter = $pdfdata['group_filter'];
    $archanai_type_filter = $pdfdata['archanai_type_filter'];

    $builder = $db->table('kattalai_archanai_booking as kab')
        ->select('kab.id, kab.ref_no, kab.name, kab.date, kab.daytype, kab.amount, kab.paid_amount, kab.payment_type')
        ->where('kab.date >=', $from_date)
        ->where('kab.date <=', $to_date);

    if (!empty($group_filter) && $group_filter != '0') {
        $builder->where('kab.daytype', $group_filter);
    }
    if ($archanai_type_filter == '2') {
        $builder->where('kab.archanai_type_id', 3);
    } elseif ($archanai_type_filter == '1') {
        $builder->where('kab.archanai_type_id !=', 3);
    }
    $builder->orderBy('kab.date', 'DESC');
    $records = $builder->get()->getResultArray();
    $grand_amount = 0;
    $grand_paid = 0;
    ?>

    <table class="header-table">
        <tr>
            <td colspan="2">
                <table style="width:100%">
                    <tr>
                        <td width="15%" align="left">
                            <img src="<?php echo base_url(); ?>/uploads/main/<?php echo $_SESSION['logo_img']; ?>"
                                style="width:120px;" align="left">
                        </td>
                        <td width="85%" align="left">
                            <h2 style="text-align:left; margin-bottom:0;">
                                <?php echo $_SESSION['site_title']; ?>
                            </h2>
                            <p style="text-align:left; font-size:16px; margin:5px 0px;">
                                <?php echo $_SESSION['address1']; ?>,<br>
                                <?php echo $_SESSION['address2']; ?>
                                <?php echo $_SESSION['city']; ?> - <?php echo $_SESSION['postcode']; ?><br>
                                Tel: <?php echo $_SESSION['telephone']; ?>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <div class="report-title">KATTALAI ARCHANAI BOOKING REPORT</div>

    <div class="date-range">
        From: <?php echo date('d-m-Y', strtotime($from_date)); ?>
        &nbsp;&nbsp; To: <?php echo date('d-m-Y', strtotime($to_date)); ?>
        <?php if (!empty($group_filter) && $group_filter != '0')
            echo '&nbsp;&nbsp; Type: ' . ucfirst($group_filter); ?>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:5%;">S.No</th>
                <th style="width:9%;">Date</th>
                <th style="width:18%;">Devotee Name</th>
                <th style="width:13%;">Ref No</th>
                <th style="width:10%;">Type</th>
                <th style="width:12%;">Payment Type</th>
                <th style="width:10%;">Amount</th>
                <th style="width:10%;">Paid Amount</th>
                <th style="width:10%;">Balance</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($records)):
                $i = 1;
                foreach ($records as $row):
                    $balance = (float) $row['amount'] - (float) $row['paid_amount'];
                    if ($balance < 0)
                        $balance = 0;
                    $grand_amount += (float) $row['amount'];
                    $grand_paid += (float) $row['paid_amount'];
                    ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['ref_no']); ?></td>
                        <td><?php echo !empty($row['daytype']) ? ucfirst($row['daytype']) : '-'; ?></td>
                        <td><?php echo !empty($row['payment_type']) ? ucfirst($row['payment_type']) : '-'; ?></td>
                        <td><?php echo number_format($row['amount'], 2); ?></td>
                        <td><?php echo number_format($row['paid_amount'], 2); ?></td>
                        <td><?php echo number_format($balance, 2); ?></td>
                    </tr>
                <?php endforeach; else: ?>
                <tr>
                    <td colspan="9" style="text-align:center;">No records found</td>
                </tr>
            <?php endif; ?>
        </tbody>
        <?php if (!empty($records)):
            $grand_balance = $grand_amount - $grand_paid;
            if ($grand_balance < 0)
                $grand_balance = 0;
            ?>
            <tfoot>
                <tr>
                    <td colspan="6" style="text-align:right; font-weight:bold;">Grand Total</td>
                    <td><?php echo number_format($grand_amount, 2); ?></td>
                    <td><?php echo number_format($grand_paid, 2); ?></td>
                    <td><?php echo number_format($grand_balance, 2); ?></td>
                </tr>
            </tfoot>
        <?php endif; ?>
    </table>

</body>
<script>
    window.onload = function () { window.print(); };
</script>

</html>