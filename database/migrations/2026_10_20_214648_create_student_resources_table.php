<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_resources', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('student_id');
            $table->string('resource_type');
            $table->string('resource_name');
            $table->string('serial_number')->nullable();
            $table->date('issue_date');
            $table->date('return_date')->nullable();
            $table->enum('status', ['issued', 'returned', 'lost'])->default('issued');
            $table->text('remarks')->nullable();
            $table->unsignedInteger('issued_by');
            $table->timestamps();

            $table->foreign('student_id')->references('user_id')->on('student_records')->onDelete('cascade');
            $table->foreign('issued_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_resources');
    }
}
