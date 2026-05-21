<?php

namespace App\View\Components\Tag;

use App\Models\Tag;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\Component;

class RatingDiff extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public Tag $tag) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $avgRatingWithTag = $this->tag->sleepEntries->avg('rating');
        $avgRatingWithoutTag = auth()->user()->sleepEntries()->select('rating')->whereDoesntHave('tags', function (Builder $query) {
            $query->whereNot('tags.id', $this->tag->id);
        })
            ->avg('rating');
        $difference = round($avgRatingWithTag - $avgRatingWithoutTag, 1);

        return view('components.tag.rating-diff', [
            'avgRatingWithTag' => $avgRatingWithTag,
            'avgRatingWithoutTag' => $avgRatingWithoutTag,
            'difference' => $difference,
        ]);
    }
}
