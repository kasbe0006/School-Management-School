@extends('layouts.app')

@section('page_title', 'Resources')

@section('content')
<div class="card">
    <div class="card-header bg-transparent text-white d-flex justify-content-between align-items-center">
        <h4 class="card-title">Student Resources</h4>
        <a href="{{ route('resources.create') }}" class="btn btn-primary">Issue New Resource</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Type</th>
                        <th>Name</th>
                        <th>Serial No.</th>
                        <th>Issue Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($resources as $resource)
                    <tr>
                        <td>{{ $resource->student->user->name ?? 'N/A' }}</td>
                        <td>{{ $resource->resource_type }}</td>
                        <td>{{ $resource->resource_name }}</td>
                        <td>{{ $resource->serial_number }}</td>
                        <td>{{ $resource->issue_date->format('Y-m-d') }}</td>
                        <td>
                            <span class="badge badge-{{ $resource->status == 'issued' ? 'warning' : ($resource->status == 'returned' ? 'success' : 'danger') }}">
                                {{ ucfirst($resource->status) }}
                            </span>
                        </td>
                        <td>
                            @if($resource->status == 'issued')
                            <form action="{{ route('resources.return', $resource->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success">Mark Returned</button>
                            </form>
                            @endif
                            <form action="{{ route('resources.destroy', $resource->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this record?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No resources found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $resources->links() }}
    </div>
</div>
@endsection
