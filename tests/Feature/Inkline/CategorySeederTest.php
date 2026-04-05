<?php

use App\Models\category;
use Database\Seeders\CategorySeeder;

test('category seeder creates default topics idempotently', function () {
    $this->seed(CategorySeeder::class);
    expect(category::query()->count())->toBe(6)
        ->and(category::query()->where('slug', 'technology')->exists())->toBeTrue();

    category::query()->delete();
    $this->seed(CategorySeeder::class);
    expect(category::query()->count())->toBe(6);
});
