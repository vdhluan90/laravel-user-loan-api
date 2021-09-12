<?php

namespace Tests\Unit\Http\Resources\LoanPlan;

use App\Http\Resources\LoanPlan\LoanPlansResource;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;

class LoanPlanResourcesTest extends TestCase
{
    public function testLoanPlanResourceFormatter()
    {
        $expectedResult = json_decode('[{"id":1,"description":"1 year","months":12,"interest_percentage":0.65,"penalty_rate":3,"created_at":"2021-09-12T05:50:36.000000Z","updated_at":"2021-09-12T05:50:36.000000Z"},{"id":2,"description":"2 years","months":24,"interest_percentage":0.7,"penalty_rate":2,"created_at":"2021-09-12T05:50:36.000000Z","updated_at":"2021-09-12T05:50:36.000000Z"},{"id":3,"description":"3 years","months":36,"interest_percentage":0.75,"penalty_rate":2,"created_at":"2021-09-12T05:50:36.000000Z","updated_at":"2021-09-12T05:50:36.000000Z"}]');

        $loanPlanResource = new LoanPlansResource(new Collection($expectedResult));
        $actualResult = $loanPlanResource->toArray(new Request());

        $this->assertNotEmpty($actualResult);
        $this->assertSame(json_encode($expectedResult), json_encode($actualResult['data']));
    }
}
