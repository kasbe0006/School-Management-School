@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header bg-transparent text-white">
        <h4 class="card-title">Issue Student Resource</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('resources.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Student</label>
                    <select name="student_id" class="form-control" required>
                        <option value="">Select Student</option>
                        @foreach($students as $student)
                            <option value="{{ $student->user_id }}">{{ $student->user->name }} ({{ $student->adm_no }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Resource Type</label>
                    <select name="resource_type" class="form-control" required>
                        <option value="">Select Type</option>
                        <option value="uniform">Uniform</option>
                        <option value="textbook">Textbook</option>
                        <option value="lab_equipment">Lab Equipment</option>
                        <option value="sports_equipment">Sports Equipment</option>
                        <option value="certificate">Certificate</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Resource Name</label>
                    <input type="text" name="resource_name" class="form-control" required placeholder="e.g., Science Lab Coat, Math Textbook">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Serial Number</label>
                    <input type="text" name="serial_number" class="form-control" placeholder="Optional">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Issue Date</label>
                    <input type="date" name="issue_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="col-md-12 mb-3">
                    <label>Remarks</label>
                    <textarea name="remarks" class="form-control" rows="3"></textarea>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Issue Resource</button>
            <a href="{{ route('resources.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
