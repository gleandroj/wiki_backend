<?php

use Wiki\Support\Database\Seeder;

class DatabaseSeeder extends Seeder
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
        $this->call(CustomerModuloSeeder::class);
    }
}
