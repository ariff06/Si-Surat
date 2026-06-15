<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermohonanTidakMampu extends Model
{
    protected $table = 'permohonan_tidak_mampu';

    protected $fillable = [
        'nomor_surat',
        'nama_lengkap',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'kewarganegaraan',
        'status_perkawinan',
        'pekerjaan',
        'alamat',
        'anak_nama_lengkap',
        'anak_jenis_kelamin',
        'anak_tempat_lahir',
        'anak_tanggal_lahir',
        'anak_agama',
        'anak_kewarganegaraan',
        'anak_status_perkawinan',
        'anak_pekerjaan',
        'anak_alamat',
        'keperluan',
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
                    ->where('tipe_permohonan', 'tidak_mampu');
    }
}