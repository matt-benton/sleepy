<?php

use Livewire\Component;

new class extends Component
{
    public $tags;
};
?>

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
