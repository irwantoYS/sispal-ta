<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User::factory(1000)->create();
        User::create([
            'nama' => 'irwanhsse',
            'no_telepon' => '0852',
            'email' => 'irwan.yeze@gmail.com',
            'password' => Hash::make('irwan123'),
            'role' => 'HSSE',
            'image' => 'string',
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'nama' => 'irwanma',
            'no_telepon' => '0852',
            'email' => 'irwanma@gmail.com',
            'password' => Hash::make('irwan123'),
            'role' => 'ManagerArea',
            'image' => 'string',
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'nama' => 'irwandriver',
            'no_telepon' => '0852',
            'email' => 'irwandriver@gmail.com',
            'password' => Hash::make('irwan123'),
            'role' => 'Driver',
            'image' => 'string',
            'remember_token' => Str::random(10),
        ]);
    }
}
