<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Spendings;

$spendings = new Spendings();
$spendingsAll = $spendings->fetchAllSpendings();

foreach ($spendingsAll as $spending)
{
    echo $spending["name"] . ": " . $spending["amount"] . "<br>";
}
?>