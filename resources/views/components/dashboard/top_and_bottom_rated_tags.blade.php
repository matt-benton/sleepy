@php

    $tags = auth()->user()->tags()
        ->select(
            'id',
            'name',
            DB::raw('
                ROUND(
                    (
                        SELECT
                            AVG(sleep_entries.rating)
                        FROM sleep_entry_tag
                        JOIN sleep_entries on sleep_entries.id = sleep_entry_tag.sleep_entry_id
                        WHERE tags.id = sleep_entry_tag.tag_id
                    )
                , 1) as avg_rating
            '),
        )
            ->where('avg_rating', '>', 0)
            ->get();

@endphp
<flux:card class="flex col-2 space-between gap-5">
    <div class="w-full">
        <flux:text class="mb-2">Top Rated Tags</flux:text>
        @if ($tags->isNotEmpty())
            <ul class="space-y-1">
                @foreach ($tags->sortByDesc('avg_rating')->splice(0, 3) as $tag)
                    <li class="flex justify-between">
                        <a href="/tags/{{ $tag->id }}" wire:navigate>
                            <flux:badge color="emerald" rounded><span>{{ $tag->name }}</span></flux:badge>
                        </a>
                        <span>{{ $tag->avg_rating }}</span>
                    </li>
                @endforeach
            </ul>
        @else
            <flux:text variant="subtle" size="xl">None</flux:text>
        @endif
    </div>
    <div class="w-full">
        <flux:text class="mb-2">Lowest Rated Tags</flux:text>
        @if ($tags->isNotEmpty())
            <ul class="space-y-1">
                @foreach ($tags->sortBy('avg_rating')->splice(0, 3) as $tag)
                    <li class="flex justify-between">
                        <a href="/tags/{{ $tag->id }}" wire:navigate>
                            <flux:badge color="rose" rounded><span>{{ $tag->name }}</span></flux:badge>
                        </a>
                        <span>{{ $tag->avg_rating }}</span>
                    </li>
                @endforeach
            </ul>
        @else
            <flux:text variant="subtle" size="xl">None</flux:text>
        @endif
    </div>
</flux:card>
