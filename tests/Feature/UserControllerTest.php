<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $dataProviderX = [
            [
                "parentAmount" => 200,
                "Currency" => "USD",
                "parentEmail" => "parent1@parent.eu",
                "statusCode" => 1,
                "registerationDate" => "2018-11-30",
                "parentIdentification" => "d3d29d70-1d25-11e3-8591-034165a3a613"
            ],
            [
                "parentAmount" => 150,
                "Currency" => "EUR",
                "parentEmail" => "parent2@parent.eu",
                "statusCode" => 2,
                "registerationDate" => "2019-01-15",
                "parentIdentification" => "d3d29d70-1d25-11e3-8591-034165a3a614"
            ]
        ];

        $dataProviderY = [
            [
                "balance" => 300,
                "currency" => "AED",
                "email" => "parent2@parent.eu",
                "status" => 100,
                "created_at" => "2018-12-22",
                "id" => "4fc2-a8d1"
            ],
            [
                "balance" => 500,
                "currency" => "USD",
                "email" => "parent4@parent.eu",
                "status" => 200,
                "created_at" => "2019-01-15",
                "id" => "5fc2-a8d2"
            ]
        ];

        file_put_contents(storage_path('app/DataProviderX.json'), json_encode($dataProviderX, JSON_PRETTY_PRINT));
        file_put_contents(storage_path('app/DataProviderY.json'), json_encode($dataProviderY, JSON_PRETTY_PRINT));
    }

    public function test_can_get_all_users()
    {
        $response = $this->getJson('/api/v1/users');

        $response->assertStatus(200);
        $response->assertJsonCount(4);
    }

    public function test_can_filter_users_by_provider()
    {
        $response = $this->getJson('/api/v1/users?provider=DataProviderX');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
    }

    public function test_can_filter_users_by_status_code()
    {
        $response = $this->getJson('/api/v1/users?statusCode=authorised');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
    }

    public function test_can_filter_users_by_balance_min()
    {
        $response = $this->getJson('/api/v1/users?balanceMin=300');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
    }

    public function test_can_filter_users_by_balance_max()
    {
        $response = $this->getJson('/api/v1/users?balanceMax=200');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
    }

    public function test_can_filter_users_by_currency()
    {
        $response = $this->getJson('/api/v1/users?currency=USD');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
    }

    public function test_can_paginate_users()
    {
        $response = $this->getJson('/api/v1/users?paginate=1&perPage=2&page=1');

        $response->assertStatus(200);
        $response->assertJsonStructure(['data', 'current_page', 'last_page', 'per_page', 'total']);
        $response->assertJsonCount(2, 'data');
    }
}
