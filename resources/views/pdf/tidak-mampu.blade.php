<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            color: #000;
            padding: 0 40px;
        }
        .kop img {
            width: 100%;
        }
        .judul {
            text-align: center;
            margin: 10px 0 4px;
        }
        .judul h2 {
            font-size: 12pt;
            font-weight: bold;
            text-decoration: underline;
        }
        .judul p { font-size: 11pt; }
        .pembuka {
            margin: 10px 0 8px;
            text-align: justify;
            line-height: 1.6;
        }
        .data-table {
            width: 100%;
            margin: 4px 0 10px 20px;
        }
        .data-table td {
            padding: 1.5px 0;
            vertical-align: top;
            line-height: 1.5;
        }
        .data-table td:first-child { width: 150px; }
        .data-table td:nth-child(2) { width: 14px; }
        .penutup {
            text-align: justify;
            line-height: 1.6;
            margin-top: 6px;
        }
        .penutup p { margin-bottom: 4px; }
        .ttd {
            margin-top: 20px;
            text-align: right;
        }
        .ttd .nama {
            font-weight: bold;
            text-decoration: underline;
            margin-top: 60px;
            display: block;
        }
    </style>
</head>
<body>

    {{-- KOP sebagai gambar --}}
    <div class="kop">
        <img src="{{ public_path('img/kop-sktm.png') }}">
    </div>

    {{-- Judul --}}
    <div class="judul">
        <h2>SURAT KETERANGAN TIDAK MAMPU</h2>
        <p>Nomor : 141.4/{{ str_pad($permohonan->id, 3, '0', STR_PAD_LEFT) }}/DS/{{ date('Y') }}</p>
    </div>

    {{-- Pembuka --}}
    <div class="pembuka">
        <p>Yang bertanda tangan dibawah ini Kepala Desa Bengle Kecamatan Majalaya Kabupaten Karawang dengan ini menerangkan bahwa :</p>
    </div>

    {{-- Data pemohon --}}
    <table class="data-table">
        <tr><td>Nama</td><td>:</td><td>{{ strtoupper($permohonan->nama_lengkap) }}</td></tr>
        <tr><td>Jenis Kelamin</td><td>:</td><td>{{ $permohonan->jenis_kelamin }}</td></tr>
        <tr><td>Tempat Tgl Lahir</td><td>:</td><td>{{ $permohonan->tempat_lahir }}, {{ \Carbon\Carbon::parse($permohonan->tanggal_lahir)->format('d-m-Y') }}</td></tr>
        <tr><td>Agama</td><td>:</td><td>{{ $permohonan->agama }}</td></tr>
        <tr><td>Kewarganegaraan</td><td>:</td><td>{{ $permohonan->kewarganegaraan }}</td></tr>
        <tr><td>Status Perkawinan</td><td>:</td><td>{{ $permohonan->status_perkawinan }}</td></tr>
        <tr><td>Pekerjaan</td><td>:</td><td>{{ strtoupper($permohonan->pekerjaan) }}</td></tr>
        <tr><td>Alamat</td><td>:</td><td>{{ $permohonan->alamat }}</td></tr>
    </table>

    <p style="margin-bottom: 8px;">Adalah orang tua wali dari :</p>

    {{-- Data anak --}}
    <table class="data-table">
        <tr><td>Nama</td><td>:</td><td>{{ strtoupper($permohonan->anak_nama_lengkap) }}</td></tr>
        <tr><td>Jenis Kelamin</td><td>:</td><td>{{ $permohonan->anak_jenis_kelamin }}</td></tr>
        <tr><td>Tempat Tgl Lahir</td><td>:</td><td>{{ $permohonan->anak_tempat_lahir }}, {{ \Carbon\Carbon::parse($permohonan->anak_tanggal_lahir)->format('d-m-Y') }}</td></tr>
        <tr><td>Status Perkawinan</td><td>:</td><td>{{ $permohonan->anak_status_perkawinan }}</td></tr>
        <tr><td>Agama</td><td>:</td><td>{{ $permohonan->anak_agama }}</td></tr>
        <tr><td>Kewarganegaraan</td><td>:</td><td>{{ $permohonan->anak_kewarganegaraan }}</td></tr>
        <tr><td>Pekerjaan</td><td>:</td><td>{{ strtoupper($permohonan->anak_pekerjaan) }}</td></tr>
        <tr><td>Alamat</td><td>:</td><td>{{ $permohonan->anak_alamat }}</td></tr>
    </table>

    {{-- Penutup --}}
    <div class="penutup">
        <p>Berdasarkan keterangan RT dan RW setempat menerangkan bahwa orang tersebut diatas adalah benar warga Desa Bengle Kecamatan Majalaya Kabupaten Karawang yang kehidupan ekonominya tergolong tidak mampu.</p>
        <p>Surat Keterangan Tidak Mampu ini di gunakan untuk {{ $permohonan->keperluan }}.</p>
        <p>Demikian Surat Keterangan Tidak Mampu ini kami buat dengan sebenarnya dan agar dapat dipergunakan sebagaimana mestinya.</p>
    </div>

    {{-- TTD --}}
    <div class="ttd">
        <p>Bengle, {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y') }}</p>
        <p>A.n/KEPALA DESA BENGLE</p>
        <p>Sekdes</p>
        <span class="nama">ADI NUGRAHA, S.IP</span>
    </div>

</body>
</html>