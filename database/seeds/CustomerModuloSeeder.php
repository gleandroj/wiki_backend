<?php

use Wiki\Domains\Customer\Models\Customer;
use Wiki\Support\Database\Seeder;
use Illuminate\Support\Facades\App;

class CustomerModuloSeeder extends Seeder
{
    /**
     * Deve retornar os ambientes que o Seeder deve ser executado
     * @return mixed
     */
    public function getEnvironments()
    {
        return ['local','testing','production'];
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->moduloPermissionSeed();
        $this->testDataSeed();
    }

    public function testDataSeed()
    {
        factory(Customer::class, 10)->create();
    }

    public function moduloPermissionSeed()
    {
    }
}
