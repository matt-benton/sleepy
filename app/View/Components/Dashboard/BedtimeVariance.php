<?php

namespace App\View\Components\Dashboard;

use Carbon\CarbonImmutable;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BedtimeVariance extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct() {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $sleepEntriesInBedBy = auth()->user()->sleepEntries()->limit(7)->pluck('in_bed_by');

        $data = $sleepEntriesInBedBy->map(function ($entry) {
            return [
                'date' => $entry,
                'time' => $this->withTodaysDateKeepingTime($entry),
            ];
        })->toArray();

        return view('components.dashboard.bedtime-variance', ['data' => $data]);
    }

    public function withTodaysDateKeepingTime(CarbonImmutable $date): CarbonImmutable
    {
        $targetDate = now($date->getTimezone());

        if ($date->hour < 6) {
            $newDate = $targetDate->addDay();
        } else {
            $newDate = $targetDate;
        }

        return $date->copy()->setDateFrom($newDate);
    }
}
