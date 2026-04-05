<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\post;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

/**
 * Public feed, single post, category listing, and authenticated CRUD.
 */
class PostController extends Controller
{
    /**
     * Home: latest published posts from all authors.
     */
    public function feed(): View
    {
        $posts = post::query()
            ->published()
            ->with(['user', 'category'])
            ->latest('published_at')
            ->paginate(10);

        return view('post.feed', compact('posts'));
    }

    /**
     * Posts in one topic (category), newest first.
     */
    public function byCategory(category $category): View
    {
        $posts = post::query()
            ->published()
            ->where('category_id', $category->id)
            ->with(['user', 'category'])
            ->latest('published_at')
            ->paginate(10);

        return view('post.by-category', compact('category', 'posts'));
    }

    /**
     * Single post at /@username/slug (first path segment includes the @).
     */
    public function show(string $author, string $postSlug): View
    {
        $user = User::query()->where('username', ltrim($author, '@'))->firstOrFail();
        $post = post::query()
            ->where('user_id', $user->id)
            ->where('slug', $postSlug)
            ->firstOrFail();

        return $this->renderPost($post);
    }

    /**
     * Same article page using the post id (used by “Read more” so links always work).
     */
    public function read(post $post): View
    {
        return $this->renderPost($post);
    }

    /**
     * Shared logic: check policy, load relations, show the article view.
     */
    private function renderPost(post $post): View
    {
        $this->authorize('view', $post);

        $post->load(['user', 'category']);
        $post->loadCount('claps');

        $clapped = false;
        if (auth()->check()) {
            $clapped = $post->claps()->where('user_id', auth()->id())->exists();
        }

        return view('post.show', compact('post', 'clapped'));
    }

    /**
     * Author dashboard: your posts (all states), paginated.
     */
    public function dashboard(Request $request): View
    {
        $posts = $request->user()
            ->posts()
            ->with('category')
            ->latest()
            ->paginate(10);

        return view('post.dashboard', compact('posts'));
    }

    public function create(): View
    {
        $this->authorize('create', post::class);

        $categories = category::query()->orderBy('name')->get();

        return view('post.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', post::class);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
            'image' => ['nullable', 'string', 'max:2048'],
        ]);

        $slug = $this->makeUniqueSlugForUser($request->user(), Str::slug($validated['title']));

        $post = $request->user()->posts()->create([
            'title' => $validated['title'],
            'slug' => $slug,
            'content' => $validated['content'],
            'category_id' => $validated['category_id'],
            'image' => $validated['image'] ?? null,
            'published_at' => now(),
        ]);

        return redirect()->route('posts.show', [
            'author' => '@'.$post->user->username,
            'postSlug' => $post->slug,
        ]);
    }

    public function edit(post $post): View
    {
        $this->authorize('update', $post);

        $categories = category::query()->orderBy('name')->get();

        return view('post.edit', compact('post', 'categories'));
    }

    public function update(Request $request, post $post): RedirectResponse
    {
        $this->authorize('update', $post);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
            'image' => ['nullable', 'string', 'max:2048'],
        ]);

        $slug = $post->slug;
        $newBase = Str::slug($validated['title']);
        if ($newBase !== $post->slug && $newBase !== '') {
            $slug = $this->makeUniqueSlugForUser($post->user, $newBase, ignorePostId: $post->id);
        }

        $post->update([
            'title' => $validated['title'],
            'slug' => $slug,
            'content' => $validated['content'],
            'category_id' => $validated['category_id'],
            'image' => $validated['image'] ?? null,
            'published_at' => $post->published_at ?? now(),
        ]);

        return redirect()->route('posts.read', $post);
    }

    public function destroy(post $post): RedirectResponse
    {
        $this->authorize('delete', $post);

        $post->delete();

        return redirect()->route('dashboard')->with('status', __('Post deleted.'));
    }

    /**
     * Build a slug that is unique for this author’s posts.
     */
    private function makeUniqueSlugForUser(User $user, string $base, ?int $ignorePostId = null): string
    {
        $base = $base !== '' ? $base : 'post';
        $candidate = $base;
        $n = 0;

        do {
            $q = post::query()->where('user_id', $user->id)->where('slug', $candidate);
            if ($ignorePostId !== null) {
                $q->where('id', '!=', $ignorePostId);
            }
            $exists = $q->exists();
            if (! $exists) {
                return $candidate;
            }
            $candidate = $base.'-'.(++$n);
        } while (true);
    }
}
