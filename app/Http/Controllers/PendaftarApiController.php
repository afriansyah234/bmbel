<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\pendaftar;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PendaftarApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pendaftar = pendaftar::with(['jadwal', 'pembayaran']);

        if ($request->has('nama')) {
            $pendaftar->where('nama_pendaftar', 'like', "%$request->nama%");
        }

        if ($request->has('status')) {
            $pendaftar->where('status_pendaftaran', $request->status);
        }

        if ($request->has('tanggal')) {
            $pendaftar->whereDate('tanggal_daftar', $request->tanggal);
        }

        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $pendaftar->orderBy($sortBy, $sortOrder);


        $data = $pendaftar->paginate(5);

        return response()->json([
            'status' => 'success',
            'current_page' => $data->currentPage(),
            'total_pages' => $data->lastPage(),
            'total' => $data->total(),
            'data' => $data->items()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pendaftar' => 'required|string|max:255',
            'jadwal_bimbel_id' => 'required|exists:jadwal_bimbels,id',
            'tanggal_daftar' => 'required|date',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $path = null;

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('foto_pendaftar', 'public');
        }

        $pendaftar = pendaftar::create([
            'nama_pendaftar' => $validated['nama_pendaftar'],
            'jadwal_bimbel_id' => $validated['jadwal_bimbel_id'],
            'tanggal_daftar' => $validated['tanggal_daftar'],
            'foto' => $path
        ]);

        return response()->json([
            'status' => 'success',
            'data' => $pendaftar
        ], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pendaftar = pendaftar::with(['jadwal', 'pembayaran'])->find($id);

        if (!$pendaftar) {
            return response()->json([
                'message' => 'pendaftar tidak ditemukan'
            ]);
        }

        return response()->json([
            'message' => $pendaftar
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Log::info('mencari pendaftar');
        $pendaftar = pendaftar::with(['jadwal', 'pembayaran'])->find($id);
        Log::info('pendaftar ditemukan');

        if (!$pendaftar) {
            return response()->json([
                'message' => 'data pendaftar tidak ditemukan'
            ]);
        }
        Log::info('memasukkan request');
        Log::info(
            [
                $request->nama_pendaftar,
                $request->tanggal_daftar,
                $request->jadwal_bimbel_id,
                $request->foto
            ]
        );
        $validated = $request->validate([
            'nama_pendaftar' => 'required|string|max:255',
            'jadwal_bimbel_id' => 'required|exists:jadwal_bimbels,id',
            'tanggal_daftar' => 'required|date',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('foto')) {
            $fotolama = $pendaftar->foto;
            if ($fotolama) {
                Storage::delete($fotolama);
            }
            $validated['foto'] = $request->file('foto')->store('foto_pendaftar');
        }

        $pendaftar->update($validated);

        return response()->json([
            'message' => $pendaftar
        ]);


    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pendaftar = pendaftar::find($id);

        if (!$pendaftar) {
            return response()->json([
                'message' => 'pendaftar tidak ditemukan'
            ]);
        }

        if ($pendaftar->foto && Storage::disk('public')->exists($pendaftar->foto)) {
            Storage::disk('public')->delete($pendaftar->foto);
        }

        $pendaftar->delete();

        return response()->json([
            'message' => 'pendaftar berhasil dihapus',
        ]);
    }

    public function cetakPdf($id)
    {
        $pendaftar = pendaftar::with('jadwal')->find($id);

        if (!$pendaftar) {
            return response()->json(['message' => 'Pendaftar tidak ditemukan'], 404);
        }

        $pdf = Pdf::loadView('pdf.pendaftar', compact('pendaftar'));

        return $pdf->stream("pendaftar_{$pendaftar->id}.pdf");
    }

    public function downloadPdf($id)
    {
        $pendaftar = pendaftar::with('jadwal')->find($id);

        if (!$pendaftar) {
            return response()->json(['message' => 'Pendaftar tidak ditemukan'], 404);
        }

        $pdf = Pdf::loadView('pdf.pendaftar', compact('pendaftar'));

        return $pdf->download("pendaftar_{$pendaftar->id}.pdf");
    }
}
