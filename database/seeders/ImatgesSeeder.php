<?php

namespace Database\Seeders;
use App\Models\Imatge;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ImatgesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    private $arrayimatge = array(
		array(
			'producte_id'=>1,
            'url' => '/img/products/img1.jpg',
				
        ),
        array(
			'producte_id'=>2,
            'url' => '/img/products/img2.jpg',
			
			
        ),
        array(
			'producte_id'=>3,
            'url' => '/img/products/img3.jpg',
           
			
        )
    );
    public function run()
    {
        $this->seedimatge();
        $this->command->info('Tabla imatge inicializada con datos!');
    }
    public function seedimatge(){

        DB::table('imatges')->delete();

        foreach( $this->arrayimatge as $image ) {
                $i = new Imatge;
                $i->producte_id = $image['producte_id'];
                $i->url = $image['url'];
                $i->save();
        }
    }
}
