<?php

namespace App\Http\Controllers;

use App\Http\Resources\LoanPlan\LoanPlansResource;
use App\Models\LoanPlan;

class LoanPlanController extends ApiController
{
    /**
     * @return mixed
     */
    public function index(): LoanPlansResource
    {
        return new LoanPlansResource(LoanPlan::all());
    }
}
