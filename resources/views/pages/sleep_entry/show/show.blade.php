<div>
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="/sleep_entries" wire:navigate>Sleep Entries</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>{{ $sleepEntry->sleep_date }}</flux:breadcrumbs.item>
    </flux:breadcrumbs>
    <div class="max-w-md mx-auto mt-7 space-y-5">
        <div class="space-y-3">
            <flux:heading size="lg">{{ $sleepEntry->sleep_date }}</flux:heading>

            @if ($sleepEntry->in_bed_by && $sleepEntry->awake_at)
                <flux:text>
                    In bed by {{ $sleepEntry->in_bed_by->format('h:i A') }}, awake at {{ $sleepEntry->awake_at->format('h:i A') }} ({{ $sleepEntry->sleep_length }})
                </flux:text>
            @elseif ($sleepEntry->in_bed_by)
                <flux:text>
                    In bed by {{ $sleepEntry->in_bed_by->format('h:i A') }}
                </flux:text>
            @elseif ($sleepEntry->awake_at)
                <flux:text>
                    Awake at {{ $sleepEntry->awake_at->format('h:i A') }}
                </flux:text>
            @endif

            @if ($sleepEntry->temperature)
                <flux:text size="sm"><i>{{ $sleepEntry->temperature }}&deg;F</i></flux:text>
            @endif

            <flux:text>{!! $sleepEntry->notes !!}</flux:text>
            <div class="flex">
                @if ($sleepEntry->rating)
                    <flux:icon.star variant="solid" />
                @else
                    <flux:icon.star />
                @endif

                @if ($sleepEntry->rating >= 2)
                    <flux:icon.star variant="solid" />
                @else
                    <flux:icon.star />
                @endif

                @if ($sleepEntry->rating >= 3)
                    <flux:icon.star variant="solid" />
                @else
                    <flux:icon.star />
                @endif

                @if ($sleepEntry->rating >= 4)
                    <flux:icon.star variant="solid" />
                @else
                    <flux:icon.star />
                @endif

                @if ($sleepEntry->rating === 5)
                    <flux:icon.star variant="solid" />
                @else
                    <flux:icon.star />
                @endif
            </div>
        </div>

        <div>
            @foreach ($sleepEntry->keyPoints as $point)
                @if ($point->is_positive)
                    <p><flux:text color="green">+ {{ $point->text }}</flux:text></p>
                @else
                    <p><flux:text color="red">- {{ $point->text }}</flux:text></p>
                @endif
            @endforeach
        </div>

        <div>
            @foreach ($sleepEntry->tags as $tag)
                <flux:badge rounded>{{ $tag->name }}</flux:badge>
            @endforeach
        </div>

        <flux:button href="/sleep_entries/{{ $sleepEntry->id }}/edit" icon="pencil" wire:navigate>Edit</flux:button>
    </div>
</div>
