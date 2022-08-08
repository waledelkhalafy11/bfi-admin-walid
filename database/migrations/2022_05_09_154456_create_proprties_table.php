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
        Schema::create('proprties', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('unit_id')->unique();
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedInteger('kitchen')->nullable();
            $table->unsignedInteger('bedroom')->nullable();
            $table->unsignedInteger('rooms')->nullable();
            $table->unsignedInteger('living_room')->nullable();
            $table->unsignedInteger('bathroom')->nullable();
            $table->unsignedInteger('garage')->nullable();
            $table->unsignedInteger('garden')->nullable();
            $table->unsignedInteger('elevator')->nullable();
            $table->unsignedInteger('floor')->nullable();
            $table->unsignedInteger('pool')->nullable();
            $table->unsignedInteger('surface_area')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proprties');
    }
};
