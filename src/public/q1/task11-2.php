<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Spendings;

$spendings = new Spendings();
$spendingsAndCategories = $spendings->fetchSpendingsAndCategories();

foreach ($spendingsAndCategories as $data)
{
    $amount = $data['amount'];
    $categoryName = $data['name'];
    
    echo "{$categoryName} :  {$amount}";
    echo "<br>";
}
?>