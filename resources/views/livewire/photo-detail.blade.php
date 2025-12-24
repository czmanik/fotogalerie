<div class="h-full bg-black flex flex-col items-center justify-center p-4">

    {{-- Photo Container --}}
    <div class="w-full max-w-[95%] mx-auto grid grid-cols-1 lg:grid-cols-4 gap-8 h-full">

        {{-- Image Section (Takes up most space) --}}
        <div class="lg:col-span-3 flex flex-col items-center justify-center relative bg-gray-900/50 rounded-lg overflow-hidden" style="min-height: 70vh;">

            {{-- Main Image --}}
            <img src="{{ $photo->getFirstMediaUrl('default', 'large') }}"
                 alt="{{ $photo->title }}"
                 class="max-h-[85vh] w-auto max-w-full object-contain shadow-2xl rounded-sm"
            >

            {{-- Mobile Navigation Overlay (Visible only on small screens) --}}
            <div class="absolute inset-x-0 top-1/2 -translate-y-1/2 flex justify-between px-2 lg:hidden pointer-events-none">
                @if($previousPhoto)
                    <a href="{{ route('photo.show', ['slug' => $previousPhoto->slug, 'projectId' => $projectId, 'personId' => $personId, 'exhibitionId' => $exhibitionId]) }}" wire:navigate class="pointer-events-auto bg-black/50 text-white p-2 rounded-full hover:bg-black/80 transition backdrop-blur-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" /></svg>
                    </a>
                @else
                    <div></div>
                @endif

                @if($nextPhoto)
                    <a href="{{ route('photo.show', ['slug' => $nextPhoto->slug, 'projectId' => $projectId, 'personId' => $personId, 'exhibitionId' => $exhibitionId]) }}" wire:navigate class="pointer-events-auto bg-black/50 text-white p-2 rounded-full hover:bg-black/80 transition backdrop-blur-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>
                    </a>
                @endif
            </div>
        </div>

        {{-- Sidebar / Info Section --}}
        <div class="lg:col-span-1 flex flex-col justify-between text-gray-300 space-y-8 py-4">

            <div>
                {{-- Title --}}
                <h1 class="text-3xl font-bold text-white mb-4 tracking-wide">{{ $photo->title }}</h1>

                {{-- Metadata --}}
                <div class="space-y-4 text-sm">
                    @if($photo->description)
                        <div class="prose prose-invert text-gray-400 leading-relaxed">
                            {!! $photo->description !!}
                        </div>
                    @endif

                    {{-- People on photo --}}
                    @if($photo->people->count() > 0)
                        <div class="pt-4 border-t border-gray-800">
                            <h3 class="text-xs uppercase tracking-widest text-amber-500 mb-2">Na fotografii</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($photo->people as $person)
                                    <a href="{{ route('people.show', $person->id) }}" class="inline-block px-2 py-1 bg-gray-800 hover:bg-amber-900/50 text-gray-300 hover:text-white text-xs rounded transition">
                                        {{ $person->full_name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Projects --}}
                    @php
                        $publicProjects = $photo->projects->where('visibility', 'public');
                    @endphp
                    @if($publicProjects->count() > 0)
                        <div class="pt-4 border-t border-gray-800">
                            <h3 class="text-xs uppercase tracking-widest text-amber-500 mb-2">Projekty</h3>
                            <ul class="space-y-1">
                                @foreach($publicProjects as $project)
                                    <li>
                                        <a href="{{ route('projects.show', $project->slug) }}" class="hover:text-white hover:underline decoration-amber-500 decoration-1 underline-offset-4 transition">
                                            {{ $project->title }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Exhibitions --}}
                    @php
                        $visibleExhibitions = $photo->exhibitions->where('is_visible', true);
                    @endphp
                    @if($visibleExhibitions->count() > 0)
                        <div class="pt-4 border-t border-gray-800">
                            <h3 class="text-xs uppercase tracking-widest text-amber-500 mb-2">Výstavy</h3>
                            <ul class="space-y-1">
                                @foreach($visibleExhibitions as $exhibition)
                                    <li>
                                        <a href="{{ route('exhibitions.show', $exhibition->slug) }}" class="hover:text-white hover:underline decoration-amber-500 decoration-1 underline-offset-4 transition">
                                            {{ $exhibition->title }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- EXIF / Technical info (Optional, keeping it subtle) --}}
                    @if($photo->captured_at)
                         <div class="pt-4 border-t border-gray-800 text-xs text-gray-600">
                            <p>Vyfoceno: {{ $photo->captured_at->format('d. m. Y') }}</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Desktop Navigation (Thumbnails) --}}
            <div class="hidden lg:grid grid-cols-2 gap-4 mt-auto pt-8 border-t border-gray-800">
                <div class="text-left">
                    @if($previousPhoto)
                        <a href="{{ route('photo.show', ['slug' => $previousPhoto->slug, 'projectId' => $projectId, 'personId' => $personId, 'exhibitionId' => $exhibitionId]) }}" wire:navigate class="group block">
                            <span class="block text-xs uppercase tracking-widest text-gray-500 mb-2 group-hover:text-amber-500 transition">&larr; Předchozí</span>
                            <div class="aspect-square bg-gray-800 overflow-hidden relative opacity-60 group-hover:opacity-100 transition">
                                <img src="{{ $previousPhoto->getFirstMediaUrl('default', 'thumb') }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition duration-500">
                            </div>
                        </a>
                    @endif
                </div>

                <div class="text-right">
                    @if($nextPhoto)
                        <a href="{{ route('photo.show', ['slug' => $nextPhoto->slug, 'projectId' => $projectId, 'personId' => $personId, 'exhibitionId' => $exhibitionId]) }}" wire:navigate class="group block">
                            <span class="block text-xs uppercase tracking-widest text-gray-500 mb-2 group-hover:text-amber-500 transition">Další &rarr;</span>
                            <div class="aspect-square bg-gray-800 overflow-hidden relative opacity-60 group-hover:opacity-100 transition">
                                <img src="{{ $nextPhoto->getFirstMediaUrl('default', 'thumb') }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition duration-500">
                            </div>
                        </a>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
