<div>
    <flux:breadcrumbs class="mb-8">
        <flux:breadcrumbs.item href="/sleep_entries" wire:navigate>Sleep Entries</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="/sleep_entries/{{ $sleepEntry->id }}" wire:navigate>{{ $sleepEntry->sleep_date }}</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>Edit Entry</flux:breadcrumbs.item>
    </flux:breadcrumbs>
    @unless ($sleepEntry->trashed())
        <div class="space-y-5 w-xl mx-auto">
            <flux:label>In Bed By</flux:label>
            <div class="flex gap-2">
                <flux:field>
                    <flux:date-picker wire:model="inBedByDate" type="input" />
                    <flux:error name="inBedByDate" />
                </flux:field>
                <flux:field>
                    <flux:time-picker wire:model="inBedByTime" interval="5" type="input" />
                    <flux:error name="inBedByTime" />
                </flux:field>
                <flux:button wire:click="clearInBedByDates">Clear</flux:button>
            </div>
            <flux:label>Awake At</flux:label>
            <div class="flex gap-2">
                <flux:field>
                    <flux:date-picker wire:model="awakeAtDate" type="input" />
                    <flux:error name="awakeAtDate" />
                </flux:field>
                <flux:field>
                    <flux:time-picker wire:model="awakeAtTime" interval="5" type="input" />
                    <flux:error name="awakeAtTime" />
                </flux:field>
                <flux:button wire:click="clearAwakeAtDates">Clear</flux:button>
            </div>
            <flux:field>
                <div class="max-w-30">
                    <flux:label>Temperature</flux:label>
                    <flux:input wire:model="temperature" />
                </div>
                <flux:error name="temperature" />
            </flux:field>
            <flux:field>
                <flux:editor label="Notes" wire:model="notes" />
            </flux:field>
            <flux:field>
                <flux:label>Rating</flux:label>
                <div class="flex">
                    @if ($this->rating >= 1)
                        <flux:icon.star variant="solid" wire:click="setRating(1)" />
                    @else
                        <flux:icon.star wire:click="setRating(1)" />
                    @endif

                    @if ($this->rating >= 2)
                        <flux:icon.star variant="solid" wire:click="setRating(2)" />
                    @else
                        <flux:icon.star wire:click="setRating(2)" />
                    @endif

                    @if ($this->rating >= 3)
                        <flux:icon.star variant="solid" wire:click="setRating(3)" />
                    @else
                        <flux:icon.star wire:click="setRating(3)" />
                    @endif

                    @if ($this->rating >= 4)
                        <flux:icon.star variant="solid" wire:click="setRating(4)" />
                    @else
                        <flux:icon.star wire:click="setRating(4)" />
                    @endif

                    @if ($this->rating === 5)
                        <flux:icon.star variant="solid" wire:click="setRating(5)" />
                    @else
                        <flux:icon.star wire:click="setRating(5)" />
                    @endif
                </div>
                <flux:error name="rating" />
            </flux:field>
            <flux:field>
                <flux:label>Tags</flux:table>
                <flux:pillbox multiple searchable placeholder="Choose tags..." wire:model="tagIds">
                    @foreach ($tags as $tag)
                        <flux:pillbox.option value="{{ $tag->id }}">{{ $tag->name }}</flux:pillbox.option>
                    @endforeach
                </flux:pillbox>
            </flux:field>
            <div class="flex gap-1 justify-end">
                <flux:button wire:click="delete" icon="trash">Delete</flux:button>
                <flux:button wire:click="save" variant="primary" icon="pencil-square">Save</flux:button>
            </div>
        </div>
    @else
        <flux:callout icon="trash" class="w-xl mx-auto" color="red">
            <flux:callout.heading>This entry has been deleted</flux:callout.heading>
            <flux:callout.text>If this was done by mistake, you can restore this entry.</flux:callout.text>

            <x-slot name="actions">
                <flux:button wire:click="restore" icon="arrow-up-left">Restore</flux:button>
            </x-slot>
        </flux:callout>
    @endunless
</div>
