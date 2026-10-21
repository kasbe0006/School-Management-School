@extends('layouts.app')

@section('page_title', 'Attendance Report')

@section('content')
<div class="content-wrapper">
    <div class="content">
        <!-- Page header -->
        <div class="page-header page-header-default">
            <div class="page-header-content">
                <div class="page-title">
                    <h4><i class="icon-calendar3"></i> Attendance Report</h4>
                </div>
                <div class="heading-elements">
                    <a href="{{ route('attendance.index') }}" class="btn btn-primary">
                        <i class="icon-arrow-left32"></i> Back to Attendance
                    </a>
                </div>
            </div>
            <div class="breadcrumb-line">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="icon-home2 mr-2"></i> Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('attendance.index') }}">Attendance</a></li>
                    <li class="breadcrumb-item active">Report</li>
                </ul>
            </div>
        </div>
        <!-- /page header -->

        <!-- Content area -->
        <div class="row">
            <div class="col-12">
                @php
                    $total = ($summary['present'] ?? 0) + ($summary['absent'] ?? 0) + ($summary['late'] ?? 0);
                @endphp

                <!-- Filter Form -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h5>Filter Attendance</h5>
                    </div>
                    <div class="card-body">
                        <form method="GET" class="form-inline">
                            <div class="form-group mr-3">
                                <label class="mr-2">Month:</label>
                                <input type="month" name="month" value="{{ $month }}" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </form>
                    </div>
                </div>

                <!-- Summary Stats -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h5>Summary Statistics</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="alert alert-success text-center">
                                    <h4>{{ number_format(($summary['present'] ?? 0) / max($total, 1) * 100, 1) }}%</h4>
                                    <small>Present</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="alert alert-danger text-center">
                                    <h4>{{ number_format(($summary['absent'] ?? 0) / max($total, 1) * 100, 1) }}%</h4>
                                    <small>Absent</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="alert alert-warning text-center">
                                    <h4>{{ number_format(($summary['late'] ?? 0) / max($total, 1) * 100, 1) }}%</h4>
                                    <small>Late</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="alert alert-info text-center">
                                    <h4>{{ ($summary['present'] + $summary['absent'] + $summary['late']) }}</h4>
                                    <small>Total Records</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Attendance Table -->
                <div class="card">
                    <div class="card-header">
                        <h5>Attendance Details - {{ \Carbon\Carbon::parse($month)->format('F Y') }}</h5>
                    </div>
                    <div class="card-body p-0">
                        @if($attendances->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr class="bg-blue">
                                            <th>#</th>
                                            <th>Student</th>
                                            <th>Class</th>
                                            <th>Section</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Marked By</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($attendances as $attendance)
                                        <tr>
                                            <td>{{ $loop->iteration + ($attendances->currentPage() - 1) * $attendances->perPage() }}</td>
                                            <td>{{ $attendance->student->user->name ?? ($attendance->student->adm_no ?? 'N/A') }}</td>
                                            <td>{{ $attendance->myClass->name ?? 'N/A' }}</td>
                                            <td>{{ $attendance->section->name ?? 'N/A' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($attendance->attendance_date)->format('d M Y') }}</td>
                                            <td>
                                                @if($attendance->status === 'present')
                                                    <span class="badge badge-success">Present</span>
                                                @elseif($attendance->status === 'absent')
                                                    <span class="badge badge-danger">Absent</span>
                                                @elseif($attendance->status === 'late')
                                                    <span class="badge badge-warning">Late</span>
                                                @endif
                                            </td>
                                            <td>{{ $attendance->markedBy->name ?? 'System' }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="pagination-container p-3">
                                {{ $attendances->appends(['month' => $month])->links() }}
                            </div>
                        @else
                            <p class="text-center p-3">No attendance records found for this month.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- /content area -->
    </div>
</div>
@endsection