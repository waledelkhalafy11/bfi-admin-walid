<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class loginController extends Controller
{
    public function loggin () {
        return view('login');

    }

    public function register () {
        return view('register');

    }
}
