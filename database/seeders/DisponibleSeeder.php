<?php

namespace Database\Seeders;
use App\Models\Disponible;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DisponibleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    
    private $arrayDisponibles = array(
		array(
			'quantitat_total' => '20',
			'quantitat_venuda' => '10',
            'product_id' => '1', 

		),
		array(
			'quantitat_total' => '50',
			'quantitat_venuda' => '25', 
            'product_id' => '2',

		),
		array(
			'quantitat_total' => '70',
			'quantitat_venuda' => '30',
            'product_id' => '3', 
		));
    public function run()
    {
        $this->seedDisponible();
        $this->command->info('Tabla inicializada con datos!');
    }
    public function seedDisponible(){
        DB::table('disponibles')->delete();
        
        foreach( $this->arrayDisponibles as $Disponible) {
            $a = new Disponible;
            $a->quantitat_total = $Disponible['quantitat_total'];
            $a->quantitat_venuda = $Disponible['quantitat_venuda'];
            $a->producte_id = $Disponible['product_id'];
            $a->save();
        }
    }
}
