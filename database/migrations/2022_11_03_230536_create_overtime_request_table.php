<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OvertimeRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('overtime_request', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id');
            $table->integer('recommend_id');
            $table->dateTime('recommend_date');
            $table->integer('approved_id');
            $table->dateTime('approved_date');
            $table->integer('declined_id');
            $table->dateTime('declined_date');
            $table->text('declined_reason');
            $table->text('reason');
            $table->enum('status', array('PENDING', 'APPROVED', 'DECLINED', 'VERIFYING', 'COMPLETED'))->default('PENDING');
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
        Schema::dropIfExists('overtime_request');
    }
}
