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
        Schema::create('request_piis', function (Blueprint $table) {
            $table->string("request_id", 50)->index();
            $table->tinyInteger("name");
            $table->tinyInteger("email");
            $table->tinyInteger("mobile");
            $table->tinyInteger("awb");
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
        Schema::dropIfExists('request_piis');
    }
};
