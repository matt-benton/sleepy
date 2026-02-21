<div>
    <flux:sidebar sticky>
        <flux:sidebar.nav>
            <flux:sidebar.item href="/tags/create" icon="plus" wire:navigate>
                New Tag
            </flux:sidebar.item>
            @foreach ($tags as $t)
                <flux:sidebar.item href="/tags/{{ $t->id }}" icon="tag" wire:navigate>
                    {{ $t->name }}
                </flux:sidebar.item>
            @endforeach
        </flux:sidebar.nav>
    </flux:sidebar>
    <flux:main container>
        <div class="space-y-4">
            <flux:heading size="xl" level="2">{{ $tag->name }}</flux:heading>
            <flux:card>
                <flux:heading size="lg">Sleeps</flux:heading>
                <flux:text class="mt-2">List of sleeps will go here</flux:text>
            </flux:card>
            <flux:button href="/tags/{{ $tag->id }}/edit" variant="primary" icon="pencil">
                Rename
            </flux:button>
            <flux:button icon="trash">
                Remove
            </flux:button>
        </div>
    </flux:main>
</div>
