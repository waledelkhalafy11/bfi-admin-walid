<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'region_id',
        'city_name',
        'city_longitude',
        'city_latitude'
        
    ];

    public function dist(){
        return $this->hasMany(District::class);
    }
    public function region(){
        return $this->belongsTo(City::class);
    }
}
