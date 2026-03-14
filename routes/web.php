<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::livewire('/tags/create', 'pages::tag.create')->name('tag.create');
    Route::livewire('/tags', 'pages::tag.index')->name('tag.index');
    Route::livewire('/tags/{tag}', 'pages::tag.show')->name('tag.show')->withTrashed();
    Route::livewire('/tags/{tag}/edit', 'pages::tag.edit')->name('tag.edit');

    Route::livewire('/sleep_entries', 'pages::sleep_entry.index')->name('sleep_entry.index');
    Route::livewire('/sleep_entries/create', 'pages::sleep_entry.create')->name('sleep_entry.create');
    Route::livewire('/sleep_entries/{sleepEntry}', 'pages::sleep_entry.show')->name('sleep_entry.show');
    Route::livewire('/sleep_entries/{sleepEntry}/edit', 'pages::sleep_entry.edit')->name('sleep_entry.edit')->withTrashed();
});

require __DIR__.'/settings.php';
