<div>
    <flux:card>
        <flux:table>
            <flux:table.columns>
                <flux:table.column>Woke Up On</flux:table.column>
                <flux:table.column align="end">Avg Rating</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($daysOfWeek as $day)
                    <flux:table.row :key="$day['day_of_week']">
                        <flux:table.cell>{{ $day['day_of_week_formatted'] }}</flux:table.cell>
                        <flux:table.cell align="end">
                            @if ($day['avg_rating'] >= 4)
                                <flux:badge color="emerald">{{ $day['avg_rating'] }}</flux:badge>
                            @elseif ($day['avg_rating'] <= 2)
                                <flux:badge color="rose">{{ $day['avg_rating'] }}</flux:badge>
                            @else
                                <flux:badge>{{ $day['avg_rating'] }}</flux:badge>
                            @endif
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </flux:card>
</div>
