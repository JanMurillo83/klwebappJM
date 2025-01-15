<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Uom;

class UomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Vaciar la tabla antes de rellenarla
        //Uom::query()->delete();
        $uoms = [
            // Unidades de Peso
            ['name' => 'kg', 'description' => 'Weight Units'],
            ['name' => 'g', 'description' => 'Weight Units'],
            ['name' => 'lb', 'description' => 'Weight Units'],
            ['name' => 'oz', 'description' => 'Weight Units'],
            ['name' => 'ton', 'description' => 'Weight Units'],

            // Unidades de Longitud
            ['name' => 'in', 'description' => 'Units of Length'],
            ['name' => 'ft', 'description' => 'Units of Length'],
            ['name' => 'cm', 'description' => 'Units of Length'],
            ['name' => 'm', 'description' => 'Units of Length'],
            ['name' => 'yd', 'description' => 'Units of Length'],

            // Unidades de Volumen
            ['name' => 'l', 'description' => 'Volume Units'],
            ['name' => 'ml', 'description' => 'Volume Units'],
            ['name' => 'm3', 'description' => 'Volume Units'],
            ['name' => 'ft3', 'description' => 'Volume Units'],
        ];

        foreach ($uoms as $uom) {
            Uom::create($uom);
        }
    }
}
