<?php

namespace App\Models;

use App\Models\Scopes\LatestAwakeAtScope;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Symfony\Component\HtmlSanitizer\HtmlSanitizer;
use Symfony\Component\HtmlSanitizer\HtmlSanitizerConfig;

#[ScopedBy([LatestAwakeAtScope::class])]
class SleepEntry extends Model
{
    /** @use HasFactory<\Database\Factories\SleepEntryFactory> */
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'in_bed_by',
        'awake_at',
        'temperature',
        'rating',
        'notes',
    ];

    protected function casts()
    {
        return [
            'in_bed_by' => 'immutable_datetime',
            'awake_at' => 'immutable_datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function keyPoints(): HasMany
    {
        return $this->hasMany(KeyPoint::class);
    }

    protected function sleepDate(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes) {
                $inBedBy = $attributes['in_bed_by'] ? new Carbon($attributes['in_bed_by'])->toImmutable() : null;
                $awakeAt = $attributes['awake_at'] ? new Carbon($attributes['awake_at'])->toImmutable() : null;

                if (! $inBedBy && ! $awakeAt) {
                    return '';
                }

                if ($inBedBy && ! $awakeAt) {
                    return $inBedBy->toFormattedDayDateString();
                }

                if (! $inBedBy && $awakeAt) {
                    return $awakeAt->toFormattedDayDateString();
                }

                if ($inBedBy->isSameDay($awakeAt)) {
                    return $inBedBy->toFormattedDayDateString();
                }

                return $inBedBy->toFormattedDayDateString().' - '.$awakeAt->toFormattedDayDateString();
            }
        );
    }

    protected function totalMinutes(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes) {
                $inBedBy = $attributes['in_bed_by'] ? new Carbon($attributes['in_bed_by'])->toImmutable() : null;
                $awakeAt = $attributes['awake_at'] ? new Carbon($attributes['awake_at'])->toImmutable() : null;

                if ($inBedBy && $awakeAt) {
                    return $inBedBy->diffInMinutes($awakeAt);
                }

                return null;
            }
        );
    }

    protected function sleepLength(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes) {
                if ($this->totalMinutes) {
                    $hours = intdiv($this->totalMinutes, 60);
                    $minutes = $this->totalMinutes % 60;

                    if ($minutes > 0) {
                        return "{$hours} hours, {$minutes} minutes";
                    } else {
                        return $hours.' hours';
                    }
                }

                return null;
            }
        );
    }

    protected function notes(): Attribute
    {
        $htmlSanitizer = new HtmlSanitizer(
            new HtmlSanitizerConfig()->allowSafeElements()
        );

        return Attribute::make(
            get: fn (string $value) => $htmlSanitizer->sanitize(html_entity_decode($value)),
        );
    }

    #[Scope]
    protected function rated(Builder $query): void
    {
        $query->where('rating', '!=', '')
            ->whereNotNull('rating');
    }
}
