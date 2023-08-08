<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Spendings;

$spendings = new Spendings();
$spendings->displaySortedSpendings();

?>