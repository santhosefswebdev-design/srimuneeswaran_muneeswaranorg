<!DOCTYPE html>
<html>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow&display=swap" rel="stylesheet">
    <style>
        @font-face {
            font-family: "Baamini";
            src: url('<?php echo base_url(); ?>/assets/font/Baamini.ttf');
            font-weight: normal;
            font-style: normal;
        }

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

        .print_header * {
            color: #fff;
        }

        .print_header {
            margin: 0 auto;
            position: relative;
        }

        .since {
            font-size: 10px;
            z-index: 9999;
            left: 55px;
        }
    </style>
</head>

<body>
    <div style="width: 100%; max-width: 210mm; margin: 0 auto;">

        <!-- HEADER TABLE -->
        <table align="center" style="width: 100%;">
            <tr>
                <td colspan="2">
                    <table style="width: 100%;">
                        <tr>
                            <td width="15%" align="left">
                                <img src="<?php echo base_url(); ?>/uploads/main/<?php echo $_SESSION['logo_img']; ?>"
                                    style="width: 120px;" align="left">
                            </td>
                            <td width="85%" align="left">
                                <h2 style="text-align:center; margin-bottom: 0; margin-top: 8px;">
                                    <?php echo $_SESSION['site_title']; ?>
                                </h2>
                                <p style="text-align:center; font-size: 16px; margin: 0px;">
                                    <?php echo $_SESSION['city']; ?><br>
                                    <?php echo $_SESSION['address1']; ?>, <?php echo $_SESSION['address2']; ?>
                                    <?php echo $_SESSION['postcode']; ?> <?php echo $_SESSION['city']; ?><br>
                                    Tel : <?php echo $_SESSION['telephone']; ?>
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
        </table>

        <!-- REPORT CONTENT -->
        <div>
            <h3 style="text-align:center;">
                Deity Report
                <?php if ($grp != '0' && $grp != '') {
                    echo ' - ' . $grp;
                } ?>
            </h3>
            <h3 style="text-align:center;">
                [From : <?= date('d-m-Y', strtotime($pdfdata['fdate'])); ?> To
                <?= date('d-m-Y', strtotime($pdfdata['tdate'])); ?>]
            </h3>

            <table border="1" width="100%" align="center">
                <thead>
                    <tr>
                        <th width="5%">SNO</th>
                        <th width="12%">Date</th>
                        <th width="22%">Product Name in English</th>
                        <th width="28%">Deity Name</th>
                        <th width="10%">Quantity</th>
                        <th width="10%" style="text-align:right; padding-right:8px;">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($pdfdata['data'])) {
                        $total = 0;
                        $i = 1;
                        foreach ($pdfdata['data'] as $row) {
                            $amt = (float) $row['rate']; // FIX: use float, not number_format
                            if (!empty($row['name'])) {
                                ?>
                                <tr>
                                    <td style="text-align:center;"><?= $i++; ?></td>
                                    <td style="text-align:center;"><?= date('d-m-Y', strtotime($row['date'])); ?></td>
                                    <td style="text-align:left; padding-left:8px;"><?= $row['name_eng']; ?></td>
                                    <td style="text-align:left; padding-left:8px;"><?= $row['name']; ?></td>
                                    <td style="text-align:center;"><?= $row['qunt']; ?></td>
                                    <td style="text-align:right; padding-right:8px;"><?= number_format($amt, 2, '.', ''); ?></td>
                                    <!-- FIX: formatted 2 decimal -->
                                </tr>
                                <?php
                                $total += $amt; // FIX: add float not string
                            }
                        }
                        ?>
                        <tr style="font-weight:bold; background:#e2dfdf;">
                            <td colspan="5" style="text-align:right; padding-right:8px;">Total</td>
                            <!-- FIX: colspan 5 not 6 -->
                            <td style="text-align:right; padding-right:8px;">
                                <?= number_format((float) $total, 2, '.', ''); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>
</body>

</html>