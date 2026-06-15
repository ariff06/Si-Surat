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

        $tidakMampu = PermohonanTidakMampu::where('rt_status', 'approved')
            ->when($search, function ($query) use ($search) {
                $query->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('anak_nama_lengkap', 'like', "%{$search}%");
            })
            ->when($nomorRt, function ($query) use ($nomorRt) {
                $query->where('nomor_rt', $nomorRt);
            })
            ->latest()->get();

        $kematian = PermohonanKematian::where('rt_status', 'approved')
            ->when($search, function ($query) use ($search) {
                $query->where('nama_jenazah', 'like', "%{$search}%")
                    ->orWhere('nama_pelapor', 'like', "%{$search}%");
            })
            ->when($nomorRt, function ($query) use ($nomorRt) {
                $query->where('nomor_rt', $nomorRt);
            })
            ->latest()->get();

        return view('admin.permohonan.index', compact('tidakMampu', 'kematian', 'search', 'nomorRt'));
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
        } else {
            $permohonan = PermohonanKematian::findOrFail($id);
        }

        $permohonan->update([
            'status'        => 'approved',
            'catatan_admin' => $request->catatan_admin,
        ]);

        return back()->with('success', 'Permohonan berhasil disetujui.');
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