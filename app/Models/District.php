<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    protected $fillable = [
        'city_id',
        'dist_name',
        'dist_longitude',
        'dist_latitude'
        
    ];

    public function city(){
        return $this->belongsTo(City::class);
    }
    public function unit(){
        return $this->hasMany(Unit::class);
    }
}
