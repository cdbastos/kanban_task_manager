<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

         User::factory()->create([
             'name' => 'Test User',
             'email' => 'test@example.com',
             'email_verified_at' => now(),
             'password' => '$2y$12$1lFHISiFdeTGkBlGddJCouqQpjTRT81zpyiUMZKkEvD.5umK3Td9C',//password
             'remember_token' => Str::random(10),

         ]);
    }
}
