<?php

$email = $argv[1] ?? null;
if (! $email) {
    fwrite(STDERR, "Usage: php scripts/delete-user-by-email.php email@example.com\n");
    exit(1);
}

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$n = \App\Models\User::where('email', $email)->delete();
echo $n ? "Deleted user(s): {$email}\n" : "No user with that email.\n";
