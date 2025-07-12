<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\mapel;

class MapelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $mapels = Mapel::paginate(5);
        return view('mapel.index', compact('mapels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mapel.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validasi = $request->validate([
            'nama_mapel' => 'required',
        ]);

        mapel::create($validasi);

        return redirect()->route('mapel.index');
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
        $mapels = mapel::findOrFail($id);

        return view('mapel.edit', compact('mapels'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validasi = $request->validate([
            'nama_mapel' => 'required'
        ]);
        $mapel = mapel::findOrFail($id);
        $mapel->update($validasi);

        return redirect()->route('mapel.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $mapel = mapel::findOrFail($id);
            $mapel->delete();
            return redirect('mapel.index');
        } catch (\Throwable $th) {
            return redirect()->back();
        }
    }
}
