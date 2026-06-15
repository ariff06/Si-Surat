<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Times New Roman', Times, serif; font-size: 12pt; color: #000; }
        .kop { display: flex; align-items: center; border-bottom: 3px solid #000; padding-bottom: 8px; margin-bottom: 16px; }
        .kop-text { text-align: center; flex: 1; }
        .kop-text h2 { font-size: 13pt; margin-bottom: 2px; }
        .kop-text h3 { font-size: 18pt; font-weight: bold; margin-bottom: 4px; }
        .kop-text p { font-size: 10pt; }
        .kop-info { margin-bottom: 16px; }
        .kop-info table td { font-size: 11pt; padding: 1px 0; }
        .kode { float: right; border: 1px solid #000; padding: 4px 8px; font-size: 10pt; }
        .judul { text-align: center; margin: 16px 0 4px; }
        .judul h2 { font-size: 14pt; font-weight: bold; text-decoration: underline; }
        .judul p { font-size: 11pt; }
        .isi { margin: 16px 0; line-height: 1.8; }
        .data-table { width: 100%; margin: 4px 0; }
        .data-table td { padding: 1px 0; vertical-align: top; }
        .data-table td:first-child { width: 180px; }
        .data-table td:nth-child(2) { width: 16px; }
        .ttd { margin-top: 32px; text-align: right; }
        .ttd p { margin-bottom: 4px; }
        .ttd .nama { font-weight: bold; text-decoration: underline; margin-top: 64px; display: block; }
        .clear { clear: both; }
    </style>
</head>
<body>

    {{-- KOP info kiri --}}
    <div class="kop-info">
        <div class="kode">Kode F.2.17</div>
        <table>
            <tr><td>Pemerintah Desa/Kelurahan</td><td>:</td><td>BENGLE</td></tr>
            <tr><td>Kecamatan</td><td>:</td><td>MAJALAYA</td></tr>
            <tr><td>Kabupaten/Kota</td><td>:</td><td>KARAWANG</td></tr>
        </table>
        <div class="clear"></div>
    </div>

    {{-- Judul --}}
    <div class="judul">
        <h2>SURAT KETERANGAN KEMATIAN</h2>
        <p>Nomor : {{ $permohonan->nomor_surat }}</p>
    </div>

    {{-- Isi --}}
    <div class="isi">
        <p>Yang bertanda tangan dibawah ini, menerangkan bahwa ;</p>
        <br>

        <table class="data-table">
            <tr><td>NIK</td><td>:</td><td>{{ $permohonan->nik_jenazah }}</td></tr>
            <tr><td>Nama Lengkap Jenazah</td><td>:</td><td>{{ strtoupper($permohonan->nama_jenazah) }}</td></tr>
            <tr><td>Jenis Kelamin</td><td>:</td><td>{{ strtoupper($permohonan->jenis_kelamin_jenazah) }}</td></tr>
            <tr><td>Agama</td><td>:</td><td>{{ strtoupper($permohonan->agama_jenazah) }}</td></tr>
            <tr><td>Umur</td><td>:</td><td>{{ $permohonan->umur_jenazah }} TAHUN</td></tr>
            <tr><td>Pekerjaan</td><td>:</td><td>{{ strtoupper($permohonan->pekerjaan_jenazah) }}</td></tr>
            <tr>
                <td>Alamat</td><td>:</td>
                <td>
                    {{ strtoupper($permohonan->alamat_jenazah) }}<br>
                    Desa &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: BENGLE<br>
                    Kecamatan : MAJALAYA
                </td>
            </tr>
        </table>

        <br>
        <p>Telah Meninggal Dunia Pada &nbsp;:</p>
        <br>

        <table class="data-table">
            <tr><td>Hari</td><td>:</td><td>{{ strtoupper($permohonan->hari_meninggal) }}</td></tr>
            <tr><td>Tanggal</td><td>:</td><td>{{ strtoupper(\Carbon\Carbon::parse($permohonan->tanggal_meninggal)->locale('id')->isoFormat('D MMMM Y')) }}</td></tr>
            <tr><td>Pukul</td><td>:</td><td>{{ $permohonan->pukul_meninggal }} WIB</td></tr>
            <tr><td>Penyebab Kematian</td><td>:</td><td>{{ strtoupper($permohonan->penyebab_kematian) }}</td></tr>
        </table>

        <br>
        <p>Surat Keterangan ini dibuat berdasarkan keterangan Pelapor :</p>
        <br>
        <p>PELAPOR</p>
        <br>

        <table class="data-table">
            <tr><td>NIK</td><td>:</td><td>{{ $permohonan->nik_pelapor }}</td></tr>
            <tr><td>Nama Lengkap</td><td>:</td><td>{{ strtoupper($permohonan->nama_pelapor) }}</td></tr>
            <tr><td>Agama</td><td>:</td><td>{{ strtoupper($permohonan->agama_pelapor) }}</td></tr>
            <tr><td>Pekerjaan</td><td>:</td><td>{{ strtoupper($permohonan->pekerjaan_pelapor) }}</td></tr>
            <tr>
                <td>Alamat</td><td>:</td>
                <td>
                    {{ strtoupper($permohonan->alamat_pelapor) }}<br>
                    Desa &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: BENGLE<br>
                    Kecamatan : MAJALAYA
                </td>
            </tr>
        </table>

        <br>
        <p>Hubungan pelapor dengan yang telah Meninggal Dunia : {{ strtoupper($permohonan->hubungan_pelapor) }}</p>
    </div>

    {{-- TTD --}}
    <div class="ttd">
        <p>Karawang, {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y') }}</p>
        <p>KEPALA DESA BENGLE</p>
        <span class="nama">LIA AMALLIA, M.Pd</span>
    </div>

</body>
</html>