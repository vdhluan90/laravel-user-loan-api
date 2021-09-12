<?php

namespace Database\Factories;

use App\Models\Loan;
use Illuminate\Database\Eloquent\Factories\Factory;

class LoanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Loan::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'purpose' => 'buy house',
            'amount' => 1200000000,
            'loan_plan_id' => 1,
            'user_id' => 1,
            'due_date' => now()->addMonths(12),
            'status' => Loan::IN_PROGRESS_STATUS,
        ];
    }
}
