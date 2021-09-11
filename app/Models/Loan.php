<?php

namespace App\Models;

use Eloquent;

class Loan extends Eloquent
{
    public $timestamps = true;
    public const IN_PROGRESS_STATUS = 'in_progress';
    public const COMPLETED_STATUS = 'completed';

    protected $table = 'loans';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'purpose',
        'amount',
        'due_date',
        'user_id',
        'loan_plan_id',
        'status',
    ];

    /**
     * Get the plan that owns the loan.
     */
    public function loanPlan()
    {
        return $this->belongsTo(LoanPlan::class);
    }

    /**
     * Get the schedules for the loan.
     */
    public function loanSchedules()
    {
        return $this->hasMany(LoanSchedule::class);
    }
}
