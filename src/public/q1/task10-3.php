<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Spendings;

$spendings = new Spendings();
$utilitySpendings2 = $spendings->displayUtilitySpendings2();

echo "「交際費」カテゴリーの支出を一覧表示してみてください。" . "<br>";

foreach ($utilitySpendings2 as $spending)
{
    echo $spending["accrual_date"] . "に支払った" . $spending["name"] . "料金: " . $spending["amount"];
    echo "<br />";
}

?>