<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HandlingTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['name' => 'Bag', 'description' => 'A flexible container.'],
            ['name' => 'Bale', 'description' => 'A large bundle.'],
            ['name' => 'Barrel', 'description' => 'A cylindrical container.'],
            ['name' => 'Basket', 'description' => 'A container made of woven material.'],
            ['name' => 'Box', 'description' => 'A square or rectangular container.'],
            ['name' => 'Bucket', 'description' => 'A typically cylindrical vessel for catching, holding, or carrying liquids or solids.'],
            ['name' => 'Bulkhead', 'description' => 'A dividing wall or barrier.'],
            ['name' => 'Bundle', 'description' => 'A group of things fastened together for convenient handling.'],
            ['name' => 'Carton', 'description' => 'A box or container usually made of cardboard and often of corrugated cardboard.'],
            ['name' => 'Case', 'description' => 'An outer container that protects the contents.'],
            ['name' => 'Crate', 'description' => 'A rugged shipping container typically made of wood.'],
            ['name' => 'Cylinder', 'description' => 'A cylindrical container for holding or transporting goods.'],
            ['name' => 'Drum', 'description' => 'A cylindrical container often used for shipping liquids.'],
            ['name' => 'Package', 'description' => 'A container used to package items for shipment.'],
            ['name' => 'Pallet', 'description' => 'A flat transport structure that supports goods in a stable fashion.'],
            ['name' => 'Piece', 'description' => 'An individual object that has been packed for shipment.'],
            ['name' => 'Rack', 'description' => 'A framework typically used to hold items.'],
            ['name' => 'Reel', 'description' => 'A cylindrical device on which objects are wound.'],
            ['name' => 'Roll', 'description' => 'A cylindrical sample of material.'],
            ['name' => 'Skid', 'description' => 'A pallet-like platform that supports goods for storage and transportation.'],
            ['name' => 'Tote', 'description' => 'A bag, typically an open one with carrying handles.'],
            ['name' => 'Sheet', 'description' => 'A large piece of cloth, paper, or other material.'],
            ['name' => 'Tube', 'description' => 'A hollow cylindrical container.']
        ];

        foreach ($types as $type) {
            DB::table('handling_types')->insert([
                'name' => $type['name'],
                'description' => $type['description'], // Corrected to use the 'description' from the array
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
