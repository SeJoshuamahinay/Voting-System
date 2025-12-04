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
        Schema::create('voting_campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('category', ['school', 'community'])->default('school');
            $table->enum('status', ['draft', 'active', 'completed', 'cancelled'])->default('draft');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->boolean('allow_multiple_votes')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voting_campaigns');
    }
};
