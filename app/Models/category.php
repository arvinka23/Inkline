<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * One category label (e.g. “Technology”) that many posts can share.
 */
class category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    /**
     * Topic URLs use /topics/{slug}.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * All posts that use this category (matched by category_id on the posts table).
     */
    public function posts()
    {
        return $this->hasMany(post::class, 'category_id');
    }
}
