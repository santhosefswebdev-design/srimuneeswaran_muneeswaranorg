<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Planalysis extends BaseController
{
    function __construct(){
        parent:: __construct();
        helper('url');
		helper('common_helper');
        $this->model = new PermissionModel();
        if( ($this->session->get('log_id') ) == false && $this->session->get('role') != 1){
            $data['dn_msg'] = 'Please Login';
            header('Location: '.base_url().'/login');
            exit;
		}
    }

    public function index()
    {
        $fromMonthYear = $this->request->getVar('fromMonthYear') ?? '2024-03';
        $toMonthYear = $this->request->getVar('toMonthYear') ?? '2024-05';

        // Call the total_chart function
        $response = $this->total_chart();

        // Extract the JSON data from the response
        $totalData = json_decode($response->getBody(), true);

        $sep_total = [
            'income' => [],
            'expenses' => []
        ];

        // Filter income data
        if (isset($totalData['income']) && is_array($totalData['income'])) {
            foreach ($totalData['income'] as $month => $income) {
                if ($month >= $fromMonthYear && $month <= $toMonthYear) {
                    $sep_total['income'][$month] = $income;
                }
            }
        }

        // Filter expenses data
        if (isset($totalData['expenses']) && is_array($totalData['expenses'])) {
            foreach ($totalData['expenses'] as $month => $expense) {
                if ($month >= $fromMonthYear && $month <= $toMonthYear) {
                    $sep_total['expenses'][$month] = $expense;
                }
            }
        }

        // Prepare data for the view
        $data['fromMonthYear'] = $fromMonthYear;
        $data['toMonthYear'] = $toMonthYear;
        $data['total_data'] = $totalData;
        $data['sep_total'] = $sep_total;

        echo "<pre>";
        print_r($data);
        echo "</pre>";
        exit;

        // echo view('template/header');
        // echo view('template/sidebar');
        // echo view('analysis/pl_report', $data);
        // echo view('template/footer');
    }


    public function index_test()
    {
        $fromMonthYear = $this->request->getVar('fromMonthYear') ?? '2024-03';
        $toMonthYear = $this->request->getVar('toMonthYear') ?? '2024-05';

        // $fromMonthYear = '2024-05';
        // $toMonthYear = '2024-05';

        $dataFromEntries = get_data_from_entries($fromMonthYear, $toMonthYear);
        $groupData = get_all_groups();
        $ledgerData = get_all_ledgers();

        $entryIds = array_column($dataFromEntries, 'id');
        $entryItems = get_entry_items_by_entry_ids($entryIds);

        $incomeGroupIds = [26, 29, 62, 66, 77, 79, 80, 81, 82, 83, 85, 86, 87];
        $expenseGroupIds = [30, 64, 67, 65, 88, 90, 91, 92, 93, 94, 96, 97, 98, 100];

        // Initialize monthly and total amounts arrays
        $totalData = [
            'income' => [],
            'expenses' => []
        ];

        $stackData = [
            'income' => [],
            'expenses' => []
        ];

        $pieData = [
            'income' => [],
            'expenses' => []
        ];

        $months = $this->total_chart();

        // Initialize array to keep track of monthly amounts
        $months = [];
        $currentMonth = strtotime($fromMonthYear);
        $endMonth = strtotime($toMonthYear);

        while ($currentMonth <= $endMonth) {
            $monthKey = date('Y-m', $currentMonth);
            $months[$monthKey] = [
                'income' => 0,
                'expenses' => 0
            ];
            $currentMonth = strtotime('+1 month', $currentMonth);
        }

        // Organize ledgers within their respective groups and sum the amounts from entry items
        foreach ($groupData as &$group) {
            $group['ledgers'] = array_filter($ledgerData, function ($ledger) use ($group) {
                return $ledger['group_id'] == $group['id'];
            });

            // Initialize group total amount
            $group['total_amount'] = 0;

            foreach ($group['ledgers'] as &$ledger) {
                $ledger['entries'] = array_filter($entryItems, function ($item) use ($ledger) {
                    return $item['ledger_id'] == $ledger['id'];
                });

                // Initialize an array to group entries by narration
                $groupedEntries = [];

                // Include narration and entry_id in ledger entries and group them by narration
                foreach ($ledger['entries'] as $key => &$entry) {
                    foreach ($dataFromEntries as $dataEntry) {
                        if ($entry['entry_id'] == $dataEntry['id']) {
                            $narration = $dataEntry['narration'];
                            $entryDate = date('Y-m', strtotime($dataEntry['date']));

                            if (!isset($groupedEntries[$narration])) {
                                $groupedEntries[$narration] = [
                                    'narration' => $narration,
                                    'total_amount' => 0,
                                    'entry_ids' => [],
                                ];
                            }
                            $groupedEntries[$narration]['total_amount'] += $entry['amount'];
                            $groupedEntries[$narration]['entry_ids'][] = $entry['entry_id'];

                            // Add to monthly amounts
                            if (isset($months[$entryDate])) {
                                if (in_array($group['id'], $incomeGroupIds)) {
                                    $months[$entryDate]['income'] += $entry['amount'];
                                } elseif (in_array($group['id'], $expenseGroupIds)) {
                                    $months[$entryDate]['expenses'] += $entry['amount'];
                                }
                            }

                            break;
                        }
                    }
                }

                // Replace ledger entries with grouped entries
                $ledger['entries'] = $groupedEntries;

                // Calculate total amount for each ledger
                $ledger['total_amount'] = array_sum(array_column($ledger['entries'], 'total_amount'));

                // Add ledger total to group total
                $group['total_amount'] += $ledger['total_amount'];
            }

            // Prepare stack data
            foreach ($group['ledgers'] as $ledger) {
                if ($ledger['total_amount'] > 0) {
                    if (in_array($group['id'], $incomeGroupIds)) {
                        $stackData['income'][] = [
                            'ledger_name' => $ledger['name'],
                            'total_amount' => $ledger['total_amount']
                        ];
                    } elseif (in_array($group['id'], $expenseGroupIds)) {
                        $stackData['expenses'][] = [
                            'ledger_name' => $ledger['name'],
                            'total_amount' => $ledger['total_amount']
                        ];
                    }
                }
            }

            // Prepare pie data
            if ($group['total_amount'] > 0) {
                if (in_array($group['id'], $incomeGroupIds)) {
                    $pieData['income'][] = [
                        'group_name' => $group['name'],
                        'total_amount' => $group['total_amount']
                    ];
                } elseif (in_array($group['id'], $expenseGroupIds)) {
                    $pieData['expenses'][] = [
                        'group_name' => $group['name'],
                        'total_amount' => $group['total_amount']
                    ];
                }
            }
        }

        // Calculate totals for income and expenses
        $totalData['income']['total'] = array_sum(array_column($months, 'income'));
        $totalData['expenses']['total'] = array_sum(array_column($months, 'expenses'));

        // Add totals to stack data
        $stackData['income']['total'] = array_sum(array_column($stackData['income'], 'total_amount'));
        $stackData['expenses']['total'] = array_sum(array_column($stackData['expenses'], 'total_amount'));

        // Prepare monthly amounts for the view
        foreach ($months as $month => $values) {
            $totalData['income'][$month] = $values['income'];
            $totalData['expenses'][$month] = $values['expenses'];
        }

        // Prepare data for the view
        $data['fromMonthYear'] = $fromMonthYear;
        $data['toMonthYear'] = $toMonthYear;
        //$data['entries'] = $dataFromEntries;
        //$data['groups'] = $groupData;
        $data['total_data'] = $totalData;
        $data['stack_data'] = $stackData;
        $data['pie_data'] = $pieData;
        $data['total_chart'] = $months;

        echo "<pre>";
        print_r($data);
        echo "</pre>";
        exit;

        // echo view('template/header');
        // echo view('template/sidebar');
        // echo view('analysis/pl_report', $data);
        // echo view('template/footer');
    }


    public function total_chart()
    {
        $fromMonthYear = '2024-01';
        $toMonthYear = date('Y-m'); 

        $monthlyTotals = $this->calculateMonthlyTotals($fromMonthYear, $toMonthYear);

        $totalData = [
            'income' => [],
            'expenses' => []
        ];

        foreach ($monthlyTotals as $month => $values) {
            $totalData['income'][$month] = $values['income'];
            $totalData['expenses'][$month] = $values['expenses'];
        }

        return $this->response->setContentType('application/json')
                              ->setJSON($totalData);
    }


    public function calculateMonthlyTotals($fromMonthYear, $toMonthYear)
    {
        $dataFromEntries = get_data_from_entries($fromMonthYear, $toMonthYear);
        $groupData = get_all_groups();
        $ledgerData = get_all_ledgers();

        $entryIds = array_column($dataFromEntries, 'id');
        $entryItems = get_entry_items_by_entry_ids($entryIds);

        $incomeGroupIds = [26, 29, 62, 66, 77, 79, 80, 81, 82, 83, 85, 86, 87];
        $expenseGroupIds = [30, 64, 67, 65, 88, 90, 91, 92, 93, 94, 96, 97, 98, 100];

        $monthlyTotals = [];

        $currentMonth = strtotime($fromMonthYear);
        $endMonth = strtotime($toMonthYear);

        while ($currentMonth <= $endMonth) {
            $monthKey = date('Y-m', $currentMonth);
            $monthlyTotals[$monthKey] = [
                'income' => 0,
                'expenses' => 0
            ];
            $currentMonth = strtotime('+1 month', $currentMonth);
        }

        foreach ($entryItems as $entry) {
            foreach ($dataFromEntries as $dataEntry) {
                if ($entry['entry_id'] == $dataEntry['id']) {
                    $entryDate = date('Y-m', strtotime($dataEntry['date']));

                    if (isset($monthlyTotals[$entryDate])) {
                        $groupId = null;
                        foreach ($ledgerData as $ledger) {
                            if ($ledger['id'] == $entry['ledger_id']) {
                                $groupId = $ledger['group_id'];
                                break;
                            }
                        }

                        if (in_array($groupId, $incomeGroupIds)) {
                            $monthlyTotals[$entryDate]['income'] += $entry['amount'];
                        } elseif (in_array($groupId, $expenseGroupIds)) {
                            $monthlyTotals[$entryDate]['expenses'] += $entry['amount'];
                        }
                    }
                }
            }
        }

        return $monthlyTotals;
    }




}
?>
