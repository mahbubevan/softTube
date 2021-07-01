<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvertisersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertisers', function (Blueprint $table) {
            $table->id();
            $table->longText('advertiser_info')->default("{}");
            $table->string('add_size',191)->default("300x300");
            $table->string('add_type',191)->nullable();
            $table->string('image')->nullable();
            $table->string('redirect_url')->nullable();
            $table->string('script')->nullable();
            $table->integer('impression')->default(0);
            $table->integer('click')->default(0);
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
        Schema::dropIfExists('advertisers');
    }
}
