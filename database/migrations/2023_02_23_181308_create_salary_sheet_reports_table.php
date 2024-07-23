<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalarySheetReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_sheet_reports', function (Blueprint $table) {
            $table->id();
            $table->integer('sl_no')->default(null);
            $table->string('name_of_the_employee')->default(null);
            $table->string('employee_id')->default(null);
            $table->string('designation')->default(null);
            $table->integer('w_days')->default(null);
            $table->integer('present')->default(null);
            $table->integer('absent')->default(null);
            $table->integer('tardy')->default(null);
            $table->string('tardy_days')->default(null);
            $table->double('gross_salary')->default(null);
            $table->double('basic_50')->default(null);
            $table->double('hra_40')->default(null);
            $table->double('medical_10')->default(null);
            $table->double('performance_incentive')->default(null);
            $table->double('absent_amount')->default(null);
            $table->double('advance')->default(null);
            $table->double('tardy_amount')->default(null);
            $table->double('incentive')->default(null);
            $table->double('net_salary')->default(null);
            $table->bigInteger('company_id')->nullable();
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
        Schema::dropIfExists('salary_sheet_reports');
    }
}
