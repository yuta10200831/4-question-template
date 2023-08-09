<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Incomes;

$incomes = new Incomes();
$sortedIncomes = $incomes->fetchAndSortByMonthTotal();

echo "収入が高い順にsortして月ごとの収入の合計を一覧表示";
echo "<br>";
foreach ($sortedIncomes as $income) {
    echo $income["month"] . "月" . $income["total"] . "<br>";
}
?>
