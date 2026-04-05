<?php

namespace Database\Factories;

use App\Models\category;
use App\Models\post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Builds fake post data for tests and seeding.
 *
 * @extends Factory<post>
 */
class PostFactory extends Factory
{
    /** The Eloquent model this factory creates. */
    protected $model = post::class;

    /**
     * Random but realistic values for each new post row.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence();

        return [
            'category_id' => category::query()->inRandomOrder()->value('id') ?? 1,
            // Null: views use post::coverImageUrl() (stable seed by id + category). Set a URL in forms to override.
            'image' => null,
            'title' => $title,
            'slug' => fake()->unique()->slug(),
            'content' => fake()->paragraph(5),
            'user_id' => 1,
            'published_at' => now(),
        ];
    }
}
