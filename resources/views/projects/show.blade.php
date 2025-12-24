<x-layout :title="$project->title">
    
    <div class="bg-gray-900 border-b border-gray-800 pt-12 pb-16">
        <div class="container mx-auto px-4 text-center">
            <a href="{{ route('projects.index') }}" class="inline-flex items-center text-gray-500 hover:text-white mb-6 text-sm uppercase tracking-wider transition">
                &larr; Zpět na projekty
            </a>
            
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">{{ $project->title }}</h1>
            
            @if($project->description)
                <div class="max-w-3xl mx-auto text-gray-400 text-lg leading-relaxed prose prose-invert">
                    {!! $project->description !!}
                </div>
            @endif
            
            </div>
    </div>

    <div class="container mx-auto px-4 py-12">
        
        @if($project->photos->isEmpty())
            <div class="text-center text-gray-500 py-20">
                Tento projekt zatím neobsahuje žádné fotografie.
            </div>
        @else
            <div class="columns-1 md:columns-2 lg:columns-3 gap-4 space-y-4">
                @foreach($project->photos as $photo)
                    <div class="break-inside-avoid">
                        <a href="{{ route('photo.show', ['slug' => $photo->slug, 'projectId' => $project->id]) }}"
                           class="block relative group overflow-hidden">
                            
                            <img src="{{ $photo->getFirstMediaUrl('default', 'medium') }}" 
                                 alt="{{ $photo->title ?? 'Fotografie' }}"
                                 class="w-full h-auto object-cover transition duration-500 group-hover:brightness-110"
                                 loading="lazy">
                            
                            <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition duration-300 flex flex-col items-center justify-center text-center p-4">
                                @if($photo->title)
                                    <h3 class="text-white font-semibold text-lg translate-y-4 group-hover:translate-y-0 transition duration-300 delay-75">
                                        {{ $photo->title }}
                                    </h3>
                                @endif
                                <p class="text-amber-500 text-sm mt-2 translate-y-4 group-hover:translate-y-0 transition duration-300 delay-100">
                                    Detail fotografie
                                </p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif

    </div>

    </x-layout>