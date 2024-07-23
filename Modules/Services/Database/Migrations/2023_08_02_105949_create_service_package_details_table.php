<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Services\Database\Seeders\ServicePackageDetailSeederTableSeeder;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_package_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('machine_id')->nullable()->constrained('service_machines')->onDelete('cascade');
            $table->foreignId('brand_id')->nullable()->constrained('service_brands')->onDelete('cascade');
            $table->foreignId('model_id')->nullable()->constrained('service_models')->onDelete('cascade');
            $table->foreignId('package_id')->nullable()->constrained('service_packages')->onDelete('cascade');
            $table->string('origin')->nullable();
            $table->integer('quantity')->default(1);
            $table->integer('warranty_period')->nullable();
            $table->integer('status_id')->nullable()->default(1); 

            $table->timestamps();
        });
        // $seeder = new ServicePackageDetailSeederTableSeeder();
        // $seeder->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_package_details');
    }
};
