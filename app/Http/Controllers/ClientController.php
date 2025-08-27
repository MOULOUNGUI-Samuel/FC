<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientController extends Controller
{
    //
    public function index(){
        return view('components.clients.liste_particulier');
    }
    public function index1(){
        return view('components.clients.liste_fondentite');
    }
}
