<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LandingPPDBController extends Controller
{
    public function index()
    {
        return view('landing.ppdb.index');
    }
}
