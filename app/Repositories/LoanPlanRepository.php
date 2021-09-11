<?php

namespace App\Repositories;

use App\Models\LoanPlan;

class LoanPlanRepository extends EloquentRepository
{
    public function getModel(): string
    {
        return LoanPlan::class;
    }
}
