<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HostController extends Controller
{
    public function index()
    {
        return view('hospedes.create-step-one');
    }
    public function iniciarReserva(Request $request)
    {
        return view('hospedes.create-step-two');
    }
    public function dadosHospedes(Request $request)
    {
        return view('hospedes.create-step-three');
    }
    //
}
