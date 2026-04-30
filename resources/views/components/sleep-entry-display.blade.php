<div>
    <flux:heading size="lg" class="mb-2">
        <flux:link href="/sleep_entries/{{ $sleepEntry->id }}" wire:navigate>{{ $sleepEntry->sleep_date }}</flux:link>
    </flux:heading>

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
        <flux:text size="sm" class="mt-1"><i>{{ $sleepEntry->temperature }}&deg;F</i></flux:text>
    @endif

    <div class="space-y-3">
        <flux:text>{!! $sleepEntry->notes !!}</flux:text>
    </div>

    <div class="flex my-5">
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
    <div class="my-5 mx-2 space-y-1">
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
            <flux:badge rounded class="mb-1">
                <a href="/tags/{{ $tag->id }}" wire:navigate>{{ $tag->name }}</a>
            </flux:badge>
        @endforeach
    </div>
</div>
