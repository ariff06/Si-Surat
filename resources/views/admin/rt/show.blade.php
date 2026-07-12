@extends('layouts.admin')

@section('content')

    <a href="{{ route('admin.rt.management.index') }}"
        class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700 mb-6 transition">
        ← Kembali ke Management RT
    </a>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 p-4 rounded-lg mb-6 text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Info, Statistik, Aksi --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

        {{-- Info RT --}}
        <div class="bg-white rounded-lg shadow p-5">
            <p class="text-xs text-gray-400 uppercase tracking-wide mb-3">Informasi RT</p>
            <div class="space-y-2">
                <div><p class="text-xs text-gray-400">Nama</p><p class="text-sm font-semibold text-gray-700">{{ $rt->name }}</p></div>
                <div><p class="text-xs text-gray-400">RT / RW</p><p class="text-sm font-semibold text-gray-700">RT {{ $rt->nomor_rt }} / RW {{ $rt->nomor_rw }}</p></div>
                <div><p class="text-xs text-gray-400">Email</p><p class="text-sm text-gray-600 break-all">{{ $rt->email }}</p></div>
                <div>
                    <p class="text-xs text-gray-400">Status Akun</p>
                    @if($rt->is_active)
                        <span class="bg-green-50 text-green-700 border border-green-200 text-xs font-medium px-2 py-1 rounded-full">Aktif</span>
                    @else
                        <span class="bg-red-50 text-red-700 border border-red-200 text-xs font-medium px-2 py-1 rounded-full">Nonaktif</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Statistik --}}
        <div class="bg-white rounded-lg shadow p-5">
            <p class="text-xs text-gray-400 uppercase tracking-wide mb-3">Statistik Permohonan</p>
            <div class="space-y-3">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Total</span>
                    <span class="font-semibold text-gray-700">{{ $tidakMampu->count() + $kematian->count() }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Tidak Mampu</span>
                    <span class="font-semibold text-gray-700">{{ $tidakMampu->count() }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Kematian</span>
                    <span class="font-semibold text-gray-700">{{ $kematian->count() }}</span>
                </div>
                <div class="border-t border-gray-100 pt-3 space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Pending RT</span>
                        <span class="font-semibold text-yellow-600">{{ $tidakMampu->where('rt_status', 'pending')->count() + $kematian->where('rt_status', 'pending')->count() }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Disetujui RT</span>
                        <span class="font-semibold text-green-600">{{ $tidakMampu->where('rt_status', 'approved')->count() + $kematian->where('rt_status', 'approved')->count() }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Ditolak RT</span>
                        <span class="font-semibold text-red-500">{{ $tidakMampu->where('rt_status', 'rejected')->count() + $kematian->where('rt_status', 'rejected')->count() }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Aksi --}}
        <div class="bg-white rounded-lg shadow p-5">
            <p class="text-xs text-gray-400 uppercase tracking-wide mb-3">Tindakan</p>
            <div class="space-y-3">
                <form method="POST" action="{{ route('admin.rt.management.reset-password', $rt->id) }}">
                    @csrf
                    <button type="submit" onclick="return confirm('Reset password RT {{ $rt->nomor_rt }} ke default?')"
                        class="w-full bg-orange-50 hover:bg-orange-100 text-orange-600 border border-orange-200 py-2.5 rounded-lg text-sm font-semibold transition">
                        🔑 Reset Password ke Default
                    </button>
                </form>
                <form method="POST" action="{{ route('admin.rt.management.toggle-active', $rt->id) }}">
                    @csrf
                    <button type="submit"
                        onclick="return confirm('{{ $rt->is_active ? 'Nonaktifkan' : 'Aktifkan' }} akun RT {{ $rt->nomor_rt }}?')"
                        class="w-full {{ $rt->is_active ? 'bg-red-50 hover:bg-red-100 text-red-600 border border-red-200' : 'bg-green-50 hover:bg-green-100 text-green-600 border border-green-200' }} py-2.5 rounded-lg text-sm font-semibold transition">
                        {{ $rt->is_active ? '🔒 Nonaktifkan Akun' : '🔓 Aktifkan Akun' }}
                    </button>
                </form>
                <div class="bg-gray-50 rounded-lg p-3">
                    <p class="text-xs text-gray-400 mb-1">Password Default</p>
                    <p class="text-xs font-mono text-gray-600">rt{{ $rt->nomor_rt }}bengle</p>
                </div>
            </div>
        </div>

    </div>

    {{-- Riwayat permohonan --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100">
            <p class="text-sm font-semibold text-gray-700">Riwayat Permohonan RT {{ $rt->nomor_rt }}</p>
        </div>

        {{-- Tab --}}
        <div class="px-5 pt-4 flex gap-2">
            <button onclick="showTab('tidak_mampu')" id="tab-tidak_mampu"
                class="px-4 py-2 rounded-lg text-sm font-medium bg-blue-50 text-blue-700 transition">
                Tidak Mampu
                <span class="ml-1 bg-blue-100 text-blue-700 text-xs px-2 py-0.5 rounded-full">{{ $tidakMampu->count() }}</span>
            </button>
            <button onclick="showTab('kematian')" id="tab-kematian"
                class="px-4 py-2 rounded-lg text-sm font-medium text-gray-500 hover:bg-gray-50 transition">
                Kematian
                <span class="ml-1 bg-gray-100 text-gray-500 text-xs px-2 py-0.5 rounded-full">{{ $kematian->count() }}</span>
            </button>
        </div>

        {{-- Tabel Tidak Mampu --}}
        <div id="tabel-tidak_mampu" class="p-5">
            @if($tidakMampu->isEmpty())
                <p class="text-center text-gray-400 text-sm py-4">Belum ada permohonan.</p>
            @else
                {{-- Desktop --}}
                <table class="hidden md:table w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="text-left px-4 py-3 text-xs text-gray-500 font-semibold uppercase tracking-wide">Nama Pemohon</th>
                            <th class="text-left px-4 py-3 text-xs text-gray-500 font-semibold uppercase tracking-wide">Keperluan</th>
                            <th class="text-left px-4 py-3 text-xs text-gray-500 font-semibold uppercase tracking-wide">Tanggal</th>
                            <th class="text-left px-4 py-3 text-xs text-gray-500 font-semibold uppercase tracking-wide">Status RT</th>
                            <th class="text-left px-4 py-3 text-xs text-gray-500 font-semibold uppercase tracking-wide">Status Desa</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($tidakMampu as $item)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 font-medium text-gray-700">{{ $item->nama_lengkap }}</td>
                            <td class="px-4 py-3 text-gray-500">{{ $item->keperluan }}</td>
                            <td class="px-4 py-3 text-gray-500">{{ $item->created_at->format('d M Y') }}</td>
                            <td class="px-4 py-3">
                                @if($item->rt_status === 'pending')
                                    <span class="bg-yellow-50 text-yellow-700 border border-yellow-200 text-xs px-2 py-1 rounded-full">Pending</span>
                                @elseif($item->rt_status === 'approved')
                                    <span class="bg-green-50 text-green-700 border border-green-200 text-xs px-2 py-1 rounded-full">Disetujui</span>
                                @else
                                    <span class="bg-red-50 text-red-700 border border-red-200 text-xs px-2 py-1 rounded-full">Ditolak</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if($item->status === 'pending')
                                    <span class="bg-yellow-50 text-yellow-700 border border-yellow-200 text-xs px-2 py-1 rounded-full">Pending</span>
                                @elseif($item->status === 'approved')
                                    <span class="bg-green-50 text-green-700 border border-green-200 text-xs px-2 py-1 rounded-full">Disetujui</span>
                                @else
                                    <span class="bg-red-50 text-red-700 border border-red-200 text-xs px-2 py-1 rounded-full">Ditolak</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Mobile --}}
                <div class="md:hidden divide-y divide-gray-100">
                    @foreach($tidakMampu as $item)
                    <div class="py-3">
                        <div class="flex items-start justify-between mb-1">
                            <p class="text-sm font-semibold text-gray-700">{{ $item->nama_lengkap }}</p>
                            @if($item->rt_status === 'pending')
                                <span class="bg-yellow-50 text-yellow-700 border border-yellow-200 text-xs px-2 py-0.5 rounded-full">Pending RT</span>
                            @elseif($item->rt_status === 'approved')
                                <span class="bg-green-50 text-green-700 border border-green-200 text-xs px-2 py-0.5 rounded-full">Disetujui RT</span>
                            @else
                                <span class="bg-red-50 text-red-700 border border-red-200 text-xs px-2 py-0.5 rounded-full">Ditolak RT</span>
                            @endif
                        </div>
                        <p class="text-xs text-gray-400 mb-1">{{ $item->keperluan }} &bull; {{ $item->created_at->format('d M Y') }}</p>
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-gray-400">Status Desa:</span>
                            @if($item->status === 'pending')
                                <span class="bg-yellow-50 text-yellow-700 border border-yellow-200 text-xs px-2 py-0.5 rounded-full">Pending</span>
                            @elseif($item->status === 'approved')
                                <span class="bg-green-50 text-green-700 border border-green-200 text-xs px-2 py-0.5 rounded-full">Disetujui</span>
                            @else
                                <span class="bg-red-50 text-red-700 border border-red-200 text-xs px-2 py-0.5 rounded-full">Ditolak</span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Tabel Kematian --}}
        <div id="tabel-kematian" class="p-5 hidden">
            @if($kematian->isEmpty())
                <p class="text-center text-gray-400 text-sm py-4">Belum ada permohonan.</p>
            @else
                {{-- Desktop --}}
                <table class="hidden md:table w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="text-left px-4 py-3 text-xs text-gray-500 font-semibold uppercase tracking-wide">Nama Jenazah</th>
                            <th class="text-left px-4 py-3 text-xs text-gray-500 font-semibold uppercase tracking-wide">Pelapor</th>
                            <th class="text-left px-4 py-3 text-xs text-gray-500 font-semibold uppercase tracking-wide">Tanggal</th>
                            <th class="text-left px-4 py-3 text-xs text-gray-500 font-semibold uppercase tracking-wide">Status RT</th>
                            <th class="text-left px-4 py-3 text-xs text-gray-500 font-semibold uppercase tracking-wide">Status Desa</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($kematian as $item)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 font-medium text-gray-700">{{ $item->nama_jenazah }}</td>
                            <td class="px-4 py-3 text-gray-500">{{ $item->nama_pelapor }}</td>
                            <td class="px-4 py-3 text-gray-500">{{ $item->created_at->format('d M Y') }}</td>
                            <td class="px-4 py-3">
                                @if($item->rt_status === 'pending')
                                    <span class="bg-yellow-50 text-yellow-700 border border-yellow-200 text-xs px-2 py-1 rounded-full">Pending</span>
                                @elseif($item->rt_status === 'approved')
                                    <span class="bg-green-50 text-green-700 border border-green-200 text-xs px-2 py-1 rounded-full">Disetujui</span>
                                @else
                                    <span class="bg-red-50 text-red-700 border border-red-200 text-xs px-2 py-1 rounded-full">Ditolak</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if($item->status === 'pending')
                                    <span class="bg-yellow-50 text-yellow-700 border border-yellow-200 text-xs px-2 py-1 rounded-full">Pending</span>
                                @elseif($item->status === 'approved')
                                    <span class="bg-green-50 text-green-700 border border-green-200 text-xs px-2 py-1 rounded-full">Disetujui</span>
                                @else
                                    <span class="bg-red-50 text-red-700 border border-red-200 text-xs px-2 py-1 rounded-full">Ditolak</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Mobile --}}
                <div class="md:hidden divide-y divide-gray-100">
                    @foreach($kematian as $item)
                    <div class="py-3">
                        <div class="flex items-start justify-between mb-1">
                            <p class="text-sm font-semibold text-gray-700">{{ $item->nama_jenazah }}</p>
                            @if($item->rt_status === 'pending')
                                <span class="bg-yellow-50 text-yellow-700 border border-yellow-200 text-xs px-2 py-0.5 rounded-full">Pending RT</span>
                            @elseif($item->rt_status === 'approved')
                                <span class="bg-green-50 text-green-700 border border-green-200 text-xs px-2 py-0.5 rounded-full">Disetujui RT</span>
                            @else
                                <span class="bg-red-50 text-red-700 border border-red-200 text-xs px-2 py-0.5 rounded-full">Ditolak RT</span>
                            @endif
                        </div>
                        <p class="text-xs text-gray-400 mb-1">Pelapor: {{ $item->nama_pelapor }} &bull; {{ $item->created_at->format('d M Y') }}</p>
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-gray-400">Status Desa:</span>
                            @if($item->status === 'pending')
                                <span class="bg-yellow-50 text-yellow-700 border border-yellow-200 text-xs px-2 py-0.5 rounded-full">Pending</span>
                            @elseif($item->status === 'approved')
                                <span class="bg-green-50 text-green-700 border border-green-200 text-xs px-2 py-0.5 rounded-full">Disetujui</span>
                            @else
                                <span class="bg-red-50 text-red-700 border border-red-200 text-xs px-2 py-0.5 rounded-full">Ditolak</span>
                            @endif
                        </div>
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

            const activeTab = 'px-4 py-2 rounded-lg text-sm font-medium bg-blue-50 text-blue-700 transition';
            const inactiveTab = 'px-4 py-2 rounded-lg text-sm font-medium text-gray-500 hover:bg-gray-50 transition';

            document.getElementById('tab-tidak_mampu').className = inactiveTab;
            document.getElementById('tab-kematian').className = inactiveTab;

            document.getElementById('tabel-' + tipe).classList.remove('hidden');
            document.getElementById('tab-' + tipe).className = activeTab;
        }
    </script>

@endsection