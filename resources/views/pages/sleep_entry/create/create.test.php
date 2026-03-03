<?php

use App\Models\Tag;
use App\Models\User;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::actingAs(User::factory()->make())
        ->test('pages::sleep_entry.create')
        ->assertStatus(200);
});

it('can create a sleep entry', function () {
    $user = User::factory()
        ->has(Tag::factory()->count(5))
        ->create();

    expect($user->sleepEntries()->count())->toBe(0);

    Livewire::actingAs($user)
        ->test('pages::sleep_entry.create')
        ->set('inBedByDate', '2026-02-26')
        ->set('inBedByTime', '23:30')
        ->set('awakeAtDate', '2026-02-27')
        ->set('awakeAtTime', '06:05')
        ->set('temperature', '67')
        ->set('rating', '5')
        ->set('notes', 'Had a wonderful sleep last night')
        ->set('tagIds', [$user->tags[1]->id, $user->tags[4]->id])
        ->call('save');

    expect($user->sleepEntries()->count())->toBe(1);

    $newSleepEntry = $user->sleepEntries[0];

    expect($newSleepEntry->in_bed_by->toDateTimeString())->toBe('2026-02-26 23:30:00');
    expect($newSleepEntry->awake_at->toDateTimeString())->toBe('2026-02-27 06:05:00');
    expect($newSleepEntry->temperature)->toBe(67);
    expect($newSleepEntry->rating)->toBe(5);
    expect($newSleepEntry->notes)->toBe('Had a wonderful sleep last night');

    expect($newSleepEntry->tags->pluck('id'))->toContain($user->tags[1]->id);
    expect($newSleepEntry->tags->pluck('id'))->toContain($user->tags[4]->id);
    expect($newSleepEntry->tags->pluck('id'))->not()->toContain($user->tags[0]->id);
    expect($newSleepEntry->tags->pluck('id'))->not()->toContain($user->tags[2]->id);
    expect($newSleepEntry->tags->pluck('id'))->not()->toContain($user->tags[3]->id);
});
