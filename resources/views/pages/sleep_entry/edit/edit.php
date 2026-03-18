<?php

use App\Models\SleepEntry;
use Flux\Flux;
use Livewire\Attributes\On;
use Livewire\Component;

new class extends Component
{
    public SleepEntry $sleepEntry;

    public Illuminate\Database\Eloquent\Collection $tags;

    public array $tagIds = [];

    public $inBedByDate = '';

    public $inBedByTime = '';

    public $awakeAtDate = '';

    public $awakeAtTime = '';

    public $temperature = '';

    public $rating = '';

    public $notes = '';

    public function mount(SleepEntry $sleepEntry)
    {
        $this->authorize('update', $sleepEntry);

        $this->sleepEntry = $sleepEntry;

        $this->inBedByDate = $sleepEntry->in_bed_by->toDateString();
        $this->inBedByTime = $sleepEntry->in_bed_by->format('H:i');
        $this->awakeAtDate = $sleepEntry->awake_at->toDateString();
        $this->awakeAtTime = $sleepEntry->awake_at->format('H:i');
        $this->temperature = $sleepEntry->temperature;
        $this->notes = $sleepEntry->notes;
        $this->rating = $sleepEntry->rating;
        $this->tagIds = $sleepEntry->tags->pluck('id')->toArray();

        $this->tags = auth()->user()->tags;
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
        ];
    }

    public function delete()
    {
        $this->authorize('delete', $this->sleepEntry);

        $this->sleepEntry->delete();

        Flux::toast(variant: 'success', text: 'Entry has been deleted');

        return back();
    }

    public function restore()
    {
        $this->authorize('restore', $this->sleepEntry);

        $this->sleepEntry->restore();

        Flux::toast(variant: 'success', text: 'Entry has been restored');

        return back();
    }

    public function save()
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

        Flux::toast(variant: 'success', text: 'Entry has been updated');

        return back();
    }

    #[On('update-rating')]
    public function setRating($rating)
    {
        $this->rating = $rating;
    }
};
