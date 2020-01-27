<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;


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
            $scopes = $request->get('scope');
            foreach ($scopes as $scope => $params) {
                $method = 'scope' . Str::title($scope);
                $paramArray = explode(',', $params);
                if (method_exists($class, $method)) {
                    $query = call_user_func_array([$query, $scope], $paramArray);
                } else {
                    $errors[] = ['Query scope does not exist.' => $scope];
                }
            }
        }
    }

    /**
     * Processes related models in query
     *
     * This function will process the "with" string from the query and tack on the related models.
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

    /**
     * Processes related models in query
     *
     * This function will process any other query strings and limit the data returned to that field/value combination.
     *
     * @param Request $request The API calls actual Rquest
     * @param Builder $query The query that the scopes should be applied to
     * @param Class $class The base class for the query. The $query->model is protected so we can't just look this up
     * @param Array $errors An array to collect the errors. Note that this is updated by reference for use after the function runs
     * @return nothing - only updates the $query and the $errors
     * @throws conditon
     **/
    public function processRequestQueryFields(Request $request, $query, $class, &$errors)
    {
        $fields = $request->except(['with', 'scope']);
        $class = new $class;
        $columnListing = Schema::getColumnListing($class->getTable());
        foreach ($fields as $field => $value) {
            if (in_array($field, $columnListing)) {
                $query = $query->where($field, $value);
            } else {
                $errors[] = ['Model field not found.' => $field];
            }
        }
    }
}
