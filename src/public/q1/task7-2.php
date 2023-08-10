<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Spendings;

$spendings = new Spendings();
$sortByAmountAsc = $spendings->sortByAmountAsc();

foreach ($sortByAmountAsc as $spending)
{
  echo $spending["amount"];
  echo "<br/>";
}
?>