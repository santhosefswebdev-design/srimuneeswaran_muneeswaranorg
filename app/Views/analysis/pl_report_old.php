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
    body {
  background-color: #F7F4E9;
  font-family: sans-serif;
}

section {
  margin-top: 2rem;
  width: 100%;
  
  #chart-wrap {
    display: flex;
    flex-direction: column;
    height: auto;
    justify-content: center;
    margin: auto;
    max-width: 500px;
    position: relative;
    width: 100%;
    
    .chart-tooltip {
       margin-left: 15px;
       position: absolute;
       z-index: 10;
       
       .chart-tooltip-wrap {
          background-color: #181818;
          border-radius: 10px;
          box-shadow: 2px 2px 5px rgba(0, 0, 0, .3);
          display: block;
          padding: .875rem;

          p {
           color: #fff;
           font-size: .875rem;
           line-height: 1.75;
           margin: 0;
         }
       }
      }
    
    svg {
        margin: auto;
      
       .text {
        fill: #fff;
        font-size: .875rem;
        text-anchor: middle;
      }
    }
    
    .legend {
      display: flex;
      flex-direction: row;
      flex-wrap: wrap;
      gap: 10px;
      justify-content: flex-start;
      margin: 2rem auto;
      width: 100%;

      .legend-group {
        align-items: center;
        display: flex;
        flex-basis: 100px;
        flex-direction: row;
        gap: 8px;
        justify-content: flex-start;
        
        .legend-box {
          height: 20px;
          margin: 0;
          width: 20px;
        }
        
        .legend-label {
          margin: 0;
        }
      }
    }
  }
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
                    <div class="header">
                        <form action="<?php echo base_url(); ?>/planalysis" method="post" id="planalysisForm">
                            <div class="row">
                                <div class="col-md-2">
                                    <input type="month" class="form-control" name="fromMonthYear" value="<?php echo $_POST['fromMonthYear'] ?? ''; ?>">
                                </div>
                                <div class="col-md-2">
                                    <input type="month" class="form-control" name="toMonthYear" value="<?php echo $_POST['toMonthYear'] ?? ''; ?>">
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" id="filterButton" class="btn btn-success">Filter</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="body">
    <h4 style="text-align: center">Total Income and Expenses</h4>
    <div class="chart-container">
        <canvas id="totalIncomeExpensesBarChart"></canvas>
    </div><br>
    <h4 style="text-align: center">Stacked bar for Income and Expenses</h4>
    <div class="chart-container">
        <canvas id="stackedIncomeExpensesBarChart"></canvas>
    </div><br>
    <h4 style="text-align: center">Income Pie Chart - March</h4>
    <div class="chart-container">
        <canvas id="incomePieChartMar"></canvas>
    </div><br>
    <h4 style="text-align: center">Expenses Pie Chart - March</h4>
    <div class="chart-container">
        <canvas id="expensesPieChartMar"></canvas>
    </div><br>
    <h4 style="text-align: center">Income Pie Chart - April</h4>
    <div class="chart-container">
        <canvas id="incomePieChartApr"></canvas>
    </div><br>
    <h4 style="text-align: center">Expenses Pie Chart - April</h4>
    <div class="chart-container">
        <canvas id="expensesPieChartApr"></canvas>
    </div><br>
    <h4 style="text-align: center">Income Pie Chart - May</h4>
    <div class="chart-container">
        <canvas id="incomePieChartMay"></canvas>
    </div><br>
    <h4 style="text-align: center">Expenses Pie Chart - May</h4>
    <div class="chart-container">
        <canvas id="expensesPieChartMay"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var ctxTotalBar = document.getElementById('totalIncomeExpensesBarChart').getContext('2d');
        var ctxStackedBar = document.getElementById('stackedIncomeExpensesBarChart').getContext('2d');
        var ctxIncomePieMar = document.getElementById('incomePieChartMar').getContext('2d');
        var ctxExpensesPieMar = document.getElementById('expensesPieChartMar').getContext('2d');
        var ctxIncomePieApr = document.getElementById('incomePieChartApr').getContext('2d');
        var ctxExpensesPieApr = document.getElementById('expensesPieChartApr').getContext('2d');
        var ctxIncomePieMay = document.getElementById('incomePieChartMay').getContext('2d');
        var ctxExpensesPieMay = document.getElementById('expensesPieChartMay').getContext('2d');

        // Assuming data fetching from backend via AJAX
        fetchFinancialData().then(data => {
            displayTotalIncomeExpensesBarChart(ctxTotalBar, data.total_data);
            displayStackedIncomeExpensesBarChart(ctxStackedBar, data.stack_data);
            displayPieChart(ctxIncomePieMar, data.pie_data.mar_data.income, 'Income Categories - March');
            displayPieChart(ctxExpensesPieMar, data.pie_data.mar_data.expenses, 'Expense Categories - March');
            displayPieChart(ctxIncomePieApr, data.pie_data.apr_data.income, 'Income Categories - April');
            displayPieChart(ctxExpensesPieApr, data.pie_data.apr_data.expenses, 'Expense Categories - April');
            displayPieChart(ctxIncomePieMay, data.pie_data.may_data.income, 'Income Categories - May');
            displayPieChart(ctxExpensesPieMay, data.pie_data.may_data.expenses, 'Expense Categories - May');
        });

        async function fetchFinancialData() {
            return {
                total_data: {
                    income: {
                        '2024-03': 212649,
                        '2024-04': 297066.41,
                        '2024-05': 496920.7,
                        //total: 1006636.11
                    },
                    expenses: {
                        '2024-03': 673083.05,
                        '2024-04': 539574.85,
                        '2024-05': 802577.18,
                        //total: 2015235.08
                    }
                },
                stack_data: {
                    income: [
                        { ledger_name: 'THIRUPANI - SANNATHI', total_amount: 297330.6 },
                        { ledger_name: 'ARCHANAI COLLECTION', total_amount: 38734 },
                        { ledger_name: 'RELIGIOUS ACTIVITIES (ANNATHANAM)', total_amount: 29415 },
                        { ledger_name: 'INTEREST ON FIXED DEPOSITS - CIMB FD', total_amount: 25279.41 },
                        { ledger_name: 'UBAYAM FEE', total_amount: 7347 }, // Note: Duplicate entry combined in original data
                        { ledger_name: 'PALLAM', total_amount: 8463 },
                        { ledger_name: 'YANTHIRA POOJA', total_amount: 32040 },
                        { ledger_name: 'YAGAM FOR KUMBABISHEGAM', total_amount: 131100 },
                        { ledger_name: 'MANDALABISHEGAM', total_amount: 15002.01 },
                        { ledger_name: 'KUMBABISHEGAM ANNATHANAM', total_amount: 89297.09 }
                    ],
                    expenses: [
                        { ledger_name: 'THIRUPANI CIVIL WORK', total_amount: 237667.45 },
                        { ledger_name: 'THIRUPANI KUMBABISHEGAM EXP', total_amount: 233741.86 },
                        { ledger_name: 'THIRUPANI GRANITE WORK', total_amount: 72572.29 },
                        { ledger_name: 'THIRUPANI ELECTRICAL WORK', total_amount: 113517.1 },
                        { ledger_name: 'THIRUPANI STAPHATHY WORK EXP', total_amount: 202369.5 },
                        { ledger_name: 'SALARIES', total_amount: 69744 },
                        { ledger_name: 'SECURITY EXPENSES', total_amount: 20534.84 },
                        { ledger_name: 'REPAIR & MAINTENANCE - TEMPLE', total_amount: 41157.1 },
                        { ledger_name: 'CREMATORIUM-ELE', total_amount: 1487 }, // Added as part of the top expenses, lower amounts for demonstration
                        { ledger_name: 'VISA & PERMIT', total_amount: 74180 } // Note: Includes highest relevant amounts
                    ]
                },
                pie_data: {
                    mar_data: {
                        income: [
                            //{ group_name: 'THIRUPANI', total_amount: 490285 },
                            { group_name: 'FLOWER SHOP RENTAL', total_amount: 62500 },
                            { group_name: 'SHOP RENTAL', total_amount: 62200 },
                            { group_name: 'ARCHANAI', total_amount: 37598 },
                            { group_name: 'FESTIVALS & UBAYAMS', total_amount: 40265 },
                            { group_name: 'INTEREST ON FIXED DEPOSITS', total_amount: 3452.29 },
                            { group_name: 'INCOME', total_amount: 7757 },
                            { group_name: 'GIFT & DONATIONS', total_amount: 865.5 }
                        ],
                        expenses: [
                            //{ group_name: 'THIRUPANI EXPENSES', total_amount: 646375.41 },
                            { group_name: 'SALARY', total_amount: 48209.8 },
                            { group_name: 'CREMATORIUM', total_amount: 28459 },
                            { group_name: 'FESTIVAL - EXPENSE', total_amount: 19238.5 },
                            { group_name: 'Expenses', total_amount: 90064.02 },
                            { group_name: 'ARCHANAI - EXPENSE', total_amount: 9266.3 },
                            { group_name: 'ELECTRICITY', total_amount: 2894.55 },
                            { group_name: 'DONATION', total_amount: 5400 },
                            { group_name: 'WATER CHARGES', total_amount: 768 }
                        ]
                    },
                    apr_data: {
                        income: [
                            //{ group_name: 'THIRUPANI', total_amount: 170458 },
                            { group_name: 'FLOWER SHOP RENTAL', total_amount: 35000 },
                            { group_name: 'SHOP RENTAL', total_amount: 24000 },
                            { group_name: 'ARCHANAI', total_amount: 21010 },
                            { group_name: 'FESTIVALS & UBAYAMS', total_amount: 20193 },
                            { group_name: 'INTEREST ON FIXED DEPOSITS', total_amount: 25279.41 },
                            { group_name: 'INCOME', total_amount: 639 },
                            { group_name: 'GIFT & DONATIONS', total_amount: 247 },
                            { group_name: 'Revenue', total_amount: 240 }
                        ],
                        expenses: [
                            //{ group_name: 'THIRUPANI EXPENSES', total_amount: 439915.14 },
                            { group_name: 'SALARY', total_amount: 5432.9 },
                            { group_name: 'CREMATORIUM', total_amount: 18909 },
                            { group_name: 'FESTIVAL - EXPENSE', total_amount: 5286.7 },
                            { group_name: 'others', total_amount: 61698.61 },
                            { group_name: 'ARCHANAI - EXPENSE', total_amount: 4955.5 },
                            { group_name: 'ARMD EDUCATION FUND', total_amount: 2000 },
                            { group_name: 'DONATION', total_amount: 500 },
                            { group_name: 'WATER CHARGES', total_amount: 877 }
                        ]
                    },
                    may_data: {
                        income: [
                            //{ group_name: 'THIRUPANI', total_amount: 424355.7 },
                            { group_name: 'FLOWER SHOP RENTAL', total_amount: 17500 },
                            { group_name: 'SHOP RENTAL', total_amount: 16500 },
                            { group_name: 'ARCHANAI', total_amount: 11047 },
                            { group_name: 'FESTIVALS & UBAYAMS', total_amount: 25729 },
                            { group_name: 'INTEREST ON FIXED DEPOSITS', total_amount: 25279.41 },
                            { group_name: 'INCOME', total_amount: 55 },
                            { group_name: 'GIFT & DONATIONS', total_amount: 232 },
                            { group_name: 'others', total_amount: 1502 }
                        ],
                        expenses: [
                            //{ group_name: 'THIRUPANI EXPENSES', total_amount: 622328.01 },
                            { group_name: 'SALARY', total_amount: 50994.9 },
                            { group_name: 'CREMATORIUM', total_amount: 13842.4 },
                            { group_name: 'FESTIVAL - EXPENSE', total_amount: 8155.6 },
                            { group_name: 'Others', total_amount: 89146.96 },
                            { group_name: 'ARCHANAI - EXPENSE', total_amount: 6276.8 },
                            { group_name: 'ELECTRICITY', total_amount: 6875.86 },
                            { group_name: 'DONATION', total_amount: 2730 },
                            { group_name: 'WATER CHARGES', total_amount: 1226.65 }
                        ]
                    }
                }
            };
        }

        function displayTotalIncomeExpensesBarChart(ctx, data) {
            var months = Object.keys(data.income);
            var incomeValues = Object.values(data.income);
            var expensesValues = Object.values(data.expenses);

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: months,
                    datasets: [
                        {
                            label: 'Income',
                            backgroundColor: 'rgba(75, 192, 192, 0.7)',
                            data: incomeValues
                        },
                        {
                            label: 'Expenses',
                            backgroundColor: 'rgba(255, 99, 132, 0.7)',
                            data: expensesValues
                        }
                    ]
                },
                options: {
                    scales: {
                        x: { stacked: false }, // Set to false for separate bars
                        y: { stacked: false }
                    },
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        }

        function displayStackedIncomeExpensesBarChart(ctx, data) {
            // Extracting ledger names and amounts for Income
            let incomeLabels = data.income.map(item => item.ledger_name);
            let incomeValues = data.income.map(item => item.total_amount);

            // Extracting ledger names and amounts for Expenses
            let expenseLabels = data.expenses.map(item => item.ledger_name);
            let expenseValues = data.expenses.map(item => item.total_amount);

            // This ensures that both income and expenses have the same labels (order and count)
            let allLabels = [...new Set([...incomeLabels, ...expenseLabels])];

            // Preparing datasets for the chart
            let incomeDataset = {
                label: 'Income',
                data: allLabels.map(label => {
                    let index = incomeLabels.indexOf(label);
                    return index !== -1 ? incomeValues[index] : 0;
                }),
                backgroundColor: 'rgba(75, 192, 192, 0.7)'
            };

            let expensesDataset = {
                label: 'Expenses',
                data: allLabels.map(label => {
                    let index = expenseLabels.indexOf(label);
                    return index !== -1 ? expenseValues[index] : 0;
                }),
                backgroundColor: 'rgba(255, 99, 132, 0.7)'
            };

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: allLabels,
                    datasets: [incomeDataset, expensesDataset]
                },
                options: {
                    scales: {
                        x: { stacked: true },
                        y: { stacked: true }
                    },
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        }

        function displayPieChart(ctx, data, title) {
    var labels = data.map(item => `${item.group_name} (${item.total_amount})`);
    var amounts = data.map(item => item.total_amount);

    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                label: title,
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#F7464A', '#46BFBD', '#FF9F40', '#FFCD56', '#4BC0C0'],
                data: amounts
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                datalabels: {
                    formatter: (value, ctx) => {
                        let sum = ctx.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                        let percentage = (value * 100 / sum).toFixed(2) + "%";
                        return `${value}\n(${percentage})`;
                    },
                    color: '#333', // Change this to a darker color
                    font: {
                        weight: 'bold' // Optionally make the font bold
                    }
                }
            }
        }
    });
}


    });
</script>
