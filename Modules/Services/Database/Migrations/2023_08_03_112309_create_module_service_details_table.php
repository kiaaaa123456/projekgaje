<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('module_service_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_service_id')->nullable()->constrained('module_services')->onDelete('cascade');
            $table->date('installation_date');
            $table->foreignId('contract_person_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('machine_id')->nullable()->constrained('service_machines')->onDelete('cascade');
            $table->bigInteger('serial_number')->nullable();
            $table->date('supply_date');
            $table->integer('status_id')->nullable()->default(1);
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
        Schema::dropIfExists('module_service_details');
    }
};
