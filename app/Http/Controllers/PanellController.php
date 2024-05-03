<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PanellController extends Controller
{
    public function index()
    {

        return view('layout.user.pannel');
    }
}
