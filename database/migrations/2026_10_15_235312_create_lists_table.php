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
        Schema::create('lists', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->string('status', 32)->default('draft'); // 'draft', 'future', 'ready', 'active', 'checkout', 'done', 'archived'
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('shop_id')->nullable()->constrained('shops');
            $table->foreignId('shared_user_id')->nullable()->constrained('users'); // readonly, the shared user can only view the list. Set editable_if_shared to true to allow editing.
            $table->boolean('editable_if_shared')->default(false);
            $table->date('date_for_future')->nullable();
            $table->string('mode', 8)->default('simple'); // 'simple', 'advanced'
            $table->text('notes')->nullable();
            $table->foreignId('initial_owner_id')->nullable()->constrained('users'); // original owner if the list has been transferred to another user
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lists');
    }
};
