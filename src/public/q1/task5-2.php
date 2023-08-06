<?php
require_once __DIR__ . '/../../vendor/autoload.php';

$spendings = new App\Spendings();
$spendingData = $spendings->fetchAllSpendings();

$totalSpendingsAmount = App\SpendingsCalculator::calculateTotalSpendings($spendingData);

echo "spendingsテーブルのamountカラムの合計:" . $totalSpendingsAmount;
?>