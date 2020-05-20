<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Client;
use App\Http\Requests\BookingRequest;
use App\Service;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BookingRequest $request)
    {
        $bookings = Booking::query();
        $errors = [];

        $this->processRequestWiths($request, $bookings, Booking::class, $errors);
        $this->processRequestScopes($request, $bookings, Booking::class, $errors);
        $this->processRequestQueryFields($request, $bookings, Booking::class, $errors);

        if (!empty($errors)) {
            return api()->validation('There were errors in your Request', $errors);
        }

        // TODO improve the message when there are scopes with parameters or no withs
        $message = 'Successfully pulled ' . implode(', ', array_keys($request->get('scope') ?? [])) . ' bookings with ' . $request->get('with');

        if (Auth::user() instanceof \App\Client) {
            $bookings = $bookings->where('user_id', Auth::id());
        }

        return api()->response(200, $message, $bookings->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Not an API route
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookingRequest $request)
    {
        $user = $request->has('user_id') ? Client::find($request->user_id) : Auth::user();

        $booking = new Booking;
        $booking->fill($request->all());
        $booking->user_id = $user->id;
        // This should move to a Validator and be handled by the BookingRequest
        // Issue #100
        if (count($user->pets) < 1) {
            // You can not make a booking if you have no pets
            return api()->validation(
                'Unable to create a booking. No pet has been setup yet.',
                $user,
                ['errors' => ['no_pets' => ['Unable to create a booking. No pet has been setup yet.']]]
            );
            // No need to test for wantsJson() because it only uses JSON now
        }
        $booking->save();

        if ($request->wantsJson()) {
            return api()->ok('Booking has been created', Booking::whereId($booking->id)->with('client.pets', 'service')->first());
        } else {
            return redirect()->route('home')->with(
                [
                    'status' => 'Booking has been created!',
                ]
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {
        return 'Getting Booking';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        // Not an API route
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(BookingRequest $request, Booking $booking)
    {
        $booking->update($request->all());

        if ($request->wantsJson()) {
            return api()->ok('Booking has been updated', Booking::whereId($booking->id)->with('client.pets', 'service')->first());
        } else {
            return redirect()->route('home')->with('status', 'Booking has been updated successfully!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $booking = Booking::find($id);
        if (is_null($booking)) {
            return api()->notFound('Booking with id ' . $id . ' not found.');
        }
        $booking->delete();

        return api()->ok('Booking has been deleted', $booking->refresh(), ['id' => $booking->id]);
    }
}
