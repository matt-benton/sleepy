<div class="grid grid-cols-3 grid-rows-2">
    <flux:text>With Tag</flux:text>
    <flux:text>Without Tag</flux:text>
    <flux:text>Difference</flux:text>

    <flux:heading size="xl">{{ round($avgRatingWithTag, 1) }}</flux:heading>
    <flux:heading size="xl">{{ round($avgRatingWithoutTag, 1) }}</flux:heading>

    @if ($difference > 0)
        <flux:heading size="xl" class="text-emerald-600 dark:text-emerald-500">+{{ round($difference, 1) }}</flux:heading>
    @elseif ($difference < 0)
        <flux:heading size="xl" class="text-rose-600 dark:text-rose-500">{{ round($difference, 1) }}</flux:heading>
    @else
        <flux:heading size="xl">None</flux:heading>
    @endif
</div>
