<?php

namespace App\Http\Controllers;

use App\Http\Requests\PetTypeRequest;
use App\PetType;

class PetTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PetTypeRequest $request)
    {
        $petType = PetType::query();
        $errors = [];

        $this->processRequestWiths($request, $petType, PetType::class, $errors);
        $this->processRequestScopes($request, $petType, PetType::class, $errors);
        $this->processRequestQueryFields($request, $petType, PetType::class, $errors);

        if (! empty($errors)) {
            return api()->validation('There were errors in your Request', $errors);
        }

        $message = 'Successfully pulled '.implode(', ', array_keys($request->get('scope') ?? [])).' petType with '.$request->get('with');

        return api()->response(200, $message, $petType->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(PetTypeRequest $request)
    {
        $petType = new PetType();
        $petType->fill($request->all());
        $petType->save();

        return api()->ok('PetType has been created.', $petType->refresh());
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(PetType $petType)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\PetType             $petType
     *
     * @return \Illuminate\Http\Response
     */
    public function update(PetTypeRequest $request, $id)
    {
        $petType = PetType::find($id);
        if (is_null($petType)) {
            return api()->notFound('PetType with id '.$id.' not found.');
        }
        $petType->fill($request->all());
        $petType->save();

        return api()->ok('PetType has been updated.', $petType->refresh());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\PetType $petType
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $petType = PetType::find($id);
        if (is_null($petType)) {
            return api()->notFound('PetType with id '.$id.' not found.');
        }
        $petType->delete();

        return api()->ok('PetType has been deleted', $petType->refresh(), ['id' => $petType->id]);
    }
}
