<div>
    <a href="/tags/create" wire:navigate class="bg-blue-500 rounded-xl p-2">New Tag</a>
    <ul>
        @foreach ($tags as $tag)
            <li>{{ $tag->name }}</li>
        @endforeach
    </ul>
</div>
