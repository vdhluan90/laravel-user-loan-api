<?php

namespace App\Models;

use Eloquent;

class Transaction extends Eloquent
{
    public $timestamps = true;
    public const MONTHLY_TYPE = 'monthly';
    public const SETTLEMENT_TYPE = 'settlement';

    protected $table = 'transactions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'note',
        'amount',
        'penalty_amount',
        'loan_id',
        'user_id',
        'type',
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
