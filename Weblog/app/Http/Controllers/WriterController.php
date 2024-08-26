<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;


class WriterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        if (Auth::check()) {
            return view('writer.dashboard');
        } else return view('home');
    }
}
