# Inkline

A small **Laravel 13** publishing app: long-form posts, public writer profiles, topic feeds, follows, and claps. It is inspired by familiar reading platforms but uses its **own** typography and warm “ink + paper” styling—not a visual clone of any commercial product.

**Composer package name:** `inkline/publishing`

## Features (v1)

- Public **home feed** of published posts (`/`)
- **Topics** (categories) at `/topics/{slug}`
- **Public profiles** at `/@{username}`
- **Post pages** at `/@{username}/{post-slug}` (slug is unique per author)
- **My desk** (`/dashboard`) — list, edit, delete your posts
- **Write** — create posts (title, body, topic, optional image URL)
- **Follow** / unfollow authors (no self-follow)
- **Clap** once per post per user
- Laravel **Breeze** auth with **email verification** for writing actions

## Requirements

- PHP 8.3+
- Composer
- Node.js + npm (for Vite / Tailwind)
- SQLite (default) or another Laravel-supported database

## Quick setup

```bash
cp .env.example .env
php artisan key:generate
touch database/database.sqlite   # if using SQLite; set DB_DATABASE in .env
php artisan migrate
php artisan db:seed                # optional: test users + sample posts
npm install
npm run build
php artisan serve
```

**Test logins (after `db:seed`):** `test1@example.com` … `test10@example.com`, password `password`. Each has username `testuser1` … `testuser10`.

## Tests

```bash
php artisan test
```

Inkline-specific scenarios live under `tests/Feature/Inkline/` (feed, post CRUD, profile, follow, clap, authorization).

## How we built this (step by step)

1. **Data model** — Added `username` and `bio` on `users`, `slug` on `categories`, `followers` and `claps` pivot-style tables, and scoped post slugs with a unique `(user_id, slug)` index.
2. **Domain logic** — `User` relationships for posts, followers, and following; `post::published()` scope; `PostPolicy` for who can view, update, or delete posts.
3. **HTTP layer** — `PostController` for feed, category listing, post show, dashboard, and CRUD; `PublicProfileController`; `FollowerController` (toggle); `ClapController` (single clap per user).
4. **Routes** — Public routes first, then `auth` + `verified` groups for writing, follow, and claps; `/@`-style paths use a regex so they do not steal `/login`, `/topics`, etc.
5. **UI** — Tailwind + Flowbite; **Fraunces** + **DM Sans** fonts; amber/stone palette (“Inkline” look).
6. **Tests** — Pest feature tests for the behaviours above; existing Breeze tests updated for `username` on register/profile.

## Roadmap (ideas)

- Draft vs published workflow  
- Comments  
- Search  
- Real image uploads (beyond URL field)  
- Notifications for new followers or claps  

## Reference material

A separate **laravel-medium-clone-main** folder may exist locally as a one-time reference; it is **not** a runtime dependency of Inkline.

## License

The MIT License. Laravel Breeze and framework components remain under their respective licenses.
