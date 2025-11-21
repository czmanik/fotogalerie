<div class="bg-gray-900 p-8 border border-gray-800">
    <h2 class="text-2xl font-bold text-white mb-6">Napište mi</h2>

    @if ($success)
        <div class="bg-green-500/10 border border-green-500 text-green-500 p-4 mb-6 rounded">
            <p class="font-bold">Děkuji za zprávu!</p>
            <p class="text-sm">Ozvu se vám co nejdříve.</p>
        </div>
    @else
        <form wire:submit.prevent="submit" class="space-y-6">
            
            <div>
                <label class="block text-gray-500 text-xs uppercase tracking-widest mb-2">Jméno</label>
                <input type="text" wire:model="name" 
                       class="w-full bg-gray-800 border border-gray-700 text-white px-4 py-3 focus:outline-none focus:border-amber-500 transition @error('name') border-red-500 @enderror">
                @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-gray-500 text-xs uppercase tracking-widest mb-2">Email</label>
                <input type="email" wire:model="email" 
                       class="w-full bg-gray-800 border border-gray-700 text-white px-4 py-3 focus:outline-none focus:border-amber-500 transition @error('email') border-red-500 @enderror">
                @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-gray-500 text-xs uppercase tracking-widest mb-2">Zpráva</label>
                <textarea rows="4" wire:model="body" 
                          class="w-full bg-gray-800 border border-gray-700 text-white px-4 py-3 focus:outline-none focus:border-amber-500 transition @error('body') border-red-500 @enderror"></textarea>
                @error('body') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="w-full bg-amber-500 text-black font-bold uppercase tracking-widest py-4 hover:bg-amber-400 transition disabled:opacity-50" wire:loading.attr="disabled">
                <span wire:loading.remove>Odeslat zprávu</span>
                <span wire:loading>Odesílám...</span>
            </button>
        </form>
    @endif
</div>