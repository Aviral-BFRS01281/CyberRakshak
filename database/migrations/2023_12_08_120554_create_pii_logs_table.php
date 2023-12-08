<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() : void
    {
        Schema::create("pii_logs", function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->unsignedBigInteger("user_id")->index();
            $table->unsignedDouble("score");
            $table->json("meta");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() : void
    {
        Schema::dropIfExists("pii_logs");
    }
};
