@extends('layouts.rt')

@section('content')

    <a href="{{ route('rt.dashboard') }}"
        class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700 mb-6 transition">
        ← Kembali ke Daftar Permohonan
    </a>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 p-4 rounded-lg mb-6 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Kolom kiri - detail data --}}
        <div class="lg:col-span-2 space-y-5">

            <div class="bg-white rounded-lg shadow p-5 flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-400 mb-1">Jenis Surat</p>
                    <p class="text-sm font-semibold text-gray-700">
                        {{ $tipe === 'tidak_mampu' ? 'Surat Keterangan Tidak Mampu' : 'Surat Keterangan Kematian' }}
                    </p>
                    <p class="text-xs text-gray-400 mt-1">Diajukan {{ $permohonan->created_at->format('d M Y, H:i') }} WIB</p>
                </div>
                @if($permohonan->rt_status === 'pending')
                    <span class="bg-yellow-50 text-yellow-700 border border-yellow-200 text-xs font-semibold px-3 py-1.5 rounded-full">⏳ Pending</span>
                @elseif($permohonan->rt_status === 'approved')
                    <span class="bg-green-50 text-green-700 border border-green-200 text-xs font-semibold px-3 py-1.5 rounded-full">✅ Disetujui RT</span>
                @else
                    <span class="bg-red-50 text-red-700 border border-red-200 text-xs font-semibold px-3 py-1.5 rounded-full">❌ Ditolak RT</span>
                @endif
            </div>

            @if($tipe === 'tidak_mampu')
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="px-5 py-3 border-b border-gray-100 bg-gray-50">
                        <p class="text-xs font-semibold text-gray-600 uppercase tracking-wide">Data Pemohon</p>
                    </div>
                    <div class="p-5 grid grid-cols-2 gap-4 text-sm">
                        <div><p class="text-xs text-gray-400">Nama Lengkap</p><p class="text-gray-700 font-medium">{{ $permohonan->nama_lengkap }}</p></div>
                        <div><p class="text-xs text-gray-400">Jenis Kelamin</p><p class="text-gray-700 font-medium">{{ $permohonan->jenis_kelamin }}</p></div>
                        <div><p class="text-xs text-gray-400">Tempat, Tgl Lahir</p><p class="text-gray-700 font-medium">{{ $permohonan->tempat_lahir }}, {{ \Carbon\Carbon::parse($permohonan->tanggal_lahir)->format('d M Y') }}</p></div>
                        <div><p class="text-xs text-gray-400">Agama</p><p class="text-gray-700 font-medium">{{ $permohonan->agama }}</p></div>
                        <div><p class="text-xs text-gray-400">Status Perkawinan</p><p class="text-gray-700 font-medium">{{ $permohonan->status_perkawinan }}</p></div>
                        <div><p class="text-xs text-gray-400">Pekerjaan</p><p class="text-gray-700 font-medium">{{ $permohonan->pekerjaan }}</p></div>
                        <div class="col-span-2"><p class="text-xs text-gray-400">Alamat</p><p class="text-gray-700 font-medium">{{ $permohonan->alamat }}</p></div>
                        <div class="col-span-2"><p class="text-xs text-gray-400">Keperluan</p><p class="text-gray-700 font-medium">{{ $permohonan->keperluan }}</p></div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="px-5 py-3 border-b border-gray-100 bg-gray-50">
                        <p class="text-xs font-semibold text-gray-600 uppercase tracking-wide">Data Anak</p>
                    </div>
                    <div class="p-5 grid grid-cols-2 gap-4 text-sm">
                        <div><p class="text-xs text-gray-400">Nama Lengkap</p><p class="text-gray-700 font-medium">{{ $permohonan->anak_nama_lengkap }}</p></div>
                        <div><p class="text-xs text-gray-400">Jenis Kelamin</p><p class="text-gray-700 font-medium">{{ $permohonan->anak_jenis_kelamin }}</p></div>
                        <div><p class="text-xs text-gray-400">Tempat, Tgl Lahir</p><p class="text-gray-700 font-medium">{{ $permohonan->anak_tempat_lahir }}, {{ \Carbon\Carbon::parse($permohonan->anak_tanggal_lahir)->format('d M Y') }}</p></div>
                        <div><p class="text-xs text-gray-400">Agama</p><p class="text-gray-700 font-medium">{{ $permohonan->anak_agama }}</p></div>
                        <div><p class="text-xs text-gray-400">Status Perkawinan</p><p class="text-gray-700 font-medium">{{ $permohonan->anak_status_perkawinan }}</p></div>
                        <div><p class="text-xs text-gray-400">Pekerjaan</p><p class="text-gray-700 font-medium">{{ $permohonan->anak_pekerjaan }}</p></div>
                        <div class="col-span-2"><p class="text-xs text-gray-400">Alamat</p><p class="text-gray-700 font-medium">{{ $permohonan->anak_alamat }}</p></div>
                    </div>
                </div>

            @else
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="px-5 py-3 border-b border-gray-100 bg-gray-50">
                        <p class="text-xs font-semibold text-gray-600 uppercase tracking-wide">Data Jenazah</p>
                    </div>
                    <div class="p-5 grid grid-cols-2 gap-4 text-sm">
                        <div><p class="text-xs text-gray-400">NIK</p><p class="text-gray-700 font-medium">{{ $permohonan->nik_jenazah }}</p></div>
                        <div><p class="text-xs text-gray-400">Nama Lengkap</p><p class="text-gray-700 font-medium">{{ $permohonan->nama_jenazah }}</p></div>
                        <div><p class="text-xs text-gray-400">Jenis Kelamin</p><p class="text-gray-700 font-medium">{{ $permohonan->jenis_kelamin_jenazah }}</p></div>
                        <div><p class="text-xs text-gray-400">Agama</p><p class="text-gray-700 font-medium">{{ $permohonan->agama_jenazah }}</p></div>
                        <div><p class="text-xs text-gray-400">Umur</p><p class="text-gray-700 font-medium">{{ $permohonan->umur_jenazah }} Tahun</p></div>
                        <div><p class="text-xs text-gray-400">Pekerjaan</p><p class="text-gray-700 font-medium">{{ $permohonan->pekerjaan_jenazah }}</p></div>
                        <div class="col-span-2"><p class="text-xs text-gray-400">Alamat</p><p class="text-gray-700 font-medium">{{ $permohonan->alamat_jenazah }}</p></div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="px-5 py-3 border-b border-gray-100 bg-gray-50">
                        <p class="text-xs font-semibold text-gray-600 uppercase tracking-wide">Data Kematian</p>
                    </div>
                    <div class="p-5 grid grid-cols-2 gap-4 text-sm">
                        <div><p class="text-xs text-gray-400">Hari Meninggal</p><p class="text-gray-700 font-medium">{{ $permohonan->hari_meninggal }}</p></div>
                        <div><p class="text-xs text-gray-400">Tanggal Meninggal</p><p class="text-gray-700 font-medium">{{ \Carbon\Carbon::parse($permohonan->tanggal_meninggal)->format('d M Y') }}</p></div>
                        <div><p class="text-xs text-gray-400">Pukul</p><p class="text-gray-700 font-medium">{{ $permohonan->pukul_meninggal }} WIB</p></div>
                        <div><p class="text-xs text-gray-400">Penyebab</p><p class="text-gray-700 font-medium">{{ $permohonan->penyebab_kematian }}</p></div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="px-5 py-3 border-b border-gray-100 bg-gray-50">
                        <p class="text-xs font-semibold text-gray-600 uppercase tracking-wide">Data Pelapor</p>
                    </div>
                    <div class="p-5 grid grid-cols-2 gap-4 text-sm">
                        <div><p class="text-xs text-gray-400">NIK</p><p class="text-gray-700 font-medium">{{ $permohonan->nik_pelapor }}</p></div>
                        <div><p class="text-xs text-gray-400">Nama Lengkap</p><p class="text-gray-700 font-medium">{{ $permohonan->nama_pelapor }}</p></div>
                        <div><p class="text-xs text-gray-400">Agama</p><p class="text-gray-700 font-medium">{{ $permohonan->agama_pelapor }}</p></div>
                        <div><p class="text-xs text-gray-400">Pekerjaan</p><p class="text-gray-700 font-medium">{{ $permohonan->pekerjaan_pelapor }}</p></div>
                        <div class="col-span-2"><p class="text-xs text-gray-400">Alamat</p><p class="text-gray-700 font-medium">{{ $permohonan->alamat_pelapor }}</p></div>
                        <div class="col-span-2"><p class="text-xs text-gray-400">Hubungan dengan Jenazah</p><p class="text-gray-700 font-medium">{{ $permohonan->hubungan_pelapor }}</p></div>
                    </div>
                </div>
            @endif

            {{-- Dokumen upload --}}
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-5 py-3 border-b border-gray-100 bg-gray-50">
                    <p class="text-xs font-semibold text-gray-600 uppercase tracking-wide">Dokumen Upload</p>
                </div>
                <div class="p-5 grid grid-cols-2 gap-4">
                    @foreach($permohonan->dokumen as $dok)
                        <div>
                            <p class="text-xs text-gray-400 mb-2 uppercase">{{ $dok->jenis }}</p>
                            <img src="{{ asset('storage/' . $dok->path_file) }}"
                                class="w-full rounded-lg border border-gray-200 object-cover"
                                style="max-height: 200px;">
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

        {{-- Kolom kanan - aksi RT --}}
        <div class="space-y-5">

            @if($permohonan->rt_status === 'pending')
                <div class="bg-white rounded-lg shadow p-5">
                    <p class="text-sm font-semibold text-gray-700 mb-4">Tindakan RT</p>

                    <form method="POST" action="{{ route('rt.permohonan.approve', ['tipe' => $tipe, 'id' => $permohonan->id]) }}" class="mb-3">
                        @csrf
                        <div class="mb-3">
                            <label class="block text-xs text-gray-500 mb-1">Catatan (opsional)</label>
                            <textarea name="rt_catatan" rows="3"
                                placeholder="Tambahkan catatan..."
                                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400"></textarea>
                        </div>
                        <button type="submit"
                            class="w-full bg-orange-500 hover:bg-orange-600 text-white py-2.5 rounded-lg text-sm font-semibold transition">
                            ✅ Setujui & Teruskan ke Desa
                        </button>
                    </form>

                    <form method="POST" action="{{ route('rt.permohonan.reject', ['tipe' => $tipe, 'id' => $permohonan->id]) }}">
                        @csrf
                        <div class="mb-3">
                            <label class="block text-xs text-gray-500 mb-1">Alasan penolakan <span class="text-red-500">*</span></label>
                            <textarea name="rt_catatan" rows="3" required
                                placeholder="Tuliskan alasan penolakan..."
                                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-400"></textarea>
                        </div>
                        <button type="submit"
                            class="w-full bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 py-2.5 rounded-lg text-sm font-semibold transition">
                            ❌ Tolak Permohonan
                        </button>
                    </form>
                </div>

            @else
                <div class="bg-white rounded-lg shadow p-5">
                    <p class="text-sm font-semibold text-gray-700 mb-3">Status Tindakan RT</p>
                    @if($permohonan->rt_status === 'approved')
                        <div class="bg-green-50 border border-green-200 rounded-lg p-3 text-sm text-green-700">
                            Permohonan telah disetujui dan diteruskan ke admin desa.
                        </div>
                    @else
                        <div class="bg-red-50 border border-red-200 rounded-lg p-3 text-sm text-red-700">
                            Permohonan telah ditolak.
                        </div>
                    @endif
                    @if($permohonan->rt_catatan)
                        <div class="mt-3">
                            <p class="text-xs text-gray-400 mb-1">Catatan RT</p>
                            <p class="text-sm text-gray-600">{{ $permohonan->rt_catatan }}</p>
                        </div>
                    @endif
                </div>
            @endif

            {{-- Status admin desa --}}
            <div class="bg-white rounded-lg shadow p-5">
                <p class="text-xs text-gray-400 mb-2">Status Admin Desa</p>
                @if($permohonan->rt_status !== 'approved')
                    <p class="text-xs text-gray-400">Menunggu persetujuan RT terlebih dahulu.</p>
                @elseif($permohonan->status === 'pending')
                    <span class="bg-yellow-50 text-yellow-700 border border-yellow-200 text-xs font-medium px-2 py-1 rounded-full">Menunggu Admin Desa</span>
                @elseif($permohonan->status === 'approved')
                    <span class="bg-green-50 text-green-700 border border-green-200 text-xs font-medium px-2 py-1 rounded-full">Disetujui Admin Desa</span>
                @else
                    <span class="bg-red-50 text-red-700 border border-red-200 text-xs font-medium px-2 py-1 rounded-full">Ditolak Admin Desa</span>
                @endif
            </div>

            {{-- Kode referensi warga --}}
            <div class="bg-white rounded-lg shadow p-5">
                <p class="text-xs text-gray-400 uppercase tracking-wide mb-2">Kode Referensi Warga</p>
                <p class="text-xs font-mono text-gray-600 break-all mb-3">{{ $permohonan->token_download }}</p>
                <p class="text-xs text-gray-400">Berikan kode ini ke warga jika mereka belum menyimpannya, untuk mengecek status permohonan.</p>
            </div>

        </div>
    </div>

@endsection