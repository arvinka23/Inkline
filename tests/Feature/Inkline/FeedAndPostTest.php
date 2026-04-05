<?php

use App\Models\category;
use App\Models\post;
use App\Models\User;

test('guest sees published posts on the home feed', function () {
    $author = User::factory()->create();
    $cat = category::factory()->create();
    post::factory()->create([
        'user_id' => $author->id,
        'category_id' => $cat->id,
        'published_at' => now(),
        'title' => 'Inkline Feed Story',
    ]);

    $this->get(route('home'))
        ->assertOk()
        ->assertSee('Inkline Feed Story');
});

test('guest can open a published post page', function () {
    $author = User::factory()->create();
    $cat = category::factory()->create();
    $p = post::factory()->create([
        'user_id' => $author->id,
        'category_id' => $cat->id,
        'published_at' => now(),
        'title' => 'Single Page Title',
    ]);

    $this->get(route('posts.show', [
        'author' => '@'.$author->username,
        'postSlug' => $p->slug,
    ]))
        ->assertOk()
        ->assertSee('Single Page Title');

    $this->get(route('posts.read', $p))
        ->assertOk()
        ->assertSee('Single Page Title');
});

test('guest cannot view an unpublished post', function () {
    $author = User::factory()->create();
    $cat = category::factory()->create();
    $p = post::factory()->create([
        'user_id' => $author->id,
        'category_id' => $cat->id,
        'published_at' => null,
    ]);

    $this->get(route('posts.show', [
        'author' => '@'.$author->username,
        'postSlug' => $p->slug,
    ]))->assertForbidden();
});

test('verified user can create and publish a post', function () {
    $user = User::factory()->create();
    $cat = category::factory()->create();

    $this->actingAs($user)
        ->post(route('posts.store'), [
            'title' => 'New Inkline Article',
            'content' => "First line.\nSecond line.",
            'category_id' => $cat->id,
        ])
        ->assertRedirect();

    $post = post::query()->where('title', 'New Inkline Article')->first();
    expect($post)->not->toBeNull()
        ->and($post->user_id)->toBe($user->id)
        ->and($post->published_at)->not->toBeNull();
});

test('user cannot delete another users post', function () {
    $owner = User::factory()->create();
    $intruder = User::factory()->create();
    $cat = category::factory()->create();
    $p = post::factory()->create([
        'user_id' => $owner->id,
        'category_id' => $cat->id,
        'published_at' => now(),
    ]);

    $this->actingAs($intruder)
        ->delete(route('posts.destroy', $p))
        ->assertForbidden();
});
