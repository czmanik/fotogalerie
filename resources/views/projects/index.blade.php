<x-layout title="Všechny projekty">
    <div class="container mx-auto px-4 py-12">
        
        <div class="text-center mb-16">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Portfolio</h1>
            <p class="text-gray-400 max-w-2xl mx-auto">
                Výběr z mých fotografických projektů.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($projects as $project)
                <a href="{{ route('projects.show', $project->slug) }}" class="group block bg-gray-900 border border-gray-800 hover:border-amber-500/50 transition duration-300">
                    <div class="aspect-3-2 overflow-hidden relative">
                        @if($project->coverPhoto)
                            <img src="{{ $project->coverPhoto->getFirstMediaUrl('default', 'medium') }}" 
                                 alt="{{ $project->title }}" 
                                 class="w-full h-full object-cover transform group-hover:scale-105 transition duration-700 ease-in-out">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-800 text-gray-600">
                                Bez náhledu
                            </div>
                        @endif
                        
                        @if($project->visibility === 'password')
                             <div class="absolute top-2 right-2 bg-amber-500 text-black text-xs px-2 py-1 font-bold uppercase tracking-wider rounded">
                                 Heslo
                             </div>
                        @endif
                    </div>
                    
                    <div class="p-6">
                        <h2 class="text-xl font-bold text-white mb-2 group-hover:text-amber-500 transition">
                            {{ $project->title }}
                        </h2>
                        @if($project->description)
                            <p class="text-gray-500 text-sm line-clamp-2">
                                {{ $project->description }}
                            </p>
                        @endif
                        
                        <div class="mt-4 text-amber-500 text-xs uppercase tracking-widest font-semibold opacity-0 transform translate-y-2 group-hover:opacity-100 group-hover:translate-y-0 transition duration-300">
                            Prohlédnout galerii &rarr;
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</x-layout>