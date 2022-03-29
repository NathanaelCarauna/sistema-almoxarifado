<?php

use Illuminate\Database\Seeder;

class CargoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Cargo::class, 1)->create(['nome' => 'Requerente']);
        factory(\App\Cargo::class, 1)->create(['nome' => 'Administrador']);
        factory(\App\Cargo::class, 1)->create(['nome' => 'Diretoria']);
        factory(\App\Cargo::class, 1)->create(['nome' => 'Assistente de estoque']);
    }
}
