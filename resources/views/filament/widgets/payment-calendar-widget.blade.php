<x-filament::widget>
    <x-filament::section>
        <div class="p-2">
            <div class="text-xl font-bold text-center mb-4">{{ $monthName }}</div>

            <div class="grid grid-cols-7 gap-1 mb-2">
                <div class="text-center font-semibold">Lun</div>
                <div class="text-center font-semibold">Mar</div>
                <div class="text-center font-semibold">Mer</div>
                <div class="text-center font-semibold">Jeu</div>
                <div class="text-center font-semibold">Ven</div>
                <div class="text-center font-semibold">Sam</div>
                <div class="text-center font-semibold">Dim</div>
            </div>

            <div class="grid grid-cols-7 gap-1">
                @php
                    $firstDayOfMonth = \Carbon\Carbon::now()->startOfMonth();
                    $startingDayOfWeek = $firstDayOfMonth->dayOfWeekIso;
                @endphp

                {{-- Empty cells for days before the first of the month --}}
                @for ($i = 1; $i < $startingDayOfWeek; $i++)
                    <div class="h-20 border rounded bg-gray-100"></div>
                @endfor

                @foreach ($calendar as $dateStr => $day)
                    <div class="h-20 border rounded p-1 overflow-hidden {{ $day['isWeekend'] ? 'bg-gray-50' : '' }} {{ $day['isToday'] ? 'border-blue-500 border-2' : '' }}">
                        <div class="text-right {{ $day['isToday'] ? 'font-bold text-blue-600' : '' }}">
                            {{ $day['date']->format('j') }}
                        </div>

                        @if(count($day['payments']) > 0)
                            <div class="mt-1">
                                @foreach($day['payments'] as $payment)
                                    <div class="text-xs rounded px-1 mb-1 truncate
                                        {{ $payment->status === 'paid' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $payment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $payment->status === 'late' ? 'bg-red-100 text-red-800' : '' }}
                                    ">
                                        {{ $payment->rentalContract->tenant->name ?? 'Locataire' }}
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </x-filament::section>
</x-filament::widget>
