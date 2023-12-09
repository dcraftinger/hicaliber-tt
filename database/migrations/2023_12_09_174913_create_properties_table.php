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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->unsignedBigInteger('price')->index();
            $table->tinyInteger('bedrooms')->index();
            $table->tinyInteger('bathrooms')->index();
            $table->tinyInteger('storeys')->index();
            $table->tinyInteger('garages')->index();
            $table->timestamps();

            $table->index(['name', 'price', 'bedrooms', 'bathrooms', 'storeys', 'garages'], 'property_search_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
