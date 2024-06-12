<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\RolesSeeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        //Seeding 10 users
        // User::factory(10)->create();

        //Seeder for Categories
        $this->call([
            CategorySeeder::class,
            // Other seeders...
        ]);

        //Seeding Admin
        User::factory()->create([
            'name' => 'Fidelis Stephano',
            'type' => 'admin',
            'password' => Hash::make('123456'),
            'email' => 'admin@osss.com',
        ]);

        //Seeding User
        User::factory()->create([
            'name' => 'Alphonce Stephano',
            'type' => 'user',
            'password' => Hash::make('123456'),
            'email' => 'user@osss.com',
        ]);

        User::factory()->create([
            'name' => 'John Stephano',
            'type' => 'user',
            'password' => Hash::make('123456'),
            'email' => 'user2@osss.com',
        ]);

        User::factory()->create([
            'name' => 'Helen Stephano',
            'type' => 'user',
            'password' => Hash::make('123456'),
            'email' => 'user3@osss.com',
        ]);
    }
}
