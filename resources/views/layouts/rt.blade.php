<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Panel RT - Desa Bengle' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">

    {{-- Top bar mobile --}}
    <div class="md:hidden bg-white shadow-sm px-4 py-3 flex items-center justify-between sticky top-0 z-50">
        <p class="text-sm font-bold text-gray-800">Panel RT {{ Auth::guard('rt')->user()->nomor_rt }}</p>
        <button onclick="toggleSidebar()" class="p-2 rounded-lg hover:bg-gray-100 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>

    {{-- Overlay mobile --}}
    <div id="sidebar-overlay" onclick="toggleSidebar()"
        class="hidden fixed inset-0 bg-black bg-opacity-30 z-30 md:hidden">
    </div>

    {{-- Wrapper --}}
    <div class="flex min-h-screen">

        {{-- Sidebar --}}
        <aside id="sidebar"
            class="fixed inset-y-0 left-0 z-40 w-64 bg-white shadow-md flex flex-col transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out">

            <div class="hidden md:block px-6 py-5 border-b flex-shrink-0">
                <h1 class="text-lg font-bold text-gray-800">Panel RT {{ Auth::guard('rt')->user()->nomor_rt }}</h1>
                <p class="text-xs text-gray-400 mt-0.5">RW {{ Auth::guard('rt')->user()->nomor_rw }} &bull; Desa Bengle</p>
            </div>

            <div class="md:hidden h-16 flex-shrink-0"></div>

            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <a href="{{ route('rt.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-2 rounded-lg {{ request()->routeIs('rt.dashboard') ? 'bg-orange-50 text-orange-700' : 'text-gray-600 hover:bg-gray-50' }} font-medium text-sm transition">
                    📋 Daftar Permohonan
                </a>
            </nav>

            <div class="px-4 py-4 border-t flex-shrink-0">
                <p class="text-xs text-gray-400 px-4 mb-2">{{ Auth::guard('rt')->user()->name }}</p>
                <form method="POST" action="{{ route('rt.logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 rounded-lg transition text-sm">
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        {{-- Konten Utama --}}
        <main class="flex-1 md:ml-64 p-4 md:p-8">
            @yield('content')
        </main>

    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const isOpen = !sidebar.classList.contains('-translate-x-full');
            if (isOpen) {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            } else {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            }
        }
    </script>

</body>
</html>