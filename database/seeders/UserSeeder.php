<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Verificar si el rol 'admin' existe, si no, crearlo
        if (!Role::where('name', 'admin')->exists()) {
            Role::create(['name' => 'admin']);
        }

        User::create([
            'name' => 'Joanna',
            'last_name' => 'Avalos',
            'email' => 'joanna@lunavalos.com',
            'password' => bcrypt('12345678'),
            'job_title' => 'Web Developer',
            'office' => 'saltillo',
        ])->assignRole('admin');

        User::factory(8)->create();
    }
}
