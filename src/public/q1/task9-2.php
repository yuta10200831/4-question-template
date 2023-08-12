<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Spendings;

$spendings = new Spendings();
$monthlyDifferences = $spendings->calculateMonthlyDifferences();

echo "前月の支出と差分を一覧表示してください。" . "<br>";

foreach ($monthlyDifferences as $month => $difference)
{
  if ($previousMonth !== null)
  {
      echo $previousMonth . "月と" . $month . "月の差分: " . $difference . "円<br>";
  }

  $previousMonth = $month;
}
?>