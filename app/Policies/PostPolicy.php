<?php

namespace App\Policies;

use App\Models\User;
use App\Models\post;

class PostPolicy
{
    /**
     * Anyone can browse their own post list in the dashboard (filtered in the query).
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Published posts are public. Unpublished (null date) are only visible to the author.
     */
    public function view(?User $user, post $post): bool
    {
        if ($post->published_at !== null && $post->published_at <= now()) {
            return true;
        }

        return $user !== null && (int) $user->id === (int) $post->user_id;
    }

    /**
     * Verified users can create posts (route middleware also checks verified).
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Only the author can edit.
     */
    public function update(User $user, post $post): bool
    {
        return (int) $user->id === (int) $post->user_id;
    }

    /**
     * Only the author can delete.
     */
    public function delete(User $user, post $post): bool
    {
        return (int) $user->id === (int) $post->user_id;
    }

    public function restore(User $user, post $post): bool
    {
        return false;
    }

    public function forceDelete(User $user, post $post): bool
    {
        return false;
    }
}
