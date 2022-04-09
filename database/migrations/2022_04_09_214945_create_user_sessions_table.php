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
        Schema::connection('mysql_telcloud')
        ->create('user_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->uuid('app_uuid');
            $table->uuid('uuid');
            $table->ipAddress('ip');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_telcloud')
        ->dropIfExists('user_sessions');
    }
};
