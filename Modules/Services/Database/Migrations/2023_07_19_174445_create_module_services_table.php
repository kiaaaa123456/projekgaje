<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Services\Database\Seeders\ServiceTableSeeder;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('module_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('institution_id')->nullable()->constrained('service_institutions')->onDelete('cascade');
            $table->foreignId('package_id')->nullable()->constrained('service_packages')->onDelete('cascade');
            $table->date('date');
            $table->integer('status_id')->nullable()->default(1); 
            $table->timestamps();
        });

        // $seeder = new ServiceTableSeeder();
        // $seeder->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('module_services');
    }
};
