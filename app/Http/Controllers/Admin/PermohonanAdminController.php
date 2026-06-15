<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PermohonanTidakMampu;
use App\Models\PermohonanKematian;
use Barryvdh\DomPDF\Facade\Pdf;

class PermohonanAdminController extends Controller
{
    public function index(Request $request)
    {
        $search   = $request->input('search');
        $nomorRt  = $request->input('nomor_rt');
        $status   = $request->input('status');

        $tidakMampu = PermohonanTidakMampu::where('rt_status', 'approved')
            ->when($search, function ($query) use ($search) {
                $query->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('anak_nama_lengkap', 'like', "%{$search}%");
            })
            ->when($nomorRt, function ($query) use ($nomorRt) {
                $query->where('nomor_rt', $nomorRt);
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest()->paginate(10, ['*'], 'page_tm');

        $kematian = PermohonanKematian::where('rt_status', 'approved')
            ->when($search, function ($query) use ($search) {
                $query->where('nama_jenazah', 'like', "%{$search}%")
                    ->orWhere('nama_pelapor', 'like', "%{$search}%");
            })
            ->when($nomorRt, function ($query) use ($nomorRt) {
                $query->where('nomor_rt', $nomorRt);
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest()->paginate(10, ['*'], 'page_k');

        return view('admin.permohonan.index', compact('tidakMampu', 'kematian', 'search', 'nomorRt', 'status'));
    }

    public function show($tipe, $id)
    {
        if ($tipe === 'tidak_mampu') {
            $permohonan = PermohonanTidakMampu::with('dokumen')->findOrFail($id);
        } else {
            $permohonan = PermohonanKematian::with('dokumen')->findOrFail($id);
        }

        return view('admin.permohonan.show', compact('permohonan', 'tipe'));
    }

    public function approve(Request $request, $tipe, $id)
    {
        $request->validate([
            'catatan_admin' => 'nullable|string',
        ]);

        if ($tipe === 'tidak_mampu') {
            $permohonan = PermohonanTidakMampu::findOrFail($id);

            // Generate nomor surat otomatis
            $tahun = date('Y');
            $urutan = PermohonanTidakMampu::where('status', 'approved')
                ->whereYear('updated_at', $tahun)
                ->count() + 1;
            $nomorSurat = '141.4/' . str_pad($urutan, 3, '0', STR_PAD_LEFT) . '/DS/' . $tahun;

        } else {
            $permohonan = PermohonanKematian::findOrFail($id);

            // Generate nomor surat otomatis
            $tahun = date('Y');
            $urutan = PermohonanKematian::where('status', 'approved')
                ->whereYear('updated_at', $tahun)
                ->count() + 1;
            $nomorSurat = '474/' . str_pad($urutan, 3, '0', STR_PAD_LEFT) . '/PEM/' . $tahun;
        }

        $permohonan->update([
            'status'        => 'approved',
            'nomor_surat'   => $nomorSurat,
            'catatan_admin' => $request->catatan_admin,
        ]);

        return back()->with('success', 'Permohonan berhasil disetujui. Nomor surat: ' . $nomorSurat);
    }

    public function reject(Request $request, $tipe, $id)
    {
        $request->validate([
            'catatan_admin' => 'required|string',
        ]);

        if ($tipe === 'tidak_mampu') {
            $permohonan = PermohonanTidakMampu::findOrFail($id);
        } else {
            $permohonan = PermohonanKematian::findOrFail($id);
        }

        $permohonan->update([
            'status'        => 'rejected',
            'catatan_admin' => $request->catatan_admin,
        ]);

        return back()->with('success', 'Permohonan berhasil ditolak.');
    }

    public function download($tipe, $token)
    {
        if ($tipe === 'tidak_mampu') {
            $permohonan = \App\Models\PermohonanTidakMampu::where('token_download', $token)
                ->where('status', 'approved')
                ->firstOrFail();
            $pdf = Pdf::loadView('pdf.tidak-mampu', compact('permohonan'));
            $filename = 'SKTM-' . strtoupper(str_replace(' ', '-', $permohonan->nama_lengkap)) . '.pdf';
        } else {
            $permohonan = \App\Models\PermohonanKematian::where('token_download', $token)
                ->where('status', 'approved')
                ->firstOrFail();
            $pdf = Pdf::loadView('pdf.kematian', compact('permohonan'));
            $filename = 'SKK-' . strtoupper(str_replace(' ', '-', $permohonan->nama_jenazah)) . '.pdf';
        }

        // Download admin tidak mengubah downloaded_at
        return $pdf->setPaper('a4', 'portrait')->download($filename);
    }

}