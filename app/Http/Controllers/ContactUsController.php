<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    public function showContacts () {
         $allContacts = \App\Models\Contact_request::all();
         return view('contact_requests' , ['allContacts'=>$allContacts]);
    }

}
 