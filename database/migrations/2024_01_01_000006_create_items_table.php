<?php

use App\Models\Acquisition;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Department;
use App\Models\Designation;
use App\Models\PropertyParent;
use App\Models\Status;
use App\Models\Subcategory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('property_parents', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->unique();
            $table->foreignIdFor(Brand::class, 'brand_id')->constrained('brands')->cascadeOnDelete();
            $table->foreignIdFor(Category::class, 'categ_id')->nullable()->constrained('categories')->cascadeOnDelete();
            $table->foreignIdFor(Subcategory::class, 'subcateg_id')->constrained('subcategories')->cascadeOnDelete();
            $table->string('description')->nullable();
            $table->string('image')->nullable()->default('default.jpg');
            $table->unsignedInteger('quantity')->default(1);
            $table->unsignedTinyInteger('is_active')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('property_children', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(PropertyParent::class, 'prop_id')->constrained('property_parents')->cascadeOnDelete();
            $table->string('prop_code', 100)->unique();
            $table->string('serial_num', 100)->nullable()->unique();
            $table->foreignIdFor(Acquisition::class, 'type_id')->constrained('acquisitions')->cascadeOnDelete();
            $table->date('acq_date')->nullable();
            $table->date('warranty_date')->nullable();
            $table->date('stock_date');
            $table->date('inventory_date')->nullable();
            $table->foreignIdFor(Department::class, 'dept_id')->constrained('departments')->cascadeOnDelete();
            $table->foreignIdFor(Designation::class, 'desig_id')->constrained('designations')->cascadeOnDelete();
            $table->foreignIdFor(Condition::class, 'condi_id')->constrained('conditions')->cascadeOnDelete();
            $table->foreignIdFor(Status::class, 'status_id')->constrained('statuses')->cascadeOnDelete();
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('property_children');
        Schema::dropIfExists('property_parents');
    }
};
