<?php

namespace App\View\Components\Dashboard;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class WeekStatsTable extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $daysOfWeek = auth()->user()->sleepEntries()
            ->selectRaw("
                strftime('%w', sleep_entries.in_bed_by) as day_of_week_numeric,
                CASE strftime('%w', sleep_entries.in_bed_by)
                    WHEN '0' THEN 'Sunday'
                    WHEN '1' THEN 'Monday'
                    WHEN '2' THEN 'Tuesday'
                    WHEN '3' THEN 'Wednesday'
                    WHEN '4' THEN 'Thursday'
                    WHEN '5' THEN 'Friday'
                    WHEN '6' THEN 'Saturday'
                END as day_of_week_formatted,
                avg(rating) as avg_rating
            ")
            ->groupBy('day_of_week_numeric')
            ->orderBy('day_of_week_numeric')
            ->get();

        return view('components.dashboard.week-stats-table', [
            'daysOfWeek' => $daysOfWeek,
        ]);
    }
}
