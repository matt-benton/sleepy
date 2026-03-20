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
        ->set('form.inBedByDate', '2026-02-26')
        ->set('form.inBedByTime', '23:30')
        ->set('form.awakeAtDate', '2026-02-27')
        ->set('form.awakeAtTime', '06:05')
        ->set('form.temperature', '67')
        ->set('form.rating', '5')
        ->set('form.notes', 'Had a wonderful sleep last night')
        ->set('form.tagIds', [$user->tags[1]->id, $user->tags[4]->id])
        ->set('form.keyPoints', [
            ['is_positive' => 1, 'text' => 'test 1'],
            ['is_positive' => 0, 'text' => 'test 2'],
        ])
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
    expect($newSleepEntry->keyPoints->count())->toBe(2);
});

it('can add a key point', function () {
    Livewire::actingAs(User::factory()->make())
        ->test('pages::sleep_entry.create')
        ->set('form.newKeyPointPositive', 0)
        ->set('form.newKeyPointText', 'test')
        ->call('addKeyPoint')
        ->assertSet('form.keyPoints', [['is_positive' => 0, 'text' => 'test']]);
});

it('can remove a key point', function () {
    Livewire::actingAs(User::factory()->make())
        ->test('pages::sleep_entry.create')
        ->set('form.keyPoints', [
            ['is_positive' => 1, 'text' => 'test 1'],
            ['is_positive' => 0, 'text' => 'test 2'],
            ['is_positive' => 0, 'text' => 'test 3'],
        ])
        ->call('removeKeyPoint', 1)
        ->assertSet('form.keyPoints', [
            ['is_positive' => 1, 'text' => 'test 1'],
            ['is_positive' => 0, 'text' => 'test 3'],
        ]);
});
