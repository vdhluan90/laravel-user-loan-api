<?php

namespace Tests\Feature;

use App\Models\Loan;
use App\Models\LoanSchedule;
use App\Models\Transaction;
use App\Models\User;
use App\Repositories\LoanScheduleRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    private $user;

    private $loan;

    private $schedule;

    private $loanScheduleRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('passport:install');
        $this->artisan('db:seed');
        $this->user = User::factory()->create();
        $this->loan = Loan::factory()->create();
        $this->schedule = LoanSchedule::where('loan_id', '=', $this->loan->id)
            ->where('status', '=', LoanSchedule::UNPAID_STATUS)
            ->first();
        $this->loanScheduleRepository = new LoanScheduleRepository();
    }

    public function testCreateNewMonthlyTransactionSuccessfully()
    {
        $this->actingAs($this->user, 'api');

        $data = [
            'note' => 'buy house',
            'amount' => $this->schedule->amount,
            'loan_schedule_id' => $this->schedule->id,
            'loan_id' => 1,
            'type' => Transaction::MONTHLY_TYPE,
        ];

        $response = $this->json('POST', '/api/transactions', $data);
        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function testCreateNewSettlementTransactionSuccessfully()
    {
        $debtMoney = $this->loanScheduleRepository->getDebtAmount($this->loan->id);

        $this->actingAs($this->user, 'api');

        $data = [
            'note' => 'buy house',
            'amount' => $debtMoney,
            'penalty_amount' => 38808000,
            'loan_schedule_id' => $this->schedule->id,
            'loan_id' => 1,
            'type' => Transaction::SETTLEMENT_TYPE,
        ];

        $response = $this->json('POST', '/api/transactions', $data);
        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function testUnauthorizedUserCreateTransaction()
    {
        $debtMoney = $this->loanScheduleRepository->getDebtAmount($this->loan->id);

        $submittedData =  [
            'note' => 'buy house',
            'amount' => $this->schedule->amount,
            'loan_schedule_id' => $this->schedule->id,
            'loan_id' => 1,
            'type' => Transaction::MONTHLY_TYPE,
        ];

        $response = $this->json('POST', '/api/transactions', $submittedData);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @param array $submittedData
     * @param int $statusCode
     *
     * @dataProvider providerInvalidMonthlyTransactionData
     */
    public function testCreateNewMonthlyTransactionWithInvalidData(array $submittedData, int $statusCode)
    {
        $this->actingAs($this->user, 'api');

        $response = $this->json('POST', '/api/transactions', $submittedData);
        $response->assertStatus($statusCode);
    }

    /**
     * @return array
     */
    public function providerInvalidMonthlyTransactionData(): array
    {
        return [
            [
                [],
                Response::HTTP_UNPROCESSABLE_ENTITY,
            ],
            [
                [
                    'note' => 'test',
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY,
            ],
            [
                [
                    'note' => 'invalid email',
                    'amount' => 0,
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY,
            ],
            [
                [
                    'note' => 'invalid email',
                    'amount' => 0,
                    'loan_schedule_id' => 1,
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY,
            ],
            [
                [
                    'note' => 'invalid email',
                    'amount' => 0,
                    'loan_schedule_id' => 1,
                    'type' => 'monthly',
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY,
            ],
        ];
    }
}
