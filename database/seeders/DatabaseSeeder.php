<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Tenant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         \App\Models\User::factory()->create([
             'name' => fake()->name(),
             'email' => 'admin@sls.com',
             'email_verified_at' => now(),
             'password' => bcrypt('password'),
             'remember_token' => Str::random(10),
             'tenant_id' => Tenant::factory()->create(),
         ]);
         \App\Models\User::factory(10)->create();


    }
}
