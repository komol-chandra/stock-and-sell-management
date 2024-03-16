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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(1)->comment("1=Active,0=Inactive");
            $table->boolean('is_deleted')->default(0)->comment("1=Active,0=Inactive");
            $table->string('date');
            $table->string('invoice_id');
            $table->integer('supplier_id');
            $table->decimal('transportation_cost', 8, 2);
            $table->decimal('grand_total', 20, 2);
            $table->text('note')->nullable();
            $table->integer("created_by")->nullable();
            $table->integer("updated_by")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
