<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * One blog post row in the database (title, content, category, etc.).
 */
class post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'image',
        'content',
        'category_id',
        'user_id',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    /**
     * Each post belongs to one category (linked by category_id on this table).
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(category::class, 'category_id');
    }

    /**
     * Author of the post.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Clap records for this post.
     */
    public function claps(): HasMany
    {
        return $this->hasMany(Clap::class, 'post_id');
    }

    /**
     * Only posts that are visible on the public feed.
     */
    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at')->where('published_at', '<=', now());
    }

    /**
     * Cover image for cards and article hero: valid stored URL if usable, else stable Picsum by post id + category.
     */
    public function coverImageUrl(int $width = 800, int $height = 600): string
    {
        $raw = $this->image;

        if (filled($raw)) {
            $url = trim((string) $raw);
            if ($url !== '') {
                if (str_starts_with($url, '/')) {
                    return url($url);
                }
                if (str_starts_with($url, '//')) {
                    return 'https:'.$url;
                }
                if (str_starts_with($url, 'http://')) {
                    $url = 'https://'.substr($url, 7);
                }
                if (filter_var($url, FILTER_VALIDATE_URL)) {
                    return $url;
                }
            }
        }

        $id = $this->getKey() ?? 0;

        return sprintf(
            'https://picsum.photos/seed/post-%d-c%d/%d/%d',
            $id,
            (int) ($this->category_id ?? 0),
            $width,
            $height
        );
    }
}
