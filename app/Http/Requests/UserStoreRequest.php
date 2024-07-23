<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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

        switch ($this->method()) {
            case 'GET':
            case 'DELETE':
            {
                return [];
            }
            case 'POST':
            {
                return [
                    'name' => 'required|max:255',
                    'phone' => [
                        'required',
                        Rule::unique('users')->whereNull('deleted_at'),
                    ],
                    'email' => [
                        'required',
                        'email',
                        Rule::unique('users')->whereNull('deleted_at'),
                    ],
                    'department_id' => 'required',
                    'gender' => 'required',
                ];
            }
            case 'PATCH':
            {
                return [
                    'name' => 'required|max:255',
                    'phone' => 'required|numeric|digits:11|regex:/(01)[0-9]{9}/|unique:users,phone,' . $this->id,
                    'email' => 'required|email|max:255|unique:users,email,' . $this->id,
                    'role_id' => 'required',
                    'department_id' => 'required',
                    'designation_id' => 'required',
                ];
            }
            default:
                break;
        }

    }
    public function messages()
    {
        return [
            'name.required'  =>  'Name is required',
            'phone.required' => 'Phone is required',
            'email.required' => 'Email is required',
            'department_id.required' => 'Department is required',
            'gender.required' => 'Gender is required',
        ];
    }

}
