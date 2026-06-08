<div>
    <livewire:tag.sidebar :tags="$tags" />
    <flux:main container>
        @if (session('message'))
            <div class="p-4 bg-green-300 rounded-lg">
                {{ session('message') }}
            </div>
        @endif
        <flux:card class="max-w-sm mx-auto">
            <form wire:submit="save" class="space-y-4">
                <flux:heading size="lg">Edit Tag</flux:heading>
                <flux:input label="Name" wire:model="name" autocomplete="off" autofocus />
                <flux:textarea label="Description" wire:model="description" maxlength="255" autocomplete="off" />
                <div class="flex justify-end">
                    <flux:button type="submit" variant="primary">Save</flux:button>
                </div>
            </form>
        </flux:card>
    </flux:main>
</div>
