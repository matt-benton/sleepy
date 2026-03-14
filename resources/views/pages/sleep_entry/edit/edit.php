<?php

use App\Models\SleepEntry;
use Livewire\Component;

new class extends Component
{
    public SleepEntry $sleepEntry;

    public function mount(SleepEntry $sleepEntry)
    {
        $this->authorize('update', $sleepEntry);

        $this->sleepEntry = $sleepEntry;
    }

    public function delete()
    {
        $this->authorize('delete', $this->sleepEntry);

        $this->sleepEntry->delete();

        return back();
    }

    public function restore()
    {
        $this->authorize('restore', $this->sleepEntry);

        $this->sleepEntry->restore();

        return back();
    }
};
