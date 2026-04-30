<?php

namespace App\Models;

use App\Models\Scopes\PositiveFirstScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ScopedBy([PositiveFirstScope::class])]
class KeyPoint extends Model
{
    /** @use HasFactory<\Database\Factories\KeyPointFactory> */
    use HasFactory;

    protected $fillable = ['is_positive', 'text'];
}
