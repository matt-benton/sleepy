<?php

use App\Livewire\Forms\SleepEntryForm;
use Livewire\Attributes\On;
use Livewire\Component;

new class extends Component
{
    public SleepEntryForm $form;

    public function mount()
    {
        $this->form->setSleepEntry();
    }

    public function save()
    {
        $this->form->store();

        return redirect()->route('sleep_entry.index');
    }

    public function clearInBedByDates()
    {
        $this->form->clearInBedByDates();
    }

    public function clearAwakeAtDates()
    {
        $this->form->clearAwakeAtDates();
    }

    #[On('update-rating')]
    public function setRating($rating)
    {
        $this->form->rating = $rating;
    }

    public function addKeyPoint()
    {
        $this->form->addKeyPoint();
    }

    public function removeKeyPoint($index)
    {
        $this->form->removeKeyPoint($index);
    }
};
