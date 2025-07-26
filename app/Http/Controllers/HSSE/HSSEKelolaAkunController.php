<?php

namespace App\Http\Controllers\HSSE;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\LaporanPerjalanan;
use Illuminate\Http\RedirectResponse;

class HSSEKelolaAkunController extends Controller
{
    /**
     * Tampilkan daftar akun.
     */
    public function index()
    {
        // Mengambil hanya user dengan status 'aktif' dan bukan root
        $users = User::where('status', 'aktif')->where('is_root', false)->get();
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:6000',
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
            : 'assets/img/default-user.jpg'; // Path gambar default

        // Simpan data akun
        User::create([
            'nama' => $request->input('nama'),
            'no_telepon' => $request->input('no_telepon'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => $request->input('role'),
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
    public function update(Request $request, User $user): RedirectResponse
    {
        if ($user->is_root) {
            return redirect()->route('hsse.kelolaakun')->with('error', 'Akun root tidak dapat diubah.');
        }
        // Pastikan hanya user aktif yang bisa diupdate datanya dari halaman ini
        if ($user->status !== 'aktif') {
            return redirect()->route('hsse.kelolaakun')->with('error', 'Akun ini sudah nonaktif.');
        }

        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:15',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'role' => 'required|in:ManagerArea,HSSE,Driver',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:6000',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'no_telepon.required' => 'Nomor telepon wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.min' => 'Password harus memiliki minimal 8 karakter.',
            'role.required' => 'Role wajib dipilih.',
            'image.image' => 'File harus berupa gambar.',
        ]);

        $data = $request->only('nama', 'no_telepon', 'email', 'role');

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->input('password'));
        }

        // Proses gambar baru jika ada
        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($user->image && $user->image !== 'assets/img/default-user.jpg') {
                Storage::disk('public')->delete($user->image);
            }
            $imagePath = $request->file('image')->store('images', 'public');
            $data['image'] = $imagePath;
        } else {
            $data['image'] = $user->image ?: 'assets/img/default-user.jpg';
        }

        // Update data pengguna
        $user->update($data);

        return redirect()->route('hsse.kelolaakun')->with('success', 'Data akun berhasil diperbarui!');
    }

    /**
     * Nonaktifkan akun.
     */
    public function destroy(User $user)
    {
        if ($user->is_root) {
            return redirect()->route('hsse.kelolaakun')->with('error', 'Akun root tidak dapat dinonaktifkan.');
        }
        // Cek jika akun sudah nonaktif
        if ($user->status === 'nonaktif') {
            return redirect()->route('hsse.kelolaakun')->with('error', 'Akun ini sudah dinonaktifkan sebelumnya.');
        }

        // Ubah status pengguna menjadi nonaktif
        try {
            $user->update(['status' => 'nonaktif']);
            return redirect()->route('hsse.kelolaakun')->with('success', 'Akun berhasil dinonaktifkan!');
        } catch (\Exception $e) {
            // Tangani jika ada error saat update
            return redirect()->route('hsse.kelolaakun')->with('error', 'Gagal menonaktifkan akun. Silakan coba lagi.');
        }
    }

    /**
     * Tampilkan daftar akun yang nonaktif.
     */
    public function showNonaktif()
    {
        $users = User::where('status', 'nonaktif')->get();
        // Kita akan membuat view baru bernama 'kelolaakun_nonaktif'
        return view('hsse.kelolaakun_nonaktif', compact('users'));
    }

    /**
     * Aktifkan kembali akun pengguna.
     */
    public function activate(User $user): RedirectResponse
    {
        // Cek jika akun sudah aktif
        if ($user->status === 'aktif') {
            // Sebaiknya arahkan ke halaman nonaktif karena proses ini dimulai dari sana
            return redirect()->route('hsse.kelolaakun.nonaktif')->with('error', 'Akun ini sudah aktif.');
        }

        try {
            $user->update(['status' => 'aktif']);
            // Kembali ke halaman daftar nonaktif dengan pesan sukses
            return redirect()->route('hsse.kelolaakun.nonaktif')->with('success', 'Akun ' . $user->nama . ' berhasil diaktifkan kembali!');
        } catch (\Exception $e) {
            // Kembali ke halaman daftar nonaktif dengan pesan error
            return redirect()->route('hsse.kelolaakun.nonaktif')->with('error', 'Gagal mengaktifkan akun. Silakan coba lagi.');
        }
    }
}
