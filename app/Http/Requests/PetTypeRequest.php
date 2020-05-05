<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PetTypeRequest extends FormRequest
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
        $id = $this->route('pet_type');

        switch ($this->method()) {
            case 'GET':
                return [];
                break;
            case 'POST':
                return [
                    'pet_type' => 'required|string|unique:pet_types,pet_type',
                ];
                break;
            case 'PUT':
            case 'PATCH':
                return [
                    'pet_type' => 'sometimes|required|string|unique:pet_types,pet_type,'.$id,
                ];
                break;
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
