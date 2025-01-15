<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShipmentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['name' => 'Completed', 'description' => 'The shipment has been completed.'],
            ['name' => 'Cancelled', 'description' => 'The shipment has been cancelled.'],
            ['name' => 'Scheduled', 'description' => 'The shipment is scheduled.'],
            ['name' => 'Active', 'description' => 'The shipment is currently active.'],
            ['name' => 'Quoting', 'description' => 'The shipment is in the quoting process.'],
        ];

        foreach ($statuses as $status) {
            DB::table('shipment_status')->insert([
                'name' => $status['name'],
                'description' => $status['description'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
