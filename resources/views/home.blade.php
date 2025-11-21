<x-layout>
    <section class="relative h-[70vh] flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 bg-gray-800">
             <img src="https://images.unsplash.com/photo-1492691527719-9d1e07e534b4?q=80&w=2000&auto=format&fit=crop" class="w-full h-full object-cover opacity-40" alt="Hero background">
        </div>
        
        <div class="relative z-10 text-center px-4">
            <h1 class="text-5xl md:text-7xl font-bold text-white mb-6 tracking-tight">
                Martin Beck
            </h1>
            <p class="text-xl md:text-2xl text-gray-300 font-light tracking-wide mb-8">
                Portrétní & Reportážní Fotografie
            </p>
            <a href="{{ route('projects.index') }}" class="inline-block px-8 py-3 border border-white text-white hover:bg-white hover:text-black transition duration-300 uppercase tracking-widest text-sm">
                Prohlédnout Portfolio
            </a>
        </div>
    </section>

    <section class="py-20 container mx-auto px-4">
        <div class="flex items-end justify-between mb-12">
            <h2 class="text-3xl font-semibold text-white">Vybrané projekty</h2>
            <a href="{{ route('projects.index') }}" class="text-amber-500 hover:text-amber-400 text-sm uppercase tracking-wider flex items-center gap-2">
                Všechny projekty <span>&rarr;</span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($featured_projects as $project)
                <a href="{{ route('projects.show', $project->slug) }}" class="group block">
                    <div class="relative overflow-hidden aspect-3-2 bg-gray-800 mb-4">
                        @if($project->coverPhoto)
                            <img src="{{ $project->coverPhoto->getFirstMediaUrl('default', 'medium') }}" 
                                 alt="{{ $project->title }}" 
                                 class="w-full h-full object-cover transform group-hover:scale-105 transition duration-700 ease-in-out opacity-90 group-hover:opacity-100">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-600">Bez náhledu</div>
                        @endif
                        
                        <div class="absolute inset-0 bg-black/20 group-hover:bg-transparent transition"></div>
                    </div>
                    
                    <h3 class="text-xl text-white font-medium group-hover:text-amber-500 transition">
                        {{ $project->title }}
                    </h3>
                    <p class="text-gray-500 text-sm mt-1 truncate">{{ $project->description }}</p>
                </a>
            @empty
                <div class="col-span-3 text-center py-12 text-gray-500">
                    Zatím zde nejsou žádné veřejné projekty.
                </div>
            @endforelse
        </div>
    </section>

    @if($upcoming_exhibitions->isNotEmpty())
    <section class="py-20 bg-gray-800/50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-semibold text-white mb-12 text-center">Aktuální a budoucí výstavy</h2>
            
            <div class="max-w-4xl mx-auto space-y-6">
                @foreach($upcoming_exhibitions as $exhibition)
                    <div class="flex flex-col md:flex-row md:items-center bg-gray-900 border border-gray-700 p-6 hover:border-amber-500/50 transition">
                        <div class="md:w-1/4 mb-4 md:mb-0 text-amber-500 font-mono text-lg">
                            {{ $exhibition->start_date->format('d.m.Y') }}
                            @if($exhibition->end_date)
                                <span class="text-gray-500 mx-1">-</span> {{ $exhibition->end_date->format('d.m.Y') }}
                            @else
                                <span class="text-gray-500 text-sm ml-2">(stálá expozice)</span>
                            @endif
                        </div>
                        
                        <div class="md:w-3/4">
                            <h3 class="text-xl font-bold text-white mb-1">{{ $exhibition->title }}</h3>
                            <div class="text-gray-400 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                  <path fill-rule="evenodd" d="m9.69 18.933.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 0 0 .281-.14c.186-.096.446-.24.757-.433.62-.384 1.445-.966 2.274-1.765C15.302 14.988 17 12.493 17 9A7 7 0 1 0 3 9c0 3.492 1.698 5.988 3.355 7.62.829.799 1.654 1.38 2.274 1.766a11.266 11.266 0 0 0 .758.434l.018.008.006.003.002.001ZM10 13a4 4 0 1 1 0-8 4 4 0 0 1 0 8Z" clip-rule="evenodd" />
                                </svg>
                                {{ $exhibition->location }}
                            </div>
                        </div>
                        
                        <div class="mt-4 md:mt-0 md:ml-auto">
                             <a href="{{ route('about') }}" class="text-sm border-b border-gray-600 hover:border-white hover:text-white text-gray-400 transition pb-0.5">Více info</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

</x-layout>