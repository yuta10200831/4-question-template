<?php
namespace App;
use PDO;

class Incomes
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

    public function fetchAllIncomes()
    {
        $sql = "SELECT * FROM incomes";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchAndSortByMonthTotal()
    {
        $sql = "SELECT YEAR(accrual_date) as year, MONTH(accrual_date) as month, SUM(amount) as total FROM incomes GROUP BY YEAR(accrual_date), MONTH(accrual_date) ORDER BY total DESC";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function calculateMonthlyDifferences()
    {
        $incomes = $this->fetchAllIncomes();
        $totalIncomesAmounts = [];
    
        foreach ($incomes as $income) {
            $date = explode('-', $income["accrual_date"]);
            $month = abs($date[1]);
            $totalIncomesAmounts[$month] += $income["amount"];
        }
    
        $differences = [];
        $previousAmount = $totalIncomesAmounts[1];
        
        for ($i = 1; $i <= 6; $i++) {
            $incomesDifference = abs($totalIncomesAmounts[$i] - $previousAmount);
            $differences[$i] = $incomesDifference;
            $previousAmount = $totalIncomesAmounts[$i];
        }
    
        return $differences;
    }
}
