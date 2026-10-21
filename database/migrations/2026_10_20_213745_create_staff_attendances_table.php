<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('staff_id');
            $table->date('attendance_date');
            $table->enum('status', ['present', 'absent', 'late'])->default('present');
            $table->time('check_in')->nullable();
            $table->time('check_out')->nullable();
            $table->string('remark')->nullable();
            $table->unsignedInteger('marked_by');
            $table->timestamps();

            $table->foreign('staff_id')->references('user_id')->on('staff_records')->onDelete('cascade');
            $table->foreign('marked_by')->references('id')->on('users')->onDelete('cascade');
            $table->unique(['staff_id', 'attendance_date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('staff_attendances');
    }
}
