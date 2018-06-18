<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

class TrackController extends Controller
{
    public function __construct()
    {
        $this->middleware('client' );
    }

    public function save(Request $request)
    {
        return response()->json(['a'=> 1]);
    }
}
