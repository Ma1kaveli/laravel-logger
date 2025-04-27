<?php

namespace Logger\Database\Migrations;

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
        Schema::create('logs.logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('created_by')->index()->nullable()->comment('Who create');
            $table->foreignId('action_log_id')->index()->comment('Action Log');

            $table->text('error_description')->nullable()->comment('This field need if app catch exception');
            $table->text('description');

            $table->boolean('is_error')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs.logs');
    }
};
