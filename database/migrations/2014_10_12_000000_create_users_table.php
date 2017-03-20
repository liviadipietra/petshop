<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->string('email')->unique();
            $table->string('senha');
            $table->integer('tipo');
            $table->rememberToken();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP(0)'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP(0)'));
            //$table->timestamps();
        });

        DB::table('users')->insert(
            array(
              'nome' => 'admin',
              'email' => 'admin@admin.com',
              'senha' => '$2y$10$qpBEl5YzhmJUgh5zVrSoQO/ofSMF85UJfflfjvhISOWas4V.ek126', //admin1
              'tipo' => 2,
              'remember_token' => ''
            )
        );

        DB::table('users')->insert(
            array(
              'nome' => 'gui',
              'email' => 'gui@gmail.com',
              'senha' => '$2y$10$ngR7mjFBNOuvciSo1uBSW.KfR2CNJxmvHb.GtytCGe/abSuzfWGqy', //123456
              'tipo' => 1,
              'remember_token' => ''
            )
        );

        DB::table('users')->insert(
            array(
              'nome' => 'operador',
              'email' => 'operador@gmail.com',
              'senha' => '$2y$10$uOOelKISaaBjkPUUANwReO0ZqzxZoJ2Q56k9XaDrJ5oPN7O2n8WtG', //operador
              'tipo' => 3,
              'remember_token' => ''
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
