<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('email')->unique();
            $t->timestamp('email_verified_at')->nullable();
            $t->string('password');
            $t->string('role')->default('customer')->index();
            $t->boolean('active')->default(true);
            $t->rememberToken();
            $t->timestamps();
        });
        Schema::create('password_reset_tokens', function (Blueprint $t) {
            $t->string('email')->primary();
            $t->string('token');
            $t->timestamp('created_at')->nullable();
        });
        Schema::create('products', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('slug')->unique();
            $t->string('sku')->unique();
            $t->string('division')->index();
            $t->text('description');
            $t->text('ingredients')->nullable();
            $t->text('usage')->nullable();
            $t->text('evidence_note')->nullable();
            $t->string('image_path')->nullable();
            $t->unsignedBigInteger('price');
            $t->unsignedInteger('stock')->default(0);
            $t->boolean('published')->default(false)->index();
            $t->timestamps();
        });
        Schema::create('orders', function (Blueprint $t) {
            $t->id();
            $t->uuid('number')->unique();
            $t->foreignId('user_id')->constrained()->restrictOnDelete();
            $t->string('checkout_key')->unique();
            $t->string('status')->default('pending')->index();
            $t->string('payment_status')->default('unpaid')->index();
            $t->string('payment_reference')->nullable()->unique();
            $t->unsignedBigInteger('subtotal');
            $t->unsignedBigInteger('shipping_fee');
            $t->unsignedBigInteger('total');
            $t->string('currency', 3)->default('TZS');
            $t->json('shipping_address');
            $t->text('notes')->nullable();
            $t->string('tracking_reference')->nullable();
            $t->timestamp('paid_at')->nullable();
            $t->timestamps();
        });
        Schema::create('order_items', function (Blueprint $t) {
            $t->id();
            $t->foreignId('order_id')->constrained()->cascadeOnDelete();
            $t->foreignId('product_id')->constrained()->restrictOnDelete();
            $t->string('name');
            $t->string('sku');
            $t->unsignedInteger('quantity');
            $t->unsignedBigInteger('unit_price');
            $t->timestamps();
        });
        Schema::create('enquiries', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('email');
            $t->string('topic');
            $t->text('message');
            $t->string('status')->default('new')->index();
            $t->timestamp('consented_at');
            $t->timestamps();
        });
        Schema::create('manufacturing_batches', function (Blueprint $t) {
            $t->id();
            $t->foreignId('product_id')->constrained()->restrictOnDelete();
            $t->string('code')->unique();
            $t->date('manufactured_on');
            $t->date('expires_on')->nullable();
            $t->string('status')->default('draft');
            $t->text('quality_notes')->nullable();
            $t->timestamps();
        });
        Schema::create('product_units', function (Blueprint $t) {
            $t->id();
            $t->foreignId('manufacturing_batch_id')->constrained()->restrictOnDelete();
            $t->string('serial')->unique();
            $t->string('verification_token', 64)->unique();
            $t->string('status')->default('created')->index();
            $t->timestamps();
        });
        Schema::create('verification_scans', function (Blueprint $t) {
            $t->id();
            $t->foreignId('product_unit_id')->constrained()->cascadeOnDelete();
            $t->string('visitor_hash', 64);
            $t->timestamps();
        });
        Schema::create('audit_logs', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $t->string('action')->index();
            $t->string('subject_type');
            $t->unsignedBigInteger('subject_id')->nullable();
            $t->json('changes')->nullable();
            $t->timestamps();
        });
    }

    public function down(): void
    {
        foreach (['audit_logs', 'verification_scans', 'product_units', 'manufacturing_batches', 'enquiries', 'order_items', 'orders', 'products', 'password_reset_tokens', 'users'] as $table) {
            Schema::dropIfExists($table);
        }
    }
};
