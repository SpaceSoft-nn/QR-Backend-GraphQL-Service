<?php

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
        Schema::create('user_workspaces', function (Blueprint $table) {

            $table->id();

            $table->foreignUuid('user_id')
                ->constrained('users')->noActionOnDelete();


            $table->foreignUuid('workspace_id')
                ->constrained('workspaces')->noActionOnDelete();

            $table->boolean('active_user')->default(false)->comment('Активен ли user в работе в workspace');
            $table->boolean('is_owner')->default(false)->comment('Является ли user создателем workspace');


            $table->unique(['user_id', 'workspace_id']);

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_workspace');
    }
};
