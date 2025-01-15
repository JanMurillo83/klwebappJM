<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            ['name' => 'FTL', 'description' => 'Full Truckload services'],
            ['name' => 'LTL', 'description' => 'Less Than Truckload services'],
            ['name' => 'Container Drayage', 'description' => 'Container Drayage services'],
            ['name' => 'Air Freight', 'description' => 'Air freight transportation'],
            ['name' => 'Charter', 'description' => 'Charter services'],
            ['name' => 'Hand Carrier', 'description' => 'Hand carrier services'],
            ['name' => 'Transfer', 'description' => 'Transfer services'],
            ['name' => 'Us Customs Broker', 'description' => 'US customs broker services'],
            ['name' => 'Trailer Rental', 'description' => 'Trailer rental services'],
            ['name' => 'Warehouse', 'description' => 'Warehouse services'],
        ];

        foreach ($services as $service) {
            DB::table('service_details')->insert($service);
        }
    }
}
