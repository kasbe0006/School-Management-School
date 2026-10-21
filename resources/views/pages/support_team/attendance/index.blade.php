@extends('layouts.app')

@section('page_title', 'Attendance')

@section('content')
<div class="card">
    <div class="card-header bg-transparent text-white d-flex justify-content-between align-items-center">
        <h4 class="card-title">Mark Student Attendance</h4>
        <a href="{{ route('attendance.report') }}" class="btn btn-sm btn-primary">
            <i class="icon-eye4"></i> View Report
        </a>
    </div>
    <div class="card-body">
        <form id="attendanceForm">
            @csrf
            <div class="row mb-3">
                <div class="col-md-4">
                    <label>Date</label>
                    <input type="date" name="date" id="attendance_date" class="form-control" value="{{ date('Y-m-d') }}">
                </div>
                <div class="col-md-4">
                    <label>Class</label>
                    <select name="class_id" id="class_id" class="form-control" required>
                        <option value="">Select Class</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label>Section</label>
                    <select name="section_id" id="section_id" class="form-control" required>
                        <option value="">Select Section</option>
                    </select>
                </div>
            </div>

            <div id="students_list"></div>

            <div id="loading" class="text-center py-4" style="display:none;">
                <i class="icon-spinner2 spinner"></i> Loading students...
            </div>

            <button type="submit" class="btn btn-primary mt-3" id="saveBtn" style="display:none;">
                Save Attendance
            </button>
        </form>
    </div>
</div>

<script>
let students = [];

$('#class_id').change(function() {
    $('#section_id').html('<option value="">Select Section</option>');
    const classId = $(this).val();

    $.ajax({
        url: '/ajax/get_class_sections/' + classId,
        type: 'GET',
        success: function(data) {
            if (data.sections) {
                data.sections.forEach(section => {
                    $('#section_id').append(`<option value="${section.id}">${section.name}</option>`);
                });
            }
        }
    });
});

$('#section_id, #attendance_date').change(function() {
    loadStudents();
});

function loadStudents() {
    const classId = $('#class_id').val();
    const sectionId = $('#section_id').val();
    const date = $('#attendance_date').val();

    if (!classId || !sectionId) return;

    $('#loading').show();
    $('#students_list').html('');
    $('#saveBtn').hide();

    $.ajax({
        url: '{{ route("attendance.students") }}',
        type: 'POST',
        data: {
            class_id: classId,
            section_id: sectionId,
            date: date,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            $('#loading').hide();
            students = response.students;

            if (students.length === 0) {
                $('#students_list').html('<p class="text-muted">No students found in this class.</p>');
                return;
            }

            let html = '<table class="table table-bordered"><thead><tr><th>Name</th><th>Status</th></tr></thead><tbody>';

            students.forEach(student => {
                const status = response.attendances[student.user_id] || 'present';
                html += `
                    <tr>
                        <td>${student.user.name}</td>
                        <td>
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-outline-success ${status === 'present' ? 'active' : ''}">
                                    <input type="radio" name="attendance[${student.user_id}]" value="present" ${status === 'present' ? 'checked' : ''}> Present
                                </label>
                                <label class="btn btn-outline-danger ${status === 'absent' ? 'active' : ''}">
                                    <input type="radio" name="attendance[${student.user_id}]" value="absent" ${status === 'absent' ? 'checked' : ''}> Absent
                                </label>
                                <label class="btn btn-outline-warning ${status === 'late' ? 'active' : ''}">
                                    <input type="radio" name="attendance[${student.user_id}]" value="late" ${status === 'late' ? 'checked' : ''}> Late
                                </label>
                            </div>
                        </td>
                    </tr>
                `;
            });

            html += '</tbody></table>';
            $('#students_list').html(html);
            $('#saveBtn').show();
        },
        error: function() {
            $('#loading').hide();
            $('#students_list').html('<p class="text-danger">Error loading students.</p>');
        }
    });
}

$('#attendanceForm').submit(function(e) {
    e.preventDefault();

    const attendance = {};
    $('input[type="radio"]:checked').each(function() {
        const match = this.name.match(/attendance\[(\d+)\]/);
        if (match) attendance[match[1]] = this.value;
    });

    $('#saveBtn').prop('disabled', true).text('Saving...');

    $.ajax({
        url: '{{ route("attendance.store") }}',
        type: 'POST',
        data: {
            class_id: $('#class_id').val(),
            section_id: $('#section_id').val(),
            date: $('#attendance_date').val(),
            attendance: attendance,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if (response.ok) {
                alert('Attendance saved successfully!');
            }
        },
        error: function() {
            alert('Error saving attendance. Please try again.');
        },
        complete: function() {
            $('#saveBtn').prop('disabled', false).text('Save Attendance');
        }
    });
});
</script>
@endsection
