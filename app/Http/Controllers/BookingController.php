<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Booking::with(['client', 'service'])->where('date', '>', Carbon::today())->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('booking.create')->with(
            [
                'services' => Service::all(['id', 'name']),
                'user' => \Auth::user(),
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $request->has('user_id') ? User::find($request->user_id) : Auth::user();
        $request->validate([
            'date' => 'required|date',
            'service_id' => 'required|exists:services,id',
            'user_id' => 'sometimes|required|exists:users'
        ]);

        $booking = new Booking;
        $booking->fill($request->all());
        $booking->user_id = $user->id;
        $booking->save();

        // TODO Revise this to return a JSON resopnse
        return redirect()->route('home')->with(
            [
                'status' => 'Booking has been created!'
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {
        return "Getting Booking";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        return view('booking.edit')->with(
            [
                'booking' => $booking,
                'services' => Service::all(['id', 'name']),
                'user' => Auth::user(),
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Booking $booking)
    {

        $request->validate([
            'date' => 'sometimes|required|date',
            'service_id' => 'sometimes|required|exists:services,id',
        ]);

        $booking->update($request->all());

        // TODO Revise this to return a JSON resopnse
        return redirect()->route('home')->with('status', 'Booking has been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();

        // TODO Revise this to return a JSON resopnse
        return redirect()->route('home')->with('status', 'Booking has been deleted.');
    }
}
