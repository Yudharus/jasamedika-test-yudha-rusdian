<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cars extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'brand', 'model', 'plate_number', 'daily_rate', 'available', 'gas', 'driving_type', 'capacity'
    ];

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }
}
