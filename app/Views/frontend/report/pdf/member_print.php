<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Member Report PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 10px;
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
        }

        .header h2 {
            margin: 3px 0;
            font-size: 18px;
        }

        .header h3 {
            margin: 3px 0;
            font-size: 16px;
        }

        .date-range {
            text-align: center;
            margin-bottom: 15px;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table th,
        table td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
            font-size: 10px;
        }

        table th {
            background-color: #f7ebbb;
            font-weight: bold;
        }

        .footer {
            margin-top: 15px;
            text-align: right;
            font-size: 11px;
            font-weight: bold;
        }

        .status-active {
            color: green;
            font-weight: bold;
        }

        .status-inactive {
            color: red;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <table border="1" align="center" style="border-collapse: collapse; width: 100%;">
        <tbody>
            <tr>
                <td width="15%" style="border: 1px solid #000; vertical-align: top;">
                    <img src="<?php echo base_url(); ?>/uploads/main/<?php echo $pdfdata['temp_details']['image']; ?>"
                        style="width:120px;" align="left">
                </td>
                <td width="85%" style="padding: 0px; border: 1px solid #000;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td>
                                <h2 style="text-align:center; margin-bottom: 0; font-size: 18px;">
                                    <?php echo $pdfdata['temp_details']['name']; ?>
                                </h2>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p style="text-align:center; font-size:16px; margin:0;">
                                    <?php echo $pdfdata['temp_details']['address1']; ?>,
                                    <?php echo $pdfdata['temp_details']['address2']; ?>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p style="text-align:center; font-size:16px; margin:0;">
                                    <?php echo $pdfdata['temp_details']['city'] . '-' . $pdfdata['temp_details']['postcode']; ?>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p style="text-align:center; font-size:16px; margin-left:120px;">
                                    Tel : <?= $pdfdata['temp_details']['telephone']; ?>
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="width: 100%;">
                    <h3 style="text-align:center;"> MEMBER REPORT
                        <?php echo date("d/m/Y", strtotime($pdfdata['fdate'])) . ' - ' . date("d/m/Y", strtotime($pdfdata['tdate'])); ?>
                    </h3>
                </td>
            </tr>
        </tbody>
    </table>

    <?php
    $fdt = date('Y-m-d', strtotime($pdfdata['fdate']));
    $tdt = date('Y-m-d', strtotime($pdfdata['tdate']));
    $status_filter = $pdfdata['status_filter'] ?? '';
    $name_filter = $pdfdata['name_filter'] ?? '';

    $db = \Config\Database::connect();
    $builder = $db->table('member as m')
        ->select('m.id, m.name, m.member_no, m.email_address, m.mobile, m.address, m.ic_no, m.created, m.status')
        ->where('DATE_FORMAT(m.created, "%Y-%m-%d") >=', $fdt)
        ->where('DATE_FORMAT(m.created, "%Y-%m-%d") <=', $tdt);

    if (!empty($status_filter) && $status_filter !== '') {
        $builder->where('m.status', $status_filter);
    }

    if (!empty($name_filter)) {
        $builder->like('m.name', $name_filter);
    }

    $results = $builder->orderBy('m.created', 'desc')->get()->getResultArray();
    ?>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">S.No</th>
                <th style="width: 10%;">Reg. Date</th>
                <th style="width: 10%;">Member No</th>
                <th style="width: 12%;">Name</th>
                <th style="width: 13%;">Email</th>
                <th style="width: 10%;">Mobile</th>
                <th style="width: 10%;">IC No</th>
                <th style="width: 20%;">Address</th>
                <th style="width: 10%;">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            $total_members = count($results);
            $active_count = 0;
            $inactive_count = 0;

            foreach ($results as $row) {
                // Count active/inactive (status is text: 'active' or 'inactive')
                if ($row['status'] == 'active') {
                    $active_count++;
                } else {
                    $inactive_count++;
                }

                // Format mobile number - use 'mobile' column directly
                $mobile_display = !empty($row['mobile']) ? $row['mobile'] : '-';

                // Format status
                $status_class = $row['status'] == '1' ? 'status-active' : 'status-inactive';
                $status_text = $row['status'] == '1' ? 'Active' : 'Inactive';

                // Format address - use 'address' column directly
                $address = !empty($row['address']) ? trim($row['address']) : '-';

                // Format other fields
                $member_no = !empty($row['member_no']) ? $row['member_no'] : '-';
                $ic_no = !empty($row['ic_no']) ? $row['ic_no'] : '-';
                $email = !empty($row['email_address']) ? $row['email_address'] : '-';
                ?>
                <tr>
                    <td><?php echo $i++; ?></td>
                    <td><?php echo date('d-m-Y', strtotime($row['created'])); ?></td>
                    <td><?php echo $member_no; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $email; ?></td>
                    <td><?php echo $mobile_display; ?></td>
                    <td><?php echo $ic_no; ?></td>
                    <td><?php echo $address; ?></td>
                    <td><span class="<?php echo $status_class; ?>"><?php echo $status_text; ?></span></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <div class="footer">
        <div>Total Members: <?php echo $total_members; ?></div>
        <div>Active: <?php echo $active_count; ?> | Inactive: <?php echo $inactive_count; ?></div>
    </div>
</body>

</html>