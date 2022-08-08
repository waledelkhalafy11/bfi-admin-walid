<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact_request extends Model
{

    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'city',
        'message'
        
    ];
}
