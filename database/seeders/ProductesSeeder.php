<?php

namespace Database\Seeders;
use App\Models\Producte;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ProductesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    private $arrayProducts = array(
		array(
			'nom' => 'Toalla',
            'descripcio'=>'color blanc',
			'mides' => '50cmx50cm',
            'preu' => 15.80,
            'unitat'=>'unidad'
        ),
        array(
			'nom' => 'Sabana',
            'descripcio'=>'color blanc',
			'mides' => '2mx2m',
            'preu' => 8.80,
            'unitat'=>'unidad'
        ),
        array(
			'nom' => 'Trapos',
            'descripcio'=>'color blanc',
			'mides' => '10x10',
            'preu' => 6.20,
            'unitat'=>'cajas de 10 kilos'
        )
    );

    public function run()
    {
        $this->seedProducts();
        $this->command->info('Tabla Products inicializada con datos!');
      }
  
      public function seedProducts(){
  
          DB::table('productes')->delete();
  
          foreach( $this->arrayProducts as $producte ) {
                  $p = new Producte;
                  $p->nom = $producte['nom'];
                  $p->mides = $producte['mides'];
                  $p->descripcio = $producte['descripcio'];
                  $p->preu = $producte['preu'];
                  $p->unitat = $producte['unitat'];
                  $p->save();
  
  
          }
      }
}
