<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         \App\Models\User::factory(10)->create();

         \App\Models\User::factory()->create([
             'name' => 'Test User1',
             'phone' => '01012661102',
         ]);

         \App\Models\User::factory()->create([
             'name' => 'Test User2',
             'phone' => '01012661101',
         ]);
    }
}
