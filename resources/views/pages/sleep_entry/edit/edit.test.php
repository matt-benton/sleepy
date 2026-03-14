<?php

use App\Models\SleepEntry;
use App\Models\User;
use Livewire\Livewire;

it('renders successfully', function () {
    $sleepEntry = SleepEntry::factory()
        ->for(User::factory())
        ->make();

    Livewire::actingAs($sleepEntry->user)
        ->test('pages::sleep_entry.edit', ['sleepEntry' => $sleepEntry])
        ->assertStatus(200);
});

it('can only be accessed by user with ownership', function () {
    $sleepEntry = SleepEntry::factory()
        ->for(User::factory())
        ->make();

    $anotherUser = User::factory()->make();

    Livewire::actingAs($anotherUser)
        ->test('pages::sleep_entry.edit', ['sleepEntry' => $sleepEntry])
        ->assertStatus(403);
});

it('can delete a sleep entry', function () {
    $sleepEntry = SleepEntry::factory()
        ->for(User::factory())
        ->create();

    Livewire::actingAs($sleepEntry->user)
        ->test('pages::sleep_entry.edit', ['sleepEntry' => $sleepEntry])
        ->call('delete')
        ->assertStatus(200);

    $this->assertNotNull($sleepEntry->fresh()->deleted_at);
});

it('can restore a sleep entry', function () {
    $sleepEntry = SleepEntry::factory()
        ->for(User::factory())
        ->state(['deleted_at' => '2026-01-01 01:00:00'])
        ->create();

    Livewire::actingAs($sleepEntry->user)
        ->test('pages::sleep_entry.edit', ['sleepEntry' => $sleepEntry])
        ->call('restore')
        ->assertStatus(200);

    $this->assertNull($sleepEntry->fresh()->deleted_at);
});
