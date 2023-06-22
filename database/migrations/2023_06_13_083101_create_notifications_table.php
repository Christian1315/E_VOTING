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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('sender_id')
            ->nullable()
            ->constrained(table: 'users')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreignId('receiver_id')
                ->nullable()->constrained(table: 'users')
                ->onUpdate('cascade')
                ->onDelete('cascade');


            $table->longText('message');
            $table->boolean('is_viewed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};