<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card_icon extends Model
{
    use HasFactory;


 /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'card_icon_url'
        
    ];




    public function card(){
        return $this->hasMany(Hero_card::class);
    }


 
}
