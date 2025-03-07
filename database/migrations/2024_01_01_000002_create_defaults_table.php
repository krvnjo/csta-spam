<?php

use App\Models\Color;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('acquisitions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->unsignedTinyInteger('is_active')->default(1);
            $table->timestamps();
        });

        Schema::create('colors', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->string('class', 50)->unique();
            $table->unsignedTinyInteger('is_active')->default(1);
            $table->timestamps();
        });

        Schema::create('dashboards', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->string('description', 50)->unique();
            $table->unsignedTinyInteger('is_active')->default(1);
            $table->timestamps();
        });

        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->foreignIdFor(Color::class, 'badge_id')->constrained('colors')->cascadeOnDelete();
            $table->foreignIdFor(Color::class, 'legend_id')->constrained('colors')->cascadeOnDelete();
            $table->unsignedTinyInteger('is_active')->default(1);
            $table->timestamps();
        });

        Schema::create('progresses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->foreignIdFor(Color::class, 'badge_id')->constrained('colors')->cascadeOnDelete();
            $table->foreignIdFor(Color::class, 'legend_id')->constrained('colors')->cascadeOnDelete();
            $table->unsignedTinyInteger('is_active')->default(1);
            $table->timestamps();
        });

        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->unsignedTinyInteger('is_active')->default(1);
            $table->timestamps();
        });

        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->unsignedTinyInteger('is_active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
        Schema::dropIfExists('subjects');
        Schema::dropIfExists('progresses');
        Schema::dropIfExists('events');
        Schema::dropIfExists('dashboards');
        Schema::dropIfExists('colors');
        Schema::dropIfExists('acquisitions');
    }
};
