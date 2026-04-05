<?php

namespace App\Http\Controllers;

use App\Models\Clap;
use App\Models\post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Add a clap to a post (one per user per post).
 */
class ClapController extends Controller
{
    public function store(Request $request, post $post): RedirectResponse
    {
        if ($post->published_at === null || $post->published_at > now()) {
            abort(404);
        }

        $user = $request->user();

        if (Clap::query()->where('post_id', $post->id)->where('user_id', $user->id)->exists()) {
            return back()->withErrors(['clap' => __('You already clapped this post.')]);
        }

        Clap::query()->create([
            'post_id' => $post->id,
            'user_id' => $user->id,
        ]);

        return back();
    }
}
