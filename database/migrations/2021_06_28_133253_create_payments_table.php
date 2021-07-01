<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('method_id')->unsigned()->nullable();
            $table->string('method_name')->nullable();
            $table->decimal('amount',18,8)->nullable();
            $table->string('currency')->nullable();
            $table->string('pm_type')->nullable();
            $table->string('trx')->nullable();
            $table->string('reciept_url')->nullable();
            $table->boolean('type')->nullable()->default(0)->comment("0=>Deposit,1=>Payment");
            $table->boolean('status')->default(0);

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
        Schema::dropIfExists('payments');
    }
}
