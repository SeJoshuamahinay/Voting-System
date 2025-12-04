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
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('voting_campaign_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('position');
            $table->string('party_list')->nullable();
            $table->text('description')->nullable();
            $table->string('photo')->nullable();
            $table->integer('vote_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidates');
    }
};
