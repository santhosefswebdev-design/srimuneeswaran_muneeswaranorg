<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $_SESSION['site_title']; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <style>

    </style>
</head>

<body>
<tr><td colspan="2">
    <table style="width:100%">
    <tr><td width="15%" align="left"><img src="<?php echo base_url(); ?>/uploads/main/<?php echo $_SESSION['logo_img']; ?>"
                        style="width:120px;" align="left"></td>
                <td width="85%" align="left">
                    <h2 style="text-align:left;margin-bottom: 0;"><?php echo $_SESSION['site_title']; ?></h2>
                    <p style="text-align:left; font-size:16px; margin:5px 0px;"><?php echo $_SESSION['address1']; ?>,
                       <br>
                        <?php echo $_SESSION['city']; ?> - <?php echo $_SESSION['postcode']; ?><br>
                        Tel : <?php echo $_SESSION['telephone']; ?></p>
                </td>
            </tr>
        </table>
    </td>
</tr>
    <h3 style="text-align:center;">VISITOR'S REGISTRATION LIST</h3><br>
    <table class="table table-bordered table-striped table-hover" style="width:100%;" border="1">
        <tr>
            <th>S.No</th>
            <th>Date</th>
            <th>Name</th>
            <th>Citizen</th>
            <th>Type</th>
            <th>Pax</th>
            <th>Comments</th>
        </tr>

        <?php $i = 1;
        foreach ($list as $row) {
            ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo date('d/m/Y', strtotime($row['created_at'])); ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['citizen']; ?></td>
                <td><?php echo $row['type']; ?></td>
                <td><?php echo $row['pax']; ?></td>
                <td><?php echo $row['comments']; ?></td>
            </tr>
            <?php
            $i++;
        }
        ?>

    </table>
    <script>
        window.print();
    </script>
</body>

</html>