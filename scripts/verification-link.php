<?php

/**
 * Print a fresh signed email-verification URL for a user (same as the mail uses).
 * Usage: php scripts/verification-link.php your@email.com
 */

$email = $argv[1] ?? null;
if (! $email) {
    fwrite(STDERR, "Usage: php scripts/verification-link.php email@example.com\n");
    exit(1);
}

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$user = \App\Models\User::where('email', $email)->first();
if (! $user) {
    fwrite(STDERR, "No user with email: {$email}\n");
    exit(1);
}

$url = \Illuminate\Support\Facades\URL::temporarySignedRoute(
    'verification.verify',
    \Illuminate\Support\Carbon::now()->addMinutes((int) config('auth.verification.expire', 60)),
    [
        'id' => $user->getKey(),
        'hash' => sha1($user->getEmailForVerification()),
    ]
);

echo $url . PHP_EOL;
