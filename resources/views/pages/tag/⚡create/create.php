<?php

use App\Models\Tag;
use Illuminate\Http\Request;
use Livewire\Attributes\Validate;
use Livewire\Component;

new class extends Component
{
    #[Validate('required|max:30')]
    public $name = '';

    public function save(Request $request)
    {
        $this->validate();

        $tag = new Tag;
        $tag->name = $this->name;
        $request->user()->tags()->save($tag);

        return redirect()->route('tag.index');
    }
};
