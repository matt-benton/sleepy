<div>
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="/sleep_entries" wire:navigate>Sleep Entries</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="/sleep_entries/{{ $sleepEntry->id }}" wire:navigate>{{ $sleepEntry->sleep_date }}</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>Edit Entry</flux:breadcrumbs.item>
    </flux:breadcrumbs>
    @unless ($sleepEntry->trashed())
        <flux:button wire:click="delete" icon="trash">Delete</flux:button>
    @else
        <flux:button wire:click="restore" icon="arrow-up-left">Restore</flux:button>
    @endunless
</div>
