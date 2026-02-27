<?php

use Livewire\Component;

new class extends Component
{
    public $inBedBy = '';

    public $awakeAt = '';

    public $temperature = '';

    public $rating = '';

    public $notes = '';

    public function save()
    {
        //
        auth()->user()->sleepEntries()->create([
            'in_bed_by' => $this->inBedBy,
            'awake_at' => $this->awakeAt,
            'temperature' => $this->temperature,
            'rating' => $this->rating,
            'notes' => $this->notes,
        ]);
    }
};
