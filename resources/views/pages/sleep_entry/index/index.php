<?php

use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    #[Url]
    public string $day_of_week = '';

    #[Computed]
    public function sleepEntries()
    {
        return auth()->user()
            ->sleepEntries()
            ->when($this->day_of_week || $this->day_of_week == 0, function ($query) {
                $query->whereRaw("strftime('%w', sleep_entries.awake_at) = ?", [$this->day_of_week]);
            })
            ->paginate()
            ->withQueryString();
    }

    #[Computed]
    public function formattedDayOfWeek()
    {
        switch ($this->day_of_week) {
            case 0:
                return 'Sunday';

            case 1:
                return 'Monday';

            case 2:
                return 'Tuesday';

            case 3:
                return 'Wednesday';

            case 4:
                return 'Thursday';

            case 5:
                return 'Friday';

            case 6:
                return 'Saturday';

            default:
                return '';
        }
    }
};
