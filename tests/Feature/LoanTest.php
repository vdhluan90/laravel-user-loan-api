<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class LoanTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    private $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('passport:install');
        $this->artisan('db:seed');
        $this->user = User::factory()->create();
    }

    public function testCreateLoanSuccessfully()
    {
        $this->actingAs($this->user, 'api');

        $data = [
            'purpose' => 'buy house',
            'amount' => 1200000000,
            'loan_plan_id' => 1,
        ];

        $response = $this->json('POST', '/api/loans', $data);
        $response->assertStatus(Response::HTTP_CREATED);
    }

    /**
     * @param array $submittedData
     * @param int $statusCode
     *
     * @dataProvider providerInvalidLoanData
     */
    public function testCreateLoanFailedWithInvalidData(array $submittedData, int $statusCode)
    {
        $this->actingAs($this->user, 'api');

        $response = $this->json('POST', '/api/loans', $submittedData);
        $response->assertStatus($statusCode);
    }

    public function testUnauthorizedUserCreateLoan()
    {
        $submittedData = [
            'purpose' => 'buy house',
            'amount' => 1200000000,
            'loan_plan_id' => 1,
        ];

        $response = $this->json('POST', '/api/loans', $submittedData);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @return array
     */
    public function providerInvalidLoanData(): array
    {
        return [
            [
                [],
                Response::HTTP_UNPROCESSABLE_ENTITY,
            ],
            [
                [
                    'purpose' => 'test',
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY,
            ],
            [
                [
                    'purpose' => 'invalid email',
                    'amount' => 1200000000,
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY,
            ],
            [
                [
                    'purpose' => 'buy house',
                    'loan_plan_id' => 1,
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY,
            ],
        ];
    }
}
