<?php

namespace App\Repositories;

use App\Models\LoanSchedule;

class LoanScheduleRepository extends EloquentRepository
{
    public function getModel(): string
    {
        return LoanSchedule::class;
    }

    /**
     * @param int $loanId
     * @return float
     */
    public function getDebtAmount(int $loanId): float
    {
        return $this->model::where('loan_id','=', $loanId)
            ->where('status', '=', LoanSchedule::UNPAID_STATUS)
            ->sum('amount');
    }

    /**
     * @param int $loanId
     * @return float
     */
    public function setSchedulesPaid(int $loanId): float
    {
        return $this->model::where('loan_id','=', $loanId)
            ->update([
                'status' => LoanSchedule::PAID_STATUS
            ]);
    }

    /**
     * @param int $loanId
     * @return mixed
     */
    public function getUnpaidLoanSchedule(int $loanId)
    {
        return $this->model::where('loan_id','=', $loanId)
            ->where('status', '=', LoanSchedule::UNPAID_STATUS)
            ->get();
    }
}
