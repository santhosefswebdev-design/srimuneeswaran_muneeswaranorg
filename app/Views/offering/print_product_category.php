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

    table td,
    table th {
        padding: 5px;
        text-align: center;
    }

    .inner_table tr:nth-child(even) {
        background: #F3F3F3;
    }

    .no-print {
        margin-bottom: 15px;
    }

    @media print {
        .no-print {
            display: none !important;
        }
    }
</style>

<!-- Print / Back Buttons -->
<!-- <div class="no-print">
    <button onclick="window.print()"
        style="padding:8px 20px; background:#333; color:#fff; border:none; cursor:pointer; border-radius:4px; margin-right:8px;">
        🖨️ Print
    </button>
    <button onclick="window.history.back()"
        style="padding:8px 20px; background:#888; color:#fff; border:none; cursor:pointer; border-radius:4px;">
        ← Back
    </button>
</div> -->

<!-- ===== TEMPLE HEADER ===== -->
<table border="1" align="center" style="border-collapse: collapse; width: 100%;">
    <tbody>
        <tr>
            <td width="15%" style="border: 1px solid #000; vertical-align: top;">
                <img src="<?php echo base_url(); ?>/uploads/main/<?php echo $temp_details['image']; ?>"
                    style="width:120px;" align="left">
            </td>
            <td width="85%" style="padding: 0px; border: 1px solid #000;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td>
                            <h2 style="text-align:center; margin-bottom: 0; font-size: 18px;">
                                <?php echo $temp_details['name']; ?>
                            </h2>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="text-align:center; font-size:16px; margin:0;">
                                <?php echo $temp_details['address1']; ?>, <?php echo $temp_details['address2']; ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="text-align:center; font-size:16px; margin:0;">
                                <?php echo $temp_details['city'] . '-' . $temp_details['postcode']; ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="text-align:center; font-size:16px; margin:0;">
                                Tel : <?php echo $temp_details['telephone']; ?>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="width: 100%;">
                <h3 style="text-align:center;">PRODUCT STOCK LIST</h3>
            </td>
        </tr>
    </tbody>
</table>
<!-- ===== END HEADER ===== -->

<h3 style="text-align:center;">
    Printed On : <?php echo date('d-m-Y'); ?>
</h3>

<!-- ===== STOCK TABLE ===== -->
<table border="1" width="100%" align="center">
    <thead>
        <tr>
            <th width="5%">SNO</th>
            <th width="30%">Offering Category</th>
            <th width="35%">Product Name</th>
            <th width="15%">Stock (g)</th>
            <th width="15%">Stock (Items)</th>
        </tr>
    </thead>
    <tbody class="inner_table">
        <?php
        $i = 1;
        $currentCat = null;
        $totalGrams = 0;
        $totalItems = 0;

        foreach ($list as $row):
            // Category group header row
            if ($currentCat !== $row['category']):
                $currentCat = $row['category'];
                ?>
                <tr>
                    <td colspan="5" style="background:#555; color:#fff; font-weight:bold; text-align:left; padding:5px 10px;">
                        <?php echo htmlspecialchars($row['category']); ?>
                    </td>
                </tr>
            <?php endif; ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td style="text-align:left;"><?php echo htmlspecialchars($row['category']); ?></td>
                <td style="text-align:left;"><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo number_format((float) ($row['stock_grams'] ?? 0), 2); ?></td>
                <td><?php echo number_format((float) ($row['stock_items'] ?? 0), 2); ?></td>
            </tr>
            <?php
            $totalGrams += $row['stock_grams'] ?? 0;
            $totalItems += $row['stock_items'] ?? 0;
        endforeach; ?>

        <!-- Grand Total -->
        <tr style="font-weight:bold;">
            <td colspan="3" style="text-align:right;">GRAND TOTAL</td>
            <td><?php echo number_format($totalGrams, 2); ?> g</td>
            <td><?php echo number_format($totalItems, 2); ?></td>
        </tr>
    </tbody>
</table>

<!-- ===== SIGNATURE FOOTER ===== -->
<br><br>
<!-- <table width="100%" style="border: none; margin-top: 30px;">
    <tr>
        <td width="33%" style="border: none; text-align: center;">
            <br><br>
            ___________________________<br>
            Prepared By
        </td>
        <td width="33%" style="border: none; text-align: center;">
            <br><br>
            ___________________________<br>
            Verified By
        </td>
        <td width="33%" style="border: none; text-align: center;">
            <br><br>
            ___________________________<br>
            Authorized By
        </td>
    </tr> 
</table> -->

<script>
    window.print();
</script>