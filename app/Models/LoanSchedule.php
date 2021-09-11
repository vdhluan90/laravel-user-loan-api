<?php

namespace App\Models;

use Eloquent;

class LoanSchedule extends Eloquent
{
    public $timestamps = true;
    public const UNPAID_STATUS = 'unpaid';
    public const PAID_STATUS = 'paid';

    protected $table = 'loan_schedules';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount',
        'status',
        'due_date',
    ];
}
