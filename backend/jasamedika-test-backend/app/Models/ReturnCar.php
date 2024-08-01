<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnCar extends Model
{
    use HasFactory;


    protected $table = 'return_car';

    protected $fillable = [
        'rentals_id',
        'plate_number',
    ];

    public function rental()
    {
        return $this->belongsTo(Rental::class, 'rentals_id');
    }
}
