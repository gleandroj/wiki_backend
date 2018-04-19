<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeederTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('public.seeders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('seeder');
            $table->string('environment');
            $table->timestamp('ran_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(env('APP_ENV') === 'local' || env('APP_ENV') === 'testing') Schema::dropIfExists('public.seeders');
    }

}
