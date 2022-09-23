<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNotaFiscalIdToItemMovimentos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_movimentos', function (Blueprint $table) {

            $table->unsignedInteger('nota_fiscal_id')->nullable();
            $table->foreign('nota_fiscal_id')->references('id')->on('nota_fiscals');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('item_movimentos', function (Blueprint $table) {

            $table->dropColumn('nota_fiscal_id');

        });
    }
}
