<?php

namespace App\View\Components\Dashboard;

use Carbon\CarbonImmutable;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AwakeAtVariance extends Component
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
        $sleepEntriesAwakeAt = auth()->user()->sleepEntries()->limit(7)->pluck('awake_at');

        $data = $sleepEntriesAwakeAt->map(function ($entry) {
            return [
                'date' => $entry,
                'time' => $this->combineDateKeepTime($entry),
            ];
        })->toArray();

        return view('components.dashboard.awake-at-variance', ['data' => $data]);
    }

    private function combineDateKeepTime(CarbonImmutable $date): CarbonImmutable
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
