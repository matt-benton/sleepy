<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::livewire('/tags/create', 'pages::tag.create')->name('tag.create');
Route::livewire('/tags', 'pages::tag.index')->name('tag.index');

require __DIR__.'/settings.php';
