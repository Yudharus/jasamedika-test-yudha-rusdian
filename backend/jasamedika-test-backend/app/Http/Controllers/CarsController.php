<?php

namespace App\Http\Controllers;

use App\Helpers\Apiformatter;
use Illuminate\Http\Request;
use App\Models\Cars;
use Illuminate\Support\Facades\Validator;



class CarsController extends Controller
{
    //
    public function index() {
        $data = Cars::all();

        if($data){
            return ApiFormatter::createApi(200, 'Sukses mendapatkan data', $data);
        } else {
            return ApiFormatter::createApi(400, 'Gagal mendapatkan data', $data);
        }
    }

    public function store(Request $request) {
        // Validasi data yang diterima dari request
      $validator = Validator::make($request->all(), [
        'brand' => 'required|string|max:255',
        'model' => 'required|string|max:255',
        'plate_number' => 'required|string|max:10|unique:cars',
        'daily_rate' => 'required|numeric|min:0',
        'available' => 'required|string|max:255',
        'gas' => 'required|integer',
        'driving_type' => 'required|string|max:255',
        'capacity' => 'required|integer',
    ]);
     
    if ($validator->fails()) {
        return ApiFormatter::createApi(400, 'Validasi gagal', $validator->errors());
    }

    // Membuat data mobil baru
    $car = Cars::create([
        'brand' => $request->brand,
        'model' => $request->model,
        'plate_number' => $request->plate_number,
        'daily_rate' => $request->daily_rate,
        'available' => $request->available,
        'gas' => $request->gas, // Menggunakan nilai dari request yang benar
        'driving_type' => $request->driving_type,
        'capacity' => $request->capacity,
    ]);

    // Cek apakah data mobil berhasil dibuat
    if ($car) {
        return ApiFormatter::createApi(201, 'Sukses menambahkan mobil', $car);
    } else {
        return ApiFormatter::createApi(500, 'Gagal menambahkan mobil', null);
    }
    }

    public function show($id) {
        // Mencari data mobil berdasarkan ID
        $car = Cars::find($id);
    
        // Cek apakah data mobil ditemukan
        if ($car) {
            return ApiFormatter::createApi(200, 'Sukses mendapatkan data detail mobil', $car);
        } else {
            return ApiFormatter::createApi(404, 'Mobil tidak ditemukan', null);
        }
    }
}