<?php

use App\Models\SleepEntry;
use App\Models\Tag;
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

it('can update a sleep entry', function () {
    $user = User::factory()->create();
    $tags = Tag::factory()
        ->for($user)
        ->count(3)
        ->create();

    $sleepEntry = SleepEntry::factory()
        ->for($user)
        ->hasAttached($tags[1])
        ->hasAttached($tags[2])
        ->create();

    Livewire::actingAs($sleepEntry->user)
        ->test('pages::sleep_entry.edit', ['sleepEntry' => $sleepEntry])
        ->set('inBedByDate', '2026-01-01')
        ->set('inBedByTime', '20:30')
        ->set('awakeAtDate', '2026-01-02')
        ->set('awakeAtTime', '7:35')
        ->set('temperature', '71')
        ->set('rating', '2')
        ->set('notes', '<p>This is a test</p>')
        ->set('tagIds', [$tags[0]->id])
        ->call('save');

    $sleepEntry->refresh();

    expect($sleepEntry->in_bed_by->toDateTimeString())->toBe('2026-01-01 20:30:00');
    expect($sleepEntry->awake_at->toDateTimeString())->toBe('2026-01-02 07:35:00');
    expect($sleepEntry->temperature)->toBe(71);
    expect($sleepEntry->rating)->toBe(2);
    expect($sleepEntry->notes)->toBe('<p>This is a test</p>');
    expect($sleepEntry->tags->count())->toBe(1);
    expect($sleepEntry->tags[0]->id)->toBe($tags[0]->id);
});

it('can set the rating', function () {
    $sleepEntry = SleepEntry::factory()
        ->for(User::factory())
        ->state(['rating' => 1])
        ->create();

    Livewire::actingAs($sleepEntry->user)
        ->test('pages::sleep_entry.edit', ['sleepEntry' => $sleepEntry])
        ->call('setRating', 5)
        ->assertSet('rating', 5);
});
