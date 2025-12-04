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
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('voting_campaign_id')->constrained()->onDelete('cascade');
            $table->foreignId('candidate_id')->constrained()->onDelete('cascade');
            $table->timestamp('voted_at');
            $table->timestamps();
            
            // Ensure one vote per user per campaign (unless multiple votes allowed)
            $table->unique(['user_id', 'voting_campaign_id', 'candidate_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('votes');
    }
};
