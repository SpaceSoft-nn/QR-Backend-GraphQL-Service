<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->string('plan_name')->default("basic");


            $table->foreignUuid('personal_area_id')->index()
                ->constrained('personal_areas');

            $table->nullableUuidMorphs("subscriptionable");

            $table->date('expires_at')->nullable(); //устанавливаем дефолтное недостижмое время для стандартного Subscription

            $table->unsignedInteger('count_workspace')->default(5)->nullable()->comment("Устанавливаем счетчик для подсчета максимального количество workspace");
            $table->unsignedInteger('payment_limit')->default(50)->nullable()->comment("Устанавливаем счетчик для подсчета максимального количество оплат (транзакций)");

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
