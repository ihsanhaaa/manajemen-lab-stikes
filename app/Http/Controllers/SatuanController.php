<?php

namespace App\Http\Controllers;

use App\Models\Satuan;
use Illuminate\Http\Request;

class SatuanController extends Controller
{
    public function index()
    {
        $satuans = Satuan::all();

        return view('satuans.index', compact('satuans'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama_satuan' => 'required|string|max:255',
        ]);
    
        $satuan = new Satuan();
        $satuan->nama_satuan = $request->nama_satuan;
        $satuan->save();
    
        return redirect()->route('data-satuan.index')->with('success', 'Data Satuan berhasil disimpan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $satuan = Satuan::findOrFail($id);
        $satuan->nama_satuan = $request->nama_satuan;
        $satuan->save();

        return redirect()->back()->with('success', 'Data Satuan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Satuan::find($id)->delete();

        return redirect()->route('data-satuan.index')
            ->with('success', 'Data Satuan Berhasil dihapus');
    }
}
