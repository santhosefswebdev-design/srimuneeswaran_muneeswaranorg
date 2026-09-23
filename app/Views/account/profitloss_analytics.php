<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Income and Expenses Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>ACCOUNTS<small>Accounts / Income and Expenditure Analytics</small></h2>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>Income and Expenditure Analytics</h2>
                        </div>
                        <div class="body">
                            <canvas id="analyticsChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        var ctx = document.getElementById('analyticsChart').getContext('2d');

        // PHP variable containing the table data
        var tableData = <?php echo json_encode($data['table']); ?>;

        // Extract only numeric values from tableData
        var dataValues = [];

        for (var i = 0; i < tableData.length; i++) {
            if (isNumeric(tableData[i])) {
                var value = parseFloat(tableData[i].replace(/,/g, ''));
                dataValues.push(value);
            }
        }

        // Function to check if a string is numeric
        function isNumeric(value) {
            return !isNaN(parseFloat(value)) && isFinite(value);
        }

        // Generate labels for the bar chart
        var labels = dataValues.map((_, index) => 'Item ' + (index + 1));

        // Create chart data object
        var chartData = {
            labels: labels,
            datasets: [{
                label: 'Amount',
                data: dataValues,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        };

        // Chart options
        var chartOptions = {
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Amount'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Items'
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function (tooltipItem) {
                            return tooltipItem.dataset.label + ': ' + tooltipItem.formattedValue;
                        }
                    }
                }
            }
        };

        // Create Chart instance
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: chartData,
            options: chartOptions
        });
    });
    </script>
</body>
</html>
