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
                    <flux:date-picker wire:model="form.inBedByDate" type="input" />
                    <flux:error name="form.inBedByDate" />
                </flux:field>
                <flux:field>
                    <flux:time-picker wire:model="form.inBedByTime" interval="5" type="input" />
                    <flux:error name="form.inBedByTime" />
                </flux:field>
                <flux:button wire:click="clearInBedByDates">Clear</flux:button>
            </div>
            <flux:label>Awake At</flux:label>
            <div class="flex gap-2">
                <flux:field>
                    <flux:date-picker wire:model="form.awakeAtDate" type="input" />
                    <flux:error name="form.awakeAtDate" />
                </flux:field>
                <flux:field>
                    <flux:time-picker wire:model="form.awakeAtTime" interval="5" type="input" />
                    <flux:error name="form.awakeAtTime" />
                </flux:field>
                <flux:button wire:click="clearAwakeAtDates">Clear</flux:button>
            </div>
            <flux:field>
                <div class="max-w-30">
                    <flux:label>Temperature</flux:label>
                    <flux:input wire:model="form.temperature" />
                </div>
                <flux:error name="temperature" />
            </flux:field>
            <flux:field>
                <flux:editor label="Notes" wire:model="form.notes" />
            </flux:field>

            <livewire:sleep_entry.rating_setter :rating="$form->rating" />

            <flux:field>
                <flux:label>Pros/Cons</flux:label>
                <flux:input.group>
                    <flux:select class="max-w-fit" wire:model="form.newKeyPointPositive">
                        <flux:select.option value="1">+</flux:select.option>
                        <flux:select.option value="0">-</flux:select.option>
                    </flux:select>
                    <flux:input wire:model="form.newKeyPointText" />
                    <flux:button icon="plus" wire:click="addKeyPoint" />
                </flux:input.group>
            </flux:field>

            @foreach ($this->form->keyPoints as $point)
                @if ($point['is_positive'])
                    <flux:callout variant="success" icon="plus-circle" wire:key="{{ $loop->index }}">
                        {{ $point['text'] }}
                        <x-slot name="controls">
                            <flux:button icon="x-mark" variant="ghost" wire:click="removeKeyPoint({{ $loop->index }})" />
                        </x-slot>
                    </flux:callout>
                @else
                    <flux:callout variant="danger" icon="minus-circle" wire:key="{{ $loop->index }}">
                        {{ $point['text'] }}
                        <x-slot name="controls">
                            <flux:button icon="x-mark" variant="ghost" wire:click="removeKeyPoint({{ $loop->index }})" />
                        </x-slot>
                    </flux:callout>
                @endif
            @endforeach

            <flux:field>
                <flux:label>Tags</flux:table>
                <flux:pillbox multiple searchable placeholder="Choose tags..." wire:model="form.tagIds">
                    @foreach ($this->form->tags as $tag)
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
