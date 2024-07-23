<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Services\Database\Seeders\ServiceBrandTableSeeder;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_brands', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('status_id')->nullable()->default(1); 
            $table->timestamps();
        });

        $seeder = new ServiceBrandTableSeeder();
        $seeder->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_brands');
    }
};
