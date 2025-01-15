<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        // $this->call(RoleSeeder::class);
        // $this->call(UserSeeder::class);
        // $this->call(BusinessDirectorySeeder::class);
        // $this->call(ShipmentStatusSeeder::class);
        // $this->call(HandlingTypeSeeder::class);

        $this->call([
            UserSeeder::class,
            RoleSeeder::class,
            BusinessDirectorySeeder::class,
            ShipmentStatusSeeder::class,
            HandlingTypeSeeder::class,
            MaterialTypesSeeder::class,
            FreightClassSeeder::class,
            ChargeTypeSeeder::class,
            FactoryCompaniesSeeder::class,
            ServiceDetailsSeeder::class,
            UrgencyTypesSeeder::class,
        ]);
        
        // User::factory()->create([
        //     'name' => 'joanna test',
        //     'email' => 'joanna@lunavalos.com',
        // ])->assignRole('admin');
    }
}
