<?php

use App\Models\SleepEntry;
use Livewire\Component;

new class extends Component
{
    public SleepEntry $sleepEntry;

    public function mount(SleepEntry $sleepEntry)
    {
        $this->authorize('view', $sleepEntry);

        $this->sleepEntry = $sleepEntry;
    }
};
