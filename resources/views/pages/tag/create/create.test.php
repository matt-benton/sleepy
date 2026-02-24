<?php

use App\Models\Tag;
use App\Models\User;
use Livewire\Livewire;

it('renders successfully', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test('pages::tag.create')
        ->assertStatus(200);
});

it('can create a tag', function () {
    $user = User::factory()->create();

    expect(Tag::count())->toBe(0);

    Livewire::actingAs($user)
        ->test('pages::tag.create')
        ->set('name', 'sleep apnea')
        ->call('save');

    expect(Tag::count())->toBe(1);
});
