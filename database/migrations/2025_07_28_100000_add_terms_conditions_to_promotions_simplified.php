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
        Schema::table('promotions_simplified', function (Blueprint $table) {
            // Add terms and conditions field
            $table->jsonb('terms_conditions')->nullable()->after('image');

            // Add user type targeting
            $table->jsonb('selected_user_types')->nullable()->after('selected_companies');

            // Add discount rules for specific scenarios
            $table->boolean('can_combine_with_other')->default(false)->after('priority');
            $table->integer('max_uses_per_order')->default(1)->after('quota_per_user');

            // Add notification settings
            $table->boolean('send_notification')->default(false)->after('is_active');
            $table->text('notification_message')->nullable()->after('send_notification');

            // Index for performance
            $table->index(['target_type', 'is_active']);
            $table->index(['discount_type', 'discount_value']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('promotions_simplified', function (Blueprint $table) {
            $table->dropColumn([
                'terms_conditions',
                'selected_user_types',
                'can_combine_with_other',
                'max_uses_per_order',
                'send_notification',
                'notification_message',
            ]);

            $table->dropIndex(['target_type', 'is_active']);
            $table->dropIndex(['discount_type', 'discount_value']);
        });
    }
};
