<?php

use Livewire\Component;

new class extends Component
{
    public $avgSevenDayRating;

    public $prevSevenDayRatings;

    public $thisMonthRatings;

    public function mount()
    {
        $this->prevSevenDayRatings = auth()->user()->sleepEntries()
            ->whereBetween('awake_at', [now()->subDays(7), now()])
            ->pluck('rating');

        $this->thisMonthRatings = auth()->user()->sleepEntries()
            ->whereBetween('awake_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->pluck('rating');
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
