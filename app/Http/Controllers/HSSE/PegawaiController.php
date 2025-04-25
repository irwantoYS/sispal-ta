<?php

namespace App\Http\Controllers\HSSE;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pegawaiList = Pegawai::orderBy('nama')->paginate(10); // Ambil data dengan pagination
        return view('hsse.pegawai.index', compact('pegawaiList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('hsse.pegawai.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:pegawai,nama',
        ]);

        Pegawai::create($request->only('nama'));

        return redirect()->route('hsse.pegawai.index')->with('success', 'Nama Pegawai berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     * (Tidak digunakan karena pakai resource kecuali show)
     */
    // public function show(Pegawai $pegawai)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pegawai $pegawai)
    {
        return view('hsse.pegawai.edit', compact('pegawai'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pegawai $pegawai)
    {
        $request->validate([
            'nama' => [
                'required',
                'string',
                'max:255',
                Rule::unique('pegawai', 'nama')->ignore($pegawai->id),
            ],
        ]);

        $pegawai->update($request->only('nama'));

        return redirect()->route('hsse.pegawai.index')->with('success', 'Nama Pegawai berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pegawai $pegawai)
    {
        try {
            $pegawai->delete();
            return redirect()->route('hsse.pegawai.index')->with('success', 'Nama Pegawai berhasil dihapus.');
        } catch (\Exception $e) {
            // Tangani jika ada error, misal karena foreign key constraint
            return redirect()->route('hsse.pegawai.index')->with('error', 'Gagal menghapus pegawai. Error: ' . $e->getMessage());
        }
    }
}
