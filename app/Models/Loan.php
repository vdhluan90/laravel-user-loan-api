<?php

namespace App\Models;

use Database\Factories\LoanFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Loan extends Eloquent
{
    use HasFactory;

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

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return LoanFactory::new();
    }
}
