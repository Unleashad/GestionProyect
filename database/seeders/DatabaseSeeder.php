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
                'localidad'     => 'FuengiPruebas',
                'provincia'     => 'MalaPruebas',
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

        DB::table('emails')->insert([
            [
                'correo_cliente'        => 'prueba@prueba.com',
                'cliente_id'            => '1'
            ]
        ]);

        DB::table('obras')->insert([
            [
                'nombre'        => 'ObraPrueba',
                'direccion'     => 'Calle Obra',
                'localidad'     => 'Mijas',
                'provincia'     => 'Málaga',
                'cliente_id'    => '1'
            ]
        ]);

        DB::table('servicios')->insert([
            [
                'fecha'             => '2022-03-30',
                'm3'                => '100',
                'hora_ini'          => '18:09:01',
                'hora_fin'          => '18:09:01',
                'desplazamiento'    => '1',
                'observaciones'     => 'hola',
                'obra_id'           => '1',
                'maquina_id'        => '1',
                'user_id'           => '1',
                'estado'            => true
            ],
            [
                'fecha'             => '2022-03-30',
                'm3'                => '100',
                'hora_ini'          => '18:09:01',
                'hora_fin'          => '18:09:01',
                'desplazamiento'    => '1',
                'observaciones'     => 'hola',
                'obra_id'           => '1',
                'maquina_id'        => '1',
                'user_id'           => '1',
                'estado'            => false
            ],
        ]);
    }
}
