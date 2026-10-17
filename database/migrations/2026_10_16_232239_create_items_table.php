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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->boolean('is_priority')->default(false);
            $table->text('note')->nullable();
            $table->foreignId('list_id')->constrained('lists');
            $table->foreignId('category_id')->nullable()->constrained('categories');
            $table->string('status', 8)->default('idle'); // 'idle', 'in_cart', 'deferred', 'canceled', 'bought'
            $table->integer('quantity')->nullable();
            $table->decimal('weight', 6, 3)->nullable(); // kg
            $table->decimal('estimated_price', 14, 2)->nullable();
            $table->decimal('price', 14, 2)->nullable();
            $table->string('currency', 3)->nullable();
            $table->string('photo_path')->nullable();
            $table->boolean('is_unplanned')->default(false);
            $table->boolean('is_added_by_other_user')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
