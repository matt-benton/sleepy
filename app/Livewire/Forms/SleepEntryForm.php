<?php

namespace App\Livewire\Forms;

use App\Models\SleepEntry;
use App\Models\Tag;
use Livewire\Form;

class SleepEntryForm extends Form
{
    public ?SleepEntry $sleepEntry;

    public $inBedByDate = '';

    public $inBedByTime = '';

    public $awakeAtDate = '';

    public $awakeAtTime = '';

    public $temperature = '';

    public $rating = '';

    public $notes = '';

    public $tagIds = [];

    public $tagSearch = '';

    public $tags = [];

    public $keyPoints = [];

    public $newKeyPointPositive;

    public string $newKeyPointText = '';

    public function setSleepEntry(?SleepEntry $sleepEntry = null)
    {
        $this->sleepEntry = $sleepEntry;

        $yesterdayAt10Pm = now()->subDay()->setTime(22, 00, 00);
        $todayAt6Am = now()->setTime(6, 00, 00);

        $this->inBedByDate = $sleepEntry ? $sleepEntry->in_bed_by->toDateString() : $yesterdayAt10Pm->toDateString();
        $this->inBedByTime = $sleepEntry ? $sleepEntry->in_bed_by->format('H:i') : $yesterdayAt10Pm->format('H:i');
        $this->awakeAtDate = $sleepEntry ? $sleepEntry->awake_at->toDateString() : $todayAt6Am->toDateString();
        $this->awakeAtTime = $sleepEntry ? $sleepEntry->awake_at->format('H:i') : $todayAt6Am->format('H:i');
        $this->temperature = $sleepEntry ? $sleepEntry->temperature : '';
        $this->rating = $sleepEntry ? $sleepEntry->rating : '';
        $this->notes = $sleepEntry ? $sleepEntry->notes : '';
        $this->tagIds = $sleepEntry ? $sleepEntry->tags->pluck('id') : [];
        $this->keyPoints = $sleepEntry ?
            $sleepEntry->keyPoints()
                ->select(['id', 'is_positive', 'text'])
                ->get()->toArray()
            : [];

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

    public function store()
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
    }

    public function update()
    {
        $this->validate();

        $this->sleepEntry->update([
            'in_bed_by' => $this->inBedByDate.' '.$this->inBedByTime,
            'awake_at' => $this->awakeAtDate.' '.$this->awakeAtTime,
            'temperature' => $this->temperature,
            'rating' => $this->rating,
            'notes' => $this->notes,
        ]);

        $this->sleepEntry->tags()->sync($this->tagIds);

        $remainingKeyPoints = array_filter($this->keyPoints, fn ($keyPoint) => array_key_exists('id', $keyPoint));
        $newKeyPoints = array_filter($this->keyPoints, fn ($keyPoint) => ! array_key_exists('id', $keyPoint));

        $remainingKeyPointIds = array_column($remainingKeyPoints, 'id');

        foreach ($this->sleepEntry->keyPoints as $keyPoint) {
            if (! in_array($keyPoint->id, $remainingKeyPointIds)) {
                $keyPoint->delete();
            }
        }

        foreach ($newKeyPoints as $newKeyPoint) {
            $this->sleepEntry->keyPoints()->create($newKeyPoint);
        }
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

    public function addKeyPoint()
    {
        array_push(
            $this->keyPoints,
            ['is_positive' => $this->newKeyPointPositive, 'text' => $this->newKeyPointText],
        );

        $this->reset('newKeyPointText');
    }

    public function removeKeyPoint($index)
    {
        array_splice($this->keyPoints, $index, 1);
    }

    // FIXME: this is not validated
    public function createTag()
    {
        $tag = new Tag;
        $tag->name = $this->tagSearch;
        auth()->user()->tags()->save($tag);

        $this->tagIds[] = $tag->id;
        $this->tags[] = $tag;
    }
}
