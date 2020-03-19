<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeavePoliciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_policies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable();
            $table->string('exam');
            $table->string('ipcc_group_1');
            $table->string('ipcc_group_2');
            $table->string('ca_final_group_1');
            $table->string('ca_final_group_2');
            $table->string('ipcc_both_groups');
            $table->string('ca_final_both_groups');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leave_policies');
    }
}
