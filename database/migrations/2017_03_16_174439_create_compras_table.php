<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('compras', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('user_id')->unsigned();
          $table->integer('produto_id')->unsigned();
          $table->integer('quantidade');
          $table->datetime('datacompra');
          $table->integer('situacao');
          $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP(0)'));
          $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP(0)'));
      });

      Schema::table('compras', function ($table) {
          $table->foreign('user_id')->references('id')->on('users');
          $table->foreign('produto_id')->references('id')->on('produtos');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('compras');
    }
}
