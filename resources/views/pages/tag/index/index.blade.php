<div>
    <livewire:tag.sidebar :tags="$tags" />
    <flux:main container>
        <flux:card class="space-y-6 max-w-lg mx-auto">
            <flux:heading level="2" size="xl">Tags</flux:heading>
            <flux:text>Tags can be added to each sleep entry to help with grouping and filtering</flux:text>
            <flux:button variant="primary" href="/tags/create" icon="plus" wire:navigate>
                New Tag
            </flux:button>
        </flux:card>
    </flux:main>
</div>
