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
}

class SpendingsCalculator
{
    public static function calculateTotalSpendings($spendings)
    {
        $totalSpendingsAmount = 0;
        foreach ($spendings as $spending)
        {
            $totalSpendingsAmount += $spending['amount'];
        }
        return $totalSpendingsAmount;
    }
}
?>
