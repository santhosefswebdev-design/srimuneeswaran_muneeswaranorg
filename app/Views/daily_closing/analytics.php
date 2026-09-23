<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: Arial, sans-serif; }
        .chart-container {
            width: 75vw;
            height: 40vh;
            margin: 20px auto;
			overflow-x: auto;
        }
    </style>
<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>Daily Closing<small>Analytics</small></h2>
		</div>
		<!-- Basic Examples -->
		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="col-md-6">
								<h3>Archanai Sales Report</h3>
							</div>
					<div class="chart-container">
						<canvas id="archanaiSalesChart" ></canvas>
					</div><br><br>
					<div class="col-md-6">
								<h3>Usage Report</h3>
							</div>
					<div class="chart-container">
					<canvas id="archanaiTransactionCountChart"></canvas>
						</div>
					<div class="col-md-6">
								<h3>Total Sales Report</h3>
							</div>
					<div class="chart-container">
						<canvas id="totalSalesChart"></canvas>
					</div>
				
				</div>
			</div>
		</div>
	</div>
</section>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var ctx1 = document.getElementById('archanaiSalesChart').getContext('2d');
        var archanaiSalesChart = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: ['Counter', 'Kiosk'],
                datasets: [{
                    label: 'Archanai Sales RM',
                    data: [<?= $archanai_sales_graph['counter']; ?>, <?= $archanai_sales_graph['kiosk']; ?>],
                    backgroundColor: ['rgba(54, 162, 235, 0.6)', 'rgba(255, 206, 86, 0.6)'],
                    borderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)'],
                    borderWidth: 1
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
                }
            }
        });

        var ctx2 = document.getElementById('totalSalesChart').getContext('2d');
        var totalSalesChart = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: ['Archanai', 'Donation', 'Prasadam'],
                datasets: [{
                    label: 'Total Sales Amount',
                    data: [<?= $total_sales_graph['Archanai']; ?>, <?= $total_sales_graph['Donation']; ?>, <?= $total_sales_graph['Prasadam']; ?>],
                    backgroundColor: ['rgba(75, 192, 192, 0.6)', 'rgba(153, 102, 255, 0.6)', 'rgba(255, 159, 64, 0.6)'],
                    borderColor: ['rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)'],
                    borderWidth: 1
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
                }
            }
        });
		var ctx3 = document.getElementById('archanaiTransactionCountChart').getContext('2d');
        var archanaiTransactionCountChart = new Chart(ctx3, {
            type: 'bar',
            data: {
                labels: ['Online', 'Counter'],
                datasets: [{
                    label: 'Number of Archanai Transactions',
                    data: [
                        <?= $archanai_transaction_count['ONLINE']; ?>, 
                        <?= $archanai_transaction_count['COUNTER']; ?>
                    ],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 99, 132, 0.6)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1  // Ensures that the scale is not fractional
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                }
            }
        });
    });
    </script>
	<!-- <script>
	console.log(transactionData);  // This should show {ONLINE: 58, COUNTER: 96}
	document.addEventListener('DOMContentLoaded', function() {
		var ctx = document.getElementById('transactionCountChart').getContext('2d');
		var transactionData = <?= json_encode($data['archanai_transaction_count']); ?>;
		var transactionCountChart = new Chart(ctx, {
		type: 'bar',
		data: {
			labels: ['ONLINE', 'COUNTER'],
			datasets: [{
				label: 'Number of Transactions',
				data: [transactionData.ONLINE, transactionData.COUNTER],
				backgroundColor: ['rgba(54, 162, 235, 0.6)', 'rgba(255, 206, 86, 0.6)'],
				borderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)'],
				borderWidth: 1
			}]
		},
		options: {
			scales: {
				y: {
					beginAtZero: true
				}
			}
		}
	});
	});
</script> -->
