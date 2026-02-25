<?php

use App\Models\Tag;
use App\Models\User;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::actingAs(User::factory()->create())
        ->test('pages::tag.edit')
        ->assertStatus(200);
});

it('can edit a tag', function () {
    $user = User::factory()
        ->has(Tag::factory()->state(['name' => 'Test']))
        ->create();

    $tag = $user->tags[0];

    Livewire::actingAs($user)
        ->test('pages::tag.edit', ['tag' => $tag])
        ->set('name', 'Renamed')
        ->call('save');

    expect($tag->fresh()->name)->toBe('Renamed');
});
