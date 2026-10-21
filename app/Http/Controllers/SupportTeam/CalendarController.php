<?php

namespace App\Http\Controllers\SupportTeam;

use App\Http\Controllers\Controller;
use App\Models\CalendarEvent;
use App\Models\StudentRecord;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function index()
    {
        $month = request('month') ? Carbon::parse(request('month')) : Carbon::now();
        $startOfMonth = $month->copy()->startOfMonth()->startOfWeek();
        $endOfMonth = $month->copy()->endOfMonth()->endOfWeek();

        $events = CalendarEvent::whereBetween('event_date', [$startOfMonth, $endOfMonth])->get();

        $days = [];
        for ($date = $startOfMonth->copy(); $date <= $endOfMonth; $date->addDay()) {
            $dayEvents = $events->where('event_date', $date->format('Y-m-d'));
            $days[] = [
                'date' => $date->copy(),
                'events' => $dayEvents,
                'isCurrentMonth' => $date->month === $month->month,
                'isToday' => $date->isToday(),
            ];
        }

        return view('pages.support_team.calendar.index', compact('days', 'month'));
    }
}