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
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('unit_name');
            $table->text('unit_address');
            $table->text('unit_description');
            $table->string('unit_longitude');
            $table->string('unit_latitude');
            $table->unsignedBigInteger('unit_price');
            $table->unsignedBigInteger('dist_id');
            $table->foreign('dist_id')->references('id')->on('districts')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('main_category', array('Residential','Commercial','Administration','Medical'));
            $table->enum('unit_category', array('Appartment','Villa','Sahel'))->nullable();
            $table->enum('res_unit_category', array('Standalone','Twin House','Town House','Duplex', 'Penthouse', 'Appartment','Chalets','Loft' , 'One Story'))->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('units');
    }
};
