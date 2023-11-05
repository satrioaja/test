<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\DataLatih;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            'name' => 'Test User',
            'email' => 'test@gmail.com',
            'password' => bcrypt('password'),
        ]);

        DataLatih::create([
            'date' => '2021-01-01',
            'open' => 28994.009766,
            'high' => 29600.626953,
            'low' => 28803.585938,
            'close' => 29374.152344,
            'volume' => 0,
            'market_cap' => 0,
        ]);
    }
}
