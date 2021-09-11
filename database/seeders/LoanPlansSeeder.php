<?php

namespace Database\Seeders;

use App\Models\LoanPlan;
use Illuminate\Database\Seeder;

class LoanPlansSeeder extends Seeder
{
    /**
     * Run the database seed.
     */
    public function run()
    {
        LoanPlan::create([
            'description' => '1 year',
            'months' => 12,
            'interest_percentage' => 0.65,
            'penalty_rate' => 3,
        ]);


        LoanPlan::create([
            'description' => '2 years',
            'months' => 24,
            'interest_percentage' => 0.7,
            'penalty_rate' => 2,
        ]);


        LoanPlan::create([
            'description' => '3 years',
            'months' => 36,
            'interest_percentage' => 0.75,
            'penalty_rate' => 2,
        ]);
    }
}
