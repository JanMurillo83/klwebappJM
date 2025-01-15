<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FactoryCompaniesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Deshabilitar las restricciones de claves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Truncar la tabla
        DB::table('factory_companies')->truncate();

        // Insertar los nuevos registros
        DB::table('factory_companies')->insert([
            ['name' => 'NA', 'notes' => 'NA'],
            ['name' => 'Company A', 'notes' => 'Notes for Company A'],
            ['name' => 'Company B', 'notes' => 'Notes for Company B'],
            ['name' => 'Company C', 'notes' => 'Notes for Company C'],
            ['name' => 'Company D', 'notes' => 'Notes for Company D'],
            ['name' => 'Company E', 'notes' => 'Notes for Company E'],
        ]);

        // Habilitar nuevamente las restricciones de claves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
