<?php

namespace App\Http\Controllers;

use App\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
        if (Auth::user()->type == 'App\\Client') {
            return view('home');
        } else {
            return view('home')->with([
                'todays_bookings' => Booking::today()->get(),
                'future_bookings' => Booking::future()->get()->groupBy('date'),
            ]);
        }
    }
}
