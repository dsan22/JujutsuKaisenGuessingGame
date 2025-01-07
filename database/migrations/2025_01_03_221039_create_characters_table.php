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
        Schema::create('characters', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('is_alive');
            $table->foreignId('arc_id')->constrained();
            $table->foreignId('grade_id')->constrained();
            $table->boolean('have_domain_expansion');
            $table->boolean('have_reverse_cursed_technique');
            $table->boolean('used_black_flash');
            $table->enum('gender',["female","male"]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('characters');
    }
};
