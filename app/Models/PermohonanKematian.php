<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermohonanKematian extends Model
{
    protected $table = 'permohonan_kematian';

    protected $fillable = [
        'nomor_surat',
        'nik_jenazah',
        'nama_jenazah',
        'jenis_kelamin_jenazah',
        'agama_jenazah',
        'umur_jenazah',
        'pekerjaan_jenazah',
        'alamat_jenazah',
        'hari_meninggal',
        'tanggal_meninggal',
        'pukul_meninggal',
        'penyebab_kematian',
        'nik_pelapor',
        'nama_pelapor',
        'agama_pelapor',
        'pekerjaan_pelapor',
        'alamat_pelapor',
        'hubungan_pelapor',
        'status',
        'token_download',
        'catatan_admin',
        'downloaded_at',
        'nomor_rt',
        'rt_status',
        'rt_catatan',
    ];

    public function dokumen()
    {
        return $this->hasMany(DokumenUpload::class, 'permohonan_id')
                    ->where('tipe_permohonan', 'kematian');
    }
}