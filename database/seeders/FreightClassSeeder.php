<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FreightClass; // Usa el modelo FreightClass

class FreightClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classes = [
            ['name' => 'Class 55', 'description' => 'Items with a lower density and higher value, usually over 50 pounds per cubic foot.'],
            ['name' => 'Class 60', 'description' => 'Car accessories and car parts.'],
            ['name' => 'Class 65', 'description' => 'Car accessories, auto engines, food items.'],
            ['name' => 'Class 70', 'description' => 'Car accessories, auto engines, automobile engines.'],
            ['name' => 'Class 77.5', 'description' => 'Tires, bathroom fixtures.'],
            ['name' => 'Class 85', 'description' => 'Crated machinery, cast iron stoves.'],
            ['name' => 'Class 92.5', 'description' => 'Computers, monitors, refrigerators.'],
            ['name' => 'Class 100', 'description' => 'Car covers, canvas, boat covers, or wine cases.'],
            ['name' => 'Class 110', 'description' => 'Cabinets, framed artwork, table saw.'],
            ['name' => 'Class 125', 'description' => 'Small household appliances.'],
            ['name' => 'Class 150', 'description' => 'Auto sheet metal parts, bookcases.'],
            ['name' => 'Class 175', 'description' => 'Clothing, couches, stuffed furniture.'],
            ['name' => 'Class 200', 'description' => 'Sheet metal parts, aluminum tables, packaged mattresses.'],
            ['name' => 'Class 250', 'description' => 'Bamboo furniture, mattress and box spring, plasma TV.'],
            ['name' => 'Class 300', 'description' => 'Wood cabinets, tables, chairs setup, model boats.'],
            ['name' => 'Class 400', 'description' => 'Deer antlers.'],
            ['name' => 'Class 500', 'description' => 'Low density or high value, highest cost. Examples include bags of gold dust or ping pong balls.']
        ];

        foreach ($classes as $class) {
            FreightClass::create($class);
        }
    }
}
