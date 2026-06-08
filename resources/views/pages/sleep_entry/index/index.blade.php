<div class="max-w-md mx-auto space-y-5">
    <div class="flex justify-end">
        <flux:button variant="primary" icon="plus" href="/sleep_entries/create" wire:navigate>New Entry</flux:button>
    </div>
    @foreach ($this->sleepEntries as $entry)
        <x-sleep-entry-display :sleep-entry="$entry" />

        @unless ($loop->last)
            <flux:separator />
        @endunless
    @endforeach

    <flux:pagination :paginator="$this->sleepEntries" />

    @if ($this->sleepEntries->isEmpty())
        <flux:card class="space-y-4">
            <flux:heading size="lg">No entries found</flux:heading>
            <flux:text>Create your first sleep entry</flux:text>
            <flux:button variant="primary" icon="pencil" href="/sleep_entries/create">Get Started</flux:button>
        </flux:card>
    @endif
</div>
