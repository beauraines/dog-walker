<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
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
                return true;
                break;
            case 'POST':
            case 'PUT':
            case 'PATCH':
            case 'DELETE':
                return 'App\\Staff' == $this->user()->type ? true : false;
                break;
            default:
                return false;
                break;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->route('service');
        switch ($this->method()) {
            case 'GET':
                return [];
                break;
            case 'POST':
                return [
                    'name'                  => 'required|string|unique:services',
                    'description'           => 'required',
                    'base_price'            => 'required|numeric',
                    'incremental_pet_price' => 'required|numeric',
                ];
                break;
            case 'PUT':
            case 'PATCH':
                return [
                    'name'                  => 'sometimes|string|unique:services,name,'.$id,
                    'description'           => 'sometimes',
                    'base_price'            => 'sometimes|numeric',
                    'incremental_pet_price' => 'sometimes|numeric',
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
