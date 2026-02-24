<?php

use App\Models\Tag;
use App\Models\User;
use Livewire\Livewire;

it('renders successfully', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test('pages::tag.show')
        ->assertStatus(200);
});

it('can delete a tag', function () {
    $user = User::factory()
        ->has(Tag::factory())
        ->create();
    $tag = $user->tags[0];

    Livewire::actingAs($user)
        ->test('pages::tag.show', ['tag' => $tag])
        ->call('delete');

    expect($tag->fresh()->trashed())->toBeTrue();
});

it('can restore a tag', function () {
    $user = User::factory()
        ->has(Tag::factory())
        ->create();
    $tag = $user->tags[0];
    $tag->delete();

    Livewire::actingAs($user)
        ->test('pages::tag.show', ['tag' => $tag])
        ->call('restore');

    expect($tag->fresh()->trashed())->toBeFalse();
});
