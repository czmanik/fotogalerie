<x-layout>
    <x-slot:title>
        {{ $exhibition->title }}
    </x-slot>

    <div class="py-12 bg-gray-900 text-white min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            @if($exhibition->coverPhoto)
                <div class="relative w-full h-[40vh] md:h-[50vh] overflow-hidden mb-12 rounded-lg shadow-2xl bg-gray-900">
                    <img src="{{ $exhibition->coverPhoto->getFirstMediaUrl('default', 'large') }}"
                         alt="{{ $exhibition->title }}"
                         class="w-full h-full object-cover opacity-60 grayscale group-hover:grayscale-0 transition duration-1000">
                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/40 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 p-8">
                        {{-- Optional overlay text if needed, currently empty to match homepage style --}}
                    </div>
                </div>
            @endif

            <div class="mb-12 border-b border-gray-800 pb-8">
                <a href="{{ route('exhibitions.index') }}" class="inline-flex items-center text-amber-500 hover:text-amber-400 mb-6 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                    Zpět na seznam výstav
                </a>

                <h1 class="text-4xl md:text-5xl font-bold tracking-tight text-white mb-6">{{ $exhibition->title }}</h1>

                <div class="flex flex-col md:flex-row md:items-center gap-6 text-gray-400">
                    <p class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-amber-500">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                          <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                        </svg>
                        <span class="text-lg">{{ $exhibition->location }}</span>
                    </p>
                    <div class="hidden md:block w-px h-6 bg-gray-800"></div>
                    <p class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-amber-500">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 9v7.5" />
                        </svg>
                        <span class="text-lg">
                            {{ $exhibition->start_date->format('d.m.Y') }}
                            @if($exhibition->end_date)
                                - {{ $exhibition->end_date->format('d.m.Y') }}
                            @else
                                (stálá expozice)
                            @endif
                        </span>
                    </p>
                </div>

                @if($exhibition->description)
                    <div class="mt-8 prose prose-invert max-w-3xl text-gray-300">
                        {!! $exhibition->description !!}
                    </div>
                @endif
            </div>

            {{-- Linked Projects --}}
            @if($exhibition->projects->count() > 0)
                <div class="mb-16 border-b border-gray-800 pb-8">
                    <h2 class="text-2xl font-bold text-amber-500 mb-6 uppercase tracking-wider">Související projekty</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($exhibition->projects as $project)
                            <a href="{{ route('projects.show', $project->slug) }}" class="group block bg-gray-800 rounded-lg p-6 hover:bg-gray-700 transition">
                                <h3 class="text-xl font-bold text-white group-hover:text-amber-500 transition mb-2">{{ $project->title }}</h3>
                                @if($project->description)
                                    <p class="text-gray-400 text-sm line-clamp-2">{{ Str::limit(strip_tags($project->description), 150) }}</p>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Gallery Grid --}}
            @if($exhibition->photos->count() > 0)
                <h2 class="text-2xl font-bold text-white mb-6 uppercase tracking-wider">Fotogalerie</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($exhibition->photos as $photo)
                        <a href="{{ route('photo.show', ['slug' => $photo->slug, 'exhibitionId' => $exhibition->id]) }}" wire:navigate class="group relative aspect-square overflow-hidden bg-gray-900 rounded-sm">
                            <img src="{{ $photo->getFirstMediaUrl('default', 'thumb') }}"
                                 alt="{{ $photo->title }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-500 opacity-80 group-hover:opacity-100"
                                 loading="lazy">

                            {{-- Hover Overlay --}}
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-end p-4">
                                <span class="text-white text-sm font-medium truncate w-full">{{ $photo->title }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 italic">K této výstavě zatím nejsou přiřazeny žádné fotografie.</p>
            @endif

        </div>
    </div>
</x-layout>
