<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('123'),
            ]
        );
        $user->assignRole('admin');
        User::firstOrCreate(
            ['email' => '123@example.com'],
            [
                'name' => 'Random',
                'password' => bcrypt('123'),
            ]
        );
        $user->assignRole('receptionist');
    }
}
