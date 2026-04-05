<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->nullable()->unique()->after('id');
            $table->text('bio')->nullable()->after('email');
        });

        foreach (User::query()->whereNull('username')->cursor() as $user) {
            $base = Str::slug(Str::before($user->email, '@')) ?: 'user';
            $candidate = $base;
            $n = 0;
            while (User::query()->where('username', $candidate)->where('id', '!=', $user->id)->exists()) {
                $candidate = $base.'-'.(++$n);
            }
            $user->update(['username' => $candidate]);
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['username', 'bio']);
        });
    }
};
