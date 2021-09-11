<?php

namespace App\Repositories;

use App\Models\Loan;

class LoanRepository extends EloquentRepository
{
    public function getModel(): string
    {
        return Loan::class;
    }
}
