<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if ('App\\Client' == Auth::user()->type) {
            return view('home');
        } else {
            return view('home')->with([
                'clients' => Client::all(),
            ]);
        }
    }
}
