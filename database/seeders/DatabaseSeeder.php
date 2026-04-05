<?php

namespace Database\Seeders;

use App\Models\post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Fill the database with sample users, categories, and posts so the dashboard has data to show.
     */
    public function run(): void
    {
        // Ten test accounts: test1@example.com … test10@example.com, password: “password”.
        for ($i = 1; $i <= 10; $i++) {
            User::factory()->create([
                'name' => 'Test User',
                'username' => "testuser{$i}",
                'email' => "test{$i}@example.com",
                'password' => Hash::make('password'),
            ]);
        }

        $this->call(CategorySeeder::class);

        // Many fake posts spread across categories (uses PostFactory).
        post::factory(100)->create();
    }
}
