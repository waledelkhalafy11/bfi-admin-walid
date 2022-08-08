<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hero_card extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'card_title',
        'card_desciption',
        'icon_id',
        'element_id_name'
        
    ];


    public function icon(){
        return $this->belongsTo(Card_icon::class);
    }
}
