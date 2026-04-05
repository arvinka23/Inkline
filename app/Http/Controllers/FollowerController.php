<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Follow or unfollow an author (toggle).
 */
class FollowerController extends Controller
{
    public function toggle(Request $request, User $user): RedirectResponse
    {
        $follower = $request->user();

        if ((int) $follower->id === (int) $user->id) {
            return back()->withErrors(['follow' => __('You cannot follow yourself.')]);
        }

        $exists = DB::table('followers')
            ->where('user_id', $user->id)
            ->where('follower_id', $follower->id)
            ->exists();

        if ($exists) {
            DB::table('followers')
                ->where('user_id', $user->id)
                ->where('follower_id', $follower->id)
                ->delete();
        } else {
            DB::table('followers')->insert([
                'user_id' => $user->id,
                'follower_id' => $follower->id,
                'created_at' => now(),
            ]);
        }

        return back();
    }
}
