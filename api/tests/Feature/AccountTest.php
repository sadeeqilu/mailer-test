<?php

namespace Tests\Feature;

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
    public function testExample()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function testCreateAccount()
    {
        $data = [
            'name' => 'Test account',
            'balance' => 20000
        ];

        $response = $this->json('POST','api/accounts/create-account',$data);
        $response->assertStatus(200);
        $response->assertJson(['message'=>'Account created successfully']);
        $response->assertJson(['data'=>$data]);

    }

    public function testGettingAccount()
    {
        $response = $this->json('get','api/accounts/1');

        $response->assertStatus(200);
    }
}
