<x-layout title="Osobnosti">
    <div class="container mx-auto px-4 py-12">
        <h1 class="text-4xl font-bold text-white mb-12 text-center">Katalog osobností</h1>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($people as $person)
                <a href="{{ route('people.show', $person->id) }}" class="group block bg-gray-900 border border-gray-800 hover:border-amber-500/50 transition">
                    <div class="aspect-square overflow-hidden relative">
                        @if($person->avatar)
                            <img src="{{ $person->avatar->getFirstMediaUrl('default', 'thumb') }}" 
                                 alt="{{ $person->full_name }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-500 grayscale group-hover:grayscale-0">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-800 text-gray-600 text-4xl">
                                {{ substr($person->first_name, 0, 1) }}
                            </div>
                        @endif
                    </div>

                    <div class="p-4 text-center">
                        <h2 class="text-lg font-bold text-white group-hover:text-amber-500 transition">
                            {{ $person->full_name }}
                        </h2>
                        @if($person->categories)
                            <div class="mt-2 flex flex-wrap justify-center gap-1">
                                @foreach($person->categories as $category)
                                    <span class="text-xs text-gray-500 uppercase tracking-wider border border-gray-700 px-1.5 py-0.5 rounded">
                                        {{ $category }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</x-layout>