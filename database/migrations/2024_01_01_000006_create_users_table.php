<?php

use App\Models\Department;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user_name', 20)->unique();
            $table->string('pass_hash');
            $table->string('lname', 75);
            $table->string('fname', 75);
            $table->string('mname', 75)->nullable();
            $table->foreignIdFor(Department::class, 'dept_id')->constrained('departments')->cascadeOnDelete();
            $table->string('email')->unique();
            $table->string('phone_num', 20)->unique()->nullable();
            $table->string('user_image')->default('default.jpg');
            $table->timestamp('last_login')->nullable();
            $table->unsignedTinyInteger('is_active')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('users');
    }
};
