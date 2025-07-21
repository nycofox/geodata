<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('version')->default(1);
            $table->foreignId('country_id')
                ->index()
                ->constrained('countries')
                ->cascadeOnDelete();

            // Names & translations
            $table->string('name');
            $table->string('name_native')->nullable();
            $table->json('translations')->nullable(); // { "es": "Madrid", "fr": "Madrid", … }

            // Geospatial
            $table->decimal('latitude', 10, 6)->nullable(); // Redundant for easier queries
            $table->decimal('longitude', 10, 6)->nullable(); // Redundant for easier queries
            $table->json('bbox')->nullable();           // GeoJSON bbox

            $table->unsignedBigInteger('population')->nullable();
            $table->unsignedInteger('elevation_m')->nullable();

            $table->string('timezone')->nullable();      // ["Europe/Berlin"]

            // Admin hierarchy (could be normalized later)
            $table->string('admin1')->nullable();       // state/province
            $table->string('admin2')->nullable();       // county/district
            $table->string('admin3')->nullable();

            // External references
            $table->string('geonames_id')->index()->nullable();
            $table->timestamp('geonames_updated_at')->nullable(); // Last update timestamp
            $table->string('wikidata_id')->index()->nullable();
            $table->timestamp('wikidata_updated_at')->nullable();
            $table->string('wikipedia_url')->nullable();
            $table->string('openstreetmap_place_id')->index()->nullable();
            $table->timestamp('openstreetmap_updated_at')->nullable(); // Last update timestamp

            $table->json('properties')->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->unique(['country_id', 'name']);
        });

        // Add capital id to countries table
        Schema::table('countries', function (Blueprint $table) {
            $table->foreignId('capital_city_id')->nullable()->constrained('cities');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove capital id from countries table
        Schema::table('countries', function (Blueprint $table) {
            $table->dropForeign(['capital_city_id']);
            $table->dropColumn('capital_city_id');
        });
        Schema::dropIfExists('cities');
    }
};
