<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;

/**
 * Public writer profile at /@username (no login required).
 */
class PublicProfileController extends Controller
{
    public function show(string $author): View
    {
        $user = User::query()->where('username', ltrim($author, '@'))->firstOrFail();

        $user->loadCount(['followers', 'following']);
        $posts = $user->posts()
            ->published()
            ->with('category')
            ->latest('published_at')
            ->paginate(10);

        $isFollowing = false;
        if (auth()->check()) {
            $isFollowing = auth()->user()->following()->where('users.id', $user->id)->exists();
        }

        return view('profile.public', compact('user', 'posts', 'isFollowing'));
    }
}
