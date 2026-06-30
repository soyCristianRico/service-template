<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('landings', function (Blueprint $table) {
            $table->string('status')->default('published')->after('content');
            $table->timestamp('publish_at')->nullable()->after('status');
            $table->index(['status', 'publish_at']);
        });

        DB::table('landings')->where('is_active', false)->update(['status' => 'draft']);

        Schema::table('landings', function (Blueprint $table) {
            $table->dropIndex(['is_active']);
            $table->dropColumn('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('landings', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->after('content');
            $table->index('is_active');
        });

        DB::table('landings')->where('status', '!=', 'published')->update(['is_active' => false]);

        Schema::table('landings', function (Blueprint $table) {
            $table->dropIndex(['status', 'publish_at']);
            $table->dropColumn(['status', 'publish_at']);
        });
    }
};
