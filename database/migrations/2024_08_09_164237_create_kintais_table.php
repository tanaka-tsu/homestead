<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKintaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kintais', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->date('this_month');
            $table->datetime('work_start_01')->nullable(true);
            $table->datetime('work_start_02')->nullable(true);
            $table->datetime('work_start_03')->nullable(true);
            $table->datetime('work_start_04')->nullable(true);
            $table->datetime('work_start_05')->nullable(true);
            $table->datetime('work_start_06')->nullable(true);
            $table->datetime('work_start_07')->nullable(true);
            $table->datetime('work_start_08')->nullable(true);
            $table->datetime('work_start_09')->nullable(true);
            $table->datetime('work_start_10')->nullable(true);
            $table->datetime('work_start_11')->nullable(true);
            $table->datetime('work_start_12')->nullable(true);
            $table->datetime('work_start_13')->nullable(true);
            $table->datetime('work_start_14')->nullable(true);
            $table->datetime('work_start_15')->nullable(true);
            $table->datetime('work_start_16')->nullable(true);
            $table->datetime('work_start_17')->nullable(true);
            $table->datetime('work_start_18')->nullable(true);
            $table->datetime('work_start_19')->nullable(true);
            $table->datetime('work_start_20')->nullable(true);
            $table->datetime('work_start_21')->nullable(true);
            $table->datetime('work_start_22')->nullable(true);
            $table->datetime('work_start_23')->nullable(true);
            $table->datetime('work_start_24')->nullable(true);
            $table->datetime('work_start_25')->nullable(true);
            $table->datetime('work_start_26')->nullable(true);
            $table->datetime('work_start_27')->nullable(true);
            $table->datetime('work_start_28')->nullable(true);
            $table->datetime('work_start_29')->nullable(true);
            $table->datetime('work_start_30')->nullable(true);
            $table->datetime('work_start_31')->nullable(true);
            $table->datetime('work_end_01')->nullable(true);
            $table->datetime('work_end_02')->nullable(true);
            $table->datetime('work_end_03')->nullable(true);
            $table->datetime('work_end_04')->nullable(true);
            $table->datetime('work_end_05')->nullable(true);
            $table->datetime('work_end_06')->nullable(true);
            $table->datetime('work_end_07')->nullable(true);
            $table->datetime('work_end_08')->nullable(true);
            $table->datetime('work_end_09')->nullable(true);
            $table->datetime('work_end_10')->nullable(true);
            $table->datetime('work_end_11')->nullable(true);
            $table->datetime('work_end_12')->nullable(true);
            $table->datetime('work_end_13')->nullable(true);
            $table->datetime('work_end_14')->nullable(true);
            $table->datetime('work_end_15')->nullable(true);
            $table->datetime('work_end_16')->nullable(true);
            $table->datetime('work_end_17')->nullable(true);
            $table->datetime('work_end_18')->nullable(true);
            $table->datetime('work_end_19')->nullable(true);
            $table->datetime('work_end_20')->nullable(true);
            $table->datetime('work_end_21')->nullable(true);
            $table->datetime('work_end_22')->nullable(true);
            $table->datetime('work_end_23')->nullable(true);
            $table->datetime('work_end_24')->nullable(true);
            $table->datetime('work_end_25')->nullable(true);
            $table->datetime('work_end_26')->nullable(true);
            $table->datetime('work_end_27')->nullable(true);
            $table->datetime('work_end_28')->nullable(true);
            $table->datetime('work_end_29')->nullable(true);
            $table->datetime('work_end_30')->nullable(true);
            $table->datetime('work_end_31')->nullable(true);
            $table->timestamps();
            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kintais');
    }
}
