<x-layout>
    <x-slot:title>
        Výstavy
    </x-slot>

    <div class="py-12 bg-gray-900 text-white min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-bold tracking-tight text-white mb-12 uppercase">Výstavy</h1>

            @if($futureExhibitions->isNotEmpty())
                <div class="mb-16">
                    <h2 class="text-2xl font-bold text-amber-500 mb-6 uppercase tracking-wider">Aktuální a plánované</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($futureExhibitions as $exhibition)
                            <a href="{{ route('exhibitions.show', $exhibition->slug) }}" class="group block bg-gray-900 rounded-lg overflow-hidden hover:ring-2 hover:ring-amber-500 transition duration-300">
                                <div class="p-6">
                                    <h3 class="text-xl font-bold mb-2 group-hover:text-amber-500 transition">{{ $exhibition->title }}</h3>
                                    <div class="text-gray-400 text-sm mb-4 space-y-1">
                                        <p class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-amber-500">
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                            </svg>
                                            {{ $exhibition->location }}
                                        </p>
                                        <p class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-amber-500">
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 9v7.5" />
                                            </svg>
                                            {{ $exhibition->start_date->format('d.m.Y') }}
                                            @if($exhibition->end_date)
                                                - {{ $exhibition->end_date->format('d.m.Y') }}
                                            @else
                                                (stálá expozice)
                                            @endif
                                        </p>
                                    </div>
                                    <div class="text-gray-500 text-sm line-clamp-3 prose prose-invert prose-sm">
                                        {{ Str::limit(strip_tags($exhibition->description), 200) }}
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($pastExhibitions->isNotEmpty())
                <div>
                    @if($futureExhibitions->isNotEmpty())
                        <h2 class="text-2xl font-bold text-gray-500 mb-6 uppercase tracking-wider">Proběhlé výstavy</h2>
                    @endif
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($pastExhibitions as $exhibition)
                             <a href="{{ route('exhibitions.show', $exhibition->slug) }}" class="group block bg-gray-900/50 rounded-lg overflow-hidden hover:bg-gray-900 transition duration-300">
                                <div class="p-6">
                                    <h3 class="text-xl font-bold mb-2 group-hover:text-amber-500 transition">{{ $exhibition->title }}</h3>
                                    <div class="text-gray-400 text-sm mb-4 space-y-1">
                                        <p class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-amber-500">
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                            </svg>
                                            {{ $exhibition->location }}
                                        </p>
                                        <p class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-amber-500">
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 9v7.5" />
                                            </svg>
                                            {{ $exhibition->start_date->format('d.m.Y') }}
                                            @if($exhibition->end_date)
                                                - {{ $exhibition->end_date->format('d.m.Y') }}
                                            @endif
                                        </p>
                                    </div>
                                    <div class="text-gray-500 text-sm line-clamp-3 prose prose-invert prose-sm">
                                        {{ Str::limit(strip_tags($exhibition->description), 200) }}
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($futureExhibitions->isEmpty() && $pastExhibitions->isEmpty())
                <p class="text-gray-400">V tuto chvíli zde nejsou žádné výstavy.</p>
            @endif
        </div>
    </div>
</x-layout>