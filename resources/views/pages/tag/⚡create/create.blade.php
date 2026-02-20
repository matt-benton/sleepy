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
        <flux:card class="max-w-sm mx-auto">
            <form wire:submit="save" class="space-y-4">
                <flux:heading size="lg">Add a New Tag</flux:heading>
                <flux:input label="Name" wire:model="name" autocomplete="off" autofocus />
                <div class="flex justify-end">
                    <flux:button type="submit" variant="primary">Save</flux:button>
                </div>
            </form>
        </flux:card>
    </flux:main>
</div>
