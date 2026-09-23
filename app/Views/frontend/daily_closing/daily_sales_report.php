<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Sales Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 80%;
            border-collapse: collapse;
            margin: 0 auto;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
            text-align: center;
        }
        td:nth-child(3) {
            text-align: left;
        }
        td:nth-child(4), td:nth-child(5) {
            text-align: right;
        }
        .header-cell {
            text-align: center;
            font-weight: bold;
            padding: 0;
        }
    </style>
</head>
<body>

<?php if (!empty($sale_summary)): ?>
    <table border="1">
        <thead>
            <tr>
                <th>Item</th>
                <th>Code</th>
                <th>Qty</th>
                <th>Amount (S$)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sale_summary as $key => $values): ?>
                <tr>
                    <td colspan="4"><h4 class="capitalize"><?= $key ?></h4></td>
                </tr>
                <?php foreach ($values as $item): ?>
                    <tr>
                        <td><?= $item['name_eng'] ?></td>
                        <td><?= $item['ledger_code'] ?></td>
                        <td><?= $item['qty'] ?></td>
                        <td><?= number_format($item['total'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2">Total</th>
                <th><?= array_sum(array_column($sale_summary, 'qty')) ?></th>
                <th><?= number_format(array_sum(array_column($sale_summary, 'total')), 2) ?></th>
            </tr>
        </tfoot>
    </table>
<?php else: ?>
    <p>No sales data available.</p>
<?php endif; ?>

    <table>
        <tr>
            <td colspan="5" class="header-cell"><h2>SRI MUNEESWARAN TEMPLE</h2></td>
        </tr>
        <tr>
            <td colspan="5" class="header-cell"><h3>3, COMMONWEALTH DRIVE (S149594)</h3></td>
        </tr>
        <tr>
            <td colspan="5" class="header-cell"><h3>DAILY SALES REPORT - 01/08/2024 @ 2130 HRS</h3></td>
        </tr>
        
            <tr>
                <th>CODE</th>
                <th>DESCRIPTION</th>
                <th>QTY</th>
                <th>UNIT $</th>
                <th>TOTAL $</th>
            </tr>
        
        <tbody>
            <tr>
                <td>A0001</td>
                <td>BABANA ARCHANAI</td>
                <td>100</td>
                <td>0.70</td>
                <td>$70.00</td>
            </tr>
            <tr>
                <td>A0002</td>
                <td>COCONUT ARCHANAI</td>
                <td>10</td>
                <td>1.20</td>
                <td>$12.00</td>
            </tr>
            <tr>
                <td>A0003</td>
                <td>ALL GODS</td>
                <td>1</td>
                <td>15.00</td>
                <td>$15.00</td>
            </tr>
            <tr>
                <td>A0004</td>
                <td>NAVAGRAHA ARCHANAI</td>
                <td>2</td>
                <td>4.50</td>
                <td>$9.00</td>
            </tr>
            <tr>
                <td>C0001</td>
                <td>MUDIKAYIRU</td>
                <td>25</td>
                <td>5.00</td>
                <td>$125.00</td>
            </tr>
            <tr>
                <td>G0001</td>
                <td>GARLAND $5/-</td>
                <td>2</td>
                <td>5.00</td>
                <td>$10.00</td>
            </tr>
            <tr>
                <td>G0002</td>
                <td>GHEE LAMP</td>
                <td>50</td>
                <td>0.20</td>
                <td>$10.00</td>
            </tr>
            <tr>
                <td>G0003</td>
                <td>MILK</td>
                <td>50</td>
                <td>1.00</td>
                <td>$50.00</td>
            </tr>
            <tr>
                <td>G0004</td>
                <td>ROSE WATER</td>
                <td>7</td>
                <td>2.00</td>
                <td>$14.00</td>
            </tr>
            <tr>
                <td>G0005</td>
                <td>COCONUT</td>
                <td>5</td>
                <td>1.00</td>
                <td>$5.00</td>
            </tr>
            <tr>
                <td>P0001</td>
                <td>KESARI</td>
                <td>16</td>
                <td>1.00</td>
                <td>$16.00</td>
            </tr>
            <tr>
                <td>P0002</td>
                <td>SARKARAI PONGAL</td>
                <td>2</td>
                <td>17.00</td>
                <td>$34.00</td>
            </tr>
            <tr>
                <td>D0001</td>
                <td>GENERAL DONATION</td>
                <td>1</td>
                <td>200.00</td>
                <td>$200.00</td>
            </tr>
            <tr>
                <td>D0002</td>
                <td>CAMPHOR TRAY</td>
                <td>1</td>
                <td>215.00</td>
                <td>$215.00</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4">TOTAL</th>
                <th style="text-align: right;">$931.00</th>
            </tr>
        </tfoot>
    </table>

</body>
</html>
