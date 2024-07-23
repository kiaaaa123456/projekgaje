<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('user_document_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 91)->unique();
            $table->bigInteger('status_id')->default(1)->comment('1=active,4=inactive');
            $table->timestamps();
            $table->index('name');
        });
        $documentTypes = [
            "Resume/CV",
            "Job Offer Letter",
            "Employment Contract",
            "W-4 Form",
            "I-9 Form",
            "Payroll Records",
            "Employee Handbook",
            "Performance Appraisals",
            "Benefits Enrollment Forms",
            "Termination Documentation",
            "Training Certificates",
            "Health and Safety Documents",
            "Workplace Policies",
            "Emergency Contact Information",
            "Non-Disclosure Agreements",
            "Employee Self-Assessments",
            "Professional Development Plans",
            "Tax Forms (e.g., 1099)",
            "Equal Opportunity Forms",
            "Direct Deposit Authorization",
            "Sick Leave and Vacation Requests",
            "Employee Recognition Awards",
            "Pension and Retirement Plans",
            "Overtime Records",
            "Expense Reports",
            "Passport",
            "Social Security Number (SSN)",
            "Work Authorization (e.g., Work Permit)",
        ];

        foreach ($documentTypes as $type) {
            DB::table('user_document_types')->insert([
                'name' => $type,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_document_types');
    }
};
