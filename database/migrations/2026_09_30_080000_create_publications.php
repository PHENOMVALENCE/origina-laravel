<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('publications', function (Blueprint $t): void {
            $t->id();
            $t->string('title');
            $t->string('slug')->unique();
            $t->string('type');
            $t->text('summary');
            $t->longText('body');
            $t->string('status')->default('draft');
            $t->timestamp('published_at')->nullable()->index();
            $t->foreignId('editor_id')->constrained('users')->restrictOnDelete();
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('publications');
    }
};
