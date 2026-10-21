<?php

namespace App\Http\Controllers\SupportTeam;

use App\Http\Controllers\Controller;
use App\Models\StudentResource;
use App\Models\StudentRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentResourceController extends Controller
{
    public function index()
    {
        $resources = StudentResource::with(['student.user', 'issuedBy'])->latest()->paginate(20);
        return view('pages.support_team.resources.index', compact('resources'));
    }

    public function create()
    {
        $students = StudentRecord::with('user')->get();
        return view('pages.support_team.resources.create', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:student_records,user_id',
            'resource_type' => 'required|string',
            'resource_name' => 'required|string',
            'issue_date' => 'required|date',
        ]);

        StudentResource::create([
            'student_id' => $request->student_id,
            'resource_type' => $request->resource_type,
            'resource_name' => $request->resource_name,
            'serial_number' => $request->serial_number,
            'issue_date' => $request->issue_date,
            'status' => 'issued',
            'issued_by' => Auth::id(),
            'remarks' => $request->remarks
        ]);

        return redirect()->route('resources.index')->with('flash_success', 'Resource issued successfully');
    }

    public function returnResource($id)
    {
        $resource = StudentResource::findOrFail($id);
        $resource->update([
            'status' => 'returned',
            'return_date' => now()
        ]);

        return redirect()->back()->with('flash_success', 'Resource returned successfully');
    }

    public function destroy($id)
    {
        $resource = StudentResource::findOrFail($id);
        $resource->delete();
        return redirect()->route('resources.index')->with('flash_success', 'Resource record deleted');
    }
}
