<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->string('age_rating')->default('PG-13')->after('duration');
            $table->enum('audience_type', ['adult', 'kids'])->default('adult')->after('age_rating');
            $table->decimal('rating_value', 3, 1)->default(0.0)->after('audience_type');
        });

        // Many-to-Many Bridge
        Schema::create('category_movie', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movie_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        // Migrate existing single categories to the pivot table
        $movies = DB::table('movies')->whereNotNull('category_id')->get();
        foreach ($movies as $movie) {
            DB::table('category_movie')->insert([
                'movie_id' => $movie->id,
                'category_id' => $movie->category_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('category_movie');
        Schema::table('movies', function (Blueprint $table) {
            $table->dropColumn(['age_rating', 'audience_type', 'rating_value']);
        });
    }
};
