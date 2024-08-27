<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateKintaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kintais', function (Blueprint $table) {
            $table->time('break_time_01')->nullable(true);
            $table->time('break_time_02')->nullable(true);
            $table->time('break_time_03')->nullable(true);
            $table->time('break_time_04')->nullable(true);
            $table->time('break_time_05')->nullable(true);
            $table->time('break_time_06')->nullable(true);
            $table->time('break_time_07')->nullable(true);
            $table->time('break_time_08')->nullable(true);
            $table->time('break_time_09')->nullable(true);
            $table->time('break_time_10')->nullable(true);
            $table->time('break_time_11')->nullable(true);
            $table->time('break_time_12')->nullable(true);
            $table->time('break_time_13')->nullable(true);
            $table->time('break_time_14')->nullable(true);
            $table->time('break_time_15')->nullable(true);
            $table->time('break_time_16')->nullable(true);
            $table->time('break_time_17')->nullable(true);
            $table->time('break_time_18')->nullable(true);
            $table->time('break_time_19')->nullable(true);
            $table->time('break_time_20')->nullable(true);
            $table->time('break_time_21')->nullable(true);
            $table->time('break_time_22')->nullable(true);
            $table->time('break_time_23')->nullable(true);
            $table->time('break_time_24')->nullable(true);
            $table->time('break_time_25')->nullable(true);
            $table->time('break_time_26')->nullable(true);
            $table->time('break_time_27')->nullable(true);
            $table->time('break_time_28')->nullable(true);
            $table->time('break_time_29')->nullable(true);
            $table->time('break_time_30')->nullable(true);
            $table->time('break_time_31')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kintais', function (Blueprint $table) {
            //
        });
    }
}
