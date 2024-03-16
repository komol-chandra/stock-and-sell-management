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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(1)->comment("1=Active,0=Inactive");
            $table->boolean('is_deleted')->default(0)->comment("1=Active,0=Inactive");
            $table->string('invoice_id');
            $table->decimal('grand_total', 20, 2);
            $table->string('date');
            $table->text('note');
            $table->bigInteger('customer_id');
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
