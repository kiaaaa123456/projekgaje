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
        Schema::create('user_documents', function (Blueprint $table) {
            $table->id();
            $table->string('document_title', 255)->nullable();
            $table->string('document_number')->nullable();
            $table->date('document_expiration')->nullable();

            $table->text('document_request_description')->nullable();
            $table->boolean('document_request_approved')->nullable();
            $table->date('document_request_date')->nullable();
            $table->date('document_notification_date')->nullable();

            $table->foreignId('attachment_id')->nullable()->constrained('uploads');

            $table->timestamps();

            // Relations
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('user_document_type_id')->constrained('user_document_types');

            // Add indexes for optimization
            $table->index('user_id');
            $table->index('user_document_type_id');
            $table->index('document_number');
            $table->index('document_expiration');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_documents');
    }
};
