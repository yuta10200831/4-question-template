<?php
require_once __DIR__ . '/../../vendor/autoload.php';

$spendings = new App\Spendings();
$totalSpendingsAmount = $spendings->calculateTotalSpendings();

echo "spendingsテーブルのamountカラムの合計:" . $totalSpendingsAmount;
?>