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
        Schema::create('hero_cards', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('card_title');
            $table->string('card_desciption');
            $table->unsignedBigInteger('icon_id');
            $table->foreign('icon_id')->references('id')->on('card_icons');
            $table->string('element_id_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hero_cards');
    }
};
