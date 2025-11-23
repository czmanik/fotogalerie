<x-layout>
    
    <section class="relative h-[80vh] flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 bg-gray-900">
             <img src="https://images.unsplash.com/photo-1554048612-387768052bf7?q=80&w=2000&auto=format&fit=crop" class="w-full h-full object-cover opacity-30 grayscale" alt="Hero background">
             <div class="absolute inset-0 bg-gradient-to-b from-transparent via-gray-900/50 to-gray-900"></div>
        </div>
        
        <div class="relative z-10 text-center px-4 animate-fade-in-up">
            <h1 class="text-5xl md:text-8xl font-bold text-white mb-6 tracking-tighter uppercase">
                Martin Beck
            </h1>
            <p class="text-lg md:text-2xl text-amber-500 font-light tracking-[0.2em] mb-10 uppercase">
                Fotografie s duší
            </p>
            <a href="{{ route('projects.index') }}" class="group inline-flex items-center gap-3 px-8 py-4 border border-gray-600 text-gray-300 hover:border-white hover:text-white transition duration-500 uppercase tracking-widest text-xs">
                Vstoupit do portfolia
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 group-hover:translate-x-1 transition"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
            </a>
        </div>
    </section>

    @if($birthday_people->isNotEmpty())
        <section class="bg-gradient-to-r from-amber-900/20 to-gray-900 border-y border-amber-900/30 py-8">
            <div class="container mx-auto px-4 flex flex-col md:flex-row items-center justify-center gap-6 text-center md:text-left">
                <div class="text-amber-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10"><path stroke-linecap="round" stroke-linejoin="round" d="M21 11.25v8.25a1.5 1.5 0 0 1-1.5 1.5H4.5a1.5 1.5 0 0 1-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 1 0 9.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1 1 14.625 7.5H12m0 0V21m-8.625-9.75h18c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125h-18c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" /></svg>
                </div>
                <div>
                    <p class="text-gray-400 text-xs uppercase tracking-widest mb-1">Dnes slaví narozeniny</p>
                    @foreach($birthday_people as $person)
                        <a href="{{ route('people.show', $person->id) }}" class="text-xl md:text-2xl text-white font-bold hover:text-amber-500 transition block">
                            {{ $person->full_name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if($upcoming_exhibitions->isNotEmpty() || $latest_article)
    <section class="py-20 container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            
            @foreach($upcoming_exhibitions as $exhibition)
            <div class="relative group">
                <h3 class="text-gray-500 text-xs uppercase tracking-widest mb-4 border-l-2 border-amber-500 pl-3">Nejbližší výstava</h3>
                <div class="bg-gray-900 border border-gray-800 p-8 hover:border-gray-600 transition duration-300 h-full flex flex-col justify-center">
                    <div class="text-4xl md:text-5xl font-bold text-white mb-4 group-hover:text-amber-500 transition">
                        {{ $exhibition->start_date->format('d. m.') }}
                    </div>
                    <h4 class="text-2xl text-gray-200 mb-2">{{ $exhibition->title }}</h4>
                    <p class="text-gray-500 mb-6">{{ $exhibition->location }}</p>
                    <a href="{{ route('about') }}" class="text-sm text-white border-b border-gray-700 pb-1 self-start hover:border-amber-500 transition">Více informací</a>
                </div>
            </div>
            @endforeach

            @if($latest_article)
            <div class="relative group">
                <h3 class="text-gray-500 text-xs uppercase tracking-widest mb-4 border-l-2 border-gray-600 pl-3">Napsali o mně</h3>
                <a href="{{ $latest_article->url }}" target="_blank" class="block bg-gray-900 border border-gray-800 p-8 hover:border-gray-600 transition duration-300 h-full flex flex-col justify-center">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="text-amber-500 text-xs font-bold uppercase tracking-widest px-2 py-1 bg-amber-500/10 rounded">
                            {{ $latest_article->source_name ?? 'Média' }}
                        </span>
                        <span class="text-gray-600 text-xs">{{ $latest_article->published_at ? $latest_article->published_at->format('Y') : '' }}</span>
                    </div>
                    <h4 class="text-2xl text-white mb-4 leading-snug group-hover:underline decoration-amber-500 decoration-2 underline-offset-4">
                        {{ $latest_article->title }}
                    </h4>
                    <div class="text-sm text-gray-500 flex items-center gap-2 mt-auto">
                        Přečíst článek 
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" /></svg>
                    </div>
                </a>
            </div>
            @endif

        </div>
    </section>
    @endif

    <section class="py-20 bg-gray-900/30 border-t border-gray-800">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-end mb-12">
                <h2 class="text-3xl font-bold text-white">Vybrané projekty</h2>
                <a href="{{ route('projects.index') }}" class="hidden md:block text-gray-500 hover:text-white text-sm uppercase tracking-widest transition">Všechny projekty &rarr;</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($featured_projects as $project)
                    <a href="{{ route('projects.show', $project->slug) }}" class="group block">
                        <div class="aspect-[4/5] overflow-hidden bg-gray-800 relative mb-4">
                            @if($project->coverPhoto)
                                <img src="{{ $project->coverPhoto->getFirstMediaUrl('default', 'medium') }}" 
                                     alt="{{ $project->title }}" 
                                     class="w-full h-full object-cover transform group-hover:scale-105 transition duration-700 ease-in-out grayscale group-hover:grayscale-0">
                            @endif
                            <div class="absolute inset-0 bg-black/20 group-hover:bg-transparent transition"></div>
                        </div>
                        <h3 class="text-xl text-white font-bold group-hover:text-amber-500 transition">{{ $project->title }}</h3>
                        <p class="text-gray-500 text-sm mt-1 truncate">{{ Str::limit($project->description, 50) }}</p>
                    </a>
                @endforeach
            </div>
            
            <div class="mt-12 text-center md:hidden">
                <a href="{{ route('projects.index') }}" class="inline-block border border-gray-700 px-6 py-3 text-white text-xs uppercase tracking-widest hover:bg-white hover:text-black transition">
                    Všechny projekty
                </a>
            </div>
        </div>
    </section>

    <section class="py-20 container mx-auto px-4">
        <h2 class="text-3xl font-bold text-white mb-12 text-center">Okamžiky</h2>
        
        <div class="columns-2 md:columns-4 gap-4 space-y-4">
            @foreach($random_photos as $photo)
                <div class="break-inside-avoid overflow-hidden group relative">
                    <img src="{{ $photo->getFirstMediaUrl('default', 'medium') }}" 
                         class="w-full h-auto object-cover hover:opacity-80 transition duration-500 rounded-sm"
                         loading="lazy" alt="Inspirace">
                </div>
            @endforeach
        </div>
    </section>

</x-layout>