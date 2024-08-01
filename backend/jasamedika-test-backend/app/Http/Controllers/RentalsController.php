<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ApiFormatter;
use App\Models\Rentals;
use Illuminate\Support\Facades\Validator;
use App\Models\Cars;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class RentalsController extends Controller
{
    public function index() {
        $data = DB::table('rentals as a')
        ->join('users as u', 'u.id', '=', 'a.user_id')
        ->join('cars as c', 'c.id', '=', 'a.car_id')
        ->select('a.*', 'u.name', 'c.brand', 'c.model')
        ->where('a.is_return', '=', 'true') // Filter untuk rental yang belum dikembalikan
        ->get();

        if($data){
            return ApiFormatter::createApi(200, 'Sukses mendapatkan data', $data);
        } else {
            return ApiFormatter::createApi(400, 'Gagal mendapatkan data', $data);
        }
    }

    public function historyRent($id) {
        $data = DB::table('rentals as a')
        ->join('users as u', 'u.id', '=', 'a.user_id')
        ->join('cars as c', 'c.id', '=', 'a.car_id')
        ->select('a.*', 'u.name', 'c.brand', 'c.model')
        ->where('a.is_return', '=', 'true') // Filter untuk rental yang belum dikembalikan
        ->where('a.user_id', '=', $id) // Filter untuk rental yang belum dikembalikan
        ->get();

        if($data){
            return ApiFormatter::createApi(200, 'Sukses mendapatkan data history rent', $data);
        } else {
            return ApiFormatter::createApi(400, 'Gagal mendapatkan data history rent', $data);
        }
    }

    public function onGoingRent($id) {
        $data = DB::table('rentals as a')
        ->join('users as u', 'u.id', '=', 'a.user_id')
        ->join('cars as c', 'c.id', '=', 'a.car_id')
        ->select('a.*', 'u.name', 'c.brand', 'c.model')
        ->where('a.is_return', '=', 'false') // Filter untuk rental yang belum dikembalikan
        ->where('a.user_id', '=', $id) // Filter untuk rental yang belum dikembalikan
        ->get();

        if($data){
            return ApiFormatter::createApi(200, 'Sukses mendapatkan on going history rent', $data);
        } else {
            return ApiFormatter::createApi(400, 'Gagal mendapatkan data on going rent', $data);
        }
    }


    public function store(Request $request) {
        // Validasi data yang diterima dari request
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'total_amount' => 'required|numeric|min:0',


        ]);

        // Cek apakah validasi gagal
        if ($validator->fails()) {
            return ApiFormatter::createApi(400, 'Validasi gagal', $validator->errors());
        }

        // Cek ketersediaan mobil
        $car = Cars::find($request->car_id);
        if (!$car || !$car->available) {
            return ApiFormatter::createApi(400, 'Mobil tidak tersedia', null);
        }

        // Membuat data rental baru
        $rental = Rentals::create([
            'user_id' => $request->user_id,
            'car_id' => $request->car_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total_amount' => $request->total_amount,
            'is_return' => 'false',

        ]);

        // Cek apakah data rental berhasil dibuat
        if ($rental) {
            // Update status mobil menjadi tidak tersedia
            $car->available = false;
            $car->save();

            return ApiFormatter::createApi(201, 'Sukses menambahkan rental', $rental);
        } else {
            return ApiFormatter::createApi(500, 'Gagal menambahkan rental', null);
        }
    }

    public function show($id) {
        $data = DB::table('rentals as a')
        ->join('users as u', 'u.id', '=', 'a.user_id')
        ->join('cars as c', 'c.id', '=', 'a.car_id')
        ->select('a.*', 'u.name as user_name', 'c.brand', 'c.model')
        ->where('a.id', '=', $id)
        ->first();

    
        // Cek apakah data mobil ditemukan
        if ($data) {
            return ApiFormatter::createApi(200, 'Sukses mendapatkan data detail rental', $data);
        } else {
            return ApiFormatter::createApi(404, 'Mobil tidak ditemukan', null);
        }
    }

    public function returnCar(Request $request, $id) {
        // Validasi data yang diterima dari request
        $validator = Validator::make($request->all(), [
            'plate_number' => 'required|string|max:50',
        ]);
    
        // Cek apakah validasi gagal
        if ($validator->fails()) {
            return ApiFormatter::createApi(400, 'Validasi gagal', $validator->errors());
        }
    
        // Temukan rental berdasarkan ID
        $rental = Rentals::find($id);
        
        if (!$rental) {
            return ApiFormatter::createApi(404, 'Rental tidak ditemukan', null);
        }
    
        // Periksa apakah rental sudah dikembalikan
        if ($rental->is_return === true) {
            return ApiFormatter::createApi(400, 'Mobil sudah dikembalikan', null);
        }
    
        // Temukan mobil terkait
        $car = Cars::find($rental->car_id);
        if (!$car) {
            return ApiFormatter::createApi(404, 'Mobil tidak ditemukan', null);
        }
    
        DB::beginTransaction();
        try {
            // Update status rental menjadi dikembalikan
            $rental->is_return = "true";
            $rental->save();
    
            // Update status mobil menjadi tersedia
            $car->available = "true";
            $car->save();
    
            DB::commit();
            return ApiFormatter::createApi(200, 'Sukses mengembalikan mobil', $rental);
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiFormatter::createApi(500, 'Gagal mengembalikan mobil: ' . $e->getMessage(), null);
        }
    }
    
}
