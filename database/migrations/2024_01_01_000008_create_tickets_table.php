<?php

use App\Models\Priority;
use App\Models\Progress;
use App\Models\PropertyChild;
use App\Models\Ticket;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('name', 20)->unique();
            $table->text('description');
            $table->decimal('total_cost', 15)->nullable();
            $table->foreignIdFor(Priority::class, 'prio_id')->constrained('priorities')->cascadeOnDelete();
            $table->foreignIdFor(Progress::class, 'prog_id')->constrained('progresses')->cascadeOnDelete();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });

        Schema::create('ticket_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Ticket::class, 'ticket_id')->constrained('tickets')->cascadeOnDelete();
            $table->foreignIdFor(PropertyChild::class, 'item_id')->constrained('property_children')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_items');
        Schema::dropIfExists('tickets');
    }
};
