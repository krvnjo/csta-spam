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
        Schema::create('colors', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->string('color_class', 100)->unique();
            $table->timestamps();
        });

        Schema::create('conditions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->text('description');
            $table->unsignedTinyInteger('is_active')->default(1)->index();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->text('description');
            $table->foreignIdFor(Color::class, 'color_id')->constrained('colors')->cascadeOnDelete();
            $table->unsignedTinyInteger('is_active')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('priorities', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->unsignedTinyInteger('is_active')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('priorities');
        Schema::dropIfExists('statuses');
        Schema::dropIfExists('conditions');
        Schema::dropIfExists('colors');
    }
};
