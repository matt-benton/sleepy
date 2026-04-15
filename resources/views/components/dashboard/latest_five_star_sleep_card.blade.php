@php
    $latestFiveStarSleepEntry = auth()->user()
        ->sleepEntries()
        ->where('rating', 5)
        ->orderBy('awake_at', 'desc')
        ->first();
@endphp
<div>
    <flux:card>
        <flux:text>Most Recent 5 Star Sleep</flux:text>
        <flux:heading size="xl" class="mt-2">
            @if ($latestFiveStarSleepEntry)
                <flux:link href="/sleep_entries/{{ $latestFiveStarSleepEntry->id }}" wire:navigate>
                    {{ $latestFiveStarSleepEntry->awake_at->diffForHumans(['parts' => 2, 'minimumUnit' => 'day']) }}
                </flux:link>
            @else
                <flux:text variant="subtle" size="xl">None</flux:text>
            @endif
        </flux:heading>
    </flux:card>
</div>
