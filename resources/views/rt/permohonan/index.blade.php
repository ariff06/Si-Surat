@extends('layouts.rt')

@section('content')

    <div class="mb-6">
        <h2 class="text-xl font-semibold text-gray-700">Daftar Permohonan</h2>
        <p class="text-xs text-gray-400 mt-0.5">Permohonan warga RT {{ Auth::guard('rt')->user()->nomor_rt }}</p>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 p-4 rounded-lg mb-6 text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Filter status --}}
    <form method="GET" action="{{ route('rt.dashboard') }}" class="mb-5">
        <div class="flex gap-3">
            <select name="status" class="bg-white border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
            </select>
            <button type="submit"
                class="bg-orange-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-orange-600 transition">
                Filter
            </button>
            @if(request('status'))
                <a href="{{ route('rt.dashboard') }}"
                    class="bg-gray-100 text-gray-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-200 transition">
                    Reset
                </a>
            @endif
        </div>
    </form>

    {{-- Tab filter --}}
    <div class="flex gap-2 mb-5">
        <button onclick="showTab('tidak_mampu')" id="tab-tidak_mampu"
            class="px-4 py-2 rounded-lg text-sm font-medium bg-orange-50 text-orange-700 transition">
            Tidak Mampu
            <span class="ml-1 bg-orange-100 text-orange-700 text-xs px-2 py-0.5 rounded-full">{{ $tidakMampu->count() }}</span>
        </button>
        <button onclick="showTab('kematian')" id="tab-kematian"
            class="px-4 py-2 rounded-lg text-sm font-medium text-gray-500 hover:bg-gray-50 transition">
            Kematian
            <span class="ml-1 bg-gray-100 text-gray-500 text-xs px-2 py-0.5 rounded-full">{{ $kematian->count() }}</span>
        </button>
    </div>

    {{-- Tabel Tidak Mampu --}}
    <div id="tabel-tidak_mampu">
        <div class="bg-white rounded-lg shadow overflow-hidden">
            @if($tidakMampu->isEmpty())
                <div class="p-8 text-center text-gray-400 text-sm">Belum ada permohonan dari RT {{ Auth::guard('rt')->user()->nomor_rt }}.</div>
            @else
                {{-- Desktop --}}
                <table class="hidden md:table w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="text-left px-5 py-3 text-xs text-gray-500 font-semibold uppercase tracking-wide">Nama Pemohon</th>
                            <th class="text-left px-5 py-3 text-xs text-gray-500 font-semibold uppercase tracking-wide">Keperluan</th>
                            <th class="text-left px-5 py-3 text-xs text-gray-500 font-semibold uppercase tracking-wide">Tanggal</th>
                            <th class="text-left px-5 py-3 text-xs text-gray-500 font-semibold uppercase tracking-wide">Status RT</th>
                            <th class="text-left px-5 py-3 text-xs text-gray-500 font-semibold uppercase tracking-wide">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($tidakMampu as $item)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-5 py-3 font-medium text-gray-700">{{ $item->nama_lengkap }}</td>
                            <td class="px-5 py-3 text-gray-500">{{ $item->keperluan }}</td>
                            <td class="px-5 py-3 text-gray-500">{{ $item->created_at->format('d M Y') }}</td>
                            <td class="px-5 py-3">
                                @if($item->rt_status === 'pending')
                                    <span class="bg-yellow-50 text-yellow-700 border border-yellow-200 text-xs font-medium px-2 py-1 rounded-full">Pending</span>
                                @elseif($item->rt_status === 'approved')
                                    <span class="bg-green-50 text-green-700 border border-green-200 text-xs font-medium px-2 py-1 rounded-full">Disetujui</span>
                                @else
                                    <span class="bg-red-50 text-red-700 border border-red-200 text-xs font-medium px-2 py-1 rounded-full">Ditolak</span>
                                @endif
                            </td>
                            <td class="px-5 py-3">
                                <a href="{{ route('rt.permohonan.show', ['tipe' => 'tidak_mampu', 'id' => $item->id]) }}"
                                    class="text-orange-600 hover:underline text-xs font-medium">Lihat Detail</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Mobile --}}
                <div class="md:hidden divide-y divide-gray-100">
                    @foreach($tidakMampu as $item)
                    <div class="p-4">
                        <div class="flex items-start justify-between mb-2">
                            <p class="text-sm font-semibold text-gray-700">{{ $item->nama_lengkap }}</p>
                            @if($item->rt_status === 'pending')
                                <span class="bg-yellow-50 text-yellow-700 border border-yellow-200 text-xs font-medium px-2 py-0.5 rounded-full">Pending</span>
                            @elseif($item->rt_status === 'approved')
                                <span class="bg-green-50 text-green-700 border border-green-200 text-xs font-medium px-2 py-0.5 rounded-full">Disetujui</span>
                            @else
                                <span class="bg-red-50 text-red-700 border border-red-200 text-xs font-medium px-2 py-0.5 rounded-full">Ditolak</span>
                            @endif
                        </div>
                        <p class="text-xs text-gray-400 mb-1">{{ $item->keperluan }}</p>
                        <p class="text-xs text-gray-400 mb-3">{{ $item->created_at->format('d M Y') }}</p>
                        <a href="{{ route('rt.permohonan.show', ['tipe' => 'tidak_mampu', 'id' => $item->id]) }}"
                            class="block text-center bg-orange-50 text-orange-600 border border-orange-200 text-xs font-medium py-2 rounded-lg hover:bg-orange-100 transition">
                            Lihat Detail →
                        </a>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- Tabel Kematian --}}
    <div id="tabel-kematian" class="hidden">
        <div class="bg-white rounded-lg shadow overflow-hidden">
            @if($kematian->isEmpty())
                <div class="p-8 text-center text-gray-400 text-sm">Belum ada permohonan dari RT {{ Auth::guard('rt')->user()->nomor_rt }}.</div>
            @else
                {{-- Desktop --}}
                <table class="hidden md:table w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="text-left px-5 py-3 text-xs text-gray-500 font-semibold uppercase tracking-wide">Nama Jenazah</th>
                            <th class="text-left px-5 py-3 text-xs text-gray-500 font-semibold uppercase tracking-wide">Pelapor</th>
                            <th class="text-left px-5 py-3 text-xs text-gray-500 font-semibold uppercase tracking-wide">Tanggal</th>
                            <th class="text-left px-5 py-3 text-xs text-gray-500 font-semibold uppercase tracking-wide">Status RT</th>
                            <th class="text-left px-5 py-3 text-xs text-gray-500 font-semibold uppercase tracking-wide">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($kematian as $item)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-5 py-3 font-medium text-gray-700">{{ $item->nama_jenazah }}</td>
                            <td class="px-5 py-3 text-gray-500">{{ $item->nama_pelapor }}</td>
                            <td class="px-5 py-3 text-gray-500">{{ $item->created_at->format('d M Y') }}</td>
                            <td class="px-5 py-3">
                                @if($item->rt_status === 'pending')
                                    <span class="bg-yellow-50 text-yellow-700 border border-yellow-200 text-xs font-medium px-2 py-1 rounded-full">Pending</span>
                                @elseif($item->rt_status === 'approved')
                                    <span class="bg-green-50 text-green-700 border border-green-200 text-xs font-medium px-2 py-1 rounded-full">Disetujui</span>
                                @else
                                    <span class="bg-red-50 text-red-700 border border-red-200 text-xs font-medium px-2 py-1 rounded-full">Ditolak</span>
                                @endif
                            </td>
                            <td class="px-5 py-3">
                                <a href="{{ route('rt.permohonan.show', ['tipe' => 'kematian', 'id' => $item->id]) }}"
                                    class="text-orange-600 hover:underline text-xs font-medium">Lihat Detail</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Mobile --}}
                <div class="md:hidden divide-y divide-gray-100">
                    @foreach($kematian as $item)
                    <div class="p-4">
                        <div class="flex items-start justify-between mb-2">
                            <p class="text-sm font-semibold text-gray-700">{{ $item->nama_jenazah }}</p>
                            @if($item->rt_status === 'pending')
                                <span class="bg-yellow-50 text-yellow-700 border border-yellow-200 text-xs font-medium px-2 py-0.5 rounded-full">Pending</span>
                            @elseif($item->rt_status === 'approved')
                                <span class="bg-green-50 text-green-700 border border-green-200 text-xs font-medium px-2 py-0.5 rounded-full">Disetujui</span>
                            @else
                                <span class="bg-red-50 text-red-700 border border-red-200 text-xs font-medium px-2 py-0.5 rounded-full">Ditolak</span>
                            @endif
                        </div>
                        <p class="text-xs text-gray-400 mb-1">Pelapor: {{ $item->nama_pelapor }}</p>
                        <p class="text-xs text-gray-400 mb-3">{{ $item->created_at->format('d M Y') }}</p>
                        <a href="{{ route('rt.permohonan.show', ['tipe' => 'kematian', 'id' => $item->id]) }}"
                            class="block text-center bg-orange-50 text-orange-600 border border-orange-200 text-xs font-medium py-2 rounded-lg hover:bg-orange-100 transition">
                            Lihat Detail →
                        </a>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <script>
        function showTab(tipe) {
            document.getElementById('tabel-tidak_mampu').classList.add('hidden');
            document.getElementById('tabel-kematian').classList.add('hidden');

            const activeTab = 'px-4 py-2 rounded-lg text-sm font-medium bg-orange-50 text-orange-700 transition';
            const inactiveTab = 'px-4 py-2 rounded-lg text-sm font-medium text-gray-500 hover:bg-gray-50 transition';

            document.getElementById('tab-tidak_mampu').className = inactiveTab;
            document.getElementById('tab-kematian').className = inactiveTab;

            document.getElementById('tabel-' + tipe).classList.remove('hidden');
            document.getElementById('tab-' + tipe).className = activeTab;
        }
    </script>

@endsection