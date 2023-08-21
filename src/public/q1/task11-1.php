<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Incomes;

$incomes = new Incomes();
$incomeAndSourceData = $incomes->displayIncomeAndSource();

foreach ($incomeAndSourceData as $data)
{
  echo "{$data['name']}" . ":" . "{$data['amount']}";
  echo "<br>";
}
?>