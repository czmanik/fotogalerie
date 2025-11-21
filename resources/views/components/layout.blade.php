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

    <header class="border-b border-gray-800 bg-gray-900/90 backdrop-blur sticky top-0 z-50">
        <div class="container mx-auto px-4 h-20 flex items-center justify-between">
            <a href="{{ route('home') }}" class="text-2xl font-semibold tracking-widest uppercase text-white hover:text-amber-500 transition">
                Martin Beck
            </a>

            <nav class="hidden md:flex space-x-8 text-sm uppercase tracking-wider font-medium">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-amber-500' : 'text-gray-400 hover:text-white' }} transition">Domů</a>
                <a href="{{ route('projects.index') }}" class="{{ request()->routeIs('projects.*') ? 'text-amber-500' : 'text-gray-400 hover:text-white' }} transition">Projekty</a>
                <a href="{{ route('people.index') }}" class="{{ request()->routeIs('people.*') ? 'text-amber-500' : 'text-gray-400 hover:text-white' }} transition">Osobnosti</a>
                <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'text-amber-500' : 'text-gray-400 hover:text-white' }} transition">O mně</a>
                <a href="{{ route('booking') }}" class="text-black bg-amber-500 px-3 py-1 rounded hover:bg-white transition">Rezervovat focení</a>
                <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'text-amber-500' : 'text-gray-400 hover:text-white' }} transition">Kontakt</a>
            </nav>

            <button class="md:hidden text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>
        </div>
    </header>

    <main class="flex-grow">
        {{ $slot }}
    </main>

    <footer class="bg-black py-12 border-t border-gray-800 mt-12">
        <div class="container mx-auto px-4 text-center">
            <h3 class="text-xl font-semibold text-white mb-4">Martin Beck</h3>
            <p class="text-gray-500 text-sm mb-6">Fotografie, které vypráví příběhy.</p>
            
            <div class="flex justify-center space-x-6 mb-8">
                <a href="#" class="text-gray-400 hover:text-white transition">Instagram</a>
                <a href="#" class="text-gray-400 hover:text-white transition">Facebook</a>
            </div>

            <p class="text-gray-600 text-xs">
                &copy; {{ date('Y') }} Martin Beck. Všechna práva vyhrazena.
            </p>
        </div>
    </footer>

</body>
</html>