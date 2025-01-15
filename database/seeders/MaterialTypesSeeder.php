<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MaterialType;

class MaterialTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $materialTypes = [
            ['name' => 'Automotive fabric', 'description' => 'Fabrics for use in vehicle interiors and upholstery.'],
            ['name' => 'Automotive foam', 'description' => 'Specialty foams used for cushioning and insulation in vehicles.'],
            ['name' => 'Automotive parts', 'description' => 'Components and accessories.'],
            ['name' => 'Automotive vinyl', 'description' => 'Durable and flexible materials.'],
            ['name' => 'Electronic devices', 'description' => 'Devices integrated with electronic circuits and systems.'],
            ['name' => 'Sand printed cores', 'description' => 'Core materials for complex shapes.'],
            ['name' => 'Hazmat Adhesives', 'description' => 'Specialized adhesives used for handling hazardous materials, ensuring safety and compliance.'],
            ['name' => 'Metal rack', 'description' => 'Sturdy metal frameworks used for storage and handling of heavy items in industrial settings.'],
            ['name' => 'Molds', 'description' => 'Tools used for shaping materials into specific designs during the manufacturing process.'],
            ['name' => 'Machine', 'description' => 'Mechanical devices engineered to perform specific tasks in industrial operations.'],
            ['name' => 'Paint', 'description' => 'Coatings and finishes applied to surfaces for protection and aesthetics.'],
            ['name' => 'Resin', 'description' => 'Synthetic or natural substances used in the production of plastics and adhesives.'],
            ['name' => 'Plastics automotive', 'description' => 'Various plastic materials used in the production of automotive components.'],
            ['name' => 'Plasticos termoplasticos', 'description' => 'Thermoplastic materials known for their moldability and reuse in high heat conditions.'],
            ['name' => 'Hazmat Material', 'description' => 'Materials that are hazardous and require special handling and regulatory compliance.']
        ]
        ;

        foreach ($materialTypes as $type) {
            MaterialType::create($type);
        }
    }
}
