<div>
    <flux:card>
        <flux:text>Recent Bedtimes</flux:text>
        <flux:chart :value="$data" class="aspect-3/1">
            <flux:chart.svg>
                <flux:chart.line field="time" class="text-sky-800 dark:text-sky-600" />
                <flux:chart.point field="time" class="text-sky-600" />

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
                    label="Bedtime"
                    :format="['hour' => 'numeric', 'minute' => 'numeric', 'hour12' => true]"
                />
            </flux:chart.tooltip>
        </flux:chart>
    </flux:card>
</div>
