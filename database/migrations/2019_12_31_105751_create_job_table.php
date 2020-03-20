<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('req_id')->nullable();
            $table->string('job_title')->nullable();
            $table->string('organisation_name')->nullable();
            $table->enum('job_type',['Full-Time','Part-Time','Freelancer','Internship'])->default('Full-Time')->nullable();
            $table->integer('min_exp')->nullable();
            $table->integer('max_exp')->nullable();
            $table->string('req_qualification')->nullable();
            $table->enum('req_travel',['Yes','No'])->default('No')->nullable();
            $table->double('min_sal',20, 2)->nullable();
            $table->double('max_sal',20, 2)->nullable();
            $table->enum('freshers',['Yes','No'])->default('No')->nullable();
            $table->enum('premium_job',['Yes','No'])->default('No')->nullable();
            $table->longText('description')->nullable();
            $table->integer('no_of_pos')->nullable();
            $table->string('req_email')->nullable();
            $table->string('phone_no')->nullable();
            $table->string('jd_desc')->nullable();
            $table->string('transaction_id')->nullable();
            $table->enum('joining_time',['Immediate','30-Days','60-Days','90-Days'])->default('Immediate')->nullable();
            $table->enum('payment_status',['Paid','Not-Paid'])->default('Not-Paid')->nullable();
            $table->longText('job_keywords')->nullable();
            $table->string('location')->nullable();
            $table->string('location_start')->nullable();
            $table->string('location_end')->nullable();
            $table->enum('status',['Active','Inactive'])->default('Active')->nullable();
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
        Schema::dropIfExists('job');
    }
}
