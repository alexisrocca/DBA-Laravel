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
        Schema::dropIfExists('reminders');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('reminders', function (Blueprint $table) {
            $table->id();
            $table->morphs('remindable');
            $table->timestamp('remind_at');
            $table->string('method');
            $table->boolean('sent')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
