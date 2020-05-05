<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceRequest;
use App\Service;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ServiceRequest $request)
    {
        $service = Service::query();
        $errors = [];

        $this->processRequestWiths($request, $service, Service::class, $errors);
        $this->processRequestScopes($request, $service, Service::class, $errors);
        $this->processRequestQueryFields($request, $service, Service::class, $errors);

        if (! empty($errors)) {
            return api()->validation('There were errors in your Request', $errors);
        }

        $message = 'Successfully pulled '.implode(', ', array_keys($request->get('scope') ?? [])).' service with '.$request->get('with');

        return api()->response(200, $message, $service->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceRequest $request)
    {
        $service = new Service();
        $service->fill($request->all());
        $service->save();

        return api()->ok('Service has been created.', $service->refresh());
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Service             $service
     *
     * @return \Illuminate\Http\Response
     */
    public function update(ServiceRequest $request, $id)
    {
        $service = Service::find($id);
        if (is_null($service)) {
            return api()->notFound('Service with id '.$id.' not found.');
        }
        $service->fill($request->all());
        $service->save();

        return api()->ok('Service has been updated.', $service->refresh());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Service $service
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service = Service::find($id);
        if (is_null($service)) {
            return api()->notFound('Service with id '.$id.' not found.');
        }
        $service->delete();

        return api()->ok('Service has been deleted', $service->refresh(), ['id' => $service->id]);
    }
}
