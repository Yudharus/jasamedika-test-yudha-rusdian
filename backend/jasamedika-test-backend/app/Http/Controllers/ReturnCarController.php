<?php

namespace App\Http\Controllers;

use App\Helpers\Apiformatter;
use Illuminate\Http\Request;
use App\Models\ReturnCar;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ReturnCarController extends Controller
{
    public function index()
{
    $data = DB::select("
        SELECT 
            rc.*, 
            r.*, 
            u.name, 
            c.brand, 
            c.model 
        FROM 
            public.return_car rc
        JOIN 
            public.rentals r ON rc.rentals_id = r.id
        JOIN 
            public.users u ON r.user_id = u.id
        JOIN 
            public.cars c ON r.car_id = c.id
    ");

    if (count($data) > 0) {
        return ApiFormatter::createApi(200, 'Sukses mendapatkan data', $data);
    } else {
        return ApiFormatter::createApi(200, 'Data tidak ditemukan', []);
    }
}

    public function store(Request $request)
    {
        // Validasi data yang diterima dari request
        $validator = Validator::make($request->all(), [
            'rentals_id' => 'required|integer|exists:rentals,id',
            'plate_number' => 'required|string|max:50',
        ]);

        // Cek apakah validasi gagal
        if ($validator->fails()) {
            return ApiFormatter::createApi(400, 'Validasi gagal', $validator->errors());
        }

        DB::beginTransaction();
        try {
            // Membuat data return car baru
            $returnCar = ReturnCar::create([
                'rentals_id' => $request->rentals_id,
                'plate_number' => $request->plate_number,
            ]);

            // Hapus data terkait di tabel return_car terlebih dahulu
            DB::table('return_car')->where('rentals_id', $request->rentals_id)->delete();

            // Hapus data dari tabel rentals
            DB::table('rentals')->where('id', $request->rentals_id)->delete();

            DB::commit();

            return ApiFormatter::createApi(201, 'Sukses menambahkan data return car', $returnCar);
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiFormatter::createApi(500, 'Gagal menambahkan data return car: ' . $e->getMessage(), null);
        }
    }

}
