<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('student_id');
            $table->unsignedInteger('my_class_id');
            $table->unsignedInteger('section_id');
            $table->date('attendance_date');
            $table->enum('status', ['present', 'absent', 'late'])->default('present');
            $table->string('remark')->nullable();
            $table->unsignedInteger('marked_by');
            $table->timestamps();

            $table->foreign('student_id')->references('user_id')->on('student_records')->onDelete('cascade');
            $table->foreign('my_class_id')->references('id')->on('my_classes')->onDelete('cascade');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
            $table->foreign('marked_by')->references('id')->on('users')->onDelete('cascade');
            $table->unique(['student_id', 'attendance_date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendances');
    }
}
