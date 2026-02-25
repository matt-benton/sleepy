<?php

use App\Models\Tag;
use Livewire\Attributes\Validate;
use Livewire\Component;

new class extends Component
{
    public Tag $tag;

    public $tags = [];

    #[Validate('required|max:30')]
    public $name = '';

    public function mount(Tag $tag)
    {
        $this->tag = $tag;
        $this->tags = auth()->user()->tags;
        $this->name = $tag->name;
    }

    public function save()
    {
        $this->validate();

        $this->tag->name = $this->name;
        $this->tag->save();

        $this->dispatch('tag-updated');

        return back();
    }
};
