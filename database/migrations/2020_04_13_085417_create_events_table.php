<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('desc')->nullable();
            $table->dateTime('begin');
            $table->dateTime('end');
            $table->string('location')->nullable();
            $table->string('link')->nullable();
            $table->unsignedBigInteger('association_id');
            $table->timestamps();

            $table->foreign('association_id')->references('id')->on('associations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
