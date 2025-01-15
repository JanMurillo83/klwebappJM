<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ChargeType;

class ChargeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define the charge types
        $chargeTypes = [
            ['name' => 'Detention at Shipper', 'description' => 'Additional time spent at the shipper location'],
            ['name' => 'Detention at Consignee', 'description' => 'Additional time spent at the consignee location'],
            ['name' => 'Detention at Broker', 'description' => 'Detention with the broker'],
            ['name' => 'Layover at Shipper', 'description' => 'Delay at the shipper location'],
            ['name' => 'Layover at Broker', 'description' => 'Delay with the broker'],
            ['name' => 'Layover at Customs', 'description' => 'Delay at customs'],
            ['name' => 'Layover at Consignee', 'description' => 'Delay at the consignee location'],
            ['name' => 'Over Weight', 'description' => 'Excess weight of the cargo'],
            ['name' => 'Over Dimensions', 'description' => 'Cargo exceeds size limits'],
            ['name' => 'Returning Back to the Shipper', 'description' => 'Returning cargo to the shipper'],
            ['name' => 'TONU', 'description' => 'Truck Ordered Not Used'],
            ['name' => 'Red Light at Customs', 'description' => 'Red light at customs inspection'],
            ['name' => 'Pickup Address Change', 'description' => 'Change in the pickup address'],
            ['name' => 'Delivery Address Change', 'description' => 'Change in the delivery address'],
            ['name' => 'Other', 'description' => 'Other charges'],
        ];

        // Insert the charge types into the database using Eloquent
        foreach ($chargeTypes as $chargeType) {
            ChargeType::create($chargeType);
        }
    }
}
