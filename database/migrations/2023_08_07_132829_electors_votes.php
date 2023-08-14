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
        Schema::create('electors_votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('elector_id')->nullable()->constrained();
            $table->foreignId('vote_id')->nullable()->constrained();
            $table->string('secret_code')->nullable();
            $table->date("creat_at")->default(now());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('electors_votes');
    }
};
