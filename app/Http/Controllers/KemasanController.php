<?php

namespace App\Http\Controllers;

use App\Models\Kemasan;
use Illuminate\Http\Request;

class KemasanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kemasans = Kemasan::all();

        return view('kemasans.index', compact('kemasans'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama_kemasan' => 'required|string|max:255',
        ]);
    
        $kemasan = new Kemasan();
        $kemasan->nama_kemasan = $request->nama_kemasan;
        $kemasan->save();
    
        return redirect()->route('data-kemasan.index')->with('success', 'Data Kemasan berhasil disimpan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $kemasan = Kemasan::findOrFail($id);
        $kemasan->nama_kemasan = $request->nama_kemasan;
        $kemasan->save();

        return redirect()->back()->with('success', 'Data kemasan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Kemasan::find($id)->delete();

        return redirect()->route('data-kemasan.index')
            ->with('success', 'Data Kemasan Berhasil dihapus');
    }
}
