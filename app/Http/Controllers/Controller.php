<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Processes Scopes from Request Query String
     *
     * This fuction will process the scopes from an API request e.g. api/booking?scope[future]&scope[dingle]&with=client.pets,service
     * and add them to the query
     *
     * @param Request $request The API calls actual Rquest
     * @param Builder $query The query that the scopes should be applied to
     * @param Class $class The base class for the query. The $query->model is protected so we can't just look this up
     * @param Array $errors An array to collect the errors. Note that this is updated by reference for use after the function runs
     * @return nothing - only updates the $query and the $errors
     * @throws conditon
     **/

    public function processRequestScopes(Request $request, $query, $class, &$errors)
    {
        if ($request->has('scope')) {
            foreach (array_keys($request->get('scope')) as $key) {
                $method = 'scope' . \Str::title($key);
                if (method_exists($class, $method)) {
                    $query = $query->$key();
                } else {
                    $errors[] = ['Query scope does not exist.' => $key];
                }
            }
        }
    }

    /**
     * Processes related models in query
     *
     * This functio nwill process the "with" string from the query and tack on the related models.
     * Note that it will only validate the first relationship in chained relations e.g. with=client.pets,service
     *
     * @param Request $request The API calls actual Rquest
     * @param Builder $query The query that the scopes should be applied to
     * @param Class $class The base class for the query. The $query->model is protected so we can't just look this up
     * @param Array $errors An array to collect the errors. Note that this is updated by reference for use after the function runs
     * @return nothing - only updates the $query and the $errors
     * @throws conditon
     **/
    public function processRequestWiths(Request $request, $query, $class, &$errors)
    {
        if ($request->has('with')) {
            $withs = explode(',', $request->get('with'));
            foreach ($withs as $relationship) {
                // THIS ONLY CHECKS if the first relationship exits
                // for example client.pets will only check if the client relationship is defined
                // ignoring if the client->pets() is defined
                $baseRelationship = explode('.', $relationship)[0];
                if (method_exists($class, $baseRelationship)) {
                    $query = $query->with($relationship);
                } else {
                    $errors[] = ['Relationship not defined.' => $relationship];
                }
            }
        }
    }
}
