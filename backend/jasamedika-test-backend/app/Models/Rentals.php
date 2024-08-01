<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rentals extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'car_id', 'start_date', 'end_date', 'total_amount', 'is_return'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function returnCar()
    {
        return $this->hasOne(ReturnCar::class, 'rentals_id');
    }
}
