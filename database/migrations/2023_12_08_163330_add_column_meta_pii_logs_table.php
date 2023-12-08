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
        //
        Schema::table('pii_logs', function($table) {
            $table->json('meta')->comment('Extra pii Data');
            $table->ipAddress('ip_address');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('pii_logs', function($table) {
            $table->dropColumn('meta');
            $table->dropColumn('ip_address');
        });
    }
};
