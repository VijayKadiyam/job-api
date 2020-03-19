<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email', 100)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->integer('active')->default(0);
            $table->string('password');
            $table->bigInteger('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('organigation_name')->nullable();
            $table->string('organigation_address')->nullable();
            $table->string('gstn')->nullable();
            $table->string('year_of_establishment')->nullable();
            $table->string('no_of_partners')->nullable();
            $table->string('total_no_of_people')->nullable();
            $table->string('description')->nullable();
            $table->string('transfer_policy')->nullable();
            $table->string('training_policy')->nullable();
            $table->string('leave_compensation')->nullable();
            $table->string('dob')->nullable();
            $table->string('gender')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('10_passing_marks')->nullable();
            $table->string('10_total_marks')->nullable();
            $table->string('12_passing_marks')->nullable();
            $table->string('12_total_marks')->nullable();
            $table->string('cpt_passing_year')->nullable();
            $table->string('cpt_marks')->nullable();
            $table->string('cpt_attempts')->nullable();
            $table->string('ipcc_group_1_passing_year')->nullable();
            $table->string('ipcc_group_1_marks')->nullable();
            $table->string('ipcc_group_1_attempts')->nullable();
            $table->string('ipcc_group_2_passing_marks')->nullable();
            $table->string('ipcc_group_2_attempts')->nullable();
            $table->string('entry_scheme')->nullable();
            $table->string('icitss_passed')->nullable();
            $table->string('icitss_passing_marks')->nullable();
            $table->string('icitss_total_marks')->nullable();
            $table->string('other_training_details')->nullable();
            $table->string('outstation_travel')->nullable();
            $table->string('api_token', 60)->unique()->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
