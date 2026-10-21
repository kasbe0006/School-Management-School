<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;

class StudentResource extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'resource_type',
        'resource_name',
        'serial_number',
        'issue_date',
        'return_date',
        'status',
        'remarks',
        'issued_by'
    ];

    protected $casts = [
        'issue_date' => 'date',
        'return_date' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(StudentRecord::class, 'student_id', 'user_id');
    }

    public function issuedBy()
    {
        return $this->belongsTo(User::class, 'issued_by');
    }
}
