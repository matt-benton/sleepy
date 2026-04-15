<?php

use Illuminate\Support\Carbon;
use Livewire\Component;

new class extends Component
{
    public $avgSevenDayRating;

    public $prevSevenDayRatings;

    public $thisMonthRatings;

    public $avgSevenDayAwakeAt;

    public $avgSevenDayInBedBy;

    public $avgMonthInBedBy;

    public $avgMonthAwakeAt;

    public function mount()
    {
        $prevSevenDayEntries = auth()->user()->sleepEntries()
            ->whereBetween('awake_at', [now()->subDays(7), now()])
            ->get();

        $this->prevSevenDayRatings = $prevSevenDayEntries->pluck('rating');

        $prevSevenDayAwakeAt = $prevSevenDayEntries->pluck('awake_at');
        $prevSevenDayInBedBy = $prevSevenDayEntries->pluck('in_bed_by');
        $this->avgSevenDayAwakeAt = $this->averageTimeOfDay($prevSevenDayAwakeAt->toArray());
        $this->avgSevenDayInBedBy = $this->averageTimeOfDay($prevSevenDayInBedBy->toArray());

        $monthEntries = auth()->user()->sleepEntries()
            ->whereBetween('awake_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->get();

        $prevMonthAwakeAt = $monthEntries->pluck('awake_at');
        $prevMonthInBedBy = $monthEntries->pluck('in_bed_by');
        $this->avgMonthAwakeAt = $this->averageTimeOfDay($prevMonthAwakeAt->toArray());
        $this->avgMonthInBedBy = $this->averageTimeOfDay($prevMonthInBedBy->toArray());

        $this->thisMonthRatings = auth()->user()->sleepEntries()
            ->whereBetween('awake_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->pluck('rating');

    }

    private function averageTimeOfDay(array $times): ?String {
        if (count($times) === 0) {
            return null;
        }

        $x = 0.0;
        $y = 0.0;

        foreach ($times as $t) {
            // get the total number of seconds that have passed in the day
            $secs = $t->hour * 3600 + $t->minute * 60 + $t->second;

            // convert "time of day" to "position on a circle"
            // M_PI is a php constant equal to pi
            // This allows each time of day to map to a position on a circle
            $angle = ($secs / 86400) * 2 * M_PI;

            // find the x and y coordinates of this time on the circle
            $x += cos($angle);
            $y += sin($angle);
        }

        $avgAngle = atan2($y / count($times), $x / count($times));
        if ($avgAngle < 0) $avgAngle += 2 * M_PI;

        $avgSecs = (int) round(($avgAngle / (2 * M_PI)) * 86400) % 86400;

        return Carbon::createFromTime(
            intdiv($avgSecs, 3600),
            intdiv($avgSecs % 3600, 60),
            $avgSecs % 60
        )->format('g:i a');
    }
};
?>

<div>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-2">
            <flux:card class="overflow-hidden min-w-[12rem]">
                <flux:text>Avg Sleep Rating (prev 7 days)</flux:text>

                <flux:heading size="xl" class="mt-2 tabular-nums">{{ round($prevSevenDayRatings->avg(), 1) }}</flux:heading>

                <flux:chart class="-mx-8 -mb-8 h-[3rem]" :value="$prevSevenDayRatings">
                    <flux:chart.svg gutter="0">
                        <flux:chart.line class="text-sky-200 dark:text-sky-400" />
                        <flux:chart.area class="text-sky-100 dark:text-sky-400/30" />
                    </flux:chart.svg>
                </flux:chart>
            </flux:card>
            <flux:card class="overflow-hidden min-w-[12rem]">
                <flux:text>Avg Sleep Rating (this month)</flux:text>

                <flux:heading size="xl" class="mt-2 tabular-nums">{{ round($thisMonthRatings->avg(), 1) }}</flux:heading>

                <flux:chart class="-mx-8 -mb-8 h-[3rem]" :value="$thisMonthRatings">
                    <flux:chart.svg gutter="0">
                        <flux:chart.line class="text-sky-200 dark:text-sky-400" />
                        <flux:chart.area class="text-sky-100 dark:text-sky-400/30" />
                    </flux:chart.svg>
                </flux:chart>
            </flux:card>
            <flux:card>
                <flux:text class="mb-2">Avg Sleep Session (prev 7 days)</flux:text>
                @if ($avgSevenDayInBedBy && $avgSevenDayAwakeAt)
                    <flux:heading size="xl">
                        {{ $avgSevenDayInBedBy . ' - ' . $avgSevenDayAwakeAt }}
                    </flux:heading>
                @else
                    <flux:text variant="subtle" size="xl">None</flux:text>
                @endif
            </flux:card>
            <flux:card>
                <flux:text class="mb-2">Avg Sleep Session (this month)</flux:text>
                @if ($avgMonthInBedBy && $avgMonthAwakeAt)
                    <flux:heading size="xl">
                        {{ $avgMonthInBedBy . ' - ' . $avgMonthAwakeAt }}
                    </flux:heading>
                @else
                    <flux:text variant="subtle" size="xl">None</flux:text>
                @endif
            </flux:card>
            <x-dashboard.latest_five_star_sleep_card />
        </div>

        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
        </div>
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
        </div>
    </div>
</div>
