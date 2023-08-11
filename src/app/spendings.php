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

    public function sortByAmountAsc()
    {
        $spendings = $this->fetchAllSpendings();
        $sort = [];
        foreach ($spendings as $spendingKey => $spending) {
            $sort[$spendingKey] = $spending["amount"];
        }
        array_multisort($sort, SORT_ASC, $spendings);
        return $spendings;
    }

    public function displaySortedSpendings()
    {
        $sortedSpendings = $this->sortByAmountAsc();

        foreach ($sortedSpendings as $spending) {
            echo $spending["amount"];
            echo "<br/>";
        }
    }

    public function calculateTotalSpendingsForSeptember()
    {
        $spendings = $this->fetchAllSpendings();
        $totalSpendingsAmount = 0;

        foreach ($spendings as $spending) {
            $date = explode('-', $spending["accrual_date"]);
            $month = abs($date[1]);
            $day = abs($date[2]);

            if ($month != 9) {
                continue;
            }

            $totalSpendingsAmount += $spending["amount"];

            if (strpos($day, "1") !== false) {
                $totalSpendingsAmount -= 2000;
            }
        }

        return $totalSpendingsAmount;
    }
}

?>