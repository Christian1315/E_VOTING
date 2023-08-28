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
            $table->string('name');

            $table->foreignId('organisation')
                ->nullable()
                ->constrained("organisations", "id")
                ->onUpdate("CASCADE")
                ->onDelete("CASCADE");

            $table->foreignId('status')
                ->nullable()
                ->constrained("vote_statuses", "id")
                ->onUpdate("CASCADE")
                ->onDelete("CASCADE");

            $table->foreignId('owner')
                ->nullable()
                ->constrained("users", "id")
                ->onUpdate("CASCADE")
                ->onDelete("CASCADE");

            $table->string('start_vote')->nullable();
            $table->string('end_vote')->nullable();

            $table->boolean("visible")->default(true);
            $table->string("deleted_at")->nullable();
            $table->timestamps();
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
