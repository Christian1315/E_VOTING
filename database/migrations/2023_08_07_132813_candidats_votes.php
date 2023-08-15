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
        Schema::create('candidats_votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidat_id')->nullable()->constrained();
            $table->foreignId('vote_id')->nullable()->constrained();
            $table->integer('score')->default(0);
            $table->date('creat_at')->default(now());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidats_votes');
    }
};
