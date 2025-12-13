<x-filament-panels::page>
    <div class="grid gap-6 lg:grid-cols-2 lg:gap-8">
        <x-filament::section class="col-span-full">
            <x-slot name="heading">
                Správa záloh
            </x-slot>

            <x-slot name="description">
                Zde můžete ručně vytvořit kompletní zálohu databáze a fotografií.
            </x-slot>

            <div class="space-y-4">
                <p class="text-sm text-gray-500">
                    Proces zálohování může trvat několik minut v závislosti na velikosti fotografií.
                    Zálohy jsou ukládány na serveru ve složce <code>storage/app/backups</code>.
                </p>
            </div>
        </x-filament::section>

        <x-filament::section class="col-span-full">
            <x-slot name="heading">
                Seznam dostupných záloh
            </x-slot>

            @if($backups->isEmpty())
                <div class="text-center text-gray-500 py-4">
                    Zatím nebyly vytvořeny žádné zálohy.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                        <thead class="bg-gray-50 dark:bg-gray-700 text-xs uppercase text-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">Název souboru</th>
                                <th scope="col" class="px-6 py-3">Datum vytvoření</th>
                                <th scope="col" class="px-6 py-3">Velikost</th>
                                <th scope="col" class="px-6 py-3 text-right">Akce</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($backups as $backup)
                                <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                        {{ $backup['filename'] }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ \Carbon\Carbon::createFromTimestamp($backup['timestamp'])->format('d.m.Y H:i:s') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $backup['size'] }}
                                    </td>
                                    <td class="px-6 py-4 text-right flex justify-end gap-2">
                                        <x-filament::button
                                            color="gray"
                                            size="sm"
                                            icon="heroicon-m-arrow-down-tray"
                                            wire:click="downloadBackup('{{ $backup['path'] }}')"
                                        >
                                            Stáhnout
                                        </x-filament::button>

                                        <x-filament::button
                                            color="danger"
                                            size="sm"
                                            icon="heroicon-m-trash"
                                            wire:click="deleteBackup('{{ $backup['path'] }}')"
                                            wire:confirm="Opravdu chcete smazat tuto zálohu?"
                                        >
                                            Smazat
                                        </x-filament::button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </x-filament::section>
    </div>
</x-filament-panels::page>
