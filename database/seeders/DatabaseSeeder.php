<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('clientes')->insert([
            [
                'nombre'        => 'prueba',
                'cif'           => 'B12345678',
                'telefono'      => '123456789',
                'direccion'     => 'Calle Pruebas',
                'localidad'     => 'MIJAS',
                'provincia'     => '09-MALAGA',
                'codigoPostal' => '12345'
            ]
        ]);

        DB::table('maquinas')->insert([
            [
                'matricula'     => '2384FRF',
                'tipo'          => '40M'
            ]
        ]);

        DB::table('rols')->insert([
            [
                'nombre' => 'Administrador'
            ],
            [
                'nombre' => 'Trabajador'
            ]
        ]);

        DB::table('users')->insert([
            [
                'nombre'        => 'Alvaro',
                'apellidos'     => 'González Delgado',
                'telefono'      => '639266047',
                'email'         => 'alvaro@alvaro.com',
                'password'      => bcrypt('123456'),
                'activo'        => true,
                'rol_id'        => '1'
            ]
        ]);
    }
}
