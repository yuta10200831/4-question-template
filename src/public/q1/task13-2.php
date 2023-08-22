<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Incomes;

$incomes = new Incomes();
$calculateSideIncomeProfits = $incomes->calculateSideIncomeProfits();

foreach ($calculateSideIncomeProfits as $data)
{
    $year = $data['year'];
    $month = str_pad($data['month'], 2, '0', STR_PAD_LEFT);
    $profit = $data['total_income'] - $data['total_expenditure'];
    
    // 小数点第一位まで表示する
    $formattedProfit = number_format($profit, 1, '.', '');

    echo "{$year}-{$month}の「副業の利益」: {$formattedProfit}";
    echo "<br>";
}
?>