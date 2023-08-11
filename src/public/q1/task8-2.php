<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Spendings;

$spendings = new Spendings();
$totalSpendingsAmountForSeptember = $spendings->calculateTotalSpendingsForSeptember();

echo "９月の支出の合計:" . $totalSpendingsAmountForSeptember;

?>