<?php

use App\Models\SleepEntry;
use App\Models\User;
use Livewire\Livewire;

it('renders successfully', function () {
    $user = User::factory()->make();

    Livewire::actingAs($user)
        ->test('pages::dashboard')
        ->assertStatus(200);
});

it('correctly calculates average in bed by time', function () {
    $user = User::factory()
        ->has(SleepEntry::factory()
            ->state([
                'in_bed_by' => now()->subDays(6)->setHour(22)->setMinute(0), // 10 pm
                'awake_at' => now()->subDays(5)->setHour(6),
            ])
        )
        ->has(SleepEntry::factory()
            ->state([
                'in_bed_by' => now()->subDays(5)->setHour(23)->setMinute(0), // 11 pm
                'awake_at' => now()->subDays(4)->setHour(6),
            ])
        )
        ->create();

    Livewire::actingAs($user)
        ->test('pages::dashboard')
        ->assertSet('avgSevenDayInBedBy', '10:30 pm');
});

it('correctly calculates average am in bed by time', function () {
    $user = User::factory()
        ->has(SleepEntry::factory()
            ->state([
                'in_bed_by' => now()->subDays(5)->setHour(1)->setMinute(0), // 1 am
                'awake_at' => now()->subDays(5)->setHour(6),
            ])
        )
        ->has(SleepEntry::factory()
            ->state([
                'in_bed_by' => now()->subDays(5)->setHour(23)->setMinute(0), // 11 pm
                'awake_at' => now()->subDays(4)->setHour(6),
            ])
        )
        ->create();

    Livewire::actingAs($user)
        ->test('pages::dashboard')
        ->assertSet('avgSevenDayInBedBy', '12:00 am');
});
