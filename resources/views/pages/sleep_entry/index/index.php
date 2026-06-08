<?php

use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    #[Computed]
    public function sleepEntries()
    {
        return auth()->user()->sleepEntries()->paginate();
    }
};
