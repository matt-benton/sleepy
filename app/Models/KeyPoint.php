<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeyPoint extends Model
{
    /** @use HasFactory<\Database\Factories\KeyPointFactory> */
    use HasFactory;

    protected $fillable = ['is_positive', 'text'];
}
