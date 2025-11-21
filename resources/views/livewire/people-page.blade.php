<div class="container mx-auto px-4 py-12 min-h-screen">
    
    <div class="text-center mb-12">
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 tracking-tight">Katalog osobností</h1>
        <p class="text-gray-400 max-w-2xl mx-auto">
            Lidé, jejichž příběhy jsem měl tu čest zachytit.
        </p>
    </div>

    <div class="flex flex-wrap justify-center gap-3 mb-16">
        
        <button 
            wire:click="setCategory('Vše')"
            class="px-5 py-2 rounded-full text-sm font-bold uppercase tracking-wider transition border 
            {{ $activeCategory === 'Vše' 
                ? 'bg-amber-500 border-amber-500 text-black' 
                : 'bg-gray-900 border-gray-700 text-gray-400 hover:border-white hover:text-white' 
            }}"
        >
            Vše <span class="opacity-60 ml-1 text-xs">({{ $this->getCountForCategory('Vše') }})</span>
        </button>

        @foreach($categoriesList as $category)
            @php
                $count = $this->getCountForCategory($category);
            @endphp
            
            @if($count > 0)
                <button 
                    wire:click="setCategory('{{ $category }}')"
                    class="px-5 py-2 rounded-full text-sm font-bold uppercase tracking-wider transition border 
                    {{ $activeCategory === $category 
                        ? 'bg-amber-500 border-amber-500 text-black' 
                        : 'bg-gray-900 border-gray-700 text-gray-400 hover:border-white hover:text-white' 
                    }}"
                >
                    {{ $category }} <span class="opacity-60 ml-1 text-xs">({{ $count }})</span>
                </button>
            @endif
        @endforeach
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 md:gap-8">
        @foreach($people as $person)
            <a href="{{ route('people.show', $person->id) }}" class="group block bg-gray-900 border border-gray-800 hover:border-amber-500/50 transition duration-300 animate-fade-in-up">
                <div class="aspect-square overflow-hidden relative bg-gray-800">
                    @if($person->avatar)
                        <img src="{{ $person->avatar->getFirstMediaUrl('default', 'thumb') }}" 
                             alt="{{ $person->full_name }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-700 ease-in-out grayscale group-hover:grayscale-0">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-600 text-4xl font-serif">
                            {{ substr($person->first_name, 0, 1) }}
                        </div>
                    @endif
                    
                    <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black/90 to-transparent p-4 pt-12 translate-y-full group-hover:translate-y-0 transition duration-300">
                        <div class="flex flex-wrap gap-1 justify-center">
                            @if($person->categories)
                                @foreach(array_slice($person->categories, 0, 2) as $cat) <span class="text-[10px] text-amber-500 uppercase tracking-widest border border-amber-500/30 px-1.5 py-0.5 bg-black/50 rounded">
                                        {{ $cat }}
                                    </span>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                <div class="p-5 text-center">
                    <h2 class="text-lg font-bold text-white group-hover:text-amber-500 transition font-sans">
                        {{ $person->full_name }}
                    </h2>
                </div>
            </a>
        @endforeach
    </div>

    @if($people->isEmpty())
        <div class="text-center py-20">
            <p class="text-gray-500 text-lg">V této kategorii zatím nikdo není.</p>
        </div>
    @endif

    @if($hasMore)
        <div class="pt-16 text-center">
            <button 
                wire:click="loadMore" 
                wire:loading.attr="disabled"
                class="group relative inline-flex items-center justify-center px-8 py-3 overflow-hidden font-medium tracking-tighter text-white bg-gray-800 rounded-lg group"
            >
                <span class="absolute w-0 h-0 transition-all duration-500 ease-out bg-amber-500 rounded-full group-hover:w-56 group-hover:h-56"></span>
                <span class="absolute inset-0 w-full h-full -mt-1 rounded-lg opacity-30 bg-gradient-to-b from-transparent via-transparent to-gray-700"></span>
                
                <span class="relative flex items-center gap-2 group-hover:text-black transition-colors uppercase tracking-widest text-xs font-bold">
                    <span wire:loading.remove>Načíst další</span>
                    <span wire:loading>Načítám...</span>
                    <svg wire:loading.remove xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" /></svg>
                </span>
            </button>
        </div>
    @endif

</div>