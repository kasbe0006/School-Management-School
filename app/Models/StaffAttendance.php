<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffAttendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'staff_id',
        'attendance_date',
        'status',
        'check_in',
        'check_out',
        'remark',
        'marked_by'
    ];

    public function staff()
    {
        return $this->belongsTo(StaffRecord::class, 'staff_id', 'user_id');
    }

    public function markedBy()
    {
        return $this->belongsTo(User::class, 'marked_by');
    }
}
