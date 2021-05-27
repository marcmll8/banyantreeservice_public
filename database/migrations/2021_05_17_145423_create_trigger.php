<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
        CREATE TRIGGER producte_eliminat AFTER UPDATE ON `disponibles` FOR EACH ROW
        BEGIN
        IF NEW.quantitat_total-NEW.quantitat_venuda<=0
        THEN
        UPDATE `productes` SET `productes`.`eliminat`=1 WHERE id = OLD.producte_id;
        END IF;
        END 
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `producte_eliminat`');
    }
}
