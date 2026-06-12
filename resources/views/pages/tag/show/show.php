<?php

use App\Models\Tag;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    public Tag $tag;

    public $tags = [];

    public string $tab = 'entries';

    public function mount(Tag $tag)
    {
        $this->tag = $tag;
        $this->tags = auth()->user()->tags;
    }

    #[Computed]
    public function sleepEntries()
    {
        return $this->tag->sleepEntries()->paginate();
    }

    #[Computed]
    public function allKeyPoints()
    {
        return $this->sleepEntries->flatMap(fn ($entry) => $entry->keyPoints)
            ->sortByDesc('is_positive');
    }

    public function delete()
    {
        $this->tag->delete();

        return back();
    }

    public function restore()
    {
        $this->tag->restore();

        return back();
    }
};
