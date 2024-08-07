<?php

namespace Tests\Unit;

use App\Traits\RefreshDatabaseTransactionLess;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase, RefreshDatabaseTransactionLess {
        RefreshDatabaseTransactionless::refreshTestDatabase insteadof RefreshDatabase;
    }
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_register()
    {
        $data = [
            'name' => 'Didan',
            'email' => 'didanadha99@gmail.com',
            'password' => '12345678',
        ];

        $response = $this->postJson('/api/register', $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'name' => $data['name'],
            'email' => $data['email'],
        ]);
    }

    public function test_failed_login()
    {
        $data = [
            'email' => 'didanadha99@gmail.com',
            'password' => '12345679', // wrong password
        ];

        $response = $this->postJson('/api/login', $data);

        $response->assertStatus(401);
    }

    public function test_login()
    {
        $data = [
            'email' => 'didanadha99@gmail.com',
            'password' => '12345678',
        ];

        $response = $this->postJson('/api/login', $data);

        $response->assertStatus(200);
    }
}
