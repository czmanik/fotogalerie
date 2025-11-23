<x-layout title="Zadejte heslo">
    <div class="container mx-auto px-4 h-[60vh] flex items-center justify-center">
        <div class="max-w-md w-full bg-gray-900 border border-gray-800 p-8 text-center rounded-lg shadow-2xl">
            
            <div class="mb-6 text-amber-500">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 mx-auto"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" /></svg>
            </div>

            <h1 class="text-2xl font-bold text-white mb-2">Soukromý projekt</h1>
            <p class="text-gray-400 mb-8">Pro zobrazení obsahu zadejte přístupové heslo.</p>

            <form action="{{ route('projects.unlock', $project->slug) }}" method="POST" class="space-y-4">
                @csrf
                
                <div>
                    <input type="password" name="password" placeholder="Heslo" autofocus
                           class="w-full bg-gray-800 border border-gray-700 text-white px-4 py-3 focus:border-amber-500 focus:outline-none text-center tracking-widest rounded">
                    @error('password')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-amber-500 text-black font-bold py-3 hover:bg-amber-400 transition uppercase text-sm tracking-widest rounded">
                    Vstoupit
                </button>
            </form>
        </div>
    </div>
</x-layout>