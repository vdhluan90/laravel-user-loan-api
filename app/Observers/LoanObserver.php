<?php

namespace App\Observers;

use App\Managers\LoanScheduleManager;
use App\Models\Loan;

class LoanObserver
{
    /** @var LoanScheduleManager */
    private $loanScheduleManager;

    public function __construct()
    {
        $this->loanScheduleManager = new LoanScheduleManager();
    }

    /**
     * @param Loan $loan
     */
    public function created(Loan $loan): void
    {
        $this->loanScheduleManager->bulkCreateSchedulesByLoan($loan);
    }
}
