<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        switch ($this->method()) {
            case 'GET':
            case 'POST':
            case 'PUT':
            case 'PATCH':
            case 'DELETE':
            default:
                return 'App\\Staff' == $this->user()->type ? true : false;
                break;
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->route('client');

        switch ($this->method()) {
            case 'GET':
                return [];
                break;
            case 'POST':
                return [
                    'name'     => 'required|string',
                    'email'    => 'unique:users',
                    'type'     => 'sometimes|regex:/App\\\\Client/',
                    'password' => 'required|min:8',
                ];
                break;
            case 'PUT':
            case 'PATCH':
                return [
                    'name'     => 'sometimes|required|string',
                    'email'    => 'sometimes|unique:users,email,'.$id,
                    'type'     => 'sometimes|regex:/App\\\\Client/',
                    'password' => 'sometimes|required|min:8',
                ];
                break;
            case 'DELETE':
                return [];
                break;
            default:
                return [];
                break;
        }
    }
}
