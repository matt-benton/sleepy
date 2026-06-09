<div>
    <flux:card>
        <flux:text>Recent Wake Up Times</flux:text>
        <flux:chart :value="$data" class="aspect-3/1">
            <flux:chart.svg>
                <flux:chart.line field="time" class="text-amber-500 dark:text-amber-400" />
                <flux:chart.point field="time" class="text-amber-400" />

                <flux:chart.axis axis="x" field="date" scale="time" :format="['weekday' => 'short', 'month' => 'short', 'day' => 'numeric']">
                    <flux:chart.axis.line />
                    <flux:chart.axis.tick />
                </flux:chart.axis>

                <flux:chart.axis axis="y" field="time" scale="time">
                    <flux:chart.axis.grid />
                    <flux:chart.axis.tick />
                </flux:chart.axis>

                <flux:chart.cursor />
            </flux:chart.svg>

            <flux:chart.tooltip>
                <flux:chart.tooltip.value
                    field="date"
                    label="Awake At"
                    :format="['hour' => 'numeric', 'minute' => 'numeric', 'hour12' => true]"
                />
            </flux:chart.tooltip>
        </flux:chart>
    </flux:card>
</div>
