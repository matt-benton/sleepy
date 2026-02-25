<div>
    <livewire:tag.sidebar :tags="$tags" />
    <flux:main container>
        <div class="space-y-4">
            <flux:heading size="xl" level="2">{{ $tag->name }}</flux:heading>
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
                <flux:card>
                    <flux:heading size="lg">Sleeps</flux:heading>
                    <flux:text class="mt-2">List of sleeps will go here</flux:text>
                </flux:card>
                <flux:button href="/tags/{{ $tag->id }}/edit" variant="primary" icon="pencil">
                    Rename
                </flux:button>
                <flux:button icon="trash" class="cursor-pointer" wire:click="delete">
                    Remove
                </flux:button>
            @endif
        </div>
    </flux:main>
</div>
