<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;



     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'unit_name',
        'unit_address',
        'unit_description',
        'unit_longitude',
        'unit_latitude',
        'unit_price',
        'dist_id',
        'main_category',
        'unit_category',
        'res_unit_category'
        
    ];




    public function photo(){
        return $this->hasMany(Unit_photo::class);
    }
    public function dist(){
        return $this->belongsTo(District::class);
    }
    public function proprty(){
        return $this->hasOne(Proprty::class);
    }
}
