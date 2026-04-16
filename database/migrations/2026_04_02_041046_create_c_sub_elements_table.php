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
        Schema::create('c_sub_elements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('element_id')->constrained('c_elements')->cascadeOnDelete();
            $table->string('name');
            $table->decimal('weight', 5, 2)->default(0);
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('c_sub_elements');
    }
};
