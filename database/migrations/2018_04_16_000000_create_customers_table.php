<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->date('dt_nascimento');
            $table->integer('rg')->unique();
            $table->string('cpf')->unique();
            $table->string('telefone');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(env('APP_ENV') === 'local' || env('APP_ENV') === 'testing') Schema::dropIfExists('customers');
    }
}
