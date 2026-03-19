<?php

use Livewire\Attributes\On;
use Livewire\Component;

new class extends Component
{
    public $inBedByDate = '';

    public $inBedByTime = '';

    public $awakeAtDate = '';

    public $awakeAtTime = '';

    public $temperature = '';

    public $rating = '';

    public $notes = '';

    public $tagIds = [];

    public $tags = [];

    public $keyPoints = [];

    public $newKeyPointPositive;

    public string $newKeyPointText = '';

    public function mount()
    {
        $yesterdayAt10Pm = now()->subDay()->setTime(22, 00, 00);
        $todayAt6Am = now()->setTime(6, 00, 00);
        $this->inBedByDate = $yesterdayAt10Pm->toDateString();
        $this->inBedByTime = $yesterdayAt10Pm->format('H:i');
        $this->awakeAtDate = $todayAt6Am->toDateString();
        $this->awakeAtTime = $todayAt6Am->format('H:i');

        $this->tags = auth()->user()->tags;

        $this->newKeyPointPositive = 1;
    }

    protected function rules()
    {
        return [
            'inBedByDate' => 'date|required_with:inBedByTime',
            'inBedByTime' => 'required_with:inBedByDate',
            'awakeAtDate' => 'date|required_with:awakeAtTime',
            'awakeAtTime' => 'required_with:awakeAtDate',
            'temperature' => 'numeric|between:-127,128',
            'rating' => 'numeric|between:1,5',
            'tagIds' => 'array',
            'tagIds.*' => 'exists:tags,id',
            'keyPoints' => 'array',
            'keyPoints.*.is_positive' => 'boolean',
            'keyPoints.*.text' => 'required',
        ];
    }

    public function save()
    {
        $this->validate();

        $sleepEntry = auth()->user()->sleepEntries()->create([
            'in_bed_by' => $this->inBedByDate.' '.$this->inBedByTime,
            'awake_at' => $this->awakeAtDate.' '.$this->awakeAtTime,
            'temperature' => $this->temperature,
            'rating' => $this->rating,
            'notes' => $this->notes,
        ]);

        $sleepEntry->tags()->attach($this->tagIds);
        $sleepEntry->keyPoints()->createMany($this->keyPoints);

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

    #[On('update-rating')]
    public function setRating($rating)
    {
        $this->rating = $rating;
    }

    public function addKeyPoint()
    {
        array_push(
            $this->keyPoints,
            ['is_positive' => $this->newKeyPointPositive, 'text' => $this->newKeyPointText],
        );

        $this->resetNewPoint();
    }

    public function removeKeyPoint($index)
    {
        array_splice($this->keyPoints, $index, 1);
    }

    private function resetNewPoint()
    {
        $this->newKeyPointText = '';
    }
};
