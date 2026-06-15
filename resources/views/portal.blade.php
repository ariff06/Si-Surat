<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal - Desa Bengle</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-md px-4">

        {{-- Header --}}
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-800">Desa Bengle</h1>
            <p class="text-sm text-gray-400 mt-1">Kecamatan Majalaya, Kabupaten Karawang</p>
        </div>

        {{-- Pilihan portal --}}
        <div class="space-y-3">

            <a href="{{ route('permohonan.dashboard') }}"
                class="flex items-center gap-4 bg-white rounded-xl shadow p-5 hover:shadow-md transition group">
                <div class="w-12 h-12 rounded-full bg-green-50 flex items-center justify-center flex-shrink-0 group-hover:bg-green-100 transition">
                    <span class="text-2xl">🏠</span>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-semibold text-gray-700">Portal Warga</p>
                    <p class="text-xs text-gray-400 mt-0.5">Ajukan permohonan surat keterangan</p>
                </div>
                <span class="text-gray-300 group-hover:text-gray-400 transition">→</span>
            </a>

            <a href="{{ route('rt.login') }}"
                class="flex items-center gap-4 bg-white rounded-xl shadow p-5 hover:shadow-md transition group">
                <div class="w-12 h-12 rounded-full bg-orange-50 flex items-center justify-center flex-shrink-0 group-hover:bg-orange-100 transition">
                    <span class="text-2xl">👥</span>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-semibold text-gray-700">Portal RT</p>
                    <p class="text-xs text-gray-400 mt-0.5">Verifikasi permohonan warga RT</p>
                </div>
                <span class="text-gray-300 group-hover:text-gray-400 transition">→</span>
            </a>

            <a href="{{ route('admin.login') }}"
                class="flex items-center gap-4 bg-white rounded-xl shadow p-5 hover:shadow-md transition group">
                <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center flex-shrink-0 group-hover:bg-blue-100 transition">
                    <span class="text-2xl">🏛️</span>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-semibold text-gray-700">Portal Admin Desa</p>
                    <p class="text-xs text-gray-400 mt-0.5">Panel administrasi desa</p>
                </div>
                <span class="text-gray-300 group-hover:text-gray-400 transition">→</span>
            </a>

        </div>

        <p class="text-center text-xs text-gray-400 mt-8">
            Jln. Aswan Krajan I &bull; Tlp. (0267) &bull; Kode Pos 41355
        </p>

    </div>

</body>
</html>