<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCistellesLiniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cistellas_linias', function (Blueprint $table) {
            $table->foreignId('cistella_id')->references('id')->on('cistellas')->onDelete('cascade')->change();
            $table->foreignId('producte_id')->references('id')->on('productes')->onDelete('cascade')->change();
            $table->integer('quantitat');
            $table->primary(["cistella_id","producte_id"]); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cistelles_linies');
    }
}
