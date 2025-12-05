<div class="container mx-auto px-4 py-12 max-w-5xl relative" x-data>
    
    <div class="text-center max-w-3xl mx-auto mb-16 md:mb-20">
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-8 tracking-tight">
            Objednejte se do ateliéru
        </h1>
        
        <div class="prose prose-invert prose-lg mx-auto text-gray-400 leading-relaxed">
            <p class="mb-6">
                Je skvělé nechat se vyfotit někým, kdo měl před objektivem 
                <span class="text-amber-500 font-bold">Dalajlámu</span>, 
                <span class="text-amber-500 font-bold">Ozzyho Osbourna</span> 
                nebo české prezidenty. 
            </p>
            <p>
                Martin Beck ale nedělá rozdíly. Ať už jste rocková hvězda, nebo si jen chcete 
                udělat radost krásným portrétem, v jeho ateliéru jste vítáni. 
                Zažijte atmosféru profesionálního focení a odneste si snímky, 
                které mají duši a vypráví váš příběh.
            </p>
        </div>
        
        <div class="mt-8 w-24 h-1 bg-amber-500 mx-auto"></div>
    </div>

    @if ($success)
        <div class="bg-green-500/10 border border-green-500 p-12 text-center rounded-lg animate-fade-in max-w-2xl mx-auto my-12">
            <div class="text-green-500 text-5xl mb-6 flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 5.523-4.477 10-10 10S1 17.523 1 12 5.477 2 11 2s10 4.477 10 10Z" /></svg>
            </div>
            <h2 class="text-3xl font-bold text-white mb-4">Termín je předběžně váš!</h2>
            <p class="text-gray-300 text-lg mb-8">Děkujeme za objednávku. Potvrzení vám zašleme na email co nejdříve.</p>
            <a href="{{ route('home') }}" class="inline-block px-8 py-3 border border-amber-500 text-amber-500 hover:bg-amber-500 hover:text-black transition font-bold uppercase tracking-widest text-sm">
                Zpět na domovskou stránku
            </a>
        </div>
    @else
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 items-start" id="booking-grid">
            
            <div class="lg:col-span-1 space-y-8">
                <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-3 sticky top-24 lg:static bg-gray-900 lg:bg-transparent py-2 lg:py-0 z-10">
                    <span class="bg-amber-500 text-black w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold shadow-lg shadow-amber-500/20">1</span>
                    Vyberte termín
                </h3>

                @if($groupedSlots->isEmpty())
                    <div class="p-8 bg-gray-900 border border-gray-800 text-center rounded-lg">
                        <p class="text-gray-500 text-lg">Momentálně nejsou vypsány žádné volné termíny.</p>
                        <p class="text-gray-600 text-sm mt-2">Zkuste to prosím později nebo nám napište přes kontaktní formulář.</p>
                    </div>
                @else
                    <div class="space-y-8">
                        @foreach($groupedSlots as $month => $monthSlots)
                            <div class="bg-gray-900/50 border border-gray-800 p-5 rounded-lg">
                                <h4 class="text-amber-500 font-bold text-lg mb-4 border-b border-gray-700 pb-3 uppercase tracking-wide">
                                    {{ $month }}
                                </h4>
                                
                                <div class="space-y-2">
                                    @foreach($monthSlots as $slot)
                                        @php
                                            $isFree = $slot->status === 'free';
                                            $isSelected = $selectedSlotId === $slot->id;
                                        @endphp
                                        
                                        <button 
                                            @if($isFree) 
                                                wire:click="selectSlot({{ $slot->id }})" 
                                                @click="$nextTick(() => {
                                                    if (window.innerWidth >= 1024) {
                                                        // Na desktopu jen jemný posun, pokud je potřeba
                                                        document.getElementById('contact-form-section').scrollIntoView({ behavior: 'smooth', block: 'center' });
                                                    }
                                                    // Na mobilu neposouváme hned, necháme uživatele, ať si vybere, nebo použije floating bar
                                                })"
                                            @endif
                                            class="w-full flex flex-col justify-between items-start px-4 py-3 border rounded-md transition duration-200 group relative overflow-hidden
                                            {{ !$isFree ? 'bg-gray-900 border-gray-800 text-gray-600 cursor-not-allowed opacity-50' : '' }}
                                            {{ $isFree && !$isSelected ? 'bg-gray-800 border-gray-700 text-gray-300 hover:border-amber-500 hover:bg-gray-750' : '' }}
                                            {{ $isSelected ? 'bg-amber-500 border-amber-500 text-black shadow-lg shadow-amber-500/20 scale-[1.02] z-10' : '' }}
                                            "
                                            {{ !$isFree ? 'disabled' : '' }}
                                        >
                                            <div class="flex justify-between w-full items-center">
                                                <div class="text-left">
                                                    <div class="font-mono text-lg leading-none flex items-baseline gap-2">
                                                        <span>{{ $slot->start_at->format('d. m.') }}</span>
                                                        <span class="text-xs {{ $isSelected ? 'text-black/70' : 'text-gray-500' }} uppercase font-sans font-bold">
                                                            {{ $slot->start_at->translatedFormat('l') }}
                                                        </span>
                                                    </div>
                                                </div>
                                                
                                                <span class="font-bold text-xl">{{ $slot->start_at->format('H:i') }}</span>
                                            </div>

                                            @if($slot->title || $slot->price || $slot->duration_minutes || $slot->location)
                                                <div class="w-full border-t {{ $isSelected ? 'border-black/10' : 'border-gray-700' }} mt-2 pt-2 flex flex-col gap-1 text-xs text-left">
                                                    <div class="flex justify-between items-center w-full">
                                                        <span class="font-bold uppercase tracking-wider {{ $isSelected ? 'text-black' : 'text-amber-500' }}">
                                                            {{ $slot->title ?? 'Focení' }}
                                                        </span>

                                                        @if($slot->price)
                                                            <span class="font-mono font-bold {{ $isSelected ? 'text-black' : 'text-gray-400' }}">
                                                                {{ number_format($slot->price, 0, ',', ' ') }} Kč
                                                            </span>
                                                        @endif
                                                    </div>

                                                    @if($slot->duration_minutes || $slot->location)
                                                        <div class="flex items-center gap-3 {{ $isSelected ? 'text-black/80' : 'text-gray-500' }} mt-1">
                                                            @if($slot->duration_minutes)
                                                                <span class="flex items-center gap-1">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3"><path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm.75-13a.75.75 0 0 0-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 0 0 0-1.5h-3.25V5Z" clip-rule="evenodd" /></svg>
                                                                    {{ $slot->duration_minutes }} min
                                                                </span>
                                                            @endif
                                                            @if($slot->location)
                                                                <span class="flex items-center gap-1">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3"><path fill-rule="evenodd" d="m9.69 18.933.003.001C9.89 19.02 10 19.02 10 19.02s.11.001.307-.086l.002-.001.002-.001.001-.001a2.139 2.139 0 0 0 1.086-1.018l.002-.006.004-.012A9.778 9.778 0 0 0 12.872 13H15a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h2.128a9.78 9.78 0 0 0 1.464 4.89l.004.012.002.005a2.137 2.137 0 0 0 1.092 1.025Zm.03-9.526A1.75 1.75 0 1 1 8 9a1.75 1.75 0 0 1 1.72 1.407Z" clip-rule="evenodd" /></svg>
                                                                    {{ $slot->location->getLabel() }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif

                                            @if(!$isFree)
                                                <div class="absolute inset-0 flex items-center justify-center bg-gray-900/60 backdrop-blur-[1px]">
                                                    <span class="text-[10px] uppercase border border-gray-500 text-gray-400 px-2 py-1 rounded font-bold bg-gray-900">Obsazeno</span>
                                                </div>
                                            @endif
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if($hasMore)
                        <div class="pt-8 text-center">
                            <button wire:click="loadMore" class="px-6 py-3 border border-gray-700 text-gray-400 hover:text-white hover:border-white transition uppercase text-xs tracking-widest">
                                Načíst další termíny
                            </button>
                        </div>
                    @endif
                @endif
            </div>

            <div id="contact-form-section" class="lg:col-span-2 lg:sticky lg:top-24 transition-all duration-700 {{ !$selectedSlotId ? 'opacity-50 grayscale blur-[1px] pointer-events-none' : 'opacity-100' }}">
                
                <h3 class="text-xl font-bold text-white mb-6 flex items-center gap-3">
                    <span class="bg-amber-500 text-black w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold shadow-lg shadow-amber-500/20">2</span>
                    Kontaktní údaje
                </h3>

                @if($selectedSlotId)
                    @php
                        $selectedSlotInfo = \App\Models\PhotoSlot::find($selectedSlotId);
                    @endphp

                    @if($selectedSlotInfo)
                        <div class="mb-8 bg-gradient-to-r from-amber-500/10 to-transparent border-l-4 border-amber-500 p-6 rounded-r-lg relative animate-fade-in-up">
                            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                                <div>
                                    <p class="text-amber-500 text-xs uppercase tracking-widest font-bold mb-2">Vybraný termín</p>
                                    <div class="flex items-baseline gap-3 text-white">
                                        <span class="text-2xl font-mono font-bold">{{ $selectedSlotInfo->start_at->format('d. m. Y') }}</span>
                                        <span class="text-xl text-gray-400">/</span>
                                        <span class="text-2xl font-bold text-amber-500">{{ $selectedSlotInfo->start_at->format('H:i') }}</span>
                                    </div>
                                    
                                    @if($selectedSlotInfo->title)
                                        <p class="text-white font-bold text-lg mt-2">{{ $selectedSlotInfo->title }}</p>
                                    @endif

                                    @if($selectedSlotInfo->price)
                                        <p class="text-gray-400 text-sm mt-1 font-mono">
                                            Cena: <span class="text-white">{{ number_format($selectedSlotInfo->price, 0, ',', ' ') }} Kč</span>
                                        </p>
                                    @endif

                                    @if($selectedSlotInfo->duration_minutes || $selectedSlotInfo->location)
                                        <div class="flex items-center gap-4 mt-3 text-gray-300 text-sm">
                                            @if($selectedSlotInfo->duration_minutes)
                                                <span class="flex items-center gap-1.5 bg-gray-800 px-2 py-1 rounded">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-amber-500"><path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm.75-13a.75.75 0 0 0-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 0 0 0-1.5h-3.25V5Z" clip-rule="evenodd" /></svg>
                                                    {{ $selectedSlotInfo->duration_minutes }} min
                                                </span>
                                            @endif
                                            @if($selectedSlotInfo->location)
                                                <span class="flex items-center gap-1.5 bg-gray-800 px-2 py-1 rounded">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-amber-500"><path fill-rule="evenodd" d="m9.69 18.933.003.001C9.89 19.02 10 19.02 10 19.02s.11.001.307-.086l.002-.001.002-.001.001-.001a2.139 2.139 0 0 0 1.086-1.018l.002-.006.004-.012A9.778 9.778 0 0 0 12.872 13H15a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h2.128a9.78 9.78 0 0 0 1.464 4.89l.004.012.002.005a2.137 2.137 0 0 0 1.092 1.025Zm.03-9.526A1.75 1.75 0 1 1 8 9a1.75 1.75 0 0 1 1.72 1.407Z" clip-rule="evenodd" /></svg>
                                                    {{ $selectedSlotInfo->location->getLabel() }}
                                                </span>
                                            @endif
                                        </div>
                                    @endif
                                </div>

                                <button @click="window.scrollTo({ top: 0, behavior: 'smooth' })" class="text-gray-500 hover:text-white text-xs uppercase tracking-widest underline shrink-0 self-start sm:self-center">
                                    Změnit
                                </button>
                            </div>

                            @if($selectedSlotInfo->description)
                                <div class="mt-4 pt-4 border-t border-amber-500/20 text-gray-300 text-sm italic flex items-start gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-amber-500 shrink-0 mt-0.5"><path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-7-4a1 1 0 1 1-2 0 1 1 0 0 1 2 0ZM9 9a.75.75 0 0 0 0 1.5h.253a.25.25 0 0 1 .244.304l-.459 2.066A1.75 1.75 0 0 0 10.747 15H11a.75.75 0 0 0 0-1.5h-.253a.25.25 0 0 1-.244-.304l.459-2.066A1.75 1.75 0 0 0 9.253 9H9Z" clip-rule="evenodd" /></svg>
                                    {{ $selectedSlotInfo->description }}
                                </div>
                            @endif
                        </div>
                    @endif
                @endif

                <div class="bg-gray-900 border border-gray-800 p-8 md:p-10 relative overflow-hidden rounded-lg shadow-2xl">
                    <div class="absolute top-0 left-0 w-1 h-full bg-gradient-to-b from-amber-500 to-gray-900"></div>

                    <form wire:submit.prevent="submit" class="space-y-6 pl-2">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="group">
                                <label class="block text-gray-500 text-xs uppercase tracking-widest mb-2 group-focus-within:text-amber-500 transition-colors">Jméno *</label>
                                <input type="text" wire:model="name" class="w-full bg-gray-800 border border-gray-700 text-white px-4 py-3 focus:border-amber-500 focus:outline-none transition placeholder-gray-600 rounded-sm">
                                @error('name') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                            </div>
                            <div class="group">
                                <label class="block text-gray-500 text-xs uppercase tracking-widest mb-2 group-focus-within:text-amber-500 transition-colors">Telefon *</label>
                                <input type="text" wire:model="phone" class="w-full bg-gray-800 border border-gray-700 text-white px-4 py-3 focus:border-amber-500 focus:outline-none transition placeholder-gray-600 rounded-sm">
                                @error('phone') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="group">
                            <label class="block text-gray-500 text-xs uppercase tracking-widest mb-2 group-focus-within:text-amber-500 transition-colors">Email *</label>
                            <input type="email" wire:model="email" class="w-full bg-gray-800 border border-gray-700 text-white px-4 py-3 focus:border-amber-500 focus:outline-none transition placeholder-gray-600 rounded-sm">
                            @error('email') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="group">
                            <label class="block text-gray-500 text-xs uppercase tracking-widest mb-2 group-focus-within:text-amber-500 transition-colors">Poznámka (volitelné)</label>
                            <textarea wire:model="body" rows="3" class="w-full bg-gray-800 border border-gray-700 text-white px-4 py-3 focus:border-amber-500 focus:outline-none transition placeholder-gray-600 rounded-sm" placeholder="Máte speciální přání?"></textarea>
                        </div>

                        <div class="pt-6 border-t border-gray-800 mt-6">
                            <button type="submit" 
                                    wire:loading.attr="disabled"
                                    @if(!$selectedSlotId) disabled class="w-full bg-gray-800 text-gray-500 font-bold text-lg py-4 cursor-not-allowed uppercase tracking-wider rounded-sm" @else class="w-full bg-amber-500 text-black font-bold text-lg py-4 hover:bg-amber-400 transition flex justify-center items-center gap-3 uppercase tracking-wider rounded-sm shadow-lg shadow-amber-500/20" @endif>
                                
                                <span wire:loading.remove>
                                    @if(!$selectedSlotId) Vyberte termín @else Dokončit rezervaci @endif
                                </span>
                                <span wire:loading><svg class="animate-spin h-5 w-5 text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg></span>
                            </button>
                            <p class="text-center text-gray-600 text-xs mt-4">
                                Odesláním souhlasíte se zpracováním osobních údajů.
                            </p>
                        </div>
                        
                        @error('selectedSlotId') 
                            <div class="bg-red-500/10 border border-red-500 text-red-500 p-3 text-center rounded mt-4 text-sm font-bold">
                                {{ $message }}
                            </div> 
                        @enderror
                    </form>
                </div>
            </div>
        </div>

        @if($selectedSlotId)
            @php $selectedSlotBar = \App\Models\PhotoSlot::find($selectedSlotId); @endphp
            <div class="fixed bottom-0 left-0 w-full bg-gray-900 border-t border-amber-500 p-4 lg:hidden z-50 flex justify-between items-center shadow-[0_-5px_20px_rgba(0,0,0,0.5)] animate-slide-up">
                <div>
                    <div class="text-[10px] text-gray-400 uppercase tracking-wider">Vybráno:</div>
                    <div class="text-white font-mono text-lg leading-none">
                        {{ $selectedSlotBar->start_at->format('d.m.') }} <span class="text-amber-500 font-bold">{{ $selectedSlotBar->start_at->format('H:i') }}</span>
                    </div>
                </div>
                <button 
                    onclick="const el = document.getElementById('contact-form-section'); const y = el.getBoundingClientRect().top + window.scrollY - 100; window.scrollTo({top: y, behavior: 'smooth'});"
                    type="button"
                    class="bg-amber-500 text-black px-6 py-2.5 font-bold uppercase text-xs tracking-widest rounded hover:bg-white transition shadow-lg shadow-amber-500/20"
                >
                    Pokračovat
                </button>
            </div>
            <div class="h-20 lg:hidden"></div>
        @endif

    @endif
</div>