@extends('layouts.app')

@section('page_title', 'Calendar')

@section('content')
<div class="content-wrapper">
    <div class="content">

        <!-- Page header -->
        <div class="page-header page-header-default">
            <div class="page-header-content">
                <div class="page-title">
                    <h4><i class="icon-calendar22"></i> School Calendar</h4>
                </div>
            </div>
            <div class="breadcrumb-line">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="icon-home2 mr-2"></i> Home</a></li>
                    <li class="breadcrumb-item active">Calendar</li>
                </ul>
            </div>
        </div>
        <!-- /page header -->

        <!-- Content area -->
        <div class="row">
            <div class="col-12">
                <!-- Calendar Card -->
                <div class="card">
                    <div class="card-header header-elements-inline">
                        <h5 class="card-title">Events Calendar</h5>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a href="#" class="list-icons-item" data-action="collapse"></a>
                                <a href="#" class="list-icons-item" data-action="reload"></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <a href="{{ route('calendar.index', ['month' => $month->copy()->subMonth()->format('Y-m')]) }}" class="btn btn-light">
                                    <i class="icon-chevron-left mr-2"></i> Previous Month
                                </a>
                            </div>
                            <div class="col-md-6 text-right">
                                <a href="{{ route('calendar.index', ['month' => $month->copy()->addMonth()->format('Y-m')]) }}" class="btn btn-light">
                                    Next Month <i class="icon-chevron-right ml-2"></i>
                                </a>
                            </div>
                        </div>

                        <div class="text-center mb-3">
                            <h5 class="mb-0">{{ $month->format('F Y') }}</h5>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-calendar">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-center">Sun</th>
                                        <th class="text-center">Mon</th>
                                        <th class="text-center">Tue</th>
                                        <th class="text-center">Wed</th>
                                        <th class="text-center">Thu</th>
                                        <th class="text-center">Fri</th>
                                        <th class="text-center">Sat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $week = [];
                                        foreach ($days as $index => $day) {
                                            $week[] = $day;
                                            if (count($week) === 7 || $index === count($days) - 1) {
                                                echo '<tr>';
                                                foreach ($week as $d) {
                                                    $bgClass = '';
                                                    if (!$d['isCurrentMonth']) {
                                                        $bgClass = 'bg-gray-50';
                                                    }
                                                    if ($d['isToday']) {
                                                        $bgClass = 'bg-primary bg-opacity-10';
                                                    }
                                                    echo '<td class="text-center ' . $bgClass . '" style="min-height: 100px; vertical-align: top;">';
                                                    echo '<div class="font-weight-bold mb-1">' . $d['date']->format('d') . '</div>';
                                                    foreach ($d['events'] as $event) {
                                                        $badgeClass = $event->calendar_type === 'hindu' ? 'badge-warning' : 'badge-info';
                                                        if ($event->is_holiday) {
                                                            $badgeClass = 'badge-danger';
                                                        }
                                                        echo '<span class="badge ' . $badgeClass . ' badge-pill d-block mb-1 text-truncate" style="font-size: 0.65rem;" title="' . $event->description . '">';
                                                        echo $event->title;
                                                        echo '</span>';
                                                    }
                                                    echo '</td>';
                                                }
                                                echo '</tr>';
                                                $week = [];
                                            }
                                        }
                                    @endphp
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /Calendar Card -->

                <!-- Events List -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h5 class="card-title">Events This Month</h5>
                    </div>
                    <div class="card-body">
                        @php
                            $monthEvents = \App\Models\CalendarEvent::whereMonth('event_date', $month->month)
                                ->whereYear('event_date', $month->year)
                                ->orderBy('event_date')
                                ->get();
                        @endphp

                        @if ($monthEvents->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Event</th>
                                            <th>Type</th>
                                            <th>Description</th>
                                            <th>Holiday</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($monthEvents as $event)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}</td>
                                            <td>{{ $event->title }}</td>
                                            <td>
                                                <span class="badge @if($event->calendar_type === 'hindu') badge-warning @else badge-info @endif">
                                                    {{ ucfirst($event->calendar_type) }}
                                                </span>
                                            </td>
                                            <td>{{ $event->description }}</td>
                                            <td>
                                                @if($event->is_holiday)
                                                    <span class="badge badge-danger">Yes</span>
                                                @else
                                                    <span class="badge badge-light">No</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-center text-muted mb-0">No events scheduled for this month.</p>
                        @endif
                    </div>
                </div>
                <!-- /Events List -->
            </div>
        </div>
        <!-- /content area -->
    </div>
</div>
@endsection

@push('styles')
<style>
.table-calendar td {
    border: 1px solid #e9ecef !important;
}
.table-calendar .bg-gray-50 {
    background-color: #f8f9fa !important;
}
.table-calendar .bg-primary.bg-opacity-10 {
    background-color: rgba(33, 150, 243, 0.1) !important;
}
</style>
@endpush