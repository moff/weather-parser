<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDaysColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('days', function (Blueprint $table) {
            $table->string('sunset')->nullable()->change();
            $table->string('sunrise')->nullable()->change();
            $table->string('moon')->nullable()->change();
            $table->string('geomagnetic')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('days', function (Blueprint $table) {
            $table->string('sunset')->change();
            $table->string('sunrise')->change();
            $table->string('moon')->change();
            $table->string('geomagnetic')->change();
        });
    }
}
