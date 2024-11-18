<?php

use App\Models\MaintenanceTicket;
use App\Models\Progress;
use App\Models\PropertyChild;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('maintenance_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_num', 15)->unique();
            $table->string('name', 50)->unique();
            $table->text('description');
            $table->decimal('cost', 15)->nullable();
            $table->foreignIdFor(Progress::class, 'prog_id')->constrained('progresses')->cascadeOnDelete();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });

        Schema::create('maintenance_ticket_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(MaintenanceTicket::class, 'ticket_id')->constrained('maintenance_tickets')->cascadeOnDelete();
            $table->foreignIdFor(PropertyChild::class, 'item_id')->constrained('property_children')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_ticket_items');
        Schema::dropIfExists('maintenance_tickets');
    }
};
