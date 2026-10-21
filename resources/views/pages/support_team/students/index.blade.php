@extends('layouts.app')

@section('page_title', 'Students')

@section('content')
<div class="content-wrapper">
    <div class="content">
        <!-- Page header -->
        <div class="page-header page-header-default">
            <div class="page-header-content">
                <div class="page-title">
                    <h4><i class="icon-students4"></i> Students</h4>
                </div>
                <div class="heading-elements">
                    <a href="{{ route('students.create') }}" class="btn bg-teal-400 btn-labeled btn-labeled-left"><b><i class="icon-plus2"></i></b> Add Student</a>
                </div>
            </div>
            <div class="breadcrumb-line">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="icon-home2 mr-2"></i> Home</a></li>
                    <li class="breadcrumb-item active">Students</li>
                </ul>
            </div>
        </div>
        <!-- /page header -->

        <!-- Content area -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>All Students</h5>
                    </div>
                    <div class="card-body p-0">
                        @if($students->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr class="bg-blue">
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Admission No</th>
                                        <th>Class</th>
                                        <th>Section</th>
                                        <th>Parent</th>
                                        <th>House</th>
                                        <th>Age</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($students as $student)
                                    <tr>
                                        <td>{{ $loop->iteration + ($students->currentPage() - 1) * $students->perPage() }}</td>
                                        <td>{{ $student->user->name ?? 'N/A' }}</td>
                                        <td>{{ $student->adm_no ?? 'N/A' }}</td>
                                        <td>{{ $student->my_class->name ?? 'N/A' }}</td>
                                        <td>{{ $student->section->name ?? 'N/A' }}</td>
                                        <td>{{ $student->my_parent->name ?? 'N/A' }}</td>
                                        <td>{{ $student->house ?? 'N/A' }}</td>
                                        <td>{{ $student->age ?? 'N/A' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="pagination-container">
                            {{ $students->links() }}
                        </div>
                        @else
                        <p class="text-center p-3">No students found.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- /content area -->
    </div>
</div>
@endsection