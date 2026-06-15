@extends('layouts.guest')

@section('slot')

<div class="mb-6">
    <h2 class="text-xl font-semibold text-gray-700">Status Permohonan</h2>
    <p class="text-xs text-gray-400 mt-0.5">Cek status permohonan surat keterangan Anda</p>
</div>

{{-- Status card --}}
<div class="bg-white rounded-lg shadow p-6 mb-4">

    {{-- Status badge --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
        <div>
            <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Jenis Surat</p>
            <p class="text-sm font-semibold text-gray-700">
                {{ $tipe === 'tidak_mampu' ? 'Surat Keterangan Tidak Mampu' : 'Surat Keterangan Kematian' }}
            </p>
        </div>
        @if($permohonan->rt_status === 'rejected')
            <span class="bg-red-50 text-red-700 border border-red-200 text-xs font-semibold px-3 py-1.5 rounded-full self-start">
                ❌ Ditolak RT
            </span>
        @elseif($permohonan->status === 'rejected')
            <span class="bg-red-50 text-red-700 border border-red-200 text-xs font-semibold px-3 py-1.5 rounded-full self-start">
                ❌ Ditolak Desa
            </span>
        @elseif($permohonan->status === 'approved')
            <span class="bg-green-50 text-green-700 border border-green-200 text-xs font-semibold px-3 py-1.5 rounded-full self-start">
                ✅ Disetujui
            </span>
        @elseif($permohonan->rt_status === 'approved')
            <span class="bg-blue-50 text-blue-700 border border-blue-200 text-xs font-semibold px-3 py-1.5 rounded-full self-start">
                ⏳ Menunggu Desa
            </span>
        @else
            <span class="bg-yellow-50 text-yellow-700 border border-yellow-200 text-xs font-semibold px-3 py-1.5 rounded-full self-start">
                ⏳ Menunggu RT
            </span>
        @endif
    </div>

    {{-- Kode referensi --}}
    <div class="bg-gray-50 rounded-lg p-4 mb-5">
        <p class="text-xs text-gray-400 mb-1">Kode Referensi</p>
        <p class="text-sm font-mono font-semibold text-gray-700 break-all">{{ $permohonan->token_download }}</p>
        <p class="text-xs text-gray-400 mt-2">Simpan kode ini untuk mengecek status permohonan Anda.</p>
    </div>

    {{-- Progress status --}}
    <div class="mb-5">
        <p class="text-xs text-gray-400 mb-3">Progres Permohonan</p>

        {{-- Mobile: vertikal --}}
        <div class="flex flex-col gap-2 sm:hidden">
            <div class="flex items-center gap-3">
                <div class="w-6 h-6 rounded-full bg-green-500 flex items-center justify-center text-white text-xs flex-shrink-0">✓</div>
                <p class="text-xs text-gray-600 font-medium">Permohonan Dikirim</p>
            </div>
            <div class="ml-3" style="width: 2px; height: 16px; background-color: {{ $permohonan->rt_status !== 'pending' ? '#86efac' : '#e5e7eb' }};"></div>

            <div class="flex items-center gap-3">
                <div class="w-6 h-6 rounded-full flex items-center justify-center text-xs flex-shrink-0"
                    style="background-color: {{ $permohonan->rt_status === 'approved' ? '#22c55e' : ($permohonan->rt_status === 'rejected' ? '#ef4444' : '#e5e7eb') }}; color: {{ $permohonan->rt_status !== 'pending' ? 'white' : '#9ca3af' }};">
                    {{ $permohonan->rt_status === 'approved' ? '✓' : ($permohonan->rt_status === 'rejected' ? '✗' : '2') }}
                </div>
                <p class="text-xs text-gray-600 font-medium">Verifikasi RT</p>
                @if($permohonan->rt_status === 'approved')
                    <span class="text-xs text-green-600">Disetujui</span>
                @elseif($permohonan->rt_status === 'rejected')
                    <span class="text-xs text-red-600">Ditolak</span>
                @else
                    <span class="text-xs text-yellow-600">Menunggu</span>
                @endif
            </div>
            <div class="ml-3" style="width: 2px; height: 16px; background-color: {{ $permohonan->status !== 'pending' ? '#86efac' : '#e5e7eb' }};"></div>

            <div class="flex items-center gap-3">
                <div class="w-6 h-6 rounded-full flex items-center justify-center text-xs flex-shrink-0"
                    style="background-color: {{ $permohonan->status === 'approved' ? '#22c55e' : ($permohonan->status === 'rejected' ? '#ef4444' : '#e5e7eb') }}; color: {{ $permohonan->status !== 'pending' ? 'white' : '#9ca3af' }};">
                    {{ $permohonan->status === 'approved' ? '✓' : ($permohonan->status === 'rejected' ? '✗' : '3') }}
                </div>
                <p class="text-xs text-gray-600 font-medium">Verifikasi Desa</p>
                @if($permohonan->status === 'approved')
                    <span class="text-xs text-green-600">Disetujui</span>
                @elseif($permohonan->status === 'rejected')
                    <span class="text-xs text-red-600">Ditolak</span>
                @else
                    <span class="text-xs text-yellow-600">Menunggu</span>
                @endif
            </div>
            <div class="ml-3" style="width: 2px; height: 16px; background-color: {{ $permohonan->status === 'approved' ? '#86efac' : '#e5e7eb' }};"></div>

            <div class="flex items-center gap-3">
                <div class="w-6 h-6 rounded-full flex items-center justify-center text-xs flex-shrink-0"
                    style="background-color: {{ $permohonan->status === 'approved' ? '#22c55e' : '#e5e7eb' }}; color: {{ $permohonan->status === 'approved' ? 'white' : '#9ca3af' }};">
                    {{ $permohonan->status === 'approved' ? '✓' : '4' }}
                </div>
                <p class="text-xs text-gray-600 font-medium">Selesai</p>
            </div>
        </div>

        {{-- Desktop: horizontal --}}
        <div class="hidden sm:flex items-center gap-2">
            <div class="flex flex-col items-center">
                <div class="w-7 h-7 rounded-full bg-green-500 flex items-center justify-center text-white text-xs">✓</div>
                <p class="text-xs text-gray-500 mt-1 text-center">Submit</p>
            </div>
            <div class="flex-1 h-0.5" style="background-color: {{ $permohonan->rt_status !== 'pending' ? '#86efac' : '#e5e7eb' }};"></div>
            <div class="flex flex-col items-center">
                <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs"
                    style="background-color: {{ $permohonan->rt_status === 'approved' ? '#22c55e' : ($permohonan->rt_status === 'rejected' ? '#ef4444' : '#e5e7eb') }}; color: {{ $permohonan->rt_status !== 'pending' ? 'white' : '#9ca3af' }};">
                    {{ $permohonan->rt_status === 'approved' ? '✓' : ($permohonan->rt_status === 'rejected' ? '✗' : '2') }}
                </div>
                <p class="text-xs text-gray-500 mt-1 text-center">Verifikasi RT</p>
            </div>
            <div class="flex-1 h-0.5" style="background-color: {{ $permohonan->status !== 'pending' ? '#86efac' : '#e5e7eb' }};"></div>
            <div class="flex flex-col items-center">
                <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs"
                    style="background-color: {{ $permohonan->status === 'approved' ? '#22c55e' : ($permohonan->status === 'rejected' ? '#ef4444' : '#e5e7eb') }}; color: {{ $permohonan->status !== 'pending' ? 'white' : '#9ca3af' }};">
                    {{ $permohonan->status === 'approved' ? '✓' : ($permohonan->status === 'rejected' ? '✗' : '3') }}
                </div>
                <p class="text-xs text-gray-500 mt-1 text-center">Verifikasi Desa</p>
            </div>
            <div class="flex-1 h-0.5" style="background-color: {{ $permohonan->status === 'approved' ? '#86efac' : '#e5e7eb' }};"></div>
            <div class="flex flex-col items-center">
                <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs"
                    style="background-color: {{ $permohonan->status === 'approved' ? '#22c55e' : '#e5e7eb' }}; color: {{ $permohonan->status === 'approved' ? 'white' : '#9ca3af' }};">
                    {{ $permohonan->status === 'approved' ? '✓' : '4' }}
                </div>
                <p class="text-xs text-gray-500 mt-1 text-center">Selesai</p>
            </div>
        </div>
    </div>

    {{-- Detail permohonan --}}
    <div class="space-y-3">
        <p class="text-xs text-gray-400 uppercase tracking-wide">Detail Permohonan</p>

        @if($tipe === 'tidak_mampu')
            <div class="grid grid-cols-2 gap-3 text-sm">
                <div>
                    <p class="text-gray-400 text-xs">Nama Pemohon</p>
                    <p class="text-gray-700 font-medium">{{ $permohonan->nama_lengkap }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-xs">Keperluan</p>
                    <p class="text-gray-700 font-medium">{{ $permohonan->keperluan }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-xs">Nama Anak</p>
                    <p class="text-gray-700 font-medium">{{ $permohonan->anak_nama_lengkap }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-xs">Tanggal Pengajuan</p>
                    <p class="text-gray-700 font-medium">{{ $permohonan->created_at->format('d M Y') }}</p>
                </div>
            </div>
        @else
            <div class="grid grid-cols-2 gap-3 text-sm">
                <div>
                    <p class="text-gray-400 text-xs">Nama Jenazah</p>
                    <p class="text-gray-700 font-medium">{{ $permohonan->nama_jenazah }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-xs">Tanggal Meninggal</p>
                    <p class="text-gray-700 font-medium">{{ \Carbon\Carbon::parse($permohonan->tanggal_meninggal)->format('d M Y') }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-xs">Nama Pelapor</p>
                    <p class="text-gray-700 font-medium">{{ $permohonan->nama_pelapor }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-xs">Tanggal Pengajuan</p>
                    <p class="text-gray-700 font-medium">{{ $permohonan->created_at->format('d M Y') }}</p>
                </div>
            </div>
        @endif
    </div>

    {{-- Catatan admin/RT --}}
    @if($permohonan->rt_catatan && $permohonan->rt_status === 'rejected')
        <div class="mt-5 bg-red-50 border border-red-100 rounded-lg p-4">
            <p class="text-xs text-red-600 font-semibold mb-1">Catatan dari RT</p>
            <p class="text-sm text-red-700">{{ $permohonan->rt_catatan }}</p>
        </div>
    @endif

    @if($permohonan->catatan_admin)
        <div class="mt-4 bg-blue-50 border border-blue-100 rounded-lg p-4">
            <p class="text-xs text-blue-600 font-semibold mb-1">Catatan dari Petugas Desa</p>
            <p class="text-sm text-blue-700">{{ $permohonan->catatan_admin }}</p>
        </div>
    @endif

    {{-- Tombol download --}}
    @if($permohonan->status === 'approved')
        <div class="mt-5">
            @if($permohonan->downloaded_at)
                <div class="w-full block text-center bg-gray-100 border border-gray-200 text-gray-400 py-3 rounded-xl font-semibold text-sm cursor-not-allowed">
                    ✓ Surat Sudah Didownload
                </div>
                <p class="text-xs text-gray-400 text-center mt-2">
                    Didownload pada {{ \Carbon\Carbon::parse($permohonan->downloaded_at)->format('d M Y, H:i') }} WIB.
                    Jika membutuhkan salinan, silakan hubungi kantor desa.
                </p>
            @else
                <a id="btn-download"
                    href="{{ route('surat.download', ['tipe' => $tipe, 'token' => $permohonan->token_download]) }}"
                    onclick="handleDownload(this)"
                    class="w-full block text-center text-white py-3 rounded-xl font-semibold text-sm transition-all duration-200 hover:opacity-90"
                    style="background: linear-gradient(135deg, #14532d, #16a34a);">
                    ⬇ Download Surat
                </a>

                <script>
                function handleDownload(el) {
                    setTimeout(function() {
                        el.outerHTML = '<div class="w-full block text-center bg-gray-100 border border-gray-200 text-gray-400 py-3 rounded-xl font-semibold text-sm cursor-not-allowed">✓ Surat Sudah Didownload</div>';
                    }, 1000);
                }
                </script>
            @endif
        </div>
    @endif

</div>

{{-- Cek status lain --}}
<div class="bg-white rounded-lg shadow p-5">
    <p class="text-sm font-medium text-gray-700 mb-3">Cek Status Permohonan Lain</p>
    <form method="GET" action="{{ route('surat.cek-status') }}">
        <div class="flex flex-col sm:flex-row gap-3">
            <input type="text" name="token" placeholder="Masukkan kode referensi"
                class="flex-1 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
            <select name="tipe" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                <option value="tidak_mampu">Tidak Mampu</option>
                <option value="kematian">Kematian</option>
            </select>
            <button type="submit"
                class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-700 transition">
                Cek
            </button>
        </div>
    </form>
</div>

@endsection