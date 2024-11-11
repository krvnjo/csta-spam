<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection(config('activitylog.database_connection'))->create(
            config('activitylog.table_name'),
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('log_name')->nullable();
                $table->text('description');
                $table->nullableMorphs('subject', 'subject');
                $table->nullableMorphs('causer', 'causer');
                $table->json('properties')->nullable();
                $table->timestamps();
                $table->index('log_name');
            },
        );

        Schema::connection(config('activitylog.database_connection'))->table(
            config('activitylog.table_name'),
            function (Blueprint $table) {
                $table->string('event')->nullable()->after('subject_type');
            },
        );

        Schema::connection(config('activitylog.database_connection'))->table(
            config('activitylog.table_name'),
            function (Blueprint $table) {
                $table->string('batch_uuid')->nullable()->after('properties');
            },
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection(config('activitylog.database_connection'))->dropIfExists(config('activitylog.table_name'));
        Schema::connection(config('activitylog.database_connection'))->table(
            config('activitylog.table_name'),
            function (Blueprint $table) {
                $table->dropColumn('batch_uuid');
            },
        );
        Schema::connection(config('activitylog.database_connection'))->table(
            config('activitylog.table_name'),
            function (Blueprint $table) {
                $table->dropColumn('event');
            },
        );
    }
};
