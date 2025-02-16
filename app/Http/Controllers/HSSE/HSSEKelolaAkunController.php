<?php

namespace App\Http\Controllers\HSSE;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\LaporanPerjalanan;

class HSSEKelolaAkunController extends Controller
{
    /**
     * Tampilkan daftar akun.
     */
    public function index()
    {
        $users = User::all();
        return view('hsse.kelolaakun', compact('users'));
    }

    /**
     * Simpan data akun baru.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:15',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:ManagerArea,HSSE,Driver',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'no_telepon.required' => 'Nomor telepon wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password harus memiliki minimal 8 karakter.',
            'role.required' => 'Role wajib dipilih.',
            'image.image' => 'File harus berupa gambar.',
        ]);

        // Proses unggah gambar atau gunakan gambar default
        $imagePath = $request->hasFile('image')
            ? $request->file('image')->store('images', 'public')
            : 'images/default-user.png'; // Path gambar default

        // Simpan data akun
        User::create([
            'nama' => $request->nama,
            'no_telepon' => $request->no_telepon,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'image' => $imagePath,
        ]);

        return redirect()->route('hsse.kelolaakun')->with('success', 'Akun berhasil ditambahkan!');
    }

    public function edit(User $user)
    {
        return view('hsse.kelolaakun', compact('user'));
    }

    /**
     * Update data akun.
     */
    public function update(Request $request, User $user)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:15',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'role' => 'required|in:ManagerArea,HSSE,Driver',
            'image' => 'nullable|image|max:2048',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'no_telepon.required' => 'Nomor telepon wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah digunakan.',
            'role.required' => 'Role wajib dipilih.',
            'image.image' => 'File harus berupa gambar.',
        ]);

        // Proses gambar baru jika ada
        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($user->image && $user->image !== 'images/default-user.png') {
                Storage::disk('public')->delete($user->image);
            }
            $imagePath = $request->file('image')->store('images', 'public');
        } else {
            $imagePath = $user->image ?: 'images/default-user.png';
        }

        // Update data pengguna
        $user->update([
            'nama' => $request->nama,
            'no_telepon' => $request->no_telepon,
            'email' => $request->email,
            'role' => $request->role,
            'image' => $imagePath,
        ]);

        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('hsse.kelolaakun')->with('success', 'Data akun berhasil diperbarui!');
    }

    /**
     * Hapus akun.
     */
    public function destroy(User $user)
{
    // Periksa apakah akun ini memiliki role selain 'Driver'
    if ($user->role === 'ManagerArea' || $user->role === 'HSSE') {
        return redirect()->route('hsse.kelolaakun')->with('error', 'Akun dengan role Manager Area dan HSSE tidak dapat dihapus!');
    }

    // Periksa apakah akun ini sudah terhubung dengan entitas lain (misalnya LaporanPerjalanan)
    $cekRelasi = LaporanPerjalanan::where('pengemudi_id', $user->id)->exists();
    
    if ($cekRelasi) {
        return redirect()->route('hsse.kelolaakun')->with('error', 'Tidak dapat menghapus akun, karena sudah terkait dengan data lain.');
    }

    // Hapus gambar jika ada dan bukan default
    if ($user->image && $user->image !== 'images/default-user.png') {
        Storage::disk('public')->delete($user->image);
    }

    // Hapus pengguna
    $user->delete();

    return redirect()->route('hsse.kelolaakun')->with('success', 'Akun berhasil dihapus!');
}

}

