<?php

use App\Models\Borrowing;
use App\Models\BorrowingProgress;
use App\Models\PropertyChild;
use App\Models\PropertyParent;
use App\Models\Requester;
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
        Schema::create('borrowings', function (Blueprint $table) {
            $table->id();
            $table->string('borrow_num')->unique();
            $table->foreignIdFor(Requester::class, 'requester_id')->constrained('requesters')->cascadeOnDelete();
            $table->string('status')->default('pending');
            $table->text('remarks')->nullable();
            $table->date('borrow_date')->nullable();
            $table->timestamps();
        });

        Schema::create('request_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Borrowing::class, 'borrow_id')->constrained('borrowings')->cascadeOnDelete();
            $table->foreignIdFor(PropertyParent::class, 'parent_id')->nullable()->constrained('property_parents')->cascadeOnDelete();
            $table->foreignIdFor(PropertyChild::class, 'child_id')->nullable()->constrained('property_children')->cascadeOnDelete();
            $table->unsignedInteger('quantity')->nullable();
            $table->boolean('is_consumable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_items');
        Schema::dropIfExists('borrowings');
    }
};
