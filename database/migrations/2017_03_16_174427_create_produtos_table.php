<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('produtos', function (Blueprint $table) {
          $table->increments('id');
          $table->string('nome');
          $table->double('preco', 15, 8);
          $table->binary('imagem');
          $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP(0)'));
          $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP(0)'));
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produtos');
    }
}
