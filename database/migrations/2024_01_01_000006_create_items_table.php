<?php

use App\Models\Acquisition;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Department;
use App\Models\Designation;
use App\Models\PropertyConsumable;
use App\Models\PropertyParent;
use App\Models\Status;
use App\Models\Subcategory;
use App\Models\Unit;
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
            $table->string('specification')->nullable();
            $table->string('description')->nullable();
            $table->string('image')->nullable()->default('default.jpg');
            $table->unsignedInteger('quantity')->default(1);
            $table->foreignIdFor(Brand::class, 'brand_id')->nullable()->constrained('brands')->cascadeOnDelete();
            $table->foreignIdFor(Category::class, 'categ_id')->nullable()->constrained('subcategories')->cascadeOnDelete();
            $table->decimal('purchase_price', 15, 2)->nullable();
            $table->decimal('residual_value', 15, 2)->nullable();
            $table->unsignedInteger('useful_life')->nullable();
            $table->foreignIdFor(Unit::class, 'unit_id')->nullable()->constrained('units')->cascadeOnDelete();
            $table->boolean('is_consumable')->default(0);
            $table->unsignedTinyInteger('is_active')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('property_children', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(PropertyParent::class, 'prop_id')->constrained('property_parents')->cascadeOnDelete();
            $table->string('prop_code', 100)->unique();
            $table->string('serial_num', 100)->nullable()->unique();
            $table->foreignIdFor(Acquisition::class, 'type_id')->nullable()->constrained('acquisitions')->cascadeOnDelete();
            $table->date('acq_date')->nullable();
            $table->date('warranty_date')->nullable();
            $table->date('stock_date')->nullable();
            $table->date('inventory_date')->nullable();
            $table->foreignIdFor(Department::class, 'dept_id')->nullable()->constrained('departments')->cascadeOnDelete();
            $table->foreignIdFor(Designation::class, 'desig_id')->nullable()->constrained('designations')->cascadeOnDelete();
            $table->foreignIdFor(Condition::class, 'condi_id')->nullable()->constrained('conditions')->cascadeOnDelete();
            $table->foreignIdFor(Status::class, 'status_id')->nullable()->constrained('statuses')->cascadeOnDelete();
            $table->string('remarks')->nullable();
            $table->unsignedTinyInteger('is_active')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

//        Schema::create('consumption_logs', function (Blueprint $table) {
//            $table->id();
//            $table->string('transaction_number')->unique();
//            $table->foreignIdFor(PropertyConsumable::class, 'consume_id')->constrained('property_consumables')->cascadeOnDelete();
//            $table->string('consumed_by', 255);
//            $table->foreignIdFor(Department::class, 'dept_id')->constrained('departments')->cascadeOnDelete();
//            $table->unsignedInteger('quantity_consumed');
//            $table->date('consumed_at');
//            $table->string('purpose', 255)->nullable();
//            $table->string('remarks', 255)->nullable();
//            $table->timestamps();
//            $table->softDeletes();
//        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consumption_logs');
        Schema::dropIfExists('property_consumables');
        Schema::dropIfExists('property_children');
        Schema::dropIfExists('property_parents');
    }
};
