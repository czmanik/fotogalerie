<x-layout :title="$person->full_name">

    <div class="container mx-auto px-4 py-12">
        
        <div class="flex flex-col md:flex-row gap-12 mb-20 items-start">
            <div class="w-full md:w-1/3 lg:w-1/4 shrink-0">
                <div class="aspect-[3/4] overflow-hidden border border-gray-800">
                    @if($person->avatar)
                        <img src="{{ $person->avatar->getFirstMediaUrl('default', 'medium') }}" 
                             alt="{{ $person->full_name }}" 
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gray-800 flex items-center justify-center text-gray-600">Bez fota</div>
                    @endif
                </div>
            </div>

            <div class="w-full md:w-2/3 lg:w-3/4">
                <a href="{{ route('people.index') }}" class="text-gray-500 hover:text-white text-sm uppercase tracking-wider mb-4 inline-block">&larr; Zpět do katalogu</a>
                
                <h1 class="text-4xl md:text-6xl font-bold text-white mb-4">{{ $person->full_name }}</h1>
                
                @if($person->categories)
                    <div class="flex gap-2 mb-6">
                        @foreach($person->categories as $category)
                            <span class="px-3 py-1 bg-gray-800 text-amber-500 text-sm font-medium uppercase tracking-widest">
                                {{ $category }}
                            </span>
                        @endforeach
                    </div>
                @endif

                @if($person->birth_date)
                    <div class="text-gray-400 font-mono text-sm mb-6">
                        * {{ $person->birth_date->format('d. m. Y') }}
                        @if($person->death_date)
                            &dagger; {{ $person->death_date->format('d. m. Y') }}
                        @endif
                    </div>
                @endif

                @if($person->bio)
                    <div class="prose prose-invert prose-lg text-gray-400 max-w-none">
                        <p>{{ $person->bio }}</p>
                    </div>
                @endif
            </div>
        </div>

        @if($person->photos->isNotEmpty())
            <div class="border-t border-gray-800 pt-12">
                <h2 class="text-2xl font-bold text-white mb-8">Fotografie s {{ $person->last_name }}</h2>
                
                <div class="columns-1 md:columns-2 lg:columns-3 gap-4 space-y-4">
                    @foreach($person->photos as $photo)
                        <div class="break-inside-avoid">
                            <a href="{{ route('photo.show', $photo->slug) }}"
                               class="block relative group overflow-hidden">
                                <img src="{{ $photo->getFirstMediaUrl('default', 'medium') }}" 
                                     alt="{{ $photo->title }}"
                                     class="w-full h-auto object-cover transition duration-500 group-hover:brightness-110">
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</x-layout>