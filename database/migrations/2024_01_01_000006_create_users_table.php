<?php

use App\Models\Access;
use App\Models\Dashboard;
use App\Models\Department;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('accesses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->string('description', 100)->unique();
            $table->unsignedTinyInteger('is_active')->default(1);
            $table->timestamps();
        });

        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->string('group', 50);
            $table->unsignedTinyInteger('is_active')->default(1);
            $table->timestamps();
        });

        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->string('description', 100)->unique();
            $table->foreignIdFor(Dashboard::class, 'dash_id')->default(2)->constrained('dashboards')->cascadeOnDelete();
            $table->unsignedTinyInteger('is_active')->default(1);
            $table->timestamps();
        });

        Schema::create('role_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Role::class, 'role_id')->constrained('roles')->cascadeOnDelete();
            $table->foreignIdFor(Permission::class, 'perm_id')->constrained('permissions')->cascadeOnDelete();
            $table->foreignIdFor(Access::class, 'access_id')->constrained('accesses')->cascadeOnDelete();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user_name', 25)->unique();
            $table->string('pass_hash');
            $table->string('name', 150);
            $table->string('lname', 75);
            $table->string('fname', 75);
            $table->string('mname', 75)->nullable();
            $table->foreignIdFor(Role::class, 'role_id')->constrained('roles')->cascadeOnDelete();
            $table->foreignIdFor(Department::class, 'dept_id')->constrained('departments')->cascadeOnDelete();
            $table->string('email', 75)->unique();
            $table->string('phone_num', 25)->unique()->nullable();
            $table->timestamp('last_login')->nullable();
            $table->string('user_image', 25)->default('default.jpg');
            $table->unsignedTinyInteger('is_active')->default(1);
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
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
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
        Schema::dropIfExists('role_permissions');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('accesses');
    }
};
