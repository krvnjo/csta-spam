<?php

use App\Models\ItemTransaction;
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
        Schema::create('item_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_num')->unique();
            $table->foreignIdFor(Requester::class, 'requester_id')->constrained('requesters')->cascadeOnDelete();
            $table->string('received_by')->nullable();
            $table->text('remarks')->nullable();
            $table->date('transaction_date');
            $table->timestamps();
        });

        Schema::create('transaction_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ItemTransaction::class, 'transaction_id')->constrained('item_transactions')->cascadeOnDelete();
            $table->foreignIdFor(PropertyParent::class, 'parent_id')->nullable()->constrained('property_parents')->cascadeOnDelete();
            $table->unsignedInteger('quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_items');
        Schema::dropIfExists('item_transactions');
    }
};
