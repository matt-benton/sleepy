<?php

use App\Models\SleepEntry;
use App\Models\User;
use Livewire\Livewire;

it('renders successfully', function () {
    $sleepEntry = SleepEntry::factory()
        ->for(User::factory())
        ->make();

    Livewire::actingAs($sleepEntry->user)
        ->test('pages::sleep_entry.show', ['sleepEntry' => $sleepEntry])
        ->assertStatus(200);
});

it('can only be accessed by user with ownership', function () {
    $sleepEntry = SleepEntry::factory()
        ->for(User::factory())
        ->make();

    $anotherUser = User::factory()->make();

    Livewire::actingAs($anotherUser)
        ->test('pages::sleep_entry.show', ['sleepEntry' => $sleepEntry])
        ->assertStatus(403);
});
