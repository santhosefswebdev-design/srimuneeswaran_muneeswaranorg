<?php        
$db = db_connect();
?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Barlow&display=swap" rel="stylesheet">
<style>
body { font-family: 'Barlow', sans-serif; }
.tbor, th {
    border: 1px solid #444242;
}
table { border-collapse: collapse; }
table td, table th { padding: 5px; }
@media print {
    .vendorListHeading th {
        color: black !important;
    }
}
</style>

<table align="center" style="width:100%; max-width:800px;">
    <tr><td colspan="2">
        <table style="width:100%">
            <tr>
                <td width="15%" align="left">
                    <img src="<?php echo base_url(); ?>/uploads/main/<?php echo $_SESSION['logo_img']; ?>" style="width:120px;" align="center">
                </td>
                <td width="85%" align="center">
                    <h2 style="text-align:center; margin-bottom:0;"><?php echo $_SESSION['site_title']; ?></h2>
                   <p style="text-align:center; font-size:16px; margin:5px 0px;">
    <?php echo $_SESSION['address1']; ?>, <br>
    <?php echo $_SESSION['address2']; ?>
    <?php echo $_SESSION['city']; ?> - <?php echo $_SESSION['postcode']; ?>, Tel : <?php echo $_SESSION['telephone']; ?>
   
</p>
                </td>
            </tr>
        </table>
    </td></tr>
    <tr><td colspan="2"><hr></td></tr>

    <tr><td colspan="2" style="width:100%;">
        <?php 
        $payfor   = $pdfdata['payfor'];
        $fdate    = $pdfdata['fdate'];
        $tdate    = $pdfdata['tdate'];
        $fltername = $pdfdata['fltername']; 
        ?>
        <h3 style="text-align:center;">
            CASH DONATION <?php echo date("d/m/Y", strtotime($fdate)) . ' - ' . date("d/m/Y", strtotime($tdate)); ?>
        </h3>
        <?php if ($payfor): 
            $res        = $db->query("SELECT * FROM donation_setting WHERE id = $payfor")->getRowArray();
            $targetamt  = number_format($res['amount'], 2, '.', ',');
            $res_don_set = $db->table('donation_setting ds')
                ->join('donation d', 'ds.id = d.pay_for', 'left')
                ->select('max(ds.amount) as total_amount')
                ->select('COALESCE(sum(d.amount), 0) as collected_amount')
                ->where(['ds.id' => $payfor])
                ->get()->getRowArray();
        ?>
        <h4 style="text-align:center;"><?php echo $res['name'] . ' &mdash; Target Amount ' . $targetamt; ?></h4>
        </td></tr>
        <tr><td colspan="2" style="width:100%;">
        <table>
            <tr>
                <td><b>Target Amount :</b></td>
                <td><?php echo $res_don_set['total_amount']; ?></td>
                <td>&nbsp;&nbsp;<b>Collected Amount :</b></td>
                <td><?php echo $res_don_set['collected_amount']; ?></td>
                <td>&nbsp;&nbsp;<b>Balance Amount :</b></td>
                <td><?php 
                    $balance_amount = $res_don_set['total_amount'] - $res_don_set['collected_amount'];
                    echo ($balance_amount >= 0) ? $balance_amount : '0';
                ?></td>
            </tr>
        </table>
        <?php endif; ?>
    </td></tr>
</table>

<table border="1" width="100%" align="center">
    <thead>
        <tr style="background-color:#444242; color:#fff;">
            <th width="5%"  align="center">S.No</th>
            <th width="18%" align="left">Date</th>
            <th width="25%" align="left">Pay For</th>
            <th width="38%" align="left">Name</th>
            <th width="19%" align="right">Amount</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $total = 0; 
        $fdt   = date('Y-m-d', strtotime($fdate));
        $tdt   = date('Y-m-d', strtotime($tdate));

        $dat = $db->table('donation')
            ->join('donation_setting', 'donation_setting.id = donation.pay_for')
            ->select('donation_setting.name as pname')
            ->select('donation.*')
            ->where('donation.date >=', $fdt)
            ->where('donation.date <=', $tdt);

        if ($payfor)    $dat = $dat->where('donation_setting.id', $payfor);
        if ($fltername) $dat = $dat->where('donation.name', $fltername);

        $dat = $dat->get()->getResultArray();
        $sn  = 1;
        foreach ($dat as $row):
            $total += $row['amount'];
        ?>
        <tr>
            <td align="center"><?= $sn++; ?></td>
            <td><?= date('d-m-Y', strtotime($row['date'])); ?></td>
            <td><?= $row['pname']; ?></td>
            <td><?= $row['name']; ?></td>
            <td align="right"><?= number_format($row['amount'], 2, '.', ','); ?></td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="4" align="right"><b>Total Amount</b></td>
            <td align="right"><b><?= number_format($total, 2, '.', ','); ?></b></td>
        </tr>
    </tbody>
</table>