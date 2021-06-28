<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Usa el UserFactory para generar 9 registros aleatorios
        factory(User::class, 15)->create();
        //Crea el usuario administrador para ingresar al sitio
        DB::table('users')->insert([
            'name' => 'Administrador',
            'email' => 'jspinzonr@misena.edu.co',
            'email_verified_at' => now(),
            'password' => Hash::make('123456789'), // password
            'created_at' => now(),
        ]);
    }
}
