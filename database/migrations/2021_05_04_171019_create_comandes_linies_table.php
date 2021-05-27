<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComandesLiniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comanda_linias', function (Blueprint $table) {
            $table->id();
            $table->string('producte_nom');
            $table->text('producte_descripcio');
            $table->string("producte_mides")->nullable();
            $table->double('producte_preu', 8, 2)->default(0);
            $table->string("unitat");
            $table->integer('quantitat')->default(0);
            $table->foreignId('producte_id')->nullable()->references('id')->on('productes');
            $table->foreignId('comanda_id')->references('id')->on('comandas')->onDelete('cascade')->change();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comandes_linies');
    }
}
