<?php

use App\Models\Tag;
use Illuminate\Http\Request;
use Livewire\Attributes\Validate;
use Livewire\Component;

new class extends Component
{
    public $tags = [];

    #[Validate('required|max:30')]
    public $name = '';

    #[Validate('nullable|max:255')]
    public string $description = '';

    public function mount()
    {
        $this->tags = auth()->user()->tags;
    }

    public function save(Request $request)
    {
        $this->validate();

        $tag = new Tag;
        $tag->name = $this->name;
        $tag->description = $this->description;
        $request->user()->tags()->save($tag);

        return redirect()->route('tag.index');
    }
};
