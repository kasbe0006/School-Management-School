<?php

namespace App\Http\Controllers\SupportTeam;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\MyClass;
use App\Models\Section;
use App\Models\StudentRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        $classes = MyClass::with('sections')->get();
        return view('pages.support_team.attendance.index', compact('classes'));
    }

    public function getStudentsByClass(Request $request)
    {
        $students = StudentRecord::where('my_class_id', $request->class_id)
            ->where('section_id', $request->section_id)
            ->with('user')
            ->get();

        $date = $request->date ?: today();
        $attendances = Attendance::where('my_class_id', $request->class_id)
            ->where('section_id', $request->section_id)
            ->where('attendance_date', $date)
            ->pluck('status', 'student_id');

        return response()->json([
            'students' => $students,
            'attendances' => $attendances
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:my_classes,id',
            'section_id' => 'required|exists:sections,id',
            'date' => 'required|date',
            'attendance' => 'required|array'
        ]);

        foreach ($request->attendance as $studentId => $status) {
            Attendance::updateOrCreate([
                'student_id' => $studentId,
                'my_class_id' => $request->class_id,
                'section_id' => $request->section_id,
                'attendance_date' => $request->date
            ], [
                'status' => $status,
                'marked_by' => Auth::id()
            ]);
        }

        return response()->json(['ok' => true, 'msg' => 'Attendance marked successfully']);
    }

    public function report(Request $request)
    {
        $month = $request->input('month', now()->format('Y-m'));
        $attendances = Attendance::whereMonth('attendance_date', explode('-', $month)[1])
            ->whereYear('attendance_date', explode('-', $month)[0])
            ->with(['student.user', 'myClass', 'section', 'markedBy'])
            ->paginate(30);

        // Summary statistics
        $all = Attendance::whereMonth('attendance_date', explode('-', $month)[1])
            ->whereYear('attendance_date', explode('-', $month)[0])
            ->get();
        $summary = [
            'present' => $all->where('status', 'present')->count(),
            'absent' => $all->where('status', 'absent')->count(),
            'late' => $all->where('status', 'late')->count(),
        ];

        return view('pages.support_team.attendance.report', compact('attendances', 'month', 'summary'));
    }
}
