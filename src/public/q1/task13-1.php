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
    
    echo "{$year}-{$month}の「合計収入 - 合計支出」 : {$difference}";
    echo "<br>";
}
?>