<?php

use App\Models\SleepEntry;
use App\Models\User;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('pages::sleep_entry.create')
        ->assertStatus(200);
});

it('can create a sleep entry', function () {
    $user = User::factory()->create();

    expect(SleepEntry::count())->toBe(0);

    Livewire::actingAs($user)
        ->test('pages::sleep_entry.create')
        ->set('inBedBy', '2026-02-26 23:30:00')
        ->set('awakeAt', '2026-02-27 06:05:00')
        ->set('temperature', '67')
        ->set('rating', '5')
        ->set('notes', 'Had a wonderful sleep last night')
        ->call('save');

    expect(SleepEntry::count())->toBe(1);
});
