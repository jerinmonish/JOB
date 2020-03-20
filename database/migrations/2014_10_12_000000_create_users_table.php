<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->bigIncrements('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('organisation_name')->nullable();
            $table->string('email')->unique();
            $table->string('profile_pic')->nullable();
            $table->timestamp('dob')->nullable();
            $table->string('mobile_no')->nullable();
            $table->string('resume_doc')->nullable();
            $table->string('specialised_in')->nullable();
            $table->string('schoolmark')->nullable();
            $table->string('collegemark')->nullable();
            $table->string('highest_qualification')->nullable();
            $table->string('year_passed_out')->nullable();
            $table->string('percentage')->nullable();
            $table->string('yoe')->nullable();
            $table->string('cur_sal')->nullable();
            $table->string('exp_sal')->nullable();
            $table->string('country')->nullable();
            $table->integer('state')->nullable();
            $table->integer('city')->nullable();
            $table->string('address')->nullable();
            $table->enum('job_type', ['Full Time', 'Part Time','Internship','Freelance'])->default('Full Time');    
            $table->enum('role', ['employee', 'employer','recrutier','admin'])->default('employer');    
            $table->enum('user_status', ['Active', 'Inactive'])->default('Active');    
            $table->timestamp('last_logged_in')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
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
