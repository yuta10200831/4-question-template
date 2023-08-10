<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Spendings;

$spendings = new Spendings();
$displaySpendingForMonth = $spendings->displaySpendingForMonth();

echo "2月の支出";
echo "<br>";

foreach ($displaySpendingForMonth as $spending) {
    echo $spending["name"] . ": " . $spending["amount"] . "<br>";
}
?>