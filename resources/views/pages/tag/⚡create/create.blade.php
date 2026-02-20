<div>
    <div class="w-72 mx-auto">
        <form wire:submit="save">
            <flux:heading size="lg" class="mb-2">Add a New Tag</flux:heading>
            <flux:input label="Name" wire:model="name" autocomplete="off" />
            <flux:button type="submit" class="mt-2">Save</flux:button>
        </form>
    </div>
</div>