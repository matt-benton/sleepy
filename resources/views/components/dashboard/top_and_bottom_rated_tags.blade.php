@php

    $categories = auth()->user()->tags()
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
        @if ($categories->isNotEmpty())
            <ul class="space-y-1">
                @foreach ($categories->sortByDesc('avg_rating')->splice(0, 3) as $cat)
                    <li class="flex justify-between"><flux:badge color="emerald" rounded><span>{{ $cat->name }}</span></flux:badge> <span>{{ $cat->avg_rating }}</span></li>
                @endforeach
            </ul>
        @else
            <flux:text variant="subtle" size="xl">None</flux:text>
        @endif
    </div>
    <div class="w-full">
        <flux:text class="mb-2">Lowest Rated Tags</flux:text>
        @if ($categories->isNotEmpty())
            <ul class="space-y-1">
                @foreach ($categories->sortBy('avg_rating')->splice(0, 3) as $cat)
                    <li class="flex justify-between"><flux:badge color="rose" rounded><span>{{ $cat->name }}</span></flux:badge> <span>{{ $cat->avg_rating }}</span></li>
                @endforeach
            </ul>
        @else
            <flux:text variant="subtle" size="xl">None</flux:text>
        @endif
    </div>
</flux:card>
