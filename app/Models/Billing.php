<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    use HasFactory;

    protected $fillable = [
        'total',
        'station_id',
        'status',
        'customer_name',
        'bill_num',
    ];

    public function station()
    {
        return $this->belongsTo(Station::class, 'station_id');
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
