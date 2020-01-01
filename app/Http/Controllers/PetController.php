<?php

namespace App\Http\Controllers;

use App\Pet;
use Illuminate\Http\Request;
use App\Http\Requests\PetRequest;
use Illuminate\Support\Facades\Auth;

class PetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PetRequest $request)
    {
        $pets = Pet::query();
        $errors = [];

        $this->processRequestWiths($request, $pets, Pet::class, $errors);
        $this->processRequestScopes($request, $pets, Pet::class, $errors);

        if (!empty($errors)) {
            return api()->validation('There were errors in your Request', $errors);
        }

        $message = 'Successfully pulled ' .  implode(', ', array_keys($request->get('scope') ?? [])) . ' pet with ' . $request->get('with');

        if (Auth::user() instanceof \App\Staff) {
            return api()->response(200, $message, $pets->get());
            return $pets->get();
        } else {
            return api()->response(200, $message, $pets->where('user_id', Auth::id())->get());
            return $pets->where('user_id', Auth::id())->get();
        }

        return api()->response(200, $message, $pet->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PetRequest $request)
    {
        $pet = new Pet;
        $pet->fill($request->all());
        $pet->save();

        return api()->ok('Pet has been created.', $pet->refresh());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pet  $pet
     * @return \Illuminate\Http\Response
     */
    public function show(Pet $pet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pet  $pet
     * @return \Illuminate\Http\Response
     */
    public function update(PetRequest $request, $id)
    {
        $pet = Pet::find($id);
        if (is_null($pet)) {
            return api()->notFound('Pet with id ' . $id . ' not found.');
        }
        $pet->fill($request->all());
        $pet->save();

        return api()->ok('Pet has been updated.', $pet->refresh());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pet  $pet
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pet = Pet::find($id);
        if (is_null($pet)) {
            return api()->notFound('Pet with id ' . $id . ' not found.');
        }
        $pet->delete();
        return api()->ok('Pet has been deleted', $pet->refresh(), ['id' => $pet->id]);
    }
}
