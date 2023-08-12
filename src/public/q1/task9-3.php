<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Incomes;

$incomes = new Incomes();
$monthlyDifferences = $incomes->calculateMonthlyDifferences();

echo "前月の収入との差分を[1月〜6月の間のぶん]のみ一覧表示してください。" . "<br>";

foreach ($monthlyDifferences as $month => $difference)
{
  if ($previousMonth !== null)
  {
      echo $previousMonth . "月と" . $month . "月の差分: " . $difference . "円<br>";
  }

  $previousMonth = $month;
}
?>