<?php

use App\Models\Brand;
use App\Models\Category;
use App\Models\Subcategory;
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
        Schema::create('acquisitions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->unsignedTinyInteger('is_active')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->unsignedTinyInteger('is_active')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->unsignedTinyInteger('is_active')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('subcategories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->foreignIdFor(Category::class, 'categ_id')->constrained('categories')->cascadeOnDelete();
            $table->unsignedTinyInteger('is_active')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('brand_category', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Brand::class, 'brand_id')->constrained('brands')->cascadeOnDelete();
            $table->foreignIdFor(Subcategory::class, 'subcateg_id')->constrained('subcategories')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('category_subcategory', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Category::class, 'categ_id')->constrained('categories')->cascadeOnDelete();
            $table->foreignIdFor(Subcategory::class, 'subcateg_id')->constrained('subcategories')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_subcategory');
        Schema::dropIfExists('brand_category');
        Schema::dropIfExists('subcategories');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('brands');
        Schema::dropIfExists('acquisitions');
    }
};
