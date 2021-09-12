<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoanPlanTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('passport:install');
        $this->artisan('db:seed');
    }

    public function testGetAllPlans()
    {
        $response = $this->get('/api/loan-plans');
        $schedules = $response->json();

        $response->assertStatus(200);
        $this->assertNotEmpty($schedules['data']);
        $this->assertEquals(3, count($schedules['data']));
    }
}
