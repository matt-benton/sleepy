<?php

use Livewire\Component;

new class extends Component
{
    public $sleepEntries = [];

    public function mount()
    {
        $this->sleepEntries = auth()->user()->sleepEntries;
    }
};
