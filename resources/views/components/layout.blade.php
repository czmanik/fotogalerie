<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Martin Beck' }} | Fotogalerie</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        .aspect-3-2 { aspect-ratio: 3 / 2; }
    </style>
</head>
<body class="bg-gray-900 text-gray-100 flex flex-col min-h-screen">

    <header class="border-b border-gray-800 bg-gray-900/90 backdrop-blur sticky top-0 z-50"
        x-data="{ mobileMenuOpen: false }"
        x-on:livewire:navigated.window="mobileMenuOpen = false"
    >
        <div class="container mx-auto px-4 h-20 flex items-center justify-between">
            <a href="{{ route('home') }}" class="text-2xl font-semibold tracking-widest uppercase text-white hover:text-amber-500 transition z-50 relative">
                Martin Beck
            </a>

            <nav class="hidden md:flex space-x-8 text-sm uppercase tracking-wider font-medium">
                <a href="{{ route('home') }}" wire:navigate class="{{ request()->routeIs('home') ? 'text-amber-500' : 'text-gray-400 hover:text-white' }} transition">Domů</a>
                <a href="{{ route('projects.index') }}" wire:navigate class="{{ request()->routeIs('projects.*') ? 'text-amber-500' : 'text-gray-400 hover:text-white' }} transition">Projekty</a>
                <a href="{{ route('people.index') }}" wire:navigate class="{{ request()->routeIs('people.*') ? 'text-amber-500' : 'text-gray-400 hover:text-white' }} transition">Osobnosti</a>
                <a href="{{ route('about') }}" wire:navigate class="{{ request()->routeIs('about') ? 'text-amber-500' : 'text-gray-400 hover:text-white' }} transition">O mně</a>
                <a href="{{ route('contact') }}" wire:navigate class="{{ request()->routeIs('contact') ? 'text-amber-500' : 'text-gray-400 hover:text-white' }} transition">Kontakt</a>
                <a href="{{ route('booking') }}" wire:navigate class="text-black bg-amber-500 px-3 py-1 rounded hover:bg-white transition">
                    Rezervovat
                </a>
            </nav>

            <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-gray-300 z-50 relative focus:outline-none">
                <svg x-show="!mobileMenuOpen" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
                <svg x-cloak x-show="mobileMenuOpen" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div 
            x-cloak 
            x-show="mobileMenuOpen" 
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-10"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-10"
            class="absolute top-0 left-0 w-full h-screen bg-gray-900 z-40 flex flex-col items-center justify-center md:hidden space-y-8 text-xl uppercase tracking-widest font-semibold"
        >
            <a href="{{ route('home') }}" wire:navigate @click="mobileMenuOpen = false" class="{{ request()->routeIs('home') ? 'text-amber-500' : 'text-white' }}">Domů</a>
            <a href="{{ route('projects.index') }}" wire:navigate @click="mobileMenuOpen = false" class="{{ request()->routeIs('projects.*') ? 'text-amber-500' : 'text-white' }}">Projekty</a>
            <a href="{{ route('people.index') }}" wire:navigate @click="mobileMenuOpen = false" class="{{ request()->routeIs('people.*') ? 'text-amber-500' : 'text-white' }}">Osobnosti</a>
            <a href="{{ route('about') }}" wire:navigate @click="mobileMenuOpen = false" class="{{ request()->routeIs('about') ? 'text-amber-500' : 'text-white' }}">O mně</a>
            <a href="{{ route('contact') }}" wire:navigate @click="mobileMenuOpen = false" class="{{ request()->routeIs('contact') ? 'text-amber-500' : 'text-white' }}">Kontakt</a>
            
            <a href="{{ route('booking') }}" wire:navigate @click="mobileMenuOpen = false" class="text-black bg-amber-500 px-8 py-3 rounded mt-4">
                Rezervovat focení
            </a>
        </div>
    </header>

    <main class="flex-grow">
        {{ $slot }}
    </main>

    <footer class="bg-black py-16 border-t border-gray-800 mt-auto">
        <div class="container mx-auto px-4">
            
            <div class="mb-12 pb-12 border-b border-gray-800 flex flex-col md:flex-row items-center justify-between gap-6">
                <span class="text-xs text-gray-600 uppercase tracking-widest">Partneři projektu</span>
                <div class="flex gap-8 grayscale opacity-50 hover:opacity-100 transition">
                    <div class="w-8 h-8 bg-gray-800 rounded-full"></div>
                    <div class="w-8 h-8 bg-gray-800 rounded-full"></div>
                    <div class="w-8 h-8 bg-gray-800 rounded-full"></div>
                </div>
                <a href="{{ route('partners') }}" class="text-xs text-gray-500 hover:text-white transition">Zobrazit vše</a>
            </div>

            <div class="text-center">
                <h3 class="text-xl font-semibold text-white mb-4 tracking-widest uppercase">Martin Beck</h3>
                <p class="text-gray-500 text-sm mb-8">Fotografie, které vypráví příběhy.</p>
                
                <div class="flex justify-center space-x-6 mb-8">
                    <a href="#" class="text-gray-400 hover:text-amber-500 transition">Instagram</a>
                    <a href="#" class="text-gray-400 hover:text-amber-500 transition">Facebook</a>
                </div>

                <p class="text-gray-700 text-xs">
                    &copy; {{ date('Y') }} Martin Beck.
                </p>
            </div>
        </div>
    </footer>

</body>
</html>