<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AccountTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_account_index()
    {
        $user = User::factory([
            'name' => '山田太郎',
            'email' => 'test@example.com',
            'password' => bcrypt('pass1234'),
        ])->create();


        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
