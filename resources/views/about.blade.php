<x-layout title="O mně">
    <div class="container mx-auto px-4 py-16 md:py-24">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-8">Martin Beck</h1>
            <div class="text-xl md:text-2xl text-gray-300 font-light leading-relaxed mb-12">
                <p>
                    "Fotografie pro mě není jen zachycení momentu, ale vyprávění příběhu, 
                    který by jinak zůstal nevyřčen."
                </p>
            </div>
            <div class="text-gray-400 leading-loose text-lg text-left md:text-center">
                <p class="mb-4">
                    Martin Beck je uznávaný fotograf specializující se na portrétní a uměleckou fotografii.
                    Jeho práce se vyznačuje... (zde doplň skutečné bio).
                </p>
            </div>
        </div>
    </div>

    @if($exhibitions->isNotEmpty())
    <div class="bg-gray-900 py-16 border-y border-gray-800">
        <div class="container mx-auto px-4 max-w-4xl">
            <h2 class="text-3xl font-bold text-white mb-10 text-center">Výstavy</h2>
            
            <div class="space-y-8 border-l border-gray-700 ml-4 md:ml-0 pl-8 md:pl-0">
                @foreach($exhibitions as $exhibition)
                    <div class="relative md:flex group">
                        <div class="hidden md:block absolute left-[-5px] top-2 w-2.5 h-2.5 rounded-full bg-gray-600 group-hover:bg-amber-500 transition"></div>

                        <div class="md:w-1/4 md:pr-8 md:text-right mb-2 md:mb-0">
                            <span class="text-amber-500 font-mono font-bold">
                                {{ $exhibition->start_date->format('Y') }}
                            </span>
                            <div class="text-xs text-gray-500 uppercase">
                                {{ $exhibition->start_date->format('d.m.') }} 
                                @if($exhibition->end_date) - {{ $exhibition->end_date->format('d.m.') }} @endif
                            </div>
                        </div>

                        <div class="md:w-3/4 pb-8 border-b border-gray-800 md:border-none">
                            <h3 class="text-xl text-white font-bold group-hover:text-amber-500 transition">
                                {{ $exhibition->title }}
                            </h3>
                            <p class="text-gray-400 mt-1 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" /></svg>
                                {{ $exhibition->location }}
                            </p>
                            @if($exhibition->description)
                                <p class="text-gray-500 text-sm mt-2">{{ $exhibition->description }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    @if($articles->isNotEmpty())
    <div class="container mx-auto px-4 py-16 max-w-5xl">
        <h2 class="text-3xl font-bold text-white mb-10 text-center">Napsali o mně</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($articles as $article)
                <a href="{{ $article->url }}" target="_blank" class="block p-6 border border-gray-800 hover:border-amber-500 bg-gray-900/50 transition group">
                    <div class="flex justify-between items-start mb-4">
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-widest border border-gray-700 px-2 py-1 rounded group-hover:text-white group-hover:border-gray-500 transition">
                            {{ $article->source_name ?? 'Média' }}
                        </span>
                        @if($article->published_at)
                            <span class="text-xs text-gray-600">
                                {{ $article->published_at->format('d. m. Y') }}
                            </span>
                        @endif
                    </div>
                    <h3 class="text-lg text-white font-bold group-hover:text-amber-500 transition flex items-center gap-2">
                        {{ $article->title }}
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                    </h3>
                </a>
            @endforeach
        </div>
    </div>
    @endif

</x-layout>