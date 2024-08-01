<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ApiFormatter;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function store(Request $request) {
   // Validasi data yang diterima dari request
   $validator = Validator::make($request->all(), [
    'name' => 'required|string|max:255',
    'address' => 'required|string|max:255',
    'phone' => 'required|string|max:50',
    'license_number' => 'required|string|max:50',
    'password' => 'required|string|max:255',
    ]);

    // Cek apakah validasi gagal
    if ($validator->fails()) {
        return ApiFormatter::createApi(400, 'Validasi gagal', $validator->errors());
    }

    // Membuat data pengguna baru
    $user = User::create([
        'name' => $request->name,
        'address' => $request->address,
        'phone' => $request->phone,
        'license_number' => $request->license_number,
        'password' => $request->password,
    ]);

    // Cek apakah data pengguna berhasil dibuat
    if ($user) {
        return ApiFormatter::createApi(201, 'Sukses menambahkan pengguna', $user);
        } else {
            return ApiFormatter::createApi(500, 'Gagal menambahkan pengguna', null);
        }
    }

    public function login(Request $request) {
        // Validasi data yang diterima dari request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'password' => 'required|string',
        ]);

        // Cek apakah validasi gagal
        if ($validator->fails()) {
            return ApiFormatter::createApi(400, 'Validasi gagal', $validator->errors());
        }

        // Mencari pengguna berdasarkan nama
        $user = User::where('name', $request->name)->first();

        // Cek apakah pengguna ditemukan dan password cocok
        if ($user && $user->password === $request->password) {
            // Mengembalikan data pengguna jika login berhasil
            return ApiFormatter::createApi(200, 'Login berhasil', [
                'user' => $user,
                // Di sini Anda bisa menambahkan token atau informasi tambahan jika perlu
            ]);
        } else {
            // Mengembalikan error jika login gagal
            return ApiFormatter::createApi(401, 'Login gagal: username atau password salah', null);
        }
    }
}
