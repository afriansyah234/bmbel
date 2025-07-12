<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\jadwal_bimbel;
use App\Models\pendaftar;
use Illuminate\Http\Request;

class PendaftarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pendaftars = pendaftar::with(['jadwal'])->get();
        return view('pendaftar.index', compact('pendaftars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tanggal = now()->format('Y-m-d');
        $jadwals = jadwal_bimbel::with(['mapel', 'pengajar', 'kelas'])->get();
        return view('pendaftar.create', compact('jadwals', 'tanggal'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pendaftar' => 'required|string|max:255',
            'jadwal_bimbel_id' => 'required|exists:jadwal_bimbels,id',
            'tanggal_daftar' => 'required|date'
        ]);

        pendaftar::create([
            'nama_pendaftar' => $validated['nama_pendaftar'],
            'jadwal_bimbel_id' => $validated['jadwal_bimbel_id'],
            'tanggal_daftar' => $request->tanggal_daftar,
        ]);

        return redirect()->route('pendaftar.index')->with('success', 'Pendaftar berhasil ditambahkan.');
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
        $pendaftar = pendaftar::findOrFail($id);
        $jadwals = jadwal_bimbel::with(['mapel', 'pengajar', 'kelas'])->get();
        return view('pendaftar.edit', compact('pendaftar', 'jadwals'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'nama_pendaftar' => 'required|string|max:255',
            'jadwal_bimbel_id' => 'required|exists:jadwal_bimbels,id',
            'tanggal_daftar' => 'required|date'
        ]);

        $pendaftar = pendaftar::findOrFail($id);
        $pendaftar->update([
            'nama_pendaftar' => $validated['nama_pendaftar'],
            'jadwal_bimbel_id' => $validated['jadwal_bimbel_id'],
            'tanggal_daftar' => $validated['tanggal_daftar'],
        ]);

        return redirect()->route('pendaftar.index')->with('success', 'Pendaftar berhasil diupdate.');
    }

    public function destroy(string $id)
    {
        try {
            $pendaftar = pendaftar::findOrFail($id);
            $pendaftar->is_riwayat = 1;
            $pendaftar->save();

            return redirect()->route('pendaftar.index')->with('success', 'Pendaftar dipindahkan ke riwayat.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal memindahkan pendaftar ke riwayat.');
        }
    }
}
