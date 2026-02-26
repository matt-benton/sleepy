<?php

use App\Models\User;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::actingAs(User::factory()->make())
        ->test('pages::sleep_entry.index')
        ->assertStatus(200);
});
