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
            $incomesDifference = abs($totalIncomesAmounts[$i + 1] - $totalIncomesAmounts[$i]);
            $differences[$i] = $incomesDifference;
            $previousAmount = $totalIncomesAmounts[$i];
        }
        return $differences;
    }

    public function displayIncomeAndSource()
    {
        $sql = "SELECT i.amount, s.name
        FROM incomes i
        INNER JOIN income_sources s ON i.income_source_id = s.id";

        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        $incomeAndSourceData = $statement->fetchAll(PDO::FETCH_ASSOC);

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

    // 13.サブスクエリを使ってみよう。課題②
    public function calculateSideIncomeProfits()
    {
        $sql = "SELECT income.year, income.month, income.total_income, spending.total_expenditure
        FROM (
            SELECT YEAR(accrual_date) as year, DATE_FORMAT(accrual_date, '%m') as month,
            SUM(CASE WHEN income_source_id = 2 THEN amount ELSE 0 END) as total_income
            FROM incomes
            GROUP BY YEAR(accrual_date), DATE_FORMAT(accrual_date, '%m')
        ) AS income

        LEFT JOIN (
            SELECT YEAR(s.accrual_date) as year, DATE_FORMAT(s.accrual_date, '%m') as month,
            SUM(
                CASE 
                    WHEN c.name = '住宅費' THEN s.amount * 0.5
                    WHEN c.name = '水道光熱費' THEN s.amount * 0.5
                    WHEN c.name = '通信料' THEN s.amount * 0.8
                    WHEN c.name = '交際費' THEN s.amount * 1.0
                    ELSE 0
                END
            ) as total_expenditure
            FROM spendings s
            INNER JOIN categories c ON s.category_id = c.id
            GROUP BY YEAR(s.accrual_date), DATE_FORMAT(s.accrual_date, '%m')
        ) AS spending ON income.year = spending.year AND income.month = spending.month
        ORDER BY income.year ASC, income.month ASC";
    
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
}