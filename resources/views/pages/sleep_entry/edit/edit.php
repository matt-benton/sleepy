<?php

use App\Livewire\Forms\SleepEntryForm;
use App\Models\SleepEntry;
use Flux\Flux;
use Livewire\Attributes\On;
use Livewire\Component;

new class extends Component
{
    public SleepEntryForm $form;

    public SleepEntry $sleepEntry;

    public function mount(SleepEntry $sleepEntry)
    {
        $this->authorize('update', $sleepEntry);

        $this->form->setSleepEntry($sleepEntry);
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
        $this->form->update();

        Flux::toast(variant: 'success', text: 'Entry has been updated');

        return back();
    }

    #[On('update-rating')]
    public function setRating($rating)
    {
        $this->form->rating = $rating;
    }

    public function clearInBedByDates()
    {
        $this->form->clearInBedByDates();
    }

    public function clearAwakeAtDates()
    {
        $this->form->clearAwakeAtDates();
    }

    public function addKeyPoint()
    {
        $this->form->addKeyPoint();
    }

    public function removeKeyPoint($index)
    {
        $this->form->removeKeyPoint($index);
    }

    public function createTag()
    {
        $this->form->createTag();
    }
};
