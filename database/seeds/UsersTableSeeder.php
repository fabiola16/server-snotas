<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$data = array(
        	[
				'nombre'    => 'Olivia',
				'apellidos' => 'Ruiz',
				'direccion' => 'Hospital del Sur',
				'email'   	=> 'jar.yascaribay@yavirac.edu.ec',
				'password'  => bcrypt('yavirac123'),
				'foto'    => 'img/default-user.png',
				'created_at' => new DateTime,
				'updated_at' => new DateTime
        	]
        );
       	App\User::insert($data);
    }
}
	