<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->enum('in_status_approve', ['OT'])->nullable()->comment('OT=On Time');
            $table->foreignId('in_status_approve_by')->nullable()->constrained('users')->cascadeOnDelete();
            $table->enum('out_status_approve', ['LT'])->nullable()->comment('LT=Left Timely');
            $table->foreignId('out_status_approve_by')->nullable()->constrained('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn('in_status_approve','in_status_approve_by','out_status_approve','out_status_approve_by');
        });
    }
};
