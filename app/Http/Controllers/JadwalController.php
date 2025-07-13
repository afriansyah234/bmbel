<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\jadwal_bimbel;
use App\Models\pengajar;
use App\Models\mapel;
use App\Models\kelas;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jadwals = jadwal_bimbel::with('pendaftar')->get();

        return view('jadwal_bimbel.index', compact('jadwals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kelas = kelas::all();
        $mapel = mapel::all();
        $pengajar = pengajar::all();
        return view('jadwal_bimbel.create', compact('kelas', 'mapel', 'pengajar'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'mapel_id' => 'required|exists:mapels,id',
            'pengajar_id' => 'required|exists:pengajars,id',
            'kelas_id' => 'required|exists:kelas,id',
            'hari' => 'required|string',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i',
            'biaya' => 'required|integer|min:0',
        ]);

        // Cek jam selesai tidak boleh kurang atau sama dengan jam mulai
        if ($request->jam_selesai <= $request->jam_mulai) {
            return back()->with('error', 'Jam selesai tidak boleh kurang atau sama dengan jam mulai!')->withInput();
        }

        // Cek bentrok jadwal pengajar
        $cekBentrok = jadwal_bimbel::where('pengajar_id', $request->pengajar_id)
            ->where('hari', $request->hari)
            ->where('mapel_id', $request->mapel_id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                    ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                    ->orWhere(function ($q) use ($request) {
                        $q->where('jam_mulai', '<=', $request->jam_mulai)
                            ->where('jam_selesai', '>=', $request->jam_selesai);
                    });
            })
            ->first();

        if ($cekBentrok) {
            return back()->with('error', 'Pengajar sudah memiliki jadwal di jam tersebut!')->withInput();
        }

        jadwal_bimbel::create($validated);

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil ditambahkan.');
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
        $jadwals = jadwal_bimbel::findOrFail($id);
        $mapel = mapel::all();
        $kelas = kelas::all();
        $pengajar = pengajar::all();
        return view('jadwal_bimbel.edit', compact('jadwals', 'mapel', 'kelas', 'pengajar'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validasi = $request->validate([
            'mapel_id' => 'required|exists:mapels,id',
            'pengajar_id' => 'required|exists:pengajars,id',
            'kelas_id' => 'required|exists:kelas,id',
            'hari' => 'required|in:senin,selasa,rabu,kamis,jumat,sabtu',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i'
        ]);

        $cekBentrok = jadwal_bimbel::where('pengajar_id', $request->pengajar_id)
            ->where('hari', $request->hari)
            ->where('mapel_id', $request->mapel_id)
            ->where('id', '!=', $id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                    ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                    ->orWhere(function ($q) use ($request) {
                        $q->where('jam_mulai', '<=', $request->jam_mulai)
                            ->where('jam_selesai', '>=', $request->jam_selesai);
                    });
            })
            ->first();

        if ($cekBentrok) {
            return back()->with('error', 'Pengajar sudah memiliki jadwal di jam tersebut!')->withInput();
        }

        $jadwal = jadwal_bimbel::findOrFail($id);
        $jadwal->update($validasi);
        return redirect()->route('jadwal.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $jadwal = jadwal_bimbel::findOrFail($id);
            $jadwal->delete();
            return redirect()->route('jadwal.index');
        } catch (\Throwable $th) {
            return redirect()->back();
        }
    }
}
