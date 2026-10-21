<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'my_class_id',
        'section_id',
        'attendance_date',
        'status',
        'remark',
        'marked_by'
    ];

    public function student()
    {
        return $this->belongsTo(StudentRecord::class, 'student_id', 'user_id');
    }

    public function myClass()
    {
        return $this->belongsTo(MyClass::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function markedBy()
    {
        return $this->belongsTo(User::class, 'marked_by');
    }
}
