<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class Usuaris extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    private $arrayUsers = array(
		array(
			'name' => 'admin',
			'email' => 'admin@gmail.com',
			'password' => '1234',
			'remember_token'=>'1234',
            'esAdmin' => '1'
		),
		array(
			'name' => 'generic',
			'email' => 'generic@gmail.com',
			'password' => '1234',
			'remember_token'=>'1234',
            'esAdmin' => '0'
		),
		array(
			'name' => 'usuari',
			'email' => 'usuari@gmail.com',
			'password' => '1234',
			'remember_token'=>'1234',
            'esAdmin' => '0'
		)
	);
    public function run()
    {
        $this->seedUsers();
        $this->command->info('Tabla usuarios inicializada con datos!');
     

    }
    public function seedUsers(){
        DB::table('users')->delete();
        foreach( $this->arrayUsers as $user) {
            $u = new User;
            $u->name = $user['name'];
            $u->email = $user['email'];
            $u->password = Hash::make($user['password']);
            $u->remember_token = $user['remember_token'];
            $u->esAdmin = $user['esAdmin'];
            $u->save();
        }
    }
    
}
