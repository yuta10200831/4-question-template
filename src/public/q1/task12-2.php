<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Spendings;

$spendings = new Spendings();
$monthlyTotalAmounts = $spendings->fetchMonthlyTotalAmounts();

foreach ($monthlyTotalAmounts as $data)
{
    $year = $data['year'];
    $month = str_pad($data['month'], 2, '0', STR_PAD_LEFT);
    $totalAmount = $data['total_amount'];
    
    echo "{$year}-{$month}の合計収入: {$totalAmount}";
    echo "<br>";
}
?>