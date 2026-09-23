<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    body { font-family: Arial, sans-serif; }
    .chart-container {
        width: 75vw;
        height: 40vh;
        margin: 20px auto;
        overflow-x: auto;
    }
    .col-lg-12,
    .col-md-12,
    .col-sm-12,
    .col-xs-12 {
        height: auto;
    }

    .chart-container {
        display: flex;
        flex-direction: column;
        align-items: center; 
    }

</style>
<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>Daily Closing<small>Analytics</small></h2>
		</div>
		<div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <form action="<?php echo base_url(); ?>/salesreport" method="post" id="salesReportForm">
                            <div class="row">
                                <div class="col-md-2">
                                    <select class="form-control" id="reportType" name="reportType">
                                        <option value="" selected disabled>Select Report Type</option>
                                        <option value="daily" <?php if (isset($_POST['reportType']) && $_POST['reportType'] == 'daily') echo 'selected'; ?>>Daily</option>
                                        <option value="weekly" <?php if (isset($_POST['reportType']) && $_POST['reportType'] == 'weekly') echo 'selected'; ?>>Weekly</option>
                                        <option value="monthly" <?php if (isset($_POST['reportType']) && $_POST['reportType'] == 'monthly') echo 'selected'; ?>>Monthly</option>
                                    </select>
                                </div>
                                <div class="col-md-2" id="dateInputs">
                                    <?php
                                    $reportType = isset($_POST['reportType']) ? $_POST['reportType'] : 'daily';
                                    if ($reportType == 'daily') {
                                        echo '<input type="date" class="form-control" name="dailyclosing_start_date" value="' . ($_POST['dailyclosing_start_date'] ?? '') . '">';
                                        echo '<input type="date" class="form-control" name="dailyclosing_end_date" value="' . ($_POST['dailyclosing_end_date'] ?? '') . '">';
                                    } elseif ($reportType == 'weekly') {
                                        echo '<input type="week" class="form-control" name="weekYear" value="' . ($_POST['weekYear'] ?? '') . '">';
                                    } elseif ($reportType == 'monthly') {
                                        echo '<input type="month" class="form-control" name="fromMonthYear" value="' . ($_POST['fromMonthYear'] ?? '') . '">';
                                        echo '<input type="month" class="form-control" name="toMonthYear" value="' . ($_POST['toMonthYear'] ?? '') . '">';
                                    }
                                    ?>
                                </div>

                                <div class="col-md-2">
                                    <button type="submit" id="filterButton" class="btn btn-success">Filter</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="body">
                        <div class="row justify-content-end">
                            <div class="col-md-8"></div>
                            <div class="col-md-2 justify-content-end">
                                <select class="form-control" id="metricType">
                                    <option value="Count" <?php if (isset($_POST['metricType']) && $_POST['metricType'] == 'Count') echo 'selected'; ?>>Count</option>
                                    <option value="Amount" <?php if (isset($_POST['metricType']) && $_POST['metricType'] == 'Amount') echo 'selected'; ?>>Amount</option>
                                </select>
                            </div>
                            <div class="col-md-2 justify-content-end">
                                <button type="button" id="metricButton" class="btn btn-primary">Change Metric</button>
                            </div>
                        </div><br>

                        <div class="row">
                            <div class="col-md-12">
                                <h3 id="reportTitle" style="text-align: center"><?= $reportTitle; ?></h3>
                            </div>
                            <?php
                                $reportType = isset($_POST['reportType']) ? $_POST['reportType'] : '';

                                if ($reportType == 'daily') {
                                    echo '<div class="chart-container">
                                            <canvas id="dailySalesBarChartCount"></canvas>
                                            <canvas id="dailySalesBarChartAmount"></canvas>
                                        </div><br>
                                        <div class="chart-container">
                                            <canvas id="dailySalesLineChartCount"></canvas>
                                            <canvas id="dailySalesLineChartAmount"></canvas>
                                        </div><br>
                                        <div class="chart-container">
                                            <canvas id="dailySalesPieChartCount"></canvas>
                                            <canvas id="dailySalesPieChartAmount"></canvas>
                                        </div>';
                                } elseif ($reportType == 'weekly') {
                                    echo '<div class="chart-container">
                                            <canvas id="weeklySalesBarChartCount"></canvas>
                                            <canvas id="weeklySalesBarChartAmount"></canvas>
                                        </div><br>
                                        <div class="chart-container">
                                            <canvas id="weeklySalesLineChartCount"></canvas>
                                            <canvas id="weeklySalesLineChartAmount"></canvas>
                                        </div><br>
                                        <div class="chart-container">
                                            <canvas id="weeklySalesPieChartCount"></canvas>
                                            <canvas id="weeklySalesPieChartAmount"></canvas>
                                        </div>';
                                } elseif ($reportType == 'monthly') {
                                    echo '<div class="chart-container">
                                            <canvas id="monthlySalesBarChartCount"></canvas>
                                            <canvas id="monthlySalesBarChartAmount"></canvas>
                                        </div><br>
                                        <div class="chart-container">
                                            <canvas id="monthlySalesLineChartCount"></canvas>
                                            <canvas id="monthlySalesLineChartAmount"></canvas>
                                        </div><br>
                                        <div class="chart-container">
                                            <canvas id="monthlySalesPieChartCount"></canvas>
                                            <canvas id="monthlySalesPieChartAmount"></canvas>
                                        </div>';
                                }
                            ?>
                        </div>
                            <br>
                        <div class="total-values">
                            <div>
                                <h2>Summary:</h2>
                                <p>Cash: <?php echo number_format($salesData['Totals']['SubTotal']['cash'], 2); ?> MYR</p>
                                <p>QR: <?php echo number_format($salesData['Totals']['SubTotal']['qr'], 2); ?> MYR</p>
                                <p>iPay Card: <?php echo number_format($salesData['Totals']['SubTotal']['ipay_card'], 2); ?> MYR</p>
                                <p>iPay Merch QR: <?php echo number_format($salesData['Totals']['SubTotal']['ipay_merch_qr'], 2); ?> MYR</p>
                                <p>Total Amount: <?php echo number_format($salesData['Totals']['SubTotal']['total_amount'], 2); ?> MYR</p>

                                <h4>Grand Total</h4>
                                <p>Devotees Count: <?php echo number_format($salesData['Totals']['GrandTotal']['count'], 0); ?> Transactions</p>
                                <p>Total Amount: <?php echo number_format($salesData['Totals']['GrandTotal']['amount'], 2); ?> MYR</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('reportType').addEventListener('change', function() {
        var selectedType = this.value;
        var dateInputs = document.getElementById('dateInputs');

        if (selectedType === 'daily') {
            dateInputs.innerHTML = '<input type="date" name="dailyclosing_start_date" class="form-control">' +
                                   '<input type="date" name="dailyclosing_end_date" class="form-control">';
        } else if (selectedType === 'weekly') {
            dateInputs.innerHTML = '<input type="month" name="monthYear" class="form-control">';
        } else if (selectedType === 'monthly') {
            dateInputs.innerHTML = '<input type="month" name="fromMonthYear" class="form-control">' +
                                   '<input type="month" name="toMonthYear" class="form-control">';
        } else {
            dateInputs.innerHTML = ''; 
        }
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var reportType = document.getElementById('reportType').value;
        displayCharts(reportType, 'Count'); // Change this to 'daily', 'weekly', or 'monthly' and 'Count' or 'Amount' as needed

        document.getElementById('metricButton').addEventListener('click', function() {
            var metricType = document.getElementById('metricType').value;
            var reportType = document.getElementById('reportType').value;
            if (reportType && metricType) {
                displayCharts(reportType, metricType);
            } else {
                alert('Please select both report type and metric type.');
            }
        });
    });

    function displayCharts(chartType, dataType) {
        document.querySelectorAll('.chart-container canvas').forEach(function(canvas) {
            canvas.style.display = 'none';
        });

        var chartsToShow = document.querySelectorAll('.chart-container canvas[id*="' + chartType + '"][id*="' + dataType + '"]');
        chartsToShow.forEach(function(canvas) {
            canvas.style.display = 'block';
        });

        var salesData = <?= json_encode($salesData); ?>; 

        switch (chartType) {
            case 'daily':
                displayDailyCharts(salesData, dataType);
                break;
            case 'weekly':
                displayWeeklyCharts(salesData, dataType);
                break;
            case 'monthly':
                displayMonthlyCharts(salesData, dataType);
                break;
            default:
                console.error('Invalid chart type: ' + chartType);
        }
    }

    function displayDailyCharts(data, dataType) {
        console.log("displayDailyCharts called with dataType:", dataType);
        console.log("Data passed to displayDailyCharts:", data);
        displayBarChart('dailySalesBarChart' + dataType.capitalize(), data, dataType);
        displayLineChart('dailySalesLineChart' + dataType.capitalize(), data, dataType);
        displayPieChart('dailySalesPieChart' + dataType.capitalize(), data, dataType);
    }

    function displayWeeklyCharts(data, dataType) {

        console.log("displayWeeklyCharts called with dataType:", dataType);
        console.log("Data passed to displayWeeklyCharts:", data);
        displayBarChart('weeklySalesBarChart' + dataType.capitalize(), data, dataType);
        displayLineChart('weeklySalesLineChart' + dataType.capitalize(), data, dataType);
        displayPieChart('weeklySalesPieChart' + dataType.capitalize(), data, dataType);
    }

    function displayMonthlyCharts(data, dataType) {
        displayBarChart('monthlySalesBarChart' + dataType.capitalize(), data, dataType);
        displayLineChart('monthlySalesLineChart' + dataType.capitalize(), data, dataType);
        displayPieChart('monthlySalesPieChart' + dataType.capitalize(), data, dataType);
    }

    function displayBarChart(chartId, salesData, dataType) {
        var ctx = document.getElementById(chartId).getContext('2d');
        var labels = Object.keys(salesData['MainData']); 
        var datasets = [];

        var counterData = labels.map(date => {
            var dayData = salesData['MainData'][date];
            return dataType === 'Count' ? dayData['CounterCount']['cash'] + dayData['CounterCount']['qr'] :
                                        dayData['Counter']['cash'] + dayData['Counter']['qr'];
        });
        var kioskData = labels.map(date => {
            var dayData = salesData['MainData'][date];
            return dataType === 'Count' ? dayData['KioskCount']['ipay_card'] + dayData['KioskCount']['ipay_merch_qr'] :
                                        dayData['Kiosk']['ipay_card'] + dayData['Kiosk']['ipay_merch_qr'];
        });

        datasets.push({
            label: 'Counter',
            backgroundColor: 'rgba(54, 162, 235, 0.6)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1,
            data: counterData
        });

        datasets.push({
            label: 'Kiosk',
            backgroundColor: 'rgba(255, 159, 64, 0.6)',
            borderColor: 'rgba(255, 159, 64, 1)',
            borderWidth: 1,
            data: kioskData
        });

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: datasets
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    datalabels: {
                        color: '#444',
                        anchor: 'end',
                        align: 'top',
                        formatter: function(value, context) {
                            return value;
                        }
                    }
                },
                responsive: true,
                maintainAspectRatio: false
            },
            plugins: [ChartDataLabels] 
        });
    }

    function displayLineChart(chartId, salesData, dataType) {
        var ctx = document.getElementById(chartId).getContext('2d');
        var labels = Object.keys(salesData['MainData']);
        var totalSales = labels.map(date => {
            var dayData = salesData['MainData'][date];
            if (dataType === 'Count') {
                return dayData['CounterCount']['cash'] + dayData['CounterCount']['qr'] +
                    dayData['KioskCount']['ipay_card'] + dayData['KioskCount']['ipay_merch_qr'];
            } else {
                return dayData['Counter']['cash'] + dayData['Counter']['qr'] +
                    dayData['Kiosk']['ipay_card'] + dayData['Kiosk']['ipay_merch_qr'];
            }
        });

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,  
                datasets: [{
                    label: 'Total Sales',
                    data: totalSales,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 1,
                    fill: true
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }

    function displayPieChart(chartId, salesData, dataType) {
        var ctx = document.getElementById(chartId).getContext('2d');
        var labels = ['Counter', 'Kiosk'];

        var counterTotal = 0;
        var kioskTotal = 0;

        Object.keys(salesData['MainData']).forEach(function(day) {
            var dayData = salesData['MainData'][day];
            if (dataType === 'Count') {
                counterTotal += dayData['CounterCount']['cash'] + dayData['CounterCount']['qr'];
                kioskTotal += dayData['KioskCount']['ipay_card'] + dayData['KioskCount']['ipay_merch_qr'];
            } else {
                counterTotal += dayData['Counter']['cash'] + dayData['Counter']['qr'];
                kioskTotal += dayData['Kiosk']['ipay_card'] + dayData['Kiosk']['ipay_merch_qr'];
            }
        });

        var dataset = {
            labels: labels,
            datasets: [{
                label: 'Payment Method Distribution',
                data: [counterTotal, kioskTotal],
                backgroundColor: ['rgba(54, 162, 235, 0.6)', 'rgba(255, 159, 64, 0.6)'],
                borderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 159, 64, 1)'],
                borderWidth: 1
            }]
        };

        new Chart(ctx, {
            type: 'pie',
            data: dataset,
            options: {
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    datalabels: {
                        formatter: (value, ctx) => {
                            let sum = ctx.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                            let percentage = ((value / sum) * 100).toFixed(2) + "%";
                            return percentage;
                        },
                        color: '#fff',
                        font: {
                            weight: 'bold'
                        },
                        anchor: 'end',
                        align: 'end'
                    }
                },
                responsive: true,
                maintainAspectRatio: false
            },
            plugins: [ChartDataLabels] 
        });
    }

    String.prototype.capitalize = function() {
        return this.charAt(0).toUpperCase() + this.slice(1);
    };
</script>
