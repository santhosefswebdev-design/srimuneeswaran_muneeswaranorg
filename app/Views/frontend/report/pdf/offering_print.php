<?php
$db = db_connect();
$temp_details = $pdfdata['temp_details'];
$fdate = $pdfdata['fdate'];
$tdate = $pdfdata['tdate'];
$type = isset($pdfdata['type']) ? $pdfdata['type'] : '';
$ptype = isset($pdfdata['ptype']) ? $pdfdata['ptype'] : '';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Offering Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
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
            vertical-align: top;
        }

        .logo-cell {
            width: 15%;
            padding: 5px;
        }

        .logo-cell img {
            width: 100px;
            height: auto;
        }

        .info-cell {
            width: 85%;
            padding: 0;
        }

        .info-cell table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-cell td {
            border: none;
            text-align: center;
            padding: 3px;
        }

        .temple-name {
            font-size: 16px;
            font-weight: bold;
            margin: 0;
        }

        .temple-address {
            font-size: 12px;
            margin: 0;
        }

        .report-title {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            padding: 8px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .data-table th,
        .data-table td {
            border: 1px solid #000;
            padding: 5px;
            font-size: 11px;
        }

        .data-table th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: left;
        }

        .data-table td.center {
            text-align: center;
        }

        .data-table td.right {
            text-align: right;
        }

        .total-row {
            background-color: #e2dfdf;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <!-- Header Section -->
    <table class="header-table">
        <tr>
            <td class="logo-cell">
                <img src="https://panel.srimuneeswaran.org/uploads/main/1720513577_Logo_image.png" alt="Logo">
            </td>
            <td class="info-cell">
                <table>
                    <tr>
                        <td>
                            <p class="temple-name"><?php echo $temp_details['name']; ?></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p class="temple-address"><?php echo $temp_details['address1']; ?>,
                                <?php echo $temp_details['address2']; ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p class="temple-address">
                                <?php echo $temp_details['city'] . '-' . $temp_details['postcode']; ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p class="temple-address">Tel: <?php echo $temp_details['telephone']; ?></p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="report-title">
                OFFERING REPORT
                <?php echo date("d/m/Y", strtotime($fdate)) . ' - ' . date("d/m/Y", strtotime($tdate)); ?>
            </td>
        </tr>
    </table>

    <!-- Data Table -->
    <table class="data-table">
        <thead>
            <tr>
                <th width="5%" style="text-align: center;">S.No</th>
                <th width="10%">Date</th>
                <th width="10%">Ref No</th> <!-- ADDED -->
                <th width="18%">Name</th>
                <th width="12%">Phone</th>
                <th width="13%">Category</th>
                <th width="17%">Product</th>
                <th width="17%">Quantity</th>
                <th width="15%" style="text-align: right;">Grams</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $fdt = date('Y-m-d', strtotime($fdate));
            $tdt = date('Y-m-d', strtotime($tdate));

            $dat = $db->table('product_offering po')
                ->join('product_offering_detail pod', 'pod.pro_off_id = po.id')
                ->join('product_category pc', 'pc.id = pod.product_id')
                ->join('offering_category oc', 'oc.id = pod.offering_id')
                ->select('po.*, pod.*, po.id as main_id, po.ref_no, pc.name as product_name, oc.name as category_name') // ADDED po.ref_no
                ->where('DATE_FORMAT(po.date, "%Y-%m-%d") >=', $fdt)
                ->where('DATE_FORMAT(po.date, "%Y-%m-%d") <=', $tdt);

            if (!empty($type)) {
                $dat = $dat->where('pod.offering_id =', $type);
            }

            if (!empty($ptype)) {
                $dat = $dat->where('pod.product_id =', $ptype);
            }

            $dat = $dat->orderBy('po.id', 'desc');
            $results = $dat->get()->getResultArray();

            $sn = 1;
            $totalGrams = 0;
            $totalByCategory = [];

            if (!empty($results)) {
                foreach ($results as $row) {
                    $totalGrams += (float) $row['grams'];

                    // Track totals by category
                    if (isset($totalByCategory[$row['category_name']])) {
                        $totalByCategory[$row['category_name']] += (float) $row['grams'];
                    } else {
                        $totalByCategory[$row['category_name']] = (float) $row['grams'];
                    }
                    ?>
                    <tr>
                        <td class="center"><?php echo $sn++; ?></td>
                        <td><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>
                        <td><?php echo $row['ref_no'] ?? ''; ?></td> <!-- ADDED -->
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['phone']; ?></td>
                        <td><?php echo $row['category_name']; ?></td>
                        <td><?php echo $row['product_name']; ?></td>
                        <td><?php echo $row['quantity']; ?></td>
                        <td class="right"><?php echo number_format($row['grams'], 2); ?></td>
                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan="8" class="center">No records found</td> <!-- CHANGED from 7 to 8 -->
                </tr>
            <?php } ?>

            <!-- Category Totals -->
            <?php if (!empty($totalByCategory)) { ?>
                <?php foreach ($totalByCategory as $category => $grams) { ?>
                    <tr class="total-row">
                        <td colspan="8" style="text-align: right;"><strong>Total <?php echo $category; ?>:</strong></td>
                        <!-- CHANGED from 6 to 7 -->
                        <td class="right"><strong><?php echo number_format($grams, 2); ?></strong></td>
                    </tr>
                <?php } ?>
            <?php } ?>

            <!-- Grand Total -->
            <?php if (!empty($results)) { ?>
                <tr class="total-row">
                    <td colspan="8" style="text-align: right;"><strong>Grand Total:</strong></td>
                    <!-- CHANGED from 6 to 7 -->
                    <td class="right"><strong><?php echo number_format($totalGrams, 2); ?></strong></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>

</html>