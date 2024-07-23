<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConferenceMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conference_members', function (Blueprint $table) {
            $table->id();
            $table->integer('conference_id');
            $table->integer('user_id');
            $table->integer('status_id')->default(1);
            $table->integer('created_by')->nullable();
            $table->integer('is_host')->default(0);
            $table->integer('is_present')->default(0);
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
        Schema::dropIfExists('conference_members');
    }
}
