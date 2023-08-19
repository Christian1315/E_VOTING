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
        Schema::create('rights', function (Blueprint $table) {
            $table->id();
            $table->integer("module")->default(0);

            $table->foreignId("action")
                ->nullable()
                ->constrained('actions', 'id')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->foreignId("rang")
                ->nullable()
                ->constrained('rangs', 'id')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->foreignId("profil")
                ->nullable()
                ->constrained('profils', 'id')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->foreignId("user_id")
                ->nullable()
                ->constrained('users', 'id')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->text("description");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rights');
    }
};
