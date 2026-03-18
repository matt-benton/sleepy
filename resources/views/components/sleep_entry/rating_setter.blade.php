<?php

use Livewire\Attributes\Reactive;
use Livewire\Component;

new class extends Component
{
    #[Reactive]
    public $rating;

    public function updateRating($newRating)
    {
        $this->dispatch('update-rating', rating: $newRating);
    }
};
?>

<div>
    <flux:field>
        <flux:label>Rating</flux:label>
        <div class="flex">
            @if ($this->rating >= 1)
                <flux:icon.star variant="solid" wire:click="updateRating(1)" />
            @else
                <flux:icon.star wire:click="updateRating(1)" />
            @endif

            @if ($this->rating >= 2)
                <flux:icon.star variant="solid" wire:click="updateRating(2)" />
            @else
                <flux:icon.star wire:click="updateRating(2)" />
            @endif

            @if ($this->rating >= 3)
                <flux:icon.star variant="solid" wire:click="updateRating(3)" />
            @else
                <flux:icon.star wire:click="updateRating(3)" />
            @endif

            @if ($this->rating >= 4)
                <flux:icon.star variant="solid" wire:click="updateRating(4)" />
            @else
                <flux:icon.star wire:click="updateRating(4)" />
            @endif

            @if ($this->rating === 5)
                <flux:icon.star variant="solid" wire:click="updateRating(5)" />
            @else
                <flux:icon.star wire:click="updateRating(5)" />
            @endif
        </div>
        <flux:error name="rating" />
    </flux:field>
</div>
