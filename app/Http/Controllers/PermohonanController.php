<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PermohonanTidakMampu;
use App\Models\PermohonanKematian;
use App\Models\DokumenUpload;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class PermohonanController extends Controller
{
    public function dashboard()
    {
        return view('permohonan.dashboard');
    }

    public function tidakMampu()
    {
        return view('permohonan.tidak-mampu');
    }

    public function kematian()
    {
        return view('permohonan.kematian');
    }

    public function storeTidakMampu(Request $request)
    {
        $request->validate([
    'nama_lengkap'           => 'required|string|max:255',
    'jenis_kelamin'          => 'required|in:Laki-laki,Perempuan',
    'tempat_lahir'           => 'required|string',
    'tanggal_lahir'          => 'required|date',
    'agama'                  => 'required|string',
    'kewarganegaraan'        => 'required|string',
    'status_perkawinan'      => 'required|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
    'pekerjaan'              => 'required|string',
    'alamat'                 => 'required|string',
    'anak_nama_lengkap'      => 'required|string',
    'anak_jenis_kelamin'     => 'required|in:Laki-laki,Perempuan',
    'anak_tempat_lahir'      => 'required|string',
    'anak_tanggal_lahir'     => 'required|date',
    'anak_agama'             => 'required|string',
    'anak_kewarganegaraan'   => 'required|string',
    'anak_status_perkawinan' => 'required|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
    'anak_pekerjaan'         => 'required|string',
    'anak_alamat'            => 'required|string',
    'keperluan'              => 'required|string',
    'ktp'                    => 'required|image|max:2048',
    'kk'                     => 'required|image|max:2048',
    'nomor_rt'               => 'required|string|max:10',
    
    ], [
    'nama_lengkap.required'           => 'Nama lengkap wajib diisi.',
    'jenis_kelamin.required'          => 'Jenis kelamin wajib dipilih.',
    'tempat_lahir.required'           => 'Tempat lahir wajib diisi.',
    'tanggal_lahir.required'          => 'Tanggal lahir wajib diisi.',
    'agama.required'                  => 'Agama wajib dipilih.',
    'kewarganegaraan.required'        => 'Kewarganegaraan wajib diisi.',
    'status_perkawinan.required'      => 'Status perkawinan wajib dipilih.',
    'pekerjaan.required'              => 'Pekerjaan wajib diisi.',
    'alamat.required'                 => 'Alamat wajib diisi.',
    'anak_nama_lengkap.required'      => 'Nama lengkap anak wajib diisi.',
    'anak_jenis_kelamin.required'     => 'Jenis kelamin anak wajib dipilih.',
    'anak_tempat_lahir.required'      => 'Tempat lahir anak wajib diisi.',
    'anak_tanggal_lahir.required'     => 'Tanggal lahir anak wajib diisi.',
    'anak_agama.required'             => 'Agama anak wajib dipilih.',
    'anak_kewarganegaraan.required'   => 'Kewarganegaraan anak wajib diisi.',
    'anak_status_perkawinan.required' => 'Status perkawinan anak wajib dipilih.',
    'anak_pekerjaan.required'         => 'Pekerjaan anak wajib diisi.',
    'anak_alamat.required'            => 'Alamat anak wajib diisi.',
    'keperluan.required'              => 'Keperluan surat wajib diisi.',
    'ktp.required'                    => 'Foto KTP wajib diupload.',
    'ktp.image'                       => 'File KTP harus berupa gambar.',
    'ktp.max'                         => 'Ukuran foto KTP maksimal 2MB.',
    'kk.required'                     => 'Foto KK wajib diupload.',
    'kk.image'                        => 'File KK harus berupa gambar.',
    'kk.max'                          => 'Ukuran foto KK maksimal 2MB.',
    ]);

        // Cek NIK yang sama dengan status pending atau approved
        $existing = PermohonanTidakMampu::where('nama_lengkap', $request->nama_lengkap)
            ->whereIn('rt_status', ['pending', 'approved'])
            ->first();

        if ($existing) {
            return back()->withErrors([
                'nama_lengkap' => 'Permohonan dengan nama ini sedang dalam proses atau sudah disetujui. Silakan cek status permohonan Anda dengan kode referensi yang sudah diterima.',
            ])->withInput();
        }

        $permohonan = PermohonanTidakMampu::create([
            'nama_lengkap'          => $request->nama_lengkap,
            'jenis_kelamin'         => $request->jenis_kelamin,
            'tempat_lahir'          => $request->tempat_lahir,
            'tanggal_lahir'         => $request->tanggal_lahir,
            'agama'                 => $request->agama,
            'kewarganegaraan'       => $request->kewarganegaraan,
            'status_perkawinan'     => $request->status_perkawinan,
            'pekerjaan'             => $request->pekerjaan,
            'alamat'                => $request->alamat,
            'anak_nama_lengkap'     => $request->anak_nama_lengkap,
            'anak_jenis_kelamin'    => $request->anak_jenis_kelamin,
            'anak_tempat_lahir'     => $request->anak_tempat_lahir,
            'anak_tanggal_lahir'    => $request->anak_tanggal_lahir,
            'anak_agama'            => $request->anak_agama,
            'anak_kewarganegaraan'  => $request->anak_kewarganegaraan,
            'anak_status_perkawinan'=> $request->anak_status_perkawinan,
            'anak_pekerjaan'        => $request->anak_pekerjaan,
            'anak_alamat'           => $request->anak_alamat,
            'keperluan'             => $request->keperluan,
            'nomor_rt'              => $request->nomor_rt,
            'token_download'        => Str::uuid(),
        ]);

        foreach (['ktp', 'kk'] as $jenis) {
            $path = $request->file($jenis)->store("dokumen/{$jenis}", 'public');
            DokumenUpload::create([
                'tipe_permohonan' => 'tidak_mampu',
                'permohonan_id'   => $permohonan->id,
                'jenis'           => $jenis,
                'path_file'       => $path,
            ]);
        }

        return redirect()->route('surat.status', [
            'tipe'  => 'tidak_mampu',
            'token' => $permohonan->token_download,
        ]);
    }

    public function storeKematian(Request $request)
    {
        $request->validate([
            'nik_jenazah'           => 'required|digits:16',
            'nama_jenazah'          => 'required|string',
            'jenis_kelamin_jenazah' => 'required|in:Laki-laki,Perempuan',
            'agama_jenazah'         => 'required|string',
            'umur_jenazah'          => 'required|integer',
            'pekerjaan_jenazah'     => 'required|string',
            'alamat_jenazah'        => 'required|string',
            'hari_meninggal'        => 'required|string',
            'tanggal_meninggal'     => 'required|date',
            'pukul_meninggal'       => 'required',
            'penyebab_kematian'     => 'required|string',
            'nik_pelapor'           => 'required|digits:16',
            'nama_pelapor'          => 'required|string',
            'agama_pelapor'         => 'required|string',
            'pekerjaan_pelapor'     => 'required|string',
            'alamat_pelapor'        => 'required|string',
            'hubungan_pelapor'      => 'required|string',
            'ktp'                   => 'required|image|max:2048',
            'kk'                    => 'required|image|max:2048',
            'nomor_rt'              => 'required|string|max:10',
        ]);

        // Cek NIK jenazah SEBELUM simpan
        $existing = PermohonanKematian::where('nik_jenazah', $request->nik_jenazah)
            ->whereIn('rt_status', ['pending', 'approved'])
            ->first();

        if ($existing) {
            return back()->withErrors([
                'nik_jenazah' => 'Permohonan dengan NIK jenazah ini sedang dalam proses. Silakan cek status dengan kode referensi yang sudah diterima.',
            ])->withInput();
        }

        $permohonan = PermohonanKematian::create([
            'nik_jenazah'           => $request->nik_jenazah,
            'nama_jenazah'          => $request->nama_jenazah,
            'jenis_kelamin_jenazah' => $request->jenis_kelamin_jenazah,
            'agama_jenazah'         => $request->agama_jenazah,
            'umur_jenazah'          => $request->umur_jenazah,
            'pekerjaan_jenazah'     => $request->pekerjaan_jenazah,
            'alamat_jenazah'        => $request->alamat_jenazah,
            'hari_meninggal'        => $request->hari_meninggal,
            'tanggal_meninggal'     => $request->tanggal_meninggal,
            'pukul_meninggal'       => $request->pukul_meninggal,
            'penyebab_kematian'     => $request->penyebab_kematian,
            'nik_pelapor'           => $request->nik_pelapor,
            'nama_pelapor'          => $request->nama_pelapor,
            'agama_pelapor'         => $request->agama_pelapor,
            'pekerjaan_pelapor'     => $request->pekerjaan_pelapor,
            'alamat_pelapor'        => $request->alamat_pelapor,
            'hubungan_pelapor'      => $request->hubungan_pelapor,
            'nomor_rt'              => $request->nomor_rt,
            'token_download'        => Str::uuid(),
        ]);

        foreach (['ktp', 'kk'] as $jenis) {
            $path = $request->file($jenis)->store("dokumen/{$jenis}", 'public');
            DokumenUpload::create([
                'tipe_permohonan' => 'kematian',
                'permohonan_id'   => $permohonan->id,
                'jenis'           => $jenis,
                'path_file'       => $path,
            ]);
        }

        return redirect()->route('surat.status', [
            'tipe'  => 'kematian',
            'token' => $permohonan->token_download,
        ]);
    }

    public function status($tipe, $token)
    {
        if ($tipe === 'tidak_mampu') {
            $permohonan = PermohonanTidakMampu::where('token_download', $token)->first();
        } else {
            $permohonan = PermohonanKematian::where('token_download', $token)->first();
        }

        if (!$permohonan) {
            return redirect()->route('surat.cek-status')->with('error',
                'Permohonan tidak ditemukan. Pastikan kode referensi dan jenis surat yang dipilih sudah benar.'
            );
        }

        return view('permohonan.status', compact('permohonan', 'tipe'));
    }


    public function cekStatus(Request $request)
    {
        if (!$request->has('token')) {
            return view('permohonan.cek-status');
        }

        $request->validate([
            'token' => 'required',
            'tipe'  => 'required|in:tidak_mampu,kematian',
        ]);

        return redirect()->route('surat.status', [
            'tipe'  => $request->tipe,
            'token' => $request->token,
        ]);
    }

    public function download($tipe, $token)
    {
        if ($tipe === 'tidak_mampu') {
            $permohonan = PermohonanTidakMampu::where('token_download', $token)
                ->where('status', 'approved')
                ->firstOrFail();
            $pdf = Pdf::loadView('pdf.tidak-mampu', compact('permohonan'));
            $filename = 'SKTM-' . strtoupper(str_replace(' ', '-', $permohonan->nama_lengkap)) . '.pdf';
        } else {
            $permohonan = PermohonanKematian::where('token_download', $token)
                ->where('status', 'approved')
                ->firstOrFail();
            $pdf = Pdf::loadView('pdf.kematian', compact('permohonan'));
            $filename = 'SKK-' . strtoupper(str_replace(' ', '-', $permohonan->nama_jenazah)) . '.pdf';
        }

        // Catat waktu download pertama kali
        if (!$permohonan->downloaded_at) {
            $permohonan->update(['downloaded_at' => now()]);
        }

        return $pdf->setPaper('a4', 'portrait')->download($filename);
    }
}