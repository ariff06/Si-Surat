<?php

namespace App\Http\Controllers\RT;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PermohonanTidakMampu;
use App\Models\PermohonanKematian;

class PermohonanRtController extends Controller
{
    public function index(Request $request)
    {
        $nomorRt = Auth::guard('rt')->user()->nomor_rt;
        $status  = $request->input('status');

        $tidakMampu = PermohonanTidakMampu::where('nomor_rt', $nomorRt)
            ->when($status, function ($query) use ($status) {
                $query->where('rt_status', $status);
            })
            ->latest()->get();

        $kematian = PermohonanKematian::where('nomor_rt', $nomorRt)
            ->when($status, function ($query) use ($status) {
                $query->where('rt_status', $status);
            })
            ->latest()->get();

        return view('rt.permohonan.index', compact('tidakMampu', 'kematian', 'status'));
    }

    public function show($tipe, $id)
    {
        $nomorRt = Auth::guard('rt')->user()->nomor_rt;

        if ($tipe === 'tidak_mampu') {
            $permohonan = PermohonanTidakMampu::where('id', $id)
                ->where('nomor_rt', $nomorRt)
                ->firstOrFail();
        } else {
            $permohonan = PermohonanKematian::where('id', $id)
                ->where('nomor_rt', $nomorRt)
                ->firstOrFail();
        }

        return view('rt.permohonan.show', compact('permohonan', 'tipe'));
    }

    public function approve(Request $request, $tipe, $id)
    {
        $nomorRt = Auth::guard('rt')->user()->nomor_rt;

        $request->validate([
            'rt_catatan' => 'nullable|string',
        ]);

        if ($tipe === 'tidak_mampu') {
            $permohonan = PermohonanTidakMampu::where('id', $id)
                ->where('nomor_rt', $nomorRt)
                ->firstOrFail();
        } else {
            $permohonan = PermohonanKematian::where('id', $id)
                ->where('nomor_rt', $nomorRt)
                ->firstOrFail();
        }

        $permohonan->update([
            'rt_status'  => 'approved',
            'rt_catatan' => $request->rt_catatan,
        ]);

        return back()->with('success', 'Permohonan berhasil disetujui. Permohonan akan diteruskan ke admin desa.');
    }

    public function reject(Request $request, $tipe, $id)
    {
        $nomorRt = Auth::guard('rt')->user()->nomor_rt;

        $request->validate([
            'rt_catatan' => 'required|string',
        ]);

        if ($tipe === 'tidak_mampu') {
            $permohonan = PermohonanTidakMampu::where('id', $id)
                ->where('nomor_rt', $nomorRt)
                ->firstOrFail();
        } else {
            $permohonan = PermohonanKematian::where('id', $id)
                ->where('nomor_rt', $nomorRt)
                ->firstOrFail();
        }

        $permohonan->update([
            'rt_status'  => 'rejected',
            'rt_catatan' => $request->rt_catatan,
        ]);

        return back()->with('success', 'Permohonan telah ditolak.');
    }
}