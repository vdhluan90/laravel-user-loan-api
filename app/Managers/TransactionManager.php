<?php

namespace App\Managers;

use App\Models\Loan;
use App\Models\LoanSchedule;
use App\Models\Transaction;
use App\Models\User;
use App\Repositories\LoanRepository;
use App\Repositories\LoanScheduleRepository;

class TransactionManager
{
    /** @var LoanRepository */
    private $loanRepository;

    /** @var LoanScheduleRepository */
    private $loanScheduleRepository;

    public function __construct()
    {
        $this->loanRepository = new LoanRepository();
        $this->loanScheduleRepository = new LoanScheduleRepository();
    }

    /**
     * @param array $data
     * @param User $user
     * @return Transaction
     *
     * @throws \Exception
     */
    public function create(array $data, User $user)
    {
        $transaction = new Transaction($data);
        $transaction->user_id = $user->id;
        $this->validateTransaction($data);
        $transaction->save();

        return $transaction;
    }

    /**
     * @param array $data
     * @throws \Exception
     */
    private function validateTransaction(array $data): void
    {
        $loan = $this->loanRepository->find($data['loan_id'] ?? null);

        if (!$loan) {
            throw new \Exception('Loan is not found!');
        }

        if ($loan->status === Loan::COMPLETED_STATUS) {
            throw new \Exception('This loan has been paid!');
        }

        switch ($data['type']) {
            case Transaction::MONTHLY_TYPE:
                $loanSchedule = $this->loanScheduleRepository->find($data['loan_schedule_id'] ?? null);

                if (!$loanSchedule) {
                    throw new \Exception('Loan schedule is not found!');
                }

                if ($data['amount'] != $loanSchedule->amount) {
                    throw new \Exception("Invalid amount! The valid amount should be $loanSchedule->amount");
                }

                $loanSchedule->status = LoanSchedule::PAID_STATUS;
                $loanSchedule->save();

                break;
            case Transaction::SETTLEMENT_TYPE:
                $debtMoney = $this->loanScheduleRepository->getDebtAmount($data['loan_id']);

                if ($data['penalty_amount'] != $loan->penalty_amount) {
                    throw new \Exception("Invalid penalty amount! The valid penalty amount should be $loan->penalty_amount");
                }

                if ($data['amount'] != $debtMoney) {
                    throw new \Exception("Invalid amount! The valid amount should be $debtMoney");
                }

                break;
        }
    }
}
