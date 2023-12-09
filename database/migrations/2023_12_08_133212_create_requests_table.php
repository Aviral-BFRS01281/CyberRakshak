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
        Schema::create("requests", function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string("url", 2000);
            $table->string("url_hash", 64)->generatedAs("sha1(url)")->index();
            $table->unsignedTinyInteger("score")->default(0);
            $table->softDeletes();
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
        Schema::dropIfExists("request_logs");
    }
};
