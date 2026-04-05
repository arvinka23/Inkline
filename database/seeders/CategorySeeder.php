<?php

namespace Database\Seeders;

use App\Models\category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Default topics for the post form and category tabs (safe to run on every deploy).
 */
class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $names = [
            'Technology',
            'Science',
            'Health',
            'Entertainment',
            'Sports',
            'Politics',
        ];

        foreach ($names as $name) {
            $slug = Str::slug($name);
            category::query()->firstOrCreate(
                ['slug' => $slug],
                ['name' => $name]
            );
        }
    }
}
