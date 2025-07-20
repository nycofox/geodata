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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('version')->default(1);
            // ISO identifiers
            $table->string('cca2', 2)->unique();
            $table->string('cca3', 3)->unique();
            $table->string('cioc')->nullable();        // Olympic code
            // Names & translations
            $table->string('name_common');
            $table->string('name_official');
            $table->json('translations')->nullable(); // { "es": "España", "fr": "Espagne", … }
            // Geometry
            $table->decimal('latitude', 10, 6)->nullable();
            $table->decimal('longitude', 10, 6)->nullable();
            $table->json('bbox')->nullable();          // GeoJSON bbox
            $table->float('area_km2')->nullable();  // Total area in square kilometers
            $table->json('borders')->nullable();      // [ "FR", "DE", … ] or GeoJSON MultiPolygon
            $table->string('region')->nullable();      // e.g. "Europe", "Asia"
            $table->string('subregion')->nullable();  // e.g. "Southern Europe", "Southeast Asia"
            // Demographics & economics
            $table->unsignedBigInteger('population')->nullable();
            $table->json('currencies')->nullable();   // [{ code, name, symbol }, …]
            $table->json('languages')->nullable();    // [{ code, name_native, name_en }, …]
            $table->json('demonyms')->nullable(); // { "eng": "Spanish", "fra": "Espagnol", … }
            // Misc
            $table->json('calling_codes')->nullable();  // ["+34", …]
            $table->json('timezones')->nullable();      // ["Europe/Madrid", …]
            $table->string('flag_emoji')->nullable();
            $table->string('flag_svg_url')->nullable();
            // External references
            $table->string('geonames_id')->nullable(); // Geonames ID
            $table->timestamp('geonames_updated_at')->nullable(); // Last update timestamp from Geonames

            $table->timestamp('rest_countries_updated_at')->nullable(); // Last update timestamp from REST Countries API

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
