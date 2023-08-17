<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Spendings;

$spendings = new Spendings();
$monthlyTotals = $spendings->calculateMonthlySpendings();

echo "支出の高い順にsortして月ごとの支出の合計を一覧表示。ただし、支出日に5が含まれるときだけ100円引いてください。" . "<br>";

foreach ($monthlyTotals as $month => $total) {
  echo $month . "の支出の合計" . $total;
  echo "<br>";
}
?>