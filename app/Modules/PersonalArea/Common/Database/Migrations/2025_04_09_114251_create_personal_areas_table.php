<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('personal_areas', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->foreignUuid('owner_id')
                ->constrained('users');

            $table->foreignUuid('subscription_id')
                ->constrained('subscriptions');

            $table->foreignUuid('balance')
                ->constrained('subscriptions');

            $table->timestamps();

        });
    }


    public function down(): void
    {
        Schema::dropIfExists('personal_areas');
    }
};
