<?php

namespace App\Managers;

use App\Models\Loan;
use App\Models\User;
use App\Repositories\LoanPlanRepository;

class LoanManager
{
    /** @var LoanPlanRepository */
    private $loanPlanRepository;

    public function __construct()
    {
        $this->loanPlanRepository = new LoanPlanRepository();
    }

    /**
     * @param array $data
     * @param User $user
     * @return Loan
     *
     * @throws \Exception
     */
    public function create(array $data, User $user)
    {
        $loanPlan = $this->loanPlanRepository->find($data['loan_plan_id'] ?? null);

        if (!$loanPlan) {
            throw new \Exception('Loan plan is not found!');
        }

        $loan = new Loan($data);
        $loan->user_id = $user->id;
        $loan->loanPlan()->associate($loanPlan);
        $loan->due_date = now()->addMonths($loanPlan->months);

        $loan->save();

        return $loan;
    }
}
