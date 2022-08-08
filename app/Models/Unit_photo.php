<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit_photo extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_id',
        'unit_image_url'
        
    ];

    public function unit(){
        return $this->belongsTo(Unit::class);
    }
}
