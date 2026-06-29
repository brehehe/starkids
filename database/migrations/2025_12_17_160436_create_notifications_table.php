<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            // Add new fields for product expiry and defecta notifications
            if (! Schema::hasColumn('notifications', 'type')) {
                $table->string('type', 50)->after('id')->nullable();
            }
            if (! Schema::hasColumn('notifications', 'title')) {
                $table->string('title')->after('type')->nullable();
            }
            if (! Schema::hasColumn('notifications', 'message')) {
                $table->text('message')->after('title')->nullable();
            }
            if (! Schema::hasColumn('notifications', 'branch_id')) {
                $table->foreignUuid('branch_id')->after('company_id')->nullable();
            }
            if (! Schema::hasColumn('notifications', 'data')) {
                $table->jsonb('data')->after('message')->nullable();
            }
            if (! Schema::hasColumn('notifications', 'read_at')) {
                $table->timestamp('read_at')->after('is_read')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropColumn(['type', 'title', 'message', 'branch_id', 'data', 'read_at']);
        });
    }
};
