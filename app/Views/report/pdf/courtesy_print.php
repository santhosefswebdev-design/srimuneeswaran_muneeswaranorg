<?php
$db = db_connect();
$data = $pdfdata;
$fdt = date('Y-m-d', strtotime($data['fdate']));
$tdt = date('Y-m-d', strtotime($data['tdate']));
?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Barlow&display=swap" rel="stylesheet">
<style>
    body {
        font-family: 'Barlow', sans-serif;
    }

    .tbor,
    th {
        border: 1px solid #444242;
    }

    table th {
        background-color: #444242 !important;
        color: #fff;
    }

    table {
        border-collapse: collapse;
    }

    table td,
    table th {
        padding: 5px;
    }

    .inner_table tr:nth-child(even) {
        background: #ffffff;
    }

    .inner_table tr:last-child {
        background: #ffffff;
    }
</style>

<table align="center" style="width:100%; max-width:800px;">
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
                            <?php echo $_SESSION['city']; ?> -
                            <?php echo $_SESSION['postcode']; ?><br>
                            Tel :
                            <?php echo $_SESSION['telephone']; ?>
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <hr>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="width:100%;">
            <h3 style="text-align:center;">
                COURTESY REPORT &nbsp;
                <?php echo date("d/m/Y", strtotime($data['fdate'])) . ' - ' . date("d/m/Y", strtotime($data['tdate'])); ?>
            </h3>
        </td>
    </tr>
</table>

<table border="1" width="100%" align="center">
    <thead>
        <tr class="vendorListHeading">
            <th width="5%">S.No</th>
            <th align="left" width="12%">Type</th>
            <th align="left" width="12%">Date</th>
            <th align="left" width="25%">Name</th>
            <th align="left" width="15%">Mobile No</th>
            <th align="left" width="20%">Email</th>
            <th align="right" width="11%">Amount</th>
        </tr>
    </thead>
    <tbody style="background:#ffffff;">
        <?php
        $total = 0;
        $i = 1;
        foreach ($data['list'] as $row):
            $total += $row['amount'];
            ?>
            <tr>
                <td>
                    <?php echo $i++; ?>
                </td>
                <td>
                    <?php echo $row['type']; ?>
                </td>
                <td>
                    <?php echo date('d-m-Y', strtotime($row['date'])); ?>
                </td>
                <td>
                    <?php echo htmlspecialchars($row['name']); ?>
                </td>
                <td>
                    <?php echo $row['mobile_no'] ?: 'N/A'; ?>
                </td>
                <td>
                    <?php echo $row['email_id'] ?: 'N/A'; ?>
                </td>
                <td style="text-align:right;">
                    <?php echo number_format($row['amount'], 2, '.', ','); ?>
                </td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="6" style="text-align:right;"><b>Total</b></td>
            <td align="right"><b>
                    <?php echo number_format((float) $total, 2, '.', ''); ?>
                </b></td>
        </tr>
    </tbody>
</table>