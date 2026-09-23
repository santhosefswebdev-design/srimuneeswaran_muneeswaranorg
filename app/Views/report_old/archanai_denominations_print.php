<title><?php echo $_SESSION['site_title']; ?></title>
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

    .inner_table tr:last-child {
        background: #e2dfdf;
    }

    .print_header {
        margin: 0 auto;
        position: relative;
        color: black;
        /* Adjusted from white to black for readability */
    }

    .since {
        position: absolute;
        font-size: 10px;
        z-index: 9999;
        right: 55px;
    }
</style>

<table align="center" style="width: 100%; max-width: 800px;">
    <tr>
        <td colspan="2">
            <div class="print_header">
                <img src="<?php echo base_url(); ?>/uploads/main/<?php echo $_SESSION['logo_img']; ?>"
                    style="width:120px;" align="left">
                <h3><?php echo $_SESSION['name_tamil']; ?></h3>
                <p><?php echo $_SESSION['city_tamil']; ?> <?php echo $_SESSION['since_tamil']; ?></p>
                <h2><?php echo $_SESSION['site_title']; ?></h2>
                <p style="margin-left: 105px;"><?php echo $_SESSION['address1']; ?>, <?php echo $_SESSION['address2']; ?>,
                    <?php echo $_SESSION['postcode']; ?> <?php echo $_SESSION['city']; ?>
                    <br>Email: <?php echo $_SESSION['email']; ?>, Tel: <?php echo $_SESSION['telephone']; ?>
                    <br>Whatsapp: <?php echo $_SESSION['mobile']; ?>
                    <br>Website: <?php echo $_SESSION['website']; ?>, ISO: <?php echo $_SESSION['iso']; ?>
                </p>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <hr>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <h3 style="text-align:center;">Archanai Denominations Report</h3>
            <h4 style="text-align:center;">[From: <?= date('d-m-Y', strtotime($fdate)); ?> To
                <?= date('d-m-Y', strtotime($tdate)); ?>]</h4>
            <table border="1" width="100%" class="inner_table">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Coin Name</th>
                        <th>Quantity</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
            <?php
            $totalQuantity = 0;
            $totalAmount = 0;
            if (!empty($denominations)):
                foreach ($denominations as $index => $row):
                    $quantity = (int) $row['quantity'];  // Convert quantity to integer
                    $amount = floatval(str_replace(',', '', $row['total'])); // Convert amount to float and remove any commas
            
                    $totalQuantity += $quantity;
                    $totalAmount += $amount;
                    ?>
                    <tr>
                        <td><?= $index + 1; ?></td>
                        <td><?= htmlspecialchars($row['name']); ?></td>
                        <td><?= $quantity; ?></td>
                        <td><?= number_format($amount, 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No data available</td>
                </tr>
            <?php endif; ?>
           

                    <tr>
                        <td colspan="3" style="text-align:right;"><strong>Total Quantity :</strong><strong><?= $totalQuantity; ?></strong></td>
                        
                        <td colspan="3" style="text-align:right;"><strong>Total Amount :</strong><strong><?= number_format($totalAmount, 2); ?></strong></td>
                      
                    </tr>
                    <!-- <tr>
                        <td colspan="3" style="text-align:right;"><strong>Total Amount</strong></td>
                        <td><strong><?= number_format($totalAmount, 2); ?></strong></td>
                    </tr> -->
                </tbody>
            </table>
        </td>
    </tr>
</table>
<script>
    window.onload = function () {
        window.print();
    };
</script>