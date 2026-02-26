<div class="max-w-md mx-auto space-y-5">
    @foreach ($sleepEntries as $entry)
        <div class="space-y-3">
            <flux:heading size="lg">
                {{ $entry->sleep_date }}
            </flux:heading>

            @if ($entry->in_bed_by && $entry->awake_at)
                <flux:text>
                    In bed by {{ $entry->in_bed_by->format('h:i A') }}, awake at {{ $entry->awake_at->format('h:i A') }} ({{ $entry->sleep_length }})
                </flux:text>
            @elseif ($entry->in_bed_by)
                <flux:text>
                    In bed by {{ $entry->in_bed_by->format('h:i A') }}
                </flux:text>
            @elseif ($entry->awake_at)
                <flux:text>
                    Awake at {{ $entry->awake_at->format('h:i A') }}
                </flux:text>
            @endif

            @if ($entry->temperature)
                <flux:text size="sm"><i>{{ $entry->temperature }}&deg;F</i></flux:text>
            @endif

            <flux:text>{{ $entry->notes }}</flux:text>
            <div class="flex">
                @if ($entry->rating)
                    <flux:icon.star variant="solid" />
                @else
                    <flux:icon.star />
                @endif

                @if ($entry->rating >= 2)
                    <flux:icon.star variant="solid" />
                @else
                    <flux:icon.star />
                @endif

                @if ($entry->rating >= 3)
                    <flux:icon.star variant="solid" />
                @else
                    <flux:icon.star />
                @endif

                @if ($entry->rating >= 4)
                    <flux:icon.star variant="solid" />
                @else
                    <flux:icon.star />
                @endif

                @if ($entry->rating === 5)
                    <flux:icon.star variant="solid" />
                @else
                    <flux:icon.star />
                @endif
            </div>
        </div>
        @unless ($loop->last)
            <flux:separator />
        @endunless
    @endforeach
    @if ($sleepEntries->isEmpty())
        <flux:card class="space-y-4">
            <flux:heading size="lg">No entries found</flux:heading>
            <flux:text>Create your first sleep entry</flux:text>
            <flux:button variant="primary" icon="pencil">Get Started</flux:button>
        </flux:card>
    @endif
</div>
