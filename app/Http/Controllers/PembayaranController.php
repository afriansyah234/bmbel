<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\pendaftar;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pembayarans = Pembayaran::with('pendaftar')->get();
        return view('pembayaran.index', compact('pembayarans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pendaftarans = pendaftar::all();
        $tanggal = now()->format('Y-m-d');
        return view('pembayaran.create', compact('pendaftarans', 'tanggal'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pendaftar_id' => 'required|exists:pendaftars,id',
            'tanggal_bayar' => 'required|date',
            'jumlah_bayar' => 'required|integer|min:0',
            'keterangan' => 'nullable|string|max:255',
        ]);

        Pembayaran::create([
            'pendaftar_id' => $validated['pendaftar_id'],
            'tanggal_bayar' => $validated['tanggal_bayar'],
            'jumlah_bayar' => $validated['jumlah_bayar'],
            'keterangan' => $validated['keterangan'],
            'status_pembayaran' => 'belum_lunas',
            'tanggal_pembayaran' => $validated['tanggal_bayar'],
        ]);

        // Cek total pembayaran
        $pendaftaran = pendaftar::with('jadwal')->find($validated['pendaftar_id']);
        $totalBayar = Pembayaran::where('pendaftar_id', $pendaftaran->id)->sum('jumlah_bayar');
        $totalBiaya = $pendaftaran->jadwal->biaya;

        if ($totalBayar >= $totalBiaya) {
            $pendaftaran->update(['status_pendaftaran' => 'terdaftar']);

            // Update semua pembayaran jadi lunas
            Pembayaran::where('pendaftar_id', $pendaftaran->id)->update(['status_pembayaran' => 'lunas']);
        }

        return redirect()->route('pembayaran.index')->with('success', 'Pembayaran berhasil ditambahkan.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $pembayaran = Pembayaran::findOrFail($id);

            // Cek status pembayaran
            if ($pembayaran->status_pembayaran !== 'lunas') {
                return redirect()->back()->with('error', 'Pembayaran hanya bisa dihapus jika status sudah lunas.');
            }

            $pembayaran->delete();
            return redirect()->route('pembayaran.index')->with('success', 'Pembayaran berhasil dihapus.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus pembayaran.');
        }
    }

    public function riwayat()
    {
        $pembayarans = Pembayaran::onlyTrashed()->paginate(10);
        return view('pembayaran.riwayat', compact('pembayarans'));
    }

}
