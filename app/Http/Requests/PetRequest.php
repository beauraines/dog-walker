<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PetRequest extends FormRequest
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
                return true;
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
        switch ($this->method()) {
            case 'GET':
                return [];
                break;
            case 'POST':
                return [
                    'name'                 => 'required|string',
                    'pet_type_id'          => 'exists:pet_types,id',
                    'special_instructions' => 'nullable',
                    'user_id'              => 'exists:users,id',
                ];
                break;
            case 'PUT':
            case 'PATCH':
                return [
                    'name'                 => 'sometimes|required|string',
                    'pet_type_id'          => 'sometimes|exists:pet_types,id',
                    'special_instructions' => 'sometimes|nullable',
                    'user_id'              => 'sometimes|exists:users,id',
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
