<!DOCTYPE html>
<html>

<head>
    <title>Offering Report</title>
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
    // Extract from pdfdata if passed via pdfdata key (PDF route), else use direct variables
    $d = isset($pdfdata) ? $pdfdata : [];
    $fdate = $d['fdate'] ?? ($fdate ?? '');
    $tdate = $d['tdate'] ?? ($tdate ?? '');
    $offerings = $d['list'] ?? ($list ?? []);
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
                            <h2 style="text-align:left;margin-bottom:0;"><?php echo $_SESSION['site_title']; ?></h2>
                            <p style="text-align:left;font-size:16px;margin:5px 0px;">
                                <?php echo $_SESSION['address1']; ?>, <br>
                                <?php echo $_SESSION['address2']; ?>,
                                <?php echo $_SESSION['city']; ?> - <?php echo $_SESSION['postcode']; ?><br>
                                Tel: <?php echo $_SESSION['telephone']; ?>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <div class="report-title">OFFERING REPORT</div>

    <div class="date-range">
        From: <?= date('d-m-Y', strtotime($fdate)) ?> To: <?= date('d-m-Y', strtotime($tdate)) ?>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:5%;">S.No</th>
                <th style="width:10%;">Date</th>
                <th style="width:10%;">Ref No</th>
                <th style="width:20%;">Name</th>
                <th style="width:12%;">Phone</th>
                <th style="width:18%;">Category</th>
                <th style="width:15%;">Product</th>
                <th style="width:5%;">Grams</th>
                <th style="width:5%;">Qty</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            $totalGrams = [];
            if (empty($offerings)): ?>
                <tr>
                    <td colspan="9" style="text-align:center;">No records found</td>
                </tr>
            <?php else:
                foreach ($offerings as $row):
                    $cat = $row['category_name'];
                    $totalGrams[$cat] = ($totalGrams[$cat] ?? 0) + $row['grams'];
                    ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= date('d-m-Y', strtotime($row['date'])) ?></td>
                        <td><?= htmlspecialchars($row['ref_no'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['phone']) ?></td>
                        <td><?= htmlspecialchars($row['category_name']) ?></td>
                        <td><?= htmlspecialchars($row['product_name']) ?></td>
                        <td><?= number_format($row['grams'], 2) ?></td>
                        <td><?= $row['quantity'] ?? '' ?></td>
                    </tr>
                <?php endforeach;
            endif; ?>
        </tbody>
        <?php if (!empty($totalGrams)): ?>
            <tfoot>
                <tr>
                    <td colspan="7" style="text-align:right;font-weight:bold;">Total by Category:</td>
                    <td colspan="2"></td>
                </tr>
                <?php foreach ($totalGrams as $category => $total): ?>
                    <tr>
                        <td colspan="7" style="text-align:right;"><strong><?= htmlspecialchars($category) ?>:</strong></td>
                        <td colspan="2"><strong><?= number_format($total, 2) ?> grams</strong></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="7" style="text-align:right;font-weight:bold;">Grand Total:</td>
                    <td colspan="2" style="font-weight:bold;"><?= number_format(array_sum($totalGrams), 2) ?> grams</td>
                </tr>
            </tfoot>
        <?php endif; ?>
    </table>
</body>

</html>