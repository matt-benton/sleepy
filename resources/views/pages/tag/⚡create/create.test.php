<?php

use App\Models\Tag;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('pages::tag.create')
        ->assertStatus(200);
});

it('can create a tag', function () {
    expect(Tag::count())->toBe(0);

    Livewire::test('pages::tag.create')
        ->set('name', 'sleep apnea')
        ->call('save');

    expect(Tag::count())->toBe(1);
});
