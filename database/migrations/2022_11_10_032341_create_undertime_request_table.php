<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UndertimeRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('undertime_request', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id');
            $table->integer('recommend_id');
            $table->dateTime('recommend_date');
            $table->integer('approved_id');
            $table->dateTime('approved_date');
            $table->integer('declined_id');
            $table->dateTime('declined_date');
            $table->text('declined_reason');
            $table->date('date');
            $table->decimal('no_of_hours', 5, 2);
            $table->dateTime('time_in');
            $table->dateTime('time_out');
            $table->text('reason');
            $table->enum('status', array('PENDING', 'APPROVED', 'DECLINED'))->default('PENDING');
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('deleted_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('undertime_request');
    }
}
