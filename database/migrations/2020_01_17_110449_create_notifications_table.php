<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('from_id')->nullable();
            $table->integer('to_id')->nullable();
            $table->string('subject')->nullable();
            $table->string('notification_type')->nullable();
            $table->integer('id_redirect')->nullable();
            $table->enum('read_status', ['Read', 'Unread'])->default('Unread');    
            $table->enum('notification_type_val', ['User-Message', 'Job-Subscribed', 'Job-Unubscribed'])->nullable();    
            $table->timestamp('read_at')->nullable();
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
        Schema::dropIfExists('notifications');
    }
}
