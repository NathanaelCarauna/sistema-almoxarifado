<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigNotaFiscalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_nota_fiscals', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('fone');
            $table->string('estado');
            $table->string('cep');
            $table->string('endereco');
            $table->string('bairro');
            $table->string('municipio');
            $table->string('cnpj');
            $table->string('nome');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('config_nota_fiscals');
    }
}
