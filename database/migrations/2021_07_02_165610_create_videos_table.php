<?php

use App\Models\Plan;
use App\Models\Video;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('title', 50)->nullable();
            $table->string('thumbnail')->nullable();
            $table->text('description')->nullable();
            $table->string('path');
            $table->boolean('storage')->default(Plan::LOCAL);
            $table->boolean('status')->default(Video::ACTIVE);

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
        Schema::dropIfExists('videos');
    }
}
