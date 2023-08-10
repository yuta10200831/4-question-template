<?php
namespace App;
use PDO;

class Spendings
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = new PDO(
            'mysql:dbname=tq_quest;host=mysql',
            'root',
            'password'
        );
    }

    public function fetchAllSpendings()
    {
        $sql = "SELECT * FROM spendings";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function calculateTotalSpendings()
    {
        $spendings = $this->fetchAllSpendings();
        $totalSpendingsAmount = 0;
        foreach ($spendings as $spending)
        {
            $totalSpendingsAmount += $spending['amount'];
        }
        return $totalSpendingsAmount;
    }

    public function displaySpendingForMonth()
    {
    $spendings = $this->fetchAllSpendings();
    
    foreach($spendings as $spending)
    {
        $date = explode("-", $spending["accrual_date"]);
        $month = abs($date[1]);
        if ($month == 2) {
            $display[] = [
                "name" => $spending["name"],
                "amount" => $spending["amount"]
            ];
        }
    }
    return $display;
    }
}


?>
