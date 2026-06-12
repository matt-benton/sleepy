<div>
    <livewire:tag.sidebar :tags="$tags" />
    <flux:main container>
        <div class="space-y-4">
            <flux:heading size="xl" level="2">{{ $tag->name }}</flux:heading>
            <flux:text>{{ $tag->description }}</flux:heading>
            @if ($tag->trashed())
                <flux:card class="bg-red-200 dark:bg-red-400 flex justify-between">
                    <div class="flex items-center">
                        <flux:icon.exclamation-triangle variant="mini" class="mr-2" />
                        <flux:text>
                            This tag has been deleted
                        </flux:text>
                    </div>
                    <div class="flex items-center">
                        <flux:button size="sm" variant="ghost" wire:click="restore">Restore</flux:button>
                    </div>
                </flux:card>
            @else
                <flux:button href="/tags/{{ $tag->id }}/edit" variant="primary" icon="pencil" wire:navigate>
                    Edit
                </flux:button>
                <flux:button icon="trash" class="cursor-pointer" wire:click="delete">
                    Remove
                </flux:button>

                @if ($this->sleepEntries->isNotEmpty())
                    <flux:card>
                        <flux:heading class="mb-2">Average Sleep Rating</flux:heading>
                        <x-tag.rating-diff :tag="$tag" />
                    </flux:card>
                @endif

                <flux:tab.group>
                    <flux:tabs wire:model="tab">
                        <flux:tab name="entries">Sleep Entries</flux:tab>
                        <flux:tab name="keyPoints">Key Points</flux:tab>
                    </flux:tabs>

                    <flux:tab.panel name="keyPoints" class="space-y-2">
                        @foreach ($this->allKeyPoints as $keyPoint)
                            @if ($keyPoint->is_positive)
                                <flux:callout variant="success" :heading="$keyPoint->text" />
                            @else
                                <flux:callout variant="danger" :heading="$keyPoint->text" />
                            @endif
                        @endforeach
                    </flux:tab.panel>

                    <flux:tab.panel name="entries">
                        <flux:card class="space-y-10">
                            @if ($this->sleepEntries->isNotEmpty())
                                @foreach ($this->sleepEntries as $entry)
                                    <x-sleep-entry-display :sleep-entry="$entry" />
                                @endforeach
                                <flux:pagination :paginator="$this->sleepEntries" />
                            @else
                                <flux:text>No sleep entries belong to this tag</flux:text>
                            @endif
                        </flux:card>
                    </flux:tab.panel>
                </flux:tab.group>
            @endif
        </div>
    </flux:main>
</div>
