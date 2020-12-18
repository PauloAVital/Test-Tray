<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVenda extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('venda', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_vendedor')->unsigned();
            $table->foreign('id_vendedor')->references('id')->on('vendedor')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('id_produto')->unsigned();
            $table->foreign('id_produto')->references('id')->on('produto')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('qtd_prod');
            $table->decimal('total_venda', 4, 2);
            $table->dateTime('data_venda');
            $table->timestamps();
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('venda');
    }
}
