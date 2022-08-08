<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proprty extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'unit_id',
        'kitchen',
        'bedroom',
        'rooms',
        'living_room',
        'bathroom',
        'garage',
        'garden',
        'elevator', 
        'floor',
        'surface_area',
        'pool'
        
    ];

    public function unit(){
        return $this->belongsTo(Unit::class);
    }
}
