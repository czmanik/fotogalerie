<div class="container mx-auto px-4 py-12 max-w-4xl">
    
    <h1 class="text-4xl font-bold text-white mb-8 text-center">Objednávka focení</h1>

    @if ($success)
        <div class="bg-green-500/10 border border-green-500 p-8 text-center rounded-lg">
            <h2 class="text-2xl font-bold text-green-500 mb-4">Rezervace odeslána!</h2>
            <p class="text-gray-300">Děkujeme. Potvrzení vám přijde na email.</p>
            <a href="{{ route('home') }}" class="inline-block mt-6 text-amber-500 hover:text-white underline">Zpět na domů</a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            
            <div>
                <h3 class="text-xl font-bold text-white mb-6">1. Vyberte volný termín</h3>
                
                @if($slots->isEmpty())
                    <p class="text-gray-500 italic">Momentálně nejsou vypsány žádné volné termíny.</p>
                @else
                    <div class="space-y-3">
                        @foreach($slots as $slot)
                            <button 
                                wire:click="selectSlot({{ $slot->id }})"
                                class="w-full text-left px-4 py-3 border rounded transition flex justify-between items-center
                                {{ $selectedSlotId === $slot->id 
                                    ? 'bg-amber-500 border-amber-500 text-black' 
                                    : 'bg-gray-900 border-gray-700 text-gray-300 hover:border-white' 
                                }}">
                                
                                <span class="font-mono text-lg">{{ $slot->start_at->format('d. m. Y') }}</span>
                                <span class="font-bold">{{ $slot->start_at->format('H:i') }}</span>
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="{{ !$selectedSlotId ? 'opacity-30 pointer-events-none' : '' }} transition">
                <h3 class="text-xl font-bold text-white mb-6">2. Kontaktní údaje</h3>

                <form wire:submit.prevent="submit" class="space-y-4">
                    <div>
                        <label class="block text-gray-500 text-xs uppercase tracking-widest mb-1">Jméno</label>
                        <input type="text" wire:model="name" class="w-full bg-gray-800 border border-gray-700 text-white px-3 py-2 focus:border-amber-500 focus:outline-none">
                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-gray-500 text-xs uppercase tracking-widest mb-1">Email</label>
                        <input type="email" wire:model="email" class="w-full bg-gray-800 border border-gray-700 text-white px-3 py-2 focus:border-amber-500 focus:outline-none">
                        @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-gray-500 text-xs uppercase tracking-widest mb-1">Telefon</label>
                        <input type="text" wire:model="phone" class="w-full bg-gray-800 border border-gray-700 text-white px-3 py-2 focus:border-amber-500 focus:outline-none">
                        @error('phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-gray-500 text-xs uppercase tracking-widest mb-1">Poznámka (volitelné)</label>
                        <textarea wire:model="body" rows="3" class="w-full bg-gray-800 border border-gray-700 text-white px-3 py-2 focus:border-amber-500 focus:outline-none"></textarea>
                    </div>

                    <button type="submit" class="w-full bg-amber-500 text-black font-bold py-3 hover:bg-amber-400 transition mt-4">
                        Rezervovat termín
                    </button>
                    
                    @error('selectedSlotId') 
                        <div class="text-red-500 text-center text-sm mt-2 font-bold">{{ $message }}</div> 
                    @enderror
                </form>
            </div>

        </div>
    @endif
</div>