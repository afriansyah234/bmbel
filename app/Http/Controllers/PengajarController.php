<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\kelas;
use App\Models\mapel;
use Illuminate\Http\Request;
use App\Models\pengajar;
use PhpParser\Node\Stmt\TryCatch;
use function Laravel\Prompts\search;

class PengajarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $pengajars = Pengajar::when($search, function ($query, $search) {
            return $query->where('nama', 'like', "%{$search}%")->orwhere('email', 'like', "%{$search}%")->orwhere('no_telp', 'like', "%{$search}%");
        })->paginate(5);
        return view('pengajar.index', compact('pengajars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pengajar.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validasi = $request->validate([
            'nama' => 'required',
            'email' => 'required|unique:pengajars,email',
            'no_telp' => 'required|unique:pengajars,no_telp'
        ]);

        pengajar::create($validasi);

        return redirect()->route('pengajar.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pengajar = Pengajar::with('mapel')->find($id);
        return view('pengajar.show', compact('pengajar'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pengajars = pengajar::findOrFail($id);

        return view('pengajar.edit', compact('pengajars'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, pengajar $pengajar)
    {
        $validasi = $request->validate([
            'nama' => 'required',
            'email' => 'required|unique:pengajars,email,' . $pengajar->id,
            'no_telp' => 'required|unique:pengajars,no_telp,' . $pengajar->id,
        ]);
        $pengajar->update($validasi);

        return redirect()->route('pengajar.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $pengajar = pengajar::findOrFail($id);
            $pengajar->delete();
            return redirect()->route('pengajar.index');
        } catch (\Throwable $th) {
            return redirect()->back();
        }
    }
}
