<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/
use Wiki\Domains\Customer\Models\Customer;

$faker = Faker\Factory::create('pt_BR');

$factory->define(Customer::class, function () use ($faker) {
    return [
        'nome' => $faker->name,
        'dt_nascimento' => $faker->date('Y-m-d', '-10 years'),
        'rg' => $faker->numerify('#######'),
        'cpf' => $faker->numerify('###.###.###-##'),
        'telefone' => $faker->numerify('(62) 9####-####')
    ];
});