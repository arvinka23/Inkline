<?php

use App\Models\category;
use App\Models\post;
use App\Models\User;

test('public profile page loads by username path', function () {
    $user = User::factory()->create(['username' => 'inkline_writer']);

    $this->get(route('profile.show', ['author' => '@inkline_writer']))
        ->assertOk()
        ->assertSee('inkline_writer');
});

test('user can follow and unfollow another author', function () {
    $fan = User::factory()->create();
    $author = User::factory()->create();

    $this->actingAs($fan)->post(route('follow', $author))->assertRedirect();
    expect($fan->fresh()->following()->where('users.id', $author->id)->exists())->toBeTrue();

    $this->actingAs($fan)->post(route('follow', $author))->assertRedirect();
    expect($fan->fresh()->following()->where('users.id', $author->id)->exists())->toBeFalse();
});

test('user cannot follow themselves', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->from(route('profile.show', ['author' => '@'.$user->username]))
        ->post(route('follow', $user))
        ->assertSessionHasErrors('follow');
});

test('user can clap a post once', function () {
    $reader = User::factory()->create();
    $author = User::factory()->create();
    $cat = category::factory()->create();
    $p = post::factory()->create([
        'user_id' => $author->id,
        'category_id' => $cat->id,
        'published_at' => now(),
    ]);

    $url = route('posts.show', ['author' => '@'.$author->username, 'postSlug' => $p->slug]);

    $this->actingAs($reader)->from($url)->post(route('claps.store', $p))->assertRedirect();
    expect($p->claps()->count())->toBe(1);

    $this->actingAs($reader)->from($url)->post(route('claps.store', $p))->assertSessionHasErrors('clap');
});
