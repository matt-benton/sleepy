<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class SleepEntry extends Model
{
    /** @use HasFactory<\Database\Factories\SleepEntryFactory> */
    use HasFactory;

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

    protected function sleepLength(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes) {
                $inBedBy = $attributes['in_bed_by'] ? new Carbon($attributes['in_bed_by'])->toImmutable() : null;
                $awakeAt = $attributes['awake_at'] ? new Carbon($attributes['awake_at'])->toImmutable() : null;

                if ($inBedBy && $awakeAt) {
                    $totalMinutes = $inBedBy->diffInMinutes($awakeAt);
                    $hours = intdiv($totalMinutes, 60);
                    $minutes = $totalMinutes % 60;

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
}
