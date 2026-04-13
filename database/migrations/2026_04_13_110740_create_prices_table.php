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
        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('field_id')->constrained()->cascadeOnDelete();
            $table->enum('day_of_week', [
                'monday',
                'tuesday',
                'wednesday',
                'thursday',
                'friday',
                'saturday',
                'sunday',
            ]);
            $table->decimal('price', 8, 2);
            $table->timestamps();

            $table->unique(['field_id', 'day_of_week']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('field_prices');
    }
};
