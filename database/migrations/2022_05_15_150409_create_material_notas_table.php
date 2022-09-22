<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialNotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_notas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedInteger('material_id')->index();
            $table->foreign('material_id')->references('id')->on('materials');

            $table->unsignedInteger('nota_fiscal_id')->index();
            $table->foreign('nota_fiscal_id')->references('id')->on('nota_fiscals');

            $table->string('quantidade_total');
            $table->string('quantidade_atual');
            $table->boolean('status');
            $table->float('valor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('material_notas');
    }
}
