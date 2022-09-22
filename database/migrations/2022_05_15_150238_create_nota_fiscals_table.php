<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotaFiscalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota_fiscals', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('numero');
            $table->string('serie');
            $table->date('data_emissao');
            $table->string('natureza_operacao');
            $table->string('valor_nota');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nota_fiscals');
    }
}
