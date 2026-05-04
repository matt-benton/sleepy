<?php

namespace App\Models;

use App\Models\Scopes\PositiveFirstScope;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable('is_positive', 'text')]
#[ScopedBy([PositiveFirstScope::class])]
class KeyPoint extends Model
{
    /** @use HasFactory<\Database\Factories\KeyPointFactory> */
    use HasFactory;

}
