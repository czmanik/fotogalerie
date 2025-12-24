<x-layout title="O mně">
    {{-- 1. HERO SEKCE --}}
    <div class="relative bg-black text-white overflow-hidden">
        {{-- Jemný šum na pozadí --}}
        <div class="absolute inset-0 opacity-10 pointer-events-none mix-blend-overlay" style="background-image: url('https://grainy-gradients.vercel.app/noise.svg');"></div>

        <div class="container mx-auto px-4 py-16 md:py-24 relative z-10">
            <div class="flex flex-col md:flex-row items-center gap-12">
                
                {{-- Levá část: Fotka Martina --}}
                <div class="w-full md:w-1/2 relative group">
                    <div class="absolute inset-0 bg-amber-600/20 rounded-sm transform translate-x-4 translate-y-4 transition duration-500"></div>
                    <img 
    src="https://www.datocms-assets.com/11302/1571136088-martin-beck-foto-josef-rabara.jpg" 
    alt="Martin Beck" 
    class="relative w-full h-[500px] object-cover shadow-2xl rounded-sm filter contrast-125 grayscale hover:grayscale-0 transition duration-700">
                </div>

                {{-- Pravá část: Nadpis a osobní vyznání --}}
                <div class="w-full md:w-1/2 text-center md:text-left">
                    <h5 class="text-amber-500 tracking-[0.2em] text-sm font-bold uppercase mb-4">Fotograf & Operní pěvec</h5>
                    <h1 class="text-5xl md:text-7xl font-bold font-serif text-white mb-8 leading-tight">
                        Martin <br> <span class="text-transparent bg-clip-text bg-gradient-to-r from-gray-200 to-gray-500">Beck</span>
                    </h1>
                    
                    <div class="border-l-4 border-amber-500 pl-6 my-8">
                        <p class="text-xl md:text-2xl text-gray-300 font-serif italic leading-relaxed">
                            "Nesnažím se jen o fotku. Snažím se nahlédnout do vaší duše a zachytit vás tak, 
                            jak byste se chtěli vidět vy sami."
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. MŮJ PŘÍBĚH (ICH-FORMA) --}}
    <div class="bg-gray-900 py-16 md:py-24 border-t border-gray-800">
        <div class="container mx-auto px-4 max-w-5xl">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-start">
                
                {{-- Sloupec 1: Osobní příběh --}}
                <div class="prose prose-lg prose-invert text-gray-400">
                    <h3 class="text-white font-bold text-2xl mb-6 font-serif">Dva světy, jeden pohled</h3>
                    <p>
                        Jmenuji se Martin Beck a pohybuji se ve dvou světech, které k sobě mají blíže, než by se mohlo zdát. 
                        Jako <strong>operní pěvec</strong>, který prošel Pražskou konzervatoří až na prkna Národního divadla,
                        vnímám svět skrze emoce, drama a jevištní světlo.
                    </p>
                    <p><br/></p>
                    <p>
                        Profesionální fotografii se věnuji od roku 2002 a od roku 2014 mám tu čest propojovat obě své vášně jako 
                        oficiální <strong>umělecký fotograf Národního divadla</strong>. Moje zkušenost z jeviště mi pomáhá 
                        rozumět lidem před objektivem – vím, co prožívají, a umím je vést.
                    </p>
                    <p class="italic text-gray-500 text-base mt-4 border-l-2 border-gray-700 pl-4">
                        Moje cesta začala s legendární <strong>Minoltou X-700</strong>. Tento fotoaparát mě naučil vidět svět v rámečku 
                        a položil základy mé lásky k analogové technice.
                    </p>
                </div>

                {{-- Sloupec 2: Technika (Důraz na FOMA a Analog) --}}
                <div class="bg-black p-8 rounded-sm border border-gray-800 relative overflow-hidden group">
                    {{-- Dekorativní prvek --}}
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-amber-500/10 rounded-full blur-2xl"></div>

                    <h3 class="text-white font-bold text-2xl mb-8 font-serif flex items-center gap-3">
                        <span class="text-amber-500 text-3xl">✦</span> Klasický proces
                    </h3>
                    
                    <p class="text-gray-400 mb-8 leading-relaxed">
                        V digitální době volím cestu, která vyžaduje čas a pokoru. Nepoužívám digitální techniku. 
                        Každá moje fotografie je <strong>ručně zhotovený originál</strong>.
                    </p>
                    
                    <ul class="space-y-6">
                        <li class="flex items-start gap-4">
                            <span class="text-amber-500 mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            </span>
                            <div>
                                <strong class="text-white block font-mono text-sm uppercase tracking-wide">Hasselblad 503CW</strong>
                                <span class="text-sm text-gray-500">Ikonický středoformát, který mě nutí zpomalit a přemýšlet nad každým záběrem.</span>
                            </div>
                        </li>
                        
                        <li class="flex items-start gap-4">
                            <span class="text-amber-500 mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                            </span>
                            <div>
                                <strong class="text-white block font-mono text-sm uppercase tracking-wide">Temná komora & Foma</strong>
                                <span class="text-sm text-gray-500">
                                    Magie vzniká ve tmě. Fotografie ručně zvětšuji na prvotřídní barytové papíry značky 
                                    <span class="text-gray-300 font-bold border-b border-gray-600">Foma Bohemia</span>. 
                                    Díky tomu je každý snímek unikát.
                                </span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            
            {{-- Seznam osobností --}}
            <div class="mt-20 text-center">
                <h4 class="text-gray-600 uppercase tracking-[0.3em] text-xs font-bold mb-8">Před mým objektivem stáli</h4>
                <div class="flex flex-wrap justify-center gap-x-8 gap-y-4 text-gray-400 font-light text-lg md:text-xl leading-relaxed max-w-4xl mx-auto">
                    <span class="hover:text-amber-500 transition cursor-default">Dalajlama</span> 
                    <span class="text-gray-700">•</span>
                    <span class="hover:text-amber-500 transition cursor-default">Václav Havel</span> 
                    <span class="text-gray-700">•</span>
                    <span class="hover:text-amber-500 transition cursor-default text-white font-medium">Ozzy Osbourne</span> 
                    <span class="text-gray-700">•</span>
                    <span class="hover:text-amber-500 transition cursor-default">Miloš Forman</span> 
                    <span class="text-gray-700">•</span>
                    <span class="hover:text-amber-500 transition cursor-default">Karel Gott</span> 
                    <span class="text-gray-700">•</span>
                    <span class="hover:text-amber-500 transition cursor-default">Edita Gruberová</span> 
                    <span class="text-gray-700">•</span>
                    <span class="hover:text-amber-500 transition cursor-default">Jan Saudek</span> 
                    <span class="text-gray-700">•</span>
                    <span class="hover:text-amber-500 transition cursor-default">Linkin Park</span>
                </div>
            </div>
        </div>
    </div>

    {{-- 3. VÝSTAVY --}}
    @if($exhibitions->isNotEmpty())
    <div class="bg-black py-16 md:py-24">
        <div class="container mx-auto px-4 max-w-4xl">
            <h2 class="text-3xl md:text-4xl font-serif text-white mb-16 text-center">Výstavy</h2>
            
            <div class="relative border-l border-gray-800 ml-6 md:ml-0 space-y-12">
                @foreach($exhibitions as $exhibition)
                    <div class="relative pl-12 md:pl-0 md:flex md:gap-12 group">
                        {{-- Bod na časové ose --}}
                        <div class="absolute -left-[5px] md:left-auto md:right-1/3 top-2 w-2.5 h-2.5 bg-gray-600 rounded-full border-4 border-black group-hover:bg-amber-500 transition duration-300 md:translate-x-[5px] z-10"></div>

                        {{-- Datum (vlevo na desktopu) --}}
                        <div class="md:w-1/3 md:text-right md:pr-12 mb-2 md:mb-0">
                            <span class="text-amber-500 font-mono text-xl font-bold block">
                                {{ $exhibition->start_date->format('Y') }}
                            </span>
                            <span class="text-xs text-gray-500 uppercase tracking-widest">
                                {{ $exhibition->start_date->format('d.m.') }} 
                                @if($exhibition->end_date) - {{ $exhibition->end_date->format('d.m.') }} @endif
                            </span>
                        </div>

                        {{-- Obsah (vpravo na desktopu) --}}
                        <div class="md:w-2/3 md:pl-12">
                            <h3 class="text-xl text-white font-serif tracking-wide group-hover:text-amber-500 transition duration-300">
                                {{ $exhibition->title }}
                            </h3>
                            <div class="text-gray-500 text-sm mt-2 flex items-center gap-2 uppercase tracking-wider">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" /></svg>
                                {{ $exhibition->location }}
                            </div>
                            @if($exhibition->description)
                                <p class="text-gray-600 mt-3 text-sm leading-relaxed max-w-prose">
                                    {{ $exhibition->description }}
                                </p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- 4. MÉDIA - JEDNODUCHÝ ČISTÝ LIST --}}
    @if($articles->isNotEmpty())
    <div class="container mx-auto px-4 py-16 max-w-4xl">
        <h2 class="text-2xl font-serif text-white mb-10 text-center">Napsali o mně</h2>
        <div class="grid gap-4">
            @foreach($articles as $article)
                <a href="{{ $article->url }}" target="_blank" class="group flex items-center justify-between p-6 bg-gray-900 border border-gray-800 hover:border-amber-500 transition duration-300">
                    <div>
                        <div class="text-xs text-amber-500 font-mono mb-1">{{ $article->source_name ?? 'Média' }}</div>
                        <h3 class="text-lg text-gray-300 group-hover:text-white transition font-medium">
                            {{ $article->title }}
                        </h3>
                    </div>
                    <div class="text-gray-600 group-hover:text-amber-500 transition transform group-hover:translate-x-1">
                        →
                    </div>
                </a>
            @endforeach
        </div>
    </div>
    @endif
</x-layout>