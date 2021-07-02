<?php

use App\Models\Plan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansTable extends Migration
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
            $table->string('name');
            $table->string('stripe_price');
            $table->decimal('price',18,8);
            $table->decimal('storage',18,8);
            $table->boolean('storage_unit')->default(Plan::GB);
            $table->boolean('storage_type')->default(Plan::LOCAL);
            $table->boolean('renewal_type')->nullable();
            $table->boolean('type')->default(Plan::LIFETIME);
            $table->boolean('withdrawal_type')->default(Plan::MONTHLY);

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
}
