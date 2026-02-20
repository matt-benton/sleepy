<?php

use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('pages::tag.index')
        ->assertStatus(200);
});
