<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('Profile.edit');
    }

    public function update(Request $request)
    {
        // Ambil user yang sedang login atau user yang ingin diperbarui
        $user = Auth::user(); // atau User::find($id); jika berdasarkan ID
    
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
    
        // Update field biasa
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'];
    
        // Jika password diisi, hash dan simpan
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }
    
        // Jika ada upload foto
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }
    
            $photo = $request->file('photo');
            $path = $photo->store('photos', 'public'); // simpan di storage/app/public/photos
            $user->photo = $path;
        }
    
        $user->save();
    
        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }
}