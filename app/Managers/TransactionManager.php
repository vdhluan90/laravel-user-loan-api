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
        $this->validateTransaction($transaction, $data);
        $transaction->save();

        return $transaction;
    }

    /**
     * @param Transaction $transaction
     * @param array $data
     * @throws \Exception
     */
    private function validateTransaction(Transaction $transaction, array $data): void
    {
        $loan = $this->loanRepository->findLoanById($data['loan_id'] ?? 0);

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

                if ($loanSchedule->status == LoanSchedule::PAID_STATUS) {
                    throw new \Exception('This schedule has been paid!');
                }

                if ($data['amount'] != $loanSchedule->amount) {
                    throw new \Exception("Invalid amount! The valid amount should be $loanSchedule->amount");
                }

                $loanSchedule->status = LoanSchedule::PAID_STATUS;
                $loanSchedule->save();

                break;
            case Transaction::SETTLEMENT_TYPE:
                $debtMoney = $this->loanScheduleRepository->getDebtAmount($data['loan_id']);
                $penaltyAmount = $debtMoney * $loan->penalty_rate / 100;
                $transaction->penalty_amount = $penaltyAmount;

                if (!isset($data['penalty_amount']) || $data['penalty_amount'] != $penaltyAmount) {
                    throw new \Exception("Invalid penalty amount! The valid penalty amount should be $penaltyAmount");
                }

                if ($data['amount'] != $debtMoney) {
                    throw new \Exception("Invalid amount! The valid amount should be $debtMoney");
                }

                break;
        }
    }
}
