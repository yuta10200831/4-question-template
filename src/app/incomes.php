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

    public function fetchAllIncomeSources()
    {
        $sql = "SELECT * FROM income_sources";
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

    public function displayIncomeAndSource()
    {
        $sql = "SELECT i.amount, s.name AS source_name 
        FROM incomes i
        INNER JOIN income_sources s ON i.incomes_source_id = s.id";
    
        $incomeSources = $this->fetchAllIncomeSources();
    
        $incomeAndSourceData = [];
        
        foreach ($incomeSources as $source)
        {
            $incomeAndSourceData[] = [
                "amount" => $source['amount'],
                "name" => $source['name']
            ];
        }

        return $incomeAndSourceData;
    }

    public function fetchMonthlyTotalAmounts()
    {
        $sql = "SELECT YEAR(accrual_date) as year, MONTH(accrual_date) as month, SUM(amount) as total_amount 
                FROM incomes 
                GROUP BY YEAR(accrual_date), MONTH(accrual_date) 
                ORDER BY year ASC, month ASC";
        
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    // 13.サブクエリを使って見よう。課題①
    public function fetchMonthlyIncomeAndExpenditure()
    {
        $sql = "SELECT income.year, income.month, income.total_income, spending.total_expenditure
        FROM (
            SELECT YEAR(accrual_date) as year, DATE_FORMAT(accrual_date, '%m') as month,
            SUM(amount) as total_income
            FROM incomes
            GROUP BY YEAR(accrual_date), DATE_FORMAT(accrual_date, '%m')
        ) AS income
        LEFT JOIN (
            SELECT YEAR(accrual_date) as year, DATE_FORMAT(accrual_date, '%m') as month,
            SUM(amount) as total_expenditure
            FROM spendings
            GROUP BY YEAR(accrual_date), DATE_FORMAT(accrual_date, '%m')
        ) AS spending ON income.year = spending.year AND income.month = spending.month
        ORDER BY income.year ASC, income.month ASC";
        
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
