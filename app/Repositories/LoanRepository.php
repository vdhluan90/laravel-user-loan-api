<?php

namespace App\Repositories;

use App\Models\Loan;

class LoanRepository extends EloquentRepository
{
    public function getModel(): string
    {
        return Loan::class;
    }

    /**
     * @param int $loanId
     * @return mixed
     */
    public function findLoanById(int $loanId)
    {
        return $this->model->select('*')
            ->join('loan_plans', 'loan_plans.id', '=', 'loans.loan_plan_id', 'inner')
            ->where('loans.id', $loanId)
            ->first();
    }
}
