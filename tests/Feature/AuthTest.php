<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class AuthTest extends TestCase
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

    public function testSignUpSuccessfully()
    {
        $this->assertGuest();

        $data = [
            'full_name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => '12345678@X',
            'password_confirmation' => '12345678@X',
        ];

        $response = $this->json('POST', '/api/auth/signup', $data);
        $response->assertStatus(Response::HTTP_CREATED);
    }

    /**
     * @param array $submittedData
     * @dataProvider providerInvalidSignUpData
     */
    public function testSignUpFailed(array $submittedData)
    {
        $this->assertGuest();

        $response = $this->json('POST', '/api/auth/signup', $submittedData);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testLoginSuccessfully()
    {
        $this->assertGuest();

        $data = [
            'email' => $this->user->email,
            'password' => '12345678@X',
        ];

        $response = $this->json('POST', '/api/auth/login', $data);
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * @param array $submittedData
     * @param int $statusCode
     * @dataProvider providerInvalidLoginData
     */
    public function testLoginFailed(array $submittedData, int $statusCode)
    {
        $this->assertGuest();

        $response = $this->json('POST', '/api/auth/login', $submittedData);
        $response->assertStatus($statusCode);
    }

    /**
     * @return array
     */
    public function providerInvalidSignUpData(): array
    {
        return [
            [
                [],
            ],
            [
                [
                    'full_name' => 'test user',
                ],
            ],
            [
                [
                    'email' => 'invalid email',
                ],
            ],
            [
                [
                    'full_name' => 'test user',
                    'email' => 'abc@test.com',
                    'password' => 'invalid password',
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function providerInvalidLoginData(): array
    {
        return [
            [
                [],
                Response::HTTP_UNPROCESSABLE_ENTITY,
            ],
            [
                [
                    'password' => 'test user',
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY,
            ],
            [
                [
                    'email' => 'invalid email',
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY,
            ],
            [
                [
                    'email' => 'test@user.com',
                    'password' => 'invalid password',
                ],
                Response::HTTP_UNAUTHORIZED,
            ],
        ];
    }
}
