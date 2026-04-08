<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfilAnggotaController extends Controller
{
    /**
     * Menampilkan desain profil pink kamu yang asli
     */
    public function show()
    {
        // Memastikan Laravel memanggil file anggota/profil.blade.php milikmu
        return view('anggota.profil', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * Update profil & foto secara fleksibel
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validasi agar field yang tidak dikirim (seperti saat update foto saja) tidak dianggap error
        $request->validate([
            'name'       => $request->has('name') ? 'required|string|max:255' : 'nullable',
            'email'      => $request->has('email') ? 'required|email|unique:users,email,' . $user->id : 'nullable',
            'no_telepon' => 'nullable|string|max:20',
            'username'   => $request->has('username') ? 'required|string|max:50|unique:users,username,' . $user->id : 'nullable',
            'foto'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 
        ]);

        // LOGIKA UPLOAD FOTO
        if ($request->hasFile('foto')) {
            // Hapus foto lama dari storage jika ada
            if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
            }

            // Simpan foto ke storage/app/public/foto-profil
            $path = $request->file('foto')->store('foto-profil', 'public');
            $user->foto = $path; 
        }

        // UPDATE DATA TEKS (Hanya update jika inputnya ada di form)
        if($request->has('name')) $user->name = $request->name;
        if($request->has('email')) $user->email = $request->email;
        if($request->has('no_telepon')) $user->no_telepon = $request->no_telepon;
        if($request->has('username')) $user->username = $request->username;
        
        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Ganti password aman
     */
    public function gantiPassword(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'password_lama' => 'required',
            'password'      => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->password_lama, $user->password)) {
            return back()->withErrors(['password_lama' => 'Password lama tidak sesuai!']);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->back()->with('success', 'Password berhasil diganti!');
    }
}