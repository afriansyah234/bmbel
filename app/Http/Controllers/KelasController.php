<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $kelass = kelas::paginate(5);
        return view('kelas.index', compact('kelass'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kelas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validasi = $request->validate([
            'nama_kelas' => 'required',
            'kapasitas' => 'required'
        ]);

        kelas::create($validasi);

        return redirect()->route('kelas.index');
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
        $kelas = kelas::findOrFail($id);
        return view('kelas.edit', compact('kelas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validasi = $request->validate([
            'nama_kelas' => 'required',
            'kapasitas' => 'required'
        ]);

        $kelas = kelas::findOrFail($id);

        $kelas->update($validasi);

        return redirect()->route('kelas.index', compact('kelas'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $kelas = kelas::findOrFail($id);
            $kelas->delete();
            return redirect()->route('kelas.index');
        } catch (\Throwable $th) {
            return redirect()->back();
        }
    }
}
