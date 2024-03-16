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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->integer('purchase_id')->nullable();
            $table->integer('product_id')->nullable();
            $table->integer('branch_id')->nullable();
            $table->integer('purchase_qty')->nullable();
            $table->integer('sell_qty')->default(0);
            $table->decimal('purchase_price', 20, 2);
            $table->decimal('sell_price', 20, 2)->nullable();
            $table->boolean('is_active')->default(1)->comment("1=Active,0=Inactive");
            $table->boolean('is_deleted')->default(0)->comment("1=Active,0=Inactive");
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
        Schema::dropIfExists('stocks');
    }
};
