<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'max:50',
                

            ],

            'git_url' => [],

            'description' => ['string'],

            'type_id' => ['nullable', 'exists:types,id'],

            'tecnologies' => ['nullable', 'exists:tecnologies,id'],

            'cover_image' => ['nullable', 'mimes:jpg,jpeg,png', 'max:512'],
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'the name is mandatory',
            'name.string' => 'the name must be text',
            'name.max' => 'the name must be a maximum of 50 characters',
           
            'description.string' => 'the description must be of text type',

            'type_id.exists' => 'the type entered is invalid',
            'type_id.required' => '...',

            'tecnologies:exists' => 'the chosen technology is not among the valid ones',

            'cover_image.mimes' => 'the image must be jpg, jpeg or png',
            'cover_image.max' => 'the image must be max 512 kb',
        ];
    }
}