<div>
    <livewire:tag.sidebar :tags="$tags" />
    <flux:main container>
        <div class="space-y-4">
            <flux:heading size="xl" level="2">{{ $tag->name }}</flux:heading>
            <flux:text>{{ $tag->description }}</flux:heading>
            @if ($tag->trashed())
                <flux:card class="bg-red-200 dark:bg-red-400 flex justify-between">
                    <div class="flex items-center">
                        <flux:icon.exclamation-triangle variant="mini" class="mr-2" />
                        <flux:text>
                            This tag has been deleted
                        </flux:text>
                    </div>
                    <div class="flex items-center">
                        <flux:button size="sm" variant="ghost" wire:click="restore">Restore</flux:button>
                    </div>
                </flux:card>
            @else
                <flux:button href="/tags/{{ $tag->id }}/edit" variant="primary" icon="pencil" wire:navigate>
                    Edit
                </flux:button>
                <flux:button icon="trash" class="cursor-pointer" wire:click="delete">
                    Remove
                </flux:button>
                @if ($tag->sleepEntries->isNotEmpty())
                    <flux:card>
                        <flux:heading class="mb-2">Average Sleep Rating</flux:heading>
                        <x-tag.rating-diff :tag="$tag" />
                    </flux:card>
                @endif
                <flux:card class="space-y-10">
                    @if ($tag->sleepEntries->isNotEmpty())
                        @foreach ($tag->sleepEntries as $entry)
                            <x-sleep-entry-display :sleep-entry="$entry" />
                        @endforeach
                    @else
                        <flux:text>No sleep entries belong to this tag</flux:text>
                    @endif
                </flux:card>
            @endif
        </div>
    </flux:main>
</div>
