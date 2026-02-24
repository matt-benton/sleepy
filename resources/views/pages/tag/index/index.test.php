<?php

use App\Models\User;
use Livewire\Livewire;

it('renders successfully', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)->test('pages::tag.index')
        ->assertStatus(200);
});
