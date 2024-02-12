<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Person;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Person::factory()->create();
        for ($i = 0; $i < 10; $i++) {
            Person::factory()->create();
        }

        for ($i = 0; $i < 10; $i++) {
            Person::factory()->create([
                'name' => 'name' . $i,
                'email' => 'email' . $i . '@example.com',
                'age' => 20 + $i,
                'phone' => '000-0000-000' . $i,
            ]);
        }

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
