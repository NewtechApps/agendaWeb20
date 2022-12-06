<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Models\Usuario;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);


        $usuario = new Usuario();
        $usuario->login  = 'admin.agenda';
        $usuario->senha  = Hash::make("adminagenda");
        $usuario->email  = env('MAIL_FROM_ADDRESS');
        $usuario->nome   = 'Administrador';
        $usuario->status = '1';
        $usuario->id_perfil = "1";
        $usuario->telefone = '(99) 99999-9999';
        $usuario->save();

    }
}
