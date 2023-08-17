<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Incomes;

$incomes = new Incomes();
$monthlyIncomeAndExpenditure = $incomes->fetchMonthlyIncomeAndExpenditure();

foreach ($monthlyIncomeAndExpenditure as $data)
{
    $year = $data['year'];
    $month = str_pad($data['month'], 2, '0', STR_PAD_LEFT);
    $totalIncome = $data['total_income'];
    $totalExpenditure = $data['total_expenditure'];
    $difference = $totalIncome - $totalExpenditure;
    
    echo "{$year}年-{$month}月: 収入{$totalIncome}円 - 支出{$totalExpenditure}円 = 差額{$difference}円";
    echo "<br>";
}
?>