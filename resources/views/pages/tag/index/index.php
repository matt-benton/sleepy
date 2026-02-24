<?php

use Livewire\Component;

new class extends Component
{
    public $tags = [];

    public function mount()
    {
        $this->tags = auth()->user()->tags;
    }
};
