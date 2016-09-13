<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateForecastsColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('forecasts', function (Blueprint $table) {
            $table->string('daytime')->nullable()->change();
            $table->string('temperature')->nullable()->change();
            $table->string('condition')->nullable()->change();
            $table->string('pressure')->nullable()->change();
            $table->string('humidity')->nullable()->change();
            $table->string('windDirection')->nullable()->change();
            $table->string('windSpeed')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('forecasts', function (Blueprint $table) {
            $table->string('daytime')->change();
            $table->string('temperature')->change();
            $table->string('condition')->change();
            $table->string('pressure')->change();
            $table->string('humidity')->change();
            $table->string('windDirection')->change();
            $table->string('windSpeed')->change();
        });
    }
}
