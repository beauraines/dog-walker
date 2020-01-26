<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;
use App\Http\Requests\ClientRequest;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ClientRequest $request)
    {
        $client = Client::query();
        $errors = [];

        $this->processRequestWiths($request, $client, Client::class, $errors);
        $this->processRequestScopes($request, $client, Client::class, $errors);
        $this->processRequestQueryFields($request, $client, Client::class, $errors);

        if (!empty($errors)) {
            return api()->validation('There were errors in your Request', $errors);
        }

        $message = 'Successfully pulled ' .  implode(', ', array_keys($request->get('scope') ?? [])) . ' client with ' . $request->get('with');
        return api()->response(200, $message, $client->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientRequest $request)
    {
        $client = new Client;
        $client->fill($request->except('password'));
        $client->password = Hash::make($request->get('password'));
        $client->api_token =  \Str::random(80);

        $client->save();

        return api()->ok('Client has been created.', $client->refresh());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(ClientRequest $request, $id)
    {
        $client = Client::find($id);
        if (is_null($client)) {
            return api()->notFound('Client with id ' . $id . ' not found.');
        }
        $client->fill($request->except('password'));
        $client->password = Hash::make($request->get('password'));
        $client->save();

        return api()->ok('Client has been updated.', $client->refresh());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClientRequest $request, $id)
    {
        $client = Client::find($id);
        if (is_null($client)) {
            return api()->notFound('Client with id ' . $id . ' not found.');
        }
        $client->delete();
        return api()->ok('Client has been deleted', $client->refresh(), ['id' => $client->id]);
    }
}
