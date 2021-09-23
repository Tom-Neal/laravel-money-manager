<?php

namespace App\Services;

use App\Models\Expense;
use App\Helpers\DateHelper;

class ExpenseTaxYearService
{

    public function groupTogether(?int $year = NULL, int $yearCount = 5): array
    {
        // If year is provided, return expenses for that year,
        // otherwise, return previous years but number is optional
        $year = $year ?? DateHelper::getCurrentTaxYear();
        $expenseYears = array();
        for ($i = 0; $i < $yearCount; $i++) {
            $expenseYears["$year-" . ($year + 1)] =
                Expense::whereBetween('date_incurred', ["$year-04-06", ($year + 1) . "-04-05"])->get();
            $year--;
        }
        return $expenseYears;
    }

}
