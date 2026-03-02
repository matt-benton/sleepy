<?php

use Livewire\Attributes\Validate;
use Livewire\Component;

new class extends Component
{
    #[Validate('date|required_with:inBedByTime')]
    public $inBedByDate = '';

    #[Validate('required_with:inBedByDate')]
    public $inBedByTime = '';

    #[Validate('date|required_with:awakeAtTime')]
    public $awakeAtDate = '';

    #[Validate('required_with:awakeAtDate')]
    public $awakeAtTime = '';

    #[Validate('numeric|between:-127,128')]
    public $temperature = '';

    #[Validate('numeric|between:1,5')]
    public $rating = '';

    public $notes = '';

    public function mount()
    {
        $yesterdayAt10Pm = now()->subDay()->setTime(22, 00, 00);
        $todayAt6Am = now()->setTime(6, 00, 00);
        $this->inBedByDate = $yesterdayAt10Pm->toDateString();
        $this->inBedByTime = $yesterdayAt10Pm->format('H:i');
        $this->awakeAtDate = $todayAt6Am->toDateString();
        $this->awakeAtTime = $todayAt6Am->format('H:i');
    }

    public function save()
    {
        $this->validate();

        auth()->user()->sleepEntries()->create([
            'in_bed_by' => $this->inBedByDate.' '.$this->inBedByTime,
            'awake_at' => $this->awakeAtDate.' '.$this->awakeAtTime,
            'temperature' => $this->temperature,
            'rating' => $this->rating,
            'notes' => $this->notes,
        ]);

        return redirect()->route('sleep_entry.index');
    }

    public function clearInBedByDates()
    {
        $this->inBedByDate = '';
        $this->inBedByTime = '';
    }

    public function clearAwakeAtDates()
    {
        $this->awakeAtDate = '';
        $this->awakeAtTime = '';
    }

    public function setRating($rating)
    {
        $this->rating = $rating;
    }
};
