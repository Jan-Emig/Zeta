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
            ->table('user_sessions', function(Blueprint $table) {
                $table->string('token', 64);
                $table->dropColumn('uuid');
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
            ->table('user_sessions', function(Blueprint $table) {
                $table->dropColumn('token');
                $table->uuid('uuid');
            });
    }
};
