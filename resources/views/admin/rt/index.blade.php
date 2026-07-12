@extends('layouts.admin')

@section('content')

    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-semibold text-gray-700">Management RT</h2>
            <p class="text-xs text-gray-400 mt-0.5">Kelola akun dan monitoring aktivitas RT</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 p-4 rounded-lg mb-6 text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Search --}}
    <form method="GET" action="{{ route('admin.rt.management.index') }}" class="mb-5">
        <div class="flex gap-3">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Cari nama, nomor RT, atau nomor RW..."
                class="flex-1 bg-white border border-gray-200 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition">
                Cari
            </button>
            @if(request('search'))
                <a href="{{ route('admin.rt.management.index') }}"
                    class="bg-gray-100 text-gray-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-200 transition">
                    Reset
                </a>
            @endif
        </div>
    </form>

    {{-- Tabel RT --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
        {{-- Desktop: tabel --}}
        <table class="hidden md:table w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="text-left px-5 py-3 text-xs text-gray-500 font-semibold uppercase tracking-wide">RT / RW</th>
                    <th class="text-left px-5 py-3 text-xs text-gray-500 font-semibold uppercase tracking-wide">Nama</th>
                    <th class="text-left px-5 py-3 text-xs text-gray-500 font-semibold uppercase tracking-wide">Email</th>
                    <th class="text-left px-5 py-3 text-xs text-gray-500 font-semibold uppercase tracking-wide">Permohonan</th>
                    <th class="text-left px-5 py-3 text-xs text-gray-500 font-semibold uppercase tracking-wide">Status</th>
                    <th class="text-left px-5 py-3 text-xs text-gray-500 font-semibold uppercase tracking-wide">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($rtUsers as $rt)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-5 py-3">
                        <span class="font-semibold text-gray-700">RT {{ $rt->nomor_rt }}</span>
                        <span class="text-gray-400 text-xs"> / RW {{ $rt->nomor_rw }}</span>
                    </td>
                    <td class="px-5 py-3 text-gray-600">{{ $rt->name }}</td>
                    <td class="px-5 py-3 text-gray-400 text-xs">{{ $rt->email }}</td>
                    <td class="px-5 py-3">
                        <span class="text-gray-700 font-medium">{{ $rt->total_permohonan }}</span>
                        @if($rt->total_pending > 0)
                            <span class="ml-1 bg-yellow-50 text-yellow-700 border border-yellow-200 text-xs px-1.5 py-0.5 rounded-full">
                                {{ $rt->total_pending }} pending
                            </span>
                        @endif
                    </td>
                    <td class="px-5 py-3">
                        @if($rt->is_active)
                            <span class="bg-green-50 text-green-700 border border-green-200 text-xs font-medium px-2 py-1 rounded-full">Aktif</span>
                        @else
                            <span class="bg-red-50 text-red-700 border border-red-200 text-xs font-medium px-2 py-1 rounded-full">Nonaktif</span>
                        @endif
                    </td>
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-3">
                            <a href="{{ route('admin.rt.management.show', $rt->id) }}"
                                class="text-blue-600 hover:underline text-xs font-medium">Detail</a>
                            <form method="POST" action="{{ route('admin.rt.management.reset-password', $rt->id) }}">
                                @csrf
                                <button type="submit" onclick="return confirm('Reset password RT {{ $rt->nomor_rt }} ke default?')"
                                    class="text-orange-600 hover:underline text-xs font-medium">Reset Password</button>
                            </form>
                            <form method="POST" action="{{ route('admin.rt.management.toggle-active', $rt->id) }}">
                                @csrf
                                <button type="submit"
                                    onclick="return confirm('{{ $rt->is_active ? 'Nonaktifkan' : 'Aktifkan' }} akun RT {{ $rt->nomor_rt }}?')"
                                    class="{{ $rt->is_active ? 'text-red-600' : 'text-green-600' }} hover:underline text-xs font-medium">
                                    {{ $rt->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Mobile: card --}}
        <div class="md:hidden divide-y divide-gray-100">
            @foreach($rtUsers as $rt)
            <div class="p-4">
                <div class="flex items-start justify-between mb-2">
                    <div>
                        <p class="text-sm font-semibold text-gray-700">RT {{ $rt->nomor_rt }} / RW {{ $rt->nomor_rw }}</p>
                        <p class="text-xs text-gray-500">{{ $rt->name }}</p>
                        <p class="text-xs text-gray-400">{{ $rt->email }}</p>
                    </div>
                    @if($rt->is_active)
                        <span class="bg-green-50 text-green-700 border border-green-200 text-xs font-medium px-2 py-0.5 rounded-full">Aktif</span>
                    @else
                        <span class="bg-red-50 text-red-700 border border-red-200 text-xs font-medium px-2 py-0.5 rounded-full">Nonaktif</span>
                    @endif
                </div>

                <div class="flex items-center gap-2 mb-3">
                    <span class="text-xs text-gray-500">Permohonan: <span class="font-medium text-gray-700">{{ $rt->total_permohonan }}</span></span>
                    @if($rt->total_pending > 0)
                        <span class="bg-yellow-50 text-yellow-700 border border-yellow-200 text-xs px-1.5 py-0.5 rounded-full">{{ $rt->total_pending }} pending</span>
                    @endif
                </div>

                <div class="grid grid-cols-3 gap-2">
                    <a href="{{ route('admin.rt.management.show', $rt->id) }}"
                        class="block text-center bg-blue-50 text-blue-600 border border-blue-200 text-xs font-medium py-2 rounded-lg hover:bg-blue-100 transition">
                        Detail
                    </a>
                    <form method="POST" action="{{ route('admin.rt.management.reset-password', $rt->id) }}">
                        @csrf
                        <button type="submit" onclick="return confirm('Reset password RT {{ $rt->nomor_rt }}?')"
                            class="w-full bg-orange-50 text-orange-600 border border-orange-200 text-xs font-medium py-2 rounded-lg hover:bg-orange-100 transition">
                            Reset PW
                        </button>
                    </form>
                    <form method="POST" action="{{ route('admin.rt.management.toggle-active', $rt->id) }}">
                        @csrf
                        <button type="submit"
                            onclick="return confirm('{{ $rt->is_active ? 'Nonaktifkan' : 'Aktifkan' }} RT {{ $rt->nomor_rt }}?')"
                            class="w-full {{ $rt->is_active ? 'bg-red-50 text-red-600 border border-red-200' : 'bg-green-50 text-green-600 border border-green-200' }} text-xs font-medium py-2 rounded-lg transition">
                            {{ $rt->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>

@endsection