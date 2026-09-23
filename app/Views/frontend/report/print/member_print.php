<!DOCTYPE html>
<html>

<head>
    <title>Member Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 5px 0;
        }

        .date-range {
            text-align: center;
            margin-bottom: 20px;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th,
        table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
            font-size: 12px;
        }

        table th {
            background-color: #f7ebbb;
            font-weight: bold;
        }

        @media print {
            .no-print {
                display: none;
            }
        }

        .print-btn {
            text-align: center;
            margin: 20px 0;
        }

        .btn {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .status-active {
            color: green;
            font-weight: bold;
        }

        .status-inactive {
            color: red;
            font-weight: bold;
        }
        .top { margin-top:0; }
        .top tr td { border:0 !important; }
    </style>
</head>

<body>

    <table border="1" align="center" style="border-collapse: collapse; width: 100%;">
        <tbody>
            <tr>
                <td width="15%" style="border: 1px solid #000; vertical-align: top;">
                    <img src="<?php echo base_url(); ?>/uploads/main/<?php echo $temp_details['image']; ?>"
                        style="width:120px;" align="left">
                </td>
                <td width="85%" style="padding: 0px;">
                    <table class="top" border="0" style="width: 100%; border-collapse: collapse;">
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
                                    Tel : <?= $temp_details['telephone']; ?>
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="width: 100%;">
                    <h3 style="text-align:center;"> MEMBER REPORT
                        <?php echo date("d/m/Y", strtotime($fdate)) . ' - ' . date("d/m/Y", strtotime($tdate)); ?>
                    </h3>
                </td>
            </tr>
        </tbody>
    </table>
    <!-- <div class="date-range">
        <strong>From:</strong> <?php echo date('d-m-Y', strtotime($fdate)); ?>
        <strong>To:</strong> <?php echo date('d-m-Y', strtotime($tdate)); ?>
    </div> -->

    <?php
    $fdt = date('Y-m-d', strtotime($fdate));
    $tdt = date('Y-m-d', strtotime($tdate));

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
                <th style="width:5%;">S.No</th>
                <th style="width:10%;">Registration Date</th>
                <th style="width:10%;">Member No</th>
                <th style="width:12%;">Name</th>
                <th style="width:12%;">Email</th>
                <th style="width:10%;">Mobile Number</th>
                <th style="width:10%;">IC Number</th>
                <th style="width:18%;">Address</th>
                <th style="width:8%;">Status</th>
                <th style="width:5%;">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            $total_members = count($results);
            $active_count = 0;
            $inactive_count = 0;

            foreach ($results as $row) {
                // Count status
                if ($row['status'] == 'active') {
                    $active_count++;
                } else {
                    $inactive_count++;
                }

                // Format mobile number
                $mobile_display = !empty($row['mobile']) ? $row['mobile'] : '-';

                // Format status
                $status_class = $row['status'] == '1' ? 'status-active' : 'status-inactive';
                $status_text = $row['status'] == '1' ? 'Active' : 'Inactive';

                // Format address
                $address = !empty($row['address']) ? trim($row['address']) : '-';

                // Format member_no and ic_no
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
                    <td>View</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <div style="margin-top: 20px; text-align: right;">
        <strong>Total Members: <?php echo $total_members; ?></strong><br>
        <strong>Active: <?php echo $active_count; ?> | Inactive: <?php echo $inactive_count; ?></strong>
    </div>
</body>
<script>
    window.onload = function () {
        window.print();
    }
</script>

</html>