<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table): void {
            $table->index(['user_id', 'created_at'], 'orders_user_created_idx');
            $table->index(['status', 'created_at'], 'orders_status_created_idx');
        });

        Schema::table('products', function (Blueprint $table): void {
            $table->index(['published', 'name'], 'products_published_name_idx');
        });

        Schema::table('enquiries', function (Blueprint $table): void {
            $table->index(['status', 'created_at'], 'enquiries_status_created_idx');
        });

        Schema::table('publications', function (Blueprint $table): void {
            $table->index(['status', 'published_at'], 'publications_status_published_idx');
        });

        Schema::table('verification_scans', function (Blueprint $table): void {
            $table->index('created_at', 'verification_scans_created_idx');
        });

        Schema::table('audit_logs', function (Blueprint $table): void {
            $table->index('created_at', 'audit_logs_created_idx');
        });
    }

    public function down(): void
    {
        Schema::table('audit_logs', function (Blueprint $table): void {
            $table->dropIndex('audit_logs_created_idx');
        });

        Schema::table('verification_scans', function (Blueprint $table): void {
            $table->dropIndex('verification_scans_created_idx');
        });

        Schema::table('publications', function (Blueprint $table): void {
            $table->dropIndex('publications_status_published_idx');
        });

        Schema::table('enquiries', function (Blueprint $table): void {
            $table->dropIndex('enquiries_status_created_idx');
        });

        Schema::table('products', function (Blueprint $table): void {
            $table->dropIndex('products_published_name_idx');
        });

        Schema::table('orders', function (Blueprint $table): void {
            $table->dropIndex('orders_user_created_idx');
            $table->dropIndex('orders_status_created_idx');
        });
    }
};
