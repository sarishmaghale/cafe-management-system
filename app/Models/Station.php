<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    use HasFactory;

    protected $fillable = [
        'station_name',
        'status',
        'total_amount'
    ];

    public function bills()
    {
        return $this->hasMany(Billing::class);
    }
}
