<?php

namespace Tests\Feature;

use Tests\TestCase;
use Wiki\Domains\Customer\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    public function setUpSeeder(){
        factory(Customer::class, 10)->create();
    }

    /**
     * Teste get customers.
     *
     * @return void
     */
    public function testGetCustomers()
    {
        $this->setUpSeeder();
        $response = $this->get('/api/customers');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => [
                'id',
                'nome',
                'dt_nascimento',
                'rg',
                'cpf',
                'telefone',
                'created_at',
                'updated_at',
                'deleted_at'
            ]
        ]);
    }

    /**
     * Teste get customer by id.
     *
     * @return void
     */
    public function testGetCustomerById()
    {
        $this->setUpSeeder();
        $customerID = Customer::first()->id;
        $response = $this->get("/api/customers/${customerID}");
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id',
            'nome',
            'dt_nascimento',
            'rg',
            'cpf',
            'telefone',
            'created_at',
            'updated_at',
            'deleted_at'
        ]);
    }


    /**
     * Teste create customer.
     *
     * @return void
     */
    public function testCreateCustomer()
    {
        $data = factory(Customer::class)->make()->toArray();
        $response = $this->post("/api/customers", $data);
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'id',
            'nome',
            'dt_nascimento',
            'rg',
            'cpf',
            'telefone',
            'created_at',
            'updated_at',
            'deleted_at'
        ]);
    }
}
