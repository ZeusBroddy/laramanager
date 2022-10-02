<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['active', 'archived'])->default('active');
            $table->enum('type', ['fixed', 'metered'])->default('fixed');
            $table->string('name');
            $table->string('stripe_plan_id')->nullable();
            $table->string('stripe_product_id')->nullable();
            $table->text('description')->nullable();
            $table->decimal('amount')->nullable();
            $table->text('currency');
            $table->enum('interval', ['day', 'week', 'month', 'quarter', 'year'])->default('month');
            $table->boolean('visible')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plans');
    }
};
