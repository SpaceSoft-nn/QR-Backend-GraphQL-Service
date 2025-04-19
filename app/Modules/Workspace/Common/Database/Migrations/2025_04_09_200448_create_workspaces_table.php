<?php

use App\Modules\Payment\Domain\Models\Payment;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        Schema::create('workspaces', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->foreignId('user_organization_id')->index()
                ->constrained('user_organization')->noActionOnDelete(); // делается для того, что бы знать какая организация и user в этой орагнизации создали workspace

            $table->string('name', 255)->unique()->index()->comment('Название workspace');
            $table->text('description')->nullable();
            $table->boolean('is_active');


            $table->foreignUuid('payment_method_id')->index()
                ->nullable()->constrained('payment_methods')->comment('Какую платежную систему использует workspace');

            $table->timestamps();

        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workspaces');
    }



};
