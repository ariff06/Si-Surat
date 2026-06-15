<aside id="sidebar"
    class="fixed inset-y-0 left-0 z-40 w-64 bg-white shadow-md flex flex-col transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out">

    <div class="hidden md:block px-6 py-5 border-b">
        <h1 class="text-lg font-bold text-gray-800">Layanan Surat Desa</h1>
        <p class="text-xs text-gray-400 mt-0.5">Desa Bengle, Kec. Majalaya</p>
    </div>

    <div class="md:hidden h-16"></div>

    <nav class="flex-1 px-4 py-6 space-y-2">
        <a id="btn-dashboard" href="{{ route('permohonan.dashboard') }}"
            class="w-full text-left flex items-center gap-3 px-4 py-2 rounded-lg {{ request()->routeIs('permohonan.dashboard') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-50' }} font-medium text-sm transition">
            🏠 Dashboard
        </a>
        <a id="btn-tidak_mampu" href="{{ route('surat.tidak-mampu') }}"
            class="w-full text-left flex items-center gap-3 px-4 py-2 rounded-lg {{ request()->routeIs('surat.tidak-mampu') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-50' }} font-medium text-sm transition">
            📄 Tidak Mampu
        </a>
        <a id="btn-kematian" href="{{ route('surat.kematian') }}"
            class="w-full text-left flex items-center gap-3 px-4 py-2 rounded-lg {{ request()->routeIs('surat.kematian') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-50' }} font-medium text-sm transition">
            📋 Kematian
        </a>

        <div class="border-t border-gray-100 pt-4 mt-2">
            <a href="{{ route('surat.cek-status') }}"
                class="w-full text-left flex items-center gap-3 px-4 py-2 rounded-lg {{ request()->routeIs('surat.cek-status') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-50' }} font-medium text-sm transition">
                🔍 Cek Status Surat
            </a>
        </div>
    </nav>

    <div class="px-6 py-4 border-t">
        <p class="text-xs text-gray-400">Jln. Aswan Krajan I</p>
        <p class="text-xs text-gray-400">Tlp. (0267) &bull; Kode Pos 41355</p>
        <a href="{{ route('portal') }}" class="text-xs text-gray-200 hover:text-gray-400 transition mt-2 block">
            v1.0
        </a>
    </div>
</aside>