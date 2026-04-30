<div>
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="/sleep_entries" wire:navigate>Sleep Entries</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>{{ $sleepEntry->sleep_date }}</flux:breadcrumbs.item>
    </flux:breadcrumbs>
    <div class="max-w-md mx-auto mt-7 space-y-5">
        <x-sleep-entry-display :sleep-entry="$sleepEntry" />

        <flux:button href="/sleep_entries/{{ $sleepEntry->id }}/edit" icon="pencil" wire:navigate>Edit</flux:button>
    </div>
</div>
