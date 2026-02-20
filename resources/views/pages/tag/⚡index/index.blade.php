<div>
    <flux:sidebar sticky>
        <flux:sidebar.nav>
            <flux:sidebar.item href="/tags/create" icon="plus" wire:navigate>
                New Tag
            </flux:sidebar.item>
            @foreach ($tags as $tag)
                <flux:sidebar.item href="/tags/{{ $tag->id }}" icon="tag" wire:navigate>
                    {{ $tag->name }}
                </flux:navlist.item>
            @endforeach
        </flux:sidebar.nav>
    </flux:sidebar>
    <flux:main container>
        <flux:card class="space-y-6 max-w-lg mx-auto">
            <flux:heading level="2" size="xl">Tags</flux:heading>
            <flux:text>Tags can be added to each sleep entry to help with grouping and filtering</flux:text>
            <flux:button variant="primary" href="/tags/create" icon="plus">
                New Tag
            </flux:button>
        </flux:card>
    </flux:main>
</div>
