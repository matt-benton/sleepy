<?php

use App\Models\Tag;
use Livewire\Component;

new class extends Component
{
    public Tag $tag;

    public $tags = [];

    public function mount(Tag $tag)
    {
        $this->tag = $tag;
        $this->tags = auth()->user()->tags;
    }

    public function delete()
    {
        $this->tag->delete();

        return back();
    }
};
