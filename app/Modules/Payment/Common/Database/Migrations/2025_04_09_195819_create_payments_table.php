<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->boolean('status');

            $table->uuid('number_uuid')->comment('номер payment');
            $table->uuid('name')->nullable()->comment('название платежного метода');

            $table->string('driver')->nullable()->comment('название драйвера для удобности');


            $table->foreignUuid('method_id')
                ->constrained('payment_methods')->noActionOnDelete(); //способ оплаты у платежа QIWI, YOUCASSA, PAYPAL, BITCOIN


            $table->timestamps();

        });
    }


    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
