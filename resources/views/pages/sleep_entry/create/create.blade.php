<div>
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
            <flux:error name="form.temperature" />
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

        @foreach ($form->keyPoints as $point)
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
            <flux:pillbox multiple variant="combobox" wire:model="form.tagIds">
                <x-slot name="input">
                    <flux:pillbox.input wire:model="form.tagSearch" placeholder="Choose tags..." />
                </x-slot>

                @foreach ($form->tags as $tag)
                    <flux:pillbox.option value="{{ $tag->id }}">{{ $tag->name }}</flux:pillbox.option>
                @endforeach

                <flux:pillbox.option.create wire:click="createTag" min-length="2">
                    Create new "<span wire:text="form.tagSearch"></span>"
                </flux:pillbox.option.create>
            </flux:pillbox>
        </flux:field>
        <div class="flex gap-1 justify-end">
            <flux:button wire:click="save" variant="primary" icon="pencil-square">Save</flux:button>
        </div>
    </div>
</div>
