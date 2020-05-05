<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->route('booking');
        switch ($this->method()) {
            case 'GET':
                return [];
                break;
            case 'POST':
                return [
                    'date'       => 'required|date|after_or_equal:today',
                    'user_id'    => 'sometimes|required|numeric|exists:users,id',
                    'service_id' => 'required|numeric|exists:services,id',
                ];
                break;
            case 'PUT':
            case 'PATCH':
                return [
                    'date'       => 'sometimes|required|date|after_or_equal:today',
                    'user_id'    => 'sometimes|required|numeric|exists:users,id',
                    'service_id' => 'sometimes|required|numeric|exists:services,id',
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
