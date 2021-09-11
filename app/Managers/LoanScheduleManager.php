<?php

namespace App\Managers;

use App\Models\Loan;
use App\Models\LoanSchedule;
use App\Repositories\LoanRepository;
use App\Repositories\LoanScheduleRepository;

class LoanScheduleManager
{
    /** @var LoanScheduleRepository */
    private $repository;

    /** @var LoanRepository */
    private $loanRepository;

    public function __construct()
    {
        $this->repository = new LoanScheduleRepository();
        $this->loanRepository = new LoanRepository();
    }

    /**
     * @param Loan $loan
     */
    public function bulkCreateSchedulesByLoan(Loan $loan)
    {
        $loanPlan = $loan->loanPlan;
        $schedules = [];

        for ($i = 1; $i <= $loanPlan->months; $i++) {
            $schedules[] = [
                'loan_id' => $loan->id,
                'amount' => ($loan->amount / $loanPlan->months) + ($loan->amount * $loanPlan->interest_percentage / 100),
                'due_date' => now()->addMonths($i),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        LoanSchedule::insert($schedules);
    }

    /**
     * @param int $loanId
     */
    public function setSchedulesPaid(int $loanId)
    {
        $this->repository->setSchedulesPaid($loanId);
    }

    /**
     * @param int $loanId
     */
    public function triggerLoanStatus(int $loanId)
    {
        $schedules = $this->repository->getUnpaidLoanSchedule($loanId);

        if (!empty($schedules->toArray())) {
            return;
        }

        $this->loanRepository->update($loanId, [
            'status' => Loan::COMPLETED_STATUS
        ]);
    }
}
