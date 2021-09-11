<?php

namespace App\Models;

use Eloquent;

class LoanPlan extends Eloquent
{
    protected $table = 'loan_plans';

    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description',
        'months',
        'interest_percentage',
        'penalty_rate',
    ];

}
