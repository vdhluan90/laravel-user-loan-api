<?php

namespace App\Observers;

use App\Managers\LoanScheduleManager;
use App\Models\Loan;
use App\Models\Transaction;

class TransactionObserver
{
    /** @var LoanScheduleManager */
    private $loanScheduleManager;

    public function __construct()
    {
        $this->loanScheduleManager = new LoanScheduleManager();
    }

    /**
     * @param Transaction $transaction
     */
    public function created(Transaction $transaction): void
    {
        if ($transaction->type === Transaction::SETTLEMENT_TYPE) {
            $this->loanScheduleManager->setSchedulesPaid($transaction->loan_id);
        }

        $this->loanScheduleManager->triggerLoanStatus($transaction->loan_id);
    }
}
