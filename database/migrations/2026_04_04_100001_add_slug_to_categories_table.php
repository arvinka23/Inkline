<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('categories', 'slug')) {
            Schema::table('categories', function (Blueprint $table) {
                $table->string('slug')->nullable()->unique()->after('name');
            });
        }

        foreach (DB::table('categories')->orderBy('id')->cursor() as $row) {
            if ($row->slug !== null && $row->slug !== '') {
                continue;
            }
            $base = Str::slug($row->name) ?: 'topic';
            $candidate = $base;
            $n = 0;
            while (DB::table('categories')->where('slug', $candidate)->where('id', '!=', $row->id)->exists()) {
                $candidate = $base.'-'.(++$n);
            }
            DB::table('categories')->where('id', $row->id)->update(['slug' => $candidate]);
        }
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
