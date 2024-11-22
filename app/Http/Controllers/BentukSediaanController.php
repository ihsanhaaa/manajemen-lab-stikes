<?php

namespace App\Http\Controllers;

use App\Models\BentukSediaan;
use Illuminate\Http\Request;

class BentukSediaanController extends Controller
{
    public function index()
    {
        $bentuk_sediaans = BentukSediaan::all();

        return view('bentuk-sediaans.index', compact('bentuk_sediaans'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama_bentuk_sediaan' => 'required|string|max:255',
        ]);
    
        $bentuk_sediaan = new BentukSediaan();
        $bentuk_sediaan->nama_bentuk_sediaan = $request->nama_bentuk_sediaan;
        $bentuk_sediaan->save();
    
        return redirect()->route('data-bentuk-sediaan.index')->with('success', 'Data Bentuk Sediaan berhasil disimpan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $bentuk_sediaan = BentukSediaan::findOrFail($id);
        $bentuk_sediaan->nama_bentuk_sediaan = $request->nama_bentuk_sediaan;
        $bentuk_sediaan->save();

        return redirect()->back()->with('success', 'Data Bentuk Sediaan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        BentukSediaan::find($id)->delete();

        return redirect()->route('data-bentuk-sediaan.index')
            ->with('success', 'Data Bentuk Sediaan Berhasil dihapus');
    }
}
